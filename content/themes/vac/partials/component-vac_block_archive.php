<?php
    $vac_content = VACTemplate::ACF_content($wp_query);
    $post_type = VACTemplate::post_type_from_wp_query($wp_query);
    $taxonomies = VACTemplate::terms_from_post_type($post_type);
?>

<div class="component">
    <div class="archive">
        <div class="archive__header">
            <h3 class="archive__title"><?php echo $vac_content; ?></h3>
            <form class="archive__filters">
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
        <?php
            $archive_posts = get_posts(array(
                'posts_per_page' => 100,
                'post_type' => $post_type
            ));
        ?>

        <?php if (!empty($archive_posts)): ?>
        <ol class="archive__list">
            <?php foreach ($archive_posts as $post): ?>
                <?php
                    $content = VACTemplate::ACF_featured_content($post->ID);
                    $content['title'] = $post->post_title;
                    $content['permalink'] = get_the_permalink($post->ID);
                    $image = VACTemplate::featured_image($post->ID);
                    $year = get_the_terms($post->ID, 'vac-year');
                    $year = isset($year[0]->name) ? $year[0]->name : '';
                ?>
                <li class="archive-item">
                    <a href="<?php echo $content['permalink']; ?>">
                    <figure class="archive-item__figure">
                        <?php echo VACTemplate::image($image); ?>
                    </figure>

                    <div class="archive-item__header">
                        <h3 class="archive-item__title">
                            <?php echo $content['title']; ?>
                        </h3>
                        <div class="archive-item__standfirst">
                            <?php echo $content['standfirst']; ?>
                        </div>
                    </div>
                    <aside class="archive-item__year">
                        <?php echo $year; ?>
                    </aside>
                    </a>
                </li>
            <?php endforeach; ?>
        </ol>
        <?php else: ?>
            <p class="text__p text__p--big">К сожалению, ничего не показать прямо сейчас.</p>
            <p class="text__p">Sorry, nothing to show right now.</p>
        <?php endif; ?>
    </div>
</div>
