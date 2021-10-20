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
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'cc_theme_base_menus', array( $this, 'add_global_menu') );
	}
	public function enqueue_scripts() {
		wp_enqueue_script( 'vocabulary', THEME_LOCAL_URI . '/assets/js/vocabulary.js', '', self::theme_ver, true );
	}
	public function enqueue_styles() {
		wp_enqueue_style( 'cc_current_style', THEME_LOCAL_URI . '/assets/css/styles.css', self::theme_ver );
	}
}

//This adds the CC colors as default color pallete
add_theme_support( 'editor-color-palette', array(
    //Brand
    array(
        'name'  => esc_attr__( 'Tomato', 'themeCreativeCommons' ),
        'slug'  => 'tomato',
        'color' => '#c74200',
    ),
    array(
        'name'  => esc_attr__( 'Dark Slate Gray', 'themeCreativeCommons' ),
        'slug'  => 'dark-slate-gray',
        'color' => '#333333',
    ),
    array(
        'name'  => esc_attr__( 'Gold', 'themeCreativeCommons' ),
        'slug'  => 'gold',
        'color' => '#fbd43c',
    ),
    array(
        'name'  => esc_attr__( 'Forest Green', 'themeCreativeCommons' ),
        'slug'  => 'forest-green',
        'color' => '#008000',
    ),
    array(
        'name'  => esc_attr__( 'Dark Turqoise', 'themeCreativeCommons' ),
        'slug'  => 'dark-turquoise',
        'color' => '#05b5da',
    ),
    array(
        'name'  => esc_attr__( 'Dark Slate Blue', 'themeCreativeCommons' ),
        'slug'  => 'dark-slate-blue',
        'color' => '#1547a8',
    ),

    //Soft Brand
    array(
        'name'  => esc_attr__( 'Soft Tomato', 'themeCreativeCommons' ),
        'slug'  => 'soft-tomato',
        'color' => '#feede9',
    ),
    array(
        'name'  => esc_attr__( 'Soft Gold', 'themeCreativeCommons' ),
        'slug'  => 'soft-gold',
        'color' => '#fef6d8',
    ),
    array(
        'name'  => esc_attr__( 'Soft Green', 'themeCreativeCommons' ),
        'slug'  => 'soft-green',
        'color' => '#e0f5e0',
    ),
    array(
        'name'  => esc_attr__( 'Soft Turquoise', 'themeCreativeCommons' ),
        'slug'  => 'soft-turquoise',
        'color' => '#dff6fc',
    ),
    array(
        'name'  => esc_attr__( 'Soft Blue', 'themeCreativeCommons' ),
        'slug'  => 'soft-blue',
        'color' => '#e3ebfd',
    ),

    //Neutral
    array(
        'name'  => esc_attr__( 'Dark Gray', 'themeCreativeCommons' ),
        'slug'  => 'dark-gray',
        'color' => '#767676',
    ),
    array(
        'name'  => esc_attr__( 'Gray', 'themeCreativeCommons' ),
        'slug'  => 'gray',
        'color' => '#b0b0b0',
    ),
    array(
        'name'  => esc_attr__( 'Light Gray', 'themeCreativeCommons' ),
        'slug'  => 'light-gray',
        'color' => '#d8d8d8',
    ),
    array(
        'name'  => esc_attr__( 'Lighter Gray', 'themeCreativeCommons' ),
        'slug'  => 'lighter-gray',
        'color' => '#f5f5f5',
    ),

    //Binary
    array(
        'name'  => esc_attr__( 'White', 'themeCreativeCommons' ),
        'slug'  => 'white',
        'color' => '#ffffff',
    ),
    array(
        'name'  => esc_attr__( 'Black', 'themeCreativeCommons' ),
        'slug'  => 'black',
        'color' => '#000000',
    ),
) );

//this line disables the default color picker
add_theme_support('disable-custom-colors'); 

/**
 * Instantiate the class object
 * */
$_s = CC_Org_Site::get_instance();
