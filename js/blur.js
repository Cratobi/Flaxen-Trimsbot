$(document).ready(function(){
	$('body').prepend('<div class="blur"></div>');
	set_background();
	
});
$(window).resize(function(){
	set_background();
});

function set_background(){
	$width = $('#blur-element').width();
	$height = $('#blur-element').height();
	$position = $("#blur-element").offset();
	$('.blur').css({
		'width': $width,
		'height': $height,
		'top': $position.top,
		'left': $position.left
	});
	$('head').append('<style>.blur:before{width:calc(' + $width + 'px + 50px) !important;height:calc(' + $height + 'px + 50px) !important;top:' + $position.top + '; left:' + $position.left + '}</style>');
}