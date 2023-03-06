<?php
/**
 * Generate custom CSS
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */


			
// Additional (calculated) theme-specific colors
// Attention! Don't forget setup custom colors also in the theme.customizer.color-scheme.js
if (!function_exists('hampton_customizer_add_theme_colors')) {
	function hampton_customizer_add_theme_colors($colors) {
		if (substr($colors['text'], 0, 1) == '#') {
			$colors['bg_color_0']  = hampton_hex2rgba( $colors['bg_color'], 0 );
			$colors['bg_color_02']  = hampton_hex2rgba( $colors['bg_color'], 0.2 );
			$colors['bg_color_07']  = hampton_hex2rgba( $colors['bg_color'], 0.7 );
			$colors['bg_color_08']  = hampton_hex2rgba( $colors['bg_color'], 0.8 );
			$colors['alter_bg_color_07']  = hampton_hex2rgba( $colors['alter_bg_color'], 0.7 );
			$colors['alter_bg_color_04']  = hampton_hex2rgba( $colors['alter_bg_color'], 0.4 );
			$colors['alter_bg_color_02']  = hampton_hex2rgba( $colors['alter_bg_color'], 0.2 );
			$colors['alter_bd_color_02']  = hampton_hex2rgba( $colors['alter_bd_color'], 0.2 );
			$colors['alter_bd_hover_07']  = hampton_hex2rgba( $colors['alter_bd_hover'], 0.7 );
			$colors['text_dark_07']  = hampton_hex2rgba( $colors['text_dark'], 0.7 );
			$colors['text_link_02']  = hampton_hex2rgba( $colors['text_link'], 0.2 );
			$colors['text_link_07']  = hampton_hex2rgba( $colors['text_link'], 0.7 );
			$colors['text_hover_07']  = hampton_hex2rgba( $colors['text_hover'], 0.7 );
			$colors['inverse_text_015']  = hampton_hex2rgba( $colors['inverse_text'], 0.15 );
		} else {
			$colors['bg_color_0'] = '{{ data.bg_color_0 }}';
			$colors['bg_color_02'] = '{{ data.bg_color_02 }}';
			$colors['bg_color_07'] = '{{ data.bg_color_07 }}';
			$colors['bg_color_08'] = '{{ data.bg_color_08 }}';
			$colors['alter_bg_color_07'] = '{{ data.alter_bg_color_07 }}';
			$colors['alter_bg_color_04'] = '{{ data.alter_bg_color_04 }}';
			$colors['alter_bg_color_02'] = '{{ data.alter_bg_color_02 }}';
			$colors['alter_bd_color_02'] = '{{ data.alter_bd_color_02 }}';
			$colors['alter_bd_hover_07'] = '{{ data.alter_bd_hover_07 }}';
			$colors['text_dark_07'] = '{{ data.text_dark_07 }}';
			$colors['text_link_02'] = '{{ data.text_link_02 }}';
			$colors['text_link_07'] = '{{ data.text_link_07 }}';
			$colors['text_hover_07'] = '{{ data.text_hover_07 }}';
			$colors['inverse_text_015'] = '{{ data.inverse_text_015 }}';
		}
		return $colors;
	}
}


			
// Additional theme-specific fonts rules
// Attention! Don't forget setup fonts rules also in the theme.customizer.color-scheme.js
if (!function_exists('hampton_customizer_add_theme_fonts')) {
	function hampton_customizer_add_theme_fonts($fonts) {
		$rez = array();	
		foreach ($fonts as $tag => $font) {
			if (substr($font['font-family'], 0, 2) != '{{') {
				$rez[$tag.'_font-family'] 		= !empty($font['font-family']) && !hampton_is_inherit($font['font-family'])
														? 'font-family:' . trim($font['font-family']) . ';' 
														: '';
				$rez[$tag.'_font-size'] 		= !empty($font['font-size']) && !hampton_is_inherit($font['font-size'])
														? 'font-size:' . hampton_prepare_css_value($font['font-size']) . ";"
														: '';
				$rez[$tag.'_line-height'] 		= !empty($font['line-height']) && !hampton_is_inherit($font['line-height'])
														? 'line-height:' . trim($font['line-height']) . ";"
														: '';
				$rez[$tag.'_font-weight'] 		= !empty($font['font-weight']) && !hampton_is_inherit($font['font-weight'])
														? 'font-weight:' . trim($font['font-weight']) . ";"
														: '';
				$rez[$tag.'_font-style'] 		= !empty($font['font-style']) && !hampton_is_inherit($font['font-style'])
														? 'font-style:' . trim($font['font-style']) . ";"
														: '';
				$rez[$tag.'_text-decoration'] 	= !empty($font['text-decoration']) && !hampton_is_inherit($font['text-decoration'])
														? 'text-decoration:' . trim($font['text-decoration']) . ";"
														: '';
				$rez[$tag.'_text-transform'] 	= !empty($font['text-transform']) && !hampton_is_inherit($font['text-transform'])
														? 'text-transform:' . trim($font['text-transform']) . ";"
														: '';
				$rez[$tag.'_letter-spacing'] 	= !empty($font['letter-spacing']) && !hampton_is_inherit($font['letter-spacing'])
														? 'letter-spacing:' . trim($font['letter-spacing']) . ";"
														: '';
				$rez[$tag.'_margin-top'] 		= !empty($font['margin-top']) && !hampton_is_inherit($font['margin-top'])
														? 'margin-top:' . hampton_prepare_css_value($font['margin-top']) . ";"
														: '';
				$rez[$tag.'_margin-bottom'] 	= !empty($font['margin-bottom']) && !hampton_is_inherit($font['margin-bottom'])
														? 'margin-bottom:' . hampton_prepare_css_value($font['margin-bottom']) . ";"
														: '';
			} else {
				$rez[$tag.'_font-family']		= '{{ data["'.$tag.'_font-family"] }}';
				$rez[$tag.'_font-size']			= '{{ data["'.$tag.'_font-size"] }}';
				$rez[$tag.'_line-height']		= '{{ data["'.$tag.'_line-height"] }}';
				$rez[$tag.'_font-weight']		= '{{ data["'.$tag.'_font-weight"] }}';
				$rez[$tag.'_font-style']		= '{{ data["'.$tag.'_font-style"] }}';
				$rez[$tag.'_text-decoration']	= '{{ data["'.$tag.'_text-decoration"] }}';
				$rez[$tag.'_text-transform']	= '{{ data["'.$tag.'_text-transform"] }}';
				$rez[$tag.'_letter-spacing']	= '{{ data["'.$tag.'_letter-spacing"] }}';
				$rez[$tag.'_margin-top']		= '{{ data["'.$tag.'_margin-top"] }}';
				$rez[$tag.'_margin-bottom']		= '{{ data["'.$tag.'_margin-bottom"] }}';
			}
		}
		return $rez;
	}
}


