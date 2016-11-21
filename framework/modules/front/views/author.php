<?php
$author_url = get_author_posts_url( $author_id );
$author_desc = get_the_author_meta( 'description' );

$user_post_count = count_user_posts( $author_id);

global $wpdb;

$comment_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) AS total FROM $wpdb->comments WHERE comment_approved = 1 AND user_id = %d", $author_id));

$userID = get_current_user_id();
$user_detail = get_user_meta($userID );
$arr_field = array('facebook', 'flickr', 'foursquare','lastfm','linkedin','git','google-plus','instagram','odnoklassniki',
	'pinterest','rss','skype','soundcloud','stumbleupon','tripAdvisor','tumblr','twitter','vimeo','vk','weibo','xing','youtube');
?>

<div class="author-page-detail author-list layout-media-horizontal">
	<div class="style-2">

		<div class="media">
			<div class="media-left">
				<a class="media-image" href="<?php echo esc_url( $author_url )?>"><?php echo get_avatar($author_id,100) ?></a>
			</div>
			<div class="media-body">
				<div class="pull-right">
					<?php 
						foreach ($arr_field as $field) {
							if(!empty($user_detail[$field][0])){ echo '<a href="' . esc_url( $user_detail[$field][0] ) . '" class="link"><i class="fa fa-' . esc_attr( $field ) . '"></i></a> &nbsp ';
							}
							
						}
					?>
				</div>
				<div class="top-bar"><a class="title" href="<?php echo esc_url( $author_url )?>"><?php the_author(); ?></a>
					<span class="style-icon"><?php echo esc_html($user_post_count).'&nbsp'?><?php esc_html_e('Posts','bignews'); ?></span> 
					&nbsp;
					<span class="style-icon"> <?php echo esc_html($comment_count).'&nbsp'?><?php esc_html_e('Comments','bignews');?></span>
				</div>
				<?php if($author_desc):?>
				<div class="description"><p><?php echo nl2br( esc_textarea( $author_desc ) ) ?></p></div>
				<?php endif;?>				
				
				<div class="social url">
					
				</div>
			</div>
			<div class="pull-right">
			</div>
		</div>
	</div>
</div>