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
				$supplementscharge = ($_POST['supplementsprice']);
				if (($_POST['chargetype']) == 'true') {
					$supplementsprice = $supplementscharge * $numberofnights;
				} elseif (($_POST['chargetype']) == 'false') {
					$supplementsprice = $supplementscharge;
				}
				
				$supplimentsvatrate = '20';
				$supplementsvatfigure = ($supplementsprice  / 100) * $supplimentsvatrate;

				//add all the vat together to a single amount
				$vatfigure = ($rentalvatfigure + $supplementsvatfigure);



			//now make a quick calc for the deposit amount			
			$balance = $rentalprice * $numberofnights + $supplementsprice - $discount;

			

			
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


?>