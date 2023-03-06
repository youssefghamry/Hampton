<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('hampton_booked_theme_setup9')) {
	add_action( 'after_setup_theme', 'hampton_booked_theme_setup9', 9 );
	function hampton_booked_theme_setup9() {
		if (hampton_exists_booked()) {
			add_action( 'wp_enqueue_scripts', 							'hampton_booked_frontend_scripts', 1100 );
			add_filter( 'hampton_filter_merge_styles',					'hampton_booked_merge_styles' );
			add_filter( 'hampton_filter_get_css',						'hampton_booked_get_css', 10, 3 );
		}
		if (is_admin()) {
			add_filter( 'hampton_filter_tgmpa_required_plugins',		'hampton_booked_tgmpa_required_plugins' );
		}
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'hampton_exists_booked' ) ) {
	function hampton_exists_booked() {
		return class_exists('booked_plugin');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'hampton_booked_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('hampton_filter_tgmpa_required_plugins',	'hampton_booked_tgmpa_required_plugins');
	function hampton_booked_tgmpa_required_plugins($list=array()) {
		if (in_array('booked', hampton_storage_get('required_plugins'))) {
            $path = hampton_get_file_dir('plugins/booked/booked.zip');
			$list[] = array(
					'name' 		=> esc_html__('Booked Appointments', 'hampton'),
					'slug' 		=> 'booked',
					'version'	=> '2.3.5',
					'source' 	=> $path,
					'required' 	=> false
			);
		}
		return $list;
	}
}
	
// Enqueue plugin's custom styles
if ( !function_exists( 'hampton_booked_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'hampton_booked_frontend_scripts', 1100 );
	function hampton_booked_frontend_scripts() {
		if (hampton_is_on(hampton_get_theme_option('debug_mode')) && file_exists(hampton_get_file_dir('plugins/booked/booked.css')))
			wp_enqueue_style( 'hampton-booked',  hampton_get_file_url('plugins/booked/booked.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'hampton_booked_merge_styles' ) ) {
	//Handler of the add_filter('hampton_filter_merge_styles', 'hampton_booked_merge_styles');
	function hampton_booked_merge_styles($list) {
		$list[] = 'plugins/booked/booked.css';
		return $list;
	}
}



// Add plugin's specific styles into color scheme
//------------------------------------------------------------------------

// Add styles into CSS
if ( !function_exists( 'hampton_booked_get_css' ) ) {
	//Handler of the add_filter( 'hampton_filter_get_css', 'hampton_booked_get_css', 10, 3 );
	function hampton_booked_get_css($css, $colors, $fonts) {
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