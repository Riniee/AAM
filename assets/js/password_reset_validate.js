$( "#password-reset" ).submit(function( event ) {
	if ( $( "#password" ).val().length === 0 ) {
		$('#validate_error').html('Password Cannot be Blank');
		$('#validate_alert').show();
		event.preventDefault();
	}
    else if ( $( "#cpassword" ).val().length === 0 ) {
		$('#validate_error').html('Confirm Password Cannot be Blank');
		$('#validate_alert').show();
		event.preventDefault();
	}
    else if ( $( "#password" ).val() !== $( "#cpassword" ).val() ) {
		$('#validate_error').html('Password Missmatched');
		$('#validate_alert').show();
		event.preventDefault();
	}
    else {
		$('#password_error').hide();

	}
});