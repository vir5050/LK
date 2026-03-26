(function($){
	$('.news').hover(function() {
		$('.news').addClass('disable');
		$(this).removeClass('disable');
	}, function() {
		$('.news').removeClass('disable');
	});

	$(document).ready(function(){
		$('.spoiler_links').click(function(){
			$(this).parent().children('div.spoiler_body').toggle('normal');
			return false;
		});

		$.ajax({
			url: '/statuses/',
			method: 'GET',
			dataType: 'html',
			success: function(response) {

				$('.servers-block').append(response);

				setTimeout(function() {
					var delay = 0;
					$('.serv-block').each(function(i, el) {
						var $this = $(this);
						$(el).find('.scale').css('width',$(el).attr('data-online')+'%');

						setInterval(function(){
							$this.addClass('animated swing');

							setTimeout(function(){
								$this.removeClass('animated swing');
							}, 1000);
						}, 3000 + delay);

						delay += 2000;
					});
				}, 50);
			}
		});
	});

})(jQuery);



function buildAjaxRequest(el, evt) {
	evt.preventDefault();

	var btn = $(el).find('[type=submit]');

	$.ajax({
		url: el.getAttribute('action'),
		type: 'POST',
		data: $(el).serializeArray(),
		dataType: 'text',
		beforeSend: function() {
			if (btn.length) btn.attr('disabled', true);
		},
		success: function(response) {
			if (!response) response = 'Ошибка при выполнении запроса';

			$.fancybox.open({
				type: 'html',
				src: response
			});
		},
		error: function(response) {
			$.fancybox.open({
				type: 'html',
				src: 'Ошибка при выполнении запроса'
			});
		},
		complete: function() {
			if (btn.length) btn.removeAttr('disabled');
		}
	});

	return false;
}

function randomString(element) {
	element.previousSibling.value = (Math.random().toString(36).slice(2) +  Math.random().toString(36).slice(2)).substr(0, 10).toUpperCase();
}