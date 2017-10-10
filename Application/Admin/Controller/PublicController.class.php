<?php
//后台登陆登出控制器
//命名空间
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller{
    //展示后台登陆界面
    public function login(){
        //展示模板
        $this->display();
    }
    //验证码方法
    public function captcha(){
        //自定义验证码相关配置
        $config=array(
            'bg'        =>  array(93, 202, 27),  // 背景颜色
            'imageH'    =>  38,               // 验证码图片高度
            'imageW'    =>  95,               // 验证码图片宽度
            'useCurve'  =>  false,            // 是否画混淆曲线
            'useNoise'  =>  false,            // 是否添加杂点
            'fontSize' =>  14,             //验证码字体大小
            'expire'    =>  60,            // 验证码过期时间（s）
            'length'    =>  4,            // 验证码位数
        );
        //实例化验证码类
        $captcha=new  \Think\Verify($config);
        //输出验证码
        $captcha->entry();
    }
    //验证用户登陆方法
    public function checkLogin(){
         //1.先验证验证码是否正确
        //使用I方法接收表单提交的post数据
//        dump(I('post.'));
//        exit();
        //D方法中的参数会连接数据库中的表,同时也会new 参数名的模型类文件
        //例如:D('user')会new UserModel 同时会连接user表(表前缀为sp_)
        $model=D('user');
        //create方法会自动过滤掉在映射字段属性中不存在也和数据库中字段不同的数据
        $data=$model->create();
        $verify=new \Think\Verify();
        if($verify->check(I('post.captcha')))
        {
            //验证码正确
            //使用模板自带自动验证用户表中输入的数据
            if (!$data)
            {
                //返回值为空证明自动验证不通过,输出错误信息并返回上级
                $this->error($model->getError());
            }
            else
                {
                    if ($res = $model->where($data)->find())
                    {
                        //将数据保存在session中,以便后续使用
                        session('username', $res['username']);
                        session('id', $res['id']);
                        session('role_id', $res['role_id']);
                        //用户名和密码验证正确,允许登陆
                        $this->redirect( 'Index/index');
                    } else {
                        //用户名和密码验证失败,返回登陆页面
                        $this->error('用户名或密码不正确!', U('login'), 2);
                    }
                }
        }
        else{
                //验证码错误,跳回登陆界面
                $this->error('验证码错误!', U('login'), 2);
            }
    }
    //实现后台主页退出功能
    public function logout(){
        //清除session
        session(null);
        $this->redirect('login');
    }
    public function _empty(){
        $this->display('Empty/error');
    }

}