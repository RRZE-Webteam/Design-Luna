<?php get_header();
    global $options;
      global $wp_query;

      $i = 0;
      $col = 0;

      $numentries = $options['category-num-article-fullwidth'] + $options['category-num-article-halfwidth'];
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
                <?php endif;





 get_footer(); ?>
