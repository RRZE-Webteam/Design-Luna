<?php
/**
 * Event Theme Optionen
 *
 * @source http://github.com/RRZE-Webteam/WKE2014
 * @licence GPL
 */

load_theme_textdomain('luna', get_template_directory() . '/languages');

require( get_template_directory() . '/inc/constants.php' );
$options = get_option('luna_theme_options');
$options = luna_compatibility($options);

// ** bw 2012-08-12 wordpress reverse proxy x-forwarded-for ip fix ** //
if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$xffaddrs = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
	$_SERVER['REMOTE_ADDR'] = $xffaddrs[0];
}



if (!isset($content_width))
	$content_width = $defaultoptions['content-width'];
require_once ( get_template_directory() . '/theme-options.php' );

add_action('after_setup_theme', 'luna_setup');

if (!function_exists('luna_setup')):

	function luna_setup() {
		global $defaultoptions;
		global $options;
		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();
		// This theme uses post thumbnails
		add_theme_support('post-thumbnails');
		// Add default posts and comments RSS feed links to head
		add_theme_support('automatic-feed-links');

		$args = array(
			'width' => 1200,
			'height' => 223,
			'default-image' => get_template_directory_uri() . '/images/header-bg.jpg',
			'uploads' => true,
			'random-default' => false,
			'flex-height' => false,
			'flex-width' => false,
			'header-text' => true,
			'default-text-color' => '#fff',
		);
		add_theme_support('custom-header', $args);

		$args = array(
			'default-color' => $defaultoptions['background-header-color'],
			'default-image' => $defaultoptions['background-header-image'],
			'background_repeat' => 'repeat-x',
			'background_position_x' => 'left',
			'background_position_y' => 'bottom',
			'wp-head-callback' => 'luna_custom_background_cb',
		);

		/**
		 * luna custom background callback.
		 *
		 */
		function luna_custom_background_cb() {
			global $defaultoptions;
			global $options;
			// $background is the saved custom image, or the default image.
			$background = set_url_scheme(get_background_image());

			// $color is the saved custom color.
			// A default has to be specified in style.css. It will not be printed here.
			$color = get_theme_mod('background_color');

			if (!$background && !$color)
				return;

			$style = $color ? "background-color: #$color;" : '';

			if ($background) {
				$image = " background-image: url('$background');";

				$repeat = get_theme_mod('background_repeat', 'repeat-x');
				if (!in_array($repeat, array('no-repeat', 'repeat-x', 'repeat-y', 'repeat')))
					$repeat = 'repeat-x';
				$repeat = " background-repeat: $repeat;";

				$positionx = get_theme_mod('background_position_x', 'left');
				if (!in_array($positionx, array('center', 'right', 'left')))
					$positionx = 'left';
				$positiony = get_theme_mod('background_position_y', 'bottom');
				if (!in_array($positiony, array('top', 'bottom')))
					$positiony = 'bottom';

				$position = " background-position: $positionx $positiony;";

				$attachment = get_theme_mod('background_attachment', 'scroll');
				if (!in_array($attachment, array('fixed', 'scroll')))
					$attachment = 'scroll';
				$attachment = " background-attachment: $attachment;";

				$style .= $image . $repeat . $position . $attachment;
			}


			echo '<style type="text/css" id="custom-background-css">';
			echo '.header { ' . trim($style) . ' } ';
			echo '</style>';
		}

		add_theme_support('custom-background', $args);

		if (function_exists('add_theme_support')) {
			add_theme_support('post-thumbnails');
			set_post_thumbnail_size(150, 150); // default Post Thumbnail dimensions
		}

		if (function_exists('add_image_size')) {
			add_image_size('teaser-thumb', $options['teaser-thumbnail_width'], $options['teaser-thumbnail_height'], $options['teaser-thumbnail_crop']); //300 pixels wide (and unlimited height)
		}


		// Make theme available for translation
		// Translations can be filed in the /languages/ directory
		load_theme_textdomain('luna', get_template_directory() . '/languages');
		$locale = get_locale();
		$locale_file = get_template_directory() . "/languages/$locale.php";
		if (is_readable($locale_file))
			require_once( $locale_file );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
			'primary' => __('Main Menu', 'luna'),
			'targetmenu' => __('Target Menu', 'luna'),
			'tecmenu' => __('Tech Menu (Contact, Imprint etc.)', 'luna'),
		));


		if ($options['login_errors'] == 0) {
			/** Abschalten von Fehlermeldungen auf der Loginseite */
			add_filter('login_errors', create_function('$a', "return null;"));
		}
		/** Entfernen der Wordpressversionsnr im Header */
		remove_action('wp_head', 'wp_generator');

		/* Zulassen von Shortcodes in Widgets */
		add_filter('widget_text', 'do_shortcode');


		if ($options['yt-alternativeembed']) {
			/* Filter fuer YouTube Embed mit nocookie: */
			#    wp_oembed_remove_provider( '#https://(www\.)?youtube.com/watch.*#i' );
			wp_embed_register_handler('ytnocookie', '#https?://www\.youtube\-nocookie\.com/embed/([a-z0-9\-]+)#i', 'wp_embed_handler_ytnocookie');
			wp_embed_register_handler('ytnormal', '#https?://www\.youtube\.com/watch\?v=([a-z0-9\-]+)#i', 'wp_embed_handler_ytnocookie');
			wp_embed_register_handler('ytnormal2', '#https?://www\.youtube\.com/watch\?feature=player_embedded&v=([a-z0-9\-]+)#i', 'wp_embed_handler_ytnocookie');
		}

		function wp_embed_handler_ytnocookie($matches, $attr, $url, $rawattr) {
			global $defaultoptions;
			$relvideo = '';
			if ($defaultoptions['yt-norel'] == 1) {
				$relvideo = '?rel=0';
			}
			$embed = sprintf(
					'<div class="embed-youtube"><p><img src="%1$s/images/social-media/youtube-24x24.png" width="24" height="24" alt="">YouTube-Video: <a href="https://www.youtube.com/watch?v=%2$s">https://www.youtube.com/watch?v=%2$s</a></p><iframe src="https://www.youtube-nocookie.com/embed/%2$s%5$s" width="%3$spx" height="%4$spx" frameborder="0" scrolling="no" marginwidth="0" marginheight="0"></iframe></div>', get_template_directory_uri(), esc_attr($matches[1]), $defaultoptions['yt-content-width'], $defaultoptions['yt-content-height'], $relvideo
			);

			return apply_filters('embed_ytnocookie', $embed, $matches, $attr, $url, $rawattr);
		}

		require( get_template_directory() . '/inc/custom-post-types.php' );

		if (is_singular())
			wp_enqueue_script("comment-reply");
	}

endif;

require( get_template_directory() . '/inc/widgets.php' );



