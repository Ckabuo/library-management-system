<?php
global $conn;
session_start();
include ('../connection.php');
$name = $_SESSION['name'];
$id = $_SESSION['id'];
if(empty($id))
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
            <a href="#">View Book Issue Requests</a>
          </li>
        </ol>
  <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-info-circle"></i>
            Issue Requests</div>
            <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Book Name</th>
                        <th>User Name</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(!empty($_GET['id'])) {
                            $id = $_GET['id'];
                            $duedate = date('Y-m-d');
                            $newdate = date('Y-m-d', strtotime($duedate. ' + 3 months'));
                            $update_issue = mysqli_query($conn, "update issues_table set status=1, issue_date=CURDATE(), due_date='$newdate' where id='$id'");

                            $select_book_id = mysqli_query($conn,"select book_id from issues_table where id='$id'");
                            $book_id = mysqli_fetch_row($select_book_id);
                            $book_id = $book_id[0];
                            $select_quantity = mysqli_query($conn, "select quantity from books_table where id='$book_id'");
                            $number = mysqli_fetch_row($select_quantity);
                            $count = $number[0];
                            $count = $count-1;
                            $update_book = mysqli_query($conn, "update books_table set quantity='$count' where id='$book_id'");
                            if($update_issue > 0) {
                                $_SESSION['icon'] = "success";
                                $_SESSION['text'] = "Book Issued Successfully";

                            } else {
                                $_SESSION['icon'] = "warning";
                                $_SESSION['text'] = "Something Went Wrong";
                            }
                        }

                        if(!empty($_GET['ids'])) {
                            $ids = $_GET['ids'];
                            $update_issue = mysqli_query($conn, "update issues_table set status=2 where id='$ids'");
                            if($update_issue > 0) {
                                $_SESSION['icon'] = "success";
                                $_SESSION['text'] = "Book Issue Rejected";
                            } else {
                                $_SESSION['icon'] = "warning";
                                $_SESSION['text'] = "Something Went Wrong";
                            }
                        }
                    ?>
                    <?php
                        $select_query = mysqli_query($conn, "select issues_table.status, issues_table.book_id, books_table.book_name, issues_table.id, issues_table.user_name, books_table.quantity from issues_table inner join books_table on books_table.id=issues_table.book_id");
                        $sn = 1;
                        while($row = mysqli_fetch_array($select_query))
                        {
                    ?>
                <tr>
                    <td><?php echo $sn; ?></td>
                    <td><?php echo $row['book_name']; ?></td>
                    
                    <td><?php echo $row['user_name']; ?></td>
                    
                    <td><?php echo $row['quantity']; ?></td>
                    <?php
                    if(!empty($row['status']) && $row['status']==1)
                    {?>
                      <td><span class="badge badge-primary">Book Issued</span>
                   
                     </td>
                    <?php 
                    } else if($row['status']==2)
                    {?>
                    <td><span class="badge badge-danger">Rejected</span>
                       <a href="#" onclick=" return acceptRequest(<?php echo $row['id']; ?>)"><button class="btn btn-success">Accept</button></a>
                    </td>
                   <?php } else {?>
                  <td><a href="#" onclick=" return acceptRequest(<?php echo $row['id']; ?>) "><button class="btn btn-success">Accept</button></a>
                   <a href="#" onclick=" return rejectRequest(<?php echo $row['id']; ?>)"><button class="btn btn-danger">Reject</button></a>
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
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

    <script language="JavaScript" type="text/javascript">
        function acceptRequest(id){
            return Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to Accept this Request?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Please!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `issue-request.php?id=${id}`;
                }

            })
        }
    </script>

<!-- To Reject Book Issue Request -->
    <script language="JavaScript" type="text/javascript">
        function rejectRequest(id){
            return Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to Reject this Request?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Please!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `issue-request.php?ids=${id}`;
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
                    window.location.href = `issue-request.php`;
                }

            });
        </script>
    <?php
    unset($_SESSION['text'], $_SESSION['icon']);
}
?>

<?php include('include/footer.php'); ?>