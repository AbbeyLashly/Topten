jQuery(document).ready(function($) {
	"use strict";
	var Megamenu_Activator = '.menu-item-shw-show-megamenu';
	var Widget_Activator = '.menu-item-shw-show-widget';
	//click - Main Menu
	$(document).on('click', Megamenu_Activator, function() {
		var checkbox = $(this);
		if(checkbox.is(':checked')) {
			$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.menu-item-shw-show-megamenu').attr( 'checked', true );
			$(this).parents('.menu-item:eq(0)').find('.show-widget').addClass('shw-mega-menu-d0');
			
			$(this).parents('.menu-item:eq(0)').find('.megamenu-column').addClass('shw-mega-menu-d0');
			if (!$(Widget_Activator).is(':checked')) {
				$(this).parents('.menu-item:eq(0)').find('.megamenu-column').addClass('shw-mega-menu-d0');
				$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.choose-widgetarea').removeClass('open');
				$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.widget-column').removeClass('open');
			}
			else{
				$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.choose-widgetarea').addClass('open');
				$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.widget-column').addClass('open');
			}
		} else {
			$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.menu-item-shw-show-megamenu').attr( 'checked', false );
			$(this).parents('.menu-item:eq(0)').find('.show-widget').removeClass('shw-mega-menu-d0');
			$(this).parents('.menu-item:eq(0)').find('.tab-title').removeClass('open');
			$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.choose-widgetarea').removeClass('open');
			$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.widget-column').removeClass('open');
			$(this).parents('.menu-item:eq(0)').find('.megamenu-column').removeClass('shw-mega-menu-d0');
		}
	});
	// click  Widget Menu
	$(document).on('click', Widget_Activator, function() {
		var checkbox = $(this);
		if(checkbox.is(':checked')) {
			$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.menu-item-shw-show-widget').attr( 'checked', true );
			$(this).parents('.menu-item:eq(0)').find('.tab-title').addClass('open');
			$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.choose-widgetarea').addClass('open');
			$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.widget-column').addClass('open');
		} else {
			$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.menu-item-shw-show-widget').attr( 'checked', false );
			$(this).parents('.menu-item:eq(0)').find('.tab-title').removeClass('open');
			$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.choose-widgetarea').removeClass('open');
			$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.widget-column').removeClass('open');
		}
	});

	// $('.toplevel_page_BigNews_options').next().css('display','none');
	// $('#2_section_group_li > a > .group_title').unwrap();
	// $('#11_section_group_li > a > .group_title').unwrap();
});