<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/thierrycharriot
 * @since      1.0.0
 *
 * @package    Plugin_Portal
 * @subpackage Plugin_Portal/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Plugin_Portal
 * @subpackage Plugin_Portal/includes
 * @author     Thierry Charriot <thierrycharriot@chez.lui>
 */
class Plugin_Portal_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		global $wpdb;

		/**
		 * @author Thierry Charriot@chez.lui
		 * Create page on plugin deactivate
		 */

		$get_data = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT ID from " . $wpdb->prefix . "posts WHERE post_name = %s", 'links'
			)
		);
		#echo $wpdb->last_guery(); die();
		$page_id = $get_data->ID;
		if ( $page_id > 0 ) {
			# Delete post wp function
			wp_delete_post( $page_id, true );
		}

	}

}
