<?php
/**
 * Single blog post layout
 *
 * @package newstore
 */
?>

<article class="single-blog-article"<?php wpsp_schema_markup( 'blog_post' ); ?>>
	<?php // Get layout blocks
	$layout_blocks = wpsp_blog_single_layout_blocks(); 

	// Loop through blocks
	foreach ( $layout_blocks as $key => $value ) :  

		// Post title
		if ( 'title' == $key && !empty($value) ) {	
			get_template_part( 'partials/blog/blog-single-title' );
		}

		// Post meta
		elseif ( 'meta' == $key && !empty($value) ) {
			get_template_part( 'partials/blog/blog-single-meta' );
		}

		// Featured Media - featured image, video, gallery, etc
		elseif ( 'featured_media' == $key && !empty($value) ) {
			if ( ! $password_required &&  !empty(get_post_meta( get_the_ID(), 'wpsp_post_media_position', true )) ) {

				$post_format = $post_format ? $post_format : 'thumbnail';
				
				get_template_part( 'partials/blog/media/blog-single', $post_format );

			}
		}

		// Get post content
		elseif ( 'the_content' == $key && !empty($value) ) {
			get_template_part( 'partials/blog/blog-single-content' );
		}

		// Post Tags
		elseif ( 'post_tags' == $key && !empty($value) && ! $password_required ) {
			get_template_part( 'partials/blog/blog-single-tags' );
		}
		
		// Social sharing links
		elseif ( 'social_share' == $key && !empty($value) && ! $password_required ) {	
			get_template_part( 'partials/social-share' );
		}

		// Author bio
		elseif ( 'author_bio' == $key && !empty($value) && ! $password_required ) {
			get_template_part( 'author-bio' );
		}

		// Get the post comments & comment_form
		elseif ( 'comments' == $key && !empty($value) || comments_open() || get_comments_number() ) {
			comments_template();
		}

	endforeach; ?>
</article>