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
    if(isset($_GET['cid'])){
        $cid = $_GET['cid'];
        $requeststatus = 'Cleared';
        $sql = "update requests set requeststatus = '$requeststatus' where id = '$cid'";
        $query = mysqli_query($con,$sql);
        if($query){
            $_SESSION['successMessage'] = "Item Cleared Successfully";
            redirect_to('requesteditem.php');
        }
        else{
            $_SESSION['ErrorMessage'] = "Something Went Wrong";
            redirect_to('requesteditem.php');
        }
    }
?>