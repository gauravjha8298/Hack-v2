<?php
session_start();
include_once("functions.php");
//check if logged in
if(isset($_SESSION["id"]) && !empty($_SESSION["id"])){
	//fetch score
	$score = getScore($_SESSION["id"]);

	if(!submissionAllowed())
		header("Location:end");

	//check if previous are cleared
	if(areLevelCleared("12")){

		if(isset($_POST['login']) && isset($_POST['email']) && isset($_POST['pass'])){
			if($con=mysqli_connect("localhost","testUser","aA1@testuser","hck")){
				$sql="select * from usr where email = '".$_POST['email']."' and password= '".$_POST['pass']."'";
				$result=mysqli_query($con,$sql);

				@$numRows = mysqli_num_rows($result);
				if($numRows==1){
					$con->close();
					// level cleared -> update score
					if(updateScore($score,"123")){  // updateScore(float currScore,String allClearedLevels)
						header("Location: level4");
					}else
						$msg = "<h4>You cleared this level, but there is some issue with the server!</h4>";
				}
				else
					$msg="<h1>Try hard untill you succeed!</h1>";
			}else
				$msg='bye world!';
		}

	}else{
		$lvl=getCurrLevel(areLevelCleared("12"));
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
}else{
		header("Location:index.php"); // if not logged in jump to index page
}
?>
<html>
<head>
	<title>
		Level 3
	</title>
	<meta charset="utf-8">
	<meta name="language" content="English">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<style>
		body{
			background-color: #000;
			color:green;
			font-family: monospace;
		}
		#story{
			margin-top: 2%;
			padding-left: 5%;
			padding-right: 5%;
			text-align: center;
		}
		#main{
			margin-top: 5%;
		}
		#btn{
			border: 1px dashed green;
			color: green;
			border-radius:3px;
			cursor: pointer;
		}
	</style>
	<script src="typed.js"></script>
</head>
<body>
	<h3 style="text-align: right; color:magenta;"><?php echo $_SESSION["name"]." (".$_SESSION["roll"].")";?> &nbsp; &nbsp;L-3 &nbsp; Score: <?php echo $score; ?> &nbsp; &nbsp;  <a href="leaderboard_table" target="_blank">Leaderboard</a> &nbsp; &nbsp; &nbsp;  <a href="logout.php">Log Out</a></h3>

		<!-- Challenge Text -->
		<center id="story">
			<div>
				<h1 style="color:white"><b style="color:yellow"> MAHABHARAT:</b><u> THE CYBER WAR BETWEEN PANDAVAS AND KAURAVAS </u></h1>
			<!--<h2> <u>Chakravyuh : Journey to the 7th door</u> </h2> -->
			<h3 id="storyText" style="color:green;font-family: 'Share Tech Mono', monospace;text-align: justify"></h3>
			<h3 id="ques"></h3>
			<img src="assets/robo1.png" height="250px">

		</div>
	</center>
	<center id="main">
		<div>
			<form method="POST" action="">
				<input type="text" name="email" placeholder="Username">
				<input type="password" name="pass" placeholder="Password">
				<input type="submit" name="login" value="LET ME IN" id="btn">
			</form>
		</div>
		<div>
			<h3><?php if(isset($_POST['login']))
							echo "".@$msg; 
				?>		
			</h3>
			<h4><?php //echo @$qry; ?></h4>
		</div>

	</center>
	<script>
	var i = 0;
	var txt = 'Abhimanyu has now completed his father\'s challenge and as per the promise had learnt all the Cyber lessons from his father, and now the time has come when he has the opportunity to fight in the cyber battle for the first time.The Cyber War is between the pandavas & the Kauravas. The Kaurav sena have lot of robots and they are now forming "Chakravyuh" which is the most complicated formation with 7 stages. At the very first stage there is a robot who only allows soilders having the right credentials to pass and only Arjun knows how to fool this robot and bypass the Authentication. But Arjun is busy in war with Dushashana so the pandavas asked Abhimanyu to fool the robot since he had learnt Authentication bypassing quite well from his father.';
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
	  		var txt2 ="Can he bypass this level as well to reach the 7th stage asap and help Pandavas win the war?";
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