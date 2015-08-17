<?php $vac_content = VACTemplate::ACF_content($wp_query); ?>
<?php $image = $vac_content['image']; ?>

<li>
    <a href="<?php echo $vac_content['permalink']; ?>">
    <h3><?php echo $vac_content['title']; ?></h3>
    <div><?php echo $vac_content['standfirst']; ?></div>
    <figure>
        <img src="<?php echo VACTemplate::image_src($image['id']); ?>"
             alt="<?php $image['alt'] ?>">
    </figure>
    </a>
</li>
