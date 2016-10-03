<?php
/**
 * Single Product Image
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     9999 // this file should never need updating...
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

// Get first image
$attachment_id  = get_post_thumbnail_id();

// Get gallery images
$attachments = $product->get_gallery_attachment_ids();
if ( $attachment_id ) {
	array_unshift( $attachments, $attachment_id );
}
$attachments = array_unique( $attachments );

// Get attachements count
$attachements_count = count( $attachments );

// Conditional to show slider or not
$show_slider = true;
if ( $product->has_child() ) {
	$show_slider = false;
}
$show_slider = apply_filters( 'wpsp_woo_product_slider', $show_slider ); ?>

<div class="images clear">

	<?php
	// Slider
	if ( $attachments && $attachements_count > 1 && $show_slider ) :

		// Slider data attributes
		$data_atributes                              = array();
		$data_atributes['animation-speed']           = 300;
		$data_atributes['auto-play']                 = 'false';
		$data_atributes['fade']                      = 'true';
		$data_atributes['buttons']                   = 'false';
		$data_atributes['loop']                      = 'false';
		$data_atributes['thumbnails-height']         = '70';
		$data_atributes['thumbnails-width']          = '70';
		$data_atributes['height-animation-duration'] = '0.0';
		$data_atributes                              = apply_filters( 'wpsp_shop_single_slider_data', $data_atributes );
		$data_atributes_html                         = '';
		foreach ( $data_atributes as $key => $val ) {
			$data_atributes_html .= ' data-'. $key .'="'. $val .'"';
		} ?>

		<div class="wpsp-slider-preloaderimg">
            <?php
            // Display first image as a placeholder while the others load
            wpsp_post_thumbnail( array(
                'attachment' => $attachments[0],
                'alt'        => get_post_meta( $attachments[0], '_wp_attachment_image_alt', true ),
            ) ); ?>
        </div><!-- .wpsp-slider-preloaderimg -->

		<div class="wpsp-slider pro-slider woocommerce-single-product-slider lightbox-group"<?php echo $data_atributes_html; ?>>

			<div class="wpsp-slider-slides sp-slides">

				<div class="slides">

					<?php
					// Loop through attachments and display in slider
					foreach ( $attachments as $attachment ) :

						// Get attachment alt
						$attachment_alt = get_post_meta( $attachment, '_wp_attachment_image_alt', true );

						// Get thumbnail
						$thumbnail = wpsp_get_post_thumbnail( array(
							'attachment' => $attachment,
							'size'       => 'shop_single',
						) );

						// Display thumbnail
						if ( $thumbnail ) : ?>

							<div class="wpsp-slider-slide sp-slide">

								<a href="<?php wpsp_lightbox_image( $attachment ); ?>" title="<?php echo esc_attr( $attachment_alt ); ?>" class="wpsp-lightbox-group-item"><?php echo $thumbnail; ?></a>

							</div><!--. wpsp-slider-slide -->

						<?php endif; ?>

					<?php endforeach; ?>

				</div><!-- .slides -->

				<div class="wpsp-slider-thumbnails sp-thumbnails">

					<?php
					// Add slider thumbnails
					foreach ( $attachments as $attachment ) :

						wpsp_post_thumbnail( array(
							'attachment' => $attachment,
							'size'       => 'shop_single_thumbnail',
							'class'      => 'wpsp-slider-thumbnail sp-thumbnail',
						) );

					endforeach; ?>

				</div><!-- .wpsp-slider-thumbnails -->

			</div><!-- .wpsp-slider-slides -->

		</div><!-- .wpsp-slider -->

	<?php elseif ( has_post_thumbnail() || isset( $attachments[0] ) ) : ?>

		<?php
		// Get image data
		$image_id    = isset( $attachments[0] ) ? $attachments[0] : $attachment_id;
		$image_title = esc_attr( get_the_title( $image_id ) );
		$image_link  = wp_get_attachment_url( $image_id );
		$image       = wpsp_get_post_thumbnail( array(
			'attachment' => $image_id,
			'size'       => 'shop_single',
			'title'      => wpsp_get_esc_title(),
		) );

		if ( $product->has_child() ) {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="woocommerce-main-image">%s</div>', $image ), $post->ID );
		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image wpsp-lightbox" title="%s" >%s</a>', $image_link, $image_title, $image ), $post->ID );
		}

		// Display variation thumbnails
		if ( $product->has_child() || ! $show_slider ) { ?>

			<div class="product-variation-thumbs clear lightbox-group">

				<?php foreach ( $attachments as $attachment ) : ?>
					
					<?php
					// Get attachment alt
					$attachment_alt = get_post_meta( $attachment, '_wp_attachment_image_alt', true );

					// Get thumbnail
					$args = apply_filters( 'wpsp_woo_variation_thumb_args', array(
						'attachment' => $attachment,
						'size'       => 'shop_single',
					) );
					$thumbnail = wpsp_get_post_thumbnail( $args ); ?>

					<?php if ( $thumbnail ) : ?>

						<a href="#<?php //wpsp_get_lightbox_image( $attachment ); ?>" title="<?php echo esc_attr( $attachment_alt ); ?>" data-title="<?php echo esc_attr( $attachment_alt ); ?>" data-type="image" class="wpsp-lightbox-group-item"><?php echo $thumbnail; ?></a>

					<?php endif; ?>

				<?php endforeach; ?>

			</div><!-- .product-variation-thumbs -->

		<?php } ?>

	<?php else : ?>

		<?php
		// Display placeholder image
		wpsp_woo_placeholder_img(); ?>
		
	<?php endif; ?>

</div>