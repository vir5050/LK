$(document).ready(function(){
	var qqq = $('.content-select-stop').attr('data-stop');
	if (qqq >= '0') {
		return false;
	} else {
		$('select').each(function(){
			$(this).wrap('<div class="select"></div>');
		});
	}

	$('.select').each(function(){
		var sel = $(this).find('option:selected').length;
		if (sel >= 1) {
			var val = $(this).find('option:selected').text();
		} else {
			var val = $(this).find('option:first').text();
		}
		
		$(this).append('<div class="select-active">'+val+'</div>');
		$(this).append('<div class="select-sub"></div>');
	});

	$('select option').each(function(){
		var text = $(this).text();
		var val = $(this).attr('value');
		if (!val) {$(this).parent().parent().find('.select-sub').append('<a>'+text+'</a>');}
		else {$(this).parent().parent().find('.select-sub').append('<a data-value="'+val+'">'+text+'</a>');}
	});

	$('.select-sub a').each(function(){
		var ln = $(this).html().length;
		if (ln == 0) {
			$(this).remove();
		}
	})

	$('body').on('click', '.select-sub a', function(){
		var html = $(this).html();
		var htmlVal = $(this).attr('data-value');
		var dat = $(this).attr('data-value');
		if (!dat) {
			$(this).parent().parent().find('select').val(html);
		} else {
			$(this).parent().parent().find('select').val(htmlVal);
		}
		$(this).parent().parent().find('.select-active').html(html);
		$('.select-sub').hide();
	});

	$('body').on('click', '.select .select-active', function(){
		$(this).parent().find('.select-sub').slideToggle(200);
	});
});