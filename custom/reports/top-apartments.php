<?php
/**
**********************************
Leader Board Tab - Top Apartments
**********************************
**/
function implement_ajax_topapartmentssearch() {

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
			$clientname = ($_POST['clientname']);
			$operatorname = ($_POST['operatorname']);
			
			ob_start();
			/*************************CONTENT STARTS HERE************************/

			//Get all the apartments before we get all their bookings. 
			$args = array ('post_type'=>'apartments', 'posts_per_page' => -1);
			$getapartment = get_posts( $args ); ?>
			<thead>
				<tr>
					<th>
					<strong><p><i class="fa fa-user"></i>Apartment Name</p></strong>
					</th>
					<th>
						<strong><p><i class="fa fa-gbp"></i>Apartment Spend</p></strong>
					</th>
				</tr>						
			</thead>						
			<tbody>
			<?php foreach ( $getapartment as $apartment ) : setup_postdata( $post ); ?>
				<tr class="sortrows">
					<td>
						<?php echo $apartment->post_title; ?>
					</td>
					<td>
					<?php
					//get all the bookings that match this apartment			
					$apartmentname = $apartment->post_title;
					if ( ( $clientname == 'ANY' ) && ( $operatorname == 'ANY') ) {
							$args2 = array (
								'post_type'=>'bookings',
								'meta_query' => array(							
									array(
										'key' => 'arrivaldate',
										'value' => $datestring,
										'compare' => 'IN',
									)			
								),
							);
						} elseif ( ( $clientname !== 'ANY' ) && ( $operatorname == 'ANY' ) ) {
							$args2 = array (
								'post_type'=>'bookings',
								'meta_query' => array(		
									'relation' => 'AND',							
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
						} elseif ( ( $clientname == 'ANY' ) && ( $operatorname !== 'ANY' ) ) {
							$args2 = array (
								'post_type'=>'bookings',
								'meta_query' => array(		
									'relation' => 'AND',
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
						} elseif ( ( $clientname !== 'ANY' ) && ( $operatorname !== 'ANY' ) ) {
							$args2 = array (
								'post_type'=>'bookings',
								'meta_query' => array(		
									'relation' => 'AND',					
									array(
										'key' => 'clientname',
										'value' => $clientname,
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
				
		};

add_action('wp_ajax_topapartments', 'implement_ajax_topapartmentssearch');
add_action('wp_ajax_nopriv_topapartments', 'implement_ajax_topapartmentssearch');