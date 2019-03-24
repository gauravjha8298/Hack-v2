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
	if(areLevelCleared("0")==true){
		if( isset($_COOKIE["levelSolved"]) && (strcmp($_COOKIE["levelSolved"],"1")==0) ){
			//update score after level cleared	
			if(updateScore($score,"1")){  // updateScore(int newScore,String allClearedLevels)
				setcookie("levelSolved","",time()-3600,"/");
				header("Location: level2");
			}else
				$msg = "<h4>You cleared this level, but there is some issue with the server!</h4>";
		}
		
	}else{
		$lvl=getCurrLevel($lvlF);
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
		header("Location:index"); // if not logged in jump to index page
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Level 1</title>
	<meta charset="utf-8">
	<meta name="language" content="English">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
	 body{
	 	background-color: #000;
	 }
	 .image-blur{
	 	margin-top:-5%;
	 	width:350px;
	 	height: 350px;
	 	background-image: url("assets/abhimanyu.png");
	 	background-repeat: no-repeat;
	 	background-position: center;
	 	background-size: 100%;
	 	box-shadow: 0px 75px 22px 23px black inset;
	 	margin-bottom: -10px;
	 }
	</style>
	<noscript>
		Please enable your javascript!
		<style>
			main{
				display: none;
				color:black;
			}
			body{
				background-color: black;
				color:green;
				padding: 25%;
				padding-left: 40%;
				font-size: 30px;
			}
		</style>
	</noscript>
	<script>
		function refreshPage(){
			location.reload();
		}
		function checkPassowrd(){
			var pass = document.getElementById("passwd").value;
			if(pass=="wearehackers#007"){
				  document.getElementById("result").innerHTML="Proceed to <button onclick='refreshPage()'>next level >> </button>"; 
				  //set cookie
				  var d = new Date();
				      d.setTime(d.getTime() + (30*24*60*60*1000));
				      var expires = "expires=" + d.toGMTString();
				  document.cookie = "levelSolved"+"="+1+";"+expires+";path=/";
			}else{
				document.getElementById("result").innerHTML = "Wrong Password!";
			}
		}
	</script>
	<!-- link href="https://fonts.googleapis.com/css?family=Share+Tech+Mono" rel="stylesheet" -->

</head>
<body>
	<main>
		<h3 style="text-align: right; color:magenta;"><?php echo $_SESSION["name"]." (".$_SESSION["roll"].")";?> &nbsp; &nbsp;L-1 &nbsp; Score: <?php echo $score; ?> &nbsp; &nbsp; <a href="leaderboard_table" target="_blank">Leaderboard</a> &nbsp; &nbsp; &nbsp; <a href="logout.php">Log Out</a></h3>

		<!-- Challenge Text -->
		<center id="story">
			<div>
				<h1 style="color:white"><b style="color:yellow"> MAHABHARAT:</b><u> THE CYBER WAR BETWEEN PANDAVAS AND KAURAVAS </u></h1>
				<!--<h2> <u>Chakravyuh : Journey to the 7th door</u> </h2> -->
				<h3 id="storyText" style="color:green;font-family: 'Share Tech Mono', monospace;"></h3>
				<h3 id="ques"></h3>
				<div class="image-blur"></div>

			</div>
		</center>
		<!-- Challenge Area -->
		<div>
			<center>
				<input type="password" id="passwd" placeholder="your password..." />
				<button onclick="checkPassowrd()" class="btn btn-default">Click Me To Login</button>
				<br/><br/>
				<p id="result" style="color:maroon;">Enter password to next level.</p><br>
				<?php echo @$msg; ?>
			</center>
		</div>
	</main>
	
	<script>

	var i = 0;
	// edit challenge text here
	var txt = 'Abhimanyu is learning hacking for the first time and he has recently learned to explore the codes of web pages using browser. He got a new challenge by his father Arjun, asking him to bypass this webpage login using his recently learned JavaScripts. As Abhimanyu is only 13 years old & very new to JavaScripts he contacted you to help him bypass this challenge.';
	var speed = 0;
	
	function typeStory() {
	  if (i < txt.length) {
	  	if(txt.charAt(i)=="." || txt.charAt(i)=="," )
	    	speed =800;
	    else
	    	speed =20;
	    document.getElementById("storyText").innerHTML += txt.charAt(i);
	    i++;
	    setTimeout(typeStory, speed);
	  }else{
	  		var j = 0;
	  		var txt2 ="Can you help him bypass this very first challenge?";
	  	function typeQues() {
	  	  if (j < txt2.length) {
	  	  	if(txt2.charAt(i)=="." || txt2.charAt(j)=="," )
	  	    	speed =800;
	  	    else
	  	    	speed =15;
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