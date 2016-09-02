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

    $header_styles = header_styles();

    // Header styles
    $header_styles = apply_filters( 'wpsp_header_styles', array(
        'one' => esc_html__( 'One - Left Logo & Right Navbar','wpsp-redux-framework' ),
        'two' => esc_html__( 'Two - Bottom Navbar','wpsp-redux-framework' ),
        'three' => esc_html__( 'Three - Bottom Navbar Centered','wpsp-redux-framework' ),
        'four' => esc_html__( 'Four - Top Navbar Centered','wpsp-redux-framework' ),
        'five' => esc_html__( 'Five - Centered Inline Logo','wpsp-redux-framework' ),
        'six' => esc_html__( 'Six - Vertical','wpsp-redux-framework' ),
    ) );

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
                'options'  => $header_styles,
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
                'subtitle' => __( 'In order to properly animate the header with CSS3 it is important to apply a fixed height to the header logo by default.', 'wpsp-redux-framework' ),
                'validate' => 'preg_replace',
                'preg'     => array(
                    'pattern'     => '/[^0-9]/s',
                    'replacement' => 'Allow only number'
                ),
            ),
            array(
                'id'       => 'fixed-header-shrink-end-height',
                'type'     => 'text',
                'required' => array( 'fixed-header-style', 'equals', array( 'shrink', 'shrink_animated' ) ),
                'title'    => __( 'Logo Shrunk Height', 'wpsp-redux-framework' ),
                'subtitle' => __( 'Your shrink header height will be set to your Logo Shrunk Height plus 20px for a top and bottom padding of 20px.', 'wpsp-redux-framework' ),
                'validate' => 'preg_replace',
                'preg'     => array(
                    'pattern'     => '/[^0-9]/s',
                    'replacement' => 'Allow only number'
                ),
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
                'title'    => __( 'Enable footer', 'wpsp-redux-framework' ),
                'desc'     => __( 'Switch footer on/off', 'wpsp-redux-framework' ),
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
                'id'       => 'footer-widgets-gap',
                'type'     => 'select',
                'required' => array( 'is-footer-widgets', '=', '1' ),
                'title'    => __( 'Footer Widgets Gap', 'wpsp-redux-framework' ),
                'options'  => array(
                    'default' => esc_html__( 'Default', 'wpsp-redux-framework' ),
                    '0' => esc_html__( '0px','wpsp-redux-framework' ),
                    '5' => esc_html__( '5px','wpsp-redux-framework' ),
                    '10' => esc_html__( '10px','wpsp-redux-framework' ),
                    '15' => esc_html__( '15px','wpsp-redux-framework' ),
                    '20' => esc_html__( '20px','wpsp-redux-framework' ),
                    '25' => esc_html__( '25px','wpsp-redux-framework' ),
                    '30' => esc_html__( '30px','wpsp-redux-framework' ),
                    '35' => esc_html__( '35px','wpsp-redux-framework' ),
                    '40' => esc_html__( '40px','wpsp-redux-framework' ),
                    '50' => esc_html__( '50px','wpsp-redux-framework' ),
                    '60' => esc_html__( '60px','wpsp-redux-framework' ),
                ),
                'default'  => 'default',
            ),
            array(
                'id'       => 'is-footer-reveal',
                'type'     => 'switch',
                'title'    => __( 'Footer Reveal', 'wpsp-redux-framework' ),
                'desc'     => __( 'Enable the footer reveal style. The footer will be placed in a fixed postion and display on scroll. This setting is for the "Full-Width" layout only and desktops only.', 'wpsp-redux-framework' ),
                'default'  => '0'// 1 = on | 0 = off
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
