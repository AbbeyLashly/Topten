<?php

// Set post view
add_action('wp_head', 'swbignews_postview_set');
if( ! function_exists( 'swbignews_postview_set' ) ) :

	function swbignews_postview_set() {
		global $post;
		if( $post ) {
			$post_id = $post->ID;
			if('post' == get_post_type() && is_single()) {
				$count_key = 'swbignews_postview_number';
				$count = get_post_meta( $post_id, $count_key, true );
				if( $count == '' ) {
					$count = 0;
					delete_post_meta( $post_id, $count_key );
					add_post_meta( $post_id, $count_key, '0' );
				} else {
					$count++;
					update_post_meta( $post_id, $count_key, $count );
				}
				// set number view of ppost for post's author
				$author_id = $post->post_author;
				$author_key = 'swbignews_author_postview_number';
				$count_author_view = get_user_meta( $author_id, $author_key, true );
				if( $count_author_view == '' ) {
					$count_author_view = 0;
					delete_user_meta( $author_id, $author_key );
					add_user_meta( $author_id, $author_key, '0' );
				} else {
					$count_author_view++;
					update_user_meta( $author_id, $author_key, $count_author_view );
				}
			}
		}
	}
endif;

// Get post view
if( ! function_exists( 'swbignews_postview_get' ) ) :

	function swbignews_postview_get( $post_id ) {
		$view_text = Swbignews_Translate::_swt( 'view' );
		$count_key = 'swbignews_postview_number';
		$count = get_post_meta( $post_id, $count_key, true );
		$res = '';
		if($count == '') {
			delete_post_meta( $post_id, $count_key );
			add_post_meta( $post_id, $count_key, '0' );
			$res = 0;
		} else {
			$res = $count;
		}
		return $res;
	}
endif;

// Get author view
if( ! function_exists( 'swbignews_authorview_get' ) ) :

	function swbignews_authorview_get( $author_id ) {
		$count_key = 'swbignews_author_postview_number';
		$count = get_user_meta( $author_id, $count_key, true );
		$res = '';
		if($count == '') {
			delete_user_meta( $author_id, $count_key );
			add_user_meta( $author_id, $count_key, '0' );
			$res = 0;
		} else {
			$res = $count;
		}
		return $res;
	}
endif;

remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

if(!function_exists('swbignews_regex')) :

	function swbignews_regex($string, $pattern = false, $start = "^", $end = "")
	{
		if(!$pattern) return false;

		if($pattern == "url")
		{
			$pattern = "!$start((https?|ftp)://(-\.)?([^\s/?\.#-]+\.?)+(/[^\s]*)?)$end!";
		}
		else if($pattern == "mail")
		{
			$pattern = "!$start\w[\w|\.|\-]+@\w[\w|\.|\-]+\.[a-zA-Z]{2,4}$end!";
		}
		else if($pattern == "image")
		{
			$pattern = "!$start(https?(?://([^/?#]*))?([^?#]*?\.(?:jpg|gif|png)))$end!";
		}
		else if(strpos($pattern,"<") === 0)
		{
			$pattern = str_replace('<',"",$pattern);
			$pattern = str_replace('>',"",$pattern);

			if(strpos($pattern,"/") !== 0) { $close = "\/>"; $pattern = str_replace('/',"",$pattern); }
			$pattern = trim($pattern);
			if(!isset($close)) $close = "<\/".$pattern.">";

			$pattern = "!$start\<$pattern.+?$close!";

		}

		preg_match($pattern, $string, $result);

		if(empty($result[0]))
		{
			return false;
		}
		else
		{
			return $result;
		}

	}
endif;

