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
            <?php
                $title = $post['vac_hero_post_title'];
                $link = $post['vac_hero_post_link'][0];
                $image = $post['vac_hero_post_image'];
                $excerpt = $post['vac_hero_post_excerpt'];
            ?>
            <li class="hero-post">
                <div class="element element--full">
                    <div class="hero-post__header">
                        <a href="<?php echo get_the_permalink($link); ?>">
                            <h3 class="hero-post__title"><?php echo $title; ?></h3>
                        </a>
                    </div>
                </div>
                <div class="element element--full">
                    <div class="element element--wide">
                        <a href="<?php echo get_the_permalink($link); ?>">
                            <figure class="hero-post__figure">
                                <?php echo VACTemplate::image($image); ?>
                            </figure>
                        </a>
                    </div>
                    <div class="element element--narrow">
                            <div class="hero-post__excerpt">
                                <?php echo $excerpt; ?>
                            </div>
                    </div>
            </li>
            <?php endforeach; ?>
        </ol>
        <?php endif; ?>
    </div>
</div>
