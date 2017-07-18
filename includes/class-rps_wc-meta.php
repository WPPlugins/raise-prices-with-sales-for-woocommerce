<?php

/**
 * The Meta Class for handling meta data
 */

class RPS_WC_Meta {
	
	/**
	 * Getting the Meta for RPS Sales
	 * @param  int $post_id 
	 * @return mixed          
	 */
	public static function get( $post_id ) {	
		return get_post_meta( $post_id, '_rps_sales', true );
	}

	/**
	 * Getting the Meta for RPS Sales
	 * @param  int $post_id 
	 * @param  mixes $value
	 * @return mixed          
	 */
	public static function update( $post_id, $value ) {	
		return update_post_meta( $post_id, '_rps_sales', $value );
	}

}