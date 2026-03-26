<div class="subhead">
    <div class="dashboard-latest-update">
        <i data-icon="&#xe019;" onclick="ajax.send('POST', 'admin/servermanagement', {updServices:true}, null, function(){ window.location.reload(); });"></i>
        <strong><?php echo My::t('core', 'Last update'); ?>:</strong> <?php echo $lastUpdate; ?>
    </div>
    <?php echo My::t('app', 'Memory'); ?>
</div>
<div class="container-wrapper">
    <table class="table-dashboard">
        <thead>
        <tr>
            <th>Total</th>
            <th>Used</th>
            <th>Free</th>
            <th>Shared</th>
            <th>Buffers</th>
            <th>Cached</th>
        </tr>
        </thead>
        <tbody>
        <?php if(isset($monitoring['memory'])): ?>
            <tr>
                <td style="text-align: center;"><?php echo $monitoring['memory']['total']; ?> mb</td>
                <td style="text-align: center;"><?php echo $monitoring['memory']['used']; ?> mb</td>
                <td style="text-align: center;"><?php echo $monitoring['memory']['free']; ?> mb</td>
                <td style="text-align: center;"><?php echo $monitoring['memory']['shared']; ?> mb</td>
                <td style="text-align: center;"><?php echo $monitoring['memory']['buffers']; ?> mb</td>
                <td style="text-align: center;"><?php echo $monitoring['memory']['cached']; ?> mb</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="subhead">
    <div class="dashboard-latest-update">
        <i data-icon="&#xe019;" onclick="ajax.send('POST', 'admin/servermanagement', {updServices:true}, null, function(){ window.location.reload(); });"></i>
        <strong><?php echo My::t('core', 'Last update'); ?>:</strong> <?php echo $lastUpdate; ?>
    </div>
    <?php echo My::t('app', 'Parameters'); ?>
</div>
<div class="container-wrapper">
    <div class="dashboard-attributes">
        <?php if(isset($monitoring['attributes'])): ?>
            <?php foreach($monitoring['attributes'] as $attribute => $value): ?>

                    <?php if($attribute == 'DoubleExp'): ?>
                        <?php echo CHtml::dropDownList('DoubleExp', $value, $this->expList, array('class'=>'field no-hover', 'id'=>'Attribute-'.$attribute, 'onchange'=>'CharmBar.setAttri({attri:\''.$attribute.'\', value:this.value}, this.nextElementSibling);')); ?>
				   <?php endif; ?>
				   <br />
                    <?php if($attribute == 'DoubleEp'): ?>
                        <?php echo CHtml::dropDownList('DoubleEp', $value, $this->epList, array('class'=>'field no-hover', 'id'=>'Attribute-'.$attribute, 'onchange'=>'CharmBar.setAttri({attri:\''.$attribute.'\', value:this.value}, this.nextElementSibling);')); ?>
				   <?php endif; ?>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<div class="subhead">
    <div class="dashboard-latest-update">
        <i data-icon="&#xe019;" onclick="ajax.send('POST', 'admin/servermanagement', {updServices:true}, null, function(){ window.location.reload(); });"></i>
        <strong><?php echo My::t('core', 'Last update'); ?>:</strong> <?php echo $lastUpdate; ?>
    </div>
    <?php echo My::t('app', 'Services'); ?>
