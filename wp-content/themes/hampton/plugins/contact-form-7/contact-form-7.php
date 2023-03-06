<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('hampton_cf7_theme_setup9')) {
	add_action( 'after_setup_theme', 'hampton_cf7_theme_setup9', 9 );
	function hampton_cf7_theme_setup9() {
		
		if (hampton_exists_cf7()) {
			add_action( 'wp_enqueue_scripts', 								'hampton_cf7_frontend_scripts', 1100 );
			add_filter( 'hampton_filter_merge_styles',						'hampton_cf7_merge_styles' );
			add_filter( 'hampton_filter_get_css',							'hampton_cf7_get_css', 10, 3 );
		}
		if (is_admin()) {
			add_filter( 'hampton_filter_tgmpa_required_plugins',			'hampton_cf7_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'hampton_cf7_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('hampton_filter_tgmpa_required_plugins',	'hampton_cf7_tgmpa_required_plugins');
	function hampton_cf7_tgmpa_required_plugins($list=array()) {
		if (in_array('contact-form-7', hampton_storage_get('required_plugins'))) {
			$list[] = array(
					'name' 		=> esc_html__('Contact Form 7', 'hampton'),
					'slug' 		=> 'contact-form-7',
					'required' 	=> false
			);
		}
		return $list;
	}
}



// Check if cf7 installed and activated
if ( !function_exists( 'hampton_exists_cf7' ) ) {
	function hampton_exists_cf7() {
		return class_exists('WPCF7');
	}
}
	
// Enqueue custom styles
if ( !function_exists( 'hampton_cf7_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'hampton_cf7_frontend_scripts', 1100 );
	function hampton_cf7_frontend_scripts() {
		if (hampton_is_on(hampton_get_theme_option('debug_mode')) && file_exists(hampton_get_file_dir('plugins/contact-form-7/contact-form-7.css')))
			wp_enqueue_style( 'hampton-contact-form-7',  hampton_get_file_url('plugins/contact-form-7/contact-form-7.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'hampton_cf7_merge_styles' ) ) {
	//Handler of the add_filter('hampton_filter_merge_styles', 'hampton_cf7_merge_styles');
	function hampton_cf7_merge_styles($list) {
		$list[] = 'plugins/contact-form-7/contact-form-7.css';
		return $list;
	}
}


// Add cf7 specific styles into color scheme
//------------------------------------------------------------------------

// Add styles into CSS
if ( !function_exists( 'hampton_cf7_get_css' ) ) {
	//Handler of the add_filter( 'hampton_filter_get_css', 'hampton_cf7_get_css', 10, 3 );
	function hampton_cf7_get_css($css, $colors, $fonts) {
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS

CSS;
		}

		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

CSS;
		}
		
		return $css;
	}
}
?>