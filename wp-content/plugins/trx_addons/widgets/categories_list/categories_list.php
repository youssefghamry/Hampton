<?php
/**
 * Widget: Categories list
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Load widget
if (!function_exists('trx_addons_widget_categories_list_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_categories_list_load' );
	function trx_addons_widget_categories_list_load() {
		register_widget('trx_addons_widget_categories_list');
	}
}

// Widget Class
class trx_addons_widget_categories_list extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_categories_list', 'description' => esc_html__('Display categories list with icons or images', 'trx_addons'));
		parent::__construct( 'trx_addons_widget_categories_list', esc_html__('ThemeREX Addons - Categories list', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {
		extract($args);

		global $post;

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');

		$style = isset($instance['style']) ? max(1, (int) $instance['style']) : 1;
		$number = isset($instance['number']) ? (int) $instance['number'] : '';
		$columns = isset($instance['columns']) ? (int) $instance['columns'] : '';
		$show_posts = isset($instance['show_posts']) ? (int) $instance['show_posts'] : 0;
		$show_children = isset($instance['show_children']) ? (int) $instance['show_children'] : 0;
		$cat_list = isset($instance['cat_list']) ? $instance['cat_list'] : '';

		$categories = get_categories(array(
			'type'                     => 'post',
			'taxonomy'                 => 'category',
			'include'                  => $cat_list,
			'number'                   => $number > 0 && empty($cat_list) ? $number : '',
			'parent'                   => $show_children && is_category() ? (int) get_query_var( 'cat' ) : '',
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 0,
			'hierarchical'             => 0,
			'pad_counts'               => $show_posts > 0 
		
		));

		// If result is empty - exit without output
		if (count($categories)==0) return;
		
		// Before widget (defined by themes)
		echo trim($before_widget);
			
		// Display the widget title if one was input (before and after defined by themes)
		if ($title) echo trim($before_title . $title . $after_title);
	
		// Display widget body
		?>
		<div class="categories_list categories_list_style_<?php echo esc_attr($style); ?>">
			<?php 
			if ($columns > 1) echo '<div class="'.esc_attr(trx_addons_get_columns_wrap_class()).'">';
			foreach ($categories as $cat) {
				$image = $style==1 ? trx_addons_get_category_icon($cat->term_id) : trx_addons_get_category_image($cat->term_id);
				set_query_var('trx_addons_args_categories_list', array(
					'style' => $style,
					'columns' => $columns,
					'image' => $image,
					'show_posts' => $show_posts,
					'cat' => $cat
				));
				if (($fdir = trx_addons_get_file_dir('widgets/categories_list/tpl.categories-list-'.trim($style).'.php')) != '') { include $fdir; }
				else if (($fdir = trx_addons_get_file_dir('widgets/categories_list/tpl.categories-list-1.php')) != '') { include $fdir; }
			}
			if ($columns > 1) echo '</div>';
			?>
		</div>
		<?php			

		// After widget (defined by themes)
		echo trim($after_widget);
	}

	// Update the widget settings
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Strip tags for title and comments count to remove HTML (important for text inputs)
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['style'] = (int) $new_instance['style'];
		$instance['number'] = (int) $new_instance['number'];
		$instance['columns'] = (int) $new_instance['columns'];
		$instance['show_posts'] = !empty($new_instance['show_posts']) ? 1 : 0;
		$instance['show_children'] = !empty($new_instance['show_children']) ? 1 : 0;
		$instance['cat_list'] = join(',', $new_instance['cat_list']);
		return $instance;
	}

	// Displays the widget settings controls on the widget panel
	function form($instance) {
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'style' => '1',
			'number' => '5',
			'columns' => '5',
			'show_posts' => '1',
			'show_children' => '0',
			'cat_list' => ''
			)
		);
		$title = $instance['title'];
		$style = (int) $instance['style'];
		$number = (int) $instance['number'];
		$columns = (int) $instance['columns'];
		$show_posts = (int) $instance['show_posts'];
		$show_children = (int) $instance['show_children'];
		$cat_list = $instance['cat_list'];
		// Prepare categories list
		$categories = get_categories(array(
			'type'                     => 'post',
			'taxonomy'                 => 'category',
			'orderby'                  => 'id',
			'order'                    => 'ASC',
			'hide_empty'               => 1,
			'hierarchical'             => 0,
			'pad_counts'               => true 
		
		));
		?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Widget title:', 'trx_addons'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('style')); ?>_1"><?php esc_html_e('Output style:', 'trx_addons'); ?></label><br />
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('style')); ?>_1" name="<?php echo esc_attr($this->get_field_name('style')); ?>" value="1" <?php echo (1==$style ? ' checked="checked"' : ''); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('style')); ?>_1"><?php esc_html_e('Style 1', 'trx_addons'); ?></label>
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('style')); ?>_2" name="<?php echo esc_attr($this->get_field_name('style')); ?>" value="2" <?php echo (2==$style ? ' checked="checked"' : ''); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('style')); ?>_2"><?php esc_html_e('Style 2', 'trx_addons'); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('cat_list')); ?>"><?php esc_html_e('Categories to show:', 'trx_addons'); ?></label>
			<span class="widgets_param_catlist">
				<?php 
				foreach ($categories as $cat) {
					?><input type="checkbox"
								value="<?php echo esc_attr($cat->term_id); ?>" 
								id="<?php echo esc_attr($this->get_field_id('cat_list')); ?>_<?php echo esc_attr($cat->term_id); ?>" 
								name="<?php echo esc_attr($this->get_field_name('cat_list')); ?>[]"
								<?php if (strpos(','.$cat_list.',', ','.$cat->term_id.',')!==false) echo ' checked="checked"'; ?>>
					<label for="<?php echo esc_attr($this->get_field_id('cat_list')); ?>_<?php echo esc_attr($cat->term_id); ?>"><?php echo esc_html($cat->name); ?></label><br><?php
				}
				?>
			</span>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number categories to show (if field above is empty):', 'trx_addons'); ?></label>
			<input type="text" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" value="<?php echo esc_attr($number); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('columns')); ?>"><?php esc_html_e('Columns number:', 'trx_addons'); ?></label>
			<input type="text" id="<?php echo esc_attr($this->get_field_id('columns')); ?>" name="<?php echo esc_attr($this->get_field_name('columns')); ?>" value="<?php echo esc_attr($columns); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('show_posts')); ?>_1"><?php esc_html_e('Show posts count:', 'trx_addons'); ?></label><br />
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('show_posts')); ?>_1" name="<?php echo esc_attr($this->get_field_name('show_posts')); ?>" value="1" <?php echo (1==$show_posts ? ' checked="checked"' : ''); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('show_posts')); ?>_1"><?php esc_html_e('Show', 'trx_addons'); ?></label>
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('show_posts')); ?>_0" name="<?php echo esc_attr($this->get_field_name('show_posts')); ?>" value="0" <?php echo (0==$show_posts ? ' checked="checked"' : ''); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('show_posts')); ?>_0"><?php esc_html_e('Hide', 'trx_addons'); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('show_children')); ?>_1"><?php esc_html_e('Only children of the current category:', 'trx_addons'); ?></label><br />
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('show_children')); ?>_1" name="<?php echo esc_attr($this->get_field_name('show_children')); ?>" value="1" <?php echo (1==$show_children ? ' checked="checked"' : ''); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('show_children')); ?>_1"><?php esc_html_e('Children', 'trx_addons'); ?></label>
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('show_children')); ?>_0" name="<?php echo esc_attr($this->get_field_name('show_children')); ?>" value="0" <?php echo (0==$show_children ? ' checked="checked"' : ''); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('show_children')); ?>_0"><?php esc_html_e('From root', 'trx_addons'); ?></label>
		</p>
	<?php
	}
}

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_widget_categories_list_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_categories_list_load_scripts_front');
	function trx_addons_widget_categories_list_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			trx_addons_enqueue_style( 'trx_addons-widget_categories_list', trx_addons_get_file_url('widgets/categories_list/categories_list.css'), array(), null );
		}
	}
}

	
// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_categories_list_merge_styles' ) ) {
	add_action("trx_addons_filter_merge_styles", 'trx_addons_widget_categories_list_merge_styles');
	function trx_addons_widget_categories_list_merge_styles($list) {
		$list[] = 'widgets/categories_list/categories_list.css';
		return $list;
	}
}



// trx_widget_categories_list
//-------------------------------------------------------------
/*
[trx_widget_categories_list id="unique_id" title="Widget title" style="1" number="4" columns="4" show_posts="0|1" show_children="0|1" cat_list="id1,id2,id3,..."]
*/
if ( !function_exists( 'trx_addons_sc_widget_categories_list' ) ) {
	function trx_addons_sc_widget_categories_list($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_widget_categories_list', $atts, array(
			// Individual params
			"title" => '',
			'style' => '1',
			'number' => '5',
			'columns' => '5',
			'show_posts' => '1',
			'show_children' => '0',
			'cat_list' => '',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		extract($atts);
		$type = 'trx_addons_widget_categories_list';
		$output = '';
		global $wp_widget_factory, $TRX_ADDONS_STORAGE;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
							. ' class="widget_area sc_widget_categories_list' 
								. (trx_addons_exists_visual_composer() ? ' vc_widget_categories_list wpb_content_element' : '') 
								. (!empty($class) ? ' ' . esc_attr($class) : '') 
								. '"'
							. ($css ? ' style="'.esc_attr($css).'"' : '')
						. '>';
			ob_start();
			the_widget( $type, $atts, trx_addons_prepare_widgets_args($TRX_ADDONS_STORAGE['widgets_args'], $id ? $id.'_widget' : 'widget_categories_list', 'widget_categories_list') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_categories_list', $atts, $content);
	}
	add_shortcode("trx_widget_categories_list", "trx_addons_sc_widget_categories_list");
}


// Add [trx_widget_categories_list] in the VC shortcodes list
if (!function_exists('trx_addons_sc_widget_categories_list_add_in_vc')) {
	function trx_addons_sc_widget_categories_list_add_in_vc() {

		if (!trx_addons_exists_visual_composer()) return;
		
		vc_map( apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_categories_list",
				"name" => esc_html__("Widget Categories List", 'trx_addons'),
				"description" => wp_kses_data( __("Insert categories list with icons or images", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_categories_list',
				"class" => "trx_widget_categories_list",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => esc_html__("Widget title", 'trx_addons'),
						"description" => wp_kses_data( __("Title of the widget", 'trx_addons') ),
						"admin_label" => true,
						"type" => "textfield"
					),
					array(
						"param_name" => "style",
						"heading" => esc_html__("Style", 'trx_addons'),
						"description" => wp_kses_data( __("Select style to display categories list", 'trx_addons') ),
						"std" => 1,
						"value" => array(
							esc_html__('Style 1', 'trx_addons') => 1,
							esc_html__('Style 2', 'trx_addons') => 2
							),
						"type" => "dropdown"
					),
					array(
						"param_name" => "number",
						"heading" => esc_html__("Number of categories to show", 'trx_addons'),
						"description" => wp_kses_data( __("How many categories display in widget?", 'trx_addons') ),
						"admin_label" => true,
						"value" => "5",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Coulumns number to show", 'trx_addons'),
						"description" => wp_kses_data( __("How many columns use to display categories list?", 'trx_addons') ),
						"admin_label" => true,
						"value" => "5",
						"type" => "textfield"
					),
					array(
						"param_name" => "show_posts",
						"heading" => esc_html__("Show posts number", 'trx_addons'),
						"description" => wp_kses_data( __("Do you want display posts number?", 'trx_addons') ),
						"std" => "1",
						"value" => array("Show posts number" => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "show_children",
						"heading" => esc_html__("Show children", 'trx_addons'),
						"description" => wp_kses_data( __("Show only children of current category", 'trx_addons') ),
						"std" => "0",
						"value" => array("Show children" => "1" ),
						"type" => "checkbox"
					),
					// Common VC parameters
					'id' => array(
						"param_name" => "id",
						"heading" => esc_html__("Element ID", 'trx_addons'),
						"description" => wp_kses_data( __("ID for current element", 'trx_addons') ),
						"group" => esc_html__('ID &amp; Class', 'trx_addons'),
						"type" => "textfield"
					),
					'class' => array(
						"param_name" => "class",
						"heading" => esc_html__("Element CSS class", 'trx_addons'),
						"description" => wp_kses_data( __("CSS class for current element", 'trx_addons') ),
						"group" => esc_html__('ID &amp; Class', 'trx_addons'),
						"type" => "textfield"
					),
					'css' => array(
						'param_name' => 'css',
						'heading' => __( 'CSS box', 'trx_addons' ),
						'group' => __( 'Design Options', 'trx_addons' ),
						'type' => 'css_editor'
					)
				)
			), 'trx_widget_categories_list') );
			
		class WPBakeryShortCode_Trx_Widget_Categories_List extends WPBakeryShortCode {}

	}
	add_action('after_setup_theme', 'trx_addons_sc_widget_categories_list_add_in_vc', 11);
}


