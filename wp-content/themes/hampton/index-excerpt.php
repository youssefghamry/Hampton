<?php
/**
 * The template for homepage posts with "Excerpt" style
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

hampton_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	echo get_query_var('blog_archive_start');

	?><div class="posts_container"><?php
	
	$hampton_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$hampton_sticky_out = is_array($hampton_stickies) && count($hampton_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($hampton_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	while ( have_posts() ) { the_post(); 
		if ($hampton_sticky_out && !is_sticky()) {
			$hampton_sticky_out = false;
			?></div><?php
		}
		get_template_part( 'content', $hampton_sticky_out && is_sticky() ? 'sticky' : 'excerpt' );
	}
	if ($hampton_sticky_out) {
		$hampton_sticky_out = false;
		?></div><?php
	}
	
	?></div><?php

	hampton_show_pagination();

	echo get_query_var('blog_archive_end');

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>