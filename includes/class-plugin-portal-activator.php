<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/thierrycharriot
 * @since      1.0.0
 *
 * @package    Plugin_Portal
 * @subpackage Plugin_Portal/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Plugin_Portal
 * @subpackage Plugin_Portal/includes
 * @author     Thierry Charriot <thierrycharriot@chez.lui>
 */
class Plugin_Portal_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		global $wpdb;

		/**
		 * @author Thierry Charriot@chez.lui
		 * Create page on plugin activate
		 */
		$get_data = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * from wp_posts WHERE post_name = %s", 'links'
			)
		);
		if( !empty( $get_data ) ) {
			# Already we have data with this post name
			//var_dump( $get_data ); 
		} else {
			$post_arr_data = array(
				'post_title' 	=> 'Links',
				'post_name' 	=> 'links',
				'post_status'	=> 'publish',
				'post_author'	=> 1,
				'post_content'	=> 'Simple Page Content of Links',
				'post_type'		=> 'page'
			);
			/**
			 * https://developer.wordpress.org/reference/functions/wp_insert_post/
			 * wp_insert_post( array $postarr, bool $wp_error = false, bool $fire_after_hooks = true )
			 * Insert or update a post.
			 */
			wp_insert_post( $post_arr_data );
		}
	}

}