// Return CSS with custom colors and fonts
if (!function_exists('hampton_customizer_get_css')) {

	function hampton_customizer_get_css($colors=null, $fonts=null, $minify=true, $only_scheme='') {

		$css = array(
			'fonts' => '',
			'colors' => ''
		);
		
		// Prepare fonts
		if ($fonts === null) {
			$fonts = hampton_get_theme_fonts();
		}
		
		if ($fonts) {

			// Make theme-specific fonts rules
			$fonts = hampton_customizer_add_theme_fonts($fonts);

			$rez = array();
			$rez['fonts'] = <<<CSS

body {
	{$fonts['p_font-family']}
	{$fonts['p_font-size']}
	{$fonts['p_font-weight']}
	{$fonts['p_font-style']}
	{$fonts['p_line-height']}
	{$fonts['p_text-decoration']}
	{$fonts['p_text-transform']}
	{$fonts['p_letter-spacing']}
}
p, ul, ol, dl, blockquote, address {
	{$fonts['p_margin-top']}
	{$fonts['p_margin-bottom']}
}

h1 {
	{$fonts['h1_font-family']}
	{$fonts['h1_font-size']}
	{$fonts['h1_font-weight']}
	{$fonts['h1_font-style']}
	{$fonts['h1_line-height']}
	{$fonts['h1_text-decoration']}
	{$fonts['h1_text-transform']}
	{$fonts['h1_letter-spacing']}
	{$fonts['h1_margin-top']}
	{$fonts['h1_margin-bottom']}
}
h2 {
	{$fonts['h2_font-family']}
	{$fonts['h2_font-size']}
	{$fonts['h2_font-weight']}
	{$fonts['h2_font-style']}
	{$fonts['h2_line-height']}
	{$fonts['h2_text-decoration']}
	{$fonts['h2_text-transform']}
	{$fonts['h2_letter-spacing']}
	{$fonts['h2_margin-top']}
	{$fonts['h2_margin-bottom']}
}
h3 {
	{$fonts['h3_font-family']}
	{$fonts['h3_font-size']}
	{$fonts['h3_font-weight']}
	{$fonts['h3_font-style']}
	{$fonts['h3_line-height']}
	{$fonts['h3_text-decoration']}
	{$fonts['h3_text-transform']}
	{$fonts['h3_letter-spacing']}
	{$fonts['h3_margin-top']}
	{$fonts['h3_margin-bottom']}
}
h4 {
	{$fonts['h4_font-family']}
	{$fonts['h4_font-size']}
	{$fonts['h4_font-weight']}
	{$fonts['h4_font-style']}
	{$fonts['h4_line-height']}
	{$fonts['h4_text-decoration']}
	{$fonts['h4_text-transform']}
	{$fonts['h4_letter-spacing']}
	{$fonts['h4_margin-top']}
	{$fonts['h4_margin-bottom']}
}
h5 {
	{$fonts['h5_font-family']}
	{$fonts['h5_font-size']}
	{$fonts['h5_font-weight']}
	{$fonts['h5_font-style']}
	{$fonts['h5_line-height']}
	{$fonts['h5_text-decoration']}
	{$fonts['h5_text-transform']}
	{$fonts['h5_letter-spacing']}
	{$fonts['h5_margin-top']}
	{$fonts['h5_margin-bottom']}
}
h6 {
	{$fonts['h6_font-family']}
	{$fonts['h6_font-size']}
	{$fonts['h6_font-weight']}
	{$fonts['h6_font-style']}
	{$fonts['h6_line-height']}
	{$fonts['h6_text-decoration']}
	{$fonts['h6_text-transform']}
	{$fonts['h6_letter-spacing']}
	{$fonts['h6_margin-top']}
	{$fonts['h6_margin-bottom']}
}

input[type="text"],
input[type="number"],
input[type="email"],
input[type="tel"],
input[type="search"],
input[type="password"],
textarea,
textarea.wp-editor-area,
.select_container,
select,
.select_container select {
	{$fonts['input_font-family']}
	{$fonts['input_font-size']}
	{$fonts['input_font-weight']}
	{$fonts['input_font-style']}
	{$fonts['input_line-height']}
	{$fonts['input_text-decoration']}
	{$fonts['input_text-transform']}
	{$fonts['input_letter-spacing']}
}

button,
input[type="button"],
input[type="reset"],
input[type="submit"],
.theme_button,
.gallery_preview_show .post_readmore,
.more-link {
	{$fonts['button_font-family']}
	{$fonts['button_font-size']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_line-height']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}

.top_panel .slider_engine_revo .slide_title {
	{$fonts['h1_font-family']}
}
.hampton_tabs .hampton_tabs_titles li a{
{$fonts['button_font-family']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_text-decoration']}
}
blockquote,
mark, ins,
.logo_text,
.post_price.price,
.theme_scroll_down, .top_panel_custom_text span:last-child {
	{$fonts['h5_font-family']}
}

.post_meta {
	{$fonts['info_font-family']}
	{$fonts['info_font-size']}
	{$fonts['info_font-weight']}
	{$fonts['info_font-style']}
	{$fonts['info_line-height']}
	{$fonts['info_text-decoration']}
	{$fonts['info_text-transform']}
	{$fonts['info_letter-spacing']}
	{$fonts['info_margin-top']}
	{$fonts['info_margin-bottom']}
}

em, i,
.post-date, .rss-date 
.post_date, .post_meta_item, .post_counters_item,
.comments_list_wrap .comment_date,
.comments_list_wrap .comment_time,
.comments_list_wrap .comment_counters,
.top_panel .slider_engine_revo .slide_subtitle,
.logo_slogan,
fieldset legend,
figure figcaption,
.wp-caption .wp-caption-text,
.wp-caption .wp-caption-dd,
.wp-caption-overlay .wp-caption .wp-caption-text,
.wp-caption-overlay .wp-caption .wp-caption-dd,
.blocks-gallery-grid .blocks-gallery-image figcaption, 
.blocks-gallery-grid .blocks-gallery-item figcaption, 
.wp-block-gallery .blocks-gallery-image figcaption, 
.wp-block-gallery .blocks-gallery-item figcaption,
.format-audio .post_featured .post_audio_author,
.post_item_single .post_content .post_meta,
.author_bio .author_link,
.comments_list_wrap .comment_posted,
.comments_list_wrap .comment_reply {
	{$fonts['info_font-family']}
}
.search_wrap .post_meta_item,
.search_wrap .post_counters_item{
	{$fonts['p_font-family']}
}

.logo_text {
	{$fonts['logo_font-family']}
	{$fonts['logo_font-size']}
	{$fonts['logo_font-weight']}
	{$fonts['logo_font-style']}
	{$fonts['logo_line-height']}
	{$fonts['logo_text-decoration']}
	{$fonts['logo_text-transform']}
	{$fonts['logo_letter-spacing']}
}
.logo_footer_text {
	{$fonts['logo_font-family']}
}

.menu_main_nav_area {
	{$fonts['menu_font-size']}
	{$fonts['menu_line-height']}
}
.menu_main_nav > li,
.menu_main_nav > li > a {
	{$fonts['menu_font-family']}
	{$fonts['menu_font-weight']}
	{$fonts['menu_font-style']}
	{$fonts['menu_text-decoration']}
	{$fonts['menu_text-transform']}
	{$fonts['menu_letter-spacing']}
}
.menu_mobile .menu_mobile_nav_area > ul > li,
.menu_mobile .menu_mobile_nav_area > ul > li > a {
	{$fonts['menu_font-family']}
}

.menu_main_nav > li li,
.menu_main_nav > li li > a {
	{$fonts['submenu_font-family']}
	{$fonts['submenu_font-size']}
	{$fonts['submenu_font-weight']}
	{$fonts['submenu_font-style']}
	{$fonts['submenu_line-height']}
	{$fonts['submenu_text-decoration']}
	{$fonts['submenu_text-transform']}
	{$fonts['submenu_letter-spacing']}
}
.menu_mobile .menu_mobile_nav_area > ul > li li,
.menu_mobile .menu_mobile_nav_area > ul > li li > a {
	{$fonts['submenu_font-family']}
}

CSS;
			$rez = apply_filters('hampton_filter_get_css', $rez, false, $fonts, false);
			$css['fonts'] = $rez['fonts'];
		}

		if ($colors !== false) {
			$schemes = empty($only_scheme) ? array_keys(hampton_get_list_schemes()) : array($only_scheme);
	
			if (count($schemes) > 0) {
				$rez = array();
				foreach ($schemes as $scheme) {
					// Prepare colors
					if (empty($only_scheme)) $colors = hampton_get_scheme_colors($scheme);
	
					// Make theme-specific colors and tints
					$colors = hampton_customizer_add_theme_colors($colors);
			
					// Make styles
					$rez['colors'] = <<<CSS

/* Common tags */

body.custom-background.blog_mode_  {
	background: {$colors['bg_color']}!important;
}


h1, h2, h3, h4, h5, h6,
h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,
li a {
	color: {$colors['text_dark']};
}
h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover,
li a:hover {
	color: {$colors['text_link']};
}

dt, b, strong, i, em, mark, ins {	
	color: {$colors['text_dark']};
}
s, strike, del {	
	color: {$colors['text_light']};
}

a {
	color: {$colors['text_link']};
}
a:hover {
	color: {$colors['text_hover']};
}

blockquote {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};
}
blockquote:before {
	color: {$colors['alter_bg_hover']}!important;
}
blockquote a {
	color: {$colors['bg_color']};
}
blockquote a:hover {
	color: {$colors['text_link']};
}

table th, table th + th, table td + th  {
	border-color: {$colors['bg_color_02']};
}
table td, table th + td, table:not(.booked-calendar) td + td {
	color: {$colors['alter_dark']};
	border-color: {$colors['bg_color']};
}

table thead th,
table tbody th {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};
}

table > tbody > tr:nth-child(2n+1) > td {
	background-color: {$colors['alter_bg_color_04']};
}

table > tbody > tr:nth-child(2n) > td {
	background-color: {$colors['alter_bg_color']};
}
table > tr:first-child > td{
    background-color: {$colors['alter_bd_color']};
    color: {$colors['inverse_text']};
    border-color: {$colors['alter_bd_hover']};
}

table th a { color: {$colors['bg_color']};}

table th a:hover {
	color: {$colors['text_hover']};
}

hr {
	border-color: {$colors['bd_color']};
}
figure figcaption,
.wp-caption .wp-caption-text,
.wp-caption .wp-caption-dd,
.wp-caption-overlay .wp-caption .wp-caption-text,
.wp-caption-overlay .wp-caption .wp-caption-dd,
.blocks-gallery-grid .blocks-gallery-image figcaption, 
.blocks-gallery-grid .blocks-gallery-item figcaption, 
.wp-block-gallery .blocks-gallery-image figcaption, 
.wp-block-gallery .blocks-gallery-item figcaption {
	color: {$colors['text_light']}!important;
	background: {$colors['alter_bg_color']}!important;
}
ul > li:before {
	color: {$colors['text_link']};
}


/* Form fields */
button[disabled],
input[type="submit"][disabled],
input[type="button"][disabled],
form.wpcf7-form input[type="submit"][disabled],
form.wpcf7-form input[type="submit"][disabled]:hover,
.comments_wrap .form-submit input[type="submit"][disabled],
.comments_wrap .form-submit input[type="submit"][disabled]:hover {
    background-color: {$colors['text_light']} !important;
    color: {$colors['text']} !important;
}
fieldset {
	border-color: {$colors['bd_color']};
}
fieldset legend {
	color: {$colors['text_dark']};
	background-color: {$colors['bg_color']};
}
input[type="search"],
input[type="text"],
input[type="number"],
input[type="email"],
input[type="tel"],
input[type="password"],
.widget_search form,
.select_container,
.select_container:before,
.select2-container .select2-choice,
textarea,
textarea.wp-editor-area {
	color: {$colors['input_light']};
	border-color: {$colors['input_bd_color']};
	background-color: {$colors['input_bg_color']};
}
aside input[type="search"]{
    background-color: {$colors['inverse_text']};
    border-color: {$colors['inverse_text']};
}
input::-webkit-input-placeholder {color:{$colors['input_light']};}
input::-moz-placeholder          {color:{$colors['input_light']};}/* Firefox 19+ */
input:-moz-placeholder           {color:{$colors['input_light']};}/* Firefox 18- */
input:-ms-input-placeholder      {color:{$colors['input_light']};}
.select_container select {
	color: {$colors['input_light']};
}
input[type="text"]:focus,
input[type="number"]:focus,
input[type="email"]:focus,
input[type="tel"]:focus,
input[type="search"]:focus,
input[type="password"]:focus,
.select_container:hover,
.select_container:before:hover,
select option:hover,
select option:focus,
.select2-container .select2-choice:hover,
textarea:focus,
textarea.wp-editor-area:focus {
	color: {$colors['input_dark']};
	border-color: {$colors['input_bd_hover']};
	background-color: {$colors['input_bg_hover']};
}
input[type="checkbox"]:checked + label:before, 
input[type="checkbox"]:checked + span:before {
	color: {$colors['text_hover']};
}
.select_container select:focus {
	color: {$colors['alter_link']};
	border-color: {$colors['input_bd_hover']};
}
.select_container:after {
	color: {$colors['input_light']};
}
.select_container:hover:after {
	color: {$colors['input_dark']};
}
.widget_search form:hover:after,
.wp-block-search.wp-block-search__button-inside .wp-block-search__button.has-icon:hover:before {
	color: {$colors['input_dark']};
}
.widget_search form:after,
.wp-block-search.wp-block-search__button-inside .wp-block-search__button.has-icon:before{
    color: {$colors['input_text']};
}

.footer_wrap .widget_search form:after{
	color: {$colors['alter_dark']};
}
.footer_wrap .widget_search form:hover:after{
	color: {$colors['text_hover']};
}

.footer_wrap h1 a[href*="tel:"]:hover,
.footer_wrap h2 a[href*="tel:"]:hover,
.footer_wrap h3 a[href*="tel:"]:hover,
.footer_wrap h4 a[href*="tel:"]:hover,
.footer_wrap h5 a[href*="tel:"]:hover,
.footer_wrap h6 a[href*="tel:"]:hover{
	color: {$colors['text_hover']} !important;
}

input::-webkit-input-placeholder,
textarea::-webkit-input-placeholder {
	color: {$colors['input_text']};
}
input[type="radio"] + label:before,
input[type="checkbox"] + label:before,
 input[type="checkbox"] + span:before{
	border-color: {$colors['input_bd_color']};
	background-color: {$colors['input_bg_color']};
}
button,
input[type="reset"],
input[type="submit"],
input[type="button"] {
	background-color: {$colors['text_link']};
	color: {$colors['inverse_text']};
}
input[type="submit"]:hover,
input[type="reset"]:hover,
input[type="button"]:hover,
button:hover,
input[type="submit"]:focus,
input[type="reset"]:focus,
input[type="button"]:focus,
button:focus {
	background-color: {$colors['text_dark']};
	color: {$colors['bg_color']};
}
.wp-editor-container input[type="button"] {
	background-color: {$colors['alter_bg_color']};
	border-color: {$colors['alter_bd_color']};
	color: {$colors['alter_dark']};
	-webkit-box-shadow: 0 1px 0 0 {$colors['alter_bd_hover']};
	   -moz-box-shadow: 0 1px 0 0 {$colors['alter_bd_hover']};
			box-shadow: 0 1px 0 0 {$colors['alter_bd_hover']};	
}
.wp-editor-container input[type="button"]:hover,
.wp-editor-container input[type="button"]:focus {
	background-color: {$colors['alter_bg_hover']};
	border-color: {$colors['alter_bd_hover']};
	color: {$colors['alter_link']};
}

.select2-results {
	color: {$colors['input_text']};
	border-color: {$colors['input_bd_hover']};
	background: {$colors['input_bg_color']};
}
.select2-results .select2-highlighted {
	color: {$colors['input_dark']};
	background: {$colors['input_bg_hover']};
}


/* WP Standard classes */
.sticky {
	border-color: {$colors['bd_color']};
}
.sticky .label_sticky {
	border-top-color: {$colors['text_link']};
}
	

/* Page */
body {
	color: {$colors['text']};
	background-color: {$colors['bg_color']};
}
#page_preloader,
.scheme_self.header_position_under .page_content_wrap,
.page_wrap {
	background-color: {$colors['bg_color']};
}
.preloader_wrap > div {
	background-color: {$colors['text_link']};
}

/* Header */
.scheme_self.top_panel.with_bg_image:before {
	background-color: {$colors['bg_color_07']};
}
.top_panel .slider_engine_revo .slide_subtitle {
	color: {$colors['text_link']};
}

/* Logo */
.logo b {
	color: {$colors['text_dark']};
}
.logo i {
	color: {$colors['text_link']};
}
.logo_text {
	color: {$colors['text_link']};
}
.logo:hover .logo_text {
	color: {$colors['text_dark']};
}
.logo_slogan {
	color: {$colors['text']};
}

/* Social items */
.socials_wrap .social_item a,
.socials_wrap .social_item a i {
	color: {$colors['text_dark']};
}
.socials_wrap .social_item a:hover,
.socials_wrap .social_item a:hover i {
	color: {$colors['text_dark']};
	border-color: {$colors['text_hover']};
}
.socials_wrap .social_item a{
    border-color: {$colors['bd_color']};
}

/* Custom text in header */
.top_panel_custom_text{
	background-color: {$colors['text_hover']};
}
.top_panel_custom_text span, .top_panel_custom_text span + span{
	color: {$colors['inverse_text']};
}


/* Search */
.search_wrap .search_field {
	color: {$colors['text']};
}
.search_wrap .search_field:focus {
	color: {$colors['text_dark']};
}
.search_wrap .search_submit {
	color: {$colors['text_dark']};
}
.search_wrap .search_submit:hover,
.search_wrap .search_submit:focus {
	color: {$colors['text']};
}

.post_item_none_search .search_wrap .search_submit:hover, .post_item_none_search .search_wrap .search_submit:focus,
.post_item_none_archive .search_wrap .search_submit:hover, .post_item_none_archive .search_wrap .search_submit:focus {
	color: {$colors['text_link']};
	background-color: transparent;
}

.wp-block-search input[type="search"] {
	border-color: {$colors['input_bd_color']};
}
.wp-block-search input[type="search"]:focus {
	border-color: {$colors['input_bd_hover']};
}

/* Search style 'Expand' */
.search_style_expand.search_opened {
	background-color: {$colors['bg_color']};
	border-color: {$colors['bd_color']};
}
.search_style_expand.search_opened .search_submit {
	color: {$colors['text']};
}
.search_style_expand .search_submit:hover,
.search_style_expand .search_submit:focus {
	color: {$colors['text_dark']};
}

/* Search style 'Fullscreen' */
.search_style_fullscreen.search_opened .search_form_wrap {
	background-color: {$colors['bg_color_08']};
}
.search_style_fullscreen.search_opened .search_form {
	border-color: {$colors['text_dark']};
}
.search_style_fullscreen.search_opened .search_close,
.search_style_fullscreen.search_opened .search_field,
.search_style_fullscreen.search_opened .search_submit {
	color: {$colors['input_dark']};
}
.search_style_fullscreen.search_opened .search_close:hover,
.search_style_fullscreen.search_opened .search_field:hover,
.search_style_fullscreen.search_opened .search_field:focus,
.search_style_fullscreen.search_opened .search_submit:hover,
.search_style_fullscreen.search_opened .search_submit:focus {
	color: {$colors['input_text']};
}
.search_style_fullscreen.search_opened input::-webkit-input-placeholder {color:{$colors['input_light']}; opacity: 1;}
.search_style_fullscreen.search_opened input::-moz-placeholder          {color:{$colors['input_light']}; opacity: 1;}/* Firefox 19+ */
.search_style_fullscreen.search_opened input:-moz-placeholder           {color:{$colors['input_light']}; opacity: 1;}/* Firefox 18- */
.search_style_fullscreen.search_opened input:-ms-input-placeholder      {color:{$colors['input_light']}; opacity: 1;}

/* Search results */
.search_wrap .search_results {
	background-color: {$colors['bg_color']};
	border-color: {$colors['bd_color']};
}
.search_wrap .search_results:after {
	background-color: {$colors['bg_color']};
	border-left-color: {$colors['bd_color']};
	border-top-color: {$colors['bd_color']};
}
.search_wrap .search_results .search_results_close {
	color: {$colors['text_light']};
}
.search_wrap .search_results .search_results_close:hover {
	color: {$colors['text_dark']};
}
.search_results.widget_area .post_item + .post_item {
	border-top-color: {$colors['bd_color']};
}


/* Main menu */
.menu_main_nav > li > a {
	color: {$colors['text_dark']};
}
.menu_main_nav > li > a:hover,
.menu_main_nav > li.sfHover > a,
.menu_main_nav > li.current-menu-item > a,
.menu_main_nav > li.current-menu-parent > a,
.menu_main_nav > li.current-menu-ancestor > a {
	color: {$colors['text_link']};
	border-color: {$colors['bd_color']};
}

/* Submenu */
.menu_main_nav > li ul {
	background-color: {$colors['text_dark']};
}
.menu_main_nav > li li > a {
	color: {$colors['inverse_text']};
}
.menu_main_nav > li li > a:hover,
.menu_main_nav > li li.sfHover > a {
	color: {$colors['text_hover']};
}
.menu_main_nav > li li.current-menu-item > a,
.menu_main_nav > li li.current-menu-parent > a,
.menu_main_nav > li li.current-menu-ancestor > a {
	color: {$colors['text_hover']};
}
.menu_main_nav > li li[class*="icon-"]:before {
	color: {$colors['inverse_link']};
}
.menu_main_nav > li li[class*="icon-"]:hover:before,
.menu_main_nav > li li[class*="icon-"].shHover:before,
.menu_main_nav > li li.current-menu-item:before,
.menu_main_nav > li li.current-menu-parent:before,
.menu_main_nav > li li.current-menu-ancestor:before {
	color: {$colors['inverse_hover']};
}
.top_panel_navi.state_fixed .menu_main_wrap {
	background-color: {$colors['bg_color']};
}

/* Mobile menu */
.scheme_self.menu_side_wrap .menu_side_button {
	color: {$colors['alter_dark']};
	border-color: {$colors['alter_bd_color']};
	background-color: {$colors['alter_bg_color_07']};
}
.scheme_self.menu_side_wrap .menu_side_button:hover {
	color: {$colors['inverse_text']};
	border-color: {$colors['alter_hover']};
	background-color: {$colors['alter_link']};
}
.menu_side_inner,
.menu_mobile_inner {
	color: {$colors['alter_text']};
	background-color: {$colors['alter_bg_color']};
}
.menu_mobile_button {
	color: {$colors['text_dark']};
}
.menu_mobile_button:hover {
	color: {$colors['text_link']};
}
.menu_mobile_close:before,
.menu_mobile_close:after {
	border-color: {$colors['alter_dark']};
}
.menu_mobile_close:hover:before,
.menu_mobile_close:hover:after {
	border-color: {$colors['inverse_dark']};
}
.menu_mobile_inner a {
	color: {$colors['alter_dark']};
}
.menu_mobile_inner a:hover,
.menu_mobile_inner .current-menu-ancestor > a,
.menu_mobile_inner .current-menu-item > a {
	color: {$colors['inverse_dark']};
}
.menu_mobile_inner .search_mobile .search_submit {
	color: {$colors['input_light']};
}

.menu_mobile_inner .search_mobile .search_submit:focus,
.menu_mobile_inner .search_mobile .search_submit:hover {
	color: {$colors['input_dark']};
}

.menu_mobile_inner .social_item a {
	color: {$colors['inverse_dark']};
}
.menu_mobile_inner .social_item a:hover {
	color: {$colors['alter_dark']};
}

/* Page title and breadcrumbs */
.top_panel_title_wrap{
	background-color: {$colors['alter_bg_color']};
}
.top_panel_title .post_meta {
	color: {$colors['text']};
}
.breadcrumbs {
	color: {$colors['text']};
}
.breadcrumbs a {
	color: {$colors['alter_text']};
}
.breadcrumbs a:hover {
	color: {$colors['text_dark']};
}
.breadcrumbs .breadcrumbs_delimiter, .breadcrumbs .breadcrumbs_item{
	color: {$colors['alter_text']};
}


/* Tabs */
.hampton_tabs .hampton_tabs_titles li a {
	color: {$colors['text_dark']};
	background-color: {$colors['alter_bg_color']};
}
.hampton_tabs .hampton_tabs_titles li a:hover {
	color: {$colors['inverse_text']};
	background-color: {$colors['text_hover']};
}
.hampton_tabs .hampton_tabs_titles li.ui-state-active a {
	color: {$colors['bg_color']};
	background-color: {$colors['text_hover']};
}

/* Post layouts */
.post_item {
	color: {$colors['text']};
}
.post_meta,
.post_meta_item,
.post_meta_item a,
.post_meta_item:before,
.post_meta_item:hover:before,
.post_date a,
.post_date:before,
.post_info .post_info_item,
.post_info .post_info_item a,
.post_info_counters .post_counters_item,
.post_counters .socials_share .socials_caption:before,
.post_counters .socials_share .socials_caption:hover:before {
	color: {$colors['text_light']};
}
.post_date a:hover,
a.post_meta_item:hover,
.post_meta_item a:hover,
.post_info .post_info_item a:hover,
.post_info_counters .post_counters_item:hover {
	color: {$colors['text_dark']};
}

.post_item .post_title a:hover,
.post_item .post_title a:hover *{
	color: {$colors['text_hover']};
}

.post_meta_item.post_categories,
.post_meta_item.post_categories a {
	color: {$colors['text_link']};
}
.post_meta_item.post_categories a:hover {
	color: {$colors['text_hover']};
}

.post_meta_item .socials_share .social_items {
	background-color: {$colors['bg_color']};
}
.post_meta_item .social_items,
.post_meta_item .social_items:before {
	background-color: {$colors['bg_color']};
	border-color: {$colors['bd_color']};
	color: {$colors['text_light']};
}

.post_layout_excerpt + .post_layout_excerpt {
	border-color: {$colors['bd_color']};
}
.post_layout_classic {
	border-color: {$colors['bd_color']};
}

.scheme_self.gallery_preview:before {
	background-color: {$colors['bg_color']};
}
.scheme_self.gallery_preview {
	color: {$colors['text']};
}

.post_featured:after {
	background-color: {$colors['bg_color']};
}

/* Post Formats */
.format-audio .post_featured .post_audio_author {
	color: {$colors['text_hover']};
}
.format-audio .post_featured.without_thumb .post_audio {
	border-color: {$colors['bd_color']};
	background: {$colors['alter_bd_color']};
}
.format-audio .mejs-controls .mejs-time-rail .mejs-time-current{
    background-color: {$colors['inverse_text']};
}
.format-audio .post_featured.without_thumb .post_audio_title,
.without_thumb .mejs-controls .mejs-currenttime,
.without_thumb .mejs-controls .mejs-duration {
	color: {$colors['inverse_text']};
}
.format-audio .post_featured.with_thumb .mejs-controls, .format-audio .post_featured > div > .mejs-container{
    background: {$colors['text_hover']};
}
.mejs-controls .mejs-button,
.mejs-controls .mejs-time-rail .mejs-time-current,
.mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current {
	color: {$colors['inverse_text']};
}
.mejs-controls .mejs-button:hover {
	color: {$colors['bg_color']};
}
.mejs-controls .mejs-time-rail .mejs-time-total,
.mejs-controls .mejs-time-rail .mejs-time-loaded,
.mejs-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total {
	background: {$colors['bg_color_02']};
}

.post_format_audio .mejs-controls .mejs-time-rail .mejs-time-total{
    background: {$colors['inverse_text']};
}

.format-aside .post_content_inner {
	color: {$colors['alter_dark']};
	background-color: {$colors['alter_bg_color']};
}

.format-link .post_content_inner,
.format-status .post_content_inner {
	color: {$colors['text_dark']};
}

.format-chat p > b,
.format-chat p > strong {
	color: {$colors['text_dark']};
}

.post_layout_chess .post_content_inner:after {
	background: linear-gradient(to top, {$colors['bg_color']} 0%, {$colors['bg_color_0']} 100%) no-repeat scroll right top / 100% 100% {$colors['bg_color_0']};
}
.post_layout_chess_1 .post_meta:before {
	background-color: {$colors['bd_color']};
}

/* Pagination */
.nav-links-old {
	color: {$colors['text_dark']};
}
.nav-links-old a:hover {
	color: {$colors['text_dark']};
	border-color: {$colors['text_dark']};
}

.page_links > a,
.nav-links .page-numbers {
	color: {$colors['alter_bd_color']};
	background-color: {$colors['input_bg_color']};
}

.page_links > a:hover,
.nav-links a.page-numbers:hover,
.page_links > span:not(.page_links_title),
.nav-links .page-numbers.current {
	color: {$colors['inverse_text']};
	background-color: {$colors['text_dark']};
}

/* Single post */
.post_item_single .post_header .post_date {
	color: {$colors['text_light']};
}
.post_item_single .post_header .post_categories,
.post_item_single .post_header .post_categories a {
	color: {$colors['text_link']};
}
.post_item_single .post_header .post_meta_item,
.post_item_single .post_header .post_meta_item:before,
.post_item_single .post_header .post_meta_item:hover:before,
.post_item_single .post_header .post_meta_item a,
.post_item_single .post_header .post_meta_item a:before,
.post_item_single .post_header .post_meta_item a:hover:before,
.post_item_single .post_header .post_meta_item .socials_caption,
.post_item_single .post_header .post_meta_item .socials_caption:before,
.post_item_single .post_header .post_edit a {
	color: {$colors['text_light']};
}
.post_item_single .post_meta_item:hover,
.post_item_single .post_meta_item > a:hover,
.post_item_single .post_meta_item .socials_caption:hover,
.post_item_single .post_edit a:hover {
	color: {$colors['text_hover']};
}
.post_item_single .post_content .post_meta_label,
.post_item_single .post_content .post_meta_item:hover .post_meta_label {
	color: {$colors['text_hover']};
}
.post_item_single .post_content .post_tags,
.post_item_single .post_content .post_tags a {
	color: {$colors['text_hover']};
}
.post_item_single .post_content .post_tags a:hover {
	color: {$colors['text_link']};
}

.post-password-form input[type="submit"] {
	border-color: {$colors['text_dark']};
}
.post-password-form input[type="submit"]:hover,
.post-password-form input[type="submit"]:focus {
	color: {$colors['bg_color']};
}

/* Single post navi */
.nav-links-single .nav-links {
	border-color: {$colors['bd_color']};
}
.nav-links-single .nav-links a .meta-nav {
	color: {$colors['text_light']};
}
.nav-links-single .nav-links a .post_date {
	color: {$colors['text_light']};
}
.nav-links-single .nav-links a:hover .meta-nav,
.nav-links-single .nav-links a:hover .post_date {
	color: {$colors['text_dark']};
}
.nav-links-single .nav-links a:hover .post-title {
	color: {$colors['text_link']};
}

/* Author info */
.author_info:before{
    background-color: {$colors['alter_bg_color']};
}
.scheme_self.author_info {
	color: {$colors['alter_text']};
	background-color: {$colors['alter_bg_hover']};
}
.scheme_self.author_info .author_title {
	color: {$colors['alter_light']};
}
.scheme_self.author_info a {
	color: {$colors['text_hover']};
}
.scheme_self.author_info a:hover {
	color: {$colors['text_light']};
}

/* Related posts */
.related_wrap {
	border-color: {$colors['alter_bg_color']};
}
.related_wrap .post_date a{
    color: {$colors['text_hover']};
}
.related_wrap .post_date a:hover{
    color: {$colors['text_dark']};
}
.related_wrap .related_item_style_1 .post_header {
	background-color: {$colors['bg_color_07']};
}
.related_wrap .related_item_style_1:hover .post_header {
	background-color: {$colors['bg_color']};
}
.related_wrap .related_item_style_1 .post_date a {
	color: {$colors['text']};
}
.related_wrap .related_item_style_1:hover .post_date a {
	color: {$colors['text_light']};
}
.related_wrap .related_item_style_1:hover .post_date a:hover {
	color: {$colors['text_dark']};
}

/* Comments */
.comments_list_wrap,
.comments_list_wrap > ul {
	border-color: {$colors['bd_color']};
}
.comments_list_wrap li + li,
.comments_list_wrap li ul {
	border-color: {$colors['bd_color']};
}
.comments_list_wrap .comment_info {
	color: {$colors['text_dark']};
}
.comments_list_wrap .comment_counters a {
	color: {$colors['text_link']};
}
.comments_list_wrap .comment_counters a:before {
	color: {$colors['text_link']};
}
.comments_list_wrap .comment_counters a:hover:before,
.comments_list_wrap .comment_counters a:hover {
	color: {$colors['text_hover']};
}
.comments_list_wrap .comment_text {
	color: {$colors['text']};
}
.comments_list_wrap .comment_reply a {
	color: {$colors['text_hover']};
}
.comments_list_wrap .comment_reply a:hover {
	color: {$colors['text_link']};
}
.comments_form_wrap {
	border-color: {$colors['bd_color']};
}
.comments_wrap .comments_notes {
	color: {$colors['text_light']};
}
.comments_list_wrap .comment_posted{
    color: {$colors['input_text']};
}
.comments_list_wrap .comment_text p{
    color: {$colors['input_text']};
}
.comments_wrap .comments_field input, .comments_wrap .comments_field textarea{
    background-color: {$colors['alter_bg_color']};
    border-color: {$colors['alter_bg_color']};
}
.comments_wrap .form-submit input[type="submit"]{
    background-color: {$colors['text_hover']};
}

.comments_wrap .comment_text table th {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};
}


/* Page 404 */
.post_item_404 .page_title {
	color: {$colors['text_light']};
}
.post_item_404 .page_description {
	color: {$colors['text_link']};
}
.post_item_404 .go_home {
	border-color: {$colors['text_dark']};
}

/* Sidebar */
.sidebar_inner {
	background-color: {$colors['alter_bg_color']};
	color: {$colors['alter_text']};
}
.sidebar_inner aside + aside {
	border-color: {$colors['bd_color']};
}
.sidebar_inner h1, .sidebar_inner h2, .sidebar_inner h3, .sidebar_inner h4, .sidebar_inner h5, .sidebar_inner h6,
.sidebar_inner h1 a, .sidebar_inner h2 a, .sidebar_inner h3 a, .sidebar_inner h4 a, .sidebar_inner h5 a, .sidebar_inner h6 a {
	color: {$colors['alter_dark']};
}
.sidebar_inner h1 a:hover, .sidebar_inner h2 a:hover, .sidebar_inner h3 a:hover, .sidebar_inner h4 a:hover, .sidebar_inner h5 a:hover, .sidebar_inner h6 a:hover {
	color: {$colors['alter_link']};
}
aside .widget_title{
    color: {$colors['text_dark']};
}

/* Widgets */
aside {
	color: {$colors['alter_text']};
}
aside li:before {
	background-color: {$colors['text_hover']};
}
aside a {
	color: {$colors['text_dark']};
}
aside a:hover {
	color: {$colors['text_hover']};
}
aside li > a {
	color: {$colors['input_text']};
}
aside li > a:hover {
	color: {$colors['text_hover']};
}

aside li.recentcomments{
    color: {$colors['input_text']};
}
aside li.recentcomments span{
	 color: {$colors['text_dark']};
}
aside li.recentcomments > a {
	color: {$colors['text_dark']};
}
aside li.recentcomments > a:hover {
	color: {$colors['text_hover']};
}


/* Archive */
.widget_archive li {
	color: {$colors['alter_dark']};
}

/* Calendar */
.widget_calendar tbody td,
.wp-block-calendar tbody td {
	color: {$colors['input_text']}!important;
}
.widget_calendar th,
.wp-block-calendar th{
	color: {$colors['text_light']};
}
.widget_calendar tbody td a:hover,
.wp-block-calendar tbody td a:hover {
	color: {$colors['text_hover']};
}
.widget_calendar tbody td a:after,
.wp-block-calendar tbody td a:after {
	background-color: {$colors['text_hover']};
}
.widget_calendar td#today,
.wp-block-calendar td#today {
	color: {$colors['inverse_text']} !important;
}
.widget_calendar td#today a,
.wp-block-calendar td#today a {
	color: {$colors['inverse_link']};
}
.widget_calendar td#today a:hover,
.wp-block-calendar td#today a:hover {
	color: {$colors['inverse_hover']};
}
.widget_calendar td#today:before,
.wp-block-calendar td#today:before {
	background-color: {$colors['text_hover']};
}
.widget_calendar td#today a:after,
.wp-block-calendar td#today a:after {
	background-color: {$colors['inverse_link']};
}
.widget_calendar td#today a:hover:after,
.wp-block-calendar td#today a:hover:after {
	background-color: {$colors['inverse_hover']};
}
.widget_calendar #prev a, .widget_calendar #next a,
.wp-block-calendar #prev a, .wp-block-calendar #next a {
	color: {$colors['text_hover']};
}
.widget_calendar #prev a:hover, .widget_calendar #next a:hover,
.wp-block-calendar #prev a:hover, .wp-block-calendar #next a:hover {
	color: {$colors['input_text']};
}
.widget_calendar td#prev a:before, 
.widget_calendar td#next a:before {
	background-color: {$colors['alter_bg_color']};
}
.wp-block-calendar td#prev a:before, 
.wp-block-calendar td#next a:before {
	background-color: {$colors['bg_color']};
}

