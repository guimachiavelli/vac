<?php
    $vac_content = VACTemplate::ACF_content($wp_query);
    $title = $vac_content['vac_schools_title'];
    $schools = $vac_content['vac_block_schools'];
    $taxonomies = VACTemplate::terms_from_post_type('vac-school');
?>

<div class="component component--full">
    <div class="schools" data-filters="true">
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
                        <?php $filter_id =  rand(0, 100) . "_{$tax}:{$term[1]}"; ?>
                        <li class="archive-filter">
                            <input class="archive-filter__input"
                                   type="radio"
                                   name="<?php echo $tax; ?>"
                                   id="<?php echo $filter_id; ?>"
                                   value="<?php echo $term[1]; ?>">
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
                $link = $school['vac_schools_link'][0];
                $school_title = $school['vac_school_title'];
                $excerpt = $school['vac_school_excerpt'];
                $image = $school['vac_school_image'];
                $events = $school['vac_school_featured_events'];
                $events_title = $school['vac_school_featured_events_title'];
                $item_terms = VACTemplate::post_terms($link);
            ?>
            <li class="school" data-categories="<?php echo $item_terms; ?>">
                <div class="school__content">
                    <header class="school__header">
                        <a href="<?php echo get_the_permalink($link); ?>">
                            <h3 class="school__title"><?php echo $school_title; ?></h3>
                        </a>
                    </header>

                    <a href="<?php echo get_the_permalink($link); ?>">
                        <figure class="school__figure">
                            <?php echo VACTemplate::image($image); ?>
                            <figcaption class="school__caption">
                                <?php echo VACTemplate::image_caption($image); ?>
                            </figcaption>
                        </figure>
                    </a>

                    <div class="school__excerpt">
                        <?php echo $excerpt; ?>
                    </div>
                </a>
                </div>

                <?php if(!empty($events)): ?>
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
                                <div class="featured-post__content">
                                    <figure class="featured-post__figure">
                                       <?php echo VACTemplate::image($event_image); ?>
                                        <figcaption class="featured-post__caption">
                                            <?php echo VACTemplate::image_caption($event_image); ?>
                                        </figcaption>
                                    </figure>
                                </div>
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
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>
