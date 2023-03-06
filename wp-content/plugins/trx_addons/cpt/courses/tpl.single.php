<?php
/**
 * The template for displaying course's single post
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

get_header();

while ( have_posts() ) { the_post();
	?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'courses_single itemscope' ); ?>
    	itemscope itemtype="http://schema.org/Article">
		
		<section class="courses_page_header">	

			<?php
			// Image
			if ( has_post_thumbnail() ) {
				?><div class="courses_page_featured">
					<?php
					the_post_thumbnail( trx_addons_get_thumb_size('huge'), array(
								'alt' => get_the_title(),
								'itemprop' => 'image'
								)
							);
					?>
				</div>
				<?php
			}
			
			// Title
			?>
			<h2 class="courses_page_title"><?php the_title(); ?></h2>

		</section>
		<?php

		// Post content
		?><div class="courses_page_content entry-content" itemprop="articleBody"><?php
			the_content( );
		?></div><!-- .entry-content --><?php
	?></article><?php

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}

get_footer();
?>