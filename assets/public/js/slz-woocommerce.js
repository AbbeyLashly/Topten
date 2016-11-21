(function($) {
	"use strict";
	$(function(){
		var remember_input = $('.woocommerce .login .form-row:not(.form-row-first):not(.form-row-last) label input');
		$(remember_input).parent().before($(remember_input));
		$('.woocommerce .cart-collaterals').append($('.woocommerce .cart-collaterals .cross-sells'));
		$('.woocommerce .woocommerce-shipping-fields #ship-to-different-address label').before($('.woocommerce .woocommerce-shipping-fields #ship-to-different-address input'));
		$('.slz-woocommerce .type-product .woocommerce-tabs .panel').addClass('fadeIn animated');
		$('.woocommerce table.wishlist_table').parent().addClass('table-responsive');
		$(".slz-woocommerce .type-product .entry-summary .quantity, .woocommerce table.shop_table .quantity").append('<div class="inc button-quantity"><i class="fa fa-caret-up"></i></div><div class="dec button-quantity"><i class="fa fa-caret-down"></i></div>');
		$(".button-quantity").on("click", function() {
			var $button = $(this);
			var oldValue = $button.parent().find("input").val();
			var newVal;

			if ($button.children().hasClass('fa-caret-up')) {
				newVal = parseFloat(oldValue) + 1;
			} else {
				// Don't allow decrementing below zero
				if (oldValue > 0) {
					newVal = parseFloat(oldValue) - 1;
				} else {
					newVal = 0;
				}
			}
			$button.parent().find("input").val(newVal);
		});
		$('.product_meta').insertBefore($('.slz-woocommerce .type-product .entry-summary .price').parent().next());
		// Owl-carousel for thumbnails
		// $('.thumbnails ul').wrap('<div class="slz_exploore_thumb"></div>');
		// $('.slz_exploore_thumb').append('<div class="navslider"><div class="nav-owl-prev">&#x276E;</div><div class="nav-owl-next">&#x276F;</div></div>');
		// // Breakpoint for thumbnails gallery
		// var breakpoints = {
		// 	0: {
		// 		items: 3
		// 	},
		// 	361: {
		// 		items: 4
		// 	},
		// 	481: {
		// 		items: 3
		// 	},
		// 	992: {
		// 		items: 4
		// 	}
		// };
		var owlthumbnails = $('.slz-woocommerce .type-product .images .thumbnails ul').slick({
			// margin: 15,
			// responsive: breakpoints,
            // dots: false
			infinite: true,
			slidesToShow: 3,
  			slidesToScroll: 3
		});
        //
		// // get real items count
		// var items = $(owlthumbnails).find('.owl-item:not(.cloned)').length;
        //
		// // $nav = your navigation element, mine is custom
		// var $nav = $(owlthumbnails).parent().find('.navslider');
        //
		// // add responsive classes to hide navigation if needed
		// if(breakpoints[992].items>=items)  $nav.addClass('hidden-arrows');
		// if(breakpoints[481].items>=items)  $nav.addClass('hidden-arrows');
		// if(breakpoints[361].items>=items)  $nav.addClass('hidden-arrows');
		// if(breakpoints[0].items>=items)    $nav.addClass('hidden-arrows');
        //
		// // Breakpoint_related, interested and upsells
		// var breakpoints_1 = {
		// 	0: {
		// 		margin: 15,
		// 		items: 1
		// 	},
		// 	480: {
		// 		margin: 15,
		// 		items: 2
		// 	},
		// 	601: {
		// 		margin: 15,
		// 		items: 3
		// 	},
		// 	768: {
		// 		margin: 30
		// 	}
		// };

		// var owlthumbnails_1 = $('.woocommerce .cart-collaterals .cross-sells .products, .woocommerce-page .cart-collaterals .cross-sells .products, .slz-woocommerce .type-product .upsells > .products, .slz-woocommerce .type-product .related > .products').owlCarousel({
		// 	nav: true,
		// 	navText: ["&#x276E;","&#x276F;"],
		// 	responsive: breakpoints_1,
        //     dots: false
		// });

		// var owlthumbnails_1 = $('.woocommerce .cart-collaterals .cross-sells .products, .woocommerce-page .cart-collaterals .cross-sells .products, .slz-woocommerce .type-product .upsells > .products, .slz-woocommerce .type-product .related > .products').slick({
		// 	// nav: true,
		// 	// responsive: breakpoints_1,
		// 	slidesToShow: 2,
		// 	prevArrow: '<button type="button" class="slick-prev fa fa-angle-left"></button>',
		// 	nextArrow: '<button type="button" class="slick-next fa fa-angle-right"></button>'
		// });


		var owlthumbnails_1 = $('.col-md-8 .woocommerce .cart-collaterals .cross-sells .products, .col-md-8 .woocommerce-page .cart-collaterals .cross-sells .products, .slz-woocommerce .col-md-8 .type-product .upsells > .products, .slz-woocommerce .col-md-8 .type-product .related > .products').slick({
			// nav: true,
			// responsive: breakpoints_1,
			slidesToShow: 3,
			prevArrow: '<button type="button" class="slick-prev fa fa-angle-left"></button>',
			nextArrow: '<button type="button" class="slick-next fa fa-angle-right"></button>',
			infinite: true,
			responsive: [
			    {
			      breakpoint: 768,
			      settings: {
			        slidesToShow: 2,
			      }
			  },
			  {
				  breakpoint: 481,
				  settings: {
					  slidesToShow: 1,
				  }
			  }
			]
		});

		var owlthumbnails_2 = $('.col-md-12 .woocommerce .cart-collaterals .cross-sells .products, .col-md-12 .woocommerce-page .cart-collaterals .cross-sells .products, .slz-woocommerce .col-md-12 .type-product .upsells > .products, .slz-woocommerce .col-md-12 .type-product .related > .products').slick({
			// nav: true,
			// responsive: breakpoints_1,
			slidesToShow: 4,
			prevArrow: '<button type="button" class="slick-prev fa fa-angle-left"></button>',
			nextArrow: '<button type="button" class="slick-next fa fa-angle-right"></button>',
			infinite: true,
			responsive: [
				{
				  breakpoint: 992,
				  settings: {
					slidesToShow: 3,
				  }
			  },
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2,
				  }
			  },
			  {
				  breakpoint: 481,
				  settings: {
					  slidesToShow: 1,
				  }
			  }
			]
		});


		// $(owlthumbnails_1).each(function(){
		// 	// get real items count
		// 	var items_1   = $(this).find('.owl-item:not(.cloned)').length;
        //
		// 	// $nav = your navigation element, mine is custom
		// 	var $nav_1	= $(this).find('.owl-controls');
        //
		// 	// add responsive classes to hide navigation if needed
		// 	if(breakpoints_1[601].items>=items_1)   $nav_1.addClass('hidden-arrows');
		// 	if(breakpoints_1[480].items>=items_1)   $nav_1.addClass('hidden-arrows');
		// 	if(breakpoints_1[0].items>=items_1)     $nav_1.addClass('hidden-arrows');
		// });
		$('.woocommerce.widget_product_categories .product-categories li .children').each(function(){
			var ul_child_drop = $(this);
			$(ul_child_drop).hide();
			if ($(ul_child_drop).length > 0) {
				$(this).parent().append('<span class="fa fa-long-arrow-right"></span>');
			}
		});
		$('.woocommerce.widget_product_categories .product-categories li span').on('click',function(){
			$(this).prev().slideToggle();
			$(this).parent().toggleClass('open');
		});
		//SHOW THE SALE PERCENTAGE
		$('.product.sale').each(function() {
			var oldPrice = parseFloat($(this).find('.price').find('del').find('.amount').first().text());
			var newPrice = parseFloat($(this).find('.price').find('ins').find('.amount').first().text());
			var salePercent = Math.round((oldPrice - newPrice) / oldPrice * 100);
			$(this).find('.onsale').find('.sale-percent').html(salePercent + '%');
		});
		//PAGINATION REFORMATTED
		$('.woocommerce-pagination > .page-numbers > li .page-numbers:not(.next, .prev)').each(function() {
			var page = parseInt($(this).text());
			if (page < 10) {
				$(this).html('0' + page);
			}
		});

		$('.woocommerce .cart-collaterals .cross-sells ul.products li img, .slz-woocommerce .type-product img').wrap('<div class="img-wrapper"></div>');

		$(".comment-form-rating p.stars a").hover( function() {
			$(this).prevAll().andSelf().addClass( "shine-hover" );
		}, function() {
			$(this).prevAll().andSelf().removeClass( "shine-hover" );
		}).on("click", function() {
			$(this).nextAll().removeClass("shine");
			$(this).prevAll().andSelf().addClass("shine");
		});

		//height
		var $columns = $('ul.products li');
		var height = 0;

		$columns.each(function(){
			if($(this).height() > height){
				height = $(this).height();
			}
		});
		$columns.height(height);
	});
})(jQuery);
