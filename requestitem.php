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
    if(isset($_POST['request'])){
        $rid = $_GET['rid'];
        $quant = $_POST['quantity'];
        $sql = "select * from items where id = '$rid'";
        $query = mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($query);
        $itemname = $row['itemname'];
        $itemid = $row['itemid'];
        $existingquantity = $row['quantity'];
        $price = $row['price'] * $quant;
        $model = $row['model'];
        $remainingquantity = $existingquantity - $quant;
        $requestedby = $_SESSION['username'];
        $requeststatus = 'Pending';
        $requestdate = date("Y-m-d");
        if($quant > $existingquantity){
            $_SESSION['ErrorMessage'] = "Requesting More Than It Exist";
            redirect_to('userdashboard.php');
            exit();
        }
        elseif(empty($quant)){
            $_SESSION['ErrorMessage'] = "Quantity Required Before Request";
            redirect_to('userdashboard.php');
            exit();
        }else{
            $sqli = "update items set quantity = '$remainingquantity' where id = '$rid'";
            $queryi = mysqli_query($con,$sqli);
            $sql1 = "INSERT INTO requests(itemname, itemid, price, model, quantity, requestedby, requeststatus, requestdate) VALUES ('$itemname','$itemid','$price','$model','$quant','$requestedby','$requeststatus','$requestdate')";
            $query1 = mysqli_query($con,$sql1);
            if($query1){
                $_SESSION['successMessage'] = "Item Requested Successfully";
                redirect_to('userdashboard.php');
            }else{
                $_SESSION['ErrorMessage'] = "Something Went Wrong";
                redirect_to('userdashboard.php');
            }
        }

    }
?>