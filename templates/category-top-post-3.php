<?php
$model = new SwlabsCore_Block;
$model->init( $top_atts, null );
$type = 'large';

if ( $model->query->have_posts() ) :
	echo ' <div class="featured-blog"> 
				<div class="row">';
				$count = 0;
				while ( $model->query->have_posts() ) {
					$count++;
					$model->query->the_post();
					$model->loop_index();
					echo '
						<div class="featured-item col-sm-6">
							<div class="wrapper-content">
								'.$model->get_featured_image( $type ).'
								<div class="description info">
									<div class="tag item">
										<a href="#" ><i class="fa fa-tags"></i> '.$model->get_category().'</a>
									</div>
									<div class="title">'.$model->get_title().'</div>
									<div class="author"><a href="#" title=""> <i class="fa fa-user"></i> David Lee</a></div>
									<div class="date-created item">'.$model->get_date().'</div>
								</div>
							</div>
						</div>';
				};
			echo '
				</div>
			</div>
			';
endif;
?>

<?php wp_reset_postdata();?>