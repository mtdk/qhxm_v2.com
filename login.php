<?php include __DIR__ . '/db/db.php';
$database = new Database();
// 定义要查询的数据表
$table = 'tb_users';
// 定义要查询的条件
$where = 'userstate_id = :userstate_id';
$params = array(':userstate_id' => 1);
// 定义要查询的字段
$fields = array('uid', 'username');
// 查询数据
$results = $database->select($table, $where, $params, $fields);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signin Template · Bootstrap v5.2</title>

    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <script>
        function UsCheck(str) {
            let xmlhttp;
            if (str.length === 0) {
                document.getElementById("upassword").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest) {
                // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
                xmlhttp = new XMLHttpRequest();
            } else {
                // IE6, IE5 浏览器执行代码
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                    if (xmlhttp.responseText !== '') {
                        document.getElementById("upassword").value = xmlhttp.responseText;
                        document.getElementById("remember_me").checked = true;
                    } else {
                        document.getElementById("upassword").value = "";
                        document.getElementById("remember_me").checked = false;
                    }
                }
            }
            xmlhttp.open("POST", "/Users_session/remember_mypwd.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("uid=" + str);
        }
    </script>
    <!-- Custom styles for this template -->
    <link href="bootstrap/css/sign-in/sign-in.css" rel="stylesheet">
</head>
<body class="text-center">

<main class="form-signin w-100 m-auto">
    <form method="post" action="User_logical_files/login_check.php">
        <img class="mb-4" src="./brand/bootstrap-logo.svg" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">请&nbsp;登&nbsp;录&nbsp;系&nbsp;统</h1>

        <div class="form-floating">
            <label for="uid"></label><select class="form-select" id="uid" name="uid"
                                             onchange="UsCheck(this.options[this.options.selectedIndex].value)"
                                             required>
                <option selected disabled value="">请选择您的姓名...</option>
                <?php
                // 显示查询结果
                foreach ($results as $row) {
                    // 输出记录内容
                    echo "<option value=" . $row['uid'] . ">" . $row['username'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-floating">
            <input type="password" name="upassword" class="form-control" id="upassword"
                   placeholder="Password" required>
            <label for="upassword">密码</label>
        </div>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="0" name="remember_me" id="remember_me"> 记住我
            </label>
        </div>
        <div class="form-floating">
            <button class="w-100 btn btn-lg btn-primary" type="submit">登&nbsp;录</button>
        </div>
        <div class="form-floating mt-3">
            <a href="./userRegister.php" class="w-100 btn btn-lg btn-primary">注&nbsp;册</a>
        </div>
        <div class="form-floating mt-3">
            <a href="./Admin_folder/admin_login.php" class="w-100 btn btn-lg btn-primary">管理员登录</a>
        </div>
        <p class="mt-5 mb-3 text-muted">&copy;Xmtdk 2017–2025</p>
    </form>
</main>
<script src="./bootstrap/js/bootstrap.js"></script>
</body>
</html>