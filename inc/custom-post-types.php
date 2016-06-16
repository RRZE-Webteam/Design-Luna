<?php

/* ---------------------------------------------------------------------------
 * Talk Custom Post Type
 * ------------------------------------------------------------------------- */

// Register Custom Post Type
function luna_talk_post_type() {
    global $options;
    if (array_key_exists('label-talk-pl', $options) && $options['label-talk-pl'] !='') {
        $slug_talk = strtolower(sanitize_title($options['label-talk-pl']));
    } elseif (array_key_exists('label-talk', $options) && $options['label-talk'] !='') {
        $slug_talk = strtolower(sanitize_title($options['label-talk']));
    } else {
        $slug_talk = 'vortraege';
    }

    $labels = array(
        'name' => _x('Talks', 'Post Type General Name', 'luna'),
        'singular_name' => _x('Talk', 'Post Type Singular Name', 'luna'),
        'menu_name' => __('Talks', 'luna'),
        'parent_item_colon' => __('Parent Item:', 'luna'),
        'all_items' => __('All Talks', 'luna'),
        'view_item' => __('View Talk', 'luna'),
        'add_new_item' => __('New Talk', 'luna'),
        'add_new' => __('New', 'luna'),
        'edit_item' => __('Edit', 'luna'),
        'update_item' => __('Update', 'luna'),
        'search_items' => __('Search Talk', 'luna'),
        'not_found' => __('Talk not found', 'luna'),
        'not_found_in_trash' => __('Talk not found in recycle bin', 'luna'),
    );
    $args = array(
        'label' => __('talk', 'luna'),
        'description' => __('Add and edit talk information', 'luna'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'little-promo-boxes', 'comments', 'revisions', 'custom-fields', 'page-attributes'),
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
        'rewrite' => array('slug' => $slug_talk, 'with_front' => FALSE),
        'capability_type' => 'page',
    );
    register_post_type('talk', $args);
}

// Hook into the 'init' action
add_action('init', 'luna_talk_post_type', 0);

function luna_talk_taxonomies() {
    $labels = array();
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'rewrite' => false,
    );
    register_taxonomy('talk_category', 'talk', $args);
}

add_action('init', 'luna_talk_taxonomies');


/*
 * Metabox fuer weitere Talkinfo
 */

function luna_talk_metabox() {
    add_meta_box(
            'talk_metabox', __('Talk Information', 'luna'), 'talk_metabox_content', 'talk', 'normal', 'high'
    );
}

