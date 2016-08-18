<?php
/**
 * Header layout.
 *
 * @package newstore
 */ 

// Define variables
$logo_url     = wpsp_header_logo_url();
$logo_title   = wpsp_header_logo_title();
$logo_img     = wpsp_get_redux( 'theme-logo' ); ?>

<div id="site-logo" class="site-branding <?php echo wpsp_header_logo_classes(); ?>">
	<div id="site-logo-inner" class="site-logo-inner">	
		<a href="<?php echo esc_url( $logo_url ); ?>" title="<?php echo esc_attr( $logo_title ); ?>" rel="home" class="main-logo">
			<img src="<?php echo esc_url( $logo_img['url'] ); ?>" alt="<?php echo esc_attr( $logo_title ); ?>" />
		</a>
	</div> <!-- .site-logo-inner -->
</div><!-- .site-branding -->