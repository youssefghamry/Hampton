<?php
/**
 * Theme functions: init, enqueue scripts and styles, include required files and widgets
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

// Theme storage
$HAMPTON_STORAGE = array(
	// Theme required plugin's slugs
	'required_plugins' => array(

		// Required plugins
		// DON'T COMMENT OR REMOVE NEXT LINES!
		'trx_addons',

		// Recommended (supported) plugins
		// If plugin not need - comment (or remove) it
		'booked',
		'contact-form-7',
		'essential-grid',
		'js_composer',
		'revslider',
        'trx_updater'
		)
);


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

if ( !function_exists('hampton_theme_setup1') ) {
	add_action( 'after_setup_theme', 'hampton_theme_setup1', 1 );
	function hampton_theme_setup1() {
		// Set theme content width
		$GLOBALS['content_width'] = apply_filters( 'hampton_filter_content_width', 1170 );
	}
}

if ( !function_exists('hampton_theme_setup') ) {
	add_action( 'after_setup_theme', 'hampton_theme_setup' );
	function hampton_theme_setup() {

		// Add default posts and comments RSS feed links to head 
		add_theme_support( 'automatic-feed-links' );
		
		// Enable support for Post Thumbnails
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size(370, 0, false);
		
		// Add thumb sizes
		// ATTENTION! If you change list below - check filter's names in the 'trx_addons_filter_get_thumb_size' hook
		$thumb_sizes = apply_filters('hampton_filter_add_thumb_sizes', array(
			'hampton-thumb-huge'		=> array(1170, 658, true),
			'hampton-thumb-big' 		=> array( 740, 416, true),
			'hampton-thumb-med' 		=> array( 370, 208, true),
			'hampton-thumb-med-cat' 		=> array( 370, 255, true),
			'hampton-thumb-avatar' 		=> array( 370, 370, true),
			'hampton-thumb-tiny' 		=> array(  90,  90, true),
			'hampton-thumb-masonry-big' => array( 770,   0, false),		// Only downscale, not crop
			'hampton-thumb-masonry'		=> array( 370,   0, false),		// Only downscale, not crop
			)
		);
		$mult = hampton_get_theme_option('retina_ready', 1);
		if ($mult > 1) $GLOBALS['content_width'] = apply_filters( 'hampton_filter_content_width', 1170*$mult);
		foreach ($thumb_sizes as $k=>$v) {
			// Add Original dimensions
			add_image_size( $k, $v[0], $v[1], $v[2]);
			// Add Retina dimensions
			if ($mult > 1) add_image_size( $k.'-@retina', $v[0]*$mult, $v[1]*$mult, $v[2]);
		}
		
		// Custom header setup
		add_theme_support( 'custom-header', array(
			'header-text'=>false
			)
		);

		// Custom backgrounds setup
		add_theme_support( 'custom-background', array()	);
		
		// Supported posts formats
		add_theme_support( 'post-formats', array('gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat') ); 
 
 		// Autogenerate title tag
		add_theme_support('title-tag');
 		
		// Add theme menus
		add_theme_support('nav-menus');
		
		// Switch default markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption') );

		// Editor custom stylesheet - for user
		add_editor_style( array_merge(
			array(
				'css/editor-style.css',
				hampton_get_file_url('css/fontello/css/fontello-embedded.css')
			),
			hampton_theme_fonts_for_editor()
			)
		);	
		
		// Make theme available for translation
		// Translations can be filed in the /languages/ directory
		load_theme_textdomain( 'hampton', hampton_get_folder_dir('languages') );
	
		// Register navigation menu
		register_nav_menus(array(
			'menu_main' => esc_html__('Main Menu', 'hampton'),
			'menu_footer' => esc_html__('Footer Menu', 'hampton')
			)
		);

		// Excerpt filters
		add_filter( 'excerpt_length',						'hampton_excerpt_length' );
		add_filter( 'excerpt_more',							'hampton_excerpt_more' );
		
		// Add required meta tags in the head
		add_action('wp_head',		 						'hampton_wp_head', 1);
		
		// Add custom inline styles
		add_action('wp_footer',		 						'hampton_wp_footer');
		add_action('admin_footer',	 						'hampton_wp_footer');

		// Enqueue scripts and styles for frontend
		add_action('wp_enqueue_scripts', 					'hampton_wp_scripts', 1000);			//priority 1000 - load styles before the plugin's support custom styles (priority 1100)
		add_action('wp_footer',		 						'hampton_localize_scripts');
		add_action('wp_enqueue_scripts', 					'hampton_wp_scripts_responsive', 2000);	//priority 2000 - load responsive after all other styles
		
		// Add body classes
		add_filter( 'body_class',							'hampton_add_body_classes' );

		// Register sidebars
		add_action('widgets_init', 							'hampton_widgets_init');
	}

}


//-------------------------------------------------------
//-- Thumb sizes
//-------------------------------------------------------
if ( !function_exists('hampton_image_sizes') ) {
	add_filter( 'image_size_names_choose', 'hampton_image_sizes' );
	function hampton_image_sizes( $sizes ) {
		$thumb_sizes = apply_filters('hampton_filter_add_thumb_sizes', array(
			'hampton-thumb-huge'		=> esc_html__( 'Fullsize image', 'hampton' ),
			'hampton-thumb-big'			=> esc_html__( 'Large image', 'hampton' ),
			'hampton-thumb-med'			=> esc_html__( 'Medium image', 'hampton' ),
			'hampton-thumb-med-cat'		=> esc_html__( 'Medium Category image', 'hampton' ),
			'hampton-thumb-avatar'		=> esc_html__( 'Avatar image', 'hampton' ),
			'hampton-thumb-tiny'		=> esc_html__( 'Small square avatar', 'hampton' ),
			'hampton-thumb-masonry-big'	=> esc_html__( 'Masonry Large (scaled)', 'hampton' ),
			'hampton-thumb-masonry'		=> esc_html__( 'Masonry (scaled)', 'hampton' ),
			)
		);
		$mult = hampton_get_theme_option('retina_ready', 1);
		foreach($thumb_sizes as $k=>$v) {
			$sizes[$k] = $v;
			if ($mult > 1) $sizes[$k.'-@retina'] = $v.' '.esc_html__('@2x', 'hampton' );
		}
		return $sizes;
	}
}


//-------------------------------------------------------
//-- Theme scripts and styles
//-------------------------------------------------------

// Load frontend scripts
if ( !function_exists( 'hampton_wp_scripts' ) ) {
	//Handler of the add_action('wp_enqueue_scripts', 'hampton_wp_scripts', 1000);
	function hampton_wp_scripts() {
		
		// Enqueue styles
		//------------------------
		
		// Links to selected fonts
		$links = hampton_theme_fonts_links();
		if (count($links) > 0) {
			foreach ($links as $slug => $link) {
				wp_enqueue_style( sprintf('hampton-font-%s', $slug), $link );
			}
		}
		
		// Fontello styles must be loaded before main stylesheet
		// This style NEED the theme prefix, because style 'fontello' in some plugin contain different set of characters
		// and can't be used instead this style!
		wp_enqueue_style( 'fontello-style',  hampton_get_file_url('css/fontello/css/fontello-embedded.css') );

		// Load main stylesheet
		$main_stylesheet = get_template_directory_uri() . '/style.css';
		wp_enqueue_style( 'hampton-main', $main_stylesheet, array(), null );

		// Load child stylesheet (if different) after the main stylesheet and fontello icons (important!)
		$child_stylesheet = get_stylesheet_directory_uri() . '/style.css';
		if ($child_stylesheet != $main_stylesheet) {
			wp_enqueue_style( 'hampton-child', $child_stylesheet, array('hampton-main'), null );
		}
		
		// Animations
		if ( (hampton_get_theme_option('blog_animation')!='none' || hampton_get_theme_option('menu_animation_in')!='none' || hampton_get_theme_option('menu_animation_out')!='none') && (hampton_get_theme_option('animation_on_mobile')=='yes' || !wp_is_mobile()) && (!function_exists('hampton_vc_is_frontend') || !hampton_vc_is_frontend()))
			wp_enqueue_style( 'hampton-animation',	hampton_get_file_url('css/animation.css') );

		// Custom colors
		if ( !is_customize_preview() && !isset($_GET['color_scheme']) && hampton_is_off(hampton_get_theme_option('debug_mode')) )
			wp_enqueue_style( 'hampton-colors', hampton_get_file_url('css/__colors.css') );
		else
			wp_add_inline_style( 'hampton-main', hampton_customizer_get_css() );

		// Merged styles
		if ( hampton_is_off(hampton_get_theme_option('debug_mode')) )
			wp_enqueue_style( 'hampton-styles', hampton_get_file_url('css/__styles.css') );

		// Add post nav background
		hampton_add_bg_in_post_nav();

		// Disable loading JQuery UI CSS
		wp_deregister_style('jquery_ui');
		wp_deregister_style('date-picker-css');


		// Enqueue scripts	
		//------------------------
		
		// Modernizr will load in head before other scripts and styles
		if ( substr(hampton_get_theme_option('blog_style'), 0, 7) == 'gallery' || substr(hampton_get_theme_option('blog_style'), 0, 9) == 'portfolio' )
			wp_enqueue_script( 'modernizr', hampton_get_file_url('js/theme.gallery/modernizr.min.js'), array(), null, false );
		
		// Merged scripts
		if ( hampton_is_off(hampton_get_theme_option('debug_mode')) )
			wp_enqueue_script( 'hampton-init', hampton_get_file_url('js/__scripts.js'), array('jquery'), null, true );
		else {
			// Skip link focus
			wp_enqueue_script( 'skip-link-focus-fix', hampton_get_file_url('js/skip-link-focus-fix.js'), array('jquery'), null, true );
			// Superfish Menu
			wp_enqueue_script( 'superfish', hampton_get_file_url('js/superfish.js'), array('jquery'), null, true );
			// Background video
			$header_video = hampton_get_theme_option('header_video');
			if (!empty($header_video) && !hampton_is_inherit($header_video))
				wp_enqueue_script( 'bideo', hampton_get_file_url('js/bideo.js'), array(), null, true );
			// Theme scripts
			wp_enqueue_script( 'hampton-utils', hampton_get_file_url('js/_utils.js'), array('jquery'), null, true );
			wp_enqueue_script( 'hampton-init', hampton_get_file_url('js/_init.js'), array('jquery'), null, true );
		}
		
		// Comments
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Media elements library	
		if (hampton_get_theme_setting('use_mediaelements')) {
			wp_enqueue_style ( 'mediaelement' );
			wp_enqueue_style ( 'wp-mediaelement' );
			wp_enqueue_script( 'mediaelement' );
			wp_enqueue_script( 'wp-mediaelement' );
		}
	}
}

// Add variables to the scripts in the frontend
if ( !function_exists( 'hampton_localize_scripts' ) ) {
	//Handler of the add_action('wp_footer', 'hampton_localize_scripts');
	function hampton_localize_scripts() {
		wp_localize_script( 'hampton-init', 'HAMPTON_STORAGE', apply_filters( 'hampton_filter_localize_script', array(
			// AJAX parameters
			'ajax_url' => esc_url(admin_url('admin-ajax.php')),
			'ajax_nonce' => esc_attr(wp_create_nonce(admin_url('admin-ajax.php'))),
			
			// Site base url
			'site_url' => get_site_url(),
			
			// User logged in
			'user_logged_in' => is_user_logged_in() ? true : false,
			
			// Menu width for mobile mode
			'mobile_layout_width' => max(480, hampton_get_theme_option('mobile_layout_width')),

			// Stretch sidemenu to window height
			'menu_stretch' => hampton_is_on(hampton_get_theme_option('menu_stretch')),

			// Menu animation
			'menu_animation_in' => hampton_get_theme_option('menu_animation_in'),
            'menu_animation_out' => hampton_get_theme_option('menu_animation_out'),

			// Video background
			'background_video' => hampton_get_theme_option('header_video'),

			// Video and Audio tag wrapper
			'use_mediaelements' => hampton_get_theme_setting('use_mediaelements') ? true : false,

			// Messages max length
			'message_maxlength'	=> intval(hampton_get_theme_setting('message_maxlength')),
						
			// Site color scheme
			'site_scheme' => sprintf('scheme_%s', hampton_get_theme_option('color_scheme')),

			
			// Internal vars - do not change it!
			
			// Flag for review mechanism
			'admin_mode' => false,

			// E-mail mask
			'email_mask' => '^([a-zA-Z0-9_\\-]+\\.)*[a-zA-Z0-9_\\-]+@[a-z0-9_\\-]+(\\.[a-z0-9_\\-]+)*\\.[a-z]{2,6}$',
			
			// Strings for translation
			'strings' => array(
					'ajax_error'		=> esc_html__('Invalid server answer!', 'hampton'),
					'error_global'		=> esc_html__('Error data validation!', 'hampton'),
					'name_empty' 		=> esc_html__("The name can't be empty", 'hampton'),
					'name_long'			=> esc_html__('Too long name', 'hampton'),
					'email_empty'		=> esc_html__('Too short (or empty) email address', 'hampton'),
					'email_long'		=> esc_html__('Too long email address', 'hampton'),
					'email_not_valid'	=> esc_html__('Invalid email address', 'hampton'),
					'text_empty'		=> esc_html__("The message text can't be empty", 'hampton'),
					'text_long'			=> esc_html__('Too long message text', 'hampton'),
					'search_error'		=> esc_html__('Search error! Try again later.', 'hampton'),
					'send_complete'		=> esc_html__("Send message complete!", 'hampton'),
					'send_error'		=> esc_html__('Transmit failed!', 'hampton')
					)
			))
		);
	}
}

// Load responsive styles (priority 2000 - load it after main styles and plugins custom styles)
if ( !function_exists( 'hampton_wp_scripts_responsive' ) ) {
	//Handler of the add_action('wp_enqueue_scripts', 'hampton_wp_scripts_responsive', 2000);
	function hampton_wp_scripts_responsive() {
		wp_enqueue_style( 'hampton-responsive', hampton_get_file_url('css/responsive.css') );
	}
}

//  Add meta tags and inline scripts in the header for frontend
if (!function_exists('hampton_wp_head')) {
	//Handler of the add_action('wp_head',	'hampton_wp_head', 1);
	function hampton_wp_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="format-detection" content="telephone=no">
		<link rel="profile" href="//gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php
	}
}

// Add theme specified classes to the body
if ( !function_exists('hampton_add_body_classes') ) {
	//Handler of the add_filter( 'body_class', 'hampton_add_body_classes' );
	function hampton_add_body_classes( $classes ) {
		$blog_mode = hampton_storage_get('blog_mode');
		$classes[] = 'blog_mode_' . esc_attr($blog_mode);
		$classes[] = 'body_tag';	// Need for the .scheme_self
		$classes[] = 'body_style_' . esc_attr(hampton_get_theme_option('body_style'));
		$classes[] = 'scheme_' . esc_attr(hampton_get_theme_option('color_scheme'));
		if (in_array($blog_mode, array('post', 'page'))) {
			$classes[] = 'is_single';
		} else {
			$classes[] = ' is_stream';
			$classes[] = 'blog_style_'.esc_attr(hampton_get_theme_option('blog_style'));
		}
		if (hampton_sidebar_present()) {
			$classes[] = 'sidebar_show sidebar_' . esc_attr(hampton_get_theme_option('sidebar_position')) ;
		} else {
			$classes[] = 'sidebar_hide';
			if (hampton_is_on(hampton_get_theme_option('expand_content')))
				 $classes[] = 'expand_content';
		}
		if (hampton_is_on(hampton_get_theme_option('remove_margins')))
			 $classes[] = 'remove_margins';

		$classes[] = 'header_style_' . esc_attr(hampton_get_theme_option("header_style"));
		$classes[] = 'header_position_' . esc_attr(hampton_get_theme_option("header_position"));
		$classes[] = 'header_title_' . esc_attr(hampton_need_page_title() ? 'on' : 'off');

		$menu_style= hampton_get_theme_option("menu_style");
		$classes[] = 'menu_style_' . esc_attr($menu_style) . (in_array($menu_style, array('left', 'right'))	? ' menu_style_side' : '');
		$classes[] = 'no_layout';
		
		return $classes;
	}
}
	
// Load inline styles
if ( !function_exists( 'hampton_wp_footer' ) ) {
	//Handler of the add_action('wp_footer', 'hampton_wp_footer');
	//and add_action('admin_footer', 'hampton_wp_footer');
	function hampton_wp_footer() {
		// Get inline styles from storage
		if (($css = hampton_storage_get('inline_styles')) != '') {
			wp_enqueue_style(  'hampton-inline-styles',  hampton_get_file_url('css/__inline.css') );
			wp_add_inline_style( 'hampton-inline-styles', $css );
		}
	}
}


//-------------------------------------------------------
//-- Sidebars and widgets
//-------------------------------------------------------

// Register widgetized areas
if ( !function_exists('hampton_widgets_init') ) {
	function hampton_widgets_init() {
		$sidebars = hampton_get_list_sidebars();
		if (is_array($sidebars) && count($sidebars) > 0) {
			foreach ($sidebars as $id=>$name) {
				register_sidebar( array(
										'name'          => $name,
										'id'            => $id,
										'before_widget' => '<aside id="%1$s" class="widget %2$s">',
										'after_widget'  => '</aside>',
										'before_title'  => '<h5 class="widget_title">',
										'after_title'   => '</h5>'
										)
								);
			}
		}
	}
}


//-------------------------------------------------------
//-- Theme fonts
//-------------------------------------------------------

// Return links for all theme fonts
if ( !function_exists('hampton_theme_fonts_links') ) {
	function hampton_theme_fonts_links() {
		$links = array();
		
		/*
		Translators: If there are characters in your language that are not supported
		by chosen font(s), translate this to 'off'. Do not translate into your own language.
		*/
		$google_fonts_enabled = ( 'off' !== esc_html_x( 'on', 'Google fonts: on or off', 'hampton' ) );
		$custom_fonts_enabled = ( 'off' !== esc_html_x( 'on', 'Custom fonts (included in the theme): on or off', 'hampton' ) );
		
		if ( ($google_fonts_enabled || $custom_fonts_enabled) && !hampton_storage_empty('load_fonts') ) {
			$load_fonts = hampton_storage_get('load_fonts');
			if (count($load_fonts) > 0) {
				$google_fonts = '';
				foreach ($load_fonts as $font) {
					$slug = hampton_get_load_fonts_slug($font['name']);
					$url  = hampton_get_file_url( sprintf('css/font-face/%s/stylesheet.css', $slug));
					if ($url != '') {
						if ($custom_fonts_enabled) {
							$links[$slug] = $url;
						}
					} else {
						if ($google_fonts_enabled) {
							$google_fonts .= ($google_fonts ? '|' : '') 
											. str_replace(' ', '+', $font['name'])
											. ':' 
											. (empty($font['styles']) ? '400,400italic,700,700italic' : $font['styles']);
						}
					}
				}
				if ($google_fonts && $google_fonts_enabled) {
					$links['google_fonts'] = sprintf('%s://fonts.googleapis.com/css?family=%s&subset=%s', hampton_get_protocol(), $google_fonts, hampton_get_theme_option('load_fonts_subset'));
				}
			}
		}
		return $links;
	}
}