/* Refuse spam-comments on media */

function filter_media_comment_status($open, $post_id) {
	$post = get_post($post_id);
	if ($post->post_type == 'attachment') {
		return false;
	}
	return $open;
}

add_filter('comments_open', 'filter_media_comment_status', 10, 2);

function luna_compatibility($oldoptions) {
	global $defaultoptions;

	if (!is_array($oldoptions)) {
		$oldoptions = array();
	}
	$newoptions = array_merge($defaultoptions, $oldoptions);


	return $newoptions;
}

if (!function_exists('get_luna_options')) :
	/*
	 * Erstes Bild aus einem Artikel auslesen, wenn dies vorhanden ist
	 */

	function get_luna_options($field) {
		global $defaultoptions;
		if (!isset($field)) {
			$field = 'luna_theme_options';
		}
		$orig = get_option($field);
		if (!is_array($orig)) {
			$orig = array();
		}
		$alloptions = array_merge($defaultoptions, $orig);
		return $alloptions;
	}

endif;



/*
 * Adds optional styles in header
 */
add_action('wp_enqueue_scripts', function() {
	global $options;
	global $defaultoptions;

	$theme = wp_get_theme();
	wp_register_style('luna', get_stylesheet_uri(), array(), $theme['Version']);
	wp_enqueue_style('luna');

	// enqueue scripts and styles, but only if is_admin
});

function luna_admin_style() {

	wp_register_style('themeadminstyle', get_template_directory_uri() . '/css/admin.css');
	wp_enqueue_style('themeadminstyle');
	wp_enqueue_media();
	wp_register_script('themeadminscripts', get_template_directory_uri() . '/js/admin.js', array('jquery'));
	wp_enqueue_script('themeadminscripts');

	if (is_admin()) {
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('wp-link');
	}
}

add_action('admin_enqueue_scripts', 'luna_admin_style');


/* Format list for Tagclouds also in widgets */

function edit_args_tag_cloud_widget($args) {
	$args = array('format' => 'list');
	return $args;
}

add_filter('widget_tag_cloud_args', 'edit_args_tag_cloud_widget');

/*
 * Breadcrumb
 */

function luna_breadcrumbs() {
	global $defaultoptions;
	global $options;
	$delimiter = '<img width="20" height="9" alt=" &raquo; " src="' . $defaultoptions['src-breadcrumb-image'] . '">';
	$home = $options['text-startseite']; // text for the 'Home' link
	$before = '<span class="current">'; // tag before the current crumb
	$after = '</span>'; // tag after the current crumb

	if (!is_home() && !is_front_page() || is_paged()) {
		global $post;
		$homeLink = home_url('/');
		echo '<div id="breadcrumb">
			<h2>Sie befinden sich hier: </h2>
				<p>
					<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

		if (is_category()) {
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$thisCat = $cat_obj->term_id;
			$thisCat = get_category($thisCat);
			$parentCat = get_category($thisCat->parent);
			if ($thisCat->parent != 0)
				echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
			echo $before . __('Articles of Category ', 'luna') . '"' . single_cat_title('', false) . '"' . $after;
		} elseif (is_day()) {
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('d') . $after;
		} elseif (is_month()) {
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('F') . $after;
		} elseif (is_year()) {
			echo $before . get_the_time('Y') . $after;
		} elseif (is_single() && !is_attachment()) {
			if (get_post_type() != 'post') {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
				echo $before . get_the_title() . $after;
			} else {
				$cat = get_the_category();
				$cat = $cat[0];
				echo is_wp_error($cat_parents = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ')) ? '' : $cat_parents;
				echo $before . get_the_title() . $after;
			}
		} elseif (!is_single() && !is_page() && !is_search() && get_post_type() != 'post' && !is_404()) {
			if ('event' == get_post_type()) {
				echo $before . $options['label-event-pl'] . $after;
			} elseif ('speaker' == get_post_type()) {
				echo $before . $options['label-speaker-pl'] . $after;
			} else {
				$post_type = get_post_type_object(get_post_type());
				echo $before . $post_type->labels->singular_name . $after;
			}
		} elseif (is_attachment()) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID);
			$cat = $cat[0];
			echo is_wp_error($cat_parents = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ')) ? '' : $cat_parents;
			echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;
		} elseif (is_page() && !$post->post_parent) {
			echo $before . get_the_title() . $after;
		} elseif (is_page() && $post->post_parent) {
			$parent_id = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			foreach ($breadcrumbs as $crumb)
				echo $crumb . ' ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;
		} elseif (is_search()) {
			echo $before . __('Search for ', 'luna') . '"' . get_search_query() . '"' . $after;
		} elseif (is_tag()) {
			echo $before . __('Articles tagged ', 'luna') . '"' . single_tag_title('', false) . '"' . $after;
		} elseif (is_author()) {
			global $author;
			$userdata = get_userdata($author);
			echo $before . __('Articles by ', 'luna') . $userdata->display_name . $after;
		} elseif (is_404()) {
			echo $before . '404' . $after;
		}
	}
	echo "</p></div>";
}

function luna_contenttitle() {
	global $defaultoptions;
	global $options;
	$before = '';
	$after = '';
	$delimiter = ': ';
	$home = $options['text-startseite']; // text for the 'Home' link

	if (!is_home() && !is_front_page() || is_paged()) {
		global $post;
		global $options;
		$homeLink = home_url('/');

		if (is_category()) {
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$thisCat = $cat_obj->term_id;
			$thisCat = get_category($thisCat);
			$parentCat = get_category($thisCat->parent);
			if ($thisCat->parent != 0)
				echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
			echo $before . __('Articles of Category ', 'luna') . '"' . single_cat_title('', false) . '"' . $after;
		} elseif (is_day()) {
			echo $before . get_the_time('d') . $after;
		} elseif (is_month()) {
			echo $before . get_the_time('F') . $after;
		} elseif (is_year()) {
			echo $before . get_the_time('Y') . $after;
		} elseif (is_single() && !is_attachment()) {
			echo $before . get_the_title() . $after;
		} elseif (!is_single() && !is_page() && !is_search() && get_post_type() != 'post' && !is_404()) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;
		} elseif (is_attachment()) {
			echo $before . get_the_title() . $after;
		} elseif (is_page() && !$post->post_parent) {
			echo $before . get_the_title() . $after;
		} elseif (is_page() && $post->post_parent) {
			echo $before . get_the_title() . $after;
		} elseif (is_search()) {
			echo $before . __('Search for ', 'luna') . '"' . get_search_query() . '"' . $after;
		} elseif (is_tag()) {
			echo $before . __('Articles tagged ', 'luna') . '"' . single_tag_title('', false) . '"' . $after;
		} elseif (is_author()) {
			global $author;
			$userdata = get_userdata($author);
			echo $before . __('Articles by ', 'luna') . $userdata->display_name . $after;
		} elseif (is_404()) {
			echo $before . '404' . $after;
		} else {
			echo $before . get_the_title() . $after;
		}
	} elseif (is_front_page()) {
		echo $before . $home . $after;
	} elseif (is_home()) {
		echo $before . get_the_title(get_option('page_for_posts')) . $after;
	}
}

