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
        $sql = "select * from requests where id = '$cid'";
        $query = mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($query);
        $requestedquantity = $row['quantity'];
        $itemname = $row['itemname'];
        $sql1 = "select * from items where itemname = '$itemname'";
        $query1 = mysqli_query($con,$sql1);
        $row1 = mysqli_fetch_assoc($query1);
        $existingquantity = $row1['quantity'];
        $totalquantity = $existingquantity + $requestedquantity;
        $sqli = "update items set quantity = '$totalquantity' where itemname = '$itemname'";
        $queryi = mysqli_query($con,$sqli);
        $sql2 = "delete from requests where id = '$cid'";
        $query2 = mysqli_query($con,$sql2);
        if($query2){
            $_SESSION['successMessage'] = "Request Cancelled Successfully";
            redirect_to('requesteditem.php');
        }
        else{
            $_SESSION['ErrorMessage'] = "Something Went Wrong";
            redirect_to('requesteditem.php');
        }
    }
?>