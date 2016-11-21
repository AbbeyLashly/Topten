<?php
$model = new SwlabsCore_Block;
$model->init( $top_atts, null );
$type = 'large';

$params = SwlabsCore::get_params( 'block-image-size', 'block-slider-01-2' );
$model->attributes['thumb-size'] = SwlabsCore_Util::get_thumb_size( $params, $model->attributes );
if ( $model->query->have_posts() ) :
	echo ' <div class="slider-news-style2 block-slider-01-6521574d3db170ce7 "> 
		<div id="block-slider-01-6521574d3db170ce7" data-ride="carousel" class="slider-news-carousel carousel slide mbs">
			<div class="carousel-inner">';
				while ( $model->query->have_posts() ) {
					$model->query->the_post();
					$model->loop_index();
					echo '<div class="item">
						<div class="items-wrapper">
							<div class="slider-caption">
								'.$model->get_title().'

								<div class="info info-style-1">
									
									'.$model->get_category().'
									
								
									'.$model->get_date().'
								</div>
								<div class="description">
									'.$model->get_excerpt().'
								</div>
							</div>
							'.$model->get_featured_image( $type ).'
						</div>
					</div>';
				};
			echo '
			</div>
			<a href="#block-slider-01-6521574d3db170ce7" data-slide="prev" class="left carousel-control">
				<span class="fa fa-angle-left"></span>
			</a>
			<a href="#block-slider-01-6521574d3db170ce7" data-slide="next" class="right carousel-control">
				<span class="fa fa-angle-right"></span>
			</a>
		</div>
		<div class="clearfix"></div>
	</div>';
endif;
$model_2 = new SwlabsCore_Block;
$model_2->init( $top_atts_2, null );
$block_cls = $model_2->attributes['extra_class'] . ' ' . $model_2->attributes['block-class'];
$type = 'large';
?>

<div class="<?php echo esc_attr($block_cls); ?>"> 
	<div class="carousel-inner-style" id="read-carousel-<?php echo esc_attr($model_2->attributes['block-class']) ?>">
		<?php if ( $model_2->query->have_posts() ) :?>
			<?php 
			$count = 0;
			$default_image = get_template_directory_uri() . '/assets/public/images/thumb-no-image.gif';
			while ( $model_2->query->have_posts() ) {
				$model_2->query->the_post();
				$model_2->loop_index();
				$count ++; 
				echo '	<div class="item">
							<div class="thumb">
								'.$model_2->get_featured_image($type).'
								<div class="caption">
									<div class="title">
										'.$model_2->get_category().'
										<div class="info">'.$model_2->get_title().'</div>
									</div>
								</div>
							</div>
						</div>';
			}
			if( $count < $limit ){
				for ($a = 0; $a < $limit - $count; $a++) {
					echo '<div class="item">
							<div class="thumb">
								<img width="600" height="600" src="' . esc_url($default_image) . '" class="img-responsive" alt="default" />
								<div class="caption">
									<div class="title">
										<div class="info"></div>
									</div>
								</div>
							</div>
						</div>';
				}
			}
		?>
		<?php endif; ?>
	</div>
</div>

<?php wp_reset_postdata();?>
