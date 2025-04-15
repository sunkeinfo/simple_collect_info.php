<?php
// 定义存储信息的文件名
$filename = 'user_data.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 从 POST 请求中获取数据
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // 将数据格式化为一行字符串 (可以根据需要调整格式)
    $data = "用户名: " . $username . "\n电话: " . $phone . "\n地址: " . $address . "\n---NEXT_ENTRY---\n";

    // 将数据追加到文件中
    if (file_put_contents($filename, $data, FILE_APPEND | LOCK_EX) !== false) {
        // 重定向回 collect_info.php 并传递成功消息
        header('Location: collect_info.php?status=success&message=' . urlencode('信息提交成功！'));
    } else {
        // 重定向回 collect_info.php 并传递失败消息
        header('Location: collect_info.php?status=error&message=' . urlencode('信息提交失败，请稍后再试。'));
    }
    exit;
} else {
    // 如果不是 POST 请求，则重定向回 collect_info.php 并传递错误消息
    header('Location: collect_info.php?status=error&message=' . urlencode('非法请求！'));
    exit;
}
?>