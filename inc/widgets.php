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

    // Pages sidebar
    $enable_page_sidebar = wpsp_get_redux( 'is-pages-custom-sidebar', false );
    if ( $enable_page_sidebar ) {

        register_sidebar( array(
            'name'          => __( 'Page sidebar', 'newstore' ),
            'id'            => 'page-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );

    }

    // Search sidebar
    $enable_search_sidebar = wpsp_get_redux( 'is-search-custom-sidebar', false );
    if ( $enable_search_sidebar ) {

        register_sidebar( array(
            'name'          => __( 'Search sidebar', 'newstore' ),
            'id'            => 'search-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );

    }

    // Footer sidebars
    $is_footer_widgets = wpsp_get_redux( 'is-footer-widgets', false );

    // Register footer widgts if enable
    if ( $is_footer_widgets ) {
        // Footer widget columns
        $footer_widget_cols = wpsp_get_redux( 'footer-widgets-columns', '4' );

        // Footer widget 1
        register_sidebar( array(
            'name'          => __( 'Footer column 1', 'newstore' ),
            'id'            => 'footer-sidebar-1',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );

        // Footer widget 2
        if ( $footer_widget_cols > 1 ) {
            register_sidebar( array(
                'name'          => __( 'Footer column 2', 'newstore' ),
                'id'            => 'footer-sidebar-2',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            ) );
        }

        // Footer widget 3
        if ( $footer_widget_cols > 2 ) {
            register_sidebar( array(
                'name'          => __( 'Footer column 3', 'newstore' ),
                'id'            => 'footer-sidebar-3',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            ) );
        }

        // Footer widget 4
        if ( $footer_widget_cols > 3 ) {
            register_sidebar( array(
                'name'          => __( 'Footer column 4', 'newstore' ),
                'id'            => 'footer-sidebar-4',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            ) );
        }

        // Footer widget 5
        if ( $footer_widget_cols > 4 ) {
            register_sidebar( array(
                'name'          => __( 'Footer column 5', 'newstore' ),
                'id'            => 'footer-sidebar-5',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            ) );
        }
    }


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