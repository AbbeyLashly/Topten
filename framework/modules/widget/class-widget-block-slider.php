<?php
/**
 * Widget_Block_Slider class.
 * 
 * @since 1.0
 */
class Swbignews_Widget_Block_Slider extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_block_slider', 'description' => esc_html__( "Slider with WP Posts.", 'bignews') );
		parent::__construct( 'swbignews_block_slider', esc_html_x( 'SW: Block Slider', 'Block slider widget', 'bignews' ), $widget_ops );
	}
	function form( $instance ) {
		$default = array(
			'block_title'   => '',
			'limit_post'    => '',
			'sort_by'       => '',
			'category_slug' => '',
			'tag_slug'      => '',
			'author'        => '',
		);
		$instance = wp_parse_args( (array) $instance, $default );
		$block_title = esc_attr( $instance['block_title'] );
		$limit_post = esc_attr( $instance['limit_post'] );
		$sort_by = esc_attr( $instance['sort_by'] );
		$category_slug = esc_attr( $instance['category_slug'] );
		$tag_slug = esc_attr( $instance['tag_slug'] );
		$author = esc_attr( $instance['author'] );
		//array
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
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['block_title'] = strip_tags( $new_instance['block_title'] );
		$instance['limit_post'] = strip_tags( $new_instance['limit_post'] );
		$instance['sort_by'] = strip_tags( $new_instance['sort_by'] );
		$instance['category_slug'] = strip_tags( $new_instance['category_slug'] );
		$instance['tag_slug'] = strip_tags( $new_instance['tag_slug'] );
		$instance['author'] = strip_tags( $new_instance['author'] );
		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('swbignews_block_title', $instance['block_title']);
		$limit_post = $instance['limit_post'];
		$sort_by = $instance['sort_by'];
		$category_slug = $instance['category_slug'];
		$tag_slug = $instance['tag_slug'];
		$author = $instance['author'];
		//call function from shortcode
		$model = new SwlabsCore_Block;
		$atts = array(
			'block_title'            => $title,
			'limit_post'             => $limit_post,
			'sort_by'                => $sort_by,
			'category_slug'          => $category_slug,
			'tag_slug'               => $tag_slug,
			'author'                 => $author,
			'large_thumb_href_class' => '',
			'layout'                 => 'widget-block-slider',
		);
		$model->init( $atts, $content = null);
		$option = array();
		$options['thumb_href_class']='';
		$type= 'large';
		echo wp_kses_post( $before_widget );
		if ( $model->query->have_posts() ) :?>
			<div class="most-popular-sidebar"><?php
				if( !empty( $title ) ) {
					echo wp_kses_post( $before_title );
					echo esc_html( $title );
					echo wp_kses_post( $after_title );
				}?>
				<div class="section-content">
					<div data-item="2" class="most-poppular-widget" data-number-post="<?php echo esc_attr ( $limit_post );?>"><?php
						while ( $model->query->have_posts() ) {
							$model->query->the_post();
							$model->loop_index();
							echo '
							<div class="media '. esc_attr($model->get_post_class()) .' " data-item="'. esc_attr( $model->query->post_count ) .'">
								<div class="media-body">'.wp_kses_post($model->get_featured_image( $type, false, $options )).'<div class="caption dark">'.wp_kses_post($model->get_title()).'</div>'.'
								</div>
							</div>';
						}?>
					</div>
					<div class="clearfix"></div>
				</div>
			</div><?php
		endif; // have_post
		wp_reset_postdata();
		echo wp_kses_post( $after_widget );
	}
}