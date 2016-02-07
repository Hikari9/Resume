$(function() {
	// resize span fonts on aside title
	$('.aside-title span').each(function() {
		var span = $(this);
		var title = $(this).parent();
		var font = parseFloat(span.css('font-size'));
		var scale = title.width() / span.width();
		span.css('font-size', font * scale + 'px');
	});
});