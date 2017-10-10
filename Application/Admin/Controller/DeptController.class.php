<?php
//命名空间
namespace Admin\Controller;
//部门控制器
class DeptController extends CommonController{
    //部门展示方法
    public function showList(){
        $deptModel=M('dept');
        //查询结果
        $result=$deptModel->order('sort asc')->select();
        //使用第一种方法:load方法手段载入Admin/common中的无限分类tree.php文件
        //第二种方法在DeptModel模型中编写tree方法,在实例化后调用tree方法完成无限分类
        //第三种方法在应用级别的函数库文件function.php中编写tree函数来完成此操作
        load('@/tree');
        $result=tree($result);
        //遍历得出pid对应的部门名称,以便在表单中使用(也可采取连表查询的方式)
        foreach($result as $k=>$v){
            if($v['pid'] > 0 ){
                $arr=$deptModel->field('name')->find($v['pid']);
                $result[$k]['deptname']=$arr['name'];
            }
        }
        $this->assign('result',$result);
        $this->display();
    }
    //显示部门添加表单
    public function add(){
        $deptModel=D('dept');
        $result=$deptModel->select();
        //调用自身模型类中的方法实现无限分类展示上级部门(第二种方法)
        $result=$deptModel->tree($result);
//        dump($result);
        $this->assign('result',$result);
        $this->display();
    }
    //完成部门信息添加
    public function insert(){
            //第一种方式采用I方法快速接受post数据
            //$data=I('post.');
            $deptModel=D('Dept');
            //第二种方法采用数据对象的方式来接收数据
            //通过create()方法,可以传递参数,也可以不传递参数,不传递,默认接收post中的数据
            //此方法有返回值,可以接收也可以不接收,因为add方法没有接收数据时
            //默认找父类的data属性中的值
            if(!$deptModel->create()){
                $this->error($deptModel->getError());
            }else {
                $deptModel->add() ? $this->success('部门添加成功', U('showList'), 2) : $this->error('部门添加失败,请重新添加', U('add'), 2);
            }
    }
    //显示部门修改表单,并完成修改操作
    public function edit(){
        //是post请求说明是表单提交
        if(IS_POST)
            {
                //获取post数据
                $data=I('post.');
                //实例化父类
                $model=M('dept');
                if($model->save($data)){
                    //修改成功,跳回列表展示页面
                    $this->success('部门修改成功!',U('showList'),2);
                }else{
                    //修改失败,返回修改表单
                    $this->error('修改失败,请重新修改');
                }
            }
        else
            {
                //接受url传递过来的id值,并通过加法运算将其转为整形
                $id=I('get.id')+0;
                //实例化父类,以便使用其中方法完成数据读取和更新操作
                $model=D('dept');
                //通过id查询数据
                $data=$model->find($id);
                //查询上级部门信息,分析得出除去本部门都可以为上级部门
                $info=$model->where("id != $id")->select();
                //调用tree方法对数据进行重新排列
                $info=$model->tree($info);
                //P($info);
                //分配数据
                $this->assign('data',$data);
                $this->assign('info',$info);
                //显示修改表单
                $this->display();
            }

    }
    //完成部门删除操作
    public function delete(){
        //接收url传递过来的多个id值组成的字符串
        $id=I('get.id');
        $model=M('dept');
        //完成删除操作
        $model->delete($id) ? $this->success('删除部门成功',U('showList'),2) : $this->error('删除失败,请重新操作!');
    }

}