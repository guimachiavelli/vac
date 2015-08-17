<?php $languages = VACNav::language(); ?>


<ul>
<?php foreach ($languages as $language): ?>
    <?php if ($language['current_lang'] == true) { continue; } ?>
    <li>
        <a href="<?php echo $language['url']; ?>"><?php echo $language['name']; ?></a>
    </li>
<?php endforeach; ?>
</ul>
