<?php
/**
 * The default template for displaying content-single-video
 *
 * Used for single.
 *
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */
if( Swbignews::get_option('shw-post-layout') == 4 ){
?>
<div class="video-top-wrapper shw-shortcode">
	<div class="video-top-content">
		<div class="media">
			<div class="media-left">
			<?php
			do_action( 'swbignews_entry_video');
			?>
			</div>
			<div class="media-body video-description">
				<?php the_title( '<h3 class="title">', '</h3>' ); ?>
				<div class="info-news">
					<div class="pull-left entry-meta">
						<?php do_action( 'swbignews_entry_meta' );?>
					</div>
				</div>
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
<?php
}
else{
	if( Swbignews::get_option('shw-post-layout') !=3 ) :
		the_title( '<h1 class="title-news">', '</h1>' );
		do_action('swbignews_single_meta');
		if( Swbignews::get_option('shw-post-layout') == 2 ){
			do_action( 'swbignews_entry_video');
		}
	endif;
	echo'<div class="main-news"><div class="entry-content">';
		the_content( sprintf( '<a href="%s"><button class="btn-readmore">%s</button></a>',
						get_permalink(),
						Swbignews_Translate::_swt( 'Read more')
		) );
		wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . Swbignews_Translate::_swt( 'Pages:' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
	echo '</div></div>';
}
if(class_exists('SwlabsCore_Block')) :
	$model = new SwlabsCore_Block;
?>
	<div class="video-link-wrapper">
		<ul role="tablist" class="nav nav-tabs list-panel-videos">
			<li role="presentation" class="active">
				<a href="#lastest" aria-controls="lastest" role="tab" data-toggle="tab" class="heading-title">
					<?php Swbignews_Translate::_swte( 'Lastest videos' ); ?></a>
			</li>
			<li role="presentation">
				<a href="#popular" aria-controls="popular" role="tab" data-toggle="tab" class="heading-title">
					<?php Swbignews_Translate::_swte( 'Popular videos' ); ?></a>
			</li>
		</ul>
		<div class="video-link-content tab-content layout-media-horizontal">
			<div id="lastest" role="tabpanel" class="tab-pane fade in active">
				<?php
					$model->get_single_video('lastest');
				?>
			</div>
			<div id="popular" role="tabpanel" class="tab-pane fade">
				<?php 
					$model->get_single_video('popular');
				?>
			</div>
		</div>
		<?php if( is_single() ):?>
			<?php do_action( 'swbignews_post_author' );?>
		<?php endif;?>
	</div>
<?php endif;?>