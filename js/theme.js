(function($) {

	//* Make sure JS is enabled
	document.documentElement.className = "js";

	$(document).ready( function() {

		//* Run 0.25 seconds after document ready for any instances viewable on load
		setTimeout( function() {
			animateObject();
		}, 250);

	});

	$(window).scroll( function() {

		//* Run on scroll
		animateObject();

	});

	function animateObject() {

		//* Define your object via class
		var object = $( '.fadeup-effect' );

		//* Loop through each object in the array
		$.each( object, function() {

			var windowHeight = $(window).height(),
				offset 		 = $(this).offset().top,
				top			 = offset - $(document).scrollTop(),
				percent 	 = Math.floor( top / windowHeight * 100 );


			if ( percent < 80 ) {

				$(this).addClass( 'fadeInUp' );

			}
		});
	}

})(jQuery);
jQuery(function( $ ){
    'use strict'

    var addHeaderScrollClass,
        $scrollPos,
	    $siteHeader = $('header.site-header');

    addHeaderScrollClass = function () {
        $scrollPos = $(window).scrollTop();

        if ( $scrollPos > 40 ) {
            $siteHeader.addClass('scroll');
        }
        // This conditional is required to fix jittery header in Chrome.
        else if ( $scrollPos < 10 ) {
            $siteHeader.removeClass('scroll');
        }
    };

    $(window).ready(addHeaderScrollClass);
    $(window).on('scroll', addHeaderScrollClass);

    $(document).ready(function(){
        $('a[href^="#"]').on('click',function (e) {
            e.preventDefault();

            var target = this.hash;
            var $target = $(target);

            $('html, body').stop().animate({
                'scrollTop': $target.offset().top - 70
            }, 900, 'swing');
        });
    });

	$( '.nav-primary .genesis-nav-menu, .nav-secondary .genesis-nav-menu' ).addClass( 'responsive-menu' ).before('<div class="responsive-menu-icon"></div>');

	$( '.responsive-menu-icon' ).click(function(){
		$(this).next( '.nav-primary .genesis-nav-menu,  .nav-secondary .genesis-nav-menu' ).slideToggle();
	});

	$( window ).resize(function(){
		if ( window.innerWidth > 800 ) {
			$( '.nav-primary .genesis-nav-menu,  .nav-secondary .genesis-nav-menu, nav .sub-menu' ).removeAttr( 'style' );
			$( '.responsive-menu > .menu-item' ).removeClass( 'menu-open' );
		}
	});

	$( '.responsive-menu > .menu-item' ).click(function(event){
		if ( event.target !== this )
		return;
			$(this).find( '.sub-menu:first' ).slideToggle(function() {
			$(this).parent().toggleClass( 'menu-open' );
		});
	});
});
