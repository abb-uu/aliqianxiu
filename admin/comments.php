<?php 
include_once './inc/logined.php';
baixiu_get_current_user();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/vendors/pagination/pagination.css">
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
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <a href="javascript:;" class="btn btn-info btn-sm btn_all_app">批量批准</a>
          <a href="javascript:;" class="btn btn-danger btn-sm btn_all_delete">批量删除</a>
        </div>
        
        <!-- 分页模版 -->
        <!-- pull-right 让分页模块靠右显示 -->
        <div id="pagination" class="pull-right"></div>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>

        
        </tbody>
      </table>
    </div>
  </div>

  <?php $current_page = 'comments'; ?>

  <?php

  include './inc/aside.php';

  ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <!-- 分页js文件 -->
  <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
  <script src="js/check.js"></script>
  <!-- 模版引擎js文件 -->
  <script src="js/template-web.js"></script>
  <!-- 准备模版 -->
  <script type="text/html" id="tmp">
    {{each list v i}}
        <tr>
            <td class="text-center"><input type="checkbox" data-id="{{v.id}}"></td>
            <td>{{v.author}}</td>
            <td>{{v.content.substr(0, 20)}}...</td>
            <td>《{{v.title}}》</td>
            <td>{{v.created}}</td>
            <td>{{sta[v.status]}}</td>
            <td class="text-right">
            {{if v.status == 'held'}}
              <a href="javascript:;" class="btn btn-info btn-xs btn-approved" data-id="{{v.id}}">批准</a>
            {{/if}}
              <a href="javascript:;" class="btn btn-danger btn-xs btn-delete" data-id="{{v.id}}">删除</a>
            </td>
        </tr>
    {{/each}}
  </script>
  <script>

      // 记录当前展示哪一页的数据,默认为第一页
      var currentPage = 1;
      // 渲染为中文
      var state = {
        held : '待审核',
        approved: '准许',
        rejected: '拒绝',
        trashed: '回收站'
      }
      render(currentPage);
      function render(page) {
      // 发送ajax请求
      $.ajax({
        type: 'get',
        url: 'com/comGet.php',
        data: {
          page: page,
        },
        dataType: 'json',
        success: function (res) {
          var obj = {
            list: res,
            sta: state,
          };
          // 拼接字符串
          var htmlStr = template('tmp', obj);
          // 渲染到页面
          $('tbody').html(htmlStr);
          // 根据状态渲染不同的颜色
          $('tbody tr').each(function (index, ele) {
            // 获取当前状态
            var txt = $(ele).children().eq(5).text();
            var color;
            switch (txt) {
              case '待审核':
              color = 'rgb(134, 201, 218)';
              break;
              case '准许':
              color = 'rgb(147, 226, 157)';
              break;
              case '拒绝':
              color = 'rgb(226, 147, 147)';
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
          })

          $('thead input').prop('checked', false);
          $('.btn-batch').fadeOut();
          // 批量删除与批量批准
          var checkboxs = $('tbody input');
          var checkboxAll = $('thead input');
          var allDelect = $('.page-action .btn-batch');
          // 调用删除方法
          delete_pub_del(checkboxs, checkboxAll, allDelect, false);
        }
      });
    }
      // 渲染分页插件
      pagination_render(currentPage);
      function pagination_render(page) {
        $.ajax({
        url: 'com/comGetTotal.php',
        type: 'get',
        dataType: 'json',
        success: function (res) {
          $('#pagination').pagination(res, {
            prev_text: '上一页',
            next_text: '下一页',
            items_per_page: 15, // 每一页的数据量,默认为10
            num_edge_entries: 1, // 首尾展示页码的数量
            num_display_entries: 6, // 中间展示页码的数量
            current_page: page - 1, // 默认展示的页码
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
      
      function btn_del(options) {
        var that = options.that || this;
        var url = options.url || '';
        var app = options.app || false;
        // 获取当前按钮自定义属性的值
        var id = that.dataset.id;
        // 发送请求
        $.ajax({
          type: 'get',
          url: url,
          data: {
            id: id,
          },
          dataType: 'json',
          // 根据currentPage的值重新渲染页面
          success: function (res) {
            // 获取当前数据总数并计算最大页数
            var maxPage = Math.ceil(res.total / 15);
            // 判断分页插件当前高亮页
            currentPage = maxPage > currentPage ? currentPage : maxPage;
            // 渲染数据
            render(currentPage);
            // 渲染分页插件
            if(!app) {
              pagination_render(currentPage);
            }
          }
        })
      }

      function btn_app(that) {
        // 获取当前按钮自定义属性的值
        var id = that.dataset.id;
        // 发送请求
        $.ajax({
          type: 'get',
          url: 'com/comApp.php',
          data: {
            id: id,
          },
          // 根据currentPage的值重新渲染页面
          success: function () {
            render(currentPage);
          }
        })
      };
      // 批准按钮
      $('tbody').on('click', '.btn-approved', function () {
        // 获取当前按钮自定义属性的值
        var id = this.dataset.id;
        // 发送请求
        $.ajax({
          type: 'get',
          url: 'com/comApp.php',
          data: {
            id: id,
          },
          // 根据currentPage的值重新渲染页面
          success: function () {

            render(currentPage);
            
          }
        })
      })

      // 删除
      $('tbody').on('click', '.btn-delete', function () {
        var that = this;
        btn_del({
          that: that,
          url: 'com/comDel.php',
          app: false
        });
      })

      // 批量删除
      $('.btn_all_delete').on('click', function () {
        var that = this;
        btn_del({
          that: that,
          url: 'com/comDel.php',
          app: false
        });
      })
      
      // 批准
      $('tbody').on('click', '.btn_all_app', function () {
        var that = this;
        btn_app(that);
      })
      // 批量批准
      $('.btn_all_app').on('click', function () {
        var that = this;
        btn_app(that);
      })


  </script>
  <script>NProgress.done()</script>
  <!-- <script>
  </script> -->
</body>
</html>

