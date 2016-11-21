<?php  include('style-footer-handle.php');?>
<?php if (Swbignews::get_option('shw-footer') ) { ?>
    <div class="footer footer-style-1 footer-1 "> 
        <div class="container">
            <div class="sub-footer">
                <div class="row">
                    <div id="footer_c1" class="footer-area <?php echo esc_attr( $footer_c1_css ); ?>">
                        <?php
                            if ( is_active_sidebar( $footer_widget_1 ) ) {
                                dynamic_sidebar($footer_widget_1);
                            }
                        ?>
                    </div>
                    <div class="col-md-1 pan <?php echo esc_attr( $hide ); ?>"></div>
                    <div id="footer_c2" class="footer-area <?php echo esc_attr( $footer_c2_css ); ?>">
                        <?php
                            if ( is_active_sidebar( $footer_widget_2 ) ) {
                                dynamic_sidebar($footer_widget_2);
                            }
                        ?>
                    </div>
                    <div class="col-md-1 pan <?php echo esc_attr( $hide ); ?>"></div>
                    <div id="footer_c3" class="footer-area <?php echo esc_attr( $footer_c3_css ); ?>">
                        <?php
                            if ( is_active_sidebar( $footer_widget_3 ) ) {
                                dynamic_sidebar($footer_widget_3);
                            }
                        ?>
                    </div>
                    <div id="footer_c4" class="footer-area <?php echo esc_attr( $footer_c4_css ); ?>">
                        <?php
                            if ( is_active_sidebar( $footer_widget_4 ) ) {
                                dynamic_sidebar($footer_widget_4);
                            }
                        ?>
                    </div>
                </div> 
            </div>
            <?php if ( Swbignews::get_option('shw-footerbt-show') ) { ?>
            <div class="copyright">
                <?php 
                    echo '<div class="pull-left">'.wp_kses_post($footer_content_one).'</div>'; 
                    echo '<div class="pull-right">'.wp_kses_post($footer_content_two).'</div>';
                ?>
            </div> 
            <?php } // end footer bt show?> 
        </div>
            
    </div> <!-- end footer-main -->
<?php } ?>