/* global jQuery:false */
/* global HAMPTON_STORAGE:false */

jQuery(document).ready(function() {
	"use strict";
	HAMPTON_STORAGE['theme_init_counter'] = 0;
	hampton_init_actions();
});


// Theme init actions
function hampton_init_actions() {
	"use strict";

	if (HAMPTON_STORAGE['vc_edit_mode'] && jQuery('.vc_empty-placeholder').length==0 && HAMPTON_STORAGE['theme_init_counter']++ < 30) {
		setTimeout(hampton_init_actions, 200);
		return;
	}
	
	hampton_ready_actions();
	hampton_resize_actions();
	hampton_scroll_actions();

	// Resize handlers
	jQuery(window).resize(function() {
		"use strict";
		hampton_resize_actions();
	});

	// Add resize on VC action vc-full-width-row
	jQuery(document).on('vc-full-width-row', function(e, el) {
		hampton_resize_actions();
	});
	
	// Check fullheight elements
	jQuery(document).on('action.init_hidden_elements', hampton_stretch_height);
	jQuery(document).on('action.init_shortcodes', hampton_stretch_height);

	// Scroll handlers
	jQuery(window).scroll(function() {
		"use strict";
		hampton_scroll_actions();
	});
}


// Theme first load actions
//==============================================
function hampton_ready_actions() {
	"use strict";

	// Add scheme class and js support
    //------------------------------------
	document.documentElement.className = document.documentElement.className.replace(/\bno-js\b/,'js');
	if (document.documentElement.className.indexOf(HAMPTON_STORAGE['site_scheme'])==-1)
		document.documentElement.className += ' ' + HAMPTON_STORAGE['site_scheme'];

	// Init background video
    //------------------------------------
	if (HAMPTON_STORAGE['background_video'] && jQuery('.top_panel.with_bg_video').length > 0) {
		// After mejs init
		setTimeout(function() {
			jQuery('.top_panel.with_bg_video').prepend('<video id="background_video" loop muted></video>');
			var bv = new Bideo();
			bv.init({
				// Video element
				videoEl: document.querySelector('#background_video'),
				
				// Container element
				container: document.querySelector('.top_panel'),
				
				// Resize
				resize: true,
				
				// autoplay: false,
				
				isMobile: window.matchMedia('(max-width: 768px)').matches,
				
				playButton: document.querySelector('#background_video_play'),
				pauseButton: document.querySelector('#background_video_pause'),
				
				// Array of objects containing the src and type
				// of different video formats to add
				src: [
					{
						src: HAMPTON_STORAGE['background_video'],
						type: 'video/'+hampton_get_file_ext(HAMPTON_STORAGE['background_video'])
					}
				],
				
				// What to do once video loads (initial frame)
				onLoad: function () {
				}
			});
		}, 10);
	}

	// Tabs
    //------------------------------------
	if (jQuery('.hampton_tabs:not(.inited)').length > 0 && jQuery.ui && jQuery.ui.tabs) {
		jQuery('.hampton_tabs:not(.inited)').each(function () {
			"use strict";
			// Get initially opened tab
			var init = jQuery(this).data('active');
			if (isNaN(init)) {
				init = 0;
				var active = jQuery(this).find('> ul > li[data-active="true"]').eq(0);
				if (active.length > 0) {
					init = active.index();
					if (isNaN(init) || init < 0) init = 0;
				}
			} else {
				init = Math.max(0, init);
			}
			// Init tabs
			jQuery(this).addClass('inited').tabs({
				active: init,
				show: {
					effect: 'fadeIn',
					duration: 300
				},
				hide: {
					effect: 'fadeOut',
					duration: 300
				},
				create: function( event, ui ) {
				    if (ui.panel.length > 0) jQuery(document).trigger('action.init_hidden_elements', [ui.panel]);
				},
				activate: function( event, ui ) {
				    if (ui.newPanel.length > 0) jQuery(document).trigger('action.init_hidden_elements', [ui.newPanel]);
				}
			});
		});
	}
	// AJAX loader for the tabs
	jQuery('.hampton_tabs_ajax').on( "tabsbeforeactivate", function( event, ui ) {
		"use strict";
		if (ui.newPanel.data('need-content')) hampton_tabs_ajax_content_loader(ui.newPanel, 1, ui.oldPanel);
	});
	// AJAX loader for the pages in the tabs
	jQuery('.hampton_tabs_ajax').on( "click", '.nav-links a', function(e) {
		"use strict";
		var panel = jQuery(this).parents('.hampton_tabs_content');
		var page = 1;
		var href = jQuery(this).attr('href');
		var pos = -1;
		if ((pos = href.lastIndexOf('/page/')) != -1 ) {
			page = Number(href.substr(pos+6).replace("/", ""));
			if (!isNaN(page)) page = Math.max(1, page);
		}
		hampton_tabs_ajax_content_loader(panel, page);
		e.preventDefault();
		return false;
	});


	// Menu
    //----------------------------------------------

	// Add TOC in the side menu
	if (jQuery('.menu_side_inner').length > 0 && jQuery('#toc_menu').length > 0)
		jQuery('#toc_menu').appendTo('.menu_side_inner');

	// Add arrows in mobile menu on homepages
	jQuery('.menu_mobile .menu-item-has-children > a').append('<span class="open_child_menu"></span>');

	// Side menu open/close
	jQuery('.menu_side_button').on('click', function(e){
		"use strict";
		jQuery(this).parent().toggleClass('opened');
		e.preventDefault();
		return false;
	});

	// Mobile menu open/close
	jQuery('.menu_mobile_button,.menu_mobile_description').on('click', function(e){
		"use strict";
		jQuery('.menu_mobile_overlay').fadeIn();
		jQuery('.menu_mobile').addClass('opened');
		jQuery(document).trigger('action.stop_wheel_handlers');
		e.preventDefault();
		return false;
	});
	jQuery(document).on('keypress', function(e) {
		"use strict";
		if (e.keyCode == 27) {
			if (jQuery('.menu_mobile.opened').length == 1) {
				jQuery('.menu_mobile_overlay').fadeOut();
				jQuery('.menu_mobile').removeClass('opened');
				jQuery(document).trigger('action.start_wheel_handlers');
				e.preventDefault();
				return false;
			}
		}
	});
	jQuery('.menu_mobile_close, .menu_mobile_overlay').on('click', function(e){
		"use strict";
		jQuery('.menu_mobile_overlay').fadeOut();
		jQuery('.menu_mobile').removeClass('opened');
		jQuery(document).trigger('action.start_wheel_handlers');
		e.preventDefault();
		return false;
	});

	// Open/Close submenu in the mobile menu
	jQuery('.menu_mobile').on('click', 'li a,li a .open_child_menu, ul.product-categories.plain li a .open_child_menu', function(e) {
		"use strict";
		var $a = jQuery(this).hasClass('open_child_menu') ? jQuery(this).parent() : jQuery(this);
		if ($a.parent().hasClass('menu-item-has-children') || $a.parent().hasClass('has_children')) {
			if ($a.attr('href')=='#' || jQuery(this).hasClass('open_child_menu')) {
				if ($a.siblings('ul:visible').length > 0)
					$a.siblings('ul').slideUp().parent().removeClass('opened');
				else {
					jQuery(this).parents('li').siblings('li').find('ul:visible').slideUp().parent().removeClass('opened');
					$a.siblings('ul').slideDown().parent().addClass('opened');
				}
			}
		}
		if (jQuery(this).hasClass('open_child_menu') || $a.attr('href')=='#') {
			e.preventDefault();
			return false;
		}
	});
	
	
	// Init superfish menus
	hampton_init_sfmenu('ul#menu_main');
	if (jQuery('ul#menu_main').hasClass('inited')) jQuery('.menu_main_nav_area').addClass('menu_show');

	// Click on the logo on home page - scroll to top action
	jQuery('.logo').on('click', function(e){
		"use strict";
		if (jQuery(this).attr('href') == '#') {
			hampton_document_animate_to(0);
			e.preventDefault();
			return false;
		}
	});
	
	// Store height of the top panel
	HAMPTON_STORAGE['top_panel_height'] = 0;



	// Search form
    //----------------------------------------------
	if (jQuery('.search_wrap:not(.inited)').length > 0) {
		jQuery('.search_wrap:not(.inited)').each(function() {
			"use strict";
			var ajax_timer = null;
			jQuery(this).addClass('inited');
			// Key is pressed
			jQuery(this).find('.search_field').on('keyup', function(e) {
				"use strict";
				if (jQuery(this).parents('.top_panel_navi').length > 0) {
					var search_field = jQuery(this);
					var search_wrap = search_field.parents('.search_wrap');
					// ESC is pressed
					if (e.keyCode == 27) {
						hampton_search_close(search_wrap);
						e.preventDefault();
						return;
					}
					// Change icon after the search field on any key is pressed
					if (!search_wrap.hasClass('search_style_fullscreen')) {
						if (search_field.val() != '') {
							if (!search_field.siblings('.search_submit').hasClass('icon-search'))
								search_field.siblings('.search_submit').removeClass('icon-cancel').addClass('icon-search');
						} else {
							if (!search_field.siblings('.search_submit').hasClass('icon-cancel'))
								search_field.siblings('.search_submit').removeClass('icon-search').addClass('icon-cancel');
						}
					}
					// AJAX search
					if (search_wrap.hasClass('search_ajax')) {
						var s = search_field.val();
						if (ajax_timer) {
							clearTimeout(ajax_timer);
							ajax_timer = null;
						}
						if (s.length >= 4) {
							ajax_timer = setTimeout(function() {
								jQuery.post(HAMPTON_STORAGE['ajax_url'], {
									action: 'ajax_search',
									nonce: HAMPTON_STORAGE['ajax_nonce'],
									text: s
								}).done(function(response) {
									"use strict";
									clearTimeout(ajax_timer);
									ajax_timer = null;
									var rez = {};
									try {
										rez = JSON.parse(response);
									} catch (e) {
										rez = { error: HAMPTON_STORAGE['search_error'] };
										console.log(response);
									}
									var msg = rez.error === '' ? rez.data : rez.error;
									search_field.parents('.search_ajax').find('.search_results_content').empty().append(rez.data);
									search_field.parents('.search_ajax').find('.search_results').fadeIn();
								});
							}, 500);
						}
					}
				}
			});
			// Click "Search submit"
			jQuery(this).find('.search_submit').on('click', function(e) {
				"use strict";
				var search_wrap = jQuery(this).parents('.search_wrap');
				if (search_wrap.find('.search_field').val() != '' && (jQuery(this).parents('.top_panel_navi').length == 0 || search_wrap.hasClass('search_opened')))
					search_wrap.find('form').get(0).submit();
				else if (jQuery(this).parents('.top_panel_navi').length > 0) {
					if (search_wrap.hasClass('search_opened')) {
						hampton_search_close(search_wrap);
					} else {
						search_wrap.addClass('search_opened');
						if (search_wrap.find('.search_field').val() == '' && !search_wrap.hasClass('search_style_fullscreen'))
							search_wrap.find('.search_submit').removeClass('icon-search').addClass('icon-cancel');
						setTimeout(function() { search_wrap.find('.search_field').get(0).focus(); }, 500);
					}
				}
				e.preventDefault();
				return false;
			});
			// Click "Search close"
			jQuery(this).find('.search_close').on('click', function(e) {
				"use strict";
				hampton_search_close(jQuery(this).parents('.search_wrap'));
				e.preventDefault();
				return false;
			});
			// Click "Close search results"
			jQuery(this).find('.search_results_close').on('click', function(e) {
				"use strict";
				jQuery(this).parent().fadeOut();
				e.preventDefault();
				return false;
			});
			// Click "More results"
			jQuery(this).on('click', '.search_more', function(e) {
				"use strict";
				if (jQuery(this).parents('.search_wrap').find('.search_field').val() != '')
					jQuery(this).parents('.search_wrap').find('form').get(0).submit();
				e.preventDefault();
				return false;
			});
		});
	}
	
	// Close search field (remove class 'search_opened' and close search results)
	function hampton_search_close(search_wrap) {
		if (search_wrap.parents('.top_panel_navi').length > 0) {
			search_wrap.removeClass('search_opened');
			if (search_wrap.find('.search_submit').hasClass('icon-cancel'))
				search_wrap.find('.search_submit').removeClass('icon-cancel').addClass('icon-search');
			search_wrap.find('.search_results').fadeOut();
		}
	}


	// Widgets decoration
    //----------------------------------------------

	// Decorate nested lists in widgets and side panels
	jQuery('.widget ul > li').each(function() {
		"use strict";
		if (jQuery(this).find('ul').length > 0) {
			jQuery(this).addClass('has_children');
		}
	});

	// Archive widget decoration
	jQuery('.widget_archive a').each(function() {
		"use strict";
		var val = jQuery(this).html().split(' ');
		if (val.length > 1) {
			val[val.length-1] = '<span>' + val[val.length-1] + '</span>';
			jQuery(this).html(val.join(' '))
		}
	});


	// Forms validation
    //----------------------------------------------

	var s = jQuery("select:not(.esg-sorting-select)").wrap('<div class="select_container"></div>');

	// Bubble submit() up for widget "Categories"
	if ( s.parents( '.widget_categories' ).length > 0 ) {
			s.parent().each( function (ind, item) { jQuery(item).get(0).submit = function() {
				jQuery(item).closest('form').submit();
			};
		});
	}

	// Comment form
	jQuery("form#commentform").submit(function(e) {
		"use strict";
		var rez = hampton_comments_validate(jQuery(this));
		if (!rez)
			e.preventDefault();
		return rez;
	});

	jQuery("form").on('keypress', '.error_field', function() {
		if (jQuery(this).val() != '')
			jQuery(this).removeClass('error_field');
	});


	// Pagination
    //------------------------------------

	// Load more
	jQuery('.nav-links-more a').on('click', function(e) {
		"use strict";
		if (HAMPTON_STORAGE['load_more_link_busy']) return;
		HAMPTON_STORAGE['load_more_link_busy'] = true;
		var more = jQuery(this);
		var page = Number(more.data('page'));
		var max_page = Number(more.data('max-page'));
		if (page >= max_page) {
			more.parent().hide();
			return;
		}
		more.parent().addClass('loading');
		var panel = more.parents('.hampton_tabs_content');
		if (panel.length == 0) {															// Load simple page content
			jQuery.get(location.href, {
				paged: page+1
			}).done(function(response) {
				"use strict";
				hampton_loadmore_add_items(jQuery('.content > .posts_container').eq(0), jQuery(response).find('.content > .posts_container > article'));
			});
		} else {																			// Load tab's panel content
			jQuery.post(HAMPTON_STORAGE['ajax_url'], {
				nonce: HAMPTON_STORAGE['ajax_nonce'],
				action: 'hampton_ajax_get_posts',
				blog_template: panel.data('blog-template'),
				blog_style: panel.data('blog-style'),
				posts_per_page: panel.data('posts-per-page'),
				cat: panel.data('cat'),
				parent_cat: panel.data('parent-cat'),
				post_type: panel.data('post-type'),
				taxonomy: panel.data('taxonomy'),
				page: page+1
			}).done(function(response) {
				"use strict";
				var rez = {};
				try {
					rez = JSON.parse(response);
				} catch (e) {
					rez = { error: HAMPTON_STORAGE['strings']['ajax_error'] };
					console.log(response);
				}
				if (rez.error !== '') {
					panel.html('<div class="hampton_error">'+rez.error+'</div>');
				} else {
					hampton_loadmore_add_items(panel.find('.posts_container'), jQuery(rez.data).find('article'));
				}
			});
		}
		// Append items to the container
		function hampton_loadmore_add_items(container, items) {
			if (container.length > 0 && items.length > 0) {
				container.append(items);
				if (container.hasClass('portfolio_wrap')) {
					container.masonry( 'appended', items );
					if (container.hasClass('gallery_wrap')) {
						HAMPTON_STORAGE['GalleryFx'][container.attr('id')].appendItems();
					}
				}
				more.data('page', page+1).parent().removeClass('loading');
				// Remove TOC if exists (rebuild on init_shortcodes)
				jQuery('#toc_menu').remove();
				// Trigger actions to init new elements
				HAMPTON_STORAGE['init_all_mediaelements'] = true;
				jQuery(document).trigger('action.init_shortcodes', [container.parent()]);
				jQuery(document).trigger('action.init_hidden_elements', [container.parent()]);
			}
			if (page+1 >= max_page)
				more.parent().hide();
			else
				HAMPTON_STORAGE['load_more_link_busy'] = false;
			// Fire 'window.scroll' after clearing busy state
			jQuery(window).trigger('scroll');
		}
		e.preventDefault();
		return false;
	});

	// Checkbox with "I agree..."
	if (jQuery('input[type="checkbox"][name="i_agree_privacy_policy"]:not(.inited),input[type="checkbox"][name="gdpr_terms"]:not(.inited),input[type="checkbox"][name="wpgdprc"]:not(.inited),#wpmtst-form input[type="checkbox"]:not(.inited),input[type="checkbox"][name="AGREE_TO_TERMS"]:not(.inited)').length > 0) {
		jQuery('input[type="checkbox"][name="i_agree_privacy_policy"]:not(.inited),input[type="checkbox"][name="gdpr_terms"]:not(.inited),input[type="checkbox"][name="wpgdprc"]:not(.inited),#wpmtst-form input[type="checkbox"]:not(.inited),input[type="checkbox"][name="AGREE_TO_TERMS"]:not(.inited)')
			.addClass('inited')
			.on('change', function(e) {
				if (jQuery(this).get(0).checked)
					jQuery(this).parents('form').find('button,input[type="submit"]').removeAttr('disabled');
				else
					jQuery(this).parents('form').find('button,input[type="submit"]').attr('disabled', 'disabled');
			}).trigger('change');
	}

	// CF7 checkboxes - add class to correct check/uncheck pseudoelement when input at right side of the label
	jQuery( '.wpcf7-checkbox > .wpcf7-list-item > .wpcf7-list-item-label,.wpcf7-radio > .wpcf7-list-item > .wpcf7-list-item-label,.wpcf7-wpgdprc > .wpcf7-list-item > .wpcf7-list-item-label' ).on(
		'click', function() {
			var chk = jQuery( this ).siblings( 'input[type="checkbox"],input[type="radio"]' );
			if (chk.attr( 'type' ) == 'radio') {
				jQuery( this ).parents( '.wpcf7-radio' )
					.find( '.wpcf7-list-item-label' ).removeClass( 'wpcf7-list-item-checked' )
					.find( 'input[type="radio"]' ).each(
					function(){
						this.checked = false;
					}
				);
			}
			if (chk.length > 0) {
				chk.get( 0 ).checked = chk.get( 0 ).checked ? false : true;
				jQuery( this ).toggleClass( 'wpcf7-list-item-checked', chk.get( 0 ).checked );
				chk.trigger('change');
			}
		}
	);


	// Infinite scroll
    jQuery(document).on('action.scroll_actions', function(e) {
		"use strict";
		if (HAMPTON_STORAGE['load_more_link_busy']) return;
		var container = jQuery('.content > .posts_container').eq(0);
		var inf = jQuery('.nav-links-infinite');
		if (inf.length == 0) return;
		if (container.offset().top + container.height() < jQuery(window).scrollTop() + jQuery(window).height()*1.5)
			inf.find('a').trigger('click');
	});
		

	// Other settings
    //------------------------------------

	jQuery(document).trigger('action.ready');

	// Init post format specific scripts
	jQuery(document).on('action.init_hidden_elements', hampton_init_post_formats);

	// Init hidden elements (if exists)
	jQuery(document).trigger('action.init_hidden_elements', [jQuery('body').eq(0)]);
	
} //end ready




