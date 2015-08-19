<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>

<div>
    <img src="<?php echo VACTemplate::image_src($vac_content); ?>" alt="">
</div>
