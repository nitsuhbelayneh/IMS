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
    if(isset($_GET['rid'])){
        $rid = $_GET['rid'];
        $sql = "select * from requests where id ='$rid'";
        $query = mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($query);
        $itemname = $row['itemname'];
        $requestquantity = $row['quantity'];
        $sql1 = "select * from items where itemname = '$itemname'";
        $query1 = mysqli_query($con,$sql1);
        $row1 = mysqli_fetch_assoc($query1);
        $existingquantity = $row1['quantity'];
        $requeststatus = 'Returned';
        $totalquantity = $existingquantity + $requestquantity;
        $sql2 = "update items set quantity = '$totalquantity' where itemname = '$itemname'";
        $query2 = mysqli_query($con,$sql2);
        $sql3 = "update requests set requeststatus = '$requeststatus' where id = '$rid'";
        $query3 = mysqli_query($con,$sql3);
        if($query3){
            $_SESSION['successMessage'] = "Item Returned Successfully";
            redirect_to('viewrequests.php');
        }
        else{
            $_SESSION['ErrorMessage'] = "Something Went Wrong";
            redirect_to('viewrequests.php');
        }

    }
?>