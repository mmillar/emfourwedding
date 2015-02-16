<?php
/**
 * Add compatibility with Gravity Forms.
 *
 * @package StagFramework
 * @subpackage GeekLove
 * @since 2.0
 */

if ( ! class_exists( 'GFForms' ) ) return;

function stag_add_gravity_scripts() {
	wp_register_style( 'stag-gravity', get_template_directory_uri() . '/config-gravityforms/gravity-mod.css', array(), STAG_THEME_VERSION, 'screen' );
	wp_enqueue_style( 'stag-gravity');
}
add_action( 'wp_enqueue_scripts', 'stag_add_gravity_scripts' );
