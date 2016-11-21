<?php
/**
 * Header Content
 */ 

/************************* Header Login Bar *********************************/
$args = array();
$defaults = array(
		'echo' => true,
		'redirect' => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
		'form_id' => 'loginform',
		'label_username' => 'Username',
		'label_password' => 'Password',
		'label_remember' => 'Remember Me',
		'label_log_in' => 'Log In',
		'id_username' => 'user_login',
		'id_password' => 'user_pass',
		'id_remember' => 'rememberme',
		'id_submit' => 'wp-submit',
		'remember' => true,
		'value_username' => '',
		'value_remember' => false,
	);

	$args = wp_parse_args( $args, apply_filters( 'login_form_defaults', $defaults ) );
	$login_form_top = apply_filters( 'login_form_top', '', $args );
	$login_form_middle = apply_filters( 'login_form_middle', '', $args );
	$login_form_bottom = apply_filters( 'login_form_bottom', '', $args );

if(!is_user_logged_in())
{
$header_login_bar = '
	<div class="list-unstyled list-inline dropdown-login-wrap">
		<div class="dropdown mega-menu-dropdown">
			<a href="#" data-hover="dropdown" class="dropdown-toggle">
				<i class="ion-person mrm"></i>
				<div class="hidden-responsive">Login</div>
			</a>
			<div class="dropdown-menu dropdown-menu-right header-login-menu dropdown-login">
				<div>
					<div class="mega-menu-content">
						<form name="' . $args['form_id'] . '" id="' . $args['form_id'] . '" action="' . esc_url( site_url( 'wp-login.php', 'login_post' ) ) . '" method="post">
						' . $login_form_top . '
							<div class="form-group">
								<div class="input-icon right"><i class="ion-email"></i><input type="text" placeholder="'.esc_html__('Email address','bignews').'" class="form-control"  name="log" id="' . esc_attr( $args['id_username'] ) . '" value="' . esc_attr( $args['value_username'] ) . '" ></div>
							</div>
							<div class="form-group">
								<div class="input-icon right"><i class="ion-locked"></i><input type="password" name="pwd" id="' . esc_attr( $args['id_password'] ) . '" placeholder="'.esc_html__('Password','bignews').'" class="form-control" value="">
								</div>
							</div>
							' . $login_form_middle . '
							' . ( $args['remember'] ? '
							<div class="form-group">
								<div class="checkbox-inline"><label><input name="rememberme" type="checkbox" id="' . esc_attr( $args['id_remember'] ) . '" value="forever"' . ( $args['value_remember'] ? ' checked="checked"' : '' ) . ' /> ' . esc_html( $args['label_remember'] ) . '</label></div>' : '' ) . '
							</div>
							<div class="form-group mbn">
								<input class="btn btn-block button-primary" type="submit" name="wp-submit" id="' . esc_attr( $args['id_submit'] ) . '" value="' . esc_attr( $args['label_log_in'] ) . '" />
								<input type="hidden" name="redirect_to" value="' . esc_url( $args['redirect'] ) . '" />
							</div>
						' . $login_form_bottom . '
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>';
}
else{

	$header_login_bar = '';
}


/************************* Search Form *********************************/

$header_search = '<div class="topbar-search">
						<form class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
							<div class="input-icon right">
								<a href="javascript:void(0);" title="Search anything" class = "submit-form-search"><i class="fa fa-search"></i></a>
								<input placeholder="'.esc_html__('Search here...', 'bignews').'" class="form-control" type="text" name="s">
							</div>
						</form>
					</div>';


/************************* Breaking News *********************************/

$cat		= '';
$tag		= '';
$posts	   = ''; 
$number	 = Swbignews::get_option('shw-breakingnews-number');
$type	   = Swbignews::get_option('shw-breakingnews');
$orderby	= Swbignews::get_option('shw-breakingnews-orderby');
$order	  = Swbignews::get_option('shw-breakingnews-order');
$args = array (
	'posts_per_page'	=> $number,
	'orderby'		   => $orderby,
	'order'			 => $order,
);
if ( $type == 'categories' ) {
	if ( null !== (Swbignews::get_option('shw-breakingnews-cat')) ) {
		$cat = Swbignews::get_option('shw-breakingnews-cat');
		$args['category__in'] = $cat;
	}
} elseif ( $type == 'tags' ) {
	
	if ( null !==(Swbignews::get_option('shw-breakingnews-tag')) ) {
		$tag = Swbignews::get_option('shw-breakingnews-tag');
		$args['tag__in'] = $tag;
	}
} elseif ( $type == 'posts' ) {
	if ( null !== (Swbignews::get_option('shw-breakingnews-post')) ) {
		$posts = Swbignews::get_option('shw-breakingnews-post');
		$args['post__in'] = $posts;
	}
}
$breaking_arr = get_posts($args);

