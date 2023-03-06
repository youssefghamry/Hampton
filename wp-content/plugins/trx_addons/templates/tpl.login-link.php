<?php
/**
 * The template to display login link
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0.1
 */

// Display link
$args = get_query_var('trx_addons_args_login');
?><a href="#trx_addons_login_popup" class="trx_addons_popup_link trx_addons_login_link trx_addons_icon-user-alt" title="<?php echo esc_attr($args['link_title']); ?>"><?php echo esc_html($args['link_text']); ?></a>