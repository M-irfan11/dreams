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

  // Get sale + customer details
  $sale = $crud->common_select("sales", "*", ['id' => $payment->sale_id]);
  $customer_name = 'N/A';
  $sale_data = null;
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
          <h3 class="mb-2 text-size-26 text-color-2">Payment Details</h3>
        </div>
        <div class="mt-3 mt-lg-0">
          <a href="<?= $base_url ?>payments/list.php" class="cursor-pointer bg-white bg-primary text-white d-flex align-items-center px-3 py-2 rounded-2 text-normal fw-bolder letter-spacing-26">
            <i class="fa-solid fa-arrow-left me-3"></i>
            Back to List
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-4">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label text-color-2 fw-bold">Customer</label>
            <div class="form-control bg-light"><?= htmlspecialchars($customer_name) ?></div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-color-2 fw-bold">Sale Reference</label>
            <div class="form-control bg-light">
              SALE-<?= str_pad($payment->sale_id, 6, '0', STR_PAD_LEFT) ?>
              <?php if ($sale_data): ?>
                <span class="text-muted ms-2">(Total: $<?= number_format($sale_data->total_amount, 2) ?>)</span>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label text-color-2 fw-bold">Amount Paid</label>
            <div class="form-control bg-light">$<?= number_format($payment->amount, 2) ?></div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-color-2 fw-bold">Payment Date</label>
            <div class="form-control bg-light"><?= date('d-m-Y', strtotime($payment->payment_date)) ?></div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label text-color-2 fw-bold">Payment Method</label>
            <div class="form-control bg-light"><?= htmlspecialchars($payment->payment_method) ?></div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-color-2 fw-bold">Transaction ID</label>
            <div class="form-control bg-light"><?= $payment->transaction_id ? htmlspecialchars($payment->transaction_id) : '-' ?></div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 mt-3">
            <a href="<?= $base_url ?>payments/edit.php?id=<?= $payment->id ?>" class="btn btn-primary">
              <i class="fa-regular fa-pen-to-square me-2"></i>Edit Payment
            </a>
            <a href="<?= $base_url ?>payments/list.php" class="btn btn-secondary ms-2">Back to List</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once "../component/footer.php" ?>
