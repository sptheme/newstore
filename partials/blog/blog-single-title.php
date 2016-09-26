<?php
/**
 * Single blog post title
 *
 * @package newstore
 */

?>

<header class="single-blog-header">
	<h1 class="single-post-title entry-title"<?php wpsp_schema_markup( 'headline' ); ?>><?php the_title(); ?></h1><!-- .single-post-title -->
</header><!-- .blog-single-header -->