// Scroll actions
//==============================================

// Do actions when page scrolled
function hampton_scroll_actions() {
	"use strict";

	var scroll_offset = jQuery(window).scrollTop();
	var adminbar_height = Math.max(0, jQuery('#wpadminbar').height());

	if (HAMPTON_STORAGE['top_panel_height'] == 0)	HAMPTON_STORAGE['top_panel_height'] = jQuery('.top_panel_navi').outerHeight();

	// Call theme/plugins specific action (if exists)
    //----------------------------------------------
    jQuery(document).trigger('action.scroll_actions');

	// Fix/unfix top panel
	if (!jQuery('body').hasClass('mobile_layout') && !jQuery('body').hasClass('menu_style_side') && !jQuery('body').hasClass('header_position_under')) {
		var slider_height = 0;
		if (scroll_offset <= slider_height + HAMPTON_STORAGE['top_panel_height']) {
			if (jQuery('body').hasClass('top_panel_fixed')) {
				jQuery('body').removeClass('top_panel_fixed');
				jQuery('.top_panel_navi').removeClass('state_fixed');
			}
		} else if (scroll_offset > slider_height + HAMPTON_STORAGE['top_panel_height']) {
			if (!jQuery('body').hasClass('top_panel_fixed') && jQuery(document).height() > jQuery(window).height()*1.5) {
				jQuery('.top_panel_fixed_wrap').height(HAMPTON_STORAGE['top_panel_height']);
				jQuery('.top_panel_navi').css('marginTop', '-150px').animate({'marginTop': 0}, 500);
				jQuery('.top_panel_navi').addClass('state_fixed');
				jQuery('body').addClass('top_panel_fixed');
			}
		}
	}
	
	// Fix/unfix sidebar
	hampton_fix_sidebar();

	// Shift top and footer panels when header position equal to 'Under content'
	if (jQuery('body').hasClass('header_position_under') && !hampton_browser_is_mobile()) {
		var delta = 50;
		var adminbar = jQuery('#wpadminbar');
		var adminbar_height = adminbar.length == 0 && adminbar.css('position') == 'fixed' ? 0 : adminbar.height();
		var header = jQuery('.top_panel');
		var header_height = header.height();
		var mask = header.find('.top_panel_mask');
		if (mask.length==0) {
			header.append('<div class="top_panel_mask"></div>');
			mask = header.find('.top_panel_mask');
		}
		if (scroll_offset > adminbar_height) {
			var offset = scroll_offset - adminbar_height;
			if (offset <= header_height) {
				var mask_opacity = Math.max(0, Math.min(0.8, (offset-delta)/header_height));
				header.css('top', Math.round(offset/1.2)+'px');
				mask.css({
					'opacity': mask_opacity,
					'display': offset==0 ? 'none' : 'block'
				});
			} else if (parseInt(header.css('top')) != 0) {
				header.css('top', Math.round(offset/1.2)+'px');
			}
		} else if (parseInt(header.css('top')) != 0) {
			header.css('top', '0px');
			mask.css({
				'opacity': 0,
				'display': 'none'
			});
		}
		var footer = jQuery('.site_footer_wrap');
		var footer_height = Math.min(footer.height(), jQuery(window).height());
		var footer_visible = (scroll_offset + jQuery(window).height()) - (header.outerHeight() + jQuery('.page_content_wrap').outerHeight());
		if (footer_visible > 0) {
			mask = footer.find('.top_panel_mask');
			if (mask.length==0) {
				footer.append('<div class="top_panel_mask"></div>');
				mask = footer.find('.top_panel_mask');
			}
			if (footer_visible <= footer_height) {
				var mask_opacity = Math.max(0, Math.min(0.8, (footer_height - footer_visible)/footer_height));
				footer.css('top', -Math.round((footer_height - footer_visible)/1.2)+'px');
				mask.css({
					'opacity': mask_opacity,
					'display': footer_height - footer_visible <= 0 ? 'none' : 'block'
				});
			} else if (parseInt(footer.css('top')) != 0) {
				footer.css('top', 0);
				mask.css({
					'opacity': 0,
					'display': 'none'
				});
			}
		}
	}
	
	// Scroll actions for animated elements
	jQuery('[data-animation^="animated"]:not(.animated)').each(function() {
		"use strict";
		if (jQuery(this).offset().top < jQuery(window).scrollTop() + jQuery(window).height())
			jQuery(this).addClass(jQuery(this).data('animation'));
	});
}



