<?php

/**
 * Luna  Constants
 *
 * */
global $options;

$defaultoptions = array(
	'js-version' => '1.1',
	'default-color' => 'e6e6e6',
	'thumbnail-width' => 624,
	'thumbnail-height' => 9999,
	'content-width' => 625,
	'bannerlink-width' => 180,
	/* Max width for Logos and Images in Sidebar */
	'bannerlink-height' => 360,
	/* Max height for Logos and Images in Sidebar */
	'src_basemod_zusatzinfo' => '/css/basemod_zusatzinfo.css',
	'aktiv-basemod_zusatzinfo' => 1,
	'src_basemod_links' => '/css/basemod_links.css',
	'aktiv-basemod_links' => 1,
	'src_basemod_sidebar' => '/css/basemod_sidebar.css',
	'aktiv-basemod_sidebar' => 1,
	'src_basemod_blau' => '/css/basemod_blau.css',
	'aktiv-basemod_blau' => 1,
	'src_socialmediabuttons' => '/css/basemod_socialmediaicons.css',
	'aktiv-socialmediabuttons' => 1,
	'aktiv-post-sm-buttons' => 1,
	'aktiv-facebook-share' => 1,
	'aktiv-twitter-share' => 1,
	'aktiv-autoren' => 1,
	'aktiv-commentreplylink' => 0,
	'default_comment_notes_before' => '<p class="comment-notes">' . __('Your email address will not be published. Required fields are highlighted: ', 'luna') . '<span class=\"required\">*</span></p>',
	'disclaimer_post' => '',
	'background-header-color' => 'ffffff',
	'background-header-image' => '',
	'login_errors' => 0,
	'src-breadcrumb-image' => get_template_directory_uri() . '/images/breadcrumbarrow.gif',
	'src-teaser-thumbnail_default' => '',
	'category-teaser' => 1,
	'category-num-article-fullwidth' => 10,
	'category-num-article-halfwidth' => 0,
	'category-teaser-maxlength' => 500,
	'category-teaser-datebox' => 0,
	/*
	 * 1 = Thumbnail (or: first picture, first video, fallback picture),
	 * 2 = First picture (or: thumbnail, first video, fallback picture),
	 * 3 = First video (or: thumbnail, first picture, fallback picture),
	 * 4 = First video (or: first picture, thumbnail, fallback picture),
	 * 5 = Nothing */
	'category-teaser-floating' => 0,
	'category-teaser-dateline' => 0, /* 1 = show Date on line up of the text if no datebox */
	'category-teaser-maxlength-halfwidth' => 200,
	'category-teaser-datebox-halfwidth' => 1,
	'category-teaser-floating-halfwidth' => 1,
	'category-teaser-dateline-halfwidth' => 0, /* 1 = show Date on line up of the text if no datebox */
	'num-article-startpage-fullwidth' => 1,
	'num-article-startpage-halfwidth' => 4,
	'teaser-thumbnail_width' => 120,
	'teaser-thumbnail_height' => 120,
	'teaser-thumbnail_crop' => 0,
	'src-teaser-thumbnail_default' => get_template_directory_uri() . '/images/default-teaserthumb.gif',
	'teaser-thumbnail_fallback' => 1,
	'teaser-title-maxlength' => 50,
	'teaser-subtitle' => __('Sticky ', 'luna'),
	'teaser-title-words' => 7,
	'teaser_maxlength' => 500,
	'teaser-datebox' => 0,
	'teaser-floating' => 0,
	'teaser-dateline' => 0, /* 1 = show Date on line up of the text if no datebox */
	'teaser-maxlength-halfwidth' => 200,
	'teaser-datebox-halfwidth' => 1,
	'teaser-floating-halfwidth' => 1,
	'teaser-dateline-halfwidth' => 0, /* 1 = show Date on line up of the text if no datebox */
	'headerbox-datum' => '20.03.<br />+ 21.03.',
	'headerbox-ort' => 'Webkongress <br /> Erlangen <span class="jahr">2014</span>',
	'text-startseite' => __('Home', 'luna'),
	'default_text_title_home_backlink' => __('Back to Home page', 'luna'),
	'default_footerlink_key' => 'Fakultaeten',
	'aktiv-buttons' => 1,
	'aktiv-anmeldebutton' => 1,
	'url-anmeldebutton' => 'http://de.amiando.com/wke2014.html',
	'title-anmeldebutton' => 'Tickets kaufen',
	'color-anmeldebutton' => 'gruen',
	'aktiv-cfpbutton' => 1,
	'url-cfpbutton' => '/programm/vortragsvorschlag-einreichen-call-for-paper/',
	'title-cfpbutton' => 'Vortrag einreichen',
	'color-cfpbutton' => 'gelb',
	'aktiv-slider' => 1,
	'aktiv-registration-link' => 1,
	'yt-alternativeembed' => 1,
	/* YouTube Videos ueber eigenen Embedcode gestalten und an youtbe-nocookie lenken */
	'yt-norel' => 1,
	/* Keine weiteren Videos vorschlagen */
	'yt-content-width' => 665,
	'yt-content-height' => 500,
);

