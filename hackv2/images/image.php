<?php
session_start();
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
                else
                    return (end($cleared)+1);
        }
    }else
        return false;
}
function calculateScore($time_now){
	//get the id
	$id = $_SESSION["id"];
	
    $conn = mysqli_connect("localhost","testUser","aA1@testuser","hck") or die("Cannot update score");
    $sql = "select last_submission from participants where id='".$id."'";
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
    $addScore=calculateScore($time_now);
	$s = $s + $addScore;
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

if(isset($_SESSION["id"]) && !empty($_SESSION["id"])){
	function injectSoilder(){
    	$score = getScore($_SESSION["id"]);
        $currLvl = getCurrLevel(false);    
        if($currLvl==7){
                if(updateScore($score,"1234567"))   
                    header("Location: ../end");
                else
                    echo "Can't update score for user with id: ".$_SESSION["id"];
        }else
           header("Location: ../end"); 
    }
}

?>