<?php
/**
 * Theme init
 *
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme setup
add_action('after_setup_theme', array( 'Swbignews', '[theme.Theme_Init, theme_setup]' ) );

/* Theme Options */
require_once( SWBIGNEWS_FRAMEWORK_DIR . '/class-shw.php' );
require_once( SWBIGNEWS_THEME_DIR . '/admin/admin-init.php' );

/**
 * Theme option function
 */
require_once( SWBIGNEWS_FRAMEWORK_DIR . '/shw-theme-option.php' );

// Setup plugins
require SWBIGNEWS_FRAMEWORK_DIR . '/shw-tgm.php';

// Remove Redux Notice
if( ! function_exists( 'swbignews_remove_demo_mode_link' ) ) {
	function swbignews_remove_demo_mode_link() {
		// Be sure to rename this function to something more unique
		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			remove_filter( 'plugin_row_meta', array (
				ReduxFrameworkPlugin::get_instance(),
				'plugin_metalinks'
			), null, 2 );
		}
		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			remove_action( 'admin_notices', array (
				ReduxFrameworkPlugin::get_instance(),
				'admin_notices'
			) );
		}
	}
}
add_action('init', 'swbignews_remove_demo_mode_link');

// Load class
Swbignews::load_class( 'Breadcrumb' );

/* Remove Admin bar in frontend when dev */
add_action('get_header', 'swbignews_remove_admin_login_header');
function swbignews_remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}

/**
 * Register sidebars
 */
add_action( 'widgets_init', array('Swbignews', '[widget.Widget_Init, widgets_init]') );

/**
 * Add scripts && css front-end
 */
if( ! is_admin() ) {
	add_action( 'wp_enqueue_scripts', array( 'Swbignews', '[theme.Theme_Init, public_enqueue]' ) );
}

require_once SWBIGNEWS_FRAMEWORK_DIR . '/shw-functions.php';
require_once SWBIGNEWS_FRAMEWORK_DIR . '/shw-menu.php';

// default
/**
 * Customizer additions.
 */
require SWBIGNEWS_THEME_DIR . '/inc/customizer.php';