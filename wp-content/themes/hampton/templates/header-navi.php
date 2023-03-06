<?php
/**
 * The template for displaying main menu
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */
$hampton_header_image = get_query_var('hampton_header_image');
$hampton_header_text_custom = hampton_get_theme_option('header_title_text');

?>
<div class="top_panel_fixed_wrap"></div>
<div class="top_panel_navi 
			<?php if ($hampton_header_image!='') echo ' with_bg_image'; ?>
			scheme_<?php echo esc_attr(hampton_is_inherit(hampton_get_theme_option('menu_scheme')) 
												? (hampton_is_inherit(hampton_get_theme_option('header_scheme')) 
													? hampton_get_theme_option('color_scheme') 
													: hampton_get_theme_option('header_scheme')) 
												: hampton_get_theme_option('menu_scheme')); ?>">
	<div class="menu_main_wrap clearfix menu_hover_<?php echo esc_attr(hampton_get_theme_option('menu_hover')); ?>">
        <?php
        // Filter header components
        $hampton_header_parts = apply_filters('hampton_filter_header_parts', array(
            'logo' => true,
            'menu' => true,
            'search' => true
        ),
            'menu_main');
        // Logo
        if (!empty($hampton_header_parts['logo'])) {
        get_template_part( 'templates/header-logo' );
        }
        ?>
        <div class="panel_right clearfix">
            <?php

            //Display socials in header
            if ( hampton_is_on(hampton_get_theme_option('socials_in_header')) && ($hampton_output = hampton_get_socials_links()) != '') {
                ?>
                <div class="socials_header_wrap socials_wrap">
                    <div class="socials_header_wrap_inner">
                        <?php hampton_show_layout($hampton_output); ?>
                    </div>
                </div>
            <?php
            }

            if (!empty($hampton_header_text_custom)) {
                hampton_show_layout($hampton_header_text_custom, '<div class="top_panel_custom_text">', '</div>');
            }
            ?>
        </div>
		<div class="menu_main_wrap_nav search_show_<?php if (hampton_is_on(hampton_get_theme_option('search_display'))){ echo 'yes'; }  else echo 'no'  ?>">
			<?php


			
			// Main menu
			if (!empty($hampton_header_parts['menu'])) {
				$hampton_hampton_menu_main = hampton_get_nav_menu('menu_main');
				if (empty($hampton_hampton_menu_main)) $hampton_hampton_menu_main = hampton_get_nav_menu();
				hampton_show_layout($hampton_hampton_menu_main);
				// Store menu layout for the mobile menu
				set_query_var('hampton_menu_main', $hampton_hampton_menu_main);
			}

			// Display search field
			if (!empty($hampton_header_parts['search'])) {
				set_query_var('hampton_search_in_header', true);
				get_template_part( 'templates/search-field' );
			}


            ?>
		</div>

	</div>
</div><!-- /.top_panel_navi -->