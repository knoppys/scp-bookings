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



/**
**********************************
Leader Board Tab - Top apartment
**********************************
**/
function implement_ajax_topapartmentsearchwidget() {

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

			$args = array ('post_type'=>'apartments', 'posts_per_page' => 500);
			$apartmentquery = new WP_Query( $args );

			//get the apartments
			if ( $apartmentquery->have_posts() ) { ?>
				
					<thead>
						<tr>
							<th>
							<strong><p><i class="fa fa-user"></i>apartment Name</p></strong>
							</th>
							<th>
								<strong><p><i class="fa fa-gbp"></i>apartment Spend</p></strong>
							</th>
						</tr>						
					</thead>						
					<tbody>
				<?php while ( $apartmentquery->have_posts() ) { $apartmentquery->the_post();

						$apartmentname = get_the_title($ID);

						//row for each apartment starts here
						echo '<tr>';

							//apartment Name
							echo '<td>';							
							echo $apartmentname;
							echo '</td>';

							//start a new query in this cell for the apartment spend
							echo '<td>';
								$args2 = array (
									'post_type'=>'bookings',
									'meta_query' => array(
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
								$bookingsquery = new WP_Query( $args2 );
								$sum = 0;
								if ( $bookingsquery->have_posts() ) {								
									while ( $bookingsquery->have_posts() ) {
										$bookingsquery->the_post();
										
										//get the apartment as a variable									
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

add_action('wp_ajax_topapartmentswidget', 'implement_ajax_topapartmentsearchwidget');
add_action('wp_ajax_nopriv_topapartsmentwidget', 'implement_ajax_topapartmentsearchwidget');
?>