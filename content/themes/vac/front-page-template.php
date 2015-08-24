<?php /* Template Name: Front page */ ?>
<?php get_header(); ?>

    <?php while (have_posts()): the_post(); ?>
        <?php
            $fields = get_fields($post->ID);
            $fields = VACTemplate::parsed_ACF($fields);
        ?>

        <div class="column column--full">
            <?php VACTemplate::ACF_loop($fields, 'hero'); ?>
        </div>

        <div class="column column--wide">
            <?php VACTemplate::ACF_loop($fields, 'left'); ?>
        </div>

        <div class="column column--narrow column--last">
            <?php VACTemplate::ACF_loop($fields, 'right'); ?>
        </div>
    <?php endwhile; ?>

<?php get_footer(); ?>