// Add images and icons to categories
//--------------------------------------------------------------------------
if (!function_exists('trx_addons_widget_categories_list_init')) {
	add_action( 'init', 'trx_addons_widget_categories_list_init' );
	function trx_addons_widget_categories_list_init() {
		// Add image property to the "category" taxonomy
		add_action('category_edit_form_fields',		'trx_addons_widget_categories_list_show_custom_fields', 10, 1 );
		add_action('category_add_form_fields',		'trx_addons_widget_categories_list_show_custom_fields', 10, 1 );
		add_action('edited_category',				'trx_addons_widget_categories_list_save_custom_fields', 10, 1 );
		add_action('created_category',				'trx_addons_widget_categories_list_save_custom_fields', 10, 1 );
		add_filter('manage_edit-category_columns',	'trx_addons_widget_categories_list_add_custom_column', 9);
		add_filter('manage_category_custom_column',	'trx_addons_widget_categories_list_fill_custom_column', 9, 3);
	}
}

// Return image from the category
if (!function_exists('trx_addons_get_category_image')) {
	function trx_addons_get_category_image($term_id=0) {
		$url = '';
		if ($term_id == 0 && is_category())
			$term_id = (int) get_query_var('cat');
		if ($term_id > 0)
			$url = get_option('trx_addons_category_image_' . $term_id);
		return $url;
	}
}

