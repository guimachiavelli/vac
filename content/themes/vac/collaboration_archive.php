<?php /* Template Name: Collaboration archive */ ?>
<?php get_header(); ?>

    <?php while (have_posts()): the_post(); ?>

        <?php
            $fields = get_fields($post->ID);
            $fields = VACTemplate::parsed_ACF($fields);
            set_query_var(VACTemplate::$post_type_key,
                          VACCollaboration::$post_type);
        ?>

        <div class="column column--single column--collaborations">
            <?php VACTemplate::ACF_loop($fields, 'single'); ?>
        </div>

    <?php endwhile; ?>

<?php get_footer(); ?>