if (!function_exists('luna_filter_wp_title')) :
	/*
	 * Sets the title
	 */

	function luna_filter_wp_title($title, $separator) {
		// Don't affect wp_title() calls in feeds.
		if (is_feed())
			return $title;

		// The $paged global variable contains the page number of a listing of posts.
		// The $page global variable contains the page number of a single post that is paged.
		// We'll display whichever one applies, if we're not looking at the first page.
		global $paged, $page;

		if (is_search()) {
			// If we're a search, let's start over:
			$title = sprintf(__('Search Results for %s', 'luna'), '"' . get_search_query() . '"');
			// Add a page number if we're on page 2 or more:
			if ($paged >= 2)
				$title .= " $separator " . sprintf(__('Page %s', 'luna'), $paged);
			// Add the site name to the end:
			$title .= " $separator " . get_bloginfo('name', 'display');
			// We're done. Let's send the new title back to wp_title():
			return $title;
		}

		// Otherwise, let's start by adding the site name to the end:
		$title .= get_bloginfo('name', 'display');

		// If we have a site description and we're on the home/front page, add the description:
		$site_description = get_bloginfo('description', 'display');
		if ($site_description && ( is_home() || is_front_page() ))
			$title .= " $separator " . $site_description;

		// Add a page number if necessary:
		if ($paged >= 2 || $page >= 2)
			$title .= " $separator " . sprintf(__('Page %s', 'luna'), max($paged, $page));

		// Return the new title to wp_title():
		return $title;
	}

endif;
add_filter('wp_title', 'luna_filter_wp_title', 10, 2);

function luna_excerpt_length($length) {
	global $defaultoptions;
	return $defaultoptions['teaser_maxlength'];
}

add_filter('excerpt_length', 'luna_excerpt_length');

function luna_continue_reading_link() {
	return ' <a class="nobr more-link" title="Weiterlesen:' . strip_tags(get_the_title()) . '" href="' . get_permalink() . '"> &#10097;&#10097;</a>';
}

function luna_auto_excerpt_more($more) {
	return ' &hellip;' . luna_continue_reading_link();
}

add_filter('excerpt_more', 'luna_auto_excerpt_more');

function luna_custom_excerpt_more($output) {
	if (has_excerpt() && !is_attachment()) {
		$output .= luna_continue_reading_link();
	}
	return $output;
}

add_filter('get_the_excerpt', 'luna_custom_excerpt_more');

function luna_remove_gallery_css($css) {
	return preg_replace("#<style type='text/css'>(.*?)</style>#s", '', $css);
}

add_filter('gallery_style', 'luna_remove_gallery_css');


