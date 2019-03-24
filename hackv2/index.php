<?php
session_start();
include_once("functions.php");
function login($email,$password){

			$conn = mysqli_connect("localhost","testUser","aA1@testuser","hck");

			if(!$conn){
				return "Unkown Error!";
			}else{
				$sql = "select * from participants where email='".$email."'";
				$rs = $conn->query($sql);
				if(!$rs){
					$conn->close();
					return "Unknown Error!";
				}else{
					if(mysqli_num_rows($rs)==1){
						$row = $rs->fetch_assoc();
						if(strcmp($row["password"], $password)==0){

							$roll=str_split($row["roll"]);
							$Y=$roll[0].$roll[1]."/";
							$B=$roll[2].$roll[3].$roll[4]."/";
							$N=$roll[5].$roll[6].$roll[7];

							// start a new session with new values
							$_SESSION["id"]=$row["id"];
							$_SESSION["name"]=$row["name"];
							$_SESSION["roll"]=$Y.$B.$N;
							$_SESSION["score"] = $row["score"];

							//get current level of user
							$currLevel=getCurrLevel(false);
							//var_dump($currLevel);
							if(strcmp($currLevel, "acknowledgement")==0){
									$conn->close();
									header("Location:acknowledgement");
							}
							else if($currLevel>7){
								$conn->close();
								header("Location:end");
							}
							else{
								$conn->close();
								header("Location:level".$currLevel);
							}


						}else{
							$conn->close();
							return "Wrong password or email!";
						}
					}else{
						$conn->close();
						return "Wrong password or email!";
					}
				}
			}
		}


//check if logged in
if(isset($_SESSION["id"]) && !empty($_SESSION["id"])){
		// if logged in get the current level
		$currLevel=getCurrLevel(false);

		if(strcmp($currLevel, "acknowledgement")==0)
			header("Location:acknowledgement");
		
		if($currLevel!=false && strcmp($currLevel, "acknowledgement")!=0){
			if($currLevel>7){
				header("Location:end.php");
			}else{
				$stage= "level".$currLevel.".php";
				header("Location:$stage");
			}
		}
}
else{
		//if trying to log in
		if(isset($_POST["login"])){
			//get form data-
			$email=test_input($_POST["email"]);
			$pass=test_input($_POST["pass"]);

			// hash password with salt
			$salt="gaurav8298";
			$pass=sha1($pass.$salt);
			$loginFormMsg=login($email,$pass);
		}

		//if trying to register
		if(isset($_POST["register"])){
			//Default error msg
			$nameErr="";$emailErr="";$rollErr="";$passErr="";
			//get form data
			$email1=test_input($_POST["email"]);
			$pass=test_input($_POST["pass"]);
			$name=test_input($_POST["name"]);
			$roll=test_input($_POST["roll"]);

			//validation for name
			if(empty($name)){
				$nameErr="Name is required!";
			}else{
				if(!preg_match ("/^[a-zA-Z\s]+$/",$name)) //characters and spaces allowed
					$nameErr="Only letters and spaces allowed!";
			}

			//validation for email
			if (empty($email1)) {
			    $emailErr = "Email is required";
			  } else {
			    // check if e-mail address is well-formed
			    if (!filter_var($email1, FILTER_VALIDATE_EMAIL)) {  //email format name@domain.xyz
			      $emailErr = "Invalid email format"; 
			    }
			  }

			//validation for password
			if (empty($pass)) {
			    $passErr = "Password is required";
			  }

			//validation for roll number
			if(empty($roll)){
			  $rollErr="Roll number is required!";
			}else{
			    if(strlen($roll)==8)
			     if (!preg_match("/^[0-9][0-9]+[a-zA-z]+[0-9][0-9][0-9]/",$roll)) {
			      $rollErr = "Invalid roll number format!";  
			    }else{
			    	$roll= preg_replace_callback('/([a-z])/', function ($word) {
			    	      return strtoupper($word[1]);
			    	      }, $roll);
			    }
			}

			//if no errors found in validation
			if($nameErr=="" && $emailErr=="" && $passErr=="" && $rollErr==""){
				// hash password wiht salt
				$salt="gaurav8298";
				$pass=sha1($pass.$salt);

				$conn = mysqli_connect("localhost","testUser","aA1@testuser","hck");
				if(!$conn){
					$formMsg = "Unknown Error!";
				}else{
					$sql = "select * from testinfo where id=1";
					$rs = $conn->query($sql);
					$row = $rs->fetch_assoc();

					if($row["status"]==0 && strcmp($row["active"], "yes")==0)
						$sql ="INSERT INTO participants (name,email,password,roll,last_submission) values('".$name."','".$email1."','".$pass."','".$roll."','".$row["start"]."')";
					else
						$sql = "INSERT INTO participants (name,email,password,roll) values('".$name."','".$email1."','".$pass."','".$roll."')";

					$rs=$conn->query($sql);
					if(!$rs){
						$SQLError=" ".mysqli_error($conn);
						if(strpos($SQLError,"Duplicate")!=false){
							if(strpos($SQLError, "email")!=false){
								$conn->close();
								$emailErr = "This email is already registered!";
							}else if(strpos($SQLError,"roll")!=false){
								$conn->close();
								$rollErr = "Roll Number already registered!";
							}else{
								$conn->close();
								$formMsg = "Unkown database error!";
							}

						}else{
							$conn->close();
							$formMsg = "Unknown form submission Error!";
						}
					}else{
						$conn->close();
						login($email1,$pass);
					}
				}
				
			}else{
				$formMsg= "Registration Unsucessful: All fields are required";
			}
		}
}
?>

