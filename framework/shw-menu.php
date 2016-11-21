<?php
	//Back end
	add_filter( 'wp_edit_nav_menu_walker', 'swbignews_edit_nav_menu', 10, 2 );
	function swbignews_edit_nav_menu( $walker, $menu_id ) {
		return 'Swbignews_Nav_Menu_Edit_Custom';
	}
	
	add_action( 'wp_update_nav_menu_item', 'swbignews_update_menu', 100, 3);

	//update menu
	function swbignews_update_menu($menu_id, $menu_item_db)
	{
		
		$check = array('show-megamenu','choose-icon','choose-widgetarea','show-widget','tab-title','megamenu-column','megamenu-widget-column');
		foreach ( $check as $key )
		{
			if(!isset($_POST['menu-item-shw-'.esc_attr($key)][$menu_item_db]))
			{
				$_POST['menu-item-shw-'.esc_attr($key)][$menu_item_db] = "";
			}
			$value = $_POST['menu-item-shw-'.esc_attr($key)][$menu_item_db];
			update_post_meta( $menu_item_db, '_menu-item-shw-'.esc_attr($key), $value );
		}
	}
if( !class_exists( 'Swbignews_Nav_Menu_Edit_Custom' ) )
{
	class Swbignews_Nav_Menu_Edit_Custom extends Walker_Nav_Menu
	{
		/**
		 * @see Walker_Nav_Menu::start_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int $depth Depth of page.
		 */
		public function start_lvl(&$output, $depth = 0, $args = array() ) {}

		/**
		 * @see Walker_Nav_Menu::end_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int $depth Depth of page.
		 */
		public function end_lvl(&$output, $depth = 0, $args = array()) {}
		/**
		 * @see Walker::start_el()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item Menu item data object.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param int $current_page Menu item ID.
		 * @param object $args
		 */
		public function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {
			global $_wp_nav_menu_max_depth;
			$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			ob_start();
			$item_id = esc_attr( $item->ID );
			$removed_args = array(
				'action',
				'customlink-tab',
				'edit-menu-item',
				'menu-item',
				'page-tab',
				'_wpnonce',
			);

			$original_title = '';
			if ( 'taxonomy' == $item->type ) {
				$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
			} elseif ( 'post_type' == $item->type ) {
				$original_object = get_post( $item->object_id );
				$original_title = $original_object->post_title;
			}

			$classes = array(
				'menu-item menu-item-depth-' . esc_attr($depth),
				'menu-item-' . esc_attr( $item->object ),
				'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
			);

			$title = $item->title;

			if ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
				$classes[] = 'pending';
				$title = sprintf( esc_html__('%s (Pending)', ''), $item->title );
			}

			$title = empty( $item->label ) ? $title : $item->label;

			$itemValue = "";
			if($depth == 0)
			{
				$itemValue = get_post_meta( $item->ID, '_menu-item-shw-megamenu', true);
				if($itemValue != "") $itemValue = 'shw_mega_active ';
			}
			?>
			<li id="menu-item-<?php echo esc_attr( $item_id ); ?>" class="<?php echo esc_attr( $itemValue ); echo ' ' . implode(' ', $classes ); ?>">
				<dl class="menu-item-bar">
					<dt class="menu-item-handle">
						<span class="item-title"><?php echo esc_html( $title ); ?></span>
						<span class="item-controls">
							<span class="item-type item-type-default"><?php echo esc_html( $item->type_label ); ?></span>
							<a class="item-edit" id="edit-<?php echo esc_attr( $item_id ); ?>" title="<?php esc_html_e('Edit Menu Item', 'bignews' ); ?>" href="<?php
								echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
							?>"><?php esc_html_e('Edit Menu Item', 'bignews' ); ?></a>
						</span>
					</dt>
				</dl>

				<div class="menu-item-settings" id="menu-item-settings-<?php echo esc_attr( $item_id ); ?>">
					<?php if( 'custom' == $item->type ) : ?>
						<p class="field-url description description-wide">
							<label for="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>">
								<?php esc_html_e( 'URL', 'bignews' ); ?><br />
								<input type="text" id="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
							</label>
						</p>
					<?php endif; ?>
					<p class="description description-thin description-label shw_label_desc_on_active">
						<label for="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>">
						<span class='shw_default_label'><?php esc_html_e( 'Navigation Label', 'bignews'  ); ?></span>
							<br />
							<input type="text" id="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
						</label>
					</p>
					<p class="description description-thin description-title">
						<label for="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Title Attribute', 'bignews'  ); ?><br />
							<input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
						</label>
					</p>
					<p class="field-link-target description description-thin">
						<label for="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Link Target', 'bignews'  ); ?><br />
							<select id="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-target" name="menu-item-target[<?php echo esc_attr( $item_id ); ?>]">
								<option value="" <?php selected( $item->target, ''); ?>><?php esc_html_e('Same window or tab', 'bignews' ); ?></option>
								<option value="_blank" <?php selected( $item->target, '_blank'); ?>><?php esc_html_e('New window or tab', 'bignews' ); ?></option>
							</select>
						</label>
					</p>
					<p class="field-css-classes description description-thin">
						<label for="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'CSS Classes (optional)' , 'bignews' ); ?><br />
							<input type="text" id="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
						</label>
					</p>
					<p class="field-xfn description description-thin">
						<label for="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Link Relationship (XFN)', 'bignews'  ); ?><br />
							<input type="text" id="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
						</label>
					</p>
					<p class="field-description description description-wide">
						<label for="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Description', 'bignews'  ); ?><br />
							<textarea id="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr( $item_id ); ?>]"><?php echo esc_html( $item->post_content ); ?></textarea>
						</label>
					</p>
					<?php do_action( 'wp_nav_menu_item_custom_fields', $item_id, $item, $depth, $args ); ?>
					
					<!--custom menu-->
					<div class='shw_menu_options'>
						<!--choose icon for each item-->
						<?php
						$key = "menu-item-shw-choose-icon";
						$value = get_post_meta( $item->ID, '_'.esc_attr($key), true );
						?>
						<p class="shw_mega_menu_d0 shw_text choose-icon  shw_mega_menu ">
							<label for="edit-<?php echo esc_attr( $key ) . '-' . esc_attr( $item_id ); ?>"><?php esc_html_e( 'Enter icon for this item' , 'bignews'); ?><br>
								<input type="text"  id="edit-<?php echo esc_attr( $key ) . '-' . esc_attr( $item_id ); ?>" class="menu-text-box <?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ) . "[". esc_attr( $item_id ) ."]";?>" value="<?php echo esc_attr( $value ); ?>" /><?php esc_html_e( 'Ex: fa fa-crosshairs', 'bignews' );?>
							</label>
						</p>
						<!--use mega menu-->
						<?php 
						$key = "menu-item-shw-show-megamenu";
						$show_megamenu  = get_post_meta( $item->ID, '_'.esc_attr($key), true);
						$megamenu_item = '';
						if( $show_megamenu  != "" ){
							$show_megamenu = "checked='checked'";
							$megamenu_item = "shw-mega-menu-d0";
						}
						?>
						<p class="description description-wide shw-show-megamenu shw-mega-menu-d0">
							<label for="edit-<?php echo esc_attr( $key ) . '-' . esc_attr( $item_id ); ?>">
								<input type="checkbox" value="active" id="edit-<?php echo esc_attr( $key ) . '-' .esc_attr( $item_id ); ?>" class=" <?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ) . "[". esc_attr( $item_id )."]";?>" <?php echo esc_attr( $show_megamenu ); ?> /><?php esc_html_e( 'Use as Mega Menu' , 'bignews'); ?>
							</label>
						</p>
						<!--Choose column for normal mega menu-->
						<?php
						$key = "menu-item-shw-megamenu-column";
						$value = get_post_meta( $item->ID, '_'.esc_attr($key), true);
						?>
						<p class="megamenu-column description description-wide <?php echo esc_attr( $megamenu_item ); ?>">
							<label for="edit-menu-item-megamenu-column-<?php echo esc_attr( $item_id ); ?>">
								<?php esc_html_e( 'Select column number for megamenu' , 'bignews'); ?>
								<select id="edit-menu-item-megamenu-column-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-megamenu-column" name="menu-item-shw-megamenu-column[<?php echo esc_attr( $item_id ); ?>]">
									<option value="0" <?php selected( $value, '0' ); ?>><?php esc_html_e( '1 Column' , 'bignews'); ?></option>
									<option value="1" <?php selected( $value, '1' ); ?>><?php esc_html_e( '2 Columns' , 'bignews'); ?></option>
									<option value="2" <?php selected( $value, '2' ); ?>><?php esc_html_e( '3 Columns' , 'bignews'); ?></option>
									<option value="3" <?php selected( $value, '3' ); ?>><?php esc_html_e( '4 Columns' , 'bignews'); ?></option>
								</select>
							</label>
						</p>
						<!--Use widget in menu-->
						<?php
						$key = "menu-item-shw-show-widget";
						$show_widget = get_post_meta( $item->ID, '_'.esc_attr($key), true);
						$widget_item = '';
						if( $show_widget != "" ){
							$show_widget = "checked='checked'";
							if ($show_megamenu != ""){
								$widget_item = "open";
							}
						}
						?>
						<p class="description description-wide show-widget <?php echo esc_attr( $megamenu_item ) ;?>">
							<label for="edit-<?php echo esc_attr( $key ) . '-' . esc_attr( $item_id ); ?>">
								<input type="checkbox" value="active" id="edit-<?php echo esc_attr( $key ) . '-' . esc_attr( $item_id ); ?>" class=" <?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ) . "[". esc_attr( $item_id ) ."]";?>" <?php echo esc_attr( $show_widget ); ?> /><?php esc_html_e( 'Use widget in  menu' , 'bignews'); ?>
							</label>
						</p>
						<!--Title for menu has widget-->
						<?php
							$key = "menu-item-shw-tab-title";
							$value = get_post_meta( $item->ID, '_'.esc_attr($key), true);
						?>
						<p class="shw_text tab-title shw_mega_menu <?php echo esc_attr( $widget_item );?> ">
							<label for="edit-<?php echo esc_attr( $key ) . '-' . esc_attr( $item_id ); ?>"><?php esc_html_e( 'Enter title  for menu has widget' , 'bignews'); ?><br>
								<input type="text"  id="edit-<?php echo esc_attr( $key ) . '-' . esc_attr( $item_id ); ?>" class="menu-text-box  <?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ) . "[". esc_attr( $item_id ) ."]";?>" value="<?php esc_attr( $value ); ?>" />
							</label>
						</p>
						 <!--Choose widget area-->
						<?php
						$key = "menu-item-shw-choose-widgetarea";
						$value = get_post_meta( $item->ID, '_'.esc_attr($key), true);?>
						<p class="description description-wide choose-widgetarea  <?php echo esc_attr( $widget_item ) ;?>">
							<label for="edit-menu-item-megamenu-widgetarea-<?php echo esc_attr( $item_id ); ?>">
								<?php esc_html_e( 'Select Widget Area' , 'bignews'); ?>
								<select id="edit-menu-item-megamenu-widgetarea-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-megamenu-widgetarea" name="menu-item-shw-choose-widgetarea[<?php echo esc_attr( $item_id ); ?>]">
									<option value="0"><?php esc_html_e( 'Select Widget Area' , 'bignews'); ?></option>
									<?php
									global $wp_registered_sidebars;
									if( ! empty( $wp_registered_sidebars ) && is_array( $wp_registered_sidebars ) ):
										foreach( $wp_registered_sidebars as $sidebar ):
									?>
									<option value="<?php echo esc_attr( $sidebar['id'] ); ?>" <?php selected( $value, $sidebar['id'] ); ?>><?php echo esc_html( $sidebar['name'] ); ?></option>
									<?php endforeach; ?>
									<?php endif; ?>
								</select>
							</label>
						</p>
						<!--Choose column for menu has widget-->
						<?php
						$key = "menu-item-shw-megamenu-widget-column";
						$value = get_post_meta( $item->ID, '_'.esc_attr($key), true);?>
						<p class="widget-column description description-wide  <?php echo esc_attr( $widget_item ) ;?>">
							<label for="edit-menu-item-megamenu-widget-column-<?php echo esc_attr( $item_id ); ?>">
								<?php esc_html_e( 'Select column to display Widget Area' , 'bignews'); ?>
								<select id="edit-menu-item-megamenu-widget-column-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-megamenu-widget-column" name="menu-item-shw-megamenu-widget-column[<?php echo esc_attr( $item_id ); ?>]">
									<option value="0" <?php selected( $value, '0' ); ?>><?php esc_html_e( '1 Column', 'bignews' )?></option>
									<option value="1" <?php selected( $value, '1' ); ?>><?php esc_html_e( '2 Columns', 'bignews' )?></option>
								</select>
							</label>
						</p>
						<!--End option-->

						<?php do_action('swbignews_mega_menu_option_fields', $output, $item, $depth, $args); ?>

						<div class="menu-item-actions description-wide submitbox">
							<?php if( 'custom' != $item->type ) : ?>
								<p class="link-to-original">
									<?php printf( esc_html__('Original: %s', 'bignews'), '<a href="' . esc_url( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
								</p>
							<?php endif; ?>
							<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr( $item_id ); ?>" href="<?php
							echo wp_nonce_url(
								add_query_arg(
									array(
										'action' => 'delete-menu-item',
										'menu-item' => $item_id,
									),
									remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
								),
								'delete-menu_item_' . $item_id
							); ?>"><?php esc_html_e('Remove', 'bignews'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo esc_attr( $item_id ); ?>" href="<?php echo add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) );
								?>#menu-item-settings-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e('Cancel', 'bignews'); ?></a>
						</div>

						<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item_id ); ?>" />
						<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
						<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
						<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
						<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
						<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
					</div>
				</div>
				<ul class="menu-item-transport"></ul>
			<?php
			$output .= ob_get_clean();
		} // end start_el func
	} // end class
	}

