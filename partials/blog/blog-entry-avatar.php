<?php
/**
 * Blog entry avatar
 *
 * @package newstore
 */
 ?>

<div class="blog-entry-author-avatar">
	<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php esc_attr_e( 'Visit Author Page', 'newstore' ); ?>">
		<?php echo get_avatar(
			get_the_author_meta( 'user_email' ),
			apply_filters( 'wpsp_blog_entry_author_avatar_size', 74 )
		) ?>
	</a>
</div><!-- .blog-entry-author-avatar -->