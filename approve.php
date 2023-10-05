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
<?php
    if(isset($_GET['aid'])){
        $aid = $_GET['aid'];
        $requeststatus = 'Approved';
        $approvedby = $_SESSION['username'];
        $sql = "update requests set requeststatus = '$requeststatus',approvedby = '$approvedby' where id = '$aid'";
        $query = mysqli_query($con,$sql);
        if($query){
            $_SESSION['successMessage'] = "Request Approved Successfully";
            redirect_to('managerequests.php');
        }else{
            $_SESSION['ErrorMessage'] = "Something Went Wrong";
            redirect_to('managerequests.php');
        }
    }
?>