// Resize actions
//==============================================

// Do actions when page scrolled
function hampton_resize_actions(cont) {
	"use strict";
	hampton_check_layout();
	hampton_fix_sidebar();
	hampton_fix_footer();
	hampton_stretch_width(cont);
	hampton_stretch_height(null, cont);
        hampton_resize_video( cont );
	hampton_vc_row_fullwidth_to_boxed(cont);
	if (HAMPTON_STORAGE['menu_stretch']) hampton_stretch_sidemenu();
}


// Stretch sidemenu (if present)
function hampton_stretch_sidemenu() {
	"use strict";
	var toc_items = jQuery('.menu_side_wrap .toc_menu_item');
	if (toc_items.length < 5) return;
	var toc_items_height = jQuery(window).height() - jQuery('.menu_side_wrap .logo').outerHeight() - toc_items.length;
	var th = Math.floor(toc_items_height / toc_items.length);
	var th_add = toc_items_height - th*toc_items.length;
	toc_items.find(".toc_menu_description,.toc_menu_icon").css({
		'height': th+'px',
		'lineHeight': th+'px'
	});
	toc_items.eq(0).find(".toc_menu_description,.toc_menu_icon").css({
		'height': (th+th_add)+'px',
		'lineHeight': (th+th_add)+'px'
	});
}

