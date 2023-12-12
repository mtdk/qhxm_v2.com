<?php
include __DIR__ . '/../Users_session/user_session.php';
include __DIR__ . '/../db/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid = trim(htmlspecialchars(strip_tags($_POST['uid'])) ?? '');
    $upassword = trim(htmlspecialchars(strip_tags($_POST['upassword'])) ?? '');
    $remember_me = trim(htmlspecialchars($_POST['remember_me']));    // 用户是否选择记住我
    if ($uid == '' || $upassword == '') {
        $_SESSION['msg'] = '用户姓名和密码不能为空，3秒后跳转回登录页面';
        $_SESSION['url'] = '../login.php';
        header('location:../msgPage.php');
        die();
    }
    $database = new Database();
    $table = 'tb_users';
    $condition = "uid = :uid";
    $params = array(':uid' => $uid);
// 定义要查询的字段
    $fields = array('uid', 'username', 'userpwd', 'department_id', 'role_id');
// 查询数据
    $results = $database->select($table, $condition, $params, $fields);
    if ($results) {
        if (!password_verify($upassword, $results[0]['userpwd'])) {
            $_SESSION['msg'] = '密码错误，3秒后跳转回登录页面';
            $_SESSION['url'] = '../login.php';
        } else {
            $_SESSION['uid'] = $uid;
            $_SESSION['username'] = $results[0]['username'];
            $_SESSION['department_id'] = $results[0]['department_id'];
            $_SESSION['role_id'] = $results[0]['role_id'];
            if ($remember_me == '0') {
                setcookie("remember_myid", $uid, time() + 3600);
                setcookie("uspasswd", $upassword, time() + 3600);
            } else {
                setcookie("remember_myid", '');
                setcookie("uspasswd", '');
            }
            $_SESSION['msg'] = '登录成功，3秒后跳转到系统首页';
            $_SESSION['url'] = '../index.php';
        }
    } else {
        $_SESSION['msg'] = '用户信息不存在，3秒后跳转回登录页面';
        $_SESSION['url'] = '../login.php';
    }
} else {
    $_SESSION['msg'] = '错误的提交方式，危险的操作！！！3秒后跳转回登录页面';
    $_SESSION['url'] = '../login.php';
}
header('location:../msgPage.php');