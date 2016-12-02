<?php

/*****************************************************************************
*This fine contains the mail functionality for booking confirmation emails. 
******************************************************************************/

function implement_ajax_arrival_email(){
    if(isset($_POST['bookingID']))
        { 

            //get some of the booking details
            $booking = get_post_meta(($_POST['bookingID']));

            //WP Mail Variables
            $to = $booking['clientemail'][0];

            //Check to see if there is a display name overide. 
            if ($booking['displayname'][0]) {
                $titletext = $booking['displayname'][0];
            } else {
                $titletext = get_the_title(($_POST['bookingID']));
            }                

            //Get the apartment details
            $apartmenttitle = $booking['apartmentname'][0];
            $page = get_page_by_title( $apartmenttitle, OBJECT, 'apartments');
            $permalink = $page->guid;

            //get the apartment address details
            $apartmentaddress   = get_post_meta($page->ID,'address', true );            
            $aprtmentlocation   = get_post_meta($page->ID,'apptlocation1', true);
            $aprtmentlocation2  = get_post_meta($page->ID,'apptlocation2', true);
            $apartmentpostcode  = get_post_meta($page->ID,'postcode', true );
            $apartmentstate     = get_post_meta($page->ID,'state', true );
            $apartmentcountry   = get_post_meta($page->ID,'country', true ); 

            //get the post code into the correct format
            $mappostcode = preg_replace('/\s+/', '+', $apartmentpostcode);

            //location text
            if ($aprtmentlocation == $aprtmentlocation2) {
                $locationtext = $aprtmentlocation . '<br>';
            } else {
                $locationtext = $aprtmentlocation . '<br>' . $aprtmentlocation2 . '<br>';
            }

        /**
            Build the email
        **/ 
        $message = ' 


        <html>
        <head>
        <style>
        body {
            font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;color:#003;
        }
        p {
            margin:0px;
        }
        </style>
        </head>
            <body>
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
                                                <h2 style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Arrival Notification</h2>
                                            </td>
                                        </tr>
                                        <!-- Welcome text -->                                    
                                        <tr>
                                            <td valign="top" colspan="2">
                                            <p style="margin:10px;border-bottom:1px solid #fff;"></p>
                                            <p></p>
                                                <p style="margin:10px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Thank you for choosing Services City Pads.</p>
                                                <p style="margin:10px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;"> Please find below your arrival instructions for your upcoming stay.</p>                                                                            
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p></p>     

                                <table align="center" style="background:#eee;margin: 0;padding: 10px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                    <tbody>
                                        <tr>
                                            <td style="padding-bottom:10px;">                                                
                                                <strong>Lead Guest: </strong>'.$booking['guestname'][0].'
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom:10px;">                                                
                                                <strong>Apartments: </strong>'.$booking['apartmentname'][0].'<br>
                                                <strong>Address: </strong>' . $apartmentaddress . ', ' . $aprtmentlocation . ', ' . $aprtmentlocation2 . ', ' . $apartmentstate . ', ' . $apartmentpostcode . '<br>' . $apartmentcountry . '
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom:10px;">
                                                <strong>Check-in: </strong>'.$booking['arrivaldate'][0].' ('.$booking['checkintime'][0].')<br>
                                                <strong>Check-in: </strong>'.$booking['leavingdate'][0].' ('.$booking['checkouttime'][0].')
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom:10px;">
                                                <strong>Arrival Process:</strong><br>'.$booking['arrivalprocess'][0].'
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom:10px;">
                                                <strong>Additional Information:</strong><br>'.$booking['additionalnotes'][0].'
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom:10px;">
                                                <strong>Emergency Tel.:</strong>'.$booking['emergencycontact'][0].'
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom:5px;">
                                                <strong>Map:</strong><br>
                                                <span style="font-style:italic;">For an interactive map, please <a style="colour:red;"href="'.$page->guid.'">click here</a></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="http://maps.googleapis.com/maps/api/staticmap?center='.$mappostcode.'&zoom=15&size=450x300&maptype=roadmap&markers=color:blue%7Clabel:We+are+here%7C'.$mappostcode.'&key=AIzaSyAgbOmk-xspMP30E6kXDyHH1-2VMIRJsjY"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom:10px;padding-top:10px;">
                                                 <strong>Terms &amp; Conditions</strong><br>'.$booking['terms'][0].'
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                    <strong>We hope you have an enjoyable stay.</strong><br></br>
                                               
                                                    If you have any questions or require assistance during your stay, please do not hesitate to get in touch. Our team can arrange extensions, late check-out and grocery deliveries - just give us a call.<br></br>
                                              
                                                    We look forward to seeing you soon!<br></br>
                                               
                                                    <strong>Serviced CIty Pads Reservation Team</strong>
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
                                               <p style="margin:10px;padding:4px 0;font-size:15px;font-weight:bold;">Contact Info</p>
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
                                               <a href="http://www.servicedcitypads.com"><img style="width:450px;height:auto;"src="http://www.servicedcitypads.com/wp-content/themes/servicedcitypads/images/image001.gif"</a>
                                            </td>
                                        </tr>                           
                                    </tbody>
                                </table>


                            </td>

                        </tr>

                    </tbody>

                </table>
            </body>
    </html>';

        $subject = 'Arrival Process';
        $headers .= "Content-type: text/html;charset=utf-8\n";
        $headers .= "X-Priority: 3\n";
        $headers .= "X-MSMail-Priority: Normal\n";
        $headers .= "X-Mailer: php\n";
        $headers .= "From: Serviced City Pads <bookings@citypadsmail.com>\n";    
        $headers .= 'Cc: info@servicedcitypads.com,accounts@servicedcitypads.com';
        wp_mail( $to, $subject, $message, $headers);
        
        }


        echo $message ;
        die();

        

}
 
add_action('wp_ajax_arrival_email', 'implement_ajax_arrival_email');
add_action('wp_ajax_nopriv_arrival_email', 'implement_ajax_arrival_email');

?>