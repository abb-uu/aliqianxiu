<?php

session_start();

function login()
{
  // 接收数据
  $email = $_POST['email'];
  $password = $_POST['password'];
  // 1.接受并校验
  // 校验邮箱是否为空
  if (empty($email)) {
    $GLOBALS['message'] = '请输入邮箱';
    return;
  };
  // 校验密码是否为空
  if (empty($password)) {
    $GLOBALS['message'] = '请输入密码';
    return;
  };
  // 引入文件,执行方法
  include_once './inc/fn.php';
  $sql = "select * from users where email = '$email'";
  $res = my_select($sql);
  if (!$res || $res['password'] !== $password) {
    $GLOBALS['message'] = '密码错误';
    return;
  };

  // 邮箱与密码匹配则跳转到index1.php
  $_SESSION['current_login_user'] = $res;
  header("location: ./index1.php");
  

  
  // 2.持久化
  // 3.响应
};
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  login();
};

// 退出功能
// 判断是否是get请求
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'logout') {
  session_destroy();
  session_unset();
};

?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../../../js/animate.css">
</head>

<body>
  <div class="login">
    <!-- action值为空,请求默认发送到此页面 -->

    <!-- autocomplete属性用于控制预测字段的显示与隐藏,off => 隐藏  on => 显示-->

    <!-- 判断$message是否不为空,若不为空,说明有错误,则表单晃动,若为空,说明登录成功,表单不晃动 -->
    <form class="login-wrap <?php echo isset($message) ? 'shake animated' : '' ?>" action="" method="post">
      <img class="avatar" src="../assets/img/default.png">
      <?php if (isset($message)) : ?>
      <div class="alert alert-danger">
        <strong>错误！</strong>
        <?php echo $message; ?>
      </div>
      <?php endif ?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <!-- type若为email会有邮箱自动校验功能,可以通过在form表单中加入novalidate来取消邮箱自动校验功能 -->
        <input id="email" type="text" class="form-control" placeholder="邮箱" autofocus name="email" value="<?php echo empty($_POST['email']) ? '' : $_POST['email'] ?>">
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" class="form-control" placeholder="密码" name="password">
      </div>
      <input class="btn btn-primary btn-block" type="submit" value="登录">
    </form>
  </div>
  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script>
    $(function () {
      var $email = $('#email');
      $email.on('blur', function () {
        if (!$email.val().trim()) {
          return;
        }
        var reg = /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/;
        if (reg.test($email.val())) {
          // $.get('./api/avatar.php', {email: $email.val()}, function (res) {
          //   $('.avatar').attr('src', res);
          // })
          $.ajax({
            type: 'GET',
            url: 'api/avatar.php',
            data: {
              email: $email.val()
            },
            success: function (res) {
              if(!res.trim()) return;
              if($('.avatar').attr('src') === res) return;
              $('.avatar').fadeOut(400, function () {
                $(this).on('load', function () {
                  $(this).fadeIn(400);
                }).attr('src', res);
              })
            },
          })
        }
      })
    })
  </script>
</body>

</html>