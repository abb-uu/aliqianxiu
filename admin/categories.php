<?php
include_once './inc/logined.php';
include_once './inc/fn.php';
baixiu_get_current_user();
$current_page = 'categories';


// ==============================添加数据
// post请求且传入参数name和slug
function add_category()
{
  // 获取提交的数据
  
  // 校验
  if (empty($_POST['name']) || empty($_POST['slug'])) {
    $GLOBALS['add_message'] = '请填写完整表单';
    $GLOBALS['success'] = false;
    return;
  };
  $name = $_POST['name'];
  $slug = $_POST['slug'];

  // 持久化数据
  $sql_add = "insert into categories values (null, '$slug', '$name')";
  $res_add = my_exec($sql_add);
  $GLOBALS['success'] = $res_add == true;
  $GLOBALS['add_message'] = $res_add == true ? '添加成功' : '添加失败';
};
// 如果为post请求则调用函数
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  add_category();
};


// ==============================编辑数据
// get请求且传入参数id
function mod_category() 
{
  if (empty($_GET['id'])) return;

  $id = $_GET['id'];
  // 准备查询语句
  $sql_mod = "select * from categories where id = $id";
  // 调用方法
  $GLOBALS['res_mod'] = my_select($sql_mod);
};


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  mod_category();
};

// ===================修改数据







// 查询分类数据库
$sql = "select * from categories order by id desc";
$categories = my_select_all($sql);




?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
        <h1>分类目录</h1>
      </div>


      <?php if (isset($add_message)) : ?>
      <!-- 添加成功时显示 -->
      <?php if ($success) : ?>
      <div class="alert alert-success">
        <?php echo $add_message ?>
      </div>
      <!-- 添加失败时显示 -->
      <?php else : ?>
      <div class="alert alert-danger">
        <?php echo $add_message ?>
      </div>
      <?php endif ?>
      <?php endif ?>


      <div class="row">
        <div class="col-md-4">
          <?php if (isset($res_mod)): ?>
          <!-- $mod_message 定义时显示此表单 -->
          <form action="cate/cateMod.php" method="GET" autocomplete="off">
            <h2>编辑<< <?php echo $res_mod['slug'] ?> >></h2>
            <div class="form-group">
            <input type="hidden" name="id" value="<?php echo $res_mod['id']?>">
              <label for="name">名称</label>
              <!-- value为要编辑数据的name -->
              <input id="name" class="form-control" name="name" type="text" value="<?php echo $res_mod['name']?>">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <!-- value为要编辑数据的slug -->
              <input id="slug" class="form-control" name="slug" type="text" value="<?php echo $res_mod['slug']?>">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="保存">
              <a href="<?php echo $_SERVER['PHP_SELF']?>" class="btn btn-primary">取消</a>
            </div>
          </form>
          <?php else: ?>
          <!-- $mod_message 未定义时显示此表单 -->
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
            <h2>添加分类信息</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="添加">
            </div>
          </form>
          <?php endif ?>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="api/delete.php" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <!-- 将数据库中的信息渲染到页面 -->
              <?php foreach ($categories as $item) : ?>
                <tr>
                <!-- 添加自定义属性data-id存储当前数据在数据库中的id -->
                  <td class="text-center"><input type="checkbox" data-id="<?php echo $item['id'] ?>"></td>
                  <td><?php echo $item['name'] ?></td>
                  <td><?php echo $item['slug'] ?></td>
                  <td class="text-center">
                    <a href="<?php echo $_SERVER['PHP_SELF'] . "?id=" . $item['id'] ?>" class="btn btn-info btn-xs">编辑</a>
                    <a href="api/delete.php?id=<?php echo $item['id'] ?>" class="btn btn-danger btn-xs">删除</a>
                  </td>
                </tr>
              
              <?php endforeach ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


  <?php include './inc/aside.php'; ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="js/check.js"></script>
  <script>
    var checkboxs = $('tbody input');
    var checkboxAll = $('thead input');
    var allDelect = $('.page-action .btn-sm');
    delete_pub_del(checkboxs, checkboxAll, allDelect, true);
  </script>
  <script>NProgress.done()</script>
</body>
</html>
