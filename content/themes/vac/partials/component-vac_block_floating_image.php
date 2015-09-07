<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>

<div class="floating-image">
    <img src="<?php echo VACTemplate::image_src($vac_content); ?>" alt="">
</div>
