<?php
get_header();

if (category_description()) : // Show an optional category description
	?>
	<div class="archive-meta"><?php echo category_description(); ?></div>
<?php endif; ?>

<?php /* The loop */ ?>
<?php while (have_posts()) : the_post(); ?>
	<?php luna_post_teaser(); ?>
<?php endwhile; ?>

<?php if ($wp_query->max_num_pages > 1) : ?>
	<div class="archiv-nav"><p>
		<?php next_posts_link(__('&larr; Older Posts', 'luna')); ?>
		<?php previous_posts_link(__('Newer Posts &rarr;', 'luna')); ?>
	</p></div>
<?php
endif;

get_footer();
?>
