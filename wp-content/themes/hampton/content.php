<?php
/**
 * The default template for displaying content of the single post, page or attachment
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post_item_single post_type_'.esc_attr(get_post_type()) 
												. ' post_format_'.esc_attr(str_replace('post-format-', '', get_post_format())) 
												. ' itemscope'
												); ?>
		itemscope itemtype="//schema.org/<?php echo esc_attr(is_single() ? 'BlogPosting' : 'Article'); ?>">
	<?php
	// Structured data snippets
	if (hampton_is_on(hampton_get_theme_option('seo_snippets'))) {
		?>
		<div class="structured_data_snippets">
			<meta itemprop="headline" content="<?php the_title_attribute(); ?>">
			<meta itemprop="datePublished" content="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
			<meta itemprop="dateModified" content="<?php echo esc_attr(get_the_modified_date('Y-m-d')); ?>">
			<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php echo get_the_permalink(); ?>" content="<?php the_title_attribute(); ?>"/>
			<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
				<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
					<?php 
					$hampton_logo_image = hampton_get_retina_multiplier(2) > 1 
										? hampton_get_theme_option( 'logo_retina' )
										: hampton_get_theme_option( 'logo' );
					if (!empty($hampton_logo_image)) {
						$hampton_attr = hampton_getimagesize($hampton_logo_image);
						?>
						<img itemprop="url" src="<?php echo esc_url($hampton_logo_image); ?>">
						<meta itemprop="width" content="<?php echo esc_attr($hampton_attr[0]); ?>">
						<meta itemprop="height" content="<?php echo esc_attr($hampton_attr[1]); ?>">
						<?php
					}
					?>
				</div>
				<meta itemprop="name" content="<?php echo esc_attr(get_bloginfo( 'name' )); ?>">
				<meta itemprop="telephone" content="">
				<meta itemprop="address" content="">
			</div>
		</div>
		<?php
	}
	
	// Featured image
	if ( !get_query_var('hampton_featured_showed', false) )
		hampton_show_post_featured();
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

	// Title and post meta
	if ( !get_query_var('hampton_title_showed', false) && !in_array(get_post_format(), array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( '<h3 class="post_title entry-title"'.(hampton_is_on(hampton_get_theme_option('seo_snippets')) ? ' itemprop="headline"' : '').'>', '</h3>' );

			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	?>
	<div class="post_content entry-content" itemprop="articleBody">
		<?php
			the_content( );

			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'hampton' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'hampton' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

			// Taxonomies and share
			if ( is_single() && !is_attachment() ) {
				?>
				<div class="post_meta post_meta_single"><?php
					
					// Post taxonomies
					?><span class="post_meta_item post_tags"><span class="post_meta_label"><?php esc_html_e('Tags:', 'hampton'); ?></span> <?php the_tags( '', ', ', '' ); ?></span><?php

					// Share
					hampton_show_share_links(array(
							'type' => 'block',
							'caption' => '',
							'before' => '<span class="post_meta_item post_share">',
							'after' => '</span>'
						));
					?>
				</div>
				<?php
			}
		?>
	</div><!-- .entry-content -->

	<?php
		// Author bio.
		if ( is_single() && !is_attachment() && get_the_author_meta( 'description' ) ) {
			get_template_part( 'templates/author-bio' );
		}
	?>
</article>
