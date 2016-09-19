<?php  
/**
Add sub menu page for reporting and search queries
**/
add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() {
	add_submenu_page( 'edit.php?post_type=bookings', 'Reports', 'Reports', 'publish_pages', 'upcomingbookings', 'upcomingbookings_callback' );
}

http://www.greenmonkeypublicrelations.com/citypads/wp-admin/admin.php?page=mt-top-level-handle
/**
**********************************
Upcoming Bookings Tab
**********************************
**/
function implement_ajax_search() {

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
		//set the operator name	


		$operatorname = ($_POST['operatorname']);
		//$apartmentname = ($_POST['apartmentname']);
		//$bookingtype = ($_POST['bookingtype']);
		//$clientname = ($_POST['clientname']);

	
 
		$args = array( 
			'post_type' => 'bookings',
			'posts_per_page' => '-1', 
			'order'		=> 'ASC',
			'meta_query' => array(
				//'relation'=>'AND',
				/*
				array(
					'key' => 'operatorname',
					'value' => $operatorname,
					'compare' => 'LIKE'
					),				
				array(
					'key' => 'apartmentname',
					'value' => $apartmentname,
					'compare' => 'LIKE'
					),
				array( 
					'key' => 'bookingtype',
					'value' => $bookingtype,
					'compare' => 'LIKE'
					),
				array( 
					'key' => 'clientname',
					'value' => $clientname,
					'compare' => 'LIKE'
					),
				*/
				
				),
				'date_query' => array(
			        array(
			            'after' => $startdate,
			            'before' => $enddate,
			        ),		
				),		
			);

		
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
							<p><strong>Arrival Date</strong></p>
						</th>
						<th>
							<p><strong>Booking Type</strong></p>
						</th>
						<th>
							<p><strong>Operator Name</strong></p>
						</th>
						<th>
							<p><strong>Cost Code</strong></p>
						</th>
						<th>
							<p><strong>Total Cost</strong></p>
						</th>
						<th>
							<p><strong>Deposit</strong></p>
						</th>
						<th>
							<p><strong>Balance Due</strong></p>
						</th>
						<th class="options">
							<p><strong>Options</strong></p>
						</th>
					</tr>
				</thead>
				<tbody>
				<?php while ( $query->have_posts() ) {

					$query->the_post(); 

					//get the id
					$ID = get_the_ID();
					//get the post meta
				    $startdate = get_post_meta( $ID, 'arrivaldate', true );
				    $enddate = get_post_meta( $ID, 'leavingdate', true );   
				    $bookingtype = get_post_meta( $ID, 'bookingtype', true); 
				    $operatorname = get_post_meta( $ID, 'operatorname', true);
				    $balancedue = get_post_meta($ID, 'balancedue', true);
				    $deposit = get_post_meta($ID, 'deposit', true);
				    $costcode = get_post_meta($ID, 'costcode', true);
				    $depositpaid = get_post_meta($ID, 'depositpaid', true);
				    $balancepaid = get_post_meta($ID, 'balancepaid', true);
				    $totalcost = $balancedue + $deposit;

				    //calculate number of nights stay
				    $datetime1 = new DateTime($startdate);
				    $datetime2 = new DateTime($enddate);
				    $interval = $datetime1->diff($datetime2);
				    $numberofnights = $interval->format('%a nights');
					?>
				
					
						<tr>
							<td>
								<p><?php the_title(); ?></p>
							</td>
							<td>
								<p><?php echo $startdate . '&nbsp(' . $numberofnights . ')'; ?></p>
							</td>
							<td>
								<p><?php echo $bookingtype; ?></p>
							</td>
							<td>
								<p><?php echo $operatorname; ?></p>
							</td>
							<td>
								<p><?php echo $costcode; ?></p>
							</td>
							<td style="text-align:right;">
								<p><strong>£ &nbsp;<?php echo $totalcost; ?></strong></p>
							</td>
							<td style="text-align:right;">
							<?php
							if ($depositpaid == "Yes") {
								echo '<p style="color:green;">';
								echo '£&nbsp' . $deposit;
								echo '</p>';
							} elseif ( ($depositpaid == "No") || ($depositpaid == "") ) {
								echo '<p style="color:red;">';
								echo '£&nbsp' . $deposit;
								echo '</p>';
							}							
							?>
							</td>
							<td style="text-align:right;">
							<?php
							if ($balancepaid == "Yes") {
								echo '<p style="color:green;">';
								echo '£&nbsp' . $balancedue;
								echo '</p>';
							} elseif ( ($balancepaid == "No") || ($balancepaid == "") ) {
								echo '<p style="color:red;">';
								echo '£&nbsp' . $balancedue;
								echo '</p>';
							}							
							?>
							</td>
							
							<td class="options">
								<a href="<?php echo get_site_url();?>/wp-admin/post.php?post=<?php echo $ID ;?>&action=edit"><i class="fa fa-file-text" style="padding-right:10px;"></i></a>
							</td>
						</tr>
						


				<?php }
			} else {
				echo 'no posts found';
			}
			echo '</tbody>';
			// Restore original Post Data
			wp_reset_postdata();

			$content = ob_get_clean();
	
			echo $content;

			die();
				
		}

