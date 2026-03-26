<div id="map-container" style="background-color: rgb(43, 39, 28); position: absolute; top: 0; left: 0; z-index: 0;">
    <object data="templates/default/images/battlemap.svg" type="image/svg+xml" id="battlemap"></object>
</div>
<script type="text/javascript">
var object = ge('battlemap'), cities = {
    <?php foreach($zones as $zone){
        echo $zone['id'].':'.json_encode($zone).',';
    } ?>
};

object.addEventListener('load', function() {
    var la = ge('left-content-area');
    var mc = ge('map-container');
    var map = object.contentDocument;
    var zones = qsall('path[id]', map);

    if (mc.offsetHeight > la.offsetHeight) {
        setStyle(la, {height:mc.offsetHeight - 20});
    } else if (mc.offsetHeight < la.offsetHeight) {
        setStyle(mc, {height:la.offsetHeight});
    }

    each(zones, function(k, v) {
        var id = v.getAttribute('id');

        if (id in cities) {
            if (cities[id].owner > 0) {
                v.setAttribute('fill', cities[id].color);
            } else {
                v.setAttribute('fill', 'rgb(255, 255, 255)');
                v.setAttribute('opacity', '0.0');
            }

            v.addEventListener('mouseover', function() {
                //this.setAttribute('filter', 'url(#contrast+)');
                v.setAttribute('opacity', '0.5');

                map.getElementById('zone_name').textContent = cities[id].name || '-';
                map.getElementById('zone_level').textContent = cities[id].level || '-';
                map.getElementById('zone_owner').textContent = cities[id].owner_name || '-';
                map.getElementById('zone_challenger').textContent = cities[id].challenger_name || '-';
                map.getElementById('zone_challenge_time').textContent = ((cities[id].challenger > 0) ? cities[id].challenge_time : '-');
            }, false);

            v.addEventListener('mouseout', function() {
                //this.removeAttribute('filter');
                if (cities[id].owner > 0) {
                    v.setAttribute('opacity', '0.3');
                } else {
                    v.setAttribute('opacity', '0.0');
                }
            }, false);
        }
    });
}, false);
</script>
