<?php get_header(); ?>

    <main class="post post--artist">
    <?php while (have_posts()): the_post(); ?>

        <?php
            $fields = get_fields($post->ID);
            $fields = VACTemplate::parsed_ACF($fields);
        ?>

        <div class="column column--wide column--post">
            <header class="post__header">
                <h2 class="post__title"><?php the_title(); ?></h2>
            </header>
            <?php VACTemplate::ACF_loop($fields, 'left'); ?>
        </div>
    <?php endwhile; ?>
    </main>

<?php get_footer(); ?>

