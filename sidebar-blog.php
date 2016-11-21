<?php
/**
 * The sidebar containing the main widget area.
 * 
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */

if ( ! is_active_sidebar( 'swbignews-sidebar-blog' ) ) {
	return;
}
?>
<div class="sidebar-wrapper">
	<?php dynamic_sidebar( 'swbignews-sidebar-blog' ); ?>
</div>
