<?php
// 获取评论总数
$sql = "select count(*) as total from comments join posts on comments.post_id = posts.id";

// 引入文件,调用方法
include_once '../inc/fn.php';
$res = my_select($sql);
// 输出评论总数
echo $res['total'];

?>