function talk_metabox_content($post) {
    global $defaultoptions;
    global $post;
    global $vortragsraeume;

    wp_nonce_field(plugin_basename(__FILE__), 'talk_metabox_content_nonce');
    ?>

    <p>
        <label for="talk_kurz"><?php _e("Code", 'luna'); ?>:</label>
        <input class="text" type="text" name="talk_kurz"
               id="talk_kurz" value="<?php echo esc_attr(get_post_meta($post->ID, 'talk_kurz', true)); ?>" size="30" />
    </p>
    <p>
        <label for="talk_datum"><?php _e("Date", 'luna'); ?>:</label>
        <input class="datepicker" type="text" name="talk_datum"
               id="talk_datum" value="<?php echo date('j.m.Y', strtotime(esc_attr(get_post_meta($post->ID, 'talk_datum', true)))); ?>" size="30" />
    </p>
    <p>
        <label for="talk_beginn"><?php _e("Time - from", 'luna'); ?>:</label>
        <input type="time" name="talk_beginn"
               id="talk_beginn" value="<?php echo esc_attr(get_post_meta($post->ID, 'talk_beginn', true)); ?>" size="10" />
        <label for="talk_ende"><?php _e("to", 'luna'); ?>:</label>
        <input type="time" name="talk_ende"
               id="talk_ende" value="<?php echo esc_attr(get_post_meta($post->ID, 'talk_ende', true)); ?>" size="10" />
    </p>
    <p>
        <label for="talk_raum"><?php _e("Location", 'luna'); ?>:</label>

        <select name="talk_raum"  id="talk_raum">
            <?php
            $liste = $vortragsraeume;
            $saal = esc_attr(get_post_meta($post->ID, 'talk_raum', true));


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
        <label for="talk_max-teilnehmer"><?php _e("Max. number of participants", 'luna'); ?>:</label>
        <input class="number" type="number" name="talk_max_teilnehmer"
               id="talk_max_teilnehmer" value="<?php echo esc_attr(get_post_meta($post->ID, 'talk_max_teilnehmer', true)); ?>" />
    </p>

    <p>
        <label for="talk_verfuegbar"><?php _e("Places available", 'luna'); ?>:</label>
        <input class="number" type="number" name="talk_verfuegbar"
               id="talk_verfuegbar" value="<?php echo esc_attr(get_post_meta($post->ID, 'talk_verfuegbar', true)); ?>" />
    </p>

    <p>
        <label for="talk_warteliste"><?php _e("Offer waiting list for fully booked talks", 'luna'); ?>
            <input class="checkbox" type="checkbox" name="talk_warteliste" id="talk_warteliste" <?php if (get_post_meta($post->ID, 'talk_warteliste', true) == "on") {
            echo ' checked="checked"';
        } ?> /></label>
    <?php print get_post_meta($post->ID, 'talk_warteliste', true); ?>
    </p>

    <p>
        <label for="talk_aufzeichnung"><?php _e("Enter URL for video (FAU Video portal): &quot;http://...&quot;", 'luna'); ?>:</label>
        <br />
        <input class="url" type="text" name="talk_aufzeichnung"
               id="talk_aufzeichnung" value="<?php echo esc_attr(get_post_meta($post->ID, 'talk_aufzeichnung', true)); ?>" size="30" />
    </p>
    <p>
        <label for="talk_folien"><?php _e("Enter URL to talk presentation slides: &quot;http://...&quot;", 'luna'); ?>:</label>
        <br />
        <input class="url" type="text" name="talk_folien"
               id="talk_folien" value="<?php echo esc_attr(get_post_meta($post->ID, 'talk_folien', true)); ?>" size="30" />
    </p>

    <?php
}

add_action('add_meta_boxes', 'luna_talk_metabox');

function talk_metabox_save($post_id) {
    if ('talk' != get_post_type())
        return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (!wp_verify_nonce($_POST['talk_metabox_content_nonce'], plugin_basename(__FILE__)))
        return;
    /* if ('page' == $_POST['post_type']) {
      if (!current_user_can('edit_page', $post_id))
      return;
      } else {
      if (!current_user_can('edit_post', $post_id))
      return;
      } */

    if (isset($_POST['talk_kurz'])) {
        update_post_meta($post_id, 'talk_kurz', sanitize_text_field($_POST['talk_kurz']));
    }
    if (isset($_POST['talk_datum'])) {
        update_post_meta($post_id, 'talk_datum', sanitize_text_field($_POST['talk_datum']));
    }
    if (isset($_POST['talk_beginn'])) {
        update_post_meta($post_id, 'talk_beginn', sanitize_text_field($_POST['talk_beginn']));
    }
    if (isset($_POST['talk_ende'])) {
        update_post_meta($post_id, 'talk_ende', sanitize_text_field($_POST['talk_ende']));
    }
    if (isset($_POST['talk_raum'])) {
        update_post_meta($post_id, 'talk_raum', sanitize_text_field($_POST['talk_raum']));
    }
    if (isset($_POST['talk_max_teilnehmer'])) {
        update_post_meta($post_id, 'talk_max_teilnehmer', sanitize_text_field($_POST['talk_max_teilnehmer']));
    }
    if (isset($_POST['talk_verfuegbar'])) {
        update_post_meta($post_id, 'talk_verfuegbar', sanitize_text_field($_POST['talk_verfuegbar']));
    }
    update_post_meta($post_id, 'talk_warteliste', $_POST['talk_warteliste']);

    $url = $_POST['talk_aufzeichnung'];
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        update_post_meta($post_id, 'talk_aufzeichnung', $url);
    }
    $url = $_POST['talk_folien'];
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        update_post_meta($post_id, 'talk_folien', $url);
    }
}

