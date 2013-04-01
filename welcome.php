<html>
<head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
</head>
<body>
<body>
    <div id="wrapper">
      <h1><a href="index.html">StudyBuddy</a><span>|choose</span></h1>
<?

//makes sure the email address is valid.
function check_email_address($email) {
  // First, we check that there's one @ symbol, 
  // and that the lengths are right.
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters 
    // in one section or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if
(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
$local_array[$i])) {
      return false;
    }
  }
  // Check if domain is IP. If not, 
  // it should be valid domain name
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if
(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
?([A-Za-z0-9]+))$",
$domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}


$to = "".$_POST["email"];  //grabs email from alert box on previous pagge
$isvalid = check_email_address($to);

if ($isvalid == true){

//connect to server to pull data for autoemailer
$con = mysql_connect("localhost", REDACTED, REDACTED);

if (!$con){

    die('Could not connect: ' . mysql_error()); //displays error if connection fails
    
}

mysql_select_db(REDACTED, $con);

$row_id = $_POST['id'];
$result = mysql_query("SELECT * FROM Groups WHERE ID = '$row_id'");
$row = mysql_fetch_array($result);



$day = $data['Day'];
$time = $data['Time'];

$from = $course_name . "<studybuddy.com>"; //replace with group name (call from database)
$reply = "test@example";  //address of the group listserv
$headers = "" .
           "Reply-To:" . $reply . "\r\n" .
           "From:" . $from . "\r\n".
           "X-Mailer: PHP/" . phpversion();
$headers .= "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
           
$updatedemails = $row['Emails'];
$updatedemails .= ", ".$to;
mysql_query("UPDATE Groups SET Emails = '$updatedemails' WHERE ID = '$row_id'");

//add header image?
$body = "<html><body><p><indent>Hey there, we're so glad you decided to join StudyBuddy!<br><h3>You joined the study group for ".$row['Dept']. " ".$row['Course'].".<br>It meets on ".$row['Day']." at ".$row['Time']."</h3><br>To contact the rest of the members in your group, email them at ".$row['Emails'].". If you no longer wish to be a part of this group, email the group with 'Unsubscribe' in the header. <br><br>Lots of love,<br>The Study Buddy Team<br>(Arjun Rao, Tim Hyon, and Steven Buccini)</p></body></html>";
/*First parameter will need to be replaced with a string with all the email address in the group.
1 - Call emails from mySQL database
2 - for loop through list, 

*/
           
mail($to, "You've joined a StudyBuddy group!", $body, $headers);
mail($row['Emails'], "A new member has joined your study group!", "A new member has joined your " .$row['Dept']. " ".$row['Course']. " study group! Their email address is " . $to . ".", $headers);


echo "<h2>Thanks for joining!  There are lot more study groups; why don't you see <a href=\"index.html\">what else is out there </a>?</h2>";

}



else
{
    echo "<h2>Sorry, the email you entered was incorrect, please try again</h2>";
}


?>



</div>
</body>
</html>