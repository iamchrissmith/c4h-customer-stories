(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	var cbArgs = {
        inline:true,
        width:"75%",
        opacity:"0",
        closeButton:false,
        className: "cs-colorbox",
        scrolling:false,
        maxWidth:'745px'
    };

    // Show customer story colorbox when hashtag anchor is added to url manually in browser
    function showCustomerStory() {
        // Get hash to identify which customer story
        var storyHash = window.location.hash;

        var path = window.location.pathname;
        var verifyDirectory = path.lastIndexOf( 'customer-stories' );
        // Check to see if we are in the right directory and if we have a hash entered by user
        if ( verifyDirectory !== -1 && storyHash !== '' ) {
            // Check to see if it is a valid customer story by checking if customer storyexists
            if ( $( storyHash ).hasClass( 'cs-list-item' ) ) {
                //todo: if mobile scroll to story,

                // else run colorbox
                $("#customer-stories").get(0).scrollIntoView();
                // document.getElementById('elementID').scrollIntoView()

                // If so, show the colorbox
                cbArgs.href = storyHash;
                console.log("CB args", cbArgs);
                $.colorbox( cbArgs );
            }

        }
    }

	$( window ).load(function() {
	    cbArgs.onComplete = function(){
	        var hash = $(this).attr('href');
            if ( hash ) {
                window.location.hash = hash;
            }


        };
        $(".cs-map-thumbnail").colorbox( cbArgs );
        $('.cs-list-item .cboxClose').on('click', function() {
            window.location.hash = '';
            $.colorbox.close();
        });

        showCustomerStory();



    });

})( jQuery );
