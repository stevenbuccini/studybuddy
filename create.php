

<!DOCTYPE html>

<html>

	<head>

		<meta charset = "utf-8">

		<title>StudyBuddy Create </title>

		<LINK REL=StyleSheet HREF="bootstrap/css/bootstrap.css" TYPE="text/css" MEDIA=screen>

		<link rel="stylesheet" type="text/css" href="styles.css" MEDIA=screen>

		<script src="jquery.js"></script>

		<script src="bootstrap/js/bootstrap.js"></script>

		<script src="script.js"></script>

	</head>

	<body>

		<div id="wrapper">

			<h1><a href="index.html">StudyBuddy</a><span>|create</span></h1>

			<?php

			$con = mysql_connect("localhost",REDACTED, REDACTED);

			if (!$con)

			  {

			  die('Could not connect: ' . mysql_error());

			  }



			mysql_select_db(REDACTED, $con);



			function cleanInput($input) {

 

				  $search = array(

				    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript

				    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags

				    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly

				    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments

				  );

				 

				    $output = preg_replace($search, '', $input);

				    return $output;

				  }





			function sanitize($input) {

			    if (is_array($input)) {

			        foreach($input as $var=>$val) {

			            $output[$var] = sanitize($val);

			        }

			    }

			    else {

			        if (get_magic_quotes_gpc()) {

			            $input = stripslashes($input);

			        }

			        $input  = cleanInput($input);

			        $output = mysql_real_escape_string($input);

			    }

			    return $output;

			}



			$_POST = sanitize($_POST); 





			if ($_POST['dept'] == NULL or $_POST['course'] == NULL or $_POST['day'] == NULL or $_POST['time'] == NULL or $_POST['name'] == NULL or $_POST['email'] == NULL) {

				//echo "<h2> Please fill out all fields of <a href='create.html'>the form</a>!</h2>";

				echo "<h3> Please fill out all fields!</a> </h3>

				<div id='main' >

				<form action='create.php' method='post'>

				I want to study for 					

				<input id='departments' name='dept' type='text' onblur='cChange();' data-provide='typeahead' data-items='10' data-minLength='1' placeholder='Department' autocomplete='off' value='" . $_POST['dept'] . "''>

					<input id='courses'  name='course' onfocus='cChange();' onclick='cChange();' type='text' data-provide='typeahead' data-items='10' data-minLength='1' placeholder='Course' autocomplete='off' value='" . $_POST['course'] ."''> on 			

					<select name='day'>

						<option value='Monday'>Monday</option>

						<option value='Tuesday'>Tuesday</option>

						<option value='Wednesday'>Wednesday</option>

						<option value='Thursday'>Thursday</option> 

						<option value='Friday'>Friday</option>

						<option value='Saturday'>Saturday</option>

						<option value='Sunday'>Sunday</option>

					</select> 

					<br />

					at <input id='times' type='text' data-provide='typeahead' data-items='5' data-minLength='1' placeholder='Time' name='time' autocomplete='off' value='" . $_POST['time']. "''>

					<select name='ampm' width='wrap-content'>

						<option value='AM'>AM</option>

						<option value='PM'>PM</option>

					</select>

					<br />

					<br />

					First Name: <input type='text' name='name' placeholder='First Name' value='" . $_POST['name'] . "''>    Email: <input type='text' name='email' placeholder='Email' value='" . $_POST['email'] . "''> 

					<br />

					<br />

					<br />

					<input type='submit' value='Create Group' class='btn btn-primary' />

				</form>

				<p> <a href='index.html'> << back to search</a></p>

			</div>";

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





