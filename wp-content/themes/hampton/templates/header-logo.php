<?php
/**
 * The template for displaying Logo or Site name and slogan in the Header
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

// Site logo
$hampton_logo_image = '';
if (hampton_get_retina_multiplier(2) > 1)
	$hampton_logo_image = hampton_get_theme_option( 'logo_retina' );
if (empty($hampton_logo_image)) 
	$hampton_logo_image = hampton_get_theme_option( 'logo' );
$hampton_logo_text   = get_bloginfo( 'name' );
$hampton_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($hampton_logo_image) || !empty($hampton_logo_text)) {
	?><a class="logo" href="<?php echo is_front_page() ? '#' : esc_url(home_url('/')); ?>"><?php
		if (!empty($hampton_logo_image)) {
			$hampton_attr = hampton_getimagesize($hampton_logo_image);
			echo '<img src="'.esc_url($hampton_logo_image).'" class="logo_main" alt="'.esc_attr($hampton_logo_text).'"'.(!empty($hampton_attr[3]) ? sprintf(' %s', $hampton_attr[3]) : '').'>' ;
		} else {
			hampton_show_layout(hampton_prepare_macros($hampton_logo_text), '<span class="logo_text">', '</span>');
			hampton_show_layout(hampton_prepare_macros($hampton_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>