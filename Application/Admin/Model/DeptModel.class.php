<?php
//命名空间
namespace Admin\Model;
use Think\Model;
//部门模型
class DeptModel extends Model{
    // 字段映射定义,防止黑客从表单name值猜测数据库表的字段设置
    protected $_map             =   array(
    );
    // 自动验证定义,必须配合create方法使用
    protected $_validate        =   array(
        array('name','require','部门名称不能为空'),//验证部门名称是否为空
        array('name','','部门已经存在',0,'unique'),//验证部门名称是否已经存在
        array('sort','number','排序必须输入数字')//验证排序输入数据是否为数字
    );
    //分层显示部门列表
    public function tree($arr,$pid=0,$level=0){
        static $res=array();
        foreach($arr as $v)
        {
            if($v['pid']==$pid)
            {
                $v['level']=$level;
                $res[]=$v;
                $this->tree($arr,$v['id'],$level+1);
            }
        }
        return $res;
    }
}