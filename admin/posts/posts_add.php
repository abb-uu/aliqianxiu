<?php

//=============== 获取前段上传的数据
// 获取用户名
include_once '../inc/fn.php';
session_start();
$user = $_SESSION['current_login_user'];
// 获取用户id
$id = $user['id'];
// 获取别名
$slug = $_POST['slug'];
// 获取标题
$title = $_POST['title'];
// 获取时间
$created = $_POST['created'];
// 获取内容
$content = $_POST['content'];
// 获取分类
$category = $_POST['category'];
// 获取状态
$status = $_POST['status'];
$feature = '';
if(!empty($_FILES['feature']) || $_FILES['feature']['error'] == 0) {
    // 获取文件
    $file = $_FILES['feature'];
    // 获取文件后缀名
    $ext = strrchr($file['name'], '.');
    // 拼接新的文件名
    $filename = time().rand(1000, 9999).$ext;
    // 拼接新的路径
    $path = "../../uploads/$filename";
    // 转存
    move_uploaded_file($file['tmp_name'], $path);
    // 给$feature重新赋值
    $feature = "../uploads/$filename";
}

// 准备sql语句
if(empty($feature)) {
    $sql = "insert into posts 
    (slug, title, created, content, status, user_id, category_id) 
    values ('$slug', '$title', '$created', '$content', '$status', $id, $category)";
}else {
    $sql = "insert into posts 
    (slug, title, feature, created, content, status, user_id, category_id) 
    values ('$slug', '$title', '$feature', '$created', '$content', '$status', $id, $category)";
}

// 执行方法
my_exec($sql);
// 跳回写文章页面
header("location: ../posts.php");


// 

?>