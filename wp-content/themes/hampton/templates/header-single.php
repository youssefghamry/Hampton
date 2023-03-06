<?php
/**
 * The template for displaying Featured image in the single post
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

if ( get_query_var('hampton_header_image')=='' && is_singular() && has_post_thumbnail() && in_array(get_post_type(), array('post', 'page')) )  {
	$hampton_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
}
?>