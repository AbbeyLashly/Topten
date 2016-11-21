<?php
$meta_class = 'info-style-3';
if( is_single() ) {
	$meta_class = 'info-style-1';
}?>
<div class="info <?php echo esc_attr($meta_class)?>"><?php
	// edit link
	if( ! $args ) :
		edit_post_link( Swbignews_Translate::_swt( 'Edit' ), '<span class="item edit-link"><i class="fa fa-pencil"></i>', '</span>' );
	endif;
	//single post 
	if( is_single() && ( ! isset( $args['show_cate'] ) || ! empty( $args['show_cate'] ) ) ) {
		// show main category
		$main_category = swbignews_get_main_category();
		if( $main_category ) {?>
			<div class="category item">
				<a href="<?php echo esc_url( get_term_link( $main_category ) );?>" class="style-icon"><?php echo esc_html( $main_category->name );?></a>
			</div><?php
		}
	}
	// date
	swbignews_post_date();
	//author
	$author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
	if( $author_url ) {
		$author_string = '<div class="author item"><a class="style-icon" href="%1$s">%2$s</a></div>';
	} else {
		$author_string = '<div class="author item"><span class="style-icon">%2$s</span></div>';
	}
	echo sprintf( $author_string, esc_url( $author_url ), esc_html( get_the_author_meta( 'display_name' ) ) );
	//comment
	if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
	<div class="comments item">
		<?php comments_popup_link('0', '1', '%', 'style-icon');?>
	</div><?php
	endif;?>
	<div class="views item">
		<span class="style-icon"><?php echo esc_html(swbignews_postview_get( get_the_ID() )); ?></span>
	</div><?php
	// category
	if( !is_single() && (! isset( $args['show_cate'] ) || ! empty( $args['show_cate'] ) ) ) :
		if ( $category_list ) :?>
			<div class="category item"><?php
				foreach($category_list as $category) :
					$link = get_category_link($category);?>
				<a href="<?php echo esc_url( $link );?>" class="style-icon"><?php echo esc_html( $category->name );?></a>
				<?php endforeach;?>
			</div><?php
		endif;
	endif; // show_cate
	//tag
	if( ! isset( $args['show_tag'] ) || ! empty( $args['show_tag'] ) ) :
		if ( $posttags ) :?>
			<div class="tag item"><?php
				foreach($posttags as $tag) :
					$tag_link = get_tag_link($tag->term_id);?>
				<a href="<?php echo esc_url( $tag_link );?>" class="style-icon"><?php echo esc_html( $tag->name );?></a>
				<?php endforeach;?>
			</div><?php
		endif;
	endif; // show_tag?>
</div>