<?php
/**
 * Widget_Livescore class.
 * 
 * @since 1.0
 */

class Swbignews_Widget_Livescore extends WP_Widget {
	public function __construct() {
		$widget_ops = array( 'classname' => 'livescore-table ', 'description' => esc_html__( 'The livescore.', 'bignews' ) );
		parent::__construct( 'widget_livescore', esc_html_x( 'SW: Livescore', 'Livescore league widget', 'bignews' ), $widget_ops );
	}
	function form( $instance ) {
		$widget_default = array(
			'title'			=> esc_html__( 'Livescore Football', 'bignews' ),
			'league'		=> ''
		);
		$instance = wp_parse_args( (array) $instance, $widget_default );
		$leagues =  Swbignews::get_params('league_options');
		extract($instance);
		?> 
	 	<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Title: ', 'bignews' );?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('league') ); ?>"><?php esc_html_e( 'Select League', 'bignews' );?></label>
			<?php
			printf (
				'<select multiple="multiple" name="%s[]" id="%s" class="widefat" >',
				$this->get_field_name('league'),
				$this->get_field_id('league')
			);
			printf(
					'<option value="'.esc_html__('all','bignews').'"  %s >'. esc_html__('All', 'bignews') .'</option>',
					in_array( 'all', $league) ? 'selected="selected"' : ''
				); 
			foreach( $leagues  as $key => $value ){
				printf(
					'<option value="%s"   %s >%s</option>',
					$key,
					in_array( $key, $league) ? 'selected="selected"' : '',
					$value
				);
			}
			echo '</select>';?>
		</p>

		<?php
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['league'] = esc_sql( $new_instance['league'] );
		return $instance;
	}

	function widget( $args, $instance ) {
		extract ( $args );
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		unset($instance['title']);
		echo wp_kses_post($before_widget);
		if(!empty($title)){
			echo '<div class="heading">';
			echo esc_html( $title );
			echo '</div>';
		}
		$leagues = $instance ['league']; ?>
		<div data-league='<?php echo json_encode($leagues)?>' class="carousel slide" data-interval="false">
			<div class="carousel-inner" >
		 		<div class="item">
					<img src="<?php echo esc_url(SWLABSCORE_ASSET_URI); ?>/images/icons/loading.gif"  class="image-loading">
				</div>
			</div>
		</div>
		<?php
		echo wp_kses_post($after_widget);
	}
}