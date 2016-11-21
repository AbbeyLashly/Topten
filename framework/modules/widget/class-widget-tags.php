<?php
/**
 * Widget_Contact_Info class.
 * 
 * @since 1.0
 */

class Swbignews_Widget_Tags extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_tags',
			'description' => esc_html__( "A cloud of your most used tags.", 'bignews')
		);
		parent::__construct( 'swbignews_tag', esc_html_x( 'SW: Tags', 'A cloud of your most used tags.', 'bignews' ), $widget_ops );
	}

	function form( $instance ) {
		$default = array(
			'title' => 'Popular tags',
			'style' => 1, 
			'number' => 20,
			'maxsize' => 20,
			'minsize' => 10
		); 
		$instance = wp_parse_args( (array) $instance, $default );
		$title = esc_attr( $instance['title'] );
		$style = esc_attr( $instance['style'] ); 
		$number = esc_attr( $instance['number'] ); 
		$maxsize = esc_attr( $instance['maxsize'] );  
		$minsize = esc_attr( $instance['minsize'] );
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
			<p>
				<label for="<?php echo  esc_attr( $this->get_field_id('number') ); ?>"><?php esc_html_e('Number', 'bignews');?></label>
				<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('number') ); ?>" name="<?php echo esc_attr( $this->get_field_name('number') ); ?>" value="<?php echo esc_attr( $number ); ?>" />
			</p>
			<p>
				<label for="<?php echo  esc_attr( $this->get_field_id('maxsize') ); ?>"><?php esc_html_e('Max front size', 'bignews');?></label>
				<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('maxsize') ); ?>" name="<?php echo esc_attr( $this->get_field_name('maxsize') ); ?>" value="<?php echo esc_attr( $maxsize ); ?>" />
			</p>
			<p>
				<label for="<?php echo  esc_attr( $this->get_field_id('minsize') ); ?>"><?php esc_html_e('Min front size', 'bignews');?></label>
				<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('minsize') ); ?>" name="<?php echo esc_attr( $this->get_field_name('minsize') ); ?>" value="<?php echo esc_attr( $minsize ); ?>" />
			</p>
			 
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['style'] = strip_tags( $new_instance['style'] ); 
		$instance['number'] = intval( $new_instance['number'] ); 
		$instance['maxsize'] = intval( $new_instance['maxsize'] ); 
		$instance['minsize'] = intval( $new_instance['minsize'] ); 
		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $instance );
		$title = apply_filters( 'widget_title', $title );
		$minsize = (intval($minsize) > 0 ) ? intval($minsize) :'10';
		$maxsize = (intval($maxsize) > 0 ) ? intval($maxsize) :'20';
		$number  = (intval($number) > 0 ) ? intval($number) :'0';
		echo wp_kses_post( $args['before_widget'] );
		echo '<div class="section-category mbn">';
		?>
			<?php if(!empty($title)){ ?>
				<div class="section-name"> 
					<?php echo esc_html( $title );?>
				</div>
			<?php }?>
			<div class="section-content">
				<div class="tags-list tags-style-<?php echo esc_attr($style) ?>">
					<?php
						$tags = get_tags(array('number'=>$number,'orderby' =>'term_id', 'order' => 'DESC'));
						foreach ( $tags as $tag ) {
							if ($style == '2')
								$size = rand($minsize,$maxsize);
							else
								$size = $minsize; 
							$tag_link = get_tag_link( $tag->term_id );
							echo sprintf('<a href="%1$s" title="%2$s" class="tag %3$s">%2$s </a>',esc_url($tag_link),esc_html($tag->name),esc_attr($tag->slug));
							
						}
					?>
				</div>
			</div>
			<?php

		echo wp_kses_post( $args['after_widget'] );
		echo '</div>';
		$custom_css = sprintf('.widget_tags .section-content .tags-list > a.tag{font-size: %spt}', esc_attr( $size ));
		do_action( 'swbignews_add_inline_style', $custom_css );
	}
}