// Check for mobile layout
function hampton_check_layout() {
	"use strict";
	if (jQuery('body').hasClass('no_layout'))
		jQuery('body').removeClass('no_layout');
	var w = window.innerWidth;
	if (w == undefined) 
		w = jQuery(window).width()+(jQuery(window).height() < jQuery(document).height() || jQuery(window).scrollTop() > 0 ? 16 : 0);
	if (HAMPTON_STORAGE['mobile_layout_width'] >= w) {
		if (!jQuery('body').hasClass('mobile_layout')) {
			jQuery('body').removeClass('top_panel_fixed desktop_layout').addClass('mobile_layout');
			jQuery('.top_panel_navi').removeClass('state_fixed');
		}
	} else {
		if (!jQuery('body').hasClass('desktop_layout')) {
			jQuery('body').removeClass('mobile_layout').addClass('desktop_layout');
			jQuery('.menu_mobile').removeClass('opened');
			jQuery('.menu_mobile_overlay').hide();
		}
	}
}

// Stretch area to full window width
function hampton_stretch_width(cont) {
	"use strict";
	if (cont===undefined) cont = jQuery('body');
	cont.find('.trx-stretch-width').each(function() {
		"use strict";
		var $el = jQuery(this);
		var $el_cont = $el.parents('.page_wrap');
		var $el_cont_offset = 0;
		if ($el_cont.length == 0) 
			$el_cont = jQuery(window);
		else
			$el_cont_offset = $el_cont.offset().left;
		var $el_full = $el.next('.trx-stretch-width-original');
		var el_margin_left = parseInt( $el.css( 'margin-left' ), 10 );
		var el_margin_right = parseInt( $el.css( 'margin-right' ), 10 );
		var offset = $el_cont_offset - $el_full.offset().left - el_margin_left;
		var width = $el_cont.width();
		if (!$el.hasClass('inited')) {
			$el.addClass('inited invisible');
			$el.css({
				'position': 'relative',
				'box-sizing': 'border-box'
			});
		}
		$el.css({
			'left': offset,
			'width': $el_cont.width()
		});
		if ( !$el.hasClass('trx-stretch-content') ) {
			var padding = Math.max(0, -1*offset);
			var paddingRight = Math.max(0, width - padding - $el_full.width() + el_margin_left + el_margin_right);
			$el.css( { 'padding-left': padding + 'px', 'padding-right': paddingRight + 'px' } );
		}
		$el.removeClass('invisible');
	});
}