add_action('wp_ajax_searchquery', 'implement_ajax_search');
add_action('wp_ajax_nopriv_searchquery', 'implement_ajax_search');



/**
**********************************
Upcoming Payments Tab
**********************************
**/
function implement_ajax_paymentssearch() {

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
		//set the operator name	


		//$operatorname = ($_POST['operatorname']);
		//$apartmentname = ($_POST['apartmentname']);
		//$bookingtype = ($_POST['bookingtype']);
		//$clientname = ($_POST['clientname']);

	
 
		$args = array( 
			'post_type' => 'bookings',
			'posts_per_page' => '-1', 
			'order'		=> 'ASC',
			'meta_query' => array(
				//'relation'=>'AND',
				/*
				array(
					'key' => 'operatorname',
					'value' => $operatorname,
					'compare' => 'LIKE'
					),				
				array(
					'key' => 'apartmentname',
					'value' => $apartmentname,
					'compare' => 'LIKE'
					),
				array( 
					'key' => 'bookingtype',
					'value' => $bookingtype,
					'compare' => 'LIKE'
					),
				array( 
					'key' => 'clientname',
					'value' => $clientname,
					'compare' => 'LIKE'
					),
				*/
				
				),
				'date_query' => array(
			        array(
			            'after' => $startdate,
			            'before' => $enddate,
			        ),		
				),		
			);

		
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
							<p><strong>Operator Name</strong></p>
						</th>
						<th>
							<p><strong>Client Name</strong></p>
						</th>						
						<th>
							<p><strong>Apartment Name</strong></p>
						</th>
						<th>
							<p><strong>Total Cost</strong></p>
						</th>
						<th>
							<p><strong>Deposit</strong></p>
						</th>
						<th>
							<p><strong>Deposit Due Date</strong></p>
						</th>
						<th>
							<p><strong>Current Balance Due</strong></p>
						</th>
						<th>
							<p><strong>Balance Due Date</strong></p>
						</th>
						<th>
							<p><strong>Apartment Due</strong></p>
						</th>
						<th>
							<p><strong>Apartment Due Date</strong></p>
						</th>
						<th class="options">
							<p><strong>Options</strong></p>
						</th>
					</tr>
				</thead>
				<tbody>
				<?php while ( $query->have_posts() ) {

					$query->the_post(); 

					//get the id
					$ID = get_the_ID();
					//get the post meta
				    $startdate = get_post_meta( $ID, 'arrivaldate', true );
				    $enddate = get_post_meta( $ID, 'leavingdate', true );   
				    $bookingtype = get_post_meta( $ID, 'bookingtype', true); 
				    $operatorname = get_post_meta( $ID, 'operatorname', true);
				    $balancedue = get_post_meta($ID, 'balancedue', true);
				    $apartmentname = get_post_meta($ID, 'apartmentname', true);
				    $deposit = get_post_meta($ID, 'deposit', true);
				    $costcode = get_post_meta($ID, 'costcode', true);
				    $depositpaid = get_post_meta($ID, 'depositpaid', true);
				    $balancepaid = get_post_meta($ID, 'balancepaid', true);
				    $clientname = get_post_meta($ID, 'clientname', true);
				    $depositdate = get_post_meta($ID ,'depositdate', true);
				    $apartmentduedate = get_post_meta($ID, 'apartmentduedate');
				    $balanceduedate = get_post_meta($ID, 'balanceduedate', true); 
				    $totalcost = $balancedue + $deposit;

				    //calculate number of nights stay
				    $startdate = get_post_meta( $ID, 'arrivaldate', true );
				    $enddate = get_post_meta( $ID, 'leavingdate', true ); 
				    $datetime1 = new DateTime($startdate);
				    $datetime2 = new DateTime($enddate);
				    $interval = $datetime1->diff($datetime2);
				    $numberofnights = $interval->format('%a nights');
					?>
				
					
						<tr>
							<td>
								<p><?php the_title(); ?></p>
							</td>
							<td>
								<p><?php echo $operatorname; ?></p>
							</td>
							<td>
								<p><?php echo $clientname; ?></p>
							</td>
							<td>
								<p><?php echo $apartmentname; ?></p>
							</td>
							<td style="text-align:right;">
								<p><strong>£ &nbsp;<?php echo $totalcost; ?></strong></p>
							</td>
							<td style="text-align:right;">
							<?php
							if ($depositpaid == "Yes") {
								echo '<p style="color:green;">';
								echo '£&nbsp' . $deposit;
								echo '</p>';
							} elseif ( ($depositpaid == "No") || ($depositpaid == "") ) {
								echo '<p style="color:red;">';
								echo '£&nbsp' . $deposit;
								echo '</p>';
							}							
							?>
							</td>
							<td>
								<p><?php echo $depositdate; ?></p>
							</td>
							<td style="text-align:right;">
							<?php
							if ($balancepaid == "Yes") {
								echo '<p style="color:green;">';
								echo '£&nbsp' . $balancedue;
								echo '</p>';
							} elseif ( ($balancepaid == "No") || ($balancepaid == "") ) {
								echo '<p style="color:red;">';
								echo '£&nbsp' . $balancedue;
								echo '</p>';
							}							
							?>
							</td>
							<td>
								<p><?php echo $balanceduedate; ?></p>
							</td>
							<td style="text-align:right;">
							<?php
							if ($apartmentpaid == "Yes") {
								echo '<p style="color:green;">';
								echo '£&nbsp' . $apartmentpaid;
								echo '</p>';
							} elseif ( ($apartmentpaid == "No") || ($apartmentpaid == "") ) {
								echo '<p style="color:red;">';
								echo '£&nbsp' . $balancedue;
								echo '</p>';
							}							
							?>
							</td>
							<td>
								<p><?php echo $balanceduedate; ?></p>
							</td>

							
							<td class="options">
								<a href="<?php echo get_site_url();?>/wp-admin/post.php?post=<?php echo $ID ;?>&action=edit"><i class="fa fa-file-text" style="padding-right:10px;"></i></a>
							</td>
						</tr>
						


				<?php }
			} else {
				echo 'no posts found';
			}
			echo '</tbody>'; 
			// Restore original Post Data
			wp_reset_postdata();

			$content = ob_get_clean();
	
			echo $content;

			die();
				
		}

