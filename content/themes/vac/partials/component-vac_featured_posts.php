<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>

<hr>

<ol>
    <?php foreach ($vac_content as $post): ?>
    <?php
        $featured_content = VACTemplate::ACF_featured_content($post);
        $image = $featured_content['image'];
    ?>
    <li>
    <a href="<?php echo get_the_permalink($post); ?>">
        <h3><?php echo get_the_title($post); ?></h3>
        <div><?php echo $featured_content['standfirst']; ?></div>
        <figure>
            <img src="<?php echo VACTemplate::image_src($image['id']); ?>"
                 alt="<?php $image['alt'] ?>">
            <figcaption><?php echo $image['caption']; ?></figcaption>
        </figure>
    </a>
    </li>
    <?php endforeach; ?>
</ol>
