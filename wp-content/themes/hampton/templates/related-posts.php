<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

// Thumb image
$hampton_thumb_image = has_post_thumbnail() 
			? wp_get_attachment_image_src(get_post_thumbnail_id(), hampton_get_thumb_size('portrait')) 
			: ( (float) wp_get_theme()->get('Version') > 1.0
					? hampton_get_no_image_placeholder()
					: ''
				);
if (is_array($hampton_thumb_image)) $hampton_thumb_image = $hampton_thumb_image[0];
$hampton_link = get_permalink();
?>
<div class="related_item related_item_style_1">
	<?php if (!empty($hampton_thumb_image)) { ?>
		<div class="post_featured <?php echo esc_attr(hampton_add_inline_style('background-image:url('.esc_url($hampton_thumb_image).');')); ?>">
			<div class="post_header entry-header">
				<div class="post_categories"><?php the_category( '' ); ?></div>
				<h6 class="post_title entry-title"><a href="<?php echo esc_url($hampton_link); ?>"><?php echo the_title(); ?></a></h6>
				<?php
				if ( in_array(get_post_type(), array( 'post', 'attachment' ) ) ) {
					?><span class="post_date"><a href="<?php echo esc_url($hampton_link); ?>"><?php echo hampton_get_date(); ?></a></span><?php
				}
				?>
			</div>
		</div>
	<?php } ?>
</div>
