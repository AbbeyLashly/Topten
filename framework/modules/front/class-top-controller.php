<?php
/**
 * Controller Top.
 * 
 * @since 1.0
 */
Swbignews::load_class( 'Abstract' );

class Swbignews_Top_Controller extends Swbignews_Abstract {
	/**
	 * Get page options
	 *
	 */
	public function get_page_options() {
		global $swbignews_options;
	
		$post_id = get_the_ID();
		if( ! $post_id ) {
			return;
		}
		$shw_page_options = get_post_meta( $post_id, 'shw_page_options', true );
		if( empty( $shw_page_options ) ) {
			return;
		}
		if( get_post_type() == 'post'){
			$maps = Swbignews::get_config( 'mapping', 'post_options' );
			foreach($maps as $option_type => $page_options ) {
				foreach( $page_options as $key => $option) {
					if(!empty($shw_page_options[$key])){
						$swbignews_options[$option] = $shw_page_options[$key];
					}
				}
			}

		} else {
			$maps = Swbignews::get_config( 'mapping', 'options' );
			$image_id_keys = array('background_image_id', 'header_background_image_id', 'pt_background_image_id');
			$no_default = Swbignews::get_config( 'mapping', 'no-default-options' );
			foreach($maps as $option_type => $page_options ) {
				$is_theme_default = $option_type .'_default';
				if( ( ! in_array($option_type, $no_default) ) &&
						(!isset( $shw_page_options[$is_theme_default] ) || isset( $shw_page_options[$is_theme_default] ) && ! empty( $shw_page_options[$is_theme_default] ) ) )
				{
					// no get page options
					continue;
				} else {
					foreach( $page_options as $key => $option) {
						$default = '';
						$bg_img = '';
						$bg_array = array(
							'background_transparent' => 'background_color',
							'header_background_transparent' => 'header_background_color',
							'pt_background_transparent' => 'pt_background_color'
						);
						foreach($bg_array as $bg_key=>$bg_val ) {
							if( isset($shw_page_options[$bg_key]) && !empty($shw_page_options[$bg_key])) {
								$shw_page_options[$bg_val] = $shw_page_options[$bg_key];
								unset($page_options[$bg_key]);
							}
						}
						if( isset( $shw_page_options[$key] ) ) {
							$option_val = $shw_page_options[$key];
							if( in_array( $key, $image_id_keys ) && ! empty( $option_val ) ) {
								$attachment_image = wp_get_attachment_image_src($option_val, 'full');
								$bg_img = $attachment_image[0];
								$default = $option_val;
							} else {
								$default = $option_val;
							}
						}
						if( $option ) {
							if( is_array( $option ) ) {
								if( count( $option ) == 3 ) {
									if( $default ) {
										$swbignews_options[$option[0]][$option[1]][$option[2]] = $default;
										if( !empty( $bg_img ) ) {
											$swbignews_options[$option[0]]['background-image'] = $bg_img;
										}
									}
								}
								else {
									$swbignews_options[$option[0]][$option[1]] = $default;
								}
							} else {
								$swbignews_options[$option] = $default;
							}
						}
					}
				}
			}
		}
		
	}
	public function header() {
		$this->render( 'header', array());
	}
	public function headerstyle($args) {
		
		/*demo*/
		$style = '';
		$header_tmp  = get_post_meta( get_the_ID(), 'shw_page_options', true ); 
		if( empty($header_tmp['header_default']) && !empty($header_tmp['header_style_id']) )
		{
			$style = $header_tmp['header_style_id']; 
		}
		$style = (!empty($style)) ? $style : 'header-custom';
		/*end demo*/

		$this->render( 'templates/content-'.esc_html( $style ), array('args'=>$args));
	}
	public function footerstyle($args) {
		if (empty($args) || empty($args['footer_style'])) {
			$style = 'footer-1';
		}else{
			$style = $args['footer_style'];
		}  
		if (!file_exists(__DIR__.'/views/templates/style-'.esc_html( $style ).'.php')) {
			$style = 'footer-1';
		}
		$this->render( 'templates/style-'.esc_html($style), array('args'=>$args));
	}
	public function breadcrumb() {
		$this->render( 'breadcrumb', array());
	}
	public function show_post_entry_thumbnail( $args = array() ) {
		$this->render( 'entry-thumbnail', array () );
	}
	public function show_post_entry_meta( $args = array() ) {
		$posttags = get_the_tags();
		$category_list = get_the_category();
		$this->render( 'entry-meta', array (
			'args' => $args,
			'posttags' => $posttags,
			'category_list' => $category_list 
		) );
	}
	public function show_post_index(){
		$this->render( SWBIGNEWS_THEME_DIR . '/index.php', array() );
	}
	public function show_searchform(){
		$this->render( 'search-form', array() );
	}
	
	//Fires at the top of the comment form, inside the form tag.
	public function comment_form_top(){
		$user = wp_get_current_user();
		echo '
		<div class="comment-write">
			<div class="media">
				<div class="media-left">'.get_avatar($user->ID,50).'</div>
				<div class="media-body">';
	}
	
	//Fires at the bottom of the comment form, inside the closing </form> tag.
	public function comment_form_bottom(){
		echo '	</div>
			</div>
		</div>';
	}
	
	public function show_post_author() {
		$author_id = get_the_author_meta( 'ID' );
		$this->render( 'author', array (
			'author_id' => $author_id 
		) );
	}
	public function single_meta( $args = array() ) {
		$this->render( 'single-meta', array (
			'args' => $args
		) );
	}
	public function show_post_entry_video( $args = array() ) {
		if(class_exists('SwlabsCore_Video_Model')){
			$post_id = $post_id = get_the_ID();
			$post_options = get_post_meta( $post_id, 'shw_post_options', true);
			$video_model = new SwlabsCore_Video_Model();
			$video_model->init();
			if(empty($post_options['youtube_id']) &&
				empty($post_options['vimeo_id']) &&
				empty($post_options['upload_video']) ){
				do_action( 'swbignews_entry_thumbnail');
			}
			else{
				printf( '<div class="first_video">%1$s%2$s</div>',
					$video_model->get_title( $post_id ),
					$video_model->get_video( $post_options['video_type'] , $post_options['youtube_id'],
											 $post_options['vimeo_id'] , $post_options['upload_video'] )
				);
			}
		}
	}
}