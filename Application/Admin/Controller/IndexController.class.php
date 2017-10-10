<?php
//命名空间
namespace Admin\Controller;
//后台主页控制器
class IndexController extends CommonController{
    //显示后台主页
    public function index(){
        //展示模板
        $this->display();
    }
}