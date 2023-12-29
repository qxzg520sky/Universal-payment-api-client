<?php

header('Location: https://www.qq.com');

exit;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>欢迎使用支付系统</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      margin: 0;
      padding: 0;
      transition: background-color 0.5s ease;
    }

    h1 {
      font-size: 3em;
      margin-top: 2em;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script>
    $(document).ready(function() {
      setInterval(changeBackgroundColor, 2000); // 每 2 秒切换一次背景色

      function changeBackgroundColor() {
        var r = Math.floor(Math.random() * 256);
        var g = Math.floor(Math.random() * 256);
        var b = Math.floor(Math.random() * 256);
        var rgbColor = "rgb(" + r + "," + g + "," + b + ")";
        $("body").css("background-color", rgbColor);
      }
    });
  </script>
</head>

<body>
  <h1>欢迎使用支付系统</h1>
</body>

</html>