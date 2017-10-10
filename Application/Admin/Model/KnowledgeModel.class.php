<?php
//命名空间
namespace Admin\Model;
use Think\Model;
use Think\Upload;

//知识模型层
class KnowledgeModel extends Model{
    //完成数据上传和入库操作
    public function saveData($data,$file){
        //操作成功返回保存的数据的主键id值,失败返回false
        return $this->add($this->upload($data,$file));
    }
    //完成数据修改后上传和和入库操作
    public function updateData($data,$file){
        //操作成功返回受影响的行数,失败返回false
        return $this->save($this->upload($data,$file));
    }
    //完成对上传图片的检查和保存及生成缩略图操作
    public function upload($data,$file){
        if($file['error']==0){
            //对上传文件的格式进行判断,是图片格式的就进行处理
            if(substr($file['type'],0,5)=='image'){
                //上传文件存在且没有错误,进行上传操作
                //1.对上传文件进行相关配置
                $config=array(
                    'rootPath'      =>  WORKING_PATH.UPLOAD_ROOT_PATH //保存根路径
                );
                $upload=new  \Think\Upload($config);
                if($info=$upload->uploadOne($file)){
                    //将图片路径和缩略图路径补充到$data数据中
                    $data['picture']=UPLOAD_ROOT_PATH.$info['savepath'].$info['savename'];
                }
                //1.实例化thinkphp自带的图片处理类
                $thumb=new \Think\Image();
                //2.打开图片
                $thumb->open(WORKING_PATH.$data['picture']);
                //3.等比缩放,生成缩略图
                $thumb->thumb(100,100);
                //4.将缩略图保存
                $thumb->save(WORKING_PATH.UPLOAD_ROOT_PATH.$info['savepath'].'thumb_'.$info['savename']);
                //将路径保存在数据库字段中
                $data['thumb']=UPLOAD_ROOT_PATH.$info['savepath'].'thumb_'.$info['savename'];
            }
        }
        //4.返回处理后的数据
        return $data;
    }
}