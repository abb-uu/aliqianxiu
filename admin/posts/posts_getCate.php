<?php
include_once '../inc/fn.php';

$sql = "select * from categories";

$res = my_select_all($sql);

echo json_encode($res);


?>