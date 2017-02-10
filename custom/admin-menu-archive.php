<?php
function archivelistings_callback(){
	
	//get all the required information for the query builder. 
			global $post; 

			echo '<div class="wrap">';
			echo '<h2>SCP Bookings</h1>';
			echo '<div class="apartments-button"><a href="' . site_url() . '/wp-admin/post-new.php?post_type=bookings" class="page-title-action">Add Booking</a></div>';


			$bookings = get_posts(array('posts_per_page'=>-1,'post_type'=>'bookings', 'post_status' => array('archive')));
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
								In Series
							</th>
							

						</tr>
					</thead>
				<tbody>
				<?php foreach ($bookings as $booking) {  
					//get post meta
					$bookingmeta = get_post_meta($booking->ID); 
					//get operator by title
					//$operatorobject = get_page_by_title( $bookingmeta['operatorname'][0], OBJECT, 'operators' );
					//get client  by title
					//$clientobject = get_page_by_title( $bookingmeta['clientname'][0], OBJECT, 'clients' );
					//get apartment by title
					//$apartmentobject = get_page_by_title( $bookingmeta['apartmentname'][0], OBJECT, 'apartments' );
					//get the number of nights
					$datetime1 = new DateTime($bookingmeta['arrivaldate'][0]);
				    $datetime2 = new DateTime($bookingmeta['leavingdate'][0]);
				    $interval = $datetime1->diff($datetime2);
				    $numberofnights = $interval->format('%a');
					?>

					<tr>
						<td><a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo $booking->ID; ?>&action=edit"><?php echo mysql2date('d.m.y', $booking->post_date); ?></a></td>
						<td><?php echo $bookingmeta['guestname'][0]; ?></td>
						<td><?php echo $bookingmeta['arrivaldate'][0];?></td>
						<td><?php echo $bookingmeta['leavingdate'][0];?></td>
						<td><?php echo $bookingmeta['location'][0];?></td>
						<td><?php echo $numberofnights; ?></td>
						<td><?php echo $bookingmeta['apartmentname'][0] ?></td>
						<td><?php echo $bookingmeta['bookingtype'][0]; ?></td>
						<td style="text-align:center;"><?php echo $bookingmeta['numberofguests'][0]; ?></td>
						<td><?php echo $bookingmeta['operatorname'][0]; ?></td>
						<td><?php echo $bookingmeta['clientname'][0]; ?></td>
						
						<td><?php echo $bookingmeta['welcomepack'][0]; ?></td>
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
												foreach ($children as $child) { 
													$leavingdate = get_post_meta($child->ID, 'leavingdate', true);
													?>													
													<tr>
														<td class="childcontent"><a href="post.php?post=<?php echo $child->ID; ?>&action=edit"><?php echo get_post_meta($child->ID, 'apartmentname', true); ?></td>
														<td class="childcontent"><?php echo get_post_meta($child->ID, 'arrivaldate', true); ?></td>
														<td class="childcontent"><?php echo $leavingdate ?></td>
													</tr>
													<?php 
													$date1 = date_create($leavingdate);
													$date = new DateTime(date_format($date1,"Y/m/d"));
													$now = new DateTime();

														if($date < $now) {
														   	$post = array(
															'ID' => $booking->ID,
															'post_status' => 'archive',
															);
															wp_update_post($post);	
														}							
												}											
											?>
										</tbody>
									</table>
								</div>
							<?php } else {} ?>							
						</td>
						
						
					</tr>

					
					

				<?php 
			}
				
				echo '</tbody>';
				echo '</table>';
			}
	}				
