<?php
//命名空间
namespace Admin\Model;
use Think\Model;
//邮箱模型类
class EmailModel extends Model{
    //发送邮件,完成数据入库
    public function addData($data,$file){
        return $this->add($this->upload($data,$file));
    }
    //完成数据上传操作
    public function upload($data,$file){
        //有上传文件,进行相应处理
        if($file['error']==0){
            //设置上传目录配置
            $config=array(
                'rootPath'      =>  WORKING_PATH.UPLOAD_ROOT_PATH //保存根路径
            );
            //实例化上传类

            $upload=new \Think\Upload($config);
            //调用上传类中uploadOne方法进行文件上传

            if($info=$upload->uploadOne($file)){
                //上传成功
                //补齐数据表中相应字段
                $data['filename']=$info['name'];
                $data['hasfile']=1;
                $data['file']=UPLOAD_ROOT_PATH.$info['savepath'].$info['savename'];
            }
        }
        return $data;
    }
}