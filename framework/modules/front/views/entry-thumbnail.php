<?php
if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) :
	if ( is_singular() ) :
	?>
		<div class="first_video">
			<?php the_post_thumbnail( 'swbignews-thumb-1140x480', array( 'class' => 'img-responsive' ) ); ?>
			<?php swbignews_post_format_icons( true ); ?>
		</div>
		
	<?php else : ?>
		<a class="media-image" href="<?php the_permalink();?>"><?php the_post_thumbnail(); ?></a>
		<?php swbignews_post_format_icons( true ); ?>
	<?php endif; // End is_singular()?>
<?php endif;?>