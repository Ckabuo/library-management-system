<?php
global $conn;
session_start();
include ('../connection.php');
$name = $_SESSION['name'];
$id = $_SESSION['id'];
if(empty($id) || empty($name)) {
    header("Location: index.php"); 
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
                        <a href="#">View Category</a>
                    </li>
                </ol>

                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fa fa-info-circle"></i>
                        View Details
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Category Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_GET['ids'])){
                                            $id = $_GET['ids'];
                                            $delete_query = mysqli_query($conn, "delete from categories_table where id='$id'");

                                            if ($delete_query > 0) {
                                                $_SESSION['icon'] = "success";
                                                $_SESSION['text'] = "Category Deleted Successfully";
                                            } else {
                                                $_SESSION['icon'] = "error";
                                                $_SESSION['text'] = "Category Not Deleted";
                                            }
                                        }
                                        $select_query = mysqli_query($conn, "select * from categories_table");
                                        $sn = 1;
                                        while($row = mysqli_fetch_array($select_query))
                                        {
                                    ?>
                                    <tr>
                                        <td><?php echo $sn; ?></td>
                                        <td><?php echo $row['category_name']; ?></td>
                                        <?php if($row['status']==1){
                                            ?><td><span class="badge badge-success">Active</span></td>
                                        <?php } else { ?><td><span class="badge badge-danger">Inactive</span></td>
                                        <?php } ?>
                                        <td>
                                            <a href="edit-category.php?id=<?php echo $row['id'];?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a href="#?>" onclick="return confirmDelete(<?php echo $row['id'];?>)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </td>
                                    </tr>
                                        <?php $sn++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

<script language="JavaScript" type="text/javascript">
     function confirmDelete(id){
         return Swal.fire({
             title: "Are you sure?",
             text: "Are you sure want to delete this Category?",
             icon: "warning",
             showCancelButton: true,
             confirmButtonColor: "#3085d6",
             cancelButtonColor: "#d33",
             confirmButtonText: "Yes, delete it!"
         }).then((result) => {
             if (result.isConfirmed) {
                 window.location.href = `view-category.php?ids=${id}`;
             }

         })
     }
</script>

<?php
if(isset($_SESSION['text']) || isset($_SESSION['icon'])) {
    ?>
    <script>
        Swal.fire({
            icon: "<?php echo $_SESSION['icon']?>",
            text: "<?php echo $_SESSION['text']?>",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `view-category.php`;
            }
        });
    </script>
    <?php
    unset($_SESSION['text'], $_SESSION['icon']);
}
?>

<?php include('include/footer.php'); ?>
