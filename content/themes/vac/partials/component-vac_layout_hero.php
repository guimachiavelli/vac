<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>

<div>
    <h2><?php echo $vac_content['vac_hero_title']; ?></h2>

    <ol>
        <?php foreach ($vac_content['vac_hero_posts'] as $post): ?>
        <?php
            $featured_content = VACTemplate::ACF_featured_content($post);
            $image = $featured_content['image'];
        ?>
        <li>
        <a href="<?php echo get_the_permalink($post); ?>">
            <h3><?php echo get_the_title($post); ?></h3>
            <div><?php echo $featured_content['standfirst']; ?></div>
            <?php if ($image): ?>
                <figure>
                    <img src="<?php echo VACTemplate::image_src($image['id']); ?>"
                         alt="<?php $image['alt'] ?>">
                    <figcaption><?php echo $image['caption']; ?></figcaption>
                </figure>
            <?php endif; ?>
        </a>
        </li>
        <?php endforeach; ?>
    </ol>

</div>
