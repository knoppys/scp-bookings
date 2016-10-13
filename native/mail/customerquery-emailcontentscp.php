<?php 
function emailcontentscp($postidstring, $commentsstring, $pricestring, $name){ 

    //get the post id string
    $postsin = explode(',', $postidstring);  

    //create an array from the $comments string
    $commentsarray = explode('%%',$commentsstring);

    //create an array from the $price string
    $pricearray = explode(',', $pricestring);
    
    //get all the posts required to fill the email template
    $args = array ('post__in' => $postsin,'post_type' => array( 'apartments' ));
    $apartments = get_posts($args);

     
    
    //concatinate the email header and body into a singel variable
    $template = '
        <html xmlns="http://www.w3.org/1999/xhtml">

        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
                                    <td valign="top" width="300" height="95">
                                        <img src="http://www.servicedcitypads.com/wp-content/themes/servicedcitypads/images/logo-email.PNG" style="margin: 0;padding: 0;max-width: 300px;width:100%;">
                                    </td>
                                    <td valign="middle">
                                        <h2 style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#ffffff;">Our Recommendations</h2>
                                    </td>
                                </tr>
                               <!-- Welcome text -->                                    
                                <tr>
                                    <td valign="top" colspan="2">
                                    <p style="margin:3px;border-bottom:1px solid #fff;"></p>
                                    <p></p>
                                        <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Dear '.$name.'</p>
                                        <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Thank you for your interest in Serviced City Pads</p>
                                        <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Please find a list of our recommended apartments below.</p>                                           
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <p></p> 
    ';
    //end header

    //begin body
    $i = 0;
    foreach ( $apartments as $apartment ) : setup_postdata( $apartment ); 
    //get post meta
    $apptlocation1 = get_post_meta($apartment->ID, 'apptlocation1', true);
    $bedrooms = get_post_meta( $apartment->ID, 'bedrooms', true );
    $bathrooms = get_post_meta($apartment->ID, 'bathrooms', true);
    $sleeps = get_post_meta( $apartment->ID, 'sleeps', true );
    $description = get_post_meta( $apartment->ID, 'description', true);
    $attachment_id = get_post_thumbnail_id( $apartment->ID );
    $image_attributes = wp_get_attachment_image_src( $attachment_id, 'medium' );
    if( $image_attributes ) {
        $img = '<img style="width:300px;height:auto;" src="'.$image_attributes[0].'">';
    } else {
        $img = '<img style="width:300px;height:auto;" src="http://www.servicedcitypads.com/servicedcitypads/wp-content/themes/servicedcitypads/images/logo.png">';
    }
    
    

    
    //start the item and add it to the previous $template variable
    $template .=    '<table bgcolor="#efefef" cellpadding="10" cellspacing="0" border="0" width="100%" class="bookings-aligntop container-table apartment-entry">
                        <tbody>
                            <tr>
                                <td class="featured-image-holder" valign="top" width="100%" style="padding-top:20px;text-align:center">'.$img.'</td>
                            </tr>
                            <tr>
                                <td class="pricingentry" width="100%">
                                    <h4><a href="'.$apartment->guid.'">'.$apartment->post_title.'</a></h4>
                                    <p><strong>Listing Price: '.$pricearray[$i].'</strong></p>
                                    <p><strong>Additional Pricing Information</strong></p>
                                    '.$commentsarray[$i].'<br/>                                                                                     
                                    <p><strong>Overview</strong></p>                                    
                                    <p>Location: '.$apptlocation1.'<br/>
                                    Bedrooms:'.$bedrooms.'<br/>
                                    Bathrooms: '.$bathrooms.'<br/>
                                    Sleeps: '.$sleeps.'</p>
                                    <p><strong>Description</strong></p>                                                     
                                    '.$description.'                                                                                                                                            
                                </td>                                     
                            </tr>
                        </tbody>
                    </table>';
                    $i++;
    endforeach; 
    wp_reset_postdata();


    //end body

    $template .=        '<p></p>
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
                                        Email : <a href="mailto:reservations@servicedcitypads.com">Reservations and Bookings</a><br>
                                        Web : <a href="http://www.servicedcitypads.com">servicedcitypads.com</a>
                                    </td>
                                </tr>   
                                <tr>
                                     <td valign="top" colspan="2" style="text-align:center;">
                                       <a href="http://www.servicedcitypads.com"><img style="width:100%;height:auto;" src="http://www.servicedcitypads.com/wp-content/themes/servicedcitypads/images/image001.gif"</a>
                                    </td>
                                </tr>                           
                            </tbody>
                        </table>



                    </td>

                </tr>

            </tbody>

        </table>
        </body>
        </html>
    
        <!--  End NOT reseller email   -->
    ';
    //end footer
    return $template;
    
    //ob_start();
    //var_dump($args);
    //$result = ob_get_clean();

    //return $result;
};