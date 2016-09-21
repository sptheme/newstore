<?php
/**
 * Blog entry layout
 *
 * @package newstore
 */

// Vars
$text   = wpsp_get_translated_theme_mod( 'blog_entry_readmore_text' );
$text   = $text ? $text : esc_html__( 'Read More', 'newstore' );

// Apply filters for child theming
$text = apply_filters( 'wpsp_post_readmore_link_text', $text );

// Button classes
$button_args = apply_filters( 'wpsp_blog_entry_button_args', array(
	'style' => '',
	'outline' => '',
	'size'  => 'btn-sm',
) ); ?>

<div class="blog-entry-readmore">
	<a href="<?php the_permalink(); ?>" class="<?php echo wpsp_get_button_classes( $button_args ); ?>" title="<?php echo $text ?>"><?php echo $text ?><span class="readmore-rarr">&rarr;</span></a>
</div><!-- .blog-entry-readmore -->