<?php
/**
**********************************
Leader Board Tab - Top Operator
**********************************
**/
function implement_ajax_topoperatorsearch() {
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
			
			ob_start();
			/*************************CONTENT STARTS HERE************************/

			//Get all the operators before we get all their bookings. 
			$option = explode(',', '1'.get_option( 'operator-excludelist' ));
			$args = array ('post_type'=>'operators', 'posts_per_page' => -1, 'post__not_in'=> $option);
			$getoperator = get_posts( $args ); ?>
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
			<?php foreach ( $getoperator as $operator ) : setup_postdata( $post ); ?>
				<tr class="sortrows">
					<td>
						<?php echo $operator->post_title; ?>
					</td>
					<td class='sortnr'>
					<?php
					//get all the bookings that match this operator			
						$operatorname = $operator->post_title;
						$args2 = array(
						'post_type' => 'bookings',					
						'posts_per_page' => -1,	
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
							),
						);

						//get the total cost field from each booking. 
						$getbookings = get_posts($args2);
						$sum = 0;
						foreach ( $getbookings as $booking ) : setup_postdata( $post );
							
							if (get_post_meta($booking->ID, 'ownerprice', true)) {
								$bookingspend = get_post_meta($booking->ID, 'ownerprice', true);
							} else {
								$bookingspend = get_post_meta($booking->ID, 'totalcost', true);
							}
							
							$sum+= $bookingspend;

						endforeach; 
						wp_reset_postdata();
						
						//echo the total from all those bookings. 						
						setlocale(LC_MONETARY,'en_UK');
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

add_action('wp_ajax_topoperator', 'implement_ajax_topoperatorsearch');
add_action('wp_ajax_nopriv_topoperator', 'implement_ajax_topoperatorsearch');