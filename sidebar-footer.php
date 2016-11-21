<?php
/**
 * The Content Sidebar
 * 
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */
$footer_col = Swbignews::get_option('shw-footer-col');
if ( $footer_col == '2' ) {
	$footer_c1_css = 'col-md-6 col-sm-6';
	$footer_c2_css = 'col-md-6 col-sm-6';
	$footer_c3_css = 'hide';
	$footer_c4_css = 'hide';
}
if ( $footer_col == '3' ) {
	$footer_c1_css = 'col-md-4 col-sm-4';
	$footer_c2_css = 'col-md-4 col-sm-4';
	$footer_c3_css = 'col-md-4 col-sm-4';
	$footer_c4_css = 'hide';
}
if ( $footer_col == '4' ) {
	$footer_c1_css = 'col-md-3 prl col-sm-3';
	$footer_c2_css = 'col-md-3 pll prl col-sm-3';
	$footer_c3_css = 'col-md-3 pll col-sm-3';
	$footer_c4_css = 'col-md-3 prl col-sm-3';
}
if ( ! is_active_sidebar( 'shw-sidebar-footer-1' ) &&
	 ! is_active_sidebar( 'shw-sidebar-footer-2' ) &&
	 ! is_active_sidebar( 'shw-sidebar-footer-3' ) &&
	 ! is_active_sidebar( 'shw-sidebar-footer-4' )) {
	return;
}
?>
<div id="footer" class="content-sidebar widget-area"
	role="complementary">
	<div id="section-footer" class="section">
		<div class="container">
			<div class="section-content">
				<div class=row>
					<div class="<?php echo esc_attr( $footer_c1_css ); ?>">
						<?php
						if ( is_active_sidebar( 'swbignews-sidebar-footer-1' ) ) {
							dynamic_sidebar( 'swbignews-sidebar-footer-1' );
						}
						?>
					</div>
					<div class="<?php echo esc_attr( $footer_c2_css ); ?>">
						<?php
						if ( is_active_sidebar( 'swbignews-sidebar-footer-2' ) ) {
							dynamic_sidebar( 'swbignews-sidebar-footer-2' );
						}
						?>
					</div>
					<div class="<?php echo esc_attr( $footer_c3_css ); ?>">
						<?php
						if ( is_active_sidebar( 'swbignews-sidebar-footer-3' ) ) {
							dynamic_sidebar( 'swbignews-sidebar-footer-3' );
						}
						?>
					</div>
					<div class="<?php echo esc_attr( $footer_c4_css ); ?>">
						<?php
						if ( is_active_sidebar( 'swbignews-sidebar-footer-4' ) ) {
							dynamic_sidebar( 'swbignews-sidebar-footer-4' );
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- #content-sidebar -->
