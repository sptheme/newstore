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
 * Include all custom widget classes
 *
 * @since 12.0.0
 */
function custom_widgets() {

    // Define directory for widgets
    $dir = get_template_directory() .'/inc/widgets/';

    // Define array of custom widgets for the theme so you can easily disable any
    $widgets = array(
        'newsletter',
    );

    // Add templatera widget
    if ( function_exists( 'templatera_init' ) ) {
        $widgets['templatera'] = 'templatera';
    }

    // Apply filters
    $widgets = apply_filters( 'wpsp_custom_widgets', $widgets );

    // Loop through array and register the custom widgets
    if ( $widgets && is_array( $widgets ) ) {
        foreach ( $widgets as $widget ) {
            require_once( $dir . $widget .'.php' );
        }
    }

}
add_action( 'widgets_init', 'custom_widgets' );