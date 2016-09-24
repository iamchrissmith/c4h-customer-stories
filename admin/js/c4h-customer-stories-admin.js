(function( $ ) {
	'use strict';

    var getNeighbors = function ( location ) {
        var neighbors = {};

        if ( location - 22 > 0 ){
            neighbors.above = location-22;
        }

        if ( location + 22 > 0 ){
            neighbors.below = location+22;
        }

        if ( (location)%22 !== 0 ){
            neighbors.right = location+1;
        }

        if ( (location - 1)%22 !== 0 ){
            neighbors.left = location-1;
        }

        console.log(neighbors);
        return neighbors;
    };

	var csResetInactive = function ( neighbors ) {
        for ( var direction in neighbors ) {
            //todo: only remove if no other neighbor-causing element
            $('#cs-map-item-'+neighbors[direction]).removeClass('cs-map-item__inactive');
        }
    };
    /**
     * set top, bottom, left and right to inactive if they exist
     *
     * @param   location    integer location of current cell
     */
	var csSetInactive = function( neighbors ) {
	    for ( var direction in neighbors ) {
            $('#cs-map-item-'+neighbors[direction]).addClass('cs-map-item__inactive');
            //todo: add data-element to track causing grid item
        }

    };

    $(function() {

        $('.cs-map-item').on('click', function(){

            if ( $(this).hasClass('cs-map-item__occupied') || $(this).hasClass('cs-map-item__inactive') ) {
                return;
            }

            var new_location = parseInt( $(this).attr('data-cs_location') ),
                grid_number = $('#_c4h_cs_grid_number'),
                current_location = parseInt( grid_number.val() );

            console.log("Location: "+new_location, "current_location: "+current_location);

            if ( '' !== current_location ) {
                $('#cs-map-item-'+current_location).removeClass('cs-map-item__occupied');
                var old_neighbors = getNeighbors( current_location );
                csResetInactive( old_neighbors );
            }

            var neighbors = getNeighbors( new_location );
            csResetInactive( neighbors );
            csSetInactive( neighbors );

            grid_number.val(new_location);
            $('#cs-map-item-'+new_location).addClass('cs-map-item__occupied').addClass('cs-map-item__current');

        });

        // $('.cs-location select').on('change', function() {
        //     var row,
        //         column,
        //         grid_number = $('#_c4h_cs_grid_number'),
        //         location = grid_number.val();
        //
        //     if ( $(this).parent().parent().hasClass('cs-location-row') ) {
        //
        //         row = $(this).val();
        //         column = $('.cs-location-column select').val();
        //
        //     } else if ( $(this).parent().parent().hasClass('cs-location-column') ) {
        //
        //         column = $(this).val();
        //         row = $('.cs-location-row select').val();
        //
        //     }
        //
        //     /** todo: add a test where when there is a change to the Row or Column select, we check the invalid combinations (REST API call?) and remove/reset as necessary
        //      * todo: As a intermediate step, we could show an error message is the new __occupied class is applied to a grid item that is already __inactive or __occupied.
        //      */
        //
        //
        //     if ( row !== ''  && column !== '' ) {
        //
        //         if ( '' !== location ) {
        //             $('#cs-map-item-'+location).removeClass('cs-map-item__occupied');
        //             var neighbors = getNeighbors( parseInt( location ) );
        //             csResetInactive( neighbors );
        //         }
        //
        //         row = parseInt(row);
        //         column = parseInt(column);
        //         location = ( (row-1) * 22 + (column) );
        //
        //         var neighbors = getNeighbors( location );
        //         csResetInactive( neighbors );
        //         csSetInactive( neighbors );
        //
        //         grid_number.val(location);
        //         $('#cs-map-item-'+location).addClass('cs-map-item__occupied');
        //
        //
        //
        //         console.log("Row: "+ row +" Column: "+ column);
        //         console.log('Sum: '+ location );
        //     }
        //
        // });
    });

})( jQuery );
