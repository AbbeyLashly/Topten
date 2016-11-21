<?php
/**
 * Widget_Init class.
 * 
 * @since 1.0
 */



Swbignews::load_class( 'widget.Widget_Accordion' );
Swbignews::load_class( 'widget.Widget_Button' );
Swbignews::load_class( 'widget.Widget_Categories' );
Swbignews::load_class( 'widget.Widget_Contact_Info' );
Swbignews::load_class( 'widget.Widget_Custom_Menu' );
Swbignews::load_class( 'widget.Widget_Social_Group' );
Swbignews::load_class( 'widget.Widget_Tags' );

if ( SWBIGNEWS_WPCF7_ACTIVE ) {
	Swbignews::load_class( 'widget.Widget_Quick_Contact' );
}
if(SWBIGNEWS_CORE_IS_ACTIVE){
	Swbignews::load_class( 'widget.Widget_Block_Carousel' );
	Swbignews::load_class( 'widget.Widget_Block_Slider' );
	Swbignews::load_class( 'widget.Widget_Block' );
	Swbignews::load_class( 'widget.Widget_Weather' );
	Swbignews::load_class( 'widget.Widget_Recent_Post' );
	Swbignews::load_class( 'widget.Widget_Grid' );
	Swbignews::load_class( 'widget.Widget_Livescore' );
	Swbignews::load_class( 'widget.Widget_Advertisement' );
	Swbignews::load_class( 'widget.Widget_Social_Counter' );
}
if(SWBIGNEWS_NEWSLETTER_ACTIVE){
	Swbignews::load_class( 'widget.Widget_Newsletter' );
}
if(SWBIGNEWS_AWESOME_SURVEYS_ACTIVE){
	Swbignews::load_class( 'widget.Widget_Survey' );
}
class Swbignews_Widget_Init {
	/**
	 * Load widgets
	 *
	 */
	public function load() {
		register_widget ( 'Swbignews_Widget_Accordion');
		register_widget ( 'Swbignews_Widget_Button');
		register_widget ( 'Swbignews_Widget_Categories');
		register_widget ( 'Swbignews_Widget_Contact_Info');
		register_widget ( 'Swbignews_Widget_Custom_Menu');
		register_widget ( 'Swbignews_Widget_Social_Group');
		register_widget ( 'Swbignews_Widget_Tags');
		if(SWBIGNEWS_CORE_IS_ACTIVE){
			register_widget ( 'Swbignews_Widget_Weather');
			register_widget ( 'Swbignews_Widget_Recent_Post');
			register_widget ( 'Swbignews_Widget_Livescore');
			register_widget ( 'Swbignews_Widget_Block_Carousel');
			register_widget ( 'Swbignews_Widget_Block_Slider');
			register_widget ( 'Swbignews_Widget_Block' );
			register_widget ( 'Swbignews_Widget_Grid' );
			register_widget ( 'Swbignews_Widget_Advertisement');
			register_widget ( 'Swbignews_Widget_Recent_Post');

			if(class_exists('SwlabsCore_Social_Api')){
				register_widget ( 'Swbignews_Widget_Social_Counter');
			}
		}
		if(SWBIGNEWS_AWESOME_SURVEYS_ACTIVE){
			register_widget ( 'Swbignews_Widget_Survey');
		}
		if ( SWBIGNEWS_WPCF7_ACTIVE ) {
			register_widget ( 'Swbignews_Widget_Quick_Contact');
		}
	}
	/**
	 * Register sidebars
	 *
	 */
	public function widgets_init() {
		register_sidebar( array (
			'name'          => esc_html__( 'Custom Widget Area', 'bignews' ),
			'id'            => 'swbignews-sidebar-custom',
			'description'   => esc_html__( 'Appears on sidebar of posts and pages', 'bignews'),
			'before_widget' => '<div id="%1$s" class="box %2$s shw-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="section-name">',
			'after_title'   => '</div>'
		));
		// Register footer area
		for ( $i = 1; $i < 5; $i++ ) {
			register_sidebar( array (
				'name'          => sprintf( esc_html__( 'Footer Widget Area %s', 'bignews' ), $i ),
				'id'            => 'swbignews-sidebar-footer-' . esc_attr($i),
				'description'   => sprintf( esc_html__( 'Appears on footer column %s.', 'bignews' ), $i ),
				'before_widget' => '<div id="%1$s" class="%2$s shw-widget widget-footer">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="footer-header">',
				'after_title'   => '</div>'
			));
		}

		register_sidebar( array (
			'name'          => esc_html__( 'Main Widget Area', 'bignews' ),
			'id'            => 'swbignews-sidebar-main',
			'description'   => esc_html__( 'Appears on posts and pages.', 'bignews' ),
			'before_widget' => '<div id="%1$s" class="box %2$s shw-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="section-name">',
			'after_title'   => '</div>'
		));
		register_sidebar( array (
			'name'          => esc_html__( 'Blog Widget Area', 'bignews' ),
			'id'            => 'swbignews-sidebar-blog',
			'description'   => esc_html__( 'Appears on sidebar of posts and pages.', 'bignews' ),
			'before_widget' => '<div id="%1$s" class="box %2$s shw-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="section-name">',
			'after_title'   => '</div>'
		));
		// Register custom sidebar
		$sidebars = get_option(SWLABSCORE_CUSTOM_SIDEBAR_NAME);
		$args =  array (
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => ''
		);
		if( is_array($sidebars) ) {
			foreach ( $sidebars as $sidebar ) {
				if( !empty($sidebar) ) {
					$name = isset($sidebar['name']) ? $sidebar['name'] : '';
					$title = isset($sidebar['title']) ? $sidebar['title'] : '';
					$class = isset($sidebar['class']) ? $sidebar['class'] : '';
					$args['name']   = $title;
					$args['id']     = str_replace(' ','-',strtolower( $name ));
					$args['class']  = 'shw-custom';
					$args['before_widget'] = '<div class="box %2$s shw-widget '. esc_attr($class) .'">';
					$args['after_widget']  = '</div>';
					$args['before_title']  = '<div class="section-name">';
					$args['after_title']   = '</div>';
					register_sidebar($args);
				}
			}
		}
	}
	/**
	 * Add custom sidebar area
	 *
	 */
	public function add_widget_field() {
		$nonce =  wp_create_nonce ('swbignews-delete-sidebar-nonce');
		$nonce = '<input type="hidden" name="swbignews-delete-sidebar-nonce" value="'.esc_attr($nonce).'" />';
		echo "\n<script type='text/html' id='swbignews-custom-widget'>";
		echo "\n  <form class='swbignews-add-widget' method='POST'>";
		echo "\n  <h3>BigNews Custom Widgets</h3>";
		echo "\n    <input class='swbignews_style_wrap' type='text' value='' placeholder = '". esc_html__('Enter Name of the new Widget Area here', 'bignews') ."' name='swbignews-add-widget[name]' />";
		echo "\n    <input class='swbignews_style_wrap' type='text' value='' placeholder = '". esc_html__('Enter class display on front-end', 'bignews') ."' name='swbignews-add-widget[class]' />";
		echo "\n    <input class='swbignews_button' type='submit' value='". esc_html__('Add Widget Area', 'bignews') ."' />";
		echo "\n    ".$nonce;
		echo "\n  </form>";
		echo "\n</script>\n";
	}

