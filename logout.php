<?php include 'include/db.php'?>
<?php include 'include/sessions.php'?>
<?php include 'include/functions.php'?>
<?php
    session_destroy();
    redirect_to('index.php');

?>