if(!function_exists('swbignews_paging_nav')) :
	/**
	 * Displays a page pagination if more posts are available than can be displayed on one page
	 * @param string $pages pass the number of pages instead of letting the script check the gobal paged var
	 * @return string $output returns the pagination html code
	 */
	function swbignews_paging_nav( $pages = '', $range = 2, $current_query = '' )
	{
		global $paged;
		if( $current_query == '' ) {
			global $paged;
			if( empty( $paged ) ) $paged = 1;
		} else {
			$paged = $current_query->query_vars['paged'];
		}
		
		
		$prev = $paged - 1;
		$next = $paged + 1;
		$range = 1; // only edit this if you want to show more page-links
		$showitems = ($range * 2)+1;
		
		if($pages == '') {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages) {
				$pages = 1;
			}
		}
		$method = "get_pagenum_link";
		if(is_single()) {
			$method = 'swbignews_post_pagination_link';
		}
		$output_page = $output_prev = $output_next = $last = $pages_of_total = '';
		if( 1 != $pages ) {
			$output_page .= '<ul class="pagination">';
			// first
			if( $paged > 2 && $paged > $range+1 && $showitems < $pages ) {
				$output_page .= '<li ><a href="'.esc_url($method(1)).'"><i class="fa fa-angle-double-left" ></i></a></li>';
			}
			// prev
			$output_page .= ($paged > 1 && $showitems < $pages)? '<li><a href="'.esc_url($method($prev)).'" ><i class="fa fa-angle-left" ></i></a></li>':'';
			if( $paged - $range > 2 ) {
				$output_page .= '<li><a href="'.esc_url($method($prev)).'">&bull;&bull;&bull;</a></li>';
			}
		
			for ($i=1; $i <= $pages; $i++) {
				if (1 != $pages &&( !($i >= $paged+$showitems || $i <= $paged-$showitems) || $pages <= $showitems )) {
					$output_page .= ($paged == $i)? '<li class="active"><a href="#">'.$i.'</a></li>':'<li class=""><a href="'.esc_url($method($i)).'" class="" >'.$i.'</a></li>';
				}
			}
		
			if( $paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages ) {
				if( $paged+$showitems < $pages +1) {
					$output_page .= '<li><a href="'.esc_url($method($next)).'">&bull;&bull;&bull;</a></li>';
				}
			}
			$output_page .= ($paged < $pages && $showitems < $pages) ? '<li><a href="'.esc_url($method($next)).'" ><i class="fa fa-angle-right" ></i></a></li>' :'';
			$output_page .= ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? '<li><a href="'.esc_url($method($pages)).'"><i class="fa fa-angle-double-right"></i></a></li>':'';
			$output_page .= '</ul>'."\n";

			// Show page of total
			$pages_of_total = sprintf('<span class="result-count">%1$s %2$s %3$s %4$s</span>', Swbignews_Translate::_swt('Page'), $paged, Swbignews_Translate::_swt('of'), $pages );

		}
		$output = sprintf('<nav class="pagination-box">%1$s%2$s</nav>', $output_page, $pages_of_total);
		return $output;
	}

	function swbignews_post_pagination_link($link)
	{
		$url =  preg_replace('!">$!','',_wp_link_page($link));
		$url =  preg_replace('!^<a href="!','',$url);
		return $url;
	}

	function swbignews_get_pagenum_link( $pagenum = 1, $escape = true, $base = null) {
		global $wp_rewrite;

		$pagenum = (int) $pagenum;
	
		$request = $base ? remove_query_arg( 'paged', $base ) : remove_query_arg( 'paged' );
	
		$home_root = parse_url(home_url());
		$home_root = ( isset($home_root['path']) ) ? $home_root['path'] : '';
		$home_root = preg_quote( $home_root, '|' );
	
		$request = preg_replace('|^'. $home_root . '|i', '', $request);
		$request = preg_replace('|^/+|', '', $request);
	
		if ( !$wp_rewrite->using_permalinks() || is_admin() ) {
			$base = trailingslashit( home_url() );
	
			if ( $pagenum > 1 ) {
				$result = add_query_arg( 'paged', $pagenum, $base . $request );
			} else {
				$result = $base . $request;
			}
		} else {
			$qs_regex = '|\?.*?$|';
			preg_match( $qs_regex, $request, $qs_match );
	
			if ( !empty( $qs_match[0] ) ) {
				$query_string = $qs_match[0];
				$request = preg_replace( $qs_regex, '', $request );
			} else {
				$query_string = '';
			}
	
			$request = preg_replace( "|$wp_rewrite->pagination_base/\d+/?$|", '', $request);
			$request = preg_replace( '|^' . preg_quote( $wp_rewrite->index, '|' ) . '|i', '', $request);
			$request = ltrim($request, '/');
	
			$base = trailingslashit( home_url() );
	
			if ( $wp_rewrite->using_index_permalinks() && ( $pagenum > 1 || '' != $request ) )
				$base .= $wp_rewrite->index . '/';
	
			if ( $pagenum > 1 ) {
				$request = ( ( !empty( $request ) ) ? trailingslashit( $request ) : $request ) . user_trailingslashit( $wp_rewrite->pagination_base . "/" . $pagenum, 'paged' );
			}
	
			$result = $base . $request . $query_string;
		}
	
		/**
		 * Filter the page number link for the current request.
		 *
		 * @since 2.5.0
		 *
		 * @param string $result The page number link.
		 */
		$result = apply_filters( 'get_pagenum_link', $result );
	
		if ( $escape )
			return esc_url( $result );
		else
			return esc_url_raw( $result );
	}
