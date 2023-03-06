/**
 * Shortcode Skills
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */


jQuery(document).on('action.init_hidden_elements', trx_addons_sc_skills_init);
jQuery(document).on('action.init_shortcodes', trx_addons_sc_skills_init);
jQuery(window).on('scroll', trx_addons_sc_skills_init);

// Skills init
function trx_addons_sc_skills_init(e, container) {
	"use strict";

	if (arguments.length < 2) var container = jQuery('body');

	var scrollPosition = jQuery(window).scrollTop() + jQuery(window).height();

	container.find('.sc_skills_item:not(.inited)').each(function () {
		"use strict";
		var skillsItem = jQuery(this);
		// If item now invisible
		if (jQuery(this).parents('div:hidden,article:hidden').length > 0) {
			return;
		}
		var scrollSkills = skillsItem.offset().top;
		if (scrollPosition > scrollSkills) {
			var init_ok = true;
			var skills = skillsItem.parents('.sc_skills').eq(0);
			var type = skills.data('type');
			var total = (type=='pie' && skills.hasClass('sc_skills_compact_on')) 
							? skillsItem.find('.sc_skills_data .pie') 
							: skillsItem.find('.sc_skills_total').eq(0);
			var start = parseInt(total.data('start'));
			var stop = parseInt(total.data('stop'));
			var maximum = parseInt(total.data('max'));
			var startPercent = Math.round(start/maximum*100);
			var stopPercent = Math.round(stop/maximum*100);
			var ed = total.data('ed');
			var speed = parseInt(total.data('speed'));
			var step = parseInt(total.data('step'));
			var duration = parseInt(total.data('duration'));
			if (isNaN(duration)) duration = Math.ceil(maximum/step)*speed;
			
			if (type == 'bar') {
				var dir = skills.data('dir');
				var count = skillsItem.find('.sc_skills_count').eq(0);
				if (dir=='horizontal')
					count.css('width', startPercent + '%').animate({ width: stopPercent + '%' }, duration);
				else if (dir=='vertical')
					count.css('height', startPercent + '%').animate({ height: stopPercent + '%' }, duration);
				trx_addons_sc_skills_animate_counter(start, stop, speed, step, ed, total);
			
			} else if (type == 'counter') {
				trx_addons_sc_skills_animate_counter(start, stop, speed, step, ed, total);

			} else if (type == 'pie') {
				if (window.Chart) {
					var steps = parseInt(total.data('steps'));
					var bg_color = total.data('bg_color');
					var border_color = total.data('border_color');
					var cutout = parseInt(total.data('cutout'));
					var easing = total.data('easing');
					var options = {
						segmentShowStroke: border_color!='',
						segmentStrokeColor: border_color,
						segmentStrokeWidth: border_color!='' ? 1 : 0,
						percentageInnerCutout: cutout,
						animationSteps: steps,
						animationEasing: easing,
						animateRotate: true,
						animateScale: false,
					};
					var pieData = [];
					total.each(function() {
						"use strict";
						var color = jQuery(this).data('color');
						var stop = parseInt(jQuery(this).data('stop'));
						var stopPercent = Math.round(stop/maximum*100);
						pieData.push({
							value: stopPercent,
							color: color
						});
					});
					if (total.length == 1) {
						trx_addons_sc_skills_animate_counter(start, stop, Math.round(1500/steps), step, ed, total);
						pieData.push({
							value: 100-stopPercent,
							color: bg_color
						});
					}
					var canvas = skillsItem.find('canvas');
					canvas.attr({width: skillsItem.width(), height: skillsItem.width()}).css({width: skillsItem.width(), height: skillsItem.height()});
					new Chart(canvas.get(0).getContext("2d")).Doughnut(pieData, options);
				} else
					init_ok = false;
			}
			if (init_ok) skillsItem.addClass('inited');
		}
	});
}

// Skills counter animation
function trx_addons_sc_skills_animate_counter(start, stop, speed, step, ed, total) {
	"use strict";
	start = Math.min(stop, start + step);
	total.text(start+ed);
	if (start < stop) {
		setTimeout(function () {
			trx_addons_sc_skills_animate_counter(start, stop, speed, step, ed, total);
		}, speed);
	}
}
