<?php
// ==================删除数据
include_once '../inc/fn.php';
// 判断是否传入参数
if(empty($_GET['id'])) {
    exit('缺少必要参数');
};
// 接受传入的参数
$id = $_GET['id'];
// 准备sql语句
$sql = "delete from posts where id in ( $id );";
// 执行方法
my_exec($sql);

// 获取当前所有数据量的sql语句
$totalSql = "select count(*) as total from posts inner join users on posts.user_id = users.id inner join categories on posts.category_id = categories.id";
// 执行方法
$res = my_select($totalSql);
// 输出当前数据量
echo json_encode($res);



?>