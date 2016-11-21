<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the content div and all content after
 *
 * @author Swlabs
 * @since 1.0
 */
?>
    					</div>
    				</div>
    			</div>
    		</div>
    		<!-- FOOTER-->
    		<footer id="footer">
            <?php 
                $footer_tmp  = get_post_meta( get_the_ID(), 'shw_page_options', true );
                $footer_sidebar1 = '';
                $footer_sidebar2 = '';
                $footer_sidebar3 = '';
                $footer_sidebar4 = '';  
                if (!empty($footer_tmp['footer_style_id']) && empty($footer_tmp['footer_default'])) {
                    $footer_style = esc_attr($footer_tmp['footer_style_id']);
                    $footer_sidebar1 = (empty($footer_tmp['footer_sidebar1_id']))? '':esc_attr($footer_tmp['footer_sidebar1_id']); 
                    $footer_sidebar2 = (empty($footer_tmp['footer_sidebar2_id']))? '':esc_attr($footer_tmp['footer_sidebar2_id']); 
                    $footer_sidebar3 = (empty($footer_tmp['footer_sidebar3_id']))? '':esc_attr($footer_tmp['footer_sidebar3_id']); 
                    $footer_sidebar4 = (empty($footer_tmp['footer_sidebar4_id']))? '':esc_attr($footer_tmp['footer_sidebar4_id']);  
                }else{ 
                    $footer_style  = Swbignews::get_option('shw-footer-style'); 
                }  
                if (empty($footer_style)) {
                    $footer_style = 'footer-1';
                } 
                $footer_tmp['footer_default'] = !isset($footer_tmp['footer_default'])? '1' : $footer_tmp['footer_default'];
                do_action('swbignews_show_footerstyle',array('footer_style'=>$footer_style,
                    'footer_sidebar1' => $footer_sidebar1,
                    'footer_sidebar2' => $footer_sidebar2,
                    'footer_sidebar3' => $footer_sidebar3,
                    'footer_sidebar4' => $footer_sidebar4,
                    'footer_default' => esc_attr($footer_tmp['footer_default'])
                    ));
            ?> 
            </footer>
        </div>
        <!-- End #page -->
		<?php if ( Swbignews::get_option('shw-backtotop')) { ?>
		<div id="back-top"><a href="#top"><i class="fa fa-angle-double-up"></i></a></div>
		<?php } ?>
		<?php wp_footer(); ?>
	</body>
</html>