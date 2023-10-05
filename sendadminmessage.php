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
    if(isset($_POST['send'])){
        $message = $_POST['message'];
        $recipient = $_POST['recipient'];
        $sender = $_SESSION['username'];
        $status = 'New';
        $currenttime = date("h:i:s");
        $currentdate = date("Y-m-d");
        if(empty($message) || empty($recipient)){
            $_SESSION['ErrorMessage'] = "All Fields Required";
            redirect_to('storemanagermessage.php');
        }else{
            $sql = "INSERT INTO messages(message , sender , recipient , status , currenttime , currentdate) VALUES ('$message','$sender','$recipient','$status','$currenttime','$currentdate')";
            $query = mysqli_query($con,$sql);
            if($query){
                $_SESSION['successMessage'] = "Message Sent Successfully";
                redirect_to('storemanagermessage.php');
            }else{
                $_SESSION['ErrorMessage'] = "Something Went Wrong";
                redirect_to('storemanagermessage.php');
            }

        }
    }
?>