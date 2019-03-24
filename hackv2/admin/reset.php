 <?php
session_start();
 if(!isset($_SESSION["admin"]) || empty($_SESSION["admin"]))
 	header("Location:index.php");

if(isset($_POST["reset"])){
 $conn = mysqli_connect("localhost","testAdmin","aA1@admin","hck") or die("cannot connect to the database."); 
 $query = "select start from testinfo where id=1";
 $rs = $conn->query($query);
 if(!$rs){
  die("can't get test timings!");
 }else{
  $row= $rs->fetch_assoc();
  $startTime = $row["start"];
  $query = "UPDATE participants SET score='0',cleared='-1',last_submission=".$startTime;
  $rs = $conn->query($query);
  if(!$rs){
   die("can't reset leaderboard!");
  }else{
    $msg ="Leaderboard is back to default!";
  }
 }
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Dashboard - Reset Leaderboard</title>
	<meta charset="utf-8">
	<meta name="language" content="English">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../assets/gbu_logo.png" type="image/gif" sizes="16x16">
	<!-- stylesheets -->
	<link rel="stylesheet" type="text/css" href="../css/admin.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<center id="resetform">
<form action="" method="post">
   <input type="submit" name="reset" value="Reset Leaderboard" class="btn btn-danger"/>
</form>
<br>
<p style="color:green;"><?php echo @$msg ?>
</center>
</body>
</html>