endif;

if ( ! function_exists( 'swbignews_post_nav' ) ) :
	/**
	 * Display navigation to next/previous post when applicable.
	*
	*/
	function swbignews_post_nav() {
		global $post;
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );
		if ( ! $next && ! $previous )
			return;
		?>
<!--	Edit here-->
		<!-- .navigation -->
		<div class="prev-next-post">
			<div class="row">
				<?php
					if($previous){
				?>
				<div class="col-sm-6">
					<h4 class="prev-next-title"><?php echo esc_html('Previous Post');  ?></h4>
					<div class="post-inner media">
						<div class="media-left media-top">
							<a href="<?php echo esc_url(get_preview_post_link($previous));?>" class="title">
							<?php
								if( has_post_thumbnail($previous) ) {
									echo get_the_post_thumbnail($previous, 'swbignews-thumb-100x100', array('class'=>'media-object')); 
								}
								else {
									echo SwlabsCore_Util::get_no_image( array("no-image-small" => "thumb-100x100.gif"), $previous, 'small', array('thumb_class' => 'media-object' ) );;
								}
							?>
							</a>
						</div>
						<div class="media-body">
							<h5 class="media-heading">
								<a href="<?php echo esc_url(get_preview_post_link($previous));?>" class="title"><?php echo esc_html($previous->post_title);?></a>
							</h5>
							<div class="info info-style-1">
								<div class="category item">
									<a href="<?php echo esc_url(get_category_link($previous->post_category[0]));?>" class=""><?php echo esc_html(get_the_category_by_ID($previous->post_category[0]));?></a>
								</div>
								<div class="date-created item">
									<a href="<?php echo esc_url(get_preview_post_link($previous));?>" class="style-icon"><?php echo esc_html(get_the_date("Y-m-d",$previous->ID));?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
				}
				if($next){
				?>
				<div class="col-sm-6">
					<h4 class="prev-next-title"><?php echo esc_html('Next Post');  ?></h4>
					<div class="post-inner media">
						<div class="media-left media-top">
							<a href="<?php echo esc_url(get_preview_post_link($next));?>" class="title">
							<?php
								if( has_post_thumbnail($next) ) {
									echo get_the_post_thumbnail($next, 'swbignews-thumb-100x100', array('class'=>'media-object')); 
								}
								else {
									echo SwlabsCore_Util::get_no_image( array("no-image-small" => "thumb-100x100.gif"), $next, 'small', array('thumb_class' => 'media-object' ) );;
								}
							?>
							</a>
						</div>
						<div class="media-body">
							<h5 class="media-heading">
								<a href="<?php echo esc_url(get_preview_post_link($next));?>" class="title"><?php echo esc_html($next->post_title);?></a>
							</h5>
							<div class="info info-style-1">
								<div class="category item">
									<a href="<?php echo esc_url(get_category_link($next->post_category[0]));?>" class=""><?php echo esc_html(get_the_category_by_ID($next->post_category[0]));?></a>
								</div>
								<div class="date-created item">
									<a href="<?php echo esc_url(get_preview_post_link($next));?>" class="style-icon"><?php echo esc_html(get_the_date("Y-m-d",$next->ID));?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'swbignews_get_link_url' ) ) :
	/**
	 * Return the post URL.
	 *
	 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
	 * the first link found in the post content.
	 *
	 * Falls back to the post permalink if no URL is found in the post.
	 *
	 *
	 * @return string The Link format URL.
	 */
	function swbignews_get_link_url() {
		$content = get_the_content();
		$has_url = get_url_in_content( $content );

		return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}
endif;

