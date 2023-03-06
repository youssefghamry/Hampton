<?php
/**
 * The template for displaying posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

$hampton_post_id    = get_the_ID();
$hampton_post_date  = hampton_get_date();
$hampton_post_title = get_the_title();
$hampton_post_link  = get_permalink();
$hampton_post_author_id   = get_the_author_meta('ID');
$hampton_post_author_name = get_the_author_meta('display_name');
$hampton_post_author_url  = get_author_posts_url($hampton_post_author_id, '');

$hampton_args = get_query_var('hampton_args_widgets_posts');
$hampton_show_date = isset($hampton_args['show_date']) ? (int) $hampton_args['show_date'] : 1;
$hampton_show_image = isset($hampton_args['show_image']) ? (int) $hampton_args['show_image'] : 1;
$hampton_show_author = isset($hampton_args['show_author']) ? (int) $hampton_args['show_author'] : 1;
$hampton_show_counters = isset($hampton_args['show_counters']) ? (int) $hampton_args['show_counters'] : 1;
$hampton_show_categories = isset($hampton_args['show_categories']) ? (int) $hampton_args['show_categories'] : 1;

$hampton_output = hampton_storage_get('hampton_output_widgets_posts');

$hampton_post_counters_output = '';
if ( $hampton_show_counters ) {
	$hampton_post_counters_output = '<span class="post_info_item post_info_counters">'
								. hampton_get_post_counters('comments')
							. '</span>';
}


$hampton_output .= '<article class="post_item with_thumb">';

if ($hampton_show_image) {
	$hampton_post_thumb = get_the_post_thumbnail($hampton_post_id, hampton_get_thumb_size('tiny'), array(
		'alt' => the_title_attribute( array( 'echo' => false ) )
	));
	if ($hampton_post_thumb) $hampton_output .= '<div class="post_thumb">' . ($hampton_post_link ? '<a href="' . esc_url($hampton_post_link) . '">' : '') . ($hampton_post_thumb) . ($hampton_post_link ? '</a>' : '') . '</div>';
}

$hampton_output .= '<div class="post_content">'
			. ($hampton_show_categories 
					? '<div class="post_categories">'
						. hampton_get_post_categories()
						. $hampton_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($hampton_post_link ? '<a href="' . esc_url($hampton_post_link) . '">' : '') . ($hampton_post_title) . ($hampton_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('hampton_filter_get_post_info', 
								'<div class="post_info">'
									. ($hampton_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($hampton_post_link ? '<a href="' . esc_url($hampton_post_link) . '" class="post_info_date">' : '') 
											. esc_html($hampton_post_date) 
											. ($hampton_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($hampton_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'hampton') . ' ' 
											. ($hampton_post_link ? '<a href="' . esc_url($hampton_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($hampton_post_author_name) 
											. ($hampton_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$hampton_show_categories && $hampton_post_counters_output
										? $hampton_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
hampton_storage_set('hampton_output_widgets_posts', $hampton_output);
?>