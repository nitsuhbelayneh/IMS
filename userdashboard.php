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
<?php
if(isset($_GET['rid'])){
    $rid = $_GET['rid'];
    $sql = "select * from items";
    $query = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($query);
    $itemname = $row['itemname'];
    $itemid = $row['itemid'];
    $price = $row['price'];
    $model = $row['model'];
    $existingquantity = $row['quantity'];
    $requestedby = $_SESSION['username'];
    $requestdate = date("Y-m-d");
    $quntity = $_GET['quantity'];
    echo $quntity;
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
    <title>Storage Management System | User Dashboard</title>
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
                <li class="active">
                    <a href="userdashboard.php"><i class="fa fa-compass"></i> Dashboard</a>
                </li>
                <li class="">
                    <a href="requesteditem.php"><i class="fa fa-registered"></i> Requested Items </a>
                </li>
                <li class="mt-2">
                    <a href="usermessage.php"><i class="fa fa-envelope"></i>   Messages<span style="float: right;" class="badge badge-pill badge-success mt-1 "><?php
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
                <h2 class="text-center pb-3">Manage Items</h2>
                <?php
                    echo Message();
                    echo successMessage();
                ?>
                <div class="container-fluid">
                    <table style="width: 100%" id="table1" class= "table table-responsive-lg table-hover table-responsive-lg table-striped  ">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Item Id</th>
                            <th scope="col">Model</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price Per Item</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "select * from items";
                        $query = mysqli_query($con , $sql);
                        $no = 0;
                        while($row=mysqli_fetch_assoc($query)){
                        $id = $row['id'];
                        $itemname = $row['itemname'];
                        $itemid = $row['itemid'];
                        $eachprice = $row['price'];
                        $model = $row['model'];
                        $quantity = $row['quantity'];
                        $totalprice = $eachprice * $quantity;
                        $addedby = $row['addedby'];
                        $addeddate = $row['addeddate'];
                        $no++;
                        ?>
                            <tr>
                                <th scope="row"><?php echo $no;?></th>
                                <td><?php echo $itemname;?></td>
                                <td><?php echo $itemid;?></td>
                                <td><?php echo $model;?></td>
                                <td><?php echo $quantity;?></td>
                                <td><?php echo $eachprice;?></td>
                                <td><?php echo $totalprice;?></td>
                                <td>
                                    <form method="post" action="requestitem.php?rid=<?php echo $id;?>">
                                        <input  id="amount" type="number" min="1" name="quantity" class="form-control" placeholder="Amount">
                                        <div class="input-group-append">
                                            <button onclick="javascript:return confirm('Are You Sure You Want To Request Items?');" name="request" class="btn delete btn-primary">Request</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
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

                var count = 1;
                $('#add').click(function(){
                    count = count + 1;
                    var html_code = "<tr id='row"+count+"'>";
                    html_code += "<td contenteditable='true' class='item_name'>";
                    html_code += "<td contenteditable='true' class='item_type'>";
                    html_code += "<td contenteditable='true' class='item_type'>";
                    html_code += "<td contenteditable='true' class='item_type'>";
                    html_code += "<td contenteditable='true' class='item_type'>";
                    html_code += "<td contenteditable='true' class='item_type'>";
                    html_code += "<td contenteditable='true' class='item_type'>";
                    html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-sm remove'>-</button></td>";
                    html_code += "</tr>";
                    $('#table').append(html_code);
                });
                $(document).on('click','.remove',function(){
                   var delete_row = $(this).data("row");
                   $('#' + delete_row).remove();
                });
                $('#table1').DataTable();
            });
        </script>

</body>
</html>