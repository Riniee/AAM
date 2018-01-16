$( "#forgot-password-mail" ).submit(function( event ) {

	if ( $( "#email" ).val().length === 0 ) {
		$('#validate_error').html('Email Cannot be empty');
		$('#validate_alert').show();
		//alert('username need');
		event.preventDefault();
	} else {
		
	}
});