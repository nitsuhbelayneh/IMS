<?php include 'include/db.php'?>
<?php include 'include/sessions.php'?>
<?php include 'include/functions.php'?>

<?php
    if(isset($_SESSION['role']) == 'storekeeper'){
        redirect_to('storekeeperdashboard.php');
        exit();
    }
    if(isset($_SESSION['role']) == 'storemanager'){
        redirect_to('storemanagerdashboard.php');
        exit();
    }
    if(isset($_SESSION['role']) == 'user'){
        redirect_to('userdashboard.php');
        exit();
    }
    if(isset($_POST['submit'])){
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars(md5($_POST['password']));
        if(empty($username) || empty($password)){
            $_SESSION['ErrorMessage'] = "All Fields Must be Field";
            redirect_to('index.php');
            exit();
        }
        else{
            $sql = "select * from credentials where username = '$username' and password = '$password'";
            $query = mysqli_query($con,$sql);
            $row = mysqli_fetch_assoc($query);
            $_SESSION['username'] = $row['username'];
            $loguser = $_SESSION['username'];
            $_SESSION['role'] = $row['role'];
            $role = $_SESSION['role'];
            if($query){
                if($role == 'storemanager'){
                    $_SESSION['successMessage'] = "Welcome ".ucfirst($loguser);
                    redirect_to('storemanagerdashboard.php');
                    exit();
                }
                elseif($role == 'storekeeper'){
                     $_SESSION['successMessage'] = "Welcome ".ucfirst($loguser);
                    redirect_to('storekeeperdashboard.php');
                    exit();
                }
                elseif($role == 'user'){
                     $_SESSION['successMessage'] = "Welcome ".ucfirst($loguser);
                    redirect_to('userdashboard.php');
                    exit();
                }
                else{
                    $_SESSION['ErrorMessage'] = "Invalid Credentials";
                    redirect_to('index.php');
                    exit();
                }

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
    <link rel="stylesheet" href="css/tselot.css">
    <title>Storage Management System | LogIn</title>
</head>
<body>
    <div class="wrapper" style="height:100vh;">
        <div id="content" class="bg-light">
            <div class="row mt-5">
                <div class="col-sm-1 col-md-2 col-lg-4"></div>
                <div class="col-sm-10 col-md-8 col-lg-4 bg-black-50">
                    <?php
                        echo Message();
                        echo successMessage();
                    ?>
                    <h1 class="text-center mb-5" style="font-size: 5rem">LogIn</h1>
                    <form action="index.php" method="post">
                        <div class="form-row">
                            <div class="input-group mb-3 input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                </div>

                                <input name="username" type="text" class="form-control" id="username" placeholder="Username">
                            </div>
                            <div class="input-group mb-3 input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-unlock"></i></span>
                                </div>
                                <input name="password" type="password" class="form-control" id="password" placeholder="Password">
                            </div>
                        </div>
                        <button name="submit"  type="submit" class="btn btn-primary btn-block mt-2 btn-lg mb-4">LogIn</button>
                    </form>
                </div>
                <div class="col-sm-1 col-md-2 col-lg-4"></div>
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
                                <input type="text" class="form-control" id="itemname" placeholder="Item Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="itemtype">Item Type</label>
                                <input type="text" class="form-control" id="itemtype" placeholder="Item Type">

                            </div>
                        </div>
                        <button style="float: right;" type="submit" class="btn btn-primary">Add Item</button>
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
    <script src="js/popper.min.js"></script>
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
            });
        </script>

</body>
</html>