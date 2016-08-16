<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package newstore
 */
?>

<?php get_sidebar('footerfull'); ?>

<div class="wrapper" id="wrapper-footer-widget">
    <div class="container">
        <?php // Get footer widgets columns
        $columns    = wpsp_get_redux( 'footer-widgets-columns', '4' );
        $grid_class = wpsp_grid_class( $columns );
        $gap        = wpsp_get_redux( 'footer-widgets-gap', '30' );

        // Classes
        $wrap_classes = array(); 
        if ( '1' == $columns ) {
            $wrap_classes[] = 'single-col-footer';
        } 
        if ( $gap ) {
            $wrap_classes[] = 'gap-'. $gap;
        }
        $wrap_classes = implode( ' ', $wrap_classes ); ?>

        <div class="row <?php echo esc_attr( $wrap_classes ); ?>">
            <!-- Widget 1 -->
            <div class="<?php echo esc_attr( $grid_class ); ?> col col-1">
                <?php dynamic_sidebar( 'footer-sidebar-1' ); ?>
            </div><!-- .footer-one-box -->

        </div> <!-- row end -->

    </div><!-- container end -->
</div> <!-- wrapper end -->

<div class="wrapper" id="wrapper-footer">
    
    <div class="container">

        <div class="row">

            <div class="col-md-12">
    
                <footer id="colophon" class="site-footer" role="contentinfo">

                    <div class="site-info">
                        <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'newstore' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'newstore' ), 'WordPress' ); ?></a>
                        <span class="sep"> | </span>
                        <?php printf( __( 'Theme: %1$s by %2$s.', 'newstore' ), 'understrap', '<a href="http://understrap.com/" rel="designer">understrap.com</a>' ); ?> 
                        (<?php printf( __( 'Version', 'newstore' ) ); ?>: 0.4.6)
                    </div><!-- .site-info -->

                </footer><!-- #colophon -->

            </div><!--col end -->

        </div><!-- row end -->
        
    </div><!-- container end -->
    
</div><!-- wrapper end -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>
