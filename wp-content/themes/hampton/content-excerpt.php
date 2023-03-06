<?php
/**
 * The default template for displaying content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

$hampton_post_format = get_post_format();
$hampton_post_format = empty($hampton_post_format) ? 'standard' : str_replace('post-format-', '', $hampton_post_format);
$hampton_full_content = hampton_get_theme_option('blog_content') != 'excerpt' || in_array($hampton_post_format, array('link', 'aside', 'status', 'quote'));
$hampton_animation = hampton_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_'.esc_attr($hampton_post_format) ); ?>
	<?php echo (!hampton_is_off($hampton_animation) ? ' data-animation="'.esc_attr(hampton_get_animation_classes($hampton_animation)).'"' : ''); ?>
	><?php

	// Featured image
	hampton_show_post_featured(array( 'thumb_size' => hampton_get_thumb_size( strpos(hampton_get_theme_option('body_style'), 'full')!==false ? 'full' : 'big' ) ));

	// Title and post meta

		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if (get_the_title() != '') {
				do_action('hampton_action_before_post_title');
				the_title(sprintf('<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>');
			}

			do_action('hampton_action_before_post_meta'); 

			// Post meta
			hampton_show_post_meta(array(
				'categories' => false,
				'date' => true,
				'edit' => true,
				'seo' => false,
				'share' => true,
				'counters' => 'comments'	//comments,likes,views - comma separated in any combination
				)
			);
			?>
		</div><!-- .post_header --><?php

	
	// Post content
	?><div class="post_content entry-content"><?php
		if ($hampton_full_content) {
			// Post content area
			?><div class="post_content_inner"><?php
				the_content( '' );
			?></div><?php
			// Inner pages
			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'hampton' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'hampton' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

		} else {

			$hampton_show_learn_more = !in_array($hampton_post_format, array('link', 'aside', 'status', 'quote'));

			// Post content area
			?><div class="post_content_inner"><?php
				if (has_excerpt()) {
					the_excerpt();
				} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
					the_content( '' );
				} else if (in_array($hampton_post_format, array('link', 'aside', 'status', 'quote'))) {
					the_content();
				} else if (substr(get_the_content(), 0, 1)!='[') {
					the_excerpt();
				}
			?></div><?php
			// More button
			if ( $hampton_show_learn_more ) {
				?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>" data-text="<?php echo esc_html_e('More info', 'hampton'); ?>"><?php esc_html_e('More info', 'hampton'); ?></a></p><?php
			}

		}
	?></div><!-- .entry-content -->
</article>