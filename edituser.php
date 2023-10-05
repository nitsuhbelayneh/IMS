<?php include 'include/db.php'?>
<?php include 'include/sessions.php'?>
<?php include 'include/functions.php'?>
<?php
if(!($_SESSION['username'])){
    $_SESSION['ErrorMessage'] = "You Don't have Permission to Access This Page";
    redirect_to('index.php');
    exit();
}
if(isset($_POST['update'])){
    $sql = 'select * from credentials';
    $query = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($query);
    $existingusername = $row['username'];
    $username = htmlspecialchars($_POST['username']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $eid = $_GET['eid'];
    if(empty($username) || empty($firstname) || empty($lastname) || empty($email)){
        $_SESSION['ErrorMessage'] = "All Fields must be Field";
        redirect_to('manageusers.php');
        exit();
    }
    elseif ($username == $existingusername){
        $_SESSION['ErrorMessage'] = "Username Already Exists";
        redirect_to('manageusers.php');
        exit();
    }
    else{
        $sql = "UPDATE `credentials` SET `username`='$username',`firstname`='$firstname',`lastname`='$lastname',`email`='$email' WHERE id = '$eid'";
        $query = mysqli_query($con , $sql);
        if($query){
            $_SESSION['successMessage'] = "Update Successful";
            redirect_to('manageusers.php');
            exit();
        }else{
            $_SESSION['ErrorMessage'] = "Something Went Wrong";
            redirect_to('manageusers.php');
            exit();
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
            $sql = "select * from credentials where id = '$eid'";
            $query = mysqli_query($con,$sql);
            $row = mysqli_fetch_assoc($query);

            ?>
            <div id="content" class="bg-light">
                <div class="row mt-5">
                    <div class="col-sm-1 col-md-2 col-lg-4"></div>
                    <div class="col-sm-10 col-md-8 col-lg-4 bg-black-50">
                        <h4 class="text-center mb-5" style="font-size: 4rem">Edit | <?php echo $row['username'];?></h4>
                        <form class="" action="edituser.php?eid=<?php echo $row['id'];?>" method="post">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="username">Username</label>
                                    <input name="username" type="text" class="form-control" id="username"
                                           placeholder="Username" value="<?php echo $row['username'];?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="firstname">First Name</label>
                                    <input name="firstname" type="text" class="form-control" id="firstname"
                                           placeholder="First Name" value="<?php echo $row['firstname'];?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lastname">Last Name</label>
                                    <input name="lastname" type="text" class="form-control" id="lastname"
                                           placeholder="Last Name" value="<?php echo $row['lastname'];?>">

                                </div>
                                <div class="form-group col-md-12">
                                    <label for="email">Email</label>
                                    <input name="email" type="email" class="form-control" id="email"
                                           placeholder="Email"
                                           value="<?php echo $row['email'];?>">
                                </div>
                            </div>
                            <button onclick="javascript:return confirm('Are You Sure You Want To Update?');" name="update" style="float: right;" type="submit" class="btn btn-primary mt-4">
                                Update User
                            </button>
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