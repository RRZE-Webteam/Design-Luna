<?php
/*
 * luna Widgets
 * Proudly made with a lot of coffee
 */

function luna_widgets_init() {

	// Kurzinfo
	register_sidebar(array(
		'name' => __('Additional Info', 'luna'),
		'id' => 'kurzinfo-area',
		'description' => __('Area below the first sidebar menu', 'luna'),
		'before_widget' => '<div class="kurzinfo">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	// Sidebar
	register_sidebar(array(
		'name' => __('Sidebar', 'luna'),
		'id' => 'sidebar-area',
		'description' => __('Second sidebar', 'luna'),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));

	// Zusatzinfo (Inhaltsinfo)
	register_sidebar(array(
		'name' => __('Content Info', 'luna'),
		'id' => 'inhaltsinfo-area',
		'description' => __('Fixed content above the main content', 'luna'),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));

	// Zusatzinfo (Zusatzinfo)
	register_sidebar(array(
		'name' => __('Additional Info', 'luna'),
		'id' => 'zusatzinfo-area',
		'description' => __('Additional info in footer area', 'luna'),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
}

add_action('widgets_init', 'luna_widgets_init');

/**
 * Adds FAULinkliste_Widget widget.
 */
class FAULinkliste_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
				'FAULinkliste_Widget', // Base ID
				__('FAU  Link List', 'luna'), array('description' => __('Link list with RRZE and FAU web services', 'luna'),) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) {
		extract($args);
		$bereich = $instance['bereich'];
		if ((!isset($bereich)) || (empty($bereich))) {
			$bereich = $defaultoptions['default_footerlink_key'];
		}
		echo $before_widget;
		global $default_footerlink_liste;

		$title = $default_footerlink_liste[$bereich]['title'];
		$url = $default_footerlink_liste[$bereich]['url'];

		if ((isset($url)) && (strlen($url) > 5)) {
			echo $before_title . '<a href="' . $url . '">' . $title . '</a>' . $after_title;
		} else {
			echo $before_title . $title . $after_title;
		}
		echo '<ul class="FAULinkliste">';

		foreach ($default_footerlink_liste[$bereich]['sublist'] as $i => $value) {
			echo '<li><a href="' . $value . '">';
			echo $i . '</a></li>';
			echo "\n";
		}
		echo '</ul>';

		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['bereich'] = strip_tags($new_instance['bereich']);
		return $instance;
	}

	/**
	 * Back-end widget form.
	 * @see WP_Widget::form()
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {

		if (isset($instance['bereich'])) {
			$bereich = $instance['bereich'];
		} else {
			$bereich = $defaultoptions['default_footerlink_key'];
		}

		global $default_footerlink_liste;
		echo "<select name=\"" . $this->get_field_name('bereich') . "\">\n";

		foreach ($default_footerlink_liste as $i => $value) {
			echo "\t\t\t\t";
			echo '<option value="' . $i . '"';
			if ($i == $bereich) {
				echo ' selected="selected"';
			}
			echo '>';
			if (!is_array($value)) {
				echo $value;
			} else {
				echo $i;
			}
			echo '</option>';
			echo "\n";
		}
		echo "</select><br>\n";
		echo "\t\t\t";
		echo "<label for=\"" . $this->get_field_name('bereich') . "\">" . __('Choose Area', 'luna') . "</label>\n";
	}

}

// class  Linkliste Widget
//
// register widget
add_action('widgets_init', create_function('', 'register_widget( "FAULinkliste_Widget" );'));

/**
 * Adds Bannerlink_Widget widget.
 */
class Bannerlink_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
				'Bannerlink_Widget', // Base ID
				__('Banner/Logo Link', 'luna'), array('description' => __('Add a linked logo or banner', 'luna'),) // Args
		);
	}

	public function form($instance) {
		$defaults = array(
			'title' => '',
			'url' => '',
			'image_url' => '',
			'image_id' => 0
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		$title = $instance['title'];
		$url = $instance['url'];
		$image_url = $instance['image_url'];
		$image_id = $instance['image_id'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'luna'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
				   name="<?php echo $this->get_field_name('title'); ?>"
				   type="text" value="<?php echo esc_attr($title); ?>" />

		</p>
		<p>
			<label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Target URL:', 'luna'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('url'); ?>"
				   name="<?php echo $this->get_field_name('url'); ?>"
				   type="text" value="<?php echo esc_attr($url); ?>" />

		</p>
		<p>
			<label for="<?php echo $this->get_field_id('image_url'); ?>"><?php _e('Image URL:', 'luna'); ?>
				<input 	class="image_url widefat" id="<?php echo $this->get_field_id('image_url'); ?>"
						name="<?php echo $this->get_field_name('image_url'); ?>"
						type="text" value="<?php echo esc_attr($image_url); ?>" />


				<input type="hidden" id="<?php echo $this->get_field_id('image_id'); ?>"
					   class="image_id"  name="<?php echo $this->get_field_name('image_id'); ?>" />
				<input
					id="<?php echo $this->get_field_id('image_url'); ?>_button"
					class="upload_image_button" value="<?php _e('Upload / Choose', 'luna'); ?>" type="button" />

				<br /><?php _e('Add a URL to the image or use the mediathek to upload or choose an image.', 'luna'); ?>
			</label>
		</p>
		<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['url'] = esc_url($new_instance['url']);
		$instance['image_url'] = esc_url($new_instance['image_url']);
		$instance['image_id'] = intval($new_instance['image_id']);
		return $instance;
	}

	public function widget($args, $instance) {
		global $defaultoptions;

		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$url = esc_url($instance['url']);
		$image_url = esc_url($instance['image_url']);
		$image_id = intval($instance['image_id']);
		$image_width = $defaultoptions['bannerlink-width'];
		$image_height = 0;
		if ($image_id > 0) {
			// Get Thumbnail instead of original
			$image_attributes = wp_get_attachment_image_src($image_id, array($defaultoptions['bannerlink-width'], $defaultoptions['bannerlink-height']));
			$image_url = $image_attributes[0];
			$image_width = $image_attributes[1];
			$image_height = $image_attributes[2];
		}
		$site_link = home_url();
		if ((isset($url)) && (strpos($url, $site_link) !== false)) {
			$url = wp_make_link_relative($url);
		}
		if ((isset($image_url)) && (strpos($image_url, $site_link) !== false)) {
			$image_url = wp_make_link_relative($image_url);
		}

		if (!isset($url) && !isset($image_url)) {
			return;
		}
		echo $before_widget;
		echo '<p class="bannerlink">';
		if ((isset($url)) && (strlen($url) > 0))
			echo '<a href="' . $url . '">';
		if ($image_url) {
			if ($image_height > 0) {
				echo '<img src="' . $image_url . '" width="' . $image_width . '" height="' . $image_height . '" alt="' . $title . '">';
			} else {
				echo '<img src="' . $image_url . '" alt="' . $title . '">';
			}
		} else {
			echo $title;
		}
		if ((isset($url)) && (strlen($url) > 0))
			echo '</a>';
		echo "</p>\n";
		echo $after_widget;
	}

}

//
// register widget
add_action('widgets_init', create_function('', 'register_widget( "Bannerlink_Widget" );'));
?>
