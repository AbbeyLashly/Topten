<?php
/**
 * Widget_Grid class.
 * 
 * @since 1.0
 */
class Swbignews_Widget_Grid extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_grid', 'description' => esc_html__( "WP Posts in grid.", 'bignews') );
		parent::__construct( 'swbignews_grid', esc_html_x( 'SW: Grid', 'Grid widget', 'bignews' ), $widget_ops );
	}
	function form( $instance ) {
		$default = array(
			'block_title' => '',
			'limit_post'  => '',
			'sort_by'       => '',
			'category_slug' => '',
			'tag_slug'      => '',
			'author'        => '',
			'show_date'     => 'on',
			'show_category' => 'on',
			'show_author'   => '',
			'show_views'    => '',
			'show_comments' => '',
		);
		$check_box = array(
			'show_date'     => esc_html__( 'Display post date', 'bignews' ),
			'show_category' => esc_html__( 'Display main category', 'bignews' ),
			'show_author'   => esc_html__( 'Display post author', 'bignews' ),
			'show_views'     => esc_html__( 'Display post views', 'bignews' ),
			'show_comments'  => esc_html__( 'Display post comments', 'bignews' ),
		);
		$instance = wp_parse_args( (array) $instance, $default );
		$block_title = esc_attr( $instance['block_title'] );
		$limit_post = esc_attr( $instance['limit_post'] );
		$sort_by = esc_attr( $instance['sort_by'] );
		$category_slug = esc_attr( $instance['category_slug'] );
		$tag_slug = esc_attr( $instance['tag_slug'] );
		$author = esc_attr( $instance['author'] );
		
		$sort_arr = Swbignews::get_params('sort_blog');
		$category_slug_arr = SwlabsCore_Com::get_category2slug_array();
		$tag_slug_arr = SwlabsCore_Com::get_tax_options2slug( 'post_tag', array('empty' => '-All tags-') );
		$author_arr = SwlabsCore_Com::get_user_login2id( array(), array('empty' => '-All authors-') );
		?>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('block_title') ); ?>"><?php esc_html_e( 'Block Title', 'bignews' );?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('block_title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('block_title') ); ?>" value="<?php echo esc_attr( $block_title ); ?>" />
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('limit_post') ); ?>"><?php esc_html_e( 'Number Post', 'bignews' );?></label>
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
			<label for="<?php echo  esc_attr( $this->get_field_id('category_slug') ); ?>"><?php esc_html_e( 'Choose Category', 'bignews' );?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('category_slug') ); ?>" name="<?php echo esc_attr( $this->get_field_name('category_slug') ); ?>" >
			<?php foreach( $category_slug_arr  as $k => $v ){?>
				<option value="<?php echo esc_attr($v); ?>"<?php if( $category_slug == $v )echo " selected"; ?>><?php echo esc_attr($k); ?></option>
			<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('tag_slug') ); ?>"><?php esc_html_e( 'Choose Tag', 'bignews' );?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('tag_slug') ); ?>" name="<?php echo esc_attr( $this->get_field_name('tag_slug') ); ?>" >
			<?php foreach( $tag_slug_arr  as $k => $v ){?>
				<option value="<?php echo esc_attr($v); ?>"<?php if( $tag_slug == $v )echo " selected"; ?>><?php echo esc_attr($k); ?></option>
			<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('author') ); ?>"><?php esc_html_e( 'Choose Author', 'bignews' );?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('author') ); ?>" name="<?php echo esc_attr( $this->get_field_name('author') ); ?>" >
			<?php foreach( $author_arr  as $k => $v ){?>
				<option value="<?php echo esc_attr($v); ?>"<?php if( $author == $v )echo " selected"; ?>><?php echo esc_attr($k); ?></option>
			<?php } ?>
			</select>
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
		$params = array(
				'block_title',
				'limit_post',
				'sort_by',
				'category_slug',
				'tag_slug',
				'author',
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
		$limit_post = $instance['limit_post'];
		$widget_id =  Swbignews::make_id();
		$index = 0;
		$default = array(
			'layout'        => 'widget-grid',
			'block_title'   => '',
			'limit_post'    => '',
			'sort_by'       => '',
			'category_slug' => '',
			'tag_slug'      => '',
			'author'        => '',
			'show_date'     => '',
			'show_category' => '',
			'show_author'   => '',
			'show_views'     => '',
			'show_comments'  => '',
		);
		$check_box = array(
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
		//call function from shortcode
		$model = new SwlabsCore_Block;
		$model->init( $atts, $content = null);
		$model->large_image_post = false;
		$html_format = '
			<li>%1$s
				<div class="description">
					<div class="inner">
						<div class="media-content">%2$s
							<div class="info info-style-3">%3$s</div>
						</div>
					</div>
				</div>
			</li>';
		echo wp_kses_post( $before_widget );?>
		<?php 
		if( !empty( $title ) ) {
				echo wp_kses_post( $before_title );
				echo esc_html( $title );
				echo wp_kses_post( $after_title );
		}
		if ( $model->query->have_posts() ) :?>
			<div class="footer-content">
				<div class="footer-media footer-mbl ">
					<?php
					$post_options = array(
						'small_post_format' => $html_format ,
						'open_group'        => ' <ul class="most-view-list">',
						'open_row'          => '',
						'close_row'         => '',
						'close_group'       => '</ul>',
						'thumb_href_class'  => '',
					);
					$model->render_block( $post_options );?>
				</div>
			</div>
		<?php endif; // have_post
		echo wp_kses_post( $after_widget );
	}
}