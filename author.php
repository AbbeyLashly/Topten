<?php
$all_container_css = swbignews_get_container_css();
extract($all_container_css);
get_header();
$userID = get_query_var('author');
$nickname = get_user_meta( $userID, 'nickname', true );
$description = get_user_meta( $userID, 'description', true );
$wedsite = get_the_author_meta( 'user_url', $userID );
$email = get_the_author_meta( 'user_email', $userID );
$display_name = get_the_author_meta( 'display_name', $userID);
$author_url = get_author_posts_url($userID);
$posts_per_page = get_option('posts_per_page'); // get from theme option
$offset = 0;
$paged = get_query_var('paged');
if(empty($paged)){
	$paged = 1;
}
$offset = ($paged - 1) * $posts_per_page ;
$args = array(
	'post_type' 		=> 'post',
	'post_status'		=> 'publish',
	'posts_per_page'	=> $posts_per_page,
	'offset'			=> $offset,
	'author'			=> $userID
);
$the_query = new WP_Query( $args );

//
?>
<div class="<?php echo esc_attr($container_css);?>">
	<div class="row mbxxl">
		<div id="content-news" class="<?php echo esc_attr( $content_css ); ?>">
			<div class="section-name">
				<div class="pull-left"><?php Swbignews_Translate::_swte( 'Author'); ?></div>
			</div>
			<div class="author-list layout-media-horizontal mbxl">
				<div class="style-2">
					<div class="media">
						<div class="media-left">
							<a href="<?php echo esc_url($wedsite)?>" class="media-image"><?php echo get_avatar($userID,250); ?></a>
							<ul class="nav nav-justified">
								<li class="article-nums">
									<?php printf('<span>%s: %s</span>', Swbignews_Translate::_swt( 'Articles' ), $the_query->found_posts );?>
								</li>
								<li class="views-count">
									<strong>
										<?php Swbignews_Translate::_swte( 'Views' ); ?>: 
										<?php echo swbignews_authorview_get($userID); ?>
									</strong>
								</li>
							</ul>
						</div>
						<div class="media-body">
							<div class="top-bar row">
								<div class="col-sm-7">
									<a href="<?php echo esc_url($wedsite)?>" class="title">
										<?php echo esc_html($display_name); ?>
									</a>
								</div>
								<div class="col-sm-5 text-right">
									<ul class="social-list list-inline">
									<?php
										$icons = Swbignews::get_params('social-icons');
										foreach($icons as $k=>$v){
											$social_value = get_user_meta($userID, $k, true);
											if( $social_value ){
												echo '<li>
														<a href="'.esc_url($social_value).'">
															<i class="fa '.esc_attr( $v ).'"></i>
														</a>
													</li>';
											}
										}
									?>
									</ul>
								</div>
							</div>
							<div class="description">
								<?php echo esc_html($description); ?>
							</div>
							<?php
							if(!empty($wedsite) || !empty($email)){
								print '<ul class="info-list">';
								if(!empty($wedsite)){
									print '<li><a href="'.esc_url($wedsite).'">
												<i class="fa fa-globe"></i>
												<span> '.esc_url($wedsite).'</span>
											</a></li>';
								}
								if(!empty($email)){
									print '<li><a href="mailto:'.esc_url($email).'">
												<i class="fa fa-envelope"></i>
												<span>'.esc_html($email).'</span>
											</a></li>';
								}
								print '</ul>';
							} 
							?>
						</div>
					</div><!--// media -->
				</div>
			</div><!-- // author-list-->
			<?php if ( $the_query->have_posts() ) { ?>
				<div class="section-name st-2">
					<?php echo esc_html($display_name); ?>
					<?php Swbignews_Translate::_swte( 'Articles'); ?>
				</div>.
			
			
			<div class="author-posted">
				<div class="row">
			<?php } ?>
				<?php
				$count_post = 0;
				if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts() ) :
						$the_query->the_post();
						$count_post++;
				?>
					<div class="col-md-6">
						<div class="media">
							<div class="media-body">
								<a href="<?php the_permalink(); ?>" class="media-image">
								<?php 
									if( has_post_thumbnail() ) {
										the_post_thumbnail('swbignews-thumb-600x400', array('class'=>'img-responsive')); 
									}
									else {
										echo '<img src="'.esc_url(SWBIGNEWS_NO_IMG).'" alt="" class="img-responsive">';
									}
								?>
								</a>
								<a href="<?php the_permalink(); ?>" class="title">
									<?php the_title() ?>
								</a>
								<div class="info info-style-1">
									<span class="category item">
									<?php
									$categories = get_the_category(get_the_ID()); 
									printf('<a href="%s">%s</a>',
											esc_url(get_category_link($categories[0]->term_id)),
											esc_html($categories[0]->name));
									?>
									</span>
									<span class="date-created item"><a href="<?php the_permalink();?>" class="style-icon" ><?php echo get_the_date(); ?></a></span>
								</div>
								<div class="description"><?php the_excerpt(); ?></div>
							</div>
						</div>
					</div>
				<?php
					if($count_post%2 == 0 && $count_post != $the_query->post_count){
						echo '</div><div class="row">';
					}
					endwhile;
				?>
			<?php if ( $the_query->have_posts() ) { ?>
				</div>
			</div>
			<?php } ?>
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-md-12 pagination-box shw-shortcode">
				<?php 
					$paged_var = get_query_var('paged');
					if(empty($paged_var)){
						$the_query->query_vars['paged'] = 1;
					}
					else{
						$the_query->query_vars['paged'] = get_query_var('paged');
					}
					endif;
					echo swbignews_paging_nav($the_query->max_num_pages, 2, $the_query);
					wp_reset_postdata(); 
				?>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<!-- sidebar -->
		<div id='page-sidebar' class="<?php echo esc_attr( $sidebar_css ); ?>">
			<?php swbignews_get_sidebar($sidebar_id);?>
		</div>
	</div><!-- // row -->
</div>
<?php get_footer(); ?>