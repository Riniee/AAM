$( "#login-form" ).submit(function( event ) {

	if ( $( "#username" ).val().length === 0 ) {
		$('#validate_error').html('UserName Cannot be Blank');
		$('#validate_alert').show();
		//alert('username need');
		event.preventDefault();
	} else if ( $( "#password" ).val().length === 0 ) {
		$('#validate_error').html('Password Cannot be Blank');
		$('#validate_alert').show();
		event.preventDefault();
	} else {
		$('#username_error').hide();
		$('#password_error').hide();

	}
});