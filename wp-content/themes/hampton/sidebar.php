<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

$hampton_sidebar_position = hampton_get_theme_option('sidebar_position');
if (hampton_sidebar_present()) {
	$hampton_sidebar_name = hampton_get_theme_option('sidebar_widgets');
	hampton_storage_set('current_sidebar', 'sidebar');
	?>
	<div class="sidebar <?php echo esc_attr($hampton_sidebar_position); ?> widget_area<?php if (!hampton_is_inherit(hampton_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(hampton_get_theme_option('sidebar_scheme')); ?>" role="complementary">
		<div class="sidebar_inner">
			<?php
			ob_start();
			do_action( 'hampton_action_before_sidebar' );
			if ( is_active_sidebar( $hampton_sidebar_name ) ) {
				dynamic_sidebar( $hampton_sidebar_name );
			}
			do_action( 'hampton_action_after_sidebar' );
			$hampton_out = ob_get_contents();
			ob_end_clean();
			hampton_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $hampton_out));
			?>
		</div><!-- /.sidebar_inner -->
	</div><!-- /.sidebar -->
	<?php
}
?>