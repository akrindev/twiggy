$("form").submit(function(e){
	e.preventDefault();
  
  
  var me = $(this);
 
  $("button").addClass('disabled');
  
  
  $.ajax({
  	url: me.attr('action'),
    data: me.serialize(),
    type: 'post',
    dataType: 'json',
    beforeSend: function(){
      
	  $("#notify").html("<div class='alert alert-info'>Authenticating . . .</div>").slideDown('slow');
    },
    success: function(r){
      
	  $("#notify").html("<div class='alert alert-success'>Successfully . . .</div>");
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