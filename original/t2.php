<html lang="zh-cn" class="cye-disabled cye-nm">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>向商户付款</title>
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta name="format-detection" content="telephone=no" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <link rel="stylesheet" href="./static/css/default.css" />
    <link rel="stylesheet" href="./static/css/style.css" />
    <style id="nightModeStyle">
      html.cye-enabled.cye-nm:not(*:-webkit-full-screen) body,
      html.cye-enabled.cye-nm:not(*:-webkit-full-screen) #cye-workaround-body {
        -webkit-filter: contrast(91%) brightness(84%) invert(1);
      }
    </style>
    <style id="cyebody">
      html.cye-enabled.cye-lm body {
        background-color: #c0dcc3 !important;
        border-color: rgb(48, 55, 48) !important;
        color: #000000 !important;
      }
    </style>
    <style id="cyediv">
      html.cye-enabled.cye-lm div {
        background-color: #c0dcc3 !important;
        border-color: rgb(48, 55, 48) !important;
        color: #000000 !important;
      }
    </style>
    <style id="cyetable">
      html.cye-enabled.cye-lm th {
        background-color: #c0dcc3 !important;
        border-color: rgb(48, 55, 48) !important;
        color: #000000 !important;
      }
      html.cye-enabled.cye-lm td {
        background-color: #c0dcc3 !important;
        border-color: rgb(48, 55, 48) !important;
        color: #000000 !important;
      }
    </style>
    <style id="cyetextInput">
      html.cye-enabled.cye-lm input[type="text"] {
        background-color: #c0dcc3 !important;
        border-color: rgb(48, 55, 48) !important;
        color: #000000 !important;
      }
      html.cye-enabled.cye-lm textarea {
        background-color: #c0dcc3 !important;
        border-color: rgb(48, 55, 48) !important;
        color: #000000 !important;
      }
    </style>
    <style id="cyeselect">
      html.cye-enabled.cye-lm select {
        background-color: #c0dcc3 !important;
        border-color: rgb(48, 55, 48) !important;
        color: #000000 !important;
      }
    </style>
    <style id="cyeul">
      html.cye-enabled.cye-lm ul {
        background-color: #c0dcc3 !important;
        border-color: rgb(48, 55, 48) !important;
        color: #000000 !important;
      }
    </style>
    <style id="cyeChangeByClick">
      html.cye-enabled.cye-lm .cye-lm-tag,
      html.cye-enabled.cye-lm.cye-lm-tag {
        background-color: #c0dcc3 !important;
        border-color: rgb(48, 55, 48) !important;
        color: #000000 !important;
      }
    </style>
  </head>
  <body style="">
    <div id="wechat" style="width: 100%; margin: 0px auto; display: none;">
      <img src="./static/images/weixin-guide.png" alt="微信打开">
    </div>
    <div class="layout-flex wrap" id="mainDiv">
      <!-- content start -->
      <div class="content">
        <div id="productNames" style="width: 100%;height: 40px;font-size: 20px;">

        </div>
        <div id="productList" style="margin-top:10px; display: flex; flex-wrap: wrap;">
        </div>
        <style>
        label > span {width: 87%; height: 40px; overflow:hidden; font-size: 16px;   display: inline-block;
 vertical-align: middle;}
        /*label > span { width:40%; height: 23px; overflow:hidden; font-size: 16px; }
        label:nth-child(odd){ margin-right:5px; }*/
        #productList input[type="radio"] {display: none; }
        #productList input:checked + .button {background: #0076fe; color: #fff; cursor: default; }
        #productList .button {display: inline-block; margin: 0 0px 10px 0; padding: 5px 10px; background: #f7f7f7; color: #333; cursor: pointer; }
        #productList .button:hover {background: #bbb; color: #fff; }
        #productList .round {border-radius: 5px; border: 1px #555555 solid;}
        </style>        
      </div>
      <div class="set_amount">
        <div class="payMoney marLeft10">请输入付款金额</div>
        <div class="amount_bd">
          <i class="i_money marLeft10" style="">¥</i>
          <span class="input_simu" id="amount">0</span>

          <!-- 模拟input -->
          <em class="line_simu" id="line"></em>
          <!-- 模拟闪烁的光标 -->
          <div
            id="clearBtn"
            style="
              touch-action: pan-y;
              user-select: none;
              -webkit-user-drag: none;
              -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            "
          ></div>
          <!-- 清除按钮 -->
        </div>
      </div>
      <!-- content end -->

      <div class="copyRight"></div>
      <!-- 键盘 -->
      <div class="keyboard">
        <table
          class="key_table" id="keyboard" style="touch-action: pan-y;user-select: none;-webkit-user-drag: none;-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
          <tbody>
            <tr>
              <td class="key border b_rgt_btm" data-value="1">1</td>
              <td class="key border b_rgt_btm" data-value="2">2</td>
              <td class="key border b_rgt_btm" data-value="3">3</td>
              <td class="key border b_btm clear" data-value="delete"></td>
            </tr>
            <tr>
              <td class="key border b_rgt_btm" data-value="4">4</td>
              <td class="key border b_rgt_btm" data-value="5">5</td>
              <td class="key border b_rgt_btm" data-value="6">6</td>
              <td
                class="pay_btn" rowspan="3" id="payBtn" style="touch-action: pan-y;user-select: none;-webkit-user-drag: none;-webkit-tap-highlight-color: rgba(0, 0, 0, 0);" >
                <em>确认</em>支付
              </td>
            </tr>
            <tr>
              <td class="key border b_rgt_btm" data-value="7">7</td>
              <td class="key border b_rgt_btm" data-value="8">8</td>
              <td class="key border b_rgt_btm" data-value="9">9</td>
            </tr>
            <tr>
              <td colspan="2" class="key border b_rgt" data-value="0">0</td>
              <td class="key border b_rgt" data-value="dot">.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="circle-box none">
      <div class="circle_animate">
        <div class="circle"></div>
        <p></p>
      </div>
    </div>
    <div class="pop_wrapper none">
      <div class="pop_outer">
        <div class="pop_cont">
          <div class="pop_tip"></div>
          <p class="border b_top"><span class="pop_btn">我知道了</span></p>
        </div>
      </div>
    </div>
    <script src="./static/js/jquery.min.js"></script>
    <script src="./static/js/hammer.js"></script>
    <script src="./static/js/common.js"></script>
    <script src="./static/js/pay.js"></script>
    <script src="./static/js/md5.min.js"></script>
    <script>
    var clientIp;
    var tips = new Tips();
      $(document).ready(function(){
          var ua = window.navigator.userAgent.toLowerCase();
          //通过正则表达式匹配ua中是否含有MicroMessenger字符串
          if(ua.match(/MicroMessenger/i) == 'micromessenger'){
              $("#wechat").show();
              $("#mainDiv").hide();
          }else{
              $("#mainDiv").show();
              $("#wechat").hide();
          }
          //判断是IOS还是安卓还是WEB
          // var device =OS();
          // $("#device").val(device);
      
      
      
      var order=generateOrderNumber();
      $(".copyRight").html("订单号: " + order);
        function getPublicIP(callback) {
          $.ajax({
            url: "https://api.ipify.org?format=json",
            dataType: "json",
            async: false,
            success: function(data) {
              var publicIP = data.ip;
              callback(publicIP);
            },
            error: function(xhr, status, error) {
              console.log("无法获取公网IP地址");
            }
          });
        }
    getPublicIP(function(ip) {
      clientIp = ip;
      console.log(clientIp);
    }); 
      });
    </script>
  </body>
</html>