if (!function_exists('luna_comment')) :

	/**
	 * Template for comments and pingbacks.
	 */
	function luna_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		global $defaultoptions;
		global $options;

		switch ($comment->comment_type) :
			case '' :
				?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<div id="comment-<?php comment_ID(); ?>">

						<div class="comment-details">
							<span class="comment-author vcard">
				<?php printf(__('%s <span class="says">says on</span>', 'luna'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link())); ?>
							</span><!-- .comment-author .vcard -->

				<?php if ($comment->comment_approved == '0') : ?>
								<em><?php _e('Comment is waiting for moderation.', 'luna'); ?></em>
								<br />
				<?php endif; ?>

							<span class="comment-meta">
								<a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
									<?php
									/* translators: 1: date, 2: time */
									printf(__('%1$s at %2$s', 'luna'), get_comment_date(), get_comment_time());
									?></a> folgendes:<?php edit_comment_link(__('Edit', 'luna'), ' ');
				?>
							</span><!-- .comment-meta .commentmetadata -->
						</div>

						<div class="comment-body"><?php comment_text(); ?></div>
							<?php if ($options['aktiv-commentreplylink']) { ?>
							<div class="reply">
							<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
							</div> <!-- .reply -->
				<?php } ?>

					</div><!-- #comment-##  -->

					<?php
					break;
				case 'pingback' :
				case 'trackback' :
					?>
				<li class="post pingback">
					<p><?php _e('Pingback:', 'luna'); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('(Edit)', 'luna'), ' '); ?></p>
					<?php
					break;
			endswitch;
		}

	endif;

	function luna_remove_recent_comments_style() {
		global $wp_widget_factory;
		remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
	}

	add_action('widgets_init', 'luna_remove_recent_comments_style');


	if (!function_exists('luna_post_teaser')) :

		/**
		 * Erstellung eines Artikelteasers
		 */
		function luna_post_teaser($showdatebox = 1, $showdateline = 0, $teaserlength = 200, $thumbfallback = 1, $usefloating = 0) {
			global $options;
			global $post;

			$sizeclass = '';
			$leftbox = '';
			if ($showdatebox == 0) {
				$showdatebox = 1;
			}
			if ($showdatebox != 5) {

// Generate Thumb/Pic or Video first to find out which class we need

				$leftbox .= '<div class="post-image">';
				$sizeclass = 'withthumb';
				$thumbnailcode = '';
				$firstpic = '';
				$firstvideo = '';
				if (has_post_thumbnail()) {
					$thumbnailcode = get_the_post_thumbnail($post->ID, 'teaser-thumb');
				}

				$firstpic = get_luna_firstpicture();
				$firstvideo = get_luna_firstvideo();
				$fallbackimg = '<img src="' . $options['src-teaser-thumbnail_default'] . '" alt="">';
				$output = '';
				if ($showdatebox == 1) {
					if ((isset($thumbnailcode)) && (strlen(trim($thumbnailcode)) > 10)) {
						$output = $thumbnailcode;
					} elseif ((isset($firstpic)) && (strlen(trim($firstpic)) > 10)) {
						$output = $firstpic;
					} elseif ((isset($firstvideo)) && (strlen(trim($firstvideo)) > 10)) {
						$output = $firstvideo;
						$sizeclass = 'withvideo';
					} else {
						$output = $fallbackimg;
					}
				} elseif ($showdatebox == 2) {

					if ((isset($firstpic)) && (strlen(trim($firstpic)) > 10)) {
						$output = $firstpic;
					} elseif ((isset($thumbnailcode)) && (strlen(trim($thumbnailcode)) > 10)) {
						$output = $thumbnailcode;
					} elseif ((isset($firstvideo)) && (strlen(trim($firstvideo)) > 10)) {
						$output = $firstvideo;
						$sizeclass = 'withvideo';
					} else {
						$output = $fallbackimg;
					}
				} elseif ($showdatebox == 3) {
					if ((isset($firstvideo)) && (strlen(trim($firstvideo)) > 10)) {
						$output = $firstvideo;
						$sizeclass = 'withvideo';
					} elseif ((isset($thumbnailcode)) && (strlen(trim($thumbnailcode)) > 10)) {
						$output = $thumbnailcode;
					} elseif ((isset($firstpic)) && (strlen(trim($firstpic)) > 10)) {
						$output = $firstpic;
					} else {
						$output = $fallbackimg;
					}
				} elseif ($showdatebox == 4) {
					if ((isset($firstvideo)) && (strlen(trim($firstvideo)) > 10)) {
						$output = $firstvideo;
						$sizeclass = 'withvideo';
					} elseif ((isset($firstpic)) && (strlen(trim($firstpic)) > 10)) {
						$output = $firstpic;
					} elseif ((isset($thumbnailcode)) && (strlen(trim($thumbnailcode)) > 10)) {
						$output = $thumbnailcode;
					} else {
						$output = $fallbackimg;
					}
				} else {
					$output = $fallbackimg;
				}

				$leftbox .= $output;
				$leftbox .= '</div>';
			} else {
				$sizeclass = '';
			}
			if ($usefloating == 1) {
				$sizeclass .= " usefloating";
			}
			?>
			<div <?php post_class($sizeclass); ?> id="post-<?php the_ID(); ?>" >

				<div class="post-title">
					<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
						<?php the_title(); ?>
					</a></h2>
				</div><!-- post-title -->

				<div class="post-content">

					<?php
					/*
					 * 1 = Thumbnail (or: first picture, first video, fallback picture),
					 * 2 = First picture (or: thumbnail, first video, fallback picture),
					 * 3 = First video (or: thumbnail, first picture, fallback picture),
					 * 4 = First video (or: first picture, thumbnail, fallback picture),
					 * 5 = Nothing */

					if ($showdatebox < 5) {
						echo $leftbox;
					} ?>

					<div class="post-entry">
						<?php if ($showdateline == 1) { ?>
							<p class="pubdateinfo"><?php luna_post_pubdateinfo(0); ?></p>
		<?php } ?>
		<?php echo get_luna_custom_excerpt($teaserlength); ?>
					</div><!-- post-entry -->

				</div><!-- post-content -->
			</div><!-- post -->

		<?php
		}

	endif;


	if (!function_exists('luna_post_pubdateinfo')) :

		/**
		 * Fusszeile unter Artikeln: Ver&ouml;ffentlichungsdatum
		 */
		function luna_post_pubdateinfo($withtext = 1) {
			if ($withtext == 1) {
				echo '<span class="meta-prep">';
				echo __('Published ', 'luna');
				echo '</span> ';
			}
			printf('%1$s', sprintf('<span class="entry-date">%1$s</span>', get_the_date()
					)
			);
		}

	endif;

	if (!function_exists('luna_post_autorinfo')) :

		/**
		 * Fusszeile unter Artikeln: Autorinfo
		 */
		function luna_post_autorinfo() {
			printf(__(' <span class="meta-prep-author">by</span> %1$s ', 'luna'), sprintf('<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span> ', get_author_posts_url(get_the_author_meta('ID')), sprintf(esc_attr__('Article by %s', 'luna'), get_the_author()), get_the_author()
					)
			);
		}

	endif;

	/**
	 * Fusszeile unter Artikeln: Taxonomie
	 */
	function luna_post_taxonominfo() {
		$tag_list = get_the_tag_list('', ', ');
		if ($tag_list) {
			$posted_in = __('<br> Categories: %1$s <br>Tags: %2$s', 'luna');
		} elseif (is_object_in_taxonomy(get_post_type(), 'category')) {
			$posted_in = __(' about %1$s.', 'luna');
		} else {
			$posted_in = '';
		}
		// Prints the string, replacing the placeholders.
		printf(
				$posted_in, get_the_category_list(', '), $tag_list, the_title_attribute('echo=0')
		);
	}

	/**
	 * Fusszeile unter Custom Post Types: Taxonomie
	 */
	function luna_cpt_taxonominfo() {
		global $post;
		$category = get_post_type() . "_category";
		if (get_the_terms($post->ID, $category)) {
			echo "<div class='post-meta'>\n<p>";
			the_terms($post->ID, $category, __('Categories: ', 'luna'), ', ');
			echo "</p>\n</div>";
		}
	}

