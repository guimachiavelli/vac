<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>

<div class="component">
    <div class="side-gallery" aria-expanded="false">
        <div class="side-gallery__mask">
            <h2 class="side-gallery__title">
                <?php echo $vac_content['vac_side_gallery_title']; ?>
            </h2>

             <ol class="side-gallery__list">
                <?php foreach ($vac_content['vac_side_gallery'] as $image): ?>
                <li class="side-gallery__item">
                    <figure>
                        <img src="<?php echo VACTemplate::image_src($image['id']); ?>"
                             alt="<?php echo $image['alt']; ?>">
                        <figcaption><?php echo $image['caption']; ?></figcaption>
                    </figure>
                </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</div>
