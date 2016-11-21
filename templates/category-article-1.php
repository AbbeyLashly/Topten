<?php
	$model = new SwlabsCore_Block;
	$model->init( $article_atts, '' );

	$html_format_tab1 = ' 
		<div class ="media">
			<div class="media-left"><div class="thumb">%1$s</div>
			</div>
			<div class="media-right">
				<div class="media-heading"> %2$s </div>
				<div class="info info-style-1"> %3$s </div>
				<div class="description">  %7$s</div>
			</div> </div>';
	
?>
<div class="grid2 news-list-wrapper">
	<?php if ( $model->query->have_posts() ) :?>
		<div class="list-view">
			<?php
			$post_options = array(
				'small_post_format' => $html_format_tab1,
				'large_post_format' => $html_format_tab1,
				'thumb_href_class'  => '', 
				'small_thumb_href_class' => '',
			);
			$model->render_category_grid( $post_options );?>
		</div>
	<?php 
	endif;?>
</div>
