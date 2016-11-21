<?php

return array(
	'load' => array(
		// Set up theme

		// Register widgets
		array( 'add_action', 'widgets_init', array(SWBIGNEWS_THEME_CLASS, '[widget.Widget_Init, load]') ),

		// action inline css
		array( 'add_action', 'swbignews_add_inline_style', array(SWBIGNEWS_THEME_CLASS, '[theme.Theme_Init, add_inline_style]') ),

		// Frontend actions
		array( 'add_action', SWBIGNEWS_THEME_PREFIX . '_show_header',       array(SWBIGNEWS_THEME_CLASS, '[front.Top_Controller, header]') ),
		array( 'add_action', SWBIGNEWS_THEME_PREFIX . '_show_headerstyle',   array(SWBIGNEWS_THEME_CLASS, '[front.Top_Controller, headerstyle]') ),
		array( 'add_action', SWBIGNEWS_THEME_PREFIX . '_show_footerstyle',   array(SWBIGNEWS_THEME_CLASS, '[front.Top_Controller, footerstyle]') ),
		array( 'add_action', SWBIGNEWS_THEME_PREFIX . '_page_options',      array(SWBIGNEWS_THEME_CLASS, '[front.Top_Controller, get_page_options]') ),
		array( 'add_action', SWBIGNEWS_THEME_PREFIX . '_show_breadcrumb',   array(SWBIGNEWS_THEME_CLASS, '[front.Top_Controller, breadcrumb]') ),
		array( 'add_action', SWBIGNEWS_THEME_PREFIX . '_entry_thumbnail',   array(SWBIGNEWS_THEME_CLASS, '[front.Top_Controller, show_post_entry_thumbnail]') ),
		array( 'add_action', SWBIGNEWS_THEME_PREFIX . '_entry_meta',        array(SWBIGNEWS_THEME_CLASS, '[front.Top_Controller, show_post_entry_meta]') ),
		array( 'add_action', SWBIGNEWS_THEME_PREFIX . '_post_author',       array(SWBIGNEWS_THEME_CLASS, '[front.Top_Controller, show_post_author]') ),
		array( 'add_action', SWBIGNEWS_THEME_PREFIX . '_show_index',        array(SWBIGNEWS_THEME_CLASS, '[front.Top_Controller, show_post_index]') ),
		array( 'add_action', SWBIGNEWS_THEME_PREFIX . '_show_searchform',   array(SWBIGNEWS_THEME_CLASS, '[front.Top_Controller, show_searchform]') ),
		array( 'add_action', SWBIGNEWS_THEME_PREFIX . '_single_meta',       array(SWBIGNEWS_THEME_CLASS, '[front.Top_Controller, single_meta]') ),
		array( 'add_action', SWBIGNEWS_THEME_PREFIX . '_entry_video',       array(SWBIGNEWS_THEME_CLASS, '[front.Top_Controller, show_post_entry_video]') ),

		array( 'add_action', 'comment_form_top',             array(SWBIGNEWS_THEME_CLASS, '[front.Top_Controller, comment_form_top]') ),
		array( 'add_action', 'comment_form',                 array(SWBIGNEWS_THEME_CLASS, '[front.Top_Controller, comment_form_bottom]') ),
	),
	'init' => array(

		// Regist Menu
		array( 'register_nav_menu', 'top-nav',    esc_html__('Top menu', 'bignews' ) ),
		array( 'register_nav_menu', 'main-nav',   esc_html__('Main menu', 'bignews' ) ),
		array( 'register_nav_menu', 'bottom-nav', esc_html__('Bottom menu', 'bignews' ) ),

		// Ajax
		array( 'add_action', 'wp_ajax_shw',        array( SWBIGNEWS_THEME_CLASS, '[Application, ajax]' ) ),
		array( 'add_action', 'wp_ajax_nopriv_shw', array( SWBIGNEWS_THEME_CLASS, '[Application, ajax]' ) ),

		// Info page
		array( 'add_action', 'admin_menu', array( SWBIGNEWS_THEME_CLASS, '[theme.Theme_Init, add_menu_welcome_pages]' ) ),
		array( 'add_action', 'admin_init', array( SWBIGNEWS_THEME_CLASS, '[theme.Theme_Init, call_tgm_plugin_action]' ) ),

		// Add sidebar area
		array( 'add_action', 'admin_print_scripts',               array( SWBIGNEWS_THEME_CLASS, '[theme.Widget_Init, add_widget_field]' ) ),
		array( 'add_action', 'load-widgets.php',                  array( SWBIGNEWS_THEME_CLASS, '[widget.Widget_Init, add_sidebar_area]')),
		array( 'add_action', 'wp_ajax_shw_delete_custom_sidebar', array( SWBIGNEWS_THEME_CLASS, '[widget.Widget_Init, delete_custom_sidebar]')),
	),
	'front_init' => array(
		array( 'add_filter', 'script_loader_src',  array(SWBIGNEWS_THEME_CLASS, '[theme.Theme_Init, remove_query_strings_1]') ),
		array( 'add_filter', 'style_loader_src',  array(SWBIGNEWS_THEME_CLASS, '[theme.Theme_Init, remove_query_strings_1]') ),
		array( 'add_filter', 'script_loader_src',  array(SWBIGNEWS_THEME_CLASS, '[theme.Theme_Init, remove_query_strings_2]') ),
		array( 'add_filter', 'style_loader_src',  array(SWBIGNEWS_THEME_CLASS, '[theme.Theme_Init, remove_query_strings_2]') ),
	),

	'admin_init' => array(
		// add action
		array( 'add_action', 'save_post',             array( SWBIGNEWS_THEME_CLASS, '[Application, save]' ) ),
		array( 'add_action', 'admin_enqueue_scripts', array( SWBIGNEWS_THEME_CLASS, '[theme.Theme_Init, admin_enqueue]' ) ),
	),

	'save_post' => array(
	),
	'mapping' => array(
		'special_options' => array(
			'header_layout', 'header_top_show', 'header_logo_show', 'header_sticky_enable',
			'footer_show', 'footer_top_show', 'footer_bottom_show',
			'page_title_show', 'breadcrumb_show', 'title_show', 'sub_title_show'
		),
		'no-default-options' => array('no_default'),
		'options' => array(
			'header' => array(
				'header_sticky_enable'         => 'shw-sticky',
				'header_top_bg_color'          => array( 'shw-headertop-bg', 'color' ),
				'header_top_color'             => array( 'shw-headertop-text-', 'color' ),
			),
			'general' => array(
				'background_transparent'   => array( 'shw-layout-boxed-background', 'background-color' ),
				'background_color'         => array( 'shw-layout-boxed-background', 'background-color' ),
				'background_repeat'        => array( 'shw-layout-boxed-background', 'background-repeat' ),
				'background_attachment'    => array( 'shw-layout-boxed-background', 'background-attachment' ),
				'background_position'      => array( 'shw-layout-boxed-background', 'background-position' ),
				'background_size'          => array( 'shw-layout-boxed-background', 'background-size' ),
				'background_image'         => array( 'shw-layout-boxed-background', 'background-image' ),
				'background_image_id'      => array( 'shw-layout-boxed-background', 'media', 'id' ),
			),
			'footer' => array(
				'footer_show'              => 'shw-footer',
				'footer_bottom_show'       => 'shw-footerbt-show',
				'footer_column_id'         => 'shw-footer-col',
				'footer_style_id'          => 'shw-footer-style', 
				'header_style_id'          => 'shw-header', 
			),
			'sidebar' => array(
				'sidebar_layout'           => 'shw-archive-sidebar-layout',
				'sidebar_id'               => 'shw-archive-sidebar',
			), 
			'post' => array(
				'blog_layout'              => 'shw-post-layout',
				'blog_sidebar_layout'      => 'shw-blog-sidebar-layout',
				'blog_sidebar_id'          => 'shw-blog-sidebar',
				'blog_show_related'        => 'shw-related-post',
			),
			'no_default' => array(
				'body_extra_class'         => 'shw-body-extra-class',
				'ct_padding_top'           => 'shw-content-padding-top',
				'ct_padding_bottom'        => 'shw-content-padding-bottom',
				'header_below_navigation'  => 'shw-breakingnews-breadcrumb'
			),
		),
		'post_options' => array(
			'post' => array(
				'blog_layout'              => 'shw-post-layout',
				'blog_sidebar_layout'      => 'shw-blog-sidebar-layout',
				'blog_sidebar_id'          => 'shw-blog-sidebar',
				'blog_show_related'        => 'shw-related-post',
			)
		),
		'bloginfo' => array(
			'show_author'   => array('shw-bloginfo', 'disabled', 'author'),
			'show_date'     => array('shw-bloginfo', 'disabled', 'date'),
			'show_views'    => array('shw-bloginfo', 'disabled','view'),
			'show_comments' => array('shw-bloginfo', 'disabled','comment'),
			'show_category' => array('shw-bloginfo', 'disabled','category'),
			'show_tag'      => array('shw-bloginfo', 'disabled','tag'),
			'show_related'  => 'shw-related',
		),
		'blogcontent' => array(
			'excerpt_length' => 'shw-excerpt-',
			'title_length'   => 'shw-title-',
		),
	),
	'image_sizes' => array(
		'swbignews-thumb-600x450'       => array( 'width' => 600, 'height' => 450 ),
		'swbignews-thumb-360x144'       => array( 'width' => 360, 'height' => 144 ),
		'swbignews-thumb-360x270'       => array( 'width' => 360, 'height' => 270 ),
		'swbignews-thumb-360x180'       => array( 'width' => 360, 'height' => 180 ),
		'swbignews-thumb-360x220'       => array( 'width' => 360, 'height' => 220 ),
		'swbignews-thumb-700x470'       => array( 'width' => 700, 'height' => 470 ),
		'swbignews-thumb-750x370'       => array( 'width' => 750, 'height' => 370 ),
		'swbignews-thumb-750x460'       => array( 'width' => 750, 'height' => 460 ),
		'swbignews-thumb-265x510'       => array( 'width' => 265, 'height' => 510 ),
		'swbignews-thumb-1140x480'      => array( 'width' => 1140, 'height' => 480 ),
		'swbignews-thumb-1140x680'      => array( 'width' => 1140, 'height' => 680 ),
		'swbignews-thumb-600x600'       => array( 'width' => 600, 'height' => 600 ),
		'swbignews-thumb-100x100'       => array( 'width' => 100, 'height' => 100 ),
		'swbignews-thumb-600x470'       => array( 'width' => 600, 'height' => 470 ),
		'swbignews-thumb-600x400'       => array( 'width' => 600, 'height' => 400 ),
		'swbignews-thumb-880x587'       => array( 'width' => 880, 'height' => 587 ),
	),
);