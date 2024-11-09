<?php
global $conn;
session_start();
include ('../connection.php');
$name = $_SESSION['name'];
$id = $_SESSION['id'];
if(empty($id) || empty($name)) {
    header("Location: index.php"); 
}
if(isset($_REQUEST['sbt-usr']))
{

    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $pwd = md5($_POST['pwd']);
    $role = $_POST['role'];
    $status = $_POST['status'];

    $insert_user = mysqli_query($conn,"insert into users_table set user_name='$user_name', email='$email', password='$pwd', role='$role', status='$status'");

    if($insert_user > 0) {
        $_SESSION['icon'] = "success";
        $_SESSION['text'] = "User Added Successfully";

        //Clear POST data
        unset($user_name,$email,$pwd,$role,$status);

        //Redirect to the same page
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();

    } else {
        $_SESSION['icon'] = "error";
        $_SESSION['text'] = "User Not Added";

        //Clear POST data
        unset($user_name,$email,$pwd,$role,$status);

        //Redirect to the same page
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
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
                    <a href="#">Add User</a>
                </li>
            </ol>

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-info-circle"></i>
                    Submit Details
                </div>

                <form method="post" class="form-valide">
                    <div class="card-body">
                                      
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="user_name">Username <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter Userame" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="email">Email <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your Email" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="pwd">Password <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="password" name="pwd" id="pwd" class="form-control" placeholder="Enter Password" required>
                            </div>
                        </div>
                                  
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="role">Role <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <select class="form-control" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option  value="1">Admin</option>
                                    <option  value="2">User</option>
                                </select>
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
                                <button type="submit" name="sbt-usr" class="btn btn-primary">Submit</button>
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
                // window.location.reload();
                window.location.href = 'view-users.php';
            }

        });
    </script>
    <?php
    unset($_SESSION['text']);
    unset($_SESSION['icon']);
}
?>

 <?php include('include/footer.php'); ?>