<?php
/**
 * Widget_Social_Counter class.
 * 
 * @since 1.0
 */

class Swbignews_Widget_Social_Counter extends WP_Widget {
	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_social_counter', 'description' => esc_html__( 'The social counter.', 'bignews' ) );
		parent::__construct( 'swbignews_social_counter', esc_html_x( 'SW: Social Counter', 'Social Counter widget', 'bignews' ), $widget_ops );
	}
	function form( $instance ) {
		$widget_default = array(
			'title'			=> esc_html__('Social Counter', 'bignews' ),
			'facebook'		=> '',
			'instagram'		=> '',
			'google'		=> '',
			'soundcloud'	=> '',
			'rss'			=> '',
			'twitter'		=> '',
			'youtube'		=> '',
			'vimeo'			=> ''
		);
		$instance = wp_parse_args( (array) $instance, $widget_default );
		unset($instance['fields']);
		foreach($instance as $k=>$v){
			if($k == 'title' ){
				$title = ucfirst($k);
			}
			else if($k == 'google'){
				$title = ucfirst($k).' Plus ID :';
			}
			else if($k == 'rss'){
				$title = strtoupper($k).' User :';
			}
			else {
				$title = ucfirst($k).' User :';
			}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id ( $k ) ); ?>">
				<?php echo esc_attr( $title) ?>
				<input type="text" name="<?php echo  esc_attr( $this->get_field_name ( $k ) ); ?>" 
					id="<?php echo esc_attr( $this->get_field_id ( $k ) ); ?>" 
					value="<?php echo esc_attr( $v ); ?>" class="widefat"/>
			</label>
		</p>
		<?php
		}
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
		$instance['youtube'] = strip_tags( $new_instance['youtube'] );
		$instance['vimeo'] = strip_tags( $new_instance['vimeo'] );
		$instance['google'] = strip_tags( $new_instance['google'] );
		$instance['instagram'] = strip_tags( $new_instance['instagram'] );
		$instance['soundcloud'] = strip_tags( $new_instance['soundcloud'] );
		$instance['rss'] = strip_tags( $new_instance['rss'] );
		return $instance;
	}

	function widget( $args, $instance ) {
		extract ( $args );
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		unset($instance['title']);
		echo wp_kses_post( $before_widget );
		if( !empty( $title ) ) {
			echo wp_kses_post( $before_title );
			echo esc_html( $title );
			echo wp_kses_post( $after_title );
		}
		$social_api = new SwlabsCore_Social_Api();
		$socials_array = Swbignews::get_params( 'social-counter' );
		echo '<ul class="social-connected">';
		foreach ($socials_array as $social_id => $social_name) { 
			if (isset($instance[$social_id]) && !empty($instance[$social_id])) {
				$social_network_meta = swbignews_get_social_network_meta($social_id, $instance[$social_id], $social_api);
				echo '<li>';
				echo '<a href="' . esc_url($social_network_meta['url']) . '" target="_blank" class="' . esc_attr($social_id) . '">';
				if( $social_id == 'google' ) $social_id = 'google-plus';
				echo '<i class="fa fa-' . esc_attr($social_id) . '"></i>';
				echo '</a>';
				echo '<div class="detail">';
				echo '<strong>' . esc_html(number_format($social_network_meta['api'])) . '</strong>';
				echo '<span>' . esc_html($social_network_meta['text']) . '</span>';
				echo '</div>';
				echo '</li>';
			}
		}
		echo '</ul>';
		echo wp_kses_post( $after_widget );
	}
}?>
