	<?php wp_footer(); ?>

    <footer class="footer">
    <?php
        $footer_id = VACHelpers::translated_page_id_from_slug('footer');
        $footer_content = get_field('vac_block_text_single', $footer_id);
        echo $footer_content;
    ?>
    </footer>

	</body>
</html>
