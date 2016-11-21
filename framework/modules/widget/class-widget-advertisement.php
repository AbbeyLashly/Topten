<?php
/**
 * Widget_advertisement class.
 * 
 * @since 1.0
 */

class Swbignews_Widget_Advertisement extends WP_Widget {
	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_advertisement', 'description' => esc_html__( 'The advertisement banner.', 'bignews' ) );
		parent::__construct( 'swbignews_advertisement', esc_html_x( 'SW: Advertisement', 'Advertisement widget', 'bignews' ), $widget_ops );
	}
	function form( $instance ) {
		$widget_default = array(
			'advertisement' => '',
		);
		$instance = wp_parse_args( (array) $instance, $widget_default );
		$advertisement = esc_attr( $instance['advertisement'] );
		$arr_ads = Swbignews::get_params( 'advertisement' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('advertisement') ); ?>"><?php esc_html_e( 'Choose advertisement', 'bignews' );?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('advertisement') ); ?>" name="<?php echo esc_attr( $this->get_field_name('advertisement') ); ?>" >
				<?php
				foreach($arr_ads as $k=>$v){
					if($advertisement == $k) $selected = "selected";
					else $selected = "";
					echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
				}
				?>
			</select>
		</p>
		<?php
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['advertisement'] = strip_tags( $new_instance['advertisement'] );
		return $instance;
	}

	function widget( $args, $instance ) {
		extract ( $args );
		$advertisement = $instance ['advertisement'];
		$widget_id =  Swbignews::make_id();
		echo wp_kses_post( $before_widget );
		$option = swbignews_get_ads_settings($advertisement);
		if($option['ads_display'] != 3){
			$align_cls = '';
			if($advertisement == 'header'){
				$align_cls = ' pull-right';
			}
			else if($advertisement == 'content' || 
					$advertisement == 'content02' || 
					$advertisement == 'content03'){
						$align_cls = ' center';
			}
			printf('<div class="shw-widget-%s">', esc_attr($widget_id));
			if($option['ads_display'] == 1){
				if($option['ads_target']){
					$option['ads_target'] = ' target="new"';
				}
				else{
					$option['ads_target'] = '';
				}
				if(!empty($option['ads_image']['url'])){
					$url = $option['ads_image']['url'];
				}
				else{
					$url = '';
				}
				printf('<div class="banner-adv %s">',esc_attr($align_cls) );
					printf('<a href="%s" title="" %s><img src="%s" alt="%s" class="img-responsive"/></a>',
							esc_url($option['ads_link']),
							esc_attr($option['ads_target']),
							esc_url($url),
							esc_attr($option['ads_alt'])
						);
				echo '</div>';
			}
			else{ 
				printf('<div class="banner-adv %s">%s</div>', $align_cls, $option['ads_code']);
			}
			echo '</div>';
		}
		echo wp_kses_post( $after_widget );
		
		// custom CSS
		if($option['ads_spacing']['margin-left']){
			$margin_left = ' margin-left : '.esc_attr($option['ads_spacing']['margin-left']).';';
		}
		else{
			$margin_left = '';
		}
		if($option['ads_spacing']['margin-top']){
			$margin_top = ' margin-top : '.esc_attr($option['ads_spacing']['margin-top']).';';
		}
		else{
			$margin_top = '';
		}
		if($option['ads_spacing']['margin-right']){
			$margin_right = ' margin-right : '.esc_attr($option['ads_spacing']['margin-right']).';';
		}
		else{
			$margin_right = '';
		}
		if($option['ads_spacing']['margin-bottom']){
			$margin_bottom = ' margin-bottom : '.esc_attr($option['ads_spacing']['margin-bottom']).';';
		}
		else{
			$margin_bottom = '';
		}
		$custom_css = '.shw-widget-'. esc_attr($widget_id).' .banner-adv{'
			.$margin_left
			.$margin_top
			.$margin_right
			.$margin_bottom
		.'}';
		do_action( 'swbignews_add_inline_style', $custom_css );
	}
}