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
<div class="title"><h2>邮件管理</h2></div>
<div class="table-operate ue-clear">
	<a href="/oa/index.php/Admin/Email/add" class="add">添加</a>
    <a href="javascript:;" class="del">删除</a>
    <a href="javascript:;" class="edit">编辑</a>
    <a href="javascript:;" class="check">审核</a>
</div>
<div class="table-box">
	<table>
    	<thead>
        	<tr>
            	<th class="id">序号</th>
                <th class="name">发件人</th>
				<th class="title">标题</th>
                <th class="file">附件</th>
                <th class="content">内容</th>
				<th class="addtime">发送时间</th>
                <th class="status">状态</th>
                <th class="operate">操作</th>
            </tr>
        </thead>
        <tbody>
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$res): $mod = ($i % 2 );++$i;?><tr>
                <td class="id"><?php echo ($res["id"]); ?></td>
                <td class="name"><?php echo ($res["truename"]); ?></td>
                <td class="title"><?php echo (msubstr($res["title"],0,10)); ?></td>
                <td class="file">
                    <?php echo ($res["filename"]); ?>
                    <?php if(!empty($res["hasfile"])): ?><a href="/oa/index.php/Admin/Email/download/id/<?php echo ($res["id"]); ?>">下载</a><?php endif; ?>
                </td>
                <td class="content"><?php echo (msubstr($res["content"],0,10)); ?></td>
                <td class="addtime"><?php echo (date('Y-m-d H:i:s',$res["addtime"])); ?></td>
                <td class="status">
                    <?php if($res['isread'] == 1 ): ?>已读
                        <?php else: ?>
                        <span style="color:red;">未读</span><?php endif; ?>

                </td>
                <td class="operate">
                    <a href ='javascript:;' data="<?php echo ($res["id"]); ?>" data-title="<?php echo ($res["title"]); ?>" class="show">查看</a>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>

        </tbody>
    </table>
</div>
<div class="pagination ue-clear">
	<div class="pagin-list">
		<?php echo ($page); ?>
	</div>
	<div class="pxofy">共 <?php echo ($count); ?> 条记录</div>
</div>
</body>
<script type="text/javascript" src="/oa/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/oa/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/oa/Public/Admin/js/WdatePicker.js"></script>
<script type="text/javascript" src="/oa/Public/Admin/plugin/layer/layer.js"></script>
<script type="text/javascript">
    //jQuery代码
    $(function(){
        //给查看按钮绑定点击事件
        $('.show').on('click',function(){
            //获取id
            var id = $(this).attr('data');
            //获取公文标题
            var title = $(this).attr('data-title');
            layer.open({
                type: 2,
                title: title,
                shadeClose: true,
                shade: false,   //背景透明
                maxmin:true,//开启最大最小化按钮
                area: ['893px', '500px'],
                content: "/oa/index.php/Admin/Email/showContent/id/" + id, //iframe的url
                end: function(){
                    window.location.href=location.href;
                }
            });
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

$("tbody").find("tr:odd").css("backgroundColor","#eff6fa");

showRemind('input[type=text], textarea','placeholder');
</script>
</html>