<?php
    $vac_content = VACTemplate::ACF_content($wp_query);
    $post_type = VACTemplate::post_type_from_wp_query($wp_query);
?>

<div>
    <h3><?php echo $vac_content; ?></h3>
    <ol>
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
                <li>
                    <a href="<?php echo $content['permalink']; ?>">
                    <h3><?php echo $content['title']; ?></h3>
                    <div><?php echo $content['standfirst']; ?></div>
                    <figure>
                        <img src="<?php echo VACTemplate::image_src($image['id']); ?>"
                             alt="<?php $image['alt'] ?>">
                    </figure>
                    </a>
                </li>
        <?php endforeach; ?>
    </ol>
</div>
