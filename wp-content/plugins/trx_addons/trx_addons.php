<?php
/*
Plugin Name: ThemeREX Addons
Plugin URI: http://themerex.net
Description: Add many widgets, shortcodes and custom post types for your theme
Version: 1.71.2.3
Author: ThemeREX
Author URI: http://themerex.net
*/

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) die( '-1' );

// Current version
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) define( 'TRX_ADDONS_VERSION', '1.71.2.3' );

// Plugin's storage
//global $TRX_ADDONS_STORAGE;
$TRX_ADDONS_STORAGE = array(
	// Plugin's location and name
	'plugin_dir' => plugin_dir_path(__FILE__),
	'plugin_url' => plugin_dir_url(__FILE__),
	'plugin_base'=> explode('/', plugin_basename(__FILE__)),
	// Plugin's custom post types
	'post_types' => array(),
	// Last operation result
	'result' => array(
		'error' => '',
		'success' => ''
	),
	// Arguments to register widgets
	'widgets_args' => array(
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget_title">',
		'after_title'   => '</h5>',
	),
	// Shortcodes stack
	'sc_stack' => array(),
	'sc_stack_data' => array(),
	// Profiler points
	'profiler_points' => array()
);

// Next files must be loaded before options
require_once 'includes/plugin.socials.php';
require_once 'includes/plugin.files.php';

// Plugin's internal utilities
require_once 'includes/plugin.debug.php';
require_once 'includes/plugin.utils.php';
require_once 'includes/plugin.media.php';
require_once 'includes/plugin.wp.php';
require_once 'includes/plugin.html.php';
require_once 'includes/plugin.users.php';

// Plugin's options
require_once 'includes/plugin.options.php';
require_once 'includes/plugin.options.customizer.php';
if (is_admin()) {
	require_once 'includes/plugin.options.meta-box.php';
}

// Internal message
if (($msg = get_option('trx_addons_message')) != '') {
	$TRX_ADDONS_STORAGE['result']['success'] = $msg;
	update_option('trx_addons_message', '');
}

// Third-party plugins support
if (($fdir = trx_addons_get_file_dir('api/bbpress.php')) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir('api/booked/booked.php')) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir('api/calculated-fields-form/calculated-fields-form.php')) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir('api/contact-form-7.php')) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir('api/content_timeline/content_timeline.php')) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir('api/essential-grid.php')) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir('api/instagram-feed.php')) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir('api/js_composer.php')) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir('api/mailchimp-for-wp.php')) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir('api/revslider.php')) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir('api/the-events-calendar/the-events-calendar.php')) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir('api/trx_donations.php')) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir('api/twitter/twitter.php')) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir('api/ubermenu.php')) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir('api/vc-extensions-bundle.php')) != '') { include_once $fdir; }
if (($fdir = trx_addons_get_file_dir('api/woocommerce.php')) != '') { include_once $fdir; }

// Extra buttons into TinyMCE Editor
if (($fdir = trx_addons_get_file_dir('editor/editor.php')) != '') { include_once $fdir; }

// Custom post types
if (($fdir = trx_addons_get_file_dir('cpt/cpt.php')) != '') { include_once $fdir; }

// Widgets
if (($fdir = trx_addons_get_file_dir('widgets/widgets.php')) != '') { include_once $fdir; }

// Shortcodes
if (($fdir = trx_addons_get_file_dir('shortcodes/shortcodes.php')) != '') { include_once $fdir; }

// CV
if (($fdir = trx_addons_get_file_dir('cv/cv.php')) != '') { include_once $fdir; }

// Importer
if (($fdir = trx_addons_get_file_dir('importer/importer.php')) != '') { include_once $fdir; }


//-------------------------------------------------------
//-- Plugin init
//-------------------------------------------------------

// Plugin activate hook
if (!function_exists('trx_addons_activate')) {
	register_activation_hook(__FILE__, 'trx_addons_activate');
	function trx_addons_activate() {
		update_option('trx_addons_just_activated', 'yes');
	}
}

