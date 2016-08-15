<?php

/**
**********************************
Add some custom meta columns to the bookings list view
**********************************
**/
add_theme_support( 'post-thumbnails' ); 


/**
**********************************
Add some custom meta columns to the bookings list view
**********************************
**/
//Add custom column

	function my_columns_head($defaults) {
		$defaults['guestname'] = 'Guest Name';
		$defaults['apartmentname'] = 'Apartment';
		$defaults['bookingtype'] = 'Booking Type';
		$defaults['numberofguests'] = 'Number of guests';
		$defaults['clientname'] = 'Client Name';
		$defaults['operatorname'] = 'Operator';
		$defaults['checkindate'] = 'Check In';
		$defaults['checkoutdate'] = 'Check Out';


	return $defaults;
	}
	add_filter('manage_edit-bookings_columns', 'my_columns_head');

//Add rows data

	function my_custom_column($column, $post_id ){
		switch ( $column ) {
		case 'guestname':
		echo get_post_meta( $post_id , 'guestname' , true );
		break;
		case 'apartmentname':
		echo get_post_meta( $post_id , 'apartmentname' , true );
		break;
		case 'bookingtype':
		echo get_post_meta( $post_id , 'bookingtype' , true );
		break;
		case 'numberofguests';
		echo get_post_meta($post_id, 'numberofguests', true);
		break;
		case 'clientname':
		echo get_post_meta( $post_id , 'clientname' , true );
		break;
		case 'operatorname':
		$operatorname = get_post_meta( $post_id , 'operatorname' , true );
		echo $operatorname; //The operators name
		$operatorget = get_page_by_title( $operatorname, OBJECT, 'operators' );
		$operatorphone = get_post_meta($operatorget->ID, 'operatortelephone', true);
		echo '<br/>Tel:&nbsp;' . $operatorphone;

		break;
		case 'checkindate':
		if (get_post_meta( $post_id , 'actualcheckindate' , true )) {
			$indate = get_post_meta( $post_id , 'actualcheckindate' , true );
		} else {
			$indate = get_post_meta( $post_id , 'arrivaldate' , true );
		}		
		echo $indate;
		break;
		case 'checkoutdate':
		if (get_post_meta( $post_id , 'actualcheckoutdate' , true )) {
			$outdate = get_post_meta( $post_id , 'actualcheckoutdate' , true );
		} else {
			$outdate = get_post_meta( $post_id , 'leavingdate' , true );
		}		
		echo $outdate;
		break;

		}
	}
	add_action( 'manage_bookings_posts_custom_column' , 'my_custom_column', 10, 2 );

