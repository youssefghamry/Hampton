<?php
/**
 * File system manipulations
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


/* Enqueue scripts and styles from child or main theme directory and use .min version
------------------------------------------------------------------------------------- */

// Enqueue .min.css (if exists and filetime .min.css > filetime .css) instead .css
if (!function_exists('trx_addons_enqueue_style')) {	
	function trx_addons_enqueue_style($handle, $src=false, $depts=array(), $ver=null, $media='all') {
		global $TRX_ADDONS_STORAGE;
		$load = true;
		if (!is_array($src) && $src !== false && $src !== '') {
			$theme_dir = get_template_directory().'/'.$TRX_ADDONS_STORAGE['plugin_base'][0].'/';
			$theme_url = get_template_directory_uri().'/'.$TRX_ADDONS_STORAGE['plugin_base'][0].'/';
			$child_dir = get_stylesheet_directory().'/'.$TRX_ADDONS_STORAGE['plugin_base'][0].'/';
			$child_url = get_stylesheet_directory_uri().'/'.$TRX_ADDONS_STORAGE['plugin_base'][0].'/';
			$dir = $url = '';
			if (strpos($src, $child_url)===0) {
				$dir = $child_dir;
				$url = $child_url;
			} else if (strpos($src, $theme_url)===0) {
				$dir = $theme_dir;
				$url = $theme_url;
			} else if (strpos($src, $TRX_ADDONS_STORAGE['plugin_url'])===0) {
				$dir = $TRX_ADDONS_STORAGE['plugin_dir'];
				$url = $TRX_ADDONS_STORAGE['plugin_url'];
			}
			if ($dir != '') {
				if (substr($src, -4)=='.css') {
					if (substr($src, -8)!='.min.css') {
						$src_min = substr($src, 0, strlen($src)-4).'.min.css';
						$file_src = $dir . substr($src, strlen($url));
						$file_min = $dir . substr($src_min, strlen($url));
						if (file_exists($file_min) && filemtime($file_src) <= filemtime($file_min)) $src = $src_min;
					}
				}
				$file_src = $dir . substr($src, strlen($url));
				$load = file_exists($file_src) && filesize($file_src) > 0;
			}
		}
		if ($load) {
			if (is_array($src))
				wp_enqueue_style( $handle, $depts, $ver, $media );
			else if (!empty($src) || $src===false)
				wp_enqueue_style( $handle, $src, $depts, $ver, $media );
		}
	}
}

// Enqueue .min.js (if exists and filetime .min.js > filetime .js) instead .js
if (!function_exists('trx_addons_enqueue_script')) {	
	function trx_addons_enqueue_script($handle, $src=false, $depts=array(), $ver=null, $in_footer=true) {
		global $TRX_ADDONS_STORAGE;
		$load = true;
		if (!is_array($src) && $src !== false && $src !== '') {
			$theme_dir = get_template_directory().'/'.$TRX_ADDONS_STORAGE['plugin_base'][0].'/';
			$theme_url = get_template_directory_uri().'/'.$TRX_ADDONS_STORAGE['plugin_base'][0].'/';
			$child_dir = get_stylesheet_directory().'/'.$TRX_ADDONS_STORAGE['plugin_base'][0].'/';
			$child_url = get_stylesheet_directory_uri().'/'.$TRX_ADDONS_STORAGE['plugin_base'][0].'/';
			$dir = $url = '';
			if (strpos($src, $child_url)===0) {
				$dir = $child_dir;
				$url = $child_url;
			} else if (strpos($src, $theme_url)===0) {
				$dir = $theme_dir;
				$url = $theme_url;
			} else if (strpos($src, $TRX_ADDONS_STORAGE['plugin_url'])===0) {
				$dir = $TRX_ADDONS_STORAGE['plugin_dir'];
				$url = $TRX_ADDONS_STORAGE['plugin_url'];
			}
			if ($dir != '') {
				if (substr($src, -3)=='.js') {
					if (substr($src, -7)!='.min.js') {
						$src_min  = substr($src, 0, strlen($src)-3).'.min.js';
						$file_src = $dir . substr($src, strlen($url));
						$file_min = $dir . substr($src_min, strlen($url));
						if (file_exists($file_min) && filemtime($file_src) <= filemtime($file_min)) $src = $src_min;
					}
				}
				$file_src = $dir . substr($src, strlen($url));
				$load = file_exists($file_src) && filesize($file_src) > 0;
			}
		}
		if ($load) {
			if (is_array($src)) {
				wp_enqueue_script( $handle, $depts, $ver, $in_footer );
			} else if (!empty($src) || $src===false) {
				wp_enqueue_script( $handle, $src, $depts, $ver, $in_footer );
			}
		}
	}
}

