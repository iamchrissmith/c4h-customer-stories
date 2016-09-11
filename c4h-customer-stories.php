<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://teamzen.io
 * @since             1.0.0
 * @package           C4h_Customer_Stories
 *
 * @wordpress-plugin
 * Plugin Name:       C4H Customer Stories
 * Plugin URI:        http://connectforhealthco.com
 * Description:       Maps testimonials in the State of Colorado
 * Version:           1.0.0
 * Author:            Zenio
 * Author URI:        https://teamzen.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       c4h-customer-stories
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-c4h-customer-stories-activator.php
 */
function activate_c4h_customer_stories() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-c4h-customer-stories-activator.php';
	C4h_Customer_Stories_Activator::activate( 'c4h-customer-stories', '1.0.0');
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-c4h-customer-stories-deactivator.php
 */
function deactivate_c4h_customer_stories() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-c4h-customer-stories-deactivator.php';
	C4h_Customer_Stories_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_c4h_customer_stories' );
register_deactivation_hook( __FILE__, 'deactivate_c4h_customer_stories' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-c4h-customer-stories.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_c4h_customer_stories() {

	$plugin = new C4h_Customer_Stories();
	$plugin->run();

}
run_c4h_customer_stories();