<?php
//设置字符编码为utf-8
header("content-type:text/html;charset=utf-8");
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
//开启调试模式,项目上线时将其注释
define('APP_DEBUG',true);
//定义常量
define('WORKING_PATH',str_replace('\\','/',__DIR__));//工作目录常量
define('UPLOAD_ROOT_PATH','/Public/Upload/');//上传文件存放根目录
// 定义应用目录
define('APP_PATH','./Application/');
//引入Thinkphp入口文件
include 'ThinkPHP/ThinkPHP.php';
