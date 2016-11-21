<?php
/**
 * Theme Customizer
 *
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function swbignews_customize_preview_js() {
	wp_enqueue_script( 'swbignews_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'swbignews_customize_preview_js' );
