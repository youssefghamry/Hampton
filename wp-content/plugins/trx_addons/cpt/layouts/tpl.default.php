<?php
/**
 * The style "default" of the Layouts
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.06
 */

$args = get_query_var('trx_addons_args_sc_layouts');

if (!empty($args['layout_id'])) {
	$layout = get_post($args['layout_id']);
	if ($layout !== null) {
		?><div class="sc_layouts sc_layouts_<?php echo esc_attr($args['type']); ?> sc_layouts_<?php echo esc_attr($layout['ID']); ?>"><?php
			echo do_shortcode($layouts->content);
		?></div><?php
	}
}
?>