(function($){
	$(document).ready(function() {
		$('#tabvanilla > ul').tabs({
			fx: {
				height: 'toggle',
				opacity: 'toggle'
			},
			select: function(event, ui){
				$('#tabtitle').text(ui.tab.dataset.title);
	  		}
	  	});

		$('#featuredvid > ul').tabs();
	});
})(jQuery);