<?php
 session_start();
 if(isset($_SESSION["admin"]) && !empty($_SESSION["admin"]))
 	header("Location:home");
 else{
 	if(isset($_POST["login"]) && isset($_POST["email"]) && isset($_POST["password"]) ){
 		$conn = mysqli_connect("localhost","testAdmin","aA1@admin","hck");
 		$query = "select * from admin where email = '".mysql_real_escape_string($_POST["email"])."'";
 		$rs= $conn->query($query);
 		if(!$rs){
 			$msg= "Unknown Error!";
 		}else{
 			if($rs->num_rows>0){
 				$row=$rs->fetch_assoc();
 				// hash password with salt
 				$salt="gaurav8298";
 				$password=sha1($_POST["password"].$salt);
 				if(strcmp($password, $row["password"])==0){
 					$_SESSION["admin"]=$row["id"];
 					$_SESSION["name"]=$row["name"];
 					header("Location:home");
 				}else{
 					$msg = "Wrong Password or Email!";
 				}
 			}else{
 				$msg = "Wrong Password or Email!";
 			}
 		}
 	}
 }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin - Login</title>
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
	<div class="container-fluid">
	<div class="row">
	<!-- login form -->
	<div class="col-sm-4 col-sm-offset-4" id="login-form">
			<center><h3><u> Log in </u></h3></center>
			<form method="post" action="" style="margin-top: 5%;">
				<div class="form-group">
				  <label for="email">Email:</label>
				  <input type="email" name="email" class="form-control" id="email" value="<?php echo @$email;?>">
				</div>
				<div class="form-group">
				  <label for="password">Password:</label>
				  <input type="password" name="password" class="form-control" id="password">
				</div>
				<input type="submit" name="login" class="btn btn-info btn-block" value="Sign in" />
			</form>	
			<center><p class="errMsg"><?php echo @$msg; ?></p></center>
	</div>
	</div>
	</div>
</body>
</html>