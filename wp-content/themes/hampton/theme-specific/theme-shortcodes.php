<?php

if ( !function_exists('hampton_specific_theme_setup1') ) {
	add_action( 'after_setup_theme', 'hampton_specific_theme_setup1', 1 );
	function hampton_specific_theme_setup1() {

	add_filter( 'trx_addons_localize_script',		'hampton_specific_trx_addons_sc_form_messages', 10, 20);

		if (is_admin()) {
		}
	}
}

// Add new message strings for form-modern
if ( !function_exists( 'hampton_specific_trx_addons_sc_form_messages' ) ) {
	function hampton_specific_trx_addons_sc_form_messages($list) {
		$list['msg_field_phone_empty'] = addslashes(esc_html__("Phone can't be empty", 'hampton'));
		$list['msg_field_zipcode_empty'] = addslashes(esc_html__("Zip code can't be empty", 'hampton'));
		return $list;
	}
}

?>