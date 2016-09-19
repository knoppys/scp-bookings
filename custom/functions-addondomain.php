<?php

/**
Title of the function and what it does
**/

function implement_ajax_addondomain() {
    if(isset($_POST['addondomain']))
        {

            
            /*******************
            *Place Function Below Here
            *******************/
            /*
            if sending content back
            ob_start();
            */

            
            //get the addon domain 
            $addondomain = ($_POST['addondomain']);
            $subdomain = explode('.', $addondomain);
            $subStr = $subdomain[0];


            
            //need this to connect
            $whmusername = "root";
            $whmpassword = "Here979Nick04)";
             
            $query = 'https://185.77.83.90:2087/json-api/cpanel?cpanel_jsonapi_user=servicedcitypads&apiversion=2&cpanel_jsonapi_module=AddonDomain&cpanel_jsonapi_func=addaddondomain&dir=query&newdomain='.$addondomain.'&subdomain='.$subStr;
                      
            $curl = curl_init();                                // Create Curl Object
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);       // Allow self-signed certs
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);       // Allow certs that do not match the hostname
            curl_setopt($curl, CURLOPT_HEADER,0);               // Do not include header in output
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);       // Return contents of transfer on curl_exec
            $header[0] = "Authorization: Basic " . base64_encode($whmusername.":".$whmpassword) . "\n\r";
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);    // set the username and password
            curl_setopt($curl, CURLOPT_URL, $query);            // execute the query
            $result = curl_exec($curl);
            if ($result == false) {
                error_log("curl_exec threw error \"" . curl_error($curl) . "\" for $query");      // log error if curl exec fails
            }
            curl_close($curl);
            

            
            //create the email variables.

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
                                          <p style="padding:20px 0;text-align:center;"><a href="http://www.servicedcitypads.com/downloads/customerquery.zip"><img style="display:block;margin:0 auto;" src="http://www.servicedcitypads.com/images/download.png" alt="Download Icon" title="Download the SCP Reseller Script"></a>"</p>
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
                                           <p style="margin:3px;padding:4px 0;font-size:15px;">If you are using FTP to upload this script to your server, you will need to unzip the folder first and upload the complete directory to the root your chosen webspace. Please be aware that in order to work, you must not change the name of the folder from "customerquery".</p>
                                            <p style="margin:3px;padding:4px 0;font-size:15px;"><strong>Upload to your server using File Manager:</strong></p>
                                            <p style="margin:3px;padding:4px 0;font-size:15px;">Using your hosts file manager, upload the complete zip file to the root of your webspace and uzip the folder. Again we ask that you do not change the name of the folder from "customerquery".</p>
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
            echo $result;
            die();
        }
    }
add_action('wp_ajax_addondomain', 'implement_ajax_addondomain');
add_action('wp_ajax_nopriv_addondomain', 'implement_ajax_addondomain');

?>