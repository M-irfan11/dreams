<?php require_once "../component/header.php"; ?>
<!-- Sidebar Start -->
<?php require_once "../component/sidebar.php"; ?>
<!-- Sidebar End -->
<?php
  $id = $_GET['id'];
  $payment = $crud->common_select("payments", "*", ['id' => $id]);
  if (!$payment['status'] || empty($payment['data'])) {
    $_SESSION['message'] = array('danger','Error', 'Payment not found.');
    echo "<script>window.location.href = '".$base_url."payments/list.php';</script>";
    exit;
  }

  $payment = $payment['data'][0];

  // Get sale details to show customer name
  $sale = $crud->common_select("sales", "*", ['id' => $payment->sale_id]);
  $customer_name = 'N/A';
  if ($sale['status'] && !empty($sale['data'])) {
      $sale_data = $sale['data'][0];
      if (isset($sale_data->customer_id)) {
          $customer = $crud->common_select("customers", "name", ['id' => $sale_data->customer_id]);
          if ($customer['status'] && !empty($customer['data'])) {
              $customer_name = $customer['data'][0]->name;
          }
      }
  }
?>
<!-- Main Content -->
<div class="main-content">
  <div class="row">
    <div class="col-12">
      <div class="d-flex align-items-lg-center flex-column flex-md-row flex-lg-row mt-3">
        <div class="flex-grow-1">
          <h3 class="mb-2 text-size-26 text-color-2">Edit Payment</h3>
        </div>
        <div class="mt-3 mt-lg-0">
          <a href="<?= $base_url ?>payments/list.php" class="cursor-pointer bg-white bg-primary text-white d-flex align-items-center px-3 py-2 rounded-2 text-normal fw-bolder letter-spacing-26">
            <i class="fa-solid fa-arrow-left me-3"></i>
            Back to List
          </a>
        </div>
      </div><!-- end card header -->
    </div>
    <!--end col-->
  </div>
  <div class="mt-4">
    <div class="card shadow-sm border-0">
      <div class="card-body p-0">
        <form action="<?= $base_url; ?>payments/update.php?id=<?= $payment->id ?>" method="POST" class="p-4">

          <!-- Sale / Customer Info (Read-only display) -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="sale_info" class="form-label">Sale / Customer</label>
              <div class="form-control bg-light" style="height: auto; padding: 10px 12px;">
                <strong><?= htmlspecialchars($customer_name) ?></strong>
                <span class="text-muted ms-2">(SALE-<?= str_pad($payment->sale_id, 6, '0', STR_PAD_LEFT) ?>)</span>
              </div>
              <input type="hidden" name="sale_id" value="<?= $payment->sale_id ?>">
              <small class="text-muted">Sale cannot be changed. To change, delete and create new payment.</small>
            </div>
            <div class="col-md-6 mb-3">
              <label for="payment_date" class="form-label">Payment Date</label>
              <input type="date" value="<?= $payment->payment_date ?>" class="form-control" id="payment_date" name="payment_date" required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="amount" class="form-label">Amount</label>
              <input type="number" step="0.01" value="<?= $payment->amount ?>" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="payment_method" class="form-label">Payment Method</label>
              <select class="form-select" id="payment_method" name="payment_method" required>
                <option value="">Select Payment Method</option>
                <option value="Cash" <?= $payment->payment_method == 'Cash' ? 'selected' : '' ?>>Cash</option>
                <option value="Bkash" <?= $payment->payment_method == 'Bkash' ? 'selected' : '' ?>>Bkash</option>
                <option value="Nagad" <?= $payment->payment_method == 'Nagad' ? 'selected' : '' ?>>Nagad</option>
                <option value="Card" <?= $payment->payment_method == 'Card' ? 'selected' : '' ?>>Card</option>
                <option value="Bank" <?= $payment->payment_method == 'Bank' ? 'selected' : '' ?>>Bank</option>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 mb-3">
              <label for="transaction_id" class="form-label">Transaction ID</label>
              <input type="text" value="<?= htmlspecialchars($payment->transaction_id ?? '') ?>" class="form-control" id="transaction_id" name="transaction_id" placeholder="Enter transaction ID (optional)">
              <small class="text-muted">Required for online payments (Bkash, Nagad, Card, Bank)</small>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 mb-3">
              <button type="submit" class="btn btn-primary">Update Payment</button>
              <a href="<?= $base_url ?>payments/list.php" class="btn btn-secondary ms-2">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once "../component/footer.php" ?>
