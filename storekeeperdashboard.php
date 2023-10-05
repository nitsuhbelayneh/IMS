    <?php include 'include/db.php'?>
    <?php include 'include/sessions.php'?>
    <?php include 'include/functions.php'?>
<?php
if(!($_SESSION['role'] == 'storekeeper')){
    $_SESSION['ErrorMessage'] = "You Don't have Permission to Access This Page";
    redirect_to('index.php');
    exit();
}
if(isset($_POST['submit'])){
    $itemname = $_POST['itemname'];
    $itemid = $_POST['itemid'];
    $model = $_POST['model'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $addedby = $_SESSION['username'];
    $addeddate = date("Y-m-d");
    $sql2 = "select * from items";
    $query2 = mysqli_query($con,$sql2);
    $row2 = mysqli_fetch_assoc($query2);
    $existingitemname = $row2['itemname'];
    $existingmodel = $row2['model'];
    $existingitemid = $row2['itemid'];
    if(empty($itemname) || empty($itemid) || empty($model) || empty($quantity) || empty($price)){
        $_SESSION['ErrorMessage'] = "All Fields Required";
        redirect_to('storekeeperdashboard.php');
    }
    elseif ($quantity <= 0){
        $_SESSION['ErrorMessage'] = "Quantity Min Is 1";
        redirect_to('storekeeperdashboard.php');
    }
    elseif ($itemname == $existingitemname || $itemid == $existingitemid){
        $_SESSION['ErrorMessage'] = "Item Already Exist use Add Existing Item";
        redirect_to('storekeeperdashboard.php');
    }
    else{
        $sql = "INSERT INTO items (itemname, itemid, model, quantity, price , addedby, addeddate) VALUES ('$itemname','$itemid','$model','$quantity','$price','$addedby','$addeddate')";
        $query = mysqli_query($con,$sql);
        if($query){
          $_SESSION['successMessage'] = "Item Successfully Added";
          redirect_to('storekeeperdashboard.php');
        }

        else{
            $_SESSION['ErrorMessage'] = "Something Went Wrong";
            redirect_to('storekeeperdashboard.php');
        }
    }
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
    <title>Storage Management System | Store Keeper Dashboard</title>
</head>
<body>
    <div class="wrapper" style="height:auto;">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Store Keeper</h3>
            </div>

            <ul class="list-unstyled components">
                <p class="text-center" style="font-weight: bold; font-size:20px !important;"><?php echo $_SESSION['username'];?></p>
                <li class="active ">
                    <a href="storekeeperdashboard.php"><i class="fa fa-compass"></i> Dashboard</a>
                </li>
                <li class="">
                    <a href="viewrequests.php"><i class="fa fa-registered"></i> View Requests <span style="float: right;" class="badge badge-pill badge-warning mt-1 ">
                            <?php
                            $sql = "select * from requests where requeststatus = 'Approved'";
                            $query = mysqli_query($con,$sql);
                            $count = mysqli_num_rows($query);
                            echo $count;

                            ?>
                        </span></a>
                </li>
                <li class="mt-2">
                    <a href="storekeepermessage.php"><i class="fa fa-envelope"></i>  Messages<span style="float: right;" class="badge badge-pill badge-success mt-1 "><?php
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
                <h2 class="text-center pb-3">Manage Items
                    <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#exampleModal2">
                        Add Existing Item
                    </button>
                    <button type="button" class="btn btn-primary mr-2" style="float: right;" data-toggle="modal" data-target="#exampleModal">
                        Add New Item
                    </button>

                </h2>
                <?php
                    echo Message();
                    echo successMessage();
                ?>
                <div class="container-fluid">
                    <table id="table" class="table table-hover table-striped table-responsive-lg col-sm-12">
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
                            <th scope="col">Edit</th>
                            <th scope="col">Delete Item</th>
                            <th scope="col">Delete All</th>
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
                                <th scope="row"><?php echo $no;?></th>
                                <td><?php echo $itemname;?></td>
                                <td><?php echo $itemid;?></td>
                                <td><?php echo $model;?></td>
                                <td><?php echo $quantity;?></td>
                                <td><?php echo $eachprice;?></td>
                                <td><?php echo $totalprice;?></td>
                                <td><?php echo $addedby;?></td>
                                <td><?php echo $addeddate;?></td>
                                <td><a href="edititem.php?eid=<?php echo $id;?>" class="btn btn-primary">Edit</a></td>
                                <td>
                                    <div class="input-group">
                                        <form method="post" action="deleteitem.php?diid=<?php echo $id;?>">
                                            <select style="float: left; width:82%;" name="quant" class="form-control quant">
                                                <option selected disabled value="">Choose Quantity</option>
                                                <?php for ($i=1;$i<=$quantity;$i++){?>
                                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                <?php }?>
                                            </select>
                                            <div class="input-group-append">
                                                <button onclick="javascript:return confirm('Are You Sure You Want To Delete Items?');" name="delete" class="btn delete btn-danger">X</button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                                <td>
                                    <a onclick="javascript:return confirm('Are You Sure You Want To Delete All Items?');" href="deleteall.php?did=<?php echo $id?>" data-id = "<?php echo $id;?>" class="btn deleteall btn-danger">Delete all</a>
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
                    <form action="storekeeperdashboard.php" method="post">
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
                                <label for="quantity">Quantity</label>
                                <input name="quantity" type="number" class="form-control" id="quantity" placeholder="Quantity">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="price">Price</label>
                                <input name="price" type="number" class="form-control" id="price" placeholder="Price">

                            </div>
                        </div>
                        <button onclick="javascript:return confirm('Are You Sure You Want To Add Item?');" name="submit" style="float: right;" type="submit" class="btn btn-primary">Add Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--end of modal-->
    <!--    modal 2-->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #343a40;color: #ffffff;">
                    <h3 class="modal-title text-center" id="exampleModalLabel">Add Multiple Item</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="addexisting.php" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="quantity">Select Existing Item</label>
                                <select name="item" required class="form-control">
                                    <?php $sql1 = "select * from items";
                                    $query1 = mysqli_query($con,$sql1);
                                    ?>
                                    <option value="">Choose Existing Item</option>
                                    <?php
                                    while($row1 = mysqli_fetch_assoc($query1)){
                                        $item = $row1['itemname'];
                                        $mod = $row1['model'];
                                        ?>
                                        <option value="<?php echo $item;?>"><?php echo $item.'-'.$mod;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="quantity">Quantity</label>
                                <input name="addquantity" type="number" class="form-control" id="quantity" placeholder="Quantity">
                            </div>
                        </div>
                        <button onclick="javascript:return confirm('Are You Sure You Want To Add Item?');" name="submitexisting" style="float: right;" type="submit" class="btn btn-primary">Add Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--end of modal-->
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
                // $(document).on('click','.delete',function () {
                //     var id = $(this).data('id');
                //     var quant = $(".quant").val();
                //
                //     alert(quant);
                // });
                $('#table').DataTable();
            });
        </script>

</body>
</html>