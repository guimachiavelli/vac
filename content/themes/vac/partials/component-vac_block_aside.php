<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>

<?php if (!empty($vac_content)): ?>
<div class="component">
    <div class="asides">
        <ol class="asides__list">
            <?php foreach ($vac_content as $aside): ?>
            <li class="aside-item" data-paragraph="<?php echo $aside['aside_paragraph_number']; ?>">
                <?php if ($aside['aside_image'] && $aside['aside_image'] != '0'): ?>
                <figure class="aside-item__figure">
                    <img src="<?php echo VACTemplate::image_src($aside['aside_image']); ?>"
                         alt="">
                </figure>
                <?php endif; ?>
                <div class="aside-item__text">
                    <?php echo $aside['aside_text']; ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>
<?php endif; ?>
