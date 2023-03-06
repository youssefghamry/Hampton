/* global jQuery:false */
/* global HAMPTON_STORAGE:false */

jQuery(document).ready(function() {
	"use strict";

	// Init Media manager variables
	HAMPTON_STORAGE['media_id'] = '';
	HAMPTON_STORAGE['media_frame'] = [];
	HAMPTON_STORAGE['media_link'] = [];
	jQuery('.hampton_media_selector').on('click', function(e) {
		hampton_show_media_manager(this);
		e.preventDefault();
		return false;
	});
	
	// Hide empty override-options
	jQuery('.postbox > .inside').each(function() {
		"use strict";
		if (jQuery(this).html().length < 5) jQuery(this).parent().hide();
	});

	// Hide admin notice
	jQuery('#hampton_admin_notice .hampton_hide_notice').on('click', function(e) {
		jQuery('#hampton_admin_notice').slideUp();
		jQuery.post( HAMPTON_STORAGE['ajax_url'], {'action': 'hampton_hide_admin_notice'}, function(response){});
		e.preventDefault();
		return false;
	});
	
	// TGMPA Source selector is changed
	jQuery('.tgmpa_source_file').on('change', function(e) {
		var chk = jQuery(this).parents('tr').find('>th>input[type="checkbox"]');
		if (chk.length == 1) {
			if (jQuery(this).val() != '')
				chk.attr('checked', 'checked');
			else
				chk.removeAttr('checked');
		}
	});
		
	// Add icon selector after the menu item classes field
	jQuery('.edit-menu-item-classes').each(function() {
		"use strict";
		var icon = hampton_get_icon_class(jQuery(this).val());
		jQuery(this).after('<span class="hampton_list_icons_selector'+(icon ? ' '+icon : '')+'" title="'+HAMPTON_STORAGE['icon_selector_msg']+'"></span>');
	});
	jQuery('.hampton_list_icons_selector').on('click', function(e) {
		"use strict";
		var input_id = jQuery(this).prev().attr('id');
		var list = jQuery('.hampton_list_icons');
		if (list.length > 0) {
			var icon = hampton_get_icon_class(jQuery(this).attr('class'));
			list.find('span.hampton_list_active').removeClass('hampton_list_active');
			if (icon != '') list.find('span[class*="'+icon+'"]').addClass('hampton_list_active');
			var pos = jQuery(this).offset();
			list.data('input_id', input_id).css({'left': pos.left, 'top': pos.top}).fadeIn();
		}
		e.preventDefault();
		return false;
	});
	jQuery('.hampton_list_icons span').on('click', function(e) {
		"use strict";
		var list = jQuery(this).parent().fadeOut();
		var icon = jQuery(this).attr('class');
		var input = jQuery('#'+list.data('input_id'));
		input.val(hampton_chg_icon_class(input.val(), icon));
		var selector = input.next();
		selector.attr('class', hampton_chg_icon_class(selector.attr('class'), icon));
		e.preventDefault();
		return false;
	});

	// Standard WP Color Picker
	if (jQuery('.hampton_color_selector').length > 0) {
		jQuery('.hampton_color_selector').wpColorPicker({

			change: function(e, ui){
				"use strict";
				jQuery(e.target).val(ui.color).trigger('change');
			},
	
			// a callback to fire when the input is emptied or an invalid color
			clear: function(e) {
				"use strict";
				jQuery(e.target).prev().trigger('change')
			},
	
		});
	}
});

function hampton_chg_icon_class(classes, icon) {
	"use strict";
	var chg = false;
	classes = classes.split(' ');
	for (var i=0; i<classes.length; i++) {
		if (classes[i].indexOf('icon-') >= 0) {
			classes[i] = icon;
			chg = true;
			break;
		}
	}
	if (!chg) classes.push(icon);
	return classes.join(' ');
}