// Return links for WP Editor
if ( !function_exists('hampton_theme_fonts_for_editor') ) {
	function hampton_theme_fonts_for_editor() {
		$links = array_values(hampton_theme_fonts_links());
		if (is_array($links) && count($links) > 0) {
			for ($i=0; $i<count($links); $i++) {
				$links[$i] = str_replace(',', '%2C', $links[$i]);
			}
		}
		return $links;
	}
}


//-------------------------------------------------------
//-- The Excerpt
//-------------------------------------------------------
if ( !function_exists('hampton_excerpt_length') ) {
	function hampton_excerpt_length( $length ) {
		return max(1, hampton_get_theme_setting('max_excerpt_length'));
	}
}

if ( !function_exists('hampton_excerpt_more') ) {
	function hampton_excerpt_more( $more ) {
		return '&hellip;';
	}
}



//-------------------------------------------------------
//-- Include theme (or child) PHP-files
//-------------------------------------------------------

require_once trailingslashit( get_template_directory() ) . 'includes/utils.php';
require_once trailingslashit( get_template_directory() ) . 'includes/storage.php';
require_once trailingslashit( get_template_directory() ) . 'includes/lists.php';
require_once trailingslashit( get_template_directory() ) . 'includes/wp.php';

require_once trailingslashit( get_template_directory() ) . 'includes/theme.tags.php';
require_once trailingslashit( get_template_directory() ) . 'includes/theme.hovers/theme.hovers.php';
require_once trailingslashit( get_template_directory() ) . 'theme-specific/theme-shortcodes.php';

