<?php
session_start();
?>
<html>
<head>
<title>Vote!</title>
<?
if($_SESSION['name']){
echo '<meta http-equiv="REFRESH" content="5;url=http://voteurl" target="_parent">';
}
?>
</head>
<body>
<center>Vote!<br>
Login successful.<br />
Please wait whilst we direct you to the vote page.<br />
Thankyou for supporting our server.
</body>
</html>