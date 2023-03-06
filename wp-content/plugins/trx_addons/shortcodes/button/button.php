<?php
/**
 * Shortcode: Button
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_button_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_button_load_scripts_front');
	function trx_addons_sc_button_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			trx_addons_enqueue_style( 'trx_addons-sc_button', trx_addons_get_file_url('shortcodes/button/button.css'), array(), null );
		}
	}
}

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_button_merge_styles' ) ) {
	add_action("trx_addons_filter_merge_styles", 'trx_addons_sc_button_merge_styles');
	function trx_addons_sc_button_merge_styles($list) {
		$list[] = 'shortcodes/button/button.css';
		return $list;
	}
}



// trx_sc_button
//-------------------------------------------------------------
/*
[trx_sc_button id="unique_id" type="default" title="Block title" subtitle="" link="#" icon="icon-cog" image="path_to_image"]
*/
if (!function_exists('trx_addons_sc_button')) {	
	function trx_addons_sc_button($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_button', $atts, array(
			// Individual params
			"type" => "default",
			"size" => "normal",
			"align" => "none",
			"text_align" => "none",
			"bg_image" => "",
			"back_image" => "",		// Alter name for bg_image in VC (it broke bg_image)
			"image" => "",
			"icon_position" => "left",
			"icon_type" => '',
			"icon_fontawesome" => "",
			"icon_openiconic" => "",
			"icon_typicons" => "",
			"icon_entypo" => "",
			"icon_linecons" => "",
			"title" => "",
			"subtitle" => "",
			"link" => '',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
	
		$atts['icon'] = isset( $atts['icon_' . $atts['icon_type']] ) && $atts['icon_' . $atts['icon_type']] != 'empty' ? $atts['icon_' . $atts['icon_type']] : '';
		trx_addons_enqueue_icons($atts['icon_type']);

		if (empty($atts['bg_image'])) $atts['bg_image'] = $atts['back_image'];
		$atts['bg_image'] = trx_addons_get_attachment_url($atts['bg_image'], trx_addons_get_thumb_size('masonry'));
		$atts['image'] = trx_addons_get_attachment_url($atts['image'], trx_addons_get_thumb_size('masonry'));

		set_query_var('trx_addons_args_sc_button', $atts);
		
		ob_start();
		if (($fdir = trx_addons_get_file_dir('shortcodes/button/tpl.'.trx_addons_esc($atts['type']).'.php')) != '') { include $fdir; }
		else if (($fdir = trx_addons_get_file_dir('shortcodes/button/tpl.default.php')) != '') { include $fdir; }
		$output = ob_get_contents();
		ob_end_clean();

		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_button', $atts, $content);
	}
	if (trx_addons_exists_visual_composer()) add_shortcode("trx_sc_button", "trx_addons_sc_button");
}



