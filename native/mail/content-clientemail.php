<?php
function clientemail($ID){
$booking = get_post_meta($ID);
$apartmenttitle = ($booking['apartmentname'][0]);
$page = get_page_by_title( $apartmenttitle, OBJECT, 'apartments');
$permalink = $page->guid;

    //Get the apartment details
    $apartmenttitle = $booking['apartmentname'][0];
    $page = get_page_by_title( $apartmenttitle, OBJECT, 'apartments');
    
        //get the link
        $permalink = $page->guid;

        //get the apartment postcode
        $apartmentpostcode  = get_post_meta($page->ID,'postcode', true );

        //get the post code into the correct format
        $mappostcode = preg_replace('/\s+/', '+', $apartmentpostcode);
        

        //check for a building name
        if (get_post_meta($page->ID,'buildingname', true )) {
            $buildingname = get_post_meta($page->ID,'buildingname', true ).', ';
        } else {
            $buildingname = '';
        }

        //check for a building name
        if (get_post_meta($page->ID,'address', true )) {
            $address = get_post_meta($page->ID,'address', true ).'<br> ';
        } else {
            $address = '';
        }

        //check for a building name
        if (get_post_meta($page->ID,'town', true )) {
            $town = get_post_meta($page->ID,'town', true ).'<br> ';
        } else {
            $town = '';
        }

        //check for a building name
        if (get_post_meta($page->ID,'state', true )) {
            $state = get_post_meta($page->ID,'state', true ).'<br> ';
        } else {
            $state = '';
        }

        //check for a building name
        if (get_post_meta($page->ID,'postcode', true )) {
            $postcode = get_post_meta($page->ID,'postcode', true ).'<br> ';
        } else {
            $postcode = '';
        }

        //check for a building name
        if (get_post_meta($page->ID,'country', true )) {
            $country = get_post_meta($page->ID,'country', true ).'<br> ';
        } else {
            $country = '';
        }
        
        $fulladdress = $buildingname.$address.$town.$state.$postcode.$country;

        $apartmentlocationtext = '
        <p style="font-family: Helvetica, Arial, sans-serif;color:#333;">
        <strong>Apartment Address</strong><br>
        '.$fulladdress.'
        </p>
        ';

//Get the currency symbol
if ( ($town == 'Dublin') || ( get_post_meta($page->ID,'apptlocation1', true ) == 'Dublin' ) || ( get_post_meta($page->ID,'apptlocation2', true ) == 'Dublin' ) ) {
    $currency = '€';
} else {
    $currency = '£';
} 

//get the number of nights
if ($booking['numberofnights'][0]) {
    $numberofnights = $booking['numberofnights'][0];
} else {
    $datetime1 = new DateTime($booking['arrivaldate'][0]);
    $datetime2 = new DateTime($booking['leavingdate'][0]);
    $interval = $datetime1->diff($datetime2);
    $numberofnights = $interval->format('%a nights');
} 
    

//Get the correct apartmentname
if ($booking['displayname'][0]) {
    $apartmentnametext = '                                  
                    <p style="font-family: Helvetica, Arial, sans-serif;color:#333;">
                    <strong>Apartment Name</strong><br>
                    '.$booking['displayname'][0].'<br>
                    <a target="_blank" href="'.$page->guid.'">View apartment information</a><br>
                    <a href="https://www.google.co.uk/maps/place/'.$apartmentpostcode.'">Get directions</a> 
                    </p>                                
                    ';
} else {
    $apartmentnametext = '
                    <p style="font-family: Helvetica, Arial, sans-serif;color:#333;">
                    <strong>'.$booking['apartmentname'][0].'</strong> <br>
                    <a target="_blank" href="'.$page->guid.'">View apartment information</a><br>
                    <a href="https://www.google.co.uk/maps/place/'.$apartmentpostcode.'">Get directions</a>
                    </p>
                    ';
} 

//Get the checkin details
$checkintext =  '
    <p style="font-family: Helvetica, Arial, sans-serif;color:#333;">
    <strong>Check-in</strong><br>
    '.$booking['arrivaldate'][0].' ('.$booking['checkintime'][0].')
    </p>
    ';

//Get the checkout details
$checkouttext =  '
    <p style="font-family: Helvetica, Arial, sans-serif;color:#333;">
    <strong>Check-out</strong><br>
    '.$booking['leavingdate'][0].' ('.$booking['checkouttime'][0].')
    </p>
    ';

//Length of stay
$lengthofstaytext = '
    <p style="font-family: Helvetica, Arial, sans-serif;color:#333;">
    <strong>Length of stay</strong><br>
    '.$numberofnights.'
    </p>
    ';

//Length of stay
$gueststext =   '
    <p style="font-family: Helvetica, Arial, sans-serif;color:#333;">
    <strong>Guests / Apartments</strong><br>
    '.$booking['numberofguests'][0].'&nbsp; / &nbsp;'.$booking['numberofapts'][0].'
    </p>
    ';

//Breakdown
if (strlen ( $booking['apptbreakdown'][0] ) >= 1 )  {
$breakdowntext = '
    <p style="font-family: Helvetica, Arial, sans-serif;color:#333;">
    <strong>Apartment Breakdown</strong><br>
    '.$booking['apptbreakdown'][0].'
    </p>
    ';
} else {}

//Additional Notes                
if (strlen ( $booking['additionalnotes'][0] ) >= 1 )  {
    $additionalnotestext = '
    <p style="font-family: Helvetica, Arial, sans-serif;color:#333;">
    <strong>Additional Notes</strong><br>
    '.$booking['additionalnotes'][0].'
    </p>
    ';
} else {}

//Arrival Process
if (strlen ( $booking['arrivalprocess'][0] ) >= 1 )  {
    $arrivalprocesstext = '
    <p style="font-family: Helvetica, Arial, sans-serif;color:#333;">                           
    '.$booking['arrivalprocess'][0].'
    </p>
    ';
} else {}

//Subject Header
if  ($booking['clientAmendment'][0] == 'on' )  {
    $subjecttext = 'Booking Amendment';
} else {
    $subjecttext = 'Booking Confirmation';
}



//Guest Contact
$guestnametext = '
    <p style="font-family: Helvetica, Arial, sans-serif;color:#333;">
    <strong>Guest Contact</strong><br>
    '.$booking['guestname'][0].'
    </p>
    ';

//Client Contact
$clientnametext = '
    <p style="font-family: Helvetica, Arial, sans-serif;color:#333;">
    <strong>Client Contact</strong><br>
    '.$booking['clientname'][0].'
    </p>
    ';

//Cost Code
$costcodetext = '
    <p style="font-family: Helvetica, Arial, sans-serif;color:#333;">
    <strong>Cost Code</strong><br>
    '.$booking['costcode'][0].'
    </p>
    ';


//get the location name
$locationPage = get_page_by_title( $aprtmentlocation, OBJECT, 'locations' );

//get the location meta
$areainformation = get_post_meta( $locationPage->ID, 'areainformation', true );
if ($areainformation) {
    $areainformationtext = '<tr>
                                <td valign="top" colspan="2">
                                    <strong><p style="font-family: Helvetica, Arial, sans-serif;color:#333;">Area Information</p></strong>                                                     
                                   <p style="margin:3px;font-family: Helvetica, Arial, sans-serif;color:#333;">Contact Name: '.$areainformation.'</p>                                          
                                </td>
                            </tr>';
} else {
    $areainformationtext = '';
}

//Get the right vat total
if ( $booking['bookingtype'][0] == 'Groups' && $booking['incvat'][0] == '1' ) {

    $nightlyratetext = $booking['rentalprice'][0];
    $totalcosttext = $booking['totalcost'][0];

} elseif ( $booking['bookingtype'][0] == 'Groups' && $booking['incvat'][0] !== '1' ) {
    
    $nightlyratetext = $booking['rentalprice'][0].' &#43;VAT';
    $totalcosttext = $booking['totalcost'][0].' &#43;VAT';

} elseif ( ($booking['bookingtype'][0] == 'Corporate' || $booking['bookingtype'][0] == 'Leisure' ) && $booking['incvat'][0] !== '1' ) {
    
    $nightlyratetext = $booking['rentalprice'][0].' &#43;VAT';
    $totalcosttext = $booking['totalcost'][0].' &#43;VAT';

} elseif ( ($booking['bookingtype'][0] == 'Corporate' || $booking['bookingtype'][0] == 'Leisure' ) && $booking['incvat'][0] == '1' ) {
    
    $nightlyratetext = $booking['rentalprice'][0];
    $totalcosttext = $booking['totalcost'][0];

} 

//Get the nightly rate label
if ($booking['bookingtype'][0] == 'Corporate') {
    $ratelabel = '<p style="font-family: Helvetica, Arial, sans-serif;color:#333;"><strong>Price Per Night</strong></p>';
} else {
    $ratelabel = '<p style="font-family: Helvetica, Arial, sans-serif;color:#333;"><strong>Price per person, per night</strong></p>';
}


//Get the discount value
if ($booking['discount'][0]) {
    $discounttext =  '
    <tr>    
        <td width="300" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;padding:4px 0px;">
          Discount
        </td>
        <td width="300" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;padding:4px 0px;">
          '.$booking['discount'][0].'
        </td>
    </tr>
    ';
} else {}

ob_start(); ?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<table cellspacing="0" cellpadding="0" class="" width="100%" style="width:100%;background: #fff;" border-collapse="collapse">
    <tbody>
        <tr>    
            <td>
                
            
                <center style="">
                      <table cellspacing="0" cellpadding="0" class="" width="500" style="width:500px;background: #003;border:3px solid #003" border-collapse="collapse">
                          <tbody>
                              <tr>    
                                  <td>
                                        
                                        <table cellspacing="0" cellpadding="0" class="" width="500" style="width:500px;background: #003; margin:0 auto;padding:10px;" border-collapse="collapse">
                                            <tbody>
                                                <tr>    
                                                    <td>
                                                        <img src="http://www.servicedcitypads.com/wp-content/themes/servicedcitypads/images/logo-email.PNG" style="margin: 0;padding: 0;max-width: 300px;width:200px;">
                                                    </td>
                                                    <td valign="middle" style="text-align:center;">
                                                        <h2 style="font-family: 'Helvetica', 'Arial', sans-serif;color:#fff;"><?php echo $subjecttext; ?></h2>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                   

                                    
                                        <table cellspacing="0" cellpadding="0" class="" width="500" style="width:500px;background: #fff; margin:0 auto;" border-collapse="collapse">
                                            <tbody>
                                                <tr>    
                                                    <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;padding:10px;">
                                                       <p style="font-size:15px;font-weight:bold;">Apartment Details</p>
                                                    </td>
                                                </tr>
                                                <tr>    
                                                    <td width="300" valign="top" style="background:#efefef;padding:20px 10px">
                                                       <?php echo $apartmentnametext ;?>
                                                    </td>
                                                    <td width="300" valign="top" style="background:#efefef;padding:20px 10px">
                                                       <?php echo $apartmentlocationtext ;?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                   

                                    
                                        <table cellspacing="0" cellpadding="0" class="" width="500" style="width:500px;background: #fff; margin:0 auto;" border-collapse="collapse">
                                            <tbody>
                                                <tr>    
                                                    <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;padding:10px;">
                                                       <p style="font-size:15px;font-weight:bold;">Check-in Details</p>
                                                    </td>
                                                </tr>
                                                <tr>    
                                                    <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                       <?php echo $checkintext ;?>
                                                    </td>
                                                    <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                       <?php echo $checkouttext ;?>
                                                    </td>
                                                </tr>
                                                <tr>    
                                                    <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                       <?php echo $lengthofstaytext ;?>
                                                    </td>
                                                     <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                       <?php echo $gueststext ;?>
                                                    </td>
                                                </tr>
                                                <tr>    
                                                    <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                       <?php echo $breakdowntext ;?>
                                                    </td>
                                                    <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                       <?php echo $additionalnotestext ;?>
                                                    </td>
                                                </tr>
                                                <tr>    
                                                    <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                       <?php echo $guestnametext ;?>
                                                    </td>
                                                    <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                       <?php echo $clientnametext ;?>
                                                    </td>
                                                </tr>
                                                <?php if ($booking['costcode'][0]){ ?>
                                                    <tr>    
                                                        <td colspan="2" valign="top" style="background:#efefef;padding:10px">
                                                           <?php echo $costcodetext ;?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table> 
                                   

                                    
                                        <table cellspacing="0" cellpadding="0" class="" width="500" style="width:500px;background: #fff; margin:0 auto;" border-collapse="collapse">
                                            <tbody>
                                                <tr>    
                                                    <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;padding:10px;">
                                                       <p style="font-size:15px;font-weight:bold;">Price</p>
                                                    </td>
                                                </tr>
                                                <tr>    
                                                    <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                        <?php echo $ratelabel; ?>
                                                    </td>
                                                    <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                        <?php echo $currency . $nightlyratetext; ?>
                                                    </td>
                                                </tr> 
                                                <?php echo $discounttext; ?>
                                                <tr>    
                                                    <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                        <p style="font-family: Helvetica, Arial, sans-serif;color:#333;"><strong>Total Cost</strong></p>
                                                    </td>
                                                    <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                      <?php echo $currency . $totalcosttext; ?>
                                                    </td>
                                                </tr>                                                
                                            </tbody>
                                        </table> 


                                    
                                        <table cellspacing="0" cellpadding="0" class="" width="500" style="width:500px;background: #fff; margin:0 auto;" border-collapse="collapse">
                                            <tbody>
                                                <tr>    
                                                    <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;padding:10px;">
                                                       <p style="font-size:15px;font-weight:bold;">Arrival Process</p>
                                                    </td>
                                                </tr>
                                                <tr>    
                                                    <td valign="top" style="background:#efefef;padding:20px 10px">
                                                       <?php echo $arrivalprocesstext; ?>
                                                    </td>
                                                </tr>                                                                                              
                                            </tbody>
                                        </table> 
                                   

                                    
                                        <table cellspacing="0" cellpadding="0" class="" width="500" style="width:500px;background: #fff; margin:0 auto;" border-collapse="collapse">
                                            <tbody>
                                                <tr>    
                                                    <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;padding:10px;">
                                                       <p style="font-size:15px;font-weight:bold;">Terms and Conditions</p>
                                                    </td>
                                                </tr> 
                                                <tr>    
                                                    <td valign="top" style="background:#efefef;padding:20px 10px">
                                                       <?php echo $booking['terms'][0]; ?>
                                                    </td>
                                                </tr>                                                                                              
                                            </tbody>
                                        </table> 
                                   

                                     
                                        <table cellspacing="0" cellpadding="0" class="" width="500" style="width:500px;background: #003; margin:0 auto;" border-collapse="collapse">
                                            <tbody>                                                
                                                <tr>    
                                                     <td valign="top" style=";padding:20px 10px">
                                                        <p style="font-family: Helvetica, Arial, sans-serif;color:#fff;">
                                                        Thank you for choosing Serviced City Pads as your accomodation provider. We hope you have an enjoyable stay.
                                                        </p>
                                                        <p style="font-family: Helvetica, Arial, sans-serif;color:#fff;">
                                                        Visit <a href="http://www.servicedcitypads.com"><span style="color:#fff;">www.servicedcitypads.com</span></a> to view our portfolio of serviced apartments.
                                                        </p>
                                                        <p style="font-family: Helvetica, Arial, sans-serif;color:#fff;">
                                                        If you would like to share your feedback with us, please get in touch by emailing <a href="mailto:reservations@servicedcitypads.com"><span style="color:#fff;">reservations@servicedcitypads.com</span></a>
                                                        </p>
                                                        <p style="font-family: Helvetica, Arial, sans-serif;color:#fff;">
                                                        Kind Regards, <br>Serviced City Pads Team
                                                        </p>
                                                    </td>
                                                </tr>                                                                                              
                                            </tbody>
                                        </table> 
                                   

                                    
                                        <table cellspacing="0" cellpadding="0" class="" width="500" style="width:500px;background: #003; margin:0 auto;" border-collapse="collapse">
                                            <tbody>
                                                <tr>    
                                                    <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;padding:10px;">
                                                       <p style="font-size:15px;font-weight:bold;">Contact Info</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" valign="top" style="background:#efefef;padding-top:20px;text-align:center;">
                                                        <p style="font-family: 'Helvetica', 'Arial', sans-serif;color:#003;">
                                                        Phone: 0844 335 8866<br>
                                                        Email: <span style="color:#003;"><a href="">Reservations and Bookings</a></span><br>
                                                        Web: <span style="color:#003;"><a href="www.servicedcitypads.com">servicedcitypads.com</a></span>
                                                        </p>
                                                    </td>
                                                </tr>   
                                                <tr>
                                                    <td valign="top" style="background:#efefef;padding-bottom:20px;text-align:right;">
                                                        <a href="https://www.facebook.com/ServicedCityPadsApartments/"><img src="http://www.servicedcitypads.com/scpemail/facebook.png"></a>
                                                    </td>
                                                    <td valign="top" style="background:#efefef;padding-bottom:20px;">
                                                        <a href="https://twitter.com/citypadteam"><img src="http://www.servicedcitypads.com/scpemail/twitter.png"></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" valign="top" style="background:#efefef;padding-top:10px;">
                                                       <a href="http://www.servicedcitypads.com"><img style="width:100%;height:auto;" src="http://www.servicedcitypads.com/wp-content/themes/servicedcitypads/images/image001.gif"></a>
                                                    </td>
                                                </tr> 
                                            </tbody>
                                        </table> 


                                  </td>
                              </tr>
                          </tbody>
                      </table> 
                  </center>                          



            </td>
        </tr>
    </tbody>
</table>
</body>
</html>

<?php $content = ob_get_clean();
return $content;

};