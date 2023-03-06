<?php
/**
 * The style "default" of the Courses
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_courses');

$query_args = array(
	'post_type' => TRX_ADDONS_CPT_COURSES_PT,
	'post_status' => 'publish',
	'posts_per_page' => $args['count'],
	'ignore_sticky_posts' => true,
);
$query_args = trx_addons_query_add_sort_order($query_args, 'courses_date', 'desc');
$query_args = trx_addons_query_add_posts_and_cats($query_args, '', TRX_ADDONS_CPT_COURSES_PT, $args['cat'], TRX_ADDONS_CPT_COURSES_TAXONOMY);
$query_args['meta_query'] = array(
	array(
		'key' => 'trx_addons_courses_date',
		'value' => date('Y-m-d'),
		'compare' => (int)$args['past']==1 ? '<' : '>='
	)
);
$query = new WP_Query( $query_args );
if ((int)$query->found_posts > 0) {
	if ($args['count'] > $query->found_posts) $args['count'] = $query->found_posts;
	if ((int)$args['columns'] < 1) $args['columns'] = $args['count'];
	//$args['columns'] = min($args['columns'], $args['count']);
	$args['columns'] = max(1, min(12, (int) $args['columns']));
	$args['slider'] = (int)$args['slider'] > 0 && $args['count'] > $args['columns'];
	$args['slides_space'] = max(0, (int) $args['slides_space']);
	?><div class="sc_courses sc_courses_<?php
			echo esc_attr($args['type']);
    		if ($args['slider']) echo ' swiper-slider-container slider_swiper slider_noresize slider_nocontrols '.((int)$args['slider_pagination'] > 0 ? 'slider_pagination' : 'slider_nopagination'); 
			?>"<?php
			echo ((int)$args['columns'] > 1 
					? ' data-slides-per-view="' . esc_attr($args['columns']) . '"' 
					: '')
				. ((int)$args['slides_space'] > 0 
					? ' data-slides-space="' . esc_attr($args['slides_space']) . '"' 
					: '')
				. ' data-slides-min-width="150"';
				?>
		>
		<?php
		trx_addons_sc_show_titles('sc_courses', $args);
		
		if ($args['slider']) {
			?><div class="sc_courses_slider sc_item_slider slides swiper-wrapper"><?php
		} else if ((int)$args['columns'] > 1) {
			?><div class="sc_courses_columns sc_item_columns <?php echo esc_attr(trx_addons_get_columns_wrap_class()); ?> columns_padding_bottom"><?php
		} else {
			?><div class="sc_courses_content sc_item_content"><?php
		}	

		set_query_var('trx_addons_args_sc_courses', $args);
			
		while ( $query->have_posts() ) { $query->the_post();
			if (($fdir = trx_addons_get_file_dir('cpt/courses/tpl.' . trx_addons_esc($args['type']) . '-item.php')) != '') { include $fdir; }
			else if (($fdir = trx_addons_get_file_dir('cpt/courses/tpl.default-item.php')) != '') { include $fdir; }
		}

		wp_reset_postdata();
	
		?></div><?php

		if ((int)$args['slider'] > 0 && (int)$args['slider_pagination'] > 0) {
			?><div class="slider_pagination_wrap swiper-pagination"></div><?php
		}
		
		trx_addons_sc_show_links('sc_courses', $args);

	?></div><!-- /.sc_courses --><?php
}
?>