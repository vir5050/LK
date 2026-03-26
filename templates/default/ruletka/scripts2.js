jQuery(document).ready(function($){
	
	$('.easywheel').easyWheel({
		items: [
			{
				id      : 'a',
				name    : '20% OFF',
				message : 'You win 20% off',
				color   : '#3498db',
				win     : true
			},{
				id      : 'b',
				name    : 'No luck',
				message : 'You have No luck today',
				color   : '#ffc107',
				win     : false
			},{
				id      : 'c',
				name    : '30% OFF',
				message : 'You win 30% off',
				color   : '#f44336',
				win     : true
			},{
				id      : 'd',
				name    : 'Lose',
				message : 'You Lose :(',
				color   : '#3498db',
				win     : false
			},{
				id      : 'e',
				name    : '40% OFF',
				message : 'You win 40% off',
				color   : '#ffc107',
				win     : true
			},{
				id      : 'f',
				name    : 'Nothing',
				message : 'You get Nothing :(',
				color   : '#f44336',
				win     : false
			}
		],
		random: true,
		button : '.spin-to-win',
		onStart: function(results, spinCount, now) {
			$('.spinner-message').css('color','#90A4AE');
			$('.spinner-message').html('Spinning...');
		},
		onComplete : function(results,count,now){
			
			$('.spinner-message').css('color',results.color).html(results.message);
			console.log(results,count,now);
		}
	});
});