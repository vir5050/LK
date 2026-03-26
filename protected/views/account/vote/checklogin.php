<?php
ob_start();
session_start();
include 'inc/config.inc.php';
include 'inc/func.inc.php';

// Connect to server and select databse.
$Link = MySQL_Connect($DBHost, $DBUser, $DBPassword) or die ("Can't connect to MySQL");
MySQL_Select_Db($DBName, $Link) or die ("Database ".$DBName." dosent exist.");


// Define $myusername and $mypassword
$Name=$_POST['name'];
$Email=$_POST['email'];

// To protect MySQL injection (more detail about MySQL injection)
$Name = stripslashes($Name);
$Email = stripslashes($Email);
$Name = mysql_real_escape_string($Name);
$Email = mysql_real_escape_string($Email);

$Result = mysql_query("SELECT * FROM users WHERE name='$Name' and email='$Email'");

$count=mysql_num_rows($Result);
if($count==1)
{
	//add record data in the ipLog file
	recordData($vis_ip,$ipLog,$goHere); 

	$row2 = mysql_fetch_array( $Result );		
	$ID = $row2['ID'];
	$TIME = $row2['creatime'];
	MySQL_Query("INSERT INTO usecashnow (userid, zoneid, sn, aid, point, cash, status, creatime) VALUES ($ID, 1, -1, 1, 0, 10000, 0, '$TIME')");
	$_SESSION['name'] = $row2[name];
	$_SESSION['email'] = $row2[email];

	header("location:login_success.php");
}
else {
?>
<html>
<head>
<title>Vote!</title>
</head>
<body>
<center>
Incorrect username or email.
<br />
<a href="index.php">Try again?</a>
</center>
</body>
</html>
<?php
}
ob_end_flush();

    define("DATE_FORMAT","d.m.Y - H : i : s");
    define("LOG_FILE","log.html");

    $logfileHeader='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html>
<head>
   <title>Visitors log</title>
   <link href="style/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <table cellpadding="0" cellspacing="1">
    <tr><th>DATE</th><th>NAME</th><th>EMAIL</th><th>IP</th></tr>'."\n";

    $userIp    = (isset($_SERVER['REMOTE_ADDR'])     && ($_SERVER['REMOTE_ADDR'] != ""))     ? $_SERVER['REMOTE_ADDR']     : "Unknown";
    $actualTime = date(DATE_FORMAT);
    $logEntry = "<b>[&nbsp;&nbsp;&nbsp;<tr><td>$actualTime</td>&nbsp;&nbsp;&nbsp;<td>$Name</td>&nbsp;&nbsp;&nbsp;<td>$Email</td>&nbsp;&nbsp;&nbsp;<td>$userIp</td>&nbsp;&nbsp;&nbsp;</tr>]</b><br> \n";


    if (!file_exists(LOG_FILE)) {
        $logFile = fopen(LOG_FILE,"w");
        fwrite($logFile, $logfileHeader);
    }
    else {
        $logFile = fopen(LOG_FILE,"a");
    }

    fwrite($logFile,$logEntry);
    fclose($logFile);


?>