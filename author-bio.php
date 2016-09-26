<?php
/**
 * The template for displaying Author bios.
 *
 * @package newstore
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get global post
global $post;

// Define author bio data
$data = array(
	'post_author' => $post->post_author,
	'avatar_size' => apply_filters( 'wpsp_author_bio_avatar_size', 74 ),
	'author_name' => get_the_author(),
	'posts_url'   => get_author_posts_url( $post->post_author ),
	'description' => get_the_author_meta( 'description' ),
);

// Get author avatar
$data['avatar'] = get_avatar( get_the_author_meta( 'user_email' ), $data['avatar_size'] );

// Apply filters so we can tweak the author bio output
$data = apply_filters( 'wpsp_post_author_bio_data', $data );

// Extract
extract( $data ); ?>

<section class="author-bio clearfix">

	<?php if ( $avatar ) : ?>

		<div class="author-bio-avatar">

			<a href="<?php echo esc_url( $posts_url ); ?>" title="<?php esc_attr_e( 'Visit Author Page', 'wpsp-blog' ); ?>">
				<?php
				// Display author avatar
				echo wpsp_sanitize_data( $avatar, 'img' ); ?>
			</a>

		</div><!-- .author-bio-avatar -->
		
	<?php endif; ?>

	<div class="author-bio-content clearfix">

		<h4 class="author-bio-title">
			<a href="<?php echo esc_url( $posts_url ); ?>" title="<?php esc_attr_e( 'Visit Author Page', 'wpsp-blog' ); ?>">
				<?php echo strip_tags( $author_name ); ?>
			</a>
		</h4><!-- .author-bio-title -->

		<?php
		// Outputs the author description if one exists
		if ( $description ) : ?>

			<div class="author-bio-description clearfix">
				<?php echo wpautop( do_shortcode( wpsp_sanitize_data( $description, 'html' ) ) ); ?>
			</div><!-- author-bio-description -->

		<?php endif; ?>

		<?php
		// Display author social links if there are social links defined
		if ( wpsp_author_has_social() ) : ?>

			<div class="author-bio-social clearfix">
				<?php
				// Display twitter url
				if ( $url = get_the_author_meta( 'wpsp_twitter', $post_author ) ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" title="Twitter" class="twitter tooltip-up">
						<span class="fa fa-twitter"></span>
					</a>
				<?php endif; ?>

				<?php
				// Display facebook url
				if ( $url = get_the_author_meta( 'wpsp_facebook', $post_author ) ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" title="Facebook" class="facebook tooltip-up">
						<span class="fa fa-facebook"></span>
					</a>
				<?php endif; ?>

				<?php
				// Display google plus url
				if ( $url = get_the_author_meta( 'wpsp_googleplus', $post_author ) ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" title="Google Plus" class="google-plus tooltip-up">
						<span class="fa fa-google-plus"></span>
					</a>
				<?php endif; ?>

				<?php
				// Display Linkedin url
				if ( $url = get_the_author_meta( 'wpsp_linkedin', $post_author ) ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" title="LinkedIn" class="linkedin tooltip-up">
						<span class="fa fa-linkedin"></span>
					</a>
				<?php endif; ?>

				<?php
				// Display pinterest plus url
				if ( $url = get_the_author_meta( 'wpsp_pinterest', $post_author ) ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" title="Pinterest" class="pinterest tooltip-up">
						<span class="fa fa-pinterest"></span>
					</a>
				<?php endif; ?>

				<?php
				// Display instagram plus url
				if ( $url = get_the_author_meta( 'wpsp_instagram', $post_author ) ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" title="Instagram" class="instagram tooltip-up">
						<span class="fa fa-instagram"></span>
					</a>
				<?php endif; ?>
			</div><!-- .author-bio-social -->

		<?php endif; ?>

	</div><!-- .author-bio-content -->

</section><!-- .author-bio -->