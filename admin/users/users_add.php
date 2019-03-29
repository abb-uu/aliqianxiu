<?php
include_once '../inc/fn.php';
// 接受数据
$email = $_POST['email'];
$slug = $_POST['slug'];
$nickname = $_POST['nickname'];
$password = $_POST['password'];

// 验证邮箱是否存在
$sql_email = "select users.email from users where email = '$email' limit 1";
$res_email = my_select($sql_email);
if(!empty($res_email)) {
    exit('邮箱已存在');
};

// 验证别名是否存在
$sql_slug = "select users.slug from users where slug = '$slug' limit 1";
$res_slug = my_select($sql_slug);
if(!empty($res_slug)) {
    exit('用户名已存在');
};

// 准备添加语句
$sql_add = "insert into users (slug, email, password, nickname, status) values ('$slug', '$email', '$password', '$nickname', 'activated')";
my_exec($sql_add);
echo 0;


?>