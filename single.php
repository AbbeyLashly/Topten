<?php
/**
 * The template for displaying all single posts.
 * 
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */

$post_type = get_post_type();
$all_container_css = swbignews_get_container_css();
extract($all_container_css);

$template = '';
$no_sidebar = array( 'swlabscore_video' );
if( in_array( $post_type, $no_sidebar ) ) {
	$content_css = 'col-md-12';
	$sidebar_css = 'hide';
	$template = 'video';
}
/**
 * Start Template
 */
get_header(); 
?>

<div class="<?php echo esc_attr( $container_css ); ?> blog-detail">
	<div class="row">
		<?php 
		if ( is_single() && empty($template) ){
			if( Swbignews::get_option( 'shw-post-layout' )==3 ){
				echo '<div class="col-md-12"><div class="content-news section-content">';
				the_title( '<h1 class="title-news">', '</h1>' );
				do_action('swbignews_single_meta');
				if(get_post_format() != 'video'){
					do_action( 'swbignews_entry_thumbnail');
				}
				else{
					do_action( 'swbignews_entry_video');
				}
				echo '</div></div>';
			}
		}
		?>
		<div id="page-content" class="<?php echo esc_attr( $content_css ); ?>">
			<div class="row">
				<div class="col-md-12">
					<?php if ( have_posts() ) : ?>
						<?php /* Custom post type */ ?>
						<?php if ( $post_type != 'post' && $template ) : ?>
							<div class="section-content">
								<?php while ( have_posts() ) : the_post(); ?>
									<?php get_template_part( 'inc/single', $template ); ?>
									<?php
										// If comments are open or we have at least one comment, load up the comment template.
										if ( comments_open() || get_comments_number() ) :
											comments_template();
										endif;
									?>
								<?php endwhile; ?>
							</div>
						<?php else: //single post?>
							<div class="section-content">
								<?php /* The loop */ ?>
								<div class="content-news section-category">
								<?php while ( have_posts() ) : the_post(); ?>
									<?php get_template_part( 'inc/content-single', get_post_format() ); ?>
								<?php endwhile; ?>
								</div>
								<!--Edit here: Move line-->
								<?php swbignews_post_nav(); ?>
								<?php
								if ( is_single() && ( comments_open() || get_comments_number() ) ) :
									echo '<div class="entry-comment">';
									comments_template();
									echo '</div>';
								endif;
								?>
							</div>
							<div class="clear-fix" ></div>
							<?php if( (get_post_format() != 'video') && (Swbignews::get_option('shw-related-post') == '1' ) ): ?>
							<div class="related-post-section">
								<?php
									$block_title = Swbignews_Translate::_swt('RELATED POSTS');
									if( shortcode_exists('swlabscore_block_carousel_sc_1') ) :
										echo do_shortcode( '[swlabscore_block_carousel_sc_1 block_title="'.$block_title.'" show_excerpt="no" show_meta="hide" column="4" post_filter_by="post_same_category" ]' );
									endif;
								?>
							</div>
							<?php endif;?>
						<?php endif;?>
					<?php else : ?>
						<?php get_template_part( 'inc/content', 'none' ); ?>
					<?php endif; // have_posts?>
				</div>
			</div>
		</div><!-- #page-content -->

		<div id='page-sidebar' class="<?php echo esc_attr( $sidebar_css )?>">
			<?php swbignews_get_sidebar($sidebar_id);?>
		</div>

	</div><!-- #row -->
</div>
<?php get_footer(); ?>