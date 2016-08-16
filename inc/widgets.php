<?php
/**
 * Declaring widgets
 *
 *
 * @package newstore
 */
function wpsp_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'newstore' ),
		'id'            => 'sidebar-1',
		'description'   => 'Sidebar widget area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

    register_sidebar( array(
        'name'          => __( 'Hero Slider', 'newstore' ),
        'id'            => 'hero',
        'description'   => 'Hero slider area. Place two or more widgets here and they will slide!',
        'before_widget' => '<div class="item">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ) );

    register_sidebar( array(
        'name'          => __( 'Hero Static', 'newstore' ),
        'id'            => 'statichero',
        'description'   => 'Static Hero widget. no slider functionallity',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );

        register_sidebar( array(
        'name'          => __( 'Footer Full', 'newstore' ),
        'id'            => 'footerfull',
        'description'   => 'Widget area below main content and above footer',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );

}
add_action( 'widgets_init', 'wpsp_widgets_init' );

/**
 * Setup default sidebar of each pages and posts
 *
 * @version 1.0.0
 */
if ( ! function_exists( 'wpsp_sidebar_primary' ) ) :    
function wpsp_sidebar_primary() {
    
    $sidebar = 'sidebar-1';

    // Set sidebar based on page
    if ( is_home() && wpsp_get_redux('sidebar-global') ) $sidebar = wpsp_get_redux('sidebar-global');

    if ( is_single() && wpsp_get_redux('sidebar-single') ) $sidebar = wpsp_get_redux('sidebar-single');
    if ( is_archive() && wpsp_get_redux('sidebar-archive') ) $sidebar = wpsp_get_redux('sidebar-archive');
    if ( is_category() && wpsp_get_redux('sidebar-category') ) $sidebar = wpsp_get_redux('sidebar-category');
    if ( is_search() && wpsp_get_redux('sidebar-search') ) $sidebar = wpsp_get_redux('sidebar-search');
    if ( is_404() && wpsp_get_redux('sidebar-404') ) $sidebar = wpsp_get_redux('sidebar-404');
    if ( is_page() && wpsp_get_redux('sidebar-page') ) $sidebar = wpsp_get_redux('sidebar-page');

    /***
     * FILTER    => Add filter for tweaking the sidebar display via child theme's
     * IMPORTANT => Must be added before meta options so that it doesn't take priority
     ***/
    $sidebar = apply_filters( 'wpsp_sidebar_primary', $sidebar );

    // Check for page/post specific sidebar
    if ( is_page() || is_single() ) {
        // Reset post data
        wp_reset_postdata();
        global $post;
        // Get meta
        $meta = get_post_meta($post->ID,'wpsp_sidebar_primary',true);
        if ( $meta ) { $sidebar = $meta; }
    }

    // Return sidebar
    return $sidebar;
}
endif;