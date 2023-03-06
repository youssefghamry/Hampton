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

?><div class="widget_content"><ul class="sc_twitter sc_twitter_list"><?php
	$cnt = 0;
	if (is_array($data) && count($data) > 0) {
		foreach ($data as $tweet) {
			if (substr($tweet['text'], 0, 1)=='@') continue;
			?><li<?php if ($cnt==$twitter_count-1) echo ' class="last"'; ?>><a href="<?php echo esc_url('https://twitter.com/'.trim($twitter_username)); ?>" class="username" target="_blank">@<?php echo esc_html($tweet['user']['screen_name']); ?></a> <?php
					echo force_balance_tags(trx_addons_prepare_twitter_text($tweet));
			?></li><?php
			if (++$cnt >= $twitter_count) break;
		}
	}
?></ul><?php

if ($follow) {
	?><a href="<?php echo esc_url('http://twitter.com/'.trim($twitter_username)); ?>" class="widget_twitter_follow"><?php esc_html_e('Follow us', 'trx_addons'); ?></a><?php
}

?></div>