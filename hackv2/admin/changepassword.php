<?php
if(isset($_POST['change'])){
	if(isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["oldPass"]) && !empty($_POST["oldPass"]) && isset($_POST["newPass"]) && !empty($_POST["newPass"]) && isset($_POST["confirmPass"]) && !empty($_POST["confirmPass"])){
		//get values
		$email = $_POST["email"];
		$oldPass = $_POST["oldPass"];
		$newPass = $_POST["newPass"];
		$confirmPass = $_POST["confirmPass"];

		$salt="gaurav8298";
		$oldPass=sha1($oldPass.$salt);
		//set default errors
		$emailPassErr ="";
		$oldPassErr ="";
		$confirmPassErr ="";

		$conn = mysqli_connect("localhost","testAdmin","aA1@admin","hck");
		$query = "select * from admin where email='".mysqli_real_escape_string($conn,$email)."' and password='".mysqli_real_escape_string($conn,$oldPass)."'";
		$rs = $conn->query($query);
		if(mysqli_num_rows($rs)>0){

			$row=mysqli_fetch_assoc($rs);
			if(strcmp($newPass, $confirmPass)==0){
				$newPass = sha1($newPass.$salt); 
				$query="UPDATE admin SET password='".$newPass."'";
				if($conn->query($query)){
					$msg = "Password updated!";
				}else
					$msg = "Unkown Server Error!";

			}else{
				$confirmPassErr = "Passwords doesn't matched!";
			}
		}else{
			$emailPassErr="Email or Password not found!";
		}
	}else{
		$msg = "<b style='color:red'>All Fields Required!</b>";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Hack1.0 | Admin - Update Password</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../assets/gbu_logo.png" type="image/gif" sizes="16x16">
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
	        <li><a href="testsettings.php">Test Settings</a></li>	        
	        <li class="active"><a href="changepassword">Change Password</a></li>
	        <li><a href="logout">Log out</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
	<div class="container-fluid passBox">
	<center><h3 class="boxlabel">Update Password</h3></center>
	<form action="" method="post">
		<label for="email">Email: </label>
		<input type="email" class="form-control" id="email" name="email" placeholder="Email"><br>

		<label for="Opass">Old Password: </label>
		<input type="password" class="form-control" id="Opass" name="oldPass" placeholder="Old password">
		<i style="color:red"><?php echo @$emailPassErr; ?></i><br><br>

		<label for="Npass">New Password: </label>
		<input type="password" class="form-control" id="Npass" name="newPass" placeholder="New password"><br>

		<label for="Cpass">Confirm Password: </label>
		<input type="password" class="form-control" id="Cpass" name="confirmPass" placeholder="Confirm password">
		<i style="color:red"><?php echo @$confirmPassErr; ?></i><br><br>

		<button class="btn btn-info btn-block" type="submit" name="change">Change Password</button><br>
	</form>
	</div>
	<br>
	<center><p style="color:green"><?php echo @$msg;?></p></center>
</body>
</html>