<?php require_once "../../component/header.php"; ?>
<!-- Sidebar Start -->
<?php require_once "../../component/sidebar.php"; ?>
<!-- Sidebar End -->
 <?php
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
                <h3>Add New Journal</h3>
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
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Account Head</th>
                                <th>Debit (Dr)</th>
                                <th>Credit (Cr)</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="voucherItems">
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <button type="button" class="btn btn-secondary float-end" id="addRowBtn">Add Row</button>
                                </td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <th><input type="text" name="total_dr" id="totalDr" class="form-control" readonly></th>
                                <th><input type="text" name="total_cr" id="totalCr" class="form-control" readonly></th>
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
                </select></td>
                <td><input type="number" oninput="checkSameRowDrCr(this)" name="dr[]" class="form-control"></td>
                <td><input type="number" oninput="checkSameRowDrCr(this)" name="cr[]" class="form-control"></td>
                <td><input type="text" name="remarks[]" class="form-control"></td>
            `;
            voucherItems.appendChild(newRow);
        
    });

    function checkSameRowDrCr(input) {
        const row = input.parentElement.parentElement;
        const drInput = row.querySelector('input[name="dr[]"]');
        const crInput = row.querySelector('input[name="cr[]"]');

        if (input === drInput && parseFloat(drInput.value) > 0) {
            crInput.value = '';
        } else if (input === crInput && parseFloat(crInput.value) > 0) {
            drInput.value = '';
        }

        calculateTotalCRDR();
    }

    function calculateTotalCRDR() {
        let totalDr = 0;
        let totalCr = 0;

        document.querySelectorAll('input[name="dr[]"]').forEach(input => {
            totalDr += parseFloat(input.value) || 0;
        });

        document.querySelectorAll('input[name="cr[]"]').forEach(input => {
            totalCr += parseFloat(input.value) || 0;
        });

        document.getElementById('totalDr').value = totalDr.toFixed(2);
        document.getElementById('totalCr').value = totalCr.toFixed(2);

        // disable submit button if totals don't match
        const submitButton = document.querySelector('button[type="submit"]');
        if (totalDr !== totalCr) {
            submitButton.disabled = true;
        } else {
            submitButton.disabled = false;
        }
    }
</script>