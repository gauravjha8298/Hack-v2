<?php
session_start();
if(!isset($_SESSION["admin"]) || empty($_SESSION["admin"]))
	die("You don't have permissions to access this page!");

$id=$_SESSION["admin"];
$conn = mysqli_connect("localhost","testAdmin","aA1@admin","hck");
$query = "select name from admin where id='".$id."'";
$rs = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Dashboard</title>
	<meta charset="utf-8">
	<meta name="language" content="English">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../assets/gbu_logo.png" type="image/gif" sizes="16x16">
	<!-- stylesheets -->
	<link rel="stylesheet" type="text/css" href="../css/admin.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script>
		function endTest(){
			window.location="endtest.php";
		}
		function startTest(){
			window.location="starttest.php";
		}
	</script>
</head>
<body>
	<?php	
		$script="";
			if(!$rs){
				$dbErr = "Unknown server error!";
			}else{
					$row = mysqli_fetch_assoc($rs);
					$name=$row["name"];

					$offset=5.5*60*60;
					$dateFormat="d M, Y H:i:s";

					//check if there are active tests
					$query = "select * from testinfo where id=1";
					$rs=$conn->query($query);

					if(!$rs)
						die("Unknown Server Error!");
					else{
						$row=mysqli_fetch_assoc($rs);
						$active = $row["active"];
						if(strcmp($active, "yes")==0){
							$status = $row["status"];
							$endTime = $row["end"];
							$timeNdate=gmdate($dateFormat, $endTime);
							if($status==1){
							//if test has not started ?>
							<center id="timer">
								<div class="container-fluid" style="width:30%">
									<div class="row">
										<div class="row">
											<h4>Test Starts at: <i style="color:green"><?php echo @gmdate($dateFormat, $row["start"]); ?></i> </h4>
											<h4>Test Ends at: <i style="color:red"><?php echo @$timeNdate; ?></i> </h4>
										</div>
										<div class="col-xs-12"><button class="btn btn-success btn-lg" type="submit" style="border-radius:0px; margin-bottom:10px" name="start" onclick='startTest()'>Start/Resume Test</button></div>
									</div>
								</div>
							</center>
							<?php }else if($status==0){
								//if test has started add the script
										$currTime =time()+$offset;
										$timeLeft=($endTime-$currTime);
										if($timeLeft>3600){
											$hr=(int)($timeLeft/(60*60));
											$min=(int)(($timeLeft-($hr*60*60))/60);
											$sec=$timeLeft-($hr*60*60)-($min*60);
										}else if($timeLeft<=3600 && $timeLeft>60){
											$hr=0;
											$min=(int)($timeLeft/60);
											$sec=$timeLeft-($hr*60*60)-($min*60);
										}else{
											$hr=0;
											$min=0;
											$sec=$timeLeft-($hr*60*60)-($min*60);
										}
										if($sec>0)
											$timeLeft=$hr."h ".$min."m ".$sec."s";
										else{
											$timeLeft="00d 00h 00m 00s";
										}
										$startTime = gmdate($dateFormat,$row["start"]);
										$script= '
											<script>
											var countDownDate = new Date("'.$timeNdate.'").getTime();

											// Update the count down every 1 second
											var x = setInterval(function() {

											    // Get todays date and time
											    var now = new Date().getTime();
											    
											    // Find the distance between now and the count down date
											    var distance = countDownDate - now;
											    
											    // Time calculations for days, hours, minutes and seconds
											    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
											    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
											    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
											    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
											    
											    // Output the result in an element with id="demo"
											    document.getElementById("startTime").innerHTML="Test Started at: <i>'.$startTime.'</i>";
											    document.getElementById("time").innerHTML = "<b>"+"Time Left: "+days + "d " + hours + "h "
											    + minutes + "m " + seconds + "s "+"</b>";
											    
											    // If the count down is over, write some text 
											    if (distance < 0) {
											        clearInterval(x);
											        document.getElementById("time").innerHTML = "<b>Time Over!</b>";
											        endTest();
											    }
											}, 1000);
											</script>
										';?>
										<center id="timer">
											<div class="container-fluid" style="width:30%">
												<div class="row">
													<div class="row">

														<h4 id="startTime">Test Starts at: <i style="color:green"><?php echo @gmdate($dateFormat, $row["start"]); ?></i> </h4>
														<h4>Test Ends at: <i style="color:red"><?php echo @$timeNdate; ?></i> </h4>
														
														<h2 id="time"><b>Time Left: 0d <?php echo @$timeLeft; ?></b></h2>
													</div>

													<div class="col-xs-12"><button class="btn btn-danger btn-lg" style="border-radius:0px; margin-bottom:30px" name="stop" onclick='endTest()'>Stop Test</button></div>

												</div>
											</div>
											<i>**Do not close this window.</i>
										</center>
						<?php echo $script;}
				}else{
					$testStatusMsg ="Test Not Active!";
				}
			}
		echo "<center><h2>".@$testStatusMsg."</h2><center>";
	}
?>
<div><?php echo "<center><h2>".@$dbErr."</h2><center>";?></div> 	
</body>
</html>