if ( ! function_exists( 'swbignews_post_format_icons' ) ) :

	function swbignews_post_format_icons( $echo = true ) {
		$format = get_post_format();
		$post_format = Swbignews::get_params( 'post-format-icons' );
		if( ! isset( $post_format[$format] ) ) {
			$post_format = $post_format['standard'];
		} else {
			$post_format = $post_format[$format];
		}
		$output = '';
		if( !empty( $post_format ) ) {
			$output = '<div class="img-cate"><i class="fa %2$s"></i></div>';
		}
		$output = sprintf( $output, esc_url( get_post_format_link( $format ) ), $post_format );
		if( $echo ) {
			echo wp_kses_post( $output );
		}
		return $output;
	}
endif;

if ( ! function_exists( 'swbignews_post_date' ) ) :
	function swbignews_post_date() {
		if ( in_array( get_post_type(), array( 'post', 'attachment', 'shw_portfolio' ) ) ) {
			$time_string = '<div class="date-created item"><a class="style-icon" href="%1$s">%2$s</a></div>';		
			$time_string = sprintf( $time_string, esc_url( get_permalink() ), get_the_date(), get_the_modified_date() );
			echo wp_kses_post($time_string);
		}
	}
endif;
if ( ! function_exists( 'swbignews_image_by_id' ) ) :
	function swbignews_image_by_id($thumbnail_id, $size = array('width'=>800,'height'=>800), $output = 'image', $data = "")
	{
		if(!is_numeric($thumbnail_id)) {return false; }

		if(is_array($size))
		{
			$size[0] = $size['width'];
			$size[1] = $size['height'];
		}

		// get the image with appropriate size by checking the attachment images
		$image_src = wp_get_attachment_image_src($thumbnail_id, $size);

		//if output is set to url return the url now and stop executing, otherwise build the whole img string with attributes
		if ($output == 'url') return $image_src[0];

		//get the saved image metadata:
		$attachment = get_post($thumbnail_id);

		if(is_object($attachment))
		{
			$image_description = $attachment->post_excerpt == "" ? $attachment->post_content : $attachment->post_excerpt;
			if(empty($image_description)) $image_description = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
			$image_description = trim(strip_tags($image_description));
			$image_title = trim(strip_tags($attachment->post_title));

			return "<img src='".esc_url($image_src[0])."' title='".esc_attr($image_title)."' alt='".esc_attr($image_description)."' ".$data."/>";
		}
	}
endif;

if ( ! function_exists( 'swbignews_get_breadcrumb' ) ) :
	function swbignews_get_breadcrumb()
	{
		if ( SWBIGNEWS_WOOCOMMERCE_ACTIVE ) 
		{
			$breadcrumbs = new WC_Breadcrumb();
			$breadcrumbs->add_crumb( esc_html_x( 'Home', 'breadcrumb', 'bignews' ), apply_filters( 'woocommerce_breadcrumb_home_url', home_url() ) );
		} else {
			$breadcrumbs = new Swbignews_Breadcrumb();
			$breadcrumbs->add_crumb( esc_html_x( 'Home', 'breadcrumb', 'bignews' ), apply_filters( 'swbignews_breadcrumb_home_url', home_url() ) );
		}
		return $breadcrumbs->generate();
	}
endif;

if ( ! function_exists( 'swbignews_get_page_template_slug' ) ) :
	function swbignews_get_page_template_slug( $post_id = null ) {
		if (function_exists("get_page_template_slug")){
			return get_page_template_slug( $post_id );
		}
		$post = get_post( $post_id );
		if ( ! $post || 'page' != $post->post_type )
			return false;
		$template = get_post_meta( $post->ID, '_wp_page_template', true );
		if ( ! $template || 'default' == $template )
			return '';
		return $template;
	}
endif;

