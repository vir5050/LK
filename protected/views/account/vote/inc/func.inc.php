<?php
//Please do not edit anything in this file unless you know exactly what you're doing.

//parsed global vars;
$register_globals = (bool) ini_get('register_gobals');
if ($register_globals) $vis_ip = getenv(REMOTE_ADDR); else $vis_ip = $_SERVER['REMOTE_ADDR'];

// Functions
function checkLog($vis_ip,$ipLog,$timeout) 
{
    global $valid;
	global $timeleft;
	$ip=$vis_ip;
    $data=file("$ipLog"); $now=time();
	
	$valid = true;

    foreach ($data as $record) 
    {
        $subdata=explode("][",$record);
        if ($now < ($subdata[1]+3600*$timeout) && $ip == $subdata[0]) 
        {
            $valid=0; 
			$timeleft = parseTime(3600*$timeout - ($now - $subdata[1] ) );
            break;
        }
    }
} 

function recordData($vis_ip,$ipLog,$goHere)
{ 
    $log=fopen("$ipLog", "a+"); 
    fputs ($log,$vis_ip."][".time()."\n"); 
    fclose($log); 
 } 

function parseTime($t) {
	$mn = ceil($t/60)%60;
	$hr = ($t/3600);
	$ts = (floor($hr)? floor($hr). ' hour'.(floor($hr)>1?'s':'').($mn>0? ' and '.$mn. ' minute'.(ceil($mn)>1?'s':'').'.':'.'): $mn. ' minutes.');
	return $ts ;
}

?>