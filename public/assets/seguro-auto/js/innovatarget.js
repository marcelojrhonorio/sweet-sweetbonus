jQuery(function(){
	$('#btn-doa').click(function() {
		$('.formulario').fadeIn(200)
		$('#btn-doa').hide();
	});
	$(document).on('click', 'a.page-scroll', function(event) {
		var $anchor = $(this);
		$('html, body').stop().animate({
			scrollTop: $($anchor.attr('href')).offset().top
		}, 1500, 'easeInOutExpo');
		event.preventDefault();
	});
});