<?php
function my_custom_menu_page(){
	
	//get all the required information for the query builder. 
			global $post; 

			echo '<div class="wrap">';
			echo '<h2>SCP Bookings</h1>';
			echo '<div class="apartments-button"><a href="' . site_url() . '/wp-admin/post-new.php?post_type=bookings" class="page-title-action">Add Booking</a></div>';


			$bookings = get_posts(array('posts_per_page'=>-1,'post_type'=>'bookings', 'post_parent' => 0, 'post_status' => array('publish','draft')));
			if ($bookings) { ?>
				<table style="width:100%;" class="bookingstable postbox">
					<thead>
						<tr>
							<th>
								<strong><p></i>Date<br>Posted</p></strong>
							</th>
							<th>
								<strong><p>Guest name</p></strong>
							</th>
							<th>
								<strong><p>Check In</p></strong>
							</th>							
							<th>
								<strong><p>Check Out</p></strong>
							</th>
							<th>
								<strong><p>Location</p></strong>
							</th>
							<th>
								<strong><p>Nights</p></strong>
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
							<th>
								Welcome Pack
							</th>
							<th>
								Duplicate
							</th>
							<th>
								In series
							</th>

						</tr>
					</thead>
				<tbody>
				<?php foreach ($bookings as $booking) {  
					//get post meta
					$bookingmeta = get_post_meta($booking->ID); 
					//get operator by title
					$operatorobject = get_page_by_title( $bookingmeta['operatorname'][0], OBJECT, 'operators' );
					//get client  by title
					$clientobject = get_page_by_title( $bookingmeta['clientname'][0], OBJECT, 'clients' );
					//get apartment by title
					$apartmentobject = get_page_by_title( $bookingmeta['apartmentname'][0], OBJECT, 'apartments' );
					//get the number of nights
					$datetime1 = new DateTime($bookingmeta['arrivaldate'][0]);
				    $datetime2 = new DateTime($bookingmeta['leavingdate'][0]);
				    $interval = $datetime1->diff($datetime2);
				    $numberofnights = $interval->format('%a');
					?>

					<tr>
						<td><?php echo mysql2date('d.m.y', $booking->post_date); ?></td>
						<td><a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo $booking->ID; ?>&action=edit"><?php echo $bookingmeta['guestname'][0]; ?></a></td>
						<td><?php echo $bookingmeta['arrivaldate'][0];?></td>
						<td><?php echo $bookingmeta['leavingdate'][0];?></td>
						<td><?php echo get_post_meta($apartmentobject->ID, 'apptlocation1', true); ?></td>
						<td><?php echo $numberofnights; ?></td>
						<td><a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo $booking->ID; ?>&action=edit"><?php echo $bookingmeta['apartmentname'][0] ?></a></td>
						<td><?php echo $bookingmeta['bookingtype'][0]; ?></td>
						<td style="text-align:center;"><?php echo $bookingmeta['numberofguests'][0]; ?></td>
						<td><a href="http://www.servicedcitypads.com/wp-admin/post.php?post=<?php echo $operatorobject->ID; ?>&action=edit"><?php echo $bookingmeta['operatorname'][0]; ?></a></td>
						<td><a href="http://www.servicedcitypads.com/wp-admin/post.php?post=<?php echo $clientobject->ID; ?>&action=edit"><?php echo $bookingmeta['clientname'][0]; ?></a></td>
						
						<td><?php echo $bookingmeta['welcomepack'][0]; ?></td>
						<td>
							<?php echo '
							<a href="admin.php?action=rd_duplicate_post_as_draft&amp;post=' . $booking->ID . '" title="Duplicate this item" rel="permalink">Duplicate</a>
							';
							?>
						</td>
						<td class="bookingexpand">
							<?php
							$args = array(
								'post_parent' => $booking->ID,
								'post_type'   => 'bookings', 
								'numberposts' => -1,
								'post_status' => 'any' 
							);
							$children = get_children( $args );
							if ($children) { ?>
								<span class="page-title-action">More</span>
								<div class="expand">
									<table>
										<tbody>
											<tr>
												<td class="childheader"><strong>Apartment name</strong></td>
												<td class="childheader"><strong>Checkin</strong></td>
												<td class="childheader"><strong>Checkout</strong></td>
											</tr>
											<?php
												foreach ($children as $child) { ?>													
													<tr>
														<td class="childcontent"><a href="post.php?post=<?php echo $child->ID; ?>&action=edit"><?php echo get_post_meta($child->ID, 'apartmentname', true); ?></td>
														<td class="childcontent"><?php echo get_post_meta($child->ID, 'arrivaldate', true); ?></td>
														<td class="childcontent"><?php echo get_post_meta($child->ID, 'leavingdate', true); ?></td>
													</tr>
												<?php }
											?>
										</tbody>
									</table>
								</div>
							<?php } else {} ?>							
						</td>
						
					</tr>

					<?php					

					if ($children){
						//do nohting
					} else {
						$leavingdate = strtotime(get_post_meta($booking->ID,'leavingdate',true ));
						$today = time();
						if ($leavingdate <= $today) {
							$post = array(
							'ID' => $booking->ID,
							'post_status' => 'archive',
							);
							wp_update_post($post);							
						};
					}

					
					?>
					

				<?php 
				}
				echo '</tbody>';
				echo '</table>';
			}
				
}