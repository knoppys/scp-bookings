<?php

/**
**********************************
Get the chosen apartment list from the custom search query and send it to the client in a nice tempalte
**********************************
**/

function implement_ajax_apartmentsearchemail() {



        if ( ($_POST['reseller']) == '' ) {
            //get the correct page ID
            $to = ($_POST['email']);
            $name = ($_POST['name']);
            $subject = 'Our Recommendations.';
            $content = ($_POST['content']);   
            //$content = html_entity_decode(($_POST['content']));      

			$message1 = ' 


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
                                        <td valign="middle>
                                            <h2 style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#ffffff;">Our Recommendations</h2>
                                        </td>
                                    </tr>
                                   <!-- Welcome text -->                                    
                                    <tr>
                                        <td valign="top" colspan="2">
                                        <p style="margin:3px;border-bottom:1px solid #fff;"></p>
                                        <p></p>
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Dear '.($_POST['name']).'</p>
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Thank you for your interest in Serviced City Pads</p>
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Please find a list of our recommended apartments below.</p>                                           
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p></p>                            
                            ';
            $message2 = $content;
            $message3 = '
                            
                            <p></p>

                            

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

         /**
         If the query is for a reseller
        */
        } else {         

            //get the reseller details
            $to = ($_POST['email']);
            $name = ($_POST['name']);
            $subject = 'Our Recommendations.';
            $content = ($_POST['content']);
            $resellertitle = ($_POST['reseller']);
            $page = get_page_by_title( $resellertitle, OBJECT, 'resellerp');
            $companylogo = wp_get_attachment_url( get_post_thumbnail_id($page->ID) );
            $postidstring = ($_POST['postidstring']);
            $resellername = get_post_meta();
            if (get_post_meta($page->id, 'resellerp_pageurl')) {
            	$resellerlink = '<a style="color:#333;text-decoration:none;" href="' . get_post_meta( $page->ID, 'resellerp_pageurl', true ) . '/customerquery/query.php?name=' . $page->post_name . '&ids=' . $postidstring.'">View these apartments online</a>';
            } else {
            	$resellerlink = '<a style="color:#333;text-decoration:none;" href="' . get_post_meta( $page->ID, 'resellerp_website', true ) . '/customerquery/query.php?name=' . $page->post_name . '&ids=' . $postidstring.'">View these apartments online</a>';
            }
           
            $message1 = ' 


            <table width="500px" align="center" style="border:1px solid #555; background:#003;margin: 0 auto;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">

                <tbody>

                    <tr>

                        <td valign="top">

                            <!-- the company logo -->
                             <table align="center" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                <tbody>
                                    <tr>
                                        <td valign="top" width="300" height="95">
                                            <img src="'. $companylogo .'" style="margin: 0;padding: 0;max-width: 200px;width:100%;">
                                        </td>
                                        <td valign="middle">
                                            <h2 style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Our Recommendations</h2>
                                        </td>
                                    </tr>
                                    <!-- Welcome text -->                                    
                                    <tr>
                                        <td valign="top" colspan="2">
                                        <p style="margin:3px;border-bottom:1px solid #fff;"></p>
                                        <p></p>
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Thankyou for your interest in ' . $resellertitle . '</p>
                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Please find a list of our recommended apartments below.</p>                                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                           <p></p>                            
                            ';
            $message2 = $content;
            $message3 = '
                            
                            <p></p>

                            <table width="100%" cellpadding="10" cellspacing="0" border-collapse="collapse" style="background:#ffa900;border-radius:5px; text-align:center;" class="">
                                <tbody>
                                    <tr>
                                        <td valign="middle">
                                        '.$resellerlink.'
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
                                            Regards : '.get_post_meta($page->ID,'resellerp_clientname', true).'<br>
                                            Phone : '.get_post_meta($page->ID,'resellerp_phone', true).'<br>
                                            Email : <a href="mailto:'.get_post_meta($page->ID,'resellerp_email', true).'">Reservations and Bookings</a><br>
                                            Web : <a href="'.get_post_meta($page->ID,'resellerp_website', true).'">'.get_post_meta($page->ID,'resellerp_website', true).'</a>
                                        </td>
                                    </tr>  
                                                               
                                </tbody>
                            </table>



                        </td>

                    </tr>

                </tbody>

            </table>';



        }

        $subject = 'Our Recommendations';
        $headers .= "Content-type: text/html;charset=UTF-8\n";
        $headers .= "X-Priority: 3\n";
        $headers .= "X-MSMail-Priority: Normal\n";
        $headers .= "X-Mailer: php\n";
        $headers .= "From: Serviced City Pads  <bookings@citypadsmail.com>\n";    
        wp_mail( $to, $subject, $message1 . stripslashes($message2) . $message3, $headers);   

        echo $content;

        die();



}   

add_action('wp_ajax_apartmentsearchemail', 'implement_ajax_apartmentsearchemail');
add_action('wp_ajax_nopriv_apartmentsearchemail', 'implement_ajax_apartmentsearchemail');