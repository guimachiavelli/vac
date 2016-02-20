<?php
    //XXX: sorry future self, very ugly code
    $default_language = pll_default_language();
    $current_language = pll_current_language();
    $search_language = $current_language != $default_language ?
                                            $current_language  :
                                            '';
    $search_text = $search_language == 'ru' ? 'Поиск' : 'Search';
    $search_url = pll_home_url($default_language) . $search_language;
    $search_url .= $search_language == '' ? '?s=' : '/?s=';
?>

<a class="search-link" href="<?php echo $search_url;  ?>">
    <?php echo $search_text; ?>
</a>
