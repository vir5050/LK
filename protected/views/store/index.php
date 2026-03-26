<div class="subhead">
    <span class="left-float"><?php echo $subhead; ?></span>
    <div class="change-category left-float">
        <div class="item-edit" role="button" tabindex="0">
            <i data-icon="&#xe12c;"></i>
            <div class="toggle-flyout light-ui" style="top: 23px; right: -9px;">
                <ul class="user-navigation">
                    <li><a class="sub-link" href="store/index" onclick="go(this, event);"><?php echo My::t('app', 'Featured items'); ?></a></li>
                    <?php if(!empty($categories)): ?>
                        <?php foreach($categories as $category): ?>
                            <li role="button" tabindex="0" id="store-category-id-<?php echo $category['category_id']; ?>">
                                <a class="sub-link" href="store/index/category/<?php echo $category['category_id']; ?>" onclick="go(this, event);"><?php echo $category['name']; ?></a>
                                <?php if(CAuth::isLoggedInAsAdmin()): ?>
                                    <i class="icon-arrow-right" onclick="this.parentNode.focus();"></i>
                                    <div class="toggle-flyout no-tail light-ui drop-right" style="width: 200px;">
                                        <ul class="user-navigation">
                                            <li><a href="javascript:;" onclick="Store.editCategory(<?php echo $category['category_id']; ?>, '<?php echo $category['name']; ?>');" class="sub-link"><?php echo My::t('app', 'Edit'); ?></a></li>
                                            <li><a href="javascript:;" onclick="var t = this; ajax.send('POST', 'store/ajax', {act:'category_remove', id:<?php echo $category['category_id']; ?>, save:true}, null, function(r) { if (r == '1') delete dispose(getParent(t, 'store-category-id-<?php echo $category['category_id']; ?>')); });" class="sub-link"><?php echo My::t('app', 'Delete category only'); ?></a></li>
                                            <li><a href="javascript:;" onclick="var t = this; ajax.send('POST', 'store/ajax', {act:'category_remove', id:<?php echo $category['category_id']; ?>}, null, function(r) { if (r == '1') delete dispose(getParent(t, 'store-category-id-<?php echo $category['category_id']; ?>')); });" class="sub-link"><?php echo My::t('app', 'Delete category and items'); ?></a></li>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php if(CAuth::isLoggedInAsAdmin()): ?>
    <div class="add-category right-float">
        <i onclick="this.parentNode.classList.add('no-display'); qs('.add-category-form').classList.remove('no-display');" onmouseover="showTooltip(this, '<?php echo My::t('app', 'Add new category'); ?>', {target:this.parentNode, tipJoint:'right', offset:[-5, 0]});" class="right-float" data-icon="&#xe004;"></i>
    </div>
    <div class="add-category-form no-display">
        <input type="hidden" id="category-id" />
        <input type="text" class="field secondary no-shadow" placeholder="<?php echo My::t('app', 'Category name'); ?>" />
        <input type="button" class="button dark-blue" value="<?php echo My::t('core', 'Add'); ?>" onclick="Store.addCategory(this);" />
    </div>
    <?php endif; ?>
</div>
<div id="store-content">
    <?php if(!empty($allItems)): ?>
        <div class="store-category-all">
            <div class="store-items-grid">
                <?php foreach($allItems as $item): ?>
                    <div class="store-item-block" id="store-id-<?php echo $item['store_id']; ?>">
                        <div class="item-info">
                            <div class="item-icon">
                                <img src="uploads/Icons/<?php echo $item['item_id']; ?>.png" height="80px" width="80px" />
                            </div>
                            <div class="item-name"><?php echo $item['name']; ?></div>
                            <div class="item-mask"><a href="store/index/mask/<?php echo $item['mask']; ?>" onclick="go(this, event);"><?php echo My::t('app', 'maskNames.'.$item['mask']); ?></a></div>
                        </div>
                        <?php if(CAuth::isLoggedInAsAdmin()): ?>
                        <div class="item-edit" role="button" tabindex="0">
                            <i data-icon="&#xe3e7;"></i>
                            <div class="toggle-flyout light-ui" style="top: 25px; right: -10px; width: 120px;">
                                <ul class="user-navigation">
                                    <li><a onclick="return go(this, event);" href="store/edit/id/<?php echo $item['store_id']; ?>" class="sub-link"><?php echo My::t('app', 'Edit'); ?></a></li>
                                    <li><a href="javascript:;" onclick="Store.removeItem('store/ajax', {act:'item_remove', sid:<?php echo $item['store_id']; ?>}, getParent(this, 'store-id-<?php echo $item['store_id']; ?>'));" class="sub-link"><?php echo My::t('app', 'Delete'); ?></a></li>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="item-details">
                            <table>
                                <tr>
                                    <td><i data-icon="&#xe1a3;"></i></td>
                                    <td><?php echo My::t('app', 'Count'); ?>: <?php echo $item['count']; ?></td>
                                </tr>
                                <tr>
                                    <td><i data-icon="&#xe464;"></i></td>
                                    <td><?php echo My::t('app', 'Preview'); ?>: <span><a class="primary-link" onclick="return false;" href="store/ajax/preview/<?php echo $item['store_id']; ?>" onmouseover="showTooltip(this, 'Preview', {target:this.parentNode, tipJoint:'left', ajax:true, offset:[10, 2]});">[?]</a></span></td>
                                </tr>
                                <tr>
                                    <td><i data-icon="&#xe1be;"></i></td>
                                    <td><?php echo My::t('app', 'Expiry time'); ?>: <span><a class="primary-link" onclick="return false;" href="store/ajax/expire/<?php echo $item['expire_date']; ?>" onmouseover="showTooltip(this, 'Expire date', {target:this.parentNode, tipJoint:'bottom', ajax:true, offset:[0, -5]});">[?]</a></span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="item-actions">
                            <a href="javascript:;" class="store-button" onmousedown="Store.showItem(this, {sid: <?php echo $item['store_id']; ?>});">
                                <i data-icon="&#xe093;"></i>
                            </a>
                            <div class="item-price"><?php echo My::t('app', 'Price'); ?>: <?php echo ($item['discount'] > 0 ? '<s style="color: red;">'.$item['price'].'</s> '.($item['price'] - ($item['price'] / 100 * $item['discount'])) : $item['price']); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php echo CWidget::create('CPagination', array(
            'htmlOptions'=>array('class'=>'pagination right'),
            'targetPath' => $targetPath,
            'currentPage' => $currentPage,
            'pageSize' => $pageSize,
            'totalRecords' => $totalRecords,
            'showTotal'=>false,
            'events'=>'onclick="return go(this, event);"'
        )); ?>
    <?php endif; ?>
</div>