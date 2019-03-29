<?php
// 获取文章总数
$sql = "select count(*) as total 
from posts 
inner join users on posts.user_id = users.id 
inner join categories on posts.category_id = categories.id ";

// 引入文件,调用方法
include_once '../inc/fn.php';
$res = my_select($sql);
// 输出文章总数
echo $res['total'];

?>