if ( ! function_exists( 'swbignews_get_container_css' ) ) :
	function swbignews_get_container_css() {
		/* Global variable from theme option */
		global $swbignews_options;
		
		if(!is_author())
			do_action('swbignews_page_options');

		$sidebar = $swbignews_options['shw-archive-sidebar-layout'];
		
		if(!empty($swbignews_options['shw-archive-sidebar']))
			$sidebar_id = $swbignews_options['shw-archive-sidebar'];
		else $sidebar_id = '';

		if( is_single() ) {
			$sidebar = $swbignews_options['shw-blog-sidebar-layout'];
			$sidebar_id = $swbignews_options['shw-blog-sidebar'];
		}

		$content_css = 'col-md-8';
		$sidebar_css = 'col-md-4';

		if ( $sidebar == 'left' ) {
			$content_css = 'col-md-8 col-right col-sm-9';
			$sidebar_css = 'col-md-4 col-left col-sm-3';
		} else if ( $sidebar == 'right' ) {
			$content_css = 'col-md-8 col-left col-sm-9';
			$sidebar_css = 'col-md-4 col-right col-sm-3';
		} else {
			$content_css = 'col-md-12';
			$sidebar_css = 'hide';
		}
		$container_css = 'container';
		return array(
			'container_css' => 'container',
			'content_css'   => $content_css,
			'sidebar_css'   => $sidebar_css,
			'sidebar'       => $sidebar,
			'sidebar_id'    => $sidebar_id
		);
	}
endif;
if ( ! function_exists( 'swbignews_get_sidebar' ) ) :
	function swbignews_get_sidebar( $sidebar_id ) {
		if( empty($sidebar_id) ) {
			get_sidebar();
		} else {
			if ( is_active_sidebar( $sidebar_id ) ) {
				dynamic_sidebar( $sidebar_id );
			}
		}
	}
endif;
/**
 * Custom callback function, see comments.php
 * 
 */
 if ( ! function_exists( 'swbignews_display_comments' ) ) : 
	function swbignews_display_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; 
		?>
		<li class="media" id="comment-<?php echo get_comment_ID() ?>">
			<div class="media-left">
				<a href="#"><?php echo get_avatar($comment,50) ?></a>
			</div>
			<div class="media-body">
				<div class="pull-left">
					<div class="info">
						<span class="author"><?php echo get_comment_author_link() ?></span>
						<span class="fa fa-circle"></span><span class="date-created"><?php echo get_comment_date() .', '. get_comment_time() ?></span>
					</div>
				</div>
				<?php 
				$comment_reply_link_args = array(
					'depth'  => $depth, 
					'before' => '<div class="pull-right"><small><i class="fa fa-reply mrs"></i>',
					'after'  => '</small></div>'
				);
				comment_reply_link( array_merge ( $args, $comment_reply_link_args ) ); 
				?>
				<div class="clearfix"></div>
				<div class="description-comment"><?php comment_text() ?></div>
			</div>
		<!--</li>-->
		<?php
	}
endif;

if(SWBIGNEWS_NEWSLETTER_ACTIVE){
	function swbignews_unregister_newsletter_widgets() {
		unregister_widget( 'NewsletterWidget' );
	}
	add_action( 'widgets_init', 'swbignews_unregister_newsletter_widgets', 20 );
	add_action('widgets_init', create_function('', 'return register_widget("Swbignews_Widget_Newsletter");'));
}

/*set banner*/
if( ! function_exists( 'swbignews_banner_header' ) ) {

	function swbignews_banner_header() {
		// Global variable from theme option
		global $swbignews_options;

		$banner = $swbignews_options['swbignews-header-banner'];
		if ( $swbignews_options['swbignews-header-banner'] == 1 ) {
			echo '<div class="banner-header">';
			printf(
				'<a href="%1$s" title="%2$s"><img src="' . esc_url($swbignews_options['shw-display-banner-header']['url']) . '" alt="" class="img-responsive"/></a>', esc_url( home_url() ), get_bloginfo('description')
			);
			echo '</div>';
		}
	}
}
/* 
*add item for user profile
*To get contact items of user :
	* get_user_meta ( int $user_id, string $key = '', bool $single = false )
*/
function swbignews_add_item_user_profile($items) {

	// Add new item
	$links = Swbignews::get_params('author-social-links');
	foreach($links as $k=>$v){
		$items[$k] = $v;
	}
	return $items;
}
add_filter('user_contactmethods', 'swbignews_add_item_user_profile');

