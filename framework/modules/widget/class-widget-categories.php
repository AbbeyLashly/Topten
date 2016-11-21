<?php
/**
 * Widget_Categories class.
 * 
 * @since 1.0
 */

class Swbignews_Widget_Categories extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_sw_categories', 'description' => esc_html__( "A list of categories.", 'bignews') );
		parent::__construct( 'swbignews_categories', esc_html_x( 'SW: Categories', 'Categories  widget', 'bignews' ), $widget_ops );
	}

	function form( $instance ) {
		$default = array(
			'title' => esc_html__( 'Categories', 'bignews' ),
			'style' => 1,
		);
		$instance = wp_parse_args( (array) $instance, $default );
		$title = esc_attr( $instance['title'] );
		$style = esc_attr( $instance['style'] );
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
				</select>
			</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['style'] = strip_tags( $new_instance['style'] );
		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$style = $instance['style'];
		$args = array(
			'pad_counts'   => 1,
		); 
		$categories = get_categories( $args ); 
		$fields_num_mid = ceil(count ( $categories ) / 2);
		$count = 0;
		echo wp_kses_post( $before_widget );
			if( !empty( $title ) ) {
				echo wp_kses_post( $before_title );
				echo esc_html( $title );
				echo wp_kses_post( $after_title );
			}?>
			<div class="footer-content"><?php 
				if ( $style == 1 ){
					echo '<ul class="footer-link list-unstyled">';
					foreach ( $categories as $key => $value) {
						$link = get_category_link( $value->cat_ID );
						echo '<li><a href="'.esc_url( $link ).'" class="widget-footer-link border-bottom-1x"><i class="fa fa-angle-right"></i>'.esc_html( $value->name ).'</a></li>';
					}
					echo '</ul>';
				}else{?>
					<div class="row"><?php
						$html = '<div class="col-md-6 col-sm-6 col-xs-6"><ul class="list-news list-unstyled">';
						printf( "%s", $html );
						foreach ( $categories as $key => $value) {
							$link = get_category_link( $value->cat_ID );
							echo '<li><a href="'.esc_url( $link ).'" class="related-link"><i class="fa fa-caret-right"></i>'.esc_html( $value->name ).'</a></li>';
							$count++;
							if ( $count == $fields_num_mid ){
								printf('</ul></div>%s', $html );
							}
						}
						echo '</ul></div>';?>
					</div>
				<?php }?>
			</div>
		<?php
		echo wp_kses_post( $after_widget );
	}
}