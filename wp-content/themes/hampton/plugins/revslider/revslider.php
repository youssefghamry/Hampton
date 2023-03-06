<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('hampton_revslider_theme_setup9')) {
	add_action( 'after_setup_theme', 'hampton_revslider_theme_setup9', 9 );
	function hampton_revslider_theme_setup9() {
		if (is_admin()) {
			add_filter( 'hampton_filter_tgmpa_required_plugins',	'hampton_revslider_tgmpa_required_plugins' );
		}
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'hampton_exists_revslider' ) ) {
	function hampton_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'hampton_revslider_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('hampton_filter_tgmpa_required_plugins',	'hampton_revslider_tgmpa_required_plugins');
	function hampton_revslider_tgmpa_required_plugins($list=array()) {
		if (in_array('revslider', hampton_storage_get('required_plugins'))) {
            $path = hampton_get_file_dir('plugins/revslider/revslider.zip');
			$list[] = array(
					'name' 		=> esc_html__('Revolution Slider', 'hampton'),
					'slug' 		=> 'revslider',
					'version'	=> '6.5.25',
					'source'	=>  $path,
					'required' 	=> false
			);
		}
		return $list;
	}
}
?>