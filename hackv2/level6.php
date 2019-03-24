<?php
session_start();
include_once("functions.php");
//check if logged in
$data="";
if(isset($_SESSION["id"]) && !empty($_SESSION["id"])){
	//fetch score
	$score = getScore($_SESSION["id"]);

	if(!submissionAllowed())
		header("Location:end");

	//check if previous are cleared
	if(areLevelCleared("12345")){
		if( isset( $_POST[ 'find' ] ) ) {
			//create DB connection
			$conn=mysqli_connect("localhost","testUser","aA1@testuser","hck");
			// Get input
			$id = test_input(@$_POST[ 'weaponID' ]);

			$id = mysqli_real_escape_string($conn, $id);
				if($id==4)
					$fmsg = "Cannot find any weapon with id-".$id;
				else{
					$query  = "SELECT * from weapons where id = $id;";
					//echo $query."<br>";
					$result = mysqli_query($conn, $query) or die( '<pre>' . mysqli_error($conn) . '</pre>' );

					// Get results
					if(mysqli_num_rows($result)>0){
							while($row=mysqli_fetch_row($result)){
								//Display record
								$data .= "id: ".$row[0]." | Name: ".$row[1]." | Power: ".$row[2]."<br>";
							}
					}else
						$fmsg= "Can't find anything!";

					$conn->close();
				}
		}else if(isset($_POST['submit'])){
			$conn=mysqli_connect("localhost","testUser","aA1@testuser","hck");
			//get input
			$code = test_input($_POST['code']);
			$code= mysqli_real_escape_string($conn, $code);
			if(is_numeric($code)==0)
				$smsg = "Invalid Input!";
			else{
				$query = "SELECT * from weapons where issecret=0 and code='".$code."'";
				@$result = mysqli_query($conn,$query) or die("Wrong code!");
				if(mysqli_num_rows($result)==1){
					$conn->close();
					//echo "level cleared!";
					if(updateScore($score,"123456")){  // updateScore(int newScore,String allClearedLevels)
						header("Location: level7");
					}else
						$msg = "<h4>You cleared this level, but there is some issue with the server!</h4>";
				}else
					$smsg = "Wrong Code entered!";
			}
		}
	}else{
		$lvl=getCurrLevel(areLevelCleared("12345"));
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
<!DOCTYPE html>
<html>
<head>
	<title>Level 6: SQL injection</title>
	<meta charset="utf-8">
	<meta name="language" content="English">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="assets/gbu_logo.png" type="image/gif" sizes="16x16">
	<!-- stylesheets -->
	<link rel="stylesheet" type="text/css" href="css/main.css">

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
		#scode{
			width:250px;
		}
		#store{
			border: 2px solid white;
			max-width:600px;
			text-align: center;
			margin: 0 auto;
			padding:10px;
		}
		#promo{
			margin-top: -30px;
		}
		#storeHeader{
			text-align: left;
			margin-left: -10px;
			margin-top: -57px;
			margin-bottom: -20px;
			background: #962020c4;
			color: white;
			padding: 0;
			font-size: 31px;
			width: 103%;
		}
	</style>
	<!--link href="https://fonts.googleapis.com/css?family=Share+Tech+Mono" rel="stylesheet" -->
	<!-- JavaScripts -->
	<script type="text/javascript" src="js/bootstrap/bootstrap.min.js"></script>
</head>
<body>
	<h3 style="text-align: right; color:magenta;"><?php echo $_SESSION["name"]." (".$_SESSION["roll"].")";?> &nbsp; &nbsp;L-6 &nbsp; Score: <?php echo $score; ?> &nbsp; &nbsp;  <a href="leaderboard_table" target="_blank">Leaderboard</a> &nbsp; &nbsp; &nbsp;  <a href="logout.php">Log Out</a></h3>

	<!-- Challenge Text -->
	<center id="story">
		<div>
			<h1 style="color:white"><b style="color:yellow"> MAHABHARAT:</b><u> THE CYBER WAR BETWEEN PANDAVAS AND KAURAVAS </u></h1>
			<!--<h2> <u>Chakravyuh : Journey to the 7th door</u> </h2> -->
			<h3 id="storyText" style="color:green;font-family: 'Share Tech Mono', monospace;text-align: justify">
				<p>The battle has come to a crucial stage now. Both the Kauravas and the Pandavas has decided to buy some new shastra for their inventory from weaponstore.com. Weaponstore.com is an online weapon store which has a lot powerful & destructive astra & shastra.</p><p> Shakuni mama recently got to know from one of his informers that weaponstore.com has a secret shastra which he only sells to the customers who have the secret code of the weapon. Weaponstore.com maintains all the data of the weapons on their server in a database. Shakuni mama advised the kauravas to get the secret weapon from the weaponstore.com and now the kauravas are busy trying to find out the secret code.</p><p> On the other hand, Krishna knew about this all along so he aksed Arjun to get the secret code before kauravas gets it.Since Arjun is busy with other battles he asked Abhimanyu to get the secret code.Abhimanyu remebers all the lessons from his childhood time when his father Arjun told subhadra how to perform SQL Injections on a website.</p></h3>
			<h3 id="ques"></h3>
			<div class="image-blur"></div>

		</div>
	</center>
	<!-- Challenge Area -->
	<div id="store">
		<div id="storeHeader"><h6>&nbsp;Weaponstore.com<img src="assets/cart.png" style="float:right"></h6>
		</div>
		<marquee id="promo">*** Special Weapons Available. Hurry only 1 Left! ***</marquee>
	<center>
		<br/>
	<form action="" method="post">
		<label for="scode">Secret Code: </label>
		<input type="number" id="scode" name="code" placeholder="Enter secret code to get secret weapon" />
		<button type="submit" name="submit" value="#">Submit Code</button>
	</form>
	<br/>
	<p style="color:red"><?php echo @$smsg; ?></p>
 	</center>
 	<br>
 	<br>
 	<center style="margin-top:-22px">
 	Search Weapons:	
 	<form action="" method="POST" style="margin-top: 5px;">
 		<label for="Weapon">Weapon ID: </label>
 		<select name="weaponID" id="Weapon">
 			<option value="1">1</option>
 			<option value="2">2</option>
 			<option value="3">3</option>
 			<option value="4">4</option>
 			<option value="5">5</option>
 		</select>
 		<button type="submit" name="find" value="#">Find</button>
 	</form>
 	</center>
 	<center>
 		<p style="color:magenta;text-align: justify;"><?php echo @$data; ?></p>
 		<p style="color:magenta"><?php echo @$fmsg; ?></p>
 	</center>
 </div>
 	<script>

 	var i = 0;
 	// edit challenge text here
 	var txt = '';
 	var speed = 0;
 	
 	function typeStory() {
 	  if (i < txt.length) {
 	  	if(txt.charAt(i)=="." || txt.charAt(i)=="," )
 	    	speed =800;
 	    else
 	    	speed =2;
 	    //document.getElementById("storyText").innerHTML += txt.charAt(i);
 	    i++;
 	    setTimeout(typeStory, speed);
 	  }else{
 	  		var j = 0;
 	  		var txt2 ="Since you are the only hope of pandavas, can you get the secret code for your father?";
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