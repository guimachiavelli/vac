<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>

<div class="component">
    <div class="accordion">
        <ol class="accordion__list">
            <?php foreach ($vac_content as $item): ?>
            <li class="accordion-item"
                aria-expanded="<?php echo VACTemplate::field_toggle($item['accordion_open']); ?>">
                <h3 class="accordion-item__title"><?php echo $item['accordion_item_title']; ?></h3>
                <div class="accordion-item__content">
                    <?php if ($item['accordion_item_type'] == 'text'): ?>
                        <?php echo $item['accordion_item_text'];  ?>
                    <?php else: ?>
                        <ul class="accordion-item__image-list">
                        <?php foreach ($item['accordion_item_image'] as $img): ?>
                            <li class="accordion-item__image">
                                <?php echo VACTemplate::image($img['id']); ?>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>
