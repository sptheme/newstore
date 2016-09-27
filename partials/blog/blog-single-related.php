<?php
/**
 * Single related posts
 *
 * @package newstore
 */

// Return if disabled
if ( ! wpsp_get_redux( 'is-related-blog-post', true ) ) {
	return;
}

// Number of columns for entries
$wpsp_columns = apply_filters( 'wpsp_related_blog_posts_columns', wpsp_get_redux( 'related-blog-post-columns', '3' ) );

// Create an array of current category ID's
$cats     = wp_get_post_terms( get_the_ID(), 'category' );
$cats_ids = array();
foreach( $cats as $wpsp_related_cat ) {
	$cats_ids[] = $wpsp_related_cat->term_id;
}

// Query args
$args = array(
	'posts_per_page' => wpsp_get_redux( 'related-blog-post-count', '3' ),
	'orderby'        => 'rand',
	'category__in'   => $cats_ids,
	'post__not_in'   => array( get_the_ID() ),
	'no_found_rows'  => true,
	'tax_query'      => array (
		'relation'  => 'AND',
		array (
			'taxonomy' => 'post_format',
			'field'    => 'slug',
			'terms'    => array( 'post-format-quote', 'post-format-link' ),
			'operator' => 'NOT IN',
		),
	),
);
$args = apply_filters( 'wpsp_blog_post_related_query_args', $args );

// Related query arguments
$wpsp_related_query = new wp_query( $args );

// If the custom query returns post display related posts section
if ( $wpsp_related_query->have_posts() ) :

	// Wrapper classes
	$classes = 'related-posts container'; ?>

	<div class="<?php echo $classes; ?>">

		<?php get_template_part( 'partials/blog/blog-single-related', 'heading' ); ?>

		<div class="row">
			<?php $wpsp_count = 0; ?>
			<?php foreach( $wpsp_related_query->posts as $post ) : setup_postdata( $post ); ?>
				<?php $wpsp_count++; ?>
				<?php include( locate_template( 'partials/blog/blog-single-related-entry.php' ) ); ?>
				<?php if ( $wpsp_columns == $wpsp_count ) $wpsp_count=0; ?>
			<?php endforeach; ?>
		</div><!-- .row -->

	</div><!-- .related-posts -->

<?php endif; ?>

<?php wp_reset_postdata(); ?>