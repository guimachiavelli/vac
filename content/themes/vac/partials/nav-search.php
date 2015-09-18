<?php
    $placeholder = pll_current_language() == 'ru' ? 'Поиск' : 'Search';
?>

<form class="search search--small" method="get" action="<?php echo home_url( '/' ); ?>">
    <input type="text" name="s" placeholder="<?php echo $placeholder; ?>" class="search__input">
</form>
