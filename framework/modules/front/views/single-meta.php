<div class="info-news">
	<div class="pull-left entry-meta">
		<?php do_action( 'swbignews_entry_meta' );?>
	</div>
	<div class="pull-right info info-style-3">
		<div class="share-link item">
			<a id="blog_share" href="#" data-toggle="dropdown" class="dropdown-toggle">
				<i class="fa fa-share-alt mrs"></i>
				<span class="hidden-text"><?php Swbignews_Translate::_swte( 'Share' ); ?></span>
			</a>
			<ul id="blog-share-contents" aria-labelledby="blog_share" class="dropdown-menu">
			<?php
				if( function_exists( 'swbignews_get_share_link' ) ) {
					$links = swbignews_get_share_link();
					foreach($links as $link){
						printf('<li>%s</li>', $link);
					}
				}
			?>
			</ul>
		</div>
	</div>
	<div class="clearfix"></div>
</div>

