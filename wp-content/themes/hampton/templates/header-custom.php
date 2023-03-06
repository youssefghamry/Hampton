<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0.06
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

// Get post with custom header
$hampton_header_id = str_replace('header-custom-', '', hampton_get_theme_option("header_style"));
if ((int) $hampton_header_id == 0) {
	$hampton_header_id = hampton_get_post_id(array(
			'name' => $hampton_header_id,
			'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
		)
	);
} else {
	$hampton_header_id = apply_filters('trx_addons_filter_get_translated_layout', $hampton_header_id);
}

$hampton_header_post = get_post($hampton_header_id);
if (!empty($hampton_header_post->post_content)) {
	?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($hampton_header_id);
						echo !empty($hampton_header_image) || !empty($hampton_header_video) ? ' with_bg_image' : ' without_bg_image';
						if ($hampton_header_video!='') echo ' with_bg_video';
						if ($hampton_header_image!='') echo ' '.esc_attr(hampton_add_inline_style('background-image: url('.esc_url($hampton_header_image).');'));
						if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
						if (hampton_is_on(hampton_get_theme_option('header_fullheight'))) echo ' header_fullheight trx-stretch-height';
						?> scheme_<?php echo esc_attr(hampton_is_inherit(hampton_get_theme_option('header_scheme')) 
														? hampton_get_theme_option('color_scheme') 
														: hampton_get_theme_option('header_scheme'));
						?>"><?php
		
		hampton_show_layout(do_shortcode($hampton_header_post->post_content));
		
	?></header><?php
}
?>