// Stretch area to the full window height
function hampton_stretch_height(e, cont) {
	"use strict";
	if (cont===undefined) cont = jQuery('body');
	cont.find('.trx-stretch-height').each(function () {
		"use strict";
		var fullheight_item = jQuery(this);
		// If item now invisible
		if (jQuery(this).parents('div:hidden,article:hidden').length > 0) {
			return;
		}
		var wh = 0;
		var fullheight_row = jQuery(this).parents('.vc_row-o-full-height');
		if (fullheight_row.length > 0) {
			wh = fullheight_row.height();
		} else {
			if (screen.width > 1000) {
				var adminbar = jQuery('#wpadminbar');
				wh = jQuery(window).height() - (adminbar.length > 0 ? adminbar.height() : 0);
			} else
				wh = 'auto';
		}
		if (wh=='auto' || wh > 0) fullheight_item.height(wh);
	});
}
	
// Recalculate width of the vc_row[data-vc-full-width="true"] when content boxed or menu_style=='left|right'
function hampton_vc_row_fullwidth_to_boxed(row) {
	"use strict";
	if (jQuery('body').hasClass('body_style_boxed') || jQuery('body').hasClass('menu_style_side')) {
		if (row === undefined) row = jQuery('.vc_row[data-vc-full-width="true"]');
		var width_content = jQuery('.page_wrap').width();
		var width_content_wrap = jQuery('.page_content_wrap  .content_wrap').width();
		var indent = ( width_content - width_content_wrap ) / 2;
		var rtl = jQuery('html').attr('dir') == 'rtl';
		row.each( function() {
			"use strict";
			var mrg = parseInt(jQuery(this).css('marginLeft'));
			jQuery(this).css({
				'width': width_content,
				'left': rtl ? 'auto' : -indent-mrg,
				'right': rtl ? -indent-mrg : 'auto',
				'padding-left': indent+mrg,
				'padding-right': indent+mrg
			});
			if (jQuery(this).attr('data-vc-stretch-content')) {
				jQuery(this).css({
					'padding-left': 0,
					'padding-right': 0
				});
			}
		});
	}
}


