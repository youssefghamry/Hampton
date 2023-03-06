<?php
/**
 * The Classic template for displaying content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

$hampton_blog_style = explode('_', hampton_get_theme_option('blog_style'));
$hampton_columns = empty($hampton_blog_style[1]) ? 1 : max(1, $hampton_blog_style[1]);
$hampton_expanded = !hampton_sidebar_present() && hampton_is_on(hampton_get_theme_option('expand_content'));
$hampton_post_format = get_post_format();
$hampton_post_format = empty($hampton_post_format) ? 'standard' : str_replace('post-format-', '', $hampton_post_format);
$hampton_animation = hampton_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($hampton_columns).' post_format_'.esc_attr($hampton_post_format) ); ?>
	<?php echo (!hampton_is_off($hampton_animation) ? ' data-animation="'.esc_attr(hampton_get_animation_classes($hampton_animation)).'"' : ''); ?>
	>

	<?php
	// Add anchor
	if ($hampton_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="post_'.esc_attr(get_the_ID()).'" title="'.the_title_attribute( array( 'echo' => false ) ).'"]');
	}

	// Featured image
	hampton_show_post_featured( array(
											'class' => $hampton_columns == 1 ? 'trx-stretch-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => hampton_get_thumb_size(
																	strpos(hampton_get_theme_option('body_style'), 'full')!==false
																		? ( $hampton_columns > 1 ? 'big' : 'original' )
																		: (	$hampton_columns > 1 ? 'med' : 'big')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header"><?php 
			do_action('hampton_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			
			do_action('hampton_action_before_post_meta'); 

			// Post meta
			$hampton_post_meta = hampton_show_post_meta(array(
									'categories' => false,
									'date' => true,
									'edit' => $hampton_columns == 1,
									'seo' => false,
									'share' => true,
									'counters' => $hampton_columns < 3 ? 'comments' : '',
									'echo' => false
									)
								);
			hampton_show_layout($hampton_post_meta);
		?></div><!-- .entry-header -->
	
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$hampton_show_learn_more = !in_array($hampton_post_format, array('link', 'aside', 'status', 'quote'));
				if (has_excerpt()) {
					the_excerpt();
				} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
					the_content( '' );
				} else if (in_array($hampton_post_format, array('link', 'aside', 'status', 'quote'))) {
					the_content();
				} else if (substr(get_the_content(), 0, 1)!='[') {
					the_excerpt();
				}
				?>
			</div>
			<?php
			// Post meta
			if (in_array($hampton_post_format, array('link', 'aside', 'status', 'quote'))) {
				hampton_show_layout($hampton_post_meta);
			}
			// More button
			if ( $hampton_show_learn_more ) {
				?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>" data-text="<?php echo esc_html_e('More info', 'hampton'); ?>"><?php esc_html_e('More info', 'hampton'); ?></a></p><?php
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>