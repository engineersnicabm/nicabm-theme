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

	if( $( document ).scrollTop() > 0 ){
		$( '.site-header' ).addClass( 'light' );
	}

	// Add opacity class to site header
	$( document ).on('scroll', function(){

		if ( $( document ).scrollTop() > 0 ){
			$( '.site-header' ).addClass( 'light' );

		} else {
			$( '.site-header' ).removeClass( 'light' );
		}

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
