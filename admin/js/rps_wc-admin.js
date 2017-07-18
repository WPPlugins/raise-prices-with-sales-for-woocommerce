(function( $ ) {
	'use strict';

	 $(function(){
	 	// Caching elements
	 	var rps_table 	= $( "#rps_table" ),
	 		rps_table_body = rps_table.find('tbody'),
	 		rps_add_row = $( "#rps_add_row" ),
	 		template	= $( "#rps_table_row_template"),
	 		limit 		= rps_wc.limit;

	 	// Adding a new row
	 	rps_add_row.on( 'click', function(){

	 		var length = rps_table_body.children('tr').length;

	 		var _template = wp.template( 'rps_table_row_template' );
	 		var html = _template({ length: length });

	 	 	rps_table_body.append( html );
	 	 	length += 1;
 
	 	 	/** Appended is +1 */ 
	 	 	if( limit > 0 && length >= limit ) {
	 	 		rps_add_row.attr( 'disabled', 'disabled' );
	 	 		$("#rps_buy_pro").removeClass('hidden');
	 	 	}

	 	})

	 	$(document).on( 'click', '.rps-delete', function(){
	 		$(this).parents('tr').remove();
	 		rps_refresh_table_body();
	 	});

	 	/**
	 	 * Refreshed table body
	 	 * @return void 
	 	 */
	 	function rps_refresh_table_body() {

	 		var count = 0;
 
	 		rps_table_body.find('tr').each(function(){
	 			var row = $(this);
	 			row.find('.rps-sales-column input').attr( 'name', 'rps_wc[' + count + '][sales]' );
	 			row.find('.rps-price-column input').attr( 'name', 'rps_wc[' + count + '][price]' );
	 			count++;
	 		});

	 		if( limit > 0 && count < limit ) {
	 			rps_add_row.attr( 'disabled', false );
	 			$("#rps_buy_pro").addClass('hidden');
	 		}

	 	}

	 });

})( jQuery );
