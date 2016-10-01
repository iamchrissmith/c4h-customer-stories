(function( $ ) {
	'use strict';

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
    var showCustomerStory = function() {
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


                // console.log(storyHash);
                cbArgs.href = storyHash;
                // console.log("CB args", cbArgs);
                $.colorbox( cbArgs );
            }

        }
    };

	$( window ).load(function() {
	    cbArgs.onComplete = function(){
	        var hash = $(this).attr('href');
            if ( hash ) {
                history.replaceState(undefined,undefined, hash);
            }
        };
        $(".cs-map-thumbnail").colorbox( cbArgs );
        $('.cs-list-item .cboxClose').on('click', function() {
            history.replaceState(undefined,undefined, " ");
            $.colorbox.close();
        });

        showCustomerStory();



    });

})( jQuery );
