<?php
/**
 * Search entry layout
 *
 * @package newstore
 */

// Add classes to the post_class
$classes   = array();
$classes[] = 'search-entry';
$classes[] = 'clearfix';
if ( ! has_post_thumbnail() ) {
	$classes[] = 'search-entry-no-thumb';
} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>

	<?php // Return if there isn't any thumbnail defined
	if ( has_post_thumbnail() ) : ?>

	<div class="search-entry-thumb">
		<a href="<?php wpsp_permalink(); ?>" title="<?php wpsp_esc_title(); ?>" class="search-entry-img-link">
			<?php wpsp_post_thumbnail( apply_filters( 'wpsp_search_thumbnail_args', array(
				'size'   => 'search_results',
				'width'  => '',
				'height' => '',
				'alt'    => wpsp_get_esc_title(),
			) ) ); ?>
		</a>
	</div><!-- .search-entry-thumb -->

	<?php endif; ?>

	<div class="search-entry-text">
		
		<header class="search-entry-header">
			<h2><a href="<?php wpsp_permalink(); ?>" title="<?php wpsp_esc_title(); ?>"><?php the_title(); ?></a></h2>
		</header><!-- .search-entry-header -->

		<div class="search-entry-excerpt">
		    <?php wpsp_excerpt( array(
		        'length'          => '30',
		        'readmore'        => false,
		        'ignore_more_tag' => true,
		    ) ); ?>
		</div><!-- .search-entry-excerpt -->

	</div> <!-- .search-entry-text -->

</article><!-- #post-## -->
