<?php
/**
 * Widget: Posts or Revolution slider
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Load widget
if (!function_exists('trx_addons_widget_slider_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_slider_load' );
	function trx_addons_widget_slider_load() {
		register_widget( 'trx_addons_widget_slider' );
	}
}

// Widget Class
class trx_addons_widget_slider extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_slider', 'description' => esc_html__('Display theme slider', 'trx_addons') );
		parent::__construct( 'trx_addons_widget_slider', esc_html__('ThemeREX Addons - Posts slider or Revolution slider', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );
		$engine = isset($instance['engine']) ? $instance['engine'] : 'swiper';

		// Before widget (defined by themes)
		echo trim($before_widget);

		// Display the widget title if one was input (before and after defined by themes)
		if ($title)	echo trim($before_title . $title . $after_title);

		// Widget body
		$html = '';
		if ($engine == 'swiper') {
			$slider_id = isset($instance['id']) ? $instance['id'] : '';
			$slider_style = isset($instance['slider_style']) ? $instance['slider_style'] : 'default';
			$slides_per_view = isset($instance['slides_per_view']) ? $instance['slides_per_view'] : 1;
			$slides_space = isset($instance['slides_space']) ? $instance['slides_space'] : 1;
			$slides = isset($instance['slides']) ? $instance['slides'] : array();
			$slides_type = isset($instance['slides_type']) ? $instance['slides_type'] : 'bg';
			$slides_ratio = isset($instance['slides_ratio']) ? $instance['slides_ratio'] : '16:9';
			$noresize = isset($instance['noresize']) ? (int) $instance['noresize'] : 0;
			$effect = isset($instance['effect']) ? $instance['effect'] : 'slide';
			$height = isset($instance['height']) ? $instance['height'] : 0;
			$category = isset($instance['category']) ? (int) $instance['category'] : 0;
			$posts = isset($instance['posts']) ? $instance['posts'] : 5;
			$interval = isset($instance['interval']) ? (int) $instance['interval'] : 7000;
			$titles = isset($instance['titles']) ? $instance['titles'] : 'center';
			$large = isset($instance['large']) && $instance['large'] > 0 ? "on" : "off";
			$controls = isset($instance['controls']) && $instance['controls'] > 0 ? "on" : "off";
            $controls_align = isset($instance['controls_align']) ? $instance['controls_align'] : 'left';
			$pagination = isset($instance['pagination']) && $instance['pagination'] > 0 ? "on" : "off";
			$label_prev = isset($instance['label_prev']) ? $instance['label_prev'] : '';
			$label_next = isset($instance['label_next']) ? $instance['label_next'] : '';
			$count = $ids = $posts;
			if (strpos($ids, ',')!==false) {
				$category = '';
				$count = 0;
			} else {
				$ids = '';
				if (empty($count)) $count = 3;
			}
			if ($count > 0 || !empty($ids)) {
				$html = trx_addons_build_slider_layout(array(
					'mode' => empty($slides) ? 'posts' : 'custom',
					'style' => $slider_style,
					'slides_type' => $slides_type,
					'slides_ratio' => $slides_ratio,
					'noresize' => $noresize,
					'effect' => $effect,
					'controls' => $controls,
					'controls_align' => $controls_align,
					'label_prev' => $label_prev,
					'label_next' => $label_next,
					'pagination' => $pagination,
					'pagination_type' => $slider_style=='modern' ? 'fraction' : 'bullets',
					'titles' => $titles,
					'large' => $large,
					'interval' => $interval,
					'height' => $height,
					'per_view' => $slides_per_view,
					'slides_space' => $slides_space,
					'cat' => $category,
					'ids' => $ids,
					'count' => $count,
					'orderby' => "date",
					'order' => "desc",
					'class' => "",	// "slider_height_fixed"
					'id' => $slider_id
					), $slides
				);
			}
		} else if ($engine=='revo') {
			$alias = isset($instance['alias']) ? $instance['alias'] : '';
			if (!empty($alias)) {
				$html = do_shortcode('[rev_slider alias="'.esc_attr($alias).'"]');
				if (empty($html)) $html = do_shortcode('[rev_slider '.esc_attr($alias).']');
			}
		}
		if (!empty($html)) {
			?>
			<div class="slider_wrap slider_engine_<?php echo esc_attr($engine); ?><?php if ($engine=='revo') echo ' slider_alias_'.esc_attr($alias); ?>">
				<?php echo trim($html); ?>
			</div>
			<?php 
		}

		// After widget (defined by themes)
		echo trim($after_widget);
	}

	// Update the widget settings.
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Strip tags for title and comments count to remove HTML (important for text inputs)
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['engine'] = strip_tags( $new_instance['engine'] );
		$instance['slider_style'] = strip_tags( $new_instance['slider_style'] );
		$instance['slides_per_view'] = intval( $new_instance['slides_per_view'] );
		$instance['slides_space'] = intval( $new_instance['slides_space'] );
		$instance['effect'] = strip_tags( $new_instance['effect'] );
		$instance['height'] = intval( $new_instance['height'] );
		$instance['category'] = intval( $new_instance['category'] );
		$instance['posts'] = strip_tags( $new_instance['posts'] );
		$instance['interval'] = intval( $new_instance['interval'] );
		$instance['titles'] = strip_tags( $new_instance['titles'] );
		$instance['large'] = max(0, min(1, intval( $new_instance['large'] )));
		$instance['controls'] = max(0, min(1, intval( $new_instance['controls'] )));
        $instance['controls_align'] = strip_tags( $new_instance['controls_align'] );
		$instance['pagination'] = max(0, min(1, intval( $new_instance['pagination'] )));
		if (isset($new_instance['alias']))
			$instance['alias'] = strip_tags( $new_instance['alias'] );

		return $instance;
	}

	// Displays the widget settings controls on the widget panel.
	function form( $instance ) {
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'engine' => 'swiper',
			'slider_style' => 'default',
			'slides_per_view' => '1',
			'slides_space' => '0',
			'effect' => 'slide',
			'height' => '345',
			'alias' => '',
			'titles' => 'center',
			'large' => 0,
			'controls' => 0,
			'pagination' => 0,
			'category' => '0',
			'controls_align' => 'left',
			'posts' => '5',
			'interval' => '7000'
			)
		);
		$title = $instance['title'];
		$engine = $instance['engine'];
		$slider_style = $instance['slider_style'];
		$slides_per_view = $instance['slides_per_view'];
		$slides_space = $instance['slides_space'];
		$effect = $instance['effect'];
		$height = $instance['height'];
		$category = $instance['category'];
		$titles = $instance['titles'];
		$large = $instance['large'];
		$controls = $instance['controls'];
        $controls_align = $instance['controls_align'];
		$pagination = $instance['pagination'];
		$posts = $instance['posts'];
		$interval = $instance['interval'];

		$categories_list = trx_addons_array_merge(array(0=>esc_html__('- Select category -', 'trx_addons')), trx_addons_get_list_categories());
		
		$sliders_list = array(
			"swiper" => esc_html__("Posts slider (Swiper)", 'trx_addons')
		);
		
		if (trx_addons_exists_revslider()) {
			$alias = !empty($instance['alias']) ? $instance['alias'] : '';
			$revo_alias_list = trx_addons_get_list_revsliders();
			$sliders_list["revo"] = esc_html__("Layer slider (Revolution)", 'trx_addons');
		}
		
		$titles_list = array(
			'no' => esc_html__('No titles', 'trx_addons'),
			'center' => esc_html__('Center', 'trx_addons'),
			'bottom' => esc_html__('Bottom Center', 'trx_addons'),
			'lb' => esc_html__('Bottom Left', 'trx_addons'),
			'rb' => esc_html__('Bottom Right', 'trx_addons')
		);
		?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'trx_addons'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($title); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('engine')); ?>"><?php esc_html_e('Slider engine:', 'trx_addons'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('engine')); ?>" name="<?php echo esc_attr($this->get_field_name('engine')); ?>" class="widgets_param_fullwidth">
			<?php
				if (is_array($sliders_list) && count($sliders_list) > 0) {
					foreach ($sliders_list as $slug => $name) {
						echo '<option value="'.esc_attr($slug).'"'.($slug==$engine ? ' selected="selected"' : '').'>'.esc_html($name).'</option>';
					}
				}
			?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'height' )); ?>"><?php esc_html_e('Slider height', 'trx_addons'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'height' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'height' )); ?>" value="<?php echo esc_attr($height); ?>" class="widgets_param_fullwidth" />
		</p>

		<?php if (trx_addons_exists_revslider()) { ?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('alias')); ?>"><?php esc_html_e('Revolution Slider alias', 'trx_addons'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('alias')); ?>" class="widgets_param_fullwidth" name="<?php echo esc_attr($this->get_field_name('alias')); ?>">
			<?php
				if (is_array($revo_alias_list) && count($revo_alias_list) > 0) {
					foreach ($revo_alias_list as $slug => $name) {
						echo '<option value="'.esc_attr($slug).'"'.($slug==$alias ? ' selected="selected"' : '').'>'.esc_html($name).'</option>';
					}
				}
			?>
			</select>
		</p>
		<?php } ?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('slider_style')); ?>"><?php esc_html_e('Swiper style', 'trx_addons'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('slider_style')); ?>" name="<?php echo esc_attr($this->get_field_name('slider_style')); ?>" class="widgets_param_fullwidth">
				<option value="default"<?php if ($slider_style=='default') echo ' selected="selected"'; ?>><?php esc_html_e('Default', 'trx_addons'); ?></option>
				<option value="modern"<?php if ($slider_style=='modern') echo ' selected="selected"'; ?>><?php esc_html_e('Modern', 'trx_addons'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('effect')); ?>"><?php esc_html_e('Swiper effect', 'trx_addons'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('effect')); ?>" name="<?php echo esc_attr($this->get_field_name('effect')); ?>" class="widgets_param_fullwidth">
				<option value="slide"<?php if ($slider_style=='slide') echo ' selected="selected"'; ?>><?php esc_html_e('Slide', 'trx_addons'); ?></option>
				<option value="fade"<?php if ($slider_style=='fade') echo ' selected="selected"'; ?>><?php esc_html_e('Fade', 'trx_addons'); ?></option>
				<option value="cube"<?php if ($slider_style=='cube') echo ' selected="selected"'; ?>><?php esc_html_e('Cube', 'trx_addons'); ?></option>
				<option value="flip"<?php if ($slider_style=='flip') echo ' selected="selected"'; ?>><?php esc_html_e('Flip', 'trx_addons'); ?></option>
				<option value="coverflow"<?php if ($slider_style=='coverflow') echo ' selected="selected"'; ?>><?php esc_html_e('Coverflow', 'trx_addons'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php esc_html_e('Category for the Swiper', 'trx_addons'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('category')); ?>" name="<?php echo esc_attr($this->get_field_name('category')); ?>" class="widgets_param_fullwidth">
			<?php
				if (is_array($categories_list) && count($categories_list) > 0) {
					foreach ($categories_list as $slug => $name) {
						echo '<option value="'.esc_attr($slug).'"'.($slug==$category ? ' selected="selected"' : '').'>'.esc_html($name).'</option>';
					}
				}
			?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'slides_per_view' )); ?>"><?php esc_html_e('Slides per view in the Swiper', 'trx_addons'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'slides_per_view' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'slides_per_view' )); ?>" value="<?php echo esc_attr($slides_per_view); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'slides_space' )); ?>"><?php esc_html_e('Space between slides in the Swiper', 'trx_addons'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'slides_space' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'slides_space' )); ?>" value="<?php echo esc_attr($slides_space); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'posts' )); ?>"><?php esc_html_e('Swiper posts:', 'trx_addons'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'posts' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'posts' )); ?>" value="<?php echo esc_attr($posts); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'interval' )); ?>"><?php esc_html_e('Swiper interval (in msec.)', 'trx_addons'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'interval' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'interval' )); ?>" value="<?php echo esc_attr($interval); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('titles')); ?>"><?php esc_html_e('Show titles in the Swiper', 'trx_addons'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('titles')); ?>" name="<?php echo esc_attr($this->get_field_name('titles')); ?>" class="widgets_param_fullwidth">
			<?php
				if (is_array($titles_list) && count($titles_list) > 0) {
					foreach ($titles_list as $slug => $name) {
						echo '<option value="'.esc_attr($slug).'"'.($slug==$titles ? ' selected="selected"' : '').'>'.esc_html($name).'</option>';
					}
				}
			?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('large')); ?>_1"><?php esc_html_e('Show large titles:', 'trx_addons'); ?></label><br />
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('large')); ?>_1" name="<?php echo esc_attr($this->get_field_name('large')); ?>" value="1" <?php echo (1==$large ? ' checked="checked"' : ''); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('large')); ?>_1"><?php esc_html_e('Large', 'trx_addons'); ?></label>
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('large')); ?>_0" name="<?php echo esc_attr($this->get_field_name('large')); ?>" value="0" <?php echo (0==$large ? ' checked="checked"' : ''); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('large')); ?>_0"><?php esc_html_e('Small', 'trx_addons'); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('controls')); ?>_1"><?php esc_html_e('Show arrows:', 'trx_addons'); ?></label><br />
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('controls')); ?>_1" name="<?php echo esc_attr($this->get_field_name('controls')); ?>" value="1" <?php echo (1==$controls ? ' checked="checked"' : ''); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('controls')); ?>_1"><?php esc_html_e('Show', 'trx_addons'); ?></label>
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('controls')); ?>_0" name="<?php echo esc_attr($this->get_field_name('controls')); ?>" value="0" <?php echo (0==$controls ? ' checked="checked"' : ''); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('controls')); ?>_0"><?php esc_html_e('Hide', 'trx_addons'); ?></label>
		</p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('controls_align')); ?>"><?php esc_html_e('Controls align', 'trx_addons'); ?></label>
            <select id="<?php echo esc_attr($this->get_field_id('controls_align')); ?>" name="<?php echo esc_attr($this->get_field_name('controls_align')); ?>" class="widgets_param_fullwidth">
                <option value="slide"<?php if ($slider_style=='left') echo ' selected="selected"'; ?>><?php esc_html_e('Left', 'trx_addons'); ?></option>
                <option value="fade"<?php if ($slider_style=='right') echo ' selected="selected"'; ?>><?php esc_html_e('Right', 'trx_addons'); ?></option>
            </select>
        </p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('pagination')); ?>_1"><?php esc_html_e('Show pagination:', 'trx_addons'); ?></label><br />
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('pagination')); ?>_1" name="<?php echo esc_attr($this->get_field_name('pagination')); ?>" value="1" <?php echo (1==$pagination ? ' checked="checked"' : ''); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('pagination')); ?>_1"><?php esc_html_e('Show', 'trx_addons'); ?></label>
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('pagination')); ?>_0" name="<?php echo esc_attr($this->get_field_name('pagination')); ?>" value="0" <?php echo (0==$pagination ? ' checked="checked"' : ''); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('pagination')); ?>_0"><?php esc_html_e('Hide', 'trx_addons'); ?></label>
		</p>
		
	<?php
	}
}

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_widget_slider_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_slider_load_scripts_front');
	function trx_addons_widget_slider_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			trx_addons_enqueue_style( 'trx_addons-widget_slider', trx_addons_get_file_url('widgets/slider/slider.css'), array(), null );
			// Attention! Slider's script will be loaded always, because it used not only in this widget, but in the many CPT, SC, etc.
			trx_addons_enqueue_script( 'trx_addons-widget_slider', trx_addons_get_file_url('widgets/slider/slider.js'), array('jquery'), null, true );
		}
	}
}

	
// Merge widget's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_slider_merge_styles' ) ) {
	add_action("trx_addons_filter_merge_styles", 'trx_addons_widget_slider_merge_styles');
	function trx_addons_widget_slider_merge_styles($list) {
		$list[] = 'widgets/slider/slider.css';
		return $list;
	}
}

	
// Merge widget's specific scripts into single file
if ( !function_exists( 'trx_addons_widget_slider_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_widget_slider_merge_scripts');
	function trx_addons_widget_slider_merge_scripts($list) {
		$list[] = 'widgets/slider/slider.js';
		return $list;
	}
}



// trx_widget_slider
//-------------------------------------------------------------
/*
[trx_widget_slider id="unique_id" title="Widget title" engine="revo" alias="home_slider_1"]
	[trx_slide title="Slide title" subtitle="Slide subtitle" link="" video_url="URL to video" video_embed="or HTML-code with iframe"]Slide content[/trx_slide]
	...
[/trx_widget_slider]
*/
if ( !function_exists( 'trx_addons_sc_widget_slider' ) ) {
	function trx_addons_sc_widget_slider($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_widget_slider', $atts, array(
			// Individual params
			'title' => '',
			'engine' => 'swiper',
			'slider_style' => 'default',
			'slides_per_view' => '1',
			'slides_space' => '0',
			'slides_type' => 'bg',
			'slides_ratio' => '16:9',
			'noresize' => '0',
			'effect' => 'slide',
			'height' => '',
			'alias' => '',
			'category' => '0',
			'posts' => '5',
			'interval' => '7000',
			'titles' => 'center',
			'large' => 0,
            'controls_align' => 'left',
			'controls' => 0,
			'pagination' => 0,
			'slides' => '',
			'label_prev' => esc_html__('Prev|PHOTO', 'trx_addons'),				// Label of the 'Prev Slide' button (Modern style)
			'label_next' => esc_html__('Next|PHOTO', 'trx_addons'),				// Label of the 'Next Slide' button (Modern style)
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);

		global $wp_widget_factory, $TRX_ADDONS_STORAGE;

		if (function_exists('vc_param_group_parse_atts'))
			$atts['slides'] = (array) vc_param_group_parse_atts( $atts['slides'] );
		if (count($atts['slides']) == 0 || count($atts['slides'][0]) == 0) {
			$atts['slides'] = $TRX_ADDONS_STORAGE['trx_slide_data'] = array();
			$content = do_shortcode($content);
			if (count($TRX_ADDONS_STORAGE['trx_slide_data']) > 0) {
				$atts['slides'] = $TRX_ADDONS_STORAGE['trx_slide_data'];
			}
		}

		$type = 'trx_addons_widget_slider';
		$output = '';
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$output = '<div' . ($atts['id'] ? ' id="'.esc_attr($atts['id']).'"' : '')
							. ' class="widget_area sc_widget_slider sc_slider_controls_align_'.esc_attr($atts['controls_align'])
								. (trx_addons_exists_visual_composer() ? ' vc_widget_slider wpb_content_element' : '') 
								. (!empty($atts['class']) ? ' ' . esc_attr($atts['class']) : '') 
								. '"'
							. ($atts['css'] ? ' style="'.esc_attr($atts['css']).'"' : '')
						. '>';
			ob_start();
			the_widget( $type, $atts, trx_addons_prepare_widgets_args($TRX_ADDONS_STORAGE['widgets_args'], $atts['id'] ? $atts['id'].'_widget' : 'widget_slider', 'widget_slider') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_slider', $atts, $content);
	}
	add_shortcode("trx_widget_slider", "trx_addons_sc_widget_slider");
}



