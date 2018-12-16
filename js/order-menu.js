 // Right click menu
$(document).ready(function(){
	order_menu();
});
function order_menu(){
	$('.icon-more').click(function(event){
		event.stopPropagation();
		$idx = $(this).parents('tr').data('id');
		rmenu_setValue($idx);
		$('#rmenu').show();
		$('#rmenu').css({
			'top': $(this).offset().top-10,
			'right': $(this).position().left+35
		});
		fetch_specific_order($idx);
	});
}

// Add order
function add_order(event) {
	event.preventDefault();
	$form = $("#order_form");
	$val_1 = $form.find('select[name="buyer_id"]').val();
	$val_2 = $form.find('input[name="style_no"]').val();
	$val_3 = $form.find('input[name="order_no"]').val();
	$val_4 = $form.find('input[name="quantity"]').val();
	$val_5 = $form.find('input[name="shipment_date"]').val();
	$val_6 = $form.find('input[name="status"]').val();
	$val_7 = $form.find('input[name="remarks"]').val();
	$url = $form.attr('action');

	$posting = $.post($url, {
		buyer_id: $val_1,
		style_no: $val_2,
		order_no: $val_3,
		quantity: $val_4,
		shipment_date: $val_5,
		status: $val_6,
		remarks: $val_7
	});

	$posting.done(function(data) {
		$form.find('select').val('');
		$form.find('input').not('input[type="submit"]').val('');
		$('#add_order').modal('hide');
		set_current_date();
		check();
	});
}
// Edit order
function edit_order(event) {
	event.preventDefault();
	$form = $("#edit_order_form");
	$val_1 = $form.find('input[name="idx"]').val();
	//$val_2 = $form.find('select[name="buyer_id"]').val();
	$val_3 = $form.find('input[name="style_no"]').val();
	$val_4 = $form.find('input[name="order_no"]').val();
	$val_5 = $form.find('input[name="quantity"]').val();
	$val_6 = $form.find('input[name="shipment_date"]').val();
	$val_7 = $form.find('input[name="status"]').val();
	$val_8 = $form.find('input[name="remarks"]').val();
	$url = $form.attr('action');
	//buyer_id: $val_2,
	$posting = $.post($url, {
		idx: $val_1,
		style_no: $val_3,
		order_no: $val_4,
		quantity: $val_5,
		shipment_date: $val_6,
		status: $val_7,
		remarks: $val_8
	});

	$posting.done(function(data) {
		//$form.find('select').val('');
		$form.find('input').not('input[type="submit"]').val('');
		$('#edit_order').modal('hide');
		check();
	});
}
// Clear form
function clear_form(){
	$form = $('#edit_order_form');
	$form.find('input').val('');
	//$form.find('select').val('');
}


// Asign value to rmenu
function rmenu_setValue(idx) {
	$('#redirect_item_rclick').attr('onclick', 'javascript:redirect_order('+idx+')');
	$('#order_checkout_rclick').attr('onclick', 'javascript:order_checkout('+idx+')');
	$('#remove_order').attr('onclick', 'javascript:remove_order('+idx+')');
}



// Redirect to item
function redirect_order(idx) {
	window.location = 'item.php?order_id='+idx+'';
}
// Fetch specific order
function fetch_specific_order(idx) {
	$.ajax({
		type: 'POST',
		url: 'php/fetch-specific-order.php',
		dataType: 'json',
		data: {
			idx: idx
		},
		success: function(response) {
			$('#edit_order_form').html(response.data);
			datepicker();
		}
	});
}

// Order checkout
function order_checkout(idx) {
	$url = 'php/order-checkout.php';
	var posting = $.post($url, {
		idx: idx
	});
	/* Put the results in a div */
	posting.done(function(data) {
		check();
	});
}
// Remove order
function remove_order(idx) {
	$url = 'php/order-remove.php';
	$posting = $.post($url, {
		idx: idx
	});
	$posting.done(function(data) {
		$('#remove_form').modal('hide');
		check();
	});
};

$(window).on('click', function(event) {
	$('#rmenu').hide();
});