<?php
/**
 * Widget_Recent_Post class.
 * 
 * @since 1.0
 */
class Swbignews_Widget_Recent_Post extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_recent_post', 'description' => esc_html__( "A recent posts list will be shown.", 'bignews') );
		parent::__construct( 'swbignews_recent_post', esc_html_x( 'SW: Recent Posts', 'Block widget', 'bignews' ), $widget_ops );
	}
	function form( $instance ) {
		$default = array(
			'block_title'   => 'Recent Posts',
			'limit_post'    => '',
			'style'         => 1,
			'show_excerpt'  => '',
			'show_date'     => 'on',
			'show_category' => '',
			'show_author'   => '',
			'show_views'    => '',
			'show_comments' => '',
		);
		$check_box = array(
			'show_excerpt'  => esc_html__( 'Display the excerpt', 'bignews' ),
			'show_date'     => esc_html__( 'Display post date', 'bignews' ),
			'show_category' => esc_html__( 'Display main category', 'bignews' ),
			'show_author'   => esc_html__( 'Display post author', 'bignews' ),
			'show_views'     => esc_html__( 'Display post views', 'bignews' ),
			'show_comments'  => esc_html__( 'Display post comments', 'bignews' ),
		);
		$instance = wp_parse_args( (array) $instance, $default );
		$block_title = esc_attr( $instance['block_title'] );
		$style = esc_attr( $instance['style'] );
		$limit_post = esc_attr( $instance['limit_post'] );
		$style_arr = Swbignews::get_params('recent_post_style');
		?>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('block_title') ); ?>"><?php esc_html_e( 'Block Title', 'bignews' );?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('block_title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('block_title') ); ?>" value="<?php echo esc_attr( $block_title ); ?>" />
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('style') ); ?>"><?php esc_html_e('Choose Style', 'bignews');?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name('style') ); ?>" >
				<?php foreach ( $style_arr as $k => $v ){ ?>
					<option value="<?php echo esc_attr($k);?>"<?php if( $style == $k ) { echo " selected"; } ?>><?php echo esc_attr($v);?></option>
				<?php }?>
			</select>
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('limit_post') ); ?>"><?php esc_html_e( 'Number Post', 'bignews' );?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('limit_post') ); ?>" name="<?php echo esc_attr( $this->get_field_name('limit_post') ); ?>" value="<?php echo esc_attr( $limit_post ); ?>" />
		</p>
		<?php
			$format = '
				<p>
					<input class="checkbox" type="checkbox" %1$s id="%2$s" name="%3$s" />
					<label for="%4$s">%5$s</label>
				</p>';
			foreach( $check_box as $field => $text ) {
				printf( $format,
						checked($instance[$field], 'on', false ),
						esc_attr( $this->get_field_id($field) ),
						esc_attr( $this->get_field_name($field) ),
						esc_attr( $this->get_field_id($field) ),
						$text
					);
			}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['block_title'] = strip_tags( $new_instance['block_title'] );
		$params = array(
				'block_title',
				'limit_post',
				'style',
				'show_excerpt',
				'show_date',
				'show_category',
				'show_author',
				'show_views',
				'show_comments',
			);
		foreach( $params as $item ) {
			$instance[$item] = strip_tags( $new_instance[$item] );
		}
		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('swbignews_block_title', $instance['block_title']);
		$style = $instance['style'];
		$widget_id =  Swbignews::make_id();
		$index = 0;
		//call function from shortcode
		$model = new SwlabsCore_Block;
		$default = array(
			'layout'        => 'widget-recent-post',
			'block_title'   => '',
			'limit_post'    => '',
			'show_excerpt'  => '',
			'show_date'     => '',
			'show_category' => '',
			'show_author'   => '',
			'show_views'     => '',
			'show_comments'  => '',
		);
		$check_box = array(
			'show_excerpt'  => '',
			'show_date'     => '',
			'show_category' => '',
			'show_author'   => '',
			'show_views'     => '',
			'show_comments'  => '',
		);
		$instance = wp_parse_args( (array) $instance, $default );
		extract($instance);
		$atts = $instance;
		foreach( $check_box as $k => $v ) {
			if( isset($atts[$k]) && $atts[$k] != 'on'){
				$atts[$k] = 'hide';
			}
			if( isset($atts[$k]) && $atts[$k] == 'on') {
				$atts[$k] = '';
			}
		}
		$limit_content = 15;
		$model->large_image_post = false;
		$model->init( $atts, $content = null);
		$show_excerpt = '';
		if( $atts['show_excerpt'] != 'hide' ) {
			$show_excerpt = '<div class="description">%5$s</div>';
		}
		$html_format_1 = '<div class="media">
							<div class="widget-footer-media border-bottom-1x">
								<div class="media-left">%1$s</div>
								<div class="media-body">
									<div class="media-heading">%2$s</div>
									<div class="info info-style-1">%3$s</div>
									'.wp_kses_post($show_excerpt).'
								</div>
							</div>
						</div>';
		$html_format_2 = '<div class="media">
							<div href="#" class="widget-footer-media border-bottom-1x">
								<div class="media-body">
									<div class="media-heading">%2$s</div>
									<div class="info info-style-1">%3$s</div>
									'.wp_kses_post($show_excerpt).'
								</div>
							</div>
						</div>';
		echo wp_kses_post($before_widget);
		?>
		<?php
		if ( $model->query->have_posts() ) :?>
			<div class="section-category mbn">
			<div class="section-name">
				<?php
					if(!empty($title)){
						echo esc_html( $title );
					}
				?>
			</div>
			<div class="footer-content"><?php
				if( $style == 1){?>
					<div class="thumb-list">
						<?php while ( $model->query->have_posts() ) {
							$model->query->the_post();
							$model->loop_index(); 
							$options['thumb_href_class'] = "thumb"; 
							echo wp_kses_post($model->get_featured_image('small',false,$options));
							?>
						<?php
						$index++;
						}?>
					</div>
				<?php } else {?>
						<div class="footer-media footer-mbl ">
							<?php 
							$post_options = array(
								'small_post_format' => $html_format_1,
								'small_thumb_href_class'  => '',
							);
							$model->render_block( $post_options );?>
						</div>
				<?php } ?>
			</div> </div>
		<?php endif; // have_post
		wp_reset_postdata();
		echo wp_kses_post($after_widget);
	}
}