<?php
/**
 * Shortcode: Skills
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_skills_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_skills_load_scripts_front');
	function trx_addons_sc_skills_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			trx_addons_enqueue_style( 'trx_addons-sc_skills', trx_addons_get_file_url('shortcodes/skills/skills.css'), array(), null );
		}
	}
}

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_skills_merge_styles' ) ) {
	add_action("trx_addons_filter_merge_styles", 'trx_addons_sc_skills_merge_styles');
	function trx_addons_sc_skills_merge_styles($list) {
		$list[] = 'shortcodes/skills/skills.css';
		return $list;
	}
}

	
// Merge skills specific scripts into single file
if ( !function_exists( 'trx_addons_sc_skills_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_skills_merge_scripts');
	function trx_addons_sc_skills_merge_scripts($list) {
		$list[] = 'shortcodes/skills/skills.js';
		return $list;
	}
}



// trx_sc_skills
//-------------------------------------------------------------
/*
[trx_sc_skills id="unique_id" type="pie" cutout="99" values="encoded json data"]
*/
if ( !function_exists( 'trx_addons_sc_skills' ) ) {
	function trx_addons_sc_skills($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_skills', $atts, array(
			// Individual params
			"type" => "counter",
			"filled" => 0,
			"cutout" => 97,
			"compact" => 0,
			"max" => 100,
			"color" => '',
			"bg_color" => '',
			"back_color" => '',		// Alter param name for VC (it broke bg_color)
			"border_color" => '',
			"columns" => "",
			"values" => "",
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
			$atts['values'] = (array) vc_param_group_parse_atts( $atts['values'] );
		if (!is_array($atts['values']) || count($atts['values']) == 0) return '';
		
		if (trx_addons_is_on(trx_addons_get_option('debug_mode')))
			trx_addons_enqueue_script( 'trx_addons-sc_skills', trx_addons_get_file_url('shortcodes/skills/skills.js'), array('jquery'), null, true );

		if (empty($atts['bg_color'])) $atts['bg_color'] = $atts['back_color'];

		$atts['cutout'] = min(100, max(0, (int) $atts['cutout']));

		if (empty($atts['max'])) {
			$atts['max'] = 0;
			foreach ($atts['values'] as $v) {
				$value = str_replace('%', '', $v['value']);
				if ($atts['max'] < $value) $atts['max'] = $value;
			}
		} else
			$atts['max'] = str_replace('%', '', $atts['max']);

		$atts['compact'] = $atts['compact']<1 ? 0 : 1;
		$atts['columns'] = $atts['compact']==0 
								? ($atts['columns'] < 1 
									? count($atts['values']) 
									: min($atts['columns'], count($atts['values']))
									)
								: 1;

		set_query_var('trx_addons_args_sc_skills', $atts);
		
		ob_start();
		if (($fdir = trx_addons_get_file_dir('shortcodes/skills/tpl.'.trx_addons_esc($atts['type']).'.php')) != '') { include $fdir; }
		else if (($fdir = trx_addons_get_file_dir('shortcodes/skills/tpl.counter.php')) != '') { include $fdir; }
		$output = ob_get_contents();
		ob_end_clean();

		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_skills', $atts, $content);
	}
	if (trx_addons_exists_visual_composer()) add_shortcode("trx_sc_skills", "trx_addons_sc_skills");
}


