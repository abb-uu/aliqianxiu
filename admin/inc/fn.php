<?php
header('content-type:text/html;charset=utf-8');


// 定义常量
define('XIU_HOST', '127.0.0.1');
define('XIU_UNAME', 'root');
define('XIU_PSW', 'root');
define('XIU_DB', 'baixiu_my');
define('XIU_PORT', '3306');

// 非查询语句
function my_exec($sql)
{
    // 连接数据库
    $link = mysqli_connect(XIU_HOST, XIU_UNAME, XIU_PSW, XIU_DB, XIU_PORT);
    // 判断是否连接成功
    if (!$link) {
        echo '连接失败';
        return false;
    }
    // 执行sql语句
    $res = mysqli_query($link, $sql);

    if ($res) {
        // 关闭数据库连接
        mysqli_close($link);
        return true;
    } else {
        // 返回错误信息,方便调试
        echo mysqli_error($link);
        // 关闭数据库连接
        mysqli_close($link);
        return false;
    }
}

// 测试
// $res = my_exec("delete from posts where id = 1");
// var_dump($res);


// 查询语句
function my_select($sql)
{
    // 连接数据库
    $link = mysqli_connect(XIU_HOST, XIU_UNAME, XIU_PSW, XIU_DB, XIU_PORT);
    // 判断是否连接成功
    if (!$link) {
        echo '连接失败';
        return false;
    }
    // 执 行sql语句
    $res = mysqli_query($link, $sql);

    if ($res) {
        $arr = [];
        for ($i = 0; $i < mysqli_num_rows($res); $i++) {
            $arr = mysqli_fetch_assoc($res);
        }
        // 关闭数据库连接
        mysqli_close($link);
        return $arr;
    } else {
        // 返回错误信息,方便调试
        echo mysqli_error($link);
        // 关闭数据库连接
        mysqli_close($link);
        return false;
    }
}


function my_select_all($sql)
{
    // 连接数据库
    $link = mysqli_connect(XIU_HOST, XIU_UNAME, XIU_PSW, XIU_DB, XIU_PORT);
    // 判断是否连接成功
    if (!$link) {
        echo '连接失败';
        return false;
    }
    // 执 行sql语句
    $res = mysqli_query($link, $sql);

    if ($res) {
        $arr = [];
        for ($i = 0; $i < mysqli_num_rows($res); $i++) {
            $arr[] = mysqli_fetch_assoc($res);
        }
        // 关闭数据库连接
        mysqli_close($link);
        return $arr;
    } else {
        // 返回错误信息,方便调试
        echo mysqli_error($link);
        // 关闭数据库连接
        mysqli_close($link);
        return false;
    }
}

// 测试
// echo '<pre>';
// print_r(my_select("select * from posts where id = 2"));
// echo '</pre>';




?>
