<?php
include __DIR__ . '/../db/db.php';
session_start();
$_SESSION['url'] = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_uid = trim(htmlspecialchars($_POST['admin_uid']) ?? '');
    $old_passwd = trim(htmlspecialchars($_POST['old_passwd']) ?? '');
    $new_passwd = trim(htmlspecialchars($_POST['new_passwd']) ?? '');
    $replay_passwd = trim(htmlspecialchars($_POST['replay_passwd']) ?? '');

    if (empty($admin_uid)) {
        $_SESSION['msg'] = "用户ID不能为空";
    } elseif (empty($old_passwd)) {
        $_SESSION['msg'] = "原密码不能为空";
    } elseif (!admin_pwd_check($admin_uid, $old_passwd)) {
        $_SESSION['msg'] = "用户原密码不正确";
    } elseif (empty($new_passwd)) {
        $_SESSION['msg'] = "新密码不能为空";
    } elseif (empty($replay_passwd)) {
        $_SESSION['msg'] = "确认密码不能为空";
    } elseif ($new_passwd != $replay_passwd) {
        $_SESSION['msg'] = "两次密码输入不一致";
    } else {
        if (admin_pwd_update($admin_uid, $new_passwd)) {
            $_SESSION['msg'] = "密码修改成功！请退出后重新登录！";
        } else {
            $_SESSION['msg'] = "密码修改失败了！";
        }
    }
    $_SESSION['url'] = 'admin_pwd_update.php';
} else {
    $_SESSION['msg'] = "错误的提交方式，危险的操作，将自动退出登录！！！";
    $_SESSION['url'] = 'admin_logout.php';
}
header('location:admin_msgPage.php');

/**
 * @param string $admin_uid 用户id
 * @param string $old_pwd 要验证的密码
 * @return bool 验证结果,验证通过返回true,验证失败返回false
 */
function admin_pwd_check(string $admin_uid, string $old_pwd): bool
{
    $database = new Database();
    $table = 'tb_admin';
    $condition = "admin_id = :admin_id";
    $params = array(':admin_id' => $admin_uid);
    // 定义要查询的字段
    $fields = array('admin_pwd');
    // 查询数据
    $results = $database->select($table, $condition, $params, $fields);
    if (!password_verify($old_pwd, $results[0]['admin_pwd'])) {
        return false;
    } else {
        return true;
    }
}

/**
 * @param string $admin_id 用户id
 * @param string $new_pwd 新密码
 * @return bool 更新成功返回true,更新失败返回false
 */
function admin_pwd_update(string $admin_id, string $new_pwd): bool
{
    // 提交数据
    $database = new Database();
    // 定义要修改的数据
    $data = array(
        'admin_pwd' => password_hash($new_pwd, PASSWORD_DEFAULT),
    );
    // 定义修改条件
    $where = array('admin_id' => $admin_id);
    // 执行修改操作
    $table = 'tb_admin';
    $affectedRows = $database->update($table, $data, $where);

    if ($affectedRows > 0) {
        return true;
    } else {
        return false;
    }
}