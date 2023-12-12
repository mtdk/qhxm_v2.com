<?php
/**
 * @return string
 */
function getUserID(): string
{
    // 获取当前时间戳，并从中截取小数点后面的部分
    $microtime = substr(microtime(true), strpos(microtime(true), ".") + 1);

    // 定义一个已知字符串，供循环随机提取使用
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    // 定义一个字符串，用于存储生成的用户 ID
    $userid = "";
    // 循环 6 次，每次从字符串 "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ" 中随机取出一个字符，并添加到 $userid 字符串中
    for ($i = 0; $i < 6; $i++) {
        $userid .= $chars[mt_rand(0, strlen($chars))];
    }
// 将当前时间戳、一个大写的 36 进制时间戳和 $userid 字符串拼接起来，并返回
    return $microtime . strtoupper(base_convert(time() - 1420070400, 10, 36)) . $userid;
}

$userid = getUserID();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<main class="flex-shrink-0">
    <div class="container mt-lg-4">
        <form class="row g-3 needs-validation" novalidate action="#" method="post">
            <div class="col-md-4">
                <label for="userid" class="form-label">用户ID</label>
                <input type="text" name="userid" class="form-control" value="<?php echo $userid; ?>" readonly
                       required>
                <div class="valid-feedback">
                    用户ID不能为空
                </div>
            </div>
            <div class="col-md-4">
                <label for="username" class="form-label">用户姓名</label>
                <input type="text" name="username" class="form-control" placeholder="请输入您的用户名" required>
                <div class="valid-feedback">
                    用户姓名不能为空
                </div>
            </div>
            <div class="col-md-4">
                <label for="userpwd" class="form-label">用户密码</label>
                <div class="input-group has-validation">
                    <input type="password" name="userpwd" class="form-control" placeholder="请输入您的6~10位密码"
                           minlength="6" maxlength="16" required>
                    <div class="invalid-feedback">
                        用户密码不能为空
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label for="reuserpwd" class="form-label">确认密码</label>
                <div class="input-group has-validation">
                    <input type="password" name="reuserpwd" class="form-control" placeholder="请再次输入您的密码"
                           minlength="6" maxlength="16" required>
                    <div class="invalid-feedback">
                        确认密码不能为空
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">注册</button>
                <a class="btn btn-primary" href="./login.php">取消</a>
            </div>
        </form>
</main>
<script>
    (() => {
        'use strict'
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
<script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>