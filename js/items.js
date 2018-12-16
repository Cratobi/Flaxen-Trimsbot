/* AJAX request to checker */
function check(){
	$.ajax({
		type: 'POST',
		url: 'php/item-check.php',
		dataType: 'json',
		data: {
			counter: $('#table-items').data('counter'),
			order_id: $('#table-items').data('order_id')
		},
		success: function(response) {
			$('#table-items').data('counter', response.current);
			if (response.update == true) {
				$('#table-items tbody').html(response.data);
				editable();
				set_background();
				search();
			}
		}
	});
}
check_update = setInterval(check, 10000);


$(document).ready(function() {
	$('.td-editable').on('hidden', function() {
		check();
		check_update = setInterval(check, 10000);
	});
	$('.td-editable').on('shown', function() {
		clearInterval(check_update);
	});
	editable();
});

$.fn.datepicker.defaults.format = "dd-mm-yyyy";
$.fn.datepicker.defaults.todayHighlight = true;
$.fn.datepicker.defaults.autoclose = true;
$.fn.editable.defaults.mode = 'inline';
$.fn.editable.defaults.showbuttons = false;
$.fn.editable.defaults.onblur = 'submit';
$.fn.editable.defaults.emptytext = '...';
$.fn.editable.defaults.emptyclass = 'txt-error';
$.fn.editable.defaults.highlight = false;
//$.fn.editable.defaults.toggle = 'dblclick';
function editable(){
	$('#table-items .td-txt').editable({
		type: 'text',
		url: 'php/edit-item.php',
		params: function(params) {
			var data = {};
			data["id"] = params.pk;
			data["header"] = params.name;
			data["value"] = params.value;
			return data;
		},
		success: function() {
			check();
		}
	});
	$('#table-items .td-no').editable({
		type: 'text',
		url: 'php/edit-item.php',
		tpl: '<input type="number" step="any">',
		params: function(params) {
			var data = {};
			data["id"] = params.pk;
			data["header"] = params.name;
			data["value"] = params.value;
			return data;
		},
		success: function() {
			check();
		}
	});
	$('#table-items .td-date').editable({
		type: 'text',
		url: 'php/edit-item.php',
		tpl: '<input type="text" data-provide="datepicker">',
		params: function(params) {
			var data = {};
			data["id"] = params.pk;
			data["header"] = params.name;
			data["value"] = params.value;
			return data;
		},
		success: function() {
			check();
		}
	});
}