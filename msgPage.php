<?php
include __DIR__ . '/Users_session/user_session.php';
?>
<!doctype html>
<html lang="en" class="h-100">
<head>
    <?php include "userHeader.php" ?>
    <title>系统消息</title>
</head>
<body class="d-flex flex-column h-100">
<!-- Begin page content -->
<main class="flex-shrink-0">
    <div class="container text-primary text-center">
        <h1 class="mt-5">
            <?php
            header('refresh:3;url=' . $url);
            echo $msg;
            $_SESSION['url'] = null;
            ?>
        </h1>
    </div>
</main>
</body>
</html>