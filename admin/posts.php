<?php 
include_once './inc/logined.php';
baixiu_get_current_user();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/pagination/pagination.css">
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
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm btn-batch btn-all-delete" href="javascript:;" style="display: none">批量删除</a>
        <!-- 分页模版 -->
      </div>
      <div id="pagination" class="pull-right"></div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>


        </tbody>
      </table>
    </div>
  </div>





<style>
    .edit-box{
        position:fixed;
        left:0;
        top:0;
        width:100%;
        height:100%;
        background:rgba(0,0,0,0.7);
        z-index:10;
        padding:50px 50px;
        display:none;
    }

    .container-fluid{
        background: #eee;
        border-radius:10px;
        padding-bottom:20px;
    }

    /* .my-in {
      background: pink;
      height800px;
    } */
</style>
<!-- -=================================================编辑模块 -->
  <div class="edit-box" style="display: none;">
    <div class="container-fluid my-in">
      <div class="page-title">
        <h1>修改文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" id="editForm">
        <!-- 隐藏域 :就是一个普通表单可以向后台传值，只是看不到而已 -->
        <input type="hidden" id="id" name="id" value="64">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">正文</label>
            <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容" style="display:none"></textarea>
            <!-- 生成富文本编辑器容器 -->
            <div id="box_content"></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong id="strong"></strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" id="img" style="width: 60px;" src="">
            <!--  accept="image/jpeg,image/gif,image/png" 限制上传文件格式 -->
            <input id="feature" class="form-control" name="feature" type="file" accept="image/gif, image/jpeg, image/png, image/jpg">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control sel-cate sel-cate1" name="category">
    
      <option value="1">未分类</option>
    
      <option value="2">奇趣事</option>
    
      <option value="3">会生活</option>
    
      <option value="4">去旅行</option>
    
  </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control sel-state sel-state1" name="status">
    
              <option value="drafted">草稿</option>
            
              <option value="published">已发布</option>
            
              <option value="trashed">回收站</option>
            
          </select>
          </div>
          <div class="form-group">
            <!-- <button class="btn btn-primary" >修改</button> -->
            <input id="btn-update" type="button" value="修改" class="btn btn-primary btn-update">
            <input id="btn-cancel" type="button" value="放弃" class="btn btn-danger btn-cancel">
          </div>
        </div>
      </form>
    </div>