	public function add_sidebar_area() {
		if( isset($_POST['swbignews-add-widget']) && !empty($_POST['swbignews-add-widget']['name']) ) {
			$sidebars = array();
			$sidebars = get_option(SWLABSCORE_CUSTOM_SIDEBAR_NAME);
			$name = $this->get_name($_POST['swbignews-add-widget']['name']);
			$class = $_POST['swbignews-add-widget']['class'];
			$sidebars[] = array('name'=>sanitize_title($name), 'title' => $name, 'class'=>$class);
			update_option(SWLABSCORE_CUSTOM_SIDEBAR_NAME, $sidebars);
			wp_redirect( admin_url('widgets.php') );
			die();
		}
	}

	public function get_name( $name ) {
		if( empty($GLOBALS['wp_registered_sidebars']) ){
			return $name;
		}

		$taken = array();
		foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
			$taken[] = $sidebar['name'];
		}
		$sidebars = get_option(SWLABSCORE_CUSTOM_SIDEBAR_NAME);

		if( empty($sidebars) ) {
			$sidebars = array();
		}

		$taken = array_merge($taken, $sidebars);
		if( in_array($name, $taken) ) {
			$counter  = substr($name, -1);
			$new_name = "";
			if( !is_numeric($counter) ) {
				$new_name = $name . " 1";
			}
			else {
				$new_name = substr($name, 0, -1) . ((int) $counter + 1);
			}
			$name = $new_name;
		}
		return $name;
	}
	public function delete_custom_sidebar() {
		check_ajax_referer('swbignews-delete-sidebar-nonce');

		if( !empty($_POST['name']) ) {
			$name = sanitize_title($_POST['name']);
			$sidebars = get_option(SWLABSCORE_CUSTOM_SIDEBAR_NAME);
			foreach($sidebars as $key => $sidebar){
				if( strcmp(trim($sidebar['name']), trim($name)) == 0) {
					unset($sidebars[$key]);
					update_option(SWLABSCORE_CUSTOM_SIDEBAR_NAME, $sidebars);
					echo "success";
					break;
				}
			}
		}
		die();
	}
}