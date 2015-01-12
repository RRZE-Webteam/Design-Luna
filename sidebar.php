<?php           
 
  echo '<aside><div id="sidebar">  <!-- begin: sidebar -->';
  
  

  get_luna_anmeldebuttons();

  get_luna_socialmediaicons();

    
   if ( is_active_sidebar( 'sidebar-area' ) ) { 
	 dynamic_sidebar( 'sidebar-area' ); 
		   
    } 
		
    echo '</div></aside>';
?>		