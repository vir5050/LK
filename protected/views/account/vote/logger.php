<?php

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
    <tr><th>DATE</th><th>USER</th><th>EMAIL</th><th>IP</th><th>URI</th></tr>'."\n";

    $userIp    = (isset($_SERVER['REMOTE_ADDR'])     && ($_SERVER['REMOTE_ADDR'] != ""))     ? $_SERVER['REMOTE_ADDR']     : "Unknown";
    $uri       = (isset($_SERVER['REQUEST_URI'])     && ($_SERVER['REQUEST_URI'] != ""))     ? $_SERVER['REQUEST_URI']     : "Unknown";

    $actualTime = date(DATE_FORMAT);

    $logEntry = "[&nbsp;&nbsp;&nbsp;<tr><td>$actualTime</td>&nbsp;&nbsp;&nbsp;<td>$userIp</td>&nbsp;&nbsp;&nbsp;<td>$uri</td>&nbsp;&nbsp;&nbsp;</tr>]<br> \n";

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

