<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive.
 *
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class( 'media' ); ?>>
	<?php do_action( 'swbignews_entry_thumbnail');?>
	<div class="content clearfix">
		<!-- title -->
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="title text-center">', '</h1>' );
			else :
				the_title( sprintf( '<a class="title index" href="%s">', esc_url( get_permalink() ) ), '</a>' );
			endif;
		?>
		<div class="entry-meta">
			<?php do_action( 'swbignews_entry_meta' );?>
			<?php 
					if( has_excerpt() ):
						the_excerpt();
					endif;
				?>
		</div>

		<div class="entry-content">
			<?php
				the_content( sprintf( '<a href="%s"><button class="btn-readmore">%s</button></a>',
						get_permalink(),
						Swbignews_Translate::_swt( 'Read more' )
				) );
				wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . Swbignews_Translate::_swt( 'Pages:' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
			?>
		</div><!-- .entry-content -->
	</div>

	<?php if( is_single() ):?>
		<?php do_action( 'swbignews_post_author' );?>
	<?php endif;?>
</div><!-- #post -->