$breakingnews = '';
foreach ($breaking_arr as $breaking) {
	$breakingnews .= '<li><a href="'.esc_url($breaking->guid).'">'.esc_html(substr($breaking->post_title,0, 70 )).'</a></li>';
};
$breakingnews = '<div class="latest-news"><i class="fa fa-rss mrm mtx pull-left"></i><span class="mrm pull-left">'. Swbignews_Translate::_swt( 'Lastest News' ) . ':</span><div class="vticker"><ul class="list-unstyled">'.$breakingnews.'</ul></div></div>';


/************************* Logo *********************************/

$header_logo_data = Swbignews::get_option( 'shw-header-logo');



/************************* Top Navigation *********************************/

$menu_location = 'top-nav' ;
$header_nav = '';
if( has_nav_menu( $menu_location ) ) {
	$walker = new Swbignews_Nav_Walker;
	$header_nav = wp_nav_menu( array(
		'theme_location'   => $menu_location,
		'container'		   => 'nav',
		'container_class'  => 'nav-header topbar-links',
		'menu_class'	   => 'list-inline',
		'echo'			   => '0',
		'walker'		   => $walker
	));
}


/************************* Header Language Bar *********************************/



$header_language_bar = '
							<div class="dropdown dropdown-language">
									<a href="#" data-hover="dropdown" class="dropdown-toggle">
										<img src="'.esc_url(SWBIGNEWS_PUBLIC_URI).'/images/flags/gb.png" alt="" class="mrm"/>
										<div class="hidden-responsive">English</div>
									</a>
									<ul class="dropdown-menu">
										<li>
											<a href="#"><img src="'.esc_url(SWBIGNEWS_PUBLIC_URI).'/images/flags/de.png" alt="" class="mrm"/>German</a>
										</li>
										<li>
											<a href="#"><img src="'.esc_url(SWBIGNEWS_PUBLIC_URI).'/images/flags/fr.png" alt="" class="mrm"/>French</a>
										</li>
										<li>
											<a href="#"><img src="'.esc_url(SWBIGNEWS_PUBLIC_URI).'/images/flags/es.png" alt="" class="mrm"/>Spanish</a>
										</li>
										<li>
											<a href="#"><img src="'.esc_url(SWBIGNEWS_PUBLIC_URI).'/images/flags/it.png" alt="" class="mrm"/>Italian</a>
										</li>
										<li>
											<a href="#"><img src="'.esc_url(SWBIGNEWS_PUBLIC_URI).'/images/flags/ru.png" alt="" class="mrm"/>Russian</a>
										</li>
									</ul>
							</div>
						';


/************************* Social  *********************************/

$header_social_active = Swbignews::get_option('shw-header-social');
$header_social = ' ';
$social_map = Swbignews::get_params( 'header-social');
if( $header_social_active && isset( $header_social_active['enabled'] ) ) {
	foreach ($header_social_active['enabled'] as $key => $value) {
		$check_social =Swbignews::get_option('shw-social-' . $key );
		if(!empty($check_social)) { 
			$header_social .= '
				<li>
					<a href="'. esc_url(Swbignews::get_option('shw-social-' . esc_attr($key) )) .'" class="icon-'.esc_attr($key).'" target="_blank">
						<i class="fa fa-fw ' . esc_attr($social_map[$key]) . '"></i>
					</a>
				</li>';
		}
	}
	$header_social = '<div class="topbar-social"><ul class="list-inline">' . $header_social . '</ul></div>';
}


/********************* Header banner Advertisement *********************/

$header_banner = '';
$banner_code = '';
$banner_image = '';
if ( Swbignews::get_option('shw-display-banner-header') == '1' ) {
	if ( Swbignews::get_option('shw-banner-header-newtab') == '0' ) {
		$header_banner = '
			<a class="header-banner-adv" href="' . esc_url(Swbignews::get_option('shw-banner-header-link')) . '">
				<img class="img img-responsive" src="' . esc_url(Swbignews::get_option('shw-banner-header','url')) .'" alt="'. esc_attr(Swbignews::get_option('shw-banner-header-alt')).'"/>
			</a>';
	} else {
		$header_banner = '
			<a class="header-banner-adv" target="_blank" href="' . esc_url(Swbignews::get_option('shw-banner-header-link')) . '">
				<img class="img img-responsive" src="' . esc_attr(Swbignews::get_option('shw-banner-header','url')) .'" alt="'.esc_attr(Swbignews::get_option('shw-banner-header-alt')).'"/>
			</a>';
	}
} elseif ( Swbignews::get_option('shw-display-banner-header') == '2' ) {
	$header_banner = Swbignews::get_option('shw-banner-header-code');
}


/********************* Content beside logo *********************/

$social_beside_logo = $phone_group = $email_group = '';

