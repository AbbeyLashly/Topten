<?php
$model = new SwlabsCore_Block;
$model->init( $top_atts, null );

$html_large = '
		<div class="block-item item-width-2">
			<div class="wrapper-item news-image media">
				%1$s
				<div class="news-content caption dark">
					%2$s
					
				</div>
			</div>
		</div>
';
$html_small = '
		<div class="block-item item-width-1">
			<div class="wrapper-item news-image media">
				%1$s
				<div class="news-content caption dark">
					%2$s
					
				</div>
			</div>
		</div>
';
$html_default = '
		<div class="block-item item-width-1">
			<div class="wrapper-item news-image media">
				%1$s
			</div>
		</div>
';
?>

<div class="technology-main news-masonry style-default">
	<div class="section-name">
		<div class="pull-left block-title"><?php echo $title; ?></div>
		<div class="clearfix"></div>
	</div>
	<?php if ( $model->query->have_posts() ) :?>
		<div class="section-content">
		<?php 
			$default_image = get_template_directory_uri() . '/assets/public/images/thumb-no-image.gif';
			$post_options = array(
				'large_post_format' => $html_large,
				'small_post_format' => $html_small,
				'default_post_format' => $html_default,
				'open_group'        => '',
				'open_row'          => '',
				'thumb_href_class'  => '',
				'close_row'         => '',
				'close_group'       => '',
				'small-group-class' => '',
				'min_post'			=> $limit,
				'default_image'		=> $default_image
			);
			$model->render_category_grid( $post_options );
			?>
		</div>
	<?php endif;?>
</div>
<?php wp_reset_postdata();?>
