// ALL
$(document).ready(function(){
    $('.nav ul li a, .content-page-list a').wrapInner('<span></span>');
    $('body').append('<div class="hidden-nav"><a class="nav-close"></a></div>');
    var clone = $('.nav').find('ul').clone();
    $('.hidden-nav').append($(clone));

    var month = $('.screen-3 .news .date div span.month').html();
    if (month == 1) {$('.screen-3 .news .date div span.month').html('янв')}
    if (month == 2) {$('.screen-3 .news .date div span.month').html('фев')}
    if (month == 3) {$('.screen-3 .news .date div span.month').html('мар')}
    if (month == 4) {$('.screen-3 .news .date div span.month').html('апр')}
    if (month == 5) {$('.screen-3 .news .date div span.month').html('мая')}
    if (month == 6) {$('.screen-3 .news .date div span.month').html('июн')}
    if (month == 7) {$('.screen-3 .news .date div span.month').html('июл')}
    if (month == 8) {$('.screen-3 .news .date div span.month').html('авг')}
    if (month == 9) {$('.screen-3 .news .date div span.month').html('сен')}
    if (month == 10) {$('.screen-3 .news .date div span.month').html('окт')}
    if (month == 11) {$('.screen-3 .news .date div span.month').html('ноя')}
    if (month == 12) {$('.screen-3 .news .date div span.month').html('дек')}

    var local = window.location.href;
    $('ul.content-page-list li a').each(function(){
        var link = $(this).attr('href');
        if (local == link) {$(this).addClass('activ')}
    });

    $('.error-block').prepend('<a class="error-close"></a>');
    var er = $('#Info').length;
    if (er >= 1) {
        $('.error-block').show();
    }
});
// CLICK
$(document).ready(function(){
    $('body').on('click', '.nav-arrow', function(){
        $('.hidden-nav').fadeIn(200);
        $('body').css('overflow', 'hidden');
    });
    $('body').on('click', '.nav-close', function(){
        $('.hidden-nav').fadeOut(200);
        $('body').css('overflow', 'auto');
    });
    $('body').on('click', '.error-close', function(){
        $('.error-block').fadeOut(200);
    });
});
// WIDTH
$(document).ready(function() {  
    $(window).resize(function(){
        if ($(window).width() < 1000) {
            $('.nav ul').hide();
            var a = $('.nav-inner').find('.nav-arrow').length;
            if (a == 0) {$('.nav-inner').append('<a class="nav-arrow"></a>');}
        } else {
            $('.nav ul').show();
            $('.nav-inner').find('.nav-arrow').remove();
            $('.hidden-nav').hide();
        }
    }); 
    $(window).resize();
});
// SCROLL
$(window).on("scroll", function() {
    if ($(window).scrollTop() > 50) $('.nav').addClass('fixed');
    else $('.nav').removeClass('fixed');
});
// CONTENT
function content() {
    $('#general').attr('data-content', '1');
}
$(document).ready(function(){
    setTimeout(function(){
        var screen = $('#general').attr('data-content');
        //$('#general').attr('data-l', screen);
        if (screen != 1) {
            $('.screen-3').find('#pager').remove();
        }
        if (screen == 1) {
            $('.screen-4').remove();
        }
    }, 100);
});
// FORM
$(document).ready(function() {
    $('#chaccpass, #chaccmail, #sexsid, #sexchar, #namesid, #charname, #changersid, #changerchar').addClass('content-page-form');
    $('#chaccpass form, #chaccmail form, #sexsid form, #sexchar form, #namesid form, #charname form, #changersid form, #changerchar form').addClass('content-page-form');
    $('#chaccpass h4, #chaccmail h4').addClass('content-page-title');
    $('.chbutton, .button, #chbutton').addClass('content-page-btn');

    var sx = $('#sexsid, #namesid').length;
    if (sx >= 1) {
        $('#sexsid, #namesid').parent().find('center h3').addClass('content-page-title');
        $('#sexsid, #namesid').parent().find('br').hide();
    }
});