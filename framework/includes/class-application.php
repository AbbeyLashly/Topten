<?php
/**
 * Application class.
 * 
 * @since 1.0
 */
class Swbignews_Application {

	/**
	 * It called on initialization of theme
	 */
	public function run() {
		$this->register( Swbignews::get_config( 'load' ) );
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}

	/**
	 * Fires after WordPress has finished loading but before any headers are sent.
	 */
	public function init() {
		$this->register( Swbignews::get_config( 'init' ) );

		if( ! is_admin() ) {
			$this->register( Swbignews::get_config( 'front_init' ) );
		}
	}

	/**
	 * It is triggered before any other hook when a user accesses the admin area. 
	 */
	public function admin_init() {
		$this->register( Swbignews::get_config( 'admin_init' ) );
	}

	/**
	 * It is an action triggered whenever a ajax call
	 */
	public function ajax() {
		@ob_clean();
		if( $act = Swbignews::get_request_param( 'module' ) ) {
			if( Swbignews::load_class( $act[0] ) && 2 == count($act) && preg_match( '/^(?P<module>\w+)\.(?P<class>\w+)$/', $act[0] ) ) {
				call_user_func_array(
					array( Swbignews::new_object( $act[0] ), $act[1] ),
					Swbignews::get_request_param( 'params', array() )
				);
			} else {
				echo json_encode( array( 'mesasge' => 'Can\'t not load class ' . $act[0] ) );
			}
		}
		die();
	}

	/**
	 *  It is an action triggered whenever a post or page is created or updated
	 *
	 * @param int $post_id The post ID.
	 */
	public function save( $post_id ) {
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		global $post;
		if( ! empty( $post->post_type ) && ( $act= Swbignews::get_config( 'save_post', $post->post_type ) ) ) {
			if( count( $act ) >= 2 && Swbignews::load_class( $act[0] ) ) {
				call_user_func_array( array( Swbignews::new_object( $act[0] ), $act[1] ), array( $post_id ) );
			}
		}
	}

	/**
	 * Call a callback with an array of parameters.
	 *
	 * @param array $item Callback parameters.
	 */
	public function register( $data ) {
		if(isset($data)){
			foreach( $data as $params ) {
				if( $fn = array_shift( $params ) ) {
					if( 'Swbignews' == $fn ) {
						$mt = array_shift ( $params );
						call_user_func_array( array( $fn, $mt ),  $params );
					} else {
						call_user_func_array( $fn, $params );
					}
				}
			}
		}
	}
}