// Return small image (icon) from the category
if (!function_exists('trx_addons_get_category_icon')) {
	function trx_addons_get_category_icon($term_id=0) {
		$url = '';
		if ($term_id == 0 && is_category())
			$term_id = (int) get_query_var('cat');
		if ($term_id > 0)
			$url = get_option('trx_addons_category_icon_' . $term_id);
		return $url;
	}
}

// Add the fields to the "category" taxonomy, using our callback function
if (!function_exists('trx_addons_widget_categories_list_show_custom_fields')) {
	//add_action('category_edit_form_fields',		'trx_addons_widget_categories_list_show_custom_fields', 10, 1 );
	//add_action('category_add_form_fields',		'trx_addons_widget_categories_list_show_custom_fields', 10, 1 );
	function trx_addons_widget_categories_list_show_custom_fields($cat) {
		$cat_id = !empty($cat->term_id) ? $cat->term_id : 0;
		// Category's image
		echo ((int) $cat_id > 0 ? '<tr' : '<div') . ' class="form-field">'
			. ((int) $cat_id > 0 ? '<th valign="top" scope="row">' : '<div>');
		?><label for="trx_addons_category_image"><?php esc_html_e('Large image URL:', 'trx_addons'); ?></label><?php
		echo ((int) $cat_id > 0 ? '</th>' : '</div>')
			. ((int) $cat_id > 0 ? '<td valign="top">' : '<div>');
		$cat_img = $cat_id > 0 ? get_option('trx_addons_category_image_' . $cat_id) : ''; 
		?><input id="trx_addons_category_image" name="trx_addons_category_image" value="<?php echo esc_url($cat_img); ?>"><?php
		echo trim(trx_addons_options_show_custom_field('trx_addons_category_image_button', array('type' => 'mediamanager', 'linked_field_id' => 'trx_addons_category_image'), null));
		if (empty($cat_img)) $cat_img = apply_filters('trx_addons_filter_no_image', trx_addons_get_file_url('css/images/no-image.jpg'));
		?><img src="<?php echo esc_url($cat_img); ?>" class="trx_addons_category_image_preview"><?php
		echo (int) $cat_id > 0 ? '</td></tr>' : '</div></div>';

		// Category's icon
		echo ((int) $cat_id > 0 ? '<tr' : '<div') . ' class="form-field">'
			. ((int) $cat_id > 0 ? '<th valign="top" scope="row">' : '<div>');
		?><label for="trx_addons_category_icon"><?php esc_html_e('Small image (icon) URL:', 'trx_addons'); ?></label><?php
		echo ((int) $cat_id > 0 ? '</th>' : '</div>')
			. ((int) $cat_id > 0 ? '<td valign="top">' : '<div>');
		$cat_img = $cat_id > 0 ? get_option('trx_addons_category_icon_' . $cat_id) : ''; 
		?><input id="trx_addons_category_icon" name="trx_addons_category_icon" value="<?php echo esc_url($cat_img); ?>"><?php
		echo trim(trx_addons_options_show_custom_field('trx_addons_category_icon_button', array('type' => 'mediamanager', 'linked_field_id' => 'trx_addons_category_icon'), null));
		if (empty($cat_img)) $cat_img = apply_filters('trx_addons_filter_no_image', trx_addons_get_file_url('css/images/no-image.jpg'));
		?><img src="<?php echo esc_url($cat_img); ?>" class="trx_addons_category_icon_preview"><?php
		echo (int) $cat_id > 0 ? '</td></tr>' : '</div></div>';
	}
}

