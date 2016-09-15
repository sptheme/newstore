<?php
/**
 * Mobile Menu alternative.
 *
 * @package newstore
 */ ?>

<div id="mobile-menu-alternative">
    <?php wp_nav_menu( array(
        'theme_location' => 'mobile_menu_alt',
        'menu_class'     => 'wpsp-dropdown-menu',
        'fallback_cb'    => false,
    ) ); ?>
</div><!-- #mobile-menu-alternative -->