// Plugin init (after init custom post types and after all other plugins)
if ( !function_exists('trx_addons_init') ) {
	add_action( 'init', 'trx_addons_init', 11 );
	function trx_addons_init() {

		// Load translation files
		trx_addons_load_plugin_textdomain();

		// Add thumb sizes
		$thumb_sizes = apply_filters('trx_addons_filter_add_thumb_sizes', array(
			'trx_addons-thumb-huge'		=> array(1170,658, true),
			'trx_addons-thumb-big'		=> array(770, 433, true),
			'trx_addons-thumb-medium'	=> array(370, 208, true),
			'trx_addons-thumb-small'	=> array(270, 152, true),
			'trx_addons-thumb-portrait'	=> array(370, 493, true),
			'trx_addons-thumb-avatar'	=> array(370, 370, true),
			'trx_addons-thumb-tiny'		=> array( 75,  75, true),
			'trx_addons-thumb-masonry'	=> array(370,   0, false)	// Only downscale, not crop
			)
		);
		$mult = trx_addons_get_option('retina_ready', 1);
		foreach ($thumb_sizes as $k=>$v) {
			// Add Original dimensions
			add_image_size( $k, $v[0], $v[1], $v[2]);
			// Add Retina dimensions
			if ($mult > 1) add_image_size( $k.'-@retina', $v[0]*$mult, $v[1]*$mult, $v[2]);
		}

		// Check if this is first run - flush rewrite rules
		if (get_option('trx_addons_just_activated')=='yes') {
			update_option('trx_addons_just_activated', 'no');
			flush_rewrite_rules();			
		}
	}
}



//-------------------------------------------------------
//-- Featured images
//-------------------------------------------------------
if ( !function_exists('trx_addons_image_sizes') ) {
	add_filter( 'image_size_names_choose', 'trx_addons_image_sizes' );
	function trx_addons_image_sizes( $sizes ) {
		$thumb_sizes = apply_filters('trx_addons_filter_add_thumb_sizes', array(
			'trx_addons-thumb-big'		=> esc_html__( 'Large image', 'trx_addons' ),
			'trx_addons-thumb-med'		=> esc_html__( 'Medium image', 'trx_addons' ),
			'trx_addons-thumb-small'	=> esc_html__( 'Small image', 'trx_addons' ),
			'trx_addons-thumb-portrait'	=> esc_html__( 'Portrait', 'trx_addons' ),
			'trx_addons-thumb-avatar'	=> esc_html__( 'Big square avatar', 'trx_addons' ),
			'trx_addons-thumb-tiny'		=> esc_html__( 'Small square avatar', 'trx_addons' ),
			'trx_addons-thumb-masonry'	=> esc_html__( 'Masonry (scaled)', 'trx_addons' )
			)
		);
		$mult = trx_addons_get_option('retina_ready', 1);
		foreach($thumb_sizes as $k=>$v) {
			$sizes[$k] = $v;
			if ($mult > 1) $sizes[$k.'-@retina'] = $v.' '.esc_html('@2x', 'trx_addons' );
		}
		return $sizes;
	}
}



//-------------------------------------------------------
//-- Load scripts and styles
//-------------------------------------------------------
	
// Load required styles and scripts in the admin mode
if ( !function_exists( 'trx_addons_load_scripts_admin' ) ) {
	add_action("admin_enqueue_scripts", 'trx_addons_load_scripts_admin');
	function trx_addons_load_scripts_admin() {
		// Admin styles
		trx_addons_enqueue_style( 'trx_addons-admin', trx_addons_get_file_url('css/trx_addons.admin.css'), array(), null );
		trx_addons_enqueue_script( 'trx_addons-admin', trx_addons_get_file_url('js/trx_addons.admin.js'), array('jquery'), null, true );
		trx_addons_enqueue_script( 'trx_addons-utils', trx_addons_get_file_url('js/trx_addons.utils.js'), array('jquery'), null, true );
	}
}
	
