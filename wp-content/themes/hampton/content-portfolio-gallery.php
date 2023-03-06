<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

$hampton_blog_style = explode('_', hampton_get_theme_option('blog_style'));
$hampton_columns = empty($hampton_blog_style[1]) ? 2 : max(2, $hampton_blog_style[1]);
$hampton_post_format = get_post_format();
$hampton_post_format = empty($hampton_post_format) ? 'standard' : str_replace('post-format-', '', $hampton_post_format);
$hampton_animation = hampton_get_theme_option('blog_animation');
$hampton_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($hampton_columns).' post_format_'.esc_attr($hampton_post_format) ); ?>
	<?php echo (!hampton_is_off($hampton_animation) ? ' data-animation="'.esc_attr(hampton_get_animation_classes($hampton_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($hampton_image[1]) && !empty($hampton_image[2])) echo intval($hampton_image[1]) .'x' . intval($hampton_image[2]); ?>"
	data-src="<?php if (!empty($hampton_image[0])) echo esc_url($hampton_image[0]); ?>"
	>

	<?php
	$hampton_image_hover = 'icon';
	if (in_array($hampton_image_hover, array('icons', 'zoom'))) $hampton_image_hover = 'dots';
	// Featured image
	hampton_show_post_featured(array(
		'hover' => $hampton_image_hover,
		'thumb_size' => hampton_get_thumb_size( strpos(hampton_get_theme_option('body_style'), 'full')!==false || $hampton_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. hampton_show_post_meta(array(
									'categories' => true,
									'date' => true,
									'edit' => false,
									'seo' => false,
									'share' => true,
									'counters' => 'comments',
									'echo' => false
									))
								. '<div class="post_description_content">'
									. apply_filters('the_excerpt', get_the_excerpt())
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'hampton') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>