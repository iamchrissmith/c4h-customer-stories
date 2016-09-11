<?php

/**
 * Fired during plugin activation
 *
 * @link       https://teamzen.io
 * @since      1.0.0
 *
 * @package    C4h_Customer_Stories
 * @subpackage C4h_Customer_Stories/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    C4h_Customer_Stories
 * @subpackage C4h_Customer_Stories/includes
 * @author     Zenio <support@teamzen.io>
 */
class C4h_Customer_Stories_Activator {

	/**
	 * Run our activation actions.
	 *
	 * Register our post type and clear the caches to avoid 404.
	 *
	 * @since    1.0.0
	 */
	public static function activate( $plugin_name, $version ) {
		// Trigger our function that registers the custom post type
		$plugin_admin = new C4h_Customer_Stories_Admin( $plugin_name, $version );
		$plugin_admin->register_cs_post_type();

		// Clear the permalinks after the post type has been registered
		flush_rewrite_rules();
	}


}