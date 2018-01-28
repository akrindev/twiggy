$('form').submit(function(e) {
  e.preventDefault();
  
  var me = $(this);
  
  $(".form-group").removeClass('has-error');
  $(".text-danger").remove();
  
  //$("button").addClass('disabled');
  // perform ajax
  $.ajax({
    url: me.attr('action'),
    type: 'post',
    data: me.serialize(),
    dataType: 'json',
    success: function(response) {
     // $("#csrfp").val(response.csrfHash);
      if (response.status == true) {
      
        $("#notify").html("<div class='alert alert-success'>Successfully register . . .</div>");
        setTimeout(function(){
        	window.location.href = '/login';
        }, 2000)
        // and also remove the error class
        $('.form-group').removeClass('has-error')
          .removeClass('has-success');
        $('.text-danger').remove();
        // reset the form
        me[0].reset();
      }
      else {
        
        $.each(response.errors, function(key, value) {
          alert(key + ' ' + value)
          var element = $('#' + key);
          element.closest('div.form-group')
            .removeClass('has-error')
            .addClass(value.length > 0 ? 'has-error' : 'has-success')
            .find('.text-danger')
            .remove();
          element.after('<span class="text-danger">' + value + "</span>");
        });
      }
    }
  });
});