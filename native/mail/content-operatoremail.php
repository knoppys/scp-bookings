<?php 
function operatoremail($bookingID){

$booking = get_post_meta($bookingID); 

$apartmenttitle = ($booking['apartmentname'][0]);
$page = get_page_by_title( $apartmenttitle, OBJECT, 'apartments');
$permalink = $page->guid;

//get the apartment address details
$apartmentaddress   = get_post_meta($page->ID,'address', true );            
$aprtmentlocation   = get_post_meta($page->ID,'apptlocation1', true);
$aprtmentlocation2  = get_post_meta($page->ID,'apptlocation2', true);
$apartmentpostcode  = get_post_meta($page->ID,'postcode', true );
$apartmentstate     = get_post_meta($page->ID,'state', true );
$apartmentcountry   = get_post_meta($page->ID,'country', true ); 

//get the number of nights
$datetime1 = new DateTime(($_POST['arrivaldate']));
$datetime2 = new DateTime(($_POST['leavingdate']));
$interval = $datetime1->diff($datetime2);
$numberofnights = $interval->format('%a nights');      

//Get the correct apartmentname
if ($booking['displayname'][0]) {
    $apartmentnametext = '                                  
                    <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">
                    <strong>Apartment Name</strong><br>
                    '.$booking['displayname'][0].'<br>
                    <a target="_blank" href="'.$page->guid.'">View apartment information</a><br>
                    <a href="https://www.google.co.uk/maps/place/'.$apartmentpostcode.'">Get directions</a> 
                    </p>                                
                    ';
} else {
    $apartmentnametext = '
                    <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">
                    <strong>'.$booking['apartmentname'][0].'</strong> <br>
                    <a target="_blank" href="'.$page->guid.'">View apartment information</a><br>
                    <a href="https://www.google.co.uk/maps/place/'.$apartmentpostcode.'">Get directions</a>
                    </p>
                    ';
} 

//Get the correct address format. 
if ($aprtmentlocation == $aprtmentlocation2) {
   $apartmentlocationtext = '
                            <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">
                            <strong>Apartment Address</strong><br>
                            '.$apartmentaddress.'<br>
                            '.$aprtmentlocation.'<br>
                            '.$apartmentpostcode.'
                            </p>
                            ';
} else {
   $apartmentlocationtext = '
                            <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">
                            <strong>Apartment Address</strong><br>
                            '.$apartmentaddress.'<br>
                            '.$aprtmentlocation.'<br>
                            '.$apptlocation2.'<br>
                            '.$apartmentpostcode.'
                            </p>
                            ';
}

//Get the checkin details
$checkintext =  '
    <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">
    <strong>Check-in</strong><br>
    '.$booking['arrivaldate'][0].' ('.$booking['checkintime'][0].')
    </p>
    ';

//Get the checkout details
$checkouttext =  '
    <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">
    <strong>Check-out</strong><br>
    '.$booking['leavingdate'][0].' ('.$booking['checkouttime'][0].')
    </p>
    ';

//Length of stay
$lengthofstaytext = '
    <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">
    <strong>Length of stay</strong><br>
    '.$numberofnights.'
    </p>
    ';

//Length of stay
$gueststext =   '
    <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">
    <strong>Guests / Apartments</strong><br>
    '.$booking['numberofguests'][0].'&nbsp; / &nbsp;'.$booking['numberofapts'][0].'
    </p>
    ';

//Breakdown
if (strlen ( $booking['apptbreakdown'][0] ) >= 1 )  {
$breakdowntext = '
    <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">
    <strong>Apartment Breakdown</strong><br>
    '.$booking['apptbreakdown'][0].'
    </p>
    ';
} else {}

//Additional Notes                
if (strlen ( $booking['additionalnotes'][0] ) >= 1 )  {
    $additionalnotestext = '
    <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">
    <strong>Additional Notes</strong><br>
    '.$booking['additionalnotes'][0].'
    </p>
    ';
} else {}


//Arrival Process
if (strlen ( $booking['arrivalprocess'][0] ) >= 1 )  {
    $arrivalprocesstext = '
    <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">                           
    '.$booking['arrivalprocess'][0].'
    </p>
    ';
} else {}


//Guest Contact
$guestnametext = '
    <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">
    <strong>Guest Contact</strong><br>
    '.$booking['guestname'][0].'
    </p>
    ';

//Client Contact
$clientnametext = '
    <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">
    <strong>Client Contact</strong><br>
    '.$booking['clientname'][0].'
    </p>
    ';


//get the location name
$locationPage = get_page_by_title( $aprtmentlocation, OBJECT, 'locations' );

//get the location meta
$areainformation = get_post_meta( $locationPage->ID, 'areainformation', true );
if ($areainformation) {
    $areainformationtext = '<tr>
                                <td valign="top" colspan="2">
                                    <strong><p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">Area Information</p></strong>                                                     
                                   <p style="margin:3px;font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">Contact Name: '.$areainformation.'</p>                                          
                                </td>
                            </tr>';
} else {
    $areainformationtext = '';
}

//Get the right total cost text
if ($booking['incvat'][0]!=='true') {
    $nightlyratetext = $booking['rentalprice'][0].' &#43;VAT';
    $totalcosttext = $booking['totalcost'][0].' &#43;VAT';
} else {
    $nightlyratetext = $booking['rentalprice'][0];
    $totalcosttext = $booking['totalcost'][0];
}

//Get the nightly rate label
if ($booking['bookingtype'][0] == 'Corporate') {
    $ratelabel = '<p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;"><strong>Price Per Night</strong></p>';
} else {
    $ratelabel = '<p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;"><strong>Price per person, per night</strong></p>';
}

//Get the currency symbol
if ( ($aprtmentlocation == 'Dublin') || $aprtmentlocation2 == 'Dublin' ) {
    $currency = '€';
} else {
    $currency = '£';
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
                                                                    <h2 style="font-family: 'Helvetica', 'Arial', sans-serif;color:#fff;">Booking Confirmation</h2>
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
                                                                   <?php echo $apartmentnametext; ?>
                                                                </td>
                                                                <td width="300" valign="top" style="background:#efefef;padding:20px 10px">
                                                                   <?php echo $apartmentlocationtext; ?>
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
                                                                   <?php echo $checkintext; ?>
                                                                </td>
                                                                <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                                   <?php echo $checkouttext; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>    
                                                                <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                                   <?php echo $lengthofstaytext; ?>
                                                                </td>
                                                                 <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                                   <?php echo $gueststext; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>    
                                                                <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                                   <?php echo $breakdowntext; ?>
                                                                <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                                   <?php echo $additionalnotestext; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>    
                                                                <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                                   <?php echo $guestnametext; ?>
                                                                </td>
                                                                <td width="300" valign="top" style="background:#efefef;padding:10px">
                                                                   <?php echo $operatornametext; ?>
                                                                </td>
                                                            </tr>
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
                                                                    <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;"><strong>Total Cost</strong></p>
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
                                                                <td>
                                                                   <?php echo $booking['terms'][0]; ?>
                                                                </td>
                                                            </tr>                                                                                              
                                                        </tbody>
                                                    </table>                                        

                                                 
                                                    <table cellspacing="0" cellpadding="0" class="" width="500" style="width:500px;background: #003; margin:0 auto;" border-collapse="collapse">
                                                        <tbody>                                                
                                                            <tr>    
                                                                 <td valign="top" style=";padding:20px 10px">
                                                                    <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#fff;">
                                                                    Thank you for choosing Serviced City Pads as your accomodation provider. We hope you have an enjoyable stay.
                                                                    </p>
                                                                    <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#fff;">
                                                                    Visit <a href="http://www.servicedcitypads.com"><span style="color:#fff;">www.servicedcitypads.com</span></a> to view our portfolio of serviced apartements acrross the UK and Ireland
                                                                    </p>
                                                                    <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#fff;">
                                                                    If you would like to share your feedback with us, please get in touch by emailing <a href="mailto:reservations@servicedcitypads.com"><span style="color:#fff;">reservations@servicedcitypads.com</span></a>
                                                                    </p>
                                                                    <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#fff;">
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
                                                                   <p style="font-family: 'Helvetica', 'Arial', sans-serif;font-size:15px;font-weight:bold;">Contact Info</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" valign="top" style="background:#efefef;padding-top:20px;text-align:center;">
                                                                    <p style="font-family:Helvetica,Helvetica&quot;, Helvetica, Arial, sans-serif;color:#003;">
                                                                    Phone : 0844 335 8866<br>
                                                                    Email : <span style="color:#003;"><a href="">Reservations and Bookings</a></span><br>
                                                                    Web : <span style="color:#003;"><a href="www.servicedcitypads.com">servicedcitypads.com</a></span>
                                                                    </p>
                                                                </td>
                                                            </tr>   
                                                            <tr>
                                                                <td valign="top" style="background:#efefef;text-align:right;">
                                                                    <a href="https://www.facebook.com/ServicedCityPadsApartments/"><img src="http://www.servicedcitypads.com/scpemail/facebook.png"></a>
                                                                </td>
                                                                <td valign="top" style="background:#efefef;">
                                                                    <a href="https://twitter.com/citypadteam"><img src="http://www.servicedcitypads.com/scpemail/twitter.png"></a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="500" colspan="2" valign="top" style="background:#efefef;padding-top:10px;">
                                                                   <a href="http://www.servicedcitypads.com"><img width="500" style="width:500px;height:auto;" src="http://www.servicedcitypads.com/wp-content/themes/servicedcitypads/images/image001.gif"></a>
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
