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
    if(isset($_POST['delete'])){
        $diid = $_GET['diid'];
        $quant = $_POST['quant'];
        $sql = "select * from items where id = '$diid'";
        $query = mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($query);
        $itemname = $row['itemname'];
        $existingquantity = $row['quantity'];
        $remaningquantity = $existingquantity - $quant;
        $sql1 = "UPDATE items SET quantity = '$remaningquantity' WHERE id = '$diid'";
        $query1 = mysqli_query($con,$sql1);
        if ($query1){
            $_SESSION['successMessage'] = $quant." Item Successfully Deleted From ".$itemname;
            redirect_to('storekeeperdashboard.php');
        }else{
            $_SESSION['ErrorMessage'] = "Something Went Wrong";
            redirect_to('storekeeperdashboard.php');
        }
    }
?>