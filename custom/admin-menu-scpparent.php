<?php

add_action( 'admin_menu', 'register_my_custom_menu_page' );

function register_my_custom_menu_page(){
	add_menu_page( 'SCP Bookings Dashboard', 'SCP Bookings', 'publish_pages', 'scp-bookings-parent', 'my_custom_menu_page', plugins_url( 'scp-bookings/images/iconmenu.png' ), 6 ); 
	add_submenu_page( 'scp-bookings-parent', 'Apartments', 'Apartments', 'publish_pages', 'apartmentslistingsview', 'apartmentslistings_callback' );
	add_submenu_page( 'scp-bookings-parent', 'Operators', 'Operators', 'publish_pages', 'operatorslistings', 'operatorslistings_callback' );
	add_submenu_page( 'scp-bookings-parent', 'Clients', 'Clients', 'publish_pages', 'clients', 'clientlistings_callback' );
	add_submenu_page( 'scp-bookings-parent', 'Locations', 'Locations', 'publish_pages', 'Locationslistings', 'Locationslistings_callback' );
	add_submenu_page( 'scp-bookings-parent', 'City Guides', 'City Guides', 'publish_pages', 'cityguides', 'cityguides_callback' );
	add_submenu_page( 'scp-bookings-parent', 'Reports', 'Reports', 'publish_pages', 'reports', 'upcomingbookings_callback' );	
	add_submenu_page( 'scp-bookings-parent', 'Customer Query', 'Customer Query', 'publish_pages', 'customerquery', 'customerquery_callback' );
	add_submenu_page( 'scp-bookings-parent', 'Welcome Packs', 'Welcome Packs', 'publish_pages', 'welcomepackquery', 'welcomepacks_callback' );
	add_submenu_page( 'scp-bookings-parent', 'Reseller Pages', 'Reseller Pages', 'publish_pages', 'resellerp', 'resellerp_callback' );
	add_submenu_page( 'scp-bookings-parent', 'Documentation', 'Documentation', 'publish_pages', 'documentation', 'documentation_callback' );
	
}

function my_custom_menu_page(){
	
	//get all the required information for the query builder. 
			global $post; 

			echo '<div class="wrap">';
			echo '<h2>SCP Bookings</h1>';
			echo '<div class="apartments-button"><a href="' . site_url() . '/wp-admin/post-new.php?post_type=bookings" class="page-title-action">Add Booking</a></div>';


			$args = array ('post_type'=>'bookings','posts_per_page' => -1);
			$apartmentsquery = new WP_Query( $args );

			//get the apartments
			if ( $apartmentsquery->have_posts() ) { ?>
				<table style="width:100%;" class="bookingstable postbox">
					<thead>
						<tr>
							<th>
								<strong><p></i>Date Added</p></strong>
							</th>
							<th>
								<strong><p>Guest name</p></strong>
							</th>
							<th>
								<strong><p>Apartment</p></strong>
							</th>
							<th>
								<strong><p>Booking Type</p></strong>
							</th>
							<th style="text-align:center;">
								<strong><p>No of guests</p></strong>
							</th>	
							<th>
								<strong><p>Operator</p></strong>
							</th>
							<th>
								<strong><p>Client</p></strong>
							</th>
							<th style="display:none;"></th>
							<th>
								<strong><p>Check In</p></strong>
							</th>							
							<th>
								<strong><p>Check Out</p></strong>
							</th>												
							<th>
								Welcome Pack
							</th>
						</tr>
					</thead>
				<tbody>
				<?php while ( $apartmentsquery->have_posts() ) { $apartmentsquery->the_post(); 
					$refid = get_post_meta($post->ID, 'refid', true);
					$guestname = get_post_meta($post->ID, 'guestname', true);
					$apartment = get_post_meta($post->ID, 'apartmentname', true);
					$bookingtype = get_post_meta($post->ID, 'bookingtype', true);
					$noofguests = get_post_meta($post->ID, 'numberofguests', true);
					$operatorname = get_post_meta( $post->ID, 'operatorname', true );
					$clientname = get_post_meta( $post->ID, 'clientname', true );
					if (!empty(get_post_meta( $post->ID, 'actualcheckintime', true ))) {
						$checkintime = get_post_meta($post->ID,'actualcheckintime',true);
					} else {
						$checkintime = get_post_meta($post->ID,'checkintime',true);
					};
					if (!empty(get_post_meta( $post->ID, 'actualcheckouttime', true ))) {
						$checkouttime = get_post_meta($post->ID,'actualcheckouttime',true);
					} else {
						$checkouttime = get_post_meta($post->ID,'checkouttime',true);
					};
					$arrivaldate = get_post_meta($post->ID, 'arrivaldate', true);
					$leavingdate = get_post_meta($post->ID, 'leavingdate', true);
					$welcomepack = get_post_meta($post->ID, 'welcomepack', true);
					//get operator by title
					$operatorobject = get_page_by_title( $operatorname, OBJECT, 'operators' );
					//get client  by title
					$clientobject = get_page_by_title( $operatorname, OBJECT, 'clients' );

									
					?>

				<tr>
					<td><?php the_time('d M'); ?></td>
					<td><a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo get_the_id(); ?>&action=edit"><?php echo $guestname; ?></a></td>
					<td><a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo get_the_id(); ?>&action=edit"><?php echo $apartment ?></a></td>
					<td><?php echo $bookingtype; ?></td>
					<td style="text-align:center;"><?php echo $noofguests; ?></td>
					<td><a href="http://www.servicedcitypads.com/wp-admin/post.php?post=<?php echo $operatorobject->ID; ?>&action=edit"><?php echo $operatorname; ?></a></td>
					<td><a href="http://www.servicedcitypads.com/wp-admin/post.php?post=<?php echo $clientobject->ID; ?>&action=edit"><?php echo $clientname; ?></a></td>
					<td style="display:none;"><?php echo strtotime($arrivaldate); ?></td>
					<td><?php echo $arrivaldate;?></td>
					<td><?php echo $leavingdate;?></td>
					<td><?php echo $welcomepack; ?></td>
				</tr>
				
				<?php } } else {} 
				echo '</tbody>';
				echo '</table>';

				wp_reset_postdata();

}

 ?>