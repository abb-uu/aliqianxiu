<?php
// 引入文件
include_once '../inc/fn.php';
$page = $_GET['page'];
$pageSize = 15;
$start = ($page - 1) * $pageSize;
// 准备sql语句
$sql = "select comments.*, posts.title from comments inner join posts on comments.post_id = posts.id order by comments.created desc limit $start, $pageSize";
// 执行方法
$res = my_select_all($sql);
// 转换为字符串输出结果
echo json_encode($res);

// 跳回评论页面
// header("location: ../comments.php");


?>