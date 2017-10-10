<?php
return array(
        /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',          // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'db_oa',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',      // 密码
    'DB_PORT'               =>  '3306',      // 端口
    'DB_PREFIX'             =>  'sp_',          // 数据库表前缀
    'DB_PARAMS'          	=>  array(),     // 数据库连接参数
    'DB_DEBUG'  			=>  TRUE,        // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        =>  0,           // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         =>  1,           // 读写分离后 主服务器数量
    'DB_SLAVE_NO'           =>  '',          // 指定从服务器序号
    //开启调试工具
    'SHOW_PAGE_TRACE'      => true,
    //'配置项'=>'配置值'
    'TMPL_PARSE_STRING'=>array(
        '__ADMIN__'=>__ROOT__.'/Public/Admin'
    ),
    //RBAC权限控制
    'RBAC_ROLES' => array(
                           '1'=>'高层管理',
                           '2'=>'中层管理',
                           '3'=>'在职员工'
                            ),
    //RBAC权限组
    'RABC_ROLE_AUTHS'=>array(
                            '1'=>'*/*',//表示拥有所有权限
                            '2'=>array('index/*','doc/*','user/*','knowledge/*'),
                            '3'=>array('index/*','email/*','dept/add','dept/insert')
                            ),
    //设置默认访问的模块 控制器 方法;
    'DEFAULT_MODULE'        =>  'Admin',  // 默认模块
    'DEFAULT_CONTROLLER'    =>  'Public', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'login', // 默认操作名称
);