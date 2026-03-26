<?php echo $actionMessage ?>
<?php 

include_once($_SERVER["DOCUMENT_ROOT"].'/config.php');
if(isset($_POST['token']) || trim($_COOKIE["token"]) !== ""){


if(!isset($_POST["token"])){
$token = $_COOKIE["token"];

include "config.php";
$users_shop = mysql_query("SELECT * FROM `mw_users` WHERE `username`='$token'",$db);
$users_shop_arr = mysql_fetch_assoc($users_shop);
$token_count = mysql_num_rows($users_shop);
$users_shop_count = mysql_num_rows($users_shop);

$trade_url = $users_shop_arr["trade_url"];
$user = $users_shop_arr;
}else{
	
include "config.php";
$uid = $user["uid"];
$users_shop = mysql_query("SELECT * FROM `mw_users` WHERE `id`='$uid'",$db);
$users_shop_count = mysql_num_rows($users_shop);
$users_shop_arr = mysql_fetch_assoc($users_shop);
$trade_url = $users_shop_arr["trade_url"];
$token_count = 1;
 
			$user = $users_shop_arr;


			
}
} 



if($token_count == "1"){ 
$coinsbalance = $users_shop_arr["coins"];

}

?>



<!--

	<link href="./css/style.css" rel="stylesheet">

	<link href="./css/bootstrap.min.css" rel="stylesheet">

	<link href="./css/styles.css" rel="stylesheet">
	
	<link href="./css/jquery.arcticmodal-0.3.css" rel="stylesheet" media="screen">
	
	<link href="//fonts.googleapis.com/css?family=Roboto:400,300,500,700&amp;subset=latin,cyrillic" rel="stylesheet" type="text/css">
	<link href="//fonts.googleapis.com/css?family=Ubuntu&amp;subset=latin,cyrillic" rel="stylesheet" type="text/css">
	

	
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script> 
	<script type="text/javascript" src="//vk.com/js/api/share.js?90"></script>
	<script type="text/javascript" src="http://cdn.socket.io/socket.io-1.3.4.js"></script> 
	<script src="/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/js/jquery.arcticmodal-0.3.min.js"></script>
	<script type="text/javascript">
		if (!navigator.cookieEnabled) {
  		alert('Включите cookie для комфортной работы с этим сайтом');
		}

	</script>
	<script type="text/javascript" src="/js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="/js/cases.js"></script>
	<script type="text/javascript" src="/js/server.js"></script>

-->








<br />
<div class="cp-center flex-sbs">
<div class="half-block">
<div class="cp-user-information">
<div class="cp-block-title">Информация</div>
<div class="line"><span>Ваш логин:</span> <?php echo CAuth::getLoggedName(); ?></div>
<div class="line"><span>Ваш e-mail:</span> <?php echo CAuth::getLoggedEmail(); ?></div>
<div class="line balance"><span>Баланс:</span> 0 Монет</div>

<div class="line"><a href="account/paymentsactivity/system/freekassa">Посмотреть историю пополнений</a></div>
</div>
</div>

<div class="half-block" style="width: 60%;">
<div class="cp-login-history">
<div class="cp-block-title">Акции сервера</div>

<div class="cp-table">
<div class="tr"><div class="td" data-label="Акция:">Сейчас нет не каких мероприятей</div><div class="td">    </div><div class="td" data-label="Время:">
<i class="fa fa-clock-o" aria-hidden="true"></i>          </div></div> 
</div>
<!--
<div class="item-wrapper" style="margin-top: 0px;" >
	<div class="item" data-key="Operation Phoenix" data-price="<?php echo $case["Operation Phoenix"]["price"];?>" style="opacity: 1; cursor: pointer;min-height: 250px;position: relative;display: block;width: 538px;height: 52px;">
		<div class="desc">
			<div class="name">
				Cлучайный предмет<br>
				<span>Operation Phoenix</span>
			</div>
		</div> 
		
		<div class="img-wrapper">
			<a class="item-link">
				<img src="./css/chroma_case.png" width="189px" class="itemsimg" >
			</a>
		</div>
		<img src="./css/stand.png" class="stand" >
		<div class="cost" style="margin-top: -5px;margin-left: -5px;font-size: 20px;">
			<img src="./css/money.png" > <?php echo $case["Operation Phoenix"]["price"];?> рублей
		</div>
		<div class="buyb" style="margin-top: -5px;margin-left: -5px;font-size: 20px;">
			<img src="./css/ook.png" style="margin-top: -3px;" > Открыть
		</div>
	</div>
</div>-->


</div>
</div>
</div>

<style>
.cp-content > .cp-center {
    width: 100%;
    padding: 0px 30px;
}
.flex-sbs {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: flex-start;
}
.cp-content > .cp-center > .half-block {
    width: calc( 50% - 15px );
}
.cp-user-information {
    width: 100%;
    margin-bottom: 15px;
    padding-bottom: 28px;

}
.cp-block-title {
    width: 100%;
    padding-bottom: 20px;
    font-family: Beaufort Bold;
    text-transform: uppercase;
    font-size: 20px;
    color: 
    #562200;
    text-align: center;
}

.cp-user-information > .line {
    width: 100%;
    font-size: 16px;
    color: 
    #634934;
    margin-bottom: 10px;
}
.cp-user-information > .line.balance {
    font-family: Roboto Bold;
    color: 
    #ff7f00;
}
.cp-character-list {
    width: 100%;
}
.cp-content > .cp-center > :last-child {
    padding-bottom: 0px !important;
}
.cp-content > .cp-center > .half-block {
    width: calc( 50% - 15px );

}
.cp-login-history {
    width: 100%;
}
.cp-table {
    width: 100%;
}
.cp-table > .tr {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    position: relative;
    padding: 10px 15px;
    background: #eeeeee;
    border-radius: 20px;
    margin-top: 4px;
}

</style>



<!--
<div style="display: none;" style="-webkit-box-sizing: border-box;">

