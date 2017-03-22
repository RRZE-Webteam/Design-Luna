<div id="suche">
    <h2><a name="suche"><?php _e("Search", 'luna'); ?></a></h2>
    <form method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
        <p>
            <label for="suchbegriff"><?php _e("Search:", 'luna'); ?></label>
            <input id="s" name="s" type="text" value="<?php the_search_query(); ?>" placeholder="<?php _e("Search for...",'luna'); ?>">
            <input type="submit" value="<?php _e("Find", 'luna'); ?>">
        </p>
    </form>
</div>