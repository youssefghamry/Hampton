<?php
/**
 * The "Style 2" template for displaying categories list
 *
 * Used for widget Categories List.
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

$args = get_query_var('trx_addons_args_categories_list');
$cat_img = $args['image'];
$cat_link = get_category_link($args['cat']->term_id);
$columns = $args['columns'];
if ((int)$columns > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $columns)); ?>"><?php
}
?>
<div class="categories_list_item">
	<div class="categories_list_image"><a href="<?php echo esc_url($cat_link); ?>">
		<img src="<?php echo esc_url(empty($cat_img) 
								? apply_filters('trx_addons_filter_no_image', trx_addons_get_file_url('css/images/no-image.jpg'))
								: trx_addons_add_thumb_size($cat_img, trx_addons_get_thumb_size((int)$columns > 3 ? 'avatar' : 'medium-category'))
								); ?>" alt="">
	</a></div>
    <div class="categories_list_desc">
        <?php
        if ($args['show_posts']) {
            ?><span class="categories_list_count">0<?php echo esc_html($args['cat']->count); ?>.</span><?php
        }?>
	<h5 class="categories_list_title">
            <?php echo esc_html($args['cat']->name); ?>
	</h5>
        <a href="<?php echo esc_url($cat_link); ?>" class="categories_list_label">
            <?php echo esc_html('view gallery', 'trx_addons'); ?>
        </a>

    </div>

</div>
<?php
if ((int)$columns > 1) {
	?></div><?php
}
?>