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
<div class="switch-button flex-cc" data-info-open="1" data-anchor="register" onclick="location='user/join'" >РЕГИСТРАЦИЯ АККАУНТА</div>
<div class="switch-button flex-cc active" data-info-open="2" data-anchor="login" onclick="location='user/login'" >ВХОД В КАБИНЕТ</div>
</div>

<div class="box-title" style="width: 100%;height: auto;font-family: Beaufort Bold;text-transform: uppercase;font-size: 30px;color: #562200;text-align: center;margin-bottom: 10px;">ВХОД В КАБИНЕТ</div>
<div class="box-title" style="display: block;
width: 100%;
height: auto;
font-family: Roboto;
text-transform: none;
font-size: 16px;
color:
#655a5a;
text-align: center;
margin-top: 5px;">Для входа в личный кабинет заполните все необходимые поля!</div>
<?php if(My::app()->getCookie()->get('userAttemptsAuth') != ''){
    echo CWidget::create('CMessage', array('error', My::t('app', 'Please confirm you are a human by clicking the button below.')));
    echo CWidget::create('CFormView', array(
        'action'=>'user/login',
        'method'=>'post',
        'htmlOptions'=>array(
            'name'=>'confirmForm',
            'id'=>'primaryForm'
        ),
        'fields'=>array(
            'userAttemptsAuth' =>array('type'=>'hidden', 'value'=>My::app()->getCookie()->get('userAttemptsAuth')),
        ),
        'buttons'=>array(
            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Confirm'), 'htmlOptions'=>array('class'=>'button blue')),
        ),
        'return'=>true,
    ));
}else{
    echo $actionMessage;
    echo CWidget::create('CFormView', array(
        'action'=>'user/login',
        'method'=>'post',
        'htmlOptions'=>array(
            'name'=>'loginForm',
            'id'=>'primaryForm'
        ),
        'captcha'=>CConfig::get('validation.captcha.login'),
        'fields'=>array(
            'act'=>array('type'=>'hidden', 'value'=>'send'),
            'separatorAccount'=>array(
                'separatorInfo'=> array('legend'=>My::t('app', '&nbsp;')),
                'username'=>array('type'=>'textbox', 'value'=>$username, 'htmlOptions'=>array('class'=>'field2 transition', 'placeholder'=>My::t('app', 'Username'), 'autofocus'=>false, 'autocomplete'=>'off')),
                'password'=>array('type'=>'password', 'value'=>$password, 'htmlOptions'=>array('style'=>'margin-top: 20px', 'class'=>'field2 transition', 'placeholder'=>My::t('app', 'Password')))
            )
        ),
        'checkboxes'=>array(
            'remember'=>array('type'=>'checkbox', 'title'=>My::t('app', 'Remember me'), 'value'=>'1', 'htmlOptions'=>array( 'class'=>'checkbox'), 'htmlLabelOptions'=>array('style'=>'position: relative;left: 195px;top: 15px;font-family: Roboto;text-transform: none;font-size: 16px;color: #655a5a', 'class'=>'icon-checkbox'))
        ),
        'buttons'=>array(
            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Sign in'), 'htmlOptions'=>array('style'=>'width: 200px; height: 40px;', 'class'=>'b-page-header__person2 ', 'onclick'=>'this.classList.add(\'active\')'))
        ),
        'events'=>array(
            'focus'=>array('field'=>$errorField)
        ),
        'return'=>true,
    ));
} ?> 
<div class="footer" style="display: block;height: auto;font-family: Roboto;text-transform: none;font-size: 16px;color: #655a5a;text-align: center;margin-top: 5px;">
<p><a href="user/recovery">ЗАБЫЛИ ПАРОЛЬ?</a></p>
</div>