// Add variables in the admin mode
if ( !function_exists( 'trx_addons_localize_scripts_admin' ) ) {
	add_action("admin_footer", 'trx_addons_localize_scripts_admin');
	function trx_addons_localize_scripts_admin() {
		// Add variables into JS
		wp_localize_script( 'trx_addons-admin', 'TRX_ADDONS_STORAGE', apply_filters('trx_addons_localize_script_admin', array(
			// AJAX parameters
			'ajax_url'	=> esc_url(admin_url('admin-ajax.php')),
			'ajax_nonce'=> esc_attr(wp_create_nonce(admin_url('admin-ajax.php'))),
			// Site base url
			'site_url'	=> esc_url(get_site_url())
			) )
		);
	}
}

	
// Load required styles and scripts in the frontend
if ( !function_exists( 'trx_addons_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_load_scripts_front');
	function trx_addons_load_scripts_front() {

		// Fontello icons must be loaded before main stylesheet
		trx_addons_enqueue_style( 'trx_addons-icons', trx_addons_get_file_url('css/font-icons/css/trx_addons_icons-embedded.css') );

		// Load Swiper slider script and styles
		trx_addons_enqueue_slider();

		// Load Popup script and styles
		trx_addons_enqueue_popup();

		// If 'debug_mode' is off - load merged style and scripts
		if (trx_addons_is_off(trx_addons_get_option('debug_mode'))) {
			trx_addons_enqueue_style( 'trx_addons', trx_addons_get_file_url('css/trx_addons.css'), array(), null );
			trx_addons_enqueue_script( 'trx_addons', trx_addons_get_file_url('js/trx_addons.js'), array('jquery'), null, true );

		// Else load all styles and scripts separate
		} else {
			trx_addons_enqueue_style( 'trx_addons', trx_addons_get_file_url('css/trx_addons.front.css'), array(), null );
			trx_addons_enqueue_style( 'trx_addons-hovers', trx_addons_get_file_url('css/trx_addons.hovers.css'), array(), null );
			trx_addons_enqueue_script( 'trx_addons', trx_addons_get_file_url('js/trx_addons.front.js'), array('jquery'), null, true );
			trx_addons_enqueue_script( 'trx_addons-utils', trx_addons_get_file_url('js/trx_addons.utils.js'), array('jquery'), null, true );
		}
	}
}

// Add variables in the frontend
if ( !function_exists( 'trx_addons_localize_scripts_front' ) ) {
	add_action("wp_footer", 'trx_addons_localize_scripts_front');
	function trx_addons_localize_scripts_front() {
		wp_localize_script( 'trx_addons', 'TRX_ADDONS_STORAGE', apply_filters('trx_addons_localize_script', array(
			// AJAX parameters
			'ajax_url'	=> esc_url(admin_url('admin-ajax.php')),
			'ajax_nonce'=> esc_attr(wp_create_nonce(admin_url('admin-ajax.php'))),
			// Site base url
			'site_url'	=> esc_url(get_site_url()),
			// VC frontend edit mode
			'vc_edit_mode'	=> function_exists('trx_addons_vc_is_frontend') && trx_addons_vc_is_frontend() ? 1 : 0,
			// Popup engine
			'popup_engine'=> trx_addons_get_option('popup_engine'),
			// Use menu cache
			'menu_cache' => trx_addons_is_on(trx_addons_get_option('menu_cache')),
			// User logged in
			'user_logged_in'=> is_user_logged_in() ? 1 : 0,
			// E-mail mask to validate forms
			'email_mask' => '^([a-zA-Z0-9_\\-]+\\.)*[a-zA-Z0-9_\\-]+@[a-z0-9_\\-]+(\\.[a-z0-9_\\-]+)*\\.[a-z]{2,6}$',
			// JS Messages
			'msg_ajax_error'			=> addslashes(esc_html__('Invalid server answer!', 'trx_addons')),
			'msg_magnific_loading'		=> addslashes(esc_html__('Loading image', 'trx_addons')),
			'msg_magnific_error'		=> addslashes(esc_html__('Error loading image', 'trx_addons')),
			'msg_error_like'			=> addslashes(esc_html__('Error saving your like! Please, try again later.', 'trx_addons')),
			'msg_field_name_empty'		=> addslashes(esc_html__("The name can't be empty", 'trx_addons')),
			'msg_field_email_empty'		=> addslashes(esc_html__('Too short (or empty) email address', 'trx_addons')),
			'msg_field_email_not_valid'	=> addslashes(esc_html__('Invalid email address', 'trx_addons')),
			'msg_field_text_empty'		=> addslashes(esc_html__("The message text can't be empty", 'trx_addons')),
			'msg_send_complete'			=> addslashes(esc_html__("Send message complete!", 'trx_addons')),
			'msg_send_error'			=> addslashes(esc_html__('Transmit failed!', 'trx_addons'))
			) )
		);
	}
}
	
