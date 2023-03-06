<?php
/**
 * Shortcode: Google Map
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_googlemap_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_googlemap_load_scripts_front');
	function trx_addons_sc_googlemap_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			trx_addons_enqueue_style( 'trx_addons-sc_googlemap', trx_addons_get_file_url('shortcodes/googlemap/googlemap.css'), array(), null );
		}
	}
}

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_googlemap_merge_styles' ) ) {
	add_action("trx_addons_filter_merge_styles", 'trx_addons_sc_googlemap_merge_styles');
	function trx_addons_sc_googlemap_merge_styles($list) {
		$list[] = 'shortcodes/googlemap/googlemap.css';
		return $list;
	}
}

	
// Merge googlemap specific scripts into single file
if ( !function_exists( 'trx_addons_sc_googlemap_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_googlemap_merge_scripts');
	function trx_addons_sc_googlemap_merge_scripts($list) {
		$list[] = 'shortcodes/googlemap/googlemap.js';
		return $list;
	}
}

	
// Add messages for JS
if ( !function_exists( 'trx_addons_sc_googlemap_localize_script' ) ) {
	add_filter("trx_addons_localize_script", 'trx_addons_sc_googlemap_localize_script');
	function trx_addons_sc_googlemap_localize_script($storage) {
		$storage['msg_sc_googlemap_not_avail'] = esc_html__('Googlemap service is not available', 'trx_addons');
		$storage['msg_sc_googlemap_geocoder_error'] = esc_html__('Error while geocode address', 'trx_addons');
		return $storage;
	}
}


// trx_sc_googlemap
//-------------------------------------------------------------
/*
[trx_sc_googlemap id="unique_id" style="grey" zoom="16" markers="encoded json data"]
*/
if ( !function_exists( 'trx_addons_sc_googlemap' ) ) {
	function trx_addons_sc_googlemap($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_googlemap', $atts, array(
			// Individual params
			"type" => "default",
			"zoom" => 16,
			"style" => 'default',
			"markers" => "",
			"width" => "100%",
			"height" => "400",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link" => '',
			"link_image" => '',
			"link_text" => esc_html__('Learn more', 'trx_addons'),
			"title_align" => "left",
			"title_style" => "default",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		
		if (function_exists('vc_param_group_parse_atts'))
			$atts['markers'] = (array) vc_param_group_parse_atts( $atts['markers'] );
		if (!is_array($atts['markers']) || count($atts['markers']) == 0) return '';

		foreach ($atts['markers'] as $k=>$v)
			if (!empty($v['description'])) $atts['markers'][$k]['description'] = trim( vc_value_from_safe( $v['description'] ) );

		$atts['css'] .= trx_addons_get_css_dimensions_from_values($atts['width'], $atts['height']);
		if (empty($atts['style'])) $atts['style'] = 'default';

		$atts['content'] = do_shortcode($content);
		
		if (trx_addons_is_on(trx_addons_get_option('api_google_load'))) {
			$api_key = trx_addons_get_option('api_google');
            if (trx_addons_get_option('api_google') != '') {
                trx_addons_enqueue_script('google-maps', trx_addons_get_protocol() . '://maps.googleapis.com/maps/api/js' . ($api_key ? '?key=' . $api_key : ''), array(), null, true);
            }
		}
        if (trx_addons_get_option('api_google') != '') {
            if (trx_addons_is_on(trx_addons_get_option('debug_mode')))
                trx_addons_enqueue_script('trx_addons-sc_googlemap', trx_addons_get_file_url('shortcodes/googlemap/googlemap.js'), array('jquery'), null, true);
        }
		set_query_var('trx_addons_args_sc_googlemap', $atts);

		ob_start();
		if (($fdir = trx_addons_get_file_dir('shortcodes/googlemap/tpl.'.trx_addons_esc($atts['type']).'.php')) != '') { include $fdir; }
		else if (($fdir = trx_addons_get_file_dir('shortcodes/googlemap/tpl.default.php')) != '') { include $fdir; }
		$output = ob_get_contents();
		ob_end_clean();

		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_googlemap', $atts, $content);
	}
	if (trx_addons_exists_visual_composer()) add_shortcode("trx_sc_googlemap", "trx_addons_sc_googlemap");
}


