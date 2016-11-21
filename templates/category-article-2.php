<?php
	$model = new SwlabsCore_Block;
	$model->init( $article_atts, '' );

	$html_format_tab1 = ' 
		<div class="category-item">
			<div class="title">%2$s</div>
			<div class="info info-style-1"> %3$s </div>
			<div class="thumb">%1$s</div>
			<div class="description">  %7$s</div> 
		</div>';
	
?>
<div class="grid2 news-list-wrapper">
	<?php if ( $model->query->have_posts() ) :?>
		<div class="list-view-2">
			<div class="list-unstyled">
				<?php
				$post_options = array(
					'small_post_format' => $html_format_tab1,
					'large_post_format' => $html_format_tab1,
					'thumb_href_class'  => ' img-responsive',
					'small_thumb_href_class' => ' img-responsive',
				);
				$model->render_category_grid( $post_options );?> 
			</div>
		</div>
	<?php 
	endif;?>
</div>