// Merge all separate styles and scripts into single file to increase page upload speed
if ( !function_exists( 'trx_addons_merge_styles' ) ) {
	add_action('trx_addons_action_save_options', 'trx_addons_merge_styles');
	function trx_addons_merge_styles() {
		$msg = 	'/* ' . strip_tags( __("ATTENTION! This file was generated automatically! Don't change it!!!", 'trx_addons') ) 
				. "\n----------------------------------------------------------------------- */\n";
		// Merge styles
		$list = apply_filters( 'trx_addons_filter_merge_styles', array(
																'css/trx_addons.front.css',
																'css/trx_addons.hovers.css'
																)
							);
		$css = '';
		foreach ($list as $f) {
			$css .= trx_addons_fgc(trx_addons_get_file_dir($f));
		}
		if ( $css != '') {
			trx_addons_fpc( trx_addons_get_file_dir('css/trx_addons.css'), $msg . trx_addons_minify_css( $css ) );
		}

		// Merge scripts
		$list = apply_filters( 'trx_addons_filter_merge_scripts', array(
																	'js/trx_addons.front.js',
																	'js/trx_addons.utils.js'
																	)
							);
		$js = '';
		foreach ($list as $f) {
			$js .= trx_addons_fgc(trx_addons_get_file_dir($f));
		}
		if ( $js != '') {
			trx_addons_fpc( trx_addons_get_file_dir('js/trx_addons.js'), $msg . trx_addons_minify_js( $js ) );
		}

	}
}



//-------------------------------------------------------
//-- Utilities
//-------------------------------------------------------

