<?php
//命名空间
namespace Admin\Model;
use Think\Model;
class DocModel extends Model{
    //保存上传数据方法
    public function saveData($data,$file){
        //完成添加数据操作,并返回结果
        return $this->add($this->upload($data,$file));

    }
    //更新上传数据方法
    public function UpdateData($data,$file){
        //进行数据更新操作并返回返回值
        return $this->save($this->upload($data,$file));
    }
    //对上传数据进行检查和上传
    public function upload($data,$file){
        //判断是否上传文件是否有错误,没有错误开始上传
        if($file['error']==0){
            //设置配置项
            $config=array(
                'rootPath'      =>  WORKING_PATH.UPLOAD_ROOT_PATH //保存根路径
            );
            //实例化系统自带上传类
            $upload=new \Think\Upload($config);
            //使用上传类中upload方法完成上传操作
            //P($upload->uploadOne($file));
            if($info=$upload->uploadOne($file)){
                //上传成功
                $data['filepath']=UPLOAD_ROOT_PATH.$info['savepath'].$info['savename'];
                $data['filename']=$info['name'];
                $data['hasfile']=1;
            }
        }
        return $data;
    }
}