// Fix/unfix footer
function hampton_fix_footer() {
	"use strict";
	if (jQuery('body').hasClass('header_position_under') && !hampton_browser_is_mobile()) {
		var ft = jQuery('.site_footer_wrap');
		if (ft.length > 0) {
			var ft_height = ft.outerHeight(false),
				pc = jQuery('.page_content_wrap'),
				pc_offset = pc.offset().top,
				pc_height = pc.height();
			if (pc_offset + pc_height + ft_height < jQuery(window).height()) {
				if (ft.css('position')!='absolute') {
					ft.css({
						'position': 'absolute',
						'left': 0,
						'bottom': 0,
						'width' :'100%'
					});
				}
			} else {
				if (ft.css('position')!='static') {
					ft.css({
						'position': 'static',
						'left': 'auto',
						'bottom': 'auto'
					});
				}
			}
		}
	}
}


// Fix/unfix sidebar
function hampton_fix_sidebar() {
	"use strict";
	var sb = jQuery('.sidebar');
	if (sb.length > 0) {

		// Unfix when sidebar is under content
		if (jQuery('.page_content_wrap .content_wrap .content').css('float') == 'none') {
			if (sb.css('position')=='fixed') {
				sb.css({
					'float': sb.hasClass('right') ? 'right' : 'left',
					'position': 'static'
				});
			}

		} else {

			var sb_height = sb.outerHeight() + 30;
			var content_height = sb.siblings('.content').outerHeight();
			var scroll_offset = jQuery(window).scrollTop();
			var top_panel_height = jQuery('.top_panel').length > 0 ? jQuery('.top_panel').outerHeight() : 0;
			var widgets_above_page_height = jQuery('.widgets_above_page_wrap').length > 0 ? jQuery('.widgets_above_page_wrap').height() : 0;
			var page_padding = parseInt(jQuery('.page_content_wrap').css('paddingTop'));
			if (isNaN(page_padding)) page_padding = 0;

			if (sb_height < content_height && 
				(sb_height >= jQuery(window).height() && scroll_offset + jQuery(window).height() > sb_height+top_panel_height+widgets_above_page_height+page_padding
				||
				sb_height < jQuery(window).height() && scroll_offset > top_panel_height+widgets_above_page_height+page_padding )
				) {
				
				// Fix when sidebar bottom appear
				if (sb.css('position')!=='fixed') {
					sb.css({
						'float': 'none',
						'position': 'fixed',
						'top': Math.min(0, jQuery(window).height() - sb_height) + 'px'
					});
				}
				
				// Detect horizontal position when resize
				var pos = jQuery('.page_content_wrap .content_wrap').position();
				pos = pos.left + Math.max(0, parseInt(jQuery('.page_content_wrap .content_wrap').css('paddingLeft'))) + Math.max(0, parseInt(jQuery('.page_content_wrap .content_wrap').css('marginLeft')));
				if (sb.hasClass('right'))
					sb.css({ 'right': pos });
				else
					sb.css({ 'left': pos });
				
				// Shift to top when footer appear
				var footer_top = 0;
				var footer_pos = jQuery('.site_footer_wrap').position();
				var widgets_below_page_pos = jQuery('.widgets_below_page_wrap').position();
				if (widgets_below_page_pos)
					footer_top = widgets_below_page_pos.top;
				else if (footer_pos)
					footer_top = footer_pos.top;
				if (footer_top > 0 && scroll_offset + jQuery(window).height() > footer_top)
					sb.css({
						'top': Math.min(top_panel_height+page_padding, jQuery(window).height() - sb_height - (scroll_offset + jQuery(window).height() - footer_top + 30)) + 'px'
					});
				else
					sb.css({
						'top': Math.min(top_panel_height+page_padding, jQuery(window).height() - sb_height) + 'px'
					});
				

			} else {

				// Unfix when page scrolling to top
				if (sb.css('position')=='fixed') {
					sb.css({
						'float': sb.hasClass('right') ? 'right' : 'left',
						'position': 'static',
						'top': 'auto',
						'left': 'auto',
						'right': 'auto'
					});
				}

			}
		}
	}
}





// Navigation
//==============================================

// Init Superfish menu
function hampton_init_sfmenu(selector) {
	"use strict";
	jQuery(selector).show().each(function() {
		"use strict";
		jQuery(this).addClass('inited').superfish({
			delay: 500,
			animation: {
				opacity: 'show'
			},
			animationOut: {
				opacity: 'hide'
			},
			speed: 		HAMPTON_STORAGE['menu_animation_in']!='none' ? 500 : 200,
			speedOut:	HAMPTON_STORAGE['menu_animation_out']!='none' ? 500 : 200,
			autoArrows: false,
			dropShadows: false,
			onBeforeShow: function(ul) {
				"use strict";
				if (jQuery(this).parents("ul").length > 1){
					var w = jQuery(window).width();  
					var par_offset = jQuery(this).parents("ul").offset().left;
					var par_width  = jQuery(this).parents("ul").outerWidth();
					var ul_width   = jQuery(this).outerWidth();
					if (par_offset+par_width+ul_width > w-20 && par_offset-ul_width > 0)
						jQuery(this).addClass('submenu_left');
					else
						jQuery(this).removeClass('submenu_left');
				}
				if (HAMPTON_STORAGE['menu_animation_in']!='none') {
					jQuery(this).removeClass('animated fast '+HAMPTON_STORAGE['menu_animation_out']);
					jQuery(this).addClass('animated fast '+HAMPTON_STORAGE['menu_animation_in']);
				}
			},
			onBeforeHide: function(ul) {
				"use strict";
				if (HAMPTON_STORAGE['menu_animation_out']!='none') {
					jQuery(this).removeClass('animated fast '+HAMPTON_STORAGE['menu_animation_in']);
					jQuery(this).addClass('animated fast '+HAMPTON_STORAGE['menu_animation_out']);
				}
			}
		});
	});
}




