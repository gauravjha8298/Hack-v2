<?php
function submissionAllowed(){
	$conn = mysqli_connect("localhost","testUser","aA1@testuser","hck") or die("Something wrong with the database!");
	$sql = "select * from testinfo where id=1";
	$rs = $conn->query($sql);

	if(!$rs){
		$conn->close();
		die("Some Unknown Error Occured!");
	}
	else{
		$row=$rs->fetch_assoc();
		$conn->close();
		$offset=5.5*60*60;
		$time_now = time()+$offset;
		if($row["status"]==0 && strcmp($row["active"], "yes")==0)
			return true;
		else
			return false;
	}
}
session_start();
$msg="Thanks for taking the Test!";
if(!submissionAllowed())
		$msg = "Either Time's up or the Test has been ended!";

if(isset($_SESSION["id"]) && !empty($_SESSION["id"])){
	$conn=mysqli_connect("localhost","testUser","aA1@testuser","hck") or die("Problem with server!");
	$sql = "select score,cleared from participants where id='".$_SESSION["id"]."'";
	$rs = $conn->query($sql);
	$row=$rs->fetch_assoc();
	$conn->close();
}else
	header("Location:index.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Thanks For Taking This Test</title>
	<meta charset="utf-8">
	<meta name="language" content="English">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="assets/gbu_logo.png" type="image/gif" sizes="16x16">
	<!-- stylesheets -->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap/bootstrap.min.css">
	<!-- JavaScripts -->
	<script type="text/javascript" src="js/bootstrap/bootstrap.min.js"></script>
</head>
<body>
	<center><?php echo @$msg; ?></center>
	<center><h2>Your Score: <?php echo @$row["score"]; ?></h2></center>
	<center><h4> 
	<?php 
		if(end(str_split($row["cleared"]))>=7)
			echo "Congratulations! You have cleared all the ";
		else
			echo "Hard Luck Noobie! You have cleared only ".end(str_split($row["cleared"]));
	?> Levels!</h4></center>
	<center><a href="admin/leaderboard_table" target="_blank"><button class="btn btn-success">Leaderboard</button></a> &nbsp; &nbsp; &nbsp; <a href="logout"><button class="btn btn-info">Log out</button></button></a></center>
</body>
</html>
<?php
@$conn->close();
?>