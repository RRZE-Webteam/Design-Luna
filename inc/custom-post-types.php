<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* ---------------------------------------------------------------------------
 * Event Custom Post Type
 * ------------------------------------------------------------------------- */

// Register Custom Post Type
function luna_event_post_type() {
	global $options;
	$slug_event = strtolower(sanitize_file_name($options['label-event-pl']));
	$labels = array(
		'name' => _x('Events', 'Post Type General Name', 'luna'),
		'singular_name' => _x('Event', 'Post Type Singular Name', 'luna'),
		'menu_name' => __('Events', 'luna'),
		'parent_item_colon' => __('Parent Item:', 'luna'),
		'all_items' => __('All Events', 'luna'),
		'view_item' => __('View Event', 'luna'),
		'add_new_item' => __('New Event', 'luna'),
		'add_new' => __('New', 'luna'),
		'edit_item' => __('Edit', 'luna'),
		'update_item' => __('Update', 'luna'),
		'search_items' => __('Search Event', 'luna'),
		'not_found' => __('Event not found', 'luna'),
		'not_found_in_trash' => __('Event not found in recycle bin', 'luna'),
	);
	$args = array(
		'label' => __('event', 'luna'),
		'description' => __('Add and edit event information', 'luna'),
		'labels' => $labels,
		'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'little-promo-boxes', 'comments', 'revisions', 'custom-fields', 'page-attributes'),
		'hierarchical' => true,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_admin_bar' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-calendar',
		'can_export' => true,
		'has_archive' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'rewrite' => array('slug' => $slug_event, 'with_front' => FALSE),
		'capability_type' => 'page',
	);
	register_post_type('event', $args);
}

// Hook into the 'init' action
add_action('init', 'luna_event_post_type', 0);

function luna_event_taxonomies() {
	$labels = array();
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		'rewrite' => false,
	);
	register_taxonomy('event_category', 'event', $args);
}

add_action('init', 'luna_event_taxonomies');


/*
 * Metabox fuer weitere Eventinfo
 */

function luna_event_metabox() {
	add_meta_box(
			'event_metabox', __('Event Information', 'luna'), 'event_metabox_content', 'event', 'normal', 'high'
	);
}

