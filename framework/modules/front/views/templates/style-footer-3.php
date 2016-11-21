<?php  include('style-footer-handle.php');?>
<?php if (Swbignews::get_option('shw-footer') ) { ?>
<div class="footer footer-3"> 
    <div class="container">
        <div class="sub-footer">
            <div class="row">
                    <div id="footer_c1" class="footer-area <?php echo esc_attr( $footer_c1_css ); ?>">
                        <?php
                            if(is_active_sidebar($footer_widget_1)){
                                dynamic_sidebar($footer_widget_1);
                            }
                        ?>
                    </div>
                    <div class="col-md-1 pan <?php echo esc_attr( $hide ); ?>"></div>
                    <div id="footer_c2" class="footer-area <?php echo esc_attr( $footer_c2_css ); ?>">
                        <?php
                            if(is_active_sidebar($footer_widget_2)){
                                dynamic_sidebar($footer_widget_2);
                            }
                        ?>
                    </div>
                    <div class="col-md-1 pan <?php echo esc_attr( $hide ); ?>"></div>
                    <div id="footer_c3" class="footer-area <?php echo esc_attr( $footer_c3_css ); ?>">
                        <?php
                            if(is_active_sidebar($footer_widget_3)){
                                dynamic_sidebar($footer_widget_3);
                            }
                        ?>
                        
                    </div>
                    <div id="footer_c4" class="footer-area <?php echo esc_attr( $footer_c4_css ); ?>">
                        <?php
                            if(is_active_sidebar($footer_widget_4)){
                                dynamic_sidebar($footer_widget_4);
                            }
                        ?>
                    </div>
                </div> 
        </div> 
    </div>
    <?php if ( Swbignews::get_option('shw-footerbt-show') ) { ?>
    <div class="copyright"> 
        <div class="container">
            <?php 
                echo '<div class="pull-left">'.wp_kses_post($footer_content_two).'</div>'; 
                echo '<div class="pull-right"><a id="totop" class="totop" href="#"><i class="fa fa-angle-up"></i></a></div>';
            ?>
        </div>
    </div>
    <?php } ?>
</div>
<?php } ?>