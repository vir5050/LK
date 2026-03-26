<?php

// Данный скрипт писал нубокодер по жизни и у меня были сроки сделать за 3 дня!

//бд настройки крч )

$server         	= "localhost";       //host         
$db_user        	= "root";       //user                             
$user_pass        	= "123456";       //password
$database       	= "myweb"; 		//dbname



 

// пароль продавца в сервисе Digiseller.ru //(Не изменять тут ничего) настройки тут http://gamesbuys.ru/admin.php?settings





/*

milspec синие

restricted фиолетовое

classified розовое

covert красное

rare ножи

*/

 

//Цена продажи товра от и до //(Не изменять тут ничего) ID товара задать тут http://gamesbuys.ru/admin.php?settings



if($priceTMP[0] == ""){$priceTMP[0] = "0";$priceTMP[1] = "1";}

$pricesell = rand($priceTMP[0],$priceTMP[1]);





include ($_SERVER["DOCUMENT_ROOT"].'/ajax/configCases.php');



$db = mysql_connect($server, $db_user, $user_pass);

	mysql_select_db($database, $db) or die("<center>Ошибка mysql.</center>");

	mysql_query("set character_set_results=utf8;",$db);

	mysql_query("set character_set_connection=utf8;",$db);

	mysql_query("set character_set_client=utf8;",$db);

	mysql_query("set character_set_database=utf8;",$db);


	?>