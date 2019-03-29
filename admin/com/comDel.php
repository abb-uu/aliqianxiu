<?php
// ==================删除数据
include_once '../inc/fn.php';
if(empty($_GET['id'])) {
    exit('缺少必要参数');
};
$id = $_GET['id'];

$sql = "delete from comments where id in ( $id );";


my_exec($sql);

// 获取当前所有数据量的sql语句
$totalSql = "select count(*) as total from comments inner join posts on comments.post_id = posts.id";
// 执行方法
$res = my_select($totalSql);
// 输出当前数据量
echo json_encode($res);


?>