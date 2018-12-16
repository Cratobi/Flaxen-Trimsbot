$(document).ready(function(){
	$('#ref_permission').change(function(){
		$('#ref_permission').prop('disabled', true);
		$('#ref_code_reset').prop('disabled', true);
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: 'php/user-signup-code.php',
			success: function(response){
				if (response.status == 0) {
					$('#ref_code').val("");
					$('#ref-form').slideUp();
					$('.ref-btn-txt').text("Turn on Sign up");
					$('#ref_permission').prop('disabled', false);
				} else if (response.status == 1) {
					$('#ref_code').val(response.code);
					$('#ref-form').find('input[name=ref]').val(response.code);
					$('#ref-form').slideDown();
					$('#ref_permission').prop('disabled', false);
					$('#ref_code_reset').prop('disabled', false);
					$(".ref-icon i").removeClass("disabled");
					$('.ref-btn-txt').text("Turn off Sign up");
				}
			}
		});
	});
});
function ref_code_new(){
	$(".ref-icon i").addClass("disabled");
	$('#ref_permission').prop('disabled', true);
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'php/user-signup-code-reset.php',
		success: function(response){
			$('#ref_code').val(response.code);
			$('#ref_permission').prop('disabled', false);
			$(".ref-icon i").removeClass("disabled");
		}
	});
}