/* Categories */
.widget_categories li {
	color: {$colors['alter_dark']};
}

/* Tag cloud */
.widget_product_tag_cloud a,
.widget_tag_cloud a,
.wp-block-tag-cloud .tag-cloud-link{
	color: {$colors['text_dark']};
	background-color: {$colors['alter_bg_hover']};
}
.widget_product_tag_cloud a:hover,
.widget_tag_cloud a:hover,
.wp-block-tag-cloud .tag-cloud-link:hover {
	color: {$colors['inverse_text']} !important;
	background-color: {$colors['text_hover']};
}

/* RSS */
.widget_rss .widget_title a {
	color: {$colors['text_dark']};
}
.widget_rss .widget_title a:hover {
	color: {$colors['text_hover']};
}
.widget_rss .rss-date {
	color: {$colors['alter_light']};
}

.footer_wrap .widget_rss .rss-date {
	color: {$colors['alter_dark']};
}

/* Footer */
.scheme_self.site_footer_wrap {
	background-color: {$colors['alter_bg_color']};
	color: {$colors['alter_text']};
}
.scheme_self.site_footer_wrap aside {
	border-color: {$colors['alter_bd_color']};
}
.scheme_self.site_footer_wrap h1, .scheme_self.site_footer_wrap h2, .scheme_self.site_footer_wrap h3, .scheme_self.site_footer_wrap h4, .scheme_self.site_footer_wrap h5, .scheme_self.site_footer_wrap h6,
.scheme_self.site_footer_wrap h1 a, .scheme_self.site_footer_wrap h2 a, .scheme_self.site_footer_wrap h3 a, .scheme_self.site_footer_wrap h4 a, .scheme_self.site_footer_wrap h5 a, .scheme_self.site_footer_wrap h6 a {
	color: {$colors['alter_dark']};
}
.scheme_self.site_footer_wrap h1 a:hover, .scheme_self.site_footer_wrap h2 a:hover, .scheme_self.site_footer_wrap h3 a:hover, .scheme_self.site_footer_wrap h4 a:hover, .scheme_self.site_footer_wrap h5 a:hover, .scheme_self.site_footer_wrap h6 a:hover {
	color: {$colors['alter_link']};
}
.footer_wrap  aside{
    color: {$colors['text']};
}
.logo_footer_wrap_inner {
	border-color: {$colors['alter_bd_color']};
}
.logo_footer_wrap_inner:after {
	background-color: {$colors['alter_text']};
}
.socials_footer_wrap_inner .social_item .social_icons {
	border-color: {$colors['alter_text']};
	color: {$colors['alter_text']};
}
.socials_footer_wrap_inner .social_item .social_icons:hover {
	border-color: {$colors['alter_dark']};
	color: {$colors['alter_dark']};
}
.menu_footer_nav_area ul li a {
	color: {$colors['alter_dark']};
}
.menu_footer_nav_area ul li a:hover {
	color: {$colors['text_hover']};
}
.menu_footer_nav_area ul li+li:before {
	border-color: {$colors['alter_light']};
}
.footer_wrap_inner .columns_wrap{
	border-color: {$colors['alter_bd_color']};
}
.footer_wrap .widget_title{
    color: {$colors['inverse_text']};
}
.footer_wrap .textwidget h5 {
    color: {$colors['inverse_text']};
}
.copyright_wrap_inner {
	background-color: {$colors['alter_bg_color']};
	border-color: {$colors['bd_color']};
	color: {$colors['text_light']};
}

