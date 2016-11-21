<?php
/**
 * Widget_Block class.
 * 
 * @since 1.0
 */
class Swbignews_Widget_Block extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_block', 'description' => esc_html__( "Block of Posts. Block style is same shortcode blocks.", 'bignews') );
		parent::__construct( 'swbignews_block', esc_html_x( 'SW: Block', 'Block widget', 'bignews' ), $widget_ops );
	}
	function form( $instance ) {
		$default = array(
			'layout'        => '1,1',
			'block_title'   => '',
			'limit_post'    => '5',
			'sort_by'       => '',
			'category_slug' => '',
			'tag_slug'      => '',
			'author'        => '',
			'show_excerpt'  => '',
			'show_date'     => 'on',
			'show_category' => '',
			'show_author'   => '',
			'show_views'     => '',
			'show_comments'  => '',
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
		extract($instance);
		//array
		$sort_arr = Swbignews::get_params('sort_blog');
		$category_slug_arr = SwlabsCore_Com::get_category2slug_array();
		$tag_slug_arr = SwlabsCore_Com::get_tax_options2slug( 'post_tag', array('empty' => '-All tags-') );
		$author_arr = SwlabsCore_Com::get_user_login2id( array(), array('empty' => '-All authors-') );
		$block_layout_arr = Swbignews::get_params('widget-block');
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('block_title') ); ?>"><?php esc_html_e( 'Title', 'bignews' );?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('block_title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('block_title') ); ?>" value="<?php echo esc_attr( $block_title ); ?>" />
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('layout') ); ?>"><?php esc_html_e( 'Block Style', 'bignews' );?></label>
			<br/><small></small>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('layout') ); ?>" name="<?php echo esc_attr( $this->get_field_name('layout') ); ?>" >
			<?php foreach( $block_layout_arr  as $k => $v ){?>
				<option value="<?php echo esc_attr($k); ?>"<?php if( $layout == $k )echo " selected"; ?>><?php echo esc_attr($v); ?></option>
			<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('limit_post') ); ?>"><?php esc_html_e( 'Number of posts', 'bignews' );?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('limit_post') ); ?>" name="<?php echo esc_attr( $this->get_field_name('limit_post') ); ?>" value="<?php echo esc_attr( $limit_post ); ?>" />
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('sort_by') ); ?>"><?php esc_html_e( 'Sort By', 'bignews' );?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('sort_by') ); ?>" name="<?php echo esc_attr( $this->get_field_name('sort_by') ); ?>" >
			<?php foreach( $sort_arr  as $k => $v ){?>
				<option value="<?php echo esc_attr($v); ?>"<?php if( $sort_by == $v )echo " selected"; ?>><?php echo esc_attr($k); ?></option>
			<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('category_slug') ); ?>"><?php esc_html_e( 'Category', 'bignews' );?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('category_slug') ); ?>" name="<?php echo esc_attr( $this->get_field_name('category_slug') ); ?>" >
			<?php foreach( $category_slug_arr  as $k => $v ){?>
				<option value="<?php echo esc_attr($v); ?>"<?php if( $category_slug == $v ) echo " selected"; ?>><?php echo esc_attr($k); ?></option>
			<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('tag_slug') ); ?>"><?php esc_html_e( 'Tag', 'bignews' );?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('tag_slug') ); ?>" name="<?php echo esc_attr( $this->get_field_name('tag_slug') ); ?>" >
			<?php foreach( $tag_slug_arr  as $k => $v ){?>
				<option value="<?php echo esc_attr($v); ?>"<?php if( $tag_slug == $v )echo " selected"; ?>><?php echo esc_attr($k); ?></option>
			<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('author') ); ?>"><?php esc_html_e( 'Author', 'bignews' );?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('author') ); ?>" name="<?php echo esc_attr( $this->get_field_name('author') ); ?>" >
			<?php foreach( $author_arr  as $k => $v ){?>
				<option value="<?php echo esc_attr($v); ?>"<?php if( $author == $v )echo " selected"; ?>><?php echo esc_attr($k); ?></option>
			<?php } ?>
			</select>
		</p>
		<p>
			<label>The below options using to block styles (Block 1, 8, 10) </label>
			
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
		?>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$params = array(
			'layout',
			'block_title',
			'limit_post',
			'sort_by',
			'category_slug',
			'tag_slug',
			'author',
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
		$default = array(
			'layout'        => '',
			'block_title'   => '',
			'limit_post'    => '',
			'sort_by'       => '',
			'category_slug' => '',
			'tag_slug'      => '',
			'author'        => '',
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
		$title = apply_filters('swbignews_block_title', $block_title);
		$wg_layout = explode(',', $layout);
		$layout = $wg_layout[0];
		$block_layout = 'widget-block-' . esc_attr($layout);
		//call function from shortcode
		$atts = $instance;
		$atts['layout'] = $block_layout;
		$column = 1;
		if( isset( $wg_layout[1] ) ) {
			$column = $wg_layout[1];
		}
		$atts['column'] = $column;
		foreach( $check_box as $k => $v ) {
			if( isset($atts[$k]) && $atts[$k] != 'on'){
				$atts[$k] = 'hide';
			}
			if( isset($atts[$k]) && $atts[$k] == 'on') {
				$atts[$k] = '';
			}
		}
		if( isset( $wg_layout[2] ) ) {
			$layout = $layout . '-' . $wg_layout[2];
		}
		$options = $this->get_block_options($layout, $atts);
		extract($options);
		$model = new SwlabsCore_Block;
		$model->init( $atts );
		$model->large_image_post = $large_image_post;

		echo wp_kses_post( $before_widget );?>
		<div class="shw-widget block-widget <?php echo ($layout==8) ? 'list-page-horizotal-1' : '' ?>">
			<?php
			if( !empty( $title ) ) {
				echo wp_kses_post( $before_title );
				echo esc_html( $title );
				echo wp_kses_post( $after_title );
			}
			if ( $model->query->have_posts() ) :?>
			<div class="section-content">
				<div class="<?php echo esc_attr($class);?>">
					<?php $model->render_block( $post_options );?>
				</div>
			</div>
			<?php endif;?>
		</div><?php
		wp_reset_postdata();
		echo wp_kses_post( $after_widget );
	}
	function get_block_options( $layout, $atts ){
		$html_large = $html_small = $desc = '';
		$options = array(
			'html_large' => $html_large,
			'html_small' => $html_small,
			'large_image_post' => false,
			'class' => '',
			'post_options' => array(),
		);
		if( $atts['show_excerpt'] != 'hide' ) {
			$desc = '<div class="description">%5$s</div>';
		}
		switch($layout) {
			case '1':
				$html_small = '
					<div class="media %6$s">
						<div class="media-body">%1$s%2$s
							<div class="info info-style-1">%3$s</div>
							' . wp_kses_post($desc) . '
						</div>
					</div>';
				$options['post_options'] = array(
					'small_post_format' => '<div class="style-1 %7$s">'.$html_small.'</div>',
					'open_row'          => '<div class="layout-media-vertical row">',
					'close_row'         => '</div>',
				);
				break;
			case '6':
				$html_large = '
					<div class="media %6$s">
						<div class="media-body">%1$s
							<div class="caption dark">%2$s</div>
						</div>
					</div>';
				$html_small = '
					<div class="media %6$s">
						<div class="media-left"><i class="fa fa-caret-right"></i></div>
						<div class="media-right">%2$s</div>
					</div>';
				$options['post_options'] = array(
					'large_post_format'       => $html_large,
					'small_post_format'       => $html_small,
					'open_group'              => '<div class="category-list-style-1">',
					'close_group'             => '</div>',
					'large_thumb_href_class'  => '',
					'small_thumb_href_class'  => 'media-image',
				);
				$options['large_image_post'] = true;
				$options['class'] = '';
				break;
			case '8':
				$html_small = '
					<div class="media">
						<div class="media-left">%1$s</div>
						<div class="media-right">%2$s
							<div class="info info-style-1">%3$s</div>
							' . wp_kses_post($desc) . '
						</div>
						
					</div>';
				if( $atts['column'] && $atts['column'] > 1 ) {
					$options['post_options'] = array(
						'small_post_format'       => '<div class="style-1 %7$s">'.$html_small.'</div>',
						'open_row'                => '<div class="row">',
						'close_row'               => '</div>',
					);
				} else {
					$options['post_options'] = array(
						'small_post_format'       => '<div class="style-1 col-sm-12">'.$html_small.'</div>',
					);
				}
				$options['large_image_post'] = false;
				$options['class'] = 'layout-media-horizontal row';
				break;
			case '9':
				$html_small = '
					<div class="media">
						<div class="media-left"><i class="fa fa-caret-right"></i></div>
						<div class="media-right">
							%2$s
							<div class="info info-style-1">%3$s</div>
						</div>
					</div>';
				$options['post_options'] = array(
					'small_post_format' => $html_small,
					'open_group'    => '<div class="category-list-style-1">',
					'close_group'   => '</div>',
				);
				break;
			case '9-2':
				$html_small = '
					<li>
						%2$s
						<div class="info info-style-1">%3$s</div>
					</li>';
				$options['post_options'] = array(
					'small_post_format' => $html_small,
					'open_group'    => '<ul class="topic-style-1">',
					'close_group'   => '</ul>',
				);
				break;
			case '10':
				$html_large = '
					<div class="media %6$s">
						<div class="media-body">%1$s
							<div class="caption dark">%2$s</div>
						</div>
					</div>';
				$html_small = '
					<div class="media %6$s">
						<div class="media-left">%1$s</div>
						<div class="media-right">%2$s</div>
					</div>';
				$options['post_options'] = array(
					'large_post_format' => $html_large,
					'small_post_format' => $html_small,
					'open_group'        => '<div class="category-list-style-1 auto-width-style">',
					'close_group'       => '</div>',
					'large_thumb_href_class'  => '',
					'small_thumb_href_class'  => 'media-image',
				);
				$options['large_image_post'] = true;
				$options['class'] = '';
				break;
		}
		return $options;
	}
}
?>