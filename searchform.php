<?php
    $querystring = esc_attr(apply_filters('the_search_query', get_search_query()));
    $searchstring = "Suchbegriff eingeben";
    if (empty($querystring)) { $querystring = $searchstring; }
?>

        <div id="suche">
          <h2><a name="suche">Suche</a></h2>
            <form method="get" id="searchform" action="<?php echo esc_url( home_url() ); ?>">
               <p>
	               <label for="suchbegriff">Suche:</label>
	               <input id="s" name="s" type="text" value="<?php echo $querystring; ?>"
				   onfocus="if(this.value=='<?php echo $querystring; ?>')this.value='';"
				   onblur="if(this.value=='')this.value='<?php echo $querystring; ?>';"
				   maxlength="100" />
	               <input type="submit" value="suchen" />
               </p>
            </form>
        </div>