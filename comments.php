<?php
/**
 * The template for displaying comments.
 * 
 * The area of the page that contains both current comments
 * and the comment form.
 * 
 * @author Swlabs
 * @package BigNews
 * @since 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="people-comment" class="comment-news">
	<?php // You can start editing here -- including this comment! ?>
	<div class="comment-form">
		<div class="comment-count"><b><?php printf( _nx( '1 Comment', '%1$s Comments', get_comments_number(), 'comments title', 'bignews' ), number_format_i18n( get_comments_number() ) ); ?></b></div>
		<?php
		//Comment Form
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? " aria-required='true'" : '' );
		$html_req  = ( $req ? " required='required'" : '' );
		$format    = 'xhtml';//The comment form format. Default 'xhtml'. Accepts 'xhtml', 'html5'.
		$html5     = 'html5' === $format;
		$author_field = sprintf(
			'<div class="comment-form-author input-group input-group-lg col-md-12 col-sm-12 col-xs-12">
				<input class="form-control" placeholder="%1$s" id="author" name="author" type="text" value="%2$s" size="30" %3$s />
				<div id="author-err-required" class="input-error-msg hide">%4$s</div>
			</div>',

				Swbignews_Translate::_swt( 'Name'),//placeholder
				esc_attr( $commenter['comment_author'] ),//value
				$aria_req . $html_req, 
				Swbignews_Translate::_swt( 'Please enter your name.')//error message

		);
		$email_field = sprintf(
			'<div class="comment-form-email input-group input-group-lg col-md-12 col-sm-12 col-xs-12">
				<input class="form-control required" placeholder="%1$s" id="email" name="email" %6$s value="%2$s" size="30" aria-describedby="email-notes" %3$s />
				<div class="input-error-msg hide" id="email-err-required">%4$s</div>
				<div class="input-error-msg hide" id="email-err-valid">%5$s</div>
			</div>',

				Swbignews_Translate::_swt( 'Email'),//placeholder
				esc_attr( $commenter['comment_author_email'] ),//value
				$aria_req . $html_req, 
				Swbignews_Translate::_swt( 'Please enter your email address.'),//error message
				Swbignews_Translate::_swt( 'Please enter a valid email address.'),//error message
				( $html5 ? 'type="email"' : 'type="text"' )

		);
		$url_field = sprintf(
			'<div class="comment-form-url input-group input-group-lg col-md-12 col-sm-12 col-xs-12">
				<input class="form-control" placeholder="%1$s" id="url" name="url" %3$s value="%2$s" size="30" />
				<div class="input-error-msg hide" id="url-err-valid">%4$s</div>
			</div>',

			Swbignews_Translate::_swt( 'Website'),//placeholder
			esc_attr( $commenter['comment_author_url'] ),//value
			( $html5 ? 'type="url"' : 'type="text"' ),
			Swbignews_Translate::_swt( 'Please enter a valid web Url.')//error message

		);
		$comment_field = sprintf(
			'<div class="input-group input-group-lg col-md-12 col-sm-12 col-xs-12">
				<textarea id="comment" name="comment" cols="45" rows="4" required="required" class="form-control" placeholder="%1$s"></textarea>
				<div class="input-error-msg hide" id="comment-err-required">%2$s</div>
			</div>',
			Swbignews_Translate::_swt( 'Your comment here...'),//placeholder
			Swbignews_Translate::_swt( 'Please enter comment.')//error message
		);
		
		$comments_args = array(
			'id_form'             => 'comment-form',
			'cancel_reply_link'   => Swbignews_Translate::_swt( 'Cancel'),
			'comment_notes_before'=> '<p class="comment-notes"><span id="email-notes">' . Swbignews_Translate::_swt( 'Your email address will not be published.') . '</span></p>',
			'format'              => $format,
			'fields'              => array( 'author' => $author_field, 'email' => $email_field, 'url' => $url_field),
			'comment_field'       => $comment_field,			
			'class_submit'        => 'btn btn-primary',
			'label_submit'        => Swbignews_Translate::_swt( 'SUBMIT'),
			'submit_field'        => '<div class="media-submit"><span class="input-group-btn">%1$s</span>%2$s</div>',
		);

		ob_start();
		comment_form($comments_args);
		echo str_replace('class="comment-form"', 'class="comment-form form-write-comment"', ob_get_clean());
		?>
		<?php if ( have_comments() ) : ?>
			<div class="comment-list">
				<ul>
				<?php
					wp_list_comments( array(
						'per_page'    => get_option( 'page_comments' ) ? get_option( 'comments_per_page' ) : '',
						'callback'    => 'swbignews_display_comments'
					) );
				?>
				</ul>
			</div>
	
			<?php 
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="paginate-com">
				<?php
					//Create pagination links for the comments on the current post, with single arrow heads for previous/next
					$defaults = array(
						'add_fragment' => '#comments',
						'prev_text' => Swbignews_Translate::_swt( 'Previous'), 
						'next_text' => Swbignews_Translate::_swt( 'Next'),
					);
					paginate_comments_links( $defaults );
				?>
			</div>
			<?php endif; // Check for comment navigation. ?>
	
		<?php endif; // Check for have_comments(). ?>

		<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="no-comments"><?php Swbignews_Translate::_swte( 'Comments are closed'); ?>.</p>
		<?php endif; ?>
	</div><!-- /comment-form -->
</div>