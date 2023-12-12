<?php
session_start();

// 设置默认值为空字符串
$uid = $_SESSION['uid'] ?? '';
$username = $_SESSION['username'] ?? '';
$department_id = $_SESSION['department_id'] ?? '';
$role_id = $_SESSION['role_id'] ?? '';

// 检查消息和URL变量是否存在
$msg = $_SESSION['msg'] ?? null;
$url = $_SESSION['url'] ?? null;