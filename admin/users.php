<?php 
include_once './inc/logined.php';
baixiu_get_current_user();



// 查询编辑项
function users_sel_one() {
  $id = $_GET['id'];
  $sql = "select * from users where id = $id limit 1";
  include_once 'inc/fn.php';
  $GLOBALS['res'] = my_select($sql);
}

if($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['id'])){
  users_sel_one();
}

$id = $_SESSION['current_login_user']['id'];



?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Users &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body data-id="<?php echo $id?>">
  <script>NProgress.start()</script>

  <div class="main">
  <?php include './inc/navbar.php';?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>用户</h1>
      </div>
      <!-- 有响应信息时展示 -->
      <div class="alert" style="display: none">
        <!-- 响应信息 -->
      </div>
      <div class="row">
        <div class="col-md-4">
          <?php if(!isset($res)):?>
            <form>
              <h2>编辑用户</h2>
              <div class="form-group">
                <label for="email">邮箱</label>
                <input id="email" class="form-control" name="email" type="type" placeholder="邮箱">
              </div>
              <div class="form-group">
                <label for="slug">别名</label>
                <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
                <p class="help-block">https://zce.me/author/<strong id="strong">slug</strong></p>
              </div>
              <div class="form-group">
                <label for="nickname">昵称</label>
                <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称">
              </div>
              <div class="form-group">
                <label for="password">密码</label>
                <input id="password" class="form-control" name="password" type="text" placeholder="密码">
              </div>
              <div class="form-group">              
                <input class="btn btn-primary btn-add" type="button" value="添加">
              </div>
            </form>
          <?php else: ?>
          <form>
            <h2>编辑用户</h2>
            <div class="form-group">
              <label for="email">邮箱</label>
              <input id="email" class="form-control" name="email" type="type" placeholder="邮箱" value="<?php echo $res['email'] ?>">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" value="<?php echo $res['slug'] ?>">
              <p class="help-block">https://zce.me/author/<strong id="strong"><?php echo $res['slug'] ?></strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称" value="<?php echo $res['nickname'] ?>">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" class="form-control" name="password" type="text" placeholder="密码" value="<?php echo $res['password'] ?>">
            </div>
            <div class="form-group">
              <input class="btn btn-primary btn-save" type="button" value="保存" data-id="<?php echo $res['id'] ?>">
              <a href="users.php" class="btn btn-primary btn-waive">放弃</a>
            </div>
          </form>
          <?php endif ?>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm btn_all_delete" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th class="text-center" width="80">头像</th>
                <th>邮箱</th>
                <th>别名</th>
                <th>昵称</th>
                <th>状态</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td class="text-center"><img class="avatar" src="../assets/img/default.png"></td>
                <td>i@zce.me</td>
                <td>zce</td>
                <td>汪磊</td>
                <td>激活</td>
                <td class="text-center">
                  <a href="post-add.php" class="btn btn-default btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr> -->
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php $current_page = 'users'; ?>

  <?php include './inc/aside.php'; ?>


  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="js/check.js"></script>
  <script>NProgress.done()</script>
  <!-- 模版引擎 -->
  <script src="js/template-web.js"></script>
  <script type="text/html" id="users_tmp">
  {{each item v i}}
    <tr>
      <td class="text-center"><input type="checkbox" data-id="{{v.id}}"></td>
      <td class="text-center"><img class="avatar" src="{{v.avatar}}"></td>
      <td>{{v.email}}</td>
      <td>{{v.slug}}</td>
      <td>{{v.nickname}}</td>
      <td>{{v.status}}</td>
      <td class="text-left">
        <a href="<?php echo $_SERVER['PHP_SELF']?>?id={{v.id}}" class="btn btn-default btn-xs btn-app btn-primary" data-id="{{v.id}}">编辑</a>
        {{if userId != v.id}}
        <a href="javascript:;" class="btn btn-danger btn-xs btn-delete" data-id="{{v.id}}">删除</a>
        {{/if}}
      </td>
    </tr>
    {{/each}}
  </script>

  <script>
    // 删除封装
    function btn_del(options) {
      var that = options.that || this;
      var url = options.url || '';
      // 获取当前按钮自定义属性的值
      var id = that.dataset.id;
      // 发送请求
      $.ajax({
        type: 'get',
        url: url,
        data: {
          id: id,
        },
        success: function () {
          render();
          $('thead input').prop('checked', false);
          $('.page-action .btn-danger').fadeOut();
        }
      })
    }
    // 发送请求获取所有用户信息
    render();
    var $id = $('body')[0].dataset.id;
    function render() {
      $.ajax({
        url: 'users/users_get.php',
        dataType: 'json',
        success: function (res) {
          // console.log(res);
          var obj = {
            item: res,
            userId: $id,
          };
          var htmlStr = template('users_tmp', obj);
          $('tbody').html(htmlStr);
          // 全选
          var checkboxs = $('tbody input');
          var checkboxAll = $('thead input');
          var allDelect = $('.page-action .btn-danger');
          delete_pub_del(checkboxs, checkboxAll, allDelect, true);
        }
      })
    }
    
    // 删除
    $('tbody').on('click', '.btn-delete', function () {
      var that = this;
      btn_del({
        that: that,
        url: 'users/users_del.php',
      });
    })
    // 批量删除
    $('.btn_all_delete').on('click', function () {
      var that = this;
      btn_del({
        that: that,
        url: 'users/users_del.php',
      });
    })

    function add_error(msg) {
      $('.alert').addClass('alert-danger').stop().slideDown(200).text(msg).delay(2000).slideUp(200);
    }
    
    // 获取表单内容封装
    function getContent(id) {
      // 获取数据
      window.email = $('#email').val().trim();
      window.slug = $('#slug').val().trim();
      window.nickname = $('#nickname').val().trim();
      window.password = $('#password').val().trim();
      window.id = id || '';
      // 验证邮箱
      if(!email) {
        add_error('请填写邮箱');
        return false;
      };
      // 验证别名
      if(!slug) {
        add_error('请填写别名');
        return false;
      };
      // 验证昵称
      if(!nickname) {
        add_error('请填写昵称');
        return false;
      };
      // 验证密码
      if(!password) {
        add_error('请填写密码');
        return false;
      };
      return true;
    }
    // 添加用户客户端验证
    $('.btn-add').on('click',function () {
      var flag = getContent();
      if(!flag) return;
      $.ajax({
        type: 'post',
        url: 'users/users_add.php',
        data: {
          email: email,
          slug: slug,
          nickname: nickname,
          password: password,
        },
        success: function (res) {
          // 根据返回码判断弹出框的内容及状态
          if(res == 0) {
            $('.alert').removeClass('alert-danger').addClass('alert-success').stop().slideDown(200).text('修改成功').delay(2000).slideUp(200);
            $('#email').val('');
            $('#slug').val('');
            $('#nickname').val('');
            $('#password').val('');
          }else{
            $('.alert').removeClass('alert-success').addClass('alert-danger').stop().slideDown(200).text(res).delay(2000).slideUp(200);
          };
          render();
        }
      })
    })

    // 别名同步
    $('#slug').on('input', function () {
      $("#strong").text($(this).val() || 'slug');
    })


    // 保存按钮
    $('.btn-save').on('click', function () {
      var $id = $('.btn-save')[0].dataset.id;
      var flag = getContent($id);
      if(!flag) return;
      $.ajax({
        type: 'post',
        url: 'users/users_mod.php',
        data: {
          email: email,
          slug: slug,
          nickname: nickname,
          password: password,
          id: id,
        },
        success: function (res) {
          // 根据返回码判断弹出框的内容及状态
          if(res == 0) {
            $('.alert').removeClass('alert-danger').addClass('alert-success').stop().slideDown(200).text('编辑成功').delay(2000).slideUp(200);
          }else{
            $('.alert').removeClass('alert-success').addClass('alert-danger').stop().slideDown(200).text(res).delay(2000).slideUp(200);
          };
          render();
        }
      })
    })   
  </script>

</body>
</html>


