<?php
/**
 * The Portfolio template for displaying content
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

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($hampton_columns).' post_format_'.esc_attr($hampton_post_format) ); ?>
	<?php echo (!hampton_is_off($hampton_animation) ? ' data-animation="'.esc_attr(hampton_get_animation_classes($hampton_animation)).'"' : ''); ?>
	>

	<?php
	$hampton_image_hover = hampton_get_theme_option('image_hover');
	// Featured image
	hampton_show_post_featured(array(
		'thumb_size' => hampton_get_thumb_size(strpos(hampton_get_theme_option('body_style'), 'full')!==false || $hampton_columns < 3 ? 'masonry-big' : 'masonry'),
		'show_no_image' => true,
		'class' => $hampton_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $hampton_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>