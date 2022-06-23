<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/thierrycharriot
 * @since      1.0.0
 *
 * @package    Plugin_Portal
 * @subpackage Plugin_Portal/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Plugin_Portal
 * @subpackage Plugin_Portal/public
 * @author     Thierry Charriot <thierrycharriot@chez.lui>
 */
class Plugin_Portal_Public {

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

		# https://developer.wordpress.org/reference/hooks/template_include/
		# apply_filters( 'template_include', string $template )
		# Filters the path of the current template before including it.
		#add_filter( 'template_include', array( $this, 'links_list' ), 3 );

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
		 * defined in Plugin_Portal_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Portal_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-portal-public.css', array(), $this->version, 'all' );

        /**
         * Include bootstrap css only for plugin public page
         *
         * @since    0.0.1
         * @author   Thierry_Charriot@chez.lui
         */
		$portal_pages = array( 'links' );
        $page = isset( $_REQUEST['page'] ) ? ( $_REQUEST['page'] ) : '';
        if ( in_array( $page, $portal_pages ) ) {
            wp_enqueue_style( 'plugin-portal-css', PLUGIN_PORTAL_URL . 'node_modules/bootstrap/dist/css/bootstrap.min.css', array(), $this->version, 'all' );
        }

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
		 * defined in Plugin_Portal_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Portal_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-portal-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * @author Thierry Charriot@chez.lui
	 * Load template plugin-portal-public-links-list.php
	 */
	public function plugin_portal_public_template_links_list() {

		global $post;

		if( $post->post_name == 'links' ) {
			//echo '<h1>I am the links page</h1>'; die(); // Debug OK
			$page_template = PLUGIN_PORTAL_PATH . 'public/partials/plugin-portal-public-links-list.php';
		}

		return $page_template;

	}

}
