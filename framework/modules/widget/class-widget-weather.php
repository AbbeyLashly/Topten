<?php
/**
 * Widget_Weather class.
 * 
 * @since 1.0
 */

class Swbignews_Widget_Weather extends WP_Widget {
	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_weather', 'description' => esc_html__( 'The weather.', 'bignews' ) );
		parent::__construct( 'swbignews_weather', esc_html_x( 'SW: Weather', 'Weather widget', 'bignews' ), $widget_ops );
	}
	function form( $instance ) {
		$widget_default = array(
			'title'			=> esc_html__( 'Weather', 'bignews' ),
			'location'		=> '',
		);
		$instance = wp_parse_args( (array) $instance, $widget_default );
		$title = $instance['title'];
		$location = $instance['location'];
		?>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Title', 'bignews' );?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('location') ); ?>">
				<?php esc_html_e( 'Location', 'bignews' );?>
				<small>(i.e: Austin, TX or London, UK)</small>
			</label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('location') ); ?>" name="<?php echo esc_attr( $this->get_field_name('location') ); ?>" value="<?php echo esc_attr( $location ); ?>" />
		</p>
		<?php
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['location'] = strip_tags( $new_instance['location'] );
		return $instance;
	}

	function widget( $args, $instance ) {
		extract ( $args );
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$location = $instance['location'];
		$widget_id =  Swbignews::make_id();
		echo wp_kses_post( $before_widget );
		if( !empty( $title ) ) {
			echo wp_kses_post( $before_title );
			echo esc_html( $title );
			echo wp_kses_post( $after_title );
		}
		printf('<div class="section-content">
					<div class="weather-news weather-%s" data-item="%s"></div>
					<div class="clearfix"></div>
				</div>',
				esc_attr( $widget_id ),
				esc_attr( $location )
			);
		echo wp_kses_post( $after_widget );
	}
}