<?php
//命名空间
namespace Admin\Controller;
class UserController extends CommonController{
    //展示部门员工列表
    public function showList(){

        $model=M('user');//1.实例化父类
        $count=$model->count();//2.获取数据表中总的记录数
        //3.实例化分页类,需要传递数据表中数据总记录数和自定义每页显示记录数(默认20条)
        $page=new \Think\Page($count,5);
        //4.定制显示分页提示的文字
        $page->rollPage   = 5;// 分页栏每页显示的页数
        $page->lastSuffix = false; // 最后一页是否显示总页数
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('first','首页');
        $page->setConfig('last','尾页');
        $show=$page->show();//5.通过show方法输出分页页码的链接
        //6.使用limit方法进行分页查询,注意参数是page类的属性
        //6.1使用join方法进行两个表的连接查询,alias方法指定表的别名
        //6.1.1采用两个不同的表连接进行查询(方法一)
        $data=$model->alias('t1')->field('t1.*,t2.name as deptname')->join('left join sp_dept as t2 on t1.dept_id=t2.id')->limit($page->firstRow ,$page->listRows)->select();
        //6.1.2采用一个表进行自连接来查询结果
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
    //展示修改表单,并完成修改员工信息操作
    public function edit(){
        //从是否有post数据判断用户是否存在表单提交
        if(IS_POST){
            //用户提交了表单,接收数据
            $model=D('user');
            $data=$model->create();
            if(!$data){
                //验证字段不通过,所以返回值为空,返回修改表单重新填写
                $this->error($model->getError());
            }
            else
             {
                //自动验证没有问题,将数据插入数据库中
                //进行更新操作一定要指定条件,sava方法中传递的数据中没有主键是不会执行的
                 $model->save($data) ? $this->success('修改成员信息成功',U('showList'),2) : $this->error('修改成员信息失败,请重新修改');
             }
        }else{
            //用户没有提交表单,展示表单让用户填写
            //获取部门信息并展示
            $id=I('get.id');
//            P($id);
            $model=M('user');
            $data=$model->alias('t1')->field('t1.*,t2.name')->join('left join sp_dept as t2 on t1.dept_id=t2.id')->where("t1.id=$id")->find();
            //分配数据
            $this->assign('data',$data);
            $this->display();
        }

    }
    //展示添加员工信息表单,并完成添加员工信息操作
    public function add(){
        //从是否有post数据判断用户是否存在表单提交
        if(IS_POST){
            //用户提交了表单,接收数据
            //采用thinkphp自带验证机制进行验证
            $model=D('user');
            //此方法会把数据保存在data属性中,并返回处理后的数据
            $data=$model->create();
            //返回值为空,说明自动验证出错,显示错误信息并返回添加界面
            if(!$data){
                $this->error($model->getError());
            }else{
                //返回值为真,使用add方法将数据添加到数据库中
                //add方法不传值默认获取data属性的值
                //增加添加时间字段
                $data['addtime']=time();
                $model->add($data) ? $this->success('员工信息添加成功',U('showList'),2) : $this->error('员工信息添加失败,请重试');
            }
        }else{
            //用户没有提交表单,展示表单让用户填写
            //获取部门信息并展示
            $model=M('dept');
            $data=$model->select();
            //分配数据
            $this->assign('data',$data);
            $this->display();
        }
    }
    //展示统计图表
    public function charts(){
        //实例化对象
        $model=M('user');
        //获取需要的数据
        $data=$model->field('name,count(*) as count')->alias('t1')->join('left join sp_dept as t2 on t1.dept_id=t2.id')->group('t1.dept_id')->select();
        //对数据进行拼接,得到一定格式的数据
        $str='[';
        foreach($data as $v){
            $str.="['".$v['name']." ', ".$v['count']."],";
        }
        $str=rtrim($str,',');
        $str.=']';
        //对数据进行配置变量
        $this->assign('str',$str);
        //载入数据变量,展示模板
        $this->display();
    }
    //完成删除操作
    public function delete(){
        //接收传递过来需要删除的数据的id值
        $id=I('get.id');
        //判断用户是否勾选了
        if(!$id){
            $this->error('请勾选您想要删除的成员信息');
        }else{
            $model=M('user');
            $model->delete($id)?$this->success('删除成员信息成功',U('showList'),2) : $this->error('删除成员信息失败,请重新删除');
        }
    }
}