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
	if(areLevelCleared("123456")){
		if(isset($_POST['send']) && !empty($_POST['send'])){
			//var_dump($_FILES['file-upload']);
			if($_FILES['file-upload']["error"]){
				echo "<br>Error uploading the file!";
			}else{
				//storage,name and allowed types
				$folder="images/";
				$allowedType=array("jpg","png","jpeg","bmp","gif");    // whitelist array
				$newFilename = sha1($_SESSION["id"]).$_FILES['file-upload']['name'];
				$fileExt=strtolower(explode('.',$_FILES['file-upload']['name'])[1]);  // bypass using double extension e.g. :   xyz.jpeg.php
				$mimeType=explode('/',$_FILES['file-upload']['type'])[0];				// bypass using proxy connection | burp suite 

				if(in_array($fileExt,$allowedType) && strcmp($mimeType,"image")==0){
					$tmpName=$_FILES['file-upload']['tmp_name'];
					if(move_uploaded_file($tmpName, $folder.$newFilename)) {
						//$newFIlename.$fileExt  => not hackable
						//echo "<br>File Upload successful!";

						//-----------LEVEL CLEARED-----------

						//add a button to view file
						$msg = "<br><img src='images/".$newFilename."' style='height:200px; width:300px;' onerror=showBtn() />";
					}
					else
						$msg = "<br>Unknown Error!";
				}else
					$msg = "<br>Error: File is not an image";
			}
		}
	}else{
		$lvl=getCurrLevel(false);
		if(strcmp($lvl, "acknowledgement")==0)
			header("Location:acknowledgement");
		else if($lvl==false)
			header("Location:index.php");  // if all these levels are not cleared then redirect to index.php 
		else{
			if($lvl >7)
				header("Location:end.php");
			else
				header("Location:level".$lvl.".php");
		}
	}
}else{
		header("Location:index.php"); // if not logged in jump to index page
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Level 7 - FILE UPLOAD </title>
	<meta charset="utf-8">
	<meta name="language" content="English">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="assets/gbu_logo.png" type="image/gif" sizes="16x16">
	<!-- stylesheets -->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	
	<!-- JavaScripts -->
	<script type="text/javascript" src="js/bootstrap/bootstrap.min.js"></script>
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
		input[type=file]{
			border: 1px solid white;
		}
	</style>
</head>
<body>
	<h3 style="text-align: right; color:magenta;"><?php echo $_SESSION["name"]." (".$_SESSION["roll"].")";?> &nbsp; &nbsp;L-7 &nbsp; Score: <?php echo $score; ?> &nbsp; &nbsp; <a href="leaderboard_table" target="_blank">Leaderboard</a> &nbsp; &nbsp; &nbsp;  <a href="logout.php">Log Out</a></h3>
	<center id="story">
		<div>
			<h1 style="color:white"><b style="color:yellow"> MAHABHARAT:</b><u> THE CYBER WAR BETWEEN PANDAVAS AND KAURAVAS </u></h1>
			<!--<h2> <u>Chakravyuh : Journey to the 7th door</u> </h2> -->
			<h3 id="storyText"  style="color:green;font-family: 'Share Tech Mono', monospace;"></h3>
			<h3 id="ques"></h3>
			<p><a href="stage7.txt" target="_blank">Download Fake profile.</a></p>
		</div>
	</center>
	<center>
	<form method="post" action="" enctype="multipart/form-data">
		<input type="file" name="file-upload">
		<input type="submit" name="send" value="UPLOAD">
	</form>
	</center>
	<center style="margin-top:5%"><p id ="viewImageButton"><?php echo @$msg; ?></p></center>
	<?php
		echo '<script>
			function showBtn() {
    				document.getElementById("viewImageButton").innerHTML = "';
    				echo "<a target='blank' href='images/".@$newFilename."'>";
    				echo '<button> View Image </button></a>";
			}
		</script>';
	?>
	<script>

	var i = 0;
	var txt = 'The unstoppable Abhimanyu has cleared the 6th stage and got the secret weapon for pandavas. The pandavas has already won half the war by acquiring the secreat weapon but the chakravyuh is needed to be destroyed. Abhimanyu has reached the final stage of chakravyuh but he can\'t beat all the soilders inside the 7th stage. He has to inject a soilder from his side into the Kaurav Sena. To inject a soilder he needs to upload a fake profile to the Kauravas soilder database. Somehow he got the interface to upload the fake profile to Kauravas database.';
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
	  		var txt2 ="Can he bypass this final stage and help Pandavas win the war?";
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