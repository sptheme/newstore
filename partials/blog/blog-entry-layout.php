<?php
/**
 * Blog entry layout
 *
 * @package newstore
 */

// Get post data
$post_format = get_post_format();
$entry_style = wpsp_blog_entry_style();

// Add classes to the blog entry post class - see framework/blog/blog-functions
$classes = wpsp_blog_entry_classes(); 

// Get layout blocks
$blocks = wpsp_blog_entry_layout_blocks(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div class="blog-entry-inner clearfix">
		
		<?php
		// Thumbnail entry style uses different layout
		if ( 'thumbnail-entry-style' == $entry_style ) : ?>

			<?php
			// Get media
			get_template_part( 'partials/blog/media/blog-entry', $post_format ); ?>

		<?php

		// Other entry styles
		else : 
			
			// Loop through composer blocks and output layout
			foreach ( $blocks as $key => $value ) : ?>

			<?php
				// Featured media
				if ( 'featured_media' == $key && !empty($value) ) { ?>

					<?php get_template_part( 'partials/blog/media/blog-entry', $post_format ); ?>

				<?php } ?>
				
			<?php
			// End block loop
			endforeach; ?>	

		<?php
		// End block check
		endif; ?>
			
	</div> <!-- blog-entry-inner -->
</article>