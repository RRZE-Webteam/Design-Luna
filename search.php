<?php get_header();
    global $options;
  global $wp_query;
?>





    <?php if ( have_posts() ) : ?>
                <?php
                /* Run the loop for the search to output the results.
                 * If you want to overload this in a child theme then include a file
                 * called loop-search.php and that will be used instead.
                 */


      $i = 0;
      $col = 0;

      $numentries = $options['category-num-article-fullwidth'] + $options['category-num-article-halfwidth'];
      $col_count = 3;
      $cols = array();

      global $query_string;
      query_posts( $query_string . '&cat=$thisCat' );

      while (have_posts() && $i<$numentries) : the_post();
      $i++;
      ob_start();
      if (( isset($options['category-num-article-fullwidth']))
                && ($options['category-num-article-fullwidth']>=$i )) {
		 luna_post_teaser($options['category-teaser-datebox'],$options['category-teaser-dateline'],$options['category-teaser-maxlength'],$options['teaser-thumbnail_fallback'],$options['category-teaser-floating']);
      } else {
		 luna_post_teaser($options['category-teaser-datebox-halfwidth'],$options['category-teaser-dateline-halfwidth'],$options['category-teaser-maxlength-halfwidth'],$options['teaser-thumbnail_fallback'],$options['category-teaser-floating-halfwidth']);
      }
      $output = ob_get_contents();
      ob_end_clean();
      if (isset($output)) {
        $cols[$col++] = $output;
      }
      endwhile;
      ?>



      <div class="columns">
        <?php
        $z=1;
        foreach($cols as $key => $col) {
            if (( isset($options['category-num-article-fullwidth']))
                && ($options['category-num-article-fullwidth']>$key )) {
                    echo $col;
                } else {
                     if (( isset($options['category-num-article-fullwidth']))
                            && ($options['category-num-article-fullwidth']==$key )
                            && ($options['category-num-article-fullwidth']>0) ) {
                         echo '<hr>';
                        }
                    echo '<div class="column'.$z.'">' . $col . '</div>';
                    $z++;
                    if ($z>2) {
                        $z=1;
                        echo '<hr style="clear: both;">';
                    }
                }
        }
        ?>
      </div>

                   <?php if (  $wp_query->max_num_pages > 1 ) : ?>
                        <div class="archiv-nav"><p>
                            <?php next_posts_link( __( '&larr; Older Posts', 'luna' ) ); ?>
                            <?php previous_posts_link( __( 'Newer Posts &rarr;', 'luna' ) ); ?>
                        </p></div>
                <?php endif; ?>



             <?php else : ?>
                        <h2><?php _e("Nothing found", 'luna'); ?></h2>
                        <p>
                            <?php _e("Sorry, but nothing matched your search terms. Please try again with different keywords.", 'luna'); ?>

                        </p>
                        <?php get_search_form(); ?>

                        <p>
                            <?php _e("Alternatively you may use one of the following links.", 'luna'); ?>

                        </p>

                        <div class="widget">
                            <h3><?php _e("Monthly Archives", 'luna'); ?></h3>
                            <?php wp_get_archives('type=monthly'); ?>
                        </div>

                         <div  class="widget">
                            <h3><?php _e("Tag Archives", 'luna'); ?></h3>
                            <div class="tagcloud">
                             <?php wp_tag_cloud(array('smallest'  => 12, 'largest'   => 28)); ?>
                             </div>
                        </div>
                        <div class="widget">
                        <h3><?php _e("Category List", 'luna'); ?></h3>
                        <ul>
                          <?php wp_list_categories('title_li='); ?>
                        </ul>
                         </div>


             <?php endif; ?>


<?php get_footer(); ?>
