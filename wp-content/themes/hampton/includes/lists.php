<?php
/**
 * Theme lists
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }



// Return numbers range
if ( !function_exists( 'hampton_get_list_range' ) ) {
	function hampton_get_list_range($from=1, $to=2, $prepend_inherit=false) {
		$list = array();
		for ($i=$from; $i<=$to; $i++)
			$list[$i] = $i;
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}



// Return styles list
if ( !function_exists( 'hampton_get_list_styles' ) ) {
	function hampton_get_list_styles($from=1, $to=2, $prepend_inherit=false) {
		$list = array();
		for ($i=$from; $i<=$to; $i++)
			$list[$i] = sprintf(esc_html__('Style %d', 'hampton'), $i);
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}

// Return list with 'Yes' and 'No' items
if ( !function_exists( 'hampton_get_list_yesno' ) ) {
	function hampton_get_list_yesno($prepend_inherit=false) {
		$list = array(
			"yes"	=> esc_html__("Yes", 'hampton'),
			"no"	=> esc_html__("No", 'hampton')
		);
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}

// Return list with 'On' and 'Of' items
if ( !function_exists( 'hampton_get_list_onoff' ) ) {
	function hampton_get_list_onoff($prepend_inherit=false) {
		$list = array(
			"on"	=> esc_html__("On", 'hampton'),
			"off"	=> esc_html__("Off", 'hampton')
		);
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}

// Return list with 'Show' and 'Hide' items
if ( !function_exists( 'hampton_get_list_showhide' ) ) {
	function hampton_get_list_showhide($prepend_inherit=false) {
		$list = array(
			"show" => esc_html__("Show", 'hampton'),
			"hide" => esc_html__("Hide", 'hampton')
		);
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}

// Return list with 'Horizontal' and 'Vertical' items
if ( !function_exists( 'hampton_get_list_directions' ) ) {
	function hampton_get_list_directions($prepend_inherit=false) {
		$list = array(
			"horizontal" => esc_html__("Horizontal", 'hampton'),
			"vertical"   => esc_html__("Vertical", 'hampton')
		);
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}

// Return list of the animations
if ( !function_exists( 'hampton_get_list_animations' ) ) {
	function hampton_get_list_animations($prepend_inherit=false) {
		$list = array(
			'none'			=> esc_html__('- None -',	'hampton'),
			'bounced'		=> esc_html__('Bounced',	'hampton'),
			'elastic'		=> esc_html__('Elastic',	'hampton'),
			'flash'			=> esc_html__('Flash',		'hampton'),
			'flip'			=> esc_html__('Flip',		'hampton'),
			'pulse'			=> esc_html__('Pulse',		'hampton'),
			'rubberBand'	=> esc_html__('Rubber Band','hampton'),
			'shake'			=> esc_html__('Shake',		'hampton'),
			'swing'			=> esc_html__('Swing',		'hampton'),
			'tada'			=> esc_html__('Tada',		'hampton'),
			'wobble'		=> esc_html__('Wobble',		'hampton')
		);
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}


// Return list of the enter animations
if ( !function_exists( 'hampton_get_list_animations_in' ) ) {
	function hampton_get_list_animations_in($prepend_inherit=false) {
		$list = array(
			'none'				=> esc_html__('- None -',			'hampton'),
			'bounceIn'			=> esc_html__('Bounce In',			'hampton'),
			'bounceInUp'		=> esc_html__('Bounce In Up',		'hampton'),
			'bounceInDown'		=> esc_html__('Bounce In Down',		'hampton'),
			'bounceInLeft'		=> esc_html__('Bounce In Left',		'hampton'),
			'bounceInRight'		=> esc_html__('Bounce In Right',	'hampton'),
			'elastic'			=> esc_html__('Elastic In',			'hampton'),
			'fadeIn'			=> esc_html__('Fade In',			'hampton'),
			'fadeInUp'			=> esc_html__('Fade In Up',			'hampton'),
			'fadeInUpSmall'		=> esc_html__('Fade In Up Small',	'hampton'),
			'fadeInUpBig'		=> esc_html__('Fade In Up Big',		'hampton'),
			'fadeInDown'		=> esc_html__('Fade In Down',		'hampton'),
			'fadeInDownBig'		=> esc_html__('Fade In Down Big',	'hampton'),
			'fadeInLeft'		=> esc_html__('Fade In Left',		'hampton'),
			'fadeInLeftBig'		=> esc_html__('Fade In Left Big',	'hampton'),
			'fadeInRight'		=> esc_html__('Fade In Right',		'hampton'),
			'fadeInRightBig'	=> esc_html__('Fade In Right Big',	'hampton'),
			'flipInX'			=> esc_html__('Flip In X',			'hampton'),
			'flipInY'			=> esc_html__('Flip In Y',			'hampton'),
			'lightSpeedIn'		=> esc_html__('Light Speed In',		'hampton'),
			'rotateIn'			=> esc_html__('Rotate In',			'hampton'),
			'rotateInUpLeft'	=> esc_html__('Rotate In Down Left','hampton'),
			'rotateInUpRight'	=> esc_html__('Rotate In Up Right',	'hampton'),
			'rotateInDownLeft'	=> esc_html__('Rotate In Up Left',	'hampton'),
			'rotateInDownRight'	=> esc_html__('Rotate In Down Right','hampton'),
			'rollIn'			=> esc_html__('Roll In',			'hampton'),
			'slideInUp'			=> esc_html__('Slide In Up',		'hampton'),
			'slideInDown'		=> esc_html__('Slide In Down',		'hampton'),
			'slideInLeft'		=> esc_html__('Slide In Left',		'hampton'),
			'slideInRight'		=> esc_html__('Slide In Right',		'hampton'),
			'wipeInLeftTop'		=> esc_html__('Wipe In Left Top',	'hampton'),
			'zoomIn'			=> esc_html__('Zoom In',			'hampton'),
			'zoomInUp'			=> esc_html__('Zoom In Up',			'hampton'),
			'zoomInDown'		=> esc_html__('Zoom In Down',		'hampton'),
			'zoomInLeft'		=> esc_html__('Zoom In Left',		'hampton'),
			'zoomInRight'		=> esc_html__('Zoom In Right',		'hampton')
		);
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}


// Return list of the out animations
if ( !function_exists( 'hampton_get_list_animations_out' ) ) {
	function hampton_get_list_animations_out($prepend_inherit=false) {
		$list = array(
			'none'			=> esc_html__('- None -',			'hampton'),
			'bounceOut'		=> esc_html__('Bounce Out',			'hampton'),
			'bounceOutUp'	=> esc_html__('Bounce Out Up',		'hampton'),
			'bounceOutDown'	=> esc_html__('Bounce Out Down',	'hampton'),
			'bounceOutLeft'	=> esc_html__('Bounce Out Left',	'hampton'),
			'bounceOutRight'=> esc_html__('Bounce Out Right',	'hampton'),
			'fadeOut'		=> esc_html__('Fade Out',			'hampton'),
			'fadeOutUp'		=> esc_html__('Fade Out Up',		'hampton'),
			'fadeOutUpBig'	=> esc_html__('Fade Out Up Big',	'hampton'),
			'fadeOutDownSmall'	=> esc_html__('Fade Out Down Small','hampton'),
			'fadeOutDownBig'=> esc_html__('Fade Out Down Big',	'hampton'),
			'fadeOutDown'	=> esc_html__('Fade Out Down',		'hampton'),
			'fadeOutLeft'	=> esc_html__('Fade Out Left',		'hampton'),
			'fadeOutLeftBig'=> esc_html__('Fade Out Left Big',	'hampton'),
			'fadeOutRight'	=> esc_html__('Fade Out Right',		'hampton'),
			'fadeOutRightBig'=> esc_html__('Fade Out Right Big','hampton'),
			'flipOutX'		=> esc_html__('Flip Out X',			'hampton'),
			'flipOutY'		=> esc_html__('Flip Out Y',			'hampton'),
			'hinge'			=> esc_html__('Hinge Out',			'hampton'),
			'lightSpeedOut'	=> esc_html__('Light Speed Out',	'hampton'),
			'rotateOut'		=> esc_html__('Rotate Out',			'hampton'),
			'rotateOutUpLeft'	=> esc_html__('Rotate Out Down Left',	'hampton'),
			'rotateOutUpRight'	=> esc_html__('Rotate Out Up Right',	'hampton'),
			'rotateOutDownLeft'	=> esc_html__('Rotate Out Up Left',		'hampton'),
			'rotateOutDownRight'=> esc_html__('Rotate Out Down Right',	'hampton'),
			'rollOut'			=> esc_html__('Roll Out',		'hampton'),
			'slideOutUp'		=> esc_html__('Slide Out Up',	'hampton'),
			'slideOutDown'		=> esc_html__('Slide Out Down',	'hampton'),
			'slideOutLeft'		=> esc_html__('Slide Out Left',	'hampton'),
			'slideOutRight'		=> esc_html__('Slide Out Right','hampton'),
			'zoomOut'			=> esc_html__('Zoom Out',		'hampton'),
			'zoomOutUp'			=> esc_html__('Zoom Out Up',	'hampton'),
			'zoomOutDown'		=> esc_html__('Zoom Out Down',	'hampton'),
			'zoomOutLeft'		=> esc_html__('Zoom Out Left',	'hampton'),
			'zoomOutRight'		=> esc_html__('Zoom Out Right',	'hampton')
		);
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}

// Return classes list for the specified animation
if (!function_exists('hampton_get_animation_classes')) {
	function hampton_get_animation_classes($animation, $speed='normal', $loop='none') {
		// speed:	fast=0.5s | normal=1s | slow=2s
		// loop:	none | infinite
		return hampton_is_off($animation) ? '' : 'animated '.esc_attr($animation).' '.esc_attr($speed).(!hampton_is_off($loop) ? ' '.esc_attr($loop) : '');
	}
}

// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if ( !function_exists( 'hampton_get_list_sidebars' ) ) {
	function hampton_get_list_sidebars($prepend_inherit=false) {
		if (($list = hampton_storage_get('list_sidebars'))=='') {
			$list = apply_filters('hampton_filter_list_sidebars', array(
				'sidebar_widgets'		=> esc_html__('Sidebar Widgets', 'hampton'),
				'header_widgets'		=> esc_html__('Header Widgets', 'hampton'),
				'above_page_widgets'	=> esc_html__('Above Page Widgets', 'hampton'),
				'above_content_widgets' => esc_html__('Above Content Widgets', 'hampton'),
				'below_content_widgets' => esc_html__('Below Content Widgets', 'hampton'),
				'below_page_widgets' 	=> esc_html__('Below Page Widgets', 'hampton'),
				'footer_widgets'		=> esc_html__('Footer Widgets', 'hampton')
				)
			);

			$custom_sidebars_number = max(0, min(10, hampton_get_theme_setting('custom_sidebars')));
			$custom_sidebars_number = is_array($custom_sidebars_number) ? count ($custom_sidebars_number) : $custom_sidebars_number;
			if (($custom_sidebars_number) > 0) {
				for ($i=1; $i <= $custom_sidebars_number; $i++) {
					$list['custom_widgets_'.intval($i)] = sprintf(esc_html__('Custom Widgets %d', 'hampton'), $i);
				}
			}
			hampton_storage_set('list_sidebars', $list);
		}
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}

// Return sidebars positions
if ( !function_exists( 'hampton_get_list_sidebars_positions' ) ) {
	function hampton_get_list_sidebars_positions($prepend_inherit=false) {
		$list = array(
			'left'  => esc_html__('Left',  'hampton'),
			'right' => esc_html__('Right', 'hampton')
		);
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}

// Return blog styles list, prepended inherit
if ( !function_exists( 'hampton_get_list_blog_styles' ) ) {
	function hampton_get_list_blog_styles($prepend_inherit=false) {
		$list = apply_filters('hampton_filter_list_blog_styles', array(
			'excerpt'	=> esc_html__('Excerpt','hampton'),
			'classic_2'	=> esc_html__('Classic /2 columns/',	'hampton'),
			'classic_3'	=> esc_html__('Classic /3 columns/',	'hampton'),
			'portfolio_2' => esc_html__('Portfolio /2 columns/','hampton'),
			'portfolio_3' => esc_html__('Portfolio /3 columns/','hampton'),
			'portfolio_4' => esc_html__('Portfolio /4 columns/','hampton'),
			'gallery_2' => esc_html__('Gallery /2 columns/',	'hampton'),
			'gallery_3' => esc_html__('Gallery /3 columns/',	'hampton'),
			'gallery_4' => esc_html__('Gallery /4 columns/',	'hampton'),
			'chess_1'	=> esc_html__('Chess /2 column/',		'hampton'),
			'chess_2'	=> esc_html__('Chess /4 columns/',		'hampton'),
			'chess_3'	=> esc_html__('Chess /6 columns/',		'hampton')
			)
		);
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}


// Return list of categories
if ( !function_exists( 'hampton_get_list_categories' ) ) {
	function hampton_get_list_categories($prepend_inherit=false) {
		if (($list = hampton_storage_get('list_categories'))=='') {
			$list = array();
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'category',
				'pad_counts'               => false );
			$taxonomies = get_categories( $args );
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
			hampton_storage_set('list_categories', $list);
		}
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}


// Return list of taxonomies
if ( !function_exists( 'hampton_get_list_terms' ) ) {
	function hampton_get_list_terms($prepend_inherit=false, $taxonomy='category') {
		if (($list = hampton_storage_get('list_taxonomies_'.($taxonomy)))=='') {
			$list = array();
			$args = array(
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => $taxonomy,
				'pad_counts'               => false );
			$taxonomies = get_terms( $taxonomy, $args );
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
			hampton_storage_set('list_taxonomies_'.($taxonomy), $list);
		}
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}

// Return list of post's types
if ( !function_exists( 'hampton_get_list_posts_types' ) ) {
	function hampton_get_list_posts_types($prepend_inherit=false) {
		if (($list = hampton_storage_get('list_posts_types'))=='') {
			$list = apply_filters('hampton_filter_list_posts_types', array(
				'post' => esc_html__('Post', 'hampton')
			));
			hampton_storage_set('list_posts_types', $list);
		}
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}


// Return list post items from any post type and taxonomy
if ( !function_exists( 'hampton_get_list_posts' ) ) {
	function hampton_get_list_posts($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'taxonomy'			=> 'category',
			'taxonomy_value'	=> '',
			'posts_per_page'	=> -1,
			'orderby'			=> 'post_date',
			'order'				=> 'desc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));

		$hash = 'list_posts_'.($opt['post_type']).'_'.($opt['taxonomy']).'_'.($opt['taxonomy_value']).'_'.($opt['orderby']).'_'.($opt['order']).'_'.($opt['return']).'_'.($opt['posts_per_page']);
		if (($list = hampton_storage_get($hash))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'hampton');
			$args = array(
				'post_type' => $opt['post_type'],
				'post_status' => $opt['post_status'],
				'posts_per_page' => $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'	=> $opt['orderby'],
				'order'		=> $opt['order']
			);
			if (!empty($opt['taxonomy_value'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field' => (int) $opt['taxonomy_value'] > 0 ? 'id' : 'slug',
						'terms' => $opt['taxonomy_value']
					)
				);
			}
			$posts = get_posts( $args );
			if (is_array($posts) && count($posts) > 0) {
				foreach ($posts as $post) {
					$list[$opt['return']=='id' ? $post->ID : $post->post_title] = $post->post_title;
				}
			}
			hampton_storage_set($hash, $list);
		}
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}


// Return list of registered users
if ( !function_exists( 'hampton_get_list_users' ) ) {
	function hampton_get_list_users($prepend_inherit=false, $roles=array('administrator', 'editor', 'author', 'contributor', 'shop_manager')) {
		if (($list = hampton_storage_get('list_users'))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'hampton');
			$args = array(
				'orderby'	=> 'display_name',
				'order'		=> 'ASC' );
			$users = get_users( $args );
			if (is_array($users) && count($users) > 0) {
				foreach ($users as $user) {
					$accept = true;
					if (is_array($user->roles)) {
						if (is_array($user->roles) && count($user->roles) > 0) {
							$accept = false;
							foreach ($user->roles as $role) {
								if (in_array($role, $roles)) {
									$accept = true;
									break;
								}
							}
						}
					}
					if ($accept) $list[$user->user_login] = $user->display_name;
				}
			}
			hampton_storage_set('list_users', $list);
		}
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}

// Return menus list, prepended inherit
if ( !function_exists( 'hampton_get_list_menus' ) ) {
	function hampton_get_list_menus($prepend_inherit=false) {
		if (($list = hampton_storage_get('list_menus'))=='') {
			$list = array();
			$list['default'] = esc_html__("Default", 'hampton');
			$menus = wp_get_nav_menus();
			if (is_array($menus) && count($menus) > 0) {
				foreach ($menus as $menu) {
					$list[$menu->slug] = $menu->name;
				}
			}
			hampton_storage_set('list_menus', $list);
		}
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}

// Return iconed classes list
if ( !function_exists( 'hampton_get_list_icons' ) ) {
	function hampton_get_list_icons($prepend_inherit=false) {
		static $list = false;
		if (!is_array($list)) 
			$list = !is_admin() ? array() : hampton_parse_icons_classes(hampton_get_file_dir("css/fontello/css/fontello-codes.css"));
		return $prepend_inherit ? hampton_array_merge(array('inherit' => esc_html__("Inherit", 'hampton')), $list) : $list;
	}
}
?>