//Front end
	
	if( ! function_exists( 'swbignews_show_main_menu' ) ) {
		function swbignews_show_main_menu() {
			$walker = new Swbignews_Nav_Walker;
			if ( has_nav_menu( 'main-nav' ) ) {
				wp_nav_menu( array(
							'theme_location'  => 'main-nav',
							'container'       => 'ul',
							'menu_id'		  => 'main-navigation',
							'menu_class'      => 'menu nav nav-pills nav-justified navbar-collapse collapse',
							'walker'          => $walker
						));
			}
		}
	}
	
	/**
	 * Add class dropdown
	 */
	if( ! function_exists( 'swbignews_menu_set_dropdown' ) ) {
		function swbignews_menu_set_dropdown( $sorted_menu_items, $args ) {
			$last_top = 0;
			foreach( $sorted_menu_items as $key=> $obj ) {
				// it is a top level item ?
				if(0 == $obj->menu_item_parent) {
					// set the key of the parent
					$last_top = $key;
				} else {
					$sorted_menu_items[$last_top]->classes['dropdown'] = 'dropdown';
				}
			}
			return $sorted_menu_items;
		}
	}
	add_filter('wp_nav_menu_objects', 'swbignews_menu_set_dropdown', 10, 2);

	/**
	 * Menu multi level
	 */
	class Swbignews_Nav_Walker extends Walker_Nav_Menu {
		var $mega_active = 0;
		var $icon = "";
		var $mega_widget_active = 0;
		var $menu_megamenu_widgetarea  = "";
		var $menu_tab_title = "";
		var $id = 0;
		var $megamenu_column = 0;
		var $widget_column = 0;
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			global $swbignews_options;
			if ( isset( $swbignews_options['shw-menu-style'] ) ){
				$default_menu_style = $swbignews_options['shw-menu-style'];
			}
			else{
				$default_menu_style = 'dark';
			}
			$indent = str_repeat( "\t", $depth );
			 if ($this->mega_active == "active" ){
				if($this->mega_widget_active == "active" ){
					if( $depth == 0 ) {
						$output .= $indent.'<ul class="dropdown-menu '.esc_attr($default_menu_style).'">
								<li>
								<div class="mega-menu mega-menu-style-2">
								<div class="row">
								<div class="col-md-3 col-sm-3 menu-left">
								<ul role="tablist" class="nav nav-tabs">';
						if ( !empty( $this->menu_tab_title ) ){
							$output .= '<li><p class="title tab-title">'.wp_kses_post($this->menu_tab_title).'</p></li>';
						}	
					}
				}
				else {
					if( $depth == 0 ) {
							$output .= $indent.'<ul class="dropdown-menu '.esc_attr($default_menu_style).'">
									<div class="mega-menu mega-menu-style-1">
									<div class="row">';
					}else{
						$output .=  "\n$indent<ul>";
					}
				}
			}
			//dropdown menu
			else {
				if( $depth == 0 ) {
					$output .= $indent.'<ul class="dropdown-menu dropdown-menu-st-1 pull-left '.esc_attr($default_menu_style).'">';
				}
				else {
					$output .= $indent.'<ul class="dropdown-menu  dropdown-menu-level-2 dropdown-menu-level-2-st-1 '.esc_attr($default_menu_style).'">';
				}
			}
		}

		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat( "\t", $depth );
			if ($this->mega_active == "active" ){
				if($this->mega_widget_active == "active" ){
					if( $depth == 0 ) {
						$output .= "</ul></div><div class=\"col-md-9 col-sm-9\"><div class=\"tab-content\"></div></div></div></div></li></ul>\n";
					}
				}
				else{
					if( $depth == 0 ) {
						$output .= "$indent</div></div></ul>\n"; 
					}else{
						$output .= "$indent</ul>";
					}
				}
			}
			else{
				$output .= "$indent</ul>\n"; 
			}
		}

		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $swbignews_options;
			$default_icon = $swbignews_options['shw-submenu-icon'];
			$this->icon = get_post_meta( $item->ID, '_menu-item-shw-choose-icon', true);
			if ( empty( $this->icon ) ){
				if ( !empty( $swbignews_options['shw-submenu-icon']) && $swbignews_options['shw-submenu-icon-show'] == 'on'  ) {
					$default_icon  = $swbignews_options['shw-submenu-icon'];
				}
			}else{
				$default_icon = $this->icon;
			}
			$this->menu_megamenu_widgetarea = get_post_meta( $item->ID, '_menu-item-shw-choose-widgetarea', true);
			$this->widget_column = get_post_meta( $item->ID, '_menu-item-shw-megamenu-widget-column', true);
			if ( $this->widget_column == 0 ){
				$this->widget_column = 'col-md-12';
			}
			else if ( $this->widget_column == 1 ){
				$this->widget_column = 'col-md-6';
			}
		
			if( empty( $args ) ) {
				return '';
			}
			$args = (object) $args;
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			
			if ($depth === 0){

				$this->megamenu_column = get_post_meta( $item->ID, '_menu-item-shw-megamenu-column', true);
				$this->mega_active = get_post_meta( $item->ID, '_menu-item-shw-show-megamenu', true);
				$this->mega_widget_active = get_post_meta( $item->ID, '_menu-item-shw-show-widget', true);
				$this->menu_tab_title = get_post_meta( $item->ID, '_menu-item-shw-tab-title', true);
				
			}
			if ($this->mega_active == "active"){
				if($this->mega_widget_active == "active") {
					$classes = empty( $item->classes ) ? array() : (array) $item->classes;
					$classes[] = 'menu-item-' . $item->ID;
					$class_names = join( ' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
					if( $depth == 0 ) {
						$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . ' mega-menu-dropdown mega-menu-full menu-text-dropdown shw-menu-tab" ' : '';
					}
					else if( $depth == 1 ){
						$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . ' shw-tab-item" ' : '';
					}

					$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
					$tab_id = $id;
					$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
					if ($depth == 0 ) {
						$output .= $indent . '<li' . $id . $class_names .'>';
					}else if ( $depth == 1 ){
						$output .= $indent . '<li' . $id . $class_names .'data-column="'.wp_kses_post($this->widget_column). '" role="presentation">';
					}

					$atts = array();
					$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
					$atts['target'] = ! empty( $item->target ) ? $item->target : '';
					$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
					$atts['href']   = ! empty( $item->url ) ? $item->url : '';

					$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

					$attributes = '';
					foreach( $atts as $attr=> $value ) {
						if( ! empty( $value ) ) {
							$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
							$attributes .= ' ' . $attr . '="' . $value . '"';
						}
					}

					$item_output = $args->before;

					if( $depth == 0 ) {
						$item_output .= '<a  class="list-main-menu" data-hover="dropdown"' . $attributes . '>'.'<i class="'.esc_attr($default_icon).'"></i>';
						$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
						if( $args->walker->has_children ){
							$item_output .= '<span class="icon-dropdown fa fa-angle-down hidden-sm hidden-xs"></span></a>';
						}else{
							$item_output .= '</a>';
						}
					} else if ( $depth == 1){
						$item_output .= '<a href=".tab_'.esc_attr($tab_id).'" role="tab" data-toggle="tab" class="tag-hover"> '.'<i class="'.esc_attr($default_icon).'"></i>';
						$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
						$item_output .= '</a>';
						//add widget
						if( $this->menu_megamenu_widgetarea && is_active_sidebar( $this->menu_megamenu_widgetarea )) {
							$item_output .= '<div  class="tab-pane fade tab_'.esc_attr($tab_id).'"><div class="tab-widget">';
							ob_start();
							if ( is_active_sidebar( $this->menu_megamenu_widgetarea ) ) {
								dynamic_sidebar( $this->menu_megamenu_widgetarea );
							}
							$item_output .= ob_get_clean() . '</div></div>';
						}else{
							$item_output .= '<div class="tab-pane fade tab_'.esc_attr($tab_id).'"></div>';
						}
					}
					$item_output .= $args->after;
					$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
						
					}
					//mega menu
				else {
					if ( $this->megamenu_column == 0 ){
						$megamenu_column = "col-md-12 col-sm-12";
					}
					else if ( $this->megamenu_column == 1 ){
						$megamenu_column = "col-md-6 col-sm-6";
					}
					else if ( $this->megamenu_column == 2 ){
						$megamenu_column = "col-md-4 col-sm-4";
					}
					else {
						$megamenu_column = "col-md-3 col-sm-4";
					}
					$classes = empty( $item->classes ) ? array() : (array) $item->classes;
					$classes[] = 'menu-item-' . $item->ID;
					$class_names = join( ' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );

					if( $depth == 0  ) {
						if ($args->walker->has_children){
						$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . ' mega-menu-dropdown mega-menu-full menu-text-dropdown" ' : '';
						}
					}
					else {
						$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '" ' : '';
					}

					$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
					$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
					
					if($depth == 1){
						$output .= $indent . '<div class="'.esc_attr($megamenu_column).'"><div class="mega-menu-submenu border-right"><li' . $id . $class_names . '>';
					}
					else
					{
						$output .= $indent . '<li' . $id . $class_names . '>';
					}

					$atts = array();
					$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
					$atts['target'] = ! empty( $item->target ) ? $item->target : '';
					$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
					$atts['href']   = ! empty( $item->url ) ? $item->url : '';

					$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

					$attributes = '';
					foreach( $atts as $attr=> $value ) {
						if( ! empty( $value ) ) {
							$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
							$attributes .= ' ' . $attr . '="' . $value . '"';
						}
					}

					$item_output = $args->before;
					
					if( $depth == 0 ) {
						$item_output .= '<a class="list-main-menu" data-hover="dropdown"' . $attributes . '>'.'<i class="'.esc_attr($default_icon).'"></i>';
					} else if( $depth == 1 ){
						$item_output .= '<p class="title">';
					}else if( $depth > 1 ){
						if( $args->walker->has_children ) {
							$item_output .='<a class="tag-hover" '. $attributes .'>';
							$item_output .= '<i class="'.esc_attr($default_icon).' "></i>' .'<span class="submenu-title">';
						}
						else{
							$item_output .='<a  class="tag-hover" '. $attributes .'>'.'<i class="'.esc_attr($default_icon).' "></i>';
						}
					}
					$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
					if( $depth == 0 ) {
						if( $args->walker->has_children ){
							$item_output .= '<span class="icon-dropdown fa fa-angle-down hidden-sm hidden-xs"></span></a>';
						}else{
							$item_output .= '</a>';
						}
					} else if($depth == 1){
						$item_output .= '</p>';
					}
					else if ($depth > 1){ 
						if( $args->walker->has_children )
						{
							$item_output .='</span></a>';
						} else {
							$item_output .='</a>';
						}
					}
					$item_output .= $args->after;
					$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
				}
			}
		//dropdown
			else{
				$classes = empty( $item->classes ) ? array() : (array) $item->classes;
				$classes[] = 'menu-item-' . $item->ID;
				$class_names = join( ' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
				if( $depth == 0 && $args->walker->has_children ) {
					$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . ' dropdown dropdown-basic" ' : '';
				}
				else if( $depth > 0 && $args->walker->has_children ) {
					$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . ' dropdown-submenu" ' : '';
				}
				else {
					$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '" ' : '';
				}

				$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
				$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
				$output .= $indent . '<li' . $id . $class_names . '>';

				$atts = array();
				$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
				$atts['target'] = ! empty( $item->target ) ? $item->target : '';
				$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
				$atts['href']   = ! empty( $item->url ) ? $item->url : '';

				$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
				$attributes = '';
				foreach( $atts as $attr => $value ) {
					if( ! empty( $value ) ) {
						$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_url( $value );
						$attributes .= ' ' . $attr . '="' . $value . '"';
					}
				}
				
				$item_output = $args->before;

				if( $depth == 0 ) {
					$item_output .= '<a  class="list-main-menu" data-hover="dropdown"' . $attributes . '>'.'<i class="'.esc_attr($default_icon).'"></i>';
				} 
				else{
					$item_output .= '<a class="tag-hover" ' . $attributes . '><i class="'.esc_attr($default_icon).'"></i><span class="submenu-title">';
				}
				$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
				if( $depth == 0 ) {
					if( $args->walker->has_children ){
							$item_output .= '<span class="icon-dropdown fa fa-angle-down hidden-sm hidden-xs"></span></a>';
						}else{
							$item_output .= '</a>';
						}
				}else{
					$item_output .= '</span></a>';
				}
				$item_output .= $args->after;
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}
			
		}

		public function end_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			$mega = get_post_meta( $item->ID, '_menu-item-shw-megamenu', true);
			//	tab menu
			if ($this->mega_widget_active == "active" && $this->mega_active == "active"){
					$output .= "</li>\n";
			}
			//mega menu
			else if ($this->mega_widget_active != "active" && $this->mega_active == "active") {
				if($depth == 1){
					$output .= "</li></div></div>";
				}
				else{
					$output .= "</li>";
				}
			}
			//dropdown menu
			else {
				$output .= "</li>\n";
			}
		}
	}