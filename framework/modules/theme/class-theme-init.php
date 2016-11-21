<?php
/**
 * Theme class.
 * 
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */
Swbignews::load_class( 'Abstract' );
class Swbignews_Theme_Init extends Swbignews_Abstract {

	/**
	 * Get Google font URL
	 * 
	 */
	public function font_google_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'bignews' ) ) {
			$fonts[] = 'Roboto:400italic,300,700,400';
		}

		if ( 'off' !== _x( 'on', 'Roboto Slab font: on or off', 'bignews' ) ) {
			$fonts[] = 'Roboto Slab:400,700,300';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}
	/**
	 * Register style/script in admin
	 * 
	 */
	public function admin_enqueue(){
		$uri = get_template_directory_uri() . '/assets/admin';
		// css
		wp_enqueue_style( 'swbignews-admin-style', $uri . '/css/admin-style.css', false, SWBIGNEWS_THEME_VER, 'all' );
		// js
		wp_enqueue_media();
		wp_enqueue_script( 'jquery', false, array(), false, false );
		wp_enqueue_script( 'swbignews-widget',      $uri . '/js/widget.js', array('jquery'), SWBIGNEWS_THEME_VER, true );
		wp_enqueue_script( 'swbignews-page-template',      $uri . '/js/page-template.js', array('jquery'), SWBIGNEWS_THEME_VER, true );
		//menu
		wp_enqueue_script( 'swbignews-menu',        $uri . '/js/menu.js', array('jquery'), SWBIGNEWS_THEME_VER, true );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'swbignews-color',       $uri . '/js/color.js', array( 'wp-color-picker' ), SWBIGNEWS_THEME_VER, true );
	}

	/**
	 * Register style/script in public
	 */
	public function public_enqueue() {
		$dir_uri = get_template_directory_uri();
		$uri = SWBIGNEWS_PUBLIC_URI;

		//google fonts
		wp_enqueue_style( 'swbignews-fonts', $this->font_google_url(), array(), null );

		// css
		wp_enqueue_style( 'swbignews-style', get_stylesheet_uri(), array(), SWBIGNEWS_THEME_VER );
		wp_enqueue_style( 'fontawesome',         $uri . '/libs/font-awesome/css/font-awesome.min.css', array(), SWBIGNEWS_THEME_VER );
		wp_enqueue_style( 'ionicons',            $uri . '/libs/ionicons/css/ionicons.min.css', array(), SWBIGNEWS_THEME_VER );
		wp_enqueue_style( 'bootstrap-min',       $uri . '/libs/bootstrap/css/bootstrap.min.css', array(), SWBIGNEWS_THEME_VER );
		wp_enqueue_style( 'animate-css',         $uri . '/libs/animate/animate.css', array(), SWBIGNEWS_THEME_VER );

		wp_enqueue_style( 'swbignews-layouts-css',         $uri . '/css/layout.css', array(), SWBIGNEWS_THEME_VER );
		wp_enqueue_style( 'swbignews-components-css',      $uri . '/css/components.css', array(), SWBIGNEWS_THEME_VER );
		wp_enqueue_style( 'swbignews-responsive-css',      $uri . '/css/responsive.css', array(), SWBIGNEWS_THEME_VER );
 		wp_enqueue_style( 'swbignews-custom-css',          $uri . '/css/custom.css', array(), SWBIGNEWS_THEME_VER );
		wp_enqueue_style( 'swbignews-custom-editor-css',   $uri . '/css/custom-editor.css', array(), SWBIGNEWS_THEME_VER );

		// js
		// comment
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		wp_enqueue_script( 'bootstrap.min',            $uri . '/libs/bootstrap/js/bootstrap.min.js', array('jquery'), false, true );

		wp_enqueue_script( 'jquery.easing.min',        $uri . '/vendors/easy-ticker/jquery.easing.min.js', array('jquery'), false, true );

		wp_enqueue_script( 'jquery.easy-ticker.min',   $uri . '/vendors/easy-ticker/jquery.easy-ticker.min.js', array('jquery'), false, true );

		wp_enqueue_script( 'bootstrap-hover-dropdown', $uri . '/libs/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js', array('jquery'), false, true );

		wp_enqueue_script( 'sidebar-fixed',            $uri . '/libs/sidebar-fixed/sidebar-fixed.js', array('jquery'), false, true );

		// theme js
		wp_enqueue_script( 'swbignews-main',   $uri . '/js/main.js', array(), SWBIGNEWS_THEME_VER, true );

		wp_enqueue_script( 'swbignews-custom', $uri . '/js/custom.js', array(), SWBIGNEWS_THEME_VER, true );

		// Woocommerce
		wp_enqueue_style( 'swbignews-woocommerce', $uri . '/css/slz-woocommerce.css', array(), SWBIGNEWS_THEME_VER );
		wp_enqueue_script( 'swbignews-woocommerce-script', $uri . '/js/slz-woocommerce.js', array('jquery'), SWBIGNEWS_THEME_VER, true );
		
		//SLICK
		wp_enqueue_style( 'jquery-slick', $uri . '/libs/slick-slider/slick.css', array(), false );
		wp_enqueue_style( 'jquery-slick-theme', $uri . '/libs/slick-slider/slick-theme.css', array(), false );
		wp_enqueue_script( 'jquery-slick-script', $uri . '/libs/slick-slider/slick.min.js', array('jquery'), false, true );

		//for contact form 7 plugin
		if ( SWBIGNEWS_WPCF7_ACTIVE ) {
			wp_localize_script(
					'shw-form',
					'ajaxurl',
					admin_url( 'admin-ajax.php' )
			);
			wp_enqueue_script( 'swbignews-cf7-jquery', plugins_url() . '/contact-form-7/includes/js/jquery.form.min.js', array(), false, true );
			wp_enqueue_script( 'swbignews-cf7-scripts', plugins_url() . '/contact-form-7/includes/js/scripts.js', array(), false, true );
		}
	}

	function remove_query_strings_1( $src ){	
		$rqs = explode( '?ver', $src );
		return $rqs[0];
	}

	function remove_query_strings_2( $src ){
		$rqs = explode( '&ver', $src );
		return $rqs[0];
	}
	/**
	 * General setting
	 * 
	 */
	public function theme_setup() {
		// Editor
		$this->add_theme_supports();
		$this->add_image_sizes();
	}
	/**
	 * Add theme_supports
	 * 
	 */
	public function add_theme_supports() {
	
		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );
		// Default custom header
		add_theme_support( 'custom-header' );
		// Default custom backgrounds
		add_theme_support( 'custom-background' );
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		/*
		* Enable support for Post Formats.
		*/
		// Post Formats
		add_theme_support( 'post-formats', array( 'image', 'video','gallery' ) );
		// Add post thumbnail functionality
		add_theme_support('post-thumbnails');
		//
		add_theme_support( 'title-tag' );
	}
	
	/**
	 * Add image sizes
	 * 
	 */
	public function add_image_sizes() {
		$image_sizes = Swbignews::get_config('image_sizes');
		foreach($image_sizes as $key => $sizes ) {
			$crop = true;
			if( isset( $sizes['crop'] ) ) {
				$crop = $sizes['crop'];
			}
			add_image_size( $key, $sizes['width'], $sizes['height'], $crop );
		}
	}
	
	/**
	 * Add menu page
	 *
	 */
	 public function call_tgm_plugin_action(){
		if( isset( $_GET['shw-deactivate'] ) && $_GET['shw-deactivate'] == 'deactivate-plugin' ) {
			check_admin_referer( 'shw-deactivate', 'shw-nonce' );

			$plugins = TGM_Plugin_Activation::$instance->plugins;

			foreach( $plugins as $plugin ) {
				if( $plugin['slug'] == $_GET['plugin'] ) {
					deactivate_plugins( $plugin['file_path'] );
				}
			}
		} if( isset( $_GET['shw-activate'] ) && $_GET['shw-activate'] == 'activate-plugin' ) {
			check_admin_referer( 'shw-activate', 'shw-nonce' );

			$plugins = TGM_Plugin_Activation::$instance->plugins;

			foreach( $plugins as $plugin ) {
				if( $plugin['slug'] == $_GET['plugin'] ) {
					activate_plugin( $plugin['file_path'] );
				}
			}
		}
	}
	
	public function add_menu_welcome_pages(){
		$menu_slug = SWBIGNEWS_THEME_PREFIX . '_welcome';

		if( is_plugin_active( 'swlabs-core/swlabs-core.php' ) ) {
			swlabscore_add_menu_page('BigNews', 'BigNews', 'manage_options', $menu_slug, array(&$this, 'show_requirement_submenu'), '', 3);
			swlabscore_add_submenu_page( $menu_slug, 'Recommendations', 'Recommendations', 'manage_options', SWBIGNEWS_THEME_PREFIX . '_requirement', array(&$this, 'show_requirement_submenu') );
			swlabscore_add_submenu_page( $menu_slug, 'Plugins', 'Plugins', 'manage_options', SWBIGNEWS_THEME_PREFIX .'_plugin', array(&$this, 'show_plugin_submenu') );
			if( is_plugin_active('redux-framework/redux-framework.php') ) {
				swlabscore_add_submenu_page( $menu_slug, 'Theme options', 'Theme options', 'manage_options', "BigNews_options" );
			}
			$plugin = new Swlab_DemoImporterPlugin;
			swlabscore_add_submenu_page( $menu_slug, 'Install Demos', 'Install Demos', 'manage_options', SWBIGNEWS_THEME_PREFIX . '_demo_importer', array($plugin, 'form') );
		}else{
			get_admin_page_title();
		}

		global $submenu; // this is a global from WordPress
		$submenu[$menu_slug][0][0] = 'Welcome';
	}
	function show_plugin_submenu(){
		$this->render( 'plugin');
	}
	
	function show_requirement_submenu(){
		$this->render( 'requirement');
	}
	
	function plugin_link( $item ) {
		$menu_slug = SWBIGNEWS_THEME_PREFIX . '_plugin';
		$return_url = SWBIGNEWS_THEME_PREFIX . '_plugin';
		$installed_plugins = get_plugins();

		$item['sanitized_plugin'] = $item['name'];

		/** We need to display the 'Install' hover link */
		if ( ! isset( $installed_plugins[$item['file_path']] ) ) {
			$actions = array(
				'install' => sprintf(
					'<a href="%1$s" class="button button-primary" title="Install %2$s">Install</a>',
					wp_nonce_url(
						add_query_arg(
							array(
								'page'		  => TGM_Plugin_Activation::$instance->menu,
								'plugin'		=> $item['slug'],
								'plugin_name'   => $item['sanitized_plugin'],
								'plugin_source' => $item['source'],
								'tgmpa-install' => 'install-plugin',
								'tgmpa-nonce' => wp_create_nonce( 'tgmpa-install' ),
								'return_url' => $return_url
							),
							admin_url( TGM_Plugin_Activation::$instance->parent_slug )
						),
						'tgmpa-install'
					),
					$item['sanitized_plugin']
				),
			);
		}
		/** We need to display the 'Activate' hover link */
		elseif ( is_plugin_inactive( $item['file_path'] ) ) {
			$actions = array(
				'activate' => sprintf(
					'<a href="%1$s" class="button button-primary" title="Activate %2$s">Activate</a>',
					add_query_arg(
						array(
							'plugin'			   => $item['slug'],
							'plugin_name'		  => $item['sanitized_plugin'],
							'plugin_source'		=> $item['source'],
							'shw-activate'	   => 'activate-plugin',
							'shw-nonce' => wp_create_nonce( 'shw-activate' ),
						),
						admin_url( 'admin.php?page=' . $menu_slug)
					),
					$item['sanitized_plugin']
				),
			);
		}
		/** We need to display the 'Update' hover link */
		elseif ( version_compare( $installed_plugins[$item['file_path']]['Version'], $item['version'], '<' ) ) {
			$actions = array(
				'update' => sprintf(
					'<a href="%1$s" class="button button-primary" title="Install %2$s">Update</a>',
					wp_nonce_url(
						add_query_arg(
							array(
								'page'		  => TGM_Plugin_Activation::$instance->menu,
								'plugin'		=> $item['slug'],
								'plugin_name'   => $item['sanitized_plugin'],
								'plugin_source' => $item['source'],
								'tgmpa-update' => 'update-plugin',
								'version' => $item['version'],
								'tgmpa-nonce' => wp_create_nonce( 'tgmpa-update' ),
								'return_url' => $return_url
							),
							admin_url( TGM_Plugin_Activation::$instance->parent_slug )
						),
						'tgmpa-install'
					),
					$item['sanitized_plugin']
				),
			);
		} elseif ( is_plugin_active( $item['file_path'] ) ) {
			if( $item['slug'] == 'swlabs-core' ){
				$return_url = admin_url( 'plugins.php');
			} else {
				$return_url = admin_url( 'admin.php?page=' . $menu_slug);
			}

			$actions = array(
				'deactivate' => sprintf(
					'<a href="%1$s" class="button button-primary" title="Deactivate %2$s">Deactivate</a>',
					add_query_arg(
						array(
							'plugin'			=> $item['slug'],
							'plugin_name'		  => $item['sanitized_plugin'],
							'plugin_source'		=> $item['source'],
							'shw-deactivate'	   => 'deactivate-plugin',
							'shw-nonce' => wp_create_nonce( 'shw-deactivate' ),
							'return_url' => $return_url
						),
						$return_url
					),
					$item['sanitized_plugin']
				),
			);
		}

		return $actions;
	}
	/**
	 * let_to_num function.
	 *
	 * This function transforms the php.ini notation for numbers (like '2M') to an integer.
	 *
	 * @param $size
	 * @return int
	 */
	function let_to_num( $size ) {
		$l   = substr( $size, -1 );
		$ret = substr( $size, 0, -1 );
		switch ( strtoupper( $l ) ) {
			case 'P':
				$ret *= 1024;
			case 'T':
				$ret *= 1024;
			case 'G':
				$ret *= 1024;
			case 'M':
				$ret *= 1024;
			case 'K':
				$ret *= 1024;
		}
		return $ret;
	}
	/**
	 * action using generate inline css
	 * @param string $custom_css
	 */
	public function add_inline_style( $custom_css ) {
		wp_enqueue_style('swbignews-custom-inline', SWBIGNEWS_PUBLIC_URI . '/css/custom-inline.css');
		wp_add_inline_style( 'swbignews-custom-inline', $custom_css );
	}
}