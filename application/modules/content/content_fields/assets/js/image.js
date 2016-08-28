$(document).ready( function() {

  $('.choose_image').click( function() {
    var link = $(this);
    var filemanager_path = '/application/third_party/file_manager/dialog.php?type=1&popup=1&field_id=image_placeholder';
    var w = 880;
    var h = 570;
    var l = Math.floor((screen.width-w)/2);
    var t = Math.floor((screen.height-h)/2);
    var win = window.open(
      filemanager_path, 
      'ResponsiveFilemanager', 
      "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l
    );

    $("#image_placeholder").on('load', function(){
      var image_src = $("#image_placeholder").attr('src');

      $.post(ADMIN_URL + '/content/entries/create-thumb', {'image_path': image_src}, function(image_path) {
        link.parent().find('.image_thumb').attr('src', image_path);
        link.parent().find('.hidden_file').val(image_src);
      });
    });
    
  });

  $('.remove_image').click( function() {
    var link = $(this);
    $.post(ADMIN_URL + '/content/entries/create-thumb', {'image_path': ' '}, function(image_path) {
      link.parent().find('.image_thumb').attr('src', image_path);
    });
    $(this).parent().find('.hidden_file').attr('value', '');
  });
  
});
