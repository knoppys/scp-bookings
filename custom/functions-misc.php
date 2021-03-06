<?php

/**
**********************************
Add some custom meta columns to the bookings list view
**********************************
**/
add_theme_support( 'post-thumbnails' ); 
function multiple_media_upload_css() {wp_enqueue_style('thickbox');}

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
			$apartmentpaid = ($_POST['apartmentpaid']);
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
		    $title = stripslashes(($_POST['operatorname']));
		    $page = get_page_by_title( $title, OBJECT, 'Operators');

		    //get the meta for the operator
		    $operatorphone	=	get_post_meta($page->ID, 'operatortelephone', true);
		    $operatoremail	=	get_post_meta($page->ID, 'operatoremail', true);
			$operatoremailArray=explode(",",$operatoremail);
		    ob_start(); ?>

		    	
		    	
		    		<table width="100%">
		    			<tr>
			    			<td>
			    				<label>Operator Phone Number</label>
			    				<input type="text" class="widefat" name="operatorphone" id="operatorphone" value="<?php echo $operatorphone; ?>"/>
			    			</td>
			    		</tr>
			    		<tr>
			    			<td>
			    				<label>Select The Contact</label>
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
			    			</td>
			    		</tr>
		    		</table>
		    	
		    

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
		    $title = stripslashes(($_POST['clientname']));
		    $page = get_page_by_title( $title, OBJECT, 'clients');

		    //get the meta for the client
		    $clientphone	=	get_post_meta($page->ID, 'clientphone', true);
		    $clientemail	=	get_post_meta($page->ID, 'clientemail', true);
			$clientemailArray=explode(",",$clientemail);
		    ob_start(); ?>

		    	
		    	
		    		<tr>
		    			<td>
		    				<label>Client Phone Number</label>
		    				<input type="text" class="widefat" name="clientphone" id="clientphone" value="<?php echo $clientphone; ?>"/>	
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>
		    				<label>Select The Contact</label>
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
		    			</td>
		    		</tr>
		    
		    	
		    		
		    
		    

		    <?php
		    $content = ob_get_clean();

		    //send the array back
		    echo $content;

		    die();
		}
	}
add_action('wp_ajax_clientdetails', 'implement_ajax_clientdetails');
add_action('wp_ajax_nopriv_clientdetails', 'implement_ajax_clientdetails');


//date conversions for the reports
function dateRange( $first, $last, $step = '+1 day', $format = 'd.m.Y' ) {

	$dates = array();
	$current = strtotime( $first );
	$last = strtotime( $last );

	while( $current <= $last ) {

		$dates[] = date( $format, $current );
		$current = strtotime( $step, $current );
	}

	return $dates;
}


function create_new_archive_post_status(){
	register_post_status( 'archive', array(
		'label'                     => _x( 'Archive', 'post' ),
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Archive <span class="count">(%s)</span>', 'Archive <span class="count">(%s)</span>' ),
	) );
}
add_action( 'init', 'create_new_archive_post_status' );

function add_to_post_status_dropdown()
{
    ?>
    <script>
    jQuery(document).ready(function($){
        $("select#post_status").append("<option value=\"archive\" <?php selected('archive', $post->post_status); ?>>Archive</option>");
    });
    </script>
    <?php
}

add_action( 'post_submitbox_misc_actions', 'add_to_post_status_dropdown');

//Add email marketing image size
add_image_size( 'iContact Special Offer', 190, 160, array( 'center', 'center' ) );
add_image_size( 'iContact Latest News', 166, 130, array( 'center', 'center' ) );


