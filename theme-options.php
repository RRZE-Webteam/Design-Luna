<?php load_theme_textdomain('luna'); ?>
<?php
add_action('admin_init', 'theme_options_init');
add_action('admin_menu', 'theme_options_add_page');

/**
 * Init plugin options to white list our options
 */
function theme_options_init() {
	register_setting('luna_options', 'luna_theme_options', 'theme_options_validate');
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page(__('Luna Theme Options', 'luna'), __('Luna Theme Options', 'luna'), 'edit_theme_options', 'theme_options', 'theme_options_do_page');
}

/**
 * Import Js and CSS for Media Upload
 */
function theme_options_enqueue_scripts() {
    wp_register_script( 'luna-upload', get_template_directory_uri() .'/js/admin.js', array('jquery','media-upload','thickbox') );

    if ( 'appearance_page_theme_options' == get_current_screen() -> id ) {
        wp_enqueue_script('jquery');

        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');

        wp_enqueue_script('media-upload');
        wp_enqueue_script('wptuts-upload');

    }

}
add_action('admin_enqueue_scripts', 'theme_options_enqueue_scripts');


/**
 * Create the options page
 */
function theme_options_do_page($tab = '') {
	global $setoptions;
	global $options;

	if (!isset($_REQUEST['settings-updated']))
		$_REQUEST['settings-updated'] = false;
	?>

	<div class="wrap">
		<div class="luna-optionen">  <!-- begin: .luna-optionen -->
			<?php echo "<h2>" . wp_get_theme() . ': ' . __('Settings', 'luna') . "</h2>"; ?>

			<?php if (false !== $_REQUEST['settings-updated']) : ?>
				<div class="updated fade"><p><strong><?php _e('Options saved', 'luna'); ?></strong></p></div>
				<?php
			endif;

			if (isset($_GET['tab'])) {
				$tab = $_GET['tab'];
			}
			if ((!isset($tab)) || (empty($tab))) {
				$tab = "design";
			}
			if (!isset($setoptions['luna_theme_options'][$tab])) {
				echo "Invalid Tab-Option or undefined Option-Field $tab";
			}


			echo "<h3 class=\"nav-tab-wrapper\">\n";
			foreach ($setoptions['luna_theme_options'] as $i => $value) {
				$tabtitel = $value['tabtitle'];
				echo "<a href=\"?page=theme_options&amp;tab=$i\" class=\"nav-tab ";
				if ($tab == $i) {
					echo "nav-tab-active";
				}
				echo "\">$tabtitel</a>\n";
			}
			echo "</h3>\n";
			?>



			<form method="post" action="options.php" enctype="multipart/form-data">
				<?php settings_fields('luna_options'); ?>
				<input type="hidden" id="luna_theme_options[tab]" name="luna_theme_options[tab]"  value="<?php echo $tab; ?>">


				<div id="einstellungen">
					<table>
						<?php
						if (isset($setoptions['luna_theme_options'][$tab]['fields'])) {
							foreach ($setoptions['luna_theme_options'][$tab]['fields'] as $i => $value) {
								$name = $i;
								if (isset($value['title']))
									$title = $value['title'];
								if (isset($value['type']))
									$type = $value['type'];
								if (isset($value['label']))
									$label = $value['label'];
								if (isset($value['parent']))
									$parent = $value['parent'];
								if (isset($value['liste']))
									$liste = $value['liste'];

								if ($type == 'section') {
									if ((isset($setsection)) && ($setsection != "")) {
										echo "\t\t\t</table>\n";
										echo "\t\t</td>\n";
										echo "\t</tr>\n";
									}
									echo "\t<tr valign=\"top\">\n\t\t<th scope=\"row\">";
									echo $title;
									echo "</th>\n\t\t<td>";
									echo "\t\t\t<table class=\"suboptions\">\n";
									$setsection = $name;
								} elseif ($type == 'description') {
									echo "\t<tr valign=\"top\">\n\t\t<td colspan=\"2\">";
									echo $title;
									echo "</td></tr>";
								} else {
									echo "\t<tr valign=\"top\">\n\t\t<th scope=\"row\">";
									echo $title;
									echo "</th>\n\t\t<td>";

									if ((!isset($options[$name])) && (isset($value['default'])) && (!empty($value['default']))) {
										$options[$name] = $value['default'];
									}
									if ($type == 'bool') {
										echo "\t\t\t";
										echo "<input id=\"luna_theme_options[$name]\" name=\"luna_theme_options[$name]\"
                                            type=\"checkbox\" value=\"1\" " . checked($options[$name], 1, false) . ">\n";
										echo "\t\t\t";
										echo "<label for=\"luna_theme_options[$name]\">$label</label>\n";
									} elseif (($type == 'text') || ($type == 'email')) {
										echo "\t\t\t";
										echo "<input class=\"regular-text\" id=\"luna_theme_options[$name]\"
                                            type=\"text\" name=\"luna_theme_options[$name]\"
					    value=\"";
										if (isset($options[$name]))
											echo esc_attr($options[$name]);

										echo "\"><br>\n";
										echo "\t\t\t";
										echo "<label for=\"luna_theme_options[$name]\">$label</label>\n";
									} elseif (($type == 'html') || ($type == 'url')) {
										echo "\t\t\t";
										echo "<input class=\"large-text\" id=\"luna_theme_options[$name]\"
                                            type=\"text\" name=\"luna_theme_options[$name]\"
					    size=\"120\" value=\"";
										if (isset($options[$name]))
											echo esc_attr($options[$name]);

										echo "\"><br>\n";
										echo "\t\t\t";
										echo "<label for=\"luna_theme_options[$name]\">$label</label>\n";
									} elseif ($type == 'imgurl') {
										echo "\t\t\t";
										echo "<input class=\"large-text\" id=\"luna_theme_options[$name]\"
                                            type=\"text\" name=\"luna_theme_options[$name]\"
					    size=\"120\" value=\"";
										if (isset($options[$name]))
											echo esc_attr($options[$name]);
										echo "\"><br>\n";
										if (isset($options[$name])) {
											echo "<img class=\"imgurl\" src=\"" . esc_attr($options[$name]) . "\" alt=\"\">\n";
										}
										echo "\t\t\t";
										echo "<label for=\"luna_theme_options[$name]\">$label</label>\n";
									} elseif ($type == 'textarea') {
										echo "\t\t\t";
										echo "<textarea class=\"large-text\" id=\"luna_theme_options[$name]\"
                                            cols=\"30\" rows=\"10\"  name=\"luna_theme_options[$name]\">";
										if (isset($options[$name]))
											echo esc_attr($options[$name]);
										echo "</textarea><br>\n";
										echo "\t\t\t";
										echo "<label for=\"luna_theme_options[$name]\">$label</label>\n";
									} elseif ($type == 'number') {
										echo "\t\t\t";
										echo "<input class=\"number\" size=\"5\" id=\"luna_theme_options[$name]\"
                                            type=\"text\" name=\"luna_theme_options[$name]\"
                                            value=\"" . esc_attr($options[$name]) . "\"><br>\n";
										echo "\t\t\t";
										echo "<label for=\"luna_theme_options[$name]\">$label</label>\n";
									} elseif ($type == 'mediaupload') {
										echo "\t\t\t";
										echo '<input type="text" id="upload_logo" name="luna_theme_options[' . $name . ']" value="' . esc_attr($options[$name]) . '" size="40" />';
										echo '<input id="upload_logo_button" type="button" class="button" value="' . __( 'Upload Logo', 'luna' ) . '" />';
										echo '<br /><span class="description">' . __('Upload or choose a logo image', 'luna' ) . '</span>';
									} elseif ($type == 'bildlist') {
										echo "\t\t\t";
										foreach ($liste as $i => $value) {
											echo "\t\t\t\t";
											$src = $value['src'];
											$label = $value['label'];
											echo "<label class=\"tile";
											if ($src == $options[$name]) {
												echo ' checked';
											}
											echo "\">\n";
											echo '<input type="radio" value="' . $src . '"
					    name="luna_theme_options[' . $name . ']"';
											if ($src == $options[$name]) {
												echo ' checked="checked"';
											}
											echo '> ';
											echo $label . '<br><img src="' . $src . '" alt="" style="width: 320px; height: auto;">';
											echo "</label>\n";
										}
										echo "<br style=\"clear: left;\">\n";
									} elseif ($type == 'bildchecklist') {
										echo "\t\t\t";
										foreach ($liste as $option) {
											$checked = '';
											if ((isset($options[$name])) && (is_array($options[$name]))) {
												foreach ($options[$name] as $current) {
													if ($current == $option['src']) {
														$checked = "checked=\"checked\"";
														break;
													}
												}
											}
											?>
											<label class="plakattile">
												<div style="height: 40px; width: 100%; margin:0 auto; background-color: #F28900; color: white; display: block;">
													<input type="checkbox" name="luna_theme_options[<?php echo $name ?>][]"
														   value="<?php echo esc_attr($option['src']); ?>" <?php echo $checked; ?> />
														   <?php echo $option['label'] ?>
												</div>
												<div style="height: 395px; overflow: hidden; margin: 5px auto; width: 280px; padding: 0;">
													<img src="<?php echo $option['src'] ?>" style="width: 280px; height: auto;  ">
												</div>
											</label>
											<?php
										}
										echo "<br style=\"clear: left;\">\n";
									} elseif ($type == 'bilddirchecklist') {
										echo "\t\t\t";
										$dir = get_template_directory() . $value['default'];


										if (is_dir($dir)) {
											$contents = dirToArray($dir);
											foreach ($contents as $key => $wert) {
												if (is_array($wert)) {

													echo "<h4>Ordner $key<h4>";
													foreach ($wert as $sub) {
														$bildurl = get_template_directory_uri() . $value['default'] . '/' . $key . '/' . $sub;
														$checked = '';
														if ((isset($options[$name])) && (is_array($options[$name]))) {
															foreach ($options[$name] as $current) {
																if ($current == $bildurl) {

																	$checked = "checked=\"checked\"";
																	break;
																}
															}
														}
														?>

														<label class="plakattile" style="width: 150px; height: 251px">
															<div style="height: 40px; width: 100%; margin:0 auto; background-color: #F28900; color: white; display: block;">
																<input type="checkbox" name="luna_theme_options[<?php echo $name ?>][]"
																	   value="<?php echo esc_attr($bildurl); ?>" <?php echo $checked; ?> />
																	   <?php echo $sub ?>
															</div>
															<div style="height: 211px; overflow: hidden; margin: 5px auto; width: 150px; padding: 0;">
																<img src="<?php echo $bildurl ?>" style="width: 150px; height: auto;  ">
															</div>
														</label>
														<?php
													}
													echo "<br style=\"clear: left;\">\n";
												}
											}
											// First Dir only

											$found = 0;
											foreach ($contents as $key => $wert) {
												if (!is_array($wert)) {
													if ($found == 0) {
														print "<h4>Ordner " . $value['default'] . "</h4>";
														$found = 1;
													}
													$bildurl = get_template_directory_uri() . $value['default'] . '/' . $wert;
													$checked = '';
													if ((isset($options[$name])) && (is_array($options[$name]))) {
														foreach ($options[$name] as $current) {
															if ($current == $bildurl) {

																$checked = "checked=\"checked\"";
																break;
															}
														}
													}
													?>

													<label class="plakattile" style="width: 150px; height: 251px">
														<div style="height: 40px; width: 100%; margin:0 auto; background-color: #F28900; color: white; display: block;">
															<input type="checkbox" name="luna_theme_options[<?php echo $name ?>][]"
																   value="<?php echo esc_attr($bildurl); ?>" <?php echo $checked; ?> />
																   <?php echo $sub ?>
														</div>
														<div style="height: 211px; overflow: hidden; margin: 5px auto; width: 150px; padding: 0;">
															<img src="<?php echo $bildurl ?>" style="width: 150px; height: auto;  ">
														</div>
													</label>
													<?php
												}
											}
											echo "<br style=\"clear: left;\">\n";
										}
									} elseif ($type == 'urlchecklist') {

										echo "\t\t\t";
										foreach ($liste as $entry => $listdata) {
											$checked = '';
											$value = '';
											$active = 0;
											if (isset($options[$name][$entry]['content'])) {
												$value = $options[$name][$entry]['content'];
											} else {
												$value = $liste[$entry]['content'];
											}
											if (isset($options[$name][$entry]['active'])) {
												$active = $options[$name][$entry]['active'];
											}

											if (($active == 1) && (filter_var($value, FILTER_VALIDATE_URL))) {
												$checked = "checked=\"checked\"";
											}
											?>
											<div style="display: inline-block; width: 90%;" class="<?php echo $name ?>">
												<label for="luna_theme_options[<?php echo $name ?>][<?php echo $entry ?>][active]" class="<?php echo $entry ?>" style="width: 120px; display: inline-block;">
													<input type="checkbox"
														   id="luna_theme_options[<?php echo $name ?>][<?php echo $entry ?>][active]"
														   name="luna_theme_options[<?php echo $name ?>][<?php echo $entry ?>][active]"
														   value="1" <?php echo $checked; ?>>
														   <?php echo $liste[$entry]['name'] ?>
												</label>

												<input id="luna_theme_options[<?php echo $name ?>][<?php echo $entry ?>][content]"
													   type="text" name="luna_theme_options[<?php echo $name ?>][<?php echo $entry ?>][content]"
													   size="80" value="<?php echo $value ?>">
											</div>
											<?php
										}
										echo "<br style=\"clear: left;\">\n";
									} elseif ($type == 'select') {
										echo "\t\t\t";
										echo "<select name=\"luna_theme_options[$name]\">\n";

										foreach ($liste as $i => $value) {
											echo "\t\t\t\t";
											echo '<option value="' . $i . '"';
											if ($i == $options[$name]) {
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
										echo "\t\t\t</select><br>\n";
										echo "\t\t\t<label for=\"luna_theme_options[$name]\">$label</label>\n";
									}

									echo "\t\t</td>\n";
									echo "\t</tr>\n";
								}

								if ((isset($setsection)) && ($setsection != "") && ($type != 'section') && (!isset($parent))) {
									/*
									 * Kein Parent mehr
									 */
									echo "\t\t\t</table>\n";
									echo "\t\t</td>\n";
									echo "\t</tr>\n";
									$setsection = "";
								}
							}
							if ((isset($setsection)) && ($setsection != "")) {
								/*
								 * Kein Parent mehr
								 */
								echo "\t\t\t</table>\n";
								echo "\t\t</td>\n";
								echo "\t</tr>\n";
								$setsection = "";
							}
						} else {
							_e('Options not set', 'luna');
						}
						?>


					</table>
				</div>

				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Options', 'luna'); ?>" />
				</p>
			</form>
		</div>

	</div> <!-- end: .luna-optionen -->
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate($input) {
	global $setoptions;
	global $defaultoptions;
	$options = get_option('luna_theme_options');

	$saved = (array) get_option('luna_theme_options');
	//    $options= $saved;
	$output = wp_parse_args($saved, $defaultoptions);
	$tab = '';
	if ((isset($_GET['tab'])) && (!empty($_GET['tab']))) {
		$tab = $_GET['tab'];
	}
	if ((empty($tab) && ($input['tab']))) {
		$tab = $input['tab'];
	}

	if (!isset($setoptions['luna_theme_options'][$tab])) {
		return $output;
	}

	if (isset($setoptions['luna_theme_options'][$tab]['fields'])) {
		foreach ($setoptions['luna_theme_options'][$tab]['fields'] as $i => $value) {
			$name = $i;
			$type = $value['type'];
			if (isset($value['default'])) {$default = $value['default'];}
			if ($type != "section") {
				if (isset($input[$name])) {
					// Wert wurde uebergebnen
					if ($type == 'bool') {
						$output[$name] = ( $input[$name] == 1 ? 1 : 0 );
					} elseif ($type == 'text') {
						$output[$name] = wp_filter_nohtml_kses($input[$name]);
					} elseif ($type == 'email') {
						$output[$name] = sanitize_email($input[$name]);
					} elseif ($type == 'textarea') {
						$output[$name] = $input[$name];
					} elseif ($type == 'html') {
						$output[$name] = $input[$name];
					} elseif (($type == 'url') || ($type == 'imgurl') || ($type == 'mediaupload')) {
						$output[$name] = esc_url($input[$name]);
					} elseif ($type == 'number') {
						$output[$name] = wp_filter_nohtml_kses($input[$name]);
					} elseif ($type == 'select') {
						$output[$name] = wp_filter_nohtml_kses($input[$name]);
					} elseif (($type == 'bildchecklist') || ($type == 'bilddirchecklist')) {
						$output[$name] = $input[$name];
					} elseif ($type == 'urlchecklist') {
						$output[$name] = $input[$name];
					} elseif ($type == 'mediaupload') {
						$output[$name] = $input[$name];
					} else {
						$output[$name] = wp_filter_nohtml_kses($input[$name]);
					}
				} else {
					// Wurde leer gemacht oder leer uebergeben#
					if ($type == 'bool') {
						$output[$name] = 0;
					} elseif ($type == 'text') {
						$output[$name] = "";
					} elseif ($type == 'textarea') {
						$output[$name] = "";
					} elseif ($type == 'html') {
						$output[$name] = "";
					} elseif ($type == 'url') {
						$output[$name] = "";
					} elseif ($type == 'number') {
						$output[$name] = 0;
					} elseif ($type == 'select') {
						$output[$name] = "";
					}
				}
			}
		}
	}

	return $output;
}



/*
 * Reads Directory and contents, ignoring unused files
 */

function dirToArray($dir) {
	$result = array();
	$contents = scandir($dir);
	$bad = array(".", "..", ".DS_Store", "_notes", "Thumbs.db", "Browse.plb");
	$cdir = array_diff($contents, $bad);

	foreach ($cdir as $key => $value) {
		if (!in_array($value, array(".", ".."))) {
			if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
				$result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
			} else {
				$result[] = $value;
			}
		}
	}

	return $result;
}
