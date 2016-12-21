<?php
//main bookings listings
add_action( 'admin_menu', 'register_my_custom_menu_page' );
add_action( 'admin_init', 'clientreportsettings' );
function register_my_custom_menu_page(){
	add_menu_page( 'SCP Bookings Dashboard', 'SCP Bookings', 'publish_pages', 'scp_bookings-parent', 'my_custom_menu_page', plugins_url( 'scp_bookings/images/iconmenu.png' ), 3 ); 
		add_submenu_page( 'scp_bookings-parent', 'Corporate', '- Corporate', 'publish_pages', 'corporatelistings', 'corporatelistings_callback' );
		add_submenu_page( 'scp_bookings-parent', 'Groups', '- Groups', 'publish_pages', 'groupslistings', 'groupslistings_callback' );
		add_submenu_page( 'scp_bookings-parent', 'Leisure', '- Leisure', 'publish_pages', 'leisurelistings', 'leisurelistings_callback' );


	add_submenu_page( 'scp_bookings-parent', 'Accounts', 'Accounts', 'publish_pages', 'accountlistings', 'accountslistings_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Apartments', 'Apartments', 'publish_pages', 'apartmentslistingsview', 'apartmentslistings_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Operators', 'Operators', 'publish_pages', 'operatorslistings', 'operatorslistings_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Clients', 'Clients', 'publish_pages', 'clients', 'clientlistings_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Locations', 'Locations', 'publish_pages', 'Locationslistings', 'Locationslistings_callback' );
	add_submenu_page( 'scp_bookings-parent', 'City Guides', 'City Guides', 'publish_pages', 'cityguides', 'cityguides_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Reports', 'Reports', 'publish_pages', 'reports', 'upcomingbookings_callback' );	
	add_submenu_page( 'scp_bookings-parent', 'Report Options', 'Report Options', 'manage_options', 'scp_bookings', 'scp_bookings_options_page');
	add_submenu_page( 'scp_bookings-parent', 'Customer Query', 'Customer Query', 'publish_pages', 'customerquery', 'customerquery_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Welcome Packs', 'Welcome Packs', 'publish_pages', 'welcomepackquery', 'welcomepacks_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Reseller Pages', 'Reseller Pages', 'publish_pages', 'resellerp', 'resellerp_callback' );
	add_submenu_page( 'scp_bookings-parent', 'Documentation', 'Documentation', 'publish_pages', 'documentation', 'documentation_callback' );
	
}

