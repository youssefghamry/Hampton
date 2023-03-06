<?php
/**
 * Default Theme Options and Internal Theme Settings
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

// -----------------------------------------------------------------
// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
// -- Internal theme settings
// -----------------------------------------------------------------
hampton_storage_set('settings', array(
	
	'custom_sidebars'			=> 2,							// How many custom sidebars will be registered (in addition to theme preset sidebars): 0 - 10

	'ajax_views_counter'		=> true,						// Use AJAX for increment posts counter (if cache plugins used) 
																// or increment posts counter then loading page (without cache plugin)
	'disable_jquery_ui'			=> false,						// Prevent loading custom jQuery UI libraries in the third-party plugins

	'max_load_fonts'			=> 3,							// Max fonts number to load from Google fonts or from uploaded fonts

	'breadcrumbs_max_level' 	=> 3,							// Max number of the nested categories in the breadcrumbs (0 - unlimited)

	'use_mediaelements'			=> true,						// Load script "Media Elements" to play video and audio

	'max_excerpt_length'		=> 35,							// Max words number for the excerpt in the blog style 'Excerpt'.
																// For style 'Classic' - get half from this value
	'message_maxlength'			=> 1000							// Max length of the message from contact form
	
));



// -----------------------------------------------------------------
// -- Theme fonts (Google and/or custom fonts)
// -----------------------------------------------------------------

// Fonts to load when theme start
// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
// For example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
hampton_storage_set('load_fonts', array(
	array(
		'name'   => 'Muli',
		'family' => 'sans-serif',
        'styles' => '300, 400'
		),
    array(
        'name'   => 'Nimbusromno9l',
        'family' => 'serif'
    )
));

// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
hampton_storage_set('load_fonts_subset', 'latin,latin-ext');

// Settings of the main tags
hampton_storage_set('theme_fonts', array(
	'p' => array(
		'title'				=> esc_html__('Main text', 'hampton'),
		'description'		=> esc_html__('Font settings of the main text of the site', 'hampton'),
		'font-family'		=> '"Muli", sans-serif',
		'font-size' 		=> '1rem',
		'font-weight'		=> '400',
		'font-style'		=> 'normal',
		'line-height'		=> '1.9em',
		'text-decoration'	=> 'none',
		'text-transform'	=> 'none',
		'letter-spacing'	=> '0.8px',
		'margin-top'		=> '0em',
		'margin-bottom'		=> '1.4em'
		),
	'h1' => array(
		'title'				=> esc_html__('Heading 1', 'hampton'),
		'font-family'		=> '"Nimbusromno9l", serif',
		'font-size' 		=> '3.74467rem',
		'font-weight'		=> '400',
		'font-style'		=> 'normal',
		'line-height'		=> '1.25em',
		'text-decoration'	=> 'none',
		'text-transform'	=> 'uppercase',
		'letter-spacing'	=> '2px',
		'margin-top'		=> '1.14em',
		'margin-bottom'		=> '0.87em'
		),
	'h2' => array(
		'title'				=> esc_html__('Heading 2', 'hampton'),
		'font-family'		=> '"Nimbusromno9l", serif',
		'font-size' 		=> '2.9rem',
		'font-weight'		=> '400',
		'font-style'		=> 'normal',
		'line-height'		=> '1.25em',
		'text-decoration'	=> 'none',
		'text-transform'	=> 'uppercase',
		'letter-spacing'	=> '2px',
		'margin-top'		=> '1.21em',
		'margin-bottom'		=> '1.1em'
		),
	'h3' => array(
		'title'				=> esc_html__('Heading 3', 'hampton'),
		'font-family'		=> '"Nimbusromno9l", serif',
		'font-size' 		=> '2.3571em',
		'font-weight'		=> '400',
		'font-style'		=> 'normal',
		'line-height'		=> '1.23em',
		'text-decoration'	=> 'none',
		'text-transform'	=> 'none',
		'letter-spacing'	=> '-0.3px',
		'margin-top'		=> '1.58em',
		'margin-bottom'		=> '0.7em'
		),
	'h4' => array(
		'title'				=> esc_html__('Heading 4', 'hampton'),
		'font-family'		=> '"Nimbusromno9l", serif',
		'font-size' 		=> '2em',
		'font-weight'		=> '400',
		'font-style'		=> 'normal',
		'line-height'		=> '1.3043em',
		'text-decoration'	=> 'none',
		'text-transform'	=> 'none',
		'letter-spacing'	=> '0',
		'margin-top'		=> '1.165em',
		'margin-bottom'		=> '0.85em'
		),
	'h5' => array(
		'title'				=> esc_html__('Heading 5', 'hampton'),
		'font-family'		=> '"Nimbusromno9l", serif',
		'font-size' 		=> '1.4286em',
		'font-weight'		=> '400',
		'font-style'		=> 'normal',
		'line-height'		=> '1.4em',
		'text-decoration'	=> 'none',
		'text-transform'	=> 'uppercase',
		'letter-spacing'	=> '0',
		'margin-top'		=> '2.01em',
		'margin-bottom'		=> '1.3em'
		),
	'h6' => array(
		'title'				=> esc_html__('Heading 6', 'hampton'),
		'font-family'		=> '"Muli", sans-serif',
		'font-size' 		=> '0.933em',
		'font-weight'		=> '700',
		'font-style'		=> 'normal',
		'line-height'		=> '1.4706em',
		'text-decoration'	=> 'none',
		'text-transform'	=> 'uppercase',
		'letter-spacing'	=> '5px',
		'margin-top'		=> '2.9059em',
		'margin-bottom'		=> '1.67em'
		),
	'logo' => array(
		'title'				=> esc_html__('Logo text', 'hampton'),
		'description'		=> esc_html__('Font settings of the text case of the logo', 'hampton'),
		'font-family'		=> '"Muli", sans-serif',
		'font-size' 		=> '1.6em',
		'font-weight'		=> '400',
		'font-style'		=> 'normal',
		'line-height'		=> '1.25em',
		'text-decoration'	=> 'none',
		'text-transform'	=> 'uppercase',
		'letter-spacing'	=> '1px'
		),
	'button' => array(
		'title'				=> esc_html__('Buttons', 'hampton'),
		'font-family'		=> '"Muli", sans-serif',
		'font-size' 		=> '12px',
		'font-weight'		=> '400',
		'font-style'		=> 'normal',
		'line-height'		=> '1.5em',
		'text-decoration'	=> 'none',
		'text-transform'	=> 'uppercase',
		'letter-spacing'	=> '2px'
		),
	'input' => array(
		'title'				=> esc_html__('Input fields', 'hampton'),
		'description'		=> esc_html__('Font settings of the input fields, dropdowns and textareas', 'hampton'),
		'font-family'		=> '"Muli", sans-serif',
		'font-size' 		=> '1em',
		'font-weight'		=> '400',
		'font-style'		=> 'normal',
		'line-height'		=> '1.2em',
		'text-decoration'	=> 'none',
		'text-transform'	=> 'none',
		'letter-spacing'	=> ''
		),
	'info' => array(
		'title'				=> esc_html__('Post meta', 'hampton'),
		'description'		=> esc_html__('Font settings of the post meta: date, counters, share, etc.', 'hampton'),
		'font-family'		=> '"Muli", sans-serif',
		'font-size' 		=> '11px',
		'font-weight'		=> '400',
		'font-style'		=> '',
		'line-height'		=> '1.5em',
		'text-decoration'	=> 'none',
		'text-transform'	=> 'none',
		'letter-spacing'	=> '3px',
		'margin-top'		=> '1.4em',
		'margin-bottom'		=> ''
		),
	'menu' => array(
		'title'				=> esc_html__('Main menu', 'hampton'),
		'description'		=> esc_html__('Font settings of the main menu items', 'hampton'),
		'font-family'		=> '"Muli", sans-serif',
		'font-size' 		=> '15px',
		'font-weight'		=> '400',
		'font-style'		=> 'normal',
		'line-height'		=> '1.5em',
		'text-decoration'	=> 'none',
		'text-transform'	=> 'none',
		'letter-spacing'	=> '1px'
		),
	'submenu' => array(
		'title'				=> esc_html__('Dropdown menu', 'hampton'),
		'description'		=> esc_html__('Font settings of the dropdown menu items', 'hampton'),
		'font-family'		=> '"Muli", sans-serif',
		'font-size' 		=> '13px',
		'font-weight'		=> '400',
		'font-style'		=> 'normal',
		'line-height'		=> '1.5em',
		'text-decoration'	=> 'none',
		'text-transform'	=> 'none',
		'letter-spacing'	=> '1px'
		)
));


// -----------------------------------------------------------------
// -- Theme colors for customizer
// -- Attention! Inner scheme must be last in the array below
// -----------------------------------------------------------------
hampton_storage_set('schemes', array(

	// Color scheme: 'default'
	'default' => array(
		'title'	 => esc_html__('Default', 'hampton'),
		'colors' => array(
			
			// Whole block border and background
			'bg_color'				=> '#ffffff',
			'bd_color'				=> '#e2dede',

			// Text and links colors
			'text'					=> '#736968',
			'text_light'			=> '#afabaa',
			'text_dark'				=> '#3b120e',
			'text_link'				=> '#1d1d1d',
			'text_hover'			=> '#df7a25',

			// Alternative blocks (submenu, buttons, tabs, etc.)
			'alter_bg_color'		=> '#f7f7f6',
			'alter_bg_hover'		=> '#f1f1f0',
			'alter_bd_color'		=> '#3b120e',
			'alter_bd_hover'		=> '#533c3a',
			'alter_text'			=> '#9b9696',
			'alter_light'			=> '#aaa2a1',
			'alter_dark'			=> '#8d8181',
			'alter_link'			=> '#280e0c',
			'alter_hover'			=> '#c86e21',

			// Input fields (form's fields and textarea)
			'input_bg_color'		=> '#f1f5f8',
			'input_bg_hover'		=> '#f1f5f8',
			'input_bd_color'		=> '#f1f5f8',
			'input_bd_hover'		=> '#e5ecf1',
			'input_text'			=> '#726968',
			'input_light'			=> '#bac0c3',
			'input_dark'			=> '#000000',
			
			// Inverse blocks (text and links on accented bg)
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#e4e0df',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#13162b',

			// Additional accented colors (if used in the current theme)
			'accent2'				=> '#faef81'
		
		)
	),

	// Color scheme: 'dark'
	'dark' => array(
		'title'  => esc_html__('Dark', 'hampton'),
		'colors' => array(
			
			// Whole block border and background
			'bg_color'				=> '#000000',
			'bd_color'				=> '#533c3a',

			// Text and links colors
			'text'					=> '#aaa2a1',
			'text_light'			=> '#736968',
			'text_dark'				=> '#ffffff',
			'text_link'				=> '#ffffff',
			'text_hover'			=> '#df7a25',

			// Alternative blocks (submenu, buttons, tabs, etc.)
			'alter_bg_color'		=> '#2c100d',
			'alter_bg_hover'		=> '#f7f7f6',
			'alter_bd_color'		=> '#422826',
			'alter_bd_hover'		=> '#140903',
			'alter_text'			=> '#726968',
			'alter_light'			=> '#3b120e',
			'alter_dark'			=> '#aaa2a1',
			'alter_link'			=> '#280e0c',
			'alter_hover'			=> '#c86e21',

			// Input fields (form's fields and textarea)
			'input_bg_color'		=> '#0e1123',
			'input_bg_hover'		=> '#181e3d',
			'input_bd_color'		=> '#181e3d',
			'input_bd_hover'		=> '#181e3d',
			'input_text'			=> '#ffffff',
			'input_light'			=> '#b8c3cc',
			'input_dark'			=> '#ffffff',
			
			// Inverse blocks (text and links on accented bg)
			'inverse_text'			=> '#f0f0f0',
			'inverse_light'			=> '#f7f7f7',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#13162b',
		
			// Additional accented colors (if used in the current theme)
			'accent2'				=> '#ff6469'

		)
	)

));



// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if (!function_exists('hampton_options_create')) {

	function hampton_options_create() {

		hampton_storage_set('options', array(
		
			// Section 'Title & Tagline' - add theme options in the standard WP section
			'title_tagline' => array(
				"title" => esc_html__('Title, Tagline & Site icon', 'hampton'),
				"desc" => wp_kses_data( __('Specify site title and tagline (if need) and upload the site icon', 'hampton') ),
				"type" => "section"
				),
		
		
			// Section 'Header' - add theme options in the standard WP section
			'header_image' => array(
				"title" => esc_html__('Header', 'hampton'),
				"desc" => wp_kses_data( __('Select or upload logo images, select header type and widgets set for the header', 'hampton') ),
				"type" => "section"
				),
			'header_image_override' => array(
				"title" => esc_html__('Header image override', 'hampton'),
				"desc" => wp_kses_data( __("Allow override the header image with the page's/post's/product's/etc. featured image", 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'hampton')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'header_video' => array(
				"title" => esc_html__('Header video', 'hampton'),
				"desc" => wp_kses_data( __("Select video to use it as background for the header", 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'hampton')
				),
				"std" => '',
				"type" => "video"
				),
			'header_fullheight' => array(
				"title" => esc_html__('Fullheight Header', 'hampton'),
				"desc" => wp_kses_data( __("Enlarge header area to fill whole screen. Used only if header have a background image", 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'hampton')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'header_style' => array(
				"title" => esc_html__('Header style', 'hampton'),
				"desc" => wp_kses_data( __('Select style to display the site header', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'hampton')
				),
				"std" => 'header-default',
				"options" => apply_filters('hampton_filter_list_header_styles', array(
					'header-default' => esc_html__('Default Header',	'hampton')
				)),
				"type" => "select"
				),
			'header_position' => array(
				"title" => esc_html__('Header position', 'hampton'),
				"desc" => wp_kses_data( __('Select position to display the site header', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'hampton')
				),
				"std" => 'default',
				"options" => array(
					'default' => esc_html__('Default','hampton'),
					'over' => esc_html__('Over',	'hampton'),
					'under' => esc_html__('Under',	'hampton')
				),
				"type" => "select"
				),
			'header_scheme' => array(
				"title" => esc_html__('Header Color Scheme', 'hampton'),
				"desc" => wp_kses_data( __('Select color scheme to decorate header area', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'hampton')
				),
				"std" => 'inherit',
				"options" => hampton_get_list_schemes(true),
				"refresh" => false,
				"type" => "select"
				),
			'menu_style' => array(
				"title" => esc_html__('Menu position', 'hampton'),
				"desc" => wp_kses_data( __('Select position of the main menu', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'hampton')
				),
				"std" => 'top',
				"options" => array(
					'top'	=> esc_html__('Top',	'hampton'),
					'left'	=> esc_html__('Left',	'hampton'),
					'right'	=> esc_html__('Right',	'hampton')
				),
				"type" => "switch"
				),
			'menu_scheme' => array(
				"title" => esc_html__('Menu Color Scheme', 'hampton'),
				"desc" => wp_kses_data( __('Select color scheme to decorate main menu area', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'hampton')
				),
				"std" => 'inherit',
				"options" => hampton_get_list_schemes(true),
				"refresh" => false,
				"type" => "select"
				),
			'menu_stretch' => array(
				"title" => esc_html__('Stretch sidemenu', 'hampton'),
				"desc" => wp_kses_data( __('Stretch sidemenu to window height (if menu items number >= 5)', 'hampton') ),
				"std" => 1,
				"type" => "checkbox"
				),
            'socials_in_header' => array(
                "title" => esc_html__('Show social icons', 'hampton'),
                "desc" => wp_kses_data( __('Show social icons in the header ', 'hampton') ),
                "std" => 1,
                "type" => "checkbox"
            ),
            'search_display' => array(
                "title" => esc_html__('Show/Hide Search', 'hampton'),
                "desc" => wp_kses_data( __("Show or hide search in header", 'hampton') ),
                "override" => array(
                    'mode' => 'page',
                    'section' => esc_html__('Header', 'hampton')
                ),
                "std" => 0,
                "type" => "checkbox"
            ),
			'search_style' => array(
				"title" => esc_html__('Search in the header', 'hampton'),
				"desc" => wp_kses_data( __('Select style of the search field in the header', 'hampton') ),
				"std" => 'expand',
				"options" => array(
					'expand' => esc_html__('Expand', 'hampton'),
					'fullscreen' => esc_html__('Fullscreen', 'hampton')
				),
				"type" => "switch"
				),
			'header_widgets' => array(
				"title" => esc_html__('Header widgets', 'hampton'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on each page', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'hampton'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on this page', 'hampton') ),
				),
				"std" => 'hide',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			'header_columns' => array(
				"title" => esc_html__('Header columns', 'hampton'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'hampton')
				),
				"dependency" => array(
					'header_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => hampton_get_list_range(0,6),
				"type" => "select"
				),
			'header_wide' => array(
				"title" => esc_html__('Header fullwide', 'hampton'),
				"desc" => wp_kses_data( __('Do you want to stretch the header widgets area to the entire window width?', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'hampton')
				),
				"std" => 1,
				"type" => "checkbox"
				),
			'show_page_title' => array(
				"title" => esc_html__('Show Page Title', 'hampton'),
				"desc" => wp_kses_data( __('Do you want to show page title area (page/post/category title and breadcrumbs)?', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'hampton')
				),
				"std" => 1,
				"type" => "checkbox"
				),
			'show_breadcrumbs' => array(
				"title" => esc_html__('Show breadcrumbs', 'hampton'),
				"desc" => wp_kses_data( __('Do you want to show breadcrumbs in the page title area?', 'hampton') ),
				"std" => 1,
				"type" => "checkbox"
				),
            'header_full_width' => array(
                "title" => esc_html__('Header in content', 'hampton'),
                "desc" => wp_kses_data( __('Do you want header in content?', 'hampton') ),
                "std" => 1,
                "type" => "checkbox"
            ),
			'logo' => array(
				"title" => esc_html__('Logo', 'hampton'),
				"desc" => wp_kses_data( __('Select or upload site logo', 'hampton') ),
				"std" => '',
				"type" => "image"
				),
			'logo_retina' => array(
				"title" => esc_html__('Logo for Retina', 'hampton'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'hampton') ),
				"std" => '',
				"type" => "image"
				),

			'header_title_text' => array(
				"title" => esc_html__('Header title text', 'hampton'),
				"desc" => wp_kses_data( __('Put here text to insert into the Header', 'hampton') ),
				"std" => '',
				"type" => "textarea"
				),
			'mobile_layout_width' => array(
				"title" => esc_html__('Mobile layout from', 'hampton'),
				"desc" => wp_kses_data( __('Window width to show mobile layout of the header', 'hampton') ),
				"std" => 959,
				"type" => "text"
				),
			
		
		
			// Section 'Content'
			'content' => array(
				"title" => esc_html__('Content', 'hampton'),
				"desc" => wp_kses_data( __('Options for the content area', 'hampton') ),
				"type" => "section",
				),
			'body_style' => array(
				"title" => esc_html__('Body style', 'hampton'),
				"desc" => wp_kses_data( __('Select width of the body content', 'hampton') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses',
					'section' => esc_html__('Content', 'hampton')
				),
				"refresh" => false,
				"std" => 'wide',
				"options" => array(
					'boxed'		=> esc_html__('Boxed',		'hampton'),
					'wide'		=> esc_html__('Wide',		'hampton'),
					'fullwide'	=> esc_html__('Fullwide',	'hampton'),
					'fullscreen'=> esc_html__('Fullscreen',	'hampton')
				),
				"type" => "select"
				),
			'color_scheme' => array(
				"title" => esc_html__('Site Color Scheme', 'hampton'),
				"desc" => wp_kses_data( __('Select color scheme to decorate whole site. Attention! Case "Inherit" can be used only for custom pages, not for root site content in the Appearance - Customize', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'hampton')
				),
				"std" => 'default',
				"options" => hampton_get_list_schemes(true),
				"refresh" => false,
				"type" => "select"
				),
			'expand_content' => array(
				"title" => esc_html__('Expand content', 'hampton'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'hampton') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses',
					'section' => esc_html__('Content', 'hampton')
				),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),
			'remove_margins' => array(
				"title" => esc_html__('Remove margins', 'hampton'),
				"desc" => wp_kses_data( __('Remove margins above and below the content area', 'hampton') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses',
					'section' => esc_html__('Content', 'hampton')
				),
				"refresh" => false,
				"std" => 0,
				"type" => "checkbox"
				),
			'seo_snippets' => array(
				"title" => esc_html__('SEO snippets', 'hampton'),
				"desc" => wp_kses_data( __('Add structured data markup to the single posts and pages', 'hampton') ),
				"std" => 0,
				"type" => "checkbox"
				),
            'privacy_text' => array(
                "title" => esc_html__("Text with Privacy Policy link", 'hampton'),
                "desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'hampton') ),
                "std"   => wp_kses( __( 'I agree that my submitted data is being collected and stored.', 'hampton'), 'hampton_kses_content' ),
                "type"  => "text"
            ),
			'no_image' => array(
				"title" => esc_html__('No image placeholder', 'hampton'),
				"desc" => wp_kses_data( __('Select or upload image, used as placeholder for the posts without featured image', 'hampton') ),
				"std" => '',
				"type" => "image"
				),
			'sidebar_widgets' => array(
				"title" => esc_html__('Sidebar widgets', 'hampton'),
				"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'hampton') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses',
					'section' => esc_html__('Widgets', 'hampton')
				),
				"std" => 'sidebar_widgets',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			'sidebar_scheme' => array(
				"title" => esc_html__('Color Scheme', 'hampton'),
				"desc" => wp_kses_data( __('Select color scheme to decorate sidebar', 'hampton') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses',
					'section' => esc_html__('Widgets', 'hampton')
				),
				"std" => 'side',
				"options" => hampton_get_list_schemes(true),
				"refresh" => false,
				"type" => "select"
				),
			'sidebar_position' => array(
				"title" => esc_html__('Sidebar position', 'hampton'),
				"desc" => wp_kses_data( __('Select position to show sidebar', 'hampton') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses',
					'section' => esc_html__('Widgets', 'hampton')
				),
				"refresh" => false,
				"std" => 'right',
				"options" => hampton_get_list_sidebars_positions(),
				"type" => "select"
				),
			'widgets_above_page' => array(
				"title" => esc_html__('Widgets above the page', 'hampton'),
				"desc" => wp_kses_data( __('Select widgets to show above page (content and sidebar)', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Widgets', 'hampton')
				),
				"std" => 'hide',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			'widgets_above_content' => array(
				"title" => esc_html__('Widgets above the content', 'hampton'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Widgets', 'hampton')
				),
				"std" => 'hide',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			'widgets_below_content' => array(
				"title" => esc_html__('Widgets below the content', 'hampton'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Widgets', 'hampton')
				),
				"std" => 'hide',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			'widgets_below_page' => array(
				"title" => esc_html__('Widgets below the page', 'hampton'),
				"desc" => wp_kses_data( __('Select widgets to show below the page (content and sidebar)', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Widgets', 'hampton')
				),
				"std" => 'hide',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
		
		
		
			// Section 'Footer'
			'footer' => array(
				"title" => esc_html__('Footer', 'hampton'),
				"desc" => wp_kses_data( __('Select set of widgets and columns number for the site footer', 'hampton') ),
				"type" => "section"
				),
			'footer_scheme' => array(
				"title" => esc_html__('Footer Color Scheme', 'hampton'),
				"desc" => wp_kses_data( __('Select color scheme to decorate footer area', 'hampton') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses',
					'section' => esc_html__('Footer', 'hampton')
				),
				"std" => 'dark',
				"options" => hampton_get_list_schemes(true),
				"refresh" => false,
				"type" => "select"
				),
			'footer_widgets' => array(
				"title" => esc_html__('Footer widgets', 'hampton'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'hampton') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses',
					'section' => esc_html__('Footer', 'hampton')
				),
				"std" => 'footer_widgets',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			'footer_columns' => array(
				"title" => esc_html__('Footer columns', 'hampton'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'hampton') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses',
					'section' => esc_html__('Footer', 'hampton')
				),
				"dependency" => array(
					'footer_widgets' => array('^hide')
				),
				"std" => 4,
				"options" => hampton_get_list_range(0,6),
				"type" => "select"
				),
			'footer_wide' => array(
				"title" => esc_html__('Footer fullwide', 'hampton'),
				"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'hampton') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses',
					'section' => esc_html__('Footer', 'hampton')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_in_footer' => array(
				"title" => esc_html__('Show logo', 'hampton'),
				"desc" => wp_kses_data( __('Show logo in the footer', 'hampton') ),
				'refresh' => false,
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_footer' => array(
				"title" => esc_html__('Logo for footer', 'hampton'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the footer', 'hampton') ),
				"dependency" => array(
					'logo_in_footer' => array('1')
				),
				"std" => '',
				"type" => "image"
				),
			'logo_footer_retina' => array(
				"title" => esc_html__('Logo for footer (Retina)', 'hampton'),
				"desc" => wp_kses_data( __('Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'hampton') ),
				"dependency" => array(
					'logo_in_footer' => array('1')
				),
				"std" => '',
				"type" => "image"
				),
			'socials_in_footer' => array(
				"title" => esc_html__('Show social icons', 'hampton'),
				"desc" => wp_kses_data( __('Show social icons in the footer (under logo or footer widgets)', 'hampton') ),
				"std" => 0,
				"type" => "checkbox"
				),
			'copyright' => array(
				"title" => esc_html__('Copyright', 'hampton'),
				"desc" => wp_kses_data( __('Copyright text in the footer', 'hampton') ),
				"std" => esc_html__('AxiomThemes &copy; {Y}. All rights reserved. Terms of use and Privacy Policy', 'hampton'),
				"refresh" => false,
				"type" => "textarea"
				),
		
		
		
			// Section 'Homepage' - settings for home page
			'homepage' => array(
				"title" => esc_html__('Homepage', 'hampton'),
				"desc" => wp_kses_data( __('Select blog style and widgets to display on the homepage', 'hampton') ),
				"type" => "section"
				),
			'expand_content_home' => array(
				"title" => esc_html__('Expand content', 'hampton'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden on the Homepage', 'hampton') ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),
			'blog_style_home' => array(
				"title" => esc_html__('Blog style', 'hampton'),
				"desc" => wp_kses_data( __('Select posts style for the homepage', 'hampton') ),
				"std" => 'excerpt',
				"options" => hampton_get_list_blog_styles(),
				"type" => "select"
				),
			'first_post_large_home' => array(
				"title" => esc_html__('First post large', 'hampton'),
				"desc" => wp_kses_data( __('Make first post large (with Excerpt layout) on the Classic layout of the Homepage', 'hampton') ),
				"dependency" => array(
					'blog_style_home' => array('classic')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'header_widgets_home' => array(
				"title" => esc_html__('Header widgets', 'hampton'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on the homepage', 'hampton') ),
				"std" => 'header_widgets',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			'sidebar_widgets_home' => array(
				"title" => esc_html__('Sidebar widgets', 'hampton'),
				"desc" => wp_kses_data( __('Select sidebar to show on the homepage', 'hampton') ),
				"std" => 'sidebar_widgets',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			'sidebar_position_home' => array(
				"title" => esc_html__('Sidebar position', 'hampton'),
				"desc" => wp_kses_data( __('Select position to show sidebar on the homepage', 'hampton') ),
				"refresh" => false,
				"std" => 'right',
				"options" => hampton_get_list_sidebars_positions(),
				"type" => "select"
				),
			'widgets_above_page_home' => array(
				"title" => esc_html__('Widgets above the page', 'hampton'),
				"desc" => wp_kses_data( __('Select widgets to show above page (content and sidebar)', 'hampton') ),
				"std" => 'hide',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			'widgets_above_content_home' => array(
				"title" => esc_html__('Widgets above the content', 'hampton'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'hampton') ),
				"std" => 'hide',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			'widgets_below_content_home' => array(
				"title" => esc_html__('Widgets below the content', 'hampton'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'hampton') ),
				"std" => 'hide',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			'widgets_below_page_home' => array(
				"title" => esc_html__('Widgets below the page', 'hampton'),
				"desc" => wp_kses_data( __('Select widgets to show below the page (content and sidebar)', 'hampton') ),
				"std" => 'hide',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			
		
		
			// Section 'Blog archive'
			'blog' => array(
				"title" => esc_html__('Blog archive', 'hampton'),
				"desc" => wp_kses_data( __('Options for the blog archive', 'hampton') ),
				"type" => "section",
				),
			'expand_content_blog' => array(
				"title" => esc_html__('Expand content', 'hampton'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden on the blog archive', 'hampton') ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),
			'blog_style' => array(
				"title" => esc_html__('Blog style', 'hampton'),
				"desc" => wp_kses_data( __('Select posts style for the blog archive', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'hampton')
				),
				"dependency" => array(
					'#page_template' => array( 'blog.php' ),
					'.editor-page-attributes__template select' => array( 'blog.php' ),
				),
				"std" => 'excerpt',
				"options" => hampton_get_list_blog_styles(),
				"type" => "select"
				),
			'blog_columns' => array(
				"title" => esc_html__('Blog columns', 'hampton'),
				"desc" => wp_kses_data( __('How many columns should be used in the blog archive (from 2 to 4)?', 'hampton') ),
				"std" => 2,
				"options" => hampton_get_list_range(2,4),
				"type" => "hidden"
				),
			'post_type' => array(
				"title" => esc_html__('Post type', 'hampton'),
				"desc" => wp_kses_data( __('Select post type to show in the blog archive', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'hampton')
				),
				"dependency" => array(
					'#page_template' => array( 'blog.php' ),
					'.editor-page-attributes__template select' => array( 'blog.php' ),
				),
				"linked" => 'parent_cat',
				"refresh" => false,
				"hidden" => true,
				"std" => 'post',
				"options" => hampton_get_list_posts_types(),
				"type" => "select"
				),
			'parent_cat' => array(
				"title" => esc_html__('Category to show', 'hampton'),
				"desc" => wp_kses_data( __('Select category to show in the blog archive', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'hampton')
				),
				"dependency" => array(
					'#page_template' => array( 'blog.php' ),
					'.editor-page-attributes__template select' => array( 'blog.php' ),
				),
				"refresh" => false,
				"hidden" => true,
				"std" => '0',
				"options" => hampton_array_merge(array(0 => esc_html__('- Select category -', 'hampton')), hampton_get_list_categories()),
				"type" => "select"
				),
			'posts_per_page' => array(
				"title" => esc_html__('Posts per page', 'hampton'),
				"desc" => wp_kses_data( __('How many posts will be displayed on this page', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'hampton')
				),
				"dependency" => array(
					'#page_template' => array( 'blog.php' ),
					'.editor-page-attributes__template select' => array( 'blog.php' ),
				),
				"hidden" => true,
				"std" => '10',
				"type" => "text"
				),
			"blog_pagination" => array( 
				"title" => esc_html__('Pagination style', 'hampton'),
				"desc" => wp_kses_data( __('Show Older/Newest posts or Page numbers below the posts list', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'hampton')
				),
				"std" => "pages",
				"options" => array(
					'pages'	=> esc_html__("Page numbers", 'hampton'),
					'links'	=> esc_html__("Older/Newest", 'hampton'),
					'more'	=> esc_html__("Load more", 'hampton'),
					'infinite' => esc_html__("Infinite scroll", 'hampton')
				),
				"type" => "select"
				),
			'show_filters' => array(
				"title" => esc_html__('Show filters', 'hampton'),
				"desc" => wp_kses_data( __('Show categories as tabs to filter posts', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'hampton')
				),
				"dependency" => array(
					'#page_template' => array( 'blog.php' ),
					'.editor-page-attributes__template select' => array( 'blog.php' ),
					'blog_style' => array('portfolio', 'gallery')
				),
				"hidden" => true,
				"std" => 0,
				"type" => "checkbox"
				),
			'first_post_large' => array(
				"title" => esc_html__('First post large', 'hampton'),
				"desc" => wp_kses_data( __('Make first post large (with Excerpt layout) on the Classic layout of blog archive', 'hampton') ),
				"dependency" => array(
					'blog_style' => array('classic')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			"blog_content" => array( 
				"title" => esc_html__('Posts content', 'hampton'),
				"desc" => wp_kses_data( __("Show full post's content in the blog or only post's excerpt", 'hampton') ),
				"std" => "excerpt",
				"options" => array(
					'excerpt'	=> esc_html__('Excerpt',	'hampton'),
					'fullpost'	=> esc_html__('Full post',	'hampton')
				),
				"type" => "select"
				),
			'time_diff_before' => array(
				"title" => esc_html__('Time difference', 'hampton'),
				"desc" => wp_kses_data( __("How many days show time difference instead post's date", 'hampton') ),
				"std" => 5,
				"type" => "text"
				),
			'related_posts' => array(
				"title" => esc_html__('Related posts', 'hampton'),
				"desc" => wp_kses_data( __('How many related posts should be displayed in the single post?', 'hampton') ),
				"std" => 2,
				"options" => hampton_get_list_range(2,4),
				"type" => "select"
				),
			"blog_animation" => array( 
				"title" => esc_html__('Animation for posts', 'hampton'),
				"desc" => wp_kses_data( __('Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'hampton') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'hampton')
				),
				"dependency" => array(
					'#page_template' => array( 'blog.php' ),
					'.editor-page-attributes__template select' => array( 'blog.php' ),
				),
				"std" => "none",
				"options" => hampton_get_list_animations_in(),
				"type" => "select"
				),
			"animation_on_mobile" => array( 
				"title" => esc_html__('Allow animation on mobile', 'hampton'),
				"desc" => wp_kses_data( __('Allow extended animation effects on mobile devices', 'hampton') ),
				"std" => 'yes',
				"dependency" => array(
					'blog_animation' => array('^none')
				),
				"options" => hampton_get_list_yesno(),
				"type" => "switch"
				),
			'header_widgets_blog' => array(
				"title" => esc_html__('Header widgets', 'hampton'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on the blog archive', 'hampton') ),
				"std" => 'hide',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			'sidebar_widgets_blog' => array(
				"title" => esc_html__('Sidebar widgets', 'hampton'),
				"desc" => wp_kses_data( __('Select sidebar to show on the blog archive', 'hampton') ),
				"std" => 'sidebar_widgets',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			'sidebar_position_blog' => array(
				"title" => esc_html__('Sidebar position', 'hampton'),
				"desc" => wp_kses_data( __('Select position to show sidebar on the blog archive', 'hampton') ),
				"refresh" => false,
				"std" => 'right',
				"options" => hampton_get_list_sidebars_positions(),
				"type" => "select"
				),
			'widgets_above_page_blog' => array(
				"title" => esc_html__('Widgets above the page', 'hampton'),
				"desc" => wp_kses_data( __('Select widgets to show above page (content and sidebar)', 'hampton') ),
				"std" => 'hide',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			'widgets_above_content_blog' => array(
				"title" => esc_html__('Widgets above the content', 'hampton'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'hampton') ),
				"std" => 'hide',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			'widgets_below_content_blog' => array(
				"title" => esc_html__('Widgets below the content', 'hampton'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'hampton') ),
				"std" => 'hide',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			'widgets_below_page_blog' => array(
				"title" => esc_html__('Widgets below the page', 'hampton'),
				"desc" => wp_kses_data( __('Select widgets to show below the page (content and sidebar)', 'hampton') ),
				"std" => 'hide',
				"options" => array_merge(array('hide'=>esc_html__('- Select widgets -', 'hampton')), hampton_get_list_sidebars()),
				"type" => "select"
				),
			
		
		
		
			// Section 'Colors' - choose color scheme and customize separate colors from it
			'scheme' => array(
				"title" => esc_html__('* Color scheme editor', 'hampton'),
				"desc" => wp_kses_data( __("<b>Simple settings</b> - you can change only accented color, used for links, buttons and some accented areas.", 'hampton') )
						. '<br>'
						. wp_kses_data( __("<b>Advanced settings</b> - change all scheme's colors and get full control over the appearance of your site!", 'hampton') ),
				"priority" => 1000,
				"type" => "section"
				),
		
			'color_settings' => array(
				"title" => esc_html__('Color settings', 'hampton'),
				"desc" => '',
				"std" => 'simple',
				"options" => array(
					"simple"  => esc_html__("Simple", 'hampton'),
					"advanced" => esc_html__("Advanced", 'hampton')
				),
				"refresh" => false,
				"type" => "switch"
				),
		
			'color_scheme_editor' => array(
				"title" => esc_html__('Color Scheme', 'hampton'),
				"desc" => wp_kses_data( __('Select color scheme to edit colors', 'hampton') ),
				"std" => 'default',
				"options" => hampton_get_list_schemes(),
				"refresh" => false,
				"type" => "select"
				),
		
			'scheme_storage' => array(
				"title" => esc_html__('Colors storage', 'hampton'),
				"desc" => esc_html__('Hidden storage of the all color from the all color shemes (only for internal usage)', 'hampton'),
				"std" => '',
				"refresh" => false,
				"type" => "hidden"
				),
		
			'scheme_info_single' => array(
				"title" => esc_html__('Colors for single post/page', 'hampton'),
				"desc" => wp_kses_data( __('Specify colors for single post/page (not for alter blocks)', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"type" => "info"
				),
				
			'bg_color' => array(
				"title" => esc_html__('Background color', 'hampton'),
				"desc" => wp_kses_data( __('Background color of the whole page', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'bd_color' => array(
				"title" => esc_html__('Border color', 'hampton'),
				"desc" => wp_kses_data( __('Color of the bordered elements, separators, etc.', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
		
			'text' => array(
				"title" => esc_html__('Text', 'hampton'),
				"desc" => wp_kses_data( __('Plain text color on single page/post', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'text_light' => array(
				"title" => esc_html__('Light text', 'hampton'),
				"desc" => wp_kses_data( __('Color of the post meta: post date and author, comments number, etc.', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'text_dark' => array(
				"title" => esc_html__('Dark text', 'hampton'),
				"desc" => wp_kses_data( __('Color of the headers, strong text, etc.', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'text_link' => array(
				"title" => esc_html__('Links', 'hampton'),
				"desc" => wp_kses_data( __('Color of links and accented areas', 'hampton') ),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'text_hover' => array(
				"title" => esc_html__('Links hover', 'hampton'),
				"desc" => wp_kses_data( __('Hover color for links and accented areas', 'hampton') ),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
		
			'scheme_info_alter' => array(
				"title" => esc_html__('Colors for alternative blocks', 'hampton'),
				"desc" => wp_kses_data( __('Specify colors for alternative blocks - rectangular blocks with its own background color (posts in homepage, blog archive, search results, widgets on sidebar, footer, etc.)', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"type" => "info"
				),
		
			'alter_bg_color' => array(
				"title" => esc_html__('Alter background color', 'hampton'),
				"desc" => wp_kses_data( __('Background color of the alternative blocks', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'alter_bg_hover' => array(
				"title" => esc_html__('Alter hovered background color', 'hampton'),
				"desc" => wp_kses_data( __('Background color for the hovered state of the alternative blocks', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'alter_bd_color' => array(
				"title" => esc_html__('Alternative border color', 'hampton'),
				"desc" => wp_kses_data( __('Border color of the alternative blocks', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'alter_bd_hover' => array(
				"title" => esc_html__('Alternative hovered border color', 'hampton'),
				"desc" => wp_kses_data( __('Border color for the hovered state of the alter blocks', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'alter_text' => array(
				"title" => esc_html__('Alter text', 'hampton'),
				"desc" => wp_kses_data( __('Text color of the alternative blocks', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'alter_light' => array(
				"title" => esc_html__('Alter light', 'hampton'),
				"desc" => wp_kses_data( __('Color of the info blocks inside block with alternative background', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'alter_dark' => array(
				"title" => esc_html__('Alter dark', 'hampton'),
				"desc" => wp_kses_data( __('Color of the headers inside block with alternative background', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'alter_link' => array(
				"title" => esc_html__('Alter link', 'hampton'),
				"desc" => wp_kses_data( __('Color of the links inside block with alternative background', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'alter_hover' => array(
				"title" => esc_html__('Alter hover', 'hampton'),
				"desc" => wp_kses_data( __('Color of the hovered links inside block with alternative background', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
		
			'scheme_info_input' => array(
				"title" => esc_html__('Colors for the form fields', 'hampton'),
				"desc" => wp_kses_data( __('Specify colors for the form fields and textareas', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"type" => "info"
				),
		
			'input_bg_color' => array(
				"title" => esc_html__('Inactive background', 'hampton'),
				"desc" => wp_kses_data( __('Background color of the inactive form fields', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'input_bg_hover' => array(
				"title" => esc_html__('Active background', 'hampton'),
				"desc" => wp_kses_data( __('Background color of the focused form fields', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'input_bd_color' => array(
				"title" => esc_html__('Inactive border', 'hampton'),
				"desc" => wp_kses_data( __('Color of the border in the inactive form fields', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'input_bd_hover' => array(
				"title" => esc_html__('Active border', 'hampton'),
				"desc" => wp_kses_data( __('Color of the border in the focused form fields', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'input_text' => array(
				"title" => esc_html__('Inactive field', 'hampton'),
				"desc" => wp_kses_data( __('Color of the text in the inactive fields', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'input_light' => array(
				"title" => esc_html__('Disabled field', 'hampton'),
				"desc" => wp_kses_data( __('Color of the disabled field', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'input_dark' => array(
				"title" => esc_html__('Active field', 'hampton'),
				"desc" => wp_kses_data( __('Color of the active field', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
		
			'scheme_info_inverse' => array(
				"title" => esc_html__('Colors for inverse blocks', 'hampton'),
				"desc" => wp_kses_data( __('Specify colors for inverse blocks, rectangular blocks with background color equal to the links color or one of accented colors (if used in the current theme)', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"type" => "info"
				),
		
			'inverse_text' => array(
				"title" => esc_html__('Inverse text', 'hampton'),
				"desc" => wp_kses_data( __('Color of the text inside block with accented background', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'inverse_light' => array(
				"title" => esc_html__('Inverse light', 'hampton'),
				"desc" => wp_kses_data( __('Color of the info blocks inside block with accented background', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'inverse_dark' => array(
				"title" => esc_html__('Inverse dark', 'hampton'),
				"desc" => wp_kses_data( __('Color of the headers inside block with accented background', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'inverse_link' => array(
				"title" => esc_html__('Inverse link', 'hampton'),
				"desc" => wp_kses_data( __('Color of the links inside block with accented background', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'inverse_hover' => array(
				"title" => esc_html__('Inverse hover', 'hampton'),
				"desc" => wp_kses_data( __('Color of the hovered links inside block with accented background', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),

			'accent2' => array(
				"title" => esc_html__('Accent2', 'hampton'),
				"desc" => wp_kses_data( __('Color of the custom accented areas', 'hampton') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$hampton_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),


			// Section 'Hidden'
			'media_title' => array(
				"title" => esc_html__('Media title', 'hampton'),
				"desc" => wp_kses_data( __('Used as title for the audio and video item in this post', 'hampton') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Title', 'hampton')
				),
				"hidden" => true,
				"std" => '',
				"type" => "text"
				),
			'media_author' => array(
				"title" => esc_html__('Media author', 'hampton'),
				"desc" => wp_kses_data( __('Used as author name for the audio and video item in this post', 'hampton') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Title', 'hampton')
				),
				"hidden" => true,
				"std" => '',
				"type" => "text"
				),


			// Internal options.
			// Attention! Don't change any options in the section below!
			'reset_options' => array(
				"title" => '',
				"desc" => '',
				"std" => '0',
				"type" => "hidden",
				),

		));


		// Prepare panel 'Fonts'
		$fonts = array(
		
			// Panel 'Fonts' - manage fonts loading and set parameters of the base theme elements
			'fonts' => array(
				"title" => esc_html__('* Fonts settings', 'hampton'),
				"desc" => '',
				"priority" => 1500,
				"type" => "panel"
				),

			// Section 'Load_fonts'
			'load_fonts' => array(
				"title" => esc_html__('Load fonts', 'hampton'),
				"desc" => wp_kses_data( __('Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'hampton') )
						. '<br>'
						. wp_kses_data( __('<b>Attention!</b> Press "Refresh" button to reload preview area after the all fonts are changed', 'hampton') ),
				"type" => "section"
				),
			'load_fonts_subset' => array(
				"title" => esc_html__('Google fonts subsets', 'hampton'),
				"desc" => wp_kses_data( __('Specify comma separated list of the subsets which will be load from Google fonts', 'hampton') )
						. '<br>'
						. wp_kses_data( __('Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'hampton') ),
				"refresh" => false,
				"std" => '$hampton_get_load_fonts_subset',
				"type" => "text"
				)
		);

		for ($i=1; $i<=hampton_get_theme_setting('max_load_fonts'); $i++) {
			$fonts["load_fonts-{$i}-info"] = array(
				"title" => esc_html(sprintf(__('Font %s', 'hampton'), $i)),
				"desc" => '',
				"type" => "info",
				);
			$fonts["load_fonts-{$i}-name"] = array(
				"title" => esc_html__('Font name', 'hampton'),
				"desc" => '',
				"refresh" => false,
				"std" => '$hampton_get_load_fonts_option',
				"type" => "text"
				);
			$fonts["load_fonts-{$i}-family"] = array(
				"title" => esc_html__('Font family', 'hampton'),
				"desc" => $i==1 
							? wp_kses_data( __('Select font family to use it if font above is not available', 'hampton') )
							: '',
				"refresh" => false,
				"std" => '$hampton_get_load_fonts_option',
				"options" => array(
					'inherit' => esc_html__("Inherit", 'hampton'),
					'serif' => esc_html__('serif', 'hampton'),
					'sans-serif' => esc_html__('sans-serif', 'hampton'),
					'monospace' => esc_html__('monospace', 'hampton'),
					'cursive' => esc_html__('cursive', 'hampton'),
					'fantasy' => esc_html__('fantasy', 'hampton')
				),
				"type" => "select"
				);
			$fonts["load_fonts-{$i}-styles"] = array(
				"title" => esc_html__('Font styles', 'hampton'),
				"desc" => $i==1 
							? wp_kses_data( __('Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'hampton') )
											. '<br>'
								. wp_kses_data( __('<b>Attention!</b> Each weight and style increase download size! Specify only used weights and styles.', 'hampton') )
							: '',
				"refresh" => false,
				"std" => '$hampton_get_load_fonts_option',
				"type" => "text"
				);
		}
		$fonts['load_fonts_end'] = array(
			"type" => "section_end"
			);

		// Sections with font's attributes for each theme element
		$theme_fonts = hampton_get_theme_fonts();
		foreach ($theme_fonts as $tag=>$v) {
			$fonts["{$tag}_section"] = array(
				"title" => !empty($v['title']) 
								? $v['title'] 
								: esc_html(sprintf(__('%s settings', 'hampton'), $tag)),
				"desc" => !empty($v['description']) 
								? $v['description'] 
								: wp_kses_post( sprintf(__('Font settings of the "%s" tag.', 'hampton'), $tag) ),
				"type" => "section",
				);
	
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$options = '';
				$type = 'text';
				$title = ucfirst(str_replace('-', ' ', $css_prop));
				if ($css_prop == 'font-family') {
					$type = 'select';
					$options = hampton_get_list_load_fonts(true);
				} else if ($css_prop == 'font-weight') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'hampton'),
						'100' => esc_html__('100 (Light)', 'hampton'), 
						'200' => esc_html__('200 (Light)', 'hampton'), 
						'300' => esc_html__('300 (Thin)',  'hampton'),
						'400' => esc_html__('400 (Normal)', 'hampton'),
						'500' => esc_html__('500 (Semibold)', 'hampton'),
						'600' => esc_html__('600 (Semibold)', 'hampton'),
						'700' => esc_html__('700 (Bold)', 'hampton'),
						'800' => esc_html__('800 (Black)', 'hampton'),
						'900' => esc_html__('900 (Black)', 'hampton')
					);
				} else if ($css_prop == 'font-style') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'hampton'),
						'normal' => esc_html__('Normal', 'hampton'), 
						'italic' => esc_html__('Italic', 'hampton')
					);
				} else if ($css_prop == 'text-decoration') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'hampton'),
						'none' => esc_html__('None', 'hampton'), 
						'underline' => esc_html__('Underline', 'hampton'),
						'overline' => esc_html__('Overline', 'hampton'),
						'line-through' => esc_html__('Line-through', 'hampton')
					);
				} else if ($css_prop == 'text-transform') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'hampton'),
						'none' => esc_html__('None', 'hampton'), 
						'uppercase' => esc_html__('Uppercase', 'hampton'),
						'lowercase' => esc_html__('Lowercase', 'hampton'),
						'capitalize' => esc_html__('Capitalize', 'hampton')
					);
				}
				$fonts["{$tag}_{$css_prop}"] = array(
					"title" => $title,
					"desc" => '',
					"refresh" => false,
					"std" => '$hampton_get_theme_fonts_option',
					"options" => $options,
					"type" => $type
				);
			}
			
			$fonts["{$tag}_section_end"] = array(
				"type" => "section_end"
				);
		}

		$fonts['fonts_end'] = array(
			"type" => "panel_end"
			);

		// Add fonts parameters into Theme Options
		hampton_storage_merge_array('options', '', $fonts);
	}
}




// -----------------------------------------------------------------
// -- Create and manage Theme Options
// -----------------------------------------------------------------

// Theme init priorities:
// 2 - create Theme Options
if (!function_exists('hampton_options_theme_setup2')) {
	add_action( 'after_setup_theme', 'hampton_options_theme_setup2', 2 );
	function hampton_options_theme_setup2() {
		hampton_options_create();
	}
}

// Step 1: Load default settings and previously saved mods
if (!function_exists('hampton_options_theme_setup5')) {
	add_action( 'after_setup_theme', 'hampton_options_theme_setup5', 5 );
	function hampton_options_theme_setup5() {
		hampton_storage_set('options_reloaded', false);
		hampton_load_theme_options();
	}
}

// Step 2: Load current theme customization mods
if (is_customize_preview()) {
	if (!function_exists('hampton_load_custom_options')) {
		add_action( 'wp_loaded', 'hampton_load_custom_options' );
		function hampton_load_custom_options() {
			if (!hampton_storage_get('options_reloaded')) {
				hampton_storage_set('options_reloaded', true);
				hampton_load_theme_options();
			}
		}
	}
}

// Load current values for each customizable option
if ( !function_exists('hampton_load_theme_options') ) {
	function hampton_load_theme_options() {
		$options = hampton_storage_get('options');
		$reset = (int) get_theme_mod('reset_options', 0);
		foreach ($options as $k=>$v) {
			if (isset($v['std'])) {
				if (strpos($v['std'], '$hampton_')!==false) {
					$func = substr($v['std'], 1);
					if (function_exists($func)) {
						$v['std'] = $func($k);
					}
				}
				$value = $v['std'];
				if (!$reset) {
					if (isset($_GET[$k]))
						$value = stripslashes($_GET[$k]);
					else {
						$tmp = get_theme_mod($k, -987654321);
						if ($tmp != -987654321) $value = $tmp;
					}
				}
				hampton_storage_set_array2('options', $k, 'val', $value);
				if ($reset) remove_theme_mod($k);
			}
		}
		if ($reset) {
			// Unset reset flag
			set_theme_mod('reset_options', 0);
			// Regenerate CSS with default colors and fonts
			hampton_customizer_save_css();
		} else {
			do_action('hampton_action_load_options');
		}
	}
}

// Override options with stored page/post meta
if ( !function_exists('hampton_override_theme_options') ) {
	add_action( 'wp', 'hampton_override_theme_options', 1 );
	function hampton_override_theme_options($query=null) {
		if (is_page_template('blog.php')) {
			hampton_storage_set('blog_archive', true);
			hampton_storage_set('blog_template', get_the_ID());
		}
		hampton_storage_set('blog_mode', hampton_detect_blog_mode());
		if (is_singular()) {
			hampton_storage_set('options_meta', get_post_meta(get_the_ID(), 'hampton_options', true));
		}
	}
}


// Return customizable option value
if (!function_exists('hampton_get_theme_option')) {
	function hampton_get_theme_option($name, $defa='', $strict_mode=false, $post_id=0) {
		$rez = $defa;
		$from_post_meta = false;
		if ($post_id > 0) {
			if (!hampton_storage_isset('post_options_meta', $post_id))
				hampton_storage_set_array('post_options_meta', $post_id, get_post_meta($post_id, 'hampton_options', true));
			if (hampton_storage_isset('post_options_meta', $post_id, $name)) {
				$tmp = hampton_storage_get_array('post_options_meta', $post_id, $name);
				if (!hampton_is_inherit($tmp)) {
					$rez = $tmp;
					$from_post_meta = true;
				}
			}
		}
		if (!$from_post_meta && hampton_storage_isset('options')) {
			if ( !hampton_storage_isset('options', $name) ) {
				$rez = $tmp = '_not_exists_';
				if (function_exists('trx_addons_get_option'))
					$rez = trx_addons_get_option($name, $tmp, false);
				if ($rez === $tmp) {
					if ($strict_mode) {
						$s = debug_backtrace();
						$s = array_shift($s);
						echo '<pre>' . sprintf(esc_html__('Undefined option "%s" called from:', 'hampton'), $name);
						if (function_exists('dco')) dco($s);
						else print_r($s);
						echo '</pre>';
						wp_die();
					} else
						$rez = $defa;
				}
			} else {
				$blog_mode = hampton_storage_get('blog_mode');
				// Override option from GET or POST for current blog mode
				if (!empty($blog_mode) && isset($_REQUEST[$name . '_' . $blog_mode])) {
					$rez = sanitize_text_field($_REQUEST[$name . '_' . $blog_mode]);
				// Override option from GET
				} else if (isset($_REQUEST[$name])) {
					$rez = sanitize_text_field($_REQUEST[$name]);
				// Override option from current page settings (if exists)
				} else if (hampton_storage_isset('options_meta', $name) && !hampton_is_inherit(hampton_storage_get_array('options_meta', $name))) {
					$rez = hampton_storage_get_array('options_meta', $name);
				// Override option from current blog mode settings: 'home', 'search', 'page', 'post', 'blog', etc. (if exists)
				} else if (!empty($blog_mode) && hampton_storage_isset('options', $name . '_' . $blog_mode, 'val') && !hampton_is_inherit(hampton_storage_get_array('options', $name . '_' . $blog_mode, 'val'))) {
					$rez = hampton_storage_get_array('options', $name . '_' . $blog_mode, 'val');
				// Get saved option value
				} else if (hampton_storage_isset('options', $name, 'val')) {
					$rez = hampton_storage_get_array('options', $name, 'val');
				// Get ThemeREX Addons option value
				} else if (function_exists('trx_addons_get_option')) {
					$rez = trx_addons_get_option($name, $defa, false);
				}
			}
		}
		return $rez;
	}
}


// Check if customizable option exists
if (!function_exists('hampton_check_theme_option')) {
	function hampton_check_theme_option($name) {
		return hampton_storage_isset('options', $name);
	}
}

// Get dependencies list from the Theme Options
if ( !function_exists('hampton_get_theme_dependencies') ) {
	function hampton_get_theme_dependencies() {
		$options = hampton_storage_get('options');
		$depends = array();
		foreach ($options as $k=>$v) {
			if (isset($v['dependency'])) 
				$depends[$k] = $v['dependency'];
		}
		return $depends;
	}
}

// Return internal theme setting value
if (!function_exists('hampton_get_theme_setting')) {
	function hampton_get_theme_setting($name) {
		return hampton_storage_isset('settings', $name) ? hampton_storage_get_array('settings', $name) : false;
	}
}


// Set theme setting
if ( !function_exists( 'hampton_set_theme_setting' ) ) {
	function hampton_set_theme_setting($option_name, $value) {
		if (hampton_storage_isset('settings', $option_name))
			hampton_storage_set_array('settings', $option_name, $value);
	}
}
?>