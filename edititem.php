<?php include 'include/db.php'?>
<?php include 'include/sessions.php'?>
<?php include 'include/functions.php'?>
<?php
if(!($_SESSION['role'] == 'storekeeper')){
    $_SESSION['ErrorMessage'] = "You Don't have Permission to Access This Page";
    redirect_to('index.php');
    exit();
}
?>
<?php
    if(isset($_POST['update'])){
        $eid = $_GET['eid'];
        $uitemname = $_POST['itemname'];
        $uitemid = $_POST['itemid'];
        $umodel = $_POST['model'];
        $uprice = $_POST['price'];
        $sql = "UPDATE items SET itemname = '$uitemname', itemid = '$uitemid', model = '$umodel' , price = '$uprice' WHERE id = '$eid'";
        $query = mysqli_query($con,$sql);
        if($query){
            $_SESSION['successMessage'] = "Item Successfully Updated";
            redirect_to('storekeeperdashboard.php');
        }else{
            $_SESSION['ErrorMessage'] = "Something Went Wrong";
            redirect_to('storekeeperdashboard.php');
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
    <title>Storage Management System | Edit</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
                
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa fa-sign-out"></i> LogOut</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php
if(isset($_GET['eid'])) {
    $eid = $_GET['eid'];
    $sql = "select * from items where id = '$eid'";
    $query = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($query);

    ?>
    <div id="content" class="bg-light">
        <div class="row mt-5">
            <div class="col-sm-1 col-md-2 col-lg-4"></div>
            <div class="col-sm-10 col-md-8 col-lg-4 bg-black-50">
                <h4 class="text-center mb-5" style="font-size: 4rem">Edit | <?php echo $row['itemname'];?></h4>
                <form action="edititem.php?eid=<?php echo $row['id'];?>" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="itemname">Item Name</label>
                            <input name="itemname" type="text" class="form-control" id="itemname" placeholder="Item Name" value="<?php echo $row['itemname'];?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="itemid">Item Id</label>
                            <input name="itemid" type="text" class="form-control" id="itemid" placeholder="Item Id" value="<?php echo $row['itemid'];?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="model">Model</label>
                            <input name="model" type="text" class="form-control" id="model" placeholder="Model" value="<?php echo $row['model'];?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price">Price</label>
                            <input name="price" type="number" class="form-control" id="price" placeholder="Price" value="<?php echo $row['price'];?>">

                        </div>
                    </div>
                    <button onclick="javascript:return confirm('Are You Sure You Want To Update?');" name="update" style="float: right;" type="submit" class="btn btn-primary">Update Item</button>
                </form>
            </div>
            <div class="col-sm-1 col-md-2 col-lg-4"></div>
        </div>

    </div>
    <?php
}
?>


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
