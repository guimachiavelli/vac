<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>

<div class="component">
    <div class="featured-posts">
        <h2 class="featured-posts__title">
            <?php echo $vac_content['vac_featured_posts_title']; ?>
        </h2>

        <?php if (!empty($vac_content['vac_block_featured_posts'])): ?>
        <ol>
            <?php foreach ($vac_content['vac_block_featured_posts'] as $post): ?>
            <li class="featured-post">
            <a href="<?php echo get_the_permalink($post['vac_featured_post_link'][0]); ?>">
                <div class="element element--narrow">
                    <figure class="featured-post__content">
                       <?php echo VACTemplate::image($post['vac_featured_post_image']); ?>
                        <figcaption class="featured-post__caption">
                            <?php echo VACTemplate::image_caption($post['vac_featured_post_image']); ?>
                        </figcaption>
                    </figure>
                </div>

                <div class="element element--wide element--last">
                    <div class="featured-post__header">
                        <h3 class="featured-post__title"><?php echo $post['vac_featured_post_title']; ?></h3>
                        <div class="featured-post__standfirst"><?php echo $post['vac_featured_post_standfirst']; ?></div>
                    </div>
                </div>
            </a>
            </li>
            <?php endforeach; ?>
        </ol>
        <?php endif; ?>
    </div>
</div>
