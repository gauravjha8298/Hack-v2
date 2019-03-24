<?php
 session_start();
 if(!isset($_SESSION["admin"]) || empty($_SESSION["admin"]))
 	header("Location:index");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Dashboard</title>
	<meta charset="utf-8">
	<meta name="language" content="English">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../assets/gbu_logo.png" type="image/gif" sizes="16x16">
	<!-- stylesheets -->
	<link rel="stylesheet" type="text/css" href="../css/admin.css">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script
</head>
<body>
		<nav class="navbar navbar-inverse" style="border-radius: 0px;background: gold;border: none;padding: 0.5em;">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>                        
		      </button>
		      <a class="navbar-brand" href="#">
		      	<div class="row">
		      		<div class="col-xs-4" style="margin-top: -15px"><img src="../assets/gbu_logo.png" height="50px"></div>
		      		<div class="col-xs-8" style="color:black"><b>HACK 1.0</b></div>
		      	</div>
		      </a>
		    </div>
		    <div class="collapse navbar-collapse" id="myNavbar">
		      <ul class="nav navbar-nav navbar-right">
		      	<li><a href="home">Home</a></li>
		        <li class="active"><a href="Leaderboard">Leaderboard</a></li>
		        <li><a href="testsettings.php">Test Settings</a></li>		        
		        <li><a href="changepassword">Change Password</a></li>
		        <li><a href="logout">Log out</a></li>
		      </ul>
		    </div>
		  </div>
		</nav>
		<div class="lb">
			<center><h3>HACK 1.0 - Leaderboard</h3> <button class="btn btn-info" style="float:right;margin-top: -40px" onclick="var ifr=document.getElementsByName('leaderboard')[0]; ifr.src=ifr.src;" >Refresh Leaderboard</button></center>
		</div>
		<div>
			<iframe src="leaderboard_table.php" name= "leaderboard" style="border:0px;overflow: auto;margin: 0px auto;width: 100%; height: 60vh"></iframe>
		</div>
<div style="z-index: 9999; position: relative;">
	<iframe scrolling="no" style="border: 0px none; overflow: auto; margin: 0px auto; width: 100%; height: 160px;" src="timer.php#timer"></iframe>
</div>
</body>
</html>