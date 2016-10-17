<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
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
	
<div class="images">

	<?php
	// Slider
	if ( $attachments && $attachements_count > 1 && $show_slider ) : ?>
	<div class="row">
		
		<div class="col-md-4">
			<div class="owl-thumbs hidden-sm-down" data-slider-id="1">
				<?php
				// Add slider thumbnails
				foreach ( $attachments as $attachment ) : ?>
					<button class="owl-thumb-item">
					
					<?php wpsp_post_thumbnail( array(
						'attachment' => $attachment,
						'size'       => 'shop_single_thumbnail'					
					) ); ?>

					</button>
				<?php endforeach; ?>
			</div> <!-- .owl-thumbs -->
		</div> <!-- .col-md-4 -->
		
		<div class="col-md-8">
			<div class="owl-carousel" data-slider-id="1">
				<div class="image-border">
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

						<div class="item">
							<a href="<?php //wpsp_lightbox_image( $attachment ); ?>" title="<?php echo esc_attr( $attachment_alt ); ?>" class="wpsp-lightbox-group-item"><?php echo $thumbnail; ?></a>
						</div><!--. wpsp-slider-slide -->

					<?php endif; ?>

				<?php endforeach; ?>
				</div> <!-- .image-border -->

			</div> <!-- .owl-carousel -->
		</div> <!-- .col-md-8 -->
		
	</div> <!-- .row -->	

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
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="woocommerce-main-image image-border">%s</div>', $image ), $post->ID );
		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="image-border"><a href="%s" itemprop="image" class="woocommerce-main-image wpsp-lightbox" title="%s" >%s</a></div>', $image_link, $image_title, $image ), $post->ID );
		}

		// Display variation thumbnails
		if ( $product->has_child() || ! $show_slider ) { ?>

			<div class="product-variation-thumbs clearfix lightbox-group">

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
						<div class="image-border">
						<a href="#<?php //wpsp_lightbox_image( $attachment ); ?>" title="<?php echo esc_attr( $attachment_alt ); ?>" data-title="<?php echo esc_attr( $attachment_alt ); ?>" data-type="image" class="wpsp-lightbox-group-item"><?php echo $thumbnail; ?></a>
						</div>
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