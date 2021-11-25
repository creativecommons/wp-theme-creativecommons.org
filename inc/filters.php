<?php
class CC_Org_Filters {
  public static function add_html_content()
  {
    $style_imports = array(
      "@import url(https://unpkg.com/@creativecommons/fonts@2020.9.3/css/fonts.css);",
      //  TODO: Replace with appropriate creative commons url.
      "@import url(http://127.0.0.1:8000/wp-content/themes/creativecommons-base/assets/css/styles.css);"
    );

    return "<style>" . implode(" ", $style_imports)  . "</style>";
  }
  public static function get_global_menu() {
    if ( false === ( $global_menu_items = get_transient( 'global_menu_items' ) ) ) {
      $menu_locations = get_nav_menu_locations();
      $global_menu = wp_get_nav_menu_object($menu_locations['global-menu']);
      if ( !empty( $global_menu ) ) {
        $global_menu_items = wp_get_nav_menu_items($global_menu);
        set_transient( 'global_menu_items', $global_menu_items, 1 * HOUR_IN_SECONDS );
      }
    }
    return $global_menu_items;
  }
  public static function get_header_menu() {
    header('Content-Type: text/html');

    if ( false === ( $header_menu_items = get_transient( 'header_menu_items' ) ) ) {
      $menu_locations = get_nav_menu_locations();
      $header_menu = wp_get_nav_menu_object($menu_locations['main-navigation']);
      if ( !empty( $header_menu ) ) {
        $header_menu_items = wp_get_nav_menu_items($header_menu);
        set_transient( 'header_menu_items', $header_menu_items, 1 * HOUR_IN_SECONDS );
      }
    }

    $menu_html = wp_nav_menu(
      array(
        'menu'  => $header_menu_items,
        'container'       => 'div',
        'container_class' => 'navbar-menu',
        'items_wrap'      => '<div id="%1$s" class="navbar-start">%3$s</div>',
        'menu_class'      => 'navbar-menu',
        'after'           => '</div>',
        'walker'          => new Navwalker(),
      )
    );

    $style_string = self::add_html_content();
    return $menu_html . $style_string;
  }
  public static function get_footer_menu() {
    header('Content-Type: text/html');

    if ( false === ( $footer_menu_items = get_transient( 'footer_menu_items' ) ) ) {
      $menu_locations = get_nav_menu_locations();
      $footer_menu = wp_get_nav_menu_object($menu_locations['footer-navigation']);
      if ( !empty( $footer_menu ) ) {
        $footer_menu_items = wp_get_nav_menu_items($footer_menu);
        set_transient( 'footer_menu_items', $footer_menu_items, 1 * HOUR_IN_SECONDS );
      }
    }

    $menu_html = wp_nav_menu(
      array(
        'menu'  => $footer_menu_items,
        'container'       => 'div',
        'container_class' => 'navbar-menu',
        'items_wrap'      => '<div id="%1$s" class="navbar-start">%3$s</div>',
        'menu_class'      => 'navbar-menu',
        'after'           => '</div>',
        'walker'          => new Navwalker(),
      )
      );
      $style_string = self::add_html_content();
    return $menu_html . $style_string;
  }
  public static function transient_queued_scripts() {
    delete_transient('cc_enqueued_scripts');
    if ( false === ( $script_list = get_transient( 'cc_enqueued_scripts' ) ) ) {
      global $wp_scripts;
      $script_list = array();
      foreach ( $wp_scripts->queue as $handler ) {
        if ($handler == 'jquery') {
          foreach ( $wp_scripts->registered[$handler]->deps as $script_dep_handler ) {
            $src = $wp_scripts->registered[$script_dep_handler]->src;
            if ( !empty( $src ) ) {
              $script_list[$script_dep_handler] = self::maybe_correct_path( $src );
            }
          }
        } else {
          $src = $wp_scripts->registered[$handler]->src;
            $script_list[$handler] = self::maybe_correct_path( $src );
        }
      }
      set_transient( 'cc_enqueued_scripts', $script_list, 1 * HOUR_IN_SECONDS );
    }
  }
  public static function transient_queued_styles() {
    delete_transient('cc_enqueued_styles');
    if ( false === ( $style_list = get_transient( 'cc_enqueued_styles' ) ) ) {
      global $wp_styles;
      $styles_list = array();
      foreach ( $wp_styles->queue as $handler ) {
        $src = $wp_styles->registered[$handler]->src;
        $styles_list[$handler] = self::maybe_correct_path( $src );
      }
      set_transient( 'cc_enqueued_styles', $styles_list, 1 * HOUR_IN_SECONDS );
    }
  }
  static public function maybe_correct_path( $url ) {
    $parse_url = wp_parse_url( $url );
    if ( empty( $parse_url['host'] ) ) {
      $return_url = get_bloginfo( 'url' ) . $url;
    } else {
      $return_url = $url;
    }
    return $return_url;
  }
  public static function get_queued_scripts() {
    $script_list = get_transient( 'cc_enqueued_scripts' );
    return $script_list;
  }
  public static function get_queued_styles() {
    $styles_list = get_transient( 'cc_enqueued_styles' );
    return $styles_list;
  }
  public static function set_global_menu_endpoint() {
    register_rest_route( 'ccglobal', '/menu', array(
      'methods' => 'GET',
      'callback' => array('CC_Org_Filters','get_main_menu'),
	  ));
  }
  public static function set_header_menu_endpoint() {
    register_rest_route( 'ccnavigation-header', '/menu', array(
      'methods' => 'GET',
      'callback' => array('CC_Org_Filters','get_header_menu'),
	  ));
  }
  public static function set_footer_menu_endpoint() {
    register_rest_route( 'ccnavigation-footer', '/menu', array(
      'methods' => 'GET',
      'callback' => array('CC_Org_Filters','get_footer_menu'),
	  ));
  }
  public static function set_queued_scripts_endpoint() {
    register_rest_route( 'cc-wpscripts', '/get', array(
      'methods' => 'GET',
      'callback' => array('CC_Org_Filters','get_queued_scripts'),
	  ));
  }
  public static function set_queued_styles_endpoint() {
    register_rest_route( 'cc-wpstyles', '/get', array(
      'methods' => 'GET',
      'callback' => array('CC_Org_Filters','get_queued_styles'),
	  ));
  }
  /**
   * Remove Global menu transient
   *
   * @param int $nav_menu_selected_id
   * @return void
   */
  function remove_global_menu_transient($nav_menu_selected_id) {
    delete_transient( 'global_menu_items' );
    delete_transient( 'header_menu_items' );
    delete_transient( 'footer_menu_items' );
  }
}

add_action( 'wp_update_nav_menu', array( 'CC_Org_Filters', 'remove_global_menu_transient' ) );
add_action( 'rest_api_init', array( 'CC_Org_Filters', 'set_global_menu_endpoint') );
add_action( 'rest_api_init', array( 'CC_Org_Filters', 'set_header_menu_endpoint') );
add_action( 'rest_api_init', array( 'CC_Org_Filters', 'set_footer_menu_endpoint') );
add_action( 'rest_api_init', array( 'CC_Org_Filters', 'set_queued_scripts_endpoint') );
add_action( 'rest_api_init', array( 'CC_Org_Filters', 'set_queued_styles_endpoint') );
add_action( 'wp_print_scripts', array( 'CC_Org_Filters', 'transient_queued_scripts'), 100 );
add_action( 'wp_print_styles', array( 'CC_Org_Filters', 'transient_queued_styles'), 100 );
