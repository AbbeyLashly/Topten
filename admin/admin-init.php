<?php

// Load the theme/plugin options
if (is_plugin_active('redux-framework/redux-framework.php') && file_exists( SWBIGNEWS_THEME_DIR.'/admin/options-init.php')) {
	require_once( SWBIGNEWS_THEME_DIR.'/admin/options-init.php' );
}