<div id="itemmodal" class="itemmodal" style="-webkit-box-sizing: border-box;">

	<div class="box-modal_close arcticmodal-close" style="-webkit-box-sizing: border-box;"></div>
	
	<div id="scrollerContainer" style="-webkit-box-sizing: border-box;">
		<div id="caruselLine" style="-webkit-box-sizing: border-box;"></div>
		<div id="caruselOver" style="-webkit-box-sizing: border-box;"></div>
		<div id="aCanvas" style="-webkit-box-sizing: border-box;">
			<div id="casesCarusel" style="margin-left: 0px;"><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52JLSKMyJYfxSVTKNRUfg7-gzpGxg-4cBrQOi69qkBLBLtsoKSMOYuN95JTMjTDPGDM1ipuxg90fMJKcDfpCvn2ni4OD0IWxvi5CtazxCLTIoO/125fx125f"><div class="weaponblockinfo"><span>MP7<br>Городская опасность</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz55Pfm6PghkZzvACLpRUrg15wH-ADQN5M5kXMOJ-7oULlnxtoTPZrAvZdkdS8XZUqSBYFipuEMwhKZdK8aN9i7niSrrPzxfCRa9qXVExrECS2z-2w/125fx125f"><div class="weaponblockinfo"><span>ПП-19 Бизон<br>Осирис</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz55Pfm6PghkZzvACLpRUrg15wH-ADQN5M5kXMOJ-7oULlnxtoTPZrAvZdkdS8XZUqSBYFipuEMwhKZdK8aN9i7niSrrPzxfCRa9qXVExrECS2z-2w/125fx125f"><div class="weaponblockinfo"><span>ПП-19 Бизон<br>Осирис</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51O_W0DzRyTQrNF6FhV_ozywTlDi8m18tiRtCzueleKg-54YLFZbcvNopIF5SFD_eGMwio4kNth6YMfJWLoSntiX67a2gUG028humfMw0/125fx125f"><div class="weaponblockinfo"><span>Nova<br>Карп кои</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz59PfWwIzJxdwr9ALFhCaIF8g3tHS83-tRcWN6x_685JV2t49fYYuElNNoaHciEX6DSbg_17E870qRZfcSJ8ynu2irpOToCCRXq_2wBnPjH5OWhSCyC7g/125fx125f"><div class="weaponblockinfo"><span>Five-SeveN<br>Птичьи игры</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51MeSwJghkZzvMBKdbSsou_RztBzQm59Vua9u_8LMSFlC-9tWTLeV-N4odS5PXX6PVNFv8uE9r1PdeKsff8i_s3SXhPW0LCUG--2pXyuaZ-uw8UAQJFkg/125fx125f"><div class="weaponblockinfo"><span>Negev<br>Пустынная атака</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz59PfWwIzJxdwr9ALFhCaIF8g3tHS83-tRcWN6x_685JV2t49fYYuElNNoaHciEX6DSbg_17E870qRZfcSJ8ynu2irpOToCCRXq_2wBnPjH5OWhSCyC7g/125fx125f"><div class="weaponblockinfo"><span>Five-SeveN<br>Птичьи игры</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz54LrTgMQhkZzvBVvVfEeEz8w3-Nis77893a9u35bwDZ17osYaUNuErM4tEScKCWPaBbw3_vxk4hKcIecHb9C68jHm8OmoPWhD1ujVToYhPwzE/125fx125f"><div class="weaponblockinfo"><span>CZ75-Auto<br>Тигр</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5uOfPhZQhvazvOCK5bT8o15gniDiIN5M5kXMOJ-7oULlnx4ILGN-V9M9BFHcPWD_DQNwypu0lugKRYKsTbpXjs2i_qaDpcWBW_-3VExrHui8poXg/125fx125f"><div class="weaponblockinfo"><span>UMP-45<br>Лабиринт</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5_MeKyPDJYcRH9BaVfW_k_ywn5GyIn-_hvXdC-44QKKE644ZzBZeErNthJGJOCWvPQZFqsuEM6ifMIK5GB9ivt3Xy8P2oKXBLurmtRhqbZ7Tllk6hd/125fx125f"><div class="weaponblockinfo"><span>Desert Eagle<br>Заговор</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52JLSKMyJYfxSVTKNRUfg7-gzpGxg-4cBrQOi69qkBLBLtsoKSMOYuN95JTMjTDPGDM1ipuxg90fMJKcDfpCvn2ni4OD0IWxvi5CtazxCLTIoO/125fx125f"><div class="weaponblockinfo"><span>MP7<br>Городская опасность</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51O_W0DzRyTQrNF6FhV_ozywTlDi8m18tiRtCzueleKg-54YLFZbcvNopIF5SFD_eGMwio4kNth6YMfJWLoSntiX67a2gUG028humfMw0/125fx125f"><div class="weaponblockinfo"><span>Nova<br>Карп кои</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5zP_PnYGc3TQfXPrAMDKVqywH6BjUr18tqU9-iyLcHO1u6qoCXN7d-MdweGsmDD_GPYAD47EI9iPIILpba8izv2yzuO2oCDRTs-2oa2LjQxpZttMo/125fx125f"><div class="weaponblockinfo"><span>P2000<br>Слоновая кость</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSFlC-9tWTLbEpMY1FGsSFDvLXM1__4hhr06RYe5Xa8S692S64PToDXRfvrGgCybWZ-uw8dna1jag/125fx125f"><div class="weaponblockinfo"><span>Glock-18<br>Водяной</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51MeSwJghkZzvMBKdbSsou_RztBzQm59Vua9u_8LMSFlC-9tWTLeV-N4odS5PXX6PVNFv8uE9r1PdeKsff8i_s3SXhPW0LCUG--2pXyuaZ-uw8UAQJFkg/125fx125f"><div class="weaponblockinfo"><span>Negev<br>Пустынная атака</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5_MeKyPDJYcRH9BaVfW_k_ywn5GyIn-_hvXdC-44QKKE644ZzBZeErNthJGJOCWvPQZFqsuEM6ifMIK5GB9ivt3Xy8P2oKXBLurmtRhqbZ7Tllk6hd/125fx125f"><div class="weaponblockinfo"><span>Desert Eagle<br>Заговор</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5oJ-TlaAhmYzvOBLZXXeEy9QbTBS414NNcWNak8L5IeVjv59fCMbV-NdtLG8bUWKKGMgiruB1sgPJdesaPoy66jyXsPW5cCQ2rpDx0zn4ssg/125fx125f"><div class="weaponblockinfo"><span>SSG 08<br>Пучина</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rZrblDzRyTQbLFbRbTuYt8Q34Nis77893a9u35bwDZwTs59bCO7kqOIxLFsTRWKOGNV__6Eg70qkILp2PoCi5iy_uM25bDxf1ujVTlZEMO3Y/125fx125f"><div class="weaponblockinfo"><span>P250<br>Сверхновая</span></div></div><div class="weaponblock weaponblock2 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52YOLkDyRufgHMAqVMY_YvywW4CHYh18R6RtKuyLcPLlSr296Xced5LtlIG5LUWvOFM1v66Rk80aVaeZ2IoiK6j3_pb2YKU0fjr2kMzuPVs-F1wjFBLhxWp7I/125fx125f"><div class="weaponblockinfo"><span>M4A1-S<br>Сайрекс</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52JLSKMyJYfxSVTKNRUfg7-gzpGxg-4cBrQOi69qkBLBLtsoKSMOYuN95JTMjTDPGDM1ipuxg90fMJKcDfpCvn2ni4OD0IWxvi5CtazxCLTIoO/125fx125f"><div class="weaponblockinfo"><span>MP7<br>Городская опасность</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5_MeKyPDJYcRH9BaVfW_k_ywn5GyIn-_hvXdC-44QKKE644ZzBZeErNthJGJOCWvPQZFqsuEM6ifMIK5GB9ivt3Xy8P2oKXBLurmtRhqbZ7Tllk6hd/125fx125f"><div class="weaponblockinfo"><span>Desert Eagle<br>Заговор</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSFlC-9tWTLbEpMY1FGsSFDvLXM1__4hhr06RYe5Xa8S692S64PToDXRfvrGgCybWZ-uw8dna1jag/125fx125f"><div class="weaponblockinfo"><span>Glock-18<br>Водяной</span></div></div><div class="weaponblock weaponblock2 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9RnTBi4-7cNcWdKy_q4LFlC-9tWTLbAvYdkfFpSFDv-GZQz14kM4hvVUfcHfoCu61C3qOGhYDRHpqzpSkLCZ-uw8KMc6tY0/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Поверхностная закалка</span></div></div><div class="weaponblock weaponblock2 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9QnTDyY27fhvXdC-44QKKE644ZyUMuF-NY4eHJWEWv6Hbgys6E0-g6JZfZONqCK-3ivtaDwJDRHp-j0MhqbZ7VLOXRkn/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Градиент</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51MeSwJghkZzvMBKdbSsou_RztBzQm59Vua9u_8LMSFlC-9tWTLeV-N4odS5PXX6PVNFv8uE9r1PdeKsff8i_s3SXhPW0LCUG--2pXyuaZ-uw8UAQJFkg/125fx125f"><div class="weaponblockinfo"><span>Negev<br>Пустынная атака</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52JLSKMyJYfxSVTKNRUfg7-gzpGxg-4cBrQOi69qkBLBLtsoKSMOYuN95JTMjTDPGDM1ipuxg90fMJKcDfpCvn2ni4OD0IWxvi5CtazxCLTIoO/125fx125f"><div class="weaponblockinfo"><span>MP7<br>Городская опасность</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz54LrTgMQhkZzvBVvVfEeEz8w3-Nis77893a9u35bwDZ17osYaUNuErM4tEScKCWPaBbw3_vxk4hKcIecHb9C68jHm8OmoPWhD1ujVToYhPwzE/125fx125f"><div class="weaponblockinfo"><span>CZ75-Auto<br>Тигр</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5oJ-TlaAhmYzvOBLZXXeEy9QbTBS414NNcWNak8L5IeVjv59fCMbV-NdtLG8bUWKKGMgiruB1sgPJdesaPoy66jyXsPW5cCQ2rpDx0zn4ssg/125fx125f"><div class="weaponblockinfo"><span>SSG 08<br>Пучина</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5uOfPhZQhvazvOCK5bT8o15gniDiIN5M5kXMOJ-7oULlnx4ILGN-V9M9BFHcPWD_DQNwypu0lugKRYKsTbpXjs2i_qaDpcWBW_-3VExrHui8poXg/125fx125f"><div class="weaponblockinfo"><span>UMP-45<br>Лабиринт</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rZrblDzRyTQbLFbRbTuYt8Q34Nis77893a9u35bwDZwTs59bCO7kqOIxLFsTRWKOGNV__6Eg70qkILp2PoCi5iy_uM25bDxf1ujVTlZEMO3Y/125fx125f"><div class="weaponblockinfo"><span>P250<br>Сверхновая</span></div></div><div class="weaponblock weaponblock2 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rbbOKMyJYYl2STKFNVfw3-x7TBS414NNcWNak8L5IeV--s9TBZeMsM9ofFsiDX6XVYwn7uRhs1ahffZaK9S_n3iu4Mj8CUw2rpDw1YXWUJg/125fx125f"><div class="weaponblockinfo"><span>P90<br>Азимов</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52JLSKMyJYfxSVTKNRUfg7-gzpGxg-4cBrQOi69qkBLBLtsoKSMOYuN95JTMjTDPGDM1ipuxg90fMJKcDfpCvn2ni4OD0IWxvi5CtazxCLTIoO/125fx125f"><div class="weaponblockinfo"><span>MP7<br>Городская опасность</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz55Pfm6PghkZzvACLpRUrg15wH-ADQN5M5kXMOJ-7oULlnxtoTPZrAvZdkdS8XZUqSBYFipuEMwhKZdK8aN9i7niSrrPzxfCRa9qXVExrECS2z-2w/125fx125f"><div class="weaponblockinfo"><span>ПП-19 Бизон<br>Осирис</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5zP_PnYGc3TQfXPrAMDKVqywH6BjUr18tqU9-iyLcHO1u6qoCXN7d-MdweGsmDD_GPYAD47EI9iPIILpba8izv2yzuO2oCDRTs-2oa2LjQxpZttMo/125fx125f"><div class="weaponblockinfo"><span>P2000<br>Слоновая кость</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51MeSwJghkZzvMBKdbSsou_RztBzQm59Vua9u_8LMSFlC-9tWTLeV-N4odS5PXX6PVNFv8uE9r1PdeKsff8i_s3SXhPW0LCUG--2pXyuaZ-uw8UAQJFkg/125fx125f"><div class="weaponblockinfo"><span>Negev<br>Пустынная атака</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz54LrTgMQhkZzvBVvVfEeEz8w3-Nis77893a9u35bwDZ17osYaUNuErM4tEScKCWPaBbw3_vxk4hKcIecHb9C68jHm8OmoPWhD1ujVToYhPwzE/125fx125f"><div class="weaponblockinfo"><span>CZ75-Auto<br>Тигр</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5zP_PnYGc3TQfXPrAMDKVqywH6BjUr18tqU9-iyLcHO1u6qoCXN7d-MdweGsmDD_GPYAD47EI9iPIILpba8izv2yzuO2oCDRTs-2oa2LjQxpZttMo/125fx125f"><div class="weaponblockinfo"><span>P2000<br>Слоновая кость</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz59PfWwIzJxdwr9ALFhCaIF8g3tHS83-tRcWN6x_685JV2t49fYYuElNNoaHciEX6DSbg_17E870qRZfcSJ8ynu2irpOToCCRXq_2wBnPjH5OWhSCyC7g/125fx125f"><div class="weaponblockinfo"><span>Five-SeveN<br>Птичьи игры</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5uOfPhZQhvazvOCK5bT8o15gniDiIN5M5kXMOJ-7oULlnx4ILGN-V9M9BFHcPWD_DQNwypu0lugKRYKsTbpXjs2i_qaDpcWBW_-3VExrHui8poXg/125fx125f"><div class="weaponblockinfo"><span>UMP-45<br>Лабиринт</span></div></div><div class="weaponblock weaponblock2 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9RnTDygg68Jna9u_8LMSFlC-9tWTLbF5NdpOGsmGUqTSYFv-uUk8gvIIe8eL9Cq-1Srgb2dcCBLsqGxVmuWZ-uw8pT4tNB0/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Патина</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz59PfWwIzJxdwr9ALFhCaIF8g3tHS83-tRcWN6x_685JV2t49fYYuElNNoaHciEX6DSbg_17E870qRZfcSJ8ynu2irpOToCCRXq_2wBnPjH5OWhSCyC7g/125fx125f"><div class="weaponblockinfo"><span>Five-SeveN<br>Птичьи игры</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz54LrTgMQhkZzvBVvVfEeEz8w3-Nis77893a9u35bwDZ17osYaUNuErM4tEScKCWPaBbw3_vxk4hKcIecHb9C68jHm8OmoPWhD1ujVToYhPwzE/125fx125f"><div class="weaponblockinfo"><span>CZ75-Auto<br>Тигр</span></div></div><div class="weaponblock weaponblock2 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9RnTBi4-7cNcWdKy_q4LFlC-9tWTLbAvYdkfFpSFDv-GZQz14kM4hvVUfcHfoCu61C3qOGhYDRHpqzpSkLCZ-uw8KMc6tY0/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Поверхностная закалка</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSFlC-9tWTLbEpMY1FGsSFDvLXM1__4hhr06RYe5Xa8S692S64PToDXRfvrGgCybWZ-uw8dna1jag/125fx125f"><div class="weaponblockinfo"><span>Glock-18<br>Водяной</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rZrblDzRyTQbLFbRbTuYt8Q34Nis77893a9u35bwDZwTs59bCO7kqOIxLFsTRWKOGNV__6Eg70qkILp2PoCi5iy_uM25bDxf1ujVTlZEMO3Y/125fx125f"><div class="weaponblockinfo"><span>P250<br>Сверхновая</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5zP_PnYGc3TQfXPrAMDKVqywH6BjUr18tqU9-iyLcHO1u6qoCXN7d-MdweGsmDD_GPYAD47EI9iPIILpba8izv2yzuO2oCDRTs-2oa2LjQxpZttMo/125fx125f"><div class="weaponblockinfo"><span>P2000<br>Слоновая кость</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSFlC-9tWTLbEpMY1FGsSFDvLXM1__4hhr06RYe5Xa8S692S64PToDXRfvrGgCybWZ-uw8dna1jag/125fx125f"><div class="weaponblockinfo"><span>Glock-18<br>Водяной</span></div></div><div class="weaponblock weaponblock2 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9RnTDygg68Jna9u_8LMSFlC-9tWTLbF5NdpOGsmGUqTSYFv-uUk8gvIIe8eL9Cq-1Srgb2dcCBLsqGxVmuWZ-uw8pT4tNB0/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Патина</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rZrblDzRyTQbLFbRbTuYt8Q34Nis77893a9u35bwDZwTs59bCO7kqOIxLFsTRWKOGNV__6Eg70qkILp2PoCi5iy_uM25bDxf1ujVTlZEMO3Y/125fx125f"><div class="weaponblockinfo"><span>P250<br>Сверхновая</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51O_W0DzRyTQrNF6FhV_ozywTlDi8m18tiRtCzueleKg-54YLFZbcvNopIF5SFD_eGMwio4kNth6YMfJWLoSntiX67a2gUG028humfMw0/125fx125f"><div class="weaponblockinfo"><span>Nova<br>Карп кои</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5oJ-TlaAhmYzvOBLZXXeEy9QbTBS414NNcWNak8L5IeVjv59fCMbV-NdtLG8bUWKKGMgiruB1sgPJdesaPoy66jyXsPW5cCQ2rpDx0zn4ssg/125fx125f"><div class="weaponblockinfo"><span>SSG 08<br>Пучина</span></div></div><div class="weaponblock weaponblock2 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52YOLkDyRufgHMAqVMY_YvywW4CHYh18R6RtKuyLcPLlSr296Xced5LtlIG5LUWvOFM1v66Rk80aVaeZ2IoiK6j3_pb2YKU0fjr2kMzuPVs-F1wjFBLhxWp7I/125fx125f"><div class="weaponblockinfo"><span>M4A1-S<br>Сайрекс</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5uOfPhZQhvazvOCK5bT8o15gniDiIN5M5kXMOJ-7oULlnx4ILGN-V9M9BFHcPWD_DQNwypu0lugKRYKsTbpXjs2i_qaDpcWBW_-3VExrHui8poXg/125fx125f"><div class="weaponblockinfo"><span>UMP-45<br>Лабиринт</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz54LrTgMQhkZzvBVvVfEeEz8w3-Nis77893a9u35bwDZ17osYaUNuErM4tEScKCWPaBbw3_vxk4hKcIecHb9C68jHm8OmoPWhD1ujVToYhPwzE/125fx125f"><div class="weaponblockinfo"><span>CZ75-Auto<br>Тигр</span></div></div><div class="weaponblock weaponblock2 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rbbOKMyJYYl2STKFNVfw3-x7TBS414NNcWNak8L5IeV--s9TBZeMsM9ofFsiDX6XVYwn7uRhs1ahffZaK9S_n3iu4Mj8CUw2rpDw1YXWUJg/125fx125f"><div class="weaponblockinfo"><span>P90<br>Азимов</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51O_W0DzRyTQrNF6FhV_ozywTlDi8m18tiRtCzueleKg-54YLFZbcvNopIF5SFD_eGMwio4kNth6YMfJWLoSntiX67a2gUG028humfMw0/125fx125f"><div class="weaponblockinfo"><span>Nova<br>Карп кои</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5oJ-TlaAhmYzvOBLZXXeEy9QbTBS414NNcWNak8L5IeVjv59fCMbV-NdtLG8bUWKKGMgiruB1sgPJdesaPoy66jyXsPW5cCQ2rpDx0zn4ssg/125fx125f"><div class="weaponblockinfo"><span>SSG 08<br>Пучина</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5zP_PnYGc3TQfXPrAMDKVqywH6BjUr18tqU9-iyLcHO1u6qoCXN7d-MdweGsmDD_GPYAD47EI9iPIILpba8izv2yzuO2oCDRTs-2oa2LjQxpZttMo/125fx125f"><div class="weaponblockinfo"><span>P2000<br>Слоновая кость</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51O_W0DzRyTQrNF6FhV_ozywTlDi8m18tiRtCzueleKg-54YLFZbcvNopIF5SFD_eGMwio4kNth6YMfJWLoSntiX67a2gUG028humfMw0/125fx125f"><div class="weaponblockinfo"><span>Nova<br>Карп кои</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz55Pfm6PghkZzvACLpRUrg15wH-ADQN5M5kXMOJ-7oULlnxtoTPZrAvZdkdS8XZUqSBYFipuEMwhKZdK8aN9i7niSrrPzxfCRa9qXVExrECS2z-2w/125fx125f"><div class="weaponblockinfo"><span>ПП-19 Бизон<br>Осирис</span></div></div><div class="weaponblock weaponblock2 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rbbOKMyJYYl2STKFNVfw3-x7TBS414NNcWNak8L5IeV--s9TBZeMsM9ofFsiDX6XVYwn7uRhs1ahffZaK9S_n3iu4Mj8CUw2rpDw1YXWUJg/125fx125f"><div class="weaponblockinfo"><span>P90<br>Азимов</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51MeSwJghkZzvMBKdbSsou_RztBzQm59Vua9u_8LMSFlC-9tWTLeV-N4odS5PXX6PVNFv8uE9r1PdeKsff8i_s3SXhPW0LCUG--2pXyuaZ-uw8UAQJFkg/125fx125f"><div class="weaponblockinfo"><span>Negev<br>Пустынная атака</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5_MeKyPDJYcRH9BaVfW_k_ywn5GyIn-_hvXdC-44QKKE644ZzBZeErNthJGJOCWvPQZFqsuEM6ifMIK5GB9ivt3Xy8P2oKXBLurmtRhqbZ7Tllk6hd/125fx125f"><div style="-webkit-box-sizing: border-box;" class="weaponblockinfo"><span>Desert Eagle<br>Заговор</span></div></div><div class="weaponblock weaponblock2 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52YOLkDyRufgHMAqVMY_YvywW4CHYh18R6RtKuyLcPLlSr296Xced5LtlIG5LUWvOFM1v66Rk80aVaeZ2IoiK6j3_pb2YKU0fjr2kMzuPVs-F1wjFBLhxWp7I/125fx125f"><div class="weaponblockinfo"><span>M4A1-S<br>Сайрекс</span></div></div><div class="weaponblock weaponblock2 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9QnTDyY27fhvXdC-44QKKE644ZyUMuF-NY4eHJWEWv6Hbgys6E0-g6JZfZONqCK-3ivtaDwJDRHp-j0MhqbZ7VLOXRkn/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Градиент</span></div></div><div class="weaponblock weaponblock2 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rbbOKMyJYYl2STKFNVfw3-x7TBS414NNcWNak8L5IeV--s9TBZeMsM9ofFsiDX6XVYwn7uRhs1ahffZaK9S_n3iu4Mj8CUw2rpDw1YXWUJg/125fx125f"><div class="weaponblockinfo"><span>P90<br>Азимов</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rZrblDzRyTQbLFbRbTuYt8Q34Nis77893a9u35bwDZwTs59bCO7kqOIxLFsTRWKOGNV__6Eg70qkILp2PoCi5iy_uM25bDxf1ujVTlZEMO3Y/125fx125f"><div class="weaponblockinfo"><span>P250<br>Сверхновая</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5uOfPhZQhvazvOCK5bT8o15gniDiIN5M5kXMOJ-7oULlnx4ILGN-V9M9BFHcPWD_DQNwypu0lugKRYKsTbpXjs2i_qaDpcWBW_-3VExrHui8poXg/125fx125f"><div class="weaponblockinfo"><span>UMP-45<br>Лабиринт</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz55Pfm6PghkZzvACLpRUrg15wH-ADQN5M5kXMOJ-7oULlnxtoTPZrAvZdkdS8XZUqSBYFipuEMwhKZdK8aN9i7niSrrPzxfCRa9qXVExrECS2z-2w/125fx125f"><div class="weaponblockinfo"><span>ПП-19 Бизон<br>Осирис</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5oJ-TlaAhmYzvOBLZXXeEy9QbTBS414NNcWNak8L5IeVjv59fCMbV-NdtLG8bUWKKGMgiruB1sgPJdesaPoy66jyXsPW5cCQ2rpDx0zn4ssg/125fx125f"><div class="weaponblockinfo"><span>SSG 08<br>Пучина</span></div></div><div class="weaponblock weaponblock2 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52YOLkDyRufgHMAqVMY_YvywW4CHYh18R6RtKuyLcPLlSr296Xced5LtlIG5LUWvOFM1v66Rk80aVaeZ2IoiK6j3_pb2YKU0fjr2kMzuPVs-F1wjFBLhxWp7I/125fx125f"><div class="weaponblockinfo"><span>M4A1-S<br>Сайрекс</span></div></div></div>
		</div>
	</div>
		
		<div style="text-align: center;
		padding: 5px 0px 1px 0px;
		font-size: 14px;
		color: #D3A23A;">
			Вы можете увеличить шанс выпадения дорогих предметов:
		</div>
		
		<div style="width: 375px; margin: 0 auto;">
			<div class="upchance upc10" data-price="10">ШАНС +10%</div>
			<div class="upchance upc20" data-price="20">ШАНС +20%</div>
			<div class="upchance upc30" data-price="30">ШАНС +30%</div>
			<div class="clearfix"></div>
		</div>
		
		<div style="text-align: center; padding-top: 13px">

			<button id="openCase" class="OpenCaseBtn">Открыть кейс</button>
			<button class="OpenCaseBtn" disabled="disabled"><span id="currentCaseprice">89</span><span id="upchanceprice"></span> рублей</button>
			<div class="clearfix"></div>

		</div>


		<div style="text-align: center; padding-top: 5px;">
		<span style="color: #eaeaea; font-size: 13px;">Открывая кейс вы соглашаетесь <a style="cursor: pointer;" data-modal="#rules">с условиями покупки</a></span>
		</div>
		
		<hr class="style-two" style="margin-bottom: 7px;">
		
		<div class="clearfix"></div>
		

		
		<div id="authError" class="syserrbox" style="display: none; margin-bottom: 10px;">
			<center style="font-size: 16px; color: #C78080; line-height: 20px;">Для того, чтобы открывать кейсы, вам нужно выполнить вход на сайт:</center>
			<div style="position: relative; left:40%" >
			 <div style="float: center;margin-top:10px">
