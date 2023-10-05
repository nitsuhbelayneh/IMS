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
    <title>Storage Management System | Store Manager Dashboard</title>
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
                <li class="active ">
                    <a href="storemanagerdashboard.php"><i class="fa fa-compass"></i> Dashboard</a>
                </li>
                <li class="">
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
                <h2 class="text-center pb-3">Manage Items</h2>
                <?php
                    echo Message();
                    echo successMessage();
                ?>
                <div class="container-fluid">
                    <table id="table1" class="table table-responsive-lg table-hover table-striped col-sm-12">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Item Name</th>
                                <th scope="col">Item Id</th>
                                <th scope="col">Model</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price Per Item</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Added By</th>
                                <th scope="col">Added Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "select * from items order by itemname asc";
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
                                <td><?php echo $no;?></td>
                                <td><?php echo $itemname;?></td>
                                <td><?php echo $itemid;?></td>
                                <td><?php echo $model;?></td>
                                <td><?php echo $quantity;?></td>
                                <td><?php echo $eachprice;?></td>
                                <td><?php echo $totalprice;?></td>
                                <td><?php echo $addedby;?></td>
                                <td><?php echo $addeddate;?></td>
                            </tr>
                            <?php }?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>




<!--    modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #343a40;color: #ffffff;">
                    <h3 class="modal-title text-center" id="exampleModalLabel">Add Single Item</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="itemname">Item Name</label>
                                <input name="itemname" type="text" class="form-control" id="itemname" placeholder="Item Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="itemid">Item Id</label>
                                <input name="itemid" type="text" class="form-control" id="itemid" placeholder="Item Id">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="model">Model</label>
                                <input name="model" type="text" class="form-control" id="model" placeholder="Model">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="itemstatus">Item Status</label>
                                <input name="itemstatus" type="text" class="form-control" id="itemstatus" placeholder="Item Status">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="quantity">Quantity</label>
                                <input name="quantity" type="number" class="form-control" id="quantity" placeholder="Quantity">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="price">Price</label>
                                <input name="price" type="number" class="form-control" id="price" placeholder="Price">

                            </div>
                        </div>
                        <button name="submit" style="float: right;" type="submit" class="btn btn-primary">Add Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--end of modal-->
    <!--    modal 2-->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #343a40;color: #ffffff;">
                    <h3 class="modal-title text-center" id="exampleModalLabel">Add Multiple Item</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="table" class="table table-hover table-bordered col-sm-12">
                        <thead>
                        <tr>
                            <th scope="col">Item Name</th>
                            <th scope="col">Item Type</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button style="float: right;" type="submit" class="btn btn-success" id="add">+</button>
                    <button type="submit" class="btn btn-primary align-items-center">Add Items</button>
                </div>
            </div>
        </div>
    </div>
<!--end of modal-->
    <script src="js/jquery-3.3.1.min.js"></script>
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