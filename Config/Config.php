<?php
/**
 * 全局配置文件目录
 */
return array(
    'database' => array(
        'type' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'dbname' => 'tbhzhuxu01',
        'charset' => 'utf8',
        'user' => 'tbhzhuxu01',
        'pwd' => '935953957A4900'
    ),
    'app' => array(
        'default_platform' => 'Home',
        'default_controller' => 'Login',
        'default_action' => 'Login',

        //上传文件路径
        'upload_path'  =>     './Public/Uploads',
        'upload_size'  =>     1024*1024,
        'upload_type'  =>     array('image/png','image/jpeg','image/gif'),

        //cookie秘钥
        'key'          =>     'abc',
        'pagesize'     =>      10

    )
);