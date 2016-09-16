<?php
/**
 * Footer widgets
 *
 * @package newstore
 */
?>

<div id="wrapper-footer-widget" class="wrapper-footer-widget">
    <div class="container">
        <?php // Get footer widgets columns
        $columns    = wpsp_get_redux( 'footer-widgets-columns', '4' );
        $grid_class = bootstrap_grid_class( $columns );
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
            <!-- Footer widget 1 -->
            <div class="<?php echo esc_attr( $grid_class ); ?> col col-1">
                <?php dynamic_sidebar( 'footer-sidebar-1' ); ?>
            </div><!-- .footer-one-box -->

            <!-- Footer widget 2 -->
            <?php if ( $columns > 1 ) : ?>
            <div class="<?php echo esc_attr( $grid_class ); ?> col col-2">
                <?php dynamic_sidebar( 'footer-sidebar-2' ); ?>
            </div><!-- .footer-one-box -->
            <?php endif; ?>

            <!-- Footer widget 3 -->
            <?php if ( $columns > 2 ) : ?>
            <div class="<?php echo esc_attr( $grid_class ); ?> col col-3">
                <?php dynamic_sidebar( 'footer-sidebar-3' ); ?>
            </div><!-- .footer-one-box -->
            <?php endif; ?>

            <!-- Footer widget 4 -->
            <?php if ( $columns > 3 ) : ?>
            <div class="<?php echo esc_attr( $grid_class ); ?> col col-4">
                <?php dynamic_sidebar( 'footer-sidebar-4' ); ?>
            </div><!-- .footer-one-box -->
            <?php endif; ?>
            
        </div> <!-- row end -->
    </div> <!-- container end -->
</div> <!-- wrapper end -->