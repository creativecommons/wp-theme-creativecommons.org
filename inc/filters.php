<?php
class CC_Org_Filters {
  public static function get_main_menu() {
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
  public static function set_custom_menu_endpoint() {
    register_rest_route( 'ccglobal', '/menu', array(
      'methods' => 'GET',
      'callback' => array('CC_Org_Filters','get_main_menu'),
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
  }
}

add_action( 'wp_update_nav_menu', array( 'CC_Org_Filters', 'remove_global_menu_transient' ) );
add_action( 'rest_api_init', array( 'CC_Org_Filters', 'set_custom_menu_endpoint') );