// trx_slide
//-------------------------------------------------------------
/*
[trx_slide title="Slide title" subtitle="Slide subtitle" link="" video_url="URL to video" video_embed="or HTML-code with iframe"]Slide content[/trx_slide]
*/
if ( !function_exists( 'trx_addons_sc_slide' ) ) {
	function trx_addons_sc_slide($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_slide', $atts, array(
			// Individual params
			'title' => '',
			'subtitle' => '',
			'link' => '',
			'image' => '',
			'video_url' => '',
			'video_embed' => '',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);

		global $TRX_ADDONS_STORAGE;
		
		$atts['content'] = do_shortcode($content);
		$TRX_ADDONS_STORAGE['trx_slide_data'][] = $atts;

		return '';
	}
	add_shortcode("trx_slide", "trx_addons_sc_slide");
}


// trx_slider_controller
//-------------------------------------------------------------
/*
[trx_slider_controller id="unique_id" title="Widget title" engine="revo" alias="home_slider_1"]
*/
if ( !function_exists( 'trx_addons_sc_slider_controller' ) ) {
	function trx_addons_sc_slider_controller($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_slider_controller', $atts, array(
			// Individual params
			'controller_style' => 'default',
			'slider_id' => '',
			'slides_per_view' => '3',
			'slides_space' => '0',
			'effect' => 'slide',
			'height' => '100',
			'interval' => '7000',
			'controls' => 0,
            'controls_align' => 'left',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		
		if (empty($atts['slider_id'])) return '';

		$output = '<div' . ($atts['id'] ? ' id="'.esc_attr($atts['id']).'"' : '')
						. ' class="sc_slider_controller sc_slider_controller_'.esc_attr($atts['controller_style']).' sc_slider_controls_align_'.esc_attr($atts['controls_align'])
							. (!empty($atts['class']) ? ' ' . esc_attr($atts['class']) : '') 
							. '"'
						. ' data-slider-id="'.esc_attr($atts['slider_id']).'"'
						. ' data-style="'.esc_attr($atts['controller_style']).'"'
						. ' data-controls="' . esc_attr($atts['controls']>0 ? 1 : 0) . '"'
						. ' data-interval="'.esc_attr($atts['interval']).'"'
						. ' data-effect="'.esc_attr($atts['effect']).'"'
						. ' data-slides-per-view="'.esc_attr($atts['slides_per_view']).'"'
						. ' data-slides-space="'.esc_attr($atts['slides_space']).'"'
						. ((int)$atts['height']>0 ? ' data-height="'.esc_attr(trx_addons_prepare_css_value($atts['height'])).'"' : '')
						. ($atts['css'] ? ' style="'.esc_attr($atts['css']).'"' : '')
					. '>'
					. '</div>';

		return apply_filters('trx_addons_sc_output', $output, 'trx_slider_controller', $atts, $content);
	}
	add_shortcode("trx_slider_controller", "trx_addons_sc_slider_controller");
}


