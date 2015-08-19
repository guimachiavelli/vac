<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>

<hr>

<ol>
    <?php foreach ($vac_content as $image): ?>
    <li>
        <figure>
            <img src="<?php echo VACTemplate::image_src($image['id']); ?>"
                 alt="<?php echo $image['alt']; ?>">
            <figcaption><?php echo $image['caption']; ?></figcaption>
        </figure>
    </li>
    <?php endforeach; ?>
</ol>
