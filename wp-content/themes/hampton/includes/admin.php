<?php
/**
 * Admin utilities
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0.1
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


//-------------------------------------------------------
//-- Theme init
//-------------------------------------------------------

// Theme init priorities:
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)

if ( !function_exists('hampton_admin_theme_setup') ) {
	add_action( 'after_setup_theme', 'hampton_admin_theme_setup' );
	function hampton_admin_theme_setup() {
		// Add theme icons
		add_action('admin_footer',	 						'hampton_admin_footer');

		// Enqueue scripts and styles for admin
		add_action("admin_enqueue_scripts",					'hampton_admin_scripts');
		add_action("admin_footer",							'hampton_admin_localize_scripts');
		
		// Show admin notice
		add_action('admin_notices',							'hampton_admin_notice', 2);
		add_action('wp_ajax_hampton_hide_admin_notice',		'hampton_callback_hide_admin_notice');

		// TGM Activation plugin
		add_action('tgmpa_register',						'hampton_register_plugins');

		// Set options for importer (before other plugins)
		add_filter( 'trx_addons_filter_importer_options',	'hampton_importer_set_options', 9 );
	}
}

// Show admin notice
if ( !function_exists( 'hampton_admin_notice' ) ) {
	//Handler of the add_action('admin_notices', 'hampton_admin_notice', 2);
	function hampton_admin_notice() {
		$opt_name = 'hampton_admin_notice';
		$show = get_option('hampton_admin_notice');
		if ($show !== false && (int) $show == 0) return;
		get_template_part( 'templates/admin-notice' );
	}
}

// Hide admin notice
if ( !function_exists( 'hampton_callback_hide_admin_notice' ) ) {
	//Handler of the add_action('wp_ajax_hampton_hide_admin_notice', 'hampton_callback_hide_admin_notice');
	function hampton_callback_hide_admin_notice() {
		update_option('hampton_admin_notice', '0');
		exit;
	}
}


//-------------------------------------------------------
//-- Styles and scripts
//-------------------------------------------------------
	
// Load inline styles
if ( !function_exists( 'hampton_admin_footer' ) ) {
	//Handler of the add_action('admin_footer', 'hampton_admin_footer');
	function hampton_admin_footer() {
		// Get current screen
		$screen = get_current_screen();
		if ($screen->id=='nav-menus') {
			get_template_part( 'templates/icons' );
		}
	}
}
	
// Load required styles and scripts for admin mode
if ( !function_exists( 'hampton_admin_scripts' ) ) {
	//Handler of the add_action("admin_enqueue_scripts", 'hampton_admin_scripts');
	function hampton_admin_scripts() {

		// Add theme styles
		wp_enqueue_style(  'hampton-admin',  hampton_get_file_url('css/admin.css') );

		// Links to selected fonts
		$screen = get_current_screen();
		if (hampton_options_allow_override($screen->id) && hampton_options_allow_override($screen->post_type)) {
			// Load fontello icons
			// This style NEED theme prefix, because style 'fontello' some plugin contain different set of characters
			// and can't be used instead this style!
			wp_enqueue_style(  'fontello-style', hampton_get_file_url('css/fontello/css/fontello-embedded.css') );
			wp_enqueue_style(  'fontello-style-animation', hampton_get_file_url('css/fontello/css/animation.css') );
			// Load theme fonts
			$links = hampton_theme_fonts_links();
			if (count($links) > 0) {
				foreach ($links as $slug => $link) {
					wp_enqueue_style( sprintf('hampton-font-%s', $slug), $link );
				}
			}
		} else if (is_customize_preview() || $screen->id=='nav-menus') {
			// Load fontello icons
			// This style NEED theme prefix, because style 'fontello' some plugin contain different set of characters
			// and can't be used instead this style!
			wp_enqueue_style(  'fontello-style', hampton_get_file_url('css/fontello/css/fontello-embedded.css') );
		}

		// Add theme scripts
		wp_enqueue_script( 'hampton-utils', hampton_get_file_url('js/_utils.js'), array('jquery'), null, true );
		wp_enqueue_script( 'hampton-admin', hampton_get_file_url('js/_admin.js'), array('jquery'), null, true );
	}
}
	
// Add variables in the admin mode
if ( !function_exists( 'hampton_admin_localize_scripts' ) ) {
	//Handler of the add_action("admin_footer", 'hampton_admin_localize_scripts');
	function hampton_admin_localize_scripts() {
		$screen = get_current_screen();
		wp_localize_script( 'hampton-admin', 'HAMPTON_STORAGE', apply_filters( 'hampton_filter_localize_script_admin', array(
			'admin_mode' => true,
			'screen_id' => esc_attr($screen->id),
			'ajax_url' => esc_url(admin_url('admin-ajax.php')),
			'ajax_nonce' => esc_attr(wp_create_nonce(admin_url('admin-ajax.php'))),
			'ajax_error_msg' => esc_html__('Server response error', 'hampton'),
			'icon_selector_msg' => esc_html__('Select the icon for this menu item', 'hampton'),
			'user_logged_in' => true
			))
		);
	}
}



//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( !function_exists( 'hampton_importer_set_options' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_importer_options',	'hampton_importer_set_options', 9 );
	function hampton_importer_set_options($options=array()) {
		if (is_array($options)) {
			// Prepare demo data
			$options['demo_url'] = esc_url(hampton_get_protocol() . '://demofiles.axiomthemes.com/hampton/');
			// Required plugins
			$options['required_plugins'] = hampton_storage_get('required_plugins');
			// Default demo
			$options['files']['default']['title'] = esc_html__('Basekit Demo', 'hampton');
			$options['files']['default']['domain_dev'] = esc_url(hampton_get_protocol().'://hampton.dv.themerex.net');		// Developers domain
			$options['files']['default']['domain_demo']= esc_url(hampton_get_protocol().'://hampton.axiomthemes.com');		// Demo-site domain
			// If theme need more demo - just copy 'default' and change required parameter
		}
		return $options;
	}
}

// Put data into specified file
if (!function_exists('hampton_fpc')) {
    function hampton_fpc($file, $data, $flag=0) {
        global $wp_filesystem;
        if (!empty($file)) {
            if (isset($wp_filesystem) && is_object($wp_filesystem)) {
                $file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
                if ($flag==0) {
                    return $wp_filesystem->put_contents($file, $data, false);
                } else {
                    // Attention! WP_Filesystem object can't append the content!!!
                    // Use native PHP function if we need append file contents
                    return $wp_filesystem->put_contents($file, ($flag==FILE_APPEND && $wp_filesystem->exists($file) ? $wp_filesystem->get_contents($file) : '') . $data, false);
                }
            } else {
                if (hampton_is_on(hampton_get_theme_option('debug_mode')))
                    throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Put contents to the file "%s" failed', 'hampton'), $file));
            }
        }
        return false;
    }
}


//-------------------------------------------------------
//-- Third party plugins
//-------------------------------------------------------

// Register optional plugins
if ( !function_exists( 'hampton_register_plugins' ) ) {
	function hampton_register_plugins() {
		tgmpa(	apply_filters('hampton_filter_tgmpa_required_plugins', array(
				// Plugins to include in the autoinstall queue.
				)),
				array(
					'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
					'default_path' => '',                      // Default absolute path to bundled plugins.
					'menu'         => 'tgmpa-install-plugins', // Menu slug.
					'parent_slug'  => 'themes.php',            // Parent menu slug.
					'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
					'has_notices'  => true,                    // Show admin notices or not.
					'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
					'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
					'is_automatic' => true,                    // Automatically activate plugins after installation or not.
					'message'      => ''                       // Message to output right before the plugins table.
				)
			);
	}
}
?>