<?php
/**
 * The template for displaying Category pages
 * 
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */

$all_container_css = swbignews_get_container_css();
extract($all_container_css);

$current_category_id = get_query_var( 'cat' );
$current_category_obj = get_category( $current_category_id );

$category_sidebar = swbignews_gender_option( 'sidebar', $current_category_id );
$category_sidebar_position = (swbignews_gender_option( 'sidebar-position', $current_category_id ) == 1 ? 'right' : swbignews_gender_option( 'sidebar-position', $current_category_id ));
$category_top_post = swbignews_gender_option( 'top-post', $current_category_id );
$category_article = swbignews_gender_option( 'article', $current_category_id );

get_header();
$limit = 0;

switch ($category_top_post) {
	case 1:
		$limit = 5;
		break;
	case 2:
		$limit = 5;
		break;
	case 3:
		$limit = 2;
		break;
	default:
		break;
}

$top_atts= array( "layout" => "block-slider-01", "limit_post" => $limit, "category_list" => urlencode("[{\"category_slug\":\"" . $current_category_obj->slug . "\"}]") );

if($category_top_post == 2){
	$top_atts_2= array( "layout" => "block-carousel-05", "limit_post" => $limit, "category_list" => urlencode("[{\"category_slug\":\"" . $current_category_obj->slug . "\"}]") );
}

$paged = ( !empty ( $_GET['page'] ) ) ? absint( $_GET['page'] ) : 1;
$limit_post = get_option('posts_per_page');
$limit = $limit + (($paged - 1) * $limit_post);
$article_atts= array( "layout" => "grid-02", "limit_post" => $limit_post, "offset_post" => $limit, "category_list" => urlencode("[{\"category_slug\":\"" . $current_category_obj->slug . "\"}]"), "pagination" => "custom");


$title = $current_category_obj->name;
?>
<div id="content-wrapper" class="<?php echo esc_attr( $container_css );?>">
	<div id="page-wrapper">
		<div class="main-content">
			<div class="content">
				<div class="container">
					<div class="row">
						<div class="top-post col-sm-12">
							<?php include(locate_template('templates/category-top-post-' . $category_top_post . '.php'));?>
						</div>
						<div class="clearfix"></div>
						<?php
							switch ($category_sidebar_position) {
								case 'left':
									?>
									<div id='page-sidebar' class="col-md-4 col-left col-sm-3">
										<?php swbignews_get_sidebar($category_sidebar); ?>
									</div>
									<div class=" main-wrapper-column col-sm-9 col-md-8 ">
										<?php include(locate_template('templates/category-article-' . $category_article . '.php'));?>
									</div>
									<?php
									break;
								case 'right':
									?>
									<div class=" main-wrapper-column col-sm-9 col-md-8 ">
										<?php include(locate_template('templates/category-article-' . $category_article . '.php'));?>
									</div>
									<div id='page-sidebar' class="col-md-4 col-right col-sm-3">
										<?php swbignews_get_sidebar($category_sidebar); ?>
									</div>
									<?php
									break;
								case 'none':
									?>
									<div class=" main-wrapper-column col-sm-12">
										<?php include(locate_template('templates/category-article-' . $category_article . '.php'));?>
									</div>
									<?php
									break;
								default: // default : sidebar right
									?>
									<div class=" main-wrapper-column col-sm-9 col-md-8 ">
										<?php include(locate_template('templates/category-article-' . $category_article . '.php'));?>
									</div>
									<div id='page-sidebar' class="col-md-4 col-right col-sm-3">
										<?php swbignews_get_sidebar($category_sidebar); ?>
									</div>
									<?php
									break;
							}
						?>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer();?>