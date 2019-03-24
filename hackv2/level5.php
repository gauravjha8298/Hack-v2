<?php
header ("X-XSS-Protection: 0");
session_start();
include_once("functions.php");
//check if logged in
if(isset($_SESSION["id"]) && !empty($_SESSION["id"])){
	//fetch score
	$score = getScore($_SESSION["id"]);

	if(!submissionAllowed())
		header("Location:end");
	
	//check if previous are cleared
	$lvlF =areLevelCleared("1234");
	if($lvlF){
		// check if this level has been cleared
		if( isset($_COOKIE["levelSolved"]) && (strcmp($_COOKIE["levelSolved"],"[object Window]")==0) ){
			//update score after level cleared	
			if(updateScore($score,"12345")){  // updateScore(int newScore,String allClearedLevels)
				setcookie("levelSolved","",time()-3600,"/");
				header("Location: level6");
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
		header("Location:index.php"); // if not logged in jump to index page
}
?>
<html>
<head>
	<title>
		Level 5
	</title>
	<meta charset="utf-8">
	<meta name="language" content="English">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="assets/gbu_logo.png" type="image/gif" sizes="16x16">
	
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
			margin-top: 2%;
		}
		#btn{
			border: 1px dashed green;
			color: green;
			border-radius:3px;
			cursor: pointer;
		}
		#next-controls{
			display:none;
		}
	</style>
	<script type="text/javascript">
		function refreshPage(){
			location.reload();
		}
		window.addEventListener("message", function(event) {
			if(event.origin == "http://localhost")
				return;
			else{
				if(event.data=="success"){
					//document.getElementById("result").innerHTML="Received data from "+event.origin;	
					  	document.getElementById("result").innerHTML="Proceed to <button onclick='refreshPage()'>next level >> </button>"; 
					    //set cookie
					    var d = new Date();
					        d.setTime(d.getTime() + (30*24*60*60*1000));
					        var expires = "expires=" + d.toGMTString();
					    document.cookie = "levelSolved"+"="+event.source+";"+expires+";path=/";
				}
			}
		});
	</script>
</head>
<body>
	<h3 style="text-align: right; color:magenta;"><?php echo $_SESSION["name"]." (".$_SESSION["roll"].")";?> &nbsp; &nbsp;L-5 &nbsp; Score: <?php echo $score; ?> &nbsp; &nbsp;  <a href="leaderboard_table" target="_blank">Leaderboard</a> &nbsp; &nbsp; &nbsp;  <a href="logout.php">Log Out</a></h3>

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
	<center><p id="result"></p></center>
	<center id="main">
		<div>
			<iframe src="frame2.php" id="f1"></iframe>
		</div>
	</center>
	<script>

	var i = 0;
	//edit challenge text here
	var txt = 'Abhimanyu has now cleared the 4th stage beating "scriptor" but the at the 5th stage of chakravyuh is gaurded by "SCRIPTOR v2.0" which is an upgraded version of the old "Scriptor" robo. "Scriptor v2.0" is more intelligent and can detect XSS activities easily. Abhimanyu is struck here and is trying to figure out a trick to fool "Scriptor v2.0" and clear this stage!';
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
	  		var txt2 ="Can he bypass this level as well to reach the 7th door asap and help Pandavas win the war?";
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