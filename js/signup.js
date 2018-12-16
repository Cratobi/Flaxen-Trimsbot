$(document).ready( function(){
	$form = $("#signupForm");
	$("#input-username").change(function(){
		$.ajax({
			type: 'POST',
			url: 'php/user-check.php',
			dataType: 'json',
			data: {
				username: $form.find('input[name="username"]').val()
			},
			success: function(response){
				if (response.update == false){
					$form.find('input[name="username"]').removeClass("txt-success").addClass("txt-error");
					$("#error-username-msg").text(response.status);
				} else {
					$form.find('input[name="username"]').removeClass("txt-error").addClass("txt-success");
					$("#error-username-msg").text("");
				} //window.location.replace("/FatMang/");
			}
		});
	});
	$form.submit(function(event){
		event.preventDefault();	// Prevent form submission
		$.ajax({
			type: 'POST',
			url: $form.attr('action'),
			dataType: 'json',
			data: {
				name: $form.find('input[name="name"]').val(),
				username: $form.find('input[name="username"]').val(),
				password: $form.find('input[name="password"]').val(),
				privillege: $form.find('input[name="privillege"]:checked').val(),
				ref: $form.find('input[name="ref"]').val()
			},
			success: function(response){
				console.log(response.state);
				if (response.update == false){
					if (response.state == 0){
						$form.find('input[name="username"]').addClass("txt-error").focus();
						$form.find('input[name="password"]').val('');
						$("#error-username-msg").text(response.status);
					}
					else if(response.state == 1){
						$("#error-header-msg").text(response.status);
						$("#error-username-msg").text("");
						$("#error-ref-msg").text("");
					}
					else if(response.state == 2){
						$form.find('input[name="ref"]').val('').focus();
						$("#error-ref-msg").text(response.status);
						$("#error-username-msg").text("");
						$("#error-header-msg").text("");
					}
				}
				else if(response.update == true) {
					if(response.state == 3){
						window.location.href="index.php";
					}
					if (response.state == 4) {
						clear_ref_form();
						toaster("New user has been added")
					}
					$("#error-username-msg").text("");
					$("#error-ref-msg").text("");
					$("#error-header-msg").text("");
				}
			}
		});
	});
});
function clear_ref_form(){
	$form = $('#signupForm');
	$form.find('input[type=text], input[type=password]').val('');
	$form.find('input[value=1]').prop( "checked", true );
}
