<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	Wishlist of <?php echo htmlentities($_GET['user']) . "<br>"; ?>
	<?php 
		$con = mysqli_connect('localhost', 'root', 'root');
		if(!$con) {
			exit ('Connect Error (' . mysqli_connect_errno() . ')' . mysqli_connect_error());
		}
		mysqli_set_charset($con, 'utf-8');
		mysqli_select_db($con, 'site');
		$user = mysqli_real_escape_string($con, htmlentities($_GET["user"]));
		$wisher = mysqli_query($con, "SELECT id FROM wishers WHERE name='" . $user . "'");
		if (mysqli_num_rows($wisher) < 1) {
		    exit("The person " . htmlentities($_GET["user"]) . " is not found. Please check the spelling and try again");
		}
		$row = mysqli_fetch_row($wisher);
		$wisherID = $row[0];
		mysqli_free_result($wisher);
	 ?>
	 <table border="black">
	 	<tr>
	 		<th>
	 			Item
	 		</th>
	 		<th>
	 			Due Date
	 		</th>
	 	</tr>
	 	<?php
		    $result = mysqli_query($con, "SELECT `description`, `due_date` FROM `wishes` WHERE `wishers_id`=" . $wisherID);
		    while ($row = mysqli_fetch_array($result)) {
		        echo "<tr><td>" . htmlentities($row["description"]) . "</td>";
		        echo "<td>" . htmlentities($row["due_date"]) . "</td></tr>\n";
		    }
		    mysqli_free_result($result);
		    mysqli_close($con);
		?>
	 </table>
</body>
</html>