// Post formats init
//=====================================================

function hampton_init_post_formats(e, cont) {
	"use strict";

	// MediaElement init
	hampton_init_media_elements(cont);
	
	// Video play button
	cont.find('.format-video .post_featured.with_thumb .post_video_hover:not(.inited)')
		.addClass('inited')
		.on('click', function(e) {
			"use strict";
			jQuery(this).parents('.post_featured')
				.addClass('post_video_play')
				.find('.post_video').html(jQuery(this).data('video'));
			jQuery(window).trigger('resize');
			e.preventDefault();
			return false;
		});
}


function hampton_init_media_elements(cont) {
	"use strict";
	if (HAMPTON_STORAGE['use_mediaelements'] && cont.find('audio:not(.inited),video:not(.inited)').length > 0) {
		if (window.mejs) {
            if (window.mejs.MepDefaults != undefined) window.mejs.MepDefaults.enableAutosize = true;
            if (window.mejs.MediaElementDefaults != undefined) window.mejs.MediaElementDefaults.enableAutosize = true;
			cont.find('audio:not(.inited),video:not(.inited)').each(function() {
				"use strict";
				if (jQuery(this).parents('.mejs-mediaelement').length == 0
					&& jQuery( this ).parents( '.wp-block-video' ).length == 0 && ! jQuery( this ).hasClass( 'wp-block-cover__video-background' )
					&& (HAMPTON_STORAGE['init_all_mediaelements'] || (!jQuery(this).hasClass('wp-audio-shortcode') && !jQuery(this).hasClass('wp-video-shortcode') && !jQuery(this).parent().hasClass('wp-playlist')))) {
					var media_tag = jQuery(this);
					var settings = {
						enableAutosize: true,
						videoWidth: -1,		// if set, overrides <video width>
						videoHeight: -1,	// if set, overrides <video height>
						audioWidth: '100%',	// width of audio player
						audioHeight: 30,	// height of audio player
						success: function(mejs) {
							var autoplay, loop;
							if ( 'flash' === mejs.pluginType ) {
								autoplay = mejs.attributes.autoplay && 'false' !== mejs.attributes.autoplay;
								loop = mejs.attributes.loop && 'false' !== mejs.attributes.loop;
								autoplay && mejs.addEventListener( 'canplay', function () {
									mejs.play();
								}, false );
								loop && mejs.addEventListener( 'ended', function () {
									mejs.play();
								}, false );
							}
						}
					};
					jQuery(this).mediaelementplayer(settings);
				}
			});
		} else
				setTimeout(function() { hampton_init_media_elements(cont); }, 400);
		}
	}


	// Fit video frames to document width
	function hampton_resize_video(cont) {
		if (cont === undefined) {
			cont = jQuery( 'body' );
		}
		cont.find( 'video' ).each(
			function() {
				// If item now invisible
				if (jQuery( this ).hasClass( 'trx_addons_resize' ) || jQuery( this ).parents( 'div:hidden,section:hidden,article:hidden' ).length > 0) {
					return;
				}
				var video     = jQuery( this ).addClass( 'hampton_resize' ).eq( 0 );
				var ratio     = (video.data( 'ratio' ) !== undefined ? video.data( 'ratio' ).split( ':' ) : [16,9]);
				ratio         = ratio.length != 2 || ratio[0] == 0 || ratio[1] == 0 ? 16 / 9 : ratio[0] / ratio[1];
				var mejs_cont = video.parents( '.mejs-video' ).eq(0);
				var w_attr    = video.data( 'width' );
				var h_attr    = video.data( 'height' );
				if ( ! w_attr || ! h_attr) {
					w_attr = video.attr( 'width' );
					h_attr = video.attr( 'height' );
					if ( ! w_attr || ! h_attr) {
						return;
					}
					video.data( {'width': w_attr, 'height': h_attr} );
				}
				var percent = ('' + w_attr).substr( -1 ) == '%';
				w_attr      = parseInt( w_attr, 10 );
				h_attr      = parseInt( h_attr, 10 );
				var w_real  = Math.round(
						mejs_cont.length > 0
							? Math.min( percent ? 10000 : w_attr, mejs_cont.parents( 'div,article' ).eq(0).width() )
							: Math.min( percent ? 10000 : w_attr, video.parents( 'div,article' ).eq(0).width() )
					),
					h_real      = Math.round( percent ? w_real / ratio : w_real / w_attr * h_attr );
				if (parseInt( video.attr( 'data-last-width' ), 10 ) == w_real) {
					return;
				}
				if (percent) {
					video.height( h_real );
				} else if (video.parents( '.wp-video-playlist' ).length > 0) {
					if (mejs_cont.length === 0) {
						video.attr( {'width': w_real, 'height': h_real} );
					}
				} else {
					video.attr( {'width': w_real, 'height': h_real} ).css( {'width': w_real + 'px', 'height': h_real + 'px'} );
					if (mejs_cont.length > 0) {
						hampton_set_mejs_player_dimensions( video, w_real, h_real );
					}
				}
				video.attr( 'data-last-width', w_real );
			}
		);
		cont.find( '.video_frame iframe, iframe' ).each(
			function() {
				// If item now invisible
				if (jQuery( this ).hasClass( 'trx_addons_resize' ) || jQuery( this ).addClass( 'hampton_resize' ).parents( 'div:hidden,section:hidden,article:hidden' ).length > 0) {
					return;
				}
				var iframe = jQuery( this ).eq( 0 );
				if (iframe.attr( 'src' ).indexOf( 'soundcloud' ) > 0) {
					return;
				}
				var ratio  = (iframe.data( 'ratio' ) !== undefined
						? iframe.data( 'ratio' ).split( ':' )
						: (iframe.parent().data( 'ratio' ) !== undefined
							? iframe.parent().data( 'ratio' ).split( ':' )
							: (iframe.find( '[data-ratio]' ).length > 0
								? iframe.find( '[data-ratio]' ).data( 'ratio' ).split( ':' )
								: [16,9]
						)
					)
				);
				ratio      = ratio.length != 2 || ratio[0] == 0 || ratio[1] == 0 ? 16 / 9 : ratio[0] / ratio[1];
				var w_attr = iframe.attr( 'width' );
				var h_attr = iframe.attr( 'height' );
				if ( ! w_attr || ! h_attr) {
					return;
				}
				var percent = ('' + w_attr).substr( -1 ) == '%';
				w_attr      = parseInt( w_attr, 10 );
				h_attr      = parseInt( h_attr, 10 );
				var par     = iframe.parents( 'div,section' ).eq(0),
					pw          = par.width(),
					ph          = par.height(),
					w_real      = pw,
					h_real      = Math.round( percent ? w_real / ratio : w_real / w_attr * h_attr );
				if (par.css( 'position' ) == 'absolute' && h_real > ph) {
					h_real = ph;
					w_real = Math.round( percent ? h_real * ratio : h_real * w_attr / h_attr )
				}
				if (parseInt( iframe.attr( 'data-last-width' ), 10 ) == w_real) {
					return;
				}
				iframe.css( {'width': w_real + 'px', 'height': h_real + 'px'} );
				iframe.attr( 'data-last-width', w_real );
			}
		);
	}

	// Set Media Elements player dimensions
	function hampton_set_mejs_player_dimensions(video, w, h) {
		if (mejs) {
			for (var pl in mejs.players) {
				if (mejs.players[pl].media.src == video.attr( 'src' )) {
					if (mejs.players[pl].media.setVideoSize) {
						mejs.players[pl].media.setVideoSize( w, h );
					} else if (mejs.players[pl].media.setSize) {
						mejs.players[pl].media.setSize( w, h );
					}
					mejs.players[pl].setPlayerSize( w, h );
					mejs.players[pl].setControlsSize();
				}
			}
		}
	}

	
	
	// Load the tab's content
	function lighthouseschool_tabs_ajax_content_loader(panel, page, oldPanel) {
	if (panel.html().replace(/\s/g, '')=='') {
		var height = oldPanel === undefined ? panel.height() : oldPanel.height();
		if (isNaN(height) || height < 100) height = 100;
		panel.html('<div class="hampton_tab_holder" style="min-height:'+height+'px;"></div>');
	} else
		panel.find('> *').addClass('hampton_tab_content_remove');
	panel.data('need-content', false).addClass('hampton_loading');
	jQuery.post(HAMPTON_STORAGE['ajax_url'], {
		nonce: HAMPTON_STORAGE['ajax_nonce'],
		action: 'hampton_ajax_get_posts',
		blog_template: panel.data('blog-template'),
		blog_style: panel.data('blog-style'),
		posts_per_page: panel.data('posts-per-page'),
		cat: panel.data('cat'),
		parent_cat: panel.data('parent-cat'),
		post_type: panel.data('post-type'),
		taxonomy: panel.data('taxonomy'),
		page: page
	}).done(function(response) {
		"use strict";
		panel.removeClass('hampton_loading');
		var rez = {};
		try {
			rez = JSON.parse(response);
		} catch (e) {
			rez = { error: HAMPTON_STORAGE['strings']['ajax_error'] };
			console.log(response);
		}
		if (rez.error !== '') {
			panel.html('<div class="hampton_error">'+rez.error+'</div>');
		} else {
			panel.prepend(rez.data).fadeIn(function() {
			    jQuery(document).trigger('action.init_shortcodes', [panel]);
			    jQuery(document).trigger('action.init_hidden_elements', [panel]);
				jQuery(window).trigger('scroll');
				setTimeout(function() {
					panel.find('.hampton_tab_holder,.hampton_tab_content_remove').remove();
					jQuery(window).trigger('scroll');
				}, 600);
			});
		}
	});
}


