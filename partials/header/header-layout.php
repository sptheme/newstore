<?php
/**
 * Header layout.
 *
 * @package newstore
 */ 
?>

<!-- ******************* The Navbar Area ******************* -->
<div class="wrapper-fluid wrapper-navbar" id="wrapper-navbar">

    <a class="skip-link screen-reader-text sr-only" href="#content"><?php _e( 'Skip to content', 'newstore' ); ?></a>

    <?php wpsp_hook_header_before(); ?>

    <header id="site-header" class="site-header <?php echo wpsp_header_classes(); ?>"<?php wpsp_schema_markup( 'header' ); ?> role="banner">

        <?php wpsp_hook_header_top(); ?>

        <div id="site-header-inner" class="container">

            <?php wpsp_hook_header_inner(); ?>

        </div> <!-- .container .clear -->

        <?php wpsp_hook_header_bottom(); ?>

        <nav class="navbar navbar-dark bg-inverse site-navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
                            

                <div class="container">


                            <div class="navbar-header">

                                <!-- .navbar-toggle is used as the toggle for collapsed navbar content -->

                                  <button class="navbar-toggle hidden-sm-up" type="button" data-toggle="collapse" data-target=".exCollapsingNavbar">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>

                                <!-- Your site title as branding in the menu -->
                                <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>

                            </div>

                            <!-- The WordPress Menu goes here -->
                            <?php wp_nav_menu(
                                    array(
                                        'theme_location' => 'primary',
                                        'container_class' => 'collapse navbar-toggleable-xs exCollapsingNavbar',
                                        'menu_class' => 'nav navbar-nav',
                                        'fallback_cb' => '',
                                        'menu_id' => 'main-menu',
                                        'walker' => new wp_bootstrap_navwalker()
                                    )
                            ); ?>

                </div> <!-- .container -->
                
            
        </nav><!-- .site-navigation -->

    </header> <!-- .site-header -->   

    <?php wpsp_hook_header_after(); ?>
    
</div><!-- .wrapper-navbar end -->