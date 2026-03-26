<style>.pariah_time > span { color: rgb(250, 0, 0) !important; } .time_used > span { color: rgb(0, 150, 0) !important; }</style>
<div class="subhead" style="width: 100%;padding-bottom: 20px;font-family: Beaufort Bold;text-transform: uppercase;font-size: 25px;color: #562200;text-align: center;top: 10px;position: relative;"><?php echo My::t('app', 'РЕЙТИНГ ПЕРСОНАЖЕЙ'); ?></div>
<div class="container-wrapper">
    <?php if(isset($roles) and !empty($roles)): ?>
		<table style="position: relative;width: 100%;height: 65px;top: 30px;left: 0;right: 0;bottom: 0;margin: auto;">
            <tr style="color: #fff; padding: 4px 10px;background-color: #ff9500;text-align: left;height: 20px;">
                <th>#</th>
				<th style="text-align: center; width: 40px;"><?php echo My::t('app', 'Class'); ?></th>
                <th><?php echo My::t('app', 'Character'); ?></th>
				<th style="width: 160px; text-align: center;"><?php echo My::t('app', 'Вельможа'); ?></th>
				<th style="width: 100px; text-align: center;"><?php echo My::t('app', 'Level'); ?></th>
                <th style="width: 30px; text-align: center;"><?php echo My::t('app', 'Gender'); ?></th>
                <th style="text-align: center; width: 200px;"><?php echo My::t('app', 'Time in game'); ?></th>

                <th style="width: 50px; text-align: center;"><?php echo My::t('app', 'Убийств'); ?></th>
                
            </tr>
            <?php $i = (($currentPage - 1) * $pageSize); ?>
            <?php foreach($roles as $role): ?>
                <?php $i++; ?>
				<tr style="font-size: 16px;font-family: Roboto Bold;color:#ff7f00;">
                    <td style="text-align: center; height: 30px; border-bottom: 1px solid rgb(218, 226, 232);"><?php echo $i; ?></td>
					<td style="text-align: center; height: 30px; border-bottom: 1px solid rgb(218, 226, 232);"><span class="role-cls" style="background: url(/images/occupation/<?php echo $role['occupation']; ?>.png); background-size: cover; width: 25px; height: 25px;"></span></td>
                    <td style=" height: 30px; border-bottom: 1px solid rgb(218, 226, 232);"><?php echo $role['name']; ?></td>
					<td style="text-align: center; height: 30px; border-bottom: 1px solid rgb(218, 226, 232);"><span class="role-cls" style="background: url(/images/occupation/vip/<?php echo $role['crs_server_viplevel']; ?>.png); background-size: cover; width: 25px; height: 25px;"> 
					<span style="margin-left: 30px;position: relative;display: block;width: 120px;">Вельможа <?php echo $role['crs_server_viplevel']; ?> ур.</span></span></td>
					<td style="text-align: center; height: 30px; border-bottom: 1px solid rgb(218, 226, 232);"><?php echo $role['level']; ?></td>
                    <td style="text-align: center; height: 30px; border-bottom: 1px solid rgb(218, 226, 232);"><span class="role-cls" style="background: url(/images/occupation/gender/<?php echo $role['gender']; ?>.png); background-size: cover; width: 25px; height: 25px;"></span></td>
                    <td style="text-align: center; height: 30px; border-bottom: 1px solid rgb(218, 226, 232);" class="time_used"><?php echo Sidebar::online($role['time_used']); ?></td>

                    
                    <td style="text-align: center; height: 30px; border-bottom: 1px solid rgb(218, 226, 232);"><?php echo ceil($role['pkvalue'] / 7200); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php echo CWidget::create('CPagination', array(
            'htmlOptions'=>array('class'=>'pagination right'),
            'targetPath' => $targetPath,
            'currentPage' => $currentPage,
            'pageSize' => $pageSize,
            'totalRecords' => $totalRecords,
            'events'=>'onclick="return go(this, event);"'
        )); ?>
    <?php endif; ?>
</div>