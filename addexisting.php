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
    if(isset($_POST['submitexisting'])){
        $itemname = $_POST['item'];
        $newquntity = $_POST['addquantity'];
        if(empty($newquntity)){
            $_SESSION['ErrorMessage'] = "Enter the Quantity First";
            redirect_to('storekeeperdashboard.php');
        }
        else {
            $sql = "select * from items where itemname = '$itemname'";
            $query = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($query);
            $existingquantity = $row['quantity'];
            $totalquantity = $newquntity + $existingquantity;
            $sql1 = "UPDATE items SET quantity = '$totalquantity' WHERE itemname = '$itemname'";
            $query1 = mysqli_query($con, $sql1);
            if($query1){
                $_SESSION['successMessage'] = "Quantity Added";
                redirect_to('storekeeperdashboard.php');
            }else{
                $_SESSION['ErrorMessage'] = "Something Went Wrong";
                redirect_to('storekeeperdashboard.php');
            }
        }
    }
?>