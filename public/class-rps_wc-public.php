<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       ibenic.com
 * @since      1.0.0
 *
 * @package    Rps_wc
 * @subpackage Rps_wc/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rps_wc
 * @subpackage Rps_wc/public
 * @author     Igor Benić <i.benic@hotmail.com>
 */
class Rps_wc_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rps_wc-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rps_wc-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Update Product Prices
	 * @param  int $order_id 
	 * @return void           
	 */
	public function update_product_prices( $order_id ) {

		$order = wc_get_order( $order_id );

		if ( ! $order || $order->get_data_store()->get_recorded_sales( $order ) ) {
			return;
		}


		if ( sizeof( $order->get_items() ) > 0 ) {
			foreach ( $order->get_items() as $item ) {
				if ( $product_id = $item->get_product_id() ) {

					 $product = wc_get_product( $product_id );
					 $total_sales = $product->get_total_sales();
					 $rps_prices = RPS_WC_Meta::get( $product_id );
					 
					 if( $rps_prices && is_array( $rps_prices ) ) {

					 	// Just check if the current number of sales is somewhere.
					 	if( isset( $rps_prices[ $total_sales ] ) ) {
					 		$product->set_regular_price( $rps_prices[ $total_sales ] );
					 		$product->save();
					 	}

					 }
				}
			}
		}
	}

	public function show_product_next_price() {
		global $product;

		$product_id = $product->get_id();
		$rps_prices = RPS_WC_Meta::get( $product_id );
		 
		if( $rps_prices && is_array( $rps_prices ) ) {

			$total_sales = $product->get_total_sales();	
			foreach ( $rps_prices as $sales => $price) {
				if( $sales <= $total_sales ) {
					continue;
				}

				$to_next_sale = (int) $sales - $total_sales;
				if( $to_next_sale ) {
					echo '<p><em>' . sprintf( __( 'The price will increase to %s after %d sales' ), wc_price( $price ), $to_next_sale ) . '</em></p>';
				}
				break;
			}		

		}
	}

}
