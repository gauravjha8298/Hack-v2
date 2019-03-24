<?php
header ("X-XSS-Protection: 0");
if(isset($_POST["send"])){
	$ip=$_POST["name"];
	$msg ="I couldn't find anything like ".$ip;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Frame-1</title>
	<script type="text/javascript" src="js/f1.js"></script>
</head>
<body>
	<h3 style="text-align: center;color:#FFF;">Exploit Me</h3>
	<form method="POST" action="">
		<input type="text" name="name">
		<input type="submit" name="send">
	</form>
	<p style="color:white;"><?php echo @$msg; ?></p>
</body>
</html>