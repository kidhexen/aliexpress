jQuery(function($){

	var d = {
			promotionfrom 	: 0,
			promotionto 	: 1000,
			creditScoreFrom : 5,
			creditScoreTo 	: 1000
		},
		c = d;

	$.each( d, function(name, value) {
		if( $('[name="'+name+'"]').length > 0 &&
			$('[name="'+name+'"]').val() != '' )
			c[name] = $('[name="'+name+'"]').val();
		else
			c[name] = value;

		$('[name="'+name+'"]' ).val( c[name] );
	});
	
	$( "#slider-promotion" ).slider({
		range: true,
		min: 0,
		step: 100,
		max: 10000,
		values: [c.promotionfrom, c.promotionto ],
		slide: function( event, ui ) {
			$( '[name="promotionfrom"]' ).val( ui.values[ 0 ] );
			$( '[name="promotionto"]' ).val( ui.values[ 1 ] );
		}
	});
	
	$( "#slider-credit" ).slider({
		range: true,
		min: 0,
		step: 100,
		max: 10000,
		values: [c.creditScoreFrom, c.creditScoreTo ],
		slide: function( event, ui ) {
			$( '[name="creditScoreFrom"]' ).val( ui.values[ 0 ] );
			$( '[name="creditScoreTo"]' ).val( ui.values[ 1 ] );
		}
	});
});