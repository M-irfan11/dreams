<?php
/**
 * =====================================================================
 * ACCOUNTING HELPER
 * =====================================================================
 * Sales / Purchase সেভ হওয়ার পরে এই ফাংশনগুলো কল করলে অটোমেটিক
 * Receive/Payment Voucher + Ledger এন্ট্রি তৈরি হয়ে যাবে এবং
 * account_heads এর current_balance আপডেট হয়ে যাবে।
 *
 * ব্যবহারের আগে account_heads টেবিলে নিচের account_code গুলো তৈরি করে রাখুন
 * (sql/seed_accounts.sql ফাইলে রেডিমেড INSERT দেওয়া আছে):
 *
 *   CASH        -> Cash in Hand               (Asset)
 *   AR          -> Accounts Receivable        (Asset)
 *   AP          -> Accounts Payable           (Liability)
 *   SALES       -> Sales Income               (Income)
 *   PURCHASE    -> Purchase / COGS            (Expense)
 *   VAT_OUTPUT  -> VAT Payable (Output VAT)   (VAT)
 *   VAT_INPUT   -> VAT Receivable (Input VAT) (VAT)
 * =====================================================================
 */

function get_account_id_by_code($crud, $code){
    $res = $crud->common_select("account_heads", "*", ["account_code" => $code], "AND", "", "ASC", "1", "", false);
    return $res["status"] ? $res["data"][0]->id : null;
}

/**
 * account_heads এর balance আপডেট করে (current_balance, total_debit, total_credit, last_transaction_date)।
 * Asset/Expense টাইপে Dr বাড়ালে balance বাড়ে। Liability/Income/Equity/VAT টাইপে Cr বাড়ালে balance বাড়ে।
 */
function update_account_balance($crud, $account_head_id, $dr, $cr, $txn_date = null){
    $accRes = $crud->common_select("account_heads", "*", ["id" => $account_head_id], "AND", "", "ASC", "1", "", false);
    if(!$accRes["status"]) return false;

    $account = $accRes["data"][0];
    $debit_increases_balance = in_array($account->account_type, ["Asset", "Expense"]);
    $balanceChange = $debit_increases_balance ? ($dr - $cr) : ($cr - $dr);

    $crud->common_update("account_heads", [
        "current_balance"       => $account->current_balance + $balanceChange,
        "total_debit"           => $account->total_debit + $dr,
        "total_credit"          => $account->total_credit + $cr,
        "last_transaction_date" => $txn_date ?: date("Y-m-d"),
    ], ["id" => $account_head_id]);

    return true;
}

/**
 * একটা Ledger এন্ট্রি ইনসার্ট করে + account balance আপডেট করে।
 * $voucherType = 'payment' | 'receive' | 'journal'
 */
function post_to_ledger($crud, $voucherType, $voucherId, $account_head_id, $dr, $cr, $remarks = "", $txn_date = null){
    $ledgerData = [
        "account_head_id"    => $account_head_id,
        "dr"                 => $dr,
        "cr"                 => $cr,
        "remarks"            => $remarks,
        "payment_voucher_id" => $voucherType === "payment" ? $voucherId : null,
        "receive_voucher_id" => $voucherType === "receive" ? $voucherId : null,
        "journal_voucher_id" => $voucherType === "journal" ? $voucherId : null,
    ];

    $ins = $crud->common_insert("ledgers", $ledgerData);
    if($ins["status"]){
        update_account_balance($crud, $account_head_id, $dr, $cr, $txn_date);
    }
    return $ins;
}

/**
 * ============================================================
 * SALE -> RECEIVE VOUCHER (Sale টেবিল থেকে কল করবেন insert এর পর)
 * ============================================================
 * $sale অবজেক্টে থাকতে হবে: id, customer_id, total_amount, tax, sale_date, status
 * status: 1 = Paid (Cash Dr হবে), 2/3 = Pending/Cancelled হলে Accounts Receivable Dr হবে
 */