// Add [trx_widget_slider] in the VC shortcodes list
if (!function_exists('trx_addons_sc_widget_slider_add_in_vc')) {
	function trx_addons_sc_widget_slider_add_in_vc() {

		if (!trx_addons_exists_visual_composer()) return;
		
		$sliders_list = array(
			"swiper" => esc_html__("Posts slider (Swiper)", 'trx_addons')
		);
		if (trx_addons_exists_revslider()) {
			$sliders_list["revo"] = esc_html__("Layer slider (Revolution)", 'trx_addons');
		}
		
		$effects_list = array(
							esc_html__('Slide', 'trx_addons') => 'slide',
							esc_html__('Fade', 'trx_addons') => 'fade',
							esc_html__('Cube', 'trx_addons') => 'cube',
							esc_html__('Flip', 'trx_addons') => 'flip',
							esc_html__('Coverflow', 'trx_addons') => 'coverflow'
							);
        $controls_align = array(
                            esc_html__('Left', 'trx_addons') => 'left',
                            esc_html__('Right', 'trx_addons') => 'right',
        );
		
		$params = array(
					array(
						"param_name" => "title",
						"heading" => esc_html__("Widget title", 'trx_addons'),
						"description" => wp_kses_data( __("Title of the widget", 'trx_addons') ),
						"admin_label" => true,
						"type" => "textfield"
					),
					array(
						"param_name" => "engine",
						"heading" => esc_html__("Slider engine", 'trx_addons'),
						"description" => wp_kses_data( __("Select engine to show slider", 'trx_addons') ),
						"admin_label" => true,
						"value" => array_flip($sliders_list),
						"type" => "dropdown"
					),
					array(
						"param_name" => "height",
						"heading" => esc_html__("Slider height", 'trx_addons'),
						"description" => wp_kses_data( __("Slider height", 'trx_addons') ),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"value" => "345",
						"type" => "textfield"
					)
				);
		if (trx_addons_exists_revslider()) {
			$params[] = array(
						"param_name" => "alias",
						"heading" => esc_html__("RevSlider alias", 'trx_addons'),
						"description" => wp_kses_data( __("Select previously created Revolution slider", 'trx_addons') ),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'revo'
						),
						"value" => array_flip(trx_addons_get_list_revsliders()),
						"type" => "dropdown"
					);
		}
		$params = array_merge($params, array(		
					array(
						"param_name" => "slider_style",
						"heading" => esc_html__("Swiper style", 'trx_addons'),
						"description" => wp_kses_data( __("Select style of the Swiper slider", 'trx_addons') ),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"value" => array(
									esc_html__('Default', 'trx_addons') => 'default',
									esc_html__('Modern', 'trx_addons') => 'modern'
									),
						"type" => "dropdown"
					),
					array(
						"param_name" => "effect",
						"heading" => esc_html__("Swiper effect", 'trx_addons'),
						"description" => wp_kses_data( __("Select slides effect of the Swiper slider", 'trx_addons') ),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"value" => $effects_list,
						"type" => "dropdown"
					),
					array(
						"param_name" => "category",
						"heading" => esc_html__("Category for the Swiper", 'trx_addons'),
						"description" => wp_kses_data( __("Select category to get posts for the slider", 'trx_addons') ),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"std" => 0,
						"value" => array_flip(trx_addons_array_merge(array(0=>esc_html__('- Select category -', 'trx_addons')), trx_addons_get_list_categories())),
						"type" => "dropdown"
					),
					array(
						"param_name" => "posts",
						"heading" => esc_html__("Posts for the Swiper", 'trx_addons'),
						"description" => wp_kses_data( __("Number posts or comma separated post IDs to show in the Swiper", 'trx_addons') ),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"value" => "5",
						"type" => "textfield"
					),
					array(
						"param_name" => "slides_per_view",
						"heading" => esc_html__("Slides per view in the Swiper", 'trx_addons'),
						"description" => wp_kses_data( __("Specify slides per view in the Swiper", 'trx_addons') ),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "slides_space",
						"heading" => esc_html__("Space between slides in the Swiper", 'trx_addons'),
						"description" => wp_kses_data( __("Space between slides in the Swiper", 'trx_addons') ),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "interval",
						"heading" => esc_html__("Interval between slides in the Swiper", 'trx_addons'),
						"description" => wp_kses_data( __("Specify interval between slides change in the Swiper", 'trx_addons') ),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"value" => "7000",
						"type" => "textfield"
					),
					array(
						"param_name" => "titles",
						"heading" => esc_html__("Titles in the Swiper", 'trx_addons'),
						"description" => wp_kses_data( __("Show post's titles and categories on the slides", 'trx_addons') ),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"std" => "center",
						"value" => array(
							esc_html__('No titles', 'trx_addons') => 'no',
							esc_html__('Center', 'trx_addons') => 'center',
							esc_html__('Bottom Center', 'trx_addons') => 'bottom',
							esc_html__('Bottom Left', 'trx_addons') => 'lb',
							esc_html__('Bottom Right', 'trx_addons') => 'rb',
							esc_html__('Outside', 'trx_addons') => 'outside'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "large",
						"heading" => esc_html__("Large titles", 'trx_addons'),
						"description" => wp_kses_data( __("Do you want use large titles?", 'trx_addons') ),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"std" => "0",
						"value" => array("Large titles" => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "controls",
						"heading" => esc_html__("Controls", 'trx_addons'),
						"description" => wp_kses_data( __("Do you want to show arrows to change slides?", 'trx_addons') ),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"std" => "0",
						"value" => array("Show arrows" => "1" ),
						"type" => "checkbox"
					),
                array(
                    "param_name" => "controls_align",
                    "heading" => esc_html__("Controls align", 'trx_addons'),
                    "description" => wp_kses_data( __("Select controls align (just for swiper style: modern )", 'trx_addons') ),
                    'dependency' => array(
                        'element' => 'engine',
                        'value' => 'swiper'
                    ),
                    "std" => "left",
                    "value" => $controls_align,
                    "type" => "dropdown"
                ),


					array(
						"param_name" => "label_prev",
						"heading" => esc_html__("Prev Slide", 'trx_addons'),
						"description" => wp_kses_data( __("Label of the 'Prev Slide' button in the Swiper (Modern style). Use '|' to break line", 'trx_addons') ),
						'dependency' => array(
							array(
								'element' => 'engine',
								'value' => 'swiper'
								),
							array(
								'element' => 'slider_style',
								'value' => 'modern'
								),
						),
						"value" => esc_html__('Prev|PHOTO', 'trx_addons'),
						"type" => "textfield"
					),
					array(
						"param_name" => "label_next",
						"heading" => esc_html__("Next Slide", 'trx_addons'),
						"description" => wp_kses_data( __("Label of the 'Next Slide' button in the Swiper (Modern style). Use '|' to break line", 'trx_addons') ),
						'dependency' => array(
							array(
								'element' => 'engine',
								'value' => 'swiper'
								),
							array(
								'element' => 'slider_style',
								'value' => 'modern'
								),
						),
						"value" => esc_html__('Next|PHOTO', 'trx_addons'),
						"type" => "textfield"
					),
					array(
						"param_name" => "pagination",
						"heading" => esc_html__("Pagination", 'trx_addons'),
						"description" => wp_kses_data( __("Do you want to show bullets to change slides?", 'trx_addons') ),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"std" => "0",
						"value" => array("Show pagination" => "1" ),
						"type" => "checkbox"
					),

					array(
						"param_name" => "noresize",
						"heading" => esc_html__("No resize slide's content", 'trx_addons'),
						"description" => wp_kses_data( __("Disable resize slide's content, stretch images to cover slide", 'trx_addons') ),
						"group" => esc_html__('Custom slides', 'trx_addons'),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"std" => "0",
						"value" => array("No resize slide's content" => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "slides_type",
						"heading" => esc_html__("Type of the slides content", 'trx_addons'),
						"description" => wp_kses_data( __("Use images from slides as background (default) or insert it as tag inside each slide", 'trx_addons') ),
						"group" => esc_html__('Custom slides', 'trx_addons'),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"std" => "bg",
						"value" => array(
							esc_html__('Background', 'trx_addons') => 'bg',
							esc_html__('Image tag', 'trx_addons') => 'images'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "slides_ratio",
						"heading" => esc_html__("Slides ratio", 'trx_addons'),
						"description" => wp_kses_data( __("Ratio to resize slides on tabs and mobile", 'trx_addons') ),
						"group" => esc_html__('Custom slides', 'trx_addons'),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"value" => "16:9",
						"type" => "textfield"
					),
					array(
						'param_name' => 'slides',
						'heading' => esc_html__( 'Slides', 'trx_addons' ),
						"description" => wp_kses_data( __("Select icons, specify title and/or description for each item", 'trx_addons') ),
						"group" => esc_html__('Custom slides', 'trx_addons'),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						'value' => '',
						'type' => 'param_group',
						'params' => array(
							array(
								'param_name' => 'title',
								'heading' => esc_html__( 'Title', 'trx_addons' ),
								'description' => esc_html__( 'Enter title of this slide', 'trx_addons' ),
								'admin_label' => true,
								'type' => 'textfield'
							),
							array(
								'param_name' => 'subtitle',
								'heading' => esc_html__( 'Subtitle', 'trx_addons' ),
								'description' => esc_html__( 'Enter subtitle of this slide', 'trx_addons' ),
								'type' => 'textfield'
							),
							array(
								'param_name' => 'link',
								'heading' => esc_html__( 'Link', 'trx_addons' ),
								'description' => esc_html__( 'URL to link of this slide', 'trx_addons' ),
								'type' => 'textfield'
							),
							array(
								"param_name" => "image",
								"heading" => esc_html__("Image", 'trx_addons'),
								"description" => wp_kses_data( __("Select or upload image or specify URL from other site", 'trx_addons') ),
								"type" => "attach_image"
							),
							array(
								'param_name' => 'video_url',
								'heading' => esc_html__( 'Video URL', 'trx_addons' ),
								'description' => esc_html__( 'Enter link to the video (Note: read more about available formats at WordPress Codex page)', 'trx_addons' ),
								'type' => 'textfield'
							),
							array(
								'param_name' => 'video_embed',
								'heading' => esc_html__( 'Video embed code', 'trx_addons' ),
								'description' => esc_html__( 'or paste the HTML code to embed video in this slide', 'trx_addons' ),
								'type' => 'textarea'
							)
						)
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
			);
		
		vc_map( apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_slider",
				"name" => esc_html__("Widget Slider", 'trx_addons'),
				"description" => wp_kses_data( __("Insert widget with slider", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_slider',
				"class" => "trx_widget_slider",
				"content_element" => true,
				'is_container' => true,
				"js_view" => 'VcColumnView',
				"as_parent" => array('only' => 'trx_slide'),
				"show_settings_on_create" => true,
				"params" => $params
			), 'trx_widget_slider' ) );
			
		class WPBakeryShortCode_Trx_Widget_Slider extends WPBakeryShortCodesContainer {}

		
		vc_map( apply_filters('trx_addons_sc_map', array(
				"base" => "trx_slide",
				"name" => esc_html__("Custom Slide", 'trx_addons'),
				"description" => wp_kses_data( __("Insert the custom slide in the slider", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_slide',
				"class" => "trx_slide",
				"content_element" => true,
				'is_container' => true,
				"js_view" => 'VcColumnView',
				"as_child" => array('only' => 'trx_widget_slider'),
				"as_parent" => array('except' => 'trx_widget_slider'),
				"show_settings_on_create" => true,
				"params" => array(
					array(
						'param_name' => 'title',
						'heading' => esc_html__( 'Title', 'trx_addons' ),
						'description' => esc_html__( 'Enter title of this slide', 'trx_addons' ),
						'admin_label' => true,
						'type' => 'textfield'
					),
					array(
						'param_name' => 'subtitle',
						'heading' => esc_html__( 'Subtitle', 'trx_addons' ),
						'description' => esc_html__( 'Enter subtitle of this slide', 'trx_addons' ),
						'type' => 'textfield'
					),
					array(
						'param_name' => 'link',
						'heading' => esc_html__( 'Link', 'trx_addons' ),
						'description' => esc_html__( 'URL to link of this slide', 'trx_addons' ),
						'type' => 'textfield'
					),
					array(
						"param_name" => "image",
						"heading" => esc_html__("Image", 'trx_addons'),
						"description" => wp_kses_data( __("Select or upload image or specify URL from other site", 'trx_addons') ),
						"type" => "attach_image"
					),
					array(
						'param_name' => 'video_url',
						'heading' => esc_html__( 'Video URL', 'trx_addons' ),
						'description' => esc_html__( 'Enter link to the video (Note: read more about available formats at WordPress Codex page)', 'trx_addons' ),
						'type' => 'textfield'
					),
					array(
						'param_name' => 'video_embed',
						'heading' => esc_html__( 'Video embed code', 'trx_addons' ),
						'description' => esc_html__( 'or paste the HTML code to embed video in this slide', 'trx_addons' ),
						'type' => 'textarea'
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
			), 'trx_slide' ) );
			
		class WPBakeryShortCode_Trx_Slide extends WPBakeryShortCodesContainer {}

		
		vc_map( apply_filters('trx_addons_sc_map', array(
				"base" => "trx_slider_controller",
				"name" => esc_html__("Slider Controller", 'trx_addons'),
				"description" => wp_kses_data( __("Insert controller for the specified slider", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_slider_controller',
				"class" => "trx_slider_controller",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "slider_id",
						"heading" => esc_html__("Slave slider ID", 'trx_addons'),
						"description" => wp_kses_data( __("ID of the slave slider", 'trx_addons') ),
						"type" => "textfield"
					),
					array(
						"param_name" => "controller_style",
						"heading" => esc_html__("Style", 'trx_addons'),
						"description" => wp_kses_data( __("Select style of the Controller", 'trx_addons') ),
						"value" => array(
									esc_html__('Thumbs', 'trx_addons') => 'thumbs',
									esc_html__('Titles', 'trx_addons') => 'titles'
									),
						"type" => "dropdown"
					),
					array(
						"param_name" => "effect",
						"heading" => esc_html__("Effect", 'trx_addons'),
						"description" => wp_kses_data( __("Select slides effect of the Controller", 'trx_addons') ),
						"value" => $effects_list,
						"type" => "dropdown"
					),
					array(
						"param_name" => "slides_per_view",
						"heading" => esc_html__("Slides per view", 'trx_addons'),
						"description" => wp_kses_data( __("Specify slides per view in the Controller", 'trx_addons') ),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "slides_space",
						"heading" => esc_html__("Space between slides", 'trx_addons'),
						"description" => wp_kses_data( __("Space between slides in the Controller", 'trx_addons') ),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "interval",
						"heading" => esc_html__("Interval between slides", 'trx_addons'),
						"description" => wp_kses_data( __("Specify interval between slides change in the Controller", 'trx_addons') ),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"value" => "7000",
						"type" => "textfield"
					),
					array(
						"param_name" => "controls",
						"heading" => esc_html__("Controls", 'trx_addons'),
						"description" => wp_kses_data( __("Do you want to show arrows to change slides?", 'trx_addons') ),
						"std" => "0",
						"value" => array("Show arrows" => "1" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "height",
						"heading" => esc_html__("Controller height", 'trx_addons'),
						"description" => wp_kses_data( __("Controller height", 'trx_addons') ),
						'dependency' => array(
							'element' => 'engine',
							'value' => 'swiper'
						),
						"value" => "100",
						"type" => "textfield"
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
			), 'trx_slider_controller' ) );
			
		class WPBakeryShortCode_Trx_Slider_Controller extends WPBakeryShortCode {}

	}
	add_action('after_setup_theme', 'trx_addons_sc_widget_slider_add_in_vc', 11);
}
?>