<?php get_header(); ?>

    <form class="search" method="get" action="<?php echo home_url('/'); ?>">
        <?php $placeholder = pll_current_language() == 'ru' ? 'Поиск' : 'Search'; ?>
        <input type="text" name="s" placeholder="<?php echo $placeholder; ?>" class="search__input" value="<?php echo get_search_query(); ?>">
        <button class="search__button" type="submit">Ok</button>
    </form>


    <div class="column column--single column--search">
        <div class="component">
        <?php if (empty($wp_query->query_vars['s'])): ?>
        <?php elseif (have_posts()): ?>
            <div class="archive">
                <ol class="archive__list">
                <?php while (have_posts()): the_post(); ?>
                    <?php $image = VACTemplate::featured_image($post->ID); ?>
                        <?php
                            $content = VACTemplate::ACF_featured_content($post->ID);
                            $content['title'] = $post->post_title;
                            $content['permalink'] = get_the_permalink($post->ID);
                            $image = VACTemplate::featured_image($post->ID);
                            $year = get_the_terms($post->ID, 'vac-year');
                            $year = isset($year[0]->name) ? $year[0]->name : '';

                            $item_terms = VACTemplate::post_terms($post->ID);
                        ?>
                        <li class="archive-item" data-categories="<?php echo $item_terms; ?>">
                            <a href="<?php echo $content['permalink']; ?>">
                            <figure class="archive-item__figure">
                                <?php echo VACTemplate::image($image); ?>
                                <figcaption class="archive-item__caption">
                                    <?php echo VACTemplate::image_caption($image); ?>
                                </figcaption>
                            </figure>

                            <div class="archive-item__header">
                                <div class="archive-item__header-spacing">
                                    <h3 class="archive-item__title">
                                        <?php echo $content['title']; ?>
                                    </h3>
                                    <div class="archive-item__standfirst">
                                        <?php echo $content['standfirst']; ?>
                                    </div>
                                </div>
                            </div>
                            <aside class="archive-item__year">
                                <?php echo $year; ?>
                            </aside>
                            </a>
                        </li>
                <?php endwhile; ?>
                </ol>
        <?php else: ?>
            no results found
        <?php endif; ?>
        </div>
    </div>

<?php get_footer(); ?>
