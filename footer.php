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

    (function () {
        document.documentElement.className = 'js'
    })();

    jQuery(document).ready(function ($) {
        $(".accordion h2").addClass("closed");
        $(".accordion div").hide();

        $(".accordion h2").click(function(){
            $(this).next().slideToggle("400");
            $(this).toggleClass("closed").toggleClass("active");
            $(".accordion div").not($(this).next()).slideUp("400");
            $(".accordion h2").not($(this)).addClass("closed").removeClass("active");
        });
    });
</script>

<?php if( has_shortcode( $post->post_content, 'content-slider') ) { ?>
    <script type="text/javascript">
        // Can also be used with $(document).ready()
        jQuery(document).ready(function($) {
            $('.contentslider').flexslider({
                animation: "slide",
                pausePlay: "true",
                pauseOnAction: "true",
                pauseOnHover: "true"
            });
        });
    </script>
<?php } ?>

<?php if( has_shortcode( $post->post_content, 'image-slider') ) { ?>
    <script type="text/javascript">
        // Can also be used with $(document).ready()
        jQuery(document).ready(function($) {
            $('.imageslider').flexslider({
                animation: "slide",
                pausePlay: "true",
                pauseOnAction: "true",
                pauseOnHover: "true"
            });
        });
    </script>
<?php } ?>

<?php wp_footer(); ?>

</body> <!-- end: body -->
</html>
