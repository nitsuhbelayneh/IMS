<?php include 'include/db.php'?>
<?php include 'include/sessions.php'?>
<?php include 'include/functions.php'?>
<?php
if(!($_SESSION['role'] == 'storemanager')){
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
    <title>Storage Management System | Manage Requests</title>
</head>
<body>
    <div class="wrapper" style="height:auto;">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Store Manager</h3>
            </div>

            <ul class="list-unstyled components">
                <p class="text-center" style="font-weight: bold; font-size:20px !important;"><?php echo $_SESSION['username'];?></p>
                <li class="">
                    <a href="storemanagerdashboard.php"><i class="fa fa-compass"></i> Dashboard</a>
                </li>
                <li class="active">
                    <a href="managerequests.php"><i class="fa fa-registered"></i> Manage Requests <span style="float: right;" class="badge badge-pill badge-primary mt-1 "><?php
                                $sql = "select * from requests where requeststatus = 'Pending'";
                                $query = mysqli_query($con,$sql);
                                $count = mysqli_num_rows($query);
                                echo $count;

                            ?></span></a>
                </li>
                <li class="mt-2">
                    <a href="managestoremanagers.php"><i class="fa fa-archive"></i> Manage Store Manager</a>
                </li>
                <li class="mt-2">
                    <a href="managestorekeepers.php"><i class="fa fa-archive"></i> Manage Store Keepers</a>
                </li>
                <li class="mt-2">
                    <a href="manageusers.php"><i class="fa fa-user"></i> Manage Users</a>
                </li>
                <li class="mt-2">
                    <a href="storemanagermessage.php"><i class="fa fa-envelope"></i> Messages<span style="float: right;" class="badge badge-pill badge-success mt-1 "><?php
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
                <?php
                    echo Message();
                    echo successMessage();
                ?>
                <h2 class="text-center pb-3">Manage Requests</h2>
                <h3 class="pb-3 text-center">Pending Requests</h3>
                <div class="container-fluid">
                    <table id="table1" class="table table-responsive-lg table-hover table-striped col-sm-12">
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
                                $sql = "select * from requests where requeststatus = 'Pending'";
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
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a onclick="javascript:return confirm('Are You Sure You Want To Approve This Request?');" class="btn btn-warning" href="approve.php?aid=<?php echo $id;?>" role="button">Approve</a>
                                            <a onclick="javascript:return confirm('Are You Sure You Want To Delete This Request?');" class="btn btn-danger" href="deleterequest.php?did=<?php echo $id;?>" role="button">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
                <h3 class="pb-3 text-center">Approved Requests</h3>
                <div class="container-fluid">
                    <table id="table2" class="table table-responsive-lg table-hover table-striped col-sm-12">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Item Id</th>
                            <th scope="col">Price</th>
                            <th scope="col">Model</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Requested By</th>
                            <th scope="col">Approved By</th>
                            <th scope="col">Request Status</th>
                            <th scope="col">Request Date</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select * from requests where requeststatus = 'Approved'";
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
                                $approvedby = $row['approvedby'];
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
                                    <td><?php echo $approvedby;?></td>
                                    <td><?php echo $requeststatus;?></td>
                                    <td><?php echo $requestdate;?></td>
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