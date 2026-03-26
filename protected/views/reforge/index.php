<div class="container-wrapper blacksmith-page">
    <div class="page-shadow"></div>
    <ul class="reforge-menu">
        <li><a href="add-cells/" onclick="return go(this, event);" class="transition"><?php echo My::t('app', 'Add cells'); ?></a></li>
        <li><a href="attack-range/" onclick="return go(this, event);" class="transition"><?php echo My::t('app', 'Add attack range'); ?></a></li>
        <li><a href="distance-fragility/" onclick="return go(this, event);" class="transition"><?php echo My::t('app', 'Delete distance fragility'); ?></a></li>
        <li><a href="attack-speed/" onclick="return go(this, event);" class="transition"><?php echo My::t('app', 'Add attack speed'); ?></a></li>
        <li><a href="item-creator/" onclick="return go(this, event);" class="transition"><?php echo My::t('app', 'Change item creator'); ?></a></li>
    </ul>
    <div class="reforge-block" style="top: 240px;">
        <p><?php echo My::t('app', 'Reforging allows undesired stats on gear to be exchanged for useful stats or improve this stats.'); ?></p>
    </div>
</div>