<?php
include __DIR__ . '/user_session.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid = trim(htmlspecialchars($_POST['uid']));
    if ($uid == $_COOKIE['remember_myid'][0]) {
        echo $_COOKIE['uspasswd'];
    } else {
        echo '';
    }
} else {
    echo '';
}