<?php get_header(); ?>

        <?php
            while (have_posts()):
                the_post();
        ?>

            <h2><?php the_time('d.m.Y'); ?></h2>
            <h1><?php the_title(); ?></h1>

            <?php
                $fields = get_fields($post->ID);
                $fields = VACTemplate::parsed_ACF($fields);
            ?>
            <div class="column column--left">
                <?php VACTemplate::ACF_loop($fields['left']); ?>
            </div>

            <div class="column column--right">
                <?php VACTemplate::ACF_loop($fields['right']); ?>
            </div>


        <?php endwhile; ?>


<?php get_footer(); ?>
