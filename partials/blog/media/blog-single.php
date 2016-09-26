<?php
/**
 * Blog single post standard format media
 *
 * @package newstore
 */

// Return if there isn't a thumbnail
if ( $thumbnail = wpsp_get_blog_post_thumbnail() ) : ?>
	<div id="post-media" class="clearfix">
	<?php if ( wpsp_get_redux( 'is-featured-image-lightbox' )  ) { ?>
		<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" data-type="image">
			<?php echo $thumbnail; ?>
		</a>
	<?php } else { ?>
		<?php echo $thumbnail; ?>
	<?php }	 ?>
	<?php
		// Blog entry caption
		if ( wpsp_get_redux( 'is-blog-thumbnail-caption' ) && $caption = wpsp_featured_image_caption() ) : ?>
		
			<div class="post-media-caption clearfix"><?php echo $caption; ?></div>

		<?php endif; ?>
	</div> <!-- #post-media -->
<?php endif; ?>

