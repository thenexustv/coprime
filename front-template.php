<?php
/**
 * Template Name: Front
 *
 */
?>
<?php get_header(); ?>

        <?php do_action('before_villain'); ?>

        <?php
        $villain_data = Coprime::get_instance()->get_villain_query();
        $villain_query = $villain_data['query'];
        $villain_mode = $villain_data['mode'];
        $villain_episodes = array();

        ?>

        <section id="villain-container" class="<?php echo $villain_mode; ?>">
            <div class="villain-wrapper">

                <?php

                    while ($villain_query->have_posts()): $villain_query->the_post();
                    $villain_episodes[] = get_the_ID();
                    get_template_part('partials/villain');
                    endwhile; ?>

                <?php do_action('in_villain'); ?>

            </div>
            
        </section>

        <?php do_action('after_villain'); ?>

        <?php do_action('before_world'); ?>

        <section id="world">
            <div id="content-container">
                <div class="content-wrapper">
                    
                    <?php do_action('before_content'); ?>

                    <?php if ( have_posts() ): while ( have_posts() ): the_post();
                        if ( strlen(get_the_content()) > 0 ):
                    ?>
                    <div id="noticeboard">
                        <?php the_content(); ?>
                    </div>
                    <?php endif; endwhile; endif; ?>

                    <div id="showboard">

                        <div class="top">
                        <?php
                            $topshelf_query = Coprime::get_instance()->get_showboard_primary_query($villain_episodes);
                            while ($topshelf_query->have_posts()): $topshelf_query->the_post();
                            get_template_part('partials/showboard');
                            endwhile;
                        ?>
                        </div>

                        <div class="bottom">
                        <?php
                            $bottom_query = Coprime::get_instance()->get_showboard_fringe_query();
                            while ($bottom_query->have_posts()): $bottom_query->the_post();
                            get_template_part('partials/showboard');
                            endwhile;
                        ?>
                        </div>

                        <div class="baseline">
                            <h3 class="all-shows"><a href="<?php echo site_url('/shows/'); ?>">&larr; All Shows</a></h3>
                            <h3 class="more-episodes"><a href="<?php echo site_url('/episode/'); ?>">More Episodes &rarr;</a></h3>
                        </div>

                    </div>

                    <?php do_action('after_content'); ?>

                </div>
            </div>
        </section>

        <?php do_action('after_world'); ?>

<?php get_footer(); ?>

