<?php
/**
 * Blog entry layout
 *
 * @package newstore
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Should we check for the more tag?
$check_more_tag = apply_filters( 'wpsp_check_more_tag', true ); ?>

<div class="blog-entry-excerpt">

    <?php
    // Display excerpt if auto excerpts are enabled in the admin
    if ( wpsp_get_redux( 'is-auto-excerpt', true ) ) :

        // Check if the post tag is using the "more" tag
        if ( $check_more_tag && strpos( get_the_content(), 'more-link' ) ) :

            // Display the content up to the more tag
            the_content( '', '&hellip;' );

        // Otherwise display custom excerpt
        else :

            // Display custom excerpt
            wpsp_excerpt( array(
                'length' => wpsp_excerpt_length(),
            ) );

        endif;

    // If excerpts are disabled, display full content
    else :

        the_content( '', '&hellip;' );

    endif; ?>

</div><!-- .blog-entry-excerpt -->