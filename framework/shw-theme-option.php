<?php
/**
 * Dynamic css from theme options - Output will be included into end of head tag
 *
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */
function swbignews_dynamic_css() {

	// init
	global $swbignews_options;
	$content = "";
	$content_desktop = "";
	// page options
	do_action('swbignews_page_options');

	$content_ptop		= '';
	$content_pbottom	= '';
	if ( isset($swbignews_options['shw-content-padding-top']) ) {
		$content_ptop   	= $swbignews_options['shw-content-padding-top'];
	}
	if ( isset($swbignews_options['shw-content-padding-bottom']) ) {
		$content_pbottom   	= $swbignews_options['shw-content-padding-bottom'];
	}

	if( is_numeric( $content_ptop ) ) {
		$content_ptop = 'padding-top:'.esc_attr($content_ptop).'px;';
	} else {
		$content_ptop = '';
	}
	if( is_numeric( $content_pbottom ) ) {
		$content_pbottom = 'padding-bottom:'.esc_attr($content_pbottom).'px;';
	} else {
		$content_pbottom = '';
	}

	$content .= '#page-content{'.esc_attr($content_ptop).esc_attr($content_pbottom).'}';

	/* Layout setting */
	$boxed_layout 		= $swbignews_options['shw-layout'];
	$boxed_width  		= $swbignews_options['shw-layout-boxed-width'];
	$boxed_bg     		= $swbignews_options['shw-layout-boxed-background'];

	if ( $boxed_width != '' ) {
		$content .= 'body .layout-boxed {width: ' .esc_attr($boxed_width['width']). ';}';
	}
	$bg_image = '';
	if( $boxed_bg['background-image'] ) {
		$bg_image = 'background-image: url("' .esc_url($boxed_bg['background-image']). '");';
	}
	if ( !empty($boxed_bg) ) {
		$content .= 'body {background-color: ' .esc_attr($boxed_bg['background-color']). ';'. $bg_image .'background-repeat: ' .esc_attr($boxed_bg['background-repeat']). ';background-attachment: ' .esc_attr($boxed_bg['background-attachment']). ';background-position:'.esc_attr($boxed_bg['background-position']).';background-size:'.esc_attr($boxed_bg['background-size']).';}';
	}

	/* Header top */
	$headertop_bg 			= $swbignews_options['shw-headertop-bg'];
	$headertop_color		= $swbignews_options['shw-headertop-text'];
	if ( !empty($headertop_bg) ) {
		$content .= '.header-topbar{background-color: '.esc_attr($headertop_bg['rgba']).'}';
		$content .= '.topbar-search .search-form input{background-color: rgba(0, 0, 0, 0.05);}';
		$content .= '.topbar-social > ul > li > a{background-color: rgba(0, 0, 0, 0.05);}';
		$content .= '.topbar-actions > ul > li > a{background-color: rgba(0, 0, 0, 0.05);}';
	}
	if ( !empty($headertop_color) ) {
		$content .= '.shw-text-info, .topbar-links ul > li > a, .topbar-actions > ul > li > a {color:'.esc_attr($headertop_color['rgba']).'}';
	}

	/*Setting banner*/
	$banner_header_pd 			= $swbignews_options['shw-spacing-banner-header'];
	$banner_sidebar_pd 			= $swbignews_options['shw-spacing-banner-sidebar'];

	$content_desktop .= '#wrapper .header-bg-wrapper #header-bg{ margin-top:'.esc_attr($banner_header_pd['margin-top']).';margin-bottom:'.esc_attr($banner_header_pd['margin-bottom']).'; margin-left:'.esc_attr($banner_header_pd['margin-left']).'; margin-right:'.esc_attr($banner_header_pd['margin-right']).';}';
	$content_desktop .= '#wrapper .header-bg-wrapper #header-bg{ margin-top:'.esc_attr($banner_sidebar_pd['margin-top']).';margin-bottom:'.esc_attr($banner_sidebar_pd['margin-bottom']).'; margin-left:'.esc_attr($banner_sidebar_pd['margin-left']).'; margin-right:'.esc_attr($banner_sidebar_pd['margin-right']).';}';

	/* Menu */
	$menu_bg 				= $swbignews_options['shw-menu-item-bg'];
	$menu_text 				= $swbignews_options['shw-menu-item-text'];
	$menu_padding     		= $swbignews_options['shw-menu-padding'];
	$submenu_icon			= Swbignews::get_value( $swbignews_options, 'shw-submenu-icon' );
	$submenu_bg       		= $swbignews_options['shw-submenu-bg'];
	$submenu_width			= $swbignews_options['shw-submenu-width'];
	$submenu_border   		= $swbignews_options['shw-submenu-border'];
	$submenu_color    		= $swbignews_options['shw-submenu-color'];
	$submenu_padding  		= $swbignews_options['shw-submenu-padding'];
	$submenu_icon_show	  	= $swbignews_options['shw-submenu-icon-show'];
	$megamenu_bg			= $swbignews_options['shw-megamenu-bg'];
	$megamenu_color			= $swbignews_options['shw-megamenu-color'];
	$megamenu_border		= $swbignews_options['shw-megamenu-border'];
	$megamenu_item_border	= $swbignews_options['shw-megamenu-item-border'];

	if ( $swbignews_options['shw-menu-custom'] == '1' ) {
		$content .= '.header-menu .menu > li > .list-main-menu        {background-color:'.esc_attr($menu_bg['regular']).';color:'.esc_attr($menu_text['regular']).';padding-top:'.esc_attr($menu_padding['padding-top']).';padding-bottom:'.esc_attr($menu_padding['padding-bottom']).';}';
		$content .= '.header-menu .menu > li.open > .list-main-menu, header-menu .menu > li.open > .list-main-menu:hover {background-color:'.esc_attr($menu_bg['hover']).';color:'.esc_attr($menu_text['hover']).'}';
		$content .= '.header-menu .menu > li.active > .list-main-menu, header-menu .menu > li > .list-main-menu:focus {background-color:'.esc_attr($menu_bg['active']).';color:'.esc_attr($menu_text['active']).'}';
	}

	if ( $submenu_icon_show == '0' ) {
		$content .= '.dropdown-menu-st-1 a i{display:none;}';
		$content .= '.mega-menu-full .dropdown-menu .mega-menu li .tag-hover i{opacity:0;width:0;}';
	}
	if ( $swbignews_options['shw-submenu-custom'] == '1') {
		$content .= '.dropdown-basic .dropdown-menu.dark{background-color:'.(isset($submenu_bg['rgba'])?$submenu_bg['rgba']:'').';width:'.esc_attr($submenu_width['width']).'}';
		$content .= '.dropdown-basic .dropdown-menu.dark li .tag-hover{background-color:'.esc_attr($submenu_bg['rgba']).';}';
		$content .= '.dropdown-basic .dropdown-menu.dark li .tag-hover{border-bottom:'.esc_attr($submenu_border['border-bottom']).' '.esc_attr($submenu_border['border-style']).' '.esc_attr($submenu_border['border-color']).';'
																	.'padding-right:'.esc_attr($submenu_padding['padding-right']).';padding-left:'.esc_attr($submenu_padding['padding-left']).';'
																	.'padding-top:'.esc_attr($submenu_padding['padding-top']).';padding-bottom:'.esc_attr($submenu_padding['padding-bottom']).';}';
		$content .= '.dropdown-basic .dropdown-menu.dark li .tag-hover{color:'.esc_attr($submenu_color['regular']).';}';
		$content .= '.dropdown-basic .dropdown-menu.dark li .tag-hover:hover{color:'.esc_attr($submenu_color['hover']).';}';
	}
	$bg_image = '';
	if( $megamenu_bg['background-image'] ) {
		$bg_image = 'background-image: url("' .esc_url($megamenu_bg['background-image']). '");';
	}
	if ( $swbignews_options['shw-megamenu-custom'] == '1') {
		$content .= '.mega-menu-full .dropdown-menu.dark{background-color:'.esc_attr($megamenu_bg['background-color']).';' . $bg_image . 'background-repeat:' .esc_attr($megamenu_bg['background-repeat']). ';background-attachment:' .esc_attr($megamenu_bg['background-attachment']). ';background-position:'.esc_attr($megamenu_bg['background-position']).'; background-size: '.esc_attr($megamenu_bg['background-size']).'; }';
		$content .= '.mega-menu-full .dropdown-menu.dark .mega-menu li .tag-hover{color:'.esc_attr($megamenu_color['regular']).'}';
		$content .= '.mega-menu-full .dropdown-menu.dark .mega-menu li .tag-hover:hover{color:'.esc_attr($megamenu_color['hover']).'}';
		$content .= '.mega-menu-full .dropdown-menu.dark .mega-menu li .tag-hover:focus{color:'.esc_attr($megamenu_color['active']).'}';
		$content .= '.mega-menu-full .dropdown-menu .mega-menu > .row > [class^="col-"]{border-right:'.esc_attr($megamenu_border['border-right']).' '.esc_attr($megamenu_border['border-style']).' '.esc_attr($megamenu_border['border-color']).';}';
		$content .= '.mega-menu-full .dropdown-menu.dark .mega-menu li .tag-hover{border-bottom:'.esc_attr($megamenu_item_border['border-bottom']).' '.esc_attr($megamenu_item_border['border-style']).' '.esc_attr($megamenu_item_border['border-color']).';}';
		$content .= '.mega-menu-full .dropdown-menu.dark .mega-menu li:last-child > .tag-hover{border-bottom:0}';
	}

	/* Sidebar */
	$sidebar_box_mb = $swbignews_options['shw-sidebar-mb'];
	$sidebar_box_pb = $swbignews_options['shw-sidebar-pb'];
	$sidebar_bb     = $swbignews_options['shw-sidebar-border'];

	if ( $sidebar_box_mb['margin-bottom'] ) {
		$content .= '#page-sidebar .shw-widget{margin-bottom:'.esc_attr($sidebar_box_mb['margin-bottom']).'}';
	}
	if ( $sidebar_box_pb['padding-bottom'] ) {
		$content .= '#page-sidebar .shw-widget{padding-bottom:'.esc_attr($sidebar_box_pb['padding-bottom']).'}';
	}
	if ( $sidebar_bb['border-bottom'] && $sidebar_bb['border-style'] && $sidebar_bb['border-color'] ) {
		$content .= '#page-sidebar .shw-widget{border-bottom:'.esc_attr($sidebar_bb['border-bottom']).' '.esc_attr($sidebar_bb['border-style']).' '.esc_attr($sidebar_bb['border-color']).';}';
	}

	/* Footer */
	$footer_custom 	= $swbignews_options['shw-footer-style'];
	$footer_bg      = $swbignews_options['shw-footer-bg'];
	$footer_mask    = $swbignews_options['shw-footer-mask-bg'];
	$footer_pd      = $swbignews_options['shw-footer-padding'];
	$footer_bg_image = '';
	
	if( $footer_bg['background-image'] ) {
		$footer_bg_image = 'background-image: url("' .esc_url($footer_bg['background-image']). '");';
	}
	if ( $footer_custom == 'custom' ) {
		if ( $footer_bg['background-color'] || $footer_bg['background-image']) {
			$content .= 'footer {background-color: ' .esc_attr($footer_bg['background-color']). ';' . $footer_bg_image . 'background-repeat: ' .esc_attr($footer_bg['background-repeat']). ';background-attachment: ' .esc_attr($footer_bg['background-attachment']). ';background-position:'.esc_attr($footer_bg['background-position']).';background-size:'.esc_attr($footer_bg['background-size']).';}';
		}
		if ( $footer_mask['rgba'] ) {
			$content .= 'footer .custom{background-color:'.esc_attr($footer_mask['rgba']).';}';
		}
	}
	if ( $footer_pd ) {
		$content .= '#footer{padding-top:'.esc_attr($footer_pd['padding-top']).';padding-bottom:'.esc_attr($footer_pd['padding-bottom']).';}';
	}

	/* Footer Bottom */
	$footerbt_border = $swbignews_options['shw-footerbt-border'];
	$footerbt_pd	 = $swbignews_options['shw-footerbt-padding'];
	$content .= 'footer .dark .border-top-1x{border-top:'.esc_attr($footerbt_border['border-top']).' '.esc_attr($footerbt_border['border-style']).' '.esc_attr($footerbt_border['border-color']).';}';
	$content .= 'footer .footer-style-6 .copyright{padding-top:'.esc_attr($footerbt_pd['padding-top']).';padding-bottom:'.esc_attr($footerbt_pd['padding-bottom']).'}';

	/* Blog Display */
	$bloginfo    	= $swbignews_options['shw-bloginfo'];
	$social      	= $swbignews_options['shw-blog-social'];
	$authorbox   	= $swbignews_options['shw-authorbox'];
	$related_post	= $swbignews_options['shw-related-post'];
	if ( $bloginfo['disabled'] ) {
		foreach ($bloginfo['disabled'] as $key => $value) {
			switch ( $key ) {
				case 'author':
					$content .= '.blog-detail .info.info-style-3 .item.author{display:none;}';
					$content .= '.blog-detail .info.info-style-1 .item.author{display:none;}';
					break;

				case 'view':
					$content .= '.blog-detail .info.info-style-3 .item.views{display:none;}';
					$content .= '.blog-detail .info.info-style-1 .item.views{display:none;}';
					break;

				case 'comment':
					$content .= '.blog-detail .info.info-style-3 .item.comments{display:none;}';
					$content .= '.blog-detail .info.info-style-1 .item.comments{display:none;}';
					break;

				case 'date':
					$content .= '.blog-detail .info.info-style-3 .item.date-created{display:none;}';
					$content .= '.blog-detail .info.info-style-1 .item.date-created{display:none;}';
					break;

				case 'category':
					$content .= '.blog-detail .info.info-style-3 .item.category{display:none;}';
					$content .= '.blog-detail .info.info-style-1 .item.category{display:none;}';
					break;

				case 'tag':
					$content .= '.blog-detail .info.info-style-3 .item.tag{display:none;}';
					$content .= '.blog-detail .info.info-style-1 .item.tag{display:none;}';
					break;

				default:
					# code...
					break;
			}
		}
	}

	if ( $social['disabled'] ) {
		foreach ($social['disabled'] as $key => $value) {
			switch ( $key ) {
				case 'facebook':
					$content .= '.article-info.bars .social-icon-sharing > li.facebook{display:none;}';
					break;

				case 'twitter':
					$content .= '.article-info.bars .social-icon-sharing > li.twitter{display:none;}';
					break;

				case 'googleplus':
					$content .= '.article-info.bars .social-icon-sharing > li.googleplus{display:none;}';
					break;

				case 'pinterest':
					$content .= '.article-info.bars .social-icon-sharing > li.pinterest{display:none;}';
					break;

				case 'instagram':
					$content .= '.article-info.bars .social-icon-sharing > li.instagram{display:none;}';
					break;

				case 'dribbble':
					$content .= '.article-info.bars .social-icon-sharing > li.dribbble{display:none;}';
					break;

				default:
					# code...
					break;
			}
		}
	}

	if ( $authorbox == '0' ) {
		$content .= '.blog-detail .author-page-detail{display:none;}';
	}

	if ( $related_post == '0' ) {
		$content .= '.blog-detail .related-post-section{display:none;}';
	}

	/* Typography */
	$body_typo      = $swbignews_options['shw-typo-body'];
	$para_typo      = $swbignews_options['shw-typo-p'];
	$h1_typo        = $swbignews_options['shw-typo-h1'];
	$h2_typo        = $swbignews_options['shw-typo-h2'];
	$h3_typo        = $swbignews_options['shw-typo-h3'];
	$h4_typo        = $swbignews_options['shw-typo-h4'];
	$h5_typo        = $swbignews_options['shw-typo-h5'];
	$h6_typo        = $swbignews_options['shw-typo-h6'];
	$text_selection = Swbignews::get_value( $swbignews_options, 'shw-typo-selection' );
	$link_color     = $swbignews_options['shw-link-color'];

	$content .= 'body{font-family:'.esc_attr($body_typo['font-family']).';color:'.esc_attr($body_typo['color']).';font-size:'.esc_attr($body_typo['font-size']).';font-weight:'.esc_attr($body_typo['font-weight']).';font-style:'.esc_attr($body_typo['font-style']).';text-align:'.esc_attr($body_typo['text-align']).';line-height:'.esc_attr($body_typo['line-height']).';}';
	$content .= 'p{font-family:'.esc_attr($para_typo['font-family']).';color:'.esc_attr($para_typo['color']).';font-size:'.esc_attr($para_typo['font-size']).';font-weight:'.esc_attr($para_typo['font-weight']).';font-style:'.esc_attr($para_typo['font-style']).';text-align:'.esc_attr($para_typo['text-align']).';line-height:'.esc_attr($para_typo['line-height']).';}';
	$content .= 'h1{font-family:'.esc_attr($h1_typo['font-family']).';color:'.esc_attr($h1_typo['color']).';font-size:'.esc_attr($h1_typo['font-size']).';font-weight:'.esc_attr($h1_typo['font-weight']).';font-style:'.esc_attr($h1_typo['font-style']).';text-align:'.esc_attr($h1_typo['text-align']).';line-height:'.esc_attr($h1_typo['line-height']).';}';
	$content .= 'h2{font-family:'.esc_attr($h2_typo['font-family']).';color:'.esc_attr($h2_typo['color']).';font-size:'.esc_attr($h2_typo['font-size']).';font-weight:'.esc_attr($h2_typo['font-weight']).';font-style:'.esc_attr($h2_typo['font-style']).';text-align:'.esc_attr($h2_typo['text-align']).';line-height:'.esc_attr($h2_typo['line-height']).';}';
	$content .= 'h3{font-family:'.esc_attr($h3_typo['font-family']).';color:'.esc_attr($h3_typo['color']).';font-size:'.esc_attr($h3_typo['font-size']).';font-weight:'.esc_attr($h3_typo['font-weight']).';font-style:'.esc_attr($h3_typo['font-style']).';text-align:'.esc_attr($h3_typo['text-align']).';line-height:'.esc_attr($h3_typo['line-height']).';}';
	$content .= 'h4{font-family:'.esc_attr($h4_typo['font-family']).';color:'.esc_attr($h4_typo['color']).';font-size:'.esc_attr($h4_typo['font-size']).';font-weight:'.esc_attr($h4_typo['font-weight']).';font-style:'.esc_attr($h4_typo['font-style']).';text-align:'.esc_attr($h4_typo['text-align']).';line-height:'.esc_attr($h4_typo['line-height']).';}';
	$content .= 'h5{font-family:'.esc_attr($h5_typo['font-family']).';color:'.esc_attr($h5_typo['color']).';font-size:'.esc_attr($h5_typo['font-size']).';font-weight:'.esc_attr($h5_typo['font-weight']).';font-style:'.esc_attr($h5_typo['font-style']).';text-align:'.esc_attr($h5_typo['text-align']).';line-height:'.esc_attr($h5_typo['line-height']).';}';
	$content .= 'h6{font-family:'.esc_attr($h6_typo['font-family']).';color:'.esc_attr($h6_typo['color']).';font-size:'.esc_attr($h6_typo['font-size']).';font-weight:'.esc_attr($h6_typo['font-weight']).';font-style:'.esc_attr($h6_typo['font-style']).';text-align:'.esc_attr($h6_typo['text-align']).';line-height:'.esc_attr($h6_typo['line-height']).';}';

	if ( $link_color['regular'] ) {
		$content .= 'a{color:'.esc_attr($link_color['regular']).'}';
		$content .= 'a:hover{color:'.esc_attr($link_color['hover']).'}';
		$content .= 'a:active{color:'.esc_attr($link_color['active']).'}';
	}

	/* Custom Color Hover*/ 
	$shw_page_options  = get_post_meta( get_the_ID(), 'shw_page_options', true );
	if (!empty($shw_page_options) && !empty($shw_page_options['hover_style_color'])) {
		$content .= '#content-wrapper a.title:hover {color: '.esc_attr($shw_page_options['hover_style_color']).'; } ';
		$content .= '#content-wrapper .subtitle:hover {color: '.esc_attr($shw_page_options['hover_style_color']).'; } ';
	} 
	 
	/* Custom  Footer Style Footer padding*/
	$custom_footer_bottom_padding = $swbignews_options['shw-footerbt-padding']; 
	 
	if ($custom_footer_bottom_padding != '') {
		$padding_top =  (!empty($custom_footer_bottom_padding['padding-top'])) ? $custom_footer_bottom_padding['padding-top']: " 0px ";
		$padding_bottom =  (!empty($custom_footer_bottom_padding['padding-bottom'])) ? $custom_footer_bottom_padding['padding-bottom']: " 0px "; 
		$content .= '#footer  .copyright {padding-top: '.esc_attr($padding_top).'; padding-bottom:'.esc_attr($padding_bottom).';}';
	}

	/* Custom  Footer Bottom padding*/
	$custom_footer_padding = $swbignews_options['shw-footer-padding']; 
	if ($custom_footer_padding != '') {
		$padding_top =  (!empty($custom_footer_padding['padding-top'])) ? $custom_footer_padding['padding-top']: " 0px ";
		$padding_bottom =  (!empty($custom_footer_padding['padding-bottom'])) ? $custom_footer_padding['padding-bottom']: " 0px "; 
	}
	/* Custom Footer Bottom Border Top*/
	$custom_footer_border = $swbignews_options['shw-footerbt-border'];
	
	if ($custom_footer_border != '') {
		$pix_border =  (!empty($custom_footer_border['border-top'])) ? $custom_footer_border['border-top']: " 1px ";
		$color_border =  (!empty($custom_footer_border['border-color'])) ? $custom_footer_border['border-color']: " 1px ";
		$style_border =  (!empty($custom_footer_border['border-style'])) ? $custom_footer_border['border-style']: " solid  ";
		$content .= '#footer .copyright{border-top: '.esc_attr($pix_border).' '.esc_attr($style_border).' '.esc_attr($color_border).';}';
	}

	/* End of dynamic CSS */
	echo "<!-- Start Dynamic Styling -->\n<style type=\"text/css\">\n@media screen {" . $content . "}</style> <!-- End Dynamic Styling -->\n";
	echo "<!-- Start Dynamic Styling only for desktop -->\n<style type=\"text/css\">\n@media screen and (min-width: 769px) {" . $content_desktop . "}</style> <!-- End Dynamic Styling only for desktop -->\n";
	/* Custom CSS */
	$custom_css = $swbignews_options['shw-custom-css'];

	if ($custom_css != '') {
		echo "<!-- Custom Styling -->\n<style type=\"text/css\">\n" . esc_attr($custom_css) . "</style>\n";
	}

	/* Custom JS */
	$custom_js = $swbignews_options['shw-custom-js'];

	if ($custom_js != '') {
		echo "<!-- Custom JS -->\n<script type=\"text/javascript\">\n" . $custom_js . "</script>\n";
	}
}

