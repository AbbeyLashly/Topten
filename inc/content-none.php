<?php
/**
 * The template for displaying a "No posts found" message
 *
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */
?>

<header class="page-header">
	<h1 class="title"><?php esc_html_e( 'Nothing Found', 'bignews'); ?></h1>
</header>

<div class="page-content">
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

	<p><?php printf( '%1$s <a href="%2$s">%3$s</a>.', esc_html__( 'Ready to publish your first post?', 'bignews' ), admin_url( 'post-new.php' ), esc_html__( 'Get started here' , 'bignews')); ?></p>

	<?php elseif ( is_search() ) : ?>

	<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'bignews' ); ?></p>
	<?php do_action( 'swbignews_show_searchform' ); ?>

	<?php else : ?>

	<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'bignews' ); ?></p>
	<?php get_search_form(); ?>

	<?php endif; ?>
</div><!-- .page-content -->