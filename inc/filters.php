<?php
class CC_Org_Filters {
  public static function get_main_menu() {
    $menu_locations = get_nav_menu_locations();
    $main_menu = wp_get_nav_menu_object($menu_locations['global-menu']);
    if ( !empty( $main_menu ) ) {
      return wp_get_nav_menu_items($main_menu);
    }
  }
  public static function set_custom_menu_endpoint() {
    register_rest_route( 'ccglobal', '/menu', array(
      'methods' => 'GET',
      'callback' => array('CC_Org_Filters','get_main_menu'),
	  ));
  }
}

add_action( 'rest_api_init', array( 'CC_Org_Filters', 'set_custom_menu_endpoint') );
