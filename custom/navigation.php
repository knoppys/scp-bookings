<?php
//main bookings listings
add_action( 'admin_menu', 'register_my_custom_menu_page' );
add_action( 'admin_init', 'clientreportsettings' );
add_action( 'admin_init', 'operatorreportsettings' );
add_action( 'admin_init', 'locationreportsettings' );
add_action( 'admin_init', 'apartmentreportsettings' );

function register_my_custom_menu_page(){
add_menu_page( 'SCP Bookings Dashboard', 'SCP Bookings', 'publish_pages', 'scp_bookings-parent', 'my_custom_menu_page', plugins_url( 'scp_bookings/images/iconmenu.png' ), 3 ); 
	add_submenu_page( 'scp_bookings-parent', 'Corporate', '- Corporate', 'publish_pages', 'corporatelistings', 'corporatelistings_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Groups', '- Groups', 'publish_pages', 'groupslistings', 'groupslistings_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Leisure', '- Leisure', 'publish_pages', 'leisurelistings', 'leisurelistings_callback' );

	add_submenu_page( 'scp_bookings-parent', 'Search', 'Search', 'publish_pages', 'searchmaps', 'searchmaps_callback' );


	add_submenu_page( 'scp_bookings-parent', 'Accounts', 'Accounts', 'publish_pages', 'accountlistings', 'accountslistings_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Apartments', 'Apartments', 'publish_pages', 'apartmentslistingsview', 'apartmentslistings_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Operators', 'Operators', 'publish_pages', 'operatorslistings', 'operatorslistings_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Clients', 'Clients', 'publish_pages', 'clients', 'clientlistings_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Locations', 'Locations', 'publish_pages', 'Locationslistings', 'Locationslistings_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Locations', '- Location Types', 'publish_pages', 'locationtypes', 'locationtypes_callback' );
	add_submenu_page( 'scp_bookings-parent', 'City Guides', 'City Guides', 'publish_pages', 'cityguides', 'cityguides_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Reports', 'Reports', 'publish_pages', 'reports', 'upcomingbookings_callback' );	

	add_submenu_page( 'scp_bookings-parent', 'Client Options', '- Client Options', 'manage_options', 'client_options', 'client_options_page');
	add_submenu_page( 'scp_bookings-parent', 'Operator Options', '- Operator Options', 'manage_options', 'operator_options', 'operator_options_page');
	add_submenu_page( 'scp_bookings-parent', 'Location Options', '- Location Options', 'manage_options', 'location_options', 'location_options_page');
	add_submenu_page( 'scp_bookings-parent', 'Apartment Options', '- Apartment Options', 'manage_options', 'apartment_options', 'apartment_options_page');
	
	add_submenu_page( 'scp_bookings-parent', 'Customer Query', 'Customer Query', 'publish_pages', 'customerquery', 'customerquery_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Welcome Packs', 'Welcome Packs', 'publish_pages', 'welcomepackquery', 'welcomepacks_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Reseller Pages', 'Reseller Pages', 'publish_pages', 'resellerp', 'resellerp_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Documentation', 'Documentation', 'publish_pages', 'documentation', 'documentation_callback' );

}
