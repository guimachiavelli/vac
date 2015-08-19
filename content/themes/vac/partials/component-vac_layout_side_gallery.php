<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>

<div>
    <h2><?php echo $vac_content['vac_side_gallery_title']; ?></h2>

    <ol>
        <?php foreach ($vac_content['vac_side_gallery'] as $image): ?>
        <li>
            <figure>
                <img src="<?php echo VACTemplate::image_src($image['id']); ?>"
                     alt="<?php echo $image['alt']; ?>">
                <figcaption><?php echo $image['caption']; ?></figcaption>
            </figure>
        </li>
        <?php endforeach; ?>
    </ol>
</div>
