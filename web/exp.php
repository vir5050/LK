<?php

function cuint($data)
{
	if($data < 64)
		return strrev(pack("C", $data));
	else if($data < 16384)
		return strrev(pack("S", ($data | 0x8000)));
	else if($data < 536870912)
		return strrev(pack("I", ($data | 0xC0000000)));
	return strrev(pack("c", -32) . pack("I", $data));
}

$GameServer = '127.0.0.1';
$GdeliverydPort = '29100';

if(2 != null)
{
	$rate = 2;
	$rate1 = str_replace("<option value=$rate>", "<option value=$rate selected>", "$rate1");
	$rates = 2;
	$gmroleid=pack("N",-1);
	$localsid=pack("N",-1);
	$attribute = pack("C",-52);
	$value = pack("H*",($rates*10));
	$valuelen = pack("C*",strlen($value));
	$Packet = "\x80\x00\x00\x4F".$gmroleid.$localsid.$attribute.$valuelen.$value;
	$PacketLen = pack("C*",strlen($Packet));
	$sock=socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
	$sock2=socket_connect($sock,$GameServer,$GdeliverydPort);
	socket_set_block($sock);
	$type = cuint(377);
	$data = $type.$PacketLen.$Packet;
	$sbytes=socket_send($sock,$data,8192,0);
	$rbytes=socket_recv($sock,$buf,8192,0);
	socket_set_nonblock($sock);
	socket_close($sock);
	$pac = bin2hex($Packet);
	echo "<script>alert('Рейты на опыт выставленны на х$rates!');</script>";
}
$rate1 = "<select style=width:100px; name=exp>
<option value=0>Выключить</option>
<option value=1>х1</option>
<option value=2>х2</option>
<option value=3>х3</option>
<option value=4>х4</option>
<option value=5>х5</option>
<option value=6>х6</option>
<option value=7>х7</option>
<option value=8>х8</option>
<option value=9>х9</option>
<option value=10>х10</option>
</select>";
if(2 != null){
	$rate = 2;
	$rate1 = str_replace("<option value=$rate>", "<option value=$rate selected>", "$rate1"); }
$BODY = <<<HTML
<center><h2>Выставить рейты на опыт</2h></center>
<form method="post">
<center><table><br>       
Рейты: $rate1<br>
<input type=submit name=submit value=Выставить></b><br>
</table></center></form>$rate1
HTML;
echo $BODY;
?>