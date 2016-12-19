<?php
/**
**********************************
Leader Board Tab - Top Client
**********************************
**/
function implement_ajax_topclientsearch() {

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
			
			ob_start();
			/*************************CONTENT STARTS HERE************************/

			$args = array ('post_type'=>'clients', 'posts_per_page' => -1);
			$clientquery = new WP_Query( $args );

			//get the clients
			if ( $clientquery->have_posts() ) { ?>
				<thead>
					<tr>
						<th>
						<strong><p><i class="fa fa-user"></i>Client Name</p></strong>
						</th>
						<th>
							<strong><p><i class="fa fa-gbp"></i>Client Spend</p></strong>
						</th>
					</tr>						
				</thead>						
				<tbody>

				<?php while ( $clientquery->have_posts() ) { $clientquery->the_post();

						$clientname = get_the_title($ID);

						//row for each clent starts here
						echo '<tr class="sortrows">';

							//Client Name
							echo '<td>';							
							the_title('<p>','</p>');
							echo '</td>';

							//start a new query in this cell for the client spend
							echo '<td class="sortnr">';
								$args2 = array (
									'post_type'=>'bookings',
									'meta_query' => array(
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
				
		}

add_action('wp_ajax_topclient', 'implement_ajax_topclientsearch');
add_action('wp_ajax_nopriv_topclient', 'implement_ajax_topclientsearch');