<?php
/**
 * The template for displaying side menu
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */
?>
<div class="menu_side_wrap scheme_<?php echo esc_attr(hampton_is_inherit(hampton_get_theme_option('menu_scheme')) 
																	? (hampton_is_inherit(hampton_get_theme_option('header_scheme')) 
																		? hampton_get_theme_option('color_scheme') 
																		: hampton_get_theme_option('header_scheme')) 
																	: hampton_get_theme_option('menu_scheme')); ?>">
	<span class="menu_side_button icon-menu-2"></span>

	<div class="menu_side_inner">
		<?php
		// Logo
		get_template_part( 'templates/header-logo' );
		// Main menu button
		?>
		<div class="toc_menu_item">
			<a href="#" class="toc_menu_description menu_mobile_description"><span class="toc_menu_description_title"><?php esc_html_e('Main menu', 'hampton'); ?></span></a>
			<a class="menu_mobile_button toc_menu_icon icon-menu-2" href="#"></a>
		</div>		
		<?php
		// Main menu
		$hampton_hampton_menu_main = hampton_get_nav_menu('menu_main');
		if (empty($hampton_hampton_menu_main)) $hampton_hampton_menu_main = hampton_get_nav_menu();
		// Store menu layout for the mobile menu
		set_query_var('hampton_menu_main', $hampton_hampton_menu_main);
		?>
	</div>
	
</div><!-- /.menu_side_wrap -->