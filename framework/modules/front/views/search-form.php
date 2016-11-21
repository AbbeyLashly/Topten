<form class="search-form" name="search-form" action="<?php echo esc_url( home_url( '/' ) ) ?>">
	<div class="input-group">
		<input type="text" class="form-control lg-input" placeholder="<?php Swbignews_Translate::_swte( 'your keyword' ) ?>" name="s">
		<div class="input-group-btn">
			<button class="btn btn-default btn-line submit-form-search" type="button"><?php Swbignews_Translate::_swte( 'Search' ) ?></button>
		</div>
	</div>
	<?php 
	if ( have_posts() ) {
		global $wp_query;
		global $paged;
		$result_start = ( empty($paged) ? 0 : ($paged-1) ) * $wp_query->query_vars['posts_per_page'];
		echo '<div class="result"><p>';
		Swbignews_Translate::_swte('Show results');
		printf(' %1$s - %2$s ', $result_start + 1, $result_start + $wp_query->post_count);
		Swbignews_Translate::_swte('of');
		printf(' %s', $wp_query->found_posts);
		echo '</p></div>';
	}
	?>
</form>