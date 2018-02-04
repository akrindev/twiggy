$("form").submit(function(e){
	e.preventDefault();
  
  
  var me = $(this);
 
  $('.form-group').removeClass('has-error');
  $('.text-danger').remove();
  
  
  $.ajax({
  	url: me.attr('action'),
    data: me.serialize(),
    type: 'post',
    dataType: 'json',
    beforeSend: function(){
      
	  $("#notify").html("<div class='alert alert-info'>Publishing . . .</div>").slideDown('slow');
    },
    success: function(r){
      if(r.validation){
        
      	if(r.status){
      
	  		$("#notify").html("<div class='alert alert-success'>Successfully, redirecting . . .</div>");
        
      		setTimeout(function(){
        		window.location.href = '/profile';
      		},2000);
      	} else {
        
	  		$("#notify").html("<div class='alert alert-danger'>Failed!!</div>");
        
      	}
        
      } else {
        
	  $("#notify").html("<div class='alert alert-danger'>Ups!! something goes wrong</div>");
        
        $.each(r.errors, function(key, value) {
          
          var element = $('#' + key);
          element.closest('div.form-group')
            .removeClass('has-error')
            .addClass(value.length > 0 ? 'has-error' : 'has-success')
            .find('.text-danger')
            .remove();
          element.after('<span class="text-danger">' + value + "</span>");
        });
      }
      
      $("button").removeClass('disabled');
    },
    error: function(j, s, t){
      alert(j+s+t);
    },
    fail:function(){
      alert('fail');
    }
  
  });


});