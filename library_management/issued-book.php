<?php
global $conn;
session_start();
include ('connection.php');
$name = $_SESSION['user_name'];
$ids = $_SESSION['id'];
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
                                    <th>Book Name</th>
                                    <th>Category</th>
                                    <th>Issue Date</th>
                                    <th>Due Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_GET['ids'])) {
                                    $id = $_GET['ids'];
                                    $delete_book = mysqli_query($conn, "delete from issues_table where book_id='$id' and  user_id='$ids'");
                                    $return_book = mysqli_query($conn, "insert into returns_table set book_id='$id', user_id='$ids', user_name='$name', return_date=CURDATE()");
                                    $select_quantity = mysqli_query($conn, "select quantity from books_table where id='$id'");
                                    $number = mysqli_fetch_row($select_quantity);
                                    $count = $number[0];
                                    $count = $count+1;
                                    $update_book = mysqli_query($conn, "update books_table set quantity='$count' where id='$id'");
                                    $update_issue_status = mysqli_query($conn, "update issues_table set status=0 where book_id='$id'");

                                    if($update_book > 0){
                                        $_SESSION['icon'] = "success";
                                        $_SESSION['text'] = "Book Returned Successfully";

                                    } else {
                                        $_SESSION['icon'] = "error";
                                        $_SESSION['text'] = "Book Return Failed";

                                    }

                                }

                                $select_query = mysqli_query($conn, "select issues_table.book_id, books_table.book_name, books_table.category, issues_table.issue_date, issues_table.due_date from issues_table inner join books_table on issues_table.book_id=books_table.id where issues_table.user_id='$ids' and issues_table.status=1");
                                $sn = 1;
                                while($row = mysqli_fetch_array($select_query))
                                {
                                ?>
                                <tr>
                                    <td><?php echo $sn; ?></td>
                                    <td><?php echo $row['book_name']; ?></td>
                                    <td><?php echo $row['category']; ?></td>
                                    <td><?php echo $row['issue_date']; ?></td>
                                    <td><?php echo $row['due_date']; ?></td>
                                    <td><a href="#" onclick="return confirmReturn(<?php echo $row['book_id']; ?>)">
                                            <button class="btn btn-success">Return</button></a>
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
    function confirmReturn(id){
        return Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want to return this book?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, please!"

        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `issued-book.php?ids=${id}`;
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
                window.location.href = `issued-book.php`;
            }

        });
    </script>
    <?php
    unset($_SESSION['text'], $_SESSION['icon']);
}
?>

<?php include('include/footer.php'); ?>
 