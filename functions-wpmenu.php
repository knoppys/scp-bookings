<?php
/*
Customsise the wp menu
*/
function remove_menus(){
  
  remove_menu_page( 'index.php' );                  
  remove_menu_page( 'edit-comments.php' );
  remove_menu_page( 'themes.php' );
  remove_menu_page( 'plugins.php' );
  remove_menu_page( 'tools.php' );
  remove_menu_page( 'options-general.php' );
  remove_menu_page( 'edit.php?post_type=acf' );
  
  
}
add_action( 'admin_menu', 'remove_menus' );