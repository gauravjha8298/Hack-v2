<?php
session_start();
include_once("functions.php");
//check if logged in
if(isset($_SESSION["id"]) && !empty($_SESSION["id"])){
	$conn = mysqli_connect("localhost","testAdmin","aA1@admin","hck") or die("cannot connect to the server!");
	if(isset($_POST["start"])){
		$sql="UPDATE participants SET cleared='0' where id='".$_SESSION["id"]."'";
		if($rs = $conn->query($sql)){
			$conn->close();
			header("Location:level1");
		}else{
			die("Cannot Proceed!".mysqli_error($conn));
		}
	}

		$sql = "select *from testinfo";
		if($rs = $conn->query($sql)){
			$row = $rs->fetch_assoc();
			$offset=5.5*60*60;
			$dateFormat="d M, Y H:i:s";
			$now = gmdate($dateFormat,time()+$offset);

			if((time()+$offset)>$row["start"] && strcmp($row["active"], "yes")==0 && $row["status"]==0) {
				$conn->close();
				$code = "<form action='' method='post'><button name='start' type='submit' class='btn btn-lg btn-success'>Start Test </button></form>";
			}else{
				$conn->close();
				$code = "<h2 style='color:green'>Test will start in a while!</h2>";
			}
		}else{
			$conn->close();
			die("Cannot load data!");
		}
}else{
		header("Location:index"); // if not logged in jump to index page
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Hack 1.0 - Instructions</title>
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
<body style="background-color: #000;">
<center><img src="assets/cover.jpg" style="width:95%;height:300px;-webkit-filter: blur(2px);filter: blur(2px); margin-top: 2%"/></center>
<center style="margin-top:20px;">
	<?php echo @$code; ?>
</center>
<div id="ack">
			<center><h5><b><i><u>Rules & Instructions</u></i></b></h5></center>
			<ul>
				<li>Each level will be of 100 marks.</li>
				<li style="color:#053">Scoing: <br>&nbsp; Solved within 5 min: 100 marks  <br>&nbsp; Solved withing 15 min. but exceeding 5 min: <i style="color:white">Marks= 100 - (Total Time taken to solve - 300)sec * 0.115</i> <br>&nbsp; Solved after 15 min: 30marks</li>
				<li>You must atleast clear 3 levels to be eligible for becoming a winner.</li>
				<li>The participant with most levels cleared within least time will be declared as winner.</li>
				<li>In case of a tie, tie-breaker round will be introduced.</li>
			</ul>
			<p><i><b>Note:</b> Read all the instructions carefully before starting the test.</i></p>	
</div>
</body>
</html>