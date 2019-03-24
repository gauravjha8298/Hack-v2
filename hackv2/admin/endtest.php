<?php
 session_start();
 if(!isset($_SESSION["admin"]) || empty($_SESSION["admin"]))
 	header("Location:index");

$conn = mysqli_connect("localhost","testAdmin","aA1@admin","hck");
$query = "UPDATE testinfo SET status=1,active='no' where id=1 ";
$rs = $conn->query($query);

if(!$rs)
	die("Error: Cannot end test");

echo "<script>window.location='timer.php'</script>";
?>