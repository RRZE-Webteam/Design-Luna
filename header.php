<?php
global $options;
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php wp_title('|', true, 'right'); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/grafiken/favicon.ico" />
		<?php wp_head(); ?>
		<?php get_luna_opengraphinfo() ?>
		<script language="JavaScript" type="text/javascript">
			<!--
				window.onload = function () {
				if (document.documentElement.clientWidth >= 600) {
					document.getElementById('toggle-menu').style.display = 'none';
				}
				if (document.documentElement.clientWidth < 600) {
					document.getElementById('menu').style.display = 'none';
				}
			}

			jQuery(document).ready(function () {
				jQuery('.slide_button').click(function () {
					jQuery('#menu').slideToggle('slow', function () {
						if (jQuery('#menu').is(':visible')) {
							jQuery('.menu-arrow').text('\u25B2');
						} else {
							jQuery('.menu-arrow').text('\u25BC');
						}
					});
				});
			});
-->
		</script>
	</head>

	<body <?php body_class(); ?>>  <!-- begin: body -->
		<div class="page_margins">  <!-- begin: page_margins -->
			<div id="seite" class="page">  <!-- begin: seite -->
				<a name="seitenmarke" id="seitenmarke"></a>

				<header>  <!-- begin: kopf -->
					<?php
						$header_image = get_header_image();
						if (!empty($header_image)) {
					?>
						<div id="kopf" style="background-image: url(<?php header_image(); ?>)">
					<?php } else { ?>
						<div id="kopf">
					<?php } ?>

						<hgroup><div id="logo">
							<?php if (!is_home()) { ?>
								<a href="<?php echo home_url('/'); ?>" title="<?php echo $options['default_text_title_home_backlink']; ?>" rel="home" class="logo">
							<?php } ?>
							<?php
								$logo = $options['headerbox-logo'];
								if (!empty($logo)) {
							?>
							<img src="<?php echo $logo; ?>" alt="<?php bloginfo('name'); ?>">
							<?php } ?>
							<?php if (!is_home()) { ?> </a>  <?php } ?>

							<?php if (!is_home()) { ?>
								<a href="<?php echo home_url('/'); ?>" title="<?php echo $options['default_text_title_home_backlink']; ?>" rel="home" class="logo">
							<?php } ?>
							<div class="bloginfo"><h1><?php bloginfo('name'); ?></h1>
							<p class="description"><?php bloginfo('description'); ?></p></div>
							<?php if (!is_home()) { ?> </a>  <?php } ?>

							<?php if ((isset($options['headerbox-datum']) && $options['headerbox-datum'] != '') || (isset($options['headerbox-ort']) && $options['headerbox-ort'] != '')) { ?>
								<hr class="headerbox">
								<p class="datum"><?php echo $options['headerbox-datum']; ?></p>
								<p class="titel"><?php echo $options['headerbox-ort']; ?></p>
							<?php } ?>
						</div></hgroup>

					<?php if (has_nav_menu('targetmenu')) { ?>
						<nav id="zielgruppen-menue" class="zielgruppen-menue" role="navigation">
						<?php wp_nav_menu(array('theme_location' => 'targetmenu', 'fallback_cb' => '', 'depth' => 1)); ?>
						</nav><!-- #target-navigation -->
					<?php } ?>


					</div></header>  <!-- end: kopf -->

				<div id="main">  <!-- begin: main -->


					<div id="sprungmarken">
						<h2>Sprungmarken</h2>
						<ul>
							<li class="first"><a href="#contentmarke">Zum Inhalt</a><span class="skip">. </span></li>
							<li><a href="#bereichsmenumarke">Zur Navigation</a><span class="skip">. </span></li>
							<li class="last"><a href="#sidebar">Zu sonstigen Informationen</a><span class="skip">. </span></li>
						</ul>
					</div>

					<?php if ((! is_front_page()) && (function_exists('luna_breadcrumbs'))) luna_breadcrumbs(); ?>

					<div id="toggle-menu">
						<a class="slide_button noprint" title="Click to Show or Hide the Navigation" href="#">Menu <span class="menu-arrow">&#9660;</span></a>
					</div>

					<div id="menu">  <!-- begin: menu -->
						<div id="bereichsmenu">
							<h2><a name="bereichsmenumarke" id="bereichsmenumarke">Navigation</a></h2>

							<?php
							if (has_nav_menu('primary')) {
								wp_nav_menu(array('container' => 'ul', 'menu_class' => 'menu',
									'menu_id' => 'navigation', 'theme_location' => 'primary', 'walker' => ''));
							} else {
								?>

								<ul id="navigation" class="menu">
									<?php
									wp_page_menu(array(
										'sort_column' => 'menu_order, post_title',
										'echo' => 1,
										'show_home' => 1));
									?>
								</ul>

							<?php } ?>

						</div>
						<?php
						if (is_active_sidebar('kurzinfo-area')) {
							dynamic_sidebar('kurzinfo-area');
						}
						?>
					</div>  <!-- end: menu -->

					<?php
						if (is_active_sidebar('sidebar-area')) {
							get_sidebar();
							//dynamic_sidebar('sidebar-area');
						}
						?>

					<?php //get_sidebar(); ?>


					<div id="content">  <!-- begin: content -->
						<a name="contentmarke" id="contentmarke"></a>

						<div id="titel">
							<h1>
								<?php if (is_day()) : ?>
									<?php printf(__('%s', 'luna'), '<span>' . get_the_date() . '</span>'); ?>
								<?php elseif (is_month()) : ?>
									<?php printf(__('%s', 'luna'), '<span>' . get_the_date(_x('F Y', 'monthly archives date format', 'luna')) . '</span>'); ?>
								<?php elseif (is_year()) : ?>
									<?php printf(__('%s', 'luna'), '<span>' . get_the_date(_x('Y', 'yearly archives date format', 'luna')) . '</span>'); ?>
								<?php elseif (is_archive() && ('event' == get_post_type() )) : ?>
									<?php print $options['label-event-pl']; ?>
								<?php elseif (is_archive() && ('speaker' == get_post_type() )) : ?>
									<?php print $options['label-speaker-pl']; ?>
								<?php else : ?>
									<?php luna_contenttitle(); ?>
								<?php endif; ?>
							</h1>
						</div>



