<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage HAMPTON
 * @since HAMPTON 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('hampton_storage_get')) {
	function hampton_storage_get($var_name, $default='') {
		global $HAMPTON_STORAGE;
		return isset($HAMPTON_STORAGE[$var_name]) ? $HAMPTON_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('hampton_storage_set')) {
	function hampton_storage_set($var_name, $value) {
		global $HAMPTON_STORAGE;
		$HAMPTON_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('hampton_storage_empty')) {
	function hampton_storage_empty($var_name, $key='', $key2='') {
		global $HAMPTON_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($HAMPTON_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($HAMPTON_STORAGE[$var_name][$key]);
		else
			return empty($HAMPTON_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('hampton_storage_isset')) {
	function hampton_storage_isset($var_name, $key='', $key2='') {
		global $HAMPTON_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($HAMPTON_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($HAMPTON_STORAGE[$var_name][$key]);
		else
			return isset($HAMPTON_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('hampton_storage_inc')) {
	function hampton_storage_inc($var_name, $value=1) {
		global $HAMPTON_STORAGE;
		if (empty($HAMPTON_STORAGE[$var_name])) $HAMPTON_STORAGE[$var_name] = 0;
		$HAMPTON_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('hampton_storage_concat')) {
	function hampton_storage_concat($var_name, $value) {
		global $HAMPTON_STORAGE;
		if (empty($HAMPTON_STORAGE[$var_name])) $HAMPTON_STORAGE[$var_name] = '';
		$HAMPTON_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('hampton_storage_get_array')) {
	function hampton_storage_get_array($var_name, $key, $key2='', $default='') {
		global $HAMPTON_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($HAMPTON_STORAGE[$var_name][$key]) ? $HAMPTON_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($HAMPTON_STORAGE[$var_name][$key][$key2]) ? $HAMPTON_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('hampton_storage_set_array')) {
	function hampton_storage_set_array($var_name, $key, $value) {
		global $HAMPTON_STORAGE;
		if (!isset($HAMPTON_STORAGE[$var_name])) $HAMPTON_STORAGE[$var_name] = array();
		if ($key==='')
			$HAMPTON_STORAGE[$var_name][] = $value;
		else
			$HAMPTON_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('hampton_storage_set_array2')) {
	function hampton_storage_set_array2($var_name, $key, $key2, $value) {
		global $HAMPTON_STORAGE;
		if (!isset($HAMPTON_STORAGE[$var_name])) $HAMPTON_STORAGE[$var_name] = array();
		if (!isset($HAMPTON_STORAGE[$var_name][$key])) $HAMPTON_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$HAMPTON_STORAGE[$var_name][$key][] = $value;
		else
			$HAMPTON_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Merge array elements
if (!function_exists('hampton_storage_merge_array')) {
	function hampton_storage_merge_array($var_name, $key, $value) {
		global $HAMPTON_STORAGE;
		if (!isset($HAMPTON_STORAGE[$var_name])) $HAMPTON_STORAGE[$var_name] = array();
		if ($key==='')
			$HAMPTON_STORAGE[$var_name] = array_merge($HAMPTON_STORAGE[$var_name], $value);
		else
			$HAMPTON_STORAGE[$var_name][$key] = array_merge($HAMPTON_STORAGE[$var_name][$key], $value);
	}
}

// Add array element after the key
if (!function_exists('hampton_storage_set_array_after')) {
	function hampton_storage_set_array_after($var_name, $after, $key, $value='') {
		global $HAMPTON_STORAGE;
		if (!isset($HAMPTON_STORAGE[$var_name])) $HAMPTON_STORAGE[$var_name] = array();
		if (is_array($key))
			hampton_array_insert_after($HAMPTON_STORAGE[$var_name], $after, $key);
		else
			hampton_array_insert_after($HAMPTON_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('hampton_storage_set_array_before')) {
	function hampton_storage_set_array_before($var_name, $before, $key, $value='') {
		global $HAMPTON_STORAGE;
		if (!isset($HAMPTON_STORAGE[$var_name])) $HAMPTON_STORAGE[$var_name] = array();
		if (is_array($key))
			hampton_array_insert_before($HAMPTON_STORAGE[$var_name], $before, $key);
		else
			hampton_array_insert_before($HAMPTON_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('hampton_storage_push_array')) {
	function hampton_storage_push_array($var_name, $key, $value) {
		global $HAMPTON_STORAGE;
		if (!isset($HAMPTON_STORAGE[$var_name])) $HAMPTON_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($HAMPTON_STORAGE[$var_name], $value);
		else {
			if (!isset($HAMPTON_STORAGE[$var_name][$key])) $HAMPTON_STORAGE[$var_name][$key] = array();
			array_push($HAMPTON_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('hampton_storage_pop_array')) {
	function hampton_storage_pop_array($var_name, $key='', $defa='') {
		global $HAMPTON_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($HAMPTON_STORAGE[$var_name]) && is_array($HAMPTON_STORAGE[$var_name]) && count($HAMPTON_STORAGE[$var_name]) > 0) 
				$rez = array_pop($HAMPTON_STORAGE[$var_name]);
		} else {
			if (isset($HAMPTON_STORAGE[$var_name][$key]) && is_array($HAMPTON_STORAGE[$var_name][$key]) && count($HAMPTON_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($HAMPTON_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('hampton_storage_inc_array')) {
	function hampton_storage_inc_array($var_name, $key, $value=1) {
		global $HAMPTON_STORAGE;
		if (!isset($HAMPTON_STORAGE[$var_name])) $HAMPTON_STORAGE[$var_name] = array();
		if (empty($HAMPTON_STORAGE[$var_name][$key])) $HAMPTON_STORAGE[$var_name][$key] = 0;
		$HAMPTON_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('hampton_storage_concat_array')) {
	function hampton_storage_concat_array($var_name, $key, $value) {
		global $HAMPTON_STORAGE;
		if (!isset($HAMPTON_STORAGE[$var_name])) $HAMPTON_STORAGE[$var_name] = array();
		if (empty($HAMPTON_STORAGE[$var_name][$key])) $HAMPTON_STORAGE[$var_name][$key] = '';
		$HAMPTON_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('hampton_storage_call_obj_method')) {
	function hampton_storage_call_obj_method($var_name, $method, $param=null) {
		global $HAMPTON_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($HAMPTON_STORAGE[$var_name]) ? $HAMPTON_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($HAMPTON_STORAGE[$var_name]) ? $HAMPTON_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('hampton_storage_get_obj_property')) {
	function hampton_storage_get_obj_property($var_name, $prop, $default='') {
		global $HAMPTON_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($HAMPTON_STORAGE[$var_name]->$prop) ? $HAMPTON_STORAGE[$var_name]->$prop : $default;
	}
}
?>