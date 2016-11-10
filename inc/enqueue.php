<?php
/**
 * newstore enqueue scripts
 *
 * @package newstore
 */

function wpsp_scripts() {

    wp_enqueue_style( 'google-font-english', 'https://fonts.googleapis.com/css?family=Montserrat|Open+Sans:400,400i,600,600i' );

    wp_enqueue_style( 'styles', get_stylesheet_directory_uri() . '/css/theme.min.css', array(), '0.4.6');
    wp_enqueue_script('jquery'); 
    wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/theme.min.js', array(), '0.4.6', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

add_action( 'wp_enqueue_scripts', 'wpsp_scripts' );


/** 
* Loading slider script conditionally
*
* @version 1.0.0
*/

if ( is_active_sidebar( 'hero' ) ):
add_action("wp_enqueue_scripts","wpsp_slider");
  
function wpsp_slider(){
    if ( is_front_page() ) {    
    $data = array(
        "timeout"=> intval( get_theme_mod( 'wpsp_theme_slider_time_setting', 5000 )),
        "items"=> intval( get_theme_mod( 'wpsp_theme_slider_count_setting', 1 ))
    	);

    wp_enqueue_script("slider-script", get_stylesheet_directory_uri() . '/js/slider_settings.js', array(), '0.4.6');
    wp_localize_script( "slider-script", "wpsp_slider_variables", $data );
    }
}
endif;

