<?php
//命名空间
namespace Admin\Controller;
//知识管理类
class KnowledgeController extends CommonController{
    //展示知识列表方法
    public function showList(){
        $data=M('knowledge')->select();
        $this->assign('data',$data);
        $this->display();
    }
    //添加知识方法
    public function add(){
        if(IS_POST){
            //用户提交了表单
            //1.接收数据
            $data=I('post.');
            //2.添加当前时间到数据中
            $data['addtime']=time();
            //调用模板中saveDate方法完成数据上传和数剧入库操作
            D('knowledge')->saveData($data,$_FILES['thumb']) ? $this->success('知识添加成功',U('showList'),2) : $this->error('知识添加失败,请重试');

        }else{
            //展示表单
            $this->display();
        }

    }
    //展示修改知识表单且完成修改知识方法
    public function edit(){
        if(IS_POST){
            //用户提交表单,接收数据
            $data=I('post.');
            //调用模型层updateData方法进行数据的更新操作
            D('knowledge')->updateData($data,$_FILES['file']) ? $this->success('更新公文信息成功',U('showList',2)) : $this->error('很抱歉,更新公文信息失败,请重试');
        }else{
            //载入表单并显示数据给用户修改
            $id=I('get.id');
            //实例化对象并调用查询方法查询对应id的数据
            $data=M('knowledge')->find($id);
            //分配变量
            $this->assign('data',$data);
            //载入模板展示
            $this->display();
        }

    }
    //删除知识数据方法
    public function delete(){
        //接收传递过来需要删除的数据的id值
        $id=I('get.id');
        //判断用户是否勾选了
        if(!$id){
            $this->error('请勾选您想要删除的成员信息');
        }else{
            $model=M('knowledge');
            $model->delete($id)?$this->success('删除成员信息成功',U('showList'),2) : $this->error('删除成员信息失败,请重新删除');
        }
    }
    //下载图片方法
    public function download(){
        //接收id
        $id=I('get.id');
        //到相应的表中查询出数据
        $data=M('knowledge')->find($id);
        //下载代码
        $file=WORKING_PATH.$data['picture'];
        //输出文件
        header("content-type:application/octet-stream");
        header('content-Disposition:attachment;filename="'.basename($file).'"');
        header("content-Length:".filesize($file));
        //输出缓冲图
        readfile($file);

    }

}