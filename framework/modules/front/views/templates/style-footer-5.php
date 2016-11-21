<?php  include('style-footer-handle.php');?>
<?php if (Swbignews::get_option('shw-footer') ) { ?>
<div class="footer footer-5">
    <div class="container">
        <div class="sub-footer">
            <div class="row">
                
               <div class="col-md-6 col-md-offset-3 text-center">
                   <div class="logo-small">
                        <a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr(get_bloginfo('description')); ?>">
                        <img src="<?php echo esc_url( Swbignews::get_option('shw-logo-footer','url') ); ?>" alt="<?php echo esc_attr( Swbignews::get_option('shw-logo-alt') ); ?>" title="<?php echo esc_attr( Swbignews::get_option('shw-logo-title') ); ?>" class="img-responsive">
                        </a>
                    </div>
                    <?php  
                        $socials_array = Swbignews::get_params( 'header-social' );   
                        echo '<ul class="list-unstyled list-inline mbl">';
                        foreach ($socials_array as $social_id => $social_name) {  
                            $data_link = Swbignews::get_option('shw-social-' . $social_id ); 
                            if (!empty($data_link)) { 
                                echo '<li >';
                                echo '<a href="' . esc_url($data_link) . '" target="_blank" class="icon-circle">';
                                    if( $social_id == 'google' ) $social_id = 'google-plus';  
                                echo '<i class="fa fa-' . esc_attr($social_id) . ' "></i>';
                                echo '</a>'; 
                                echo '</li>';
                            }
                        }
                        echo '</ul>';
                    ?>
                   <p class="mbx"><?php echo wp_kses_post($footer_content_one) ?></p> 
               </div>
            </div>
        </div> 
    </div>
    <?php if ( Swbignews::get_option('shw-footerbt-show') ) { ?>
    <div class="copyright"> 
        <div class="container"> 
            <?php  
                echo '<div class="text-center">'.wp_kses_post($footer_content_center).'</div>'; 
            ?> 
        </div>
    </div>
    <?php } ?>
</div>
<?php } ?>