<?php
/**
 * ThemeREX Addons Custom post types
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.1
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Include files with CPT
if (!function_exists('trx_addons_cpt_load')) {
	add_action( 'after_setup_theme', 'trx_addons_cpt_load', 2 );
	add_action( 'trx_addons_action_save_options', 'trx_addons_cpt_load', 2 );
	function trx_addons_cpt_load() {
		static $loaded = false;
		if ($loaded) return;
		$loaded = true;
		global $TRX_ADDONS_STORAGE;
		$TRX_ADDONS_STORAGE['cpt_resume_types'] = apply_filters('trx_addons_cpt_resume_types', array(
			'skills' => esc_html__('Skills', 'trx_addons'),
			'work' => esc_html__('Work experience', 'trx_addons'),
			'education' => esc_html__('Education', 'trx_addons'),
			'services' => esc_html__('Services', 'trx_addons')
		) );
		$TRX_ADDONS_STORAGE['cpt_list'] = apply_filters('trx_addons_cpt_list', array(
/*			'layouts' => array(
				'title' => esc_html__('Layouts', 'trx_addons'),
				'post_type' => 'cpt_layouts',
				'post_type_slug' => 'layouts',
				'taxonomy' => 'cpt_layouts_group',
				'taxonomy_slug' => 'layouts_group'
				),
*/			'certificates' => array(
				'title' => esc_html__('Certificates', 'trx_addons'),
				'post_type' => 'cpt_certificates',
				'post_type_slug' => 'certificates'
				),
			'courses' => array(
				'title' => esc_html__('Courses', 'trx_addons'),
				'post_type' => 'cpt_courses',
				'post_type_slug' => 'courses',
				'taxonomy' => 'cpt_courses_group',
				'taxonomy_slug' => 'courses_group'
				),
			'portfolio' => array(
				'title' => esc_html__('Portfolio', 'trx_addons'),
				'post_type' => 'cpt_portfolio',
				'post_type_slug' => 'portfolio',
				'taxonomy' => 'cpt_portfolio_group',
				'taxonomy_slug' => 'portfolio_group'
				),
			'resume' => array(
				'title' => esc_html__('Resume', 'trx_addons'),
				'post_type' => 'cpt_resume',
				'post_type_slug' => 'resume'
				),
			'services' => array(
				'title' => esc_html__('Services', 'trx_addons'),
				'post_type' => 'cpt_services',
				'post_type_slug' => 'services',
				'taxonomy' => 'cpt_services_group',
				'taxonomy_slug' => 'services_group'
				),
			'team' => array(
				'title' => esc_html__('Team', 'trx_addons'),
				'post_type' => 'cpt_team',
				'post_type_slug' => 'team',
				'taxonomy' => 'cpt_team_group',
				'taxonomy_slug' => 'team_group'
				),
			'testimonials' => array(
				'title' => esc_html__('Testimonials', 'trx_addons'),
				'post_type' => 'cpt_testimonials',
				'post_type_slug' => 'testimonials',
				'taxonomy' => 'cpt_testimonials_group',
				'taxonomy_slug' => 'testimonials_group'
				)
			)
		);
		if (is_array($TRX_ADDONS_STORAGE['cpt_list']) && count($TRX_ADDONS_STORAGE['cpt_list']) > 0) {
			foreach ($TRX_ADDONS_STORAGE['cpt_list'] as $cpt => $params) {
				if (($fdir = trx_addons_get_file_dir("cpt/{$cpt}/{$cpt}.php")) != '') { include_once $fdir; }
			}
		}
	}
}

// Return list of the allowed CPT
if (!function_exists('trx_addons_get_cpt_list')) {
	function trx_addons_get_cpt_list() {
		global $TRX_ADDONS_STORAGE;
		$list = array();
		if (is_array($TRX_ADDONS_STORAGE['cpt_list']) && count($TRX_ADDONS_STORAGE['cpt_list']) > 0) {
			foreach ($TRX_ADDONS_STORAGE['cpt_list'] as $cpt => $params) {
				$list[$params['post_type']] = $params['title'];
			}
		}
		return $list;
	}
}

// Return slug of the CPT
if (!function_exists('trx_addons_cpt_param')) {
	function trx_addons_cpt_param($cpt='', $param='') {
		global $TRX_ADDONS_STORAGE;
		return $TRX_ADDONS_STORAGE['cpt_list'][$cpt][$param];
	}
}
?>