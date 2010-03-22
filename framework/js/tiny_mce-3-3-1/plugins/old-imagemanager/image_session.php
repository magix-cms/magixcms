<?php 
session_start();
if(isset($_SESSION['useradmin'])){
	$_SESSION['isLoggedIn'] = true;
	$return = isset($_REQUEST['return_url']) ? htmlentities($_REQUEST['return_url']) : "";
	header("location: " . $return);
}
?>