// Make these columns sortable
	function sortable_columns() {
		return array(
			'guestname' => 'guestname',
			'apartmentname' => 'apartmentname',
			'bookingtype' => 'bookingtype',
			'numberofguests' => 'numberofguests',
			'clientname' => 'clientname',
			'operatorname' => 'operatorname',
			'checkindate' => 'checkindate',
			'checkoutdate' => 'checkoutdate'
		);
	}
	add_filter( "manage_edit-bookings_sortable_columns", "sortable_columns" );


	add_action( 'pre_get_posts', 'manage_wp_posts_be_qe_pre_get_posts', 1 );
	function manage_wp_posts_be_qe_pre_get_posts( $query ) {

	   /**
	    * We only want our code to run in the main WP query
	    * AND if an orderby query variable is designated.
	    */
	   if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) {

	      switch( $orderby ) {

	        
	         case 'guestname':
	         $query->set( 'meta_key', 'guestname' );
	         $query->set( 'orderby', 'meta_value' );
	         break;

	         case 'apartmentname':
	         $query->set( 'meta_key', 'apartmentname' );
	         $query->set( 'orderby', 'meta_value' );
	         break;

	         case 'bookingtype':
	         $query->set( 'meta_key', 'bookingtype' );
	         $query->set( 'orderby', 'meta_value' );
	         break;
	         

	        case 'clientname':	        
	        $query->set( 'meta_key', 'clientname' );
	        $query->set( 'orderby', 'meta_value' );
	        break;         

	        case 'operatorname':
	        $query->set( 'meta_key', 'operatorname' );
	        $query->set( 'orderby', 'meta_value' );
	        break;

	        case 'checkindate':
	        $query->set( 'meta_key', 'leavingdate' );
	        $query->set( 'orderby', 'meta_value' );
	        break;

	        case 'checkoutdate':
	        $query->set( 'meta_key', 'arrivaldate' );
	        $query->set( 'orderby', 'meta_value' );
	        break;


	        var_dump($query);
	      }

	   }

	}

	add_filter( 'posts_clauses', 'manage_wp_posts_be_qe_posts_clauses', 1, 2 );
	function manage_wp_posts_be_qe_posts_clauses( $pieces, $query ) {
	   global $wpdb;

	   /**
	    * We only want our code to run in the main WP query
	    * AND if an orderby query variable is designated.
	    */
	   if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) {

	      // Get the order query variable - ASC or DESC
	      $order = strtoupper( $query->get( 'order' ) );

	      // Make sure the order setting qualifies. If not, set default as ASC
	      if ( ! in_array( $order, array( 'ASC', 'DESC' ) ) )
	         $order = 'ASC';

	      switch( $orderby ) {
		
	         // If we're ordering by release_date
	         case 'checkindate':
				
	            /**
	             * We have to join the postmeta table to
	             * include our release date in the query.
	             */
	            $pieces[ 'join' ] .= " LEFT JOIN $wpdb->postmeta wp_rd ON wp_rd.post_id = {$wpdb->posts}.ID AND wp_rd.meta_key = 'checkindate'";
					
	            // Then tell the query to order by our custom field.
	            // The STR_TO_DATE function converts the custom field
	            // to a DATE type from a string type for
	            // comparison purposes. '%m/%d/%Y' tells the query
	            // the string is in a month/day/year format.
	            $pieces[ 'orderby' ] = "STR_TO_DATE( wp_rd.meta_value,'%m/%d/%Y' ) $order, " . $pieces[ 'orderby' ];
					
	         break;

			case 'checkoutdate':
				
	            /**
	             * We have to join the postmeta table to
	             * include our release date in the query.
	             */
	            $pieces[ 'join' ] .= " LEFT JOIN $wpdb->postmeta wp_rd ON wp_rd.post_id = {$wpdb->posts}.ID AND wp_rd.meta_key = 'checkoutdate'";
					
	            // Then tell the query to order by our custom field.
	            // The STR_TO_DATE function converts the custom field
	            // to a DATE type from a string type for
	            // comparison purposes. '%m/%d/%Y' tells the query
	            // the string is in a month/day/year format.
	            $pieces[ 'orderby' ] = "STR_TO_DATE( wp_rd.meta_value,'%m/%d/%Y' ) $order, " . $pieces[ 'orderby' ];
					
	         break;
	      }
		
	   }

	   return $pieces;


	}


/**
**********************************
Populate the hidden locations field in the booking view. 
**********************************
**/

function implement_ajax_getlocation() {
	if(isset($_POST['apartmentname']))
		{
		    
		    //get the correct page ID
		    $title = ($_POST['apartmentname']);
		    $page = get_page_by_title( $title, OBJECT, 'apartments');	  
		    
		    //get the remaining custom meta
		    //$data	= get_post_meta($page->ID,'apartmentlocation', true ); 
		    $data = get_post_meta($page->ID, 'apartmentlocation', true);

			echo $data;

			die();
		} 
	}
add_action('wp_ajax_getlocation', 'implement_ajax_getlocation');
add_action('wp_ajax_nopriv_getlocation', 'implement_ajax_getlocation');


/**
**********************************
Bookings Section - Autopopulate fields according to appartment selection
**********************************
**/

