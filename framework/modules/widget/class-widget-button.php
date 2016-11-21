<?php
/**
 * Widget_button class.
 * 
 * @since 1.0
 */

class Swbignews_Widget_Button extends WP_Widget {
	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_button', 'description' => esc_html__( 'A button have link to page.', 'bignews' ) );
		parent::__construct( 'swbignews_button', esc_html_x( 'SW: Button', 'Button widget', 'bignews' ), $widget_ops );
	}
	function form( $instance ) {
		$widget_default = array(
			'button_text' => '',
			'page'  => '',
			'link'  => '',
		);
		$instance = wp_parse_args( (array) $instance, $widget_default );
		$button_text = esc_attr( $instance['button_text'] );
		$page = esc_attr( $instance['page'] );
		$link = esc_attr( $instance['link'] );
		$args = array ('post_type' => 'page');
		$pages = get_pages( $args );
	
		
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id ( 'button_text' ) ); ?>"><?php esc_html_e( 'Enter text of button', 'bignews' ) ?>
			<input type="text" name="<?php echo  esc_attr( $this->get_field_name ( 'button_text' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id ( 'button_text' ) ); ?>" value="<?php echo esc_attr( $button_text ); ?>" class="widefat"/></label>
		</p>
		<label><?php esc_html_e( 'Choose link to page or Other link', 'bignews' ) ?></label>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('page') ); ?>"><?php esc_html_e( 'Link to page', 'bignews' );?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('page') ); ?>" name="<?php echo esc_attr( $this->get_field_name('page') ); ?>" >
				<option value="" ><?php esc_html_e('-All Pages-', 'bignews');?></option>
			<?php foreach ( $pages as $p ) {?>
				<option value="<?php echo ( $p->ID );?>"<?php if( $page == (string)$p->ID ){ echo " selected";}?>><?php echo esc_attr( $p->post_name ); ?></option>
			<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id ( 'link' ) ); ?>"><?php esc_html_e( 'Other link', 'bignews' ) ?>
			<input type="text" name="<?php echo  esc_attr( $this->get_field_name ( 'link' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id ( 'link' ) ); ?>" value="<?php echo esc_url( $link ); ?>" class="widefat"/></label>
		</p>
		<?php
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['button_text'] = strip_tags( $new_instance['button_text'] );
		$instance['page'] = strip_tags( $new_instance['page'] );
		$instance['link'] = strip_tags( $new_instance['link'] );
		return $instance;
	}

	function widget( $args, $instance ) {
		extract ( $args );
		$button_text = $instance['button_text'];;
		$page = $instance['page'];
		$link = $instance['link'];
		$pages = get_pages( $args );
		$page_button_text = '';
		$page_link = '';
		foreach ( $pages as $p ){
			if ( $page == (string)$p->ID ){
				$page_button_text = $p->post_name;
				$page_link = $p->guid;
			}
		}
		if (!empty($link)){
			$page_link = $link;
		}
		echo wp_kses_post( $before_widget );?>
			<div class="footer-content">
				<?php if (!empty( $button_text )){?>
					<a href='<?php echo esc_url( $page_link );?>' class="footer-button border-1x"><?php echo esc_html( $button_text );?></a>
				<?php }?>
			</div>
		<?php
		echo wp_kses_post( $after_widget );
	}
}