//  Enqueue Swiper Slider scripts and styles
if ( !function_exists( 'trx_addons_enqueue_slider' ) ) {
	function trx_addons_enqueue_slider($engine='all') {
		if ($engine=='all' || $engine=='swiper') {
			trx_addons_enqueue_style(  'swiperslider', trx_addons_get_file_url('js/swiper/swiper.css'), array(), null );
			trx_addons_enqueue_script( 'swiperslider', trx_addons_get_file_url('js/swiper/swiper.jquery.js'), array('jquery'), null, true );
		}
	}
}

// Enqueue popup scripts and styles
// Link must have attribute: data-rel="popupEngine" or data-rel="popupEngine[gallery]"
if ( !function_exists( 'trx_addons_enqueue_popup' ) ) {
	function trx_addons_enqueue_popup($engine='') {
		if ($engine=='pretty') {
			trx_addons_enqueue_style(  'prettyphoto',	trx_addons_get_file_url('js/prettyphoto/css/prettyPhoto.css'), array(), null );
			trx_addons_enqueue_script( 'prettyphoto',	trx_addons_get_file_url('js/prettyphoto/jquery.prettyPhoto.min.js'), array('jquery'), 'no-compose', true );
		} else {
			trx_addons_enqueue_style(  'magnific-popup',trx_addons_get_file_url('js/magnific/magnific-popup.css'), array(), null );
			trx_addons_enqueue_script( 'magnific-popup',trx_addons_get_file_url('js/magnific/jquery.magnific-popup.js'), array('jquery'), '', true );
		}
	}
}


/* Check if file/folder present in the child theme and return path (url) to it. 
   Else - path (url) to file in the main theme dir
------------------------------------------------------------------------------------- */
if (!function_exists('trx_addons_get_file_dir')) {	
	function trx_addons_get_file_dir($file, $return_url=false) {
		global $TRX_ADDONS_STORAGE;
		if ($file[0]=='/') $file = substr($file, 1);
		$theme_dir = get_template_directory().'/'.$TRX_ADDONS_STORAGE['plugin_base'][0].'/';
		$theme_url = get_template_directory_uri().'/'.$TRX_ADDONS_STORAGE['plugin_base'][0].'/';
		$child_dir = get_stylesheet_directory().'/'.$TRX_ADDONS_STORAGE['plugin_base'][0].'/';
		$child_url = get_stylesheet_directory_uri().'/'.$TRX_ADDONS_STORAGE['plugin_base'][0].'/';
		$dir = '';
		if (file_exists(($child_dir).($file)))
			$dir = ($return_url ? $child_url : $child_dir).($file);
		else if (file_exists(($theme_dir).($file)))
			$dir = ($return_url ? $theme_url : $theme_dir).($file);
		else if (file_exists(($TRX_ADDONS_STORAGE['plugin_dir']).($file)))
			$dir = ($return_url ? $TRX_ADDONS_STORAGE['plugin_url'] : $TRX_ADDONS_STORAGE['plugin_dir']).($file);
		return $dir;
	}
}

if (!function_exists('trx_addons_get_file_url')) {	
	function trx_addons_get_file_url($file) {
		return trx_addons_get_file_dir($file, true);
	}
}

// Return file extension from full name/path
if (!function_exists('trx_addons_get_file_ext')) {	
	function trx_addons_get_file_ext($file) {
		$parts = pathinfo($file);
		return $parts['extension'];
	}
}


// Get domain part from URL
if (!function_exists('trx_addons_get_domain_from_url')) {
	function trx_addons_get_domain_from_url($url) {
		if (($pos=strpos($url, '://'))!==false) $url = substr($url, $pos+3);
		if (($pos=strpos($url, '/'))!==false) $url = substr($url, 0, $pos);
		return $url;
	}
}


/* Init WP Filesystem before the plugins and theme init
------------------------------------------------------------------- */
if (!function_exists('trx_addons_init_filesystem')) {
	add_action( 'after_setup_theme', 'trx_addons_init_filesystem', 0);
	function trx_addons_init_filesystem() {
        if( !function_exists('WP_Filesystem') ) {
            require_once( ABSPATH .'/wp-admin/includes/file.php' );
        }
		if (is_admin()) {
			$url = admin_url();
			$creds = false;
			// First attempt to get credentials.
			if ( function_exists('request_filesystem_credentials') && false === ( $creds = request_filesystem_credentials( $url, '', false, false, array() ) ) ) {
				// If we comes here - we don't have credentials
				// so the request for them is displaying no need for further processing
				return false;
			}
	
			// Now we got some credentials - try to use them.
			if ( !WP_Filesystem( $creds ) ) {
				// Incorrect connection data - ask for credentials again, now with error message.
				if ( function_exists('request_filesystem_credentials') ) request_filesystem_credentials( $url, '', true, false );
				return false;
			}
			
			return true; // Filesystem object successfully initiated.
		} else {
            WP_Filesystem();
		}
		return true;
	}
}



