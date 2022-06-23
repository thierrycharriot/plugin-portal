<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/thierrycharriot
 * @since      1.0.0
 *
 * @package    Plugin_Portal
 * @subpackage Plugin_Portal/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Portal
 * @subpackage Plugin_Portal/admin
 * @author     Thierry Charriot <thierrycharriot@chez.lui>
 */
class Plugin_Portal_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		# https://developer.wordpress.org/reference/hooks/admin_menu/
		# do_action( 'admin_menu', string $context )
		# Fires before the administration menu loads in the admin.
		add_action( 'admin_menu', array( $this, 'links_menu' ), 3 );

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
		 * defined in Plugin_Portal_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Portal_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-portal-admin.css', array(), $this->version, 'all' );

        /**
         * Include bootstrap css only for plugin admin page
         *
         * @since    0.0.1
         * @author   Thierry_Charriot@chez.lui
         */
		$portal_pages = array( 'portal-dashboard', 'links-create', 'links-read', 'links-list' );
        $page = isset( $_REQUEST['page'] ) ? ( $_REQUEST['page'] ) : '';
        if ( in_array( $page, $portal_pages ) ) {
            wp_enqueue_style( 'plugin-portal-css', PLUGIN_PORTAL_URL . 'node_modules/bootstrap/dist/css/bootstrap.min.css', array(), $this->version, 'all' );
        }

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-portal-admin.js', array( 'jquery' ), $this->version, false );

        /**
         * Include bootstrap js only for plugin admin page
         *
         * @since    0.0.1
         * @author   Thierry_Charriot@chez.lui
         */
		$portal_pages = array( 'portal-dashboard', 'links-create', 'links-read', 'links-list' );
        $page = isset( $_REQUEST['page'] ) ? ( $_REQUEST['page'] ) : '';
        if ( in_array( $page, $portal_pages ) ) {
            wp_enqueue_style( 'plugin-portal-js', PLUGIN_PORTAL_URL . 'node_modules/bootstrap/dist/js/bootstrap.min.js', array(), $this->version, 'all' );
        }

	}

	/**
	 * Add menus in admin page
	 *
	 * @since    0.0.1
	 * @author   Thierry_Charriot@chez.lui
	 */
	public function links_menu() 
	{
		/**
		 * https://developer.wordpress.org/reference/functions/add_menu_page/
		 * add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', string $icon_url = '', int $position = null )
		 * Adds a top-level menu page.
		 * https://developer.wordpress.org/resource/dashicons/#media-interactive
		 */
		add_menu_page( 'Portal dashboard', 'Portal', 'manage_options', 'portal-dashboard', array( $this, 'portal_dashboard' ), 'dashicons-admin-site', 3 );

		/**
		 * https://developer.wordpress.org/reference/functions/add_submenu_page/
		 * add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', int $position = null )
		 * Adds a submenu page.
		 */
		add_submenu_page('portal-dashboard', 'Dashboard', 'Dashboard', 'manage_options', 'portal-dashboard', array($this, 'portal_dashboard'));

		add_submenu_page('portal-dashboard', 'Links', 'Links Create', 'manage_options', 'links-create', array($this, 'links_create')); 
		
		add_submenu_page('portal-dashboard', 'Links', 'Links List', 'manage_options', 'links-list', array($this, 'links_list')); 
	}

	public function portal_dashboard() {
		#echo '<h3>Welcome to admin Plugin Dashboard</h3>';
		/**
		 * https://www.php.net/manual/fr/function.ob-start.php
		 * ob_start — Enclenche la temporisation de sortie
		 */
		ob_start();
		include_once( PLUGIN_PORTAL_PATH . 'admin/partials/plugin-portal-admin-display.php' );
		/**
		 * https://www.php.net/manual/fr/function.ob-get-contents.php
		 * ob_get_contents — Retourne le contenu du tampon de sortie
		 */
		$template = ob_get_contents();
		/**
		 * https://www.php.net/manual/fr/function.ob-end-clean.php
		 * ob_end_clean — Détruit les données du tampon de sortie et éteint la temporisation de sortie
		 */
		ob_end_clean();

		echo( $template );
	}

	public function links_create() {
		#echo '<h3>Welcome to admin Plugin Create</h3>';
		/**
		 * https://www.php.net/manual/fr/function.ob-start.php
		 * ob_start — Enclenche la temporisation de sortie
		 */
		ob_start();
		include_once( PLUGIN_PORTAL_PATH . 'admin/partials/plugin-portal-admin-links-create.php' );
		/**
		 * https://www.php.net/manual/fr/function.ob-get-contents.php
		 * ob_get_contents — Retourne le contenu du tampon de sortie
		 */
		$template = ob_get_contents();
		/**
		 * https://www.php.net/manual/fr/function.ob-end-clean.php
		 * ob_end_clean — Détruit les données du tampon de sortie et éteint la temporisation de sortie
		 */
		ob_end_clean();

		echo( $template );
	}

	public function links_list() {
		#echo '<h3>Welcome to admin Plugin List</h3>';
		/**
		 * https://www.php.net/manual/fr/function.ob-start.php
		 * ob_start — Enclenche la temporisation de sortie
		 */
		ob_start();
		include_once( PLUGIN_PORTAL_PATH . 'admin/partials/plugin-portal-admin-links-list.php' );
		/**
		 * https://www.php.net/manual/fr/function.ob-get-contents.php
		 * ob_get_contents — Retourne le contenu du tampon de sortie
		 */
		$template = ob_get_contents();
		/**
		 * https://www.php.net/manual/fr/function.ob-end-clean.php
		 * ob_end_clean — Détruit les données du tampon de sortie et éteint la temporisation de sortie
		 */
		ob_end_clean();

		echo( $template );		
	}

}
