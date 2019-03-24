<?php
session_start();
if(!isset($_SESSION['admin']) || empty($_SESSION["admin"])){
	header("Location:index");
}
$dateFormat="d-m-Y H:i:s";
if(isset($_POST["save"]) && !empty($_POST["save"])){
	//get the values
	$date = explode("-",$_POST["startDate"]);
	$startDateTime= gmmktime($_POST["startHour"],$_POST["startMin"],$_POST["startSec"],$date[1],$date[2],$date[0]);

	$date = explode("-",$_POST["endDate"]);
	$endDateTime = gmmktime($_POST["endHour"],$_POST["endMin"],$_POST["endSec"],$date[1],$date[2],$date[0]);

	if($endDateTime<$startDateTime){
		$msg = "<p style='color:red'>Start time cannot be  after end time!</p>";
	}else if($endDateTime==$startDateTime){
		$msg = "<p style='color:red'>Start time and end time cannot be same!</p>";
	}else{
		$conn = mysqli_connect("localhost","testAdmin","aA1@admin","hck") or die("could not connect to the database");
		$sql = "UPDATE testinfo SET status=1,start='".$startDateTime."',end='".$endDateTime."',active='yes' WHERE id='1'";
		$rs= $conn->query($sql);
		if(!$rs)
			$msg="<p style='color:red'>Unkown Server Error!</p>";
		else{
			$msg="<p style='color:green'>Test Details Updated!</p>";
			$sql = "UPDATE participants SET last_submission ='".$startDateTime."'"; //set initial default reference last_submission
			$rs= $conn->query($sql);
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin - Test Settings</title>
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
	        <li><a href="Leaderboard">Leaderboard</a></li>
	        <li class="active"><a href="testsettings.php">Test Settings</a></li>
	        <li><a href="changepassword">Change Password</a></li>
	        <li><a href="logout">Log out</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<center>
				<form action="" method="post" class="passBox">
					<center><h3 class="boxlabel">Timmings</h3></center>
					<label for="startDate" style="margin-top:20px">Test starts at (IST): </label>
					<input type="date" name="startDate" id="startDate" required/>
					<select name="startHour">
					<?php
						for($var=0;$var<24;$var++){
							
							if($var<10)
								echo "<option value='0".$var."'>0".$var;
							else
								echo "<option value='".$var."'>".$var;

							echo "</option>";
						}
					?>
					</select>
					<select name="startMin">
					<?php
						for($var=0;$var<60;$var++){
							if($var<10)
								echo "<option value='0".$var."'>0".$var;
							else
								echo "<option value='".$var."'>".$var;

							echo "</option>";
						}
					?>
					</select>
					<select name="startSec">
					<?php
						for($var=0;$var<60;$var++){
							if($var<10)
								echo "<option value='0".$var."'>0".$var;
							else
								echo "<option value='".$var."'>".$var;

							echo "</option>";
						}
					?>
					</select><br>


					<label for="endDate" style="margin-top:10px">Test ends at (IST): </label>
					<input type="date" name="endDate" id="endDate" required/>
					<select name="endHour">
					<?php
						for($var=0;$var<24;$var++){
							
							if($var<10)
								echo "<option value='0".$var."'>0".$var;
							else
								echo "<option value='".$var."'>".$var;

							echo "</option>";
						}
					?>
					</select>
					<select name="endMin">
					<?php
						for($var=0;$var<60;$var++){
							if($var<10)
								echo "<option value='0".$var."'>0".$var;
							else
								echo "<option value='".$var."'>".$var;

							echo "</option>";
						}
					?>
					</select>
					<select name="endSec">
					<?php
						for($var=0;$var<60;$var++){
							if($var<10)
								echo "<option value='0".$var."'>0".$var;
							else
								echo "<option value='".$var."'>".$var;

							echo "</option>";
						}
					?>
					</select><br>
					<input type="submit" name="save" value="save" class="btn btn-primary" style="margin-top:10px; padding:5px 30px; font-size: 16px;">
				</form>
			</center>
			<div>
				<center><p><?php echo @$msg;?></p></center>
			</div>
		</div>
	</div>
	<div>
		<?php
			$conn = mysqli_connect("localhost","testAdmin","aA1@admin","hck") or die("could not connect to the database");
			$query ="select * from testinfo where active='yes'";
			$rs= $conn->query($query);
			if(!$rs){
				//do nothing!
			}else{
				if($rs->num_rows==1){
					$row = mysqli_fetch_assoc($rs);
		?>
		<center>
		<p style="color:red;">You have an active test:</p>
		<p><b>Starts at:<?php echo gmdate($dateFormat,$row["start"]);?></b></p>
		<p><b>Ends at: <?php echo gmdate($dateFormat,$row["end"]);?></b></p>
		</center>
		<?php
				}
			}
		?>
	</div>
</body>
</html>