<?php /* Template Name: Front page */ ?>
<?php get_header(); ?>
    <?php while (have_posts()): the_post(); ?>
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
