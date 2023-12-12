<?php
if (!isset($_SESSION['uid'])) {
    $_SESSION['msg'] = '您还未登录系统，请先登录系统，3秒后跳转回登录页面';
    $_SESSION['url'] = 'login.php';
    header('location:msgPage.php');
    exit;
}