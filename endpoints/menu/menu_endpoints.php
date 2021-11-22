<?php

add_action('rest_api_init', function () {
    register_rest_route('api/v1', '/menus/main-navigation', array(
        'methods' => 'GET',
        'callback' => 'get_menus',
    ));
});

function get_menus()
{
    header('Content-Type: text/html');
    $html_string =  wp_nav_menu(
        array(
            'theme_location'  => 'main-navigation',
            'depth'           => 2,
            'container'       => 'div',
            'container_class' => 'navbar-menu',
            'items_wrap'      => '<div id="%1$s" class="navbar-start">%3$s</div>',
            'menu_class'      => 'navbar-menu',
            'menu_id'         => 'primary-menu',
            'after'           => '</div>',
            'walker'          => new Navwalker(),
        )
    );

    return $html_string . " <style> @import url(https://unpkg.com/@creativecommons/fonts@2020.9.3/css/fonts.css); @import url(https://creativecommons.org/wp-content/themes/creativecommons-base/assets/css/styles.css?ver=5.8.1); </style> ";
}