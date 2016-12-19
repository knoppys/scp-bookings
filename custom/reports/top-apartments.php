<?php
/**
**********************************
Leader Board Tab - Top Apartments
**********************************
**/
function implement_ajax_topapartmentssearch() {

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
			$clientname = ($_POST['clientname']);
			$operatorname = ($_POST['operatorname']);
			
			ob_start();
			/*************************CONTENT STARTS HERE************************/

			$args = array ('post_type'=>'apartments', 'posts_per_page' => -1);
			$apartmentsquery = new WP_Query( $args );

			//get the locationss
			if ( $apartmentsquery->have_posts() ) { ?>
				<thead>
					<tr>
						<th>
						<strong><p><i class="fa fa-user"></i>Apartment Name</p></strong>
						</th>
						<th>
							<strong><p><i class="fa fa-gbp"></i>Apartment Revenue</p></strong>
						</th>
					</tr>						
				</thead>						
				<tbody>
				<?php while ( $apartmentsquery->have_posts() ) { $apartmentsquery->the_post();

						$apartmentname = get_the_title($ID);

						//row for each clent starts here
						echo '<tr class="sortrows">';

							//locations Name
							echo '<td>';							
							the_title('<p>','</p>');
							echo '</td>';

							//start a new query in this cell for the apartments spend
							echo '<td class="sortnr">';
								if ( ( $clientname == 'ANY' ) && ( $operatorname == 'ANY') ) { //search by all
									$args2 = array (
										'post_type'=>'bookings',
										'meta_query' => array(									
											array(
												'key' => 'apartmentname',
												'value' => $apartmentname,
												'compare' => '=',
											)									
										),										
										'date_query' => array(
										        array(
										            'after' => $startdate,
										            'before' => $enddate,
										        ),			
										),
									);
								} elseif ( ( $clientname !== 'ANY' ) && ( $operatorname == 'ANY' ) ) { //search by clientname
									$args2 = array (
										'post_type'=>'bookings',
										'meta_query' => array(		
											'relation' => 'AND',							
											array(
												'key' => 'apartmentname',
												'value' => $apartmentname,
												'compare' => '=',
											),
											array(
												'key' => 'clientname',
												'value' => $clientname,
												'compare' => '=',
											),								
										),										
										'date_query' => array(
										        array(
										            'after' => $startdate,
										            'before' => $enddate,
										        ),			
										),
									);
								} elseif ( ( $clientname == 'ANY' ) && ( $operatorname !== 'ANY' ) ) { //search by operatorname
								$args2 = array (
									'post_type'=>'bookings',
									'meta_query' => array(		
										'relation' => 'AND',							
										array(
											'key' => 'apartmentname',
											'value' => $apartmentname,
											'compare' => '=',
										),
										array(
											'key' => 'operatorname',
											'value' => $operatorname,
											'compare' => '=',
										),								
									),										
									'date_query' => array(
									        array(
									            'after' => $startdate,
									            'before' => $enddate,
									        ),			
									),
								);
								} elseif ( ( $clientname !== 'ANY' ) && ( $operatorname !== 'ANY' ) ) { //searh by client and operator
									$args2 = array (
										'post_type'=>'bookings',
										'meta_query' => array(		
											'relation' => 'AND',							
											array(
												'key' => 'apartmentname',
												'value' => $apartmentname,
												'compare' => '=',
											),
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
										),										
										'date_query' => array(
										        array(
										            'after' => $startdate,
										            'before' => $enddate,
										        ),			
										),
									);
								};
								$bookingsquery = new WP_Query( $args2 );
								$sum = 0;
								if ( $bookingsquery->have_posts() ) {								
									while ( $bookingsquery->have_posts() ) {
										$bookingsquery->the_post();
										
										//get the operator as a variable									
										$bookingid = get_the_ID();
										$bookingspend = get_post_meta($bookingid, 'totalcost', true);
										$sum+= $bookingspend;
										

									}
								} else {}
								wp_reset_postdata();
								echo '<p>£' . $sum . '</p>';
							echo '</td>';
							//end the query in the second cell							
						echo '</tr>';					
					} 					
				
				} else {}
				echo '</tbody>';
				wp_reset_postdata();
			
			/*************************CONTENT ENDS HERE************************/
			$content = ob_get_clean();
			echo $content;

			die();
				
		};

add_action('wp_ajax_topapartments', 'implement_ajax_topapartmentssearch');
add_action('wp_ajax_nopriv_topapartments', 'implement_ajax_topapartmentssearch');