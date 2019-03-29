<?php

include_once '../inc/fn.php';
// 接受数据
$email = $_POST['email'];
$slug = $_POST['slug'];
$nickname = $_POST['nickname'];
$password = $_POST['password'];
$id = $_POST['id'];

// 验证邮箱是否存在
$sql_email = "select users.email from users where id not in ($id)";
$res_email = my_select_all($sql_email);
foreach ($res_email as $k => $val) {
    if(in_array($email, $val)) {
        exit('邮箱已存在');
    }
}
// 验证用户名是否存在
$sql_slug = "select users.slug from users where id not in ($id)";
$res_slug = my_select_all($sql_slug);
foreach ($res_slug as $k => $val) {
    if(in_array($slug, $val)) {
        exit('用户名已存在');
    }
}


// 准备修改语句
$sql_mod = "update users set slug = '$slug', email = '$email', password = '$password', nickname = '$nickname' where id = $id";
my_exec($sql_mod);
echo 0;



?>