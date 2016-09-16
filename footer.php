<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package newstore
 */
?>

    <?php wpsp_hook_wrapper_content_bottom(); ?>

    </div> <!-- .wrapper-content -->

    <?php wpsp_hook_wrapper_content_after(); ?>

    
    <?php wpsp_hook_page_bottom(); ?>

</div><!-- #page -->

<?php wpsp_hook_page_after(); ?>

<?php wp_footer(); ?>

</body>

</html>
