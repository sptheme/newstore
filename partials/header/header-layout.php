<?php
/**
 * Header layout.
 *
 * @package newstore
 */ 
?>

<a class="skip-link screen-reader-text sr-only" href="#content"><?php _e( 'Skip to content', 'newstore' ); ?></a>

<?php wpsp_hook_header_before(); ?>

<header id="site-header" class="site-header <?php echo wpsp_header_classes(); ?>"<?php wpsp_schema_markup( 'header' ); ?> role="banner">

    <?php wpsp_hook_header_top(); ?>

    <div id="site-header-inner" class="container clearfix">

        <?php wpsp_hook_header_inner(); ?>

    </div> <!-- .container .clear -->

    <?php wpsp_hook_header_bottom(); ?>

</header> <!-- .site-header -->   

<?php wpsp_hook_header_after(); ?>