(function($) {
	"use strict";
	var swbignews_quick_contact_widget = function (){
		$('.quick-contact-widget').find('.your-name').children().addClass('form-control').attr('placeholder','Name');
		$('.quick-contact-widget').find('.your-email').children().addClass('form-control').attr('placeholder','Email Address');
		$('.quick-contact-widget').find('.your-subject').children().addClass('form-control').attr('placeholder','Subject');
		$('.quick-contact-widget').find('.your-message').children().addClass('form-control').attr('placeholder','Message');
		$('.quick-contact-widget').find('.wpcf7-submit').addClass('footer-button border-1x');
		
	};
	
	var swbignews_menu = function() {
		$('#main-navigation').each(function (){
			var lastchild = $(this).children().last();
			if ( $(lastchild).hasClass('dropdown-basic') ){
				$(lastchild).find('.dropdown-menu-st-1').removeClass('pull-left').addClass(' pull-right');
				$(lastchild).find('.dropdown-menu-st-1').find('.dropdown-menu').removeClass('dropdown-menu-level-2-st-1').addClass('dropdown-menu-level-2-st-2');
			}
		});
		var column;
		$('.shw-menu-tab').each(function(){
			var tabmenu = $(this);
			tabmenu.find('.shw-tab-item').each(function(){
				column = $(this).attr('data-column');
					$('.shw-widget',$(this)).each(function(){
					$(this).wrap('<div class = "'+column+' col-widget"></div>');
					});
					var span = $(this).find(".col-widget");
					var $div = '';
					if ( column === 'col-md-12'){
						for (var i = 0; i < span.length ; i += 1) {
							$div = $("<div/>", {
								class: 'row'
							});
							span.slice(i, i + 1).wrapAll($div);
						}
					}
					else{
						for (var i = 0; i < span.length ; i += 2) {
							$div = $("<div/>", {
								class: 'row'
							});
							span.slice(i, i + 2).wrapAll($div);
						}
					}
					var tabitem = $(this);
					var item_content = tabitem.find('.tab-pane');
					var tab_content = tabmenu.find('.tab-content');
					item_content.appendTo(tab_content);
			});
			//active first tab of tab menu
			$(this).find('.tab-content').children().first().addClass('active in');
			if ($(this).find('.tab-title').length > 0){
				$(this).find('.nav-tabs').children().slice( 1, 2 ).addClass('active');
			}else{
				$(this).find('.nav-tabs').children().first().addClass('active');
			}
			
		});
		if ( $('.shw-widget').find('.tabmenu-carousel').length > 0 ){
			$('.tabmenu-carousel').owlCarousel({
					margin: 5,
					loop: true,
					lazyLoad: true,
					nav: false,
					autoplay: true,
					autoplayTimeout: 5000,
					smartSpeed: 1200,
					responsiveClass: true,
					responsive: {
						0: {
							items: 1
						},
						768: {
							items: 3
						},
						1024: {
							items: 4
						}
					}
			});
		}

		if ( $('.shw-widget').find('.tabmenu-carousel-2').length > 0 ) {
			$('.tabmenu-carousel-2').owlCarousel({
					loop: true,
					margin: 30,
					smartSpeed: 1200,
					nav: true,
					navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right" ></i>'],
					responsiveClass: true,
					responsive: {
						0: {
							items: 1,
							margin: 15
						},
						480 : {
							items: 2,
							margin: 15
						},
						600: {
							items: 3,
							margin: 15
						},
						1000: {
							items: 3
						}
					}
			});
		}
	}; // end tab menu func

	// menu responsive
	var swbignews_resposnive = function() {
		if ( $(window).width() < 767 ) {
			// clear dropdown hover
			$('header .header-menu .menu > li').removeClass('dropdown');
			$('.menu > li .list-main-menu').removeAttr('data-hover');
			$('.menu > li .list-main-menu').next().hide();
			$('.menu > li').on('hover',function(e){
				e.preventDefault();
				$(this).removeClass('open');
			});
			// custom dropdown
			$('.menu > li .list-main-menu i.fa').on('click',function(e){
				e.preventDefault();
				$(this).parent().next().slideToggle();
			})
		}
	}

	// set height left column = height right column
	var swbignews_setheight = function() {

		$('.sum-height-right').css('height', $('.sum-height-left').height());

		$('.sum-height-right2 .section-content').css('height', $('.sum-height-left2').height() - $('.sum-height-right2 .section-name').height() - 37);

		$('.left-carousel').css('height', $('.right-carousel').height());

		$('.left-video-gallery').css('height', $('.right-video-gallery').height())
	};

	// label news animation in header
	var swbignews_breaking_news = function() {
		var dd = $('.vticker').easyTicker({
			direction: 'up',
			easing: 'easeInOutBack',
			speed: 'slow',
			interval: 3000,
			height: 'auto',
			visible: 1,
			mousePause: 0,
			controls: {
				up: '.up',
				down: '.down',
				toggle: '.toggle',
				stopText: 'Stop !!!'
			}
		}).data('easyTicker');
	};
	/**
	 * Layout when wordpress admin bar active
	 */
	var swbignews_Wpadminbar = function() {
		if ( $( '#wpadminbar' ).length ) {
			var adminbar_style = '<style>html{margin-top:32px;} @media screen and (max-width:782px) {html{margin-top:46px;}}</style>';
			$('body').addClass('adminbar-on');
			$('head').prepend(adminbar_style);
		}
	}; // end func
	// BACK TOP
	var swbignews_back_to_top = function() {
		$('#back-top a').click(function() {
			$('body,html').animate({
				scrollTop : 0
			}, 700);
			return false;
		});
	};
	/**
	 * Comment
	 */
	var swbignews_comment = function() {
		$("#submit",$("#comment-form")).click(function () {
			var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
			var urlPattern = /(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/;
			var isError	= false;
			var focusEle   = null; 
			$("#comment-form .input-error-msg").addClass('hide');
			$("#comment-form input, #comment-form textarea").removeClass('input-error');
			if ( $("#author").length ){
				if($("#comment").val().trim() == '' ){
					$('#comment-err-required').removeClass('hide');
					$("#comment").addClass('input-error');
					isError  = true;
					focusEle = "#comment";
				}
				else if($("#author").val().trim() == '' ) {
						$('#author-err-required').removeClass('hide');
						$("#author").addClass('input-error');
						isError  = true;
						focusEle = "#author";
					}
				else if($("#email").val().trim() == '' ){
					$('#email-err-required').removeClass('hide');
					$("#email").addClass('input-error');
					isError  = true;
					focusEle = "#email";
				}
				else if(!$("#email").val().match(emailRegex)){
					$('#email-err-valid').removeClass('hide');
					$("#email").addClass('input-error');
					isError  = true;
					focusEle = "#email";
				}
			}else{
				if($("#comment").val().trim() == '' ){
					$('#comment-err-required').removeClass('hide');
					$("#comment").addClass('input-error');
					isError  = true;
					focusEle = "#comment";
				}
			}
			if(isError){
				$(focusEle).focus();
				return false;
			}
			return true;
		});
	}; // end comment func

	/**
	 * SearchForm
	 */
	var swbignews_searchform = function() {
		$('.submit-form-search').on('click', function(e){
			e.preventDefault();
			$(this).closest('form').submit();
		});
	};

	// cut text
	// count lenght for descripton
	var swbignews_count_lenght = function(string, length, delimiter) {
		delimiter = delimiter || "&hellip;";
		return string.length > length ? string.substr(0, length) + delimiter : string;
	};

	var swbignews_show_3dots = function(){
		// Init function text truncate

		$('.topic-style-2 .media .title').each(function () {
			$(this).html(swbignews_count_lenght($(this).text(), 48));
		});

		$('.weather-news .today-weather .info p').each(function () {
			$(this).html(swbignews_count_lenght($(this).text(), 9));
		});

		if($(window).width() <= 1024 && $(window).width() > 767) {

			$('.list-submedia-style-1 .layout-media-vertical .style-1 .media .title, .list-submedia-style-1 .layout-media-vertical .style-2 .media .title, .list-submedia-style-1 .layout-media-horizontal .style-1 .media .title, .category-list-style-1 .media .media-right .title').each(function () {
				$(this).html(swbignews_count_lenght($(this).text(), 30));
			});
		}
		else if( $(window).width() <= 767) {

			$('.list-submedia-style-1 .layout-media-horizontal .style-1 .media .title, .list-submedia-style-1 .layout-media-vertical .style-1 .media .title, .list-submedia-style-1 .layout-media-vertical .style-2 .media .title').each(function () {
				$(this).html(swbignews_count_lenght($(this).text(), 50));
			});
		}

		if($(window).width() <= 1024 && $(window).width() > 480) {
			$('.media .media-body .description, .media .media-right .description').each(function () {
				$(this).html(swbignews_count_lenght($(this).text(), 150));
			});

			$('.list-submedia-style-1 .media .caption .title').each(function () {
				$(this).html(swbignews_count_lenght($(this).text(), 50));
			});

			$('.list-submedia-style-1 .col-md-3.col-sm-6.col-xs-6 .media .caption .title').each(function () {
				$(this).html(swbignews_count_lenght($(this).text(), 40));
			});
		}
		else if($(window).width() <= 480) {
			$('.media .media-body .description, .media .media-right .description').each(function () {
				$(this).html(swbignews_count_lenght($(this).text(), 90));
			});

			$('.list-submedia-style-1 .media .caption .title').each(function () {
				$(this).html(swbignews_count_lenght($(this).text(), 40));
			});

			$(' .news-category .media .caption .title').each(function () {
				$(this).html(swbignews_count_lenght($(this).text(), 40));
			});
		}

		if($(window).width() <= 1024 && $(window).width() > 380) {
			$('.list-page-horizotal-full .media .title').each(function () {
				$(this).html(swbignews_count_lenght($(this).text(), 40));
			});
		}
		if($(window).width() > 380 && $(window).width() <= 480){
			$('.list-page-horizotal-1 .media .title').each(function () {
				$(this).html(swbignews_count_lenght($(this).text(), 40));
			});
		}

		if($(window).width() <= 1024) {
			$('.media-body .title, .media-right .title').each(function () {
				$(this).html(swbignews_count_lenght($(this).text(), 60));
			});

			$('.index-topics .media .caption .title').each(function () {
				$(this).html(swbignews_count_lenght($(this).text(), 22));
			});

			$(' .news-category .media .caption .title').each(function () {
				$(this).html(swbignews_count_lenght($(this).text(), 40));
			});

			$('.carousel-style-2 .right-video-gallery .media .caption .title, .news-category .media .caption .title').each(function () {
				$(this).html(swbignews_count_lenght($(this).text(), 50));
			});

		}
	};
	$(document).ready(function() {
		swbignews_menu();
		swbignews_resposnive();
		swbignews_quick_contact_widget();
		swbignews_comment();
		swbignews_searchform();
		swbignews_back_to_top();
		swbignews_setheight();
		swbignews_breaking_news();
		swbignews_Wpadminbar();
		swbignews_show_3dots();
		
	});


	$(window).load(function() {
		swbignews_setheight();
	});
	$(window).resize(function() {
	});
	
})(jQuery);