/*
 * Liste Social Media Share
 */
$default_socialmedia_post_liste = array(
	'facebook_share' => array(
		'name' => 'Facebook',
		'link' => 'https://www.facebook.com/sharer/sharer.php?u=',
		'link_title' => __('Share on Facebook', 'luna'),
	),
	'twitter_share' => array(
		'name' => 'Twitter',
		'link' => 'https://twitter.com/intent/tweet?&url=',
		'link_title' => __('Share on Twitter', 'luna'),
	),
);

/*
 * Liste Social Media Follow
 */
$default_socialmedia_liste = array(
	'delicious' => array(
		'name' => 'Delicious',
		'content' => '',
		'active' => 0,
	),
	'diaspora' => array(
		'name' => 'Diaspora',
		'content' => '',
		'active' => 0,
	),
	'facebook_follow' => array(
		'name' => 'Facebook',
		'content' => 'https://www.facebook.com/pages/Webkongress-Erlangen',
		'active' => 1,
	),
	'twitter_follow' => array(
		'name' => 'Twitter',
		'content' => 'https://twitter.com/#!/wke',
		'active' => 1,
	),
	'gplus' => array(
		'name' => 'Google Plus',
		'content' => '',
		'active' => 1,
	),
	'flattr' => array(
		'name' => 'Flattr',
		'content' => '',
		'active' => 0,
	),
	'flickr' => array(
		'name' => 'Flickr',
		'content' => 'http://flickr.com/photos/tags/wke2010/',
		'active' => 0,
	),
	'identica' => array(
		'name' => 'Identica',
		'content' => '',
		'active' => 0,
	),
	'itunes' => array(
		'name' => 'iTunes',
		'content' => '',
		'active' => 0,
	),
	'skype' => array(
		'name' => 'Skype',
		'content' => '',
		'active' => 0,
	),
	'youtube' => array(
		'name' => 'YouTube',
		'content' => '',
		'active' => 1,
	),
	'xing' => array(
		'name' => 'Xing',
		'content' => '',
		'active' => 0,
	),
	'tumblr' => array(
		'name' => 'Tumblr',
		'content' => '',
		'active' => 1,
	),
	'github' => array(
		'name' => 'GitHub',
		'content' => '',
		'active' => 0,
	),
	'appnet' => array(
		'name' => 'App.Net',
		'content' => '',
		'active' => 0,
	),
	'feed' => array(
		'name' => 'RSS Feed',
		'content' => get_bloginfo('rss2_url'),
		'active' => 1,
	),
);

/*
 * Linkliste fuer Footer und Widgets
 */
$default_footerlink_liste = array(
	__('Faculties', 'luna') => array(
		'title' => __('Friedrich-Alexander-Universit&auml;t Erlangen-N&uuml;rnberg', 'luna'),
		'url' => 'http://www.fau.de',
		'sublist' => array(
			__('Faculty of Humanities, Social Sciences, and Theology', 'luna') => 'http://www.phil.faude/',
			__('Faculty of Business, Economics, and Law', 'luna') => 'http://www.rw.fau.de/',
			__('Faculty of Medicine', 'luna') => 'http://www.med.fau.de/',
			__('Faculty of Sciences', 'luna') => 'http://www.natfak.fau.de/',
			__('Faculty of Engineering', 'luna') => 'http://www.techfak.fau.de/',
		)
	),
	__('RRZE', 'luna') => array(
		'title' => __('Regional Computing Centre Erlangen', 'luna'),
		'url' => 'http://www.rrze.fau.de',
		'sublist' => array(
			__('Service Desk', 'luna') => 'http://www.rrze.fau.de/hilfe/service-theke',
			__('Information Centre City', 'luna') => 'http://www.izi.rrze.fau.de/',
			__('Information Centre Nuremberg', 'luna') => 'http://www.zzn.rrze.fau.de/',
			__('Information Centre Halbmondstrasse', 'luna') => 'http://www.izh.rrze.fau.de/',
			__('Blog Service', 'luna') => 'http://blogs.fau.de/',
			__('Video Portal', 'luna') => 'http://video.fau.de/',
			__('IDM', 'luna') => 'https://www.idm.fau.de/',
			__('News', 'luna') => 'http://blogs.fau.de/rrze/',
		)
	),
);



