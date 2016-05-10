<?php
/*
 * Footer
 */
global $options;
?>




<hr id="vorfooter" />
</div>  <!-- end: content -->
</div>  <!-- end: main -->
<footer><div id="footer">  <!-- begin: footer -->
		<div id="footerinfos">  <!-- begin: footerinfos -->

			<?php if (has_nav_menu('tecmenu')) { ?>
				<nav role="navigation">
					<div id="tecmenu">   <!-- begin: tecmenu -->
						<h2 class="skip"><a name="hilfemarke" id="hilfemarke">Technisches Menu</a></h2>
						<?php wp_nav_menu(array('theme_location' => 'tecmenu', 'fallback_cb' => '')); ?>
					</div>  <!-- end: tecmenu -->
				</nav>
			<?php } ?>
			<div id="zusatzinfo" class="noprint">  <!-- begin: zusatzinfo -->
				<a id="zusatzinfomarke" name="zusatzinfomarke"></a>
				<?php
				if (is_active_sidebar('zusatzinfo-area')) {
					dynamic_sidebar('zusatzinfo-area');
				}
				?>


				<p class="skip"><a href="#seitenmarke">Zum Seitenanfang</a></p>
			</div>  <!-- end: zusatzinfo -->




		</div> <!-- end: footerinfos -->
	</div></footer>   <!-- end: footer -->

</div>  <!-- end: seite -->
</div>  <!-- end: page_margins  -->

<script type="text/javascript">
	jQuery(document).ready(function ($) {
		$(".accordion h2:gt(0)").addClass("closed");
		$(".accordion div:gt(0)").hide();
		$(".accordion h2").click(function () {
			$(this).next("div").slideToggle(400);
			$(this).toggleClass("closed");
		});
	});
</script>
<?php if ($options['aktiv-slider'] == 1) { ?>

	<script type="text/javascript">
		/* <![CDATA[ */
		var slideshowSpeed = 2000;
		var uripath = '<?php echo get_template_directory_uri() ?>';
		var minscreenwidth = 1199;
		/* ]]> */
	</script>
	<?php
}
wp_footer();
?>
</body> <!-- end: body -->
</html>
