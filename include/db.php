<?php 
$con = mysqli_connect('localhost','root','','storage');
if(!$con){
	die("Error while connecting to database".mysqli_error());
}

?>