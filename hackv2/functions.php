<?php
function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }
		
        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(__FUNCTION__, $d);
        }
        else {
            // Return array
            return $d;
        }
    }
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function submissionAllowed(){
	$conn = mysqli_connect("localhost","testUser","aA1@testuser","hck") or die("Something wrong with the database!");
	$sql = "select * from testinfo where id=1";
	$rs = $conn->query($sql);

	if(!$rs)
		die("Some Unknown Error Occured!");
	else{
		$row=$rs->fetch_assoc();
		$conn->close();
		$offset=5.5*60*60;
		$time_now = time()+$offset;
		if($row["status"]==0 && strcmp($row["active"], "yes")==0)
			return true;
		else
			return false;
	}
}

function getScore($id){
	$conn = mysqli_connect("localhost","testUser","aA1@testuser","hck") or die("Something wrong with the database!");
	$sql = "SELECT score FROM participants WHERE id ='".$id."'";
	$rs= $conn->query($sql);
	if(!$rs)
		die("Can't fetch user's data");
	else{
		$row = $rs->fetch_assoc();
		$conn->close();
		return $row["score"];
	}
}
function areLevelCleared($levels){

	 $flag=true;
	 $levels=str_split($levels);
	 $conn = mysqli_connect("localhost","testUser","aA1@testuser","hck") or die("Something wrong with the database!");
	 $sql = "SELECT cleared FROM participants WHERE id ='".$_SESSION["id"]."'";
	 $rs= $conn->query($sql);
	 if(!$rs)
	 	die("Can't fetch user's data");
	 else{
	 	$row = $rs->fetch_assoc();
	 	$conn->close();
	 	$cleared = str_split($row["cleared"]);

	 	foreach ($levels as $l) {
	 		if(!in_array($l, $cleared)){
	 			$flag=false;
	 			break;
	 		}
	 	}
	 	if($flag==true && count($cleared) == count($levels))
	 		$flag=true;
	 	else
	 		$flag=false;

	 	return $flag;
	 }
}
function getCurrLevel($f){
	if($f==false){
		$conn = mysqli_connect("localhost","testUser","aA1@testuser","hck") or die("Something wrong with the database!");
		$sql = "SELECT cleared FROM participants WHERE id ='".$_SESSION["id"]."'";
		$rs= $conn->query($sql);
		if(!$rs)
			die("Can't fetch user's data");
		else{
				$row =$rs->fetch_assoc();
				$cleared = str_split($row["cleared"]);

				if(end($cleared)==1 && $cleared[0] == '-')
					return "acknowledgement";

				return (end($cleared)+1);
		}
	}else
		return false;
}

function calculateScore($time_now){
	//get the id
	$id = $_SESSION["id"];
	
    $conn = mysqli_connect("localhost","testUser","aA1@testuser","hck") or die("Cannot update score");
    $sql = "select score,last_submission from participants where id='".$id."'";
    $rs=$conn->query($sql);

    if(!$rs)
    	die("Could not update records!");
    else{

    	$UTB = 300;$LTB=900;$USB=100;$LSB=30;  //change here to make changes to scoring methodology

    	$row=$rs->fetch_assoc();

    	$last_submission = $row["last_submission"];

    	$timeTaken = $time_now-$last_submission;
    	if($timeTaken <=300)
    		return $USB;
    	else if($timeTaken>300 && $timeTaken <900){
    		$extraTimeTaken = $time_now - ($last_submission+$UTB); 	
    		//$pointsDiff=$UsB-$LsB;
    		//$timeDiff = $UTB-$LTB;
    		$pointsPerSec = 0.115;  // if USB =100 & LSB =30 => 0.115
    		$penalty = $pointsPerSec*$extraTimeTaken;
    		return ($USB-$penalty);
    	}else
    		return $LSB;
    }		
}

function updateScore($s,$clearedLevel){
	//get the id
	$id = $_SESSION["id"];

	$offset=5.5*60*60;
	$time_now = time()+$offset;
	$s = $s + calculateScore($time_now);
	//echo calculateScore($time_now);
    $conn = mysqli_connect("localhost","testAdmin","aA1@admin","hck") or die("Cannot update score");
    $sql = "UPDATE participants SET score='".$s."',cleared='".$clearedLevel."',last_submission='".$time_now."' where id='".$id."'";
    $rs =$conn->query($sql);
    if(!$rs){
    	$conn->close();
    	return false;
    }
    else{
    	$conn->close();
    	return true;
    }
}

?>