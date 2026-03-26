<?php
include 'inc/config.inc.php';
include 'inc/func.inc.php';
$valid= true;
$timeleft = 0;
checkLog($vis_ip,$ipLog,$timeout);
?>
<html>
<head>
<title>Vote!</title>
</head>
<body>
<br /><br />
<center>Vote!<br></center>
<?php
	if(!$valid) {
?>
You can vote once every 12 hours.<br /><br /> Try again in <?php echo $timeleft ?>
<?php
	}else{
?>
<form name="form1" method="post" action="checklogin.php">
Username:<br />
<input name="name" type="text" id="name"><br />
Email:<br />
<input name="email" type="text" id="email"><br />
<input type="submit" name="Submit" value="Vote">
</form>
<?php
	}
?>
</body>
</html>