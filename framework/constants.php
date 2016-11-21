<?php
/**
 * Constants.
 * 
 * @package BigNews
 * @since 1.0
 */

defined( 'SWBIGNEWS_LANG_ZONE' )      || define( 'SWBIGNEWS_LANG_ZONE', 'bignews' );
defined( 'SWBIGNEWS_THEME_VER' )      || define( 'SWBIGNEWS_THEME_VER', '1.0.0' );
defined( 'SWBIGNEWS_THEME_NAME' )     || define( 'SWBIGNEWS_THEME_NAME', 'bignews' );
defined( 'SWBIGNEWS_THEME_PREFIX' )   || define( 'SWBIGNEWS_THEME_PREFIX', 'swbignews' );
defined( 'SWBIGNEWS_THEME_CLASS' )    || define( 'SWBIGNEWS_THEME_CLASS', 'Swbignews' );

defined( 'SWBIGNEWS_THEME_DIR' )      || define( 'SWBIGNEWS_THEME_DIR', get_template_directory() );
defined( 'SWBIGNEWS_THEME_URI' )      || define( 'SWBIGNEWS_THEME_URI', get_template_directory_uri() );
defined( 'SWBIGNEWS_FRAMEWORK_DIR' )  || define( 'SWBIGNEWS_FRAMEWORK_DIR', SWBIGNEWS_THEME_DIR . '/framework' );

defined( 'SWBIGNEWS_MODULES_DIR' )    || define( 'SWBIGNEWS_MODULES_DIR', SWBIGNEWS_FRAMEWORK_DIR . '/modules' );
defined( 'SWBIGNEWS_FRONT_DIR' )      || define( 'SWBIGNEWS_FRONT_DIR', SWBIGNEWS_FRAMEWORK_DIR . '/modules/front' );
defined( 'SWBIGNEWS_PLUGINS_DIR' )    || define( 'SWBIGNEWS_PLUGINS_DIR', SWBIGNEWS_FRAMEWORK_DIR . '/plugins' );
defined( 'SWBIGNEWS_LIBS_DIR' )       || define( 'SWBIGNEWS_LIBS_DIR', SWBIGNEWS_FRAMEWORK_DIR . '/libs' );
defined( 'SWBIGNEWS_EXTERNAL_DIR' )   || define( 'SWBIGNEWS_EXTERNAL_DIR', SWBIGNEWS_FRAMEWORK_DIR . '/external' );

defined( 'SWBIGNEWS_ADMIN_URI' )      || define( 'SWBIGNEWS_ADMIN_URI', SWBIGNEWS_THEME_URI . '/assets/admin' );
defined( 'SWBIGNEWS_PUBLIC_URI' )     || define( 'SWBIGNEWS_PUBLIC_URI', SWBIGNEWS_THEME_URI . '/assets/public' );
defined( 'SWBIGNEWS_CORE_URI' )		  || define( 'SWBIGNEWS_CORE_URI', WP_PLUGIN_DIR . '/swlabs-core/' );
// Social Links
defined( 'SWBIGNEWS_FACEBOOK_LINK' )  || define( 'SWBIGNEWS_FACEBOOK_LINK', 'https://www.facebook.com/' );
defined( 'SWBIGNEWS_TWITTER_LINK' )   || define( 'SWBIGNEWS_TWITTER_LINK', 'https://twitter.com/' );
defined( 'SWBIGNEWS_GOOGLEPLUS_LINK' )|| define( 'SWBIGNEWS_GOOGLEPLUS_LINK', 'https://plus.google.com/' );
defined( 'SWBIGNEWS_SKYPE_LINK' )     || define( 'SWBIGNEWS_SKYPE_LINK', 'http://www.skype.com/' );

