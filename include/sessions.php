<?php
session_start();
function Message(){
	if(isset($_SESSION["ErrorMessage"])){
		$output="<div class='alert alert-danger alert-dismissible' role='alert'><button class='close' data-dismiss='alert' >&times;</button>".htmlentities($_SESSION["ErrorMessage"])."</div>";
		$_SESSION["ErrorMessage"] = null;

		return $output;
	}
}
function successMessage(){
	if(isset($_SESSION["successMessage"])){
		$output="<div class='alert alert-success alert-dismissible' role='alert'><button class='close' data-dismiss='alert' >&times;</button>".htmlentities($_SESSION["successMessage"])."</div>";
		$_SESSION["successMessage"] = null;
		return $output;
	}
}
?>