<?php
include_once '../inc/fn.php';

$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];
$slug = $_POST['slug'];
$category = $_POST['category'];
$created = $_POST['created'];
$status = $_POST['status'];

$img = '';
if (!empty($_FILES['feature']) && $_FILES['feature']['error'] == 0) {
    // 获取文件
    $file = $_FILES['feature'];
    // 获取文件后缀名
    $ext = strrchr($file['name'], '.');
    // 拼接新的文件名
    $filename = time() . rand(1000, 9999) . $ext;
    // 拼接新的路径
    $path = "../../uploads/$filename";
    // 转存
    move_uploaded_file($file['tmp_name'], $path);
    // 给$feature重新赋值
    $img = "../uploads/$filename";
};


if(empty($img)) {
    $sql = "update posts set 
    slug = '$slug', 
    title = '$title', 
    content = '$content', 
    posts.status = '$status', 
    created = '$created', 
    category_id = $category 
    where id = $id ";
}else {
    $sql = "update posts set 
    slug = '$slug', 
    title = '$title', 
    feature = '$img', 
    content = '$content', 
    posts.status = '$status', 
    created = '$created', 
    category_id = $category 
    where id = $id";
}
my_exec($sql);



?>