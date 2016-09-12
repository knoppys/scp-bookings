<?php

/**
Sends an email to the client 
**/

function implement_ajax_sendemail() {
    if(isset($_POST['email']))
        {

            
            /*******************
            *Place Function Below Here
            *******************/
            /*
            if sending content back
            ob_start();
            */
            
           

            $to = ($_POST['email']);
            $message = '

            <html>
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
                                            <h2 style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Reseller Information</h2>
                                        </td>
                                    </tr>
                                    <!-- Welcome text -->                                    
                                    <tr>
                                        <td valign="top" colspan="2">
                                       <p style="margin:3px;border-bottom:1px solid #fff;"></p>
                                        <p></p>
                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Thank you for your interest in the Apartment Recommendations Tool from Serviced City Pads.</p>

                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">This email is to confirm the creation of your account on our system and provide you with some information about setting up the Customer Query Script on your chosen hosting provider.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p></p>                            
                            
                            <!-- Installation details -->   
                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                <tbody>  
                                     <!-- Installation details -->
                                    <tr>
                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                           <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Step 1 :: Software Download</p>
                                        </td>  
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="middle">
                                        <p style="margin:3px;padding:4px 0;font-size:15px;"><strong>How does this software work?</strong></p>
                                        <p style="margin:3px;padding:4px 0;font-size:15px;">The script you download will sit on your webspace and act as a window to a page on our Website. The page on our site shows your company branding and details etc along with the selected apartments for each customer query.</p>
                                        <p style="margin:3px;padding:4px 0;font-size:15px;"><strong>Is this software secure?</strong></p>
                                        <p style="margin:3px;padding:4px 0;font-size:15px;">This software is totally secure, the script will not interact with your webspace or your website. It wont ask for any passwords and the content can not be indexed by google.</p>
                                        <p style="margin:3px;padding:4px 0;font-size:15px;">Click the icon to download the Reseller Software.</p>
                                          <p style="padding:20px 0;text-align:center;"><img style="display:block;margin:0 auto;" src="http://www.servicedcitypads.com/images/download.png" alt="Download Icon" title="Download the SCP Reseller Script"></p>
                                        <p style="margin:3px;padding:4px 0;font-size:15px;">If you have any questions regarding the use of this script or you wish to enquire into its methods before use, please feel free to contact our support team on support@knoppys.co.uk</p>                                        
                                        </td>  
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                           <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Step 2 :: Installation</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="middle">
                                           <p style="margin:3px;padding:4px 0;font-size:15px;"><strong>Upload to your server using FTP:</strong></p>
                                           <p style="margin:3px;padding:4px 0;font-size:15px;">If you are using FTP to upload this script to your server, you will need to unzip the folder first and upload the complete directory ("customer-query") to the root directory of your chosen webspace. Please be aware that in order to work, you must not change the name of the folder from "customer-query".</p>
                                            <p style="margin:3px;padding:4px 0;font-size:15px;"><strong>Upload to your server using File Manager:</strong></p>
                                            <p style="margin:3px;padding:4px 0;font-size:15px;">Using your hosts file manager, upload the complete zip file to the root of your webspace and uzip the folder. Again we ask that you do not change the name of the folder from customer-query.</p>
                                            <p style="margin:3px;padding:4px 0;font-size:15px;">Please remember to let us know if you are using a web address different than that of your normal web address for this tool.</p>
                                            <p style="margin:3px;padding:4px 0;font-size:15px;"><strong>Installation Complete</strong></p>
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

            </table>
            </body>
            </html>

            ';
            $subject = 'Serviced City Pads Reseller Introduction';
            $headers .= "Content-type: text/html;charset=utf-8\n";
            $headers .= "X-Priority: 3\n";
            $headers .= "X-MSMail-Priority: Normal\n";
            $headers .= "X-Mailer: php\n";
            $headers .= "From: Serviced City Pads <bookings@citypadsmail.com>";    
            wp_mail( $to, $subject, $message, $headers);


            /*
            if sending content back
            $content = ob_get_clean();
            */
            /*******************
            *End Here
            *******************/


            //send the array back           
            //echo $content;

            die();
        }
    }
add_action('wp_ajax_sendemail', 'implement_ajax_sendemail');
add_action('wp_ajax_nopriv_sendemail', 'implement_ajax_sendemail');

?>