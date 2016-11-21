<?php
/**
 * Header template.
 * 
 * @author Swlabs
 * @since 1.0
 */

// Global variable from theme option
do_action('swbignews_page_options');

// Page classes
$page_class = '';

//Layout boxed
if ( Swbignews::get_option('shw-layout') == '2' ) {
	$page_class .= 'layout-boxed';
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		<link rel="shortcut icon" href="<?php echo esc_url( Swbignews::get_option('shw-favicon','url') ); ?>" />
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<div id="page" class="site <?php echo esc_attr( $page_class );?>">
			<!-- HEADER-->
			<?php		
			do_action('swbignews_show_headerstyle');?>

			<div class="clearfix"></div>
			<!-- WRAPPER-->
			<div id="content-wrapper">
				<!-- PAGE WRAPPER-->
				<div id="page-wrapper">
					<!-- MAIN CONTENT-->
					<div class="main-content">
						<!-- CONTENT-->
						<div class="content">
