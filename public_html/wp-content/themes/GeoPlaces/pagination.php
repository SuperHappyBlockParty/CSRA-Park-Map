<?php if (!templ_is_ajax_pagination()) : ?>
    <div class="pagination">
        <?php if (function_exists('wp_pagenavi')) wp_pagenavi(); ?>
    </div>
    <?php else : ?>
    <div id="pagination"><?php next_posts_link(__('LOAD MORE','templatic')); ?></div>
<?php endif; ?>