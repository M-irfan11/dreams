<?php require_once "../../component/header.php"; ?>
<!-- Sidebar Start -->
<?php require_once "../../component/sidebar.php"; ?>
<!-- Sidebar End -->
 <?php
    // Fetch account heads for the dropdown
    $accheadsDatadr=[];
    $accountHeadsdr = $crud->common_query("SELECT id, account_name FROM account_heads WHERE account_subtype ='Current Asset' and deleted_at IS NULL"); 
    if($accountHeadsdr['status']) {
        foreach ($accountHeadsdr['data'] as $head) {
            $accheadsDatadr[] = [
                'id' => $head->id,
                'name' => $head->account_name
            ];
        }
    }
    // Fetch account heads for the dropdown
    $accheadsData=[];
    $accountHeads = $crud->common_query("SELECT id, account_name FROM account_heads WHERE deleted_at IS NULL"); 
    if($accountHeads['status']) {
        foreach ($accountHeads['data'] as $head) {
            $accheadsData[] = [
                'id' => $head->id,
                'name' => $head->account_name
            ];
        }
    }
    ?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">
                <h3>Received From</h3>
            </div>
        </div>
        
        <form action="store.php" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <label>Voucher Date</label>
                    <input type="date" name="voucher_date" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Narration</label>
                    <input type="text" name="narration" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Received From</label>
                    <input type="text" name="pay_to" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Received From</label>
                    <select name="pay_dr" class="form-control" required>
                        <?php foreach ($accheadsDatadr as $head): ?>
                            <option value="<?= $head['id'] ?>"><?= $head['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Account Head</th>
                                <th>Amount</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="voucherItems">
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    <button type="button" class="btn btn-secondary float-end" id="addRowBtn">Add Row</button>
                                </td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <th><input type="text" name="totalAmount" id="totalAmount" class="form-control" readonly></th>
                                <th></th>
                            </tr>
                    </table>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Save Voucher</button>
        </form>
    </div>
</div>
<?php require_once "../../component/footer.php"; ?>
<script>
    document.getElementById('addRowBtn').addEventListener('click', function() {
       
            const voucherItems = document.getElementById('voucherItems');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><select name="account_head_id[]" class="form-control" required>
                    <?php foreach ($accheadsData as $head): ?>
                        <option value="<?= $head['id'] ?>"><?= $head['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="number" oninput="calculateTotal()" name="cr[]" class="form-control"></td>
                <td><input type="text" name="remarks[]" class="form-control"></td>
            `;
            voucherItems.appendChild(newRow);
        
    });

    function calculateTotal() {
        let total = 0;

        document.querySelectorAll('input[name="cr[]"]').forEach(input => {
            total += parseFloat(input.value) || 0;
        });

        document.getElementById('totalAmount').value = total.toFixed(2);

    }
</script>