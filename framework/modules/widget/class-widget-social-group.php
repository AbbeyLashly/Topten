<?php
/**
 * Widget_Social_Group class.
 * 
 * @since 1.0
 */

class Swbignews_Widget_Social_Group extends WP_Widget {
	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_social_group', 'description' => esc_html__( 'A list social links for your site.', 'bignews' ) );
		parent::__construct( 'swbignews_social_group', esc_html_x( 'SW: Social Group', 'Social group widget', 'bignews' ), $widget_ops );
	}
	function form( $instance ) {
		$widget_default = array(
			'title'         => '',
			'style'         => 1,
			'facebook'      => '',
			'twitter'       => '',
			'google'        => '',
			'skype'         => '',
			'youtube'       => '',
			'rss'           => '',
			'delicious'     => '',
			'flickr'        => '',
			'lastfm'        => '',
			'linkedin'      => '',
			'vimeo'         => '',
			'tumblr'        => '',
			'pinterest'     => '',
			'deviantart'    => '',
			'git'           => '',
			'instagram'     => '',
			'stumbleupon'   => '',
			'behance'       => '',
			'tripAdvisor'   => '',
			'500px'         => '',
			'vk'            => '',
			'foursquare'    => '',
			'xing'          => '',
			'weibo'         => '',
			'odnoklassniki' => '',
		);
		$instance = wp_parse_args( (array) $instance, $widget_default );
		?>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Title', 'bignews' );?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('style') ); ?>"><?php esc_html_e( 'Choose Style', 'bignews' );?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('style') ); ?>" name="<?php echo esc_attr( $this->get_field_name('style') ); ?>" >
				<option value="style-1"<?php if( $instance['style']  == 'style-1' ) echo " selected"; ?>>Style: Icon hover</option>
				<option value="style-2"<?php if( $instance['style']  == 'style-2' ) echo " selected"; ?>>Style: Square, Background hover</option>
			</select>
		</p>
		<?php
		foreach( $widget_default as $k => $v ){
			if( $k != 'title' && $k != 'style' ){?>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id($k) ); ?>"><?php echo esc_attr( ucfirst($k));?></label>
					<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id($k) ); ?>" name="<?php echo esc_attr( $this->get_field_name($k) ); ?>" value="<?php echo esc_attr( $instance[$k] ); ?>"/>
				</p>
				<?php
			}
		}
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['style'] = strip_tags( $new_instance['style'] );
		$arr_social = Swbignews::get_params('social-icons');
		foreach( $arr_social as $k => $v ){
			$instance[$k] = $new_instance[$k];
		}
		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		$arr_social = Swbignews::get_params('social-icons');
		$title = apply_filters('widget_title', $instance['title']);
		$style = $instance['style'];
		if ( $style == 'style-1' ){
			$class = 'widget-social-3';
		}else{
			$class = 'widget-social-2';
		}
		echo wp_kses_post( $before_widget );
		?>
		<div class="footer-social"><?php
			if( !empty( $title ) ) {
				echo wp_kses_post( $before_title );
				echo esc_html( $title );
				echo wp_kses_post( $after_title );
			}?>
			<ul class="list-unstyled list-inline <?php echo esc_attr( $class );?> text-left">
				<?php foreach( $arr_social as $k => $v ){
				if( !empty( $instance[$k] ) ){?>
				<li><a href="<?php echo esc_url( $instance[$k] );?>" class="social-icon icon-<?php echo esc_attr($v);?>"><i class="fa <?php echo esc_attr($v) ; ?> fa-fw"></i></a></li>
				<?php }}?>
			</ul>
		</div>
		<div class="clearfix"></div>
		<?php
		echo wp_kses_post( $after_widget );
	}
}