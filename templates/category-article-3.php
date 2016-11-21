<?php
	$model = new SwlabsCore_Block;
	$model->init( $article_atts, '' );
	$html_format_tab1 = ' 
		<div class="col-md-6 col-sm-6 col-xs-6">
			<div class="thumb media">%1$s
			<div class="caption dark"> %2$s</div>
			</div> 
		</div>';
	
?>
<div class="grid2 news-list-wrapper">
	<?php if ( $model->query->have_posts() ) :?>
		<div class="grid-view">
			<div class="row">
			<?php
				$post_options = array(
					'small_post_format' => $html_format_tab1,
					'large_post_format' => $html_format_tab1,
				);
				$model->render_category_grid( $post_options );?> 
			</div>
		</div>
	<?php 
	endif;?>
</div>
