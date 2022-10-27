<?php
/**
 * Swish Design functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Eyorsogood_Design
 */

if ( ! defined( 'THEME_IS_DEV_MODE' ) ) {
	define( 'THEME_IS_DEV_MODE', true );
}

define( 'QED_VERSION', '1.0.0' );
define( 'PARENT_DIR', get_template_directory() );
define( 'PARENT_URL', get_template_directory_uri() );

require PARENT_DIR . '/includes/core.php';
require PARENT_DIR . '/php/class-main.php';


/**
 * 
 *  Instantiate classes
 */

$theme = new Theme();


add_action( 'admin_menu', 'isa_remove_menus', 999 ); 
function isa_remove_menus() { 
     remove_menu_page( 'branding' );
     remove_menu_page( 'wpmudev' );
 }


add_action( 'init', 'woocommerce_clear_cart_url' );

function woocommerce_clear_cart_url() {
  global $woocommerce;

    if (isset( $_GET['add-to-cart'] ) ) { 
        $woocommerce->cart->empty_cart(); 
    }
}

add_action( 'admin_enqueue_scripts', 'load_admin_style' );

function load_admin_style() {
    global $pagenow;

    if ( 'post.php' === $pagenow && isset($_GET['post']) && 'shop_order' === get_post_type( $_GET['post'] ) ) {
      echo '<style>
       #post-body-content {
          display:block!important;
        } 
      </style>';
    }
}