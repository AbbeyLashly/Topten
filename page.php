<?php
/**
 * The template for displaying all pages.
 *
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */

$all_container_css = swbignews_get_container_css();
extract($all_container_css);

if ( SWBIGNEWS_WOOCOMMERCE_ACTIVE ) {
	if(is_cart() || is_checkout() || is_account_page() || (get_option('woocommerce_thanks_page_id') && is_page(get_option('woocommerce_thanks_page_id')))) {
		$content_css = 'col-md-12';
		$sidebar = 'none';
		$sidebar_css = 'hide';
	}
}

$shw_page_options  = get_post_meta( get_the_ID(), 'shw_page_options', true );

get_header();
?>

<!-- Content section -->
<div class="<?php echo esc_attr($container_css);?>">
	<div class="row">
		<div id="page-content" class="<?php echo esc_attr( $content_css ); ?>">
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
				<?php while ( have_posts() ) : the_post(); ?>
					<?php do_action( 'swbignews_entry_thumbnail');?>
					<div class="section-page-content clearfix ">
						<?php 
							if ( empty( $shw_page_options['show_title'] ) || !$shw_page_options['show_title'] ) {
								the_title( sprintf( '<h1 class="page_title">', esc_url( swbignews_get_link_url() ) ), '</h1>' );
							}
						?>
						<div class="entry-content">
							<?php the_content(); ?>
							<?php
								wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . Swbignews_Translate::_swt( 'Pages:') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
							?>
							<?php edit_post_link( Swbignews_Translate::_swt( 'Edit'), '<footer class="entry-footer"><span class="edit-link"><i class="fa fa-pencil"></i>', '</span></footer>' ); ?>
						</div>
						<?php if ( comments_open() ) :
								echo '<div class="entry-comment">';
									comments_template();
								echo '</div>';
							endif;
						?>
					</div>

				<?php endwhile; // End of the loop. ?>

			</div>
		</div>
		<div id='page-sidebar' class="<?php echo esc_attr( $sidebar_css ); ?>">
			<?php swbignews_get_sidebar($sidebar_id);?>
		</div>
	</div>
</div>
<!-- #section -->
<?php get_footer(); ?>