<div  class="" style="float: center;" id="uLogines" data-ulogin="display=panel;fields=first_name,last_name;providers=steam,vkontakte;hidden=;redirect_uri=http%3A%2F%2F<?php echo $_SERVER["HTTP_HOST"];?>%2F"></div>
</div>

			</div>
		</div>
		
		<div id="balanceError" class="syserrbox" style="display: none; margin-bottom: 10px;">
			<center style="font-size: 16px; color: #C78080;">Вам нужно пополнить баланс:</center>
			<div style="font-size: 20px; color: #FCFCFC; text-align: center;">
				Ваш баланс: <span class="userBalance">10000</span> руб
			</div>
			<div style="margin-left: 35%;  margin-top: 7px;">
				<form class="form-inline">
				<div class="form-group">
					<div class="input-group">
					<div class="addbal"><a data-modal="#paySystems" href="#">Пополнить</a></div>
					</div>
				</div>
				</form>
				<span class="userPanelError" style="float: none"></span>
				<div class="clearfix"></div>
			</div>
		</div>
		
		<div id="linkError" class="syserrbox" style="display: none; width: 500px; padding-bottom: 5px; margin-bottom: 10px;">
			<center style="font-size: 16px; color: #C78080;">Вам нужно ввести вашу ссылку на обмен:</center>
			<div class="tradelinkbox" style="padding-top: 6px;">
				<form class="form-inline">
				<div class="form-group">
					<div class="input-group" style="background: #212121; border-color: #434343;">
					<input type="text" class="form-control linkInput" placeholder="Введите вашу ссылку на обмен" style="width: 360px; padding: 0px 10px; height: 30px;  background: #212121; border-color: #434343; margin: 1px 0;
					outline:0;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);">
					<a class="utlink" style="padding: 0px 13px;">Сохранить</a>
					</div>
				</div>
				</form>
				<a class="llink" data-modal="#tradelinkInstruction" href="http://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url" target="_blank">Как узнать ссылку на обмен?</a>
				<span class="userPanelError"></span>
				<div class="clearfix"></div>
			</div>
		</div>
		

		
		<div style="text-align: center; color: #83B6C2; font-size: 13px; margin-bottom: -7px;">Предметы, которые могут вам выпасть с <span id="curCaseName" style="color: #D3A23A; font-size: 15px;">Кейс операции "Прорыв"</span></div>
	
	<ul id="caseItems"><li class="weaponblock weaponblock1 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52JLSKMyJYfxSVTKNRUfg7-gzpGxg-4cBrQOi69qkBLBLtsoKSMOYuN95JTMjTDPGDM1ipuxg90fMJKcDfpCvn2ni4OD0IWxvi5CtazxCLTIoO/125fx125f"><div class="weaponblockinfo"><span>MP7<br>Городская опасность</span></div></li><li class="weaponblock weaponblock1 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51MeSwJghkZzvMBKdbSsou_RztBzQm59Vua9u_8LMSFlC-9tWTLeV-N4odS5PXX6PVNFv8uE9r1PdeKsff8i_s3SXhPW0LCUG--2pXyuaZ-uw8UAQJFkg/125fx125f"><div class="weaponblockinfo"><span>Negev<br>Пустынная атака</span></div></li><li class="weaponblock weaponblock1 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5zP_PnYGc3TQfXPrAMDKVqywH6BjUr18tqU9-iyLcHO1u6qoCXN7d-MdweGsmDD_GPYAD47EI9iPIILpba8izv2yzuO2oCDRTs-2oa2LjQxpZttMo/125fx125f"><div class="weaponblockinfo"><span>P2000<br>Слоновая кость</span></div></li><li class="weaponblock weaponblock1 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5oJ-TlaAhmYzvOBLZXXeEy9QbTBS414NNcWNak8L5IeVjv59fCMbV-NdtLG8bUWKKGMgiruB1sgPJdesaPoy66jyXsPW5cCQ2rpDx0zn4ssg/125fx125f"><div class="weaponblockinfo"><span>SSG 08<br>Пучина</span></div></li><li class="weaponblock weaponblock1 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5uOfPhZQhvazvOCK5bT8o15gniDiIN5M5kXMOJ-7oULlnx4ILGN-V9M9BFHcPWD_DQNwypu0lugKRYKsTbpXjs2i_qaDpcWBW_-3VExrHui8poXg/125fx125f"><div class="weaponblockinfo"><span>UMP-45<br>Лабиринт</span></div></li><li class="weaponblock weaponblock1 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz55Pfm6PghkZzvACLpRUrg15wH-ADQN5M5kXMOJ-7oULlnxtoTPZrAvZdkdS8XZUqSBYFipuEMwhKZdK8aN9i7niSrrPzxfCRa9qXVExrECS2z-2w/125fx125f"><div class="weaponblockinfo"><span>ПП-19 Бизон<br>Осирис</span></div></li><li class="weaponblock weaponblock1 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz54LrTgMQhkZzvBVvVfEeEz8w3-Nis77893a9u35bwDZ17osYaUNuErM4tEScKCWPaBbw3_vxk4hKcIecHb9C68jHm8OmoPWhD1ujVToYhPwzE/125fx125f"><div class="weaponblockinfo"><span>CZ75-Auto<br>Тигр</span></div></li><li class="weaponblock weaponblock1 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51O_W0DzRyTQrNF6FhV_ozywTlDi8m18tiRtCzueleKg-54YLFZbcvNopIF5SFD_eGMwio4kNth6YMfJWLoSntiX67a2gUG028humfMw0/125fx125f"><div class="weaponblockinfo"><span>Nova<br>Карп кои</span></div></li><li class="weaponblock weaponblock1 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rZrblDzRyTQbLFbRbTuYt8Q34Nis77893a9u35bwDZwTs59bCO7kqOIxLFsTRWKOGNV__6Eg70qkILp2PoCi5iy_uM25bDxf1ujVTlZEMO3Y/125fx125f"><div class="weaponblockinfo"><span>P250<br>Сверхновая</span></div></li><li class="weaponblock weaponblock1 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5_MeKyPDJYcRH9BaVfW_k_ywn5GyIn-_hvXdC-44QKKE644ZzBZeErNthJGJOCWvPQZFqsuEM6ifMIK5GB9ivt3Xy8P2oKXBLurmtRhqbZ7Tllk6hd/125fx125f"><div class="weaponblockinfo"><span>Desert Eagle<br>Заговор</span></div></li><li class="weaponblock weaponblock1 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz59PfWwIzJxdwr9ALFhCaIF8g3tHS83-tRcWN6x_685JV2t49fYYuElNNoaHciEX6DSbg_17E870qRZfcSJ8ynu2irpOToCCRXq_2wBnPjH5OWhSCyC7g/125fx125f"><div class="weaponblockinfo"><span>Five-SeveN<br>Птичьи игры</span></div></li><li class="weaponblock weaponblock1 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSFlC-9tWTLbEpMY1FGsSFDvLXM1__4hhr06RYe5Xa8S692S64PToDXRfvrGgCybWZ-uw8dna1jag/125fx125f"><div class="weaponblockinfo"><span>Glock-18<br>Водяной</span></div></li><li class="weaponblock weaponblock1 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rbbOKMyJYYl2STKFNVfw3-x7TBS414NNcWNak8L5IeV--s9TBZeMsM9ofFsiDX6XVYwn7uRhs1ahffZaK9S_n3iu4Mj8CUw2rpDw1YXWUJg/125fx125f"><div class="weaponblockinfo"><span>P90<br>Азимов</span></div></li><li class="weaponblock weaponblock1 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52YOLkDyRufgHMAqVMY_YvywW4CHYh18R6RtKuyLcPLlSr296Xced5LtlIG5LUWvOFM1v66Rk80aVaeZ2IoiK6j3_pb2YKU0fjr2kMzuPVs-F1wjFBLhxWp7I/125fx125f"><div class="weaponblockinfo"><span>M4A1-S<br>Сайрекс</span></div></li><li class="weaponblock weaponblock1 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9QnTDyY27fhvXdC-44QKKE644ZyUMuF-NY4eHJWEWv6Hbgys6E0-g6JZfZONqCK-3ivtaDwJDRHp-j0MhqbZ7VLOXRkn/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Градиент</span></div></li><li class="weaponblock weaponblock1 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9RnTBi4-7cNcWdKy_q4LFlC-9tWTLbAvYdkfFpSFDv-GZQz14kM4hvVUfcHfoCu61C3qOGhYDRHpqzpSkLCZ-uw8KMc6tY0/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Поверхностная закалка</span></div></li><li class="weaponblock weaponblock1 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9RnTDygg68Jna9u_8LMSFlC-9tWTLbF5NdpOGsmGUqTSYFv-uUk8gvIIe8eL9Cq-1Srgb2dcCBLsqGxVmuWZ-uw8pT4tNB0/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Патина</span></div></li></ul>
	<div class="clearfix"></div>