// this function initializes the iframe elements
// maybe wont work on multisite installations. please use plugins instead.
	function luna_change_mce_options($initArray) {
		$ext = 'iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src]';
		if (isset($initArray['extended_valid_elements'])) {
			$initArray['extended_valid_elements'] .= ',' . $ext;
		} else {
			$initArray['extended_valid_elements'] = $ext;
		}
		// maybe; set tiny paramter verify_html
		$initArray['verify_html'] = false;
		return $initArray;
	}

	add_filter('tiny_mce_before_init', 'luna_change_mce_options');


	if (!function_exists('get_luna_firstpicture')) :
		/*
		 * Erstes Bild aus einem Artikel auslesen, wenn dies vorhanden ist
		 */

		function get_luna_firstpicture() {
			global $post;
			$first_img = '';
			ob_start();
			ob_end_clean();
			$matches = array();
			preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
			if ((is_array($matches)) && (isset($matches[1]))) {
				$first_img = $matches[1];
				if (!empty($first_img)) {
					$site_link = home_url();
					$first_img = preg_replace("%$site_link%i", '', $first_img);
					$imagehtml = '<img src="' . $first_img . '" alt="" >';
					return $imagehtml;
				}
			}
		}

	endif;


	if (!function_exists('get_luna_firstvideo')) :
		/*
		 * Erstes Bild aus einem Artikel auslesen, wenn dies vorhanden ist
		 */

		function get_luna_firstvideo($width = 300, $height = 169, $nocookie = 1, $searchplain = 1) {
			global $post;
			ob_start();
			ob_end_clean();
			$matches = array();
			preg_match('/src="([^\'"]*www\.youtube[^\'"]+)/i', $post->post_content, $matches);
			if ((is_array($matches)) && (isset($matches[1]))) {
				$entry = $matches[1];
				if (!empty($entry)) {
					if ($nocookie == 1) {
						$entry = preg_replace('/youtube.com\/watch\?v=/', 'youtube-nocookie.com/embed/', $entry);
					}
					$htmlout = '<iframe width="' . $width . '" height="' . $height . '" src="' . $entry . '" allowfullscreen></iframe>';
					return $htmlout;
				}
			}
			// Schau noch nach YouTube-URLs die Plain im text sind. Hilfreich fuer
			// Installationen auf Multisite ohne iFrame-Unterstützung
			if ($searchplain == 1) {
				preg_match('/\b(https?:\/\/www\.youtube[\/a-z0-9\.\-\?=]+)/i', $post->post_content, $matches);
				if ((is_array($matches)) && (isset($matches[1]))) {
					$entry = $matches[1];
					if (!empty($entry)) {
						if ($nocookie == 1) {
							$entry = preg_replace('/youtube.com\/watch\?v=/', 'youtube-nocookie.com/embed/', $entry);
						}
						$htmlout = '<iframe width="' . $width . '" height="' . $height . '" src="' . $entry . '" allowfullscreen></iframe>';
						return $htmlout;
					}
				}
			}
			return;
		}

	endif;

	if (!function_exists('get_luna_custom_excerpt')) :
		/*
		 * Erstellen des Extracts
		 */

		function get_luna_custom_excerpt($length = 0, $continuenextline = 0, $removeyoutube = 1) {
			global $options;
			global $post;

			if (has_excerpt()) {
				return get_the_excerpt();
			} else {
				$excerpt = get_the_content();
				if (!isset($excerpt)) {
					$excerpt = __('No content', 'luna');
				}
			}
			if ($length == 0) {
				$length = $options['teaser_maxlength'];
			}
			if ($removeyoutube == 1) {
				$excerpt = preg_replace('/^\s*([^\'"]*www\.youtube[\/a-z0-9\.\-\?=]+)/i', '', $excerpt);
				// preg_match('/^\s*([^\'"]*www\.youtube[\/a-z0-9\.\-\?=]+)/i', $excerpt, $matches);
			}

			$excerpt = strip_shortcodes($excerpt);
			$excerpt = strip_tags($excerpt);
			if (mb_strlen($excerpt) < 5) {
				$excerpt = __('No content', 'luna');
			}

			if (mb_strlen($excerpt) > $length) {
				$the_str = mb_substr($excerpt, 0, $length);
				$the_str .= "...";
			} else {
				$the_str = $excerpt;
			}
			$the_str = '<p>' . $the_str;
			if ($continuenextline == 1) {
				$the_str .= '<br>';
			}
			$the_str .= luna_continue_reading_link();
			$the_str .= '</p>';
			return $the_str;
		}

	endif;


	if (!function_exists('get_luna_anmeldebuttons')) :

		/**
		 * Displays Anmeldebutton
		 */
		function get_luna_anmeldebuttons() {
			global $options;
			if (isset($options['aktiv-buttons']) && ($options['aktiv-buttons'] == 1)) {
				if (isset($options['aktiv-anmeldebutton']) && ($options['aktiv-anmeldebutton'] == 1) && isset($options['url-anmeldebutton'])) {
					echo '<a href="' . $options['url-anmeldebutton'] . '" class="button breit gross ' . $options['color-anmeldebutton'] . '">' . $options['title-anmeldebutton'] . '</a>';
					echo "\n";
				}

				if (isset($options['aktiv-cfpbutton']) && ($options['aktiv-cfpbutton'] == 1) && isset($options['url-cfpbutton'])) {
					echo '<a href="' . $options['url-cfpbutton'] . '" class="button breit gross ' . $options['color-cfpbutton'] . '">' . $options['title-cfpbutton'] . '</a>';
					echo "\n";
				}
			}
		}

	endif;

	/**
	* Displays Social Media  Follow Icons in Sidebar
	*/
	function get_luna_socialmediaicons() {
		global $options;
		global $default_socialmedia_liste;
		$zeigeoption = $options['aktiv-socialmediabuttons'];

		if ($zeigeoption != 1) {
			return;
		}
		$result = '';
		$links = '';
		$result .= '<div class="socialmedia_iconbar widget">';
		$result .= '<ul class="socialmedia">';
		foreach ($default_socialmedia_liste as $entry => $listdata) {
			$value = '';
			$active = 0;
			if (isset($options['sm-list'][$entry]['content'])) {
				$value = $options['sm-list'][$entry]['content'];
			} else {
				$value = $default_socialmedia_liste[$entry]['content'];
			}
			if (isset($options['sm-list'][$entry]['active'])) {
				$active = $options['sm-list'][$entry]['active'];
			}
			if (($active == 1) && ($value)) {
				$links .= '<li><a class="icon_' . $entry . '" href="' . $value . '">';
				$links .= $listdata['name'] . '</a></li>';
				$links .= "\n";
			}
		}

		if (strlen($links) > 1) {
			$result .= $links;
			$result .= '</ul>';
			$result .= '</div>';
			echo $result;
		} else {
			return;
		}
	}

	/**
	 * Display social media icons on every post
	 */
	function luna_post_socialmedia_icons() {
		global $post;
		global $options;
		global $defaultoptions;
		global $default_socialmedia_post_liste;
		$zeigeoption = $options['aktiv-post-sm-buttons'];

		if ($zeigeoption != 1) {
			return;
		}
		$links = '<div class="sm-box"><ul class="socialmedia">';

		//Facebook link
		$fb_active = $options['aktiv-facebook-share'];
		$fb_title = $default_socialmedia_post_liste['facebook_share']['name'];
		$fb_text = $default_socialmedia_post_liste['facebook_share']['link_title'];
		$fb_link = $default_socialmedia_post_liste['facebook_share']['link'];
		if (isset($fb_active) && ($fb_active == 1)) {
			$links .= '<li><a class="sm-' . strtolower($fb_title) . '_share" href="' . $fb_link . get_permalink() . '" title="' . $fb_text . '" target="_blank">';
			$links .= '<span class="sm-icon"></span>';
			$links .= '<span class="sm-text screen-reader-text">';
			$links .= $fb_text . '</a></li>' . "\n";
		}

		//Twitter link
		$tw_active = $options['aktiv-twitter-share'];
		$tw_title = $default_socialmedia_post_liste['twitter_share']['name'];
		$tw_text = $default_socialmedia_post_liste['twitter_share']['link_title'];
		$tw_link = $default_socialmedia_post_liste['twitter_share']['link'];
		$tw_via = (isset($options['via-twitter']) ? $options['via-twitter'] : $defaultoptions['via-twitter']);
		if (isset($tw_active) && ($tw_active == 1)) {
			$links .= '<li><a class="sm-' . strtolower($tw_title) . '_share" href=" ' . $tw_link . get_permalink();
			if (isset($tw_via) && ($tw_via != '')) {
				$links .= '&via=' . $tw_via;
			}
			$links .= '" title="' . $tw_text;
			$links .= '" target="_blank">';
			$links .= '<span class="sm-icon"></span>';
			$links .= '<span class="sm-text screen-reader-text">';
			$links .= $tw_text . '</a></li>' . "\n";
		}

		$links.= '</ul></div>';

		if (strlen($links) > 1) {
			echo $links;
		} else {
			return;
		}
	}



	if (!function_exists('short_title')) :
		/*
		 * Erstellen des Kurztitels
		 */

		function short_title($after = '...', $length = 6, $textlen = 10) {
			$thistitle = get_the_title();
			$mytitle = explode(' ', get_the_title());
			if ((count($mytitle) > $length) || (mb_strlen($thistitle) > $textlen)) {
				while (((count($mytitle) > $length) || (mb_strlen($thistitle) > $textlen)) && (count($mytitle) > 1)) {
					array_pop($mytitle);
					$thistitle = implode(" ", $mytitle);
				}
				$morewords = 1;
			} else {
				$morewords = 0;
			}
			if (mb_strlen($thistitle) > $textlen) {
				$thistitle = mb_substr($thistitle, 0, $textlen);
				$morewords = 1;
			}
			if ($morewords == 1) {
				$thistitle .= $after;
			}
			return $thistitle;
		}

	endif;


	/**
	  class My_Walker_Nav_Menu extends Walker_Nav_Menu {
	 *
	 */
	/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */
	/**
	  public function start_el( &$output, $item, $depth, $args ) {
	  if ( '-' === $item->title )
	  {
	  // you may remove the <hr> here and use plain CSS.
	  $output .= '<li class="menu_separator"><hr>';
	  } else{
	  parent::start_el( $output, $item, $depth, $args );
	  }
	  }
	 *
	 */
	/* Klasse has_children einfuegen */
	/**
	  public function display_element($el, &$children, $max_depth, $depth = 0, $args, &$output){
	  $id = $this->db_fields['id'];

	  if(isset($children[$el->$id]))
	  $el->classes[] = 'has_children';

	  parent::display_element($el, $children, $max_depth, $depth, $args, $output);
	  }
	  }
	 *
	 */
	/* Interne Links relativ ausgeben */

	add_action('template_redirect', 'rw_relative_urls');

	function rw_relative_urls() {
		// Don't do anything if:
		// - In feed
		// - In sitemap by WordPress SEO plugin
		if (is_feed() || get_query_var('sitemap'))
			return;
		$filters = array(
			'post_link',
			'post_type_link',
			'page_link',
			'attachment_link',
			'get_shortlink',
			'post_type_archive_link',
			'get_pagenum_link',
			'get_comments_pagenum_link',
			'term_link',
			'search_link',
			'day_link',
			'month_link',
			'year_link',
		);
		foreach ($filters as $filter) {
			add_filter($filter, 'wp_make_link_relative');
		}
	}

	if (!function_exists('make_relative_site_links_in_content')) :

		function make_relative_site_links_in_content($content) {
			global $wpdb;

			$search = array(
				'href="' . site_url(), 'src="' . site_url(),
				'href="' . site_url('', 'https'), 'src="' . site_url('', 'https')
			);

			$replace = array(
				'href="', 'src="',
				'href="', 'src="'
			);

			if (function_exists('get_original_url')) {
				$original_url = get_original_url('siteurl');
				$site_url = str_replace("https://", "http://", $original_url);
				$site_url_ssl = str_replace("http://", "https://", $original_url);
				$search = array_merge($search, array(
					'href="' . $site_url, 'src="' . $site_url,
					'href="' . $site_url_ssl, 'src="' . $site_url_ssl
				));

				$replace = array_merge($replace, array(
					'href="', 'src="',
					'href="', 'src="'
				));
			}

			return str_replace($search, $replace, $content);
		}

	endif;

	add_filter('the_content', function($content) {
		return make_relative_site_links_in_content($content);
	}, 99);


	/* Content-Slider */

	function contentSlider($atts) {

		// Attributes
		extract(shortcode_atts(
						array(
			"type" => '',
			"anzahl" => '',
			"kategorie" => '',
			'orderby' => 'rand',
						), $atts, 'content-slider'
		));
		$type = sanitize_text_field($type);
		$orderby = sanitize_text_field($orderby);
		$kategorie = sanitize_text_field($kategorie);
		$anzahl = sanitize_text_field($anzahl);
		// Code
		$args = array(
			'post_type' => $type,
			'posts_per_page' => $anzahl,
			'category_name' => $kategorie,
			'orderby' => $orderby);
		$the_query = new WP_Query($args);
		$output = '';
		if ($the_query->have_posts()) :
			$output = '<div class="flexslider">';
			$output .= '<ul class="slides">';
			while ($the_query->have_posts()) : $the_query->the_post();
				$id = get_the_ID();
				$output .= '<li>';
				$output .= '<h2>' . get_the_title() . '</h2>';
				if (has_post_thumbnail()) {
					$output .= get_the_post_thumbnail($id, 'teaser-thumb', array('class' => 'attachment-teaser-thumb'));
				} else {
					$output .= '<div class="infoimage" style="width:120px;float:left;margin-right:10px;">' . get_luna_firstpicture() . '</div>';
				}
				$output .= get_luna_custom_excerpt($length = 200, $continuenextline = 0, $removeyoutube = 1);
				$output .= '</li>';
			endwhile;
			$output .= '</ul>';
			$output .= '</div>';
		endif;
		wp_reset_postdata();

		wp_enqueue_script('jquery-flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'), '2.2.0', true);
		wp_enqueue_script('flexslider', get_template_directory_uri() . '/js/flexslider.js', array(), false, true);
		return $output;
	}

	add_shortcode('content-slider', 'contentSlider');


	/* Add Excerpt, Category and Tags to Page */

	add_action('init', 'my_add_excerpts_to_pages');

	function my_add_excerpts_to_pages() {
		add_post_type_support('page', 'excerpt');
	}

	function my_add_categories_to_pages() {
		// Add tag metabox to page
		register_taxonomy_for_object_type('post_tag', 'page');
		// Add category metabox to page
		register_taxonomy_for_object_type('category', 'page');
	}

	add_action('admin_init', 'my_add_categories_to_pages');


	if (!function_exists('get_luna_opengraphinfo')) :

		/**
		 * Assemble Open Graph Information for Facebook
		 */
		function get_luna_opengraphinfo() {
			global $post;

			$ogimage = '';
			if (is_single() && (has_post_thumbnail($post->ID))) :
				$ogimage = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
			elseif (is_single() && !(has_post_thumbnail($post->ID))) :
				$ogimage = get_luna_first_image_url();
			elseif (get_header_image()):
				$ogimage = get_header_image();
			endif;

			$ogtitle = '';
			if (is_home()) :
				$ogtitle = get_bloginfo('title');
			elseif (is_single() || is_page()) :
				$ogtitle = get_the_title();
			elseif (is_category()) :
				$ogtitle = sprintf(__('Category Archives: %s', 'luna'), single_cat_title('', false));
			elseif (is_tag()) :
				$ogtitle = sprintf(__('Tag Archives: %s', 'luna'), single_tag_title('', false));
			endif;
			?>

			<meta property="og:title" content="<?php echo $ogtitle; ?>" />
			<meta property="og:description" content="<?php bloginfo('description'); ?>" />
			<meta property="og:image" content="<?php echo $ogimage; ?>" />
			<meta property="og:url" content="<?php echo 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>" />
			<meta property="og:locale" content="<?php echo str_replace("-", "_", get_bloginfo('language')); ?>" />
			<meta property="og:type" content="website" />

			<?php
		}

	endif;



	if (!function_exists('get_luna_first_image_url')) :

		/**
		 * Get First Picture URL from content
		 */
		function get_luna_first_image_url() {
			global $post;
			$first_img = '';
			ob_start();
			ob_end_clean();
			$matches = array();
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
			if ($output != 0) {
				$first_img = $matches[1][0];
			} elseif (($output == 0) && (get_header_image())) {
				$first_img = get_header_image();
			}
			return $first_img;
		}

	endif;

	/**
	 * Add Speaker link to Event
	 * Description: <a target="_blank" href="http://wordpress.stackexchange.com/q/85107/89">WPSE 85107</a>
	 */
	class speaker_link {

		var $FOR_POST_TYPE = 'event';
		var $SELECT_POST_TYPE = 'speaker';
		var $SELECT_POST_LABEL = 'Speaker';
		var $box_id;
		var $box_label;
		var $field_id;
		var $field_label;
		var $field_name;
		var $meta_key;

		function __construct() {
			add_action('admin_init', array($this, 'admin_init'));
		}

		function admin_init() {
			add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
			add_action('save_post', array($this, 'save_post'), 10, 2);
			$this->meta_key = "_selected_{$this->SELECT_POST_TYPE}";
			$this->box_id = "select-{$this->SELECT_POST_TYPE}-metabox";
			$this->field_id = "selected-{$this->SELECT_POST_TYPE}";
			$this->field_name = "selected_{$this->SELECT_POST_TYPE}";
			$this->box_label = __("Select {$this->SELECT_POST_LABEL}", 'luna');
			$this->field_label = __("Choose {$this->SELECT_POST_LABEL}", 'luna');
		}

		function add_meta_boxes() {
			add_meta_box(
					$this->box_id, $this->box_label, array($this, 'select_box'), $this->FOR_POST_TYPE, 'normal'
			);
		}

		function select_box($post) {
			$selected_post_id = get_post_meta($post->ID, $this->meta_key, true);
			global $wp_post_types;
			$save_hierarchical = $wp_post_types[$this->SELECT_POST_TYPE]->hierarchical;
			$wp_post_types[$this->SELECT_POST_TYPE]->hierarchical = true;
			wp_dropdown_pages(array(
				'id' => $this->field_id,
				'name' => $this->field_name,
				'selected' => empty($selected_post_id) ? 0 : $selected_post_id,
				'post_type' => $this->SELECT_POST_TYPE,
				'show_option_none' => $this->field_label,
			));
			$wp_post_types[$this->SELECT_POST_TYPE]->hierarchical = $save_hierarchical;
		}

		function save_post($post_id, $post) {
			if ($post->post_type == $this->FOR_POST_TYPE && isset($_POST[$this->field_name])) {
				update_post_meta($post_id, $this->meta_key, $_POST[$this->field_name]);
			}
		}

	}

	new speaker_link();

	/**
	 * Render custom fields of custom post type 'event'
	 */
	function luna_event_fields() {
		global $post;
		global $options;
		$post_id = $post->ID;
		$event_referentname = get_post(get_post_meta($post_id, '_selected_speaker', true))->post_title;
		$event_referentlink = get_post_permalink(get_post_meta($post_id, '_selected_speaker', true));
		$event_kurz = get_post_meta($post_id, 'event_kurz', true);
		$event_datum = get_post_meta($post_id, 'event_datum', true);
		$event_beginn = get_post_meta($post_id, 'event_beginn', true);
		$dtstamp_beginn = date('Ymd', strtotime($event_datum)) . "T" . date('Hi', strtotime($event_beginn));
		$event_ende = get_post_meta($post_id, 'event_ende', true);
		$dtstamp_ende = date('Ymd', strtotime($event_datum)) . "T" . date('Hi', strtotime($event_ende));
		$event_raum = get_post_meta($post_id, 'event_raum', true);
		$event_max_teilnehmer = get_post_meta($post_id, 'event_max_teilnehmer', true);
		$event_verfuegbar = get_post_meta($post_id, 'event_verfuegbar', true);
		$event_aufzeichnung = get_post_meta($post_id, 'event_aufzeichnung', true);
		$event_folien = get_post_meta($post_id, 'event_folien', true);

		$str = '';

		$field_label = array(
			'event_kurz' => $options['label-short'],
			'event_datum' => 'Datum',
			'event_beginn' => 'Zeit',
			'event_raum' => 'Raum',
			'event_event_max-teilnehmer' => 'max. Teilnehmer',
			'event_verfuegbar' => 'Verf&uuml;gbare Pl&auml;tze',
			'_selected_speaker' => $options['label-speaker'],
		);

		$str .= "<div>";
		if (isset($event_kurz) && (strlen(trim($event_kurz)) > 0)) {
			$str .= "<span class='event-label kurz'>" . $options['label-short'] . "</span> <span class='event-kurz'>" . $event_kurz . "</a><br>";
		}
		if (isset($event_referentname) && (strlen(trim($event_referentname)) > 0)) {
			$str .= "<span class='event-label speaker'>" . $options['label-speaker'] . ":</span> <span class='event-speaker'><a href='" . $event_referentlink . "'>" . $event_referentname . "</a></span><br>";
		}
		if (isset($event_datum) && (strlen(trim($event_datum)) > 0)) {
			$str .= "<span class='event-label date'>Datum:</span> <span class='event-date' title='" . date('Y-m-d', strtotime($event_datum)) . "'>" . $event_datum . "</span><br>";
		}
		if (isset($event_beginn) && (strlen(trim($event_beginn)) > 0)) {
			$str .= "<span class='event-label time'>Zeit:</span> <span class='event-start dtstamp' title='" . $dtstamp_beginn . "'>" . $event_beginn . "</span>";
			if (isset($event_ende) && (strlen(trim($event_ende)) > 0)) {
				$str .= " &ndash; <span class='event-end dtstamp' title='" . $dtstamp_ende . "'>" . $event_ende . "</span><br>";
			}
		}
		if (isset($event_raum) && (strlen(trim($event_raum)) > 0)) {
			$str .= "<span class='event-label place'>Ort:</span> <span class='event_ort'>" . $event_raum . "</span><br>";
		}
		if (isset($event_max_teilnehmer) && (strlen(trim($event_max_teilnehmer)) > 0)) {
			$str .= "<span class='event-label max-teilnehmer'>max. Teilnehmer:</span> <span class='event_max_teilnehmer'>" . $event_max_teilnehmer . "</span><br>";
		}
		if (isset($event_verfuegbar) && (strlen(trim($event_verfuegbar)) > 0)) {
			$str .= "<span class='event-label verfuegbar'>noch verf&uuml;gbar:</span> <span class='event_verfuegbar'>" . $event_verfuegbar . "</span>";
			if (get_post_meta($post->ID, 'event_warteliste', true) == "on") {
				$str .= " &ndash; <em>Buchung auf Warteliste m&ouml;glich</em>";
			}
			$str .= "<br>";
		}
		$str .= "</div>";
		$str .= '<ul class="medien">';
		if (isset($event_aufzeichnung) && (strlen(trim($event_aufzeichnung)) > 0)) {
			$str .= '<li class="video"><a href="' . $event_aufzeichnung . '">Videoaufzeichnung</a></li>';
		}
		if (isset($event_folien) && (strlen(trim($event_folien)) > 0)) {
			$str .= '<li class="folien"><a href="' . $event_folien . '">Vortragsfolien</a></li>';
		}
		$str .= '</ul>';
		echo $str;
	}

	/**
	 * Display a speaker's events
	 */
	function luna_speaker_event_list() {
		global $post;
		global $options;
		$str = "<h3 style='clear:both;'>" . $options['label-event-pl'] . ":</h3>";
		$str .= "<ul>";
		$args = array('post_type' => 'event', 'orderby' => 'title', 'order' => 'ASC');
		$events = get_posts($args);
		//echo "<pre>";
		//print_r($events);
		//echo "</pre>";
		if (!empty($events)) {
			foreach ($events as $event) {
				$custom_fields = get_post_meta($event->ID);
				$speaker_id = $custom_fields['_selected_speaker'][0];
				if ($post->ID == $speaker_id) {
					$str .= "<li><a href='" . get_post_permalink($event->ID) . "'>";
					$str .= apply_filters('the_title', $event->post_title);
					$str .= "</a></li>";
				}
			}
		}
		$str .= "</ul>";

		echo $str;
		//echo "<pre>";
		//print_r($post->ID);
		//print_r($speaker_id);
		//echo "</pre>";
	}

	/**
	 * Contact Form 7 : Shortcode [event-list] aus Liste der Events (= Custom Post Type) erstellen
	 * z.B. [select* event-list include_blank]
	 */
	function luna_add_plugin_list_to_contact_form($tag, $unused) {

		if ($tag['name'] != 'event-list')
			return $tag;

		$args = array('post_type' => 'event',
			'orderby' => 'title',
			'order' => 'ASC');
		$events = get_posts($args);

		if (!$events)
			return $tag;

		foreach ($events as $event) {
			$verfuegbar = get_post_meta($event->ID, 'event_verfuegbar', true);
			$kurz = get_post_meta($event->ID, 'event_kurz', true);
			$datum = get_post_meta($event->ID, 'event_datum', true);
			$warteliste = get_post_meta($event->ID, 'event_warteliste', true);
			if ((isset($verfuegbar)) && ($verfuegbar > 0)) {
				$tag['raw_values'][] = $kurz . "_" . $event->post_name;
				$tag['values'][] = $kurz . "_" . $event->post_name;
				$tag['labels'][] = $datum . ": " . $event->post_title . " (" . $kurz . ")";
			} elseif ((isset($verfuegbar)) && ($verfuegbar == 0) && $warteliste == "on") {
				$tag['raw_values'][] = $kurz . "_" . $event->post_name . "_warteliste";
				$tag['values'][] = $kurz . "_" . $event->post_name . "_warteliste";
				$tag['labels'][] = $datum . ": " . $event->post_title . " (" . $kurz . ") &ndash; " . _x('WAITING LIST', 'Addition to select list option on registration form', 'luna');
			}
		}

		return $tag;
	}

	add_filter('wpcf7_form_tag', 'luna_add_plugin_list_to_contact_form', 10, 2);

	/**
	 * Contact Form 7 : String für leere Auswahl-Option im Auswahlmenü anpassen
	 */
	function my_wpcf7_form_elements($select) {
		$text = __('Please select...', 'luna');
		$select = str_replace('<option value="">---</option>', '<option value="">' . $text . '</option>', $select);
		return $select;
	}

	add_filter('wpcf7_form_elements', 'my_wpcf7_form_elements');

	/*
	 * Contact Form 7 : CF7-JavaScript deaktivieren (ungeklärter Konflikt mit Theme-JS)
	 */
	add_filter('wpcf7_load_js', '__return_false');


	/*
	 * Hilfe-Panel über der Theme-Options-Seite
	 */
	function luna_contextual_help() {
		$helptexts = array(
			array(
				'id'	=> 'design',
				'title'	=> __('Design','luna'),
				'content'	=> '<h3>Slider</h3><p>Mit dem Content-Slider können Sie Inhalte des Webauftritts in einem Slider durchlaufenlassen.</p><p>Den Slider binden Sie mithilfe des Shortcodes <code>[content-slider type=event anzahl=6]</code>ein. <br /><code>type</code> steht für den Inhaltstyp: Beitrag (article), Veranstaltung (event) oder Referent (speaker).<br /> Mit <code>anzahl</code> können Sie die Anzahl der durchlaufenden Inhalte begrenzen.</p>'
			),
			array(
				'id'	=> 'veranstaltungen',
				'title'	=> __('Events','luna'),
				'content'	=> '<h3>Tabellarische Veranstaltungsübersicht</h3><p>Über den Shortcode <code>[event format=table]</code> können Sie automatisch eine Tabelle mit allen Einzelveranstaltungen generieren.</p><p>Geben Sie dazu an, welche Felder in der Tabelle angezeigt werden sollen. Es empfiehlt sich, max. 4-5 Felder auszuwählen, da sonst die Tabelle zu breit und zu unübersichtlich wird.</p><h3>Anmeldeformular</h3><p>Das Theme verwendet das Formular-Plugin Contactform7. Konfigurieren Sie das Formular über den Menüpunkt "Formular" und binden Sie es in eine Seite ein.</p><p>Geben Sie hier bei den Optionen den relativen Link zu der Seite ein, auf der Sie das Anmeldeformular eingebunden haben. Relativ bedeutet ohne "http://www.meine-domain.de/". Dieser Link wird für den Anmelden-Button unterhalb jeder Eventseite verwendet.</p>'
				)
		);

		$screen = get_current_screen();
		foreach ($helptexts as $helptext) {
			$screen->add_help_tab($helptext);
		}
	}
	if (isset($_GET['page']) && $_GET['page'] == 'theme_options') {
		add_action('contextual_help', 'luna_contextual_help', 10, 3);
	}