add_action('wp_head', 'swbignews_dynamic_css');

/*
 * Extras Options Not use CSS
 */

/* Sticky header */
$swbignews_options = get_option('swbignews_options');
if ( $swbignews_options ) {
	function swbignews_sticky_class() {
		global $swbignews_options;
		$classes[] = '';
		if ( $swbignews_options['shw-sticky'] == '1') {
			$classes[] = 'sticky-enable';
		}
		return $classes;
	}
	add_filter( 'body_class', 'swbignews_sticky_class' );
}

/* Custom Styles to WordPress Visual Editor */
function swbignews_wpb_mce_buttons_2($buttons) {
	array_unshift($buttons, 'styleselect');
	return $buttons;
}
add_filter('mce_buttons_2', 'swbignews_wpb_mce_buttons_2');

// Callback function to filter the MCE settings
function swbignews_mce_before_init_insert_formats( $init_array ) {
	$init_array['style_formats'] = json_encode( Swbignews::get_params('style_formats') );
	return $init_array;
}
// Attach callback to 'tiny_mce_before_init'
add_filter( 'tiny_mce_before_init', 'swbignews_mce_before_init_insert_formats' );

/* add editor style */
function swbignews_add_editor_styles() {
	add_editor_style( get_template_directory_uri() . '/assets/public/css/custom-editor.css' );
	add_editor_style( get_template_directory_uri() . '/assets/public/libs/bootstrap/css/bootstrap.min.css' );
	add_editor_style( get_template_directory_uri() . '/assets/public/libs/font-awesome/css/font-awesome.min.css' );
}
add_action( 'init', 'swbignews_add_editor_styles' );