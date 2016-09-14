<?php
/**
**********************************
Bookings section - VAT Calculator
**********************************
**/
function implement_ajax_vat() {
	if(isset($_POST['rentalprice']))
		{
    
		    //get the start and end dates
		    $startdate = ($_POST['arrivaldate']);
		    $enddate = ($_POST['leavingdate']);	 

		    //get the vat applicable field
		    $vatselect = ($_POST['vatselect']);

		    //get remaining vriables   		    
			$discount = ($_POST['discount']);
			$priceperperson = ($_POST['priceperperson']);
			$baserentalprice = ($_POST['rentalprice']);
			$numberofguests = ($_POST['numberofguests']);
			$bookingtype = ($_POST['bookingtype']);

		    $datetime1 = new DateTime($startdate);
		    $datetime2 = new DateTime($enddate);
		    $interval = $datetime1->diff($datetime2);
		    $numberofnights = $interval->format('%a nights');

		    //get the custom vat value if there is one
		    $customvatvalue = ($_POST['customvatvalue']);	 


			
			//calculatge the VAT amount				

				//set rental price variable as Price per Person or Fixed Apartment Price
				if (isset($priceperperson) && $priceperperson != '') { 
					$rentalprice = ($priceperperson * $numberofguests); 
				} else { 
					$rentalprice = $baserentalprice; 
				}		

				
				//over ride the vat amount if there is a value in the vat field.

				if (($_POST['vatselect'])) {
					if($customvatvalue > 0 ) {
						$vatrate = $customvatvalue;
					} else {

						if($numberofnights >= 29){
			    			$vatrate = '4';
				    	} elseif ($numberofnights <= 28) {
				    		$vatrate = '20';
				    	} 

					}
				} elseif (!($_POST['vatselect'])) {
					$vatrate == 0;
				}
				

						    	
				
				//get the booking type and check if its a variable rate	
				//then calculate the vat figure based on the  rental price
				if(($bookingtype == 'Corporate') || ($bookingtype == 'Groups')){                                                       
				    $vatamount = (($rentalprice * $numberofnights) / 100) * $vatrate;
				} elseif ($bookingtype == 'Leisure') {				                       
				    $vatamount = (($rentalprice * $numberofnights) / 100) * 20;
				}
				$rentalvatfigure = round($vatamount, 2);

				//calculatge the vat for the suppliments and add ons
				$supplements = ($_POST['supplements']);
				$supplementsprice = ($_POST['supplementsprice']);
				$supplementscharge = ($_POST['chargetype']);

				$supplementsfig1 = $supplements * $supplementsprice;
				
				if ($supplementscharge == 'true') {
					$supplementsvalue = $supplementsfig1 * $numberofnights;
				} elseif ($supplementscharge == 'false') {
					$supplementsvalue = $supplementsfig1;
				}
						
				$supplementsvatfigure = ($supplementsvalue  / 100) * $vatamount;

				//add all the vat together to a single amount
				$vatfigure = ($rentalvatfigure + $supplementsvatfigure);



			//now make a quick calc for the deposit amount			
			$balance = $rentalprice * $numberofnights + $supplementsvalue - $discount;

			

			
			if ( ($bookingtype == 'Corporate') ){
				$balancedue = $balance - $vatfigure;
			} else {
				$balancedue = $balance;
			}

			$totalcost = round($balancedue, 2);

			//bundle it all into an array
		    $data = json_encode(array(
		    	'vatfigure' => $vatfigure, 
		    	'balancedue' 	=> $totalcost,
		    	'bookingtype'		=> $bookingtype, 
		    	'nights'				=>$numberofnights
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