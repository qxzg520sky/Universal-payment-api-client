<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  <link rel="stylesheet" type="text/css" href="https://cdn.staticfile.org/layui/2.5.6/css/layui.min.css">
</head>
<body>
  <div class="layui-container">
    <div class="layui-card">
      <div class="layui-card-header">Login Form</div>
      <div class="layui-card-body">
        <form class="layui-form" method="POST" action="index.php">
          <div class="layui-form-item">
            <label class="layui-form-label">Username</label>
            <div class="layui-input-block">
              <input type="text" name="username" lay-verify="required" placeholder="Enter your username" autocomplete="off" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">Password</label>
            <div class="layui-input-block">
              <input type="password" name="password" lay-verify="required" placeholder="Enter your password" autocomplete="off" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button class="layui-btn" lay-submit lay-filter="login">Login</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdn.staticfile.org/layui/2.5.6/layui.min.js"></script>
  <script>
  layui.use(['form', 'layer'], function(){
    var form = layui.form;
    var layer = layui.layer;

    // 监听登录表单提交
    form.on('submit(login)', function(data){
      var username = data.field.username;
      var password = data.field.password;

      // 使用 AJAX 提交表单数据并验证
      // 这里我使用了 jQuery 的 AJAX 方式发送请求，请确保页面已引入 jQuery 库
      $.ajax({
        type: 'POST',
        url: 'login.php', // 登录验证脚本的路径
        data: {username: username, password: password},
        dataType: 'json',
        success: function(response){
          if (response.success) {
            layer.msg('Login successful', {icon: 1});
            setTimeout(function(){
              window.location.href = 'main-local.php'; // 跳转到主页
            }, 1000);
          } else {
            layer.msg('Login failed. Please try again.', {icon: 2});
          }
        }
      });

      return false; // 阻止表单默认提交
    });
  });
  </script>
</body>
</html>