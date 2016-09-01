<?php
/**
 * Site header search dropdown HTML
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package newstore
 */
?>

<section id="searchform-overlay" class="header-searchform-wrap clearfix">
	<div id="searchform-overlay-title"><?php esc_html_e( 'Search', 'newstore' ); ?></div>
	<?php get_search_form( true ); ?>
</section><!-- #searchform-overlay -->