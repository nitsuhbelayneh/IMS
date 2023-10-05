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
    if(isset($_GET['did'])){
        $did = $_GET['did'];
        $sql = "select * from requests where id = '$did'";
        $query = mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($query);
        $itemname = $row['itemname'];
        $requestedquantity = $row['quantity'];
        $sql1 = "select * from items where itemname = '$itemname'";
        $query1 = mysqli_query($con,$sql1);
        $row1 = mysqli_fetch_assoc($query1);
        $existingquantity = $row1['quantity'];
        $totalquantity = $existingquantity + $requestedquantity;
        $sql2 = "UPDATE items SET quantity = '$totalquantity' WHERE itemname = '$itemname'";
        $query2 = mysqli_query($con,$sql2);
        $sql3 = "delete from requests where id = $did";
        $query3 = mysqli_query($con,$sql3);
        if ($query3){
            $_SESSION['successMessage'] = "Request Deleted Successfully!";
            redirect_to('managerequests.php');
        }else{
            $_SESSION['ErrorMessage'] = "Something Went Wrong";
            redirect_to('managerequests.php');
        }
    }
?>