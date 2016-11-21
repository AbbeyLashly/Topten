<?php
/**
 * Options Config (ReduxFramework Sample Config File).
 *
 * For full documentation, please visit: https://docs.reduxframework.com
 *
 */

if (!class_exists('Swbignews_Redux_Framework_Config')) {

	class Swbignews_Redux_Framework_Config {

		public $args     = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		public function __construct() {

			if ( ! class_exists('ReduxFramework') ) {
				return;
			}

			// This is needed. Bah WordPress bugs.  ;)
			if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
				$this->initSettings();
			} else {
				add_action('plugins_loaded', array($this, 'initSettings'), 10);
			}

		}

		public function initSettings() {

			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();

			// Set a few help tabs so you can see how it's done
			$this->setHelpTabs();

			// Create the sections and fields
			$this->setSections();

			if (!isset($this->args['opt_name'])) { // No errors please
				return;
			}

			// If Redux is running as a plugin, this will remove the demo notice and links
			add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

			$this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
		}

		/**
		 * This is a test function that will let you see when the compiler hook occurs.
		 *
		 * It only runs if a field   set with compiler=>true is changed.
		 */
		function compiler_action($options, $css) {
			return;
		}

		/**
		 * Custom function for filtering the sections array.
		 *
		 */
		function dynamic_section($sections) {
			$sections[] = array(
				'title'  => esc_html__('Section via hook', 'bignews'),
				'desc'   => wp_kses_post('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>'),
				'icon'   => 'el-icon-paper-clip',
				// Leave this as a blank section, no options just some intro text set above.
				'fields' => array()
			);

			return $sections;
		}

		/**
		 * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
		 *
		 */
		function change_arguments($args) {
			return $args;
		}

		/**
		 * Filter hook for filtering the default value of any given field. Very useful in development mode.
		 */
		function change_defaults($defaults) {
			$defaults['str_replace'] = 'Testing filter hook!';

			return $defaults;
		}

		// Remove the demo link and the notice of integrated demo from the redux-framework plugin
		function remove_demo() {

			// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
			if ( class_exists('ReduxFrameworkPlugin') ) {
				remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

				// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
				remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
			}
		}

		public function setSections() {

			/*
			  Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
			*/
			// Background Patterns Reader
			$sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
			$sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
			$sample_patterns        = array();
			$image_opt_path         = get_template_directory_uri() . '/assets/admin/images/';

			if ( is_dir( $sample_patterns_path ) ) {

				if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
					$sample_patterns = array();

					while ( ( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false ) {

						if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
							$name = explode( '.', $sample_patterns_file );
							$name = str_replace( '.' . end($name), '', $sample_patterns_file );
							$sample_patterns[] = array( 'alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file );
						}
					}
				}
			}

			ob_start();

			$ct          = wp_get_theme();
			$this->theme = $ct;
			$item_name   = $this->theme->get('Name');
			$tags        = $this->theme->Tags;
			$screenshot  = $this->theme->get_screenshot();
			$class       = $screenshot ? 'has-screenshot' : '';

			$customize_title = sprintf( esc_html__( 'Customize &#8220;%s&#8221;', 'bignews' ), $this->theme->display('Name') );

			?>
			<div id="current-theme" class="<?php echo esc_attr($class); ?>">
			<?php if ( $screenshot ) : ?>
				<?php if ( current_user_can('edit_theme_options') ) : ?>
						<a href="<?php echo esc_url(wp_customize_url()); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
							<img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview', 'bignews'); ?>" />
						</a>
				<?php endif; ?>
					<img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview', 'bignews' ); ?>" />
				<?php endif; ?>

				<h4><?php echo esc_html( $this->theme->display('Name') ); ?></h4>

				<div>
					<ul class="theme-info">
						<li><?php printf(esc_html__('By %s', 'bignews'), $this->theme->display('Author')); ?></li>
						<li><?php printf(esc_html__('Version %s', 'bignews'), $this->theme->display('Version')); ?></li>
						<li><?php echo '<strong>' . esc_html__('Tags', 'bignews') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
					</ul>
					<p class="theme-description"><?php echo esc_html( $this->theme->display('Description') ); ?></p>
			<?php
			if ( $this->theme->parent() ) {
				printf(' <p class="howto">' . wp_kses_post('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', esc_url('http://codex.wordpress.org/Child_Themes'), $this->theme->parent()->display('Name'));
			}
			?>

				</div>
			</div>

			<?php
			$item_info = ob_get_contents();

			ob_end_clean();

			global $swbignews_translate_option;

			// ACTUAL DECLARATION OF SECTIONS
			// General setting
			$this->sections[] = array(
				'title'     => esc_html__( 'General', 'bignews' ),
				'icon'      => 'el-icon-adjust-alt',
				'fields'    => array(
					array(
						'id'       => 'shw-layout',
						'type'     => 'image_select',
						'title'    => esc_html__( 'Layout Display', 'bignews' ),
						'subtitle' => esc_html__( 'Choose type of layout', 'bignews' ),
						'desc'     => esc_html__( 'This option will change layout for all page of theme.', 'bignews' ),
						'options'  => array(
							'1' => array(
								'alt' => 'Fluid',
								'img' => esc_url($image_opt_path) . 'full.png'
							),
							'2' => array(
								'alt' => 'Boxed',
								'img' => esc_url($image_opt_path) . 'boxed.png'
							),
						),
						'default'  => '1'
					),
					array(
						'id'             => 'shw-layout-boxed-width',
						'type'           => 'dimensions',
						'units_extended' => false,
						'title'          => esc_html__( 'Body Boxed Width', 'bignews' ),
						'required'       => array( 'shw-layout', '=', '2' ),
						'height'         => false,
						'default'        => array(
							'width'  => '1200',
							'height' => 'auto'
						)
					),
					array(
						'id'       => 'shw-layout-boxed-background',
						'type'     => 'background',
						'title'    => esc_html__( 'Body Background', 'bignews' ),
						'subtitle'    => esc_html__( 'Choose the background of body', 'bignews' ),
						'default'  => array(
							'background-color'      => '#ffffff',
							'background-image'      => '',
							'background-repeat'     => 'no-repeat',
							'background-attachment' => '',
							'background-position'	=> 'center center',
							'background-size'		=> 'cover'
						)
					),
					array(
						'id'       => 'shw-logo-header',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Header Logo', 'bignews' ),
						'compiler' => 'true',
						'subtitle' => esc_html__( 'Upload your header logo .png or .jpg', 'bignews' ),
						'default'  => array( 'url' => SWBIGNEWS_LOGO_BLACK )
					),
					array(
						'id'       => 'shw-logo-footer',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Footer Logo', 'bignews' ),
						'compiler' => 'true',
						'subtitle' => esc_html__( 'Upload your footer logo .png or .jpg', 'bignews' ),
						'default'  => array( 'url' => SWBIGNEWS_LOGO_WHITE )
					),
					array(
						'id'       => 'shw-logo-alt',
						'type'     => 'text',
						'title'    => esc_html__( 'Logo Alt Attribute', 'bignews' ),
						'subtitle' 	   => esc_html__( 'It\'s useful for SEO and generally is the name of the site.', 'bignews' ),
						'default'  => get_bloginfo('title')
					),
					array(
						'id'       => 'shw-logo-title',
						'type'     => 'text',
						'title'    => esc_html__( 'Logo Title Attribute', 'bignews' ),
						'subtitle' 	   => esc_html__( 'This attribute specifies extra information about the logo.', 'bignews' ),
						'default'  => get_bloginfo('title')
					),
					array(
						'id'       => 'shw-favicon',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Favicon Icon', 'bignews' ),
						'compiler' => 'true',
						'subtitle' => esc_html__( 'Optional - upload a favicon image (16 x 16px) .ico', 'bignews' ),
						'default'  => array( 'url' => SWBIGNEWS_FAVICON )
					),
					array(
						'id'        => 'shw-sticky',
						'type'      => 'switch',
						'title'     => esc_html__( 'Header Sticky Enable', 'bignews' ),
						'subtitle'  => esc_html__( 'Enable or disable fixed header when scroll', 'bignews' ),
						'required'	=> array( '1','=','2'),
						'default'   => true,
					),
					array(
						'id'       => 'shw-backtotop',
						'type'     => 'switch',
						'title'    => esc_html__( 'To Top Button', 'bignews' ),
						'subtitle' => esc_html__( 'Setting for back to top button', 'bignews' ),
						'on'       => 'Show',
						'off'      => 'Hide',
						'default'  => true
					),
				)
			);

			// Social
			$this->sections[] = array(
				'title'     => esc_html__( 'Social', 'bignews' ),
				'desc'	=> wp_kses_post( 'These information will be used for content in <strong>Header</strong> & <strong>Footer</strong>' ),
				'icon'      => 'el-icon-group-alt',
				'fields'    => array(
					array(
						'id'       => 'shw-social-facebook',
						'type'     => 'text',
						'title'    => esc_html__( 'Facebook', 'bignews' ),
						'default'  => 'http://facebook.com'
					),
					array(
						'id'       => 'shw-social-twitter',
						'type'     => 'text',
						'title'    => esc_html__( 'Twitter', 'bignews' ),
						'default'  => 'http://twitter.com'
					),
					array(
						'id'       => 'shw-social-google-plus',
						'type'     => 'text',
						'title'    => esc_html__( 'Googleplus', 'bignews' ),
						'default'  => 'https://plus.google.com/'
					),
					array(
						'id'       => 'shw-social-pinterest',
						'type'     => 'text',
						'title'    => esc_html__( 'Pinterest', 'bignews' ),
						'default'  => 'https://pinterest.com/'
					),
					array(
						'id'       => 'shw-social-instagram',
						'type'     => 'text',
						'title'    => esc_html__( 'Instagram', 'bignews' ),
						'default'  => 'http://instagram.com'
					),
					array(
						'id'       => 'shw-social-dribbble',
						'type'     => 'text',
						'title'    => esc_html__( 'Dribbble', 'bignews' ),
						'default'  => 'http://dribbble.com'
					),
				)
			);
			// $this->sections[] = array(
			// 	'title'   => esc_html__( 'Layout Setting', 'bignews' ),
			// );
			// Header setting
			$this->sections[] = array(
				'title'   => esc_html__( 'Header', 'bignews' ),
				'desc'    => esc_html__( 'This Section will change setting for header', 'bignews' ),
				'icon'    => 'el-icon-caret-up',
				'fields'  => array(
					array(
						'id'     => 'opt-notice-info',
						'type'   => 'info',
						'notice' => false,
						'style'  => 'info',
						'title'  => esc_html__( 'Describe content of all elements in header', 'bignews' ),
						'desc'   => wp_kses_post(' - "Social list" will get data from "Social" option<br>- "Top Navigation" will get data of Top Menu in "Appearance -> Menus"<br>- "Top Banner" will get data of Top Banner in "Theme Options -> Advertisement Settings"<br>- "Breaking News option", "Phone", "Email" get data from below field')
					),
					array(
						'id'        => 'shw-header-content-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Header Top', 'bignews' ),
						'subtitle'  => esc_html__( 'Configure detailed information for each content in header', 'bignews' ),
						'indent'    => true,
					), 
					array(
						'id'       => 'shw-header-custom-left',
						'type'     => 'sorter',
						'title'     => esc_html__( 'Header Left Content', 'bignews' ),
						'options'  => array(
							'disabled' => array(
								'search'	 		=> 'Search Form',
								'nav' 				=> 'Top Navigation',
								'language'			=> 'Language Bar',
								'breakingnews'		=> 'Breaking News',
							),
							'enabled'  => array(
								'social'			=> 'Social List',
							),
						),
					),
					array(
						'id'       => 'shw-header-custom-right',
						'type'     => 'sorter',
						'title'     => esc_html__( 'Header Right Content', 'bignews' ),
						'options'  => array(
							'disabled' => array(
								'nav' 				=> 'Top Navigation',
								'social'			=> 'Social List',
								'login'				=> 'Login Bar',
								'language'			=> 'Language Bar',
							),
							'enabled'  => array(
								'search'			=> 'Search Form',
							),
						),
					),
					array(
						'id'        => 'shw-header-main-content-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Header Main', 'bignews' ),
						'subtitle'  => esc_html__( 'Configure detailed information for each content in header', 'bignews' ),
						'indent'    => true,
					),
					array(
					    'id'       => 'shw-header-logo-pos',
					    'type'     => 'button_set',
					    'title'    => esc_html__('Logo Position', 'bignews'),
					    'options'  => array(
					        'left' 		=> 'Left',
					        'right'		=> 'Right',
					    ),
					    'default' => 'left'
					),
					array(
						'id'       => 'shw-header-main-content',
						'type'     => 'sorter',
						'title'     => esc_html__( 'Header Main Content', 'bignews' ),
						'options'  => array(
							'disabled' => array(
								'phone-group' 			=> 'Phone Group',
								'email-group'			=> 'Email Group',
								'social'				=> 'Social List',
							),
							'enabled'  => array(
								'banner' 				=> 'Top Banner',
							),
						),
					),
					array(
						'id'        => 'shw-beside-logo',
						'type'      => 'section',
						'title'     => esc_html__( 'Content In Header', 'bignews' ),
						'subtitle'  => esc_html__( 'Configure content for social list, phone, email in header', 'bignews' ),
						'indent'    => true,
					),
					array(
						'id'       => 'shw-header-social',
						'type'     => 'sorter',
						'title'    => 'Social List',
						'options'  => array(
							'disabled' => array(
								'instagram'	 	=> 'Instagram',
								'dribbble' 	 	=> 'Dribbble',
								'pinterest'	 	=> 'Pinterest',
							),
							'enabled'  => array(
								'facebook'    	=> 'Facebook',
								'google-plus' 	=> 'Google plus',
								'twitter'     	=> 'Twitter',
							),
						),
					),
					array(
						'id'       => 'shw-phone-1',
						'type'     => 'text',
						'title'    => esc_html__( 'Phone 1', 'bignews' ),
						'default'  => ' '
					),

					array(
						'id'       => 'shw-phone-2',
						'type'     => 'text',
						'title'    => esc_html__( 'Phone 2', 'bignews' ),
						'default'  => ' ',
					),
					array(
						'id'       => 'shw-email-1',
						'type'     => 'text',
						'title'    => esc_html__( 'Email 1', 'bignews' ),
						'default'  => ' ',
					),

					array(
						'id'       => 'shw-email-2',
						'type'     => 'text',
						'title'    => esc_html__( 'Email 2', 'bignews' ),
						'default'  => ' ',
					),
					array(
						'id'        => 'shw-breakingnews-title',
						'type'      => 'section',
						'title'     => esc_html__( 'Breaking News Option', 'bignews' ),
						'subtitle'  => esc_html__( 'Edit info appear in breaking news', 'bignews' ),
						'indent'    => true,
					),
					array(
						'id'       => 'shw-breakingnews-number',
						'type'     => 'text',
						'title'    => esc_html__( 'Number Breaking Posts To Show', 'bignews' ),
						'default'  => '3'
					),
					array(
					    'id'       => 'shw-breakingnews',
					    'type'     => 'button_set',
					    'title'    => esc_html__('Breaking News Query', 'bignews'),
					    'options'  => array(
					        'categories' 	=> 'Categories',
					        'tags' 		=> 'Tags',
					        'posts'		=> 'Posts',
					    ),
					    'default' => 'categories'
					),
					array(
						'id'       	=> 'shw-breakingnews-cat',
						'type'     	=> 'select',
						'data'     	=> 'categories',
						'multi'		=> true,
						'title'    	=> esc_html__( 'Breaking News Query By Categories', 'bignews' ),
						'required'  => array( 'shw-breakingnews', '=', 'categories' ),
						'default'  	=> ''
					),
					array(
						'id'       	=> 'shw-breakingnews-tag',
						'type'     	=> 'select',
						'data'     	=> 'tags',
						'multi'		=> true,
						'title'    	=> esc_html__( 'Breaking News Query By Tags', 'bignews' ),
						'required'  => array( 'shw-breakingnews', '=', 'tags' ),
						'default'  	=> ''
					),
					array(
						'id'       	=> 'shw-breakingnews-post',
						'type'     	=> 'select',
						'data'     	=> 'posts',
						'multi'		=> true,
						'title'    	=> esc_html__( 'Breaking News Query By Posts', 'bignews' ),
						'required'  => array( 'shw-breakingnews', '=', 'posts' ),
						'default'  	=> ''
					),
					array(
						'id'       	=> 'shw-breakingnews-orderby',
						'type'     	=> 'select',
						'data'     	=> 'posts',
						'title'    	=> esc_html__( 'Order By', 'bignews' ),
						'options'  	=> array(
					        'ID' 		=> 'ID',
					        'title' 	=> 'Title',
					        'date' 		=> 'Date',
					        'author'	=> 'Author'
					    ),
						'default'  	=> 'date'
					),
					array(
						'id'       	=> 'shw-breakingnews-order',
						'type'     	=> 'select',
						'data'     	=> 'posts',
						'title'    	=> esc_html__( 'Order', 'bignews' ),
						'options'  	=> array(
					        'DESC' 		=> 'DESC',
					        'ASC' 		=> 'ASC',
					    ),
						'default'  	=> 'DESC'
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					array(
						'id'        => 'shw-header-bearking-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Options Below Navigation', 'bignews' ),
						'subtitle'  => esc_html__( 'Configure content for each location in header', 'bignews' ),
						'indent'    => true,
					),
					
					array(
					    'id'       => 'shw-breakingnews-breadcrumb',
					    'type'     => 'button_set',
					    'title'    => esc_html__('Show Below Menu', 'bignews'),
					    'options'  => array(
					        'breaking_news' 			=> 'Breaking News',
					        'breadcrumb' 			=> 'Breadcumb',
					        'none'					=> 'None',
					    ),
					    'default' => 'breadcrumb'
					),

					array(
						'id'        => 'shw-breakingnews-date',
						'type'      => 'switch',
						'title'     => esc_html__( 'Date Time Text', 'bignews' ),
						'subtitle'  => esc_html__( 'Enable or disable date time text', 'bignews' ),
						'default'   => true,
					),
			
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),

				)
			);

			// Header Styling
			$this->sections[] = array(
				'title'    => esc_html__( 'Header Styling', 'bignews' ),
				'desc'     => esc_html__( 'Configuration for main navigation on top', 'bignews' ),
				'icon'     => 'el-icon-brush',
				'fields'   => array(
					array(
						'id'        => 'shw-headertop-style',
						'type'      => 'section',
						'title'     => esc_html__( 'Header Top', 'bignews' ),
						'subtitle'  => esc_html__( 'Configuration header top style', 'bignews' ),
						'indent'    => true,
					),
					array(
						'id'        => 'shw-headertop-bg',
						'type'      => 'color_rgba',
						'title'     => esc_html__( 'Header Top Background', 'bignews' ),
						'subtitle'  => esc_html__( 'Set background color', 'bignews' ),
						'default'   => array(
							'color'    => '#f1f1f1',
							'alpha'    => '1',
							'rgba'     => 'rgba(241, 241, 241, 1)'
						),
						'mode'      => 'background',
						'validate'  => 'colorrgba'
					),
					array(
						'id'        => 'shw-headertop-text',
						'type'      => 'color_rgba',
						'title'     => esc_html__( 'Header Top Text Color', 'bignews' ),
						'subtitle'  => esc_html__( 'Set text color', 'bignews' ),
						'default'   => array(
							'color'    => '#737373',
							'alpha'    => '1',
							'rgba'     => 'rgba(115, 115, 115, 1)'
						),
						'mode'      => 'background',
						'validate'  => 'colorrgba'
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					array(
						'id'        => 'shw-submenu-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Main Menu Setting', 'bignews' ),
						'subtitle'  => esc_html__( 'Configuration for Main Menu', 'bignews' ),
						'indent'    => true,
					),
					array(
						'id'        => 'shw-menu-custom',
						'type'      => 'switch',
						'title'     => esc_html__( 'Main Menu Custom', 'bignews' ),
						'on'        => 'Custom',
						'off'       => 'Default',
						'default'   => false,
					),
					array(
						'id'        => 'shw-menu-item-bg',
						'type'      => 'link_color',
						'title'     => esc_html__( 'Menu Item Background', 'bignews' ),
						'subtitle'  => esc_html__( 'Set background for Menu item', 'bignews' ),
						'required'  => array( 'shw-menu-custom', '=', true ),
						'default'   => array(
							'regular'   => '#140909',
							'hover'     => '#1c1c1c',
							'active'    => '#1c1c1c',
							'visited'   => '#1c1c1c'
						)
					),
					array(
						'id'        => 'shw-menu-item-text',
						'type'      => 'link_color',
						'title'     => esc_html__( 'Menu Item Color', 'bignews' ),
						'subtitle'  => esc_html__( 'Set color for Menu item', 'bignews' ),
						'required'  => array( 'shw-menu-custom', '=', true ),
						'default'   => array(
							'regular'   => 'rgba(255, 255, 255, 0.6)',
							'hover'     => '#ffffff',
							'active'    => '#ffffff',
							'visited'   => '#ffffff'
						)
					),
					array(
						'id'             => 'shw-menu-padding',
						'type'           => 'spacing',
						'mode'           => 'padding',
						'required'  => array( 'shw-menu-custom', '=', true ),
						'all'            => false,
						'left'			 => false,
						'right'			 => false,
						'units'          => 'px',
						'units_extended' => 'false',
						'title'          => esc_html__( 'Menu Item Padding', 'bignews' ),
						'subtitle'       => esc_html__( 'Choose inwards spacing for each menu item', 'bignews' ),
						'desc'           => esc_html__( 'unit is "px"', 'bignews' ),
						'default'        => false
					),
					array(
						'id'        => 'shw-submenu-icon-show',
						'type'      => 'switch',
						'title'     => esc_html__( 'Show Icon In Submenu', 'bignews' ),
						'subtitle'  => esc_html__( 'Choose to show or hide icon for item in submenu', 'bignews' ),
						'on'        => 'Show',
						'off'       => 'Hide',
						'default'   => false,
					),
					array(
						'id'        => 'shw-submenu-icon',
						'type'      => 'text',
						'title'     => esc_html__( 'Default Icon Classess', 'bignews' ),
						'subtitle'	=> esc_html__( 'Menu item will use this when icon option in "Appearance -> Menus" leave empty', 'bignews' ),
						'description' => wp_kses_post( 'Ex: "fa fa-angle-right". Please go on <a href="' . SWBIGNEWS_FONT_AWESOME_URL . '">FortAwesome</a> for more detailed.'),
						'default'   => 'fa fa-angle-right',
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					array(
						'id'        => 'shw-submenu-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Dropdown Menu Setting', 'bignews' ),
						'subtitle'  => esc_html__( 'Configuration for submenu', 'bignews' ),
						'indent'    => true,
					),
					array(
						'id'        => 'shw-submenu-custom',
						'type'      => 'switch',
						'title'     => esc_html__( 'Dropdown Menu Custom', 'bignews' ),
						'subtitle'	=> esc_html__( 'In default, dropdown menu will follow "Submenu Style" above', 'bignews' ),
						'on'        => 'Custom',
						'off'       => 'Default',
						'default'   => false,
					),
					array(
						'id'        => 'shw-submenu-bg',
						'type'      => 'color_rgba',
						'title'     => esc_html__( 'Submenu Background', 'bignews' ),
						'subtitle'  => esc_html__( 'Set background color for submenu dropdown', 'bignews' ),
						'default'   => array(
							'color'    => '#fff',
							'alpha'    => '1',
							'rgba'     => 'rgba(255, 255, 255, 1)'
						),
						'required'  => array( 'shw-submenu-custom', '=', true ),
						'mode'      => 'background',
						'validate'  => 'colorrgba'
					),
					array(
						'id'        => 'shw-submenu-color',
						'type'      => 'link_color',
						'title'     => esc_html__( 'SubMenu Item Color', 'bignews' ),
						'subtitle'  => esc_html__( 'Set color for text in submenu', 'bignews' ),
						'required'  => array( 'shw-submenu-custom', '=', true ),
						'default'   => array(
							'regular'   => '#333333',
							'hover'     => '#333333',
							'active'    => '#333333',
							'visited'   => '#333333'
						)
					),
					array(
						'id'             => 'shw-submenu-width',
						'type'           => 'dimensions',
						'units_extended' => false,
						'title'          => esc_html__( 'Submenu Width', 'bignews' ),
						'height'          => false,
						'default'        => array(
							'width'  => 'auto',
							'height' => '60'
						)
					),
					array(
						'id'        => 'shw-submenu-border',
						'type'      => 'border',
						'title'     => esc_html__( 'Submenu Separate', 'bignews' ),
						'subtitle'  => esc_html__( 'Set border bottom attribute for submenu', 'bignews' ),
						'all'       => false,
						'top'       => false,
						'left'      => false,
						'right'     => false,
						'default'   => array(
							'border-style'  => 'solid',
							'border-color'  => '#f0f0f0',
							'border-bottom' => '1px',
							'border-top'    => '0px',
							'border-left'   => '0px',
							'border-right'  => '0px'
						)
					),
					array(
						'id'             => 'shw-submenu-padding',
						'type'           => 'spacing',
						'mode'           => 'padding',
						'all'            => false,
						'units'          => 'px',      // You can specify a unit value. Possible: px, em, %
						'units_extended' => 'false',   // Allow users to select any type of unit
						'title'          => esc_html__( 'SubMenu Item Padding', 'bignews' ),
						'subtitle'       => esc_html__( 'Choose inwards spacing for each submenu item', 'bignews' ),
						'desc'           => esc_html__( 'unit is "px"', 'bignews' ),
						'default'        => false
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					array(
						'id'        => 'shw-submenu-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Mega Menu Setting', 'bignews' ),
						'subtitle'  => esc_html__( 'Configuration for Mega Menu', 'bignews' ),
						'indent'    => true,
					),
					array(
						'id'        => 'shw-megamenu-custom',
						'type'      => 'switch',
						'title'     => esc_html__( 'Mega Menu Custom', 'bignews' ),
						'subtitle'	=> esc_html__( 'In default, mega menu will follow "Submenu Style" above', 'bignews' ),
						'on'        => 'Custom',
						'off'       => 'Default',
						'default'   => false,
					),
					array(
						'id'        => 'shw-megamenu-bg',
						'type'      => 'background',
						'title'     => esc_html__( 'Mega Menu Background', 'bignews' ),
						'required'  => array( 'shw-megamenu-custom', '=', true ),
						'default'   => array(
							'background-color'     => '#f3f3f3',
							'background-repeat'    => 'no-repeat',
							'background-size'      => 'cover',
							'background-attachment' => 'scroll',
							'background-position'  => 'center center',
							'background-image'     => ''
						)
					),
					array(
						'id'        => 'shw-megamenu-color',
						'type'      => 'link_color',
						'title'     => esc_html__( 'Megamenu Item Color', 'bignews' ),
						'subtitle'  => esc_html__( 'Set color for text in submenu', 'bignews' ),
						'required'  => array( 'shw-megamenu-custom', '=', true ),
						'default'   => array(
							'regular'   => '#0D1721',
							'hover'     => '#0D1721',
							'active'    => '#0D1721',
							'visited'   => '#0D1721'
						)
					),
					array(
						'id'        => 'shw-megamenu-border',
						'type'      => 'border',
						'title'     => esc_html__( 'Megamenu Column Separate', 'bignews' ),
						'subtitle'  => esc_html__( 'Set border right attribute for Megamenu column', 'bignews' ),
						'all'       => false,
						'top'       => false,
						'left'      => false,
						'bottom'     => false,
						'default'   => array(
							'border-style'  => 'solid',
							'border-color'  => 'rgba(0, 0, 0, 0.1)',
							'border-bottom' => '0px',
							'border-top'    => '0px',
							'border-left'   => '0px',
							'border-right'  => '1px'
						)
					),
					array(
						'id'        => 'shw-megamenu-item-border',
						'type'      => 'border',
						'title'     => esc_html__( 'Megamenu Item Separate', 'bignews' ),
						'subtitle'  => esc_html__( 'Set border bottom attribute for Megamenu column', 'bignews' ),
						'all'       => false,
						'top'       => false,
						'left'      => false,
						'right'     => false,
						'default'   => array(
							'border-style'  => 'solid',
							'border-color'  => 'rgba(0, 0, 0, 0.06)',
							'border-bottom' => '1px',
							'border-top'    => '0px',
							'border-left'   => '0px',
							'border-right'  => '0px'
						)
					),
					array(
						'id'     => 'section-start',
						'type'   => 'section',
						'indent' => false,
					),
				)
			);

			// Sidebar setting
			$this->sections[] = array(
				'title'     => esc_html__( 'Sidebar', 'bignews' ),
				'desc'      => esc_html__( 'Configuration for sidebar', 'bignews' ),
				'icon'      => 'el-icon-caret-right',
				'fields'    => array(
					array(
						'id'        => 'shw-footer-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Default Sidebar', 'bignews' ),
						'indent'    => true,
					),
					array(
						'id'        => 'shw-archive-sidebar-layout',
						'type'      => 'image_select',
						'title'     => esc_html__( 'Default Sidebar Layout', 'bignews' ),
						'subtitle'  => esc_html__( 'Set how to display default sidebar', 'bignews' ),
						'options'   => array(
							'left'  => array(
								'alt' => 'left',
								'img' => esc_url($image_opt_path) . 'sidebar-left.png'
							),
							'right' => array(
								'alt' => 'right',
								'img' => esc_url($image_opt_path) . 'sidebar-right.png'
							),
							'none'  => array(
								'alt' => 'none',
								'img' => esc_url($image_opt_path) . 'sidebar-full.png'
							)
						),
						'default'   => 'right'
					),
					array(
						'id'       	=> 'shw-archive-sidebar',
						'type'     	=> 'select',
						'data'     	=> 'sidebars',
						'title'    	=> esc_html__( 'Default Sidebar', 'bignews' ),
						'subtitle'	=> wp_kses_post( 'You can create new sidebar in <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >Appearance > Widgets</a>' )
					),
					array(
						'id'        => 'shw-sidebar-section',
						'type'      => 'section',
						'indent'    => false,
					),
					array(
						'id'        => 'shw-footer-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Category Sidebar', 'bignews' ),
						'indent'    => true,
					),
					array(
						'id'        => 'shw-category-template-sidebar-position',
						'type'      => 'image_select',
						'title'     => esc_html__( 'Category Sidebar Layout', 'bignews' ),
						'subtitle'  => esc_html__( 'Set how to display category sidebar', 'bignews' ),
						'options'   => array(
							'left'  => array(
								'alt' => 'left',
								'img' => esc_url($image_opt_path) . 'sidebar-left.png'
							),
							'right' => array(
								'alt' => 'right',
								'img' => esc_url($image_opt_path) . 'sidebar-right.png'
							),
							'none'  => array(
								'alt' => 'none',
								'img' => esc_url($image_opt_path) . 'sidebar-full.png'
							)
						),
						'default'   => 'right'
					),
					array(
						'id'       	=> 'shw-category-template-sidebar',
						'type'     	=> 'select',
						'data'     	=> 'sidebars',
						'title'    	=> esc_html__( 'Default Sidebar', 'bignews' ),
						'subtitle'	=> wp_kses_post( 'You can create new sidebar in <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >Appearance > Widgets</a>'),
						'default'  	=> ''
					),
					array(
						'id'     => 'shw-sidebar-end',
						'type'   => 'section',
						'indent' => false,
					),
					array(
						'id'        => 'shw-footer-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Blog Sidebar', 'bignews' ),
						'indent'    => true,
					),
					array(
						'id'        => 'shw-blog-sidebar-layout',
						'type'      => 'image_select',
						'title'     => esc_html__( 'Blog Sidebar Layout', 'bignews' ),
						'subtitle'  => esc_html__( 'Set how to display blog sidebar', 'bignews' ),
						'options'   => array(
							'left'  => array(
								'alt' => 'left',
								'img' => esc_url($image_opt_path) . 'sidebar-left.png'
							),
							'right' => array(
								'alt' => 'right',
								'img' => esc_url($image_opt_path) . 'sidebar-right.png'
							),
							'none'  => array(
								'alt' => 'none',
								'img' => esc_url($image_opt_path) . 'sidebar-full.png'
							)
						),
						'default'   => 'right'
					),
					array(
						'id'       	=> 'shw-blog-sidebar',
						'type'     	=> 'select',
						'data'     	=> 'sidebars',
						'title'    	=> esc_html__( 'Blog Sidebar', 'bignews' ),
						'subtitle'	=> wp_kses_post( 'You can create new sidebar in <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >Appearance > Widgets</a>' ),
						'default'  	=> ''
					),
					array(
						'id'        => 'shw-footer-section',
						'type'      => 'section',
						'indent'    => false,
					),
					array(
						'id'        => 'shw-footer-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Block in Sidebar', 'bignews' ),
						'indent'    => true,
					),
					array(
						'id'             => 'shw-sidebar-mb',
						'type'           => 'spacing',
						'mode'           => 'margin',
						'all'            => false,
						'top'            => false,
						'left'           => false,
						'right'          => false,
						'units'          => 'px',      // You can specify a unit value. Possible: px, em, %
						'units_extended' => 'false',   // Allow users to select any type of unit
						'title'          => esc_html__( 'Sidebar Block Margin Bottom', 'bignews' ),
						'subtitle'       => esc_html__( 'Choose margin bottom between 2 block content on sidebar', 'bignews' ),
						'desc'           => esc_html__( 'unit is "px"', 'bignews' ),
						'default'        => array(
							'margin-top'     => '',
							'margin-right'   => '',
							'margin-bottom'  => '50px',
							'margin-left'    => '',
							'units'          => 'px',
						)
					),
					array(
						'id'             => 'shw-sidebar-pb',
						'type'           => 'spacing',
						'mode'           => 'padding',
						'all'            => false,
						'top'            => false,
						'left'           => false,
						'right'          => false,
						'units'          => 'px',      // You can specify a unit value. Possible: px, em, %
						'units_extended' => 'false',   // Allow users to select any type of unit
						'title'          => esc_html__( 'Sidebar Block Padding Bottom', 'bignews' ),
						'subtitle'       => esc_html__( 'Choose padding bottom for one block content on sidebar', 'bignews' ),
						'desc'           => esc_html__( 'unit is "px"', 'bignews' ),
						'default'        => array(
							'padding-top'     => '',
							'padding-right'   => '',
							'padding-bottom'  => '',
							'padding-left'    => '',
							'units'           => 'px',
						)
					),
					array(
						'id'        => 'shw-sidebar-border',
						'type'      => 'border',
						'title'     => esc_html__( 'Block Seperate', 'bignews' ),
						'subtitle'  => esc_html__( 'Set border bottom attribute for block content on sidebar', 'bignews' ),
						'all'       => false,
						'top'       => false,
						'left'      => false,
						'right'     => false,
						'default'   => array(
							'border-color'  => '#fff',
							'border-style'  => 'solid',
							'border-top'    => '0px',
							'border-right'  => '0px',
							'border-bottom' => '0px',
							'border-left'   => '0px'
						)
					),
					array(
						'id'        => 'shw-footer-section',
						'type'      => 'section',
						'indent'    => false,
					),
				)
			);

			// Footer setting
			$this->sections[] = array(
				'title'     => esc_html__( 'Footer', 'bignews' ),
				'icon'      => 'el-icon-caret-down',
				'desc'      => esc_html__( 'Configuration for footer of site', 'bignews' ),
				'fields'    => array(
					array(
						'id'        => 'shw-footer-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Footer Main', 'bignews' ),
						'indent'    => true,
					),
					array(
						'id'        => 'shw-footer',
						'type'      => 'switch',
						'title'     => esc_html__( 'Footer Section', 'bignews' ),
						'on'        => 'Show',
						'off'       => 'Hide',
						'default'   => true
					),
					array(
						'id'        => 'shw-footer-col',
						'type'      => 'radio',
						'title'     => esc_html__( 'Columns', 'bignews' ),
						'subtitle'  => wp_kses_post( 'Choose grid layout for footer.<br> Please go on "Appearance->Widget" to set data for footer' ),
						'options'   => array(
							'11'	=> '1 Column & text center',
							'1' => '1 Column',
							'2' => '2 Columns',
							'3' => '3 Columns',
							'4' => '4 Columns'
						),
						'default'   => '3'
					),
					array(
						'id'     => 'opt-notice-info',
						'type'   => 'info',
						'notice' => false,
						'style'  => 'info',
						'title'  => esc_html__( 'Footer Content When Set Column', 'bignews' ),
						'desc'   => wp_kses_post(' - 2 columns: Widgets Footer 1&2 will show.<br> - 3 columns: Widgets Footer 1, 2 & 3 will show.<br> - 4 columns: all footer widgets will show.')
					), 
					array(
						'id'        => 'shw-footer-style',
						'type'      => 'image_select',
						'title'     => esc_html__( 'Footer Style', 'bignews' ), 
						'options'   => array(
							'footer-1'  => array(
								'alt' => 'footer-1',
								'img' => esc_url($image_opt_path) . 'footer-1.png'
							),
							'footer-2' => array(
								'alt' => 'footer-2',
								'img' => esc_url($image_opt_path) . 'footer-2.png'
							),
							'footer-3'  => array(
								'alt' => 'footer-3',
								'img' => esc_url($image_opt_path) . 'footer-3.png'
							),
							'footer-4'  => array(
								'alt' => 'footer-4',
								'img' => esc_url($image_opt_path) . 'footer-4.png'
							),
							'footer-5'  => array(
								'alt' => 'footer-5',
								'img' => esc_url($image_opt_path) . 'footer-5.png'
							),
							'footer-6'  => array(
								'alt' => 'footer-6',
								'img' => esc_url($image_opt_path) . 'footer-6.png'
							)
						),
						'default'   => 'footer-1'
					),

					array(
						'id'        => 'shw-footer-bg',
						'type'      => 'background',
						'title'     => esc_html__( 'Footer Background Image', 'bignews' ),
						'subtitle'  => esc_html__( 'Set background image for footer section', 'bignews' ),
						'required'  => array( 'shw-footer-style', '=', 'custom' ),
						'default'   => array(
							'background-color'      => '#5ca5dd',
							'background-image'      => '',
							'background-repeat'     => 'no-repeat',
							'background-attachment' => ''
						)
					),
					array(
						'id'        => 'shw-footer-mask-bg',
						'type'      => 'color_rgba',
						'title'     => esc_html__( 'Footer Mask Background', 'bignews' ),
						'subtitle'  => esc_html__( 'Set background color for mask layer above footer', 'bignews' ),
						'required'  => array( 'shw-footer-style', '=', 'custom' ),
						'default'   => array(
							'color'     => '#ffffff',
							'alpha'     => 0,
							'rgba'      => 'rgba(255, 255, 255, 0)'
						)
					),
					array(
						'id'             => 'shw-footer-padding',
						'type'           => 'spacing',
						'mode'           => 'padding',
						'all'            => false,
						'left'           => false,
						'right'          => false,
						'units'          => 'px',
						'units_extended' => 'false',
						'title'          => esc_html__( 'Footer Padding', 'bignews' ),
						'subtitle'       => esc_html__( 'Choose inwards spacing for footer section', 'bignews' ),
						'desc'           => esc_html__( 'unit is "px"', 'bignews' ),
						'default'        => array(
							'padding-top'    => '50',
							'padding-bottom' => '0'
						)
					),
					array(
						'id'     => 'shw-subtitle-end',
						'type'   => 'section',
						'indent' => false,
					),
					array(
						'id'        => 'shw-footerbt-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Footer Bottom', 'bignews' ),
						'indent'    => true,
					),
					array(
						'id'        => 'shw-footerbt-show',
						'type'      => 'switch',
						'title'     => esc_html__( 'Show Footer Bottom', 'bignews' ),
						'on'        => 'Show',
						'off'       => 'Hide',
						'default'   => true,
					),
					array(
					    'id'       => 'shw-footerbt-01',
					    'type'     => 'select',
					    'title'    => esc_html__('Footer Location 1 Content', 'bignews' ),
					    'desc'     => esc_html__('Choose here and set content at below field', 'bignews' ),
					    'options'  => array(
					        'text' 		=> 'Text Information',
					        'nav'  		=> 'Footer Navigation',
					    	'none' 		=> 'None'),
					    'default'  => 'social'
					),
					array(
					    'id'       => 'shw-footerbt-02',
					    'type'     => 'select',
					    'title'    => esc_html__('Footer Location 2 Content', 'bignews' ),
					    'desc'     => esc_html__('Choose here and set content at below field', 'bignews' ),
					    'options'  => array(
					        'text' 		=> 'Text Information',
					        'nav'  		=> 'Footer Navigation',
					    	'none' 		=> 'None'),
					    'default'  => 'social'
					),
					array(
					    'id'       => 'shw-footerbt-03',
					    'type'     => 'select',
					    'title'    => esc_html__('Footer Location Center Content', 'bignews' ),
					    'desc'     => esc_html__('Choose here and set content at below field', 'bignews' ),
					    'options'  => array(
					        'text' 		=> 'Text Information',
					        'nav'  		=> 'Footer Navigation',
					    	'none' 		=> 'None'),
					    'default'  => 'social'
					),
					array(
						'id'        => 'shw-footerbt-text',
						'type'      => 'text',
						'title'     => esc_html__( 'Text Information', 'bignews' ),
						'default'   => SWBIGNEWS_COPYRIGHT,
					),
					array(
						'id'        => 'shw-footerbt-border',
						'type'      => 'border',
						'title'     => esc_html__( 'Footer Bottom Border Top', 'bignews' ),
						'subtitle'  => esc_html__( 'Set border top attribute for footer bottom', 'bignews' ),
						'all'       => false,
						'bottom'    => false,
						'left'      => false,
						'right'     => false,
						'default'   => array(
							'border-style'  => 'solid',
							'border-color'  => 'rgba(255, 255, 255, 0.6)',
							'border-bottom' => '0px',
							'border-top'    => '1px',
							'border-left'   => '0px',
							'border-right'  => '0px'
						)
					),
					array(
						'id'             => 'shw-footerbt-padding',
						'type'           => 'spacing',
						'mode'           => 'padding',
						'all'            => false,
						'left'           => false,
						'right'          => false,
						'units'          => 'px',
						'units_extended' => 'false',
						'title'          => esc_html__( 'Footer Bottom Padding', 'bignews' ),
						'subtitle'       => esc_html__( 'Choose inwards spacing for footer section', 'bignews' ),
						'desc'           => esc_html__( 'unit is "px"', 'bignews' ),
						'default'        => array(
							'padding-top'    => '20px',
							'padding-bottom' => '20px'
						)
					),
					array(
						'id'     => 'shw-subtitle-end',
						'type'   => 'section',
						'indent' => false,
					)
				)
			);

			// Block Setting
			$this->sections[] = array(
				'id'			=> 'shw_post_excerpt',
				'title'			=> esc_html__( 'Block Setting', 'bignews' ),
				'desc'  	=> wp_kses_post( 'This section will change Title Length & Excerpt Length for SWlabsCore Elements.<br />
					You can see all elements when using <strong>Visual Composer</strong> -> <strong>Add Element</strong> -> <strong>SwlabsCore</strong> for creating <a href="' . esc_url( admin_url( 'post-new.php?post_type=page' ) ) . '" >New Page</a>.', 'bignews' ),
				'icon'      	=> 'el-icon-website',
				'fields'		=> array(
					// Block 1 start
					array(
						'id'     => 'shw-section-block-01',
						'type'   => 'section',
						'title'  => esc_html__( 'Block 1', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-01',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '10'
					),
					array(
						'id'        => 'shw-excerpt-block-01',
						'type'      => 'text',
						'title'     => esc_html__( 'Excerpt Length', 'bignews' ),
						'default'   => '15'
					),
					// Block 1 end
					// Block 2 start
					array(
						'id'     => 'shw-section-block-02',
						'type'   => 'section',
						'title'  => esc_html__( 'Block 2', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-02',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '10'
					),
					array(
						'id'        => 'shw-excerpt-block-02',
						'type'      => 'text',
						'title'     => esc_html__( 'Excerpt Length', 'bignews' ),
						'default'   => '25'
					),
					// Block 2 end
					// Block 3 start
					array(
						'id'     => 'shw-section-block-03',
						'type'   => 'section',
						'title'  => esc_html__( 'Block 3', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-03',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '15'
					),
					array(
						'id'        => 'shw-excerpt-block-03',
						'type'      => 'text',
						'title'     => esc_html__( 'Excerpt Length', 'bignews' ),
						'default'   => '25'
					),
					// Block 3 end
					// Block 4 start
					array(
						'id'     => 'shw-section-block-04',
						'type'   => 'section',
						'title'  => esc_html__( 'Block 4', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-04',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '10'
					),
					array(
						'id'        => 'shw-excerpt-block-04',
						'type'      => 'text',
						'title'     => esc_html__( 'Excerpt Length', 'bignews' ),
						'default'   => '20'
					),
					// Block 4 end
					// Block 5 start
					array(
						'id'     => 'shw-section-block-05',
						'type'   => 'section',
						'title'  => esc_html__( 'Block 5', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-05',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '10'
					),
					array(
						'id'        => 'shw-excerpt-block-05',
						'type'      => 'text',
						'title'     => esc_html__( 'Excerpt Length', 'bignews' ),
						'default'   => '15'
					),
					// Block 5 end
					// Block 6 start
					array(
						'id'     => 'shw-section-block-06',
						'type'   => 'section',
						'title'  => esc_html__( 'Block 6', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-06',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '10'
					),
					// Block 6 end
					// Block 7 start
					array(
						'id'     => 'shw-section-block-07',
						'type'   => 'section',
						'title'  => esc_html__( 'Block 7', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-07',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '15'
					),
					array(
						'id'        => 'shw-excerpt-block-07',
						'type'      => 'text',
						'title'     => esc_html__( 'Excerpt Length', 'bignews' ),
						'default'   => '25'
					),
					// Block 7 end
					// Block 8 start
					array(
						'id'     => 'shw-section-block-08',
						'type'   => 'section',
						'title'  => esc_html__( 'Block 8', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-08',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '8'
					),
					// Block 8 end
					// Block 9 start
					array(
						'id'     => 'shw-section-block-09',
						'type'   => 'section',
						'title'  => esc_html__( 'Block 9', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-09',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '15'
					),
					// Block 9 end
					// Block 10 start
					array(
						'id'     => 'shw-section-block-10',
						'type'   => 'section',
						'title'  => esc_html__( 'Block 10', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-10',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '8'
					),
					// Block 10 end
					// Block 11 start
					array(
						'id'     => 'shw-section-block-11',
						'type'   => 'section',
						'title'  => esc_html__( 'Block 11', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-11',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '10'
					),
					array(
						'id'        => 'shw-excerpt-block-11',
						'type'      => 'text',
						'title'     => esc_html__( 'Excerpt Length', 'bignews' ),
						'default'   => '15'
					),
					// Block 11 end
					//	// Carousel 1
					array(
						'id'     => 'shw-section-block-carousel-01',
						'type'   => 'section',
						'title'  => esc_html__( 'Carousel 1', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-carousel-01',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '8'
					),
					//	// Carousel 2
					array(
						'id'     => 'shw-section-block-carousel-02',
						'type'   => 'section',
						'title'  => esc_html__( 'Carousel 2', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-carousel-02',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '8'
					),
					// Carousel 3 start
					array(
						'id'     => 'shw-section-block-carousel-03',
						'type'   => 'section',
						'title'  => esc_html__( 'Carousel 3', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-carousel-03',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '10'
					),
					array(
						'id'        => 'shw-excerpt-block-carousel-03',
						'type'      => 'text',
						'title'     => esc_html__( 'Excerpt Length', 'bignews' ),
						'default'   => '15'
					),
					// Carousel 3 end
					// Carousel 4 start
					array(
						'id'     => 'shw-section-block-carousel-04',
						'type'   => 'section',
						'title'  => esc_html__( 'Carousel 4', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-carousel-04',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '10'
					),
					array(
						'id'        => 'shw-excerpt-block-carousel-04',
						'type'      => 'text',
						'title'     => esc_html__( 'Excerpt Length', 'bignews' ),
						'default'   => '15'
					),
					// Carousel 4 end
					// Carousel 5 start
					array(
						'id'     => 'shw-section-block-carousel-05',
						'type'   => 'section',
						'title'  => esc_html__( 'Carousel 5', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-carousel-05',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '8'
					),
					// Carousel 5 end
					// Block Grid start
					// Grid 1 start
					array(
						'id'     => 'shw-section-grid-01',
						'type'   => 'section',
						'title'  => esc_html__( 'Grid 1', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-grid-01',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '8'
					),
					// Grid 1 end
					// Grid 2 start
					array(
						'id'     => 'shw-section-grid-02',
						'type'   => 'section',
						'title'  => esc_html__( 'Grid 2', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-grid-02',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '15'
					),
					// Grid 2 end
					// Grid 3 start
					array(
						'id'     => 'shw-section-grid-03',
						'type'   => 'section',
						'title'  => esc_html__( 'Grid 3', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-grid-03',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '8'
					),
					// Grid 3 end
					// Grid 4 start
					array(
						'id'     => 'shw-section-grid-04',
						'type'   => 'section',
						'title'  => esc_html__( 'Grid 4', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-grid-04',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '10'
					),
					// Grid 4 end
					// Block Grid end
					// Block Slider 1 start
					array(
						'id'     => 'shw-section-block-slider-01',
						'type'   => 'section',
						'title'  => esc_html__( 'Slider 1', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-slider-01',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '8'
					),
					array(
						'id'        => 'shw-excerpt-block-slider-01',
						'type'      => 'text',
						'title'     => esc_html__( 'Excerpt Length', 'bignews' ),
						'default'   => '20'
					),
					// Block Slider 1 end
					// Block Slider 2 start
					array(
						'id'     => 'shw-section-block-slider-02',
						'type'   => 'section',
						'title'  => esc_html__( 'Slider 2', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-slider-02',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '9'
					),
					// Block Slider 2 end
					// Block Slider 3 start
					array(
						'id'     => 'shw-section-block-slider-03',
						'type'   => 'section',
						'title'  => esc_html__( 'Slider 3', 'bignews' ),
						'indent' => true,
					),
					array(
						'id'        => 'shw-title-block-slider-03',
						'type'      => 'text',
						'title'     => esc_html__( 'Title Length', 'bignews' ),
						'default'   => '9'
					),
					// Block Slider 3 end
				)
			);

			// Post setting
			$this->sections[] = array(
				'title'     => esc_html__( 'Post Setting', 'bignews' ),
				'icon'      => 'el-icon-edit',
				'desc'      => esc_html__( 'Configuration layout for post detail pages.', 'bignews' ),
				'fields'    => array(
					array(
						'id'       => 'shw-post-layout',
						'type'     => 'image_select',
						'title'    => esc_html__('Post Layout Display', 'bignews'),
						'subtitle' => esc_html__('Style display post', 'bignews'),
						'options'  => array(
							'1'      => array(
								'alt'   => 'No Feature Image',
								'img'   => esc_url($image_opt_path) . 'post-layout-01.png'
							),
							'2'      => array(
								'alt'   => 'Feature Image Style 1',
								'img'   => esc_url($image_opt_path) . 'post-layout-02.png'
							),
							'3'      => array(
								'alt'   => 'Feature Image Style 2',
								'img'   => esc_url($image_opt_path) . 'post-layout-03.png'
							),
							'4'      => array(
								'alt'   => 'Video Format',
								'img'   => esc_url($image_opt_path) . 'post-layout-04.png'
							),
						),
						'default' => '1'
					),
					array(
						'id'        => 'shw-bloginfo',
						'type'      => 'sorter',
						'title'     => 'Post Info',
						'subtitle'  => 'Choose what information to show in post detail pages.',
						'options'   => array(
							'disabled' => array(

							),
							'enabled'  => array(
								'author' => 'Author',
								'date'	 => 'Date',
								'view'      => 'View number',
								'comment'   => 'Comment number',
								'category'   => 'Category',
								'tag'   => 'Tag'
							),
						),
					),
					array(
						'id'       => 'shw-blog-social',
						'type'     => 'sorter',
						'title'    => 'Social Network',
						'subtitle' => 'Choose what social networks to show in post detail pages.',
						'options'  => array (
							'disabled' => array(
								'facebook'    	=> 'Facebook',
								'twitter'     	=> 'Twitter',
								'pinterest'		=> 'Pinterest'
							),
							'enabled'  => array(
								'googleplus' 	=> 'Google plus',
								'stumbleupon'   => 'Stumbleupon',
								'linkedin'		=> 'Linkedin'
							),
						),
					),
					array(
						'id'        => 'shw-authorbox',
						'type'      => 'switch',
						'title'     => esc_html__( 'Author Section', 'bignews' ),
						'on'        => 'Show',
						'off'       => 'Hide',
						'default'   => true
					),
					array(
						'id'        => 'shw-related-post',
						'type'      => 'switch',
						'title'     => esc_html__( 'Related Post', 'bignews' ),
						'on'        => 'Show',
						'off'       => 'Hide',
						'default'   => true
					),
					array(
						'id'        => 'cmt-wordpress',
						'type'      => 'section',
						'title'     => esc_html__( 'WordPress Comments Options', 'bignews' ),
						'indent'    => true,
					), 
					array(
					    'id'       => 'cmt-wordpress-enable',
					    'type'     => 'button_set',
					    'title'    => esc_html__('Enable Default WordPress Comments', 'bignews'),
					    'options'  => array(
					        'yes' 		=> 'Yes',
					        'no'		=> 'No',
					    ),
					    'default' => 'yes'
					),
					array(
						'id'        => 'cmt-wordpress-label',
						'type'      => 'text',
						'title'     => esc_html__( 'WordPress Comments Label', 'bignews' ),
						'default'   => 'Default Comments',
					),
					array(
						'id'        => 'cmt-facebook',
						'type'      => 'section',
						'title'     => esc_html__( 'Facebook Comments Options', 'bignews' ),
						'indent'    => true,
					),
					array(
					    'id'       => 'cmt-facebook-enable',
					    'type'     => 'button_set',
					    'title'    => esc_html__('Enable Facebook Comments', 'bignews'),
					    'options'  => array(
					        'yes' 		=> 'Yes',
					        'no'		=> 'No',
					    ),
					    'default' => 'no'
					),
					array(
						'id'        => 'cmt-facebook-label',
						'type'      => 'text',
						'title'     => esc_html__( 'Facebook Comments Label', 'bignews' ),
						'default'   => 'Facebook Comments',
					),
					array(
						'id'        => 'cmt-facebook-url',
						'type'      => 'text',
						'title'     => esc_html__( 'Url to comment on', 'bignews' ),
						'default'   => '',
					),
					array(
						'id'        => 'cmt-facebook-width',
						'type'      => 'text',
						'title'     => esc_html__( 'Width', 'bignews' ),
						'default'   => '',
					),
					array(
					    'id'       => 'cmt-facebook-color',
					    'type'     => 'button_set',
					    'title'    => esc_html__('Color Scheme', 'bignews'),
					    'options'  => array(
					        'light' 	=> 'Light',
					        'dark'		=> 'Dark',
					    ),
					    'default' => 'light'
					),
					array(
						'id'        => 'cmt-facebook-number-cmt',
						'type'      => 'text',
						'title'     => esc_html__( 'Number Of Comments', 'bignews' ),
						'default'   => '',
					),
					array(
					    'id'       => 'cmt-facebook-order',
					    'type'     => 'button_set',
					    'title'    => esc_html__('Order By', 'bignews'),
					    'options'  => array(
					        'social' 	=> 'Social',
					        'reversetime' => 'Reverse Time',
					        'time'      => 'Time',
					    ),
					    'default' => 'social'
					),
					array(
						'id'        => 'cmt-facebook-language',
						'type'      => 'text',
						'title'     => esc_html__( 'Language', 'bignews' ),
						'default'   => 'en_US',
					),
					array(
						'id'        => 'cmt-google',
						'type'      => 'section',
						'title'     => esc_html__( 'Google Plus Comments Options', 'bignews' ),
						'indent'    => true,
					),
					array(
					    'id'       => 'cmt-google-enable',
					    'type'     => 'button_set',
					    'title'    => esc_html__('Enable Google Plus Comments', 'bignews'),
					    'options'  => array(
					        'yes' 		=> 'Yes',
					        'no'		=> 'No',
					    ),
					    'default' => 'no'
					),
					array(
						'id'        => 'cmt-google-label',
						'type'      => 'text',
						'title'     => esc_html__( 'Google Plus Comments label', 'bignews' ),
						'default'   => 'G+ Comments',
					),
					array(
						'id'        => 'cmt-google-width',
						'type'      => 'text',
						'title'     => esc_html__( 'Width', 'bignews' ),
						'default'   => '',
					),
					array(
						'id'        => 'cmt-google-url',
						'type'      => 'text',
						'title'     => esc_html__( 'Url to comment on', 'bignews' ),
						'default'   => '',
					),
					array(
						'id'        => 'cmt-disqus',
						'type'      => 'section',
						'title'     => esc_html__( 'Disqus comments Options', 'bignews' ),
						'indent'    => true,
					),
					array(
					    'id'       => 'cmt-disqus-enable',
					    'type'     => 'button_set',
					    'title'    => esc_html__('Enable Disqus comments', 'bignews'),
					    'options'  => array(
					        'yes' 		=> 'Yes',
					        'no'		=> 'No',
					    ),
					    'default' => 'yes'
					),
					array(
						'id'        => 'cmt-disqus-label',
						'type'      => 'text',
						'title'     => esc_html__( 'Disqus Comments label', 'bignews' ),
						'default'   => 'Disqus Comments',
					),
					array(
						'id'        => 'cmt-disqus-shortname',
						'type'      => 'text',
						'title'     => esc_html__( 'Disqus Shortname', 'bignews' ),
						'default'   => '',
					),
					array(
						'id'        => 'cmt-disqus-apikey',
						'type'      => 'text',
						'title'     => esc_html__( 'Disqus API Key', 'bignews' ),
						'default'   => '',
					),
				)
			);
			
			$category_item = array();

			$category_item[] = array(
				'id'       => 'shw-category-template-top-post',
				'type'     => 'image_select',
				'title'    => esc_html__('Top Posts Style', 'bignews'),
				'subtitle' => esc_html__('Choose how to display the top posts.', 'bignews'),
				'options'  => array(
					'1'      => array(
						'alt'   => 'Top Posts Style 1',
						'img'   => esc_url($image_opt_path) . 'icon-category-top-1.png'
					),
					'2'      => array(
						'alt'   => 'Top Posts Style 2',
						'img'   => esc_url($image_opt_path) . 'icon-category-top-2.png'
					),
					'3'      => array(
						'alt'   => 'Top Posts Style 3',
						'img'   => esc_url($image_opt_path) . 'icon-category-top-3.png'
					)
				),
				'default' => '1'
			);
			$category_item[] = array(
				'id'       => 'shw-category-template-article',
				'type'     => 'image_select',
				'title'    => esc_html__('Article Display View', 'bignews'),
				'subtitle' => esc_html__('Select a module type, this is how your article list will be displayed.', 'bignews'),
				'options'  => array(
					'1'      => array(
						'alt'   => 'Article Style 1',
						'img'   => esc_url($image_opt_path) . 'icon-category-article-1.png'
					),
					'2'      => array(
						'alt'   => 'Article Style 2',
						'img'   => esc_url($image_opt_path) . 'icon-category-article-2.png'
					),
					'3'      => array(
						'alt'   => 'Article Style 3',
						'img'   => esc_url($image_opt_path) . 'icon-category-article-3.png'
					)
				),
				'default' => '1'
			);

			// Category Template
			$this->sections[] = array(
				'title'     => esc_html__( 'Category & Tag Setting', 'bignews' ),
				'icon'      => 'el el-website',
				'desc'      => esc_html__( 'Configuration layout for Category page and Tag page.', 'bignews' ),
				'fields'    => $category_item
			);

			// Page Setting
			$this->sections[] = array(
				'title'     => esc_html__( 'Page Setting', 'bignews' ),
				'icon'      => 'el-icon-list-alt',
				'desc'      => esc_html__( 'This page will display options for special page template', 'bignews' ),
				'fields'    => array(
					array(
						'id'        => 'shw-footerbt-section',
						'type'      => 'section',
						'title'     => esc_html__( '404 Page', 'bignews' ),
						'indent'    => true,
					),
					array(
						'id'        => 'shw-404-title',
						'type'      => 'text',
						'title'     => esc_html__( 'Main Title', 'bignews' ),
						'default'   => '404'
					),
					array(
						'id'        => 'shw-404-subtitle',
						'type'      => 'text',
						'title'     => esc_html__( 'Main Subtitle', 'bignews' ),
						'default'   => 'ERROR'
					),
					array(
						'id'        => 'shw-404-desc',
						'type'      => 'editor',
						'title'     => esc_html__( 'Description', 'bignews' ),
						'default'   => 'Look like the page you are looking for does not exist.<br>If your came here from the bookmark, please remember update your bookmark.'
					),
					array(
						'id'        => 'shw-404-backhome',
						'type'      => 'text',
						'title'     => esc_html__( 'Back To Home Text', 'bignews' ),
						'default'   => 'BACK TO HOME'
					),
					array(
						'id'        => 'shw-footerbt-section',
						'type'      => 'section',
						'indent'    => false,
					),
				)
			);

			// Banner setting
			$this->sections[] = array(
				'id'			=> 'shw_banner_settings',
				'title'			=> esc_html__( 'Advertisement Settings', 'bignews' ),
				'sub-title'		=> esc_html__( 'Settings Banner', 'bignews' ),
				'icon'      	=> 'el-icon-picture',
				'fields'		=> array(
					array(
						'id'        => 'shw-header-ads-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Top Banner', 'bignews' ),
						'indent'    => true,
					),
					array(
					    'id'       => 'shw-display-banner-header',
					    'type'     => 'button_set',
					    'title'    => esc_html__('Display Banner', 'bignews'),
					    'options' => array(
					        '1' => 'Image',
					        '2' => 'Custom Code',
					        '3' => 'None'
					     ),
					    'default' => '1'
					),
					array(
						'id'       => 'shw-banner-header',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Banner Image', 'bignews' ),
						'compiler' => 'true',
						'subtitle' => esc_html__( 'Choose logo image for your site', 'bignews' ),
						'default'  => array( 'url' => SWBIGNEWS_BANNER_TOP ),
						'required'  => array( 'shw-display-banner-header', '=', '1' ),
					),
					array(
						'id'       => 'shw-banner-header-link',
						'type'     => 'text',
						'title'    => esc_html__( 'Banner Link', 'bignews' ),
						'required'  => array( 'shw-display-banner-header', '=', '1' ),
						'default'  => ''
					),
					array(
						'id'       => 'shw-banner-header-alt',
						'type'     => 'text',
						'title'    => esc_html__( 'Alternative Text For ', 'bignews' ),
						'required' => array( 'shw-display-banner-header', '=', '1' ),
						'default'  => ''
					),
					array(
						'id'        => 'shw-banner-header-newtab',
						'type'      => 'switch',
						'title'     => esc_html__( 'Open Link In New Tab', 'bignews' ),
						'required' 	=> array( 'shw-display-banner-header', '=', '1' ),
						'default'   => true,
					),
					array(
						'id'			=>'shw-banner-header-code',
						'type' 			=> 'textarea',
						'required'  	=> array( 'shw-display-banner-header', '=', '2' ),
						'title' 		=> esc_html__('Textarea Banner Header Option Code - HTML Validated Custom', 'bignews'),
						'subtitle' 		=> esc_html__('Custom HTML Allowed', 'bignews'),
						'desc' 			=> esc_html__('This is the description field, again good for additional info.', 'bignews')
					),
					array(
						'id'             => 'shw-spacing-banner-header',
						'type'           => 'spacing',
						'output'         => array('.site-banner-header'),
						'mode'           => 'margin',
						'units'          => array('px'),
						'units_extended' => 'false',
						'title'          => esc_html__('Margin Option', 'bignews'),
						'desc'           => esc_html__('You can enable or disable any piece of this field. Top, Right, Bottom, Left, or Units.', 'bignews'),
						'required'  	=> array( 'shw-display-banner-header', '=', array('1','2') ),
						'default'            => array(
							'margin-top'     => '1px',
							'margin-right'   => '1px',
							'margin-bottom'  => '1px',
							'margin-left'    => '1px',
							'units'          => 'px',
						),
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					array(
						'id'        => 'shw-sidebar-ads-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Sidebar Banner 01', 'bignews' ),
						'indent'    => true,
					),
					array(
					    'id'       => 'shw-display-banner-sidebar',
					    'type'     => 'button_set',
					    'title'    => esc_html__('Display Banner', 'bignews'),
					    'options' => array(
					        '1' => 'Image',
					        '2' => 'Custom Code',
					        '3' => 'None'
					     ),
					    'default' => '1'
					),
					array(
						'id'       => 'shw-banner-sidebar',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Banner Image', 'bignews' ),
						'compiler' => 'true',
						'subtitle' => esc_html__( 'Choose logo image for your site', 'bignews' ),
						'default'  => array( 'url' => SWBIGNEWS_BANNER_SIDE_SMALL ),
						'required'  => array( 'shw-display-banner-sidebar', '=', '1' ),
					),
					array(
						'id'       => 'shw-banner-sidebar-link',
						'type'     => 'text',
						'title'    => esc_html__( 'Banner Link', 'bignews' ),
						'required'  => array( 'shw-display-banner-sidebar', '=', '1' ),
						'default'  => ''
					),
					array(
						'id'       => 'shw-banner-sidebar-alt',
						'type'     => 'text',
						'title'    => esc_html__( 'Alternative Text For ', 'bignews' ),
						'required' => array( 'shw-display-banner-sidebar', '=', '1' ),
						'default'  => ''
					),
					array(
						'id'        => 'shw-banner-sidebar-newtab',
						'type'      => 'switch',
						'title'     => esc_html__( 'Open Link In New Tab', 'bignews' ),
						'required' 	=> array( 'shw-display-banner-sidebar', '=', '1' ),
						'default'   => true,
					),
					array(
						'id'			=>'shw-banner-sidebar-textarea',
						'type' 			=> 'textarea',
						'required'  	=> array( 'shw-display-banner-sidebar', '=', '2' ),
						'title' 		=> esc_html__('Textarea Banner Sidebar Option Code - HTML Validated Custom', 'bignews'),
						'subtitle' 		=> esc_html__('Custom HTML Allowed', 'bignews'),
						'desc' 			=> esc_html__('This is the description field, again good for additional info.', 'bignews'),
					),
					array(
						'id'             => 'shw-spacing-banner-sidebar',
						'type'           => 'spacing',
						'output'         => array('.site-banner-sidebar'),
						'mode'           => 'margin',
						'units'          => array('px'),
						'units_extended' => 'false',
						'title'          => esc_html__('Padding/Margin Option', 'bignews'),
						'desc'           => esc_html__('You can enable or disable any piece of this field. Top, Right, Bottom, Left, or Units.', 'bignews'),
						'required'  	=> array( 'shw-display-banner-sidebar', '=', array('1','2') ),
						'default'            => array(
							'margin-top'     => '1px',
							'margin-right'   => '1px',
							'margin-bottom'  => '1px',
							'margin-left'    => '1px',
							'units'          => 'px',
						),
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					array(
						'id'        => 'shw-sidebar-02-ads-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Sidebar Banner 02', 'bignews' ),
						'indent'    => true,
					),
					array(
					    'id'       => 'shw-display-banner-sidebar-02',
					    'type'     => 'button_set',
					    'title'    => esc_html__('Display Banner', 'bignews'),
					    'options' => array(
					        '1' => 'Image',
					        '2' => 'Custom Code',
					        '3' => 'None'
					     ),
					    'default' => '1'
					),
					array(
						'id'       => 'shw-banner-sidebar-02',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Banner Image', 'bignews' ),
						'compiler' => 'true',
						'subtitle' => esc_html__( 'Choose logo image for your site', 'bignews' ),
						'default'  => array( 'url' => SWBIGNEWS_BANNER_SIDE ),
						'required'  => array( 'shw-display-banner-sidebar-02', '=', '1' ),
					),
					array(
						'id'       => 'shw-banner-sidebar-02-link',
						'type'     => 'text',
						'title'    => esc_html__( 'Banner Link', 'bignews' ),
						'required'  => array( 'shw-display-banner-sidebar-02', '=', '1' ),
						'default'  => ''
					),
					array(
						'id'       => 'shw-banner-sidebar-02-alt',
						'type'     => 'text',
						'title'    => esc_html__( 'Alternative Text For ', 'bignews' ),
						'required' => array( 'shw-display-banner-sidebar-02', '=', '1' ),
						'default'  => ''
					),
					array(
						'id'        => 'shw-banner-sidebar-02-newtab',
						'type'      => 'switch',
						'title'     => esc_html__( 'Open Link In New Tab', 'bignews' ),
						'required' 	=> array( 'shw-display-banner-sidebar-02', '=', '1' ),
						'default'   => true,
					),
					array(
						'id'			=>'shw-banner-sidebar-02-textarea',
						'type' 			=> 'textarea',
						'required'  	=> array( 'shw-display-banner-sidebar-02', '=', '2' ),
						'title' 		=> esc_html__('Banner Option Code - HTML Validated Custom', 'bignews'),
						'subtitle' 		=> esc_html__('Custom HTML Allowed', 'bignews'),
					),
					array(
						'id'             => 'shw-spacing-banner-sidebar-02',
						'type'           => 'spacing',
						'mode'           => 'margin',
						'units'          => array('px'),
						'units_extended' => 'false',
						'title'          => esc_html__('Padding/Margin Option', 'bignews'),
						'desc'           => esc_html__('You can enable or disable any piece of this field. Top, Right, Bottom, Left, or Units.', 'bignews'),
						'required'  	=> array( 'shw-display-banner-sidebar-02', '=', array('1','2') ),
						'default'            => array(
							'margin-top'     => '1px',
							'margin-right'   => '1px',
							'margin-bottom'  => '1px',
							'margin-left'    => '1px',
							'units'          => 'px',
						),
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					array(
						'id'        => 'shw-content-ads-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Content Banner', 'bignews' ),
						'indent'    => true,
					),
					array(
					    'id'       => 'shw-display-banner-content',
					    'type'     => 'button_set',
					    'title'    => esc_html__('Display Banner', 'bignews'),
					    'options' => array(
					        '1' => 'Image',
					        '2' => 'Custom Code',
					        '3' => 'None'
					     ),
					    'default' => '1'
					),
					array(
						'id'       => 'shw-banner-content',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Banner Image', 'bignews' ),
						'compiler' => 'true',
						'subtitle' => esc_html__( 'Choose logo image for your site', 'bignews' ),
						'default'  => array( 'url' => SWBIGNEWS_BANNER_TOP ),
						'required'  => array( 'shw-display-banner-content', '=', '1' ),
					),
					array(
						'id'       => 'shw-banner-content-link',
						'type'     => 'text',
						'title'    => esc_html__( 'Banner Link', 'bignews' ),
						'required'  => array( 'shw-display-banner-content', '=', '1' ),
						'default'  => ''
					),
					array(
						'id'       => 'shw-banner-content-alt',
						'type'     => 'text',
						'title'    => esc_html__( 'Alternative Text For ', 'bignews' ),
						'required' => array( 'shw-display-banner-content', '=', '1' ),
						'default'  => ''
					),
					array(
						'id'        => 'shw-banner-content-newtab',
						'type'      => 'switch',
						'title'     => esc_html__( 'Open Link In New Tab', 'bignews' ),
						'required' 	=> array( 'shw-display-banner-content', '=', '1' ),
						'default'   => true,
					),
					array(
						'id'			=>'shw-banner-content-textarea',
						'type' 			=> 'textarea',
						'required'  	=> array( 'shw-display-banner-content', '=', '2' ),
						'title' 		=> esc_html__('Banner Code - HTML Validated Custom', 'bignews'),
						'subtitle' 		=> esc_html__('Custom HTML Allowed', 'bignews'),
					),
					array(
						'id'             => 'shw-spacing-banner-content',
						'type'           => 'spacing',
						'mode'           => 'margin',
						'units'          => array('px'),
						'units_extended' => 'false',
						'title'          => esc_html__('Margin Option', 'bignews'),
						'desc'           => esc_html__('You can enable or disable any piece of this field. Top, Right, Bottom, Left, or Units.', 'bignews'),
						'required'  	=> array( 'shw-display-banner-content', '=', array('1','2') ),
						'default'            => array(
							'margin-top'     => '1px',
							'margin-right'   => '1px',
							'margin-bottom'  => '1px',
							'margin-left'    => '1px',
							'units'          => 'px',
						),
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					array(
						'id'        => 'shw-content02-ads-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Content Banner 02', 'bignews' ),
						'indent'    => true,
					),
					array(
					    'id'       => 'shw-display-banner-content02',
					    'type'     => 'button_set',
					    'title'    => esc_html__('Display Banner', 'bignews'),
					    'options' => array(
					        '1' => 'Image',
					        '2' => 'Custom Code',
					        '3' => 'None'
					     ),
					    'default' => '1'
					),
					array(
						'id'       => 'shw-banner-content02',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Banner Image', 'bignews' ),
						'compiler' => 'true',
						'subtitle' => esc_html__( 'Choose logo image for your site', 'bignews' ),
						'default'  => array( 'url' => SWBIGNEWS_BANNER_TOP ),
						'required'  => array( 'shw-display-banner-content02', '=', '1' ),
					),
					array(
						'id'       => 'shw-banner-content02-link',
						'type'     => 'text',
						'title'    => esc_html__( 'Banner Link', 'bignews' ),
						'required'  => array( 'shw-display-banner-content02', '=', '1' ),
						'default'  => ''
					),
					array(
						'id'       => 'shw-banner-content02-alt',
						'type'     => 'text',
						'title'    => esc_html__( 'Alternative Text For ', 'bignews' ),
						'required' => array( 'shw-display-banner-content02', '=', '1' ),
						'default'  => ''
					),
					array(
						'id'        => 'shw-banner-content02-newtab',
						'type'      => 'switch',
						'title'     => esc_html__( 'Open Link In New Tab', 'bignews' ),
						'required' 	=> array( 'shw-display-banner-content02', '=', '1' ),
						'default'   => true,
					),
					array(
						'id'			=>'shw-banner-content02-textarea',
						'type' 			=> 'textarea',
						'required'  	=> array( 'shw-display-banner-content02', '=', '2' ),
						'title' 		=> esc_html__('Banner Sidebar Option Code - HTML Validated Custom', 'bignews'),
						'subtitle' 		=> esc_html__('Custom HTML Allowed', 'bignews'),
					),
					array(
						'id'             => 'shw-spacing-banner-content02',
						'type'           => 'spacing',
						'mode'           => 'margin',
						'units'          => array('px'),
						'units_extended' => 'false',
						'title'          => esc_html__('Padding/Margin Option', 'bignews'),
						'desc'           => esc_html__('You can enable or disable any piece of this field. Top, Right, Bottom, Left, or Units.', 'bignews'),
						'required'  	=> array( 'shw-display-banner-content02', '=', array('1','2') ),
						'default'            => array(
							'margin-top'     => '1px',
							'margin-right'   => '1px',
							'margin-bottom'  => '1px',
							'margin-left'    => '1px',
							'units'          => 'px',
						),
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					array(
						'id'        => 'shw-content03-ads-section',
						'type'      => 'section',
						'title'     => esc_html__( 'Content Banner 03', 'bignews' ),
						'indent'    => true,
					),
					array(
					    'id'       => 'shw-display-banner-content03',
					    'type'     => 'button_set',
					    'title'    => esc_html__('Display Banner', 'bignews'),
					    'options' => array(
					        '1' => 'Image',
					        '2' => 'Custom Code',
					        '3' => 'None'
					     ),
					    'default' => '1'
					),
					array(
						'id'       => 'shw-banner-content03',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Banner Image', 'bignews' ),
						'compiler' => 'true',
						'subtitle' => esc_html__( 'Choose logo image for your site', 'bignews' ),
						'default'  => array( 'url' => SWBIGNEWS_BANNER_TOP ),
						'required'  => array( 'shw-display-banner-content03', '=', '1' ),
					),
					array(
						'id'       => 'shw-banner-content03-link',
						'type'     => 'text',
						'title'    => esc_html__( 'Banner Link', 'bignews' ),
						'required'  => array( 'shw-display-banner-content03', '=', '1' ),
						'default'  => ''
					),
					array(
						'id'       => 'shw-banner-content03-alt',
						'type'     => 'text',
						'title'    => esc_html__( 'Alternative Text For ', 'bignews' ),
						'required' => array( 'shw-display-banner-content03', '=', '1' ),
						'default'  => ''
					),
					array(
						'id'        => 'shw-banner-content03-newtab',
						'type'      => 'switch',
						'title'     => esc_html__( 'Open Link In New Tab', 'bignews' ),
						'required' 	=> array( 'shw-display-banner-content03', '=', '1' ),
						'default'   => true,
					),
					array(
						'id'			=>'shw-banner-content03-textarea',
						'type' 			=> 'textarea',
						'required'  	=> array( 'shw-display-banner-content03', '=', '2' ),
						'title' 		=> esc_html__('Banner Sidebar Option Code - HTML Validated Custom', 'bignews'),
						'subtitle' 		=> esc_html__('Custom HTML Allowed', 'bignews'),
					),
					array(
						'id'             => 'shw-spacing-banner-content03',
						'type'           => 'spacing',
						'mode'           => 'margin',
						'units'          => array('px'),
						'units_extended' => 'false',
						'title'          => esc_html__('Padding/Margin Option', 'bignews'),
						'desc'           => esc_html__('You can enable or disable any piece of this field. Top, Right, Bottom, Left, or Units.', 'bignews'),
						'required'  	 => array( 'shw-display-banner-content03', '=', array('1','2') ),
						'default'            => array(
							'margin-top'     => '1px',
							'margin-right'   => '1px',
							'margin-bottom'  => '1px',
							'margin-left'    => '1px',
							'units'          => 'px',
						),
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
				),
			);
			// $this->sections[] = array(
			// 	'title'   => esc_html__( 'Customization Setting', 'bignews' ),
			// );
			// Translation
			$this->sections[] = array(
				'title'     => esc_html__( 'Translation', 'bignews' ),
				'icon'      => 'el-icon-globe-alt',
				'fields'		=> $swbignews_translate_option
			);

			// Custom CSS
			$this->sections[] = array(
				'title'     => esc_html__( 'Custom Style', 'bignews' ),
				'icon'      => 'el-icon-css',
				'desc'      => esc_html__( 'Customize your site by code', 'bignews' ),
				'fields'    => array(
					array(
						'id'       => 'shw-custom-css',
						'type'     => 'ace_editor',
						'title'    => esc_html__( 'CSS Code', 'bignews' ),
						'subtitle' => esc_html__( 'Paste your CSS code here.', 'bignews' ),
						'mode'     => 'css',
						'theme'    => 'monokai',
						'default'  => "body{\n   margin: 0 auto;\n}"
					)
				)
			);

			// Custom js
			$this->sections[] = array(
				'title'     => esc_html__( 'Custom Script', 'bignews' ),
				'icon'      => 'el-icon-link',
				'desc'      => esc_html__( 'Customize your site by code', 'bignews' ),
				'fields'    => array(
					array(
						'id'       => 'shw-custom-js',
						'type'     => 'ace_editor',
						'title'    => esc_html__( 'JS Code', 'bignews' ),
						'subtitle' => esc_html__( 'Paste your JS code here.', 'bignews' ),
						'mode'     => 'javascript',
						'theme'    => 'chrome',
						'default'  => "jQuery(document).ready(function(){\n\n});"
					),
				)
			);

			// Typography
			$this->sections[] = array(
				'title'     => esc_html__( 'Typography', 'bignews' ),
				'icon'      => 'el-icon-text-height',
				'desc'      => esc_html__( 'Customize your site by code', 'bignews' ),
				'fields'    => array(
					array(
						'id'        => 'shw-typo-body',
						'type'      => 'typography',
						'title'     => esc_html__( 'Body Text', 'bignews' ),
						'subtitle'  => esc_html__( 'Set font ', 'bignews' ),
						'google'    => true,
						'default'   => false
					),
					array(
						'id'        => 'shw-typo-p',
						'type'      => 'typography',
						'title'     => esc_html__( 'Paragraph Text', 'bignews' ),
						'google'    => true,
						'default'   => false
					),
					array(
						'id'       => 'shw-link-color',
						'type'     => 'link_color',
						'title'    => esc_html__( 'Links Color Option', 'bignews' ),
						'subtitle' => esc_html__( 'Only color validation can be done on this field type', 'bignews' ),
						'default'  => array(
							'regular' => '#333',
							'hover'   => '#a3a3a3',
							'active'  => '#a3a3a3',
						)
					),
					array(
						'id'        => 'shw-typo-h1',
						'type'      => 'typography',
						'title'     => esc_html__( 'H1 Text', 'bignews' ),
						'google'    => true,
						'default'   => false
					),
					array(
						'id'        => 'shw-typo-h2',
						'type'      => 'typography',
						'title'     => esc_html__( 'H2 Text', 'bignews' ),
						'google'    => true,
						'default'   => false
					),
					array(
						'id'        => 'shw-typo-h3',
						'type'      => 'typography',
						'title'     => esc_html__( 'H3 Text', 'bignews' ),
						'google'    => true,
						'default'   => false
					),
					array(
						'id'        => 'shw-typo-h4',
						'type'      => 'typography',
						'title'     => esc_html__( 'H4 Text', 'bignews' ),
						'google'    => true,
						'default'   => false
					),
					array(
						'id'        => 'shw-typo-h5',
						'type'      => 'typography',
						'title'     => esc_html__( 'H5 Text', 'bignews' ),
						'google'    => true,
						'default'   => false
					),
					array(
						'id'        => 'shw-typo-h6',
						'type'      => 'typography',
						'title'     => esc_html__( 'H6 Text', 'bignews' ),
						'google'    => true,
						'default'   => false
					)
				)
			);
		}

		public function setHelpTabs() {

			// Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
			$this->args['help_tabs'][] = array(
				'id'        => 'redux-help-tab-1',
				'title'     => esc_html__('Theme Information 1', 'bignews'),
				'content'   => wp_kses_post('<p>This is the tab content, HTML is allowed.</p>')
			);

			$this->args['help_tabs'][] = array(
				'id'        => 'redux-help-tab-2',
				'title'     => esc_html__('Theme Information 2', 'bignews'),
				'content'   => wp_kses_post('<p>This is the tab content, HTML is allowed.</p>')
			);

			// Set the help sidebar
			$this->args['help_sidebar'] = wp_kses_post('<p>This is the sidebar content, HTML is allowed.</p>');
		}

		/*
	      All the possible arguments for Redux.
	      For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
		*/

		public function setArguments() {

			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
				'opt_name'              => 'swbignews_options',
				'dev_mode'              => false, // disable dev mode when release
				'global_variable'       => 'swbignews_options',
				'display_name'          => 'BigNews - News & Magazine Theme',
				'display_version'       => false,
				'page_slug'             => 'BigNews_options',
				'page_title'            => 'BigNews Option Panel',
				'update_notice'         => false,
				'menu_type'             => 'menu',
				'menu_title'            => 'Theme options',
				'menu_icon'             => SWBIGNEWS_ADMIN_URI . '/images/theme-option-icon.png',
				'allow_sub_menu'        => false,
				'page_priority'         => '31',
				'page_parent' 			=> 'swbignews_welcome',
				'customizer'            => true,
				'default_mark'          => '*',
				'class'                 => 'sw_theme_options_panel',
				'hints'                 => array(
					'icon'          => 'el-icon-question-sign',
					'icon_position' => 'right',
					'icon_size'     => 'normal',
					'tip_style'     => array(
						'color' => 'light',
					),
					'tip_position' => array(
						'my' => 'top left',
						'at' => 'bottom right',
					),
					'tip_effect' => array(
						'show' => array(
							'duration' => '500',
							'event'    => 'mouseover',
						),
						'hide' => array(
							'duration' => '500',
							'event'    => 'mouseleave unfocus',
						),
					),
				),
				'intro_text'         => '',
				'footer_text'        => '<p>Thank you for purchased BigNews!</p>',
				'page_icon'          => 'icon-themes',
				'page_permissions'   => 'manage_options',
				'save_defaults'      => true,
				'show_import_export' => true,
				'database'           => 'options',
				'transient_time'     => '3600',
				'network_sites'      => true,
			);

			$this->args['share_icons'][] = array(
				'url'   => 'https://www.facebook.com/swlabs/',
				'title' => 'Like us on Facebook',
				'icon'  => 'el-icon-facebook'
			);
			$this->args['share_icons'][] = array(
				'url'   => 'http://themeforest.net/user/swlabs',
				'title' => 'Follow us on themeforest',
				'icon'  => 'el-icon-user'
			);
			$this->args['share_icons'][] = array(
				'url'   => 'mailto:admin@swlabs.co',
				'title' => 'Send us email',
				'icon'  => 'el-icon-envelope'
			);
		}

	}

	global $reduxConfig;
	$reduxConfig = new Swbignews_Redux_Framework_Config();
}
/*
  Custom function for the callback validation referenced above
*/
if (!function_exists('swbignews_validate_callback_function')):
	function swbignews_validate_callback_function($field, $value, $existing_value) {
		$error = false;
		$value = 'just testing';

		$return['value'] = $value;
		if ($error == true) {
			$return['error'] = $field;
		}
		return $return;
	}
endif;
