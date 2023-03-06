<?php
/**
 * Widget: Video player for Youtube, Vimeo, etc. embeded video
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.1
 */

// Load widget
if (!function_exists('trx_addons_widget_video_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_video_load' );
	function trx_addons_widget_video_load() {
		register_widget( 'trx_addons_widget_video' );
	}
}

// Widget Class
class trx_addons_widget_video extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_video', 'description' => esc_html__('Show video from Youtube, Vimeo, etc.', 'trx_addons') );
		parent::__construct( 'trx_addons_widget_video', esc_html__('ThemeREX Addons - Video player', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );
		$embed = isset($instance['embed']) ? str_replace("`", '"', $instance['embed']) : '';
		$link = isset($instance['link']) ? $instance['link'] : '';

		if (empty($embed) && empty($link)) return;
		
		// Before widget (defined by themes)
		echo trim($before_widget);

		// Display the widget title if one was input (before and after defined by themes)
		if ($title)	echo trim($before_title . $title . $after_title);

		// Widget body
		$cover = isset($instance['cover']) ? $instance['cover'] : '';
		if ($cover!='') {
			$cover = trx_addons_get_attachment_url($cover, trx_addons_get_thumb_size('big'));
			$attr = trx_addons_getimagesize($cover);
			$cover = '<img src="' . esc_url($cover) . '" alt="' . esc_attr($title) . '"'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
		}

		?><div class="trx_addons_video_player <?php echo !empty($cover) ? 'with_cover hover_play' : 'without_cover'; ?>"><?php 
		
			if (!empty($link)) {
				global $wp_embed;
				if ( is_object($wp_embed) ) {
					$embed = $wp_embed->run_shortcode( '[embed]' . trim($link) . '[/embed]' );
				}
			}
			if ( $cover ) {
				$embed = trx_addons_make_video_autoplay($embed);
				echo trim($cover);
				?><div class="video_mask"></div><div class="video_hover" data-video="<?php echo esc_attr($embed); ?>"></div><?php 
			}
	
			?><div class="video_embed video_frame"><?php 
				if ( !$cover ) {
					echo trim($embed);
				}
			?></div><?php

		?></div><?php

		// After widget (defined by themes)
		echo trim($after_widget);
	}

	// Update the widget settings.
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Strip tags for title and comments count to remove HTML (important for text inputs)
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['cover'] = strip_tags( $new_instance['cover'] );
		$instance['link']  = trim( $new_instance['link'] );
		$instance['embed'] = trim( $new_instance['embed'] );

		return $instance;
	}

	// Displays the widget settings controls on the widget panel.
	function form( $instance ) {
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'cover' => '',
			'link' => '',
			'embed' => ''
			)
		);
		$title = $instance['title'];
		$cover = $instance['cover'];
		$link = $instance['link'];
		$embed = $instance['embed'];
		?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'trx_addons'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($title); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'cover' )); ?>"><?php echo wp_kses_data( __('Cover image URL:<br />(leave empty if you not need the cover)', 'trx_addons') ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'cover' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'cover' )); ?>" value="<?php echo esc_attr($cover); ?>" class="widgets_param_fullwidth widgets_param_media_selector" />
            <?php
			echo trim(trx_addons_options_show_custom_field($this->get_field_id( 'cover_media' ), array('type'=>'mediamanager', 'linked_field_id'=>$this->get_field_id( 'cover' )), null))
				. '<span class="trx_addons_options_field_preview">'
					. ($cover ? '<img src="'.esc_url($cover).'" class="widgets_param_maxwidth" alt="">' : '')
				. '</span>';
			?>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'link' )); ?>"><?php esc_html_e('Link to video:', 'trx_addons'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'link' )); ?>" value="<?php echo esc_attr($link); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'embed' )); ?>"><?php esc_html_e('or paste HTML code to embed video:', 'trx_addons'); ?></label>
			<textarea id="<?php echo esc_attr($this->get_field_id( 'embed' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'embed' )); ?>" rows="5" class="widgets_param_fullwidth"><?php echo htmlspecialchars($embed); ?></textarea>
		</p>
		
	<?php
	}
}

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_widget_video_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_video_load_scripts_front');
	function trx_addons_widget_video_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			trx_addons_enqueue_style( 'trx_addons-widget_video', trx_addons_get_file_url('widgets/video/video.css'), array(), null );
		}
	}
}

	
// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_video_merge_styles' ) ) {
	add_action("trx_addons_filter_merge_styles", 'trx_addons_widget_video_merge_styles');
	function trx_addons_widget_video_merge_styles($list) {
		$list[] = 'widgets/video/video.css';
		return $list;
	}
}



// trx_widget_video
//-------------------------------------------------------------
/*
[trx_widget_video id="unique_id" title="Widget title" embed="HTML code" cover="image url"]
*/
if ( !function_exists( 'trx_addons_sc_widget_video' ) ) {
	function trx_addons_sc_widget_video($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_widget_video', $atts, array(
			// Individual params
			'title' => '',
			'cover' => '',
			'link' => '',
			'embed' => '',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		if (!empty($atts['embed'])) $atts['embed'] = trim( vc_value_from_safe( $atts['embed'] ) );
		extract($atts);
		$type = 'trx_addons_widget_video';
		$output = '';
		global $wp_widget_factory, $TRX_ADDONS_STORAGE;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
							. ' class="widget_area sc_widget_video' 
								. (trx_addons_exists_visual_composer() ? ' vc_widget_video wpb_content_element' : '') 
								. (!empty($class) ? ' ' . esc_attr($class) : '') 
								. '"'
							. ($css ? ' style="'.esc_attr($css).'"' : '')
						. '>';
			ob_start();
			the_widget( $type, $atts, trx_addons_prepare_widgets_args($TRX_ADDONS_STORAGE['widgets_args'], $id ? $id.'_widget' : 'widget_video', 'widget_video') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_video', $atts, $content);
	}
	add_shortcode("trx_widget_video", "trx_addons_sc_widget_video");
}


// Add [trx_widget_video] in the VC shortcodes list
if (!function_exists('trx_addons_sc_widget_video_add_in_vc')) {
	function trx_addons_sc_widget_video_add_in_vc() {

		if (!trx_addons_exists_visual_composer()) return;
		
		vc_map( apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_video",
				"name" => esc_html__("Widget Video player", 'trx_addons'),
				"description" => wp_kses_data( __("Insert widget with embedded video from popular video hosting: Vimeo, Youtube, etc.", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_video',
				"class" => "trx_widget_video",
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
						"param_name" => "cover",
						"heading" => esc_html__("Cover image", 'trx_addons'),
						"description" => wp_kses_data( __("Select or upload cover image or write URL from other site", 'trx_addons') ),
						"type" => "attach_image"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Link to video", 'trx_addons'),
						"description" => wp_kses_data( __("Enter link to the video (Note: read more about available formats at WordPress Codex page)", 'trx_addons') ),
						"admin_label" => true,
						"type" => "textfield"
					),
					array(
						"param_name" => "embed",
						"heading" => esc_html__("or paste Embed code", 'trx_addons'),
						"description" => wp_kses_data( __("or paste the HTML code to embed video", 'trx_addons') ),
						"type" => "textarea_safe"
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
			), 'trx_widget_video' ) );
			
		class WPBakeryShortCode_Trx_Widget_Video extends WPBakeryShortCode {}

	}
	add_action('after_setup_theme', 'trx_addons_sc_widget_video_add_in_vc', 11);
}
?>