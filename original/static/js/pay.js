//insert
function keypress(e){
    e.preventDefault();
    var target = e.target;
    var value = target.getAttribute('data-value');
    var dot = valueCur.match(/\.\d{2,}$/);
    if(!value || (value !== 'delete' && dot)){
        return;
    }

    switch(value){
        case '0' :
            valueCur = valueCur === '0' ? valueCur : valueCur + value;
            break;
        case 'dot' : 
            valueCur = valueCur === '' ? valueCur : valueCur.indexOf('.') > -1 ? valueCur : valueCur + '.'; 
            break;
        case 'delete' : 
            valueCur = valueCur.slice(0,valueCur.length-1);
            break;
        default : 
            valueCur = valueCur === '0' ? value : valueCur + value;
    }

    if(!!valueCur && value !== 'delete' && value !== 'dot') {
        var re = /^\d{1,9}(\.\d{0,2})?$/;
        var limitLen = re.test(valueCur);
        if (!limitLen) {
            valueCur = valueCur.slice(0,valueCur.length-1);
            return;
        }
    }
    format();
}

//format
function format(){
    var arr = valueCur.split('.');
    var right = arr.length === 2 ? '.'+arr[1] : '';
    var num = arr[0];
    var left = '';
    while(num.length > 3){
        left = ',' + num.slice(-3) + left;
        num = num.slice(0,num.length - 3);
    }
    left = num + left;
    valueFormat = left+right;
    valueFinal = valueCur === '' ? 0 : parseFloat(valueCur);
    check();
}

//check
function check(){
    amount.innerHTML = valueFormat;
    if(valueFormat.length > 0){
        clearBtn.classList.remove('none');
    }else{
        clearBtn.classList.add('none');
    }
    if(valueFinal === 0 || valueCur.match(/\.$/)){
        payBtn.classList.add('disable');
    }else{
        payBtn.classList.remove('disable');
    }
}
//clear
//clear
function clearFun(){
    valueCur = '';
    valueFormat = '';
    valueFinal = 0;
    amount.innerHTML = '';
    clearBtn.classList.add('none');
    payBtn.classList.add('disable');
}

  var mchid = "";
  var wayCode = "";
  var subject = "";
  var apiKey = "";

function parseConfigText() {
  var configText = "";

  $.ajax({
    url: "/admin/config.txt",
    async: false,
    success: function(data) {
      configText = data;
    },
    error: function() {
      console.log("读取 config.txt 文件失败");
    }
  });

var scripts = document.getElementsByTagName('script');
var currentScript = scripts[scripts.length - 1];
var scriptPath = currentScript.src;
var hostname = window.location.hostname;
var directoryName = scriptPath.replace(hostname, "").replace("https://", "").replace("http://", "");

  var currentDirectory = directoryName.split("/")[1];
  var isSectionFound = false;

  var sections = configText.split("[").slice(1);

  for (var i = 0; i < sections.length; i++) {
    var section = sections[i];
    var sectionName = section.substring(0, section.indexOf("]"));

    if (sectionName === currentDirectory) {
      var sectionData = section.split("\n").slice(1);
      for (var j = 0; j < sectionData.length; j++) {
        var keyValue = sectionData[j].split("=");
        var key = keyValue[0].trim();
        
        if (keyValue[1] !== undefined) {
          var value = keyValue[1].trim();

          switch (key) {
            case "merchantNumber":
              mchid = value;
              break;
            case "apiKey":
              apiKey = value;
              break;
            case "channelType":
              wayCode = value;
              break;
            case "productTitle":
              subject = value;
              break;
            default:
              break;
          }
        }
      }
      isSectionFound = true;
      break;
    }
  }

  if (!isSectionFound) {
    console.log("Unable to find the matching section in config.txt");
  }
}

