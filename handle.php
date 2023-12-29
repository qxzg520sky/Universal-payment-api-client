<?php

// 接收POST参数
$mchId = $_POST['mchId'];
$wayCode = $_POST['wayCode'];
$subject = $_POST['subject'];
$outTradeNo = $_POST['outTradeNo'];
$amount = $_POST['amount'];
$clientIp = $_POST['clientIp'];
$notifyUrl = $_POST['notifyUrl'];
$returnUrl = $_POST['returnUrl'];
$reqTime = $_POST['reqTime'];
$sign = $_POST['sign'];

// 创建请求的数据
$data = array(
    'mchId' => $mchId,
    'wayCode' => $wayCode,
    'subject' => $subject,
    'outTradeNo' => $outTradeNo,
    'amount' => $amount,
    'clientIp' => $clientIp,
    'notifyUrl' => $notifyUrl,
    'returnUrl' => $returnUrl,
    'reqTime' => $reqTime,
    'sign' => $sign
);

// 将数据转换为JSON格式
$jsonData = json_encode($data);

// 创建一个cURL资源
$ch = curl_init();

// 设置请求的URL
curl_setopt($ch, CURLOPT_URL, 'https://yangpayozfwe6wav.zzbbm.xyz/api/pay/unifiedorder');
// 设置请求方法为POST
curl_setopt($ch, CURLOPT_POST, true);
// 设置请求的数据
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
// 设置请求头部
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
// 将响应输出而不是直接返回
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

// 执行请求并获取响应
$response = curl_exec($ch);

// 输出响应结果
echo $response;

// 关闭cURL资源
curl_close($ch);

?>