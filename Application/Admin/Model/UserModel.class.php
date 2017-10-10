<?php
//命名空间
namespace Admin\Model;
use Think\Model;
class UserModel extends Model{
    //表单字段映射,防止黑客从表单中猜测出数据表的结构
    protected $_map=array(
        'aa' =>  'username',
        'bb' =>  'password',
    );
    // // 自动验证定义,必须配合create方法使用
    protected  $_validate = array(
        array('username','require','用户名不能为空'),
        array('password','require','密码不能为空')
    );


}