<?php
/**
 * Site header search dropdown HTML
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package newstore
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div id="searchform-dropdown" class="header-searchform-wrap clearfix">
	<?php get_search_form('true'); ?>
</div><!-- #searchform-dropdown -->