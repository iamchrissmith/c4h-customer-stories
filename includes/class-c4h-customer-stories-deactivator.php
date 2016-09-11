<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://teamzen.io
 * @since      1.0.0
 *
 * @package    C4h_Customer_Stories
 * @subpackage C4h_Customer_Stories/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    C4h_Customer_Stories
 * @subpackage C4h_Customer_Stories/includes
 * @author     Zenio <support@teamzen.io>
 */
class C4h_Customer_Stories_Deactivator {

	/**
	 * Run our deactivation actions.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// Our post type will be automatically removed, so no need to unregister it

		// Clear the permalinks to remove our post type's rules
		flush_rewrite_rules();
	}

}