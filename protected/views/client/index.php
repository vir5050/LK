<title>Клиент</title>
<div id="left-content-area">
	<div class="subhead" 
	style="width: 100%;padding-bottom: 20px;
	font-family: Beaufort Bold;text-transform: uppercase;
	font-size: 25px;color: #562200;text-align: center;
	top: 10px;position: relative;">FW-ARCADIA КЛИЕНТ!</div>
<div class="container-wrapper">
<?php if(CAuth::isLoggedIn()): ?>
<?php else: ?>
<section class="start-game-guide-box">
<div class="title">РЕГИСТРАЦИЯ АККАУНТА</div>
<br />
<i class="far fa-grin-tongue-wink" style="text-align: center;color: #e55454;display: block;font-size: 90px;"></i>

<div class="text" style="width: 100%;text-align: center;font-family: Beaufort;color: #533724;font-size: 16px;margin-top: 15px;">
Создайте аккаунт прямо сейчас и получите <span style="color: #e55454;">Подарок при регистрации</span> 
</div>
<a href="user/join" style="width: 170px;" class="button yellow-grad yellow-grad-text hover-effect flex-cc reg-button">СОЗДАТЬ АККАУНТ</a>
<br /><br /><br />
</section>
<p style="border-top: 3px solid #e55454;">&nbsp;</p>
<?php endif ?>


<section class="start-game-guide-box">
<div class="title">ЗАГРУЗКА КЛИЕНТА</div>
<div class="text" style="width: 100%;text-align: center;font-family: Beaufort;color: #533724;font-size: 16px;margin-top: 15px;">
Создайте аккаунт прямо сейчас и получите <span style="color: #e55454;">Подарок при регистрации</span> 
</div>



<div style="width: 710px;line-height: 65px;margin: 20px auto 0;">
<a href="#" class="btn-google" target="_blank">  <span class="circle"><i class="fa fa-download" style="position: relative;right: -13px;"></i></span>  <span class="title">GOOGLE</span>  <span class="title-hover">Скачать</span></a>
<a href="#" class="btn-torrent" target="_blank">  <span class="circle"><i class="fa fa-download" style="position: relative;right: -13px;"></i></span>  <span class="title">ТОРРЕНТ</span>  <span class="title-hover">Скачать</span></a>
<a href="#" class="btn-yandex" target="_blank">  <span class="circle"><i class="fa fa-download" style="position: relative;right: -13px;"></i></span>  <span class="title">YANDEX DISK</span>  <span class="title-hover">Скачать</span></a>
<!--
<a href="#" class="btn-google" target="_blank">  <span class="circle"><i class="fa fa-download" style="position: relative;right: -13px;"></i></span>  <span class="title">MEGA</span>  <span class="title-hover">Скачать</span></a>
-->
</div>
<br /><br /><br />
</section>


        </div>
</div>