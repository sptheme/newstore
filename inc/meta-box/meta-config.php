<?php
 /**
 * Registering meta boxes
 *
 * For more information, please visit:
 * @link http://metabox.io/docs/registering-meta-boxes/
 *
 * @package newstore
 */

 add_filter( 'rwmb_meta_boxes', 'wpsp_register_meta_boxes' );

/**
 * Register meta boxes
 *
 *
 * @param array $meta_boxes List of meta boxes
 *
 * @return array
 */
	function wpsp_register_meta_boxes( $meta_boxes ) {
	/**
	 * prefix of meta keys (optional)
	 * Use underscore (_) at the beginning to make keys hidden
	 * Alt.: You also can make prefix empty to disable it
	 */
	// Better has an underscore as last sign
	$prefix = 'wpsp_';

	/* get the registered sidebars */
    global $wp_registered_sidebars;

    $sidebars = array();
    foreach( $wp_registered_sidebars as $id=>$sidebar ) {
      $sidebars[ $id ] = $sidebar[ 'name' ];
    }
    $sidebars_tmp = array_unshift( $sidebars, "-- Choose Sidebar --" );    

    // Page layout options
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'page-options',
		'title'      => __( 'Page options', 'wpsp-meta-box' ),
		'post_types' => array( 'post', 'page' ),
		'context'    => 'normal', // Where the meta box appear: normal (default), advanced, side. Optional.
		'priority'   => 'high', // Order of meta box: high (default), low. Optional.
		'autosave'   => true, // Auto save: true, false (default). Optional.

		// List of meta fields
		'fields'     => array(
			
			array(
				'type' => 'heading',
				'name' => esc_html__( 'Header', 'wpsp-meta-box' ),
			),
			array(
				'name'  => __( 'Header', 'wpsp-meta-box' ), 
				'id'    => $prefix . "is_display_header",
				'desc'	=> __( 'Enable or disable header logo and main navigation on this page or post.', 'wpsp-meta-box' ), 
				'type'  => 'checkbox',
				'std'  => 1,
			),
			array(
				'type' => 'heading',
				'name' => esc_html__( 'Title', 'wpsp-meta-box' ),
			),
			array(
				'name'  => __( 'Title', 'wpsp-meta-box' ), 
				'id'    => $prefix . "is_page_title",
				'desc'	=> __( 'Enable or disable this element on this page or post.', 'wpsp-meta-box' ), 
				'type'  => 'checkbox',
				'std'  => 1,
			),
			array(
				'name'  => __( 'Custom Title', 'wpsp-meta-box' ), 
				'id'    => $prefix . "post_title",
				'desc'	=> __( 'Alter the main title display.', 'wpsp-meta-box' ), 
				'type'  => 'text',
			),
			array(
				'name'  => __( 'Title Margin', 'wpsp-meta-box' ), 
				'id'    => $prefix . "disable_header_margin",
				'desc'	=> __( 'Enable or disable margin.', 'wpsp-meta-box' ), 
				'type'  => 'checkbox',
				'std'  => 1,
			),
			array(
				'name'  => __( 'Subheading', 'wpsp-meta-box' ), 
				'id'    => $prefix . "post_subheading",
				'desc'	=> __( 'Enter your page subheading. Shortcodes & HTML is allowed.', 'wpsp-meta-box' ), 
				'type'  => 'text',
			),
			array(
				'name'  => __( 'Title style', 'wpsp-meta-box' ), 
				'id'    => $prefix . "post_title_style",
				'desc'	=> __( 'Select a custom title style for this page or post.', 'wpsp-meta-box' ), 
				'type'  => 'select',
				'options'     => array(
					'' => __( 'Default', 'wpsp-meta-box' ),
					'centered' => __( 'Centered', 'wpsp-meta-box' ),
					'centered-minimal' => __( 'Centered Minimal', 'wpsp-meta-box' ),
					'background-image' => __( 'Background Image', 'wpsp-meta-box' ),
					'solid-color' => __( 'Solid Color & White Text', 'wpsp-meta-box' ),
					),
			),
			array(
				'name'  => __( 'Title: Background Color', 'wpsp-meta-box' ), 
				'id'    => $prefix . "post_title_background_color",
				'desc'	=> __( 'Select color', 'wpsp-meta-box' ), 
				'type'  => 'color',
				'class' => 'post_title_background_color'
			),
			array(
				'name'  => __( 'Title: Background Image', 'wpsp-meta-box' ), 
				'id'    => $prefix . "post_title_background_img",
				'desc'	=> __( 'Select a custom header image for your main title.', 'wpsp-meta-box' ), 
				'type'  => 'image_advanced',
				'max_file_uploads' => 1,
				'class' => 'post_title_background_img'
			),
			array(
				'name'  => __( 'Title: Background Height', 'wpsp-meta-box' ), 
				'id'    => $prefix . "post_title_height",
				'desc'	=> __( 'Select your custom height for your title background. Default is 400px.', 'wpsp-meta-box' ), 
				'type'  => 'text',
				'class' => 'post_title_height'
			),
			array(
				'name'  => __( 'Title: Background Overlay', 'wpsp-meta-box' ), 
				'id'    => $prefix . "post_title_background_overlay",
				'desc'	=> __( 'Select an overlay for the title background.', 'wpsp-meta-box' ), 
				'type'  => 'select',
				'class' => 'post_title_background_overlay',
				'options'     => array(
					'' => __( 'None', 'wpsp-meta-box' ),
					'dark' => __( 'Dark', 'wpsp-meta-box' ),
					'dotted' => __( 'Dotted', 'wpsp-meta-box' ),
					'dashed' => __( 'Diagonal Lines', 'wpsp-meta-box' ),
					'bg-color' => __( 'Background Color', 'wpsp-meta-box' ),
					),
			),
			array(
				'name'  => __( 'Title: Background Overlay Opacity', 'wpsp-meta-box' ), 
				'id'    => $prefix . "post_title_background_overlay_opacity",
				'desc'	=> __( 'Enter a custom opacity for your title background overlay. e.g: 0.5 and max 1', 'wpsp-meta-box' ), 
				'type'  => 'text',
				'class' => 'post_title_background_overlay_opacity'
			),
			array(
				'type' => 'heading',
				'name' => esc_html__( 'Layout', 'wpsp-meta-box' ),
			),	
			array(
				'name'  => __( 'Primary Sidebar', 'wpsp-meta-box' ), 
				'id'    => $prefix . "sidebar_primary",
				'desc'  => __( 'Overrides default', 'wpsp-meta-box' ),// Field description (optional)
				'type'  => 'select',
				// Array of 'value' => 'Image Source' pairs
				'options'  => $sidebars,
			),
			array(
				'name'  => __( 'Layout', 'wpsp-meta-box' ), 
				'id'    => $prefix . "layout",
				'desc'  => __( 'Overrides the default layout option', 'wpsp-meta-box' ),// Field description (optional)
				'type'  => 'image_select',
				'std'   => __( 'inherit', 'wpsp-meta-box' ),// Default value (optional)
				// Array of 'value' => 'Image Source' pairs
				'options'  => array(
					'inherit'  => get_template_directory_uri() . '/images/admin/layout-off.png',
					'right-sidebar'  => get_template_directory_uri() . '/images/admin/2cr.png',
					'left-sidebar'  => get_template_directory_uri() . '/images/admin/2cl.png',
					'full-width'   => get_template_directory_uri() . '/images/admin/full-width.png',
					'full-screen'   => get_template_directory_uri() . '/images/admin/full-screen.png',
				),
			),
		)
	);


	return $meta_boxes;
}