// Add [trx_sc_googlemap] in the VC shortcodes list
if (!function_exists('trx_addons_sc_googlemap_add_in_vc')) {
	function trx_addons_sc_googlemap_add_in_vc() {

		if (!trx_addons_exists_visual_composer()) return;
		
		vc_map( apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_googlemap",
				"name" => esc_html__("Google Map", 'trx_addons'),
				"description" => wp_kses_data( __("Google map with custom styles and several markers", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_googlemap',
				"class" => "trx_sc_googlemap",
				'content_element' => true,
				'is_container' => true,
				"js_view" => 'VcColumnView',
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "type",
						"heading" => esc_html__("Layout", 'trx_addons'),
						"description" => wp_kses_data( __("Select shortcode's layout", 'trx_addons') ),
						"admin_label" => true,
						"class" => "",
						"std" => "default",
						"value" => apply_filters('trx_addons_sc_type', array(
							esc_html__('Default', 'trx_addons') => 'default',
							esc_html__('Detailed', 'trx_addons') => 'detailed'
						), 'trx_sc_googlemap' ),
						"type" => "dropdown"
					),
					array(
						"param_name" => "style",
						"heading" => esc_html__("Style", 'trx_addons'),
						"description" => wp_kses_data( __("Map custom style", 'trx_addons') ),
						"admin_label" => true,
						"class" => "",
						"value" => apply_filters('trx_addons_filter_sc_googlemap_styles', array(
							esc_html__('Default', 'trx_addons') => 'default',
							esc_html__('Greyscale', 'trx_addons') => 'greyscale',
							esc_html__('Inverse', 'trx_addons') => 'inverse',
							esc_html__('Simple', 'trx_addons') => 'simple'
						)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "zoom",
						"heading" => esc_html__("Zoom", 'trx_addons'),
						"description" => wp_kses_data( __("Map zoom factor from 1 to 20", 'trx_addons') ),
						"admin_label" => true,
						"class" => "",
						"value" => "16",
						"type" => "textfield"
					),
					array(
						"param_name" => "width",
						"heading" => esc_html__("Width", 'trx_addons'),
						"description" => wp_kses_data( __("Width of the element", 'trx_addons') ),
						"value" => '100%',
						"type" => "textfield"
					),
					array(
						"param_name" => "height",
						"heading" => esc_html__("Height", 'trx_addons'),
						"description" => wp_kses_data( __("Height of the element", 'trx_addons') ),
						"value" => 350,
						"type" => "textfield"
					),
					array(
						'type' => 'param_group',
						'param_name' => 'markers',
						'heading' => esc_html__( 'Markers', 'trx_addons' ),
						"description" => wp_kses_data( __("Add markers into this map", 'trx_addons') ),
						'value' => urlencode( json_encode( array(
							array(
								'title' => esc_html__( 'One', 'trx_addons' ),
								'description' => '',
								'address' => '',
								'latlng' => '',
								'icon' => ''
							),
						) ) ),
						'params' => array(
							array(
								"param_name" => "address",
								"heading" => esc_html__("Address", 'trx_addons'),
								"description" => wp_kses_data( __("Address of this marker", 'trx_addons') ),
								"admin_label" => true,
								"value" => "",
								"type" => "textfield"
							),
							array(
								"param_name" => "latlng",
								"heading" => esc_html__("Latitude and Longitude", 'trx_addons'),
								"description" => wp_kses_data( __("Comma separated marker's coorditanes (instead Address)", 'trx_addons') ),
								"admin_label" => true,
								"value" => "",
								"type" => "textfield"
							),
							array(
								"param_name" => "icon",
								"heading" => esc_html__("Marker image", 'trx_addons'),
								"description" => wp_kses_data( __("Select or upload image or write URL from other site for this marker", 'trx_addons') ),
								"value" => "",
								"type" => "attach_image"
							),
							array(
								"param_name" => "title",
								"heading" => esc_html__("Title", 'trx_addons'),
								"description" => wp_kses_data( __("Title for this marker", 'trx_addons') ),
								"admin_label" => true,
								"value" => "",
								"type" => "textfield"
							),
							array(
								"param_name" => "description",
								"heading" => esc_html__("Description", 'trx_addons'),
								"description" => wp_kses_data( __("Description of this marker", 'trx_addons') ),
								"value" => "",
								"type" => "textarea_safe"
							),
						),
					),
					/*
					array(
						'heading' => __( 'Content', 'trx_addons' ),
						"description" => wp_kses_data( __("Inner content (placed over map)", 'trx_addons') ),
						'param_name' => 'content',
						'value' => '',
						'holder' => 'div',
						'type' => 'textarea_html',
					),
					*/
					array(
						"param_name" => "title_style",
						"heading" => esc_html__("Title style", 'trx_addons'),
						"description" => wp_kses_data( __("Select style of the title and subtitle", 'trx_addons') ),
						"admin_label" => true,
						"group" => esc_html__('Titles', 'trx_addons'),
						"std" => "default",
						"value" => apply_filters('trx_addons_sc_title_style', array(
							esc_html__('Default', 'trx_addons') => 'default',
							esc_html__('Underline', 'trx_addons') => 'underline'
						), 'trx_sc_googlemap' ),
						"type" => "dropdown"
					),
					array(
						"param_name" => "title_align",
						"heading" => esc_html__("Title alignment", 'trx_addons'),
						"description" => wp_kses_data( __("Select alignment of the title, subtitle and description", 'trx_addons') ),
						"group" => esc_html__('Titles', 'trx_addons'),
						"std" => "default",
						"value" => array(
							esc_html__('Default', 'trx_addons') => 'default',
							esc_html__('Left', 'trx_addons') => 'left',
							esc_html__('Center', 'trx_addons') => 'center',
							esc_html__('Right', 'trx_addons') => 'right'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", 'trx_addons'),
						"description" => wp_kses_data( __("Title of the block. Enclose any words in {{ and }} to accent them", 'trx_addons') ),
						"admin_label" => true,
						"group" => esc_html__('Titles', 'trx_addons'),
						"type" => "textfield"
					),
					array(
						"param_name" => "subtitle",
						"heading" => esc_html__("Subtitle", 'trx_addons'),
						"description" => wp_kses_data( __("Subtitle for the block", 'trx_addons') ),
						"group" => esc_html__('Titles', 'trx_addons'),
						"type" => "textfield"
					),
					array(
						"param_name" => "description",
						"heading" => esc_html__("Description", 'trx_addons'),
						"description" => wp_kses_data( __("Description of this block", 'trx_addons') ),
						"group" => esc_html__('Titles', 'trx_addons'),
						"type" => "textarea_safe"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Button URL", 'trx_addons'),
						"description" => wp_kses_data( __("Link URL for the button at the bottom of the block", 'trx_addons') ),
						"group" => esc_html__('Titles', 'trx_addons'),
						"type" => "textfield"
					),
					array(
						"param_name" => "link_text",
						"heading" => esc_html__("Button's text", 'trx_addons'),
						"description" => wp_kses_data( __("Caption for the button at the bottom of the block", 'trx_addons') ),
						"group" => esc_html__('Titles', 'trx_addons'),
						"type" => "textfield"
					),
					array(
						"param_name" => "link_image",
						"heading" => esc_html__("Button's image", 'trx_addons'),
						"description" => wp_kses_data( __("Select the promo image from the library for this button", 'trx_addons') ),
						"group" => esc_html__('Titles', 'trx_addons'),
						"type" => "attach_image"
					),
					// Common VC parameters
					'id' => array(
						"param_name" => "id",
						"heading" => esc_html__("Element ID", 'trx_addons'),
						"description" => wp_kses_data( __("ID for current element", 'trx_addons') ),
						"group" => esc_html__('ID &amp; Class', 'trx_addons'),
						"admin_label" => true,
						"type" => "textfield"
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
				
			), 'trx_sc_googlemap' ) );
			
		if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
			class WPBakeryShortCode_Trx_Sc_Googlemap extends WPBakeryShortCodesContainer {}
		}

	}
	add_action('after_setup_theme', 'trx_addons_sc_googlemap_add_in_vc', 11);
}
?>