</div>
<div class="container-wrapper">
    <table class="table-dashboard">
        <thead>
        <tr>
            <th><?php echo My::t('app', 'Command'); ?></th>
            <th style="width: 120px;"><?php echo My::t('app', 'Process ID'); ?></th>
            <th style="width: 140px;"><?php echo My::t('app', 'CPU usage'); ?></th>
            <th style="width: 140px;"><?php echo My::t('app', 'Memory usage'); ?></th>
            <th style="width: 100px;"><?php echo My::t('core', 'Action'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if(isset($monitoring['services'])): ?>
            <?php foreach($monitoring['services'] as $service => $info): ?>
                <tr>
                    <td valign="top"><?php echo $service; ?></td>
                    <td onmouseover="showTooltip(this, '<?php echo str_replace(' ', '<br />', $info['pid']); ?>', {target:this, tipJoint:'left', offset:[5, 0]});" valign="top" style="text-align: center;">Посмотреть</td>
                    <td valign="top">
                        <div class="dashboard-progress-bar">
                            <div style="background-color: <?php echo (isset($info['cpu']) ? '#'.CDebug::percent2Color($info['cpu']) : 'transparent'); ?>; width: <?php echo (isset($info['cpu']) ? ceil(str_replace(',', '.', $info['cpu'])).'%' : '0%'); ?>;"></div>
                            <label><?php echo (isset($info['cpu']) ? $info['cpu'].'%' : 'n/a'); ?></label>
                        </div>
                    </td>
                    <td valign="top">
                        <div class="dashboard-progress-bar">
                            <div style="background-color: <?php echo (isset($info['cpu']) ? '#'.CDebug::percent2Color($info['mem']) : 'transparent'); ?>; width: <?php echo (isset($info['mem']) ? ceil(str_replace(',', '.', $info['mem'])).'%' : '0%'); ?>;"></div>
                            <label><?php echo (isset($info['virt']) ? CDebug::convertMemory($info['virt']) : 'n/a'); ?> <?php echo (isset($info['mem']) ? '('.$info['mem'].'%)' : ''); ?></label>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <?php if(isset($info['pid']) and !empty($info['pid'])): ?>
                            <a class="dashboard-action-link" href="javascript:;" onclick="CharmBar.request('POST', 'admin/servermanagement', {killProcess:<?php echo $info['pid']; ?>, updServices:true}, false, function() { window.location.reload(); });"><i class="turn-off" data-icon="&#xe34a;"></i><?php echo My::t('app', 'Turn off'); ?></a>
                        <?php else: ?>
                            <a class="dashboard-action-link" href="javascript:;" onclick="CharmBar.request('POST', 'admin/servermanagement', {startService:'<?php echo $service; ?>', updServices:true}, false, function() { window.location.reload(); });"><i class="turn-on" data-icon="&#xe34a;"></i><?php echo My::t('app', 'Run'); ?></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="subhead">
    <div class="dashboard-latest-update">
        <i data-icon="&#xe019;" onclick="CharmBar.request('POST', 'admin/servermanagement', {updServices:true}, false, function() { window.location.reload(); });"></i>
        <strong><?php echo My::t('core', 'Last update'); ?>:</strong> <?php echo $lastUpdate; ?>
    </div>
    <?php echo My::t('app', 'Dungeons'); ?>
</div>
<div class="container-wrapper">
    <table class="table-dashboard">
        <thead>
        <tr>
            <th><?php echo My::t('app', 'Command'); ?></th>
            <th style="width: 120px;"><?php echo My::t('app', 'Process ID'); ?></th>
            <th style="width: 140px;"><?php echo My::t('app', 'CPU usage'); ?></th>
            <th style="width: 140px;"><?php echo My::t('app', 'Memory usage'); ?></th>
            <th style="width: 100px;"><?php echo My::t('core', 'Action'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if(isset($monitoring['dungeon'])): ?>
            <?php foreach($monitoring['dungeon'] as $dungeon => $info): ?>
                <tr>
                    <td valign="top"><?php echo $dungeon; ?></td>
                    <td valign="top" style="text-align: center;"><?php echo $info['pid']; ?></td>
                    <td valign="top">
                        <div class="dashboard-progress-bar">
                            <div style="background-color: <?php echo (isset($info['cpu']) ? '#'.CDebug::percent2Color($info['cpu']) : 'transparent'); ?>; width: <?php echo (isset($info['cpu']) ? ceil(str_replace(',', '.', $info['cpu'])).'%' : '0%'); ?>;"></div>
                            <label><?php echo (isset($info['cpu']) ? $info['cpu'].'%' : 'n/a'); ?></label>
                        </div>
                    </td>
                    <td valign="top">
                        <div class="dashboard-progress-bar">
                            <div style="background-color: <?php echo (isset($info['cpu']) ? '#'.CDebug::percent2Color($info['mem']) : 'transparent'); ?>; width: <?php echo (isset($info['mem']) ? ceil(str_replace(',', '.', $info['mem'])).'%' : '0%'); ?>;"></div>
                            <label><?php echo (isset($info['virt']) ? CDebug::convertMemory($info['virt']) : 'n/a'); ?> <?php echo (isset($info['mem']) ? '('.$info['mem'].'%)' : ''); ?></label>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <a class="dashboard-action-link" href="javascript:;" onclick="CharmBar.request('POST', 'admin/servermanagement', {killProcess:<?php echo $info['pid']; ?>, updServices:true}, false, function() { window.location.reload(); }); return false;"><i class="turn-off" data-icon="&#xe34a;"></i><?php echo My::t('app', 'Turn off'); ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        <tr>
            <td colspan="5" style="background-color: transparent; border-top: 1px solid rgb(218, 226, 232); position: relative;">
                <div class="dashboard-run-dungeon">
                    <button class="button small blue right-float" onclick="CharmBar.request('POST', 'admin/servermanagement', {startDungeon:ge('map-list').value, updServices:true}, getParent(this, false, 'td'), function() { window.location.reload(); });"><?php echo My::t('app', 'Run'); ?></button>
                    <?php echo CHtml::dropDownList('dungeons', '', My::t('dungeon', 'map'), array('class'=>'field no-hover', 'id'=>'map-list')); ?>
                    <i class="icon-arrow-down"></i>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>