<?php
/**
 * Blog single post related entry
 *
 * @package newstore
 */

// Disable embeds
$show_embeds = apply_filters( 'wpsp_related_blog_posts_embeds', false );

// Check if experts are enabled
$has_excerpt = wpsp_get_redux( 'is-blog-related-excerpt', true );

// Get post format
$format = get_post_format();

// Get featured image
$thumbnail = wpsp_get_post_thumbnail( array(
	'size' => 'blog_related',
) );

// Add classes
$classes	= array( 'related-post' );
$classes[]	= bootstrap_grid_class( $wpsp_columns ); ?>

<article <?php post_class( $classes ); ?>>

	<?php
	// Display post video
	if ( $show_embeds && 'video' == $format && $video = wpsp_get_post_video_html() ) : ?>

		<div class="related-post-video">
			<?php echo $video; ?>
		</div><!-- .related-post-video -->

	<?php
	// Display post audio
	elseif ( $show_embeds && 'audio' == $format && $audio = wpsp_get_post_audio_html() ) : ?>

		<div class="related-post-video">
			<?php echo $audio; ?>
		</div><!-- .related-post-audio -->

	<?php
	// Display post thumbnail
	elseif ( $thumbnail ) :

		// Overlay style
		$overlay = wpsp_get_redux( 'blog-related-overlay' ); ?>

		<figure class="related-post-figure clearfix">
			<a href="<?php the_permalink(); ?>" title="<?php wpsp_esc_title(); ?>" rel="bookmark" class="related-post-thumb">
				<?php echo $thumbnail; ?>
			</a><!-- .related-post-thumb -->
		</figure>

	<?php endif; ?>

	<?php
	// Display post excerpt
	if ( $has_excerpt ) : ?>

		<div class="related-post-content equal-height-content">
			<h4 class="related-post-title">
				<a href="<?php wpsp_permalink(); ?>" title="<?php wpsp_esc_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h4><!-- .related-post-title -->
			<div class="related-post-excerpt">
				<?php wpsp_excerpt( array(
					'length' => wpsp_get_redux( 'blog-related-excerpt-length', '15' ),
				) ); ?>
			</div><!-- related-post-excerpt -->
		</div><!-- .related-post-content -->

	<?php endif; ?>

</article><!-- .related-post -->