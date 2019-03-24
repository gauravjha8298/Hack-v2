<?php
session_start();
 if(!isset($_SESSION["admin"]) || empty($_SESSION["admin"]))
 	header("Location:index");

$conn = mysqli_connect("localhost","testAdmin","aA1@admin","hck");
 		$query = "update testinfo set status=0 ,active='yes' where id=1";
 		$rs= $conn->query($query);
 		if(!$rs){
 			$msg = "cannot Start Test!";
 		}else{
 			echo "<script>
 					window.location='timer.php';
 					</script>";
 		}
echo "<center><h3>".$msg."</h3></center>";
?>