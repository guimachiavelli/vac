<?php
    $vac_content = VACTemplate::ACF_content($wp_query);
    $title = $vac_content['vac_schools_title'];
    $schools = $vac_content['vac_block_schools'];
    $taxonomies = VACTemplate::terms_from_post_type('vac-school');
?>

<div class="component component--full">
    <div class="schools">
        <header class="schools__header">
            <h2 class="schools__title">
                <?php echo $title; ?>
            </h2>
        </header>

        <aside class="schools__filters">
            <form>
                <ul>
                    <?php foreach($taxonomies as $tax => $terms): ?>
                    <?php foreach($terms as $term): ?>
                        <?php $filter_id = "{$tax}:{$term[1]}"; ?>
                        <li class="archive-filter">
                            <input class="archive-filter__input"
                                   type="radio"
                                   name="<?php echo $tax; ?>"
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
        </aside>

        <ol class="schools__list">
            <?php foreach ($schools as $school): ?>
            <?php
                $link = $school['vac_schools_link'];
                $school_title = $school['vac_school_title'];
                $excerpt = $school['vac_school_excerpt'];
                $image = $school['vac_school_image'];
                $events = $school['vac_school_featured_events'];
                $events_title = $school['vac_school_featured_events_title'];
            ?>
            <li class="school">
                <div class="school__content">
                <a href="<?php echo get_the_permalink($link); ?>">
                    <header class="school__header">
                        <h3 class="school__title">
                            <?php echo $school_title; ?>
                        </h3>
                    </header>

                    <figure class="school__figure">
                        <?php echo VACTemplate::image($image); ?>
                        <figcaption class="school__caption">
                            <?php echo VACTemplate::image_caption($image); ?>
                        </figcaption>
                    </figure>

                    <div class="school__excerpt">
                        <?php echo $excerpt; ?>
                    </div>
                </a>
                </div>

                <div class="school__events featured-posts">
                    <h4 class="featured-posts__title">
                        <?php echo $events_title; ?>
                    </h4>
                    <ul class="featured-posts__list">
                        <?php foreach ($events as $event): ?>
                        <?php
                            $event_image = $event['vac_school_featured_event_image'];
                            $event_link = $event['vac_school_featured_event_link'];
                            $event_text = $event['vac_school_featured_event_text'];
                        ?>
                        <li class="featured-post">
                        <a href="<?php echo get_the_permalink($event_link); ?>">
                            <div class="element element--narrow">
                                <figure class="featured-post__content">
                                   <?php echo VACTemplate::image($event_image); ?>
                                    <figcaption class="featured-post__caption">
                                        <?php echo VACTemplate::image_caption($event_image); ?>
                                    </figcaption>
                                </figure>
                            </div>

                            <div class="element element--wide element--last">
                                <div class="featured-post__header">
                                    <?php echo $event_text; ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>