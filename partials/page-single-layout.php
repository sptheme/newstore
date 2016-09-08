<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package newstore
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?> 
    
	<div class="entry-content">

		<?php the_content(); ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'newstore' ),
				'after'  => '</div>',
			) );
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php edit_post_link( __( 'Edit', 'newstore' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-footer -->

	<?php
	// Get social sharing template part
	get_template_part( 'partials/social', 'share' ); ?>

</article><!-- #post-## -->

<?php
// Display comments if enabled
if ( wpsp_get_redux( 'is-page-comments', false ) ) :
	comments_template();
endif; ?>
