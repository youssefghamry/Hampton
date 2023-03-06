<?php
/**
 * The template for displaying Header widgets area
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

// Header sidebar
$hampton_header_name = hampton_get_theme_option('header_widgets');
$hampton_header_present = !hampton_is_off($hampton_header_name) && is_active_sidebar($hampton_header_name);
if ($hampton_header_present) { 
	hampton_storage_set('current_sidebar', 'header');
	$hampton_header_wide = hampton_get_theme_option('header_wide');
	ob_start();
	do_action( 'hampton_action_before_sidebar' );
	if ( is_active_sidebar( $hampton_header_name ) ) {
		dynamic_sidebar( $hampton_header_name );
	}
	do_action( 'hampton_action_after_sidebar' );
	$hampton_widgets_output = ob_get_contents();
	ob_end_clean();
	$hampton_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $hampton_widgets_output);
	$hampton_need_columns = strpos($hampton_widgets_output, 'columns_wrap')===false;
	if ($hampton_need_columns) {
		$hampton_columns = max(0, (int) hampton_get_theme_option('header_columns'));
		if ($hampton_columns == 0) $hampton_columns = min(6, max(1, substr_count($hampton_widgets_output, '<aside ')));
		if ($hampton_columns > 1)
			$hampton_widgets_output = preg_replace("/class=\"widget /", "class=\"column-1_".esc_attr($hampton_columns).' widget ', $hampton_widgets_output);
		else
			$hampton_need_columns = false;
	}
	?>
	<div class="header_widgets_wrap widget_area<?php echo !empty($hampton_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
		<div class="header_widgets_wrap_inner widget_area_inner">
			<?php 
			if (!$hampton_header_wide) { 
				?><div class="content_wrap"><?php
			}
			if ($hampton_need_columns) {
				?><div class="columns_wrap"><?php
			}
			hampton_show_layout($hampton_widgets_output);
			if ($hampton_need_columns) {
				?></div>	<!-- /.columns_wrap --><?php
			}
			if (!$hampton_header_wide) {
				?></div>	<!-- /.content_wrap --><?php
			}
			?>
		</div>	<!-- /.header_widgets_wrap_inner -->
	</div>	<!-- /.header_widgets_wrap -->
<?php
}
?>