function hampton_get_icon_class(classes) {
	"use strict";
	var classes = classes.split(' ');
	var icon = '';
	for (var i=0; i<classes.length; i++) {
		if (classes[i].indexOf('icon-') >= 0) {
			icon = classes[i];
			break;
		}
	}
	return icon;
}

function hampton_show_media_manager(el) {
	"use strict";

	HAMPTON_STORAGE['media_id'] = jQuery(el).attr('id');
	HAMPTON_STORAGE['media_link'][HAMPTON_STORAGE['media_id']] = jQuery(el);
	// If the media frame already exists, reopen it.
	if ( HAMPTON_STORAGE['media_frame'][HAMPTON_STORAGE['media_id']] ) {
		HAMPTON_STORAGE['media_frame'][HAMPTON_STORAGE['media_id']].open();
		return false;
	}

	// Create the media frame.
	HAMPTON_STORAGE['media_frame'][HAMPTON_STORAGE['media_id']] = wp.media({
		// Popup layout (if comment next row - hide filters and image sizes popups)
		frame: 'post',
		// Set the title of the modal.
		title: HAMPTON_STORAGE['media_link'][HAMPTON_STORAGE['media_id']].data('choose'),
		// Tell the modal to show only images.
		library: {
			type: HAMPTON_STORAGE['media_link'][HAMPTON_STORAGE['media_id']].data('type') ? HAMPTON_STORAGE['media_link'][HAMPTON_STORAGE['media_id']].data('type') : 'image'
		},
		// Multiple choise
		multiple: HAMPTON_STORAGE['media_link'][HAMPTON_STORAGE['media_id']].data('multiple')===true ? 'add' : false,
		// Customize the submit button.
		button: {
			// Set the text of the button.
			text: HAMPTON_STORAGE['media_link'][HAMPTON_STORAGE['media_id']].data('update'),
			// Tell the button not to close the modal, since we're
			// going to refresh the page when the image is selected.
			close: true
		}
	});

	// When an image is selected, run a callback.
	HAMPTON_STORAGE['media_frame'][HAMPTON_STORAGE['media_id']].on( 'insert select', function(selection) {
		"use strict";
		// Grab the selected attachment.
		var field = jQuery("#"+HAMPTON_STORAGE['media_link'][HAMPTON_STORAGE['media_id']].data('linked-field')).eq(0);
		var attachment = null, attachment_url = '';
		if (HAMPTON_STORAGE['media_link'][HAMPTON_STORAGE['media_id']].data('multiple')===true) {
			HAMPTON_STORAGE['media_frame'][HAMPTON_STORAGE['media_id']].state().get('selection').map( function( att ) {
				attachment_url += (attachment_url ? "\n" : "") + att.toJSON().url;
			});
			var val = field.val();
			attachment_url = val + (val ? "\n" : '') + attachment_url;
		} else {
			attachment = HAMPTON_STORAGE['media_frame'][HAMPTON_STORAGE['media_id']].state().get('selection').first().toJSON();
			attachment_url = attachment.url;
			var sizes_selector = jQuery('.media-modal-content .attachment-display-settings select.size');
			if (sizes_selector.length > 0) {
				var size = hampton_get_listbox_selected_value(sizes_selector.get(0));
				if (size != '') attachment_url = attachment.sizes[size].url;
			}
		}
		field.val(attachment_url);
		if (attachment_url.indexOf('.jpg') > 0 || attachment_url.indexOf('.png') > 0 || attachment_url.indexOf('.gif') > 0) {
			var preview = field.siblings('.hampton_override_options_field_preview');
			if (preview.length != 0) {
				if (preview.find('img').length == 0)
					preview.append('<img src="'+attachment_url+'">');
				else 
					preview.find('img').attr('src', attachment_url);
			} else {
				preview = field.siblings('img');
				if (preview.length != 0)
					preview.attr('src', attachment_url);
			}
		}
		field.trigger('change');
	});

	// Finally, open the modal.
	HAMPTON_STORAGE['media_frame'][HAMPTON_STORAGE['media_id']].open();
	return false;
}