function create_receive_voucher_for_sale($crud, $sale){
    $cashAccId  = get_account_id_by_code($crud, "CASH");
    $arAccId    = get_account_id_by_code($crud, "AR");
    $salesAccId = get_account_id_by_code($crud, "SALES");
    $vatAccId   = get_account_id_by_code($crud, "VAT_OUTPUT");

    if(!$cashAccId || !$arAccId || !$salesAccId){
        return ["status" => false, "message" => "Account heads (CASH/AR/SALES) সেটাপ করা নেই। sql/seed_accounts.sql রান করুন।"];
    }

    $debitAccId = ($sale->status == 1) ? $cashAccId : $arAccId;
    $invoiceNo  = $crud->generate_invoice_no("receive_vouchers", "RV");
    $vatAmount  = isset($sale->tax) ? (float) $sale->tax : 0;
    $netSales   = $sale->total_amount - $vatAmount;

    $crud->begin_transaction();

    $rv = $crud->common_insert("receive_vouchers", [
        "invoice_no"   => $invoiceNo,
        "receive_from" => "Customer #" . $sale->customer_id,
        "note"         => "Auto generated from Sale #" . $sale->id,
        "date"         => $sale->sale_date,
        "source_type"  => "sale",
        "source_id"    => $sale->id,
        "dr"           => $sale->total_amount,
        "cr"           => $sale->total_amount,
        "status"       => "Active",
    ]);

    if(!$rv["status"]){
        $crud->rollback();
        return $rv;
    }
    $rvId = $rv["data"];

    $crud->common_insert("receive_voucher_details", [
        "receive_voucher_id" => $rvId, "account_head_id" => $debitAccId,
        "dr" => $sale->total_amount, "cr" => 0, "remarks" => "Sale Invoice #" . $sale->id,
    ]);
    $crud->common_insert("receive_voucher_details", [
        "receive_voucher_id" => $rvId, "account_head_id" => $salesAccId,
        "dr" => 0, "cr" => $netSales, "remarks" => "Sales Income",
    ]);
    post_to_ledger($crud, "receive", $rvId, $debitAccId, $sale->total_amount, 0, "Sale #" . $sale->id, $sale->sale_date);
    post_to_ledger($crud, "receive", $rvId, $salesAccId, 0, $netSales, "Sale #" . $sale->id, $sale->sale_date);

    if($vatAmount > 0 && $vatAccId){
        $crud->common_insert("receive_voucher_details", [
            "receive_voucher_id" => $rvId, "account_head_id" => $vatAccId,
            "dr" => 0, "cr" => $vatAmount, "remarks" => "Output VAT",
        ]);
        post_to_ledger($crud, "receive", $rvId, $vatAccId, 0, $vatAmount, "Sale #" . $sale->id, $sale->sale_date);
    }

    $crud->commit();
    return $rv;
}

/**
 * ============================================================
 * PURCHASE -> PAYMENT VOUCHER (Purchase টেবিল থেকে কল করবেন insert এর পর)
 * ============================================================
 * $purchase অবজেক্টে থাকতে হবে: id, supplier_id, grand_total, vat, purchase_date, status
 * status: 1 = Received & Paid (Cash Cr), 0 = Pending হলে Accounts Payable Cr হবে
 */
function create_payment_voucher_for_purchase($crud, $purchase){
    $cashAccId     = get_account_id_by_code($crud, "CASH");
    $apAccId       = get_account_id_by_code($crud, "AP");
    $purchaseAccId = get_account_id_by_code($crud, "PURCHASE");
    $vatAccId      = get_account_id_by_code($crud, "VAT_INPUT");

    if(!$cashAccId || !$apAccId || !$purchaseAccId){
        return ["status" => false, "message" => "Account heads (CASH/AP/PURCHASE) সেটাপ করা নেই। sql/seed_accounts.sql রান করুন।"];
    }

    $creditAccId = ($purchase->status == 1) ? $cashAccId : $apAccId;
    $invoiceNo   = $crud->generate_invoice_no("payment_vouchers", "PV");
    $vatAmount   = isset($purchase->vat) ? (float) $purchase->vat : 0;
    $netPurchase = $purchase->grand_total - $vatAmount;

    $crud->begin_transaction();

    $pv = $crud->common_insert("payment_vouchers", [
        "invoice_no"  => $invoiceNo,
        "pay_to"      => "Supplier #" . $purchase->supplier_id,
        "note"        => "Auto generated from Purchase #" . $purchase->id,
        "date"        => $purchase->purchase_date,
        "source_type" => "purchase",
        "source_id"   => $purchase->id,
        "dr"          => $purchase->grand_total,
        "cr"          => $purchase->grand_total,
        "status"      => "Active",
    ]);

    if(!$pv["status"]){
        $crud->rollback();
        return $pv;
    }
    $pvId = $pv["data"];

    $crud->common_insert("payment_voucher_details", [
        "payment_voucher_id" => $pvId, "account_head_id" => $purchaseAccId,
        "dr" => $netPurchase, "cr" => 0, "remarks" => "Purchase Invoice #" . $purchase->id,
    ]);
    post_to_ledger($crud, "payment", $pvId, $purchaseAccId, $netPurchase, 0, "Purchase #" . $purchase->id, $purchase->purchase_date);

    if($vatAmount > 0 && $vatAccId){
        $crud->common_insert("payment_voucher_details", [
            "payment_voucher_id" => $pvId, "account_head_id" => $vatAccId,
            "dr" => $vatAmount, "cr" => 0, "remarks" => "Input VAT",
        ]);
        post_to_ledger($crud, "payment", $pvId, $vatAccId, $vatAmount, 0, "Purchase #" . $purchase->id, $purchase->purchase_date);
    }

    $crud->common_insert("payment_voucher_details", [
        "payment_voucher_id" => $pvId, "account_head_id" => $creditAccId,
        "dr" => 0, "cr" => $purchase->grand_total, "remarks" => "Purchase Invoice #" . $purchase->id,
    ]);
    post_to_ledger($crud, "payment", $pvId, $creditAccId, 0, $purchase->grand_total, "Purchase #" . $purchase->id, $purchase->purchase_date);

    $crud->commit();
    return $pv;
}
