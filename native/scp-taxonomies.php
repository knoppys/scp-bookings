<?php 


/**
Custom Taxonomies
1. Bookings Status Taxonomy
2. Booking Type Taxonomy
3. Apartment Type Taxonomy
4. Apartment Category Taxonomy
5. Country Taxonomy
*/
/** 
1. Booking Status Taxonomy
*/
function scp_bookings_taxonomy() {

	$labels = array(
		'name'                       => 'Booking Status',
		'singular_name'              => 'Booking Status',
		'menu_name'                  => 'Booking Status',
		'all_items'                  => 'All Booking Status',
		'parent_item'                => 'Parent Booking Status',
		'parent_item_colon'          => 'Parent Booking Status:',
		'new_item_name'              => 'New Booking Status',
		'add_new_item'               => 'Add New Booking Status',
		'edit_item'                  => 'Edit Booking Status',
		'update_item'                => 'Update Booking Status',
		'separate_items_with_commas' => 'Separate Booking Status with commas',
		'search_items'               => 'Search Booking Status',
		'add_or_remove_items'        => 'Add or Remove Booking Status',
		'choose_from_most_used'      => 'Choose From Most Used Booking Status',
		'not_found'                  => 'Not Found',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'show_in_menu'				 => false,
	);
	register_taxonomy( 'status', array( 'bookings' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'scp_bookings_taxonomy', 0 );


/** 
2. Booking Type Taxonomy

function scp_bookingtype_taxonomy() {

	$labels = array(
		'name'                       => 'Booking Type',
		'singular_name'              => 'Booking Type',
		'menu_name'                  => 'Booking Types',
		'all_items'                  => 'All Booking Types',
		'parent_item'                => 'Parent Booking Type',
		'parent_item_colon'          => 'Parent Booking Type:',
		'new_item_name'              => 'New Booking Type',
		'add_new_item'               => 'Add New Booking Type',
		'edit_item'                  => 'Edit Booking Type',
		'update_item'                => 'Update Booking Type',
		'separate_items_with_commas' => 'Separate Booking Type with commas',
		'search_items'               => 'Search Booking Type',
		'add_or_remove_items'        => 'Add or Remove Item Type',
		'choose_from_most_used'      => 'Choose From Most Used Booking Types',
		'not_found'                  => 'Not Found',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_menu'				 => false,
	);
	register_taxonomy( 'booking_type', array( 'bookings' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'scp_bookingtype_taxonomy', 0 );
*/

/** 
3. Apartment Type Taxonomy
*/
function scp_apartmenttype_taxonomy() {

	$labels = array(
		'name'                       => 'Apartment Type',
		'singular_name'              => 'Apartment Type',
		'menu_name'                  => 'Apartment Types',
		'all_items'                  => 'All Apartment Types',
		'parent_item'                => 'Parent Apartment Type',
		'parent_item_colon'          => 'Parent Apartment Type:',
		'new_item_name'              => 'New Apartment Type',
		'add_new_item'               => 'Add New Apartment Type',
		'edit_item'                  => 'Edit Apartment Type',
		'update_item'                => 'Update Apartment Type',
		'separate_items_with_commas' => 'Separate Apartment Type with commas',
		'search_items'               => 'Search Apartment Type',
		'add_or_remove_items'        => 'Add or Remove Item Type',
		'choose_from_most_used'      => 'Choose From Most Used Apartment Types',
		'not_found'                  => 'Not Found',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_menu'				 => false,
	);
	register_taxonomy( 'Apartment_type', array( 'apartments' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'scp_apartmenttype_taxonomy', 0 );


/** 
5. Apartment Category Taxonomy

function scp_apartmentCategory_taxonomy() {

	$labels = array(
		'name'                       => 'Apartment Category',
		'singular_name'              => 'Apartment Category',
		'menu_name'                  => 'Apartment Categories',
		'all_items'                  => 'All Apartment Categories',
		'parent_item'                => 'Parent Apartment Category',
		'parent_item_colon'          => 'Parent Apartment Category:',
		'new_item_name'              => 'New Apartment Category',
		'add_new_item'               => 'Add New Apartment Category',
		'edit_item'                  => 'Edit Apartment Category',
		'update_item'                => 'Update Apartment Category',
		'separate_items_with_commas' => 'Separate Apartment Category with commas',
		'search_items'               => 'Search Apartment Category',
		'add_or_remove_items'        => 'Add or Remove Item Category',
		'choose_from_most_used'      => 'Choose From Most Used Apartment Categoryhs',
		'not_found'                  => 'Not Found',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_menu'				 => false,
	);
	register_taxonomy( 'Apartment_Category', array( 'apartments' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'scp_apartmentcategory_taxonomy', 0 );
*/
/** 
6. Country Taxonomy

function scp_country_taxonomy() {

	$labels = array(
		'name'                       => 'Country',
		'singular_name'              => 'Country',
		'menu_name'                  => 'Countries',
		'all_items'                  => 'All Countries',
		'parent_item'                => 'Parent Country',
		'parent_item_colon'          => 'Parent Country:',
		'new_item_name'              => 'New Country',
		'add_new_item'               => 'Add New Country',
		'edit_item'                  => 'Edit Country',
		'update_item'                => 'Update Country',
		'separate_items_with_commas' => 'Separate Countries with commas',
		'search_items'               => 'Search Country',
		'add_or_remove_items'        => 'Add or Remove Item Category',
		'choose_from_most_used'      => 'Choose From Most Used Countries',
		'not_found'                  => 'Not Found',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => false,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_menu'				 => false,
	);
	register_taxonomy( 'countries', array( 'apartments' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'scp_country_taxonomy', 0 );
*/
/** 
6. Location Category Taxonomy
*/
function scp_location_category_taxonomy() {

	$labels = array(
		'name'                       => 'Location Category',
		'singular_name'              => 'Location Category',
		'menu_name'                  => 'Categories',
		'all_items'                  => 'All Categories',
		'parent_item'                => 'Parent Location Category',
		'parent_item_colon'          => 'Parent Location Category:',
		'new_item_name'              => 'New Location Category',
		'add_new_item'               => 'Add New Location Category',	
		'edit_item'                  => 'Edit Location Category',
		'update_item'                => 'Update Location Category',
		'separate_items_with_commas' => 'Separate Categories with commas',
		'search_items'               => 'Search Location Category',
		'add_or_remove_items'        => 'Add or Remove Item Category',
		'choose_from_most_used'      => 'Choose From Most Used Categories',
		'not_found'                  => 'Not Found',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_menu'				 => false,
	);
	register_taxonomy( 'locationcategory', array( 'locations' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'scp_location_category_taxonomy', 0 );
?>