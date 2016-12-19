<?php
/**
**********************************
Leader Board Tab - Top locations
**********************************
**/
function implement_ajax_toplocationssearch() {

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

			$args = array ('post_type'=>'locations', 'posts_per_page' => -1);
			$locationsquery = new WP_Query( $args );

			//get the locationss
			if ( $locationsquery->have_posts() ) { ?>
				<table>
					<thead>
						<th>
							<strong><p><i class="fa fa-user"></i>Locations Name</p></strong>
						</th>
						<th>
							<strong><p><i class="fa fa-gbp"></i>Locations Spend</p></strong>
						</th>	
					</thead>						
				<tbody>
				<?php while ( $locationsquery->have_posts() ) { $locationsquery->the_post();

						$locationsname = get_the_title($ID);

						//row for each clent starts here
						echo '<tr class="sortrows">';

							//locations Name
							echo '<td>';							
							the_title('<p>','</p>');
							echo '</td>';

							//start a new query in this cell for the locations spend
							echo '<td class="sortnr">';
								if ( ( $clientname == 'ANY' ) && ( $operatorname == 'ANY') ) {
									$args2 = array (
										'post_type'=>'bookings',
										'meta_query' => array(									
											array(
												'key' => 'location',
												'value' => $locationsname,
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
								} elseif ( ( $clientname !== 'ANY' ) && ( $operatorname == 'ANY' ) ) {
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
										),										
										'date_query' => array(
										        array(
										            'after' => $startdate,
										            'before' => $enddate,
										        ),			
										),
									);
								} elseif ( ( $clientname == 'ANY' ) && ( $operatorname !== 'ANY' ) ) {
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
										),										
										'date_query' => array(
										        array(
										            'after' => $startdate,
										            'before' => $enddate,
										        ),			
										),
									);
								} elseif ( ( $clientname !== 'ANY' ) && ( $operatorname !== 'ANY' ) ) {
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

add_action('wp_ajax_toplocations', 'implement_ajax_toplocationssearch');
add_action('wp_ajax_nopriv_toplocations', 'implement_ajax_toplocationssearch');