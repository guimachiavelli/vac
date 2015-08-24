<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>

<div class="component component--full">
    <div class="hero">
        <div class="element element--full">
            <h2 class="hero__title">
                <?php echo $vac_content['vac_hero_title']; ?>
            </h2>
        </div>

        <?php if (!empty($vac_content['vac_hero_posts'])): ?>
        <ol class="hero__posts">
            <?php foreach ($vac_content['vac_hero_posts'] as $post): ?>
            <?php
                $featured_content = VACTemplate::ACF_featured_content($post);
                $image = $featured_content['image'];
            ?>
            <li class="hero-post">
            <a href="<?php echo get_the_permalink($post); ?>">
                <div class="element element--full">
                    <div class="hero-post__header">
                        <h3 class="hero-post__title">
                            <?php echo get_the_title($post); ?>
                        </h3>
                        <div class="hero-post__standfirst">
                            <?php echo $featured_content['standfirst']; ?>
                        </div>
                    </div>
                </div>
                <div class="element element--full">
                    <?php if ($image): ?>
                        <div class="element element--wide">
                            <figure class="hero-post__picture">
                                <img src="<?php echo VACTemplate::image_src($image['id']); ?>"
                                     alt="<?php $image['alt'] ?>">
                                <figcaption><?php echo $image['caption']; ?></figcaption>
                            </figure>
                        </div>
                    <?php endif; ?>
                    <div class="element element--narrow element--last">
                        <div class="hero-post__excerpt">
                            lorem ipsum dolor sit amet
                        </div>
                    </div>
            </a>
            </li>
            <?php endforeach; ?>
        </ol>
        <?php endif; ?>
    </div>
</div>
