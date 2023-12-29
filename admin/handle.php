<!-- 引入 Layui 的 CSS 文件 -->
<link rel="stylesheet" type="text/css" href="https://cdn.staticfile.org/layui/2.5.6/css/layui.min.css" />

    <!-- 引入 Layui 的 JS 文件 -->
<script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdn.staticfile.org/layui/2.5.6/layui.min.js"></script>
<?php
// 接收表单数据
$tabName = $_POST['tabName'];
$merchantNumber = $_POST['merchantNumber'];
$apiKey = $_POST['apiKey'];
$channelType = $_POST['channelType'];
$productTitle = $_POST['productTitle'];

// 读取原始config.txt内容
$config = file_get_contents(__DIR__ . '/config.txt');
// 根据tabName查找需要更新的配置段落
$escapedTabName = preg_quote($tabName, '/');

// 使用转义后的标签进行匹配
preg_match("/\[$escapedTabName\].*?(?=\[|$)/s", $config, $matches);
$existingConfig = $matches[0];

if (!empty($existingConfig)) {

  
  // 构建新的配置段落
  $newConfig = "[$tabName]\n";
  $newConfig .= "merchantNumber=$merchantNumber\n";
  $newConfig .= "apiKey=$apiKey\n";
  $newConfig .= "channelType=$channelType\n";
  $newConfig .= "productTitle=$productTitle\n";

  // 替换原始config.txt中对应的配置段落
  $newContent = str_replace($existingConfig, $newConfig, $config);

  // 更新config.txt文件
  file_put_contents(__DIR__ . '/config.txt', $newContent);

  // 返回成功信息
  // 在配置成功后
    echo "<script>";
    echo "layui.use('layer', function() {";
    echo "    layer.msg('Config updated successfully!', {icon: 1});";
    echo "    setTimeout(function() {";
    echo "        window.location.href = 'main-local.php';";
    echo "    }, 2000);";
    echo "});";
    echo "</script>";
} else {
  // 在未找到匹配配置部分时
    echo "<script>";
    echo "layui.use('layer', function() {";
    echo "    layer.msg('Failed to find a matching config section for tab name: $tabName', {icon: 2});";
    echo "    setTimeout(function() {";
    echo "        window.location.href = 'main-local.php';";
    echo "    }, 2000);";
    echo "});";
    echo "</script>";
}
if (isset($_POST['newDirectoryName'])) {
    $newDirectoryName = $_POST['newDirectoryName'];
    $content = "[newDirectoryName]\nmerchantNumber=\napiKey=\nchannelType=\nproductTitle=\n";

    $currentPath = dirname(__FILE__); // 获取当前脚本所在的路径
    $originalPath = $currentPath . "/../original"; // 计算原始文件目录的绝对路径

    // 递归地复制文件和目录
    function copyFolder($source, $destination) {
        if (is_dir($source)) {
            if (!file_exists($destination)) {
                mkdir($destination);
            }
            $files = scandir($source);
            foreach ($files as $file) {
                if ($file !== "." && $file !== "..") {
                    copyFolder($source . "/" . $file, $destination . "/" . $file);
                }
            }
        } else {
            copy($source, $destination);
        }
    }
      // 创建目录
    if (!file_exists($currentPath.'/../'.$newDirectoryName)) {
        mkdir($currentPath.'/../'.$newDirectoryName);
        echo "目录创建成功！";
    } else {
        echo "目录已存在！";
    }
    
    // 复制文件和目录
    copyFolder($originalPath, $currentPath.'/../'.$newDirectoryName);
    // 附加内容到 config.txt 文件
    $filename = __DIR__ . "/config.txt";
    $file = fopen($filename, 'a');
    if ($file) {
        fwrite($file, str_replace("newDirectoryName", $newDirectoryName, $content));
        fclose($file);

        // 成功附加内容后的提示和页面跳转
        echo "<script>";
        echo "layui.use('layer', function() {";
        echo "    layer.msg('Content appended to config.txt successfully!', {icon: 1});";
        echo "    setTimeout(function() {";
        echo "        history.go(-1);";
        echo "    }, 2000);";
        echo "});";
        echo "</script>";
        exit; // 为了防止继续执行其他代码，结束脚本执行
    } else {
        echo "<script>";
        echo "layui.use('layer', function() {";
        echo "    layer.msg('Failed to open config.txt for appending content!', {icon: 2});";
        echo "    setTimeout(function() {";
        echo "        history.go(-1);";
        echo "    }, 2000);";
        echo "});";
        echo "</script>";
        exit; // 为了防止继续执行其他代码，结束脚本执行
    }
} 

// handle.php
// 递归删除目录及其所有文件
function deleteDirectory($dir) {
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? deleteDirectory("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}
if (isset($_POST['deleteDirectoryName'])) {
    $deleteDirectoryName = $_POST['deleteDirectoryName'];
    // 获取当前目录的上级目录
    $rootDirectory = realpath('..');
    
    // 拼接要删除的目录路径
    $deleteDirectoryPath = $rootDirectory . DIRECTORY_SEPARATOR . $deleteDirectoryName;
    
    // 删除目录及其所有文件
    if (is_dir($deleteDirectoryPath)) {
        deleteDirectory($deleteDirectoryPath);
        echo "目录 $deleteDirectoryName 及其所有文件已成功删除。";
    } else {
        echo "目录 $deleteDirectoryName 不存在。";
    }
    
   
    // Read content of config.txt
    $configContent = file_get_contents('config.txt');

    // Match the content between square brackets
    $pattern = "/\[(.*?)\]/";
    preg_match_all($pattern, $configContent, $matches);

    // Find the index of the specified directory name
    $index = array_search($deleteDirectoryName, $matches[1]);

    if ($index !== false) {
        // Remove the section between square brackets for the specified directory
        $start = strpos($configContent, '[' . $deleteDirectoryName . ']');
        $end = strpos($configContent, '[', $start + 1);

        if ($end === false) {
            // If the end is not found, remove until the end of the file
            $configContent = substr_replace($configContent, '', $start);
        } else {
            // Remove the section between square brackets
            $configContent = substr_replace($configContent, '', $start, $end - $start);
        }

        // Update the config.txt file
        file_put_contents('config.txt', $configContent);

        // Use layui to show a success message and redirect after 2 seconds
        echo "
            <script>
                layui.use('layer', function(){
                    var layer = layui.layer;
                    layer.msg('删除成功', {
                        time: 2000
                    }, function(){
                        window.location.href = document.referrer;
                    });
                });
            </script>
        ";
    } else {
        // Use layui to show an error message
        echo "
            <script>
                layui.use('layer', function(){
                    var layer = layui.layer;
                    layer.msg('未找到对应目录，删除失败', {
                        icon: 2,
                        time: 2000
                    });
                });
            </script>
        ";
    }
}


?>