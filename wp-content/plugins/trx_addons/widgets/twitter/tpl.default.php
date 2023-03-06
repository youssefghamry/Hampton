<?php
/**
 * The style "default" of the Twitter
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.4.3
 */

$args = get_query_var('trx_addons_args_widget_twitter');
$twitter_username = isset($args['twitter_username']) ? $args['twitter_username'] : '';	
$twitter_count = isset($args['twitter_count']) ? $args['twitter_count'] : '';	
$follow = isset($args['follow']) ? (int) $args['follow'] : 0;
$args['columns'] = (int)$args['columns'] < 1 ? $twitter_count : min($args['columns'], $twitter_count);
$args['columns'] = max(1, min(12, (int) $args['columns']));
$args['slider'] = (int)$args['slider'] > 0 && $twitter_count > $args['columns'];
$args['slides_space'] = max(0, (int) $args['slides_space']);

?><div class="widget_content">
	<div class="sc_twitter sc_twitter_<?php
				echo esc_attr($args['type']);
				if ($args['slider']) echo ' swiper-slider-container slider_swiper slider_noresize slider_nocontrols '.((int)$args['slider_pagination'] > 0 ? 'slider_pagination' : 'slider_nopagination');
				?>"<?php
			echo ((int)$args['columns'] > 1 
						? ' data-slides-per-view="' . esc_attr($args['columns']) . '"' 
						: '')
				. ((int)$args['slides_space'] > 0 
						? ' data-slides-space="' . esc_attr($args['slides_space']) . '"' 
						: '')
				. ' data-slides-min-width="150"';
	?>><?php
		if ($args['slider']) {
			?><div class="sc_twitter_slider sc_item_slider slides swiper-wrapper"><?php
		} else if ((int)$args['columns'] > 1) {
			?><div class="sc_twitter_columns sc_item_columns <?php echo esc_attr(trx_addons_get_columns_wrap_class()); ?> columns_padding_bottom"><?php
		} else {
			?><div class="sc_twitter_content sc_item_content"><?php
		}	

		$cnt = 0;
		if (is_array($data) && count($data) > 0) {
			foreach ($data as $tweet) {
				if (substr($tweet['text'], 0, 1)=='@') continue;

				if ($args['slider']) {
					?><div class="swiper-slide"><?php
				} else if ((int)$args['columns'] > 1) {
					?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?>"><?php
				}
				?>
				<div class="sc_twitter_item<?php if ($cnt==$twitter_count-1) echo ' last'; ?>">
					<div class="sc_twitter_item_icon icon-twitter"></div>
					<div class="sc_twitter_item_content"><a href="<?php echo esc_url('https://twitter.com/'.trim($twitter_username)); ?>" class="username" target="_blank">@<?php echo esc_html($tweet['user']['screen_name']); ?></a> <?php
						echo force_balance_tags(trx_addons_prepare_twitter_text($tweet));
					?></div>
				</div>
				<?php
				if ($args['slider'] || (int)$args['columns'] > 1) {
					?></div><?php
				}
				if (++$cnt >= $twitter_count) break;
			}
		}

		?></div><?php

		if ((int)$args['slider'] > 0 && (int)$args['slider_pagination'] > 0) {
			?><div class="slider_pagination_wrap swiper-pagination"></div><?php
		}

	?></div><!-- /.sc_twitter --><?php

    if ($follow) {
        ?><a href="<?php echo esc_url('http://twitter.com/'.trim($twitter_username)); ?>" class="widget_twitter_follow"><?php esc_html_e('Follow us', 'trx_addons'); ?></a><?php
    }

?></div><!-- /.widget_content -->