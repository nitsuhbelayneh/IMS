<?php include 'include/db.php'?>
<?php include 'include/sessions.php'?>
<?php include 'include/functions.php'?>
<?php
if(!($_SESSION['role'] == 'user')){
    $_SESSION['ErrorMessage'] = "You Don't have Permission to Access This Page";
    redirect_to('index.php');
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="datatables/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="css/tselot.css">
    <title>Storage Management System | Requested Items</title>
</head>
<body>
    <div class="wrapper" style="height:auto;">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>User</h3>
            </div>

            <ul class="list-unstyled components">
                <p class="text-center" style="font-weight: bold; font-size:20px !important;"><?php echo $_SESSION['username'];?></p>
                <li class="">
                    <a href="userdashboard.php"><i class="fa fa-compass"></i> Dashboard</a>
                </li>
                <li class="active">
                    <a href="requesteditem.php"><i class="fa fa-registered"></i> Requested Items</a>
                </li>
                <li class="mt-2">
                    <a href="usermessage.php"><i class="fa fa-envelope"></i> Messages<span style="float: right;" class="badge badge-pill badge-success mt-1 "><?php
                            $username = $_SESSION['username'];
                            $sql = "select * from messages where status = 'New' and recipient = '$username'";
                            $query = mysqli_query($con,$sql);
                            $count = mysqli_num_rows($query);
                            echo $count;

                            ?></span></a>
                </li>
            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                    <a href="logout.php" class="download">Logout</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content Holder -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="navbar-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#"><i class="fa fa-"></i></a>
                            </li>
                          
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> LogOut</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container-fluid">
                <h2 class="text-center pb-3">Your Requests</h2>
                <?php
                    echo Message();
                    echo successMessage();
                ?>
                <div class="container-fluid">
                    <table id="table1" class="table table-hover table-responsive-lg table-striped table-responsive-lg col-sm-12">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Item Id</th>
                            <th scope="col">Price</th>
                            <th scope="col">Model</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Requested By</th>
                            <th scope="col">Request Status</th>
                            <th scope="col">Request Date</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $requesteby = $_SESSION['username'];
                        $sql = "select * from requests where requestedby = '$requesteby' order by requeststatus asc";
                        $query = mysqli_query($con,$sql);
                        $no = 0;
                        while($row = mysqli_fetch_assoc($query)){
                            $id = $row['id'];
                            $itemname = $row['itemname'];
                            $itemid = $row['itemid'];
                            $model = $row['model'];
                            $price = $row['price'];
                            $quantity = $row['quantity'];
                            $requestedby = $row['requestedby'];
                            $requeststatus = $row['requeststatus'];
                            $requestdate = $row['requestdate'];
                            $no++;
                        ?>
                        <tr>
                            <th scope="row"><?php echo $no;?></th>
                            <td><?php echo $itemname;?></td>
                            <td><?php echo $itemid;?></td>
                            <td><?php echo $price;?></td>
                            <td><?php echo $model;?></td>
                            <td><?php echo $quantity;?></td>
                            <td><?php echo $requestedby;?></td>
                            <td><?php echo $requeststatus;?></td>
                            <td><?php echo $requestdate;?></td>
                            <td>
                                <?php if($requeststatus == 'Returned'){

                                 ?>

                                <?php }elseif($requeststatus == 'Approved'){?>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a class="btn btn-success" href="#" role="button">Transfer Item</a>
                                    </div>
                                <?php }else{?>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a onclick="javascript:return confirm('Are You Sure You Want To Cancel Your Request?');" class="btn btn-warning" href="cancelrequest.php?cid=<?php echo $id;?>" role="button">Cancel Request</a>
                                </div>
                                <?php }?>
                            </td>
                        </tr>
                        <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="datatables/js/jquery.dataTables.min.js"></script>
    <script src="datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').toggleClass('active');
                    $(this).toggleClass('active');
                });
                $('#table1').DataTable();
                $('#table2').DataTable();
            });
        </script>

</body>
</html>