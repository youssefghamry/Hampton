<?php
/**
 * Widget: Display Contacts info
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Load widget
if (!function_exists('trx_addons_widget_contacts_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_contacts_load' );
	function trx_addons_widget_contacts_load() {
		register_widget('trx_addons_widget_contacts');
	}
}

// Widget Class
class trx_addons_widget_contacts extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_contacts', 'description' => esc_html__('Contacts - logo and short description, address, phone and email', 'trx_addons'));
		parent::__construct( 'trx_addons_widget_contacts', esc_html__('ThemeREX Addons - Contacts', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {
		extract($args);

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
		
		$logo = isset($instance['logo']) ? $instance['logo'] : '';
		if (!empty($logo)) {
			$logo = trx_addons_get_attachment_url($logo, 'full');
			$attr = trx_addons_getimagesize($logo);
			$logo = '<img src="'.esc_url($logo).'" alt=""'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
			// Logo for Retina
			$logo_retina = isset($instance['logo_retina']) ? $instance['logo_retina'] : '';
			if (!empty($logo_retina)) {
				$logo_retina = trx_addons_get_attachment_url($logo_retina, 'full');
				$logo_retina = '<img src="'.esc_url($logo_retina).'" alt=""'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
			}
		}
		
		$description = isset($instance['description']) ? $instance['description'] : '';

		$address = isset($instance['address']) ? $instance['address'] : '';
		$phone = isset($instance['phone']) ? $instance['phone'] : '';
		$email = isset($instance['email']) ? $instance['email'] : '';
		$socials = isset($instance['socials']) ? (int) $instance['socials'] : 0;
		
		// Before widget (defined by themes)
		echo trim($before_widget);

		// Display the widget title if one was input (before and after defined by themes)
		if ($title) echo trim($before_title . $title . $after_title);
	
		// Widget body
		if (!empty($logo)) {
			?><div class="contacts_logo"><?php echo trim($logo); ?></div><?php
		}

		?>
		<div class="contacts_description"><?php echo do_shortcode($description); ?></div>
		<?php

		if (!empty($address) || !empty($phone) || !empty($email)) {
			?><div class="contacts_info"><?php
				if (!empty($phone) || !empty($email)) {
					?><div class="contacts_right"><?php
					if (!empty($email)) {
						?><span class="contacts_email"><a href="mailto:<?php echo esc_url($email); ?>"><?php echo trim($email); ?></a></span><?php
					}
					if (!empty($phone)) {
						?><span class="contacts_phone"><?php echo trim($phone); ?></span><?php
					}
					?></div><?php
				}
				if (!empty($address)) {
					?><div class="contacts_left"><span class="contacts_address"><?php echo str_replace('|', "<br>", $address); ?></span></div><?php
				}
			?></div><?php
		}
	
		// Display widget body
		if ( $socials && ($output = trx_addons_get_socials_links()) != '') {
			?><div class="contacts_socials socials_wrap"><?php echo trim($output); ?></div><?php
		}
			
		// After widget (defined by themes)
		echo trim($after_widget);
	}

	// Update the widget settings.
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		// Strip tags for title and comments count to remove HTML (important for text inputs)
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['logo'] = strip_tags($new_instance['logo']);
		$instance['logo_retina'] = strip_tags($new_instance['logo_retina']);
		$instance['description'] = wp_kses_post($new_instance['description']);
		$instance['address'] = wp_kses_data($new_instance['address']);
		$instance['phone'] = wp_kses_data($new_instance['phone']);
		$instance['email'] = wp_kses_data($new_instance['email']);
		$instance['socials'] = isset( $new_instance['socials'] ) ? 1 : 0;

		return $instance;
	}

	// Displays the widget settings controls on the widget panel.
	function form($instance) {

		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'logo' => '',
			'logo_retina' => '',
			'description' => '',
			'address' => '',
			'phone' => '',
			'email' => '',
			'socials' => 0
			)
		);
		$title = $instance['title'];
		$logo = $instance['logo'];
		$logo_retina = $instance['logo_retina'];
		$description = $instance['description'];
		$address = $instance['address'];
		$phone = $instance['phone'];
		$email = $instance['email'];
		$socials = (int) $instance['socials'] ? 1 : 0;
		?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Widget title:', 'trx_addons'); ?></label><br>
			<input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" class="widgets_param_fullwidth">
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'logo' )); ?>"><?php esc_html_e('Logo:', 'trx_addons'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'logo' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'logo' )); ?>" value="<?php echo esc_attr($logo); ?>" class="widgets_param_fullwidth widgets_param_media_selector">
            <?php
			echo trim(trx_addons_options_show_custom_field($this->get_field_id( 'logo_button' ), array('type'=>'mediamanager', 'linked_field_id'=>$this->get_field_id( 'logo' )), null))
					. '<span class="trx_addons_options_field_preview">'
						. ($logo ? '<img src="'.esc_url($logo).'" class="widgets_param_maxwidth" alt="">' : '')
					. '</span>';
			?>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'logo_retina' )); ?>"><?php esc_html_e('Logo for Retina:', 'trx_addons'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'logo_retina' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'logo_retina' )); ?>" value="<?php echo esc_attr($logo_retina); ?>" class="widgets_param_fullwidth widgets_param_media_selector">
            <?php
			echo trim(trx_addons_options_show_custom_field($this->get_field_id( 'logo_retina_button' ), array('type'=>'mediamanager', 'linked_field_id'=>$this->get_field_id( 'logo_retina' )), null))
					. '<span class="trx_addons_options_field_preview">'
						. ($logo_retina ? '<img src="'.esc_url($logo_retina).'" class="widgets_param_maxwidth" alt="">' : '')
					. '</span>';
			?>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'description' )); ?>"><?php esc_html_e('Short description about user', 'trx_addons'); ?></label>
			<textarea id="<?php echo esc_attr($this->get_field_id( 'description' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'description' )); ?>" rows="5" class="widgets_param_fullwidth"><?php echo $description; ?></textarea>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('address')); ?>"><?php esc_html_e('Address:', 'trx_addons'); ?></label><br>
			<input id="<?php echo esc_attr($this->get_field_id('address')); ?>" name="<?php echo esc_attr($this->get_field_name('address')); ?>" value="<?php echo esc_attr($address); ?>" class="widgets_param_fullwidth">
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('phone')); ?>"><?php esc_html_e('Phone:', 'trx_addons'); ?></label><br>
			<input id="<?php echo esc_attr($this->get_field_id('phone')); ?>" name="<?php echo esc_attr($this->get_field_name('phone')); ?>" value="<?php echo esc_attr($phone); ?>" class="widgets_param_fullwidth">
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('email')); ?>"><?php esc_html_e('E-mail:', 'trx_addons'); ?></label><br>
			<input id="<?php echo esc_attr($this->get_field_id('email')); ?>" name="<?php echo esc_attr($this->get_field_name('email')); ?>" value="<?php echo esc_attr($email); ?>" class="widgets_param_fullwidth">
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('socials')); ?>" name="<?php echo esc_attr($this->get_field_name('socials')); ?>" value="1" <?php echo (1==$socials ? ' checked="checked"' : ''); ?> />
			<label for="<?php echo esc_attr($this->get_field_id('socials')); ?>"><?php esc_html_e('Show Social icons', 'trx_addons'); ?></label><br />
		</p>
	<?php
	}
}

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_widget_contacts_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_contacts_load_scripts_front');
	function trx_addons_widget_contacts_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			trx_addons_enqueue_style( 'trx_addons-widget_contacts', trx_addons_get_file_url('widgets/contacts/contacts.css'), array(), null );
		}
	}
}

	
// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_contacts_merge_styles' ) ) {
	add_action("trx_addons_filter_merge_styles", 'trx_addons_widget_contacts_merge_styles');
	function trx_addons_widget_contacts_merge_styles($list) {
		$list[] = 'widgets/contacts/contacts.css';
		return $list;
	}
}



// trx_widget_contacts
//-------------------------------------------------------------
/*
[trx_widget_contacts id="unique_id" title="Widget title" logo="image_url" logo_retina="image_url" description="short description" address="Address string" phone="Phone" email="Email" socials="0|1"]
*/
if ( !function_exists( 'trx_addons_sc_widget_contacts' ) ) {
	function trx_addons_sc_widget_contacts($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_widget_contacts', $atts, array(
			// Individual params
			"title" => "",
			"logo" => "",
			"logo_retina" => "",
			"description" => "",
			"address" => "",
			"phone" => "",
			"email" => "",
			"socials" => 0,
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		if ($atts['socials']=='') $atts['socials'] = 0;
		extract($atts);
		$type = 'trx_addons_widget_contacts';
		$output = '';
		global $wp_widget_factory, $TRX_ADDONS_STORAGE;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
							. ' class="widget_area sc_widget_contacts' 
								. (trx_addons_exists_visual_composer() ? ' vc_widget_contacts wpb_content_element' : '') 
								. (!empty($class) ? ' ' . esc_attr($class) : '') 
								. '"'
							. ($css ? ' style="'.esc_attr($css).'"' : '')
						. '>';
			ob_start();
			the_widget( $type, $atts, trx_addons_prepare_widgets_args($TRX_ADDONS_STORAGE['widgets_args'], $id ? $id.'_widget' : 'widget_contacts', 'widget_contacts') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_contacts', $atts, $content);
	}
	add_shortcode("trx_widget_contacts", "trx_addons_sc_widget_contacts");
}


// Add [trx_widget_contacts] in the VC shortcodes list
if (!function_exists('trx_addons_sc_widget_contacts_add_in_vc')) {
	function trx_addons_sc_widget_contacts_add_in_vc() {

		if (!trx_addons_exists_visual_composer()) return;
		
		vc_map( apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_contacts",
				"name" => esc_html__("Widget Contacts", 'trx_addons'),
				"description" => wp_kses_data( __("Insert widget with logo, short description and contacts", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_contacts',
				"class" => "trx_widget_contacts",
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
						"param_name" => "logo",
						"heading" => esc_html__("Logo", 'trx_addons'),
						"description" => wp_kses_data( __("Select or upload image or write URL from other site for site's logo.", 'trx_addons') ),
						"type" => "attach_image"
					),
					array(
						"param_name" => "logo_retina",
						"heading" => esc_html__("Logo Retina", 'trx_addons'),
						"description" => wp_kses_data( __("Select or upload image or write URL from other site: site's logo for the Retina display.", 'trx_addons') ),
						"type" => "attach_image"
					),
					array(
						"param_name" => "description",
						"heading" => esc_html__("Description", 'trx_addons'),
						"description" => wp_kses_data( __("Short description about user. If empty - get description of the first registered blog user", 'trx_addons') ),
						"type" => "textarea"
					),
					array(
						"param_name" => "address",
						"heading" => esc_html__("Address", 'trx_addons'),
						"description" => wp_kses_data( __("Address string. Use '#' to split this string on two parts", 'trx_addons') ),
						"admin_label" => true,
						"type" => "textfield"
					),
					array(
						"param_name" => "phone",
						"heading" => esc_html__("Phone", 'trx_addons'),
						"description" => wp_kses_data( __("Your phone", 'trx_addons') ),
						"admin_label" => true,
						"type" => "textfield"
					),
					array(
						"param_name" => "email",
						"heading" => esc_html__("E-mail", 'trx_addons'),
						"description" => wp_kses_data( __("Your e-mail address", 'trx_addons') ),
						"admin_label" => true,
						"type" => "textfield"
					),
					array(
						"param_name" => "socials",
						"heading" => esc_html__("Show Social Icons", 'trx_addons'),
						"description" => wp_kses_data( __("Do you want to display icons with links on your profiles in the Social networks?", 'trx_addons') ),
						"std" => "0",
						"value" => array("Show Social Icons" => "1" ),
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
			), 'trx_widget_contacts') );
			
		class WPBakeryShortCode_Trx_Widget_Contacts extends WPBakeryShortCode {}

	}
	add_action('after_setup_theme', 'trx_addons_sc_widget_contacts_add_in_vc', 11);
}
?>