add_action('save_post', 'talk_metabox_save');

function talk_metabox_updated_messages($messages) {
    global $post, $post_ID;
    $messages['talk'] = array(
        0 => '',
        1 => __('Talk information updated. ', 'luna'),
        2 => __('Talk information updated.', 'luna'),
        3 => __('Talk information deleted.', 'luna'),
        6 => __('Talk information published.', 'luna'),
        7 => __('Talk information saved.', 'luna'),
    );
    return $messages;
}

add_filter('post_updated_messages', 'talk_metabox_updated_messages');



/*
 * Shortcode Definition
 */

function talk_shortcode($atts) {
    global $post;
    global $options;
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
            'post_type' => 'talk',
            'p' => $id
        );
        $single = 1;
    } elseif ((isset($cat)) && ( strlen(trim($cat)) > 0)) {
        $args = array(
            'post_type' => 'talk',
            'tax_query' => array(
                array(
                    'taxonomy' => 'talk_category',
                    'field' => 'slug',
                    'terms' => $cat
                )
            )
        );
    } else {
        $args = array(
            'post_type' => 'talk'
        );
    }

    $links = new WP_Query($args);
    if ($links->have_posts()) {
        $i = 0;
        $out = '';

        if (isset($format) && ($format == 'table') && ($single == 0)) {
            $out .= '<table class="talktabelle">
					<thead>
					<tr>';
            if ($options['talk-table-date'] == 1) {
                $out .= '<th scope="col" class="date">' . __('Date', 'luna') . '</th>';
            }
            $out .= '<th scope="col" class="titel">Titel</th>';
            if ($options['talk-table-begin'] == 1) {
                $out .= '<th scope="col" class="time">' . __('Start', 'luna') . '</th>';
            }
            if ($options['talk-table-end'] == 1) {
                $out .= '<th scope="col" class="time">' . __('End', 'luna') . '</th>';
            }
            if ($options['talk-table-location'] == 1) {
                $out .= '<th scope="col" class="location">' . __('Location', 'luna') . '</th>';
            }
            if ($options['talk-table-speaker'] == 1) {
                $out .= '<th scope="col" class="time">' . $options['label-speaker'] . '</th>';
            }
            if ($options['talk-table-short'] == 1) {
                $out .= '<th scope="col" class="time">' . $options['label-short'] . '</th>';
            }
            if ($options['talk-table-participants'] == 1) {
                $out .= '<th scope="col" class="time">' . __('Participants', 'luna') . '</th>';
            }
            if ($options['talk-table-availible'] == 1) {
                $out .= '<th scope="col" class="time">' . __('Available', 'luna') . '</th>';
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
            $talk_kurztext = $post->post_excerpt;
            $talk_text = $post->post_content;
            $talk_link = get_permalink();
            $talk_referentname = get_post(get_post_meta($post_id, '_selected_speaker', true))->post_title;
            $talk_referentlink = get_post_permalink(get_post_meta($post_id, '_selected_speaker', true));
            $talk_kurz = get_post_meta($post_id, 'talk_kurz', true);
            $talk_datum = get_post_meta($post_id, 'talk_datum', true);
            $talk_beginn = get_post_meta($post_id, 'talk_beginn', true);
            $dtstamp_beginn = date('Ymd', strtotime($talk_datum)) . "T" . date('Hi', strtotime($talk_beginn));
            $talk_ende = get_post_meta($post_id, 'talk_ende', true);
            $dtstamp_ende = date('Ymd', strtotime($talk_datum)) . "T" . date('Hi', strtotime($talk_ende));
            $talk_raum = get_post_meta($post_id, 'talk_raum', true);
            $talk_max_teilnehmer = get_post_meta($post_id, 'talk_max_teilnehmer', true);
            $talk_verfuegbar = get_post_meta($post_id, 'talk_verfuegbar', true);
            $talk_aufzeichnung = get_post_meta($post_id, 'talk_aufzeichnung', true);
            $talk_folien = get_post_meta($post_id, 'talk_folien', true);

            if (isset($id) && isset($format) && ($format == 'short')) {
                // format short
                $out .= ''
                        . '<span class="titel">'
                        . $title
                        . '</span> &ndash; '
                        . '<span class="referent">';
                if (isset($talk_referentlink) && (strlen(trim($talk_referentlink)) > 0)) {
                    $out .= '<a href="' . $talk_referentlink . '" title="' . $talk_referentname . '">';
                }
                $out .= $talk_referentname;
                if (isset($talk_referentlink) && (strlen(trim($talk_referentlink)) > 0)) {
                    $out .= '</a>';
                }
                $out .= '</span><br />';
            } elseif (isset($format) && ($format == 'table') && ($single == 0)) {
                // format table
                // Datum
                $out .= "<tr class=\"talk\">\n";
                if ($options['talk-table-date'] == 1) {
                    $out .= '<td>';
                    if (isset($talk_datum) && (strlen(trim($talk_datum)) > 0)) {
                        $out .= $talk_datum;
                    }
                    $out .= '</td>';
                }
                //Titel (kein If, da immer vorhanden)
                $out .= '<th><a href="' . $talk_link . '" title="' . $title . '">' . $title . '</a></th>';
                //Beginn
                if ($options['talk-table-begin'] == 1) {
                    $out .= '<td>';
                    if (isset($talk_beginn) && (strlen(trim($talk_beginn)) > 0)) {
                        $out .= $talk_beginn;
                    }
                    $out .= '</td>';
                }
                //Ende
                if ($options['talk-table-end'] == 1) {
                    $out .= '<td>';
                    if (isset($talk_ende) && (strlen(trim($talk_ende)) > 0)) {
                        $out .= $talk_ende;
                    }
                    $out .= '</td>';
                }
                //Ort
                if ($options['talk-table-location'] == 1) {
                    $out .= '<td>';
                    if (isset($talk_raum) && (strlen(trim($talk_raum)) > 0)) {
                        $out .= $talk_raum;
                    }
                    $out .= '</td>';
                }
                //Referent
                if ($options['talk-table-speaker'] == 1) {
                    $out .= '<td>';
                    if (isset($talk_referentname) && (strlen(trim($talk_referentname)) > 0)) {
                        if (isset($talk_referentlink) && (strlen(trim($talk_referentlink)) > 0)) {
                            $out .= '<a href="' . $talk_referentlink . '" title="' . $talk_referentname . '">';
                        }
                        $out .= $talk_referentname;
                        if (isset($talk_referentlink) && (strlen(trim($talk_referentlink)) > 0)) {
                            $out .= '</a>';
                        }
                    }
                    $out .= '</td>';
                }
                //Seminar-Kurzbezeichnung
                if ($options['talk-table-short'] == 1) {
                    $out .= '<td>';
                    if (isset($talk_kurz) && (strlen(trim($talk_kurz)) > 0)) {
                        $out .= $talk_kurz;
                    }
                    $out .= '</td>';
                }
                //Max. Teilnehmerzahl
                if ($options['talk-table-participants'] == 1) {
                    $out .= '<td>';
                    if (isset($talk_max_teilnehmer) && (strlen(trim($talk_max_teilnehmer)) > 0)) {
                        $out .= $talk_max_teilnehmer;
                    }
                    $out .= '</td>';
                }
                //Verfügbare Plätze
                if ($options['talk-table-availible'] == 1) {
                    $out .= '<td>';
                    if (isset($talk_verfuegbar) && (strlen(trim($talk_verfuegbar)) > 0)) {
                        $out .= $talk_verfuegbar;
                    }
                    $out .= '</td>';
                }
                $out .= "</tr>\n";
            } else {
                // format other
                $out .= '<section class="shortcode talk vtalk" id="post-' . $post_id . '" >';
                $out .= "\n";
                $out .= '<header class="titel">';
                // Titel
                $out .= '<h3 class="summary">' . $title . '</h3>';
                // Referent
                if ((isset($talk_referentname)) && ($showautor == 1)) {
                    $out .= '<p class="referent">';
                    if (isset($talk_referentlink) && (strlen(trim($talk_referentlink)) > 0)) {
                        $out .= '<a href="' . $talk_referentlink . '">';
                    }
                    $out .= $talk_referentname;
                    if (isset($talk_referentlink) && (strlen(trim($talk_referentlink)) > 0)) {
                        $out .= '</a>';
                    }
                    $out .= '</p>';
                }
                // Termin = Ort und Zeit
                $raumstring = $vortragsraeume[$talk_raum];
                //if ($datumset == 1) {
                $out .= '<ul class="termin">';
                $out .= '<li class="date dtstart" title="' . date('Y-m-d', strtotime($talk_datum)) . '">Datum: ' . $talk_datum . '</span></li>';
                $out .= '<li class="zeit">Zeit: <span class="dtstamp" title="' . $dtstamp_beginn . '">' . $talk_beginn . '</span> - <span class="dtstamp" title="' . $dtstamp_ende . '">' . $talk_ende . '</span> Uhr</li>';
                $out .= '<li class="ort">Ort: <span class="location">' . $raumstring . '</span></li>';
                $out .= '</ul>';
                //}

                $out .= '</header>';
                $out .= "\n";
                $out .= '<div class="talk_daten">';
                $out .= "\n";
                $out .= '<article class="post-entry">';
                $out .= "\n";

                if (isset($talk_kurztext) && (strlen(trim($talk_kurztext)) > 0)) {
                    $out .= '<p class="kurzbeschreibung">';
                    $out .= $talk_kurztext;
                    $out .= '</p>';
                }

                if (isset($talk_text) && (strlen(trim($talk_text)) > 0)) {

                    $out .= '<p class="detailbeschreibung">';
                    $out .= $talk_text;
                    $out .= '</p>';
                }

                $out .= "</article>\n";

                if ((isset($talk_aufzeichnung) && (strlen(trim($talk_aufzeichnung)) > 0)) || (isset($talk_folien) && (strlen(trim($talk_folien)) > 0))) {
                    $out .= '<footer>';
                    $out .= '<ul class="medien">';
                    if (isset($talk_aufzeichnung) && (strlen(trim($talk_aufzeichnung)) > 0)) {
                        $out .= '<li class="video"><a href="' . $talk_aufzeichnung . '">Videoaufzeichnung</a></li>';
                    }
                    if (isset($talk_folien) && (strlen(trim($talk_folien)) > 0)) {
                        $out .= '<li class="folien"><a href="' . $talk_folien . '">Vortragsfolien</a></li>';
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
        $out = '<section class="shortcode talk"><p>';
        $out .= __('No talk information found.', 'luna');
        $out .= "</p></section>\n";
    }

    return $out;
}

add_shortcode('talk', 'talk_shortcode');



/* ---------------------------------------------------------------------------
 * Speaker Custom Post Type
 * ------------------------------------------------------------------------- */

function luna_speaker_post_type() {
    global $options;
    
    if (array_key_exists('label-speaker-pl', $options) && $options['label-speaker-pl'] !='') {
        $slug_speaker = strtolower(sanitize_title($options['label-speaker-pl']));
    } elseif (array_key_exists('label-speaker', $options) && $options['label-speaker'] !='') {
        $slug_speaker = strtolower(sanitize_title($options['label-speaker']));
    } else {
        $slug_speaker = 'referenten';
    }

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
        'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes'),
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
            'speaker_metabox', __('Speaker description', 'luna'), 'speaker_metabox_content', 'speaker', 'normal', 'high'
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

    /* if ('page' == $_POST['speaker']) {
      if (!current_user_can('edit_page', $post_id))
      return;
      } else {
      if (!current_user_can('edit_post', $post_id))
      return;
      } */

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
