<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>

<div class="floating-image" aria-hidden="true">
    <img src="<?php echo VACTemplate::image_src($vac_content); ?>" alt="">
</div>
