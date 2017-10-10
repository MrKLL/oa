<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/oa/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/oa/Public/Admin/css/info-mgt.css" />
<link rel="stylesheet" href="/oa/Public/Admin/css/WdatePicker.css" />
<title>移动办公自动化系统</title>
</head>

<body>
<div class="title"><h2>信息管理</h2></div>
<div class="table-operate ue-clear">
	<a href="add" class="add">添加</a>
    <a href="javascript:;" class="del">删除</a>
    <a href="javascript:;" class="edit">编辑</a>
    <a href="javascript:;" class="count">统计</a>
    <a href="javascript:;" class="check">审核</a>
</div>
<div class="table-box">
	<table>
    	<thead>
        	<tr>
            	<th class="num">序号</th>
                <th class="name">部门</th>
                <th class="process">所属部门</th>
                <th class="node">排序</th>
                <th class="time">备注</th>
                <th class="operate">操作</th>
            </tr>
        </thead>
        <tbody>
        <?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$res): $mod = ($i % 2 );++$i;?><tr>
                <td class="num" style="position:relative;">
                    <input type="checkbox" name="deptid" value="<?php echo ($res["id"]); ?>" style="position:absolute;bottom:4px;right:42px;height:14px;"/>
                    <?php echo ($res["id"]); ?>
                </td>

                <td class="name">
                    <?php echo (str_repeat('&emsp;',$res["level"])); ?>
                    <?php echo ($res["name"]); ?>
                </td>
                <td class="process">
                    <?php if($res["pid"] == 0): ?>顶级部门
                    <?php else: ?>
                        <?php echo ($res["deptname"]); endif; ?>
                </td>
                <td class="node"><?php echo ($res["sort"]); ?></td>
                <td class="time"><?php echo ($res["remark"]); ?></td>
                <td class="operate">
                    <a href="javascript:;">查看</a>
                    <a href="edit/id/<?php echo ($res["id"]); ?>" class="edit">编辑</a>
                    <a href="delete/id/<?php echo ($res["id"]); ?>" onclick="javascript:return confirm('您确定要删除这个部门吗?')" class="delete">删除</a>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>

        </tbody>
    </table>
</div>
<div class="pagination ue-clear"></div>
</body>
<script type="text/javascript" src="/oa/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/oa/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/oa/Public/Admin/js/WdatePicker.js"></script>
<script type="text/javascript" src="/oa/Public/Admin/js/jquery.pagination.js"></script>
<script type="text/javascript">
    //jquery实现获取复选框的值
$(function(){
    $('.del').on('click',function(){
        //事件处理程序
       var idObj=$(':checkbox:checked');
       var id='';
       for(var i=0; i<idObj.length;i++){
           id += idObj[i].value + ',';
       }

       id = id.substring(0,id.length-1);
       window.location.href= 'delete/id/' + id;
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

$('.pagination').pagination(100,{
	callback: function(page){
		alert(page);	
	},
	display_msg: true,
	setPageNo: true
});

$("tbody").find("tr:odd").css("backgroundColor","#eff6fa");

showRemind('input[type=text], textarea','placeholder');
</script>
</html>