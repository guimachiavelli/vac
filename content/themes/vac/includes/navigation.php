<?php

class VACNav {

    public static function language() {
        if (!function_exists('pll_the_languages')) {
            return;
        }

        return pll_the_languages(array('raw' => true));
    }


}
