<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>

<div class="component component--full">
    <div class="hero">
        <div class="element element--full">
            <h2 class="hero__title">
                <?php echo $vac_content['vac_hero_title']; ?>
            </h2>
        </div>

        <?php if (!empty($vac_content['vac_block_hero_posts'])): ?>
        <ol class="hero__posts">
            <?php foreach ($vac_content['vac_block_hero_posts'] as $post): ?>
            <li class="hero-post">
            <a href="<?php echo get_the_permalink($post['vac_hero_post_link']); ?>">
                <div class="element element--full">
                    <div class="hero-post__header">
                        <h3 class="hero-post__title">
                            <?php echo $post['vac_hero_post_title']; ?>
                        </h3>
                    </div>
                </div>
                <div class="element element--full">
                    <div class="element element--wide">
                        <figure class="hero-post__picture">
                            <?php echo VACTemplate::image($post['vac_hero_post_image']); ?>
                        </figure>
                    </div>
                    <div class="element element--narrow element--last">
                        <div class="hero-post__excerpt">
                            <?php echo $post['vac_hero_post_excerpt']; ?>
                        </div>
                    </div>
            </a>
            </li>
            <?php endforeach; ?>
        </ol>
        <?php endif; ?>
    </div>
</div>
