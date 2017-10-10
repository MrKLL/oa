<?php
//命名空间
namespace Admin\Controller;
//邮箱功能类
class EmailController extends CommonController{
    //展示发邮件表单且完成发邮件操作
    public function send(){
           if(IS_POST){
            //用户提交了表单
            //接收数据
               $data=I('post.');
               //将发送者id从session中取出,加入数据中
               $data['from_id']=session('id');
               $data['addtime']=time();
               //调用saveData方法完成附件上传和数据入库操作
               D('email')->addData($data,$_FILES['file']) ? $this->success('邮件发送成功',U('sendBox')):$this->error('邮件发送失败,请重试');
           }
           else{
               //用户没有提交表单
               //查询出收件人的信息
               $id=session('id');
               $data=M('user')->field('id,username')->where("id!=$id")->select();
               //分配变量
               $this->assign('data',$data);
               //展示发送邮件表单
               $this->display();
           }
    }
    //发件箱功能
    public function sendBox(){
       //从session中获取当前用户的id
        $id=session('id');
        //查找数据
        $data=M('email')->field('t1.*,t2.truename')->alias('t1')->join('left join sp_user as t2 on t1.to_id=t2.id')->where("from_id=$id")->select();
//        P($data);
        //分配变量
        $this->assign('data',$data);
        //载入模板
        $this->display();
    }
    //收件箱功能
    public function recBox(){
        //从session中获取当前用户的id值
        $id=session('id');
        //连表查询出想要的数据
        $data=M('email')->alias('t1')->field('t1.*,t2.truename')->join('left join sp_user as t2 on t1.from_id=t2.id')->where("to_id=$id")->select();
//        P($data);
        $this->assign('data',$data);
        $this->display();
    }
    public function showContent(){
        //获得此条记录的id
        $id=I('get.id');
        $model=M('email');
        //为了防止用户直接从地址栏输入id值获取他人邮件,条件中加入to_id=当前用户的id
        $data=$model->field('title,content,isread')->where("id=$id and to_id = ".session('id'))->find();
        //修改邮件状态
       !$data['isread'] ? $model->save(array('id' => $id,'isread'=>1)) : '';
        //输出内容信息
        echo $data['content'];
    }
    //下载功能
    public function download(){
        //接收id
        $id=I('get.id');
        //到相应的表中查询出数据
        $data=M('email')->find($id);
        //下载代码
        $file=WORKING_PATH.$data['file'];
        //输出文件
        header("content-type:application/octet-stream");
        header('content-Disposition:attachment;filename="'.basename($file).'"');
        header("content-Length:".filesize($file));
        //输出缓冲图
        $rs=fopen($file,'rb');
//while循环输出文件,feof()函数是检测指针是否到达文件尾部,是返回true,否返回false
        while(!feof($rs)){
            //指针没到文件尾部就读取文件
            echo fread($rs,2048);//1024单位为b,代表每次读取1kb;
        }
    }
}