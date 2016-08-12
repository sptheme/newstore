<?php
/**
 * newstore Theme Customizer
 *
 * @package newstore
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function wpsp_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

}
add_action( 'customize_register', 'wpsp_customize_register' );

function wpsp_theme_customize_register( $wp_customize ) {

    $wp_customize->add_section( 'wpsp_theme_slider_options', array(
        'title'          => __( 'Slider Settings', 'newstore' )
    ) );

    $wp_customize->add_setting( 'wpsp_theme_slider_count_setting', array(
        'default'        => '1',
        'sanitize_callback' => 'absint'
    ) );

    $wp_customize->add_control( 'wpsp_theme_slider_count', array(
        'label'      => __( 'Number of slides displaying at once', 'newstore' ),
        'section'    => 'wpsp_theme_slider_options',
        'type'       => 'text',
        'settings'   => 'wpsp_theme_slider_count_setting'
    ) );

    $wp_customize->add_setting( 'wpsp_theme_slider_time_setting', array(
        'default'        => '5000',
        'sanitize_callback' => 'absint'
    ) );

    $wp_customize->add_control( 'wpsp_theme_slider_time', array(
        'label'      => __( 'Slider Time (in ms)', 'newstore' ),
        'section'    => 'wpsp_theme_slider_options',
        'type'       => 'text',
        'settings'   => 'wpsp_theme_slider_time_setting'
    ) );

    $wp_customize->add_setting( 'wpsp_theme_slider_loop_setting', array(
        'default'        => 'true',
        'sanitize_callback' => 'esc_textarea'
    ) );

    $wp_customize->add_control( 'wpsp_theme_loop', array(
        'label'      => __( 'Loop Slider Content', 'newstore' ),
        'section'    => 'wpsp_theme_slider_options',
        'type'     => 'radio',
        'choices'  => array(
            'true'  => 'yes',
            'false' => 'no',
        ),
        'settings'   => 'wpsp_theme_slider_loop_setting'
    ) );

}
add_action( 'customize_register', 'wpsp_theme_customize_register' );



/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function wpsp_customize_preview_js() {
	wp_enqueue_script( 'wpsp_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'wpsp_customize_preview_js' );
