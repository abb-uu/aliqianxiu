<?php
// 判断是否是登录状态
include_once './inc/logined.php';
baixiu_get_current_user();


// 主页数据
include_once 'inc/fn.php';
$sql_posts = "select count(1) as num from posts";
$sql_drafted = "select count(1) as num from posts where status = 'drafted'";
$sql_categories = "select count(1) as num from categories";
$sql_comments = "select count(1) as num from comments";
$sql_held = "select count(1) as num from comments where status = 'held'";
$res_posts = my_select($sql_posts)['num'];
$res_drafted = my_select($sql_drafted)['num'];
$res_categories = my_select($sql_categories)['num'];
$res_comments = my_select($sql_comments)['num'];
$res_held = my_select($sql_held)['num'];

?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>

<body>
  <script>
    NProgress.start()
  </script>

  <div class="main">
    <?php

    include './inc/navbar.php';

    ?>
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.php" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong>
                  <?php echo $res_posts ?></strong>篇文章（<strong>
                  <?php echo $res_drafted ?></strong>篇草稿）</li>
              <li class="list-group-item"><strong>
                  <?php echo $res_categories ?></strong>个分类</li>
              <li class="list-group-item"><strong>
                  <?php echo $res_comments ?></strong>条评论（<strong>
                  <?php echo $res_held ?></strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>

  <!-- 数据报表 -->
  <div id="pie" style="width: 600px; height: 600px; position: absolute; left: 850px; top: 400px;">
  </div>

  <?php $current_page = 'index1' ?>

  <?php

  include './inc/aside.php';

  ?>


  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>
    NProgress.done()
  </script>
  <!-- 数据报表 -->
  <script src="../assets/vendors/chart/echarts.min.js"></script>
  <script>
    var myChart = echarts.init(document.getElementById('pie'));

    option = {
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        orient: 'vertical',
        left: 'left',
        data: ['文章','草稿','分类','评论','待审核']
    },
    series : [
        {
            name: '站内统计',
            type: 'pie',
            radius : '55%',
            center: ['60%', '40%'],
            data:[
                {value:<?php echo $res_posts ?>, name:'文章'},
                {value:<?php echo $res_drafted ?>, name:'草稿'},
                {value:<?php echo $res_categories ?>, name:'分类'},
                {value:<?php echo $res_comments ?>, name:'评论'},
                {value:<?php echo $res_held ?>, name:'待审核'}
            ],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
};


          myChart.setOption(option);

// '文章', '草稿', '分类', '评论', '待审核'
 

  </script>
</body>

</html>