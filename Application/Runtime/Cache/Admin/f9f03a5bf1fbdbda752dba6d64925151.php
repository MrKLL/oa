<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/oa/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/oa/Public/Admin/css/info-mgt.css" />
<link rel="stylesheet" href="/oa/Public/Admin/css/WdatePicker.css" />
<title>移动办公自动化系统</title>
<style type='text/css'>
	table tr .id{ width:63px; text-align: center;}
	table tr .name{ width:118px; padding-left:17px;}
	table tr .nickname{ width:63px; padding-left:17px;}
	table tr .dept_id{ width:63px; padding-left:13px;}
	table tr .sex{ width:63px; padding-left:13px;}
	table tr .birthday{ width:80px; padding-left:13px;}
	table tr .tel{ width:113px; padding-left:13px;}
	table tr .email{ width:160px; padding-left:13px;}
	table tr .addtime{ width:160px; padding-left:13px;}
	table tr .operate{ padding-left:13px;}
</style>
</head>

<body>
<div class="title"><h2>信息管理</h2></div>
<div class="table-operate ue-clear">
	<a href="/oa/index.php/Admin/User/add" class="add">添加</a>
    <a href="javascript:;" class="del">删除</a>
    <a href="/oa/index.php/Admin/User/edit" class="edit">编辑</a>
    <a href="/oa/index.php/Admin/User/charts" class="count">统计</a>
    <a href="javascript:;" class="check">审核</a>
</div>
<div class="table-box">
	<table>
    	<thead>
        	<tr>
            	<th class="id">序号</th>
                <th class="name">姓名</th>
				<th class="nickname">昵称</th>
                <th class="dept_id">所属部门</th>
				<th class="sex">性别</th>
				<th class="birthday">生日</th>
                <th class="tel">电话</th>
				<th class="email">邮箱</th>
                <th class="addtime">添加时间</th>
                <th class="operate">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$res): $mod = ($i % 2 );++$i;?><tr>
                    <td class="id" style="position:relative;">
                        <input type="checkbox" name="id" value="<?php echo ($res["id"]); ?>" style="position:absolute;bottom:4px;right:34px;height:14px;"/>
                        <?php echo ($res["id"]); ?>
                    </td>
                    <td class="name"><?php echo ($res["username"]); ?></td>
                    <td class="nickname"><?php echo ($res["nickname"]); ?></td>
                    <td class="dept_id"><?php echo ($res["deptname"]); ?></td>
                    <td class="sex"><?php echo ($res["sex"]); ?></td>
                    <td class="birthday"><?php echo ($res["birthday"]); ?></td>
                    <td class="tel"><?php echo ($res["tel"]); ?></td>
                    <td class="email"><?php echo ($res["email"]); ?></td>
                    <td class="addtime"><?php echo (date('Y-m-d H:i:s',$res["addtime"])); ?></td>
                    <td class="operate">
                        <a href="/oa/index.php/Admin/User/edit/id/<?php echo ($res["id"]); ?>">编辑</a>
                        <a href="/oa/index.php/Admin/User/delete/id/<?php echo ($res["id"]); ?>" onclick="javascript:return confirm('您真的要删除此员工的信息吗')" >删除</a>

                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<div class="pagination ue-clear">
	<div class="pagin-list">
		<?php echo ($page); ?>
	</div>
	<div class="pxofy">显示第 <?php echo ($start); ?> 条到 <?php echo ($end); ?>条记录，总共<?php echo ($count); ?>条记录</div>
</div>
</body>
<script type="text/javascript" src="/oa/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/oa/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/oa/Public/Admin/js/WdatePicker.js"></script>
<script type="text/javascript">
    $(function(){
        $('.del').on('click',function(){
            //事件处理程序
            var idObj=$(':checkbox:checked');
            var id='';
            for(var i=0; i<idObj.length;i++){
                id += idObj[i].value + ',';
            }

            id = id.substring(0,id.length-1);
            window.location.href= '/oa/index.php/Admin/User/delete/id/' + id;
        });
    });
$(".select-title").on("click",function(){
	$(".select-list").hide();
	$(this).siblings($(".select-list")).show();
	return false;
})
$(".select-list").on("click","li",function(){
	var txt = $(this).text();
	$(this).parent($(".select-list")).siblings($(".select-title")).find("span").text(txt);
})

// $('.pagination').pagination(100,{
// 	callback: function(page){
// 		alert(page);	
// 	},
// 	display_msg: true,
// 	setPageNo: true
// });

$("tbody").find("tr:odd").css("backgroundColor","#eff6fa");

showRemind('input[type=text], textarea','placeholder');
</script>
</html>