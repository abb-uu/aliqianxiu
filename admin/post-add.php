<?php 
include_once './inc/logined.php';
baixiu_get_current_user();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../assets/vendors/wangEditor/wangEditor.min.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
  <?php
    
    include './inc/navbar.php';
    
  ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert" style="display: none">
        <!-- 发生XXX错误 -->
      </div>
      <form class="row" action="posts/posts_add.php" method="post" enctype="application/x-www-form-urlencoded">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <textarea style="display: none" id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容"></textarea>
            <div id="box_content"></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong id="strong">slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none; height: 100px">
            <input id="feature" class="form-control" name="feature" type="file" accept="image/*">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">
              <option value="1">未分类</option>
              <!-- <option value="2">潮生活</option>
              <option value="3">奇趣事</option>
              <option value="4">会生活</option>
              <option value="5">去旅行</option> -->
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
              <option value="published">已发布</option>
              <option value="trashed">回收站</option>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php $current_page = 'post-add'; ?>

  <?php include './inc/aside.php'; ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <!-- 格式化时间 -->
  <script src="../assets/vendors/moment/moment.js"></script>
  <!-- 富文本编辑器 -->
  <script src="../assets/vendors/wangEditor/wangEditor.min.js"></script>
  <!-- 模版引擎 -->
  <script src="js/template-web.js"></script>
  <script type="text/html" id='post_add_tmp'>
    {{each item v i}}
      <option value="{{v.id}}">{{v.name}}</option>
    {{/each}}
  </script>
  <script>NProgress.done()</script>


  <script>
    // 发送请求获取所有分类渲染到页面
    $.ajax({
      type: 'get',
      url: 'posts/posts_getCate.php',
      dataType: 'json',
      success: function (res) {
        var obj = {
          item: res
        };
        var htmlStr = template('post_add_tmp', obj);
        $('#category').html(htmlStr);
      }
    })

    function add_error(msg) {
      $('.alert').addClass('alert-danger').stop().slideDown(200).text(msg).delay(2000).slideUp(200);
    }

    // 客户端校验
    $('.btn-primary').on('click', function (e) {
      // 标题校验
      if(!$('#title').val().trim()) {
        add_error("请填写标题");
        return false;
      }
      // 内容校验
      if(!$('#content').val().trim()) {
        add_error("请填写内容");
        return false;
      }
      // 别名校验
      if(!$('#slug').val().trim()) {
        add_error("请填写别名");
        return false;
      }
      // 时间校验
      if(!$('#created').val().trim()) {
        add_error("请选择时间");
        return false;
      }
    })

    // 别名同步
    $('#slug').on('input', function () {
      $("#strong").text($(this).val() || 'slug');

    })

    // 初始化富文本编辑器插件
    var E = window.wangEditor;
    var editor = new E('#box_content');
    // 将文本域与富文本编辑器关联起来
    editor.customConfig.onchange = function (html) {
      $('#content').val(html);
    }
    editor.create();
    // 图片预览
    $('#feature').on('change', function () {
      // 获取上传的文件
      var file = this.files[0];
      // 创建一个随机路径(内存中);
      var path = URL.createObjectURL(file);
      // 展示到界面
      $('.thumbnail').attr('src', path).on('load', function () {
        $('.thumbnail').slideDown(1000);
      })

    })

    // 显示本地时间
    var res_time = moment().format('YYYY-MM-DDTHH:mm');
    $('#created').val(res_time);



  </script>
</body>
</html>
