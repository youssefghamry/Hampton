<?php
/**
 * The template for displaying Page title and Breadcrumbs
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

// Page (category, tag, archive, author) title

if ( hampton_need_page_title() ) {
	set_query_var('hampton_title_showed', true);
	$hampton_top_icon = hampton_get_category_icon();
	?>
	<div class="top_panel_title_wrap">
		<div class="content_wrap">
			<div class="top_panel_title">
				<div class="page_title">
					<?php

					// Blog/Post title
					$hampton_blog_title = hampton_get_blog_title();
					$hampton_blog_title_text = $hampton_blog_title_class = $hampton_blog_title_link = $hampton_blog_title_link_text = '';
					if (is_array($hampton_blog_title)) {
						$hampton_blog_title_text = $hampton_blog_title['text'];
						$hampton_blog_title_class = !empty($hampton_blog_title['class']) ? ' '.$hampton_blog_title['class'] : '';
						$hampton_blog_title_link = !empty($hampton_blog_title['link']) ? $hampton_blog_title['link'] : '';
						$hampton_blog_title_link_text = !empty($hampton_blog_title['link_text']) ? $hampton_blog_title['link_text'] : '';
					} else
						$hampton_blog_title_text = $hampton_blog_title;
					?>
					<h1 class="page_caption<?php echo esc_attr($hampton_blog_title_class); ?>"><?php
						if (!empty($hampton_top_icon)) {
                            $alt = basename($hampton_top_icon);
                            $alt = substr($alt,0,strlen($alt) - 4);
							?><img src="<?php echo esc_url($hampton_top_icon); ?>" alt="<?php echo esc_attr($alt); ?>"><?php
						}
						echo wp_kses_post($hampton_blog_title_text);
					?></h1>
					<?php
					if (!empty($hampton_blog_title_link) && !empty($hampton_blog_title_link_text)) {
						?><a href="<?php echo esc_url($hampton_blog_title_link); ?>" class="theme_button theme_button_small page_title_link"><?php echo esc_html($hampton_blog_title_link_text); ?></a><?php
					}
					
					// Category/Tag description
					if ( is_category() || is_tag() || is_tax() ) 
						the_archive_description( '<div class="page_description">', '</div>' );
					?>
				</div>
				<?php
				// Breadcrumbs
				if (hampton_is_on(hampton_get_theme_option('show_breadcrumbs'))) {
					hampton_show_layout(hampton_get_breadcrumbs(), '<div class="breadcrumbs">', '</div>');
				}
				?>
			</div>
		</div>
	</div>
	<?php
}
?>