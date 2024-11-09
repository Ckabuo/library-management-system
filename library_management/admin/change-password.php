<?php
global $conn;
session_start();
include ('../connection.php');
$name = $_SESSION['name'];
$id = $_SESSION['id'];
if(empty($id) || empty($name)){}
{
    header("Location: index.php"); 
}
if(isset($_REQUEST['change-pwd'])) {

    $c_password = md5($_POST['c_password']);
    $n_password = $_POST['n_password'];
    $c_n_password = $_POST['c_n_password'];

    $select_query = mysqli_query($conn, "select password from users_table where id='$id'");
    $curr_pass = mysqli_fetch_assoc($select_query);
    if($curr_pass['password']==$c_password){
        if($n_password == $c_n_password){
            $new_pwd = md5($n_password);
            $sql = "update `users_table` set password='$new_pwd' where id='$id' and role=1";
            $result = mysqli_query($conn, $sql);
            if($result){
                $_SESSION['icon'] = "success";
                $_SESSION['text'] = "Your password has been changed successfully!";

                // Clear POST data
                unset($_POST);

                //Redirect to the same page
                header("Location: ". $_SERVER['PHP_SELF']);
                exit();

            } else {
                $_SESSION['icon'] = "error";
                $_SESSION['text'] = "Something went wrong!";

                // Clear POST data
                unset($c_password, $n_password, $c_n_password);

                //Redirect to the same page
                header("Location: ". $_SERVER['PHP_SELF']);
                exit();

            }
        } else {
            $_SESSION['icon'] = "error";
            $_SESSION['text'] = "New Password and Confirm New Password do not match!";

            // Clear POST data
            unset($c_password, $n_password, $c_n_password);

            //Redirect to the same page
            header("Location: ". $_SERVER['PHP_SELF']);
            exit();
        }
    } else {
        $_SESSION['icon'] = "warning";
        $_SESSION['text'] = "Current Password does not match!";

        // Clear POST data
        unset($c_password, $n_password, $c_n_password);

        //Redirect to the same page
        header("Location: ". $_SERVER['PHP_SELF']);
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
                        <a href="#">Change Password</a>
                    </li>
                </ol>

                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fa fa-info-circle"></i>
                        Submit Password Details
                    </div>

                    <form method="post" class="form-valide">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="c_password">Current Password <span class="text-danger">*</span></label>
                                <div class="col-lg-6">
                                    <input type="password" name="c_password" id="c_password" class="form-control" placeholder="Enter Current Password" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="n_password">New Password <span class="text-danger">*</span></label>
                                <div class="col-lg-6">
                                    <input type="password" name="n_password" id="n_password" class="form-control" placeholder="Enter New Password" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="c_n_password">Confirm New Password <span class="text-danger">*</span></label>
                                <div class="col-lg-6">
                                    <input type="password" name="c_n_password" id="c_n_password" class="form-control" placeholder="Confirm New Password" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-8 ml-auto">
                                    <button type="submit" name="change-pwd" class="btn btn-primary">Submit</button>
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

        });
    </script>
    <?php
    unset($_SESSION['text']);
    unset($_SESSION['icon']);
}
?>

 <?php include('include/footer.php'); ?>