/*
 * Definition welche Konstanten als Optionen im Backend geaendert werden koennen
 */


$setoptions = array(
	'luna_theme_options' => array(
		'design' => array(
			'tabtitle' => __('Design', 'luna'),
			'fields' => array(
				'aktiv-basemod_sidebar' => array(
					'type' => 'bool',
					'title' => __('Sidebar', 'luna'),
					'label' => __('Show second sidebar', 'luna'),
					'default' => $defaultoptions['aktiv-basemod_sidebar'],
				),
				'aktiv-basemod_zusatzinfo' => array(
					'type' => 'bool',
					'title' => __('Additional Info', 'luna'),
					'label' => __('Show additional info area', 'luna'),
					'default' => $defaultoptions['aktiv-basemod_zusatzinfo'],
				),
				'aktiv-basemod_links' => array(
					'type' => 'bool',
					'title' => __('Link Icons', 'luna'),
					'label' => __('Add link icons', 'luna'),
					'default' => $defaultoptions['aktiv-basemod_links'],
				),
				'headerbox-logo' => array(
					'type' => 'mediaupload',
					'title' => __('Logo', 'luna'),
					'label' => __('Show Logo in Header Area', 'luna'),
				),
				'headerbox-datum' => array(
					'type' => 'html',
					'title' => __('Date', 'luna'),
					'label' => __('Show event date in header', 'luna'),
					'default' => $defaultoptions['headerbox-datum'],
				),
				'headerbox-ort' => array(
					'type' => 'html',
					'title' => __('Location', 'luna'),
					'label' => __('Show event location in header', 'luna'),
					'default' => $defaultoptions['headerbox-ort'],
				),
				'text-startseite' => array(
					'type' => 'text',
					'title' => __('Home page name', 'luna'),
					'label' => __('Name of the home page for breadcrumb navigation', 'luna'),
					'default' => $defaultoptions['text-startseite'],
				),
				'aktiv-autoren' => array(
					'type' => 'bool',
					'title' => __('Show authors', 'luna'),
					'label' => __('Show link to authors in articles', 'luna'),
					'default' => $defaultoptions['aktiv-autoren'],
				),
				'aktiv-slider' => array(
					'type' => 'bool',
					'title' => __('Slider', 'luna'),
					'label' => __('Use slider for content types (e.g. articles, events or speakers). See Help panel.', 'luna'),
					'default' => $defaultoptions['aktiv-slider'],
				),
				'buttons' => array(
					'type' => 'section',
					'title' => __('Buttons', 'luna'),
				),
				'aktiv-buttons' => array(
					'type' => 'bool',
					'title' => __('Show&nbsp;Buttons', 'luna'),
					'label' => __('Display custom buttons on top of the second sidebar', 'luna'),
					'default' => $defaultoptions['aktiv-buttons'],
					'parent' => 'buttons'
				),
				'aktiv-anmeldebutton' => array(
					'type' => 'bool',
					'title' => __('First&nbsp;Button', 'luna'),
					'label' => __('Show', 'luna'),
					'default' => $defaultoptions['aktiv-anmeldebutton'],
					'parent' => 'buttons'
				),
				'url-anmeldebutton' => array(
					'type' => 'url',
					'title' => __('URL', 'luna'),
					'label' => __('Target URL', 'luna'),
					'default' => $defaultoptions['url-anmeldebutton'],
					'parent' => 'buttons'
				),
				'title-anmeldebutton' => array(
					'type' => 'text',
					'title' => __('Button label', 'luna'),
					'label' => __('Button label', 'luna'),
					'default' => $defaultoptions['title-anmeldebutton'],
					'parent' => 'buttons'
				),
				'color-anmeldebutton' => array(
					'type' => 'select',
					'title' => __('Color', 'luna'),
					'label' => __('Button background color', 'luna'),
					'default' => $defaultoptions['color-anmeldebutton'],
					'liste' => array(
						'grau' => __("Grey", "luna"),
						'gelb' => __("Yellow", "luna"),
						'gruen' => __("Green", "luna"),
						'blau' => __("Blue", "luna"),
					),
					'parent' => 'buttons'
				),
				'aktiv-cfpbutton' => array(
					'type' => 'bool',
					'title' => __('Second&nbsp;Button', 'luna'),
					'label' => __('Show', 'luna'),
					'default' => $defaultoptions['aktiv-cfpbutton'],
					'parent' => 'buttons'
				),
				'url-cfpbutton' => array(
					'type' => 'url',
					'title' => __('URL', 'luna'),
					'label' => __('Target URL', 'luna'),
					'default' => $defaultoptions['url-cfpbutton'],
					'parent' => 'buttons'
				),
				'title-cfpbutton' => array(
					'type' => 'text',
					'title' => __('Button label', 'luna'),
					'label' => __('Button label', 'luna'),
					'default' => $defaultoptions['title-cfpbutton'],
					'parent' => 'buttons'
				),
				'color-cfpbutton' => array(
					'type' => 'select',
					'title' => __('Color', 'luna'),
					'label' => __('Button background color', 'luna'),
					'default' => $defaultoptions['color-cfpbutton'],
					'liste' => array(
						'grau' => __("Grey", "luna"),
						'gelb' => __("Yellow", "luna"),
						'gruen' => __("Green", "luna"),
						'blau' => __("Blue", "luna"),
					),
					'parent' => 'buttons'
				),
			)
		),
		'startseite' => array(
			'tabtitle' => __('Home Page', 'luna'),
			'fields' => array(
				'description' => array(
					'type' => 'description',
					'title' => __('Home page settings', 'luna'),
				),
				'teaser-title-maxlength' => array(
					'type' => 'number',
					'title' => __('Title text length', 'luna'),
					'label' => __('Maximum title length (number of characters)', 'luna'),
					'default' => $defaultoptions['teaser-title-maxlength'],
				),
				'teaser-title-words' => array(
					'type' => 'number',
					'title' => __('Title words', 'luna'),
					'label' => __('Maximum number of words in title (limited by the title text length)', 'luna'),
					'default' => $defaultoptions['teaser-title-words'],
				),
				'teaser-fullwidth' => array(
					'type' => 'section',
					'title' => __('Full width articles', 'luna'),
				),
				'num-article-startpage-fullwidth' => array(
					'type' => 'number',
					'title' => __('Count', 'luna'),
					'label' => __('Number of articles displayed in full width', 'luna'),
					'default' => $defaultoptions['num-article-startpage-fullwidth'],
					'parent' => 'teaser-fullwidth'
				),
				'teaser_maxlength' => array(
					'type' => 'number',
					'title' => __('Teaser length', 'luna'),
					'label' => __('Maximum teaser length on home page', 'luna'),
					'default' => $defaultoptions['teaser_maxlength'],
					'parent' => 'teaser-fullwidth'
				),
				'teaser-dateline' => array(
					'type' => 'bool',
					'title' => __('Date line', 'luna'),
					'label' => __('Show article date with the teaser', 'luna'),
					'default' => $defaultoptions['teaser-dateline'],
					'parent' => 'teaser-fullwidth'
				),
				'teaser-datebox' => array(
					'type' => 'select',
					'title' => __('Teaser image', 'luna'),
					'label' => __('Show featured image, first image or first video in article as teaser image.', 'luna'),
					'default' => $defaultoptions['teaser-datebox'],
					'liste' => array(
						1 => __("Order: Article image, first image, first video, default image", "luna"),
						2 => __("Order: First image, article image, first video, default image", "luna"),
						3 => __("Order: First video, article image, first image, default image", "luna"),
						4 => __("Order: First video, first image, article image, default image", "luna"),
						5 => __("No image", "luna")),
					'parent' => 'teaser-fullwidth'
				),
				'teaser-halfwidth' => array(
					'type' => 'section',
					'title' => __('Half width articles', 'luna'),
				),
				'num-article-startpage-halfwidth' => array(
					'type' => 'select',
					'title' => __('Count', 'luna'),
					'label' => __('Number of articles displayed in half width', 'luna'),
					'liste' => array(0 => 0, 2 => 2, 4 => 4, 6 => 6, 8 => 8),
					'default' => $defaultoptions['num-article-startpage-halfwidth'],
					'parent' => 'teaser-halfwidth'
				),
				'teaser-maxlength-halfwidth' => array(
					'type' => 'number',
					'title' => __('Teaser length', 'luna'),
					'label' => __('Maximum teaser length (half width articles)', 'luna'),
					'default' => $defaultoptions['teaser-maxlength-halfwidth'],
					'parent' => 'teaser-halfwidth'
				),
				'teaser-dateline-halfwidth' => array(
					'type' => 'bool',
					'title' => __('Date line', 'luna'),
					'label' => __('Show article date with the teaser', 'luna'),
					'default' => $defaultoptions['teaser-dateline-halfwidth'],
					'parent' => 'teaser-halfwidth'
				),
				'teaser-datebox-halfwidth' => array(
					'type' => 'select',
					'title' => __('Teaser image', 'luna'),
					'label' => __('Show featured image, first image or first video in article as teaser image.', 'luna'),
					'default' => $defaultoptions['teaser-datebox-halfwidth'],
					'liste' => array(
						1 => __("Order: Article image, first image, first video, default image", "luna"),
						2 => __("Order: First image, article image, first video, default image", "luna"),
						3 => __("Order: First video, article image, first image, default image", "luna"),
						4 => __("Order: First video, first image, article image, default image", "luna"),
						5 => __("No image", "luna")),
					'parent' => 'teaser-halfwidth'
				),
			),
		),
		'Indexseiten' => array(
			'tabtitle' => __('Index pages', 'luna'),
			'fields' => array(
				'category-description' => array(
					'type' => 'description',
					'title' => __('Archive page settings (category, tag, date, author etc)', 'luna'),
				),
				'category-fullwidth' => array(
					'type' => 'section',
					'title' => __('Full width articles', 'luna'),
				),
				'category-num-article-fullwidth' => array(
					'type' => 'number',
					'title' => __('Count', 'luna'),
					'label' => __('Number of articles displayed in full width', 'luna'),
					'default' => $defaultoptions['category-num-article-fullwidth'],
					'parent' => 'category-fullwidth'
				),
				'category-teaser-maxlength' => array(
					'type' => 'number',
					'title' => __('Teaser length', 'luna'),
					'label' => __('Maximum teaser length (full width articles)', 'luna'),
					'default' => $defaultoptions['category-teaser-maxlength'],
					'parent' => 'category-fullwidth'
				),
				'category-teaser-datebox' => array(
					'type' => 'select',
					'title' => __('Teaser image', 'luna'),
					'label' => __('Show featured image, first image or first video in article as teaser image.', 'luna'),
					'default' => $defaultoptions['category-teaser-datebox'],
					'liste' => array(
						1 => __("Order: Article image, first image, first video, default image", "luna"),
						2 => __("Order: First image, article image, first video, default image", "luna"),
						3 => __("Order: First video, article image, first image, default image", "luna"),
						4 => __("Order: First video, first image, article image, default image", "luna"),
						5 => __("No image", "luna")),
					'parent' => 'category-fullwidth'
				),
				'category-teaser-floating' => array(
					'type' => 'bool',
					'title' => __('Floating Text', 'luna'),
					'label' => __('Text floating around the image', 'luna'),
					'default' => $defaultoptions['category-teaser-floating'],
					'parent' => 'category-fullwidth'
				),
				'category-teaser-dateline' => array(
					'type' => 'bool',
					'title' => __('Date line', 'luna'),
					'label' => __('Show article date with the teaser', 'luna'),
					'default' => $defaultoptions['category-teaser-dateline'],
					'parent' => 'category-fullwidth'
				),
				'category-halfwidth' => array(
					'type' => 'section',
					'title' => __('Half width articles', 'luna'),
				),
				'category-num-article-halfwidth' => array(
					'type' => 'select',
					'title' => __('Count', 'luna'),
					'label' => __('Number of articles displayed in half width', 'luna'),
					'liste' => array(0 => 0, 2 => 2, 4 => 4, 6 => 6, 8 => 8, 10 => 10, 12 => 12, 14 => 14, 16 => 16),
					'default' => $defaultoptions['category-num-article-halfwidth'],
					'parent' => 'category-halfwidth'
				),
				'category-teaser-maxlength-halfwidth' => array(
					'type' => 'number',
					'title' => __('Teaser length', 'luna'),
					'label' => __('Maximum teaser length (half width articles)', 'luna'),
					'default' => $defaultoptions['category-teaser-maxlength-halfwidth'],
					'parent' => 'category-halfwidth'
				),
				'category-teaser-datebox-halfwidth' => array(
					'type' => 'select',
					'title' => __('Teaser image', 'luna'),
					'label' => __('Show featured image, first image or first video in article as teaser image.', 'luna'),
					'default' => $defaultoptions['category-teaser-datebox-halfwidth'],
					'liste' => array(
						1 => __("Order: Article image, first image, first video, default image", "luna"),
						2 => __("Order: First image, article image, first video, default image", "luna"),
						3 => __("Order: First video, article image, first image, default image", "luna"),
						4 => __("Order: First video, first image, article image, default image", "luna"),
						5 => __("No image", "luna")),
					'parent' => 'category-halfwidth'
				),
				'category-teaser-floating-halfwidth' => array(
					'type' => 'bool',
					'title' => __('Floating Text', 'luna'),
					'label' => __('Text floating around the image', 'luna'),
					'default' => $defaultoptions['category-teaser-floating-halfwidth'],
					'parent' => 'category-halfwidth'
				),
				'category-teaser-dateline-halfwidth' => array(
					'type' => 'bool',
					'title' => __('Date line', 'luna'),
					'label' => __('Show article date with the teaser', 'luna'),
					'default' => $defaultoptions['category-teaser-dateline-halfwidth'],
					'parent' => 'category-halfwidth'
				),
			)
		),
		'Veranstaltungen' => array(
			'tabtitle' => __('Events', 'luna'),
			'fields' => array(
				'labels-event' => array(
					'type' => 'section',
					'title' => __('Event label', 'luna'),
				),
				'label-event' => array(
					'type' => 'text',
					'title' => __('Singular', 'luna'),
					'label' => __('Denotation of the events (e.g. Workshop, Course, Conference etc)', 'luna'),
					'default' =>  __('Event','luna'),
					'parent' => 'labels-event'
				),
				'label-event-pl' => array(
					'type' => 'text',
					'title' => __('Plural', 'luna'),
					'label' => __('Denotation of the events (e.g. Workshop, Course, Conference etc)', 'luna'),
					'default' =>  __('Events','luna'),
					'parent' => 'labels-event'
				),
				'labels-speaker' => array(
					'type' => 'section',
					'title' => __('Speaker label', 'luna'),
				),
				'label-speaker' => array(
					'type' => 'text',
					'title' => __('Singular', 'luna'),
					'label' => __('Denotation of the speakers (e.g. lecturer, speaker, contributor etc)', 'luna'),
					'default' =>  __('Speaker','luna'),
					'parent' => 'labels-speaker'
				),
				'label-speaker-pl' => array(
					'type' => 'text',
					'title' => __('Plural', 'luna'),
					'label' => __('Denotation of the speakers (e.g. lecturer, speaker, contributor etc)', 'luna'),
					'default' =>  __('Speakers','luna'),
					'parent' => 'labels-speaker'
				),
				'labels-short' => array(
					'type' => 'section',
					'title' => __('Code label', 'luna'),
				),
				'label-short' => array(
					'type' => 'text',
					'title' => __('Label', 'luna'),
					'label' => __('Denotation of the event code (e.g. Course Nr, ID etc)', 'luna'),
					'default' =>  __('Seminar Nr','luna'),
					'parent' => 'labels-short'
				),
				'event-fields-table' => array(
					'type' => 'section',
					'title' => __('Fields displayed in event overview table', 'luna'),
				),
				'event-table-date' => array(
					'type' => 'bool',
					'title' => __('Date', 'luna'),
					'label' => __('Show event date', 'luna'),
					'default' => 1,
					'parent' => 'event-fields-table'
				),
				'event-table-begin' => array(
					'type' => 'bool',
					'title' => __('Start time', 'luna'),
					'label' => __('Show start time of the event', 'luna'),
					'default' => 1,
					'parent' => 'event-fields-table'
				),
				'event-table-end' => array(
					'type' => 'bool',
					'title' => __('End time', 'luna'),
					'label' => __('Show end time of the event', 'luna'),
					'default' => 0,
					'parent' => 'event-fields-table'
				),
				'event-table-location' => array(
					'type' => 'bool',
					'title' => __('Location', 'luna'),
					'label' => __('Show event location', 'luna'),
					'default' => 1,
					'parent' => 'event-fields-table'
				),
				'event-table-speaker' => array(
					'type' => 'bool',
					'title' => __('Speaker', 'luna'),
					'label' => __('Show the speaker&rsquo;s name linked to his single page', 'luna'),
					'default' => 1,
					'parent' => 'event-fields-table'
				),
				'event-table-short' => array(
					'type' => 'bool',
					'title' => __('Code', 'luna'),
					'label' => __('Show event code', 'luna'),
					'default' => 1,
					'parent' => 'event-fields-table'
				),
				'event-table-participants' => array(
					'type' => 'bool',
					'title' => __('Max. number of participants', 'luna'),
					'label' => __('Show max. number of participants', 'luna'),
					'default' => 0,
					'parent' => 'event-fields-table'
				),
				'event-table-availible' => array(
					'type' => 'bool',
					'title' => __('Places available', 'luna'),
					'label' => __('Show number of places available', 'luna'),
					'default' => 0,
					'parent' => 'event-fields-table'
				),
				'registration-form' => array(
					'type' => 'section',
					'title' => __('Registration form', 'luna'),
				),
				'aktiv-registration-link' => array(
					'type' => 'bool',
					'title' => __('Registration button', 'luna'),
					'label' => __('Show registration button on single event view', 'luna'),
					'default' => $defaultoptions['aktiv-registration-link'],
					'parent' => 'registration-form'
				),
				'registration-link' => array(
					'type' => 'text',
					'title' => __('Registration page', 'luna'),
					'label' => __('Relative path to the registration page', 'luna'),
					'default' =>  __('registration','luna'),
					'parent' => 'registration-form'
				)
			)
		),
		'socialmedia' => array(
			'tabtitle' => __('Social Media', 'luna'),
			'fields' => array(
				'post-icons' => array(
					'type' => 'section',
					'title' => __('Share Icons in Post Header', 'luna'),
				),
				'aktiv-post-sm-buttons' => array(
					'type' => 'bool',
					'title' => __('Show', 'luna'),
					'label' => __('Show social media share buttons in the header of each post', 'luna'),
					'default' => $defaultoptions['aktiv-post-sm-buttons'],
					'parent' => 'post-icons',
				),
				'aktiv-facebook-share' => array(
					'type' => 'bool',
					'title' => __('Facebook', 'luna'),
					'label' => __('Show "Share on Facebook" icon.', 'luna'),
					'link' => 'https://www.facebook.com/sharer/sharer.php?u=',
					'link_title' => __('Share on Facebook', 'luna'),
					'default' => $defaultoptions['aktiv-facebook-share'],
					'parent' => 'post-icons',
				),
				'aktiv-twitter-share' => array(
					'type' => 'bool',
					'title' => __('Twitter', 'luna'),
					'label' => __('Show "Share on Twitter" icon.', 'luna'),
					'link' => 'https://twitter.com/intent/tweet?url=',
					'link_title' => __('Share on Twitter', 'luna'),
					'default' => $defaultoptions['aktiv-twitter-share'],
					'parent' => 'post-icons',
				),
				'via-twitter' => array(
					'type' => 'text',
					'title' => __('Twitter via (optional)', 'luna'),
					'label' => __('Your Twitter user name. Appears appended to Tweet text as via @username. The Twitter account may appear in a list of recommended accounts to follow.', 'luna'),
					'parent' => 'post-icons',
				),
				'site-icons' => array(
					'type' => 'section',
					'title' => __('Follow Icons in Sidebar', 'luna'),
				),
				'aktiv-socialmediabuttons' => array(
					'type' => 'bool',
					'title' => __('Show', 'luna'),
					'label' => __('Show social media link icons on top of the sidebar', 'luna'),
					'default' => $defaultoptions['aktiv-socialmediabuttons'],
					'parent' => 'site-icons',
				),
				'sm-list' => array(
					'type' => 'urlchecklist',
					'title' => __('Links', 'luna'),
					'liste' => $default_socialmedia_liste,
					'parent' => 'post-icons',
				),
			)
		),
	)
);
?>
