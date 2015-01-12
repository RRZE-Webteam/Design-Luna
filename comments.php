<?php
global $defaultoptions;
global $options;

if (post_password_required()) :
	?>
	<p><?php _e("This article is password proteced. Please enter the password to view the comments.", 'luna'); ?></p>
	<?php
	return;
endif;
if (have_comments()) :
	?>
	<h2 id="comments-title"><?php _e("Comments", 'luna'); ?></h2>
	<p>
		<?php printf(_n('One Comment about %2$s', '%1$s Comments about %2$s', get_comments_number(), 'luna'), number_format_i18n(get_comments_number()), '&quot;' . get_the_title() . '&quot;'); ?>
	</p>
	<?php
	// Are there comments to navigate through?
	if (get_comment_pages_count() > 1 && get_option('page_comments')) :
		?>
		<div class="comment-nav" role="navigation">
			<h3 class="sr-only"><?php _e('Comment navigation', 'luna'); ?></h3>
			<ul>
				<li class="back"><?php previous_comments_link(__('&larr; Older Comments', 'luna')); ?></li>
				<li class="forward"><?php next_comments_link(__('Newer Comments &rarr;', 'luna')); ?></li>
			</ul>
		</div><!-- .comment-nav -->
	<?php endif; // Check for comment navigation ?>

	<?php if (!comments_open() && get_comments_number()) : ?>
		<p class="no-comments"><?php _e('Comments are closed.', 'luna'); ?></p>
		<?php
	endif;
	?>
	<ol>
		<?php wp_list_comments(array('callback' => 'luna_comment')); ?>
	</ol>

	<?php
	// Are there comments to navigate through?
	if (get_comment_pages_count() > 1 && get_option('page_comments')) :
		?>
		<div class="comment-nav" role="navigation">
			<h3 class="sr-only"><?php _e('Comment navigation', 'luna'); ?></h3>
			<ul>
				<li class="back"><?php previous_comments_link(__('&larr; Older Comments', 'luna')); ?></li>
				<li class="forward"><?php next_comments_link(__('Newer Comments &rarr;', 'luna')); ?></li>
			</ul>
		</div><!-- .comment-nav -->
	<?php
	endif; // Check for comment navigation

endif;

$comment_before = '';
if (isset($options['comments_disclaimer'])) {
	$comment_before = '<div class="comment-disclaimer">' . $options['comments_disclaimer'] . '</div>';
}


if (isset($options['anonymize-user']) && ($options['anonymize-user'] == 1)) {
	// Emailadresse kann/soll weggelassen werden

	if ($options['anonymize-user-commententries'] == 1) {
		// Nur Autorname
		$comments_args = array('fields' => array(
				'author' => '<p class="comment-form-author">' . '<label for="author">' . __('Name', 'luna') . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
				'<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>'
			),
			'comment_notes_before' => $comment_before,
		);
		comment_form($comments_args);
	} elseif ($options['anonymize-user-commententries'] == 2) {
		// Name + URL
		$comments_args = array('fields' => array(
				'author' => '<p class="comment-form-author">' . '<label for="author">' . __('Name', 'luna') . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
				'<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>',
				'url' => '<p class="comment-form-url"><label for="url">' . __('Website', 'luna') . '</label>' .
				'<input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></p>'
			),
			'comment_notes_before' => $comment_before,
		);
		comment_form($comments_args);
	} else {
		// WP-Default (Name+Email+URL)

		$comment_before = $comments_before . $defaultoptions['default_comment_notes_before'];
		comment_form(array('comment_notes_before' => $comment_before));
	}
} else {

	$comment_before = $comment_before . $defaultoptions['default_comment_notes_before'];
	comment_form(array('comment_notes_before' => $comment_before));
}
?>

