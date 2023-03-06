<article <?php post_class( 'post_item_single post_item_404 post_item_none_search' ); ?>>
	<div class="post_content">
		<h1 class="page_title"><?php esc_html_e( 'No results', 'hampton' ); ?></h1>
		<div class="page_info">
			<h3 class="page_subtitle"><?php echo sprintf(esc_html__("We're sorry, but your search \"%s\" did not match", 'hampton'), get_search_query()); ?></h3>
			<p class="page_description"><?php echo wp_kses_data( sprintf( __("Can't find what you need? Take a moment and do a search below or start from <a href='%s'>our homepage</a>.", 'hampton'), esc_url(home_url('/')) ) ); ?></p>
			<div class="page_search"><?php
                $hampton_search_style = hampton_get_theme_option('search_style');
                $hampton_search_in_header = get_query_var('hampton_search_in_header');
                set_query_var('hampton_search_in_header', false);
                ?>
                <div class="search_wrap<?php
                if ($hampton_search_in_header) {
                    echo ' search_style_'.esc_attr($hampton_search_style);
                    if ($hampton_search_style != 'fullscreen') echo ' search_ajax';
                }
                ?>">
                    <div class="search_form_wrap">
                        <form role="search" method="get" class="search_form" action="<?php echo esc_url(home_url('/')); ?>">
                            <input type="text" class="search_field" placeholder="<?php esc_attr_e('Search', 'hampton'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s">
                            <button type="submit" class="search_submit icon-search"></button>
                            <?php if ($hampton_search_in_header && $hampton_search_style == 'fullscreen') { ?>
                                <a class="search_close icon-cancel"></a>
                            <?php } ?>
                        </form>
                    </div>
                    <div class="search_results widget_area"><a href="#" class="search_results_close icon-cancel"></a><div class="search_results_content"></div></div>
                </div>
             </div>
		</div>
	</div>
</article>
