<?php include 'include/db.php'?>
<?php include 'include/sessions.php'?>
<?php include 'include/functions.php'?>

<?php
if(!($_SESSION['role'] == 'storemanager')){
    $_SESSION['ErrorMessage'] = "You Don't have Permission to Access This Page";
    redirect_to('index.php');
    exit();
}
    $addedby = $_SESSION['username'];

    if(isset($_POST["submit"])){
        $sql = 'select * from credentials';
        $query = mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($query);
        $existingusername = $row['username'];
        $username = htmlspecialchars($_POST['username']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $email = htmlspecialchars($_POST['email']);
        $valemail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $password = htmlspecialchars(md5($_POST['password']));
        $cpassword = htmlspecialchars(md5($_POST['cpassword']));
        $role = 'storemanager';
        $addeddate = date("Y-m-d");
        if(empty($username) || empty($firstname) || empty($lastname) || empty($email) || empty($email) || empty($password) || empty($cpassword)){
            $_SESSION['ErrorMessage'] = "All Fields must be Field";
            redirect_to('managestoremanagers.php');
            exit();
        }
        elseif($password != $cpassword){
            $_SESSION['ErrorMessage'] = "Passwords Doesn't Match";
            redirect_to('managestoremanagers.php');
            exit();
        }
        elseif (strlen($password) < 7 ){
            $_SESSION['ErrorMessage'] = "Passwords Length Min 6";
            redirect_to('managestoremanagers.php');
            exit();
        }
        elseif ($username == $existingusername){
            $_SESSION['ErrorMessage'] = "Username Already Exists";
            redirect_to('managestoremanagers.php');
            exit();
        }
        else{
            $sql1 = "INSERT INTO `credentials`(`username`, `firstname`, `lastname`, `email`, `password`, `role`, `addedby`, `addeddate`) VALUES ('$username','$firstname','$lastname','$email','$password','$role','$addedby','$addeddate')";
            $query1 = mysqli_query($con , $sql1);
            if ($query1){
                $_SESSION['successMessage'] = "Store Manager Successfully Registered";
                redirect_to('managestoremanagers.php');
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
    <title>Storage Management System | Manage Store Manager</title>
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
                <li>
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
                <li class="mt-2 active">
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
                <h2 class="text-center pb-3">Manage Store Managers
                    <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#exampleModal">
                        Add Store Manager
                    </button>
                </h2>
                <div class="container-fluid">
                    <?php
                        $no = 0;
                        $sql = "select * from credentials where role = 'storemanager' order by username asc";
                        $query = mysqli_query($con,$sql);

                    ?>
                    <table id="table1" class="table table-responsive-lg table-hover table-striped col-sm-12">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Username</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Added Date</th>
                                <th scope="col">Added By</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($query){
                            while($row = mysqli_fetch_assoc($query)){
                                $no++;
                        ?>
                            <tr>
                                <th scope="row"><?php echo $no;?></th>
                                <td><?php echo $row['username'];?></td>
                                <td><?php echo $row['firstname'];?></td>
                                <td><?php echo $row['lastname'];?></td>
                                <td><?php echo $row['email'];?></td>
                                <td><?php echo $row['addeddate'];?></td>
                                <td><?php echo $row['addedby'];?></td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a class="btn btn-primary" href="editstoremanager.php?eid=<?php echo $row['id'];?>">Edit</a>
                                        <a onclick="javascript:return confirm('Are You Sure You Want To Delete?');" class="btn btn-danger" href="managestoremanagers.php?did=<?php echo $row['id'];?>" role="button">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            }
                        }
                        if(isset($_GET['did'])){
                            $did = $_GET['did'];
                            $sql = "DELETE FROM `credentials` WHERE id = '$did'";
                            $query = mysqli_query($con,$sql);
                            if($query){
                                $_SESSION['successMessage'] = "Store Manager Successfully deleted";
                                echo "
                                <script>
                                    location.href='managestoremanagers.php';
                                </script>";
                            }
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
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #343a40;color: #ffffff;">
                    <h3 class="modal-title text-center" id="exampleModalLabel">Add Store Manager</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="" action="managestoremanagers.php" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="username">Username</label>
                                <input name="username" type="text" class="form-control" id="username" placeholder="Username">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="firstname">First Name</label>
                                <input name="firstname" type="text" class="form-control" id="firstname" placeholder="First Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lastname">Last Name</label>
                                <input name="lastname" type="text" class="form-control" id="lastname" placeholder="Last Name">

                            </div>
                            <div class="form-group col-md-12">
                                <label for="email">Email</label>
                                <input name="email" type="email" class="form-control" id="email" placeholder="Email">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input name="password" type="password" class="form-control" id="password" placeholder="Password">

                            </div>
                            <div class="form-group col-md-6">
                                <label for="cpassword">Comfirm Password</label>
                                <input name="cpassword" type="password" class="form-control" id="cpassword" placeholder="Comfirm Password">

                            </div>
                        </div>
                        <button name="submit" style="float: right;" type="submit" class="btn btn-primary mt-4">Add Store Manager</button>
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
    <script src="https://cdn.rawgit.com/PascaleBeier/bootstrap-validate/v2.1.3/dist/bootstrap-validate.js" ></script>
    <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {

                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').toggleClass('active');
                    $(this).toggleClass('active');
                });
                $('#table1').DataTable();

            });
            bootstrapValidate('#email','email:Enter a Valid Email Address')

        </script>

</body>
</html>