<?php 
include_once './inc/logined.php';
baixiu_get_current_user();
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <title>Slides &laquo; Admin</title>
    <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
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
                <h1>图片轮播</h1>
            </div>
            <!-- 有错误信息时展示 -->
            <div class="alert alert-danger" style="display:none">
              <!-- 错误信息 -->
            </div>
            <div class="row">
                <div class="col-md-4">
                    <form>
                        <h2>添加新轮播内容</h2>
                        <div class="form-group">
                            <label for="image">图片</label>
                            <!-- show when image chose -->
                            <img class="help-block thumbnail" style="display: none">
                            <input id="image" class="form-control" name="image" type="file">
                        </div>
                        <div class="form-group">
                            <label for="text">文本</label>
                            <input id="text" class="form-control" name="text" type="text" placeholder="文本">
                        </div>
                        <div class="form-group">
                            <label for="link">链接</label>
                            <input id="link" class="form-control" name="link" type="text" placeholder="链接">
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary btn-add" type="button" value="添加">
                        </div>
                    </form>
                </div>
                <div class="col-md-8">
                    <div class="page-action">
                        <!-- show when multiple checked -->
                        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
                    </div>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">图片</th>
                                <th>文本</th>
                                <th>链接</th>
                                <th class="text-center" width="100">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- 图片 -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php $current_page = 'slides'; ?>

    <?php

    include './inc/aside.php';

    ?>

    <script src="../assets/vendors/jquery/jquery.js"></script>
    <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
    <!-- 模版引擎 -->
    <script src="js/template-web.js"></script>
    <!-- 准备模版 -->
    <script type="text/html" id="tmp">
        {{each item v i}}
      <tr>                
        <td class="text-center"><img class="slide" src="../{{v.image}}"></td>
        <td>{{v.text}}</td>
        <td>{{v.link}}</td>
        <td class="text-center">
          <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
        </td>
      </tr>
    {{/each}}
  </script>
    <script>
        NProgress.done()
    </script>
    <script>
        // 发送ajax请求获取数据
        render();
        function render() {
          $.ajax({
            url: 'slides/slideGet.php',
            dataType: 'json',
            success: function(res) {
              var obj = {
                item: res,
              }
              var htmlstr = template('tmp', obj);
              $('tbody').html(htmlstr);
            }
          })
        }

        // 添加图片
        $('.btn-add').on('click', function () {
          if(!$('#image').val()){
            $(".alert").text("请选择图片").stop().slideDown().delay(2000).slideUp();
            return false;
          }
          var formdata = new FormData($('form')[0]);
          $.ajax({
            type: 'post',
            url: 'slides/slideAdd.php',
            data: formdata,
            contentType: false,
            processData: false,
            success: function (res){
              // 重新渲染列表
              $('form')[0].reset();
              render();
            }
          })
        })
    </script>
</body>

</html> 