// Forms validation
//-------------------------------------------------------

// Comments form
function hampton_comments_validate(form) {
	"use strict";
	form.find('input').removeClass('error_field');
	var comments_args = {
		error_message_text: HAMPTON_STORAGE['strings']['error_global'],	// Global error message text (if don't write in checked field)
		error_message_show: true,									// Display or not error message
		error_message_time: 4000,									// Error message display time
		error_message_class: 'hampton_messagebox hampton_messagebox_style_error',	// Class appended to error message block
		error_fields_class: 'error_field',							// Class appended to error fields
		exit_after_first_error: false,								// Cancel validation and exit after first error
		rules: [
			{
				field: 'comment',
				min_length: { value: 1, message: HAMPTON_STORAGE['strings']['text_empty'] },
				max_length: { value: HAMPTON_STORAGE['message_maxlength'], message: HAMPTON_STORAGE['strings']['text_long']}
			}
		]
	};
	if (form.find('.comments_author input[aria-required="true"]').length > 0) {
		comments_args.rules.push(
			{
				field: 'author',
				min_length: { value: 1, message: HAMPTON_STORAGE['strings']['name_empty']},
				max_length: { value: 60, message: HAMPTON_STORAGE['strings']['name_long']}
			}
		);
	}
	if (form.find('.comments_email input[aria-required="true"]').length > 0) {
		comments_args.rules.push(
			{
				field: 'email',
				min_length: { value: 1, message: HAMPTON_STORAGE['strings']['email_empty']},
				max_length: { value: 60, message: HAMPTON_STORAGE['strings']['email_long']},
				mask: { value: HAMPTON_STORAGE['email_mask'], message: HAMPTON_STORAGE['strings']['email_not_valid']}
			}
		);
	}
	var error = hampton_form_validate(form, comments_args);
	return !error;
}
