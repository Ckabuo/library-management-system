<?php
session_start();
include ('connection.php');
$name = $_SESSION['user_name'];
$ids = $_SESSION['id'];
//$id = $_GET['id'];
if(empty($ids))
{
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
                    <a href="#">View Book</a>
                </li>
            </ol>

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-info-circle"></i>
                    View Book Details
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Author</th>
                                    <th>ISBN</th>
                                    <th>Availability</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(isset($_GET['ids'])){
                                        $id = $_GET['ids'];
                                        $insert_issue = mysqli_query($conn, "insert into issues_table set book_id='$id', user_id='$ids', user_name='$name', issue_date= NOW(),due_date= DATE_ADD(NOW(), INTERVAL 5 DAY), status=3");
                                        if($insert_issue > 0) {
                                            $_SESSION['icon'] = "success";
                                            $_SESSION['text'] = "Request Sent Successfully";
                                        } else {
                                            $_SESSION['icon'] = "error";
                                            $_SESSION['text'] = "Request Failed";
                                        }
                                    }

                                    $select_query = mysqli_query($conn, "select * from books_table where availability=1");
                                    $sn = 1;
                                    while($row = mysqli_fetch_array($select_query))
                                    {
                                        ?>
                                <tr>
                                    <td><?php echo $sn; ?></td>
                                    <td><?php echo $row['book_name']; ?></td>
                                    <td><?php echo $row['category']; ?></td>
                                    <td><?php echo $row['author']; ?></td>
                                    <td><?php echo $row['isbnno']; ?></td>
                                    <?php if($row['availability']==1){
                                        ?>
                                    <td><span class="badge badge-success">Available</span></td>
                                    <?php } else { ?><td><span class="badge badge-danger">Not Available</span></td>
                                    <?php }
                                        $id = $row['id'];
                                        $fetch_issue_details = mysqli_query($conn, "select status from issues_table where user_id='$ids' and book_id='$id'");
                                        $res = mysqli_fetch_row($fetch_issue_details);
                                        if(!empty($res)){
                                            $res = $res[0];
                                           }
                                        if($res==1){
                                            ?>
                                    <td><span class="badge badge-success">Issued</span>
                                    </td>
                                        <?php
                                        } else if($res==2){
                                            ?>
                                    <td>
                                        <span class="badge badge-danger">Rejected</span>
                                    </td>
                                        <?php }
                                         else if($res==3){
                                                ?>
                                    <td>
                                        <span class="badge badge-primary">Request Sent</span>
                                    </td>
                                         <?php }
                                               else { ?>
                                    <td>
                                        <a href="#" onclick="return confirmIssue(<?php echo $row['id']; ?>)">
                                            <button class="btn btn-success">Issue</button></a>
                                    </td>
                                          <?php } ?>
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

<?php include('include/footer.php'); ?>

<script language="JavaScript" type="text/javascript">
    function confirmIssue(id){
        return Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want this book?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, please!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `book.php?ids=${id}`;
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
                window.location.href = `book.php`;
            }

        });
    </script>
    <?php
    unset($_SESSION['text'], $_SESSION['icon']);
}
?>