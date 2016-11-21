<?php
/**
 * Widget_Block_Carousel class.
 * 
 * @since 1.0
 */
class Swbignews_Widget_Block_Carousel extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_block_carousel', 'description' => esc_html__( "Carousel with WP Posts.", 'bignews') );
		parent::__construct( 'swbignews_block_carousel', esc_html_x( 'SW: Block Carousel', 'Block Carousel widget', 'bignews' ), $widget_ops );
	}
	function form( $instance ) {
		$default = array(
			'layout'        => '4',
			'block_title'   => '',
			'limit_post'    => '',
			'sort_by'       => '',
			'category_slug' => '',
			'tag_slug'      => '',
			'author'        => '',
			'show_date'     => 'on',
			'show_category' => '',
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
		$layout = esc_attr( $instance['layout'] );
		//array
		$sort_arr = Swbignews::get_params('sort_blog');
		$category_slug_arr = SwlabsCore_Com::get_category2slug_array();
		$tag_slug_arr = SwlabsCore_Com::get_tax_options2slug( 'post_tag', array('empty' => '-All tags-') );
		$author_arr = SwlabsCore_Com::get_user_login2id( array(), array('empty' => '-All authors-') );
		$carousel_layout_arr = Swbignews::get_params('widget-carousel');
		?>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('block_title') ); ?>"><?php esc_html_e( 'Block Title', 'bignews' );?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('block_title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('block_title') ); ?>" value="<?php echo esc_attr( $block_title ); ?>" />
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('layout') ); ?>"><?php esc_html_e( 'Block Style', 'bignews' );?></label>
			<br/><small></small>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('layout') ); ?>" name="<?php echo esc_attr( $this->get_field_name('layout') ); ?>" >
			<?php foreach( $carousel_layout_arr  as $k => $v ){?>
				<option value="<?php echo esc_attr($k); ?>"<?php if( $layout == $k )echo " selected"; ?>><?php echo esc_attr($v); ?></option>
			<?php } ?>
			</select>
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
		<p>
			<label><?php echo esc_html__( 'The below options using to Block Carousel styles (Carousel 2, 4)', 'bignews' ); ?> </label>
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
				'layout',
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
		$title = $instance['block_title'];
		$limit_post = $instance['limit_post'];
		$sort_by = $instance['sort_by'];
		$category_slug = $instance['category_slug'];
		$tag_slug = $instance['tag_slug'];
		$author = $instance['author'];
		$default = array(
			'layout'        => '',
			'block_title'   => '',
			'limit_post'    => '',
			'sort_by'       => '',
			'category_slug' => '',
			'tag_slug'      => '',
			'author'        => '',
			'show_date'     => '',
			'show_category' => '',
			'show_author'   => '',
			'show_views'    => '',
			'show_comments' => '',
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
		$block_layout = 'widget-block-carousel-' . esc_attr($layout);
		$atts['layout'] = $block_layout;
		//call function from shortcode
		$model = new SwlabsCore_Block;
		$limit_content = 55;
		$model->init( $atts, $content = null);
		$random_id = rand(1,100);
		echo wp_kses_post( $before_widget );
		if($layout==1){
			echo '<div class="carousel-style-4-items carousel-section">';
		}
		if ($layout==4) {
			echo '<div class="slide-banner-sidebar">';
		}
		?>
			<?php 
			if( !empty( $title ) ) {
				switch ($layout) {
					case '1':
						echo '<div class="section-name"><div class="pull-left block-title">';
						echo esc_html( $model->attributes['block_title'] );
						echo'</div>
								<div class="pull-right">
									<div class="btn-slider">
										<div class="btn-slider-left"><i class="fa fa-angle-left"></i></div>
										<div class="btn-slider-right"><i class="fa fa-angle-right"></i></div>
									</div>
								</div>
							</div>';
						break;
					case '2':
						echo '<div class="section-name block-title">';
						echo esc_html($title);
						echo '</div>';
						break;
					case '4':
						echo '<div class="heading block-title">';
						echo esc_html( $title );
						echo '</div>';
						break;
				}
				
			}
			switch ($layout) {
				case '1':
					if ( $model->query->have_posts() ) :
						echo '
						<div class="section-content">
							<div class="tabmenu-carousel carousel-media">';
						while ( $model->query->have_posts() ) {
								$model->query->the_post();
								$model->loop_index();
								echo'
										<div class="media %6$s">
											<div class="media-body">'.wp_kses_post($model->get_featured_image()).wp_kses_post($model->get_title()).'
											</div>
										</div>';
						} //end while 
						echo '
							</div>
						</div>';
					endif; // have_post
					break;
				case '2':
					$type = 'large';
					echo '<div class="section-content">';
					if ( $model->query->have_posts() ) :
						echo '<div class="tabmenu-carousel-2">';
							$count = 0;
							while ( $model->query->have_posts() ) {
								$model->query->the_post();
								$model->loop_index();
								$count ++; 
								echo '<div class="item">
											<div class="thumb">
												'.wp_kses_post($model->get_featured_image($type)).'
											</div>
											'.wp_kses_post($model->get_title()).'
											<div class="info info-style-1">
												'.wp_kses_post($model->get_meta()).'
											</div>
										</div>';
							} //end while 
						
						endif;
						echo '</div>';
						echo '</div>';
					break;
				case '4':
					if ( $model->query->have_posts() ) :
						echo '
							<div id="viewed_posts_carousel-'.esc_attr($random_id).'"> 
								<div class="banner-sidebar">
						';
						while ( $model->query->have_posts() ) {
							$model->query->the_post();
							$model->loop_index();
							echo '<div class="item">'.wp_kses_post($model->get_featured_image()).wp_kses_post($model->get_title()).'
									<div class="info info-style-1">
										'.wp_kses_post($model->get_meta()).'
									</div>
							</div>';
						}
						echo '</div></div>';
					endif; // have_post
					break;
			}
		wp_reset_postdata();
		if($layout==1){
			echo '</div>';
		}
		if ($layout==4) {
			echo '</div>';
		}
		echo wp_kses_post( $after_widget );
	}
}?>