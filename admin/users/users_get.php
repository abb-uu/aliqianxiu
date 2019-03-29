<?php

// 准备sql语句
$sql = "select * from users";
// 引入文件
include_once '../inc/fn.php';
// 执行方法
$res = my_select_all($sql);

echo json_encode($res);


?>