<?php
//用递归实现无限分类
function tree($arr,$pid=0,$level=0){
    static $res=array();
    foreach($arr as $v)
    {
        if($v['pid']==$pid)
        {
            $v['level']=$level;
            $res[]=$v;
            tree($arr,$v['id'],$level+1);
        }
    }
    return $res;
}