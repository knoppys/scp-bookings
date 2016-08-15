<?php

/**
Add sub menu page for listing apartmnets as the default page isnt comprehensive enough
**/
add_action('admin_menu', 'bookingslistingfunction');

function bookingslistingfunction() {
	add_submenu_page( 'mt-top-level-handle', 'Bookings', 'Bookings', 'manage_options', 'bookingslistings', 'bookingslistings_callback' );
}

function bookingslistings_callback() { 

			//get all the required information for the query builder. 
			global $post; 


			$args = array ('post_type'=>'bookings','posts_per_page' => -1);
			$apartmentsquery = new WP_Query( $args );

			//get the apartments
			if ( $apartmentsquery->have_posts() ) { ?>
				<table style="width:100%;" class="dashboard_widget">
					<thead>
						<tr>
							<th>
								<strong><p><i class="fa fa-user"></i>Booking ID</p></strong>
							</th>
							<th>
								<strong><p><i class="fa fa-user"></i>Guest name</p></strong>
							</th>
							<th>
								<strong><p><i class="fa fa-building"></i>Apartment</p></strong>
							</th>
							<th>
								<strong><p><i class="fa fa-user"></i>Booking Type</p></strong>
							</th>
							<th>
								<strong><p><i class="fa fa-users"></i>No of guests</p></strong>
							</th>	
							<th>
								<strong><p><i class="fa fa-user"></i>Operator</p></strong>
							</th>
							<th>
								<strong><p><i class="fa fa-user"></i>Client</p></strong>
							</th>
							<th>
								<strong><p><i class="fa fa-clock-0"></i>Check In</p></strong>
							</th>	
							<th>
								<strong><p><i class="fa fa-clock-0"></i>Check Out</p></strong>
							</th>						
						</tr>
					</thead>
				<tbody>
				<?php while ( $apartmentsquery->have_posts() ) { $apartmentsquery->the_post(); 
				
					$refid = get_post_meta($post->ID, 'refid', true);
					$guestname = get_post_meta($post->ID, 'guestname', true);
					$apartment = get_post_meta($post->ID, 'bookingsapartment_new_field', true);
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
						$checkintime = get_post_meta($post->ID,'actualcheckouttime',true);
					} else {
						$checkintime = get_post_meta($post->ID,'checkouttime',true);
					};
					$arrivaldate = get_post_meta($post->ID, 'arrivaldate', true);
					$leavingdate = get_post_meta($post->ID, 'leavingdate', true);
									
					?>

				<tr>
					<td><?php echo $refid; ?></td>
					<td><a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo get_the_id(); ?>&action=edit"><?php the_title(); ?></a></td>
					<td><?php echo $apartment; ?></td>
					<td><?php echo $bookngtype; ?></td>
					<td><?php echo $noofguests; ?></td>
					<td><?php echo $operatorname; ?></td>
					<td><?php echo $clientname; ?></td>
					<td><?php echo $arrivaldate;?><br><?php echo $checkintime; ?></td>
					<td><?php echo $leavingdate;?><br><?php echo $checkouttime; ?></td>
				</tr>
				
				<?php } } else {} 
				echo '</tbody>';
				echo '</table>';

				wp_reset_postdata();

 }

?>