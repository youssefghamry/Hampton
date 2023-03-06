<?php
/**
 * The style "default" of the Services
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.4
 */

$args = get_query_var('trx_addons_args_sc_services');

$query_args = array(
	'post_type' => TRX_ADDONS_CPT_SERVICES_PT,
	'post_status' => 'publish',
	'posts_per_page' => $args['count'],
	'ignore_sticky_posts' => true,
	'orderby' => 'title',
	'order' => 'asc'
);
$query_args = trx_addons_query_add_posts_and_cats($query_args, '', TRX_ADDONS_CPT_SERVICES_PT, $args['cat'], TRX_ADDONS_CPT_SERVICES_TAXONOMY);
$query = new WP_Query( $query_args );
if ((int)$query->found_posts > 0) {
	if ($args['count'] > $query->found_posts) $args['count'] = $query->found_posts;
	if ((int)$args['columns'] < 1) $args['columns'] = $args['count'];
	//$args['columns'] = min($args['columns'], $args['count']);
	$args['columns'] = max(1, min(12, (int) $args['columns']));
	$args['slider'] = (int)$args['slider'] > 0 && $args['count'] > $args['columns'];
	$args['slides_space'] = max(0, (int) $args['slides_space']);
	?><div class="sc_services sc_services_<?php 
			echo esc_attr($args['type']);
			if ($args['slider']) echo ' swiper-slider-container slider_swiper slider_noresize slider_nocontrols '.((int)$args['slider_pagination'] > 0 ? 'slider_pagination' : 'slider_nopagination');
			?>"<?php
			echo ((int)$args['columns'] > 1 
					? ' data-slides-per-view="' . esc_attr($args['columns']) . '"' 
					: '')
				. ((int)$args['slides_space'] > 0 
					? ' data-slides-space="' . esc_attr($args['slides_space']) . '"' 
					: '')
				. ' data-slides-min-width="' . ($args['type']=='iconed' ? 250 : 200) . '"';
				?>
		>
		<?php


    $align = !empty($args['title_align']) ? ' sc_align_'.trim($args['title_align']) : '';
    $style = !empty($args['title_style']) ? ' sc_item_title_style_'.trim($args['title_style']) : '';

    if (!empty($args['title'])) {
        if (empty($size)) $size = is_page() ? 'large' : 'normal';
        $title_tag = apply_filters('trx_addons_filter_sc_item_title_tag', 'large' == $size ? 'h2' : ('tiny' == $size ? 'h4' : 'h3'));
        ?><<?php echo esc_attr($title_tag); ?> class="<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_title_class', 'sc_item_title sc_services_title'.$align.$style)); ?>"><?php echo trim(trx_addons_str_decorate($args['title'])); ?></<?php echo esc_attr($title_tag); ?>><?php
    }
    if (!empty($args['subtitle'])) {
        ?><h6 class="<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_subtitle_class', 'sc_item_subtitle sc_services_subtitle'.$align.$style)); ?>"><?php echo trim(trx_addons_str_decorate($args['subtitle'])); ?></h6><?php
    }
    if (!empty($args['description'])) {
        ?><div class="<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_description_class', 'sc_item_descr sc_services_descr'.$align)); ?>"><?php echo do_shortcode(trx_addons_str_decorate($args['description'])); ?></div><?php
    }

		if ($args['slider']) {
			?><div class="sc_services_slider sc_item_slider slides swiper-wrapper"><?php
		} else if ((int)$args['columns'] > 1) {
			?><div class="sc_services_columns sc_item_columns <?php echo esc_attr(trx_addons_get_columns_wrap_class()).($args['type']!='list' ? ' columns_padding_bottom' : ''); ?>"><?php
		} else {
			?><div class="sc_services_content sc_item_content"><?php
		}	

		set_query_var('trx_addons_args_sc_services', $args);
			
		while ( $query->have_posts() ) { $query->the_post();
			if (($fdir = trx_addons_get_file_dir('cpt/services/tpl.'.trx_addons_esc($args['type']).'-item.php')) != '') { include $fdir; }
			else if (($fdir = trx_addons_get_file_dir('cpt/services/tpl.default-item.php')) != '') { include $fdir; }
		}

		wp_reset_postdata();
	
		?></div><?php

		if ((int)$args['slider'] > 0 && (int)$args['slider_pagination'] > 0) {
			?><div class="slider_pagination_wrap swiper-pagination"></div><?php
		}
		
		trx_addons_sc_show_links('sc_services', $args);

	?></div><!-- /.sc_services --><?php
}
?>