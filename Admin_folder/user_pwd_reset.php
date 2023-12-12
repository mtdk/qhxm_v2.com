<?php
include __DIR__ . '/../db/db.php';
session_start();
$_SESSION['url'] = null;
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $uid = trim(base64_decode(htmlspecialchars($_GET['uid'])));
    $new_user_pwd = 'abc123456';       // 用户的原始密码

    if (empty($uid)) {
        $_SESSION['msg'] = "用户ID不能为空";
    } else {
        // 提交数据
        $database = new Database();
        // 定义要修改的数据
        $data = array(
            'userpwd' => password_hash($new_user_pwd, PASSWORD_DEFAULT),
        );
        // 定义修改条件
        $where = array('uid' => $uid);

        // 执行修改操作
        $table = 'tb_users';
        $affectedRows = $database->update($table, $data, $where);

        if ($affectedRows < 0) {
            $_SESSION['msg'] = "密码重置失败了！";
        }elseif ($affectedRows>0){
            $_SESSION['msg'] = "密码已重置，当前密码是：" . $new_user_pwd;
        } else {
            $_SESSION['msg'] = "已是原始密码，无需重置！";
        }
    }
    $_SESSION['url'] = 'user_info_query.php';
} else {
    // err_msg
    $_SESSION['msg'] = "错误的提交方式，危险的操作，将自动退出登录！！！";
    $_SESSION['url'] = 'admin_logout.php';
}
header('location:admin_msgPage.php');
die();