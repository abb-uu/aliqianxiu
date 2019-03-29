<?php

$text = $_POST['text'];
$link = $_POST['link'];
// 获取文件
$file = $_FILES['image'];
// 获取文件后缀名
$ext = strrchr($file['name'], '.');
// 拼接新的文件名
$filename = time().rand(1000, 9999).$ext;
// 拼接新的路径
$path = "../../uploads/$filename";
// 转存
move_uploaded_file($file['tmp_name'], $path);
// 给$image重新赋值
$photo = "uploads/$filename";
// 将数据存储在数组中
$info['image'] = $photo;
$info['text'] = $text;
$info['link'] = $link;
// 引入文件,执行方法
include_once '../inc/fn.php';
// 获取并修改数据
$res_str = my_select("select * from options where id = 10")['value'];
// 将字符串转化为数组
$res_arr = json_decode($res_str, true);
// 将传来的数据添加到数组中
$res_arr[] = $info;
// 再转化为字符串
$res_newStr = json_encode($res_arr);
// 修改数据sql语句
$sql = "update options set value = '$res_newStr' where id = 10";
// 执行修改语句
my_exec($sql);




?>