function implement_ajax() {
	if(isset($_POST['apartmentname']))
		{
		    
		    //get the correct page ID
		    $title = ($_POST['apartmentname']);
		    $page = get_page_by_title( $title, OBJECT, 'apartments');

		    //Get the booking type meta value and terms because there are 3 different values
		    $bookingtype = ($_POST['bookingtype']);
		    if(empty(get_post_meta($page->ID, $bookingtype, true ))){
		    	$terms = 'No terms have been set';
		    }else{
		    	$terms = get_post_meta($page->ID, $bookingtype, true );
		    };

		    //get the remaining custom meta
		    if(empty(get_post_meta($page->ID, 'apptchekintime', true ))){
		    	$checkintime = 'No Data Available';
		    }else{
		    	$checkintime = get_post_meta($page->ID, 'apptchekintime', true );
		    };

		    if(empty(get_post_meta($page->ID, 'apptcheckouttime', true ))){
		    	$checkouttime = 'No Data Available';
		    }else{
		    	$checkouttime = get_post_meta($page->ID, 'apptchekouttime', true );
		    };

		    if(empty(get_post_meta($page->ID, 'ownerprice', true ))){
		    	$ownerprice = 'No Data Available';
		    }else{
		    	$ownerprice = get_post_meta($page->ID, 'ownerprice', true );
		    };

		    if(empty(get_post_meta($page->ID, 'arrivalprocess', true ))){
		    	$arrivalprocess = 'No Data Available';
		    }else{
		    	$arrivalprocess = get_post_meta($page->ID, 'arrivalprocess', true );
		    };

		    if(empty(get_post_meta($page->ID, 'emergencycontact', true ))){
		    	$emergencycontact = 'No Data Available';
		    }else{
		    	$emergencycontact = get_post_meta($page->ID, 'emergencycontact', true );
		    };	    


		    // Get the right price for the aparmtent

		    	//Get the number of nights
				    
				    //get the start and end dates
				    $startdate = ($_POST['startdate']);
				    $enddate = ($_POST['enddate']);	

				    //get the number of nights
				    $datetime1 = new DateTime($startdate);
				    $datetime2 = new DateTime($enddate);
				    $interval = $datetime1->diff($datetime2);
				    $numberofnights = $interval->format('%a');

			    //Check the booking type and get the correct base rental price

				if ( $bookingtype == 'Corporate' ) {
					$prefix = 'cp';
				} elseif ( ($bookingtype == 'Groups') || ($bookingtype == 'Leisure') ) {
					$prefix = 'gr';
				}
		  

			
				if ( $numberofnights <= '7' ) {

					$baserentalprice = get_post_meta($page->ID, $prefix . '37', true);

				} elseif ( $numberofnights > '7' && $numberofnights <= '28' ) {

					$baserentalprice = get_post_meta($page->ID, $prefix . '728', true);

				} elseif ( $numberofnights > '28' && $numberofnights <= '90' ) {

					$baserentalprice = get_post_meta($page->ID, $prefix . '2990', true);

				} elseif ( $numberofnights > '90' ) {

					$baserentalprice = get_post_meta($page->ID, $prefix . '90', true);

				} else {

					$baserentalprice = "incorect date";

				}
	





		    //bundle it all into an array
		    $data = json_encode(array(
		    	'terms' 			=> $terms, 
		    	'checkintime' 		=> $checkintime,
		    	'checkouttime' 		=> $checkouttime,
		    	'ownerprice'		=> $ownerprice,
		    	'arrivalprocess' 	=> $arrivalprocess,
		    	'emergencycontact' 	=> $emergencycontact,	
		    	'rentalprice' 		=> $baserentalprice,
		    	'bookingtype'		=> $bookingtype,
		    	'nights'			=> $numberofnights
		   
		    	)
		    );

		    //send the aray back 
		    echo $data;

			die();
		} 
	}
add_action('wp_ajax_my_special_action', 'implement_ajax');
add_action('wp_ajax_nopriv_my_special_action', 'implement_ajax');




/**
**********************************
Bookings section - Deposit Paid Check
**********************************
**/
function implement_ajax_depositpaid() {
	if(isset($_POST['depositpaid']))
		{

			//get the variables
			$depositpaid = ($_POST['depositpaid']);
			$deposit = ($_POST['deposit']);
			$balancedue = ($_POST['balancedue']);
			$apartmentpaid = ($_POST['apartmentpaud']);
			$balancepaid = ($_POST['balancepaid']);

		//if just the deposit is paid
			if ( ($depositpaid == "Yes") and (($balancepaid == "No") || ($balancepaid == "")) ) {
			  	$newbalance = $balancedue - $deposit;

		//if deposit and balance are paid
			  } elseif ( ($depositpaid == "Yes") && ($balancepaid == "Yes") ){
			  	$newbalance = $balancedue - $balancedue;
			  
		//if the whole balance is paid without a deposit
			  } elseif ( ( ($depositpaid == "") || ($depositpaid == "No") ) && ($balancepaid == "Yes") ) {
			  	$newbalance = $balancedue - $balancedue;
			  
		//if neither balance or deposit have been paid
			  } elseif ( ($depositpaid == "No") && ( ($balancepaid == "No") || ($balancepaid == "") ) ) {
			  	$newbalance = $balancedue;
			  }
			    
		echo $newbalance;
		die();
	} 
}

add_action('wp_ajax_depositpaid', 'implement_ajax_depositpaid');
add_action('wp_ajax_nopriv_depositpaid', 'implement_ajax_depositpaid');

/**
Get the operator details and populate the operator fields in the booking form
**/

