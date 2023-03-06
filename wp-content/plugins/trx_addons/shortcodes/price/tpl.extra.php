<?php
/**
 * The style "default" of the Price block
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_price');

if (!empty($args['image'])) {
	$args['image'] = trx_addons_get_attachment_url($args['image'], 'full');
	$args['css'] .= ($args['image'] !== '' ? 'background-image:url(' . esc_url($args['image']) . ');' : '');
}

?><div <?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"'; ?> 
	class="sc_price sc_price_<?php
			echo esc_attr($args['type']);
			if (!empty($args['class'])) echo ' '.esc_attr($args['class']);
	?>"<?php
	if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"';
?>>
<div class="sc_price_info"><?php


		if (!empty($args['title'])) {
			?><div class="sc_price_title"><?php
				if (!empty($args['link'])) {
					?><a href="<?php echo esc_url($args['link']); ?>"><?php
				} 
				echo esc_html($args['title']); 
				if (!empty($args['link'])) {
					?></a><?php
				} 
			?></div><?php
		}
    if (!empty($args['subtitle'])) {
        ?><div class="sc_price_subtitle"><?php echo esc_html($args['subtitle']); ?></div><?php
    }
		if (!empty($args['description'])) {
			?><div class="sc_price_description"><?php echo wp_kses_post(trx_addons_parse_codes($args['description'])); ?></div><?php
		}
		if (!empty($args['price'])) {
			$parts = explode('.', trx_addons_parse_codes($args['price']));
			?><div class="sc_price_price"><?php
				if (!empty($args['currency'])) {
					?><span class="sc_price_currency"><?php echo esc_html($args['currency']); ?></span><?php
				}
				?><span class="sc_price_value"><?php echo wp_kses_post($parts[0]); ?></span><?php
				if (count($parts) > 1 && $parts[1]!='') {
					?><span class="sc_price_decimals"><?php echo wp_kses_post($parts[1]); ?></span><?php
				}
			?></div><?php
		}
		if ( ($content = do_shortcode($content))!='' ) {
			?><div class="sc_price_details"><?php echo wp_kses_post($content); ?></div><?php
		}

	if (!empty($args['link']) && !empty($args['link_text'])) {
		?><a href="<?php echo esc_url($args['link']); ?>" class="sc_price_link sc_button_default2 sc_button_size_normal" data-text="<?php echo esc_html($args['link_text']); ?>"><?php echo esc_html($args['link_text']); ?><span class="sc_button_iconed"></span></a><?php
	}

	?></div>
</div>