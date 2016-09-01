<?php
/**
 * Site header search dropdown HTML
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package newstore
 */
?>

<div id="searchform-header-replace" class="header-searchform-wrap clear">
	<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="header-searchform">
		<input type="search" name="s" autocomplete="off" placeholder="<?php echo esc_html__( 'Type then hit enter to search...', 'newstore' ); ?>" />
		<?php if ( defined( 'ICL_LANGUAGE_CODE' ) ) { ?>
			<input type="hidden" name="lang" value="<?php echo( ICL_LANGUAGE_CODE ); ?>"/>
		<?php } ?>
	</form>
	<span id="searchform-header-replace-close" class="fa fa-times"></span>
</div><!-- #searchform-header-replace -->