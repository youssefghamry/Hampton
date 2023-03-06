<?php
/**
 * The "News Excerpt" template to show post's content
 *
 * Used in the widget Recent News.
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */
 
$args = get_query_var('trx_addons_args_recent_news');
$style = $args['style'];
$number = $args['number'];
$count = $args['count'];
$post_format = get_post_format();
$post_format = empty($post_format) ? 'standard' : str_replace('post-format-', '', $post_format);
$animation = apply_filters('trx_addons_blog_animation', '');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_'.esc_attr($style)
					.' post_format_'.esc_attr($post_format)
					); ?>
	<?php echo (!empty($animation) ? ' data-animation="'.esc_attr($animation).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}
	
	set_query_var('trx_addons_args_featured', array(
		'post_info' => '<div class="post_info"><span class="post_categories">'.trx_addons_get_post_categories().'</span></div>',
		'thumb_size' => trx_addons_get_thumb_size('medium')
	));
	if (($fdir = trx_addons_get_file_dir('templates/tpl.featured.php')) != '') { include $fdir; }
	?>

	<div class="post_body">

		<?php
		if ( !in_array($post_format, array('link', 'aside', 'status', 'quote')) ) {
			?>
			<div class="post_header entry-header">
				<?php
				
				the_title( '<h4 class="post_title entry-title"><a href="'.esc_url(get_permalink()).'" rel="bookmark">', '</a></h4>' );
				
				if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
					?><div class="post_meta"><span class="post_author"><?php the_author_link(); ?></span><?php
					?><span class="post_date"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo get_the_date(); ?></a></span></div><?php
				}
				?>
			</div><!-- .entry-header -->
			<?php
		}
		?>
		
		<div class="post_content entry-content">
			<?php
			echo wpautop(get_the_excerpt());
			?>
		</div><!-- .entry-content -->
	
		<div class="post_footer entry-footer">
			<?php
			if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
				set_query_var('trx_addons_args_post_counters', array(
					'counters' => 'views,likes,comments'
					)
				);
				if (($fdir = trx_addons_get_file_dir('templates/tpl.post-counters.php')) != '') { include $fdir; }
			}
			?>
		</div><!-- .entry-footer -->

	</div><!-- .post_body -->

</article>