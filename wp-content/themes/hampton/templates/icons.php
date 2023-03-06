<?php
/**
 * The template to displaying popup with Theme Icons
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

$hampton_icons = hampton_get_list_icons();
if (is_array($hampton_icons)) {
	?>
	<div class="hampton_list_icons">
		<?php
		foreach($hampton_icons as $icon) {
			?><span class="<?php echo esc_attr($icon); ?>" title="<?php echo esc_attr($icon); ?>"></span><?php
		}
		?>
	</div>
	<?php
}
?>