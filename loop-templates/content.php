<?php
/**
 * @package newstore
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
	<header class="entry-header">
        
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>

			<div class="entry-meta">
				<?php wpsp_posted_on(); ?>
			</div><!-- .entry-meta -->

		<?php endif; ?>
        
	</header><!-- .entry-header -->

        <?php // Display media if thumbnail exists
			if ( $thumbnail = wpsp_get_blog_entry_thumbnail() ) :?> 
		<div class="blog-entry-media entry-media">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" class="blog-entry-media-link">
				<?php echo $thumbnail; ?>
			</a><!-- .blog-entry-media-link -->
		</div>	
		<?php endif; ?>
    
		<div class="entry-content">

	            <?php
	                the_excerpt();
	            ?>

			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'newstore' ),
					'after'  => '</div>',
				) );
			?>
	        
		</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php wpsp_entry_footer(); ?>
		
	</footer><!-- .entry-footer -->
    
</article><!-- #post-## -->