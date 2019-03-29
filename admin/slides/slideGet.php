<?php
// sql语句
$sql = "select * from options where id = 10";
// 引入文件,执行方法
include_once '../inc/fn.php';
echo my_select($sql)['value'];



?>