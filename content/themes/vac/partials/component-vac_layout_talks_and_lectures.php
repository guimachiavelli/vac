<?php
    $vac_content = VACTemplate::ACF_content($wp_query);
    $taxonomies = VACTemplate::terms_from_post_type('vac-event');
    $title = $vac_content['vac_talks_title'];
    $talks = $vac_content['vac_block_talks'];
?>

<div class="component">
    <div class="talks">
        <div class="talks__header">
            <h3 class="talks__title"><?php echo $title; ?></h3>
            <form class="talks__filters">
                <ul>
                    <li class="archive-filter">
                        <button class="archive-filter__button" type="reset">
                            All
                        </button>
                    </li>
                    <?php foreach($taxonomies as $tax => $terms): ?>
                    <?php foreach($terms as $term): ?>
                        <?php $filter_id = "{$tax}:{$term[1]}"; ?>
                        <li class="archive-filter">
                            <input class="archive-filter__input"
                                   type="checkbox"
                                   name="<?php echo $filter_id; ?>"
                                   id="<?php echo $filter_id; ?>"
                                   value="<?php echo $filter_id; ?>">
                            <label class="archive-filter__label"
                                   for="<?php echo $filter_id; ?>">
                                        <?php echo $term[0] ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
            </form>
        </div>

        <ol class="talks__list">
            <?php foreach ($talks as $talk): ?>
            <?php
                $link = $talk['vac_talk_link'][0];
                $image = $talk['vac_talk_image'];
                $text = $talk['vac_talk_text'];
            ?>
            <li class="featured-post">

            <a href="<?php echo get_the_permalink($link); ?>">
                <div class="element element--narrow">
                    <figure class="featured-post__content">
                       <?php echo VACTemplate::image($image); ?>
                        <figcaption class="featured-post__caption">
                            <?php echo VACTemplate::image_caption($image); ?>
                        </figcaption>
                    </figure>
                </div>

                <div class="element element--wide element--last">
                    <div class="featured-post__header">
                        <?php echo $text; ?>
                    </div>
                </div>
            </a>
            </li>
            <?php endforeach; ?>
        </ol>


    </div>
</div>
