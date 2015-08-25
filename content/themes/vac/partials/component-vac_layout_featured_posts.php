<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>

<div class="component">
    <div class="featured-posts">
        <h2 class="featured-posts__title">
            <?php echo $vac_content['vac_featured_post_title']; ?>
        </h2>

        <?php if ($vac_content['vac_featured_posts'] != null): ?>
        <ol>
            <?php foreach ($vac_content['vac_featured_posts'] as $post): ?>
            <?php
                $featured_content = VACTemplate::ACF_featured_content($post);
                $image = $featured_content['image'];
            ?>
            <li class="featured-post">
            <a href="<?php echo get_the_permalink($post); ?>">
                <div class="element element--narrow">
                    <figure class="featured-post__content">
                        <?php if ($image): ?>
                            <img src="<?php echo VACTemplate::image_src($image['id']); ?>"
                                 alt="<?php $image['alt'] ?>">
                            <figcaption><?php echo $image['caption']; ?></figcaption>
                        <?php endif; ?>
                    </figure>
                </div>

                <div class="element element--wide element--last">
                    <div class="featured-post__header">
                        <h3 class="featured-post__title"><?php echo get_the_title($post); ?></h3>
                        <div class="featured-post__standfirst"><?php echo $featured_content['standfirst']; ?></div>
                    </div>
                </div>
            </a>
            </li>
            <?php endforeach; ?>
        </ol>
        <?php endif; ?>
    </div>
</div>
