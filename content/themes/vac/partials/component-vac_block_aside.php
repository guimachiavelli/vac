<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>

<hr>

<ol>
    <?php foreach ($vac_content as $aside): ?>
    <li data-paragraph="<?php echo $aside['aside_paragraph_number']; ?>">
        <?php if ($aside['aside_image'] && $aside['aside_image'] != '0'): ?>
        <figure>
            <img src="<?php echo VACTemplate::image_src($aside['aside_image']); ?>"
                 alt="">
        </figure>
        <?php endif; ?>
        <div>
            <?php echo $aside['aside_text']; ?>
        </div>
    </li>
    <?php endforeach; ?>
</ol>
