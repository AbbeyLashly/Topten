<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */
get_header();
?>

<!-- Content section -->
<div class="container">
	<div class="content-404">
		<div class="error-404"><?php echo esc_html( Swbignews::get_option( 'shw-404-title' ) ) ?></div>
		<div class="error-name"><?php echo esc_html( Swbignews::get_option('shw-404-subtitle') ) ?></div>
		<div class="description"><?php echo nl2br( wp_kses_post( Swbignews::get_option('shw-404-desc') ) )?></div>
		<a href="<?php echo esc_url(home_url('/'))?>" class="btn btn-default"><?php echo esc_html( Swbignews::get_option('shw-404-backhome') )?></a>
	</div>
</div>
<?php get_footer(); ?>