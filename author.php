<?php
/**
 * The template for displaying the author pages.
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package newstore
 */
get_header(); ?>

<div class="wrapper" id="author-wrapper">
    
    <div  id="content" class="container">

        <div class="row">
        
            <div id="primary" class="<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>col-md-8<?php else : ?>col-md-12<?php endif; ?> content-area">
               
                <main id="main" class="site-main" role="main">

                    <?php wpsp_hook_main_top(); ?>
                        
                    <header class="page-header author-header">
                        
                        <?php
                            $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
                        ?>

                        <h1><?php esc_html_e( 'About:', 'newstore' ); ?> <?php echo $curauth->nickname; ?></h1>

                        <?php if ( ! empty( $curauth->ID ) ) : ?>
                            <?php echo get_avatar($curauth->ID); ?>
                        <?php endif; ?>

                        <dl>
                            <?php if ( ! empty( $curauth->user_url ) ) : ?>
                                <dt><?php esc_html_e( 'Website', 'newstore' ); ?></dt>
                                <dd><a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></dd>
                            <?php endif; ?>

                            <?php if ( ! empty( $curauth->user_description ) ) : ?>
                                <dt><?php esc_html_e( 'Profile', 'newstore' ); ?></dt>
                                <dd><?php echo $curauth->user_description; ?></dd>
                            <?php endif; ?>
                        </dl>
                        
                        <h2><?php esc_html_e( 'Posts by', 'newstore' ); ?> <?php echo $curauth->nickname; ?>:</h2>
                            
                    </header><!-- .page-header -->
                    
                    <ul>
                        <!-- The Loop -->
                        
                        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                               <li>
                                    <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>">
                                    <?php the_title(); ?></a>,
                                    <?php the_time('d M Y'); ?> in <?php the_category('&');?>
                            </li>
                        
                        <?php endwhile; ?>

                            <?php the_posts_navigation(); ?>

                        <?php else : ?>

                            <?php get_template_part( 'loop-templates/content', 'none' ); ?>

                        <?php endif; ?>
                        
                        <!-- End Loop -->
        
                    </ul>

                    <?php wpsp_hook_main_bottom(); ?>

                </main><!-- #main -->
               
            </div><!-- #primary -->

            <?php get_sidebar(); ?>

        </div> <!-- .row -->
        
    </div><!-- Container end -->
    
</div><!-- Wrapper end -->

<?php get_footer(); ?>