<?php
if ( file_exists( SWBIGNEWS_EXTERNAL_DIR . '/class-tgm-plugin-activation.php' ) ) {

	// include file
	require_once SWBIGNEWS_EXTERNAL_DIR . '/class-tgm-plugin-activation.php';

	// hook function
	add_action('tgmpa_register', 'swbignews_register_required_plugins');
	function swbignews_register_required_plugins () {
		// Required keys are name and slug.
		$plugins = array(
			array(
				'name'					=> 'Swlabs Core',
				'slug'					=> 'swlabs-core',
				'source'				=> SWBIGNEWS_PLUGINS_DIR . '/swlabs-core.zip',
				'required'				=> true,
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'image_url'				=> SWBIGNEWS_ADMIN_URI . '/images/swlabs_core.png',
				'version'				=> '1.0',
			),
			// Include Visual Composer plugin.
			array(
				'name'					=> 'WPBakery Visual Composer',
				'slug'					=> 'js_composer',
				'source'				=> SWBIGNEWS_PLUGINS_DIR . '/js_composer.zip',
				'required'				=> true,
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'image_url'				=> SWBIGNEWS_ADMIN_URI . '/images/js_composer.jpg',
				//'version'				=> '4.8.1',
			),
			// Include Contact Form 7 plugin.
			array(
				'name'					=> 'Contact Form 7',
				'slug'					=> 'contact-form-7',
				'required'				=> true,
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'image_url'				=> SWBIGNEWS_ADMIN_URI . '/images/contact_form_7.jpg',
				//'version'				=> '4.3',
			),
			// Latest Tweets Widget
			array(
				'name'					=> 'Latest Tweets Widget',
				'slug'					=> 'latest-tweets-widget',
				'required'				=> false,
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'image_url'				=> SWBIGNEWS_ADMIN_URI . '/images/latest_tweets.jpg',
				'version'				=> '1.1.3',
			),
			// Include Newsletter plugin.
			array(
				'name'					=> 'Newsletter',
				'slug'					=> 'newsletter',
				'required'				=> false,
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'image_url'				=> SWBIGNEWS_ADMIN_URI . '/images/newsletter.png',
				'version'				=> '4.0.4',
			),
			// WP User Avatar
			array(
				'name'					=> 'WP User Avatar',
				'slug'					=> 'wp-user-avatar',
				'required'				=> false,
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'image_url'				=> SWBIGNEWS_ADMIN_URI . '/images/user_avatar.jpg',
				'version'				=> '2.0.3',
			),
			// Awesome Surveys
			array(
				'name'					=> 'Awesome Surveys',
				'slug'					=> 'awesome-surveys',
				'required'				=> false,
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'image_url'				=> SWBIGNEWS_ADMIN_URI . '/images/awesome_surveys.jpg',
				'version'				=> '2.0.9',
			)
			,
			// Redux Framework
			array(
				'name'					=> 'Redux Framework',
				'slug'					=> 'redux-framework',
				'required'				=> true,
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'image_url'				=> SWBIGNEWS_ADMIN_URI . '/images/redux-framework.jpg',
				'version'				=> '3.6.0.2',
			),
			// Woocommerce
			// array(
			// 	'name'					=> 'WooCommerce',
			// 	'slug'					=> 'woocommerce',
			// 	'required'				=> false,
			// 	'force_activation'		=> false,
			// 	'force_deactivation'	=> false,
			// 	'image_url'				=> SWBIGNEWS_ADMIN_URI . '/images/woocommerce.png',
			// 	'version'				=> '2.5.5',
			// )
		);
		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		*/
		$config = array(
			'id'               => 'tgmpa',
			'domain'           => 'bignews',
			'default_path'     => '',
			'parent_slug'      => 'themes.php',
			'menu'             => 'tgmpa-install-plugins',
			'has_notices'      => true,
			'is_automatic'     => true, // Automatically activate plugins after installation or not
			'message'          => '',
			'strings'          => array(
				'page_title'                       => esc_html__('Install Required Plugins', 'bignews'),
				'menu_title'                       => esc_html__('Install Plugins', 'bignews'),
				'installing'                       => esc_html__('Installing Plugin: %s', 'bignews'), // %1$s = plugin name
				'oops'                             => esc_html__('Something went wrong with the plugin API.', 'bignews'),
				'notice_can_install_required'      => _n_noop('This theme requires the following plugin installed or update: %1$s.', 'This theme requires the following plugins installed or updated: %1$s.', 'bignews' ), // %1$s = plugin name(s)
				'notice_can_install_recommended'   => _n_noop('This theme recommends the following plugin installed or updated: %1$s.', 'This theme recommends the following plugins installed or updated: %1$s.', 'bignews' ), // %1$s = plugin name(s)
				'notice_cannot_install'            => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'bignews' ), // %1$s = plugin name(s)
				'notice_can_activate_required'     => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'bignews' ), // %1$s = plugin name(s)
				'notice_can_activate_recommended'  => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'bignews' ), // %1$s = plugin name(s)
				'notice_cannot_activate'           => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'bignews' ), // %1$s = plugin name(s)
				'notice_ask_to_update'             => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'bignews' ), // %1$s = plugin name(s)
				'notice_cannot_update'             => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'bignews' ), // %1$s = plugin name(s)
				'install_link'                     => _n_noop('Begin installing plugin', 'Begin installing plugins', 'bignews' ),
				'activate_link'                    => _n_noop('Activate installed plugin', 'Activate installed plugins', 'bignews' ),
				'return'                           => esc_html__('Return to Required Plugins Installer', 'bignews'),
				'plugin_activated'                 => esc_html__('Plugin activated successfully.', 'bignews'),
				'complete'                         => esc_html__('All plugins installed and activated successfully. %s', 'bignews'), // %1$s = dashboard link
				'nag_type'                         => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
			)
		);
		tgmpa($plugins, $config);
	}
}
