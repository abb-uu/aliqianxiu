<?php

// ==================删除数据
include_once '../inc/fn.php';
if(empty($_GET['id'])) {
    exit('缺少必要参数');
};
$id = $_GET['id'];

$sql = 'delete from categories where id in (' . $id . ');';

my_exec($sql);


header("location: ../categories.php");

?>