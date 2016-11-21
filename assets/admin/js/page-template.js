jQuery(document).ready(function($) {
	$('.vc_templates-template-type-default_templates').each(function() {

		var template_name = $(this).data('template_name');
		if (template_name == 'technology') {
			$(this).find('.vc_ui-list-bar-item > button.vc_ui-list-bar-item-trigger').html('<div class="temp-img"><img src="'+THEME_ADMIN+'/images/technology.png" /></div></div class="template_name"><span>Technology</span><a onclick="window.open(\'http://wp.swlabs.co/bignews/technology/\', \'_blank\')" class="link-demo">Demo</a><div class="clearfix"></div></div>');
		}
		if ( template_name == 'homepage' ) {
			$(this).find('.vc_ui-list-bar-item > button.vc_ui-list-bar-item-trigger').html('<div class="temp-img"><img src="'+THEME_ADMIN+'/images/homepage.png" /></div></div class="template_name"><span>Homepage</span><a onclick="window.open(\'http://wp.swlabs.co/bignews/\', \'_blank\')" class="link-demo">Demo</a><div class="clearfix"></div></div>');
		}
		if (template_name == 'fashion') {
			$(this).find('.vc_ui-list-bar-item > button.vc_ui-list-bar-item-trigger').html('<div class="temp-img"><img src="'+THEME_ADMIN+'/images/fashion.png" /></div></div class="template_name"><span>Fashion</span><a onclick="window.open(\'http://wp.swlabs.co/bignews/fashion/\', \'_blank\'); return false;" class="link-demo">Demo</a><div class="clearfix"></div></div>');
		}
	});
});