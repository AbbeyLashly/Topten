<?php
/**
 * The template for displaying Search Results pages
 * 
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */

$all_container_css = swbignews_get_container_css();
extract($all_container_css);

if(get_post_type() == "page") {
	$css = '
	#wrapper #content-wrapper {
		padding-top: 80px;
		padding-bottom: 80px;
	}';
	do_action( 'swbignews_add_inline_style', $css);
}
get_header();
?>
<div class="<?php echo esc_attr( $container_css );?>">
	<div class="row mbxxl">
		<div id="page-content" class="list-page-vertical-1 list-page-border shw-shortcode <?php echo esc_attr( $content_css ); ?>">
			<div class="section-name"><div class="pull-left"><?php echo Swbignews_Translate::_swt( 'Search') ?></div></div>
			<div class="search-page">
				<?php if ( have_posts() ) : ?>
				<?php do_action( 'swbignews_show_searchform' ); ?>
				<div class="layout-media-horizontal row list-page-2">
					<!-- The loop -->
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'inc/content-search', get_post_format() ); ?>
					<?php endwhile; ?>
				</div>
				<?php echo swbignews_paging_nav(); ?>
				<?php else : ?>
					<?php get_template_part( 'inc/content', 'none' ); ?>
				<?php endif; ?>
			</div>
		</div>
		<?php if ( $sidebar != 'none' ) { ?>
			<div id='page-sidebar' class="<?php echo esc_attr( $sidebar_css ); ?>">
				<?php swbignews_get_sidebar($sidebar_id);?>
			</div>
		<?php } ?>
	</div>
</div>
<?php get_footer();?>