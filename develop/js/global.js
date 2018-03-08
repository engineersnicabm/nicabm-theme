jQuery(function( $ ){
    'use strict'

    var addHeaderScrollClass,
	    $siteHeader;

    $siteHeader = $('header.site-header');

    addHeaderScrollClass = function () {
        if ($(this).scrollTop() > 20 ) {
            $siteHeader.addClass('scroll');
        }
        else {
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