// Put data into specified file
if (!function_exists('trx_addons_fpc')) {
    function trx_addons_fpc($file, $data, $flag=0) {
        global $wp_filesystem;
        if (!empty($file)) {
            if (isset($wp_filesystem) && is_object($wp_filesystem)) {
                $file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
                // Attention! WP_Filesystem can't append the content to the file!
                if ($flag==FILE_APPEND && $wp_filesystem->exists($file) && strpos($file, '//')===false) {
                    // If it is a existing local file (not contain '//' in the path) and we need to append data -
                    // use native PHP function to prevent large consumption of memory
                    return file_put_contents($file, $data, $flag);
                } else {
                    // In other case (not a local file or not need to append data or file not exists)
                    // That's why we have to read the contents of the file into a string,
                    // add new content to this string and re-write it to the file if parameter $flag == FILE_APPEND!
                    return $wp_filesystem->put_contents($file, ($flag==FILE_APPEND && $wp_filesystem->exists($file) ? $wp_filesystem->get_contents($file) : '') . $data, false);
                }
            } else {
                if (trx_addons_is_on(trx_addons_get_option('debug_mode')))
                    throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Put contents to the file "%s" failed', 'trx_addons'), $file));
            }
        }
        return false;
    }
}

// Get text from specified file
if (!function_exists('trx_addons_fgc')) {
    function trx_addons_fgc($file, $unpack=false) {
        static $allow_url_fopen = -1;
        if ($allow_url_fopen==-1) $allow_url_fopen = (int) ini_get('allow_url_fopen');
        global $wp_filesystem;
        if (!empty($file)) {
            if (isset($wp_filesystem) && is_object($wp_filesystem)) {
                $file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
                $tmp_cont = !$allow_url_fopen && strpos($file, '//')!==false
                    ? trx_addons_remote_get($file)
                    : $wp_filesystem->get_contents($file);
                if ($unpack && trx_addons_get_file_ext($file) == 'zip') {
                    $tmp_name = 'tmp-'.rand().'.zip';
                    $tmp = wp_upload_bits($tmp_name, null, $tmp_cont);
                    if ($tmp['error'])
                        $tmp_cont = '';
                    else {
                        unzip_file($tmp['file'], dirname($tmp['file']));
                        $file_name = dirname($tmp['file']) . '/' . basename($file, '.zip') . '.txt';
                        $tmp_cont = trx_addons_fgc($file_name);
                        unlink($tmp['file']);
                        unlink($file_name);
                    }
                }
                return $tmp_cont;
            } else {
                if (trx_addons_is_on(trx_addons_get_option('debug_mode')))
                    throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Get contents from the file "%s" failed', 'trx_addons'), $file));
            }
        }
        return '';
    }
}

// Get text from specified file via HTTP (cURL)
if (!function_exists('trx_addons_remote_get')) {
    function trx_addons_remote_get($file, $timeout=-1) {
        // Set timeout as half of the PHP execution time
        if ($timeout < 1) $timeout = round( 0.5 * max(30, ini_get('max_execution_time')));
        $response = wp_remote_get($file, array(
                'timeout'     => $timeout
            )
        );
        //return wp_remote_retrieve_response_code( $response ) == 200 ? wp_remote_retrieve_body( $response ) : '';
        return isset($response['response']['code']) && $response['response']['code']==200 ? $response['body'] : '';
    }
}



// Get array with rows from specified file
if (!function_exists('trx_addons_fga')) {	
	function trx_addons_fga($file) {
		global $wp_filesystem;
		if (!empty($file)) {
			if (isset($wp_filesystem) && is_object($wp_filesystem)) {
				$file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
				return $wp_filesystem->get_contents_array($file);
			} else {
				if (trx_addons_is_on(trx_addons_get_option('debug_mode')))
					throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Get rows from the file "%s" failed', 'trx_addons'), $file));
			}
		}
		return array();
	}
}

// Remove unsafe characters from file/folder path
if (!function_exists('trx_addons_esc')) {	
	function trx_addons_esc($file) {
		return str_replace(array('\\', '~', '$', ':', ';', '+', '>', '<', '|', '"', "'", '`', "\xFF", "\x0A", "\x0D", '*', '?', '^'), '/', trim($file));
	}
}
?>