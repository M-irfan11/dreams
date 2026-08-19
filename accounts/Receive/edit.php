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

    $voucher_id=$_GET['id'] ?? null;
    $voucherData = [];
    if ($voucher_id) {
        $voucherResult = $crud->common_query("SELECT * FROM receive_vouchers WHERE id = $voucher_id");
        if ($voucherResult['status']) {
            $voucherData = $voucherResult['data'][0];
        }
        $voucherDetailsResult = $crud->common_query("SELECT * FROM receive_voucher_details WHERE receive_voucher_id = $voucher_id");
        if ($voucherDetailsResult['status']) {
            $voucherDetails = $voucherDetailsResult['data'];
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
        
        <form action="update.php" method="POST">
            <input type="hidden" name="voucher_id" value="<?= $voucher_id ?>">
            <div class="row">
                <div class="col-md-6">
                    <label>Voucher Date</label>
                    <input type="date" value="<?= $voucherData->voucher_date ?? '' ?>" name="voucher_date" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Narration</label>
                    <input type="text" value="<?= $voucherData->narration ?? '' ?>" name="narration" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Receive from</label>
                    <input type="text" value="<?= $voucherData->pay_to ?? '' ?>" name="received_from" class="form-control" required>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Account Head</th>
                                <th>Credit (Cr)</th>
                                <th>Debit (Dr)</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="voucherItems">
                            <?php
                            if (!empty($voucherDetails)) {
                                foreach ($voucherDetails as $detail) {
                                    echo "<tr>
                                        <td><select name='account_head_id[]' class='form-control' required>";
                                    foreach ($accheadsData as $head) {
                                        $selected = $head['id'] == $detail->account_head_id ? 'selected' : '';
                                        echo "<option value='{$head['id']}' {$selected}>{$head['name']}</option>";
                                    }
                                    echo "</select></td>
                                        <td><input type='number' oninput='checkSameRowDrCr(this)' name='cr[]' class='form-control' value='{$detail->cr}'></td>
                                        <td><input type='number' oninput='checkSameRowDrCr(this)' name='dr[]' class='form-control' value='{$detail->dr}'></td>
                                        <td><input type='text' name='remarks[]' class='form-control' value='{$detail->remarks}'></td>
                                    </tr>";
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <button type="button" class="btn btn-secondary float-end" id="addRowBtn">Add Row</button>
                                </td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <th><input type="text" value="<?= $voucherData->cr ?? 0 ?>" name="total_cr" id="totalCr" class="form-control" readonly></th>
                                <th><input type="text" value="<?= $voucherData->dr ?? 0 ?>" name="total_dr" id="totalDr" class="form-control" readonly></th>
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
                <td><input type="number" oninput="checkSameRowDrCr(this)" name="cr[]" class="form-control"></td>
                <td><input type="number" oninput="checkSameRowDrCr(this)" name="dr[]" class="form-control"></td>
                <td><input type="text" name="remarks[]" class="form-control"></td>
            `;
            voucherItems.appendChild(newRow);
        
    });

    function checkSameRowDrCr(input) {
        const row = input.parentElement.parentElement;
        const crInput = row.querySelector('input[name="cr[]"]');
        const drInput = row.querySelector('input[name="dr[]"]');

        if (input === drInput && parseFloat(drInput.value) > 0) {
            crInput.value = '';
        } else if (input === crInput && parseFloat(crInput.value) > 0) {
            drInput.value = '';
        }

        calculateTotalCRDR();
    }

    function calculateTotalCRDR() {
        let totalCr = 0;
        let totalDr = 0;

        document.querySelectorAll('input[name="cr[]"]').forEach(input => {
            totalCr += parseFloat(input.value) || 0;
        });

        document.querySelectorAll('input[name="dr[]"]').forEach(input => {
            totalDr += parseFloat(input.value) || 0;
        });

        document.getElementById('totalCr').value = totalCr.toFixed(2);
        document.getElementById('totalDr').value = totalDr.toFixed(2);

        // disable submit button if totals don't match
        const submitButton = document.querySelector('button[type="submit"]');
        if (totalCr !== totalDr) {
            submitButton.disabled = true;
        } else {
            submitButton.disabled = false;
        }
    }
</script>