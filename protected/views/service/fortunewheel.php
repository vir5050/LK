<div class="subhead"><?php echo $this->_pageTitle; ?></div>
<div class="container-wrapper">
    <?php if(!isset($offline)): ?>
        <ul class="ui-list" style="margin: 0 20px;">
            <li>При <strong style="color: green;">медленном</strong> вращении шанс удачи не увеличивается, стоит <strong><?php echo $fortunewheel['price']['1']; ?> монет.</strong></li>
            <li>При <strong style="color: orange;">среднем</strong> вращении шанс удачи увеличивается <strong style="color: orange;">в 1.5 раза</strong>, стоит <strong><?php echo $fortunewheel['price']['2']; ?> монет.</strong></li>
            <li>При <strong style="color: red;">быстром</strong> вращении шанс увеличивается <strong style="color: red;">в 2 раза</strong>, стоит <strong><?php echo $fortunewheel['price']['3']; ?> монет.</strong></li>
        </ul>
        <table class="wheel-wrapper" style="margin-top: 10px; border-top: 1px solid rgb(233, 233, 233);">
            <tr>
				<td valign="middle" style="width: 480px;">
					<div class="span5" style="height: 474px; float: left;">
						<div class="the_wheel">
							<canvas class="the_canvas" id="myDrawingCanvas" width="434" height="434">
								<p class="noCanvasMsg" align="center">Ваш браузер не поддерживает данную функцию.</p>
							</canvas>
						</div>
					</div>
				</td>
				<td valign="middle">
					<div class="span2" style="float: right;">
						<div class="power_controls">
							<table class="power" cellpadding="10" cellspacing="0">
								<tr>
									<th align="center" style="padding-bottom: 10px;">Скорость вращения</th>
								</tr>
								<tr>
									<td align="center">
										<button style="width: 80px;" class="button grey-gradient" id="pw3" onClick="powerSelected(3);">Быстро</button>
									</td>
								</tr>
								<tr>
									<td align="center">
										<button style="width: 100px;" class="button grey-gradient" id="pw2" onClick="powerSelected(2);">Средне</button>
									</td>
								</tr>
								<tr>
									<td align="center">
										<button style="width: 120px;" class="button grey-gradient" id="pw1" onClick="powerSelected(1);">Медленно</button>
									</td>
								</tr>
								<tr>
									<td align="center">
										<button style="margin-top: 30px;height: 50px;line-height: 50px;width: 100px;" id="spin_button" class="button blue-gradient" onClick="startSpin();">Крутить</button>
									</td>
								</tr>
								<tr>
									<td align="center">
										<button style="margin-top: 10px;" class="button grey-gradient" onClick="resetWheel(); return false;">Рестарт</button>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</td>
			</tr>
        </table>
    <?php endif; ?>
    <?php echo $actionMessage; ?>
</div>
<div class="subhead">Призы</div>
<div class="container-wrapper">
	<?php if(isset($fortunewheel) and !empty($fortunewheel)): ?>
        <table class="primary-table" style="width: 100%;">
            <tr>
                <th style="width: 100px;">#</th>
                <th>Предмет</th>
                <th style="width: 50px; text-align: center;">Монеты</th>
            </tr>
            <?php foreach($fortunewheel as $key => $value): ?>
			<?php if($key !== 'price'): ?>
			<?php if(null!==($item = Store::model()->findByPk($value['store']))): ?>
                <tr>
                    <td><?php echo $prizeEnum[$key]; ?> приз</td>
                    <td><a href="store/ajax/preview/<?php echo $value['store']; ?>" style="display: block; height: 32px; line-height: 32px;" onmouseover="showTooltip(this, '<?php echo $key; ?>', {target:this, removeElementsOnHide:true, tipJoint:'right', ajax:true, offset:[-4, 0]});"><img width="32px" height="32px" src="uploads/Icons/<?php echo $item->item_id; ?>.png" style="float: left;" /> <span style="display: block; padding-left: 40px;"><?php echo $item->name; ?> x<?php echo $item->count; ?></span></a></td>
					<td style="text-align: center;"><?php echo $value['cash']; ?></td>
                </tr>
			<?php endif; ?>
			<?php endif; ?>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
<script>begin();</script>