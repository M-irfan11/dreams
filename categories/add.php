
<?php
require_once('../component/connection.php');
require_once('../component/header_auth.php');

if($_POST){
    $data = [
        "name" => $_POST['name'],
        "description" => $_POST['description']
    ];

    if(!empty($_SESSION['user_id'])){
        $data["created_by"] = $_SESSION['user_id'];
    }

    $result = $crud->common_insert("categories", $data);

    if($result['status']){
        header("Location: list.php");
        exit;
    }
}

require_once('../component/header.php');
require_once('../component/sidebar.php');
?>

<div class="page-wrapper">
    <div class="content">
        <div class="card">
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Category Name" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" placeholder="Description"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('../component/footer.php');?>
