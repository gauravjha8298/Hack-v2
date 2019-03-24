<?php
session_start();
include_once("functions.php");
//check if logged in
if(isset($_SESSION["id"]) && !empty($_SESSION["id"])){
	//fetch score
	$score = getScore($_SESSION["id"]);

	if(!submissionAllowed())
		header("Location:end");

	if(areLevelCleared("1")==true){
		if(isset($_POST["login"]) && !empty($_POST["login"])){
			$conn = mysqli_connect("localhost","testUser","aA1@testuser","hck");
			$pass = test_input($_POST["pass"]);
			echo $pass;
			$pass = mysqli_real_escape_string($conn,$pass);
			$conn->close();
			if(strcmp($pass, "mai samay hu")==0){
				//level cleared
				if(updateScore($score,"12"))
					header("Location:level3.php");
				else
					$msg = "Error updating score on server!";
			}else
				$msg = "Wrong password!";
		}
	}else{
		$lvl=getCurrLevel(false);
		if(strcmp($lvl, "acknowledgement")==0)
			header("Location:acknowledgement");
		else if($lvl==false)
			header("Location:index.php");  // if all these levels are not cleared then redirect to index.php 
		else{
			if($lvl >7)
				header("Location:end");
			else
				header("Location:level".$lvl);
		} 
	}
}else
	header("Location:index.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Level 2: Stegnography</title>
	<meta charset="utf-8">
	<meta name="language" content="English">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
	 body{
	 	background-color: #000;
	 }
	 .image-blur{
	 	width:500px;
	 	height: 200px;
	 	background-image: url("assets/samay.jpg");
	 	background-repeat: no-repeat;
	 	background-position: center;
	 	background-size: 100%;
	 	box-shadow: 0px 10px 61px 23px black inset;
	 	margin-bottom: -10px;
	 }
	</style>
	

</head>
<body>
	<h3 style="text-align: right; color:magenta;"><?php echo $_SESSION["name"]." (".$_SESSION["roll"].")";?> &nbsp; &nbsp;L-2 &nbsp; Score: <?php echo $score; ?> &nbsp; &nbsp; <a href="leaderboard_table" target="_blank">Leaderboard</a> &nbsp; &nbsp; &nbsp;  <a href="logout.php">Log Out</a></h3>

	<!-- Challenge Text -->
	<center id="story">
		<div>
			<h1 style="color:white"><b style="color:yellow"> MAHABHARAT:</b><u> THE CYBER WAR BETWEEN PANDAVAS AND KAURAVAS </u></h1>
			<h3 id="storyText" style="color:green;font-family: 'Share Tech Mono', monospace;text-align: justify;margin-left: 5%;margin-right: 5%"></h3>
			<h3 id="ques"></h3>
			<div class="image-blur"></div>
			<br/>
			<a href="assets/samay.jpg" style="text-decoration: none;">Download Image</a>
		</div>
	</center>
	<!-- Challenge Area -->
	<center style="margin-top: 3%">
		<div id="challenge">
			<form action="" method="post">
				<input type="password" name="pass" />
				<input type="submit" name="login" value="Login"/>
			</form>
			<br>
			<br>
			<p style="color:red"><?php echo @$msg; ?></p>
		</div>
	</center>

	<script>

	var i = 0;
	var txt = 'Arjun is very proud as his son Abhimanyu successfully completed the challange. Now he taught Abhimanyu about stegnography, a way of hiding secret data into image files. But he is not sure that Abhimanyu has got the concept so he gave Abhimanyu another challenge to login to his phone using the below login form and also sent him the password hidden into an image file. Arujn promised Abhimanyu that if he complete this chalenge then he will teach him all the Cyber lessons and will also give him the opportunity to fight in the Cyber War. Abhimanyu being a bright kid acepted the challenge and is trying to login to his father\'s phone.';
	var speed = 0;
	
	function typeStory() {
	  if (i < txt.length) {
	  	if(txt.charAt(i)=="." || txt.charAt(i)=="," )
	    	speed =800;
	    else
	    	speed =30;
	    document.getElementById("storyText").innerHTML += txt.charAt(i);
	    i++;
	    setTimeout(typeStory, speed);
	  }else{
	  		var j = 0;
	  		var txt2 ="Can he get the hidden data out of the image & login to his father\'s phone?";
	  	function typeQues() {
	  	  if (j < txt2.length) {
	  	  	if(txt2.charAt(i)=="." || txt2.charAt(j)=="," )
	  	    	speed =800;
	  	    else
	  	    	speed =30;
	  	    document.getElementById("ques").style.color="red";
	  	    document.getElementById("ques").innerHTML += txt2.charAt(j);
	  	    j++;
	  	    setTimeout(typeQues, speed);
	  	  }
	  	}
	  	typeQues();
	  }

	}
	typeStory();	
	</script>
</body>
</html>