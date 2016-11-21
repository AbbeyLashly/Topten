<?php include('style-header-handle.php'); ?>

<header>
	<div class="header-light">
		<div class="header-topbar">
			<div class="container">
				<div class="topbar-left">
					<?php 
						echo wp_kses_post($header_language_bar);
						echo wp_kses_post($breakingnews);
					 ?>
				</div>
			<?php 
			echo '
				<div class="topbar-right">
					'.$header_search.$header_login_bar.'
				</div>
				';
			?>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="header-logo">
			<div class="container">
				<div class="pull-left">
					<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo get_bloginfo('description'); ?>" class="logo widget-logo">
						<img src="<?php echo esc_url( Swbignews::get_option('shw-logo-header','url') ); ?>" alt="<?php echo esc_attr( Swbignews::get_option('shw-logo-alt') ); ?>" title="<?php echo esc_attr( Swbignews::get_option('shw-logo-title') ); ?>" class="site-logo" />
					</a>
				</div>
				<div class="navbar-header">
					<button type="button" data-toggle="collapse" data-target="#main-navigation" aria-expanded="false" class="navbar-toggle collapsed"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar">	 </span></button>
				</div>
				<div class="banner-adv-728x90 pull-right">
					<?php echo wp_kses_post($header_banner); ?>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="header-menu">
			<div class="container">
				<?php swbignews_show_main_menu();?>
			</div>
		</div>
	</div>
	<?php if ( Swbignews::get_option('shw-breakingnews-01') == '1' ) { ?>
		<div class="header-bottom">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<div class="breaking-news shw-widget">
							<div class="row">
								<div class="col-lg-2 col-md-3 col-sm-3"><label><?php Swbignews_Translate::_swte( 'Breaking News' ) ?>: </label></div>
								<?php printf('<div class="col-lg-10 col-md-9 col-sm-9">%s</div>', $breakingnews ); ?>
							</div>
						</div>
					</div>
					<?php if ( Swbignews::get_option('shw-breakingnews-date') == '1' ) { ?>
					<div class="col-md-4">
						<div class="weather-info shw-widget">
							<span class="date">
								<?php echo date( 'D, M d, Y' ); ?>
							</span>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="header-breadcrumb header-bottom">
		<div class="container">
		<?php do_action('swbignews_show_breadcrumb');?>
		</div>
	</div>
</header>