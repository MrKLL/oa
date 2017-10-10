<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>test3</title>
</head>
<body>

<?php if(is_array($arr)): $i = 0; $__LIST__ = $arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; echo ($v); ?>-<?php endforeach; endif; else: echo "" ;endif; ?>

<hr/>
<?php if(is_array($arr)): foreach($arr as $key=>$v): echo ($v); ?>-<?php endforeach; endif; ?>
<hr/>

<hr/>
foreach:
<?php if(is_array($arrs)): foreach($arrs as $k=>$aa): echo ($k); endforeach; endif; ?>

</body>
</html>