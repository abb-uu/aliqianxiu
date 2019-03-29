<?php
$id = $_GET['id'];

// 根据传来的id修改数据库中的数据
// 准备sql语句
$sql = "update comments set status = 'approved' where id in ( $id )";
// 引入文件,调用方法
include_once '../inc/fn.php';

my_exec($sql);


?>