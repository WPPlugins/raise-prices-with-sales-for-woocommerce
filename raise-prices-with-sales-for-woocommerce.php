<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              ibenic.com
 * @since             1.0.0
 * @package           Rps_wc
 *
 * @wordpress-plugin
 * Plugin Name:       Raise Prices with Sales for WooCommerce
 * Description:       The plugin allows you to set sales points that will increase the product price after each sale
 * Version:           1.0.0
 * Author:            Igor Benić
 * Author URI:        http://ibenic.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rps_wc
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rps_wc-activator.php
 */
function activate_rps_wc() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rps_wc-activator.php';
	Rps_wc_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rps_wc-deactivator.php
 */
function deactivate_rps_wc() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rps_wc-deactivator.php';
	Rps_wc_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_rps_wc' );
register_deactivation_hook( __FILE__, 'deactivate_rps_wc' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rps_wc.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_rps_wc() {
	if( ! class_exists( 'WooCommerce' ) ) { 
		return;
	}
	 
	$wc_version = WC()->version;

	if( version_compare( $wc_version, '3.0', '<' ) ) { 
		return;
	}

	$plugin = new Rps_wc();
	$plugin->run();

}
add_action( 'plugins_loaded', 'run_rps_wc' );;

