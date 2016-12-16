<?php
/**
**********************************
Client Report Tab
**********************************
**/
function implement_ajax_clientsearch() {

		//get the posted values from the search fields that dont require any validation	
		//set the date
		if ( ($_POST['startdate']) ) {
			$startdate = ($_POST['startdate']);
		} else {
			$startdate = '01.01.' . date('Y');
		}
		//set the date
		if ( ($_POST['enddate']) ) {
			$enddate = ($_POST['enddate']);
		} else {
			$enddate = '31.12.' . date('Y');
		}

		$datestring = join(',',dateRange($startdate, $enddate));

		$clientname = ($_POST['clientname']);
		$apartmentname = ($_POST['apartmentname']);
		$location = ($_POST['location']);		

		//Query all the clients bookings
		if( isset($clientname) && ( !isset($apartmentname) || ($apartmentname == 'ANY') ) &&  ( !isset($location) || ($location == 'ANY') ) ) {
			$args = array( 
				'post_type' => 'bookings',
				'meta_key' => 'arrivaldate',
				'meta_value' => $datestring,
				'meta_compare' => 'IN',
				'posts_per_page' => -1,	
				'meta_query' => array(
						array(
							'key' => 'clientname',
							'value' => $clientname,
							'compare' => '=',
						),										
				),							
				
			);

		}//Query all the clients bookings in a particular apartment
		elseif( isset($clientname) && ( isset($apartmentname) || ($apartmentname !== 'ANY') ) &&  ( !isset($location) || ($location == 'ANY') ) ) {
		   $args = array( 
				'post_type' => 'bookings',
				'meta_key' => 'arrivaldate',
				'meta_value' => $datestring,
				'meta_compare' => 'IN',
				'posts_per_page' => -1,	
				'meta_query' => array(
					'relation' => 'AND',
						array(
							'key' => 'clientname',
							'value' => $clientname,
							'compare' => '=',
						),
						array(
							'key' => 'apartmentname',
							'value' => $apartmentname,
							'compare' => '=',
							
						),					
				),							
				
			);
		}//Query all the clients bookings in a particular location
		elseif( isset($clientname) && ( !isset($apartmentname) || ($apartmentname == 'ANY') ) &&  ( isset($location) || ($location !== 'ANY') ) ) {
			$args = array( 
				'post_type' => 'bookings',
				'meta_key' => 'arrivaldate',
				'meta_value' => $datestring,
				'meta_compare' => 'IN',
				'posts_per_page' => -1,	
				'meta_query' => array(
					'relation' => 'AND',
						array(
							'key' => 'clientname',
							'value' => $clientname,
							'compare' => '=',
						),
						array(
							'key' => 'location',
							'value' => $location,
							'compare' => '=',
							
						),					
				),
			);
		}//Query all bookings by a client in a particular apartment in a particular location
		elseif( isset($clientname) && ( isset($apartmentname) || ($apartmentname !== 'ANY') ) &&  ( isset($location) || ($location !== 'ANY') ) ) {
			$args = array( 
				'post_type' => 'bookings',
				'meta_key' => 'arrivaldate',
				'meta_value' => $datestring,
				'meta_compare' => 'IN',
				'posts_per_page' => -1,	
				'meta_query' => array(
					'relation' => 'AND',
						array(
							'key' => 'clientname',
							'value' => $clientname,
							'compare' => '=',
						),
						array(
							'key' => 'apartmentname',
							'value' => $apartmentname,
							'compare' => '=',
							
						),
						array(
							'key' => 'location',
							'value' => $location,
							'compare' => '=',
							
						),					
				),
			);
		}
		
 		

			// The Query
			$query = new WP_Query( $args );
			ob_start();
			// The Loop
			if ( $query->have_posts() ) {?>	
				<thead>
					<tr>
						<th>
							<p><strong>Booking Ref</strong></p>
						</th>
						
						<th>
							<p><strong>Client Name</strong></p>
						</th>						
						<th>
							<p><strong>Apartment Name</strong></p>
						</th>
						<th>
							<p><strong>Location</strong></p>
						</th>
						<th>
							<p><strong>No of nights</strong></p>
						</th>
						<th>
							<p><strong>Nightly Rate</strong></p>
						</th>
						<th>
							<p><strong>Cost Code</strong></p>
						</th>
						<th>
							<p><strong>Total Cost</strong></p>
						</th>						
						<th class="options">
							<p><strong>Options</strong></p>
						</th>
					</tr>
				</thead>
				<tfoot>
					<!-- Total Spend Control Row -->
					<tr>						
						<td class="report-footer">							
						</td>
						<td class="report-footer">							
						</td>
						<td class="report-footer">							
						</td>
						<td class="report-footer">							
						</td>							
						<td class="report-footer">							
						</td>
						<td class="report-footer">							
						</td>							
						<td class="report-footer">
							<button class="wp-core-ui button-primary" id="calculate_total">Total Spend</button>
						</td>
						<td class="report-footer">
							<strong><p style="text-align:right;"id="total_spend"></p></strong>
						</td>						
						<td class="report-footer options">							
						</td>
					</tr>
					<!-- Average Spend Control Row -->
					<tr>						
						<td class="report-footer">							
						</td>
						<td class="report-footer">							
						</td>
						<td class="report-footer">							
						</td>
						<td class="report-footer">							
						</td>							
						<td class="report-footer">							
						</td>
						<td class="report-footer">							
						</td>							
						<td class="report-footer">
							<button class="wp-core-ui button-primary" id="calculate_average">Average Spend</button>
						</td>
						<td class="report-footer">
							<strong><p style="text-align:right;"id="average_spend"></p></strong>									
						</td>						
						<td class="report-footer options">							
						</td>
					</tr>
					<tr>						
						<td class="report-footer">							
						</td>
						<td class="report-footer">							
						</td>
						<td class="report-footer">							
						</td>						
						<td class="report-footer">							
						</td>		
						<td class="report-footer">							
						</td>	
						<td class="report-footer">							
						</td>					
						<td class="report-footer">
							<button class="wp-core-ui button-primary" id="calculate_total_bookings">Total Bookings</button>
						</td>
						<td class="report-footer">
							<strong><p style="text-align:right;"id="total_bookings"></p></strong>									
						</td>						
						<td class="report-footer options">							
						</td>
					</tr>
					<tr>						
						<td class="report-footer">							
						</td>
						<td class="report-footer">							
						</td>
						<td class="report-footer">							
						</td>						
						<td class="report-footer">							
						</td>		
						<td class="report-footer">							
						</td>	
						<td class="report-footer">							
						</td>					
						<td class="report-footer">
							<button class="wp-core-ui button-primary" id="calculate_average_duration">Average Duration</button>
						</td>
						<td class="report-footer">
							<strong><p style="text-align:right;"id="average_duration"></p></strong>									
						</td>						
						<td class="report-footer options">							
						</td>
					</tr>
					<tr>						
						<td class="report-footer">							
						</td>
						<td class="report-footer">							
						</td>	
						<td class="report-footer">							
						</td>					
						<td class="report-footer">							
						</td>		
						<td class="report-footer">							
						</td>	
						<td class="report-footer">							
						</td>					
						<td class="report-footer">
							<button class="wp-core-ui button-primary" id="calculate_average_nightly">Average Nightly Rate</button>
						</td>
						<td class="report-footer">
							<strong><p style="text-align:right;"id="average_nightly"></p></strong>									
						</td>						
						<td class="report-footer options">							
						</td>
					</tr>
				</tfoot>
				<tbody id="clientreportbody">
				<?php while ( $query->have_posts() ) {

					$query->the_post(); 

					//get the id
					$ID = get_the_ID();
					//get the post meta	
					$startdate = get_post_meta( $ID, 'arrivaldate', true );
				    $enddate = get_post_meta( $ID, 'leavingdate', true );			    	  
				    $operatorname = get_post_meta( $ID, 'operatorname', true);
				    $balancedue = get_post_meta($ID, 'balancedue', true);
				    $apartmentname = get_post_meta($ID, 'apartmentname', true);				   
				    $clientname = get_post_meta($ID, 'clientname', true);			  
				    $totalcost = get_post_meta($ID, 'totalcost', true);
				    $location = get_post_meta($ID, 'location', true);
				    $costcode = get_post_meta($ID, 'costcode', true);

				    //calculate number of nights stay				     
				    $datetime1 = new DateTime($startdate);
				    $datetime2 = new DateTime($enddate);
				    $interval = $datetime1->diff($datetime2);
				    $numberofnights = $interval->format('%a');

				    //get the nightly rate
				    $nightlyrate = $totalcost / $numberofnights;
				    $nicenightly = round($nightlyrate, 2);

					?>
				
					
						<tr class="booking">
							<td>
								<p><?php the_title(); ?></p>
							</td>							
							<td>
								<p><?php echo $clientname; ?></p>
							</td>
							<td>
								<p><?php echo $apartmentname; ?></p>
							</td>
							<td>
								<p><?php echo $location; ?></p>
							</td>
							<td class="numberofnights">
								<p><?php echo $numberofnights; ?></p>
							</td>
							<td class="nightlyrate">
								<p><?php echo $nicenightly; ?></p>
							</td>
							<td class="">
								<p><?php echo $costcode; ?></p>
							</td>
							<td style="text-align:right;" class="total-cost">
								<p><strong><?php echo floor($totalcost); ?></strong></p>
							</td>						
							<td class="options">
								<a href="<?php echo get_site_url();?>/wp-admin/post.php?post=<?php echo $ID ;?>&action=edit"><i class="fa fa-file-text" style="padding-right:10px;"></i></a>
							</td>
						</tr>
					<?php } ?>
				
			<?php } else {
				echo 'no posts found';
			} ?>		

			<?php 
			echo '</tbody>';
			// Restore original Post Data
			wp_reset_postdata();

			$content = ob_get_clean();
	
			echo $content;

			die();
				
		}

add_action('wp_ajax_clientreport', 'implement_ajax_clientsearch');
add_action('wp_ajax_nopriv_clientreport', 'implement_ajax_clientsearch');