$social_map = Swbignews::get_params( 'header-social');
if( $header_social_active && isset( $header_social_active['enabled'] ) ) {
	foreach ($header_social_active['enabled'] as $key => $value) {
		$check_social =Swbignews::get_option('shw-social-' . $key );
		if(!empty($check_social) ) {
			$social_beside_logo .= '<a href="'. esc_url(Swbignews::get_option('shw-social-' . $key )) .'" class="icons" target="_blank"><i class="fa fa-fw ' . esc_attr($social_map[$key]) . '"></i></a>';
			$social_beside_logo .= '';
		}
	}
}
$phone_1 = trim( Swbignews::get_option('shw-phone-1') );
$phone_2 = trim( Swbignews::get_option('shw-phone-2') );
if( !empty( $phone_1 ) ) {
	$phone_1 = '<p>'. esc_html($phone_1) .'</p>';
}
if( !empty( $phone_2 ) ) {
	$phone_2 = '<p>'. esc_html($phone_2) .'</p>';
}
if( !empty($phone_1) || !empty($phone_2) ) {
	$phone_group = '
			<div class="col-md-4 col-sm-6 col-xs-6">
				<div class="block-info"><a href="#" class="icons"><i class="fa fa-phone"></i></a>
					<div class="details">
						'. $phone_1 . $phone_2 .'
					</div>
				</div>
			</div>
	';
}
$email_1 = trim( Swbignews::get_option('shw-email-1') );
$email_2 = trim( Swbignews::get_option('shw-email-2') );
if( !empty( $email_1 ) ) {
	$email_1 = '<p>'. esc_html($email_1) .'</p>';
}
if( !empty( $email_2 ) ) {
	$email_2 = '<p>'. esc_html($email_2) .'</p>';
}
if( !empty($email_1) || !empty($email_2) ) {
	$email_group = '
			<div class="col-md-4 col-sm-6 col-xs-6">
				<div class="block-info"><a href="#" class="icons"><i class="fa fa-envelope"></i></a>
					<div class="details">
						'. $email_1 . $email_2 . '
					</div>
				</div>
			</div>
	';
}
$social_logo = '
		<div class="col-md-4 col-sm-4 col-xs-4 hidden-responsive">
			<div class="block-info">
				'. wp_kses_post($social_beside_logo).'
			</div>
		</div>
';

$content_beside_logo = '<div class="header-info"><div class="row">';
$content_beside_logo .= $phone_group.$email_group.$social_logo;
$content_beside_logo .='</div></div>';



/********************* Logo *********************/
$logo = '
			<a href="'.esc_url( home_url() ).'" title="'. get_bloginfo('description') .'" class="widget-logo logo">
				<img src="' . esc_url( Swbignews::get_option('shw-logo-header','url') ) . '" alt="' . esc_attr( Swbignews::get_option('shw-logo-alt') ) . '" title="' . esc_attr( Swbignews::get_option('shw-logo-title') ) . '" class="site-logo" />
			</a>
		';


/***********************************************************************/
/************************* The Content *********************************/
$header_style='';

$header_left = '';
$header_right = '';
 
	$content_array = array(
	'nav'			=> $header_nav,
	'social'		=> $header_social,
	'search'		=> $header_search,
	'breakingnews'	=> $breakingnews,
	'login'			=> $header_login_bar,
	'language'		=> $header_language_bar,
	'none'			=> ''
	);

	$header_left_active = Swbignews::get_option('shw-header-custom-left');

	if( $header_left_active && isset( $header_left_active['enabled'] ) ) {
		foreach ($header_left_active['enabled'] as $key => $value) {
			if ( $key != 'placebo' && isset( $content_array[$key] ) ) {
				$header_left .= $content_array[$key];
			}
		}
	}

	$header_right_active = Swbignews::get_option('shw-header-custom-right');

	if( $header_right_active && isset( $header_right_active['enabled'] ) ) {
		foreach ($header_right_active['enabled'] as $key => $value) {
			if ( $key != 'placebo' && isset( $content_array[$key] ) ) {
				$header_right .= $content_array[$key];
			}
		}
	}

$headermain_left = '';
$headermain_right = '';
$headermain = '';

$contentmain_array = array(
	'logo'					=> $logo,
	'banner'				=> $header_banner,
	'content-beside-logo'	=> $content_beside_logo,
	'email-group'			=> $email_group,
	'phone-group'			=> $phone_group,
	'social'				=> $social_logo,
	'none'					=> '',
);

$headermain_main_active = Swbignews::get_option('shw-header-main-content');

if( $headermain_main_active && isset( $headermain_main_active['enabled'] ) ) {
	foreach ($headermain_main_active['enabled'] as $key => $value) {
		if ( $key != 'placebo' && isset( $contentmain_array[$key] ) ) {
			$headermain .= $contentmain_array[$key];
		}
	}
}
$headermain = '<div class="header-info">'.$headermain.'</div>';

$headerlogo_pos = Swbignews::get_option('shw-header-logo-pos');

if ( $headerlogo_pos == 'right' ) {
	$headermain_left = $headermain;
	$headermain_right = $logo;
} else {
	$headermain_left = $logo;
	$headermain_right = $headermain;
}

?>