defined( 'SWBIGNEWS_COPYRIGHT' )         || define( 'SWBIGNEWS_COPYRIGHT', '&#169; 2016 by BIGNEWS. All Rights Reserved' );
defined( 'SWBIGNEWS_LOGO_BLACK' )        || define( 'SWBIGNEWS_LOGO_BLACK', SWBIGNEWS_PUBLIC_URI . '/images/logo-black.png' );
defined( 'SWBIGNEWS_LOGO_WHITE' )        || define( 'SWBIGNEWS_LOGO_WHITE', SWBIGNEWS_PUBLIC_URI . '/images/logo-white.png' );
defined( 'SWBIGNEWS_FAVICON' )        || define( 'SWBIGNEWS_FAVICON', SWBIGNEWS_PUBLIC_URI . '/images/favicon.ico' );
defined( 'SWBIGNEWS_FONT_AWESOME_URL' )  || define( 'SWBIGNEWS_FONT_AWESOME_URL', 'http://fortawesome.github.io/Font-Awesome/icons/' );

// Banner Ads
defined( 'SWBIGNEWS_BANNER_TOP' )        || define( 'SWBIGNEWS_BANNER_TOP', SWBIGNEWS_PUBLIC_URI . '/images/banner_adv_728x90.jpg' );
defined( 'SWBIGNEWS_BANNER_SIDE_SMALL' ) || define( 'SWBIGNEWS_BANNER_SIDE_SMALL', SWBIGNEWS_PUBLIC_URI . '/images/banner_adv_300x60.jpg' );
defined( 'SWBIGNEWS_BANNER_SIDE' )       || define( 'SWBIGNEWS_BANNER_SIDE', SWBIGNEWS_PUBLIC_URI . '/images/banner_adv_300x300.jpg' );

//Active VC Plugin - SWBIGNEWS_VC_IS_ACTIVE
if( defined( 'WPB_VC_VERSION' ) ) {
	define( 'SWBIGNEWS_VC_IS_ACTIVE', defined( 'WPB_VC_VERSION' ) );
}
else {
	define( 'SWBIGNEWS_VC_IS_ACTIVE', '' );
}
//Active Shinway-core Plugin - SHINWAY_CORE_VERSION
if( defined( 'SWLABSCORE_VERSION' ) ) {
	define( 'SWBIGNEWS_CORE_IS_ACTIVE', defined( 'SWLABSCORE_VERSION' ) );
}
else {
	define( 'SWBIGNEWS_CORE_IS_ACTIVE', '' );
}

if( !defined( 'SWLABSCORE_CUSTOM_SIDEBAR_NAME' ) ) {
	define( 'SWLABSCORE_CUSTOM_SIDEBAR_NAME', 'swbignews_custom_sidebar' );
}

//Active ContactForm7 Plugin - SWBIGNEWS_WPCF7_ACTIVE
if( defined( 'WPCF7_LOAD_JS' ) ) {
	define( 'SWBIGNEWS_WPCF7_ACTIVE', defined( 'WPCF7_LOAD_JS' ) );
}
else {
	define( 'SWBIGNEWS_WPCF7_ACTIVE', '' );
}
//Active Woocommerce Plugin
defined( 'SWBIGNEWS_WOOCOMMERCE_ACTIVE' )     || define( 'SWBIGNEWS_WOOCOMMERCE_ACTIVE', class_exists( 'WC_API' ) );

defined( 'SWBIGNEWS_WOOCOMMERCE_WISHLIST' )   || define( 'SWBIGNEWS_WOOCOMMERCE_WISHLIST', class_exists( 'YITH_WCWL_Shortcode' ) );

if ( ! function_exists( 'is_plugin_active' ) )
	require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
defined( 'SWBIGNEWS_AWESOME_SURVEYS_ACTIVE' ) || define( 'SWBIGNEWS_AWESOME_SURVEYS_ACTIVE', is_plugin_active( 'awesome-surveys/awesome-surveys.php' ) );
defined( 'SWBIGNEWS_NEWSLETTER_ACTIVE' )      || define( 'SWBIGNEWS_NEWSLETTER_ACTIVE', is_plugin_active( 'newsletter/plugin.php' ) );

defined( 'SWBIGNEWS_NO_IMG' )         || define( 'SWBIGNEWS_NO_IMG', SWBIGNEWS_PUBLIC_URI.'/images/thumb-no-image.gif' );
