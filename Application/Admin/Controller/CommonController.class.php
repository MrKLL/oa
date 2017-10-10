<?php
//命名空间
namespace Admin\Controller;
use Think\Controller;
//基础控制器,判断用户的登陆状态
class CommonController extends Controller{
    //此处不选用php自带的构造方法,因为使用其后,继承自本类的子类需要使用此类的父类的方法
    //就必须先实例化此类的父类,所以此处选用thinkphp自带的_initialize()：该方法有ThinkPHP提供，不需要构造父类。
    public function _initialize(){
        $id=session('id');
        if(empty($id)){
            $this->redirect('Admin/Public/login');
        }
        //获取权限id
        $role_id=session('role_id');
        //使用C方法获取当前用户的权限信息
        $currRoleAuth=C('RABC_ROLE_AUTHS')[$role_id];
//        P($currRoleAuth);
        //获取当前控制器名和方法名,并全部小写
        $controller=strtolower(CONTROLLER_NAME);
        $action=strtolower(ACTION_NAME);
        //判断当前用户是否有权限访问某个控制器或方法
        //超级管理员拥有所有权限,不进行判断
        if($role_id>1){
        if(!in_array($controller.'/*',$currRoleAuth) && !in_array($controller.'/'.$action,$currRoleAuth)){
            //在权限数组中找不到对应的值,证明没有权限
            //没有权限,跳回上级页面
            $this->error('很抱歉,您无权访问');
        }
        }
    }
}