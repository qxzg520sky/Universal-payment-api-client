<!DOCTYPE html>
<html>
<head>
  <title>Your Website Title</title>
  <!-- Include necessary CSS dependencies for LAYUI -->
  <link rel="stylesheet" type="text/css" href="https://cdn.staticfile.org/layui/2.5.6/css/layui.min.css" />
    <!-- Include necessary JS dependencies for LAYUI -->
  <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdn.staticfile.org/layui/2.5.6/layui.min.js"></script>
</head>
<body>
<div class="layui-container">
  <div class="layui-tab layui-tab-brief">
    <ul class="layui-tab-title">
      <!-- Generate tab titles dynamically from config.txt file -->
      <?php
        $config = file_get_contents(__DIR__ . '/config.txt');
        preg_match_all('/\[(.*?)\]/', $config, $tabTitles);
        foreach ($tabTitles[1] as $index => $title) {
          $activeClass = ($index === 0) ? 'layui-this' : ''; // Add 'layui-this' class to the first tab
          echo "<li class=\"$activeClass\">$title</li>";
        }
      ?>
    </ul>
    <div class="layui-tab-content">
      <?php
        $formConfigs = preg_split('/\[(.*?)\]/', $config, -1, PREG_SPLIT_DELIM_CAPTURE);
        array_shift($formConfigs);
        for ($i = 0; $i < count($formConfigs); $i += 2) {
          $activeClass = ($i === 0) ? 'layui-show' : ''; // Set 'layui-show' class to the first form
          $formTitle = $formConfigs[$i];
          $formFields = explode("\n", trim($formConfigs[$i+1]));
          echo "<div class=\"layui-tab-item $activeClass\">";
          echo "<form class=\"layui-form\" method=\"POST\" action=\"handle.php\">";
          echo "<input type=\"hidden\" name=\"tabName\" value=\"$formTitle\" lay-verify=\"required\" placeholder=\"$fieldName\" class=\"layui-input\">";

          // Generate form fields dynamically from config.txt
          foreach ($formFields as $field) {
            if (!empty($field)) {
              $fieldData = explode("=", $field);
              $fieldName = trim($fieldData[0]);
              $fieldValue = trim($fieldData[1]);
              echo "<div class=\"layui-form-item\">";
              echo "<label class=\"layui-form-label\">$fieldName</label>";
              echo "<div class=\"layui-input-block\">";
              echo "<input type=\"text\" name=\"$fieldName\" value=\"$fieldValue\" lay-verify=\"required\" placeholder=\"$fieldName\" class=\"layui-input\">";
              echo "</div>";
              echo "</div>";
            }
          }
          
          // Add submit button
          echo "<div class=\"layui-form-item\">";
          echo "<div class=\"layui-input-block\">";
          echo "<button class=\"layui-btn\" lay-submit lay-filter=\"submit-form\">提交</button>";
          echo "</div>";
          echo "</div>";

          echo "</form>";
          echo "</div>";
        }
      ?>
    </div>
  </div>
  </div>
  <div class="layui-container">
  <form class="layui-form" action="handle.php" method="POST">
    <div class="layui-form-item">
      <label class="layui-form-label">新建目录</label>
      <div class="layui-input-block">
        <input type="text" name="newDirectoryName" placeholder="请输入目录名" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item">
      <div class="layui-input-block">
        <button class="layui-btn" lay-submit lay-filter="submitForm">提交</button>
      </div>
    </div>
  </form>
  </div>
  <div class="layui-container">
  <form class="layui-form" action="handle.php" method="POST">
    <div class="layui-form-item">
      <label class="layui-form-label">删除目录</label>
      <div class="layui-input-block">
        <input type="text" name="deleteDirectoryName" placeholder="请输入要删除的目录名" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item">
      <div class="layui-input-block">
        <button class="layui-btn" lay-submit lay-filter="deleteForm">删除</button>
      </div>
    </div>
  </form>
</div>

<?php 
// 获取服务器地址 
$http = empty($_SERVER['HTTPS']) ? 'http' : 'https'; $domain = $_SERVER['HTTP_HOST'];
// 读取配置文件
$filename = __DIR__ . "/config.txt"; $file = fopen($filename, 'r'); ?> <div class="layui-container"> <blockquote class="layui-elem-quote">共生成了以下网址:</blockquote> <ul class="layui-timeline">

<?php

if($file) {

  while(($line = fgets($file)) !== false) {

    preg_match("/\[(.*?)\]/", $line, $matches);

    if(!empty($matches)) {

      $directory = $matches[1];
      $url = "{$http}://{$domain}/{$directory}";

      echo "<li class='layui-timeline-item'>";

      echo "<i class='layui-icon layui-timeline-axis'>&#xe63f;</i>";

      echo "<div class='layui-timeline-content layui-text'>";
      
      echo "<h3 class='layui-timeline-title'>";

      echo "<a href='{$url}'>{$directory}</a>";

      echo "</h3>";

      // 生成二维码
      $qrcode = get_qrcode($url); 
      
      echo "<img src='{$qrcode}'>";

      echo "</div>";

      echo "</li>";

    }

  }

  fclose($file);

} else {

  echo "<div class='layui-elem-quote'>加载文件失败!</div>";

}

?>
</ul> </div> <?php 
// 调用API生成二维码 
function get_qrcode($url) { $response = file_get_contents("https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={$url}"); return "data:image/png;base64," . base64_encode($response); } ?>



  <!-- Include custom script file -->
  <script>
      layui.use(['layer', 'element', 'form'], function(){
  var layer = layui.layer;
  var element = layui.element;
  var form = layui.form;

  // Load default data for the tabs and forms on page load
  layer.ready(function() {
    var tabTitles = document.querySelectorAll('.layui-tab-title li');
    var tabContents = document.querySelectorAll('.layui-tab-content .layui-tab-item');
    var formFields = <?php echo json_encode($formFields); ?>;

    for (var i = 0; i < tabTitles.length; i++) {
      if (i === 0) {
        tabTitles[i].classList.add('layui-this');
        tabContents[i].classList.add('layui-show');
      } else {
        tabTitles[i].classList.remove('layui-this');
        tabContents[i].classList.remove('layui-show');
      }
    }

    // Fill form fields with loaded data
    var inputFields = document.querySelectorAll('form input');
    for (var i = 0; i < inputFields.length; i++) {
      var fieldName = inputFields[i].name;
      if (formFields.hasOwnProperty(fieldName)) {
        inputFields[i].value = formFields[fieldName];
      }
    }
  });
});
  </script>
</body>
</html>