<?php
/**
 * Widget_Survey class.
 * 
 * @since 1.0
 */
class Swbignews_Widget_Survey extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_survey', 'description' => esc_html__( "The survey.", 'bignews') );
		parent::__construct( 'swbignews_survey', esc_html_x( 'SW: Survey', 'Survey widget', 'bignews' ), $widget_ops );
	}
	function form( $instance ) {
		$default = array(
			'survey' => '',
		);
		$instance = wp_parse_args( (array) $instance, $default );
		$survey = esc_attr( $instance['survey'] );
		$arr_survey = array();
		$args = array(
			'posts_per_page'   => -1,
			'post_type'        => 'awesome-surveys',
			'post_status'      => 'publish'
		);
		$posts = get_posts( $args );
		foreach($posts as $post){
			$k = (!empty($post->post_title))? $post->post_title : $post->post_name;
			$arr_survey[$post->ID] = $k;
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('survey') ); ?>"><?php esc_html_e( 'Choose survey', 'bignews' );?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('survey') ); ?>" name="<?php echo esc_attr( $this->get_field_name('survey') ); ?>">
				<?php if(empty($arr_survey)){
						echo '<option value=""></option>';
					}
					else{
						foreach($arr_survey as $k=>$v){
							if($survey == $k) $selected = "selected";
							else $selected = "";
							echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
						}
					}
				?>
			</select>
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['survey'] = strip_tags( $new_instance['survey'] );
		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		$survey = $instance['survey'];
		echo wp_kses_post( $before_widget );
		?>
		<div class="survey-widget shw-widget">
			<?php if(!empty( $survey )) 
				echo do_shortcode('[wwm_survey id="'.$survey.'"]'); ?>
		</div>
		<?php
		echo wp_kses_post( $after_widget );
	}
}