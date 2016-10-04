<?php
/**
 * The template for displaying search results pages.
 *
 * @package newstore
 */

get_header(); ?>
<div class="wrapper" id="wrapper-search">
        
   <div id="content" class="container">

        <div class="row">
       
           <div id="primary" class="<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>col-md-8<?php else : ?>col-md-12<?php endif; ?> content-area">
            
                <main id="main" class="site-main" role="main">

                <?php wpsp_hook_main_top(); ?>

                <?php if ( have_posts() ) : ?>

                    <div id="search-entries" class="clearfix">
                        
                        <?php if ( 'blog' == wpsp_get_redux( 'search-style' ) ) : ?>
                            <div id="blog-entries" class="<?php wpsp_blog_wrap_classes(); ?>">

                                <?php // Define counter for clearing floats
                                $wpsp_count = 0; ?>

                                <?php while ( have_posts() ) : the_post(); 
                                        // Add to counter
                                        $wpsp_count++; ?>

                                        <?php // Get blog entry layout
                                        get_template_part( 'partials/blog/blog-entry-layout' ); 

                                        if ( wpsp_blog_entry_columns() == $wpsp_count ) $wpsp_count = 0; ?>

                                <?php endwhile; ?>

                            </div> <!-- #blog-entries -->
                        <?php // Display custom style for search entries 
                            else: ?>    

                            <?php while ( have_posts() ) : the_post(); ?>

                                <?php get_template_part( 'partials/search-entry-layout' ); ?>

                            <?php endwhile; ?>

                        <?php endif; ?>

                        <?php
                            // Display post pagination (next/prev - 1,2,3,4..)
                            wpsp_blog_pagination(); ?>

                    </div><!-- #search-entries -->        

                <?php else : ?>

                    <?php get_template_part( 'loop-templates/content', 'none' ); ?>

                <?php endif; ?>

                </main><!-- #main -->

                <?php wpsp_hook_main_bottom(); ?>
            
            </div><!-- #primary -->

            <?php get_sidebar(); ?>

        </div><!-- .row -->
       
   </div><!-- Container end -->
    
</div><!-- Wrapper end -->

<?php get_footer(); ?>