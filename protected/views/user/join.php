<style>
.switch {
    width: 100%;
}
.flex-sbc {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
}
.switch > .switch-button {
width: 50%;
height: 28px;
font-family: Beaufort;
text-transform: uppercase;
font-size: 18px;
color:#655a5a;
background:#d5d1d1;
border-bottom: 1px solid#ddd;
cursor: pointer;
position: relative;
transition: all .2s ease-in-out;
top: -32px;
}
.switch > .switch-button:hover {
background:#fff;
}
.flex-cc {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
}


.switch > .active {
    background: #e55454;
color:#fff;
border-bottom: 1px solid
    transparent;
    cursor: default;
    pointer-events: none;
}
</style>
<div class="switch flex-sbc">
<div class="switch-button flex-cc active" data-info-open="1" data-anchor="register" onclick="location='user/join'" >РЕГИСТРАЦИЯ АККАУНТА</div>
<div class="switch-button flex-cc" data-info-open="2" data-anchor="login" onclick="location='user/login'" >ВХОД В КАБИНЕТ</div>
</div>

<div class="box-title" style="width: 100%;height: auto;font-family: Beaufort Bold;text-transform: uppercase;font-size: 30px;color: #562200;text-align: center;margin-bottom: 10px;">СОЗДАНИЕ АККАУНТА</div>
<div class="box-title" style="display: block;
width: 100%;
height: auto;
font-family: Roboto;
text-transform: none;
font-size: 16px;
color:
#655a5a;
text-align: center;
margin-top: 5px;">Введите данные своей учетной записи:</div>
<?php
echo $actionMessage;
echo CWidget::create('CFormView', array(
    'action'=>'user/join',
    'method'=>'post',
    'htmlOptions'=>array(
        'name'=>'loginForm',
        'id'=>'primaryForm',
        'onkeypress'=>'if (event.keyCode == 13) return cancelEvent(event);'
    ),
    'captcha'=>CConfig::get('validation.captcha.join'),
    'fieldSetType'=>'frameset',
    'fields'=>array(
        'act'=>array('type'=>'hidden', 'value'=>'send'),
        'separatorAccount'=>array(
            'separatorInfo'=>array('legend'=>My::t('app', '&nbsp;')),
            'username'=>array('type'=>'textbox', 'value'=>$username, 'htmlOptions'=>array('class'=>'field2 transition', 'placeholder'=>My::t('app', 'Username'), 'autofocus'=>false, 'autocomplete'=>'off')),
            'password'=>array('type'=>'password', 'value'=>$password, 'htmlOptions'=>array('style'=>'margin-top: 20px', 'class'=>'field2 transition', 'placeholder'=>My::t('app', 'Password'))),
            'passwordRetype'=>array('type'=>'password', 'htmlOptions'=>array('style'=>'margin-top: 20px', 'class'=>'field2 transition', 'placeholder'=>My::t('app', 'Retype password'))),
            'email'=>array('type'=>'textbox', 'value'=>$email, 'htmlOptions'=>array('style'=>'margin-top: 20px', 'class'=>'field2 transition', 'placeholder'=>My::t('app', 'Email')))
        ),/**
        'separatorReferrer'=>array(
            'separatorInfo'=>array('legend'=>(CConfig::get('referral.enable') ? My::t('app', 'Referral program:') : false)),
            'referral'=>array('type'=>'textbox', 'value'=>My::app()->getRequest()->getQuery('ref', 'integer'), 'htmlOptions'=>array('class'=>'field2 transition', 'placeholder'=>My::t('app', 'Optional field'), 'maxlength'=>'10', 'autocomplete'=>'off')),
        ),
        'separatorGift'=>array(
            'separatorInfo'=>array('legend'=>(!empty($giftList) ? My::t('app', 'Ваш подарок') : false)),
            'gift'=>array('type'=>'radiobuttonlist', 'data'=>$giftList, 'checked'=>$gift, 'htmlOptions'=>array('style'=>'display: none', 'class'=>'field'))
        ),**/
    ),
    'checkboxes'=>array(
        'remember'=>array('type'=>'checkbox', 'title'=>My::t('app', 'I confirm my acquaintance and acceptance of these Terms'), 'htmlOptions'=>array('class'=>'checkbox', 'onchange'=>'if (this.value == true) { setStyle(ge(\'terms\'), {display:\'none\'}); ge(\'join-button\').classList.remove(\'no-display\'); ge(\'terms-link\').ot.hide(); }'), 'htmlLabelOptions'=>array('class'=>'icon-checkbox', 'id'=>'terms', 'style'=>'position: relative;left: 195px;top: 15px;font-family: Roboto;text-transform: none;font-size: 16px;color: #655a5a'))
    ),
    'buttons'=>array(
        'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Sign up'), 'htmlOptions'=>array('style'=>'width: 200px; height: 40px;left: 45px;position: relative;', 'class'=>'button no-display', 'id'=>'join-button', 'onclick'=>'this.style.pointerEvents = \'none\''))
    ),
    'events'=>array(
        'focus'=>array('field'=>$errorField)
    ),
    'return'=>true,
));
?>
<div class="footer">

</div>