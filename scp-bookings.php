<?php
/*
Plugin Name:       SCP Bookings
Plugin URI:        https://github.com/knoppys/scp-bookings.git
Description:       The SCP Bookings plugin is a custom built application as a tool for managing the companies assets. Process bookings, assetts and peform reports on yoru data with ease. 
Version:           3.1
Author:            Knoppys Digital Limited
License:           GNU General Public License v2
License URI:       http://www.gnu.org/licenses/gpl-2.0.html
GitHub Plugin URI: https://github.com/knoppys/scp-bookings.git
GitHub Branch:     master
*/
define( 'BOOKINGS_VERSION', '3.1' );
define( 'BOOKINGS__MINIMUM_WP_VERSION', '1.0' );
define( 'BOOKINGS__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'BOOKINGS__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

/***************************
*Load Native & Custom wordpress functionality plugin files. 
****************************/

//Post Types and Taxonomies
foreach ( glob( dirname( __FILE__ ) . '/native/*.php' ) as $root ) {
    require $root;
}

//Meta boxes for all the post types. 
foreach ( glob( dirname( __FILE__ ) . '/native/meta/*.php' ) as $meta ) {
    require $meta;
}

//All the custom functions that populate posts and post types that arent generally included in
//the wp core. 
foreach ( glob( dirname( __FILE__ ) . '/custom/*.php' ) as $functions ) {
    require $functions;
}

//All the mail functionality for sending out notifications 
//NO FRONT END FUNCTIONALITY HERE
foreach ( glob( dirname( __FILE__ ) . '/native/mail/*.php' ) as $mail ) {
    require $mail;
}


/***************************
*Load SCP styles
****************************/
function scp_admin_style() {        

        wp_register_style( 'jqueryUIcss', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css', false, '1.0.0' );
        wp_enqueue_style( 'jqueryUIcss' );

        wp_register_style( 'jquerystepscss', plugin_dir_url( __FILE__ ) . 'css/jquery.steps.css', false, '1.0.0' );
        wp_enqueue_style( 'jquerystepscss' );

        wp_register_style( 'datatablescss', 'http://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css', false, '1.0.0' );
        wp_enqueue_style( 'datatablescss' );

        wp_register_style( 'bookings_adminstyle', plugin_dir_url( __FILE__ ) . 'css/admin-style.css', false, '1.0.0' );
        wp_enqueue_style( 'bookings_adminstyle' );

        wp_register_style( 'bookings_datetime', plugin_dir_url( __FILE__ ) . 'css/jquery.datetimepicker.css', false, '1.0.0' );
        wp_enqueue_style( 'bookings_datetime' );

        wp_register_style( 'bookings_fontawesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', false, '1.0.0' );
        wp_enqueue_style( 'bookings_fontawesome' );

       
}
add_action( 'admin_enqueue_scripts', 'scp_admin_style' );



/***************************
* Load SCP Scripts
****************************/
function scp_scripts() {    
    
    wp_enqueue_script( 'datetimepicker', plugin_dir_url( __FILE__ ) . 'js/jquery.datetimepicker.js', array(), '1.0.0', true );
    wp_enqueue_script( 'datatablejs', 'http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'ui', plugin_dir_url( __FILE__ ) . 'js/jquery-ui.min.js', array(), '', true );
    wp_enqueue_script( 'steps', plugin_dir_url( __FILE__ ) . 'js/jquery.steps.min.js', array(), '', true );
    wp_enqueue_script( 'core', plugin_dir_url( __FILE__ ) . 'js/core.js', array(), '1.0.0', true );
    wp_localize_script( 'core', 'siteUrlobject', array('siteUrl' => get_bloginfo('url')));
    wp_enqueue_script( 'dashboard-widgets', plugin_dir_url( __FILE__ ) . 'js/dashboard-widgets.js', array(), '1.0.0', true );
}

add_action( 'admin_enqueue_scripts', 'scp_scripts' );


       
?>
