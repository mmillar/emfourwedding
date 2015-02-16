<?php

function stag_customize_register( $wp_customize ){

    $wp_customize->add_section('accent_control', array(
        'title' => __('Styling Options', 'stag'),
        'description' => null,
        'priority' => 36,
    ));
    $wp_customize->add_section('blog_settings', array(
        'title' => __('Blog Settings', 'stag'),
        'priority' => 50,
    ));

    $wp_customize->add_setting( 'stag_framework_values[style_background_color]' , array(
        'default'   => '#ffffff',
        'type'      => 'option',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'stag_framework_values[style_background_color]', array(
        'label'    => __('Choose Site Background', 'stag'),
        'section'  => 'accent_control',
        'settings' => 'stag_framework_values[style_background_color]',
    )));

    $wp_customize->add_setting( 'stag_framework_values[accent_color]' , array(
        'default'   => '#d44646',
        'type'      => 'option',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'stag_framework_values[accent_color]', array(
        'label' => __('Choose accent color', 'stag'),
        'section' => 'accent_control',
        'settings' => 'stag_framework_values[accent_color]',
    )));


    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'stag_customize_register' );

function proxy_customize_css() {
    ?>
<style type="text/css">

body, .container{ background-color:<?php echo stag_get_option('style_background_color'); ?>; }

hr.section-divider:after{ background-color:<?php echo stag_get_option('style_background_color'); ?>; }

.accent-color, a, .wedding-couple-wrap h2, [class*="icon-"], [data-icon]:before, .hentry:before, .countdown-section:before, .section-title, #reply-title,h3#comments,.comment-author, .commentlist li:after, .entry-content h2,.stag-toggle .ui-state-active,.stag-tabs ul.stag-nav .ui-state-active a,.stag-divider.plain:after{ color:<?php echo stag_get_option('accent_color'); ?>; }

::selection{ background-color:<?php echo stag_get_option('accent_color'); ?>; }
::-moz-selection{ background-color:<?php echo stag_get_option('accent_color'); ?>; color: #fff; }
.wedding-couple-wrap .person-info:first-child:before{ background-color:<?php echo stag_get_option('accent_color'); ?>; }

.meta-data,.accent-background, #navigation, #primary-menu ul,#mobile-nav,#mobile-primary-nav,input[type="submit"], button, .button, .stag-button, .countdown-section, .nav-next a, .nav-prev a, .page-numbers, blockquote{ background-color:<?php echo stag_get_option('accent_color'); ?>; }

.person-info:first-child:after{ background-color:<?php echo stag_get_option('accent_color'); ?>; }


</style>
    <?php
}
add_action( 'wp_head', 'proxy_customize_css');

function geeklove_customizer_live_preview() {
    wp_enqueue_script( 'geeklove-themecustomizer', get_template_directory_uri().'/assets/js/theme-customizer.js', array( 'jquery','customize-preview' ), STAG_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'geeklove_customizer_live_preview' );

/**
 * Textarea Control
 *
 * Attach the custom textarea control to the `customize_register` action
 * so the WP_Customize_Control class is initiated.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function stag_customize_textarea_control( $wp_customize ) {
    /**
     * Textarea Control
     */
    class Stag_Customize_Textarea_Control extends WP_Customize_Control {
        public $type = 'textarea';

        public function render_content() {
    ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        </label>

        <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
    <?php
        }
    }
}
add_action( 'customize_register', 'stag_customize_textarea_control', 1, 1 );
