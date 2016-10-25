<?php
/**
**********************************
Bookings section - VAT Calculator
**********************************
**/
function implement_ajax_vat() {
	if(isset($_POST['rentalprice']))
		{
    
			//***********************
			//Get the posted variables
			//***********************	

				//1. Get some posted values and assign them variables for easy syntax
				$discount = ($_POST['discount']);				
				$baserentalprice = ($_POST['rentalprice']);
				$numberofguests = ($_POST['numberofguests']);
				$bookingtype = ($_POST['bookingtype']);
				$customvatvalue = ($_POST['customvatvalue']);
				$supplements = ($_POST['supplements']);
				$supplementsprice = ($_POST['supplementsprice']);
				$supplementscharge = ($_POST['chargetype']);
				$incvat = ($_POST['incvat']);



		    //***********************
			//calculatge the length of stay
			//***********************	

				//1. Get the dates and get the diff between them
				$datetime1 = new DateTime(($_POST['arrivaldate']));
			    $datetime2 = new DateTime(($_POST['leavingdate']));
			    $interval = $datetime1->diff($datetime2);
			    $numberofnights = $interval->format('%a nights');


			//***********************
			//calculatge the rental VAT amount
			//***********************				

				//1. Set rental price variable as Price per Person or Fixed Apartment Price
				if ( ($bookingtype !== 'Corporate') ) {
					$rentalprice = ($baserentalprice * $numberofguests);
				} else {
					$rentalprice = $baserentalprice; 
				}
								
				
				//2. Over ride the vat amount if there is a value in the vat field.	
				if($customvatvalue) {
					$vatrate = $customvatvalue;
				} else {
					if($numberofnights >= 29){
		    			$vatrate = '4';
			    	} elseif ($numberofnights <= 28) {
			    		$vatrate = '20';
			    	} 
				}	    	
				
				//3. Give the rental VAT figure			
				$rentalvatfigure = round( (($rentalprice * $numberofnights) / 100) * $vatrate, 2);




			//***********************
			//calculatge the supplements VAT amount
			//***********************				

				//1. = number of supps X supps price
				$supplementsfig1 = $supplements * $supplementsprice;
				
				//2. If the supps are charged nightly then no. of supps X no. of nights
				if ($supplementscharge == 'true') {
					$supplementsvalue = $supplementsfig1 * $numberofnights;
				} elseif ($supplementscharge == 'false') {
					$supplementsvalue = $supplementsfig1;
				}
				
				//3. Get the supplements VAT figure. If the booking is a groups or leisure booking then normal 20% VAT applies
				if ($bookingtype == 'Corporate' || 'Groups') {
					$supplementsvatfigure = round( ($supplementsvalue  / 100) * 20, 2);
				} else {
					$supplementsvatfigure = '';
				}
				
				


			//***********************
			//calculatge the total VAT for the booking
			//***********************	

				//1. Add both the $rentalvatfigure and $supplementsvatfigure
				$vatfigure = ($rentalvatfigure + $supplementsvatfigure);



			//***********************
			//Get the balance of the booking in total INC VAT
			////// This can also be used for the totalcost figure if the booking reuqires INC VAT
			//***********************

				//1. Balance = the rental price X the number of nights + supps. If there is a discount, take it off
				$balance = $rentalprice * $numberofnights + $supplementsvalue - $discount;



			//***********************
			//Get the net price
			//***********************
			
				//1. This is the balance less the vat figure
				$netprice = $balance - $vatfigure;
			
			

			//***********************
			//Get the totalcost for this booking
			//***********************

				//1. If the booking is INC VAT then $totalcost will be the $balance figure, else its the $netprice
				if ($incvat == 'true') {
					$totalcost = round($balance, 2);
				} else {
					$totalcost = round($netprice, 2);
				}
			


			//***********************
			//Bundle this into an array and send it all back
			//***********************
			    $data = json_encode(array(
			    	'vatfigure' => 	$vatfigure, 
			    	'totalcost'	=> 	$balance,
			    	'nights'	=> 	$numberofnights
			    	)
			    );
			    
			    //send the aray back
			    echo $data;    

		die();
	} 
}


add_action('wp_ajax_my_special_vataction', 'implement_ajax_vat');
add_action('wp_ajax_nopriv_my_special_vataction', 'implement_ajax_vat');


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
		    	$terms = get_post_meta($page->ID, 'Corporate', true );
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
?>