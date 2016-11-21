<?php
$post_id  = get_the_ID();
if( empty( $post_id ) ) {
	return;
}
$title = get_the_title( $post_id );
$video_option = get_post_meta( $post_id, 'swlabscore_video_meta', true );
$category = Swbignews::get_value( $video_option, 'video_type' );
$youtube_id = Swbignews::get_value( $video_option, 'youtube_id' );
$vimeo_id = Swbignews::get_value( $video_option, 'vimeo_id' );
$upload_video = Swbignews::get_value( $video_option, 'upload_video' );
?>
<div class=" page-detail-video2">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="video-col">
				<div data-ride="carousel" data-interval="" class="video-slider carousel slide carousel-fade">
					<div class="carousel-inner">
						<div class="item active">
							<h3 class="title"><?php echo esc_html( $title )?></h3><?php
							$item = '';
							if ( $category == 'youtube' ){
								$item = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.esc_html( $youtube_id ).'" frameborder="0" allowfullscreen ></iframe> ';
							}else if( $category == 'vimeo' ){
								$item ='<iframe width="560" height="315" src="https://player.vimeo.com/video/'.esc_html( $vimeo_id ).'?'.'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
							}else{
								if ( filter_var( $upload_video, FILTER_VALIDATE_URL ) ){
									if( is_array( getimagesize( $upload_video ) ) ){
										$item = '<img class="img-video-related" alt="" src="'.  esc_url( $upload_video ).'" />';
									}
									else {
										$item = '<video controls >
													<source src="'.  esc_url( $upload_video ).'"type="video/mp4"/>
												</video>';
									}
								}
							}
							echo '<div class="video-wrapper">'.wp_kses_post($item).'</div>';
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php if( SWBIGNEWS_CORE_IS_ACTIVE ){ ?>
		<div class="col-md-12 col-sm-12">
			<div class="clearfix"></div>
			<div class="video-list video-style-3 owl-carousel">
				<?php 
				$video_model = new SwlabsCore_Video_Model();
				$video_model->init();
				$taxonomy = 'swlabscore_video_category';
				$categories= array();
				$categories_object = get_the_terms( $post_id, $taxonomy );
				if( $categories_object ) {
					foreach ( $categories_object as $cat ){
						$categories[]= $cat->slug;
					}
				}
				$args = array (
					'post_type'      => 'swlabscore_video',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'post__not_in'   => array( $post_id )
				);
				if( $categories ) {
					$args['tax_query'] = array(
											'taxonomy' => $taxonomy,
											'field' => 'slug',
											'terms' => $categories,
										);
				}
				$the_query = new WP_Query( $args );
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						$data = $video_model->get_video_info( get_the_ID() );
						if ( has_post_thumbnail() ){
							$attachment_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'swbignews-thumb-360x270' );
							$image = $attachment_image[0];
						}else {
							$image = SWLABSCORE_NO_IMG_URI.'thumb-360x270.gif' ;
						}?>
						<div class="item media video-block">
							<a href="#"><img src="<?php echo esc_url( $image );?>"></a>
							<div class="caption dark">
								<a href="<?php echo esc_url(get_permalink())?>" class="title"><?php echo esc_html( $data['title'] );?></a>
								<div class="author"><?php echo esc_html( $data['author'] );?></div>
								<div class="views"><?php echo esc_html( number_format_i18n(  $data['view'] ) );?></div>
							</div>
						</div>
				<?php
					} //end while
				} // end if
				wp_reset_postdata();
				?>
			</div>
		</div>
	<?php }?>
	</div>
</div>