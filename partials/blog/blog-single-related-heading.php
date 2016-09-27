<?php
/**
 * Blog single post related heading
 *
 * @package newstore
 */

// Output heading
wpsp_heading( array(
	'content'		=> wpsp_blog_related_heading(),
	'tag'			=> 'div',
	'classes'		=> array( 'related-posts-title' ),
	'apply_filters'	=> 'blog_related',
) );