<?php
global $conn;
session_start();
include ('../connection.php');
$name = $_SESSION['name'];
$id = $_SESSION['id'];
if(empty($id) || empty($name)) {
    header("Location: index.php"); 
}
if(isset($_REQUEST['sbt-plc']))
{
   
	$place_name = $_POST['place_name'];
  $status = $_POST['status'];

  $insert_location = mysqli_query($conn,"insert into locations_table set name='$place_name', status='$status'");

    if($insert_location > 0) {
        $_SESSION['icon'] = "success";
        $_SESSION['text'] = "Location Added Successfully";

    } else {
        $_SESSION['icon'] = "error";
        $_SESSION['text'] = "Location Not Added";

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
                    <a href="#">Add Place</a>
                </li>
            </ol>

            <div class="card mb-3">

                <div class="card-header">
                    <i class="fa fa-info-circle"></i>
                    Submit Details
                </div>

                <form method="post" class="form-validate">
                    <div class="card-body">

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="place_name">Place Name <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="place_name" id="place_name" class="form-control" placeholder="Enter Place Name" required>
                            </div>
                        </div>
                                  
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="status">Status <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option  value="1">Active</option>
                                    <option  value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                           
                        <div class="form-group row">
                            <div class="col-lg-8 ml-auto">
                                <button type="submit" name="sbt-plc" class="btn btn-primary">Submit</button>
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
                window.location.href = 'view-place.php';
            }

        });
    </script>
    <?php
    unset($_SESSION['text']);
    unset($_SESSION['icon']);
}
?>

 <?php include('include/footer.php'); ?>