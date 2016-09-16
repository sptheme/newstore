<?php
/**
 * Footer Layout
 *
 * @package newstore
 */
?>

<?php wpsp_hook_footer_before(); ?>

<?php if ( has_footer_widgets() ) : ?>

    <footer id="footer" class="site-footer"<?php wpsp_schema_markup( 'footer' ); ?>>

        <?php wpsp_hook_footer_top(); ?>

        <div id="footer-inner">

            <?php wpsp_hook_footer_inner(); // widgets are added via this hook ?>
            
        </div><!-- #footer-widgets -->

        <?php wpsp_hook_footer_bottom(); ?>

    </footer><!-- #footer -->

<?php endif; ?>

<?php wpsp_hook_footer_after(); ?>