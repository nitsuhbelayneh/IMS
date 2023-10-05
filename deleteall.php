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
    if(isset($_GET['did'])){
        $did = $_GET['did'];
        $sql3 = "delete from items where id = '$did'";
        $query3 = mysqli_query($con,$sql3);
        if($query3){
            $_SESSION['successMessage'] = "Item Deleted Successfully";
            redirect_to('storekeeperdashboard.php');
        }
        else{
            $_SESSION['ErrorMessage'] = "Something Went Wrong";
            redirect_to('storekeeperdashboard.php');
        }
    }
?>