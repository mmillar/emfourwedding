<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add an option to the framework.
 *
 * @uses stag_update_option() Adds/updates the specific option.
 * @param  string $name  Name of the option.
 * @param  string $value Optional. Value of the option.
 * @return void
 */
function stag_add_option( $name, $value ){
	stag_update_option( $name, $value );
}

/**
 * Adds/Updates the specific framework option.
 *
 * @param  string $name  Name of the option.
 * @param  string $value Optional. Value of the option.
 * @return void
 */
function stag_update_option( $name, $value ){
	$stag_values        = get_option( 'stag_framework_values' );
	$stag_values[$name] = $value;
	update_option( 'stag_framework_values', $stag_values );
}

/**
 * Remove a framework option already saved.
 *
 * @param  string $name Name of the function to remove.
 * @return void
 */
function stag_remove_option( $name ){
	$stag_values = get_option( 'stag_framework_values' );
	unset($stag_values[$name]);
	update_option( 'stag_framework_values', $stag_values );
}

/**
 * Get an option from the framework.
 *
 * @param  string $name Name of key of which to get the value from saved options
 * @return void
 */
function stag_get_option( $name ){
	$stag_values = get_option( 'stag_framework_values' );
	if( @array_key_exists( $name, $stag_values ) ) {
		return $stag_values[$name];
	}
	return false;
}

/**
 * Check if theme is just activated.
 *
 * @return bool
 */
function stag_is_theme_activated(){
	global $pagenow;
	if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" )
		return true;
	return false;
}

/**
 * Add version meta under <head>.
 *
 * @return void
 */
function stag_add_version_meta() {
	echo '<meta name="generator" content="' . STAG_THEME_NAME . ' ' . STAG_THEME_VERSION . '">'."\n";
	echo '<meta name="generator" content="StagFramework ' . STAG_FRAMEWORK_VERSION . '">'."\n";
}
add_action( 'wp_head', 'stag_add_version_meta', 10 );

/**
 * Filters that allow shortcodes in Text widgets
 */
add_filter( 'widget_text', 'shortcode_unautop' );
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Add browser body classes.
 *
 * @param  array $classes An array containing classes for body
 * @return void
 */
function stag_body_class( $classes ) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) {
		$browser = $_SERVER['HTTP_USER_AGENT'];
		$browser = substr( "$browser", 25, 8);
		if ($browser == "MSIE 7.0"  ) {
			$classes[] = 'ie7';
			$classes[] = 'ie';
		} elseif ($browser == "MSIE 6.0" ) {
			$classes[] = 'ie6';
			$classes[] = 'ie';
		} elseif ($browser == "MSIE 8.0" ) {
			$classes[] = 'ie8';
			$classes[] = 'ie';
		} elseif ($browser == "MSIE 9.0" ) {
			$classes[] = 'ie9';
			$classes[] = 'ie';
		} else {
			$classes[] = 'ie';
		}
	}
	else $classes[] = 'unknown';

	if( $is_iphone ) $classes[] = 'iphone';

	return $classes;
}
add_filter( 'body_class', 'stag_body_class' );

/**
 * Minify custom CSS.
 *
 * @since 2.0.1.2
 * @param  mixed $css Unminified css
 * @return mixed Minfied CSS output.
 */
function stag_minify_css( $css ) {
	$is_minify_on = stag_get_option('style_minify_css');

	if( isset($is_minify_on) && $is_minify_on == "on" ) {
		// Remove comments
		$css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
		// Remove space after colons
		$css = str_replace(': ', ':', $css);
		// Remove whitespace
		$css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
	}

	return $css;
}
add_filter( 'stag_minify_css', 'stag_minify_css' );
