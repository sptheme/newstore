<?php
/**
 * Adds image sizes for use with the theme
 *
 * @package newstore
 */

if ( ! class_exists( WPSP_Image_Sizes ) ) {
	class WPSP_Image_Sizes {
		private $sizes;

		public function __construct()
		{
			$this->sizes = array();		

			// Define and add image sizes => Needs low priority for Visual Composer
			add_filter( 'init', array( $this, 'define_sizes' ), 0 );
			add_filter( 'init', array( $this, 'add_sizes' ), 1 );

			// Prevent images from cropping when on the fly is enabled
			add_filter( 'intermediate_image_sizes_advanced', array( $this, 'do_not_crop_on_upload' ) );	
		}

		/** 
		 * Defined array of image sizes use by theme
		 *
		 * @since 1.0.0
		 */
		public function define_sizes(){
			$this->sizes = apply_filters( 'wpsp_image_sizes', array(
				'blog_entry' => array(
					'label'   => esc_html__( 'Blog Entry', 'newstore' ),
					'width'   => 'blog-entry-image-width',
					'height'  => 'blog-entry-image-height',
					'crop'    => 'blog-entry-image-crop',
				),
				'blog_post'   => array(
					'label'   => esc_html__( 'Blog Post', 'newstore' ),
					'width'   => 'blog-post-image-width',
					'height'  => 'blog-post-image-height',
					'crop'    => 'blog-post-image-crop',
				),
				'blog_related' => array(
					'label'    => esc_html__( 'Blog Post: Related', 'newstore' ),
					'width'    => 'blog-related-image-width',
					'height'   => 'blog-related-image-height',
					'crop'     => 'blog-related-image-crop',
				),
			) );
		}

		/** 
		 * Register image size in wordpress
		 *
		 * @since 1.0.0
		 */
		public function add_sizes() {
			// Get sizes array
			$sizes = $this->sizes;

			foreach ($sizes as $size => $args ) {
				extract( $args );

				// Get theme mod values
				$width  = wpsp_get_redux( $width, '9999' );
				$height = wpsp_get_redux( $height, '9999' );
				$crop   = wpsp_get_redux( $crop, 'center-center'  );
				$crop   = $crop ? $crop : 'center-center'; // Sanitize crop

				// Turn crop into array
				$crop = ( 'center-center' == $crop ) ? 1 : explode( '-', $crop );

				// If image resizing is disabled and a width or height is defined add image size
				if ( $width || $height ) {
					add_image_size( $size, $width, $height, $crop );
				}
			}
		}

		/**
		 * Filter the image sizes automatically generated when uploading an image.
		 *
		 * @since 1.0.0
		 */
		public function do_not_crop_on_upload( $sizes ) {

			// Remove my image sizes from cropping if image resizing is enabled
			if ( wpsp_get_redux( 'is-image-resizing', true ) && ! empty ( $this->sizes ) ) {
				foreach( $this->sizes as $size => $args ) {
					unset( $sizes[$size] );
				}
			}

			// Return $meta
			return $sizes;

		}
	}
}
new WPSP_Image_Sizes();