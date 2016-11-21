jQuery(document).ready(function($) {
	"use strict";
	// social
	$(document).on('click','.widget-inside input[id^="widget-sw_social_group"]',function() {
		if($(this).attr('checked') != 'checked') {
			$(this).parents('p').next('div').fadeOut();
		} else {
			$(this).parents('p').next('div').fadeIn();
		}
	});
	// custom sidebar
	$('.widget-liquid-right').append($('#swbignews-custom-widget').html());
	$('.sidebar-shw-custom',$('#widgets-right')).append('<span class="swbignews-sidebar-delete-button">&times;</span>');
	$(".swbignews-sidebar-delete-button").on('click', function(e) { 
		var delete_it = confirm("Do you really want to delete this widget area?");
		if(delete_it == false) return false;

		var widget = $(e.currentTarget).parents('.widgets-holder-wrap:eq(0)'),
			title = widget.find('.sidebar-name h2'),
			spinner = title.find('.spinner'),
			widget_name = $.trim(title.text()),
			nonce = $(e.currentTarget).parents('.widget-liquid-right:eq(0)').find('input[name="swbignews-delete-sidebar-nonce"]').val();
		$.ajax({
			type: "POST",
			url: window.ajaxurl,
			data: {
				action: 'shw_delete_custom_sidebar',
				name: widget_name,
				_wpnonce: nonce
			},

			beforeSend: function()
			{
				spinner.addClass('activate_spinner');
			},
			success: function(response)
			{
				if(response == 'success')
				{
					widget.slideUp(200, function(){
						
						$('.widget-control-remove', widget).trigger('click'); //delete all widgets inside
						widget.remove();
						
						wpWidgets.saveOrder();
						
					});
				} 
			}
		});
	});
});