// Save the fields to the "category" taxonomy, using our callback function
if (!function_exists('trx_addons_widget_categories_list_save_custom_fields')) {
	//add_action('edited_category',		'trx_addons_widget_categories_list_save_custom_fields', 10, 1 );
	//add_action('created_category',	'trx_addons_widget_categories_list_save_custom_fields', 10, 1 );
	function trx_addons_widget_categories_list_save_custom_fields($term_id) {
		if (isset($_POST['trx_addons_category_image']))
			update_option('trx_addons_category_image_' . intval($term_id), $_POST['trx_addons_category_image']);
		if (isset($_POST['trx_addons_category_icon']))
			update_option('trx_addons_category_icon_' . intval($term_id), $_POST['trx_addons_category_icon']);

	}
}

// Create additional column in the categories list
if (!function_exists('trx_addons_widget_categories_list_add_custom_column')) {
	//add_filter('manage_edit-category_columns',	'trx_addons_widget_categories_list_add_custom_column', 9);
	function trx_addons_widget_categories_list_add_custom_column( $columns ){
		$columns['category_image'] = esc_html__('Image', 'trx_addons');
		$columns['category_icon'] = esc_html__('Icon', 'trx_addons');
		return $columns;
	}
}

// Fill image column in the categories list
if (!function_exists('trx_addons_widget_categories_list_fill_custom_column')) {
	//add_filter('manage_category_custom_column',	'trx_addons_widget_categories_list_fill_custom_column', 9, 3);
	function trx_addons_widget_categories_list_fill_custom_column($output='', $column_name='', $tax_id=0) {
		if ($column_name == 'category_image' && ($cat_img = trx_addons_get_category_image($tax_id))) {
			?><img class="trx_addons_category_image_preview" src="<?php echo esc_url(trx_addons_add_thumb_size($cat_img, trx_addons_get_thumb_size('tiny'))); ?>" alt=""><?php
		}
		if ($column_name == 'category_icon' && ($cat_img = trx_addons_get_category_icon($tax_id))) {
			?><img class="trx_addons_category_icon_preview" src="<?php echo esc_url(trx_addons_add_thumb_size($cat_img, trx_addons_get_thumb_size('tiny'))); ?>" alt=""><?php
		}
	}
}
?>