<html>
<head>
	<title>
		Hack 1.0 - Login or Register
	</title>
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
<body style="
	background-image: url(assets/watermark.png);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    background-color: whitesmoke;
">
	<center style="margin-top:3%"><img src="assets/eventName.png" id="eventName"/></center>
	<div class="container-fluid">
		<div class="row">
		  <!-- login form -->
		  <div class="col-sm-5" id="login-form">
		  		<center><h3><u> Log in </u></h3></center>
		  		<form method="post" action="" style="margin-top: 5%;">
		  			<div class="form-group">
		  			  <label for="email">Email:</label>
		  			  <input type="email" name="email" class="form-control" id="email" value="<?php echo @$email;?>">
		  			</div>
		  			<div class="form-group">
		  			  <label for="password">Password:</label>
		  			  <input type="password" name="pass" class="form-control" id="password">
		  			</div>
		  			<input type="submit" name="login" class="btn btn-info btn-block" value="Sign in" />
		  		</form>	
		  		<center><p class="errMsg"><?php echo @$loginFormMsg; ?></p></center>
		  </div>
		  <div class="col-sm-1">
		  	<center><p id="afterText">or</p></center>
		  </div>
		  <!-- registeration form -->
		  <div class="col-sm-6" id="registration-form">
		  		<center><h3><u> Register Here </u></h3></center>
		  		<form method="post"  action="" style="margin-top: 5%;">	
		  			<div class="row form-group">
		  				<div class="col-sm-6">
		  					<label for="name"> Name: </label>
		  					<input type="text" name="name" pattern="[A-Z a-z]{3,}" class="form-control mb-2 mr-sm-2" value="<?php echo @$name;?>"/>
		  					<p class="errMsg"><?php echo @$nameErr; ?></p>
		  				</div>
		  				<div class="col-sm-6">
		  					<label for="roll"> Roll No: </label>
		  					<input type="text" name="roll" pattern="[A-Za-z0-9]{8}" class="form-control mb-2 mr-sm-2" style="text-transform:uppercase" value="<?php echo @$roll;?>" placeholder="e.g. 16BIT021,13ICS001"/>
		  					<p class="errMsg"><?php echo @$rollErr; ?></p>
		  				</div>
		  			</div>
		  			<div class="form-group">
		  			  <label for="email1">Email:</label>
		  			  <input type="email" name="email" class="form-control" id="email1" value="<?php echo @$email1;?>" />
		  			  <p class="errMsg"><?php echo @$emailErr; ?></p>
		  			</div>
		  			<div class="form-group">
		  			  <label for="password1">Password:</label>
		  			  <input type="password" name="pass" class="form-control" id="password1"  />
		  			  <p class="errMsg"><?php echo @$passErr; ?></p>
		  			</div>
		  					
		  			<input type="submit" name="register" class="btn btn-success btn-block" value="Register Me">
		  		</form>		
		  		<center><p class="errMsg"><?php echo @$formMsg; ?></p></center>
		  </div>
		</div>
		<!-- Rules and instructions -->
		<div id="instructions">
			<center><h5><b><i><u>Rules & Instructions</u></i></b></h5></center>
			<ul>
				<li>Candidate needs to register themself for the test if not yet registered.</li>
				<li>After successful registration login to your account to start the test.</li>
				<li>There are 7 levels in this series.</li>
				<li>Each level will be of 100 marks.</li>
				<li>A candidate must atleast clear 3 levels to be eligible for becoming a winner.</li>
				<li>The candidate with most levels cleared within least time will be declared as winner.</li>
				<li>In case of a tie, tie-breaker round will be introduced.</li>
				
			</ul>
			<p><i><b>Note:</b> Read all the instructions carefully before starting the test.</i></p>	
		</div>
	</div>
	<footer style="background: darkseagreen;padding: 0.5em;"><i style="font-size: 13px">&nbsp;&nbsp;&nbsp;**Best viewed with: Google Chrome - V68.0 and Mozzila Firefox - V62.0</i><b style="float: right">Developed By: Gaurav Kumar Jha</b></footer>
</body>
</html>