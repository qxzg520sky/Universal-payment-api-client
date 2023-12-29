<?php
$userAgent = $_SERVER['HTTP_USER_AGENT'];
// Get the current URL
$currentURL = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// 判断是否为微信
if (strpos($userAgent, 'MicroMessenger') !== false) {
    echo '<img src="./static/images/weixin-guide.png" alt="微信打开" width="100%" height="auto">';
    exit;
} elseif (strpos($userAgent, 'QQ/') !== false) {
    echo '<img src="./static/images/qq-guide.jpg" alt="QQ打开" width="100%" height="auto">';
    exit;
} elseif (strpos($userAgent, 'AlipayClient') !== false) {
    // 判断是否为支付宝
    echo '<img src="./static/images/weixin-guide.png" alt="支付宝打开" width="100%" height="auto">';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simulated Security Check</title>
  <!-- Include jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <style>
    #progressbar {
      width: 50%;
      margin: 20px auto;
    }

    #notification {
      font-size: 24px;
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<div id="notification">正在进行安全检查...</div>
<div id="progressbar"></div>

<script>
  // Display a message and progress bar on page load
  $(document).ready(function () {
    $("#progressbar").progressbar({
      value: false
    });

    // Simulate security check for 3 seconds
    setTimeout(function () {
      // Close the progress bar
      $("#progressbar").hide();
      // Open the webpage after the security check
      $("#notification").text("安全检查完成，即将打开网页。");
      // Redirect to your actual webpage URL
      setTimeout(function () {
        window.location.href = "./t2.php";
      }, 2000);
    }, 3000);
  });
</script>

</body>
</html>
