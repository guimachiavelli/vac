<?php get_header(); ?>

    <main class="post">
    <?php while (have_posts()): the_post(); ?>

        <?php
            $fields = get_fields($post->ID);
            $fields = VACTemplate::parsed_ACF($fields);
        ?>

        <div class="column column--full column--post">
            <header class="post__header">
                <h1 class="post__date"><?php the_time('d.m.Y'); ?></h1>
                <h2 class="post__title"><?php the_title(); ?></h2>
                <?php VACTemplate::ACF_loop($fields['hero']); ?>
            </header>
        </div>

        <div class="column column--wide column--post">
            <?php VACTemplate::ACF_loop($fields['left']); ?>
        </div>

        <div class="column column--narrow column--post">
            <?php VACTemplate::ACF_loop($fields['right']); ?>
        </div>
    <?php endwhile; ?>
    </main>

<?php get_footer(); ?>
