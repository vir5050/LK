<style>
    i[onclick] {
        display: inline-block;
        height: 20px;
        width: 20px;
        padding: 0;
        font-size: 20px;
        margin: 5px;
    }

    i[onclick]:hover {
        cursor: pointer;
        color: rgb(24, 24, 24);
    }

    #icons-list {
        position: absolute;
        bottom: 0; left: 103px;
        border: 1px solid rgb(189, 199, 216);
        height: 200px;
        width: 551px;
        background: rgb(255, 255, 255);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        overflow: auto;
    }
</style>
<div class="subhead"><?php echo My::t('app', 'Manage menu'); ?></div>
<div class="container-wrapper">
    <?php echo $actionMessage; ?>
    <?php echo CWidget::create('CFormView', array(
        'action'=>'menu/admin',
        'method'=>'post',
        'htmlOptions'=>array(
            'name'=>'settings-form',
            'class'=>'light-form',
            'style'=>'float: none;'
        ),
        'fields'=>array(
            'act' =>array('type'=>'hidden', 'value'=>(!empty($id) ? 'edit' : 'add')),
            'id' =>array('type'=>'hidden', 'value'=>$id),
            'title'=>array('type'=>'textbox', 'value'=>$title, 'title'=>My::t('app', 'Title').':', 'htmlOptions'=>array('class'=>'field')),
            'message'=>array('type'=>'textarea', 'value'=>$message, 'htmlOptions'=>array('class'=>'field', 'style'=>'height: 250px;')),
            'external_url'=>array('type'=>'textbox', 'value'=>$external_url, 'htmlOptions'=>array('class'=>'field large', 'placeholder'=>My::t('app', 'External url'))),
            'position'=>array('type'=>'textbox', 'value'=>$position, 'htmlOptions'=>array('class'=>'field small', 'placeholder'=>My::t('app', 'Position'))),
            'icon'=>array('type'=>'textbox', 'value'=>$icon, 'htmlOptions'=>array('class'=>'field small', 'placeholder'=>My::t('app', 'Icon'), 'onfocus'=>'getIcons(this);'), 'appendCode'=>'<div id="icons-list" class="no-display"></div>')
        ),
        'buttons'=>array(
            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button small blue right-float'))
        ),
        'return'=>true
    )); ?>
</div>
<script type="text/javascript">
    function getIcons(el) {
        var node = ge('icons-list');

        if (el.loaded) return node.classList.remove('no-display');

        ajax.send('GET', 'menu/icons', {}, null, function(r) {
            el.loaded = true;

            node.innerHTML = r;
            node.classList.remove('no-display');
        });
    }
    function setIcon(i) {
        var input = qs('input[name=icon]'), node = ge('icons-list');
        input.value = i;
        node.classList.add('no-display');
    }
</script>