// Add [trx_sc_skills] in the VC shortcodes list
if (!function_exists('trx_addons_sc_skills_add_in_vc')) {
	function trx_addons_sc_skills_add_in_vc() {

		if (!trx_addons_exists_visual_composer()) return;
		
		vc_map( apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_skills",
				"name" => esc_html__("Skills", 'trx_addons'),
				"description" => wp_kses_data( __("Skill counters and pie charts", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_skills',
				"class" => "trx_sc_skills",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "type",
						"heading" => esc_html__("Type", 'trx_addons'),
						"description" => wp_kses_data( __("Select counter's type", 'trx_addons') ),
						"admin_label" => true,
						"value" => apply_filters('trx_addons_sc_type', array(
							esc_html__('Pie', 'trx_addons') => 'pie',
							esc_html__('Counter', 'trx_addons') => 'counter'
						), 'trx_sc_skills' ),
						"type" => "dropdown"
					),
					array(
						"param_name" => "filled",
						"heading" => esc_html__("Fill pie", 'trx_addons'),
						"description" => wp_kses_data( __("Show pie filled or bordered", 'trx_addons') ),
						"admin_label" => true,
						'dependency' => array(
							'element' => 'type',
							'value' => 'pie'
						),
						"std" => "0",
						"value" => array(esc_html__("Filled", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "cutout",
						"heading" => esc_html__("Cutout", 'trx_addons'),
						"description" => wp_kses_data( __("Specify pie cutout. You will see border width as 100% - cutout value", 'trx_addons') ),
						"type" => "textfield"
					),
					array(
						"param_name" => "compact",
						"heading" => esc_html__("Compact pie", 'trx_addons'),
						"description" => wp_kses_data( __("Show all values in one pie or each value in the single pie", 'trx_addons') ),
						"admin_label" => true,
						'dependency' => array(
							'element' => 'type',
							'value' => 'pie'
						),
						"std" => "0",
						"value" => array(esc_html__("Compact", 'trx_addons') => "1" ),
						"type" => "checkbox"
					),
					array(
						'param_name' => 'color',
						'heading' => esc_html__( 'Color', 'trx_addons' ),
						'description' => esc_html__( 'Select custom color to fill each item', 'trx_addons' ),
						'value' => '#ff0000',
						'type' => 'colorpicker',
					),
					array(
						'param_name' => 'back_color',	// Alter name for bg_color in VC (it broke bg_color)
						'heading' => esc_html__( 'Background color', 'trx_addons' ),
						'description' => esc_html__( "Select custom color for item's background", 'trx_addons' ),
						'dependency' => array(
							'element' => 'type',
							'value' => 'pie'
						),
						'value' => '',
						'type' => 'colorpicker',
					),
					array(
						'param_name' => 'border_color',
						'heading' => esc_html__( 'Border color', 'trx_addons' ),
						'description' => esc_html__( "Select custom color for item's border", 'trx_addons' ),
						'dependency' => array(
							'element' => 'type',
							'value' => 'pie'
						),
						'value' => '',
						'type' => 'colorpicker',
					),
					array(
						'param_name' => 'max',
						'heading' => esc_html__( 'Max. value', 'trx_addons' ),
						'description' => esc_html__( 'Enter max value for all items', 'trx_addons' ),
						'value' => 100,
						'type' => 'textfield',
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'trx_addons'),
						"description" => wp_kses_data( __("Specify number of columns for skills. If empty - auto detect by items number", 'trx_addons') ),
						"type" => "textfield"
					),
					array(
						'type' => 'param_group',
						'param_name' => 'values',
						'heading' => esc_html__( 'Values', 'trx_addons' ),
						"description" => wp_kses_data( __("Specify values for each counter's item", 'trx_addons') ),
						'value' => urlencode( json_encode( array(
							array(
								'title' => esc_html__( 'One', 'trx_addons' ),
								'value' => '60',
								'color' => '',
								'icon_fontawesome' => 'empty',
								'icon_openiconic' => 'empty',
								'icon_typicons' => 'empty',
								'icon_entypo' => 'empty',
								'icon_linecons' => 'empty'
							),
							array(
								'title' => esc_html__( 'Two', 'trx_addons' ),
								'value' => '40',
								'color' => '',
								'icon_fontawesome' => 'empty',
								'icon_openiconic' => 'empty',
								'icon_typicons' => 'empty',
								'icon_entypo' => 'empty',
								'icon_linecons' => 'empty'
							),
						) ) ),
						'params' => array_merge(array(
								array(
									'param_name' => 'title',
									'heading' => esc_html__( 'Title', 'trx_addons' ),
									'description' => esc_html__( 'Enter title for this item', 'trx_addons' ),
									'admin_label' => true,
									'type' => 'textfield',
								),
								array(
									'param_name' => 'value',
									'heading' => esc_html__( 'Value', 'trx_addons' ),
									'description' => esc_html__( 'Enter value for this item', 'trx_addons' ),
									'type' => 'textfield',
								),
								array(
									'param_name' => 'color',
									'heading' => esc_html__( 'Color', 'trx_addons' ),
									'description' => esc_html__( 'Select custom color for this item', 'trx_addons' ),
									'type' => 'colorpicker',
								),
							), trx_addons_vc_add_icon_param() ),
					),
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
						), 'trx_sc_skills' ),
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
			), 'trx_sc_skills' ) );
			
		if ( class_exists( 'WPBakeryShortCode' ) ) {
			class WPBakeryShortCode_Trx_Sc_Skills extends WPBakeryShortCode {}
		}

	}
	add_action('after_setup_theme', 'trx_addons_sc_skills_add_in_vc', 11);
}
?>