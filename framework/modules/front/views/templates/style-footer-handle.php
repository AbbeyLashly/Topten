<?php 
/**
 * Footer Main
 */ 
$footer_stt = '0';
$footerbt_stt  = '0';
$footer_col = '3';
$footer_css = 'dark';
$footerbt_css  = 'hide';
$bannerft_stt   = '1';
$footer_c1_css  = '';
$footer_c2_css  = '';
$footer_c3_css  = '';
$footer_c4_css  = '';
$footer_bt      = ''; 
$hide = ''; 
$footer_widget_1 = (empty($args['footer_default']) && !empty($args['footer_sidebar1'])) ? esc_attr($args['footer_sidebar1']) : 'swbignews-sidebar-footer-1';
$footer_widget_2 = (empty($args['footer_default']) && !empty($args['footer_sidebar2'])) ? esc_attr($args['footer_sidebar2']) : 'swbignews-sidebar-footer-2';
$footer_widget_3 = (empty($args['footer_default']) && !empty($args['footer_sidebar3'])) ? esc_attr($args['footer_sidebar3']) : 'swbignews-sidebar-footer-3';
$footer_widget_4 = (empty($args['footer_default']) && !empty($args['footer_sidebar4'])) ? esc_attr($args['footer_sidebar4']) : 'swbignews-sidebar-footer-4'; 


if ( Swbignews::get_option('shw-footer') !== null ) {
    $footer_stt = Swbignews::get_option('shw-footer');
}
if ( Swbignews::get_option('shw-footer-style')  !== null  ) {
    $footer_css = Swbignews::get_option('shw-footer-style');
}
if ( Swbignews::get_option('shw-footer-style') == 'custom' ) {
    $footer_css .= ' custom';
}
if (  Swbignews::get_option('shw-footerbt-show')  !== null  ) {
    $footerbt_stt = Swbignews::get_option('shw-footerbt-show');
}
if (  Swbignews::get_option('shw-footer-col')  !== null  ) {
    $footer_col = Swbignews::get_option('shw-footer-col');
}
if ( $footerbt_stt == '1' ) {
    $footerbt_css = '';
} 
if ( $footer_col == '11' ) {
    $footer_c1_css = 'col-md-6 col-md-offset-3 text-center';
    $footer_c2_css = 'hide';
    $footer_c3_css = 'hide';
    $footer_c4_css = 'hide';
}
if ( $footer_col == '1' ) {
    $footer_c1_css = 'col-md-12 col-sm-12';
    $footer_c2_css = 'hide';
    $footer_c3_css = 'hide';
    $footer_c4_css = 'hide';
}
if ( $footer_col == '2' ) {
    $footer_c1_css = 'col-md-6 col-sm-6';
    $footer_c2_css = 'col-md-6 col-sm-6';
    $footer_c3_css = 'hide';
    $footer_c4_css = 'hide';
}
if ( $footer_col == '3' ) {
    $footer_c1_css = 'col-md-3 prn col-sm-4 style-left-right sw_col-md-6-sidebar';
    $footer_c2_css = 'col-md-3 col-sm-4 sw_col-md-6-sidebar';
    $footer_c3_css = 'col-md-4 pln col-sm-4 sw_col-md-6-sidebar';
    $footer_c4_css = 'hide';
    if ($args['footer_style'] == 'footer-2' || $args['footer_style'] == 'footer-3') {
       $footer_c2_css = 'col-md-3 pan col-sm-4 mbxxl sw_col-md-6-sidebar';
    }
    if ($args['footer_style'] == 'footer-4') {
       $footer_c2_css = 'col-md-4 col-sm-4 sw_col-md-6-sidebar';
       $footer_c3_css = 'col-md-3 col-sm-4 sw_col-md-6-sidebar';
    }
    if ($args['footer_style'] == 'footer-6') {
        $footer_c1_css = 'col-md-2 col-sm-3 sw_col-md-6-sidebar';
        $footer_c2_css = 'col-md-4 plxl col-sm-4 sw_col-md-6-sidebar';
        $footer_c3_css = 'col-md-6 plxl col-sm-5 sw_col-md-6-sidebar';
        $hide = ' hide ';
    }
    
}


if ( $footer_col == '4' ) {
    $footer_c1_css = 'col-md-3 col-sm-3 style-left-right sw_col-md-6-sidebar';
    $footer_c2_css = 'col-md-3 col-sm-3 sw_col-md-6-sidebar';
    $footer_c3_css = 'col-md-3 col-sm-3 sw_col-md-6-sidebar';
    $footer_c4_css = 'col-md-3 pln col-sm-3 sw_col-md-6-sidebar';
    $hide  = ' hide ';
}

/**
 * Footer Bottom
 */
if (  Swbignews::get_option('shw-footerbt-layout')  !== null  ) {
    $footerbt = Swbignews::get_option('shw-footerbt-layout');
}

// Content

$copyright = Swbignews::get_option('shw-footerbt-text');
$menu_location = 'bottom-nav' ;
$footerbt_nav = '';
if( has_nav_menu( $menu_location ) ) {
    $walker = new Swbignews_Nav_Walker;
    $footerbt_nav = wp_nav_menu( array(
        'theme_location'    => $menu_location,
        'container'         => 'nav',
        'container_class'   => 'nav-footer',
        'menu_class'        => 'list-inline mbn',
        'echo'              => '0',
        'walker'            => $walker
    ));
}
// Location
$content_array = array(
    'text'      => $copyright,
    'nav'       => $footerbt_nav,
    'none'      => ''
);
$footer_content_one = Swbignews::get_option('shw-footerbt-01');
$footer_content_one = Swbignews::get_value( $content_array, $footer_content_one );
$footer_content_two = Swbignews::get_option('shw-footerbt-02');
$footer_content_two = Swbignews::get_value( $content_array, $footer_content_two );
$footer_content_center = Swbignews::get_option('shw-footerbt-03');
$footer_content_center = Swbignews::get_value( $content_array, $footer_content_center );
$footer_sidebar_arr = array();
for( $i= 1; $i<=4; $i++){
    $footer_sidebar_id = 'swbignews-sidebar-footer-' . esc_attr($i);
    if(   Swbignews::get_option('shw-sidebar-footer-id-' . $i) !== null  && null !== (Swbignews::get_option('shw-sidebar-footer-id-' . $i) ) ) {
        $footer_sidebar_id = Swbignews::get_option('shw-sidebar-footer-id-' . $i);
    }
    $footer_sidebar_arr['sidebar_footer_'.esc_attr($i)] = $footer_sidebar_id;
}

extract($footer_sidebar_arr);
?>