if (is_admin()) {
	require_once trailingslashit( get_template_directory() ) . 'includes/tgmpa/class-tgm-plugin-activation.php';
	require_once trailingslashit( get_template_directory() ) . 'includes/admin.php';
}

require_once trailingslashit( get_template_directory() ) . 'theme-options/theme.customizer.php';

// Plugins support
if (is_array($HAMPTON_STORAGE['required_plugins']) && count($HAMPTON_STORAGE['required_plugins']) > 0) {
	foreach ($HAMPTON_STORAGE['required_plugins'] as $plugin_slug) {
		$plugin_slug = hampton_esc($plugin_slug);
		$plugin_path = trailingslashit( get_template_directory() ) . sprintf('plugins/%s/%s.php', $plugin_slug, $plugin_slug);
		if (file_exists($plugin_path)) { require_once $plugin_path; }
	}
}


// Add checkbox with "I agree ..."
if ( ! function_exists( 'hampton_comment_form_agree' ) ) {
    add_filter('comment_form_fields', 'hampton_comment_form_agree', 11);
    function hampton_comment_form_agree( $comment_fields ) {
        $privacy_text = hampton_get_privacy_text();
        if ( ! empty( $privacy_text ) ) {
            $comment_fields['i_agree_privacy_policy'] = hampton_single_comments_field(
                array(
                    'form_style'        => 'default',
                    'field_type'        => 'checkbox',
                    'field_req'         => '',
                    'field_icon'        => '',
                    'field_value'       => '1',
                    'field_name'        => 'i_agree_privacy_policy',
                    'field_title'       => $privacy_text,
                )
            );
        }
        return $comment_fields;
    }
}

