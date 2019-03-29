
<?php
header("Content-Type: text/html; charset=utf-8");

if(empty($_GET['email'])) {
    exit('缺少必要参数');
};
$email = $_GET['email'];
include_once '../inc/fn.php';
$sql = "select avatar from users where email = '$email' limit 1;";
$res = my_select($sql);
if(empty($res)) {
    echo false;
}else {
    echo $res['avatar'];
};


?>