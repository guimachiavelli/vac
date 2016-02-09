<?php
    $search_language = pll_current_language();
    $search_text = $search_language == 'ru' ? 'Поиск' : 'Search';
    $search_url = pll_home_url('en') . $search_language . '/?s=';
?>

<a class="search-link" href="<?php echo $search_url;  ?>">
    <?php echo $search_text; ?>
</a>
