<?php
	/**
	 * Widget_Custom_Menu class.
	 * 
	 * @since 1.0
	 */
	class Swbignews_Widget_Custom_Menu extends WP_Widget {

		function __construct() {
			$widget_ops = array( 'description' => esc_html__('Use this widget to add one of your custom menu as a link list widget.','bignews') );
			parent::__construct( 'custom_menu_widget-1', esc_html__('SW: Custom Menu','bignews'), $widget_ops );
		}

		function widget($args, $instance) {  
			extract($instance);
			// Get menu
			$nav_menu = ! empty( $nav_menu ) ? wp_get_nav_menu_object( $nav_menu ) : false;

			if ( !$nav_menu )
				return;

			$instance['title'] = apply_filters( 'widget_title', empty( $title ) ? '' : $title, $instance, $this->id_base );

			echo wp_kses_post( $args['before_widget'] );
			if ( !empty($title) ){ 
				echo sprintf(' %1$s %2$s %3$s',wp_kses_post($args['before_title']),esc_html($title) ,wp_kses_post($args['after_title'])); 
			}
			if ($column == 2) {  
				echo '<div class="section-content row">'; 
				$array  = wp_get_nav_menu_items($nav_menu);
				if (!empty($array)){
					$pieces = array_chunk($array, ceil(count($array) / 2));
					if (count($pieces) > 0): 
					foreach ($pieces as $key => $value): 
						if (count($value) > 0):
							echo '<div class="col-md-6 col-sm-6 col-xs-6">';
							echo '<ul class="list-news list-unstyled  custom-menu-2-column">';
							foreach ($value as $k => $li):  
								echo sprintf('<li><a href="%1$s">%2$s</a></li>',esc_url($li->url),esc_html($li->title));
							endforeach;
							echo '</ul>'; 
							echo '</div>'; 
						endif; 
					endforeach; endif;
				}
			}else{ 
				echo '<div class="section-content">'; 
				wp_nav_menu( array( 'menu' => $nav_menu,'menu_class' => 'list-news list-unstyled  custom-menu-1-column') );
			}
			echo '</div>';
			echo wp_kses_post( $args['after_widget'] );

		}

		function update( $new_instance, $old_instance ) {
			$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
			$instance['column'] = strip_tags( stripslashes($new_instance['column']) );
			$instance['nav_menu'] = (int) $new_instance['nav_menu']; 
			return $instance;
		}

		function form( $instance ) {
			$title = isset( $instance['title'] ) ? $instance['title'] : '';
			$column = isset( $instance['column'] ) ? $instance['column'] : '1';
			$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';

			// Get menus
			$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

			// If no menus exists, direct the user to go and create some.
			if ( !$menus ) {
				echo sprintf( '<p>'.esc_html_e('No menus have been created yet.','bignews').'<a href="%s">'.esc_html_e('Create some','bignews').'</a>.', admin_url('nav-menus.php') ) .'</p>';
				return;
			}
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:','bignews') ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr($title); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('nav_menu') ); ?>"><?php esc_html_e('Select Menu:','bignews'); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id('nav_menu') ); ?>" name="<?php echo esc_attr( $this->get_field_name('nav_menu') ); ?>">
			<?php
				foreach ( $menus as $menu ) {
					$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
					echo '<option'. $selected .' value="'. esc_attr($menu->term_id) .'">'.esc_html( $menu->name ).'</option>';
				}
			?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('column') ); ?>"><?php esc_html_e('Select Style:','bignews'); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id('column') ); ?>" name="<?php echo esc_attr( $this->get_field_name('column') ); ?>">
					<option value="1" <?php if($column == '1') echo "selected='selected'" ?>>
						<?php echo esc_html_e('1 Column','bignews') ?>
					</option>
					<option value="2" <?php if($column == '2') echo "selected='selected'" ?>>
						<?php echo esc_html_e('2 Columns','bignews') ?>
					</option>
				</select> 
			</p>
			<?php
		}
	}