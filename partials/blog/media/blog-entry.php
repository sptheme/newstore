<?php
/**
 * Blog entry standard format media
 *
 * @package newstore
 */

// Display media if thumbnail exists
if ( $thumbnail = wpsp_get_blog_entry_thumbnail() ) :

	// Overlay style
	$overlay = wpsp_get_redux( 'blog-entry-overlay' );
	$overlay = $overlay ? $overlay : 'none'; ?>

<div class="blog-entry-media entry-media">	
	<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" class="blog-entry-media-link<?php wpsp_entry_image_animation_classes(); ?>">
		<?php echo $thumbnail; ?>		
	</a><!-- .blog-entry-media-link -->
</div> <!-- blog-entry-media -->

<?php endif; ?>