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
        <ol class="archive__list">
            <?php
                $posts = get_posts(array(
                    'posts_per_page' => 100,
                    'post_type' => $post_type
                ));
            ?>

            <?php foreach ($posts as $post): ?>
                <?php
                    $content = VACTemplate::ACF_featured_content($post->ID);
                    $content['title'] = $post->post_title;
                    $content['permalink'] = get_the_permalink($post->ID);
                    $image = $content['image'];
                ?>
                <li class="archive-item">
                    <a href="<?php echo $content['permalink']; ?>">
                    <div class="archive-item__header">
                        <h3 class="archive-item__title"><?php echo $content['title']; ?></h3>
                        <div class="archive-item__standfirst"><?php echo $content['standfirst']; ?></div>
                    </div>
                    <figure>
                        <?php echo VACTemplate::image($image['id']); ?>
                    </figure>
                    </a>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>
