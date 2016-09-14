<?php

/*****************************************************************************
*This fine contains the mail functionality for booking confirmation emails. 
******************************************************************************/

function implement_ajax_email_operator(){
    if(isset($_POST['title']))
        { 
            $testvar = 'ajax comms up';
            /**
            Email content vairables
            */

            //WP Mail Variables
            
            $to = ($_POST['operatoremail']);
          

            //Check to see if there is a display name overide. 
            if (($_POST['displayname'])) {
                $titletext = ($_POST['displayname']);
            } else {
                $titletext = ($_POST['title']);
            }

            

            //Check to see if there is a cost code
            if (($_POST['costcode'])) {
                $costcodetext = '<tr>
                                    <td style="width:250px;"valign="middle">
                                        <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Cost code</p></strong> 
                                    </td>
                                    <td style="width:250px;"valign="middle">  
                                        <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.($_POST['costcode']).'</p>                                          
                                    </td>
                                </tr>';
            } else {
                $costcodetext = '';
            }

            //Check to see if there are Supplements
            if (($_POST['supplementsprice'])) {
                $suplementtext   = '<tr>
                                        <td style="width:250px;"valign="middle">
                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Supplements</p></strong> 
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.($_POST['supplementstext']).'</p>
                                        </td>
                                        <td style="width:250px;"valign="middle">  
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">&pound;'.($_POST['supplementsprice']).'</p>                                          
                                        </td>
                                    </tr>';
            } else {
                $suplementtext   = '';
            }

            //Check to see if there is a discount
            if (($_POST['discount'])) {
                $discounttext   = '<tr>
                                        <td style="width:250px;"valign="middle">
                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Discount</p></strong> 
                                        </td>
                                        <td style="width:250px;"valign="middle">  
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">&pound;'.($_POST['discount']).'</p>                                          
                                        </td>
                                    </tr>';
            } else {
                $discounttext   = '';
            }


            /**
            HTML Email Elements
            */


            //Get the apartment details
                $apartmenttitle = ($_POST['apartmentname']);
                $page = get_page_by_title( $apartmenttitle, OBJECT, 'apartments');
                $permalink = $page->guid;

                //get the apartment address details
                $apartmentaddress   = get_post_meta($page->ID,'address', true );            
                $aprtmentlocation   = get_post_meta($page->ID,'apptlocation1', true);
                $aprtmentlocation2  = get_post_meta($page->ID,'apptlocation2', true);
                $apartmentpostcode  = get_post_meta($page->ID,'postcode', true );
                $apartmentstate     = get_post_meta($page->ID,'state', true );
                $apartmentcountry   = get_post_meta($page->ID,'country', true ); 
                //get the location name
                $locationPage = get_page_by_title( $aprtmentlocation, OBJECT, 'locations' );
                    //get the location meta
                    $areainformation = get_post_meta( $locationPage->ID, 'areainformation', true );
                    if ($areainformation) {
                        $areainformationtext = '<tr>
                                                    <td valign="top" colspan="2">
                                                        <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Area Information</p></strong>                                                     
                                                        <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Contact Name: '.$areainformation.'</p>                                          
                                                    </td>
                                                </tr>';
                    } else {
                        $areainformationtext = '';
                    }

                //get the number of nights
                $datetime1 = new DateTime(($_POST['arrivaldate']));
                $datetime2 = new DateTime(($_POST['leavingdate']));
                $interval = $datetime1->diff($datetime2);
                $numberofnights = $interval->format('%a nights');

                //Get the right nightly rate field
                if (($_POST['bookingtype'])==('Corporate')) {
                    $nightlyratetext = (($_POST['rentalprice']));
                } else {
                    $nightlyratetext = (($_POST['priceperperson']));
                }

                //Get the right total cost field
                if (($_POST['bookingtype'])==('Corporate')) {
                    $totalcosttext = ($_POST['totalcost']).' &#43;VAT';
                } else {
                    $totalcosttext = ($_POST['totalcost']);
                }

                //the chekin time
                if (($_POST['actualcheckintime'])) {
                    $theintime = ($_POST['actualcheckintime']);
                } else {
                    $theintime = ($_POST['checkintime']);
                }

                //the chekin time
                if (($_POST['actualcheckouttime'])) {
                    $theouttime = ($_POST['actualcheckouttime']);
                } else {
                    $theouttime = ($_POST['checkouttime']);
                }

                if (($_POST['vatselect']) == true) {
                    $vatselecttext = ' &#43;VAT';
                }

                //Get the nightly rate label
                if ($bookingtype == ('Corporate')) {
                    $ratelabel = ''.$ratelabel.'';
                } else {
                    $ratelabel = 'Price per person, per night';
                }

        /**
            Build the email
        **/ 
        $message = ' 


            <table width="500px" align="center" style="border:1px solid #555; background:#003;margin: 0 auto;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">

                <tbody>

                    <tr>

                        <td valign="top">

                            <!-- the company logo -->
                             <table align="center" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                <tbody>
                                    <tr>
                                        <td valign="top">
                                            <img src="http://www.servicedcitypads.com/wp-content/themes/servicedcitypads/images/logo-email.PNG" style="margin: 0;padding: 0;max-width: 300px;width:300px;">
                                        </td>
                                        <td valign="middle" style="text-align:center;">
                                            <h2 style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Booking Confirmation</h2>
                                        </td>
                                    </tr>
                                    <!-- Welcome text -->                                    
                                    <tr>
                                        <td valign="top" colspan="2">
                                        <p style="margin:3px;border-bottom:1px solid #fff;"></p>
                                        <p></p>
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Thank you for booking with Serviced City Pads. Please find below your booking confirmation.</p>

                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Please see below for Terms and Conditions and details regarding payment of the remaining balance.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p></p>                            
                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                <tbody>                                   

                                    <!-- Apartment details -->
                                    <tr>
                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                            <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Apartment Details</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:250px;"valign="top">                                            
                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Apartment Name</p></strong>
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">' . $titletext . '<br>
                                            <a href="'.$permalink.'">View apartment information</a><br>
                                            <a href="https://www.google.co.uk/maps/place/'.$apartmentpostcode.'">Get directions</a>
                                            </p>


                                        </td>
                                        <td style="width:250px;"valign="top">
                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Apartment Address</p></strong>
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">' . $apartmentaddress . '<br>' . $aprtmentlocation . '<br>' . $aprtmentlocation2 . '<br>' . $apartmentstate . '<br/>' . $apartmentpostcode . '&nbsp;' . $country . '</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p></p>

                            <!-- Booking details -->   
                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                <tbody>  
                                     <!-- Apartment details -->
                                    <tr>
                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                            <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Check-in Details</p>
                                        </td>
                                    </tr>                  
                                    <tr>
                                        <td style="width:250px;"valign="top">
                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Check-in Date</p></strong>
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">' . ($_POST['arrivaldate']) . '(' . $theintime . ')</p> 
                                        </td>
                                        <td style="width:250px;"valign="top">
                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Check-out Date</p></strong>
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">' . ($_POST['leavingdate']) . '(' . $theouttime . ')</p> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:250px;"valign="top">
                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Length of Stay</p></strong>
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$numberofnights.'</p> 
                                        </td>
                                        <td style="width:250px;"valign="top">
                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Guests / Apartments</p></strong>
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.($_POST['numberofguests']).'&nbsp; / &nbsp;'.($_POST['numberofapts']).'</p> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" colspan="1">
                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Apartment(s) Breakdown</p></strong>
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.($_POST['apptbreakdown']).'</p> 
                                        </td>
                                        <td valign="top" colspan="1">
                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Additional Notes</p></strong>
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.($_POST['additionalnotes']).'</p> 
                                        </td>                                        
                                    </tr>
                                    '.$areainformationtext.'
                                    <tr>
                                        <!-- Guest Details -->
                                        <td style="width:250px;"valign="top">
                                            <h4 style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Guest Contact</h4>
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.($_POST['guestname']).'</p> 
                                        </td>
                                         <!-- Operator Details -->
                                        <td style="width:250px;"valign="top">
                                            <h4 style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Operator Contact</h4>
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.($_POST['operatorname']).'</p> 
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <p></p>
                             <!-- Pricing -->
                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                <tbody>
                                    <!-- Apartment details -->
                                    <tr>
                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                           <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Price</p>
                                        </td>
                                    </tr>                                                            
                                    <tr>
                                       <td style="width:250px;"valign="middle">
                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Owner Price</p></strong>
                                        </td>
                                        <td style="width:250px;"valign="middle">  
                                          <p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">&pound;'.($_POST['ownerprice']).'</p>                                     
                                        </td>
                                    </tr>                                                                   
                                </tbody>
                            </table>                    

                            <p></p>
                           <!-- Arrival Process -->
                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                <tbody>                                 
                                    <tr>
                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                           <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Arrival Process</p>
                                        </td>
                                    </tr>
                                    <tr>                                        
                                        <td valign="top" colspan="2">
                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.($_POST['arrivalprocess']).'</p>    
                                            
                                        </td>
                                    </tr>                                  
                                </tbody>
                            </table>

                            <p></p>
                            <!--Terms -->
                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                <tbody>
                                    <tr>
                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                           <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Terms and Conditions</p>
                                        </td>
                                    </tr>
                                    <tr>                                        
                                        <td valign="top" colspan="2">  
                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.($_POST['terms']).'</p>                                         
                                        </td>
                                    </tr>                                  
                                </tbody>
                            </table>

                            <p></p>
                            <!-- Thank you -->
                            <table style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                <tbody>
                                    <tr>                                        
                                        <td valign="top" colspan="2">
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Thanks for using Serviced City Pads as your booking agent. We hope you have an enjoyable stay.</p>

                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">We have an extensive selection of serviced apartments located across the UK. Please visit www.servicedcitypads.com to see how we can help you with your next stay.</p>

                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">If you have any comments or feedback about Serviced City Pads, please get in touch by e-mailing the Customer Service team. </p>

                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Regards</p>

                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">'.($_POST['username']).'</p>
                                        </td>
                                    </tr>                                    
                                </tbody>
                            </table>

                            <p></p>
                            <!-- Contact Info -->
                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                <tbody>
                                    <tr>
                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                            <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Contact Info</p>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td valign="top" colspan="2" style="text-align:center;">
                                            Phone : 0844 335 8866<br>
                                            Email : <a href="">Reservations and Bookings</a><br>
                                            Web : <a href="www.servicedcitypads.com">servicedcitypads.com</a>
                                        </td>
                                    </tr>   
                                    <tr>
                                         <td valign="top" colspan="2" style="text-align:center;">
                                           <a href="http://www.servicedcitypads.com"><img style="width:100%;height:auto;"src="http://www.servicedcitypads.com/wp-content/themes/servicedcitypads/images/image001.gif"</a>
                                        </td>
                                    </tr>                           
                                </tbody>
                            </table>



                        </td>

                    </tr>

                </tbody>

            </table>';

        $subject = 'Booking Confirmation';
        $headers .= "Content-type: text/html;charset=utf-8\n";
        $headers .= "X-Priority: 3\n";
        $headers .= "X-MSMail-Priority: Normal\n";
        $headers .= "X-Mailer: php\n";
        $headers .= "From: Serviced City Pads <bookings@citypadsmail.com>\n";    
        $headers .= 'Cc: info@servicedcitypads.com,accounts@servicedcitypads.com';
        wp_mail( $to, $subject, $message, $headers);
        
        }

        
        
        die();


        

}
 
add_action('wp_ajax_booking_confirmation_email_operator', 'implement_ajax_email_operator');
add_action('wp_ajax_nopriv_booking_confirmation_email_operator', 'implement_ajax_email_operator');

?>