<?php
get_header();
global $options;
if (is_active_sidebar('inhaltsinfo-area')) {
	dynamic_sidebar('inhaltsinfo-area');
}
?>

<?php
if (have_posts())
	while (have_posts()) : the_post();
		$custom_fields = get_post_custom();
		?>

		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">


			<?php if (has_post_thumbnail() && !post_password_required() && !is_attachment() && !has_post_format('image') && !has_post_format('gallery')) { ?>
				<div class="post-image">
					<?php the_post_thumbnail(); ?>
				</div>
			<?php } ?>

			<div class="post-entry">
				<?php the_content(); ?>
			</div>
			<?php
			wp_link_pages(array(
				'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'luna') . '</span>',
				'after' => '</div>',
				'link_before' => '<span>',
				'link_after' => '</span>'
			));
			?>

			<?php if (('speaker' != get_post_type()) && ('talk' != get_post_type())) { ?>
				<div class="post-meta">
					<?php if ($options['aktiv-post-sm-buttons'])
						luna_post_socialmedia_icons(); ?>
					<p>
						<?php
						luna_post_pubdateinfo();
						if ($options['aktiv-autoren'])
							luna_post_autorinfo();
						if ((get_the_tag_list()) || (is_object_in_taxonomy(get_post_type(), 'category'))) {
							luna_post_taxonominfo();
						}
						?>
					</p>
				</div>
			<?php } elseif ((('speaker' == get_post_type()) || ('talk' == get_post_type())) && (/*(get_the_tag_list()) ||*/ (is_object_in_taxonomy(get_post_type(), 'category')))) { ?>
				<div class="post-meta">
					<p>
						<?php luna_post_taxonominfo(); ?>
					</p>
				</div>
			<?php } ?>
			<?php edit_post_link(__('Edit', 'luna'), '', ''); ?>
		</div>

		<div class="post-nav">
			<ul>
				<?php
				previous_post_link('<li class="back">&larr; %link</li>', '%title');
				next_post_link('<li class="forward">%link &rarr;</li>', '%title');
				?>
			</ul>
		</div>

		<div class="post-comments" id="comments">
		<?php comments_template('', true); ?>
		</div>

		<div class="post-nav">

				<?php if (has_filter('related_posts_by_category')) { ?>
				<h3><?php _e("Related Articles:", 'luna'); ?></h3>
				<ul class="related">
					<?php
					do_action(
							'related_posts_by_category', array(
						'orderby' => 'post_date',
						'order' => 'DESC',
						'limit' => 5,
						'echo' => true,
						'before' => '<li>',
						'inside' => '',
						'outside' => '',
						'after' => '</li>',
						'rel' => 'follow',
						'type' => 'post',
						'image' => array(1, 1),
						'message' => 'Keine Treffer'
							)
					)
					?>
				</ul>
		<?php } ?>
		</div>

	<?php endwhile; // end of the loop.    ?>

<?php get_footer(); ?>