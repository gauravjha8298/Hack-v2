<?php
session_start();
if(isset($_SESSION["id"]) && !empty($_SESSION["id"]) && isset($_SESSION["score"]) && !empty($_SESSION["score"])){
	unset($_SESSION["id"]);
	unset($_SESSION["name"]);
	unset($_SESSION["roll"]);
	unset($_SESSION["score"]);
	session_destroy();
	header("Location:index.php");
}
session_destroy();
header("Location:index.php");
?>