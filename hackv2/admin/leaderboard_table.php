<!DOCTYPE html>
<html>
<head>
	<title>Leaderboard</title>
	<meta charset="utf-8">
	<meta name="language" content="English">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../assets/gbu_logo.png" type="image/gif" sizes="16x16">
	<!-- stylesheets -->
	<link rel="stylesheet" type="text/css" href="../css/admin.css">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script
</head>
<body>
	<?php
		$conn = mysqli_connect("localhost","testAdmin","aA1@admin","hck") or die("cannot connect to the server!");
		$rs=$conn->query("select * from participants order by score DESC");
		if(!$rs){
			die("Unknown Error!");
		}else{
			if(mysqli_num_rows($rs)>0){?>
				<div class="table-responsive">
					<table class="table">
					<thead style="background:#e44c4c;color:white">	
						<tr>
							<td  scope="col">#</td>
							<td  scope="col">Name</td>
							<td  scope="col">Roll No.</td>
							<td  scope="col">L1</td>
							<td  scope="col">L2</td>
							<td  scope="col">L3</td>
							<td  scope="col">L4</td>
							<td  scope="col">L5</td>
							<td  scope="col">L6</td>
							<td  scope="col">L7</td>
							<td scope="col">Score</td>
						</tr>
					</thead>	
					<?php 
					$rank=1;
					while($row=$rs->fetch_assoc()){
						echo '
						<tr>
							<th scope="row">'.$rank.'</th>
							<td>'.$row["name"].'</td>
							<td>'.$row["roll"].'</td>';
							$cleared = str_split($row["cleared"]);
							if(in_array("-", $cleared) && in_array("1", $cleared)){
									// none has started the test
								for($a=0;$a<7;$a++)
								echo '<td>-</td>';
								echo '<td>0</td>';
							}else{
									if(in_array("1", $cleared))
										echo '<td><img src="../assets/done.png" height="15px"></td>';
									else
										echo '<td>-</td>';
									if(in_array("2", $cleared))
										echo '<td><img src="../assets/done.png" height="15px"></td>';
									else
										echo '<td>-</td>';
									if(in_array("3", $cleared))
										echo '<td><img src="../assets/done.png" height="15px"></td>';
									else
										echo '<td>-</td>';
									if(in_array("4", $cleared))
										echo '<td><img src="../assets/done.png" height="15px"></td>';
									else
										echo '<td>-</td>';
									if(in_array("5", $cleared))
										echo '<td><img src="../assets/done.png" height="15px"></td>';
									else
										echo '<td>-</td>';
									if(in_array("6", $cleared))
										echo '<td><img src="../assets/done.png" height="15px"></td>';
									else
										echo '<td>-</td>';
									if(in_array("7", $cleared))
										echo '<td><img src="../assets/done.png" height="15px"></td>';
									else
										echo '<td>-</td>';
									echo'
									<td>'.$row["score"].'
								</tr>	
								';
								$rank++;
							}
					}
					?>
					</table>
				</div>
			<?php
			}else{
				$msg = "No data to display!";
			}
		}
		$conn->close();
	?>	
</div>
</body>
</html>