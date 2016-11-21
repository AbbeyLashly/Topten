<?php
/**
 * The default template for displaying content
 *
 * Used for search.
 *
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */
?>
<?php 
$post_href = esc_url( get_permalink() );
?>
<div id="post-<?php the_ID(); ?>" <?php post_class( 'col-sm-12 style-2' ); ?>>
	<div class="media search-post">
		<div class="media-left">
			<a class="media-image" href="<?php echo esc_url($post_href); ?>" >
			<?php 
			$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
			if ( $post_thumbnail_id ) {
				echo wp_get_attachment_image( $post_thumbnail_id, 'swbignews-thumb-360x270', false, array('class' => 'img-responsive') );
			}
			else {
				echo '<img class="img-responsive" src="' . esc_url(SWBIGNEWS_NO_IMG) . '" alt="">';
			}
			?>
			</a>
		</div>
		<div class="media-right">
			<!-- title -->
			<?php the_title( sprintf( '<a class="title" href="%s">', $post_href ), '</a>' ); ?>
			
			<?php if ( 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<div class="info info-style-2">
						<?php do_action( 'swbignews_entry_meta' );?>
					</div>
				</div>
			<?php else : ?>
				<div class="entry-meta">
					<div class="info info-style-2">
						<?php edit_post_link( Swbignews_Translate::_swt( 'Edit' ), '<span class="edit-link"><i class="fa fa-pencil"></i>', '</span>' ); ?>
					</div>
				</div>
			<?php endif; ?>
			
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		</div>
	</div>
</div><!-- #post -->