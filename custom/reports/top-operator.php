<?php
/**
**********************************
Leader Board Tab - Top Operator
**********************************
**/
function implement_ajax_topoperatorsearch() {

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
			
			ob_start();
			/*************************CONTENT STARTS HERE************************/

			$args = array ('post_type'=>'Operators', 'posts_per_page' => -1);
			$operatorquery = new WP_Query( $args );

			//get the operators
			if ( $operatorquery->have_posts() ) { ?>
				
					<thead>
						<tr>
							<th>
							<strong><p><i class="fa fa-user"></i>Operator Name</p></strong>
							</th>
							<th>
								<strong><p><i class="fa fa-gbp"></i>Operator Spend</p></strong>
							</th>
						</tr>						
					</thead>						
					<tbody>
				<?php while ( $operatorquery->have_posts() ) { $operatorquery->the_post();

						$operatorname = get_the_title($ID);

						//row for each operator starts here
						echo '<tr>';

							//Operator Name
							echo '<td>';							
							the_title('<p>','</p>');
							echo '</td>';

							//start a new query in this cell for the operator spend
							echo '<td>';
								$args2 = array (
									'post_type'=>'bookings',
									'meta_query' => array(
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

add_action('wp_ajax_topoperator', 'implement_ajax_topoperatorsearch');
add_action('wp_ajax_nopriv_topoperator', 'implement_ajax_topoperatorsearch');