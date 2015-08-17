<?php /* Template Name: Exhibition archive */ ?>
<?php get_header(); ?>

    <?php while (have_posts()): the_post(); ?>

        <?php
            $fields = get_fields($post->ID);
            $fields = VACTemplate::parsed_ACF($fields);
        ?>

        <div>
            <?php VACTemplate::ACF_loop($fields['single']); ?>
        </div>

        <ol>
            <?php
                $exhibitions = get_posts(array(
                    'posts_per_page' => 100,
                    'post_type' => VACExhibition::$post_type
                ));
            ?>

        <?php foreach ($exhibitions as $exhibition): ?>
            <?php
                $content = VACTemplate::ACF_featured_content($exhibition->ID);
                $content['title'] = $exhibition->post_title;
            ?>
                <?php set_query_var(VACTemplate::$content_key, $content); ?>
                <?php get_template_part('partials/component', 'vac_featured_post'); ?>
                <?php VACTemplate::clear_query_vars($wp_query); ?>
        <?php endforeach; ?>

        </ol>


    <?php endwhile; ?>

<?php get_footer(); ?>
