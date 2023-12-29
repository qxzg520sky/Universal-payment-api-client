function updateAmount(number) {
  const amountInput = document.getElementById('amountInput');
  amountInput.value = '￥' + number;
}

function clearAmount() {
  const amountInput = document.getElementById('amountInput');
  amountInput.value = '￥0';
}

function confirmAmount() {
  const amountInput = document.getElementById('amountInput');
  const amount = amountInput.value.substring(1);
  alert('付款金额为：' + amount);
}