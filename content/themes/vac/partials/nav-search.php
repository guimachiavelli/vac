<?php
    $search_text = pll_current_language() == 'ru' ? 'Поиск' : 'Search';
?>

<a class="search-link" href="<?php echo get_bloginfo('url');  ?>/?s=">
    <?php echo $search_text; ?>
</a>
