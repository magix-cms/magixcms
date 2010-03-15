<?php 
if(isset($_SESSION['useradmin'])){
	session_start();
	$_SESSION['isLoggedIn'] = true;
	header("location: " . $_REQUEST['return_url']);
}
?>