<!DOCTYPE html>
<html>
	<head>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
		<script type= "text/javascript">
			function addUser(id) {
				$("#modalSubmit").click(function() {
						var firstName = $("#first").val();
	 					var lastName = $("#last").val();
	 					var email = $("#email").val();
						$.post("welcome.php", {email: email, firstName:firstName, lastName:lastName, id: id}, function(data) {
						$('#wrapper').html(data);
					});
				});

			};
		</script>
		<script src="timeScript.js"></script>
		<script src="bootstrap/js/bootstrap.js"></script>
		<title>StudyBuddy Choose</title>
		<LINK REL=StyleSheet HREF="bootstrap/css/bootstrap.css" TYPE="text/css" MEDIA=screen>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<div id="wrapper">

			<h1><a href="index.html">StudyBuddy</a><span>|choose</span></h1>
			<div id = "container main">
				<?php
				$con = mysql_connect("localhost","stevenbu_admin","f@cebook");
				if (!$con)
				{
					die('Could not connect: ' . mysql_error());
				}
				mysql_select_db("stevenbu_studybuddy", $con);
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

				if (mysql_num_rows($result) == 0) {
					echo " <h2>No groups to display! Would you like to <a href='create.html'>create one</a>?<h2>";
				}
				else {
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
					echo "<td><form action=\"welcome.php\"><input type=\"button\" href = \"#myModal\" data-toggle=\"modal\" data-target=\"#myModal\" value = \"+ Join\" onclick = \"addUser($temp);\" class=\"btn btn-primary\"'></form></td>";
					echo "</tr>";
				}
			}
				echo "</table>";
				mysql_close($con);
				?>

				<div class="modal hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

					  <div class="modal-header">
					    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					    <h3 id="myModalLabel">Join Group</h3>
					  </div>

					  <div class="modal-body">
					  	Please give some information so your study group can contact you.</br>
					    First Name:&nbsp<input id = "first" type="text"></input></br>
					    Last Name:&nbsp<input id = "last" type="text"></input></br>
					    Email:&nbsp<input id = "email" type="text"></input></br>
					  </div>

					  <div class="modal-footer">
					    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
					    <button id="modalSubmit" data-dismiss="modal" aria-hidden="true" class="btn btn-primary">Submit</button>
					  </div>
				</div>
			</div> <!-- We were missing a div close tag for the "container main" div.  I put it here, but it is this closing tag supposed to go above the "myModal" div? -->

			</div>
		</div>
	</body>
</html>

