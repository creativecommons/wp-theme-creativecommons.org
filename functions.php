<?php
/**
 * Functions: list
 *
 * @version 2020.07.1
 * @package wp-theme-creativecommons.org
 */

/* Theme Constants (to speed up some common things) ------*/
define( 'THEME_LOCAL_URI', get_stylesheet_directory_uri() );
define( 'THEME_PARENT_URI', get_template_directory_uri() );

/**
 * Include local files
 */
require STYLESHEETPATH . '/inc/filters.php';

/**
 * Theme singleton class
 * ---------------------
 * Stores various theme and site specific info and groups custom methods
 **/
class CC_Org_Site {
	private static $instance;

	const id        = __CLASS__;
	const theme_ver = '2020.07.1';
	private function __construct() {
		$this->actions_manager();
	}
	public function __get( $key ) {
		return isset( $this->$key ) ? $this->$key : null;
	}
	public function __isset( $key ) {
		return isset( $this->$key );
	}
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			$c              = __CLASS__;
			self::$instance = new $c();
		}
		return self::$instance;
	}
	public function __clone() {
		trigger_error( 'Clone is not allowed.', E_USER_ERROR );
	}
	public function add_global_menu($parent_menus) {
		$parent_menus['global-menu'] = 'Global menu';
		return $parent_menus;
	}
	/**
	 * Setup theme actions, both in the front and back end
	 * */
	public function actions_manager() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_filter( 'cc_theme_base_menus', array( $this, 'add_global_menu') );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	public function admin_enqueue_scripts() {
		wp_enqueue_script( 'custom-block-settings', THEME_LOCAL_URI . '/custom-block-settings.js', '', self::theme_ver, true );
	}

	public function enqueue_styles() {
		wp_enqueue_style( 'cc_current_style', THEME_LOCAL_URI . '/style.css', self::theme_ver );

	}
}

/**
 * Instantiate the class object
 * */

$_s = CC_Org_Site::get_instance();
