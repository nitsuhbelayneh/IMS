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
    <link rel="stylesheet" href="css/simplePagination.css">
    <link rel="stylesheet" href="css/tselot.css">
    <title>Storage Management System | User Message</title>
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
                <li class="">
                    <a href="requesteditem.php"><i class="fa fa-registered"></i> Requested Items</a>
                </li>
                <li class="mt-2 active">
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
                <h2 class="text-center pb-3">Messages
                </h2>
                <?php
                echo Message();
                echo successMessage();
                ?>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Compose Message</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Inbox <span style="float: right;" class="badge badge-pill badge-success mt-1 "><?php
                                $username = $_SESSION['username'];
                                $sql = "select * from messages where status = 'New' and recipient = '$username'";
                                $query = mysqli_query($con,$sql);
                                $count = mysqli_num_rows($query);
                                echo $count;

                                ?></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Sent Messages</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row mt-5">
                            <div class="col-sm-1 col-md-2 col-lg-4"></div>
                            <div class="col-sm-10 col-md-8 col-lg-4 bg-black-50">
                                <form action="sendusermessage.php" method="post">
                                    <div class="form-group">
                                        <label for="recipient">To</label>
                                        <select name="recipient" class="form-control" id="recipient">
                                            <?php $sql1 = "select * from credentials";
                                            $query1 = mysqli_query($con,$sql1);
                                            ?>
                                            <option disabled selected value="">Choose Recipient</option>
                                            <?php
                                            while($row1 = mysqli_fetch_assoc($query1)){
                                                $username= ucfirst($row1['username']);
                                                $role= $row1['role'];
                                                if($row1['username'] == $_SESSION['username'])
                                                    continue

                                                ?>
                                                <option value="<?php echo $username;?>"><?php echo $username.'-'.$role;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="message">Message</label>
                                        <textarea name="message" class="form-control" id="message" rows="3"></textarea>
                                    </div>
                                    <button name="send"  type="submit" class="btn btn-primary btn-block mt-2 btn-lg mb-4">Send Message</button>
                                </form>
                            </div>
                            <div class="col-sm-1 col-md-2 col-lg-4"></div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row mt-5">
                            <div class="col-sm-1 col-md-2 col-lg-4"></div>
                            <div class="col-sm-10 col-md-8 col-lg-4 bg-black-50">
                                <?php
                                    $username = $_SESSION['username'];
                                    $sql = "select * from messages where recipient = '$username' order by status , id desc";
                                    $query = mysqli_query($con,$sql);
                                    while($row = mysqli_fetch_assoc($query)){

                                        $id = $row['id'];
                                        $from = ucfirst($row['sender']);
                                        $message = $row['message'];
                                        $time = $row['currenttime'];
                                        $date = $row['currentdate'];
                                        $status = $row['status'];
                                        $sender = $row['sender'];
                                        $to = $row['recipient'];
                                        if($status == 'clear')
                                            continue;
                                    ?>
                                        <?php if($status == 'New'){?>
                                            <h3 class="font-weight-bold">From : <?php echo $from;?></h3>
                                            <i class="font-weight-bold">On <?php echo $date;?> At <?php echo $time;?></i>
                                            <p class="font-weight-bold lead"><?php echo $message;?>
                                                <a  href="usermessage.php?mid=<?php echo $id?>" class="badge badge-primary pull-right">Mark as read</a>
                                                <a onclick="javascript:return confirm('Are You Sure You Want To Clear?');" href="usermessage.php?cid=<?php echo $id?>" class="badge badge-danger pull-right">Clear</a>
                                            </p>
                                            <hr>
                                        <?php }else{
                                            ?>
                                            <h3>From : <?php echo $from;?></h3>
                                            <i>On <?php echo $date;?> At <?php echo $time;?></i>
                                            <p><?php echo $message;?>
                                                <a onclick="javascript:return confirm('Are You Sure You Want To Clear?');" href="usermessage.php?cid=<?php echo $id?>" class="badge badge-danger pull-right">Clear</a>
                                            </p>
                                            <hr>
                                        <?php }?>
                                    <?php }
                                ?>

                            </div>
                            <div class="col-sm-1 col-md-2 col-lg-4"></div>
                        </div>
                        <?php
                            if(isset($_GET['mid'])){
                                $mid = $_GET['mid'];
                                $sql = "update messages set status = 'Read' where id = '$mid'";
                                $query = mysqli_query($con,$sql);
                                if($query){
                                    $_SESSION['successMessage'] = "Message Marked As Read";
                                    echo "
                                    <script type='text/javascript'>window.location='usermessage.php'</script>                                    
                                    ";
                                }else{
                                    $_SESSION['ErrorMessage'] = "Something Went Wrong";
                                    echo "
                                    <script type='text/javascript'>window.location='usermessage.php'</script>                                    
                                    ";
                                }
                                exit();
                            }
                            if (isset($_GET['cid'])){
                                $cid = $_GET['cid'];
                                $sql = "update messages set status = 'clear' where id = '$cid'";
                                $query = mysqli_query($con,$sql);
                                if($query){
                                    $_SESSION['successMessage'] = "Message Cleared";
                                    echo "
                                    <script type='text/javascript'>window.location='usermessage.php'</script>                                    
                                    ";
                                }else{
                                    $_SESSION['ErrorMessage'] = "Something Went Wrong";
                                    echo "
                                    <script type='text/javascript'>window.location='usermessage.php'</script>                                    
                                    ";
                                }
                            }

                        ?>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="row mt-5">
                        <div class="col-sm-1 col-md-2 col-lg-4"></div>
                        <div class="col-sm-10 col-md-8 col-lg-4 bg-black-50">
                            <?php
                            $username = $_SESSION['username'];
                            $sql = "select * from messages where sender = '$username' order by id desc";
                            $query = mysqli_query($con,$sql);
                            $num = mysqli_num_rows($query);
                            while($row = mysqli_fetch_assoc($query)){
                                $id = $row['id'];
                                $from = ucfirst($row['sender']);
                                $message = $row['message'];
                                $time = $row['currenttime'];
                                $date = $row['currentdate'];
                                $status = $row['status'];
                                $sender = $row['sender'];
                                $to = $row['recipient'];
//                                if($status == 'clear')
//                                    continue;
                                ?>
                                <h3>To : <?php echo $to;?></h3>
                                <i>On <?php echo $date;?> At <?php echo $time;?></i>
                                <p><?php echo $message;?>
                                </p>
                                <hr>
                                <?php }?>
                            <div class="sent"></div>
                        </div>
                        <div class="col-sm-1 col-md-2 col-lg-4"></div>
                    </div>

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
                $('#table1').DataTable();
                $('#demo').pagination({
                    dataSource: [1, 2, 3, 4, 5, 6, 7, ... , 35],
                pageSize: 5,
                    pageNumber: 3,
                    callback: function(data, pagination) {
                    // template method of yourself
                    var html = template(data);
                    dataContainer.html(html);
                }
            })
            });
        </script>
        <script type="text/javascript">

        </script>

</body>
</html>