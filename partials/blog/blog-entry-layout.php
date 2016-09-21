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

			<div class="blog-entry-content entry-details">

				<?php 
				// Loop through entry blocks
				foreach ( $blocks as $key => $value ) : 

					// Display the entry title
					if ( 'title' == $key && !empty($value) ) { 
						get_template_part( 'partials/blog/blog-entry-title' );
					} 

					// Display the entry meta
					elseif ( 'meta' == $key && !empty($value) ) { 
						get_template_part( 'partials/blog/blog-entry-meta' ); 
					} 

					// Display the entry excerpt or content
					elseif ( 'excerpt_content' == $key && !empty($value) ) { 
						get_template_part( 'partials/blog/blog-entry-content' ); 
					} 

					// Display the readmore button
					elseif ( 'readmore' == $key && !empty($value) ) { 
						if ( wpsp_get_redux( 'is-auto-excerpt', true ) ) { 
							get_template_part( 'partials/blog/blog-entry-readmore' ); 
						}
					} 

					// Display the readmore button
					elseif ( 'social_share' == $key && !empty($value) ) { 
						get_template_part( 'partials/social-share' ); 
					} ?>

				<?php
				// End block loop
				endforeach; ?>	

			</div><!-- blog-entry-content -->

		<?php

		// Other entry styles
		else : 
			
			// Loop through composer blocks and output layout
			foreach ( $blocks as $key => $value ) : ?>

			<?php
				// Featured media
				if ( 'featured_media' == $key && !empty($value) ) { ?>

					<?php get_template_part( 'partials/blog/media/blog-entry', $post_format ); ?>

				<?php } 

				// Display the entry header
				elseif ( 'title' == $key && !empty($value) ) { 
					get_template_part( 'partials/blog/blog-entry-title' );
				} 

				// Display the entry meta
				elseif ( 'meta' == $key && !empty($value) ) { 
					get_template_part( 'partials/blog/blog-entry-meta' ); 
				} 

				// Display the entry excerpt or content
				elseif ( 'excerpt_content' == $key && !empty($value) ) { 
					get_template_part( 'partials/blog/blog-entry-content' ); 
				}  

				// Display the readmore button
				elseif ( 'readmore' == $key && !empty($value) ) { 
					if ( wpsp_get_redux( 'is-auto-excerpt', true ) ) { 
						get_template_part( 'partials/blog/blog-entry-readmore' ); 
					}
				} 

				// Display the readmore button
				elseif ( 'social_share' == $key && !empty($value) ) { 
					get_template_part( 'partials/social-share' );
				} ?>
				
			<?php
			// End block loop
			endforeach; ?>	

		<?php
		// End block check
		endif; ?>
			
	</div> <!-- blog-entry-inner -->
</article>