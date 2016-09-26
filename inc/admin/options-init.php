<?php

    /**
     * For full documentation, please visit: http://docs.reduxframework.com/
     * For a more extensive sample-config file, you may look at:
     * https://github.com/reduxframework/redux-framework/blob/master/sample/sample-config.php
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "redux_wpsp";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        'opt_name' => 'redux_wpsp',
        'use_cdn' => TRUE,
        'display_name' => 'Theme Options',
        'display_version' => '1.0.0',
        'page_title' => 'Theme Options',
        'update_notice' => TRUE,
        'intro_text' => '<p>This text is displayed above the options panel. It isn\’t required, but more info is always better! The intro_text field accepts all HTML.</p>’',
        'footer_text' => '<p>This text is displayed below the options panel. It isn\’t required, but more info is always better! The footer_text field accepts all HTML.</p>',
        'admin_bar' => TRUE,
        'menu_type' => 'menu',
        'menu_title' => 'Theme Options',
        'page_parent_post_type' => 'your_post_type',
        'customizer' => TRUE,
        'default_mark' => '*',
        'hints' => array(
            'icon_position' => 'right',
            'icon_size' => 'normal',
            'tip_style' => array(
                'color' => 'light',
            ),
            'tip_position' => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect' => array(
                'show' => array(
                    'duration' => '500',
                    'event' => 'mouseover',
                ),
                'hide' => array(
                    'duration' => '500',
                    'event' => 'mouseleave unfocus',
                ),
            ),
        ),
        'output' => TRUE,
        'output_tag' => TRUE,
        'settings_api' => TRUE,
        'cdn_check_time' => '1440',
        'compiler' => TRUE,
        'global_variable' => 'redux_wpsp',
        'page_permissions' => 'manage_options',
        'save_defaults' => TRUE,
        'show_import_export' => TRUE,
        'database' => 'options',
        'transient_time' => '3600',
        'network_sites' => TRUE,
    );

    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
        'title' => 'Visit us on GitHub',
        'icon'  => 'el el-github'
        //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://twitter.com/reduxframework',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://www.linkedin.com/company/redux-framework',
        'title' => 'Find us on LinkedIn',
        'icon'  => 'el el-linkedin'
    );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */

    /*
     * ---> OTHER VARIABLE
     */

    $sites_sharing = array( 
        'twitter'       => esc_html__( 'Twitter', 'wpsp-redux-framework' ),
        'facebook'      => esc_html__( 'Facebook', 'wpsp-redux-framework' ),
        'google_plus'   => esc_html__( 'Google+', 'wpsp-redux-framework' ),
        'pinterest'     => esc_html__( 'Pinterest', 'wpsp-redux-framework' ),
        );

    $header_styles_array = header_styles_array();
    $wpsp_overlay_styles_array = wpsp_overlay_styles_array();
    

    /*
     * ---> END OTHER VARIABLE
     */

    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'Theme Information 1', 'admin_folder' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'admin_folder' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => __( 'Theme Information 2', 'admin_folder' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'admin_folder' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'admin_folder' );
    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */
    // General section
    Redux::setSection( $opt_name, array(
        'title'            => __( 'General', 'wpsp-redux-framework' ),
        'id'               => 'general-options',
        'desc'             => __( '', 'wpsp-redux-framework' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-cog'
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Social Sharing', 'wpsp-redux-framework' ),
        'id'         => 'social-sharing',
        'subsection' => true,
        //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => 'social-share-sites',
                'type'     => 'checkbox',
                'multi'    => true,
                'title'    => __( 'Social share site', 'wpsp-redux-framework' ),
                'subtitle' => __( 'checked website to be display', 'wpsp-redux-framework' ),
                'options'  => $sites_sharing,
                'default'  => array('twitter' => '1', 'facebook' => '1', 'google_plus' => '1'),
            ),
            array(
                'id'       => 'social-share-position',
                'type'     => 'select',
                'title'    => __( 'Position', 'wpsp-redux-framework' ),
                'options'  => array(
                        'horizontal'   => esc_html__( 'Horizontal', 'wpsp-redux-framework' ),
                        'vertical'   => esc_html__( 'Vertical', 'wpsp-redux-framework' ),
                    ),
                'default' => 'horizontal',
            ),
            array(
                'id'       => 'is-social-share-heading',
                'type'     => 'switch',
                'title'    => __( 'Enable/disable heading', 'wpsp-redux-framework' ),
                'default'  => true,
            ),
            array(
                'id'       => 'social-share-heading',
                'type'     => 'text',
                'required' => array( 'is-social-share-heading', '=', '1' ),
                'title'    => __( 'Heading on Posts', 'wpsp-redux-framework' ),
                'default'  => __( 'Please Share This', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'social-share-style',
                'type'     => 'select',
                'title'    => __( 'Style', 'wpsp-redux-framework' ),
                'options'  => array(
                        'flat'   => esc_html__( 'Flat', 'wpsp-redux-framework' ),
                        'minimal'   => esc_html__( 'Minimal', 'wpsp-redux-framework' ),
                        'three-d'   => esc_html__( '3D', 'wpsp-redux-framework' ),
                    ),
                'default' => 'flat',
            ),
            array(
                'id'       => 'social-share-twitter-handle',
                'type'     => 'text',
                'title'    => __( 'Twitter Handle', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Twitter user name/id', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'is-social-share-pages',
                'type'     => 'switch',
                'title'    => __( 'Enable for Pages', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Enable/disable for page', 'wpsp-redux-framework' ),
                'default'  => '0'// 1 = on | 0 = off
            ),
        )
    ) );
    // General Pages title
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Page title', 'wpsp-redux-framework' ),
        'id'         => 'page-title',
        'subsection' => true,
        //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => 'page-title-style',
                'type'     => 'select',
                'title'    => __( 'Style', 'wpsp-redux-framework' ),
                'options'  => array(
                    ''                  => esc_html__( 'Default', 'wpsp-redux-framework' ),
                    'centered'          => esc_html__( 'Centered', 'wpsp-redux-framework' ),
                    'centered-minimal'  => esc_html__( 'Centered Minimal', 'wpsp-redux-framework' ),
                    'hidden'            => esc_html__( 'Hidden', 'wpsp-redux-framework' ),
                ),
                'default' => '',
            ),
            array(
                'id'       => 'page-title-background-img',
                'type'     => 'media',
                'title'    => __( 'Background image', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Upload image', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'page-title-background-img-position',
                'type'     => 'select',
                'title'    => __( 'Background Image Position', 'wpsp-redux-framework' ),
                'options'  => array(
                    'stretched'     => 'Stretched',
                    'repeat'        => 'Repeat',
                    'fixed-top'     => 'Fixed Top',
                    'fixed'         => 'Fixed Center',
                    'fixed-bottom'  => 'Fixed Bottom',
                    'repeat-x'      => 'Repeat-x',
                    'repeat-y'      => 'Repeat-y',
                ),
                'default' => 'fixed',
            ),
        )
    ) );
    // General > Pages
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Pages', 'wpsp-redux-framework' ),
        'id'         => 'single-page',
        'subsection' => true,
        //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => 'page-layout',
                'type'     => 'image_select',
                'title'    => __( 'Layout', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Layout for all Pages', 'wpsp-redux-framework' ),
                'desc'     => __( 'Other layouts will override this option if they are set', 'wpsp-redux-framework' ),
                //Must provide key => value(array:title|img) pairs for radio options
                'options'  => array(
                    'inherit' => array(
                        'alt' => 'Inherit',
                        'img' => get_template_directory_uri() . '/images/admin/layout-off.png'
                    ),
                    'full-width' => array(
                        'alt' => 'Full width',
                        'img' => get_template_directory_uri() . '/images/admin/full-width.png'
                    ),
                    'full-screen' => array(
                        'alt' => 'Full screen',
                        'img' => get_template_directory_uri() . '/images/admin/full-screen.png'
                    ),
                    'left-sidebar' => array(
                        'alt' => '2 Column Left',
                        'img' => get_template_directory_uri() . '/images/admin/2cl.png'
                    ),
                    'right-sidebar' => array(
                        'alt' => '2 Column Right',
                        'img' => get_template_directory_uri() . '/images/admin/2cr.png'
                    )
                ),
                'default'  => 'inherit',
            ),
            array(
                'id'       => 'sidebar-page',
                'type'     => 'select',
                'data'     => 'sidebar',
                'title'    => __( 'Sidebar', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Widget will apply on all pages', 'wpsp-redux-framework' ),
                'desc'     => __( 'Other sidebar will override this option if they are set', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'is-pages-custom-sidebar',
                'type'     => 'switch',
                'title'    => __( 'Enable/Disable page sidebar', 'wpsp-redux-framework' ),
                'default'  => '0'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'is-page-comments',
                'type'     => 'switch',
                'title'    => __( 'Enable/Disable comment on pages', 'wpsp-redux-framework' ),
                'default'  => '0'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'is-page-featured-image',
                'type'     => 'switch',
                'title'    => __( 'Display Featured Images', 'wpsp-redux-framework' ),
                'default'  => '0'// 1 = on | 0 = off
            ),
        )
    ) );
    // General > Error 404
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Error 404', 'wpsp-redux-framework' ),
        'id'         => 'error-404',
        'subsection' => true,
        //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => '404-layout',
                'type'     => 'image_select',
                'title'    => __( 'Layout', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Layout for 404 error page', 'wpsp-redux-framework' ),
                'desc'     => __( '[ is_404 ] Error 404 page layout', 'wpsp-redux-framework' ),
                'options'  => array(
                    'inherit' => array(
                        'alt' => 'Inherit',
                        'img' => get_template_directory_uri() . '/images/admin/layout-off.png'
                    ),
                    'full-width' => array(
                        'alt' => 'Full width',
                        'img' => get_template_directory_uri() . '/images/admin/full-width.png'
                    ),
                    'full-screen' => array(
                        'alt' => 'Full screen',
                        'img' => get_template_directory_uri() . '/images/admin/full-screen.png'
                    ),
                    'left-sidebar' => array(
                        'alt' => '2 Column Left',
                        'img' => get_template_directory_uri() . '/images/admin/2cl.png'
                    ),
                    'right-sidebar' => array(
                        'alt' => '2 Column Right',
                        'img' => get_template_directory_uri() . '/images/admin/2cr.png'
                    )
                ),
                'default'  => 'inherit',
            ),
            array(
                'id'       => 'sidebar-404',
                'type'     => 'select',
                'data'     => 'sidebar',
                'title'    => __( 'Sidebar', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Sidebar for 404 Error page', 'wpsp-redux-framework' ),
                'desc'     => __( '[ <strong>is_404</strong> ] Primary', 'wpsp-redux-framework' ),
            ),
        )
    ) );        
    // General > Search
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Search', 'wpsp-redux-framework' ),
        'id'         => 'search',
        'subsection' => true,
        //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => 'search-layout',
                'type'     => 'image_select',
                'title'    => __( 'Layout', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Layout for search page', 'wpsp-redux-framework' ),
                'desc'     => __( '[ is_search ] Search page layout', 'wpsp-redux-framework' ),
                'options'  => array(
                    'inherit' => array(
                        'alt' => 'Inherit',
                        'img' => get_template_directory_uri() . '/images/admin/layout-off.png'
                    ),
                    'full-width' => array(
                        'alt' => 'Full width',
                        'img' => get_template_directory_uri() . '/images/admin/full-width.png'
                    ),
                    'full-screen' => array(
                        'alt' => 'Full screen',
                        'img' => get_template_directory_uri() . '/images/admin/full-screen.png'
                    ),
                    'left-sidebar' => array(
                        'alt' => '2 Column Left',
                        'img' => get_template_directory_uri() . '/images/admin/2cl.png'
                    ),
                    'right-sidebar' => array(
                        'alt' => '2 Column Right',
                        'img' => get_template_directory_uri() . '/images/admin/2cr.png'
                    )
                ),
                'default'  => 'inherit',
            ),
            array(
                'id'       => 'sidebar-search',
                'type'     => 'select',
                'data'     => 'sidebar',
                'title'    => __( 'Sidebar', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Sidebar for search page', 'wpsp-redux-framework' ),
                'desc'     => __( '[ <strong>is_search</strong> ] Primary', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'search-style',
                'type'     => 'select',
                'title'    => __( 'Style', 'wpsp-redux-framework' ),
                'options'  => array(
                    'default' => 'Left Thumbnail',
                    'blog' => 'Inherit From Blog',
                ),
                'default'  => 'default'
            ),
            array(
                'id'       => 'search-posts-per-page',
                'type'     => 'text',
                'title'    => __( 'Posts Per Page', 'wpsp-redux-framework' ),
                'validate' => 'preg_replace',
                'preg'     => array(
                    'pattern'     => '/[^0-9]/s',
                    'replacement' => 'Allow only number'
                ),
                'default'  => '10',
            ),
            array(
                'id'       => 'is-search-custom-sidebar',
                'type'     => 'switch',
                'title'    => __( 'Enable/Disable search sidebar', 'wpsp-redux-framework' ),
                'desc'     => __( 'Show search sidebar on/off', 'wpsp-redux-framework' ),
                'default'  => '0'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'is-main-search',
                'type'     => 'switch',
                'title'    => __( 'Enable/Disable main search on header', 'wpsp-redux-framework' ),
                'default'  => '1'// 1 = on | 0 = off
            ),
        )
    ) );
    // General > Scroll to top
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Scroll to top', 'wpsp-redux-framework' ),
        'id'         => 'scroll-to-top',
        'subsection' => true,
        //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => 'is-scroll-top',
                'type'     => 'switch',
                'title'    => __( 'Enable/Disable Scroll Up Button', 'wpsp-redux-framework' ),
                'default'  => '1'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'scroll-top-arrow',
                'type'     => 'select',
                'required' => array( 'is-scroll-top', '=', '1' ),
                'title'    => __( 'Arrow', 'wpsp-redux-framework' ),
                'options'  => array(
                        'chevron-up' => 'chevron-up',
                        'caret-up'    => 'caret-up',
                        'angle-up'    => 'angle-up',
                        'angle-double-up'    => 'angle-double-up',
                        'long-arrow-up' => 'long-arrow-up',
                        'arrow-circle-o-up'    => 'arrow-circle-o-up',
                        'arrow-up'    => 'arrow-up',
                        'caret-square-o-up'    => 'caret-square-o-up',
                        'level-up'    => 'level-up',
                        'sort-up'    => 'sort-up',
                        'toggle-up'    => 'toggle-up',
                ),
                'default'  => 'chevron-up'
            ),
            array(
                'id'       => 'scroll-top-size',
                'type'     => 'text',
                'required' => array( 'is-scroll-top', '=', '1' ),
                'title'    => __( 'Button Size', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Enter a value in pixels. e.g:20px', 'wpsp-redux-framework' ),                
            ),
            array(
                'id'       => 'scroll-top-icon-size',
                'type'     => 'text',
                'required' => array( 'is-scroll-top', '=', '1' ),
                'title'    => __( 'Icon Size', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Enter a value in pixels. e.g:16px', 'wpsp-redux-framework' ),                
            ),
            array(
                'id'       => 'scroll-top-border-radius',
                'type'     => 'text',
                'required' => array( 'is-scroll-top', '=', '1' ),
                'title'    => __( 'Button Radius', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Enter a value in pixels. e.g:24px', 'wpsp-redux-framework' ),                
            ),
            array(
                'id'       => 'scroll-top-color',
                'type'     => 'color',
                'required' => array( 'is-scroll-top', '=', '1' ),
                'title'    => __( 'Color', 'wpsp-redux-framework' ),
                'validate' => 'color',
            ),
            array(
                'id'       => 'scroll-top-color-hover',
                'type'     => 'color',
                'required' => array( 'is-scroll-top', '=', '1' ),
                'title'    => __( 'Color: Hover', 'wpsp-redux-framework' ),
                'validate' => 'color',
            ),
            array(
                'id'       => 'scroll-top-bg',
                'type'     => 'color',
                'required' => array( 'is-scroll-top', '=', '1' ),
                'title'    => __( 'Background', 'wpsp-redux-framework' ),
                'validate' => 'color',
            ),
            array(
                'id'       => 'scroll-top-bg-hover',
                'type'     => 'color',
                'required' => array( 'is-scroll-top', '=', '1' ),
                'title'    => __( 'Background: Hover', 'wpsp-redux-framework' ),
                'validate' => 'color',
            ),
            array(
                'id'       => 'scroll-top-border',
                'type'     => 'color',
                'required' => array( 'is-scroll-top', '=', '1' ),
                'title'    => __( 'Border', 'wpsp-redux-framework' ),
                'validate' => 'color',
            ),
            array(
                'id'       => 'scroll-top-border-hover',
                'type'     => 'color',
                'required' => array( 'is-scroll-top', '=', '1' ),
                'title'    => __( 'Border: Hover', 'wpsp-redux-framework' ),
                'validate' => 'color',
            ),
        )
    ) );

    // Header
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Header', 'wpsp-redux-framework' ),
        'id'               => 'header-options',
        'desc'             => __( '', 'wpsp-redux-framework' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-tasks'
    ) );
    // Header > General
    Redux::setSection( $opt_name, array(
        'title'      => __( 'General', 'wpsp-redux-framework' ),
        'id'         => 'header-general',
        'subsection' => true,
        //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => 'is-enable-header',
                'type'     => 'switch',
                'title'    => __( 'Enable', 'wpsp-redux-framework' ),
                'default'  => '1'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'is-full-width-header',
                'type'     => 'switch',
                'title'    => __( 'Full width', 'wpsp-redux-framework' ),
                'default'  => '0'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'header-style',
                'type'     => 'select',
                'title'    => __( 'Style', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Style header menu left, bottom and center', 'wpsp-redux-framework' ),
                'options'  => $header_styles_array,
                'default'  => 'one',
            ),
            array(
                'id'       => 'vertical-header-style',
                'type'     => 'select',
                'required' => array( 'header-style', '=', 'six' ),
                'title'    => __( 'Vertical Header Style', 'wpsp-redux-framework' ),
                'options'  => array(
                        ''         => 'Default',
                        'fixed'    => 'Fixed',
                ),
            ),
        )
    ) );
    // Header > logo
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Logo', 'wpsp-redux-framework' ),
        'id'         => 'header-logo',
        'subsection' => true,
        //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => 'theme-logo',
                'type'     => 'media',
                'title'    => __( 'Main logo', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Upload main image logo', 'wpsp-redux-framework' ),
                'default'  => array(
                    'url'=> get_template_directory_uri() . '/images/logo.png'
                ),
            ),
        )
    ) );
    // Header > Sticky
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Sticky Header', 'wpsp-redux-framework' ),
        'id'         => 'header-sticky-header',
        'subsection' => true,
        'fields'     => array(   
            array(
                'id'       => 'fixed-header-style',
                'type'     => 'select',
                'title'    => __( 'Style', 'wpsp-redux-framework' ),
                'options'  => array(
                        'disabled' => 'Disabled',
                        'standard'    => 'Standard',
                        'shrink'    => 'Shrink',
                        'shrink_animated'    => 'Animated Shrink',
                ),
                'default'  => 'disabled'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'fixed-header-shrink-start-height',
                'type'     => 'text',
                'required' => array( 'fixed-header-style', 'equals', array( 'shrink', 'shrink_animated' ) ),
                'title'    => __( 'Logo Start Height', 'wpsp-redux-framework' ),
                'subtitle' => __( 'In order to properly animate the header with CSS3 it is important to apply a fixed height to the header logo by default. e.g:40px', 'wpsp-redux-framework' ),                
            ),
            array(
                'id'       => 'fixed-header-shrink-end-height',
                'type'     => 'text',
                'required' => array( 'fixed-header-style', 'equals', array( 'shrink', 'shrink_animated' ) ),
                'title'    => __( 'Logo Shrunk Height', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Your shrink header height will be set to your Logo Shrunk Height plus 20px for a top and bottom padding of 20px. e.g:60px', 'wpsp-redux-framework' ),                
            ),
            array(
                'id'       => 'is-fixed-header-mobile',
                'type'     => 'switch',
                'required' => array( 'fixed-header-style', 'equals', array( 'standard', 'shrink', 'shrink_animated' ) ),
                'title'    => __( 'Sticky Header On Mobile', 'wpsp-redux-framework' ),
                'default'  => '1'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'fixed-header-opacity',
                'type'     => 'text',
                'required' => array( 'fixed-header-style', 'equals', array( 'standard', 'shrink', 'shrink_animated' ) ),
                'title'    => __( 'Sticky header Opacity', 'wpsp-redux-framework' ),
                'validate' => 'preg_replace',
                'preg'     => array(
                    'pattern'     => '/[^0-9]/s',
                    'replacement' => 'Allow only number'
                ),
            ),
        )
    ) );
    // Header > search icon
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Search icon', 'wpsp-redux-framework' ),
        'id'         => 'header-search-icon',
        'subsection' => true,
        //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => 'menu-search-style',
                'type'     => 'select',
                'title'    => __( 'Search Icon Style', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Vertical header styles only support the disabled and overlay styles.', 'wpsp-redux-framework' ),
                'options'  => array(
                    'disabled'          => 'Disabled',
                    'drop_down'         => 'Dropdown',
                    'overlay'           => 'Overlay',
                    'header_replace'    => 'Header Replace',
                ),
                'default'   => 'drop_down',
            ),
        )
    ) );
    // Header > Mobile menu
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Mobile menu', 'wpsp-redux-framework' ),
        'id'         => 'header-mobile-menu',
        'subsection' => true,
        'fields'     => array(   
            array(
                'id'       => 'mobile-menu-breakpoint',
                'type'     => 'text',
                'title'    => __( 'Mobile Menu Breakpoint', 'wpsp-redux-framework' ),
                'desc'     => __( 'Default: 992px. Follow Bootstrap responsive breakpoint', 'wpsp-redux-framework' ),
                'validate' => 'preg_replace',
                'preg'     => array(
                    'pattern'     => '/[^0-9]/s',
                    'replacement' => 'Allow only number'
                ),
            ),
            array(
                'id'       => 'is-mobile-menu-search',
                'type'     => 'switch',
                'title'    => __( 'Mobile Menu Search', 'wpsp-redux-framework' ),
                'desc'     => __( 'Switch search form on/off in mobile menu', 'wpsp-redux-framework' ),
                'default'  => '1'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'mobile-menu-toggle-style',
                'type'     => 'select',
                'title'    => __( 'Toggle Button Style', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Locate mobile menu where should be.', 'wpsp-redux-framework' ),
                'options'  => array(
                    'icon_buttons'              => 'Right Aligned Icon Button(s)',
                    'icon_buttons_under_logo'   => 'Under The Logo Icon Button(s)',
                    'navbar'                    => 'Navbar',
                    'fixed_top'                 => 'Fixed Site Top',
                ),
                'default'   => 'icon_buttons',
            ),
            array(
                'id'       => 'mobile-menu-toggle-fixed-top-bg',
                'type'     => 'color',
                'required' => array( 'mobile-menu-toggle-style', 'equals', array( 'fixed_top', 'navbar' ) ),
                'title'    => __( 'Toggle Background', 'wpsp-redux-framework' ),
                'subtitle' => __( 'This option work only Toggle Button Style = NavBar or Fixed Site Top', 'wpsp-redux-framework' ),
                'default'  => '#262626',
                'validate' => 'color',
            ),
            array(
                'id'       => 'mobile-menu-toggle-text',
                'type'     => 'text',
                'required' => array( 'mobile-menu-toggle-style', 'equals', array( 'fixed_top', 'navbar' ) ),
                'title'    => __( 'Toggle Text', 'wpsp-redux-framework' ),
                'subtitle' => __( 'This option work only Toggle Button Style = NavBar or Fixed Site Top', 'wpsp-redux-framework' ),
                'default'  => __( 'Menu', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'mobile-menu-style',
                'type'     => 'select',
                'title'    => __( 'Mobile Menu Style', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Locate mobile menu where to display, sidebar(left or right), toggle, full screen or disable', 'wpsp-redux-framework' ),
                'options'  => array(
                    'sidr'       => 'Sidebar',
                    'toggle'        => 'Toggle',
                    'full_screen'   => 'Full Screen Overlay',
                    'disabled'      => 'Disabled',
                ),
                'default'   => 'sidr',
            ),
            array(
                'id'       => 'mobile-menu-sidr-direction',
                'type'     => 'select',
                'required' => array( 'mobile-menu-style', '=', 'sidr' ),
                'title'    => __( 'Direction', 'wpsp-redux-framework' ),
                'options'  => array(
                    'left'  => 'Left',
                    'right' => 'Right',
                ),
                'default'   => 'left',
            ),
            array(
                'id'       => 'mobile-menu-sidr-displace',
                'type'     => 'checkbox',
                'required' => array( 'mobile-menu-style', '=', 'sidr' ),
                'title'    => __( 'Displace', 'wpsp-redux-framework' ),
                'desc'     => __( 'Do not push sidebar', 'wpsp-redux-framework' ),
                'default'  => '1'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'full-screen-mobile-menu-style',
                'type'     => 'select',
                'required' => array( 'mobile-menu-style', '=', 'full_screen' ),
                'title'    => __( 'Style full screen', 'wpsp-redux-framework' ),
                'options'  => array(
                    'white'  => 'White',
                    'black' => 'Black',
                ),
                'default'   => 'white',
            ),
        )
    ) );

    // Footer
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Footer', 'wpsp-redux-framework' ),
        'id'               => 'footer-options',
        'desc'             => __( '', 'wpsp-redux-framework' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-credit-card'
    ) );
    // Footer > widget 
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Footer Widget', 'wpsp-redux-framework' ),
        'id'         => 'footer-widget',
        'subsection' => true,
        //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => 'is-footer-widgets',
                'type'     => 'switch',
                'title'    => __( 'Enable footer widget', 'wpsp-redux-framework' ),
                'desc'     => __( 'Switch footer widget on/off', 'wpsp-redux-framework' ),
                'default'  => '0'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'footer-widgets-columns',
                'type'     => 'select',
                'required' => array( 'is-footer-widgets', '=', '1' ),
                'title'    => __( 'Columns', 'wpsp-redux-framework' ),
                'options'  => array(
                        '1' => '1', 
                        '2' => '2', 
                        '3' => '3', 
                        '4' => '4', 
                    ),
                'default'  => '4',
            ),
            array(
                'id'       => 'is-fixed-footer',
                'type'     => 'switch',
                'title'    => __( 'Fixed Footer', 'wpsp-redux-framework' ),
                'desc'     => __( 'This setting will not "fix" your footer per-se but will add a min-height to your #main container to keep your footer always at the bottom of the page.', 'wpsp-redux-framework' ),
                'default'  => '0'// 1 = on | 0 = off
            ),
        )
    ) );
    // Footer > bottom 
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Footer Bottom', 'wpsp-redux-framework' ),
        'id'         => 'footer-bottom',
        'subsection' => true,
        //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => 'is-footer-bottom',
                'type'     => 'switch',
                'title'    => __( 'Enable footer bottom', 'wpsp-redux-framework' ),
                'desc'     => __( 'Switch footer bottom on/off', 'wpsp-redux-framework' ),
                'default'  => '1'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'footer-copyright-text',
                'type'     => 'textarea',
                'required' => array( 'is-footer-bottom', '=', '1' ),
                'title'    => __( 'Copyright', 'wpsp-redux-framework' ),
                'default'  => __( 'Copyright <a href="#">Your Business LLC.</a> - All Rights Reserved', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'bottom-footer-text-align',
                'type'     => 'select',
                'required' => array( 'is-footer-bottom', '=', '1' ),
                'title'    => __( 'Text align', 'wpsp-redux-framework' ),
                'options'  => array(
                    'default' => esc_html__( 'Default', 'wpsp-redux-framework' ),
                    'left' => esc_html__( 'Left','wpsp-redux-framework' ),
                    'right' => esc_html__( 'Right','wpsp-redux-framework' ),
                    'center' => esc_html__( 'Center','wpsp-redux-framework' ),
                ),
                'default'  => 'default',
            ),
            array(
                'id'       => 'bottom-footer-padding',
                'type'     => 'text',
                'required' => array( 'is-footer-bottom', '=', '1' ),
                'title'    => __( 'Padding', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Format: top right bottom left.', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'bottom-footer-background',
                'type'     => 'color',
                'required' => array( 'is-footer-bottom', '=', '1' ),
                'title'    => __( 'Background', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Footer bottom background color', 'wpsp-redux-framework' ),
                'default'  => '#ffffff',
                'validate' => 'color',
            ),
            array(
                'id'       => 'bottom-footer-color',
                'type'     => 'color',
                'required' => array( 'is-footer-bottom', '=', '1' ),
                'title'    => __( 'Color', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Footer bottom text color', 'wpsp-redux-framework' ),
                'default'  => '#ffffff',
                'validate' => 'color',
            ),
            array(
                'id'       => 'bottom-footer-link-color',
                'type'     => 'color',
                'required' => array( 'is-footer-bottom', '=', '1' ),
                'title'    => __( 'Link', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Footer bottom link color', 'wpsp-redux-framework' ),
                'default'  => '#ffffff',
                'validate' => 'color',
            ),
            array(
                'id'       => 'bottom-footer-link-color-hover',
                'type'     => 'color',
                'required' => array( 'is-footer-bottom', '=', '1' ),
                'title'    => __( 'Link', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Footer bottom link color hover', 'wpsp-redux-framework' ),
                'default'  => '#ffffff',
                'validate' => 'color',
            ),
        )
    ) );

    // Blog section
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Blog', 'wpsp-redux-framework' ),
        'id'               => 'blog-options',
        'desc'             => __( '', 'wpsp-redux-framework' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-file-edit'
    ) );
    // blog > general
    Redux::setSection( $opt_name, array(
        'title'      => __( 'General', 'wpsp-redux-framework' ),
        'id'         => 'blog-general',
        'subsection' => true,
        //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => 'blog-page',
                'type'     => 'select',
                'data'     => 'pages',
                'title'    => __( 'Main Page', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'blog-cats-exclude',
                'type'     => 'text',
                'title'    => __( 'Exclude Categories From Blog', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Enter the ID of categories to exclude from the blog template or homepage blog seperated by a comma (no spaces).', 'wpsp-redux-framework' ),
            ),
        )
    ) );
    // blog > single 
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Single', 'wpsp-redux-framework' ),
        'id'         => 'blog-single',
        'subsection' => true,
        //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => 'single-layout',
                'type'     => 'image_select',
                'title'    => __( 'Layout', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Layout for single post', 'wpsp-redux-framework' ),
                'desc'     => __( '[ is_single ] Single post layout - If a post has a set layout, it will override this.', 'wpsp-redux-framework' ),
                'options'  => array(
                    'inherit' => array(
                        'alt' => 'Inherit',
                        'img' => get_template_directory_uri() . '/images/admin/layout-off.png'
                    ),
                    'full-width' => array(
                        'alt' => 'Full width',
                        'img' => get_template_directory_uri() . '/images/admin/full-width.png'
                    ),
                    'full-screen' => array(
                        'alt' => 'Full screen',
                        'img' => get_template_directory_uri() . '/images/admin/full-screen.png'
                    ),
                    'left-sidebar' => array(
                        'alt' => '2 Column Left',
                        'img' => get_template_directory_uri() . '/images/admin/2cl.png'
                    ),
                    'right-sidebar' => array(
                        'alt' => '2 Column Right',
                        'img' => get_template_directory_uri() . '/images/admin/2cr.png'
                    )
                ),
                'default'  => 'inherit',
            ),
            array(
                'id'       => 'sidebar-single',
                'type'     => 'select',
                'data'     => 'sidebar',
                'title'    => __( 'Sidebar single post', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Sidebar for single post', 'wpsp-redux-framework' ),
                'desc'     => __( '[ is_single ] Primary - If a single post has a unique sidebar, it will override this.', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'blog-single-header',
                'type'     => 'select',
                'title'    => __( 'Header Displays', 'wpsp-redux-framework' ),
                'options'  => array(
                    'custom_text' => 'Custom Text',
                    'post_title' => 'Post title',
                    'first_category' => 'First Category',
                ),
                'default'  => 'custom_text'
            ),
            array(
                'id'       => 'blog-single-header-custom-text',
                'type'     => 'text',
                'required' => array( 'blog-single-header', '=', 'custom_text' ),
                'title'    => __( 'Header Custom Text', 'wpsp-redux-framework' ),
                'default'  => __( 'Blog', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'is-featured-image-lightbox',
                'type'     => 'checkbox',
                'title'    => __( 'Featured image lightbox', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Enable/disable featured image lightbox', 'wpsp-redux-framework' ),
                'default'  => '1'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'is-blog-thumbnail-caption',
                'type'     => 'checkbox',
                'title'    => __( 'Featured image caption', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Enable/disable featured image caption', 'wpsp-redux-framework' ),
                'default'  => '1'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'blog-post-meta-sections',
                'type'     => 'checkbox',
                'title'    => __( 'Meta', 'wpsp-redux-framework' ),
                'subtitle' => __( 'checked meta filed to be display', 'wpsp-redux-framework' ),
                'options'  => array(
                    'date'       => esc_html__( 'Date', 'wpsp-redux-framework' ),
                    'author'     => esc_html__( 'Author', 'wpsp-redux-framework' ),
                    'categories' => esc_html__( 'Categories', 'wpsp-redux-framework' ),
                    'comments'   => esc_html__( 'Comments', 'wpsp-redux-framework' ),
                    ),
                'default'  => array(
                    'date'          => true,
                    'author'        => true,
                    'categories'    => true,
                    'comments'      => true,
                )
            ),
            array(
                'id'       => 'blog-single-block',
                'type'     => 'sortable',
                'mode'     => 'checkbox', // checkbox or text
                'title'    => __( 'Single layout element', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Click and drag and drop elements to re-order them.', 'wpsp-redux-framework' ),
                'label'    => true,
                'options'  => array(
                    'title' => esc_html__( 'Title', 'wpsp-redux-framework' ),
                    'meta' => esc_html__( 'Meta', 'wpsp-redux-framework' ),
                    'featured_media' => esc_html__( 'Featured Media','wpsp-redux-framework' ),
                    'the_content' => esc_html__( 'Content','wpsp-redux-framework' ),
                    'post_tags' => esc_html__( 'Post Tags','wpsp-redux-framework' ),
                    'social_share' => esc_html__( 'Social Share','wpsp-redux-framework' ),
                    'author_bio' => esc_html__( 'Author Bio','wpsp-redux-framework' ),
                    'related_posts' => esc_html__( 'Related Posts','wpsp-redux-framework' ),
                    'comments' => esc_html__( 'Comments','wpsp-redux-framework' ),
                ),
                'default'  => array(
                    'title'           => true,
                    'meta'            => true,
                    'featured_media'  => true,
                    'the_content'     => true,
                    'post_tags'       => true,
                    'social_share'    => true,
                    'author_bio'      => false,
                    'related_posts'   => true,
                    'comments'        => false,
                )
            ),
        )
    ) );
    // Blog > Archive
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Archive', 'wpsp-redux-framework' ),
        'id'         => 'blog-archive',
        'subsection' => true,
        //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => 'archive-layout',
                'type'     => 'image_select',
                'title'    => __( 'Archive', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Layout for archive page', 'wpsp-redux-framework' ),
                'desc'     => __( '[ is_archive ] Category, date, tag and author archive layout', 'wpsp-redux-framework' ),
                'options'  => array(
                    'inherit' => array(
                        'alt' => 'Inherit',
                        'img' => get_template_directory_uri() . '/images/admin/layout-off.png'
                    ),
                    'full-width' => array(
                        'alt' => 'Full width',
                        'img' => get_template_directory_uri() . '/images/admin/full-width.png'
                    ),
                    'full-screen' => array(
                        'alt' => 'Full screen',
                        'img' => get_template_directory_uri() . '/images/admin/full-screen.png'
                    ),
                    'left-sidebar' => array(
                        'alt' => '2 Column Left',
                        'img' => get_template_directory_uri() . '/images/admin/2cl.png'
                    ),
                    'right-sidebar' => array(
                        'alt' => '2 Column Right',
                        'img' => get_template_directory_uri() . '/images/admin/2cr.png'
                    )
                ),
                'default'  => 'inherit',
            ),
            array(
                'id'       => 'category-layout',
                'type'     => 'image_select',
                'title'    => __( 'Archive — Category', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Layout for each categories', 'wpsp-redux-framework' ),
                'desc'     => __( '[ is_category ] Category archive layout', 'wpsp-redux-framework' ),
                'options'  => array(
                    'inherit' => array(
                        'alt' => 'Inherit',
                        'img' => get_template_directory_uri() . '/images/admin/layout-off.png'
                    ),
                    'full-width' => array(
                        'alt' => 'Full width',
                        'img' => get_template_directory_uri() . '/images/admin/full-width.png'
                    ),
                    'full-screen' => array(
                        'alt' => 'Full screen',
                        'img' => get_template_directory_uri() . '/images/admin/full-screen.png'
                    ),
                    'left-sidebar' => array(
                        'alt' => '2 Column Left',
                        'img' => get_template_directory_uri() . '/images/admin/2cl.png'
                    ),
                    'right-sidebar' => array(
                        'alt' => '2 Column Right',
                        'img' => get_template_directory_uri() . '/images/admin/2cr.png'
                    )
                ),
                'default'  => 'inherit',
            ),
            array(
                'id'       => 'sidebar-archive',
                'type'     => 'select',
                'data'     => 'sidebar',
                'title'    => __( 'Sidebar', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Sidebar for archive page', 'wpsp-redux-framework' ),
                'desc'     => __( '[ is_archive ] Primary', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'sidebar-category',
                'type'     => 'select',
                'data'     => 'sidebar',
                'title'    => __( 'Sidebar — Category', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Sidebar for each categories', 'wpsp-redux-framework' ),
                'desc'     => __( '[ is_category ] Primary', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'blog-entry-style',
                'type'     => 'select',
                'title'    => __( 'Blog entry style', 'wpsp-redux-framework' ),
                'options'  => array(
                    '' => esc_html__( 'Default', 'wpsp-redux-framework' ),
                    'large-image-entry-style' => esc_html__( 'Large Image','wpsp-redux-framework' ),
                    'thumbnail-entry-style' => esc_html__( 'Left Thumbnail','wpsp-redux-framework' ),
                    'grid-entry-style' => esc_html__( 'Grid','wpsp-redux-framework' ),
                ),
                'default'  => 'large-image-entry-style'
            ),
            array(
                'id'       => 'blog-grid-columns',
                'type'     => 'select',
                'required' => array( 'blog-entry-style', '=', 'grid-entry-style' ),
                'title'    => __( 'Grid columns', 'wpsp-redux-framework' ),
                'options'  => array(
                    '' => esc_html__( 'Default', 'wpsp-redux-framework' ),
                    '6' => esc_html__( '6','wpsp-redux-framework' ),
                    '5' => esc_html__( '5','wpsp-redux-framework' ),
                    '4' => esc_html__( '4','wpsp-redux-framework' ),
                    '3' => esc_html__( '3','wpsp-redux-framework' ),
                    '2' => esc_html__( '2','wpsp-redux-framework' ),
                ),
            ),
            array(
                'id'       => 'blog-grid-style',
                'type'     => 'select',
                'required' => array( 'blog-entry-style', '=', 'grid-entry-style' ),
                'title'    => __( 'Grid style', 'wpsp-redux-framework' ),
                'options'  => array(
                    '' => esc_html__( 'Default', 'wpsp-redux-framework' ),
                    'fit-rows' => esc_html__( 'Fit Rows','wpsp-redux-framework' ),
                    'masonry' => esc_html__( 'Masonry','wpsp-redux-framework' ),
                ),
            ),
            array(
                'id'       => 'blog-archive-grid-equal-heights',
                'type'     => 'checkbox',
                'title'    => __( 'Equal Heights', 'wpsp-redux-framework' ),
                'default'  => 0,
            ),
            array(
                'id'       => 'blog-pagination-style',
                'type'     => 'select',
                'title'    => __( 'Pagination Style', 'wpsp-redux-framework' ),
                'options'  => array(
                    '' => esc_html__( 'Default', 'wpsp-redux-framework' ),
                    'standard' => esc_html__( 'Standard','wpsp-redux-framework' ),
                    'infinite_scroll' => esc_html__( 'Infinite Scroll','wpsp-redux-framework' ),
                    'next_prev' => esc_html__( 'Next/Prev','wpsp-redux-framework' ),
                ),
            ),
            array(
                'id'       => 'blog-entry-overlay',
                'type'     => 'select',
                'title'    => __( 'Overlay Style', 'wpsp-redux-framework' ),
                'subtitle' => __( 'set overlay style for each entry post thumbnails', 'wpsp-redux-framework' ),
                'options'  => $wpsp_overlay_styles_array,
            ),
            array(
                'id'       => 'is-auto-excerpt',
                'type'     => 'switch',
                'title'    => __( 'Auto Excerpts', 'wpsp-redux-framework' ),
                'default'  => true,
            ),
            array(
                'id'       => 'blog-excerpt-length',
                'type'     => 'text',
                'required' => array( 'is-auto-excerpt', '=', '1' ),
                'title'    => __( 'Related Posts Excerpt Length', 'wpsp-redux-framework' ),
                'validate' => 'preg_replace',
                'preg'     => array(
                    'pattern'     => '/[^0-9]/s',
                    'replacement' => 'Allow only number'
                ),
                'default'  => '40'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'blog-entry-readmore-text',
                'type'     => 'text',
                'required' => array( 'is-auto-excerpt', '=', '1' ),
                'title'    => __( 'Read More Button Text', 'wpsp-redux-framework' ),
                'validate' => 'preg_replace',
                'preg'     => array(
                    'pattern'     => '/[^a-zA-Z_ -]/s',
                    'replacement' => 'Allow only text'
                ),
                'default'  => 'Read More'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'blog-entry-meta-sections',
                'type'     => 'checkbox',
                'title'    => __( 'Entry Meta', 'wpsp-redux-framework' ),
                'subtitle' => __( 'checked meta filed to be display', 'wpsp-redux-framework' ),
                'options'  => array(
                    'date'       => esc_html__( 'Date', 'wpsp-redux-framework' ),
                    'author'     => esc_html__( 'Author', 'wpsp-redux-framework' ),
                    'categories' => esc_html__( 'Categories', 'wpsp-redux-framework' ),
                    'comments'   => esc_html__( 'Comments', 'wpsp-redux-framework' ),
                    ),
                'default'  => array(
                    'date'          => true,
                    'author'        => true,
                    'categories'    => true,
                    'comments'      => true,
                )
            ),
            array(
                'id'       => 'blog-entry-video-output',
                'type'     => 'checkbox',
                'title'    => __( 'Display Featured Videos?', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Show/hide featured video', 'wpsp-redux-framework' ),
                'default'  => '1'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'blog-entry-author-avatar',
                'type'     => 'checkbox',
                'title'    => __( 'Author Avatar', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Show/hide Author Avatar', 'wpsp-redux-framework' ),
                'default'  => '1'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'blog-entry-block',
                'type'     => 'sortable',
                'mode'     => 'checkbox', // checkbox or text
                'title'    => __( 'Entry Layout Elements', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Click and drag and drop elements to re-order them.', 'wpsp-redux-framework' ),
                'label'    => true,
                'options'  => array(
                    'featured_media'  => esc_html__( 'Media', 'wpsp-redux-framework' ),
                    'title'           => esc_html__( 'Title', 'wpsp-redux-framework' ),
                    'meta'            => esc_html__( 'Meta', 'wpsp-redux-framework' ),
                    'excerpt_content' => esc_html__( 'Excerpt', 'wpsp-redux-framework' ),
                    'readmore'        => esc_html__( 'Read More', 'wpsp-redux-framework' ),
                    'social_share'    => esc_html__( 'Social Share', 'wpsp-redux-framework' ),
                ),
                'default'  => array(
                    'featured_media'  => true,
                    'title'           => true,
                    'meta'            => true,
                    'excerpt_content' => true,
                    'readmore'        => true,
                    'social_share'    => false,
                )
            ),
        )
    ) );

    // Image
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Image sizes', 'wpsp-redux-framework' ),
        'id'               => 'image-option',
        'desc'             => __( 'These are general setting for images', 'wpsp-redux-framework' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-resize-full'
    ) );
    // Image > General
    Redux::setSection( $opt_name, array(
        'title'      => __( 'General', 'wpsp-redux-framework' ),
        'id'         => 'image-general',
        'subsection' => true,
        'desc'       => __( 'Manage image sizes and cropping', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => 'is-image-resizing',
                'type'     => 'checkbox',
                'title'    => __( 'Image resizing', 'wpsp-redux-framework' ),
                'desc'     => __( 'If enabled whenever you upload a new image it will NOT be cropped into all the different sizes defined below, but rather cropped when loaded on the front-end (cropped once then saved to your uploads directory), thus saving precious server space.', 'wpsp-redux-framework' ),
                'default'  => '1',
            ),
        )
    ) ); 
    // Image > Blog
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Blog', 'wpsp-redux-framework' ),
        'id'         => 'image-blog',
        'subsection' => true,
        'desc'       => __( 'Manage image sizes and cropping for blog entry, single post and post related', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => 'blog-entry-image',
                'type'     => 'section',
                'title'    => __( 'Blog entry', 'wpsp-redux-framework' ), 
                'indent'   => true,               
            ),
            array(
                'id'       => 'blog-entry-image-width',
                'type'     => 'text',
                'title'    => __( 'Blog entry width', 'wpsp-redux-framework' ),
                'desc'     => __( 'Number only. Default 9999', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'blog-entry-image-height',
                'type'     => 'text',
                'title'    => __( 'Blog entry height', 'wpsp-redux-framework' ),
                'desc'     => __( 'Number only. Default 9999', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'blog-entry-crop-location',
                'type'     => 'select',
                'title'    => __( 'Crop location', 'wpsp-redux-framework' ),
                'options'  => array(
                    'default' => esc_html__( 'Default', 'wpsp-redux-framework' ),
                    'left-top' => esc_html__( 'Top Left','wpsp-redux-framework' ),
                    'right-top' => esc_html__( 'Top Right','wpsp-redux-framework' ),
                    'center-top' => esc_html__( 'Top Center','wpsp-redux-framework' ),
                    'left-center' => esc_html__( 'Center Left','wpsp-redux-framework' ),
                    'right-center' => esc_html__( 'Center Right','wpsp-redux-framework' ),
                    'center-center' => esc_html__( 'Center Center','wpsp-redux-framework' ),
                    'left-bottom' => esc_html__( 'Bottom Left','wpsp-redux-framework' ),
                    'right-bottom' => esc_html__( 'Bottom Right','wpsp-redux-framework' ),
                    'center-bottom' => esc_html__( 'Bottom Center','wpsp-redux-framework' ),
                ),               
            ),
            array(
                'id'       => 'blog-post-image',
                'type'     => 'section',
                'title'    => __( 'Blog post', 'wpsp-redux-framework' ), 
                'indent'   => true,               
            ),
            array(
                'id'       => 'blog-post-image-width',
                'type'     => 'text',
                'title'    => __( 'Blog post width', 'wpsp-redux-framework' ),
                'desc'     => __( 'Number only. Default 9999', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'blog-post-image-height',
                'type'     => 'text',
                'title'    => __( 'Blog post height', 'wpsp-redux-framework' ),
                'desc'     => __( 'Number only. Default 9999', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'blog-post-crop-location',
                'type'     => 'select',
                'title'    => __( 'Crop location', 'wpsp-redux-framework' ),
                'options'  => array(
                    'default' => esc_html__( 'Default', 'wpsp-redux-framework' ),
                    'left-top' => esc_html__( 'Top Left','wpsp-redux-framework' ),
                    'right-top' => esc_html__( 'Top Right','wpsp-redux-framework' ),
                    'center-top' => esc_html__( 'Top Center','wpsp-redux-framework' ),
                    'left-center' => esc_html__( 'Center Left','wpsp-redux-framework' ),
                    'right-center' => esc_html__( 'Center Right','wpsp-redux-framework' ),
                    'center-center' => esc_html__( 'Center Center','wpsp-redux-framework' ),
                    'left-bottom' => esc_html__( 'Bottom Left','wpsp-redux-framework' ),
                    'right-bottom' => esc_html__( 'Bottom Right','wpsp-redux-framework' ),
                    'center-bottom' => esc_html__( 'Bottom Center','wpsp-redux-framework' ),
                ),               
            ),
            array(
                'id'       => 'blog-related-image',
                'type'     => 'section',
                'title'    => __( 'Blog related', 'wpsp-redux-framework' ), 
                'indent'   => true,               
            ),
            array(
                'id'       => 'blog-related-image-width',
                'type'     => 'text',
                'title'    => __( 'Blog related width', 'wpsp-redux-framework' ),
                'desc'     => __( 'Number only. Default 9999', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'blog-related-image-height',
                'type'     => 'text',
                'title'    => __( 'Blog related height', 'wpsp-redux-framework' ),
                'desc'     => __( 'Number only. Default 9999', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'blog-related-crop-location',
                'type'     => 'select',
                'title'    => __( 'Crop location', 'wpsp-redux-framework' ),
                'options'  => array(
                    'default' => esc_html__( 'Default', 'wpsp-redux-framework' ),
                    'left-top' => esc_html__( 'Top Left','wpsp-redux-framework' ),
                    'right-top' => esc_html__( 'Top Right','wpsp-redux-framework' ),
                    'center-top' => esc_html__( 'Top Center','wpsp-redux-framework' ),
                    'left-center' => esc_html__( 'Center Left','wpsp-redux-framework' ),
                    'right-center' => esc_html__( 'Center Right','wpsp-redux-framework' ),
                    'center-center' => esc_html__( 'Center Center','wpsp-redux-framework' ),
                    'left-bottom' => esc_html__( 'Bottom Left','wpsp-redux-framework' ),
                    'right-bottom' => esc_html__( 'Bottom Right','wpsp-redux-framework' ),
                    'center-bottom' => esc_html__( 'Bottom Center','wpsp-redux-framework' ),
                ),               
            ),
        )
    ) );  
    
    // Layout
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Layout', 'wpsp-redux-framework' ),
        'id'               => 'layout-option',
        'desc'             => __( 'These are general setting for layout', 'wpsp-redux-framework' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-screen'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'General', 'wpsp-redux-framework' ),
        'id'         => 'layout-general',
        'subsection' => true,
        'desc'       => __( 'Manage page layout with fullwide and responsive', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => 'layout-global',
                'type'     => 'image_select',
                'title'    => __( 'Global layout', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Layout for all pages, posts and custom post', 'wpsp-redux-framework' ),
                'desc'     => __( 'Other layouts will override this option if they are set', 'wpsp-redux-framework' ),
                //Must provide key => value(array:title|img) pairs for radio options
                'options'  => array(
                    'full-width' => array(
                        'alt' => 'Full width',
                        'img' => get_template_directory_uri() . '/images/admin/full-width.png'
                    ),
                    'full-screen' => array(
                        'alt' => 'Full screen',
                        'img' => get_template_directory_uri() . '/images/admin/full-screen.png'
                    ),
                    'left-sidebar' => array(
                        'alt' => '2 Column Left',
                        'img' => get_template_directory_uri() . '/images/admin/2cl.png'
                    ),
                    'right-sidebar' => array(
                        'alt' => '2 Column Right',
                        'img' => get_template_directory_uri() . '/images/admin/2cr.png'
                    )
                ),
                'default'  => 'right-sidebar',
            ),
        )
    ) );

    // Branding
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Branding', 'wpsp-redux-framework' ),
        'id'               => 'branding-options',
        'desc'             => __( '', 'wpsp-redux-framework' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-flag'
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Custom login', 'wpsp-redux-framework' ),
        'id'         => 'custom-login',
        'subsection' => true,
        //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
        'fields'     => array(
            array(
                'id'       => 'custom-login-logo',
                'type'     => 'media',
                'title'    => __( 'Custom login logo', 'wpsp-redux-framework' ),
                'default'  => array(
                    'url'=> get_template_directory_uri() . '/images/icons/posh-logo.png'
                ),
            ),
            array(
                'id'       => 'custom-admin-favicon',
                'type'     => 'media',
                'title'    => __( 'Custom favicon', 'wpsp-redux-framework' ),
                'default'  => array(
                    'url'=> get_template_directory_uri() . '/images/icons/favicon-16x16.png'
                ),
            ),
            array(
                'id'       => 'login-logo-height',
                'type'     => 'text',
                'title'    => __( 'Logo height', 'wpsp-redux-framework' ),
                'desc'     => __( 'Default: 84px', 'wpsp-redux-framework' ),
            ),
            array(
                'id'       => 'login-bg-color',
                'type'     => 'color',
                'title'    => __( 'Background color', 'wpsp-redux-framework' ),
                'default'  => '#ffffff',
                'validate' => 'color',
            ),
        )
    ) );

    /*
     * <--- END SECTIONS
     */
