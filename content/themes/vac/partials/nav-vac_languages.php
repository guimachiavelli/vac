<?php $languages = VACNav::language(); ?>

<nav class="nav-language">
    <ul>
    <?php foreach ($languages as $language): ?>
        <?php if ($language['current_lang'] == true) { continue; } ?>
        <li class="nav-language__item">
            <a class="nav-language__link" href="<?php echo $language['url']; ?>">
                <?php echo $language['name']; ?>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>
</nav>
