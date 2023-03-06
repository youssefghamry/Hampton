<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('hampton_essential_grid_theme_setup9')) {
	add_action( 'after_setup_theme', 'hampton_essential_grid_theme_setup9', 9 );
	function hampton_essential_grid_theme_setup9() {
		if (hampton_exists_essential_grid()) {
			add_action( 'wp_enqueue_scripts', 							'hampton_essential_grid_frontend_scripts', 1100 );
			add_filter( 'hampton_filter_merge_styles',					'hampton_essential_grid_merge_styles' );
			add_filter( 'hampton_filter_get_css',						'hampton_essential_grid_get_css', 10, 3 );
		}
		if (is_admin()) {
			add_filter( 'hampton_filter_tgmpa_required_plugins',		'hampton_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'hampton_exists_essential_grid' ) ) {
	function hampton_exists_essential_grid() {
		return defined('EG_PLUGIN_PATH') || defined( 'ESG_PLUGIN_PATH' );
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'hampton_essential_grid_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('hampton_filter_tgmpa_required_plugins',	'hampton_essential_grid_tgmpa_required_plugins');
	function hampton_essential_grid_tgmpa_required_plugins($list=array()) {
		if (in_array('essential-grid', hampton_storage_get('required_plugins'))) {
            $path = hampton_get_file_dir('plugins/essential-grid/essential-grid.zip');
			$list[] = array(
						'name' 		=> esc_html__('Essential Grid', 'hampton'),
						'slug' 		=> 'essential-grid',
						'version'		=> '3.0.15',
						'source'		=> $path,
						'required' 	=> false
			);
		}
		return $list;
	}
}
	
// Enqueue plugin's custom styles
if ( !function_exists( 'hampton_essential_grid_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'hampton_essential_grid_frontend_scripts', 1100 );
	function hampton_essential_grid_frontend_scripts() {
		if (hampton_is_on(hampton_get_theme_option('debug_mode')) && file_exists(hampton_get_file_dir('plugins/essential-grid/essential-grid.css')))
			wp_enqueue_style( 'hampton-essential-grid',  hampton_get_file_url('plugins/essential-grid/essential-grid.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'hampton_essential_grid_merge_styles' ) ) {
	//Handler of the add_filter('hampton_filter_merge_styles', 'hampton_essential_grid_merge_styles');
	function hampton_essential_grid_merge_styles($list) {
		$list[] = 'plugins/essential-grid/essential-grid.css';
		return $list;
	}
}



// Add plugin's specific styles into color scheme
//------------------------------------------------------------------------

// Add styles into CSS
if ( !function_exists( 'hampton_essential_grid_get_css' ) ) {
	//Handler of the add_filter( 'hampton_filter_get_css', 'hampton_essential_grid_get_css', 10, 3 );
	function hampton_essential_grid_get_css($css, $colors, $fonts) {
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS

.eg-tyler-premier-element-3 {
	{$fonts['h5_font-family']}
}
.eg-tyler-premier-element-5{
{$fonts['info_font-family']}
}

CSS;
		}

		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS



.eg-tyler-premier-element-1-a i {
    color: {$colors['inverse_text']};

}
.esg-grid a.eg-tyler-premier-element-1{
     border-color: {$colors['inverse_text']};
}
.esg-grid a.eg-tyler-premier-element-1:hover{
     border-color: {$colors['text_hover']};
}
.esg-grid a.eg-tyler-premier-element-1:hover i{
     color: {$colors['text_hover']};
}


CSS;
		}
		
		return $css;
	}
}
?>