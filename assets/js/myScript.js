var prevScroll = window.pageYOffset;
$(window).scroll(function(){
	var currentScroll = window.pageYOffset;
	if(prevScroll > currentScroll){
		$('#header').removeClass('show')
	} else {
		$('#header').addClass('show')
		$('#header-menu').addClass('hidden')	
	}
	prevScroll = currentScroll;
})
$('#toggle-menu').click(function(){
	$('#header-menu').toggleClass('hidden')
})
setInterval(function(){
	if($(window).width() < 991){
		$('.dropdown-content').removeAttr('id')
		$('.dropdown-content').attr('id', 'menu-dropdown-aplication-responsive')
		$('.dropdown-cover-app').removeAttr('id')
		$('.dropdown-cover-app').attr('id', 'aplications-responsive')
	} else {
		$('.dropdown-content').removeAttr('id')
		$('.dropdown-content').attr('id', 'menu-dropdown-aplication')
		$('.dropdown-cover-app').removeAttr('id')
		$('.dropdown-cover-app').attr('id', 'aplications')
	}
}, 100)
$(document).on('click', '#aplications-responsive', function(){
	$('#menu-dropdown-aplication-responsive').toggleClass('show-dropdown')
	$('#menu-dropdown-aplication-responsive').toggleClass('hide-dropdown')
})
AOS.init({
    // Global settings:
    disable: false,
    startEvent: 'DOMContentLoaded',
    initClassName: 'aos-init', 
    animatedClassName: 'aos-animate', 
    useClassNames: false, 
    disableMutationObserver: false, 
    debounceDelay: 50, 
    throttleDelay: 99, 
    
    offset: 120, 
    delay: 0, 
    duration: 750, 
    easing: 'ease', 
    once: false, 
    mirror: false, 
    anchorPlacement: 'top-bottom',
});