<?php
return array(
    // url manager
    'urlManager'=>array(
        'rules'=>array(
            'role-edit'=>'admin/roleedit',
            'user-info'=>'admin/userinfo',
            'send-mail'=>'admin/sendmail',
            'send-message'=>'admin/sendmessage',
            'server-management'=>'admin/servermanagement',
        ),
    ),

    'components'=>array(
        'monitoring'=>array('enable'=>false, 'class'=>'Monitoring'),
    ),

    'monitoring'=>array(
        'services'=>array('authd', 'gamedbd', 'gacd', /*'gfactiond',*/ 'gdeliveryd', 'glinkd', 'logservice', 'uniquenamed'),
    ),
);
