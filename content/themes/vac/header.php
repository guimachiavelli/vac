<!doctype html>
<html lang="<?php echo pll_current_language(); ?>">
	<head>
		<meta charset="utf-8">

        <title><?php bloginfo('title'); ?></title>
		<meta name="description" content="">

		<meta name="viewport" content="width=device-width">

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

        <header class="header">
            <h1 class="logo">
                <a class="logo__link" href="<?php echo get_bloginfo('url');  ?>">
                    <b class="logo__letter">V</b>
                    <b class="logo__dash logo__dash--long">-</b>
                    <b class="logo__letter">A</b>
                    <b class="logo__dash">-</b>
                    <b class="logo__letter">C</b>
                </a>
            </h1>

            <?php get_template_part('partials/nav', 'vac_primary'); ?>
            <?php get_template_part('partials/nav', 'vac_languages'); ?>
        </header>
