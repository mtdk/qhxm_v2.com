<?php
session_start();
// 设置默认值为空字符串
$_SESSION['uid'] = '';
$_SESSION['username'] = '';

// 检查消息和URL变量是否存在
$_SESSION['msg'] = null;
$_SESSION['url'] = null;
session_destroy();
header('location:login.php');
exit;