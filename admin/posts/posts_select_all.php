<?php
// 引入方法
include_once '../inc/fn.php';
// 接受前段传来的要请求的页码
$page = $_GET['page'];
// 定义每一页的数量
$pageSize = $_GET['pageSize'];
// 计算请求不同页码时从哪一条数据开始
$start = ($page - 1) * $pageSize;
// 准备sql语句, 多表联合查询, 只查询需要的字段以优化性能, order by 字段名 desc/asc 降序查询/升序查询
$sql = "select
posts.id, posts.title, users.nickname as user_name, categories.name as category_name, posts.created, posts.status 
from posts inner join users on posts.user_id = users.id 
inner join categories on posts.category_id = categories.id 
order by posts.created desc 
limit $start, $pageSize";
// 将对象转换为字符串
$res = json_encode(my_select_all($sql));
// 输出数据
echo $res;





?>