<?php include('style-header-handle.php'); ?>

<header>
	<div class="header-light">
		<?php if( !empty($header_left) || !empty($header_right)) :?>
		<div class="header-topbar">
			<div class="container">
			<?php
			echo '
				<div class="topbar-left">
					'.$header_left.'
				</div>
				<div class="topbar-right">
					'.$header_right.'
				</div>
				';
			?>
				<div class="clearfix"></div>
			</div>
		</div>
		<?php endif;?>
		<div class="header-logo">
			<div class="container">
			<?php
				echo '
				<div class="header-logo-left pull-left">
					'.$headermain_left.'
				</div>';
			?>
				<div class="navbar-header">
					<button type="button" data-toggle="collapse" data-target="#main-navigation" aria-expanded="false" class="navbar-toggle collapsed"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar">	 </span></button>
				</div>
			<?php
				echo '
				<div class="header-logo-right pull-right">
					'.$headermain_right.'
				</div>';
			?>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="header-menu">
			<div class="container">
				<?php swbignews_show_main_menu();?>
			</div>
		</div>
	</div>

		<div class="header-bottom">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
								<?php
									$data = Swbignews::get_option('shw-breakingnews-breadcrumb');
									$shw_page_options_nav  = get_post_meta( get_the_ID(), 'shw_page_options', true );
									if(!empty($shw_page_options_nav['header_below_navigation']))
										$optionpage  = $shw_page_options_nav['header_below_navigation'];
									else $optionpage = '';
									if($optionpage != 'none')
									{
										if($data == 'breaking_news'){
											echo '	
												<div class="breaking-news shw-widget">
													<div class="row">
														<div class="col-lg-2 col-md-3 col-sm-3">
															<label>
																'.esc_html__('Breaking News','bignews').': 
															</label>
														</div>';
											printf('<div class="col-lg-10 col-md-9 col-sm-9">%s</div>', $breakingnews );
											echo'
													</div>
												</div>';
											
										}else {
											echo'
											<div class="header-breadcrumb">';
													do_action('swbignews_show_breadcrumb');
											echo '</div>';
										}
									}
									else
									{
										if($data == 'breaking_news'){
											echo '	
												<div class="breaking-news shw-widget">
															<label>
																'.esc_html__('Breaking News','bignews').': 
															</label>
												</div>';
											printf('<div class="col-lg-10 col-md-9 col-sm-9">%s</div>', $breakingnews );
										}elseif ($data == 'breadcrumb') {
											echo'
											<div class="header-breadcrumb">
												<div class="container">';
													do_action('swbignews_show_breadcrumb');
											echo '	
												</div>
											</div>';
										}
										else{
											echo '';
										}
									}
								 ?>
						
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
</header>