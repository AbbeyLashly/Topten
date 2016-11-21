<?php
class Swbignews_Translate {
	public function __construct( $options = array() ) {
		global $swbignews_translate_option;
		$shw_translate = self::set_translate();
		
		foreach ($shw_translate as $key => $translate_value){
			$swbignews_translate_option[] = array(
				'id'		=> 'shw-text-'.$key,
				'type'		=> 'text',
				'title' 	=> $translate_value[0],
				'default'	=> ''
			);
		}
	}
	
	public static function set_translate(){
		return array(
			'all'	=> array('All', esc_html__('All', 'bignews')),
			'articles'	=> array('Articles', esc_html__('Articles', 'bignews')),
			'author'	=> array('Author', esc_html__('Author', 'bignews')),
			'breaking-news'	=> array('Breaking News', esc_html__('Breaking News', 'bignews')),
			'cancel'		=> array('Cancel', esc_html__('Cancel', 'bignews')),
			'comments-are-closed'	=> array('Comments are closed', esc_html__('Comments are closed', 'bignews')),
			'edit'	=> array('Edit', esc_html__('Edit', 'bignews')),
			'email'			=> array('Email', esc_html__('Email', 'bignews')),
			'error-404'	=> array('Error 404', esc_html__('Error 404', 'bignews')),
			'fans'	=> array('Fans', esc_html__('Fans', 'bignews')),
			'follow'	=> array('Follow', esc_html__('Follow', 'bignews')),
			'followers'	=> array('Followers', esc_html__('Followers', 'bignews')),
			'get-started-here'	=> array('Get started here', esc_html__('Get started here', 'bignews')),
			'lastest-news'	=> array('Lastest News', esc_html__('Lastest News', 'bignews')),
			'lastest-videos'	=> array('Lastest videos', esc_html__('Lastest videos', 'bignews')),
			'like'	=> array('Like', esc_html__('Like', 'bignews')),
			'likes'	=> array('Likes', esc_html__('Likes', 'bignews')),
			'load-more'	=> array('load more', esc_html__('load more', 'bignews')),
			'name'			=> array('Name', esc_html__('Name', 'bignews')),
			'next'			=> array('Next', esc_html__('Next', 'bignews')),
			'newer-posts'	=> array('Newer posts', esc_html__('Newer posts', 'bignews')),
			'of'	=> array('of', esc_html__('of', 'bignews')),
			'older-posts'	=> array('Older posts', esc_html__('Older posts', 'bignews')),
			'page'	=> array('Page', esc_html__('Page', 'bignews')),
			'pages'	=> array('Pages:', esc_html__('Pages:', 'bignews')),
			'please-enter-a-valid-email-address'	=> array('Please enter a valid email address.', esc_html__('Please enter a valid email address.', 'bignews')),
			'please-enter-a-valid-web-url'	=> array('Please enter a valid web Url.', esc_html__('Please enter a valid web Url.', 'bignews')),
			'please-enter-comment'	=> array('Please enter comment.', esc_html__('Please enter comment.', 'bignews')),
			'please-enter-your-email-address'	=> array('Please enter your email address.', esc_html__('Please enter your email address.', 'bignews')),
			'please-enter-your-name'	=> array('Please enter your name.', esc_html__('Please enter your name.', 'bignews')),
			'popular-videos'	=> array('Popular videos', esc_html__('Popular videos', 'bignews')),
			'post-navigation'	=> array('Post navigation', esc_html__('Post navigation', 'bignews')),
			'posts-tagged'	=> array('Posts tagged', esc_html__('Posts tagged', 'bignews')),
			'previous'		=> array('Previous', esc_html__('Previous', 'bignews')),
			'read-more'	=> array('Read more', esc_html__('Read more', 'bignews')),
			'ready-to-publish-your-first-post'	=> array('Ready to publish your first post?', esc_html__('Ready to publish your first post?', 'bignews')),
			'related-posts'	=> array('RELATED POSTS', esc_html__('RELATED POSTS', 'bignews')),
			'related-videos'	=> array('Related Videos', esc_html__('Related Videos', 'bignews')),
			'search'	=> array('Search', esc_html__('Search', 'bignews')),
			'search-results-for'	=> array('Search results for', esc_html__('Search results for', 'bignews')),
			'share'	=> array('Share', esc_html__('Share', 'bignews')),
			'shop-now'	=> array('shop now', esc_html__('shop now', 'bignews')),
			'show-results'	=> array('Show results', esc_html__('Show results', 'bignews')),
			'submit'		=> array('SUBMIT', esc_html__('SUBMIT', 'bignews')),
			'subscribe'	=> array('Subscribe', esc_html__('Subscribe', 'bignews')),
			'subscribers'	=> array('Subscribers', esc_html__('Subscribers', 'bignews')),
			'view'	=> array('view', esc_html__('view', 'bignews')),
			'views'	=> array('Views', esc_html__('Views', 'bignews')),
			'view-more'	=> array('View more', esc_html__('View more', 'bignews')),
			'website'		=> array('Website', esc_html__('Website', 'bignews')),
			'your-comment-here'	=> array('Your comment here...', esc_html__('Your comment here...', 'bignews')),
			'your-email-address-will-not-be-published'	=> array('Your email address will not be published.', esc_html__('Your email address will not be published.', 'bignews')),
			'your-keyword'	=> array('your keyword', esc_html__('your keyword', 'bignews')),
			'specify-a-disqus-shortname'	=> array('Specify a Disqus shortname', esc_html__('Specify a Disqus shortname in Bignews menu &gt; Theme options &gt; Post Setting section in admin panel', 'bignews')),
		);
	}
	public static function _swt( $text ){
		global $swbignews_options;
		$shw_translate = self::set_translate();//swbignews_translate();
		$sanitize_text = 'shw-text-'.sanitize_title( htmlspecialchars ( $text ) );
		if ( isset($swbignews_options[ $sanitize_text ]) && !empty($swbignews_options[ $sanitize_text ]) ){
			return htmlspecialchars_decode ( $swbignews_options[ $sanitize_text ] );
		} else {
			return $shw_translate[sanitize_title( htmlspecialchars ( $text ) )][1];
		}
	}
	
	public static function _swte( $text ){
		echo self::_swt( $text );
	}
} new Swbignews_Translate();