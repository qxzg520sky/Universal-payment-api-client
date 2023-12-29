<?php
$mchId = $_POST['mchId'];
$tradeNo = $_POST['tradeNo'];
$outTradeNo = $_POST['outTradeNo'];
$originTradeNo = $_POST['originTradeNo'];
$amount = $_POST['amount'];
$subject = $_POST['subject'];
$body = $_POST['body'];
$extParam = $_POST['extParam'];
$state = $_POST['state'];
$notifyTime = $_POST['notifyTime'];
$sign = $_POST['sign'];

if ($state == 1) {
   header("Location: index.html");
    exit;
}
?>