// Return template for the single field in the comments
if ( ! function_exists( 'hampton_single_comments_field' ) ) {
    function hampton_single_comments_field( $args ) {
        $path_height = 'path' == $args['form_style']
            ? ( 'text' == $args['field_type'] ? 75 : 190 )
            : 0;
        $html = '<div class="comments_field comments_' . esc_attr( $args['field_name'] ) . '">'
            . ( 'default' == $args['form_style'] && 'checkbox' != $args['field_type']
                ? '<label for="' . esc_attr( $args['field_name'] ) . '" class="' . esc_attr( $args['field_req'] ? 'required' : 'optional' ) . '">' . esc_html( $args['field_title'] ) . '</label>'
                : ''
            )
            . '<span class="sc_form_field_wrap">';
        if ( 'text' == $args['field_type'] ) {
            $html .= '<input id="' . esc_attr( $args['field_name'] ) . '" name="' . esc_attr( $args['field_name'] ) . '" type="text"' . ( 'default' == $args['form_style'] ? ' placeholder="' . esc_attr( $args['field_placeholder'] ) . ( $args['field_req'] ? ' *' : '' ) . '"' : '' ) . ' value="' . esc_attr( $args['field_value'] ) . '"' . ( $args['field_req'] ? ' aria-required="true"' : '' ) . ' />';
        } elseif ( 'checkbox' == $args['field_type'] ) {
            $html .= '<input id="' . esc_attr( $args['field_name'] ) . '" name="' . esc_attr( $args['field_name'] ) . '" type="checkbox" value="' . esc_attr( $args['field_value'] ) . '"' . ( $args['field_req'] ? ' aria-required="true"' : '' ) . ' />'
                . ' <label for="' . esc_attr( $args['field_name'] ) . '" class="' . esc_attr( $args['field_req'] ? 'required' : 'optional' ) . '">' . wp_kses_post( $args['field_title'] ) . '</label>';
        } else {
            $html .= '<textarea id="' . esc_attr( $args['field_name'] ) . '" name="' . esc_attr( $args['field_name'] ) . '"' . ( 'default' == $args['form_style'] ? ' placeholder="' . esc_attr( $args['field_placeholder'] ) . ( $args['field_req'] ? ' *' : '' ) . '"' : '' ) . ( $args['field_req'] ? ' aria-required="true"' : '' ) . '></textarea>';
        }
        if ( 'default' != $args['form_style'] ) {
            $html .= '<span class="sc_form_field_hover">'
                . ( 'path' == $args['form_style']
                    ? '<svg class="sc_form_field_graphic" preserveAspectRatio="none" viewBox="0 0 520 ' . intval( $path_height ) . '" height="100%" width="100%"><path d="m0,0l520,0l0,' . intval( $path_height ) . 'l-520,0l0,-' . intval( $path_height ) . 'z"></svg>'
                    : ''
                )
                . ( 'iconed' == $args['form_style']
                    ? '<i class="sc_form_field_icon ' . esc_attr( $args['field_icon'] ) . '"></i>'
                    : ''
                )
                . '<span class="sc_form_field_content" data-content="' . esc_attr( $args['field_title'] ) . '">' . wp_kses_post( $args['field_title'] ) . '</span>'
                . '</span>';
        }
        $html .= '</span></div>';
        return $html;
    }
}

/**
 * Fire the wp_body_open action.
 *
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
 */
if ( ! function_exists( 'wp_body_open' ) ) {
	function wp_body_open() {
		/**
		 * Triggered after the opening <body> tag.
		 */
		do_action('wp_body_open');
	}
}
?>