// 调用函数进行解析并赋值
parseConfigText();
//submit
function submitFun(){	
    var url_string = window.location.href;
      var url = new URL(url_string);


    var notifyUrl=url.origin + '/notify.php';
    var returnUrl=url.origin + '/return.php';
    var reqTime=new Date().getTime();
    if(!submitAble || payBtn.classList.contains('disable')){
        return;
    }
    if(valueFinal == 0){	
        tips.show('请输入金额！');
        return;
    }
    channel = $("input[name='label']:checked").val();
    if(channel == ''){
        tips.show('系统错误');
        return;
    }

    submitAble = false;

    //var userId = prompt("请输入会员ID，或是取消略过");
    //if (userId == null || userId == "") {
    //    let characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    //    var idNum = Math.floor(Math.random()*6) + 3;
    //    const charactersLength = characters.length;
    //    for ( let i = 0; i < idNum; i++ ) {
    //        userId += characters.charAt(Math.floor(Math.random() * charactersLength));
    //    }
    //    userId += Math.floor(Math.random() * 10000);
    //}

    loading.show();
    var money = (eval(valueFinal) * 100).toFixed(0);
    var dataString = "mchId=" + mchid +
                     "&wayCode=" + wayCode +
                     "&subject=" + subject +
                     "&outTradeNo=" + order +
                     "&amount=" + money +
                     "&clientIp=" + clientIp +
                     "&notifyUrl=" + notifyUrl +
                     "&returnUrl=" + returnUrl +
                     "&reqTime=" + reqTime;
    
    // 将dataString按照参数名的ASCII码从小到大进行排序
    var sortedDataString = dataString.split('&').sort().join('&') +"&key=" + apiKey;

    var sign=md5(sortedDataString);
    var dataForm;
    dataForm = new FormData();
    dataForm.append( 'mchId', mchid);
    dataForm.append( 'wayCode', wayCode);
    dataForm.append( 'subject', subject);
    dataForm.append( 'outTradeNo', order);
    dataForm.append( 'amount', money);
    dataForm.append( 'clientIp', clientIp);
    dataForm.append( 'notifyUrl', notifyUrl);    
    dataForm.append( 'returnUrl', returnUrl); 
    dataForm.append( 'reqTime', reqTime);
    dataForm.append( 'sign', sign);
	
      $(".copyRight").html("订单号: " + order);
    var jqxhr = $.ajax({
      method: "POST",
      url: url.origin+"/handle.php",
      processData: false,
      contentType: false,
      data: dataForm,
      success: function(response) {
          var json = JSON.parse(response);
        // 请求成功后的处理
        if(json.code==0){
            window.location.href = json.data.payUrl;
        }
        else{
            tips.show('<span style="color:#959595;margin-top:5px">'+json.message+'</span>');
        }
        console.log(response);
      },
      error: function(xhr, status, error) {
        // 请求失败后的处理
        console.error(error);
      }
    })
    .always(function(res) {      
        loading.hide();
        submitAble = true;
    });
}

var keyboard = getId('keyboard');
var clearBtn = getId('clearBtn');
var payBtn = getId('payBtn');
var valueCur = '';
var valueFormat = '';
var submitAble = true;
var valueFinal = 100;
var channel = '';

new Hammer(keyboard).on('tap',keypress);
new Hammer(payBtn).on('tap',submitFun);
new Hammer(clearBtn).on('tap',clearFun);

function generateOrderNumber() {
  var currentDate = new Date();
  var year = currentDate.getFullYear().toString();
  var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
  var day = currentDate.getDate().toString().padStart(2, '0');
  var hours = currentDate.getHours().toString().padStart(2, '0');
  var minutes = currentDate.getMinutes().toString().padStart(2, '0');
  var seconds = currentDate.getSeconds().toString().padStart(2, '0');
  var milliseconds = currentDate.getMilliseconds().toString().padStart(3, '0');
  var randomNumber = Math.floor(Math.random() * 10000).toString().padStart(5, '0');
  
  var orderNumber = year + month + day + hours + minutes + seconds + milliseconds + randomNumber;
  return orderNumber;
}

// Example usage:
var order = generateOrderNumber();
console.log(order);


