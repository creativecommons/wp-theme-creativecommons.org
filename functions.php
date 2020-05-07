<?php
/**
 * Functions: list
 *
 * @version 2020.05.1
 * @package wp-theme-creativecommons.org
 */

/* Theme Constants (to speed up some common things) ------*/
define( 'THEME_LOCAL_URI', get_stylesheet_directory_uri() );
define( 'THEME_PARENT_URI', get_template_directory_uri() );

/**
 * Theme singleton class
 * ---------------------
 * Stores various theme and site specific info and groups custom methods
 **/
class CC_Org_Site {
	private static $instance;

	const id        = __CLASS__;
	const theme_ver = '2020.05.1';
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
	/**
	 * Setup theme actions, both in the front and back end
	 * */
	public function actions_manager() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
	}
	public function enqueue_styles() {
		wp_enqueue_style( 'cc_current_style', THEME_LOCAL_URI . '/assets/css/styles.css', self::theme_ver );
	}
}

/**
 * Instantiate the class object
 * */

$_s = CC_Org_Site::get_instance();
