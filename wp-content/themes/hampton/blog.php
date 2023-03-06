<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the WPBakery Page Builder to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$hampton_content = '';
$hampton_blog_archive_mask = '%%CONTENT%%';
$hampton_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $hampton_blog_archive_mask);
if ( have_posts() ) {
	the_post(); 
	if (($hampton_content = apply_filters('the_content', get_the_content())) != '') {
		if (($hampton_pos = strpos($hampton_content, $hampton_blog_archive_mask)) !== false) {
			$hampton_content = preg_replace('/(\<p\>\s*)?'.$hampton_blog_archive_mask.'(\s*\<\/p\>)/i', $hampton_blog_archive_subst, $hampton_content);
		} else
			$hampton_content .= $hampton_blog_archive_subst;
		$hampton_content = explode($hampton_blog_archive_mask, $hampton_content);
	}
}

// Make new query
$hampton_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$hampton_args = hampton_query_add_posts_and_cats($hampton_args, '', hampton_get_theme_option('post_type'), hampton_get_theme_option('parent_cat'));
$hampton_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($hampton_page_number > 1) {
	$hampton_args['paged'] = $hampton_page_number;
	$hampton_args['ignore_sticky_posts'] = true;
}
$hampton_ppp = hampton_get_theme_option('posts_per_page');
if ((int) $hampton_ppp != 0)
	$hampton_args['posts_per_page'] = (int) $hampton_ppp;

query_posts( $hampton_args );

// Set query vars in the new query!
if (is_array($hampton_content) && count($hampton_content) == 2) {
	set_query_var('blog_archive_start', $hampton_content[0]);
	set_query_var('blog_archive_end', $hampton_content[1]);
}

get_template_part('index');
?>