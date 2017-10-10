<?php
namespace Admin\Controller;
use Think\Controller;
//当控制器不存在的时候默认进入此控制器
class EmptyController extends Controller{
    //空操作方法当方法不存在的时候默认访问
    public function _empty(){
        $this->display('Empty/error');
    }
}