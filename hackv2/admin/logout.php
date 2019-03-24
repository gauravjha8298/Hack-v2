<?php
session_start();
if(isset($_SESSION["admin"]) && !empty($_SESSION["admin"])){
	unset($_SESSION["admin"]);
	unset($_SESSION["name"]);
	session_destroy();
	header("Location:index");
}
session_destroy();
header("Location:index");
?>