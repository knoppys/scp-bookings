<?php


/**
Register post types
1. Bookings
2. Apartments
3. Clients
4. Operators
5. Companies
6. Locations
7. Special Offers
**********/
/** 
1. Bookings post type 
***/
function custom_post_type_bookings() {

	$labels = array(
		'name'                => 'Bookings',
		'singular_name'       => 'Booking',
		'menu_name'           => 'SCP Bookings',
		'parent_item_colon'   => 'Parent Booking:',
		'all_items'           => 'All Bookings',
		'view_item'           => 'View Booking',
		'add_new_item'        => 'Guest Name',
		'add_new'             => 'Add Booking',
		'edit_item'           => 'Edit Booking',
		'update_item'         => 'update Booking',
		'search_items'        => 'Search Bookings',
		'not_found'           => 'No Bookings found',
		'not_found_in_trash'  => 'No Bookings found in trash',
	);
	$args = array(
		'label'               => 'Bookings',
		'description'         => 'This section relates to Bookings',
		'labels'              => $labels,
		'supports'            => array( 'title', 'revisions'),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => false,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 100,
		'menu_icon'           => 'dashicons-book-alt',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'bookings', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type_bookings', 0 );



/** 
2. Apartments post type 
***/
function custom_post_type_apartments() {

	$labels = array(
		'name'                => 'Apartments',
		'singular_name'       => 'Apartment',
		'menu_name'           => 'Apartments',
		'parent_item_colon'   => 'Parent Apartment:',
		'all_items'           => 'Apartments',
		'view_item'           => 'View Apartment',
		'add_new_item'        => 'Add New Apartment',
		'add_new'             => 'Add New',
		'edit_item'           => 'Edit Apartment',
		'update_item'         => 'update Apartment',
		'search_items'        => 'Search Apartments',
		'not_found'           => 'No apartments found',
		'not_found_in_trash'  => 'No apartments found in trash',
	);
	$args = array(
		'label'               => 'apartments',
		'description'         => 'This section relates to Apartments',
		'labels'              => $labels,
		'supports'            => array( 'title','thumbnail', 'page-attributes', ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => false,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 100,
		'menu_icon'           => 'dashicons-admin-home',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'apartments', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type_apartments', 0 );


/** 
3. Clients post type 
***/
function custom_post_type_clients() {

	$labels = array(
		'name'                => 'Clients',
		'singular_name'       => 'Client',
		'menu_name'           => 'Clients',
		'parent_item_colon'   => 'Parent Client:',
		'all_items'           => 'Clients',
		'view_item'           => 'View Client',
		'add_new_item'        => 'Add New Client',
		'add_new'             => 'Add New',
		'edit_item'           => 'Edit Client',
		'update_item'         => 'update Client',
		'search_items'        => 'Search Clients',
		'not_found'           => 'No Clients found',
		'not_found_in_trash'  => 'No Clients found in trash',
	);
	$args = array(
		'label'               => 'Clients',
		'description'         => 'This section relates to Clients',
		'labels'              => $labels,
		'supports'            => array( 'title','thumbnail', ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => false,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 100,
		'menu_icon'           => 'dashicons-admin-home',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'clients', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type_clients', 0 );

/** 
4. Operators post type 
***/
function custom_post_type_Operators() {

	$labels = array(
		'name'                => 'Operators',
		'singular_name'       => 'Operator',
		'menu_name'           => 'Operators',
		'parent_item_colon'   => 'Parent Operator:',
		'all_items'           => 'Operators',
		'view_item'           => 'View Operator',
		'add_new_item'        => 'Add New Operator',
		'add_new'             => 'Add New',
		'edit_item'           => 'Edit Operator',
		'update_item'         => 'update Operator',
		'search_items'        => 'Search Operators',
		'not_found'           => 'No Operators found',
		'not_found_in_trash'  => 'No Operators found in trash',
	);
	$args = array(
		'label'               => 'Operators',
		'description'         => 'This section relates to Operators',
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => false,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => false,
		'menu_position'       => 100,
		'menu_icon'           => 'dashicons-admin-home',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'Operators', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type_Operators', 0 );




/** 
5. Locations post type 
***/
function custom_post_type_Locations() {

	$labels = array(
		'name'                => 'Locations',
		'singular_name'       => 'Location',
		'menu_name'           => 'Locations',
		'parent_item_colon'   => 'Parent Location:',
		'all_items'           => 'Locations',
		'view_item'           => 'View Location',
		'add_new_item'        => 'Add New Location',
		'add_new'             => 'Add New',
		'edit_item'           => 'Edit Location',
		'update_item'         => 'update Location',
		'search_items'        => 'Search Locations',
		'not_found'           => 'No Locations found',
		'not_found_in_trash'  => 'No Locations found in trash',
	);
	$args = array(
		'label'               => 'Locations',
		'description'         => 'This section relates to Locations',
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => false,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => false,
		'menu_position'       => 2,
		'menu_icon'           => 'dashicons-admin-home',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'locations', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type_locations', 0 );

/** 
1. Special Offers post type 
***/
function custom_post_type_special_offers() {

	$labels = array(
		'name'                => 'Special Offers',
		'singular_name'       => 'Offer',
		'menu_name'           => 'SCP Special Offers',
		'parent_item_colon'   => 'Parent Offer:',
		'all_items'           => 'All Special Offers',
		'view_item'           => 'View Offer',
		'add_new_item'        => 'Add new offer',
		'add_new'             => 'Add Offer',
		'edit_item'           => 'Edit Offer',
		'update_item'         => 'Update Offer',
		'search_items'        => 'Search Special Offers',
		'not_found'           => 'No Special Offers found',
		'not_found_in_trash'  => 'No Special Offers found in trash',
	);
	$args = array(
		'label'               => 'Special Offers',
		'description'         => 'This section relates to Special Offers',
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 100,
		'menu_icon'           => 'dashicons-book-alt',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'special_offers', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type_special_offers', 0 );



/** 
1. Welcome Packs post type 
***/
function custom_post_type_welcomepacks() {

	$labels = array(
		'name'                => 'Welcome Packs',
		'singular_name'       => 'Welcome Pack',
		'menu_name'           => 'Welcome Packs',
		'parent_item_colon'   => 'Parent Welcome Pack:',
		'all_items'           => 'All Welcome Packs',
		'view_item'           => 'View Welcome Pack',
		'add_new_item'        => 'Add new Welcome Pack',
		'add_new'             => 'Add Welcome Pack',
		'edit_item'           => 'Edit Welcome Pack',
		'update_item'         => 'Update Welcome Pack',
		'search_items'        => 'Search Welcome Packs',
		'not_found'           => 'No Welcome Packs found',
		'not_found_in_trash'  => 'No Welcome Packs found in trash',
	);
	$args = array(
		'label'               => 'Welcome Packs',
		'description'         => 'This section relates to Welcome Packs',
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => false,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 100,
		'menu_icon'           => 'dashicons-book-alt',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'welcomepacks', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type_welcomepacks', 0 );

/*** 
1. Reseller Pages post type 
***/
function custom_post_type_resellerp() {

	$labels = array(
		'name'                => 'Reseller Pages',
		'singular_name'       => 'Reseller Page',
		'menu_name'           => 'Reseller Pages',
		'parent_item_colon'   => 'Parent Reseller Page:',
		'all_items'           => 'All Reseller Pages',
		'view_item'           => 'View Reseller Page',
		'add_new_item'        => 'Add new Reseller Page',
		'add_new'             => 'Add Reseller Page',
		'edit_item'           => 'Edit Reseller Page',
		'update_item'         => 'Update Reseller Page',
		'search_items'        => 'Search Reseller Pages',
		'not_found'           => 'No Reseller Pages found',
		'not_found_in_trash'  => 'No Reseller Pages found in trash',
	);
	$args = array(
		'label'               => 'Reseller Pages',
		'description'         => 'This section relates to Reseller Pages',
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => false,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 100,
		'menu_icon'           => 'dashicons-book-alt',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'resellerp', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type_resellerp', 0 );


/*** 
1. City Guides post type 
***/
function custom_post_type_cityguides() {

	$labels = array(
		'name'                => 'City Guides',
		'singular_name'       => 'City Guide',
		'menu_name'           => 'City Guides',
		'parent_item_colon'   => 'Parent City Guide:',
		'all_items'           => 'All City Guides',
		'view_item'           => 'View City Guide',
		'add_new_item'        => 'Add new City Guide',
		'add_new'             => 'Add City Guide',
		'edit_item'           => 'Edit City Guide',
		'update_item'         => 'Update City Guide',
		'search_items'        => 'Search City Guides',
		'not_found'           => 'No City Guides found',
		'not_found_in_trash'  => 'No City Guides found in trash',
	);
	$args = array(
		'label'               => 'City Guides',
		'description'         => 'This section relates to City Guides',
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail', 'editor'),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => false,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 100,
		'menu_icon'           => 'dashicons-book-alt',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'cityguides', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type_cityguides', 0 );
?>