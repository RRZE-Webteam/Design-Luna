<?php
get_header();
global $options;

if (is_active_sidebar('inhaltsinfo-area')) {
	dynamic_sidebar('inhaltsinfo-area');
}

$i = 0;
$col = 0;

$numentries = $options['num-article-startpage-fullwidth'] + $options['num-article-startpage-halfwidth'];
$col_count = 3;
$cols = array();
while (have_posts() && $i < $numentries) : the_post();
	$i++;
	ob_start();
	if (( isset($options['num-article-startpage-fullwidth'])) && ($options['num-article-startpage-fullwidth'] >= $i )) {
		luna_post_teaser($options['teaser-datebox'], $options['teaser-dateline'], $options['teaser_maxlength'], $options['teaser-thumbnail_fallback'], $options['teaser-floating']);
	} else {
		luna_post_teaser($options['teaser-datebox-halfwidth'], $options['teaser-dateline-halfwidth'], $options['teaser-maxlength-halfwidth'], $options['teaser-thumbnail_fallback'], $options['teaser-floating-halfwidth']);
	}
	$output = ob_get_contents();
	ob_end_clean();
	if (isset($output)) {
		$cols[$col++] = $output;
	}
endwhile;
?>
<div class="columns">
	<?php
	$z = 1;
	foreach ($cols as $key => $col) {
		if (( isset($options['num-article-startpage-fullwidth'])) && ($options['num-article-startpage-fullwidth'] > $key )) {
			echo $col;
		} else {
			if (( isset($options['num-article-startpage-fullwidth'])) && ($options['num-article-startpage-fullwidth'] == $key ) && ($options['num-article-startpage-fullwidth'] > 0 )) {

			}
			echo '<div class="column' . $z . '">' . $col . '</div>';
			$z++;
			if ($z > 2) {
				$z = 1;
			}
		}
	}
	?>
</div>


<?php if (!have_posts()) : ?>
	<h2><?php _e("Nothing found", 'luna'); ?></h2>
	<p>
	<?php _e("Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.", 'luna'); ?>
	</p>
		<?php get_search_form(); ?>
	<hr>
<?php endif; ?>



<?php get_footer(); ?>