/*
	* get Advertisement Settings in Theme option *
*/
if( ! function_exists( 'swbignews_get_ads_settings' ) ) {
	
	function swbignews_get_ads_settings($advertisement) {
		// Global variable from theme option
		global $swbignews_options;
		$option = array();
		$ads_options = Swbignews::get_params('ads_options');
		foreach($ads_options as $key => $value){
			$option_id = sprintf($value, $advertisement);
			$option[$key] = Swbignews::get_value( $swbignews_options, $option_id );
		}
		return $option;
	}
}
/*
	* get share link *
*/
if( ! function_exists( 'swbignews_get_share_link' ) ) {
	
	function swbignews_get_share_link() {
		// Global variable from theme option
		global $swbignews_options;
		$socials = $swbignews_options['shw-blog-social']['enabled'];
		unset($socials['placebo']);
		$arr_link = array();
		$share_url = array(
			'facebook'		=> sprintf('http://www.facebook.com/sharer.php?u=%s',
									urlencode( esc_url( get_permalink() ) ) ),
			'twitter'		=> sprintf('https://twitter.com/intent/tweet?text=%s&url=%s&via=%s',
									htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8'),
									urlencode( esc_url( get_permalink() ) ),
									urlencode( get_bloginfo( 'name' ))
								),
			'google-plus'	=> sprintf('http://plus.google.com/share?url=%s',
									urlencode( esc_url( get_permalink() ))
								),
			'pinterest'		=> sprintf('http://pinterest.com/pin/create/button/?url=%s', 
									urlencode( esc_url(get_permalink()) )
								),
			'stumbleupon'	=> sprintf('http://www.stumbleupon.com/submit?url=%s&title=%s',
									urlencode (esc_url( get_permalink()) ),
									esc_attr( get_the_title() )
								),
			'linkedin'		=> sprintf('http://www.linkedin.com/shareArticle?mini=true&url=%s',
									urlencode( esc_url( get_permalink()) )
								),
			'digg'			=> sprintf('http://digg.com/submit?url=%s&title=%s',
									 urlencode( esc_url(get_permalink())),
									 esc_attr(get_the_title())
								),
		);
		$action = 'window.open(this.href, \'Share Window\',\'left=50,top=50,width=600,height=350,toolbar=0\');';
		foreach($socials as $k=>$v){
			if($k == 'googleplus') $k = 'google-plus';
			$arr_link[] = sprintf('<a href="%s" onclick="%s return false;"><i class="fa fa-%s"></i>%s</a>',
								$share_url[$k], $action, $k, $v);
		}
		return $arr_link;
	}
}
/*
	* get social meta *
*/
if( ! function_exists( 'swbignews_get_social_network_meta' ) ) {
	
	function swbignews_get_social_network_meta($service_id, $user_id, &$td_social_api) {
		switch ($service_id) {
			case 'facebook':
				return array(
					'button' => Swbignews_Translate::_swt( 'Like'),
					'url' => "https://www.facebook.com/$user_id",
					'text' => Swbignews_Translate::_swt( 'Fans' ),
					'api' => $td_social_api->get_social_counter($service_id, $user_id),
				);
				break;
		
			case 'twitter':
				return array(
					'button' => Swbignews_Translate::_swt( 'Follow' ),
					'url' => "https://twitter.com/$user_id",
					'text' => Swbignews_Translate::_swt( 'Followers' ),
					'api' => $td_social_api->get_social_counter($service_id, $user_id),
				);
				break;
		
			case 'vimeo':
				return array(
					'button' => Swbignews_Translate::_swt( 'Like' ),
					'url' => "http://vimeo.com/$user_id",
					'text' => Swbignews_Translate::_swt( 'Likes' ),
					'api' => $td_social_api->get_social_counter($service_id, $user_id),
				);
				break;
		
			case 'youtube':
				return array(
					'button' => Swbignews_Translate::_swt( 'Subscribe' ),
					'url' => (strpos('channel/', $user_id) >= 0) ? "http://www.youtube.com/$user_id" : "http://www.youtube.com/user/$user_id",
					'text' => Swbignews_Translate::_swt( 'Subscribers' ),
					'api' => $td_social_api->get_social_counter($service_id, $user_id),
				);
				break;
		
			case 'google':
				return array(
					'button' => '+1',
					'url' => "https://plus.google.com/$user_id",
					'text' => Swbignews_Translate::_swt( 'Subscribers' ),
					'api' => $td_social_api->get_social_counter($service_id, $user_id),
				);
				break;
		
			case 'instagram':
				return array(
					'button' => Swbignews_Translate::_swt( 'Follow' ),
					'url' => "http://instagram.com/$user_id#",
					'text' => Swbignews_Translate::_swt( 'Followers' ),
					'api' => $td_social_api->get_social_counter($service_id, $user_id),
				);
				break;
		
			case 'soundcloud':
				return array(
					'button' => Swbignews_Translate::_swt( 'Follow' ),
					'url' => "https://soundcloud.com/$user_id",
					'text' => Swbignews_Translate::_swt( 'Followers' ),
					'api' => $td_social_api->get_social_counter($service_id, $user_id),
				);
				break;
		
			case 'rss':
				return array(
					'button' => Swbignews_Translate::_swt( 'Follow' ),
					'url' => get_bloginfo('rss2_url'),
					'text' => Swbignews_Translate::_swt( 'Followers' ),
					'api' => $td_social_api->get_social_counter($service_id, $user_id),
				);
				break;
		}
	}
}
if( !function_exists( 'swbignews_get_block_options' ) ) {
	function swbignews_get_block_options( &$args = array() ) {
		global $swbignews_options;
		$mapping = Swbignews::get_config('mapping', 'bloginfo');
		foreach( $mapping as $key => $option ) {
			$val = '';
			if( ! is_array($option) ) {
				if( isset($swbignews_options[$option]) && $swbignews_options[$option] != '1' ){
					$val = 'hide';
				}
			}
			elseif( isset($swbignews_options[$option[0]][$option[1]][$option[2]]) ) {
				$val = 'hide';
			}
			$args[$key] = $val;
		}
		$mapping = Swbignews::get_config('mapping', 'blogcontent');
		$layout = $args['layout'];
		$layout_arr = explode('-', $layout);
		if( isset($layout_arr[0]) && $layout_arr[0] == 'widget') {
			unset($layout_arr[0]);
		}
		$layout = implode('-', $layout_arr);
		foreach( $mapping as $key => $option ) {
			$option = $option . $layout;
			if(isset($swbignews_options[$option]) ) {
				$args[$key] = $swbignews_options[$option];
			}
		}
		return $args;
	}
}
if( !function_exists( 'swbignews_get_main_category' ) ) {
	function swbignews_get_main_category() {
		global $post;
		$cat = '';
		$post_options = get_post_meta( get_the_ID(), 'shw_page_options', true);
		if ( isset( $post_options['blog_main_category'] ) && !empty( $post_options['blog_main_category'] ) ) {
			// Main category has seleted post options
			$cat = get_category_by_slug( $post_options['blog_main_category'] );
		} else {
			$cat = current( get_the_category( $post ) );
		}
		return $cat;
	}
}
if( !function_exists( 'swbignews_gender_option' ) ) {
	function swbignews_gender_option( $option_name, $term_id ) {
		$cat_data = get_option("shw_category_$term_id");
		if( empty( $cat_data[ $option_name ] ) || $cat_data[ $option_name ] == '0' || $cat_data[ $option_name ] == 'default' ){
			return ( Swbignews::get_option( 'shw-category-template-' . $option_name ) == '' || Swbignews::get_option( 'shw-category-template-' . $option_name ) === '0') ? 1 : Swbignews::get_option( 'shw-category-template-' . $option_name );
		}
		return $cat_data[ $option_name ];
	}
}

//remove all default template of visual composer
add_filter( 'vc_load_default_templates', 'swbignews_my_custom_template_modify_array' );
function swbignews_my_custom_template_modify_array($data) {
    return array();
}

add_action( 'vc_load_default_templates_action','swbignews_my_custom_template_for_vc' ); // Hook in
 
function swbignews_my_custom_template_for_vc() {
	require_once(SWBIGNEWS_THEME_DIR.'/inc/template-page.php');
}

function swbignews_add_theme_script_option() {
	echo '
		<script type="text/javascript">
					var THEME_ADMIN = "'.SWBIGNEWS_ADMIN_URI.'";
		 </script>
	 ';

}
add_action( 'admin_enqueue_scripts', 'swbignews_add_theme_script_option' );

/**
 * Auto detect javascipt and add it to html
 * 
 */
if ( !function_exists('swbignews_javascript_detection') ) {
	function swbignews_javascript_detection() {
		echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
	}
	add_action( 'wp_head', 'swbignews_javascript_detection', 0 );
}