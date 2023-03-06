<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

hampton_storage_set('blog_archive', true);

// Load scripts for both 'Gallery' and 'Portfolio' layouts!
wp_enqueue_script( 'classie', hampton_get_file_url('js/theme.gallery/classie.min.js'), array(), null, true );
wp_enqueue_script( 'imagesloaded', hampton_get_file_url('js/theme.gallery/imagesloaded.min.js'), array(), null, true );
wp_enqueue_script( 'masonry', hampton_get_file_url('js/theme.gallery/masonry.min.js'), array(), null, true );
wp_enqueue_script( 'hampton-gallery-script', hampton_get_file_url('js/theme.gallery/theme.gallery.js'), array(), null, true );

get_header(); 

if (have_posts()) {

	echo get_query_var('blog_archive_start');

	$hampton_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$hampton_sticky_out = is_array($hampton_stickies) && count($hampton_stickies) > 0 && get_query_var( 'paged' ) < 1;
	
	// Show filters
	$hampton_show_filters = hampton_get_theme_option('show_filters');
	$hampton_tabs = array();
	if (!hampton_is_off($hampton_show_filters)) {
		$hampton_cat = hampton_get_theme_option('parent_cat');
		$hampton_post_type = hampton_get_theme_option('post_type');
		$hampton_taxonomy = hampton_get_post_type_taxonomy($hampton_post_type);
		$hampton_args = array(
			'type'			=> $hampton_post_type,
			'child_of'		=> $hampton_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'exclude'		=> '',
			'include'		=> '',
			'number'		=> '',
			'taxonomy'		=> $hampton_taxonomy,
			'pad_counts'	=> false
		);
		$hampton_portfolio_list = get_terms($hampton_args);
		if (is_array($hampton_portfolio_list) && count($hampton_portfolio_list) > 0) {
			$hampton_tabs[$hampton_cat] = esc_html__('All', 'hampton');
			foreach ($hampton_portfolio_list as $hampton_term) {
				if (isset($hampton_term->term_id)) $hampton_tabs[$hampton_term->term_id] = $hampton_term->name;
			}
		}
	}
	if (count($hampton_tabs) > 0) {
		$hampton_portfolio_filters_ajax = true;
		$hampton_portfolio_filters_active = $hampton_cat;
		$hampton_portfolio_filters_id = 'portfolio_filters';
		if (!is_customize_preview())
			wp_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true);
		?>
		<div class="portfolio_filters hampton_tabs hampton_tabs_ajax">
			<ul class="portfolio_titles hampton_tabs_titles">
				<?php
				foreach ($hampton_tabs as $hampton_id=>$hampton_title) {
					?><li><a href="<?php echo esc_url(hampton_get_hash_link(sprintf('#%s_%s_content', $hampton_portfolio_filters_id, $hampton_id))); ?>" data-tab="<?php echo esc_attr($hampton_id); ?>"><?php echo esc_html($hampton_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$hampton_ppp = hampton_get_theme_option('posts_per_page');
			if (hampton_is_inherit($hampton_ppp)) $hampton_ppp = '';
			foreach ($hampton_tabs as $hampton_id=>$hampton_title) {
				$hampton_portfolio_need_content = $hampton_id==$hampton_portfolio_filters_active || !$hampton_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $hampton_portfolio_filters_id, $hampton_id)); ?>"
					class="portfolio_content hampton_tabs_content"
					data-blog-template="<?php echo esc_attr(hampton_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(hampton_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($hampton_ppp); ?>"
					data-post-type="<?php echo esc_attr($hampton_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($hampton_taxonomy); ?>"
					data-cat="<?php echo esc_attr($hampton_id); ?>"
					data-parent-cat="<?php echo esc_attr($hampton_cat); ?>"
					data-need-content="<?php echo (false===$hampton_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($hampton_portfolio_need_content) 
						hampton_show_portfolio_posts(array(
							'cat' => $hampton_id,
							'parent_cat' => $hampton_cat,
							'taxonomy' => $hampton_taxonomy,
							'post_type' => $hampton_post_type,
							'page' => 1,
							'sticky' => $hampton_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		hampton_show_portfolio_posts(array(
			'cat' => $hampton_id,
			'parent_cat' => $hampton_cat,
			'taxonomy' => $hampton_taxonomy,
			'post_type' => $hampton_post_type,
			'page' => 1,
			'sticky' => $hampton_sticky_out
			)
		);
	}

	echo get_query_var('blog_archive_end');

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>