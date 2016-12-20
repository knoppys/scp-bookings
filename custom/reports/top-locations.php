<?php
/**
**********************************
Leader Board Tab - Top locations
**********************************
**/
function implement_ajax_toplocationssearch() {

			//get the posted values from the search fields that dont require any validation	
			//set the start date
			if ( ($_POST['startdate']) ) {
				$startdate = ($_POST['startdate']);
			} else {
				$startdate = '01.01.1970';
			}
			//set the end date
			if ( ($_POST['enddate']) ) {
				$enddate = ($_POST['enddate']);
			} else {
				$enddate = '31.12.3000';
			}
			//get the date array
			$datestring = join(',',dateRange($startdate, $enddate));
			$locationname = ($_POST['locationname']);
			$clientname = ($_POST['clientname']);
			$operatorname = ($_POST['operatorname']);
			
			ob_start();
			/*************************CONTENT STARTS HERE************************/

			//Get all the locations before we get all their bookings. 
			$args = array ('post_type'=>'locations', 'posts_per_page' => -1);
			$getlocation = get_posts( $args ); ?>
			<thead>
				<tr>
					<th>
					<strong><p><i class="fa fa-user"></i>Location Name</p></strong>
					</th>
					<th>
						<strong><p><i class="fa fa-gbp"></i>Location Spend</p></strong>
					</th>
				</tr>						
			</thead>						
			<tbody>
			<?php foreach ( $getlocation as $location ) : setup_postdata( $post ); ?>
				<tr class="sortrows">
					<td>
						<?php echo $location->post_title; ?>
					</td>
					<td>
					<?php
					//get all the bookings that match this location			
					$locationname = $location->post_title;
					if ( ( $locationname == 'ANY' ) && ( $operatorname == 'ANY') ) {
							$args2 = array (
								'post_type'=>'bookings',
								'meta_query' => array(									
									array(
										'key' => 'location',
										'value' => $locationsname,
										'compare' => '=',
									),									
									array(
										'key' => 'arrivaldate',
										'value' => $datestring,
										'compare' => 'IN',
									)			
								),
							);
						} elseif ( ( $locationname !== 'ANY' ) && ( $operatorname == 'ANY' ) ) {
							$args2 = array (
								'post_type'=>'bookings',
								'meta_query' => array(		
									'relation' => 'AND',							
									array(
										'key' => 'location',
										'value' => $locationsname,
										'compare' => '=',
									),
									array(
										'key' => 'clientname',
										'value' => $clientname,
										'compare' => '=',
									),								
									array(
										'key' => 'arrivaldate',
										'value' => $datestring,
										'compare' => 'IN',
									),
								)
							);
						} elseif ( ( $locationname == 'ANY' ) && ( $operatorname !== 'ANY' ) ) {
							$args2 = array (
								'post_type'=>'bookings',
								'meta_query' => array(		
									'relation' => 'AND',							
									array(
										'key' => 'location',
										'value' => $locationsname,
										'compare' => '=',
									),
									array(
										'key' => 'operatorname',
										'value' => $operatorname,
										'compare' => '=',
									),								
									array(
										'key' => 'arrivaldate',
										'value' => $datestring,
										'compare' => 'IN',
									)
								)
							);
						} elseif ( ( $locationname !== 'ANY' ) && ( $operatorname !== 'ANY' ) ) {
							$args2 = array (
								'post_type'=>'bookings',
								'meta_query' => array(		
									'relation' => 'AND',							
									array(
										'key' => 'location',
										'value' => $locationsname,
										'compare' => '=',
									),
									array(
										'key' => 'locationname',
										'value' => $locationname,
										'compare' => '=',
									),
									array(
										'key' => 'operatorname',
										'value' => $operatorname,
										'compare' => '=',
									),								
									array(
										'key' => 'arrivaldate',
										'value' => $datestring,
										'compare' => 'IN',
									)
								)
							);
						};

						//get the total cost field from each booking. 
						$getbookings = get_posts($args2);
						$sum = 0;
						foreach ( $getbookings as $booking ) : setup_postdata( $post );
							
							$bookingspend = get_post_meta($booking->ID, 'totalcost', true);
							$sum+= $bookingspend;

						endforeach; 
						wp_reset_postdata();
						
						//echo the total from all those bookings. 						
						echo '£'.money_format('%i', $sum);

						?>
					</td>
				</tr>			
			<?php endforeach; 
			wp_reset_postdata();
			
			
			/*************************CONTENT ENDS HERE************************/
			$content = ob_get_clean();
			echo $content;

			die();
				
		}
add_action('wp_ajax_toplocations', 'implement_ajax_toplocationssearch');
add_action('wp_ajax_nopriv_toplocations', 'implement_ajax_toplocationssearch');