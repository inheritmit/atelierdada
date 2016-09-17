$(document).ready(function() {

$('.smallNav').click(function() {		 
  $('.menuBox').toggleClass('showMenu');
  $(this).toggleClass('closeNav');
  $('.searchBoxMain').toggle();
   $('.blackBg').toggle();
});

$('video').parent('div').addClass('videoPic');

$('.menuBox a-, .start, .subMenu a, .logo, .minHeight, .wrapper, .footer, .innerBanner, .map, .blackBg').click(function() {		 
  $('.menuBox').removeClass('showMenu');
  $('.smallNav').removeClass('closeNav');
  $('.searchBoxMain').show();
  $('.blackBg').hide();
});

$('.toggleSubNav').click(function() {
    $(this).parents('li').children('.subMenu').slideToggle('fast');
	$(this).children('i.fa-caret-down').toggleClass('arowHide');
	$(this).children('i.fa-caret-up').toggleClass('arowHide');
    return false;
});


$('.backToTop, .homeTop').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
 });
 
 $('.searchBoxMain a').click(function () {
    $('.searchBoxMain').addClass('active');
	}).blur(function () {
    $('.searchBoxMain').removeClass('active');
	});	
	
	$('.searchBoxMain input').focus(function () {
    $('.searchBoxMain').addClass('active');
	}).blur(function () {
    $('.searchBoxMain').removeClass('active');
	});	
 	
	
});


(function() {
	"use strict";
$(document).scroll(function() {
	if ($(document).scrollTop() >= $('.wrapper').offset().top - $(window).height()  + 600) {
	  $('.smallNav').addClass('menuYellow');
	  $('.logo').addClass('logoNone');
	} else {
	  $('.smallNav').removeClass('menuYellow');
	  $('.logo').removeClass('logoNone');
	}
	});
})(jQuery);







       
