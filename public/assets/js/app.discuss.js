$('.avatar').initial();

  	$('form').submit(function(e) {
    	e.preventDefault();
      
      $.ajax({
      	url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        type: 'post',
        success: function(r) {
          alert('success');
        },
        error: function(j, s, t) {
          alert( j+ s + t);
        }
      });
    });