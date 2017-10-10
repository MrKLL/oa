<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>test4</title>
</head>
<body>
    <?php if($day==6): ?>星期六
        <?php elseif($day==1): ?>
        星期一
        <?php elseif($day==2): ?>
        星期二
        <?php elseif($day==3): ?>
        星期三
        <?php elseif($day==4): ?>
        星期四
        <?php elseif($day==5): ?>
        星期五
        <?php else: ?>
        星期天<?php endif; ?>
</body>
</html>