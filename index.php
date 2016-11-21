<?php
/**
 * Index
 * 
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */
$all_container_css = swbignews_get_container_css();
extract($all_container_css);

get_header();
?>
<div class="<?php echo esc_attr( $container_css );?>">
	<div class="row">
		<div id="page-content" class="list-page-vertical-1 list-page-border shw-shortcode <?php echo esc_attr( $content_css ); ?>">
			<div class="section-name"><div class="pull-left"></div></div>
			<?php if ( have_posts() ) : ?>
			<div class="section-content">
				<div class="layout-media-vertical row">
					<div class="col-sm-12 style-1">
					<!-- The loop -->
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'inc/content', get_post_format() ); ?>
					<?php endwhile; ?>
					<?php echo swbignews_paging_nav(); ?>
					</div>
				</div>
			</div>
			<?php else : ?>
				<?php get_template_part( 'inc/content', 'none' ); ?>
			<?php endif; ?>
		</div>
		<?php if ( $sidebar != 'none' ) { ?>
			<div id='page-sidebar' class="<?php echo esc_attr( $sidebar_css ); ?>">
				<?php swbignews_get_sidebar($sidebar_id);?>
			</div>
		<?php } ?>
	</div>
</div>
<?php get_footer();?>