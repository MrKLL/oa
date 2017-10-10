<?php
//命名空间
namespace Admin\Controller;
//公文处理类
class DocController extends CommonController{
    //展示公文列表
    public function showList(){
        //1.实例化父类
        $model=M('doc');
        //2.获取数据表中总的记录数
        $count=$model->count();
        //3.实例化分页类,需要传递数据表中数据总记录数和自定义每页显示记录数(默认20条)
        $page=new \Think\Page($count,5);
        //4.定制显示分页提示的文字
        $page->rollPage   = 5;// 分页栏每页显示的页数
        $page->lastSuffix = false; // 最后一页是否显示总页数
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('first','首页');
        $page->setConfig('last','尾页');
        //5.通过show方法输出分页页码的链接
        $show=$page->show();
        //6.使用limit方法进行分页查询,注意参数是page类的属性
        $data=$model->limit($page->firstRow ,$page->listRows)->select();
        //7.使用assign方法将查询到的数据分配变量传递给模板
        $this->assign('data',$data);//根据分页所需取出的所有数据
        $this->assign('page',$show);//输出整个分页模板
        $start=$page->firstRow+1;
        $this->assign('start',$start);//开始的数据条数
        $end=$page->listRows+$page->firstRow;
        $end=$end<$count ? $end : $count;//对末页的数值进行判断防止其超过总的记录数
        $this->assign('end',$end);//结束的数据条数
        $this->assign('count',$count);//总的数据记录数
        //8.到模板中输出
        $this->display();
    }
    //完成添加公文操作
    public function add(){
        //从是否有post数据判断用户是否存在表单提交
        if(IS_POST){
            //用户提交了表单,接收数据
//            P($_FILES['file']);
            $data=I('post.');
            //采用thinkphp自带验证机制进行验证
            $data['addtime']=time();
//           P($data);
            $model=D('doc');
            $model->saveData($data,$_FILES['file']) ? $this->success('公文添加成功',U('showList'),2) : $this->error('公文添加失败,请重试');
        }else{
            //用户没有提交表单,展示表单让用户填写
            $this->display();
        }
    }
    //完成编辑公文操作
    public function edit(){
        if(IS_POST){
            //用户提交表单,接收数据
            $data=I('post.');
            //获取上传文件信息
            $file=$_FILES['file'];
            //调用模型层updateData方法进行数据的更新操作
            D('doc')->updateData($data,$file) ? $this->success('更新公文信息成功',U('showList',2)) : $this->error('很抱歉,更新公文信息失败,请重试');
        }else{
            //载入表单并显示数据给用户修改
            $id=I('get.id');
            //实例化对象并调用查询方法查询对应id的数据
            $data=M('doc')->find($id);
            //分配变量
            $this->assign('data',$data);
            //载入模板展示
            $this->display();
        }

    }
    //完成删除公文操作
    public function delete(){
        $id=I('get.id');
        M('doc')->delete($id) ? $this->success('删除公文成功',U('showList'),2) : $this->error('删除公文失败,请重试');
    }
    //完成附件下载操作
    public function download(){
        //接收id
        $id=I('get.id');
        //到相应的表中查询出数据
        $data=M('doc')->find($id);
        //下载代码
        $file=WORKING_PATH.$data['filepath'];
        //输出文件
        header("content-type:application/octet-stream");
        header('content-Disposition:attachment;filename="'.basename($file).'"');
        header("content-Length:".filesize($file));
        //输出缓冲图
        readfile($file);
    }
    //使用layer插件展示公文内容详情
    public function showContent(){
        //接收url中的id值
        $id=I('get.id');
        //实例化模型并查找数据
        $data=M('doc')->field('content')->find($id);
        //在进行数据添加操作的时候通过I方法接收数据会使用系统函数htmlspecialchars
        //进行实体字符转义防止sql注入攻击,所以此处数据需要使用 htmlspecialchars_decode函数
        //进行解码输出
        echo  htmlspecialchars_decode($data['content']);
    }
}