</div>
</div>







<div style="display: none;">
<div id="weaponBlock" class="itemmodal">
	<div class="box-modal_close arcticmodal-close mini"></div>

	<div class="recweaptitle">
		<span class="stattrack">StatTrak™</span> <span class="name"></span>
	</div>
	
	<div class="recweap classified">
		<img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSFlC-9tWTLbEpMY1FGsSFDvLXM1__4hhr06RYe5Xa8S692S64PToDXRfvrGgCybWZ-uw8dna1jag/384fx384f" >
	</div>
	
	<div style="width: 410px; margin: 0 auto;">
		<div class="shareBtn"><a href="http://vk.com/share.php?url=http%3A%2F%2Fcrackedlix.ru%2F%3Futm_source%3Dvkshare%26title%3D%25D0%259A%25D0%25B5%25D0%25B9%25D1%2581%25D1%258B%2520CS%3AGO%2520-%2520%25D0%259E%25D1%2582%25D0%25BA%25D1%2580%25D1%258B%25D0%25B2%25D0%25B0%25D0%25B9%2520%25D1%2581%2520%25D0%25B2%25D1%258B%25D0%25B3%25D0%25BE%25D0%25B4%25D0%25BE%25D0%25B9%2F%26description%3D%25D0%25AF%2520%25D0%25B2%25D1%258B%25D0%25B8%25D0%25B3%25D1%2580%25D0%25B0%25D0%25BB%2520Glock-18%2520%257C%2520%25D0%2592%25D0%25BE%25D0%25B4%25D1%258F%25D0%25BD%25D0%25BE%25D0%25B9%2F%26image%3Dhttp%3A%2F%2Fsteamcommunity-a.akamaihd.net%2Feconomy%2Fimage%2FfWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSFlC-9tWTLbEpMY1FGsSFDvLXM1__4hhr06RYe5Xa8S692S64PToDXRfvrGgCybWZ-uw8dna1jag%2F360fx360f%2F%26noparse%3D"true"" onmouseup="this._btn=event.button;this.blur();" onclick="return VK.Share.click(1, this);" style="display:inline-block;text-decoration:none;"><span style="position: relative; padding:0;"><img src="<?php echo "http://".$_SERVER["HTTP_HOST"];?>images/vk_icon.png"><span>Поделиться результатом</span></span></a></div>
	
		<div id="sellBlock" class="recweapinfo" style="font-size: 13px; line-height: 15px; display: none;">
		Steam ввел новые ограничения и поэтому сейчас наши боты не могут сразу отправлять предметы <span style="color: rgb(75, 105, 255);">Армейского качества</span>
			<div style="padding-top: 3px;">
			Сейчас моментально отправляются только <span style="color: rgb(228, 174, 57);">Ножи</span> и предметы редкости <span style="color: rgb(136, 71, 255);">Запрещенное</span>, <span style="color: rgb(211, 44, 230);">Засекреченное</span> и <span style="color: rgb(235, 75, 75);">Тайное</span>
			</div>
			<div style="padding-top: 3px;">
			Полную информацию <a style="cursor: pointer; text-decoration: underline;" data-modal="#rules">читать здесь</a>
			</div>
			<div style="padding-top: 5px; padding-left: 15px;">
				1. Мы можем выкупить данный предмет по рыночной цене торговой площадки Steam и зачислить возвращенные средства на ваш баланс на нашем сайте.
				<div style="padding-top: 5px;">
				2. Подождать пока разрешиться проблема и наши боты снова попробуют отправить вам данный предмет (минимальный срок – 7 дней)
				</div>
			</div>
			<div class="wpmillBtn sellBtn" style="margin-left: 21px;">Продать<br><span><span class="sellprice">12</span> руб (цена на маркете)</span></div>
			<div class="wpmillBtn waitBtn" style="margin-left: 25px;">Подождать<br><span>ждать от 7 дней</span></div>
		</div>
	
		<div id="aftersellBlock1" style="display: none;">
			<div class="recweapinfo" style="padding: 6px; line-height: 15px; font-size: 16px; margin-top: 10px;">
			Сумма в размере <span style="color: #D3A23A"><span class="sellprice">12 рублей</span></span> была успешно зачислена на ваш баланс
			</div>		
			<div class="TryAgainBtn arcticmodal-close">Попробовать еще раз</div>
		</div>
	
		<div id="aftersellBlock2" style="display: none;">
			<div class="recweapinfo" style="font-size: 14px; line-height: 15px;">
			Как только разрешиться проблема с ограничением наши боты снова попробуют отправить вам данный предмет.<br>
			Минимальный срок ожидания - 7 дней.<br>
			Просим прощение за неудобства.
			<div style="padding-top: 10px;">
			Напоминае, что <u>это ограничение у нас распостраняется только на предметы <span style="color: rgb(75, 105, 255);">Армейского качества!</span></u><br>
			<span style="color: rgb(228, 174, 57);">Ножи</span> и предметы редкости <span style="color: rgb(136, 71, 255);">Запрещенное</span>, <span style="color: rgb(211, 44, 230);">Засекреченное</span> и <span style="color: rgb(235, 75, 75);">Тайное</span> <u>отправляются моментально после покупки</u>!
			</div>
			</div>
			<div class="TryAgainBtn arcticmodal-close">Попробовать еще раз</div>
		</div>

		<div id="aftersellBlock3" style="display: block;">
			<div class="recweapinfo" style="padding: 3px 3px 3px 5px; line-height: 15px; font-size: 15px; margin-top: 10px;">
			<span style="color: #D3A23A">Поздравляем!</span> Предмет вам уже отправлен. Вы можете получить ваш предмет <a href="http://steamcommunity.com/id/me/tradeoffers/" target="_blank">на странице предложений обмена в Steam</a>
			</div>		
			<div class="TryAgainBtn arcticmodal-close">Попробовать еще раз</div>
		</div>		
		
		<div class="clearfix"></div>
	</div>
</div>
</div>-->