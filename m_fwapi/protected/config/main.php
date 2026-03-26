<?php

return [
    // application data
    'name'=>'MyWeb',
    'version'=>'1.0.0',

    'defaultController'=>'Index',
    'defaultAction'=>'index',

    // url manager
    'urlManager'=>[
        'urlFormat'=>'shortPath',  /* get | path | shortPath */
        'rules'=>[
        ],
    ],

    // server data
    'server'=>[
        'version'=>'fw.608',
        'zoneid'=>2,
        'aid'=>19,
        'path'=>'/root/fw',
        'startingLogsPath'=>'/root/logs/starting/',
        'chat_file' => '/root/logs/****/world2.chat',
    ],

    // ssh manager
    'ssh'=>[
        'enable'=>true,
        'host'=>'127.0.0.1',
        'port'=>22,
        'username'=>'root',
        'password'=>'123456',
        'connectionType'=>'password', /* password | public_key */
    ]
];