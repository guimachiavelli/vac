<?php get_header(); ?>

<?php
    if (have_posts()) {
        while (have_posts()) {
        the_post();
?>
    <article class="main-content">

        <figure class="featured-image">
            <?php the_post_thumbnail('large'); ?>
        </figure>

        <h1 class="project-title">
            <?php the_title(); ?>
            <time datetime="<?php the_time('Y-m') ?>"><?php the_time('Y/m') ?></time>
        </h1>

        <?php the_content(); ?>

<?php var_dump(get_field('test')); ?>

        <footer class="project-footer">
            <?php
                $prev_post = get_adjacent_post();
                $next_post = get_adjacent_post(false, '', false);
            ?>

            <?php if ($next_post) : ?>
                <li class="project-nav-link project-next">
                    <a href="<?php echo get_permalink($next_post->ID); ?>">
                        ‹
                        <span class="project-nav-link-text">Next</span>
                        <span class="project-nav-link-title"><?php echo $next_post->post_title; ?></span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($prev_post) : ?>
                <li class="project-nav-link project-prev">
                    <a href="<?php echo get_permalink($prev_post->ID); ?>">
                        <span class="project-nav-link-text">Prev</span>
                        <span class="project-nav-link-title"><?php echo $prev_post->post_title; ?></span>
                        ›
                    </a>
                </li>
            <?php endif; ?>


        </footer>

    </article>
<?php
        }
    }
?>

<?php get_footer(); ?>