</div>


  <?php $current_page = 'posts'; ?>


  <?php include './inc/aside.php'; ?>



  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="js/check.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <!-- 富文本编辑器 -->
  <script src="../assets/vendors/wangEditor/wangEditor.min.js"></script>
  <!-- 分页js文件 -->
  <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
  <script>NProgress.done()</script>
  <!-- 引入引擎模版 -->
  <script src="js/template-web.js"></script>
  <!-- 准备模版 -->
  <script type="text/html" id="posts_tmp">
    {{each item v i}}
      <tr>
        <td class="text-center"><input type="checkbox" data-id={{v.id}}></td>
        <td>{{v.title}}</td>
        <td>{{v.user_name}}</td>
        <td>{{v.category_name}}</td>
        <td class="text-center">{{format_date(v.created)}}<br>{{format_time(v.created)}}</td>
        <td class="text-center">{{state[v.status]}}</td>
        <td class="text-center">
          <a href="javascript:;" class="btn btn-info btn-xs btn-edit" data-id="{{v.id}}">编辑</a>
          <a href="javascript:;" class="btn btn-danger btn-xs btn-delete" data-id="{{v.id}}">删除</a>
        </td>
      </tr>
    {{/each}}
  </script>

  <script>


    //================== 初始化富文本编辑器插件
    var E = window.wangEditor;
    var editor = new E('#box_content');
    // 将文本域与富文本编辑器关联起来
    editor.customConfig.onchange = function (html) {
      $('#content').val(html);
    }
    editor.create();



    //================== 定义一个变量存储当前页面下标
    var currentPage = 1;
    // 每页的数据量, 默认值为12;
    var pageSize = 10;
    // 数据转换
    var state = {
      drafted : '草稿',
      published: '已发布',
      trashed: '回收站'
    };
    
    //================================================================ 初始默认为第一页
    render(currentPage);
    // 数据渲染封装
    function render(page) {
      // 发送ajax请求
      $.ajax({
        type: 'get',
        url: 'posts/posts_select_all.php',
        dataType: 'json',
        data: {
          page: page,
          pageSize: pageSize,
        },
        success: function (res) {
          var obj = {
            item: res,
            state: state,
            format_date: function (time) {
              var arr_time = time.trim().split(' ');
              var str_time = arr_time[0];
              var arr_localTime = str_time.split('-');
              var str_localTime = arr_localTime[0] + '年' + arr_localTime[1] + '月' + arr_localTime[2] + '日';
              return str_localTime;
            },
            format_time: function (time) {
              return time.trim().split(' ')[1];
            }
          };
          var htmlStr = template('posts_tmp', obj);
          // 将数据渲染到页面
          $('tbody').html(htmlStr);
          // 循环当前页面所有的tr
          $('tbody tr').each(function (index, ele) {
            // 获取当前状态
            var txt = $(ele).children().eq(5).text();
            var color;
            // 根据不同的状态定义不同的颜色
            switch (txt) {
              case '草稿':
              color = 'rgb(134, 201, 218)';
              break;
              case '已发布':
              color = 'rgb(147, 226, 157)';
              break;
              case '回收站':
              color = 'rgb(206, 206, 198)';
              break;
              default:
              color = 'rgb(255, 255, 255)';
              break;
            };
            // 渲染
            $(ele).css("background", color);
          });
          // 恢复为初始状态
          $('thead input').prop('checked', false);
          $('.btn-all-delete').fadeOut(200);
          // 多选与全选
          var checkboxs = $('tbody input');
          var checkboxAll = $('thead input');
          var allDelect = $('.page-action .btn-batch');
          delete_pub_del(checkboxs, checkboxAll, allDelect, true);
        }
      })
    }
    
    //================================================================ 默认为第一页
    pagination_render(currentPage);
    // 渲染分页插件封装
    function pagination_render(page) {
      $.ajax({
        url: 'posts/posts_getTotal.php',
        type: 'get',
        dataType: 'json',
        success: function (res) {
          $('#pagination').pagination(res, {
            prev_text: '上一页',
            next_text: '下一页',
            items_per_page: pageSize, // 每一页的数据量,默认为10
            num_edge_entries: 1, // 首尾展示页码的数量
            num_display_entries: 6, // 中间展示页码的数量
            current_page: page - 1, // 默认展示的页码下标
            load_first_page: false, // 初始化时是否触发回调函数,默认为true
            // 回调函数,点击页码时会被触发
            callback: function (index) {
              // 默认参数index, 存储了当前页码的下标
              // 点击页码发送ajax请求,渲染对应的数据到页面
              render(index + 1);
              // 修改currentPage的值,让变量与当前展示页码保持一致
              currentPage = index + 1
            }
          })
        }
      })
    }

      
      
    //================================================================ 删除按钮
    // 删除操作封装
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
        async: false,
        dataType: 'json',
        // 根据currentPage的值重新渲染页面
        success: function (res) {
          // 获取当前数据总数并计算最大页数
          var maxPage = Math.ceil(res.total / 12);
          // 判断分页插件当前高亮页
          currentPage = maxPage > currentPage ? currentPage : maxPage;
          // 渲染数据
          render(currentPage);
          // 渲染分页插件
          pagination_render(currentPage);
        }
      })
    }

    // 点击删除
    $('tbody').on('click', '.btn-delete', function () {
      var that = this;
      btn_del({
        that: that,
        url: 'posts/posts_delete.php',
        app: false
      });
    })

    //================================================================ 批量删除
    $('.btn-all-delete').on('click', function () {
      var that = this;
      btn_del({
        that: that,
        url: 'posts/posts_delete.php',
        app: false
      });
    })

    //================================================================ 编辑
    $('tbody').on('click', '.btn-edit', function () {
      // 获取当前文章的data-id
      var $id = $(this).data('id');
      // 发送ajax请求获取数据渲染到编辑页
      $.ajax({
        type: 'get',
        url: 'posts/posts_edit.php',
        data: {
          id: $id,
        },
        dataType: 'json',
        success: function (res) {
          // 使用对象存储状态对应的中文
          var state = {
            published: '已发布',
            trashed: '回收站',
            drafted: '草稿'
          };
          // 转换为指定时间格式 YYYY-MM-ddThh:mm
          function loca_time(time) {
            // 以空格分割字符串
            var arr = time.split(' ');
            // 使用T连接字符串并且去掉后三位
            return arr.join('T').slice(0, -3);
          }
          // 渲染内容
          // 将当前文章id渲染到隐藏域
          $('#id').val(res.id);
          // 标题
          $('#title').val(res.title);
          // 内容
          $('#content').val(res.content);
          // 富文本默认内容
          editor.txt.html(res.content);
          // 别名
          $('#slug').val(res.post_slug);
          // 设置图片
          $('#img').prop('src', res.feature);
          // 调用方法,设置时间
          $('#created').val(loca_time(res.created))
          // 遍历所有分类option, 选中当前分类
          $('#category option').each(function (index, ele) {
            $(ele).prop('selected', $(ele).text() == res.name)
          });
          // 遍历所有状态option, 选中当前分类
          $('#status option').each(function (index, ele) {
            $(ele).prop('selected', $(ele).text() == state[res.status]);
          });
          // strong
          $('#strong').text(res.post_slug);
          $('#slug').on('input', function () {
            $('#strong').text($('#slug').val() || 'slug')
          })
          // 显示编辑页
          $('.edit-box').css({display: 'block'});

        }
      })
    })

    //================================================================ 放弃修改
    $('.btn-cancel').on('click', function () {
      $('.edit-box').css({display: 'none'});
    })

    //================================================================ 修改
    // 实时预览
    $('#feature').on('change', function () {
      $('#img').prop('src', URL.createObjectURL(this.files[0]));
    })
    $('.btn-update').on('click', function () {
      // 上传form表单数据
      // 获取数据序列
      var formData = new FormData($('#editForm')[0]);
      // 发送请求
      // $.ajax({
      //   type: 'post',
      //   url: 'posts/posts_mod.php',
      //   data: formData,
      //   contentType: false, // 不设置请求行
      //   processData: false, // 数据不进行编码
      //   success: function (res) {
      //     // 隐藏编辑模块
      //     $('.edit-box').hide();
      //     // 重新渲染
      //     render(currentPage);
      //   }
      // })

      $.ajax({
        type: 'post',
        url: 'posts/posts_mod.php',
        // 发送表单数据
        data: new FormData($('#editForm')[0]),
        // 不设置请求头
        contentType: false,
        // 不对数据进行编码
        processData: false,
        success:function () {
          // 重新渲染列表
          render(currentPage);
          // 隐藏模态块
          $('.edit-box').hide();
        }
      })
    })

    

  </script>
  
</body>
</html>