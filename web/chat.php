<?PHP
$GameServer = '127.0.0.1';				//ип серва
$GlinkdPort = '29000';					//Link daemon
$GamedbPort = '29400';					//GBD daemon
$GdeliverydPort = '29100';				//delyvery daemon
$GProviderPort = '29300';					//Provider daemon
$GFactionPort = '29500';				//faction daemon
$UniquePort = '29401';					//unamedb daemon
$LogclientPort = '11101';

if(9 != null)
{        
		 $chat = 9;
         $canal = str_replace("<option value=$chat>", "<option value=$chat selected>", "$canal");
         $Chanel1 = pack("C*",$chat);
         $Id1=pack("N*",0,$chat);
         $Emotion = pack("C*",0);
		 $Param = pack("C*",0);
		 $Mesg = 'Голосуй за сервер, и получай подарки в кабинете!';
		 $Message = iconv("UTF-8", "UTF-16LE", $Mesg);
		 $MessageLengh = strlen($Message); 
		if($MessageLengh < 128)
			{
				$MessageLengh = pack("C*", $MessageLengh);
			}
		else
			{
				$MessageLengh = pack("n*", $MessageLengh + 32768);
			}
         $Packet = $Chanel1.$Emotion.$Param.$Id1.$MessageLengh.$Message."\x00\x00";
		 $PacketLen = pack("C*",strlen($Packet));
		 $type = pack("C",120);
		 $sock=socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
		 $sock2=socket_connect($sock,$GameServer,$GProviderPort);
		 socket_set_block($sock);
		 $data = $type.$PacketLen.$Packet;
         $sbytes=socket_send($sock,$data,8192,0);
         $rbytes=socket_recv($sock,$buf,8192,0);  
		 socket_set_nonblock($sock);
		 socket_close($sock);
		 echo "<script>alert('Сообщение с текстом $Mesg успешно отправлено!');</script>";
}
    


?>