add_action('wp_ajax_paymentsquery', 'implement_ajax_paymentssearch');
add_action('wp_ajax_nopriv_paymentsquery', 'implement_ajax_paymentssearch');

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

		$clientname = ($_POST['clientname']);
		$apartmentname = ($_POST['apartmentname']);
		$location = ($_POST['location']);		

		//Query all the clients bookings
		if( isset($clientname) && ( !isset($apartmentname) || ($apartmentname == 'ANY') ) &&  ( !isset($location) || ($location == 'ANY') ) ) {
			$args = array( 
				'post_type' => 'bookings', 	
				'posts_per_page' => '-1', 
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

		}//Query all the clients bookings in a particular apartment
		elseif( isset($clientname) && ( isset($apartmentname) || ($apartmentname !== 'ANY') ) &&  ( !isset($location) || ($location == 'ANY') ) ) {
		   $args = array( 
				'post_type' => 'bookings', 	
				'posts_per_page' => '-1', 
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
				'date_query' => array(
				        array(
				            'after' => $startdate,
				            'before' => $enddate,
				        ),			
				),
			);
		}//Query all the clients bookings in a particular location
		elseif( isset($clientname) && ( !isset($apartmentname) || ($apartmentname == 'ANY') ) &&  ( isset($location) || ($location !== 'ANY') ) ) {
			$args = array( 
				'post_type' => 'bookings', 	
				'posts_per_page' => '-1', 
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
				'date_query' => array(
				        array(
				            'after' => $startdate,
				            'before' => $enddate,
				        ),			
				),
			);
		}//Query all bookings by a client in a particular apartment in a particular location
		elseif( isset($clientname) && ( isset($apartmentname) || ($apartmentname !== 'ANY') ) &&  ( isset($location) || ($location !== 'ANY') ) ) {
			$args = array( 
				'post_type' => 'bookings', 	
				'posts_per_page' => '-1', 
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
				'date_query' => array(
				        array(
				            'after' => $startdate,
				            'before' => $enddate,
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
				<script>
					
					//Total Spend Calculation
					jQuery(function() {
					    jQuery("#calculate_total").click(function() {
					        var add = 0;
					       	jQuery(".total-cost").each(function() {
					            add += Number(jQuery(this).text());
					        });
					        jQuery("#total_spend").text('£' + add);
					    });
					});

					//Average Spend Calculation
					jQuery(function(){
						jQuery('#calculate_average').click(function(){
							var add = 0;
							jQuery('.total-cost').each(function(){							
								add += Number(jQuery(this).text());
								numberofcells = jQuery('.total-cost').length;
								num = (add / numberofcells);
							});
							jQuery("#average_spend").text('£' + (Math.round(num*100)/100).toFixed(2) );		
						});
					});

					//The total number of bokings
					jQuery(function(){
						jQuery('#calculate_total_bookings').click(function(){
							var numberofcells = jQuery('.booking').length;
							jQuery('#total_bookings').text(numberofcells + ' bookings');
						});
					});
					//Average Number of nights
					jQuery(function(){
						jQuery('#calculate_average_duration').click(function(){
							var add = 0;
							jQuery('.numberofnights').each(function(){							
								add += Number(jQuery(this).text());
								numberofcells = jQuery('.numberofnights').length;
								num = (add / numberofcells);
							});
							jQuery("#average_duration").text((Math.round(num*100)/100).toFixed(0) + ' nights');					
						});
					});
					//Average price per night 
					jQuery(function(){
						jQuery('#calculate_average_nightly').click(function(){
							var add = 0;
							jQuery('.nightlyrate').each(function(){							
								add += Number(jQuery(this).text());
								numberofcells = jQuery('.numberofnights').length;
								num = (add / numberofcells);
							});						
							jQuery("#average_nightly").text('£' + (Math.round(num*100)/100).toFixed(2) );
						
						});
					});
				</script>
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



/**
**********************************
Operator Report Tab
**********************************
**/
function implement_ajax_operatorsearch() {

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
			$operatorname = ($_POST['operatorname']);
			$apartmentname = ($_POST['apartmentname']);
			$location = ($_POST['location']);		

			//Query all the clients bookings
			if( isset($operatorname) && ( !isset($apartmentname) || ($apartmentname == 'ANY') ) &&  ( !isset($location) || ($location == 'ANY') ) ) {
				$args = array( 
					'post_type' => 'bookings', 	
								'posts_per_page' => '-1', 
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

			}//Query all the clients bookings in a particular apartment
			elseif( isset($operatorname) && ( isset($apartmentname) || ($apartmentname !== 'ANY') ) &&  ( !isset($location) || ($location == 'ANY') ) ) {
			   $args = array( 
					'post_type' => 'bookings', 	
								'posts_per_page' => '-1', 
					'meta_query' => array(
						'relation' => 'AND',
							array(
								'key' => 'operatorname',
								'value' => $operatorname,
								'compare' => '=',
							),
							array(
								'key' => 'apartmentname',
								'value' => $apartmentname,
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
			}//Query all the clients bookings in a particular location
			elseif( isset($operatorname) && ( !isset($apartmentname) || ($apartmentname == 'ANY') ) &&  ( isset($location) || ($location !== 'ANY') ) ) {
				$args = array( 
					'post_type' => 'bookings', 	
								'posts_per_page' => '-1', 
					'meta_query' => array(
						'relation' => 'AND',
							array(
								'key' => 'operatorname',
								'value' => $operatorname,
								'compare' => '=',
							),
							array(
								'key' => 'location',
								'value' => $location,
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
			}//Query all bookings by a client in a particular apartment in a particular location
			elseif( isset( $operatorname ) && ( isset( $apartmentname ) || ( $apartmentname !== 'ANY' ) ) &&  ( isset( $location ) || ( $location !== 'ANY' ) ) ) {
				$args = array( 
					'post_type' => 'bookings', 	
								'posts_per_page' => '-1', 
					'meta_query' => array(
						'relation' => 'AND',
							array(
								'key' => 'operatorname',
								'value' => $operatorname,
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
					'date_query' => array(
					        array(
					            'after' => $startdate,
					            'before' => $enddate,
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
							<p><strong>Operator Name</strong></p>
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
							<button class="wp-core-ui button-primary" id="calculate_average_nightly">Average Nightly Rate</button>
						</td>
						<td class="report-footer">
							<strong><p style="text-align:right;"id="average_nightly"></p></strong>									
						</td>						
						<td class="report-footer options">							
						</td>
					</tr>
				</tfoot>
				<script>
					
					//Total Spend Calculation
					jQuery(function() {
					    jQuery("#calculate_total").click(function() {
					        var add = 0;
					       	jQuery(".total-cost").each(function() {
					            add += Number(jQuery(this).text());
					        });
					        jQuery("#total_spend").text('£' + add);
					    });
					});

					//Average Spend Calculation
					jQuery(function(){
						jQuery('#calculate_average').click(function(){
							var add = 0;
							jQuery('.total-cost').each(function(){							
								add += Number(jQuery(this).text());
								numberofcells = jQuery('.total-cost').length;
								num = (add / numberofcells);
							});
							jQuery("#average_spend").text('£' + (Math.round(num*100)/100).toFixed(2) );		
						});
					});

					//The total number of bokings
					jQuery(function(){
						jQuery('#calculate_total_bookings').click(function(){
							var numberofcells = jQuery('.booking').length;
							jQuery('#total_bookings').text(numberofcells + ' bookings');
						});
					});
					//Average Number of nights
					jQuery(function(){
						jQuery('#calculate_average_duration').click(function(){
							var add = 0;
							jQuery('.numberofnights').each(function(){							
								add += Number(jQuery(this).text());
								numberofcells = jQuery('.numberofnights').length;
								num = (add / numberofcells);
							});
							jQuery("#average_duration").text((Math.round(num*100)/100).toFixed(0) + ' nights');					
						});
					});
					//Average price per night 
					jQuery(function(){
						jQuery('#calculate_average_nightly').click(function(){
							var add = 0;
							jQuery('.nightlyrate').each(function(){							
								add += Number(jQuery(this).text());
								numberofcells = jQuery('.numberofnights').length;
								num = (add / numberofcells);
							});						
							jQuery("#average_nightly").text('£' + (Math.round(num*100)/100).toFixed(2) );
						
						});
					});
				</script>

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
								<p><?php echo $operatorname; ?></p>
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
							<td style="text-align:right;" class="total-cost">
								<p><strong><?php echo $totalcost; ?></strong></p>
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

add_action('wp_ajax_operatorreport', 'implement_ajax_operatorsearch');
add_action('wp_ajax_nopriv_operatorreport', 'implement_ajax_operatorsearch');


?>