<?php
/**
 * Adds thumbnail options to taxonomies
 *
 * @package newstore
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Global var for class
global $wpsp_term_thumbnails;

// Start Class
if ( ! class_exists( 'WPSP_Term_Thumbnails' ) ) {
	class WPSP_Term_Thumbnails {

		/**
		 * Main constructor
		 *
		 * @since 2.1.0
		 */
		public function __construct() {
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_filter( 'wpsp_page_header_style',  array( $this, 'page_header_style' ) );
			add_filter( 'wpsp_page_header_background_image',  array( $this, 'page_header_bg' ) );
		}

		/**
		 * Initialize things in the backend
		 *
		 * @since 2.1.0
		 */
		public function admin_init() {

			// Get taxonomies
			$taxonomies = apply_filters( 'wpsp_thumbnail_taxonomies', get_taxonomies() );

			// Remove woo
			if ( isset( $taxonomies['product_cat'] ) ) {
				unset( $taxonomies['product_cat'] );
			}

			// Loop through taxonomies
			foreach ( $taxonomies as $taxonomy ) {

				// Add forms
				add_action( $taxonomy . '_add_form_fields', array( $this, 'add_form_fields' ) );
				add_action( $taxonomy . '_edit_form_fields', array( $this, 'edit_form_fields' ) );
				
				// Add columns
				add_filter( 'manage_edit-'. $taxonomy .'_columns', array( $this, 'admin_columns' ) );
				add_filter( 'manage_'. $taxonomy .'_custom_column', array( $this, 'admin_column' ), 10, 3 );

				// Save forms
				add_action( 'created_'. $taxonomy, array( $this, 'save_forms' ), 10, 3 );
				add_action( 'edit_'. $taxonomy, array( $this, 'save_forms' ), 10, 3 );

			}

		}

		/**
		 * Add Thumbnail field to add form fields
		 *
		 * @since 2.1.0
		 */
		public function add_form_fields() {

			// Enqueue media for media selector
			wp_enqueue_media();

			// Get current taxonomy
			$taxonomy = get_taxonomy( $_GET['taxonomy'] );
			$taxonomy = $taxonomy->labels->singular_name; ?>

			<div class="form-field">

				<label for="display_type"><?php esc_html_e( 'Page Header Thumbnail', 'newstore' ); ?></label>

				<select id="wpsp_term_page_header_image" name="wpsp_term_page_header_image" class="postform">
					<option value=""><?php esc_html_e( 'Default', 'newstore' ); ?></option>
					<option value="false"><?php esc_html_e( 'No', 'newstore' ); ?></option>
					<option value="true"><?php esc_html_e( 'Yes', 'newstore' ); ?></option>
				</select>

			</div>

			<div class="form-field">

				<label for="term-thumbnail"><?php esc_html_e( 'Thumbnail', 'newstore' ); ?></label>

				<div>

					<div id="wpsp-term-thumbnail" style="float:left;margin-right:10px;">
						<img class="wpsp-term-thumbnail-img" src="<?php echo wpsp_placeholder_img_src(); ?>" width="60px" height="60px" />
					</div>

					<input type="hidden" id="wpsp_term_thumbnail" name="wpsp_term_thumbnail" />

					<button type="submit" class="wpsp-remove-term-thumbnail button"><?php esc_html_e( 'Remove image', 'newstore' ); ?></button>
					<button type="submit" class="wpsp-add-term-thumbnail button"><?php esc_html_e( 'Upload/Add image', 'newstore' ); ?></button>

					<script type="text/javascript">

						// Only show the "remove image" button when needed
						if ( ! jQuery( '#wpsp_term_thumbnail' ).val() ) {
							jQuery( '.wpsp-remove-term-thumbnail' ).hide();
						}

						// Uploading files
						var file_frame;
						jQuery( document ).on( 'click', '.wpsp-add-term-thumbnail', function( event ) {

							event.preventDefault();

							// If the media frame already exists, reopen it.
							if ( file_frame ) {
								file_frame.open();
								return;
							}

							// Create the media frame.
							file_frame = wp.media.frames.downloadable_file = wp.media({
								title    : '<?php esc_html_e( 'Choose an image', 'newstore' ); ?>',
								button   : {
									text : '<?php esc_html_e( 'Use image', 'newstore' ); ?>',
								},
								multiple : false
							});

							// When an image is selected, run a callback.
							file_frame.on( 'select', function() {
								attachment = file_frame.state().get( 'selection' ).first().toJSON();
								jQuery( '#wpsp_term_thumbnail' ).val( attachment.id );
								jQuery( '.wpsp-term-thumbnail-img' ).attr( 'src', attachment.url );
								jQuery( '.wpsp-remove-term-thumbnail' ).show();
							});

							// Finally, open the modal.
							file_frame.open();

						});

						jQuery( document ).on( 'click', '.wpsp-remove-term-thumbnail', function( event ) {
							jQuery( '.wpsp-term-thumbnail' ).attr( 'src', '<?php echo wpsp_placeholder_img_src(); ?>' );
							jQuery( '#wpsp_term_thumbnail' ).val( '' );
							jQuery( '.wpsp-remove-term-thumbnail' ).hide();
							return false;
						});

					</script>

				</div>

				<div class="clear"></div>

			</div>

		<?php
		}

		/**
		 * Add Thumbnail field to edit form fields
		 *
		 * @since 2.1.0
		 */
		public function edit_form_fields( $term ) {

			// Enqueue media for media selector
			wp_enqueue_media();

			// Get current taxonomy
			$term_id  = $term->term_id;
			$taxonomy = get_taxonomy( $_GET['taxonomy'] );
			$taxonomy = $taxonomy->labels->singular_name;

			// Get term data
			$term_data = get_option( 'wpsp_term_data' );

			// Get thumbnail
			$thumbnail_id  = isset( $term_data[$term_id]['thumbnail'] ) ? $term_data[$term_id]['thumbnail'] : '';
			if ( $thumbnail_id ) {
				$thumbnail_src = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail', false );
				$thumbnail_url = ! empty( $thumbnail_src[0] ) ? $thumbnail_src[0] : '';
			}

			// Get page header setting
			$page_header_bg = isset( $term_data[$term_id]['page_header_bg'] ) ? $term_data[$term_id]['page_header_bg'] : ''; ?>

			<tr class="form-field">

				<th scope="row" valign="top"><label><?php esc_html_e( 'Page Header Thumbnail', 'newstore' ); ?></label></th>

				<td>
					<select id="wpsp_term_page_header_image" name="wpsp_term_page_header_image" class="postform">
						<option value="" <?php selected( $page_header_bg, '' ); ?>><?php esc_html_e( 'Default', 'newstore' ); ?></option>
						<option value="false" <?php selected( $page_header_bg, 'false' ); ?>><?php esc_html_e( 'No', 'newstore' ); ?></option>
						<option value="true" <?php selected( $page_header_bg, 'true' ); ?>><?php esc_html_e( 'Yes', 'newstore' ); ?></option>
					</select>
				</td>

			</tr>

			<tr class="form-field">

				<th scope="row" valign="top">
					<label for="term-thumbnail"><?php esc_html_e( 'Thumbnail', 'newstore' ); ?></label>
				</th>

				<td>

					<div id="wpsp-term-thumbnail" style="float:left;margin-right:10px;">
						<?php if ( ! empty( $thumbnail_url ) ) { ?>
							<img class="wpsp-term-thumbnail-img" src="<?php echo esc_url( $thumbnail_url ); ?>" width="60px" height="60px" />
						<?php } else { ?>
							<img class="wpsp-term-thumbnail-img" src="<?php echo esc_url( wpsp_placeholder_img_src() ); ?>" width="60px" height="60px" />
						<?php } ?>
					</div>

					<input type="hidden" id="wpsp_term_thumbnail" name="wpsp_term_thumbnail" value="<?php echo esc_attr( $thumbnail_id ); ?>" />

					<button type="submit" class="wpsp-remove-term-thumbnail button"<?php if ( ! $thumbnail_id ) echo 'style="display:none;"'; ?>>
						<?php esc_html_e( 'Remove image', 'newstore' ); ?>
					</button>

					<button type="submit" class="wpsp-add-term-thumbnail button">
						<?php esc_html_e( 'Upload/Add image', 'newstore' ); ?>
					</button>

					<script type="text/javascript">

						// Uploading files
						var file_frame;

						jQuery( document ).on( 'click', '.wpsp-add-term-thumbnail', function( event ) {

							event.preventDefault();

							// If the media frame already exists, reopen it.
							if ( file_frame ) {
								file_frame.open();
								return;
							}

							// Create the media frame.
							file_frame = wp.media.frames.downloadable_file = wp.media({
								title    : '<?php esc_html_e( 'Choose an image', 'newstore' ); ?>',
								button   : {
									text : '<?php esc_html_e( 'Use image', 'newstore' ); ?>',
								},
								multiple : false
							} );

							// When an image is selected, run a callback.
							file_frame.on( 'select', function() {
								attachment = file_frame.state().get( 'selection' ).first().toJSON();
								jQuery( '#wpsp_term_thumbnail' ).val( attachment.id );
								jQuery( '.wpsp-term-thumbnail-img' ).attr( 'src', attachment.url );
								jQuery( '.wpsp-remove-term-thumbnail' ).show();
							} );

							// Finally, open the modal.
							file_frame.open();

						} );

						jQuery( document ).on( 'click', '.wpsp-remove-term-thumbnail', function( event ) {
							jQuery( '.wpsp-term-thumbnail-img' ).attr( 'src', '<?php echo wpsp_placeholder_img_src(); ?>' );
							jQuery( '#wpsp_term_thumbnail' ).val( '' );
							jQuery( '.wpsp-remove-term-thumbnail' ).hide();
							return false;
						} );
					</script>

					<div class="clear"></div>

				</td>

			</tr>

			<?php

		}

		/**
		 * Adds the thumbnail to the database
		 *
		 * @since 2.1.0
		 */
		public function add_term_data( $term_id, $key, $data ) {

			// Validate data
			if ( empty( $term_id ) || empty( $data ) || empty( $key ) ) {
				return;
			}

			// Get thumbnails
			$term_data = get_option( 'wpsp_term_data' );

			// Add to options
			$term_data[$term_id][$key] = $data;

			// Update option
			update_option( 'wpsp_term_data', $term_data );

		}

		/**
		 * Deletes the thumbnail from the database
		 *
		 * @since 2.1.0
		 */
		public function remove_term_data( $term_id, $key ) {

			// Validate data
			if ( empty( $term_id ) || empty( $key ) ) {
				return;
			}

			// Get thumbnails
			$term_data = get_option( 'wpsp_term_data' );

			// Add to options
			if ( isset( $term_data[$term_id][$key] ) ) {
				unset( $term_data[$term_id][$key] );
			}

			// Update option
			update_option( 'wpsp_term_data', $term_data );
			
		}

		/**
		 * Update thumbnail value
		 *
		 * @since 2.1.0
		 */
		public function update_thumbnail( $term_id, $thumbnail_id ) {

			// Add thumbnail
			if ( ! empty( $thumbnail_id ) ) {
				$this->add_term_data( $term_id, 'thumbnail', $thumbnail_id );
			}

			// Delete thumbnail
			else {
				$this->remove_term_data( $term_id, 'thumbnail' );
			}


		}

		/**
		 * Update page header image option
		 *
		 * @since 2.1.0
		 */
		public function update_page_header_img( $term_id, $display ) {
			
			// Add option
			if ( ! empty( $display ) ) {
				$this->add_term_data( $term_id, 'page_header_bg', $display );
			}

			// Remove option
			else {
				$this->remove_term_data( $term_id, 'page_header_bg' );
			}

		}

		/**
		 * Save Forms
		 *
		 * @since 2.1.0
		 */
		public function save_forms( $term_id, $tt_id = '', $taxonomy = '' ) {
			if ( isset( $_POST['wpsp_term_thumbnail'] ) ) {
				$this->update_thumbnail( $term_id, $_POST['wpsp_term_thumbnail'] );
			}
			if ( isset( $_POST['wpsp_term_page_header_image'] ) ) {
				$this->update_page_header_img( $term_id, $_POST['wpsp_term_page_header_image'] );
			}
		}

		/**
		 * Thumbnail column added to category admin.
		 *
		 * @since 2.1.0
		 */
		public function admin_columns( $columns ) {
			$columns['wpsp-term-thumbnail-col'] = esc_attr__( 'Thumbnail', 'newstore' );
			return $columns;
		}

		/**
		 * Thumbnail column value added to category admin.
		 *
		 * @since 2.1.0
		 */
		public function admin_column( $columns, $column, $id ) {

			// Add thumbnail to columns
			if ( 'wpsp-term-thumbnail-col' == $column ) {
				if ( $thumbnail_id = $this->get_term_thumbnail_id( $id, 'thumbnail_id', true ) ) {
					$image = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
					$image = $image[0];
				} else {
					$image = wpsp_placeholder_img_src();
				}
				$columns .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Thumbnail', 'newstore' ) . '" class="wp-post-image" height="48" width="48" />';
			}

			// Return columns
			return $columns;

		}

		/**
		 * Retrieve term thumbnail
		 *
		 * @since 2.1.0
		 */
		public function get_term_thumbnail_id( $term_id = null ) {

			// Get term id if not defined and is tax
			$term_id = $term_id ? $term_id : get_queried_object()->term_id;

			// Return if no term id
			if ( ! $term_id ) {
				return;
			}

			// Get data
			$term_data = get_option( 'wpsp_term_data' );
			$term_data = ! empty( $term_data[ $term_id ] ) ? $term_data[ $term_id ] : '';

			// Return thumbnail ID
			if ( $term_data && ! empty( $term_data['thumbnail'] ) ) {
				return $term_data['thumbnail'];
			}
			
		}

		/**
		 * Check if the term page header should have a background image
		 *
		 * @since 2.1.0
		 */
		public function term_has_page_header_bg( $term_id = '' ) {

			// Get term id if not defined and is tax
			$term_id = $term_id ? $term_id : get_queried_object()->term_id;

			// True by default
			$bool = true;

			// Get Options and extract thumbnail
			$term_data = get_option( 'wpsp_term_data' );

			// Return thumbnail ID
			if ( ! empty( $term_data[$term_id]['page_header_bg'] ) ) {
				$option = $term_data[$term_id]['page_header_bg'];
				$bool   = ( 'true' == $option ) ? true : $bool;
				$bool   = ( 'false' == $option ) ? false : $bool;
			}

			// Apply filters
			$bool = apply_filters( 'wpsp_term_has_page_header_bg', $bool );

			// Return bool
			return $bool;
			
		}

		/**
		 * Check if the term page header should have a background image
		 *
		 * @since 2.1.0
		 */
		public function page_header_style( $style ) {

			// Return background-image for taxonomies where it's enabled and defined
			if ( $this->is_tax_archive() && $this->term_has_page_header_bg() ) {

				// Get term thumbnail
				$term_thumbnail = $this->get_term_thumbnail_id();

				// Set style to background if term_thumbnail exists
				if ( $term_thumbnail ) {
					$style = 'background-image';
				}

			}

			// Return style
			return $style;

		}

		/**
		 * Sets correct page header background
		 *
		 * @since 2.1.0
		 */
		public function page_header_bg( $image ) {

			// Only check on tax pages
			if ( $this->is_tax_archive() ) {

				// Get term thumbnail
				$term_thumbnail = $this->get_term_thumbnail_id();

				// Set style to background if term_thumbnail exists
				if ( $term_thumbnail ) {
					$image = wp_get_attachment_image_src( $term_thumbnail, 'full' );
					$image = $image[0];
				}

			}

			// Return background
			return $image;

		}

		/**
		 * Check if on a tax archive
		 *
		 * @since 2.1.0
		 */
		public function is_tax_archive() {
			if ( ! is_search() && ( is_tax() || is_category() || is_tag() ) ) {
				return true;
			}
		}

	}
}
$wpsp_term_thumbnails = new WPSP_Term_Thumbnails();

// Helper functions
function wpsp_get_term_thumbnail_id( $term_id = null ) {
	global $wpsp_term_thumbnails;
	if ( $wpsp_term_thumbnails ) {
		$id = $wpsp_term_thumbnails->get_term_thumbnail_id( $term_id );
		return $id;
	} else {
		// Get term id if not defined and is tax
		$term_id = $term_id ? $term_id : get_queried_object()->term_id;
		// Term id isn't empty so lets locate the thumbnail
		if ( $term_id ) {
			// Get data
			$term_data = get_option( 'wpsp_term_data' );
			$term_data = ! empty( $term_data[ $term_id ] ) ? $term_data[ $term_id ] : '';
			// Return thumbnail ID
			if ( $term_data && ! empty( $term_data['thumbnail'] ) ) {
				return $term_data['thumbnail'];
			}
		}
	}
}