function implement_ajax_operatordetails() {
	if(isset($_POST['operatorname']))
		{
			//get the correct page ID
		    $title = ($_POST['operatorname']);
		    $page = get_page_by_title( $title, OBJECT, 'Operators');

		    //get the meta for the operator
		    $operatorphone	=	get_post_meta($page->ID, 'operatortelephone', true);
		    $operatoremail	=	get_post_meta($page->ID, 'operatoremail', true);
			$operatoremailArray=explode(",",$operatoremail);
		    ob_start(); ?>

		    	
		    	
		    		<h4>Operator Phone Number</h4>
		    		<input type="text" class="widefat" name="operatorphone" id="operatorphone" value="<?php echo $operatorphone; ?>"/>
		    	
		    		<h4>Select The Contact</h4>
		    		<select class="widefat" id="operatoremailselect">
		    			<option>Please select a contact email</option>
		    			<?php
                    	foreach($operatoremailArray as $email) { ?>
                    	<?php $emailaddress = str_replace(' ', '', $email);?>
                    		<option value="<?php echo $emailaddress; ?>"><?php echo $emailaddress; ?></option>
                    	<?php } ?>
		    		</select>
		    		<?php echo '<input type="hidden" class="widefat" name="operatoremail" id="operatoremail" value=""/>'; ?>
		    		<script>
		    			jQuery('#operatoremailselect').change(function(){
		    				var operatoremail = jQuery(this).val();
		    				jQuery('#operatoremail').val(operatoremail);
		    			});
		    		</script>
		    	
		    

		    <?php
		    $content = ob_get_clean();

		    //send the array back
		    echo $content;

		    die();
		}
	}
add_action('wp_ajax_operatordetails', 'implement_ajax_operatordetails');
add_action('wp_ajax_nopriv_operatordetails', 'implement_ajax_operatordetails');

/**
Get the client details and populate the client fields in the booking form
**/

function implement_ajax_clientdetails() {
	if(isset($_POST['clientname']))
		{
			//get the correct page ID
		    $title = ($_POST['clientname']);
		    $page = get_page_by_title( $title, OBJECT, 'clients');

		    //get the meta for the client
		    $clientphone	=	get_post_meta($page->ID, 'clientphone', true);
		    $clientemail	=	get_post_meta($page->ID, 'clientemail', true);
			$clientemailArray=explode(",",$clientemail);
		    ob_start(); ?>

		    	
		    	
		    		<h4>Client Phone Number</h4>
		    		<input type="text" class="widefat" name="clientphone" id="clientphone" value="<?php echo $clientphone; ?>"/>
		    
		    	
		    		<h4>Select The Contact</h4>
		    		<select class="widefat" id="clientemailselect">
		    			<option>Please select a contact email</option>
		    			<?php
                    	foreach($clientemailArray as $email) { ?>
                    	<?php $emailaddress = str_replace(' ', '', $email);?>
                    		<option value="<?php echo $emailaddress; ?>"><?php echo $emailaddress; ?></option>
                    	<?php } ?>
		    		</select>		    		
		    		<?php echo '<input type="hidden" class="widefat" name="clientemail" id="clientemail" value=""/>'; ?>
		    		<script>
		    			jQuery('#clientemailselect').change(function(){
		    				var clientemail = jQuery(this).val();
		    				jQuery('#clientemail').val(clientemail);
		    			});
		    		</script>
		    
		    

		    <?php
		    $content = ob_get_clean();

		    //send the array back
		    echo $content;

		    die();
		}
	}
add_action('wp_ajax_clientdetails', 'implement_ajax_clientdetails');
add_action('wp_ajax_nopriv_clientdetails', 'implement_ajax_clientdetails');


/*
Update all bookings posts


function implement_ajax_update_bookings() { ?>


			<ul>
			<?php
			 ob_start();

				// WP_Query arguments
				$args = array (
					'post_type' => array( 'bookings' ),
					'posts_per_page' => -1,
				);

				// The Query
				$query = new WP_Query( $args );
			
				// The Loop
				if ( $query->have_posts() ) {
					
					while ( $query->have_posts() ) {
						$query->the_post();
						echo '<div>'; 
						echo the_title();

							//get the data
							$postid = get_the_id();
							$terms = get_post_meta($postid, 'terms', true);
							$arrival = get_post_meta($postid, 'arrival', true);

							echo '<p>' . $terms . '</p>';
							echo '<p>' . $arrival . '</p>';

							//sanitize the fields
							$myterms = sanitize_text_field( $terms );
							$myarrival = sanitize_text_field( $arrival );

							//update post meta
							//update_post_meta( $postid, 'terms', $myterms );
							//update_post_meta( $postid, 'arrival', $myarrival );

						echo '</div>';

					}
					
				} 
				else {
					// no posts found
				}

				// Restore original Post Data
				wp_reset_postdata();


				$content = ob_get_clean();

			echo $content;
		    die();
		}
	
add_action('wp_ajax_update_bookings', 'implement_ajax_update_bookings');
add_action('wp_ajax_nopriv_update_bookings', 'implement_ajax_update_bookings');
*/

 ?>