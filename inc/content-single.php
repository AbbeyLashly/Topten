<?php
/**
 * The default template for displaying content
 *
 * Used for single.
 *
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */
if( Swbignews::get_option('shw-post-layout')==4 ){
?>
<div class="video-top-wrapper shw-shortcode">
	<div class="video-top-content">
		<div class="media">
			<div class="media-left">
			<?php
				do_action( 'swbignews_entry_thumbnail');
			?>
			</div>
			<div class="media-body video-description">
				<?php the_title( '<h3 class="title">', '</h3>' ); ?>
				<div class="info-news">
					<div class="pull-left entry-meta">
						<?php do_action( 'swbignews__single_meta' );?>
					</div>
				</div>
				<div class="entry-content">
				<?php
					the_content( sprintf( '<a href="%s"><button class="btn-readmore">%s</button></a>',
							get_permalink(),
							Swbignews_Translate::_swt( 'Read more')
					) );
					wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . Swbignews_Translate::_swt( 'Pages:' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
				?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
}
else{
	if( Swbignews::get_option('shw-post-layout') !=3 ) :
		the_title( '<h1 class="title-news">', '</h1>' );
		do_action('swbignews_single_meta');
		if( Swbignews::get_option('shw-post-layout') == 2 ){
			do_action( 'swbignews_entry_thumbnail');
		}
	endif;
	?>
	<div class="main-news">
		<div class="entry-content">
			<?php
				the_content( sprintf( '<a href="%s"><button class="btn-readmore">%s</button></a>',
						get_permalink(),
						Swbignews_Translate::_swt( 'Read more')
				) );
				wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . Swbignews_Translate::_swt( 'Pages:' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
			?>
		</div><!-- .entry-content -->	
	</div>
<?php } ?>
<?php if( is_single() ):?>
	<?php do_action( 'swbignews_post_author' );?>
<?php endif;?>