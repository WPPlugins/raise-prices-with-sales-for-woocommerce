<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       ibenic.com
 * @since      1.0.0
 *
 * @package    Rps_wc
 * @subpackage Rps_wc/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rps_wc
 * @subpackage Rps_wc/admin
 * @author     Igor Benić <i.benic@hotmail.com>
 */
class Rps_wc_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Limit
	 * @var integer
	 */
	private $limit = 3;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->limit = apply_filters( 'rps_wc_sales_points_limit', 3 );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rps_wc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rps_wc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rps_wc-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {
	 	// We want our script to be loaded only on edit or new post
	 	if( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
	 		return;
	 	}

		global $post;
	 	
	 	if( ! $post ) {
	 		return;
	 	}

	 	// We want our script to be loaded only on a product type post
	 	if( 'product' != $post->post_type ) {
	 		return;
	 	}
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rps_wc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rps_wc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rps_wc-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'rps_wc', array( 'limit' => $this->limit ) );
		wp_enqueue_script(  $this->plugin_name );
	}

	/**
	 * Template for Prices
	 * @return void 
	 */
	public function wc_product_prices() {
		$limit = $this->limit;
		include_once 'partials/rps_wc-admin-prices.php';
	}

	/**
	 * Saving the Product Prices Data
	 * @param  int $post_id 
	 * @param  WP_Post $post    
	 * @return void          
	 */
	public function wc_product_save( $post_id, $post ) {

		$rps_array = array();

		if( isset( $_POST['rps_wc'] ) ) {

			$limit = $this->limit;
			$count = 0;
			foreach ( $_POST['rps_wc']as $sale_points ) {

				if( ! $sale_points['sales'] ) {
					continue;
				}

				if( $limit > 0 && $count == $limit ) {
					break;
				}

				$rps_array[ $sale_points['sales'] ] = $sale_points['price'];
				$count++;
			}

			if( $rps_array ) {
				RPS_WC_Meta::update( $post_id, $rps_array );
			}
		}
		 
	}

}
