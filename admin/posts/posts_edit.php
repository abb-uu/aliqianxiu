<?php

include_once '../inc/fn.php';
if(empty($_GET['id'])) {
    exit('缺少必要参数');
};
$id = $_GET['id'];
$sql = "select posts.id, posts.slug as post_slug, posts.title, posts.feature, posts.created, posts.content, posts.status, categories.name from posts join categories on posts.category_id = categories.id where posts.id = $id limit 1";
$res = my_select($sql);
echo json_encode($res);



?>