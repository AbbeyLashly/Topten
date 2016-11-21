<?php
/**
 * Widget_Contact_Info class.
 * 
 * @since 1.0
 */

class Swbignews_Widget_Contact_Info extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_contact',
			'description' => esc_html__( "The contact information.", 'bignews')
		);
		parent::__construct( 'swbignews_contact_info', esc_html_x( 'SW: Contact Info', 'Contact Info widget', 'bignews' ), $widget_ops );
	}

	function form( $instance ) {
		$default = array(
			'title' => 'CONTACT',
			'style' => 1,
			'description' => '',
			'address' => '',
			'phone' => '',
			'mail' => '',
			'skype' => '',
			'link' => '',
		);
		$instance = wp_parse_args( (array) $instance, $default );
		$title = esc_attr( $instance['title'] );
		$style = esc_attr( $instance['style'] );
		$description = esc_attr( $instance['description'] );
		$address = esc_attr( $instance['address'] );
		$phone = esc_attr( $instance['phone'] );
		$mail = esc_attr( $instance['mail'] );
		$link = esc_attr( $instance['link'] );
		$skype = esc_attr( $instance['skype'] );
		?>
			<p>
				<label for="<?php echo  esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title', 'bignews');?></label>
				<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo  esc_attr( $this->get_field_id('style') ); ?>"><?php esc_html_e('Choose Style', 'bignews');?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name('style') ); ?>" >
					<option value="1"<?php if( $style == 1 ) { echo " selected"; } ?>><?php esc_html_e('Style 1', 'bignews');?></option>
					<option value="2"<?php if( $style == 2 ) { echo " selected"; } ?>><?php esc_html_e('Style 2', 'bignews');?></option>
					<option value="3"<?php if( $style == 3 ) { echo " selected"; } ?>><?php esc_html_e('Style 3', 'bignews');?></option>
					<option value="4"<?php if( $style == 4 ) { echo " selected"; } ?>><?php esc_html_e('Style 4', 'bignews');?></option>
					<option value="5"<?php if( $style == 5 ) { echo " selected"; } ?>><?php esc_html_e('Style 5', 'bignews');?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('description') ); ?>"><?php esc_html_e('Description', 'bignews');?></label>
				<textarea class="widefat" rows="5" id="<?php echo esc_attr( $this->get_field_id('description') ); ?>" name="<?php echo esc_attr( $this->get_field_name('description') ); ?>" ><?php echo esc_textarea( $description ); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('address') ); ?>"><?php esc_html_e('Address', 'bignews');?></label>
				<textarea class="widefat" rows="1" id="<?php echo esc_attr( $this->get_field_id('address') ); ?>" name="<?php echo esc_attr( $this->get_field_name('address') ); ?>" ><?php echo esc_textarea( $address ); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('phone') ); ?>"><?php esc_html_e('Phone', 'bignews');?></label>
				<textarea class="widefat" rows="1" id="<?php  echo esc_attr( $this->get_field_id('phone') ); ?>" name="<?php echo esc_attr( $this->get_field_name('phone') ); ?>" ><?php echo esc_textarea( $phone ); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('mail') ); ?>"><?php esc_html_e('Email', 'bignews');?></label>
				<textarea class="widefat" rows="1" id="<?php echo esc_attr( $this->get_field_id('mail') ); ?>" name="<?php echo esc_attr( $this->get_field_name('mail') ); ?>" ><?php echo esc_textarea( $mail ); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('skype') ); ?>"><?php esc_html_e( 'Skype', 'bignews' );?></label>
				<textarea class="widefat" rows="1" id="<?php echo esc_attr( $this->get_field_id('skype') ); ?>" name="<?php echo esc_attr( $this->get_field_name('skype') ); ?>"><?php echo esc_textarea( $skype ); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('link') ); ?>"><?php esc_html_e( 'Link', 'bignews' );?></label>
				<textarea class="widefat" rows="1" id="<?php echo esc_attr( $this->get_field_id('link') ); ?>" name="<?php echo esc_attr( $this->get_field_name('link') ); ?>"><?php echo esc_textarea( $link ); ?></textarea>
			</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['style'] = strip_tags( $new_instance['style'] );
		$instance['description'] = strip_tags( $new_instance['description'] );
		$instance['address'] = strip_tags( $new_instance['address'] );
		$instance['phone'] = strip_tags( $new_instance['phone'] );
		$instance['mail'] = strip_tags( $new_instance['mail'] );
		$instance['link'] = strip_tags( $new_instance['link'] );
		$instance['skype'] = strip_tags( $new_instance['skype'] );
		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		$default = array(
			'title' => 'CONTACT',
			'style' => 1,
			'description' => '',
			'address' => '',
			'phone' => '',
			'mail' => '',
			'skype' => '',
			'link' => '',
		);
		$instance = wp_parse_args( (array) $instance, $default );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$style = $instance['style'];
		$description = $instance['description'];
		$address = $instance['address'];
		$phone = $instance['phone'];
		$email = $instance['mail'];
		$link = $instance['link'];
		$skype = $instance['skype'];
		echo wp_kses_post($before_widget);
		echo '<div class="footer-contact-info section-category mbn">';
		?>
			<?php if(!empty($title)){ ?>
				<div class="section-name"> 
					<?php echo esc_html( $title );?>
				</div>
			<?php } ?> 
			<div class="section-content">
				<?php if ( $style == 1 )
				{ ?>
					<?php if( !empty( $address ) ){ ?>
						<div class="address">
							<i class="fa fa-map-marker fa-fw mrl"></i>
							<?php echo nl2br( esc_textarea( $address ) ); ?>
						</div>
					<?php } ?>

					<div class="row mbxl"> 
						<?php if( !empty( $phone ) ){ ?>
						<div class="col-md-4"><i class="fa fa-phone fa-fw mrl"></i>
							<?php echo nl2br( esc_textarea( $phone ) ); ?>
						</div>
						<?php } ?>

						<div class="col-md-4 pan"><i class="fa fa-envelope mrm"></i>
							<?php
								$arr_email = preg_split ( '/$\R?^/m', $email );
								foreach( $arr_email as $value ){
									echo '<a class="mail-to" href="mailto:'.esc_url( $value ).'">'.nl2br( esc_attr( $value ) ).'</a>';
								}
							?>
						</div>

						<?php if (!empty($link)) {?>
						<p class="mbl">
							<a href="<?php echo esc_url($link)?>"  class="view-more"><i class="fa fa-angle-double-right mrm"></i><?php echo esc_html__('Read more', 'bignews') ?></a> 
						</p>
						<?php }?>

					</div>
				<?php 
				} elseif ( $style == 2 ) { ?>
					<div class="mbl  text-justify">
						<?php if( !empty( $description ) ){ 
							echo '<div class="footer-description">'.esc_textarea( $description ).'</div>';
						} ?>
					</div>
					<ul class="list-info list-unstyled">
						<li>
							<p><i class="fa fa-envelope-o fa-fw mrl"></i>
								<?php
									$arr_email = preg_split ( '/$\R?^/m', $email );
									foreach( $arr_email as $value ){
										echo '<a href="mailto:'.esc_url( $value ).'">'.nl2br( esc_attr( $value ) ).'</a>';
									}
								?>
							</p>
						</li>

						<?php if( !empty( $phone ) ){ ?>
							<li>
								<p>
									<i class="fa fa-phone fa-fw mrl"></i>
									<?php echo nl2br( esc_textarea( $phone ) ); ?>
								</p>
							</li>
						<?php } ?>

						<?php if( !empty( $address ) ){ ?>
							<li>
								<p>
									<i class="fa fa-map-marker fa-fw mrl"></i>
									<?php echo nl2br( esc_textarea( $address ) ); ?>
								</p>
							</li>
						<?php } ?>
					</ul>

				<!-- Style 2 -->
				<?php } elseif ( $style == 4) {
					 
				 ?> 
					<?php if (!empty($phone)) {?>
					<p>
						<?php  echo esc_html__('Call us ','bignews').nl2br( esc_textarea( $phone ) ); ?>
					</p>
					<?php }?> 
					<?php if( !empty( $email ) ){ ?>
					<p>  <?php $arr_email = preg_split ( '/$\R?^/m', $email );
							foreach( $arr_email as $value ){
								echo  esc_html__('Send an Email on','bignews').nl2br( esc_attr( $value ) ) ;
							} ?>
					 </p> <?php } ?>

					<?php if (!empty($address)) {?>
					<p class="mbl">
						<?php  echo  esc_html__('Visit us ','bignews').nl2br( esc_textarea( $address ) ); ?>
					</p>
					<?php }?>

				<?php } elseif ( $style == 5) {
					 
				 ?> 
					<?php if (!empty($address)) {?> 
					<div class="address">
						<i class="fa fa-map-marker mrm"></i> <?php  echo esc_textarea( $address ); ?>
					</div>  
					<?php }?> 
					<div class="row mbxl">
						<div class="col-md-4"><i class="fa fa-phone mrm"></i><?php 
							if (!empty($phone))  echo esc_textarea($phone) ?> </div>
						<div class="col-md-4 pan"><i class="fa fa-envelope mrm"></i>
							 <?php $arr_email = preg_split ( '/$\R?^/m', $email );
							foreach( $arr_email as $value ){
								echo  esc_attr( $value ) ;
							} ?>
						</div>
						<div class="col-md-4"><i class="fa fa-skype mrm"></i><?php if (!empty($skype))  echo esc_textarea($skype)  ?></div>

					</div> 
				<!-- Style 4 -->
				<?php } else {?>
					<div class="logo-small">
						<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo get_bloginfo('description'); ?>">
							<img src="<?php echo esc_url( Swbignews::get_option('shw-logo-footer','url') ); ?>" alt="<?php echo esc_html__('Site logo','bignews'); ?>" class="img-responsive">
						</a>
					</div>
					<div class="mbl  text-justify">  
						<?php if( !empty( $description ) ){ 
							echo '<div class="footer-description">'.esc_textarea( $description ).'</div>';
						} ?>
					</div>
					<ul class="list-info list-unstyled">
						<?php if( !empty( $email ) ){ ?>
						<li>
							<p><i class="fa fa-envelope-o fa-fw mrl"></i>
								<?php
									$arr_email = preg_split ( '/$\R?^/m', $email );
									foreach( $arr_email as $value ){
										echo '<a href="mailto:'.esc_url( $value ).'">'.nl2br( esc_attr( $value ) ).'</a>';
									}
								?>
							</p>
						</li>
						<?php } ?>
						<?php if( !empty( $phone ) ){ ?>
							<li>
								<p>
									<i class="fa fa-phone fa-fw mrl"></i>
									<?php echo nl2br( esc_textarea( $phone ) ); ?>
								</p>
							</li>
						<?php } ?>

						<?php if( !empty( $address ) ){ ?>
							<li>
								<p>
									<i class="fa fa-map-marker fa-fw mrl"></i>
									<?php echo nl2br( esc_textarea( $address ) ); ?>
								</p>
							</li>
						<?php } ?>
					</ul>
					 <?php if (!empty($link)) {?>
					<p class="mbl">
						<a href="<?php echo esc_url($link)?>"  class="view-more"><i class="fa fa-angle-double-right mrm"></i><?php echo esc_html__('Read more', 'bignews') ?></a> 
					</p>
					<?php }?>
				<?php } ?>
				<!-- Style 3 -->
			</div>

		<?php
		echo wp_kses_post($after_widget);
		echo '</div>';
	}
}
