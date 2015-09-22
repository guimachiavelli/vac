<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>

<?php if (!empty($vac_content)): ?>

<div class="component">
    <div class="slider">
        <ol class="slider__list">
            <?php foreach ($vac_content as $image): ?>
            <li class="slider-item">
                <figure class="slider-item__figure">
                    <?php echo VACTemplate::image($image['id']); ?>
                    <figcaption class="slider-item__caption">
                        <?php echo $image['caption']; ?>
                    </figcaption>
                </figure>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>

<?php endif; ?>
