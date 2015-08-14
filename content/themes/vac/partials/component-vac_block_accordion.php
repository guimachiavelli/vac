<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>

<hr>
<ol>
    <?php foreach ($vac_content as $item): ?>
    <li data-open="<?php echo $item['accordion_open'];  ?>">
        <h4><?php echo $item['accordion_item_title']; ?></h4>
        <div>
            <?php if ($item['accordion_item_type'] == 'text'): ?>
                <?php echo $item['accordion_item_text'];  ?>
            <?php else: ?>
                <?php foreach ($item['accordion_item_image'] as $img): ?>
                    <ul>
                        <li>
                            <img src="<?php echo VACTemplate::image_src($img['id']); ?>">
                        </li>
                    </ul>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </li>
    <?php endforeach; ?>
</ol>
