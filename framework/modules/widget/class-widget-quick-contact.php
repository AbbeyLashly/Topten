<?php
/**
 * Widget_Quick_Contact class.
 * 
 * @since 1.0
 */

class Swbignews_Widget_Quick_Contact extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_quick_contact' , 'description' => esc_html__( 'Quick contact form.', 'bignews' ) );
		parent::__construct( 'swbignews_quick_contact', esc_html_x( 'SW: Quick Contact', 'Quick contact widget', 'bignews' ), $widget_ops );
	}

	function form( $instance ) {
		$default = array( 'title' => 'Quick Contact','contact_form' =>'' );
		$instance = wp_parse_args( (array) $instance, $default );
		$title = esc_attr( $instance['title'] );
		$contact_form = esc_attr( $instance['contact_form'] );
		$contact_form_arr = array();
		$args = array (
			'post_type' => 'wpcf7_contact_form',
			'post_per_page' => -1,
			'status' => 'publish',
		);
		$post_arr = get_posts( $args );
		foreach( $post_arr as $post ){
			$k = ( !empty( $post->post_title ) )? $post->post_title : $post->post_name;
			$contact_form_arr[ $post->ID ] = $k;
		}
		
		//show form
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Title', 'bignews' );?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('contact_form') ); ?>"><?php esc_html_e( 'Contact form shortcode', 'bignews' );?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('contact_form') ); ?>" name="<?php echo esc_attr( $this->get_field_name('contact_form') ); ?>" >
				<?php 
						if ( empty( $contact_form_arr )){
							$contact_form_arr[0]= esc_html__( 'Create at least one contact form', 'bignews' );
						}
						foreach( $contact_form_arr as $k => $v ){
							$selected = "";
							if( $contact_form == $k ){
								$selected = "selected";
							}
							echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
						}
				?>
			</select>
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['contact_form'] = strip_tags( $new_instance['contact_form'] );
		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = esc_html( $instance ['title'] );
		$contact_form = esc_attr( $instance ['contact_form'] );
		echo wp_kses_post( $before_widget );
			if( !empty( $title ) ) {
				echo wp_kses_post( $before_title );
				echo esc_html( $title );
				echo wp_kses_post( $after_title );
			}?>
			<div class="quick-contact-widget widget widget-form">
				<?php if(!empty( $contact_form )) 
					echo do_shortcode('[contact-form-7 id="'.$contact_form.'"]'); ?>
			</div>
		<?php
		echo wp_kses_post( $after_widget );
	}
}