.copyright_wrap_inner a, .copyright_wrap_inner p {
	color: {$colors['text']};
}
.copyright_wrap_inner a:hover {
	color: {$colors['text_hover']};
}
.copyright_wrap_inner .copyright_text {
	color: {$colors['text']};
}


/* Buttons */
.theme_button,
.more-link,
.comments_wrap .form-submit input[type="submit"] {
	color: {$colors['inverse_text']} !important;
	background-color: {$colors['text_hover']} !important;
}
.theme_button:hover,
.more-link:hover,
.comments_wrap .form-submit input[type="submit"]:hover,
.comments_wrap .form-submit input[type="submit"]:focus {
	color: {$colors['inverse_text']} !important;
	background-color: {$colors['alter_link']} !important;
}

.format-video .post_featured.with_thumb .post_video_hover {
	color: {$colors['inverse_text']};
	background-color: {$colors['text_hover']};
}
.format-video .post_featured.with_thumb .post_video_hover:hover {
	color: {$colors['inverse_text']};
	background-color: {$colors['text_link']};
}
.format-video .post_featured.with_thumb .post_video_hover:after{
    border-color: {$colors['inverse_text_015']};
}

.theme_scroll_down:hover {
	color: {$colors['text_link']};
}


/* Third-party plugins */
.mfp-bg {
	background-color: {$colors['bg_color_07']};
}
.mfp-image-holder .mfp-close,
.mfp-iframe-holder .mfp-close {
	color: {$colors['text_dark']};
}
.mfp-image-holder .mfp-close:hover,
.mfp-iframe-holder .mfp-close:hover {
	color: {$colors['text_link']};
}


