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