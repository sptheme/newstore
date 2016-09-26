<?php
/**
 * Single blog meta
 *
 * @package newstore
 */

// Get meta sections
$sections = wpsp_blog_single_meta_sections();

// Return if sections are empty
if ( empty( $sections ) ) {
	return;
}

// Add class for meta with title
$classes = 'meta clearfix';
if ( 'custom_text' == wpsp_get_redux( 'blog-single-header', 'custom_text' ) ) {
	$classes .= ' meta-with-title';
} ?>

<ul class="<?php echo esc_attr( $classes ); ?>">

	<?php
	// Loop through meta sections
	foreach ( $sections as $key => $value ) : ?>

		<?php if ( $key == 'date' && $value == '1' ) : ?>
			<li class="meta-date"><span class="fa fa-clock-o"></span><time class="published updated" datetime="<?php the_date('Y-m-d');?>"<?php wpsp_schema_markup( 'publish_date' ); ?>><?php echo get_the_date(); ?></time></li>
		<?php endif; ?>

		<?php if ( $key == 'author' && $value == '1' ) : ?>
			<li class="meta-author"><span class="fa fa-user"></span><span class="vcard author"<?php wpsp_schema_markup( 'author_name' ); ?>><span class="fn"><?php the_author_posts_link(); ?></span></span></li>
		<?php endif; ?>

		<?php if ( $key == 'categories' && $value == '1' ) : ?>
			<li class="meta-category"><span class="fa fa-folder-o"></span><?php the_category( ', ', get_the_ID() ); ?></li>
		<?php endif; ?>

		<?php if ( $key == 'comments' && $value == '1' && comments_open() && ! post_password_required() ): ?>
			<li class="meta-comments comment-scroll"><span class="fa fa-comment-o"></span><?php comments_popup_link( esc_html__( '0 Comments', 'wpsp-blog' ), esc_html__( '1 Comment',  'wpsp-blog' ), esc_html__( '% Comments', 'wpsp-blog' ), 'comments-link' ); ?></li>
		<?php endif; ?>

	<?php endforeach; ?>

</ul><!-- .meta -->