<?php

header ("X-XSS-Protection: 0");

// Is there any input?
if( array_key_exists( "name", $_POST ) && $_POST[ 'name' ] != NULL ) {
	// Get input
	$name = str_replace( "<script lang='eng' type='text/javascript'>", '', $_POST[ 'name' ]);
    $name = str_replace( '<script lang="eng" type="text/javascript">', '', $name );
    $name = str_replace( '<script>', '',  $name);
    $name = str_replace( '</script>', '',  $name);
    $name = str_replace( ';', '',  $name);
	$name = str_replace( 'script', '', $name );
	$name = str_replace( 'lang', '',$name );
	$name = str_replace( 'type', '', $name );
	$msg = "I can't find any person with name: ".$name;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Frame-2</title>
	<script type="text/javascript" src="js/f1.js"></script>
</head>
<body>
	<h3 style="text-align: center;color:#FFF;">Tell Me Your Secret Code</h3>
	<form method="POST" action="">
		<input type="text" name="name">
		<input type="submit" name="send">
	</form>
	<p style="color:#10ffe5"><?php echo @$msg; ?></p>
</body>
</html>
