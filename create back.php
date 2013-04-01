

<!DOCTYPE html>

<html>

	<head>

		<meta charset = "utf-8">

		<title>StudyBuddy Create </title>

		<link rel="stylesheet" type="text/css" href="styles.css">

	</head>

	<body>

		<div id="wrapper">

			<h1><a href="index.html">StudyBuddy</a><span>|create</span></h1>

			<?php

			$con = mysql_connect("localhost", REDACTED,REDACTED);

			if (!$con)

			  {

			  die('Could not connect: ' . mysql_error());

			  }



			mysql_select_db(REDACTED, $con);



			if ($_POST['dept'] == NULL or $_POST['course'] == NULL or $_POST['day'] == NULL or $_POST['time'] == NULL or $_POST['name'] == NULL or $_POST['email'] == NULL) {

				echo "<h2> Please fill out all fields of <a href='create.html'>the form </a>!</h2>";

			} 

			else {

				$sql="INSERT INTO Groups (Dept, Course, Day, Time, AMPM, Names, Emails) VALUES ('$_POST[dept]','$_POST[course]','$_POST[day]', '$_POST[time]', '$_POST[ampm]', '$_POST[name]', '$_POST[email]')";



				if (!mysql_query($sql,$con))

			  	{

			  	die('Error: ' . mysql_error());

			  	}

			echo "<h2> Congratulations, your study group has been created! <a href=\"index.html\"> Back home. </a> </h2>"; }



			mysql_close($con);

			?>

		</div>

	</body>

</html>