// Add [trx_sc_button] in the VC shortcodes list
if (!function_exists('trx_addons_sc_button_add_in_vc')) {
	function trx_addons_sc_button_add_in_vc() {

		if (!trx_addons_exists_visual_composer()) return;
		
		vc_map( apply_filters('trx_addons_sc_map', array(
			"base" => "trx_sc_button",
			"name" => esc_html__("Button", 'trx_addons'),
			"description" => wp_kses_data( __("Insert button", 'trx_addons') ),
			"category" => esc_html__('ThemeREX', 'trx_addons'),
			'icon' => 'icon_trx_sc_button',
			"class" => "trx_sc_button",
			'content_element' => true,
			'is_container' => false,
			"show_settings_on_create" => true,
			"params" => array_merge(
				array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Layout", 'trx_addons'),
							"description" => wp_kses_data( __("Select shortcodes's layout", 'trx_addons') ),
							"admin_label" => true,
							"class" => "",
							"std" => "default",
							"value" => apply_filters('trx_addons_sc_type', array(
								esc_html__('Default', 'trx_addons') => 'default',
                                esc_html__('Default2', 'trx_addons') => 'default2',
								esc_html__('Simple', 'trx_addons') => 'simple'
							), 'trx_sc_button' ),
							"type" => "dropdown"
						),
						array(
							"param_name" => "size",
							"heading" => esc_html__("Size", 'trx_addons'),
							"description" => wp_kses_data( __("Size of the button", 'trx_addons') ),
							"admin_label" => true,
							"value" => array(
								esc_html__('Normal', 'trx_addons') => 'normal',
								esc_html__('Small', 'trx_addons') => 'small',
								esc_html__('Large', 'trx_addons') => 'large'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "link",
							"heading" => esc_html__("Button URL", 'trx_addons'),
							"description" => wp_kses_data( __("Link URL for the button", 'trx_addons') ),
							"type" => "textfield"
						),
						array(
							"param_name" => "title",
							"heading" => esc_html__("Title", 'trx_addons'),
							"description" => wp_kses_data( __("Title of the button.", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "subtitle",
							"heading" => esc_html__("Subtitle", 'trx_addons'),
							"description" => wp_kses_data( __("Subtitle for the button", 'trx_addons') ),
							"type" => "textfield"
						),
						array(
							"param_name" => "align",
							"heading" => esc_html__("Button alignment", 'trx_addons'),
							"description" => wp_kses_data( __("Select button alignment", 'trx_addons') ),
							"value" => array(
								esc_html__('Default', 'trx_addons') => 'none',
								esc_html__('Left', 'trx_addons') => 'left',
								esc_html__('Center', 'trx_addons') => 'center',
								esc_html__('Right', 'trx_addons') => 'right'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "text_align",
							"heading" => esc_html__("Text alignment", 'trx_addons'),
							"description" => wp_kses_data( __("Select text alignment", 'trx_addons') ),
							"value" => array(
								esc_html__('Default', 'trx_addons') => 'none',
								esc_html__('Left', 'trx_addons') => 'left',
								esc_html__('Center', 'trx_addons') => 'center',
								esc_html__('Right', 'trx_addons') => 'right'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "back_image",		// Alter name for bg_image in VC (it broke bg_image)
							"heading" => esc_html__("Button's background image", 'trx_addons'),
							"description" => wp_kses_data( __("Select the image from the library for this button's background", 'trx_addons') ),
							"type" => "attach_image"
						)
					),
				trx_addons_vc_add_icon_param(esc_html__('Icon', 'trx_addons')),
				array(
					array(
						"param_name" => "image",
						"heading" => esc_html__("or select an image", 'trx_addons'),
						"description" => wp_kses_data( __("Select the image instead the icon (if need)", 'trx_addons') ),
						"group" => esc_html__('Icon', 'trx_addons'),
						"type" => "attach_image"
					),
					array(
						"param_name" => "icon_position",
						"heading" => esc_html__("Icon position", 'trx_addons'),
						"description" => wp_kses_data( __("Place the image to the left or to the right or to the top of the button", 'trx_addons') ),
						"group" => esc_html__('Icon', 'trx_addons'),
						"value" => array(
							esc_html__('Left', 'trx_addons') => 'left',
							esc_html__('Right', 'trx_addons') => 'right',
							esc_html__('Top', 'trx_addons') => 'top'
						),
						"type" => "dropdown"
					),
				), array(
					// Common VC parameters
					'id' => array(
						"param_name" => "id",
						"heading" => esc_html__("Element ID", 'trx_addons'),
						"description" => wp_kses_data( __("ID for current element", 'trx_addons') ),
						"group" => esc_html__('ID &amp; Class', 'trx_addons'),
						"admin_label" => true,
						"type" => "el_id"
					),
					'class' => array(
						"param_name" => "class",
						"heading" => esc_html__("Element CSS class", 'trx_addons'),
						"description" => wp_kses_data( __("CSS class for current element", 'trx_addons') ),
						"group" => esc_html__('ID &amp; Class', 'trx_addons'),
						"admin_label" => true,
						"type" => "textfield"
					),
					'css' => array(
						'param_name' => 'css',
						'heading' => __( 'CSS box', 'trx_addons' ),
						'group' => __( 'Design Options', 'trx_addons' ),
						'type' => 'css_editor'
					) 
				)
			)

		), 'trx_sc_button' ) );
		
		if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
			class WPBakeryShortCode_Trx_Sc_Button extends WPBakeryShortCode {}
		}
	}
	add_action('after_setup_theme', 'trx_addons_sc_button_add_in_vc', 11);
}
?>