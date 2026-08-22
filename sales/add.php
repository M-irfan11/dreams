<?php
require_once '../component/connection.php';
 $crud->conn->begin_transaction();
 
function getAccountId($crud, $code) {
    $r = $crud->common_select('account_heads', '*', ["account_code" => $code]);
    return $r['status'] ? $r['data'][0]->id : null;
}

    $error=0;
    $data = [
        "customer_id" => $_POST['customer_id'],
        "user_id" => $_SESSION['user_id'],
        "sale_date" => $_POST['sale_date'],
        "total_amount" => $_POST['total_amount'],
        "discount" => $_POST['discount_amount'],
        "tax" => $_POST['vat'],
        "status" => 1,
        "created_at" => date('Y-m-d H:i:s'),
        "created_by" => $_SESSION['user_id']
    ];

    // warehouse is optional in the sales table, only include it if one was picked
    if(!empty($_POST['warehouse_id'])){
        $data["warehouse_id"] = $_POST['warehouse_id'];
    }

    $result = $crud->common_insert('sales', $data);

    if($result['status']){
        $sale_id = $result['data'];
        // reduce stock for each product sold via stock_transfers table
       // <!-- `id`, `product_id`, `warehouse_id`, `quantity`, `transfer_date`, `sale_id`, `sales_id`, `sale_return_id`, `sales_return_id`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by` -->
        foreach($_POST['product_id'] as $index => $product_id){
            $stock_data = [
                "sale_id" => $sale_id,
                "product_id" => $product_id,
                "quantity" => $_POST['quantity'][$index],
                "unit_price" => $_POST['selling_price'][$index],
                "subtotal" => $_POST['subtotal'][$index],
                "created_at" => date('Y-m-d H:i:s'),
                "created_by" => $_SESSION['user_id']
            ];
            $sd=$crud->common_insert('sale_details', $stock_data);
            if(!$sd['status']){
                $error++;
            }
            // remove stock in stock_transfers table (status 0 = out)
            $st=$crud->common_insert('stocks', [
                "product_id" => $product_id,
                "quantity" => "-".$_POST['quantity'][$index],
                "warehouse_id" => $_POST['warehouse_id'],
                "stock_date" => $_POST['sale_date'],
                "sale_id" => $sale_id,
                "created_at" => date('Y-m-d H:i:s')
            ]);
            if(!$st['status']){
                $error++;
            }
        }
      
        if($result['status'] && $error==0){

            $total_amount = (float) $_POST['total_amount'];
            $discount = (float) ($_POST['discount_amount'] ?: 0);
            $tax = (float) ($_POST['vat'] ?: 0);

            $revenue_amount = $total_amount - $discount;
            $receivable_amount = $revenue_amount + $tax;

            $receivable_acc = getAccountId($crud, '1200');
            $revenue_acc    = getAccountId($crud, '4000');
            $vat_output_acc = getAccountId($crud, '2100');

            if (!$receivable_acc || !$revenue_acc) {
                throw new Exception("Accounting accounts not set up. Please add accounts 1200 and 4000 first.");
            }

            $journal_voucher_id = add_journal_voucher($crud, $sale_id, [
                ['account_id' => $receivable_acc, 'dr' => $receivable_amount, 'cr' => 0, 'remarks' => "Sale #$sale_id - Receivable"],
                ['account_id' => $revenue_acc, 'dr' => 0, 'cr' => $revenue_amount, 'remarks' => "Sale #$sale_id - Revenue"],
                ['account_id' => $vat_output_acc, 'dr' => 0, 'cr' => $tax, 'remarks' => "Sale #$sale_id - VAT Output"]
            ], $receivable_amount, "Sale #$sale_id", $_POST['sale_date']);
           
            $crud->conn->commit();
             $_SESSION['message'] = array(
                "type" => "success",
                "title" => "Success",
                "message" => "Sale added successfully."
            );
        } else {
            $crud->conn->rollback();
                $_SESSION['message'] = array(
                    "type" => "danger",
                    "title" => "Error",
                    "message" => $result['message']
                );
        }

       
    } else {
        $_SESSION['message'] = array(
            "type" => "danger",
            "title" => "Error",
            "message" => $result['message']
        );
    }


    function add_journal_voucher($crud, $sale_id, $account_ids, $grand_total, $description,$sale_date) {
        $voucher_no = $crud->common_query("SELECT max(id) as max_id FROM journal_vouchers");
        $voucher_no = 'J' . str_pad($voucher_no['data'][0]->max_id + 1, 6, '0', STR_PAD_LEFT);
        $journal_voucher = [
            'voucher_no' => $voucher_no,
            'voucher_date' => $sale_date,
            'source_type' => 'Sales',
            'source_id' => $sale_id,
            'narration' => $description ?? 'Sales Voucher',
            'dr' => $grand_total ?? 0,
            'cr' => $grand_total ?? 0,
            'created_by' => $_SESSION['user_id'],
            'status' => 1
        ];

        $journal_voucher_result = $crud->common_insert("journal_vouchers", $journal_voucher);
        $voucher_id = $journal_voucher_result['data'];

        foreach ($account_ids as $account_head_id) {
            $details_data = [
                'journal_voucher_id' => $voucher_id,
                'account_head_id' => $account_head_id['account_id'],
                'dr' => $account_head_id['dr'] ?? 0,
                'cr' => $account_head_id['cr'] ?? 0,
                'remarks' => $account_head_id['remarks'] ?? '',
                'created_by' => $_SESSION['user_id']
            ];
            $journal_voucher_detail_result = $crud->common_insert("journal_voucher_details", $details_data);
            $ledger_data = [
                'journal_voucher_id' => $voucher_id,
                'account_head_id' => $account_head_id['account_id'],
                'dr' => $account_head_id['dr'] ?? 0,
                'cr' => $account_head_id['cr'] ?? 0,
                'remarks' => $account_head_id['remarks'] ?? '',
                'created_by' => $_SESSION['user_id']
            ];
            $crud->common_insert("ledger", $ledger_data);
        }

        return  $voucher_id;
    }

    echo "<script>window.location='list.php'</script>";