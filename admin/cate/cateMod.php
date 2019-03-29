<?php

// 判断传入数据是否有空值
if(empty($_GET['name']) || empty($_GET['slug'])) {
    header("location: ../categories.php");
    exit('0');
};

$name = $_GET['name'];
$slug = $_GET['slug'];
$id = $_GET['id'];


// 准备sql语句
$sql = "update categories set slug = '$slug', name = '$name' where id = $id ";

// 引入文件,调用方法
include_once '../inc/fn.php';
my_exec($sql);
header("location: ../categories.php");




?>