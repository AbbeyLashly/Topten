<div class="wrap about-wrap shw-wrap shw-tab-style">
	<h1><?php esc_html_e( "Welcome to BigNews!", 'bignews' ); ?></h1>
	<div class="about-text"><?php esc_html_e( "BigNews is now installed and ready to use!  Get ready to build something beautiful. Please register your purchase to get support and automatic theme updates. Read below for additional information. We hope you enjoy it!", 'bignews' ); ?></div>
	<h2 class="nav-tab-wrapper">
		<?php 
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page='.SWBIGNEWS_THEME_PREFIX.'_requirement' ), esc_html__( "Recommendations", 'bignews' ) );
		printf( '<a href="%s" class="nav-tab nav-tab-active">%s</a>', admin_url( 'admin.php?page='.SWBIGNEWS_THEME_PREFIX.'_plugin' ), esc_html__( "Plugins", 'bignews' ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page='.SWBIGNEWS_THEME_PREFIX.'_demo_importer' ), esc_html__( "Install Demos", 'bignews' ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=BigNews_options' ), esc_html__( "Theme Options", 'bignews' ) );
		?>
	</h2>
	<div class="shw-important-notice">
		<p class="about-description"><?php esc_html_e('These are the plugins we include with BigNews.  Currently Swlabs Core is the only required plugin that is needed to use BigNews. You can activate, deactivate or update the plugins from this tab.', 'bignews' );?></p>
	</div>
	<div class="shw-demo-themes shw-install-plugins">
		<div class="feature-section theme-browser rendered">
			<?php
			$plugins = TGM_Plugin_Activation::$instance->plugins;
			$installed_plugins = get_plugins();
			$required_plugin = array();
			$recommend_plugin = array();
			$required_plugin[] = $plugins['swlabs-core'];
			$required_plugin[] = $plugins['js_composer'];
			$required_plugin[] = $plugins['contact-form-7'];
			$required_plugin[] = $plugins['redux-framework'];
			$recommend_plugin[] = $plugins['latest-tweets-widget'];
			$recommend_plugin[] = $plugins['newsletter'];
			$recommend_plugin[] = $plugins['awesome-surveys'];
			$recommend_plugin[] = $plugins['wp-user-avatar'];
			// $recommend_plugin[] = $plugins['woocommerce'];
			foreach( $required_plugin as $plugin ):
				$class = '';
				$plugin_status = '';
				$file_path = $plugin['file_path'];
				$plugin_action = $this->plugin_link( $plugin );

				if( is_plugin_active( $file_path ) ) {
					$plugin_status = 'active';
					$class = 'active';
				}
			?>
			<div class="theme <?php echo esc_attr( $class ); ?>">
				<div class="theme-screenshot">
					<img src="<?php echo esc_url($plugin['image_url']); ?>" alt="" />
				</div>
				<h3 class="theme-name">
					<?php
					if( $plugin_status == 'active' ) {
						echo sprintf( '<span>%s</span> ', esc_html__( 'Active:', 'bignews' ) );
					}
					echo esc_html($plugin['name']);
					?>
				</h3>
				<div class="theme-actions">
					<?php
					foreach( $plugin_action as $action ) {
						echo !empty($action) ? $action : '';
					}
					?>
				</div>
				<?php if( isset( $plugin_action['update'] ) && $plugin_action['update'] ): ?>
				<div class="theme-update">Update Available: Version <?php echo esc_html($plugin['version']); ?></div>
				<?php endif; ?>

				<?php if( isset( $installed_plugins[$plugin['file_path']] ) ): ?> 
				<div class="plugin-info">
					<?php echo sprintf('Version %s | %s', esc_html($installed_plugins[$plugin['file_path']]['Version']), esc_html($installed_plugins[$plugin['file_path']]['Author']) ); ?>
				</div>
				<?php endif; ?>
				<?php if( isset($plugin['required']) && $plugin['required'] ): ?>
				<div class="plugin-required">
					<?php esc_html_e( 'Required', 'bignews' ); ?>
				</div>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
		<h2>Recommended Plugins</h2>
		<p><?php esc_html_e('These are the plugins we tested with BigNews and they are compatible with together. If you want to use these plugins, you can activate, deactivate or update them in this tab.', 'bignews' );?></p>
		<div class="tested-plugin feature-section theme-browser rendered">
			<?php
			foreach( $recommend_plugin as $plugin ):
				$class = '';
				$plugin_status = '';
				$file_path = $plugin['file_path'];
				$plugin_action = $this->plugin_link( $plugin );

				if( is_plugin_active( $file_path ) ) {
					$plugin_status = 'active';
					$class = 'active';
				}
			?>
			<div class="theme <?php echo esc_attr( $class ); ?>">
				<div class="theme-screenshot">
					<img src="<?php echo esc_url($plugin['image_url']); ?>" alt="" />
				</div>
				<h3 class="theme-name">
					<?php
					if( $plugin_status == 'active' ) {
						echo sprintf( '<span>%s</span> ', esc_html__( 'Active:', 'bignews' ) );
					}
					echo esc_html($plugin['name']);
					?>
				</h3>
				<div class="theme-actions">
					<?php
					foreach( $plugin_action as $action ) {
						echo !empty($action) ? $action : '';
					}
					?>
				</div>
				<?php if( isset( $plugin_action['update'] ) && $plugin_action['update'] ): ?>
				<div class="theme-update"><?php esc_html__('Update Available: Version', 'bignews'); ?><?php echo esc_html($plugin['version']); ?></div>
				<?php endif; ?>

				<?php if( isset( $installed_plugins[$plugin['file_path']] ) ): ?> 
				<div class="plugin-info">
					<?php echo sprintf('Version %s | %s', esc_html($installed_plugins[$plugin['file_path']]['Version']), esc_html($installed_plugins[$plugin['file_path']]['Author']) ); ?>
				</div>
				<?php endif; ?>
				<div class="plugin-recommend">
					<?php esc_html_e( 'Recommend', 'bignews' ); ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>