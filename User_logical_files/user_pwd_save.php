<?php
include __DIR__ . '/../Users_session/user_session.php';
include __DIR__ . '/../Users_session/login_state.php';
include __DIR__ . '/../db/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = trim($_POST['userid'] ? htmlspecialchars($_POST['userid']) : '');
    $old_passwd = trim($_POST['old_passwd'] ? htmlspecialchars($_POST['old_passwd']) : '');
    $new_passwd = trim($_POST['new_passwd'] ? htmlspecialchars($_POST['new_passwd']) : '');
    $replay_passwd = trim($_POST['replay_passwd'] ? htmlspecialchars($_POST['replay_passwd']) : '');

    if (empty($userid)) {
        $_SESSION['msg'] = "用户ID不能为空";
    } elseif (empty($old_passwd)) {
        $_SESSION['msg'] = "原密码不能为空";
    } elseif (!user_pwd_check($userid, $old_passwd)) {
        $_SESSION['msg'] = "用户原密码不正确";
    } elseif (empty($new_passwd)) {
        $_SESSION['msg'] = "新密码不能为空";
    } elseif (empty($replay_passwd)) {
        $_SESSION['msg'] = "确认密码不能为空";
    } elseif ($new_passwd != $replay_passwd) {
        $_SESSION['msg'] = "两次密码输入不一致";
    } else {
        if (user_pwd_update($userid, $new_passwd)) {
            $_SESSION['msg'] = "密码修改成功！请退出后重新登录！";
        } else {
            $_SESSION['msg'] = "密码修改失败了！";
        }
    }
    $_SESSION['url'] = 'user_pwd_update.php';
} else {
    $_SESSION['msg'] = "错误的提交方式，危险的操作，将自动退出登录！！！";
    $_SESSION['url'] = 'logout.php';
}
header('location:../msgPage.php');

/**
 * @param string $userid 用户id
 * @param string $old_pwd 要验证的密码
 * @return bool 验证结果,验证通过返回true,验证失败返回false
 */
function user_pwd_check(string $userid, string $old_pwd): bool
{
    $database = new Database();
    $table = 'tb_users';
    $condition = "uid = :uid";
    $params = array(':uid' => $userid);
    // 定义要查询的字段
    $fields = array('userpwd');
    // 查询数据
    $results = $database->select($table, $condition, $params, $fields);
    if (!password_verify($old_pwd, $results[0]['userpwd'])) {
        return false;
    } else {
        return true;
    }
}

/**
 * @param string $userid 用户id
 * @param string $new_pwd 新密码
 * @return bool 更新成功返回true,更新失败返回false
 */
function user_pwd_update(string $userid, string $new_pwd): bool
{
    // 提交数据
    $database = new Database();
    // 定义要修改的数据
    $data = array(
        'userpwd' => password_hash($new_pwd, PASSWORD_DEFAULT),
    );
    // 定义修改条件
    $where = array('uid' => $userid);
    // 执行修改操作
    $table = 'tb_users';
    $affectedRows = $database->update($table, $data, $where);

    if ($affectedRows > 0) {
        return true;
    } else {
        return false;
    }
}
