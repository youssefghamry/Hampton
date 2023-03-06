<?php
/**
 * The Sticky template for displaying sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

$hampton_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$hampton_post_format = get_post_format();
$hampton_post_format = empty($hampton_post_format) ? 'standard' : str_replace('post-format-', '', $hampton_post_format);
$hampton_animation = hampton_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($hampton_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($hampton_post_format) ); ?>
	<?php echo (!hampton_is_off($hampton_animation) ? ' data-animation="'.esc_attr(hampton_get_animation_classes($hampton_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	hampton_show_post_featured(array(
		'thumb_size' => hampton_get_thumb_size($hampton_columns==1 ? 'big' : ($hampton_columns==2 ? 'med' : 'avatar'))
	));

	if ( !in_array($hampton_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			hampton_show_post_meta();
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div>