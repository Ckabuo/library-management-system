<?php
global $conn;
session_start();
include ('../connection.php');
$name = $_SESSION['name'];
$id = $_SESSION['id'];
if(empty($id) || empty($name)) {
    header("Location: index.php"); 
}
$id = $_GET['id'];
$fetch_query = mysqli_query($conn, "select * from categories_table where id='$id'");
$row = mysqli_fetch_array($fetch_query);
if(isset($_REQUEST['sv-cat'])) {
   
	$category_name = $_POST['category_name'];
    $status = $_POST['status'];

    $update_category = mysqli_query($conn,"update categories_table set category_name='$category_name', status='$status' where id='$id'");

    if($update_category > 0) {
        $_SESSION['icon'] = "success";
        $_SESSION['text'] = "Category updated successfully";

    } else {
        $_SESSION['icon'] = "error";
        $_SESSION['text'] = "Error updating category";

    }
}
?>
<?php include('include/header.php'); ?>

<div id="wrapper">

    <?php include('include/side-bar.php'); ?>

    <div id="content-wrapper">

        <div class="container-fluid">

            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Edit Category</a>
                </li>
            </ol>

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-info-circle"></i>
                    Edit Details
                </div>

                <form method="post" class="form-valide">
                    <div class="card-body">
                                      
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="category_name">Category Name <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Enter Category Name" value="<?php echo $row['category_name']; ?>" required>
                            </div>
                        </div>
                                  
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="status">Status <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="1" <?php if($row['status'] == 1) { ?> selected="selected"; <?php } ?>>Active</option>
                                    <option value="0" <?php if($row['status'] == 0) { ?> selected="selected"; <?php } ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                                      
                        <div class="form-group row">
                            <div class="col-lg-8 ml-auto">
                                <button type="submit" name="sv-cat" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                                    
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

<?php
if(isset($_SESSION['text']) || isset($_SESSION['icon'])) {
    ?>
    <script>
        Swal.fire({

            icon: "<?php echo $_SESSION['icon']?>",
            text: "<?php echo $_SESSION['text']?>",

        }).then((result)=>{
            if (result.isConfirmed) {
                window.location.href = 'view-category.php';
            }

        });
    </script>
    <?php
    unset($_SESSION['text']);
    unset($_SESSION['icon']);
}
?>

<?php include('include/footer.php'); ?>