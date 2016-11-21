<?php
/**
 * The template for displaying posts in the Link post format
 * 
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('media'); ?>>
	<?php do_action( 'swbignews_entry_thumbnail');?>
	<div class="content clearfix">
		<!-- title -->
		<?php
			if ( is_single() ) :
				the_title( sprintf( '<h1><a href="%s">', esc_url( swbignews_get_link_url() ) ), '</a></h1>' );
			else :
				the_title( sprintf( '<a class="title index" href="%s">', esc_url( swbignews_get_link_url() ) ), '</a>' );
			endif;
		?>

		<div class="entry-content">
			<?php
				the_content( sprintf( '<div class="pull-right"><span class="read-more"><a href="%s" class="btn btn-outlined btn-primary">%s<i class="fa fa-plus"></i></a></span></div>',
						get_permalink(),
						Swbignews_Translate::_swt( 'Read more' )
				) );
				wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . Swbignews_Translate::_swt( 'Pages:' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
			?>
		</div><!-- .entry-content -->

		<div class="entry-meta">
			<?php do_action( 'swbignews_entry_meta' );?>
		</div>
	</div>
	<?php if( is_single() ):?>
		<?php do_action( 'swbignews_post_author' );?>
	<?php endif;?>
</div><!-- #post -->