function event_metabox_content($post) {
	global $defaultoptions;
	global $post;
	global $vortragsraeume;

	wp_nonce_field(plugin_basename(__FILE__), 'event_metabox_content_nonce');
	?>

	<p>
		<label for="event_kurz"><?php _e("Code", 'luna'); ?>:</label>
		<input class="text" type="text" name="event_kurz"
			   id="event_kurz" value="<?php echo esc_attr(get_post_meta($post->ID, 'event_kurz', true)); ?>" size="30" />
	</p>
	<p>
		<label for="event_datum"><?php _e("Date", 'luna'); ?>:</label>
		<input class="datepicker" type="text" name="event_datum"
			   id="event_datum" value="<?php echo date('j.m.Y',strtotime(esc_attr(get_post_meta($post->ID, 'event_datum', true)))); ?>" size="30" />
	</p>
	<p>
		<label for="event_beginn"><?php _e("Time - from", 'luna'); ?>:</label>
		<input type="time" name="event_beginn"
			   id="event_beginn" value="<?php echo esc_attr(get_post_meta($post->ID, 'event_beginn', true)); ?>" size="10" />
		<label for="event_ende"><?php _e("to", 'luna'); ?>:</label>
		<input type="time" name="event_ende"
			   id="event_ende" value="<?php echo esc_attr(get_post_meta($post->ID, 'event_ende', true)); ?>" size="10" />
	</p>
	<p>
		<label for="event_raum"><?php _e("Location", 'luna'); ?>:</label>

		<select name="event_raum"  id="event_raum">
			<?php
			$liste = $vortragsraeume;
			$saal = esc_attr( get_post_meta( $post->ID, 'event_raum', true ) );


			foreach ($liste as $i => $value) {
				echo "\t\t\t\t";
				echo '<option value="' . $i . '"';
				if ($i == $saal) {
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
			?>

		</select>
	</p>

	<p>
		<label for="event_max-teilnehmer"><?php _e("Max. number of participants", 'luna'); ?>:</label>
		<input class="number" type="number" name="event_max_teilnehmer"
			   id="event_max_teilnehmer" value="<?php echo esc_attr(get_post_meta($post->ID, 'event_max_teilnehmer', true)); ?>" />
	</p>

	<p>
		<label for="event_verfuegbar"><?php _e("Places available", 'luna'); ?>:</label>
		<input class="number" type="number" name="event_verfuegbar"
			   id="event_verfuegbar" value="<?php echo esc_attr(get_post_meta($post->ID, 'event_verfuegbar', true)); ?>" />
	</p>

	<p>
		<label for="event_warteliste"><?php _e("Offer waiting list for fully booked events", 'luna'); ?>
			<input class="checkbox" type="checkbox" name="event_warteliste" id="event_warteliste" <?php if (get_post_meta($post->ID, 'event_warteliste', true) == "on") { echo ' checked="checked"';} ?> /></label>
	<?php print get_post_meta($post->ID, 'event_warteliste', true); ?>
	</p>

	<p>
		<label for="event_aufzeichnung"><?php _e("Enter URL for video (FAU Video portal): &quot;http://...&quot;", 'luna'); ?>:</label>
		<br />
		<input class="url" type="text" name="event_aufzeichnung"
			   id="event_aufzeichnung" value="<?php echo esc_attr(get_post_meta($post->ID, 'event_aufzeichnung', true)); ?>" size="30" />
	</p>
	<p>
		<label for="event_folien"><?php _e("Enter URL to event presentation slides: &quot;http://...&quot;", 'luna'); ?>:</label>
		<br />
		<input class="url" type="text" name="event_folien"
			   id="event_folien" value="<?php echo esc_attr(get_post_meta($post->ID, 'event_folien', true)); ?>" size="30" />
	</p>

	<?php
}

add_action('add_meta_boxes', 'luna_event_metabox');

function event_metabox_save($post_id) {
	if ('event' != get_post_type())
		return;
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;
	if (!wp_verify_nonce($_POST['event_metabox_content_nonce'], plugin_basename(__FILE__)))
		return;
	/*if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return;
	} else {
		if (!current_user_can('edit_post', $post_id))
			return;
	}*/

	if (isset($_POST['event_kurz'])) {
		update_post_meta($post_id, 'event_kurz', sanitize_text_field($_POST['event_kurz']));
	}
	if (isset($_POST['event_datum'])) {
		update_post_meta($post_id, 'event_datum', sanitize_text_field($_POST['event_datum']));
	}
	if (isset($_POST['event_beginn'])) {
		update_post_meta($post_id, 'event_beginn', sanitize_text_field($_POST['event_beginn']));
	}
	if (isset($_POST['event_ende'])) {
		update_post_meta($post_id, 'event_ende', sanitize_text_field($_POST['event_ende']));
	}
	if (isset($_POST['event_raum'])) {
		update_post_meta($post_id, 'event_raum', sanitize_text_field($_POST['event_raum']));
	}
	if (isset($_POST['event_max_teilnehmer'])) {
		update_post_meta($post_id, 'event_max_teilnehmer', sanitize_text_field($_POST['event_max_teilnehmer']));
	}
	if (isset($_POST['event_verfuegbar'])) {
		update_post_meta($post_id, 'event_verfuegbar', sanitize_text_field($_POST['event_verfuegbar']));
	}
	update_post_meta($post_id, 'event_warteliste', $_POST['event_warteliste']);

	$url = $_POST['event_aufzeichnung'];
	if (filter_var($url, FILTER_VALIDATE_URL)) {
		update_post_meta($post_id, 'event_aufzeichnung', $url);
	}
	$url = $_POST['event_folien'];
	if (filter_var($url, FILTER_VALIDATE_URL)) {
		update_post_meta($post_id, 'event_folien', $url);
	}
}

add_action('save_post', 'event_metabox_save');

function event_metabox_updated_messages($messages) {
	global $post, $post_ID;
	$messages['event'] = array(
		0 => '',
		1 => __('Event information updated. ', 'luna'),
		2 => __('Event information updated.', 'luna'),
		3 => __('Event information deleted.', 'luna'),
		6 => __('Event information published.', 'luna'),
		7 => __('Event information saved.', 'luna'),
	);
	return $messages;
}

add_filter('post_updated_messages', 'event_metabox_updated_messages');



/*
 * Shortcode Definition
 */

function event_shortcode($atts) {
	global $post;
	global $options;
	global $eventszeiten;
	global $vortragsraeume;
	extract(shortcode_atts(array(
		'cat' => '',
		'num' => 30,
		'id' => '',
		'format' => '',
		'showautor' => 1
					), $atts));
	$single = 0;
	$cat = sanitize_text_field($cat);
	$format = sanitize_text_field($format);
	$showautor = sanitize_text_field($showautor);
	if ((isset($id)) && ( strlen(trim($id)) > 0)) {

		$args = array(
			'post_type' => 'event',
			'p' => $id
		);
		$single = 1;
	} elseif ((isset($cat)) && ( strlen(trim($cat)) > 0)) {
		$args = array(
			'post_type' => 'event',
			'tax_query' => array(
				array(
					'taxonomy' => 'event_category',
					'field' => 'slug',
					'terms' => $cat
				)
			)
		);
	} else {
		$args = array(
			'post_type' => 'event'
		);
	}

	$links = new WP_Query($args);
	if ($links->have_posts()) {
		$i = 0;
		$out = '';

		if (isset($format) && ($format == 'table') && ($single == 0)) {
			$out .= '<table class="eventtabelle">
					<thead>
					<tr>';
			if ($options['event-table-date']==1) {
				$out .= '<th scope="col" class="date">' . __('Date','luna') . '</th>';
			}
			$out .= '<th scope="col" class="titel">Titel</th>';
			if ($options['event-table-begin']==1) {
				$out .= '<th scope="col" class="time">' . __('Start','luna') . '</th>';
			}
			if ($options['event-table-end']==1) {
				$out .= '<th scope="col" class="time">' . __('End','luna') . '</th>';
			}
			if ($options['event-table-location']==1) {
				$out .= '<th scope="col" class="location">' . __('Location','luna') . '</th>';
			}
			if ($options['event-table-speaker']==1) {
				$out .= '<th scope="col" class="time">' . $options['label-speaker'] . '</th>';
			}
			if ($options['event-table-short']==1) {
				$out .= '<th scope="col" class="time">' . $options['label-short'] . '</th>';
			}
			if ($options['event-table-participants']==1) {
				$out .= '<th scope="col" class="time">' . __('Participants','luna') . '</th>';
			}
			if ($options['event-table-availible']==1) {
				$out .= '<th scope="col" class="time">' . __('Available','luna') . '</th>';
			}
			$out .= '</tr>
					</thead>
				    <tbody>';
		}

		while ($links->have_posts() && ($i < $num)) {
			$links->the_post();
			$i++;
			$post_id = $links->post->ID;
			$title = get_the_title();
			$event_kurztext = $post->post_excerpt;
			$event_text = $post->post_content;
			$event_link = get_permalink();
			$event_referentname = get_post(get_post_meta($post_id,'_selected_speaker', true))->post_title;
			$event_referentlink = get_post_permalink(get_post_meta($post_id,'_selected_speaker', true));
			$event_kurz = get_post_meta($post_id, 'event_kurz', true);
			$event_datum = get_post_meta($post_id, 'event_datum', true);
			$event_beginn = get_post_meta($post_id, 'event_beginn', true);
			$dtstamp_beginn = date('Ymd',strtotime($event_datum))."T".date('Hi',strtotime($event_beginn));
			$event_ende = get_post_meta($post_id, 'event_ende', true);
			$dtstamp_ende = date('Ymd',strtotime($event_datum))."T".date('Hi',strtotime($event_ende));
			$event_raum = get_post_meta($post_id, 'event_raum', true);
			$event_max_teilnehmer = get_post_meta($post_id, 'event_max_teilnehmer', true);
			$event_verfuegbar = get_post_meta($post_id, 'event_verfuegbar', true);
			$event_aufzeichnung = get_post_meta($post_id, 'event_aufzeichnung', true);
			$event_folien = get_post_meta($post_id, 'event_folien', true);

			if (isset($id) && isset($format) && ($format == 'short')) {
			// format short
				$out .= ''
						. '<span class="titel">'
						. $title
						. '</span> &ndash; '
						. '<span class="referent">';
				if (isset($event_referentlink) && (strlen(trim($event_referentlink)) > 0)) {
					$out .= '<a href="' . $event_referentlink . '" title="' . $event_referentname . '">';
				}
					$out .= $event_referentname;
				if (isset($event_referentlink) && (strlen(trim($event_referentlink)) > 0)) {
					$out .= '</a>';
				}
				$out .= '</span><br />';


			} elseif (isset($format) && ($format == 'table') && ($single == 0)) {
			// format table
				// Datum
				$out .= "<tr class=\"event\">\n";
				if ($options['event-table-date']==1) {
					$out .= '<td>';
					if (isset($event_datum) && (strlen(trim($event_datum)) > 0)) {
						$out .= $event_datum; }
					$out .= '</td>';
				}
				//Titel (kein If, da immer vorhanden)
				$out .= '<th><a href="' . $event_link . '" title="' . $title . '">' . $title . '</a></th>';
				//Beginn
				if ($options['event-table-begin']==1) {
					$out .= '<td>';
					if (isset($event_beginn) && (strlen(trim($event_beginn)) > 0)) {
						$out .= $event_beginn; }
					$out .= '</td>';
				}
				//Ende
				if ($options['event-table-end']==1) {
					$out .= '<td>';
					if (isset($event_ende) && (strlen(trim($event_ende)) > 0)) {
						$out .= $event_ende; }
					$out .= '</td>';
				}
				//Ort
				if ($options['event-table-location']==1) {
					$out .= '<td>';
					if (isset($event_raum) && (strlen(trim($event_raum)) > 0)) {
						$out .= $event_raum; }
					$out .= '</td>';
				}
				//Referent
				if ($options['event-table-speaker']==1) {
					$out .= '<td>';
					if (isset($event_referentname) && (strlen(trim($event_referentname)) > 0)) {
						if (isset($event_referentlink) && (strlen(trim($event_referentlink)) > 0)) {
							$out .= '<a href="' . $event_referentlink . '" title="' . $event_referentname . '">';
						}
						$out .= $event_referentname;
						if (isset($event_referentlink) && (strlen(trim($event_referentlink)) > 0)) {
							$out .= '</a>';
						}
					}
					$out .= '</td>';
				}
				//Seminar-Kurzbezeichnung
				if ($options['event-table-short']==1) {
					$out .= '<td>';
					if (isset($event_kurz) && (strlen(trim($event_kurz)) > 0)) {
						$out .= $event_kurz;
					}
					$out .= '</td>';
				}
				//Max. Teilnehmerzahl
				if ($options['event-table-participants']==1) {
					$out .= '<td>';
					if (isset($event_max_teilnehmer) && (strlen(trim($event_max_teilnehmer)) > 0)) {
						$out .= $event_max_teilnehmer;
					}
					$out .= '</td>';
				}
				//Verfügbare Plätze
				if ($options['event-table-availible']==1) {
					$out .= '<td>';
					if (isset($event_verfuegbar) && (strlen(trim($event_verfuegbar)) > 0)) {
						$out .= $event_verfuegbar;
					}
					$out .= '</td>';
				}
				$out .= "</tr>\n";


			} else {
			// format other
				$out .= '<section class="shortcode event vevent" id="post-' . $post_id . '" >';
				$out .= "\n";
				$out .= '<header class="titel">';
				// Titel
				$out .= '<h2 class="summary">' . $title . '</h2>';
				// Referent
				if ((isset($event_referentname)) && ($showautor == 1)) {
					$out .= '<p class="referent">';
					if (isset($event_referentlink) && (strlen(trim($event_referentlink)) > 0)) {
						$out .= '<a href="' . $event_referentlink . '">';
					}
					$out .= $event_referentname;
					if (isset($event_referentlink) && (strlen(trim($event_referentlink)) > 0)) {
						$out .= '</a>';
					}
					$out .= '</p>';
				}
				// Termin = Ort und Zeit
				$raumstring = $vortragsraeume[$event_raum];
				//if ($datumset == 1) {
					$out .= '<ul class="termin">';
					$out .= '<li class="date dtstart" title="' . date('Y-m-d',strtotime($event_datum)) . '">Datum: ' . $event_datum . '</span></li>';
					$out .= '<li class="zeit">Zeit: <span class="dtstamp" title="' . $dtstamp_beginn . '">' . $event_beginn . '</span> - <span class="dtstamp" title="' . $dtstamp_ende . '">' . $event_ende . '</span> Uhr</li>';
					$out .= '<li class="ort">Ort: <span class="location">' . $raumstring . '</span></li>';
					$out .= '</ul>';
				//}

				$out .= '</header>';
				$out .= "\n";
				$out .= '<div class="event_daten">';
				$out .= "\n";
				$out .= '<article class="post-entry">';
				$out .= "\n";

				if (isset($event_kurztext) && (strlen(trim($event_kurztext)) > 0)) {
					$out .= '<p class="kurzbeschreibung">';
					$out .= $event_kurztext;
					$out .= '</p>';
				}

				if (isset($event_text) && (strlen(trim($event_text)) > 0)) {

					$out .= '<p class="detailbeschreibung">';
					$out .= $event_text;
					$out .= '</p>';
				}

				$out .= "</article>\n";

				if ((isset($event_aufzeichnung) && (strlen(trim($event_aufzeichnung)) > 0)) || (isset($event_folien) && (strlen(trim($event_folien)) > 0))) {
					$out .= '<footer>';
					$out .= '<ul class="medien">';
					if (isset($event_aufzeichnung) && (strlen(trim($event_aufzeichnung)) > 0)) {
						$out .= '<li class="video"><a href="' . $event_aufzeichnung . '">Videoaufzeichnung</a></li>';
					}
					if (isset($event_folien) && (strlen(trim($event_folien)) > 0)) {
						$out .= '<li class="folien"><a href="' . $event_folien . '">Vortragsfolien</a></li>';
					}
					$out .= '</ul>';
					$out .= '</footer>';
				}



				$out .= "</div>\n";
				$out .= "</section>\n";
			}
		}
		if (isset($format) && ($format == 'table') && ($single == 0)) {
			$out .= '</table>';
		}




		wp_reset_postdata();
	} else {
		$out = '<section class="shortcode event"><p>';
		$out .= __('No event information found.', 'luna');
		$out .= "</p></section>\n";
	}

	return $out;
}

add_shortcode('event', 'event_shortcode');



/* ---------------------------------------------------------------------------
 * Speaker Custom Post Type
 * ------------------------------------------------------------------------- */

function luna_speaker_post_type() {
	global $options;
	$slug_speaker = strtolower(sanitize_file_name($options['label-speaker-pl']));

	$labels = array(
		'name' => _x('Speakers', 'Post Type General Name', 'luna'),
		'singular_name' => _x('Speaker', 'Post Type Singular Name', 'luna'),
		'menu_name' => __('Speakers', 'luna'),
		'parent_item_colon' => __('Parent Item:', 'luna'),
		'all_items' => __('All Speakers', 'luna'),
		'view_item' => __('View Speaker', 'luna'),
		'add_new_item' => __('New Speaker', 'luna'),
		'add_new' => __('New', 'luna'),
		'edit_item' => __('Edit', 'luna'),
		'update_item' => __('Update', 'luna'),
		'search_items' => __('Search Speaker', 'luna'),
		'not_found' => __('Speaker not found', 'luna'),
		'not_found_in_trash' => __('Speaker not found in recycle bin', 'luna'),
	);
	$args = array(
		'label' => __('speaker', 'luna'),
		'description' => __('Add and edit speaker information', 'luna'),
		'labels' => $labels,
		'supports' =>  array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes' ),
		'hierarchical' => true,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_admin_bar' => true,
		'menu_position' => 6,
		'menu_icon' => 'dashicons-businessman',
		'can_export' => true,
		'has_archive' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'rewrite' => array('slug' => $slug_speaker, 'with_front' => FALSE),
		'capability_type' => 'page',
	);
	register_post_type('speaker', $args);
}

// Hook into the 'init' action
add_action('init', 'luna_speaker_post_type', 0);


function luna_speaker_taxonomies() {
	$labels = array();
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		'rewrite' => false,
	);
	register_taxonomy('speaker_category', 'speaker', $args);
}

add_action('init', 'luna_speaker_taxonomies');

/*
 * Metabox fuer weitere Speakerinfos
 */

function luna_speaker_metabox() {
	add_meta_box(
			'speaker_metabox',
			__('Speaker description', 'luna'),
			'speaker_metabox_content',
			'speaker',
			'normal',
			'high'
	);
}

function speaker_metabox_content($post) {
	global $defaultoptions;
	global $post;

	wp_nonce_field(plugin_basename(__FILE__), 'speaker_metabox_content_nonce');
	?>

	<p>
		<label for="speaker_website"><?php _e("Website", 'luna'); ?>:</label>
		<br />
		<input class="url" type="text" name="speaker_website"
			   id="speaker_website" value="<?php echo esc_attr(get_post_meta($post->ID, 'speaker_website', true)); ?>" size="30" />
	</p>

	<?php
}

add_action('add_meta_boxes', 'luna_speaker_metabox');

function speaker_metabox_save($post_id) {
	if ('speaker' != get_post_type()) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;

	if (!wp_verify_nonce($_POST['speaker_metabox_content_nonce'], plugin_basename(__FILE__)))
		return;

	/*if ('page' == $_POST['speaker']) {
		if (!current_user_can('edit_page', $post_id))
			return;
	} else {
		if (!current_user_can('edit_post', $post_id))
			return;
	}*/

	$url = $_POST['speaker_website'];
	if (filter_var($url, FILTER_VALIDATE_URL)) {
		update_post_meta($post_id, 'speaker_website', $url);
	}
}

add_action('save_post', 'speaker_metabox_save');

function speaker_metabox_updated_messages($messages) {
	global $post, $post_ID;
	$messages['speaker'] = array(
		0 => '',
		1 => __('Speaker information updated. ', 'luna'),
		2 => __('Speaker information updated.', 'luna'),
		3 => __('Speaker information deleted.', 'luna'),
		6 => __('Speaker information published.', 'luna'),
		7 => __('Speaker information saved.', 'luna'),
	);
	return $messages;
}

add_filter('post_updated_messages', 'speaker_metabox_updated_messages');
?>