form.wpcf7-form textarea,
form.wpcf7-form input{
	color: {$colors['input_text']} !important;
	background-color: {$colors['alter_bg_hover']} !important;
}
form.wpcf7-form input[type="checkbox"] + span:before {
	border-color: {$colors['alter_bg_hover']} !important;
	background-color: {$colors['alter_bg_hover']} !important;
}
form.wpcf7-form input[type="submit"] {
	background-color: {$colors['text_hover']} !important;
	color: {$colors['inverse_text']} !important;
}
form.wpcf7-form input[type="submit"]:hover {
	background-color: {$colors['text_hover']} !important;
	color: {$colors['inverse_text']} !important;
}
form.wpcf7-form .flex .itm .wpcf7-form-control-wrap:after,
form.wpcf7-form .row .wpcf7-form-control-wrap:after,
form.wpcf7-form .wpcf7-form-control-wrap.your-message:after{
	color: {$colors['text_hover']} !important;
}


CSS;
				
					$rez = apply_filters('hampton_filter_get_css', $rez, $colors, false, $scheme);
					$css['colors'] .= $rez['colors'];
				}
			}
		}
				
		$css_str = (!empty($css['fonts']) ? $css['fonts'] : '')
				. (!empty($css['colors']) ? $css['colors'] : '');
		return $minify ? hampton_minify_css($css_str) : $css_str;
	}
}
?>