/*
Description:
	This script contains the functions to load the winning wheel image and do the rotation of it.
	By Douglas McKechie @ www.dougtesting.net
*/
var canvasId         = "myDrawingCanvas";
var wheelImageName   = "images/roulette/prizewheel.png";
var spinButtonImgOn  = "images/roulette/spin_on.png";
var spinButtonImgOff = "images/roulette/spin_off.png";
var theSpeed         = 20;
var pointerAngle     = 0;
var doPrizeDetection = true;
var spinMode         = "determinedAngle";
var determinedGetUrl = "wheelAjax/";
var surface;
var wheel;
var angle 		 = 0;
var targetAngle  = 0;
var currentAngle = 0;
var power        = 0;
var randomLastThreshold = 150;
var spinTimer;
var wheelState = 'reset';
var toAngle;
var prizes = new Array();
prizes[0] = {"name" : "Приз #1", "startAngle" : 0,   "endAngle" : 39};
prizes[1] = {"name" : "Приз #2", "startAngle" : 40,  "endAngle" : 79};
prizes[2] = {"name" : "Приз #3", "startAngle" : 80,  "endAngle" : 119};
prizes[3] = {"name" : "Приз #4", "startAngle" : 120, "endAngle" : 159};
prizes[4] = {"name" : "Приз #5", "startAngle" : 160, "endAngle" : 199};
prizes[5] = {"name" : "Приз #6", "startAngle" : 200, "endAngle" : 239};
prizes[6] = {"name" : "Приз #7", "startAngle" : 240, "endAngle" : 279};
prizes[7] = {"name" : "Приз #8", "startAngle" : 280, "endAngle" : 319};
prizes[8] = {"name" : "Банкрот", "startAngle" : 320, "endAngle" : 360};
function begin()
{
	surface = document.getElementById(canvasId);
	if (surface.getContext) 
	{
		wheel = new Image();
		wheel.onload = initialDraw;
		wheel.src = wheelImageName;
	}
}
function initialDraw(e)
{
	var surfaceContext = surface.getContext('2d');
	surfaceContext.drawImage(wheel, 0, 0);
}
function startSpin(determinedValue)
{
	var stopAngle = undefined;
	if (spinMode == "random")
	{
		stopAngle = Math.floor(Math.random() * 360);
	}
	else if (spinMode == "determinedAngle")
	{
		if (typeof(determinedValue) === 'undefined')
		{
			if (determinedGetUrl)
			{
                if(wheelState == 'reset'){				
					ajax.send('GET', determinedGetUrl, { power: power }, null, function(result) {
						try {
							result = JSON.parse(result);
							if (result.status == '1') {
								alert("Рулетка отключена");
							} else if(result.status == '2'){
								alert("Неверные параметры, попробуйте опять");
							} else if(result.status == '3'){
								alert("Недостаточно монеток");
							} else if(result.status == '4'){
								toAngle = 332;
								startSpin(toAngle);
								alert("Вы ничего не выйграли");
							} else if(result.status == '5') {
								toAngle = result.angle;
								startSpin(toAngle);
							} else if(result.status == '6') {
								alert("Вы не выбрали персонажа");
							} else if(result.status == '7') {
								toAngle = result.angle;
								startSpin(toAngle);
								alert("Сервер не смог отправить вам приз, напишите администратору");
							} else {
								alert("Сервер не ответил вовремя, попробуйте позже");
							}
							console.log(result);
						} catch(e) {
							console.log(e.message);
						}
						console.log(result);
					});
                }
			}
		}
		else
		{
			stopAngle = determinedValue;
		}
	}
	else if (spinMode == "determinedPrize")
	{	
		if (typeof(determinedValue) === 'undefined')
		{
			if (determinedGetUrl)
			{
				xhr.open('GET', determinedGetUrl, true);
				xhr.send('');
			}
		}
		else
		{
			stopAngle = Math.floor(prizes[determinedValue]['startAngle'] + (Math.random() * (prizes[determinedValue]['endAngle'] - prizes[determinedValue]['startAngle'])));
		}
	}
	if ((typeof(stopAngle) !== 'undefined') && (wheelState == 'reset') && (power))
	{
		stopAngle = (360 + pointerAngle) - stopAngle;
		targetAngle = (360 * (power * 6) + stopAngle);
		randomLastThreshold = Math.floor(90 + (Math.random() * 90));
		document.getElementById('spin_button').className = "button blue-gradient";
		wheelState = 'spinning';
		doSpin();
	}
}
function ajaxCallback()
{
	if (xhr.readyState < 4)
	{
		return;
	}
	if (xhr.status !== 200)
	{
		return;
	}
	startSpin(toAngle);
}
function doSpin()
{	
	var surfaceContext = surface.getContext('2d');
	surfaceContext.save();
	surfaceContext.translate(wheel.width * 0.5, wheel.height * 0.5);
	surfaceContext.rotate(DegToRad(currentAngle));
	surfaceContext.translate(-wheel.width * 0.5, -wheel.height * 0.5);
	surfaceContext.drawImage(wheel, 0, 0);
	surfaceContext.restore();
	currentAngle += angle;
	if (currentAngle < targetAngle)
	{
		var angleRemaining = (targetAngle - currentAngle);
		if (angleRemaining > 6480)
			angle = 55;
		else if (angleRemaining > 5000)
			angle = 45;
		else if (angleRemaining > 4000)
			angle = 30;
		else if (angleRemaining > 2500)
			angle = 25;
		else if (angleRemaining > 1800)
			angle = 15;
		else if (angleRemaining > 900)
			angle = 11.25;
		else if (angleRemaining > 400)
			angle = 7.5;
		else if (angleRemaining > 220)
			angle = 3.80;
		else if (angleRemaining > randomLastThreshold)
			angle = 1.90;
		else
			angle = 1;

		spinTimer = setTimeout("doSpin()", theSpeed);
	}
	else
	{
		wheelState = 'stopped';
		if ((doPrizeDetection) && (prizes))
		{
			var times360 = Math.floor(currentAngle / 360);
			var rawAngle = (currentAngle - (360 * times360));
			var relativeAngle =  Math.floor(pointerAngle - rawAngle);
			if (relativeAngle < 0)
				relativeAngle = 360 - Math.abs(relativeAngle);
			for (x = 0; x < (prizes.length); x ++)
			{
				if ((relativeAngle >= prizes[x]['startAngle']) && (relativeAngle <= prizes[x]['endAngle']))
				{
                    if(x!=9){
                        alert("Вы выйграли " + prizes[x]['name'] + "!");
                    } else {
                        alert("Вы ничего не выйграли");
                    }

					break;
				}
			}
		}
	}
}
function DegToRad(d)
{
	return d * 0.0174532925199432957;
}
function powerSelected(powerLevel)
{
	if (wheelState == 'reset')
	{
		document.getElementById('pw1').className = "button grey-gradient";
		document.getElementById('pw2').className = "button grey-gradient";
		document.getElementById('pw3').className = "button grey-gradient";
		if (powerLevel >= 1)
			document.getElementById('pw1').className = "button green-gradient";
		if (powerLevel >= 2)
			document.getElementById('pw2').className = "button gold-gradient";
		if (powerLevel >= 3)
			document.getElementById('pw3').className = "button red-gradient";
		power = powerLevel;
		document.getElementById('spin_button').className = "button blue-gradient";
	}
}
function resetWheel()
{
	clearTimeout(spinTimer);
	angle 		 = 0;
	targetAngle  = 0;
	currentAngle = 0;
	power        = 0;
	document.getElementById('pw1').className = "button grey-gradient";
	document.getElementById('pw2').className = "button grey-gradient";
	document.getElementById('pw3').className = "button grey-gradient";
	document.getElementById('spin_button').className = "button blue-gradient";
	wheelState = 'reset';
	initialDraw();
}