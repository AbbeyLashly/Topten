<?php
/**
 * Shinway functions and definitions
 * 
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 * */
clearstatcache();

if( ! isset( $content_width ) ) {
	$content_width = 1024;
}
// load constants
require_once ( get_template_directory() . '/framework/constants.php' );

load_theme_textdomain( 'bignews', SWBIGNEWS_THEME_DIR . '/languages' );
/* Theme Initialization */
require_once( SWBIGNEWS_FRAMEWORK_DIR . '/class-translate.php' );

require_once( SWBIGNEWS_FRAMEWORK_DIR . '/shw-init.php' );

$app = Swbignews::new_object('Application');
$app->run();