// Load plugin's translation files
if ( !function_exists( 'trx_addons_load_plugin_textdomain' ) ) {
	function trx_addons_load_plugin_textdomain($domain='trx_addons') {
		if ( is_textdomain_loaded( $domain ) && !is_a( $GLOBALS['l10n'][ $domain ], 'NOOP_Translations' ) ) return true;
		return load_plugin_textdomain( $domain, false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}
}


// Return result of last operation
if ( !function_exists( 'trx_addons_get_last_result' ) ) {
	function trx_addons_get_last_result() {
		global $TRX_ADDONS_STORAGE;
		return $TRX_ADDONS_STORAGE['result'];
	}
}



//-------------------------------------------------------
//-- Delayed action from previous session
//-- (after save options)
//-- to save new CSS, etc.
//-------------------------------------------------------
if ( !function_exists('trx_addons_do_delayed_action') ) {
	add_action( 'after_setup_theme', 'trx_addons_do_delayed_action' );
	function trx_addons_do_delayed_action() {
		if (($action = get_option('trx_addons_action')) != '') {
		    do_action($action);
			update_option('trx_addons_action', '');
		}
	}
}


//------------------------------------------------------------
//-- Compatibility Gutenberg and other PageBuilders
//-------------------------------------------------------------

// Prevent simultaneous editing of posts for Gutenberg and other PageBuilders (VC, Elementor)
if ( ! function_exists( 'trx_addons_gutenberg_disable_cpt' ) ) {
    add_action( 'current_screen', 'trx_addons_gutenberg_disable_cpt' );
    function trx_addons_gutenberg_disable_cpt() {
        if ( trx_addons_exists_gutenberg() ) {
            $current_post_type = get_current_screen()->post_type;
            $disable = false;
            if ( !$disable && trx_addons_exists_elementor() ) {
                $post_types = get_post_types_by_support( 'elementor' );
                $disable = is_array($post_types) && in_array($current_post_type, $post_types);
            }
            if ( !$disable && trx_addons_exists_vc() ) {
                $post_types = function_exists('vc_editor_post_types') ? vc_editor_post_types() : array();
                $disable = is_array($post_types) && in_array($current_post_type, $post_types);
            }
            if ( $disable ) {
                remove_filter( 'replace_editor', 'gutenberg_init' );
                remove_action( 'load-post.php', 'gutenberg_intercept_edit_post' );
                remove_action( 'load-post-new.php', 'gutenberg_intercept_post_new' );
                remove_action( 'admin_init', 'gutenberg_add_edit_link_filters' );
                remove_filter( 'admin_url', 'gutenberg_modify_add_new_button_url' );
                remove_action( 'admin_print_scripts-edit.php', 'gutenberg_replace_default_add_new_button' );
                remove_action( 'admin_enqueue_scripts', 'gutenberg_editor_scripts_and_styles' );
                remove_filter( 'screen_options_show_screen', '__return_false' );
            }
        }
    }
}

// Check if plugin 'WPBakery PageBuilder' (old name is 'Visual Composer') is installed and activated
if ( !function_exists( 'trx_addons_exists_vc' ) ) {
    function trx_addons_exists_vc() {
        return class_exists('Vc_Manager');
    }
}

// Check if plugin 'Elementor' is installed and activated
if ( !function_exists( 'trx_addons_exists_elementor' ) ) {
    function trx_addons_exists_elementor() {
        return class_exists('Elementor\Plugin');
    }
}

// Check if plugin 'Gutenberg' is installed and activated
if ( !function_exists( 'trx_addons_exists_gutenberg' ) ) {
    function trx_addons_exists_gutenberg() {
        return function_exists( 'register_block_type' );  // && function_exists( 'the_gutenberg_project' )
    }
}


/* WordPress 5.8+: Widgets block editor in Customize don't allow moving sections with widgets
 *                 from the panel 'Widgets' to another panel
--------------------------------------------------------------------------------------------------- */
if ( ! function_exists( 'trx_addons_disable_moving_widgets_sections_in_customizer' ) ) {
    add_filter( 'after_setup_theme', 'trx_addons_disable_moving_widgets_sections_in_customizer', 1 );
    function trx_addons_disable_moving_widgets_sections_in_customizer() {
        if ( version_compare( get_bloginfo( 'version' ), '5.8', '>=' ) ) {
            $slug = str_replace( '-', '_', get_template() );
            add_filter( "{$slug}_filter_front_page_options", 'trx_addons_disable_moving_widgets_sections_in_customizer_callback', 10000, 1 );
        }
    }
}

// Rename sections with widgets to prevent its moving
if ( ! function_exists( 'trx_addons_disable_moving_widgets_sections_in_customizer_callback' ) ) {
    function trx_addons_disable_moving_widgets_sections_in_customizer_callback( $options ) {
        if ( isset( $options['front_page_sections']['options'] ) && is_array( $options['front_page_sections']['options'] ) ) {
            foreach ( $options['front_page_sections']['options'] as $k => $v ) {
                if ( isset( $options["sidebar-widgets-front_page_{$k}_widgets"] ) && ! isset( $options["front_page_{$k}_widgets"] ) ) {
                    trx_addons_array_insert_after( $options, "sidebar-widgets-front_page_{$k}_widgets", array(
                        "front_page_{$k}_widgets" => $options["sidebar-widgets-front_page_{$k}_widgets"]
                    ) );
                    unset( $options["sidebar-widgets-front_page_{$k}_widgets"] );
                }
                if ( ! empty( $options["front_page_{$k}_widgets_info"]['desc'] ) && is_string( $options["front_page_{$k}_widgets_info"]['desc'] ) ) {
                    $options["front_page_{$k}_widgets_info"]['desc'] .= '<br>&nbsp;<br><i>' . wp_kses_data( sprintf( __( 'Attention! Since WordPress 5.8+ you are not able to select widgets for this section here, in order to do that please go to Customize - Widgets - Front page section "%s"', 'trx_addons' ), $v ) . '</i>' );
                }
            }
        }
        return $options;
    }
}
?>