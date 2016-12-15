<?php

function arrivalemail($ID) {

    //get some of the booking details
    $booking = get_post_meta($ID);

    //Check to see if there is a display name overide. 
    if ($booking['displayname'][0]) {
        $titletext = $booking['displayname'][0];
    } else {
        $titletext = get_the_title(($_POST['bookingID']));
    }                

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
            $address = get_post_meta($page->ID,'address', true ).', ';
        } else {
            $address = '';
        }

        //check for a building name
        if (get_post_meta($page->ID,'town', true )) {
            $town = get_post_meta($page->ID,'town', true ).', ';
        } else {
            $town = '';
        }

        //check for a building name
        if (get_post_meta($page->ID,'state', true )) {
            $state = get_post_meta($page->ID,'state', true ).', ';
        } else {
            $state = '';
        }

        //check for a building name
        if (get_post_meta($page->ID,'postcode', true )) {
            $postcode = get_post_meta($page->ID,'postcode', true );
        } else {
            $postcode = '';
        }

        //check for a building name
        if (get_post_meta($page->ID,'country', true )) {
            $country = get_post_meta($page->ID,'country', true ).', ';
        } else {
            $country = '';
        }
        
        $fulladdress = $buildingname.$address.$town.$state.$postcode.$country;


    //arrival email text
    if ($booking['arrivalprocess'][0]) {
        $arrivaltext = '
        <tr>
            <td style="font-family: \'Helvetica\', \'Arial\', sans-serif;background:#efefef;padding:10px;">
                <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">
                    <strong style="font-weight:bold;">Arrival Process:</strong><br>'.$booking['arrivalprocess'][0].'
                </p>
            </td>
        </tr>
        ';
    } else {}

    //additional information text
    if ($booking['additionalinformation'][0]) {
        $additionalinformationtext = '
        <tr>
            <td style="font-family: \'Helvetica\', \'Arial\', sans-serif;background:#efefef;padding:10px;">
                <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">
                    <strong style="font-weight:bold;">Additional Information:</strong><br>'.$booking['additionalnotes'][0].'
                </p>
            </td>
        </tr>
        ';
    } else {}

    //emergeny telephone text
    if ($booking['emergenecycontact']) {
        $emergencytelephonetext = '
        <tr>
            <td style="font-family: \'Helvetica\', \'Arial\', sans-serif;background:#efefef;padding:10px;">
                <p style="font-family: \'Helvetica\', \'Arial\', sans-serif;color:#333;">
                    <strong style="font-weight:bold;">Emergency Tel.:</strong>'.$booking['emergencycontact'][0].'
                </p>
            </td>
        </tr>
        ';
    } else {
        # code...
    }
    
    
    


        ob_start(); ?>
        <html xmlns="http://www.w3.org/1999/xhtml">

        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:600,800" rel="stylesheet" />
            <!--[if !mso]><!-->
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:600,800" rel="stylesheet" />
            <!--<![endif]-->
            <style type="text/css">
                body, p {
                    font-family: 'Helvetica', 'Arial', sans-serif;
                }
                strong {
                    font-weight: bold;
                }
            </style>
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
                                                                            <h2 style="font-family: 'Helvetica', 'Arial', sans-serif;color:#fff;">Arrival Process</h2>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="background:#003;padding:10px;">
                                                                           <p style="font-family: 'Helvetica', 'Arial', sans-serif;color:#fff;font-size: 16px;">                                              
                                                                                Thank you for choosing Serviced City Pads.
                                                                                Please find below your arrival instructions for your upcoming stay.
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table> 
                                                            

                                                            <table cellspacing="0" cellpadding="0" class="" width="500" style="width:500px;background: #fff; margin:0 auto;" border-collapse="collapse">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="background:#efefef;padding:10px;">
                                                                            <p style="font-family: 'Helvetica', 'Arial', sans-serif;color:#333;">                                           
                                                                                <strong>Lead Guest: </strong><?php echo $booking['guestname'][0]; ?>
                                                                            </p>
                                                                        </td>
                                                                    </tr>  
                                                                    <tr>
                                                                        <td style="background:#efefef;padding:10px;">
                                                                            <p style="font-family: 'Helvetica', 'Arial', sans-serif;color:#333;">
                                                                                <strong>Apartments: </strong><?php echo $booking['apartmentname'][0]; ?><br>
                                                                                <strong>Address: </strong><?php echo $fulladdress; ?>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="background:#efefef;padding:10px;">
                                                                            <p style="font-family: 'Helvetica', 'Arial', sans-serif;color:#333;">
                                                                                <strong>Check-in: </strong><?php echo $booking['arrivaldate'][0]; ?> (<?php echo $booking['checkintime'][0]; ?>)<br>
                                                                                <strong>Check-in: </strong><?php echo $booking['leavingdate'][0]; ?> (<?php echo $booking['checkouttime'][0]; ?>)
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <?php echo $arrivaltext; ?>
                                                                    <?php echo $additionalinformationtext; ?>
                                                                    <?php echo $emergencytelephonetext; ?>
                                                                    <tr>
                                                                        <td style="background:#efefef;padding:10px;">
                                                                            <p style="font-family: 'Helvetica', 'Arial', sans-serif;color:#333;">
                                                                                <strong>Map:</strong><br>
                                                                                <span style="font-style:italic;">For an interactive map, please <a style="color:red;"href="<?php echo $page->guid; ?>">click here</a></span>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="background:#efefef;padding:10px;">
                                                                            <img src="http://maps.googleapis.com/maps/api/staticmap?center='.$mappostcode.'&zoom=15&size=450x300&maptype=roadmap&markers=color:blue%7Clabel:We+are+here%7C'.$mappostcode.'&key=AIzaSyAgbOmk-xspMP30E6kXDyHH1-2VMIRJsjY"/>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="background:#efefef;padding:10px;">
                                                                            <p style="font-family: 'Helvetica', 'Arial', sans-serif;color:#333;">
                                                                                 <strong>Terms &amp; Conditions</strong><br><?php echo $booking['terms'][0]; ?>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="background:#efefef;padding:10px;">
                                                                            <p style="font-family: 'Helvetica', 'Arial', sans-serif;color:#333;">
                                                                                    <strong>We hope you have an enjoyable stay.</strong><br></br>                                                               
                                                                               
                                                                                    If you have any questions or require assistance during your stay, please do not hesitate to get in touch. Our team can arrange extensions, late check-out and grocery deliveries - just give us a call.<br></br>
                                                                              
                                                                                    We look forward to seeing you soon!<br></br>
                                                                               
                                                                                    <strong>Serviced City Pads Reservation Team</strong>
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
                                                                            Phone: 0844 335 8866<br>
                                                                            Email: <span style="color:#003;"><a href="">Reservations and Bookings</a></span><br>
                                                                            Web: <span style="color:#003;"><a href="www.servicedcitypads.com">servicedcitypads.com</a></span>
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
