<!DOCTYPE html>

<html>

	<head>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>

		<script type= "text/javascript">function addUser(id) {    var email = prompt("To which email would you like notifications regarding this group be sent?");  $.post("welcome.php", {email: email, id: id}, function(data) {                $('#wrapper').html(data);    });};</script>

		<script src="timeScript.js"></script>

		<title>StudyBuddy Choose</title>

		<LINK REL=StyleSheet HREF="bootstrap/css/bootstrap.css" TYPE="text/css" MEDIA=screen>

		<link rel="stylesheet" type="text/css" href="styles.css">

	</head>

	

	<body>

		<div id="wrapper">

			<h1><a href="index.html">StudyBuddy</a><span>|choose</span></h1>

			<div id = "container main">

				<?php

				$con = mysql_connect("localhost",REDACTED,REDACTED);

				if (!$con)

				{

					die('Could not connect: ' . mysql_error());

				}



				mysql_select_db(REDACTED, $con);



				$result = mysql_query("SELECT * FROM Groups 

					WHERE Dept = '$_POST[dept]' AND Course = '$_POST[course]' ORDER BY

						CASE AMPM WHEN '$_POST[ampm]' THEN 1

								ELSE 2

								END, 

						CASE Time WHEN '$_POST[time]:00' THEN 1

								ELSE 2

								END,

						CASE Day WHEN '$_POST[day]' THEN 1

								ELSE 2

								END

						ASC");

				

				//$result = mysql_query("SELECT * FROM Groups");





				echo "<table id='hor-minimalist-a'>

				<tr>

				<th>Course</th>

				<th>Day</th>

				<th>Time</th>

				</tr>";



				while($row = mysql_fetch_array($result))

				{

					$temp = $row['ID'];

					echo "<tr>";

					echo "<td>" . $row['Dept'] . " " . $row['Course'] . "</td>";

					echo "<td>" . $row['Day'] . "</td>";

					echo "<td id = \"time\">" . $row['Time'] . " " . $row['AMPM'] . "</td>"; 

					echo "<td><a href=\"#myModal\" role=\"button\" class=\"btn\" data-toggle=\"modal\">Launch demo modal</a></td>";

					echo "</tr>";

				}





				echo '</table>

				<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

				  <div class="modal-header">

				    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

				    <h3 id="myModalLabel">Modal header</h3>

				  </div>

				  <div class="modal-body">

				    <form action="welcome.php" >

				    First Name<input type="text" name="fname" />

				    Last Name<input type="text" name="lname" />

				    Email <input type="text" name="email" />

				  </div>

				  <div class="modal-footer">

				    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

				    <input type="submit" class="btn btn-primary" value="Save changes"</input>

				    </form>

				  </div>

				</div>';





				mysql_close($con);

				?> 

				













			</div>

		</div>



	</body>

</html>

