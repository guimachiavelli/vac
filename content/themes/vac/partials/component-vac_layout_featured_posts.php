<?php
    $vac_content = VACTemplate::ACF_content($wp_query);
    $title = $vac_content['vac_featured_posts_title'];
    $posts = $vac_content['vac_block_featured_posts'];
?>

<div class="component">
    <div class="featured-posts">
        <h2 class="featured-posts__title">
            <?php echo $title; ?>
        </h2>

        <?php if (!empty($posts)): ?>
        <ol class="featured-posts__list">
            <?php foreach ($posts as $post): ?>
            <?php
                $link = $post['vac_featured_post_link'][0];
                $image = VACTemplate::featured_image($link);
                $text = VACTemplate::featured_title($link);
                $excerpt = VACTemplate::featured_excerpt($link); ?>
            <li class="featured-post">
            <a class="featured-post__link" href="<?php echo get_the_permalink($link); ?>">
                <div class="element element--narrow">
                    <div class="featured-post__content">
                        <figure class="featured-post__figure">
                           <?php echo VACTemplate::image($image); ?>
                            <figcaption class="featured-post__caption">
                                <?php echo VACTemplate::image_caption($image); ?>
                            </figcaption>
                        </figure>
                    </div>
                </div>

                <div class="element element--wide element--last">
                    <div class="featured-post__header">
                        <?php echo $text; ?>
                    </div>
                </div>

                <div class="element element-full">
                    <aside class="featured-post__excerpt"><?php echo $excerpt; ?></aside>
                </div>
            </a>
            </li>
            <?php endforeach; ?>
        </ol>
        <?php endif; ?>
    </div>
</div>
