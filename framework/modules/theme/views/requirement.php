<div class="wrap about-wrap shw-wrap shw-tab-style">
	<h1><?php echo esc_html__( "Welcome to BigNews!", 'bignews' ); ?></h1>
	<div class="about-text"><?php echo esc_html__( "BigNews is now installed and ready to use!  Get ready to build something beautiful. Please register your purchase to get support and automatic theme updates. Read below for additional information. We hope you enjoy it!", 'bignews' ); ?></div>
	<h2 class="nav-tab-wrapper">
		<?php 
		printf( '<a href="%s" class="nav-tab nav-tab-active">%s</a>', admin_url( 'admin.php?page='.SWBIGNEWS_THEME_PREFIX.'_requirement' ), esc_html__( "Recommendations", 'bignews' ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page='.SWBIGNEWS_THEME_PREFIX.'_plugin' ), esc_html__( "Plugins", 'bignews' ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page='.SWBIGNEWS_THEME_PREFIX.'_demo_importer' ), esc_html__( "Install Demos", 'bignews' ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=BigNews_options' ), esc_html__( "Theme Options", 'bignews' ) );
		?>
	</h2>
	<div class="shw-requirement">
		<table class="widefat" cellspacing="0">
			<thead>
				<tr>
					<th colspan="2"><?php esc_html_e( 'Requirements & Recommendations', 'bignews' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php esc_html_e( 'Uploads folder writable', 'bignews' ); ?> :</td>
					<td><?php 
					$dir = wp_upload_dir();
					if(wp_is_writable($dir['basedir'].'/')){
						echo '<i class="fa fa-check-square"></i>';
					}else{
						echo '<i class="fa fa-info-circle"></i><span>'. esc_html__('Please set the write permission (755) to your wp-content/uploads folders.', 'bignews').'</span>';
					} 
					?></td>
				</tr>
				<tr>
					<td><?php esc_html_e( 'Mbstring Extension', 'bignews' ); ?>:</td>
					<td><?php
					if(extension_loaded("mbstring")){
						echo '<i class="fa fa-check-square"></i>';
					}else{
						$url_mbstring = 'http://php.net/manual/en/mbstring.installation.php';
						echo '<i class="fa fa-info-circle"></i><span>'. esc_html__('Please enable the Mbstring extension for PHP on your server.', 'bignews').'</span><a href="'.esc_url($url_mbstring).'" title="How to enable the Mbstring extension for PHP on your server">Read more</a>';
					}
					?></td>
				</tr>
				<tr>
					<td><?php esc_html_e( 'PHP Version', 'bignews' ); ?>:</td>
					<td><?php if ( function_exists( 'phpversion' ) ){
						if(phpversion() >= 5.3){
							echo '<i class="fa fa-check-square"></i><span>'.esc_html__('Currently: ', 'bignews').esc_html( phpversion() ).'</span>';
						}
						else{
							echo '<i class="fa fa-info-circle"></i><span>'.esc_html__('Currently:', 'bignews').esc_html( phpversion() ).'</span><span>'.esc_html__('Recommended: 5.3', 'bignews').'</span>';
						}
					} ?></td>
				</tr>
				<tr>
					<td><?php esc_html_e( 'Memory Limit', 'bignews' ); ?>:</td>
					<td><?php
					$mem_limit = ini_get('memory_limit');
					$mem_limit_byte = wp_convert_hr_to_bytes($mem_limit);
		
					if($mem_limit_byte < 268435456){ // 256M
						//not good
						echo '<i class="fa fa-info-circle"></i>';
					} else {
						echo '<i class="fa fa-check-square"></i>';
					}
		
					echo '<span >'.esc_html__('Currently:', 'bignews').' '.esc_html($mem_limit).'</span>';
		
					if($mem_limit_byte < 268435456){
						$url_wp = 'http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP';
						//not good
						echo '<span >'. esc_html__('Recommended: 256M', 'bignews').'</span><a href="'. esc_url($url_wp).'" target="_blank">'.esc_html__('Increasing Memory Limit', 'bignews').'</a>';
					} 
					?></td>
				</tr>
				<tr>
					<td ><?php esc_html_e( 'Upload Max Filesize', 'bignews' ); ?>:</td>
					<td><?php
						$upload_max_filesize = ini_get('upload_max_filesize');
						$upload_max_filesize_byte = wp_convert_hr_to_bytes($upload_max_filesize);
						
						if($upload_max_filesize_byte < 33554432 ){ // 256M
							//not good
							echo '<i class="fa fa-info-circle"></i>';
						} else {
							echo '<i class="fa fa-check-square"></i>';
						}
			
						echo '<span>'.esc_html__('Currently:', 'bignews').' '.esc_html($upload_max_filesize).'</span>';
						if($upload_max_filesize_byte < 33554432 ){
							$url_wp = 'https://wordpress.org/support/topic/how-to-increase-the-max-upload-size';
							echo '<span>'.esc_html__('Recommended: 32M', 'bignews').'</span><a href="'. esc_url($url_wp).'" target="_blank">'.esc_html__('Increasing Upload Max Filesize', 'bignews').'</a>';
						}
					?></td>
				</tr>
				<tr>
					<td ><?php esc_html_e( 'Post Max Size', 'bignews' ); ?>:</td>
					<td><?php
						$post_max_size = ini_get('post_max_size');
						$post_max_size_byte = wp_convert_hr_to_bytes($post_max_size);
						if($post_max_size_byte < 33554432 ){ // 128M
							//not good
							echo '<i class="fa fa-info-circle"></i>';
						} else {
							echo '<i class="fa fa-check-square"></i>';
						}
			
						echo '<span>'.esc_html__('Currently:', 'bignews').' '.esc_html($post_max_size).'</span>';
						if($post_max_size_byte < 33554432 ){
							$url_wp = 'https://wordpress.org/support/topic/changing-max-file-and-post-size';
							echo '<span>'.esc_html__('Recommended: 32M', 'bignews').'</span><a href="'. esc_url( $url_wp ) .'" target="_blank">'.esc_html__('Increasing Post Max Size', 'bignews').'</a>';
						}
					?></td>
				</tr>
				<tr>
					<td ><?php esc_html_e( 'Time Limit:', 'bignews' ); ?>:</td>
					<td><?php
						$time_limit = ini_get('max_execution_time');
						
						if($time_limit < 1800 && $time_limit != 0 ){ // 32M
							//not good
							echo '<i class="fa fa-info-circle"></i>';
						} else {
							echo '<i class="fa fa-check-square"></i>';
						}
			
						echo '<span>'.esc_html__('Currently:', 'bignews').' '.esc_html($time_limit).'</span>';
						if($time_limit < 1800 && $time_limit != 0){
							$url_wp = 'http://codex.wordpress.org/Common_WordPress_Errors#Maximum_execution_time_exceeded';
							echo '<span>'.esc_html__('Recommended: 1800', 'bignews').'</span><a href="'. esc_url( $url_wp ).'" target="_blank">'.esc_html__('Increasing Time Limit', 'bignews').'</a>';
						}
					?></td>
				</tr>
				<tr>
					<td ><?php esc_html_e( 'PHP Max Input Vars:', 'bignews' ); ?>:</td>
					<td><?php
						$max_input_vars = ini_get('max_input_vars');
						
						if($max_input_vars < 6000 ){
							//not good
							echo '<i class="fa fa-info-circle"></i>';
						} else {
							echo '<i class="fa fa-check-square"></i>';
						}
			
						echo '<span>'.esc_html__('Currently:', 'bignews').' '.esc_html($max_input_vars).'</span>';
						if($max_input_vars < 6000){
							echo '<span>'.esc_html__('Recommended: 6000', 'bignews').'</span>';
						}
					?></td>
				</tr>
				<tr>
					<td><?php esc_html_e( 'Debug Mode', 'bignews' ); ?>:</td>
					<td><?php 
					if ( defined('WP_DEBUG') && WP_DEBUG ){
						echo '<i class="fa fa-check-square"></i>';
					} else {
						echo '<i class="fa fa-info-circle"></i>';
					}
					?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>