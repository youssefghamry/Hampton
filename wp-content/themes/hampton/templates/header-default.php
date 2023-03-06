<?php
/**
 * The template to display "Header 1"
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

$hampton_header_css = $hampton_header_image = '';
$hampton_header_video = wp_is_mobile() ? '' : hampton_get_theme_option('header_video');
if (true || empty($hampton_header_video)) {
	$hampton_header_image = get_header_image();
	if (hampton_is_on(hampton_get_theme_option('header_image_override')) && apply_filters('hampton_filter_allow_override_header_image', true)) {
		if (is_category()) {
			if (($hampton_cat_img = hampton_get_category_image()) != '')
				$hampton_header_image = $hampton_cat_img;
		} else if (is_singular() || hampton_storage_isset('blog_archive')) {
			if (has_post_thumbnail()) {
				$hampton_header_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				if (is_array($hampton_header_image)) $hampton_header_image = $hampton_header_image[0];
			} else
				$hampton_header_image = '';
		}
	}
}

// Store header image for navi
set_query_var('hampton_header_image', $hampton_header_image || $hampton_header_video);

?><header class="top_panel top_panel_default<?php
                    if (hampton_is_on(hampton_get_theme_option('header_full_width'))) echo ' content_wrap';
					echo !empty($hampton_header_image) || !empty($hampton_header_video) ? ' with_bg_image' : ' without_bg_image';
					if ($hampton_header_video!='') echo ' with_bg_video';
					if ($hampton_header_image!='') echo ' '.esc_attr(hampton_add_inline_style('background-image: url('.esc_url($hampton_header_image).');'));
					if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
					if (hampton_is_on(hampton_get_theme_option('header_fullheight'))) echo ' header_fullheight trx-stretch-height';
					?> scheme_<?php echo esc_attr(hampton_is_inherit(hampton_get_theme_option('header_scheme')) 
													? hampton_get_theme_option('color_scheme') 
													: hampton_get_theme_option('header_scheme'));
					?>"><?php
	
	// Main menu
	if (hampton_get_theme_option("menu_style") == 'top') {
		// Mobile menu button
		?><a class="menu_mobile_button icon-menu-2"></a><?php
		// Navigation panel
		get_template_part( 'templates/header-navi' );
	}

	// Page title and breadcrumbs area
	get_template_part( 'templates/header-title');

	// Header widgets area
	get_template_part( 'templates/header-widgets' );

	// Header for single posts
	get_template_part( 'templates/header-single' );

?></header>