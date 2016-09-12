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
            

            /*
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

                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">This email is to confirm the creation of your account on our system and provide you with some information about what you need to do next.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p></p>                            
                            
                            <!-- Installation details -->   
                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                <tbody>  
                                     <!-- Installation details -->                                    
                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                           <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Step 2 :: Installation</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="middle">
                                           <p style="margin:3px;padding:4px 0;font-size:15px;"><strong>DNS Configuration:</strong></p>
                                           <p style="margin:3px;padding:4px 0;font-size:15px;">In order for the tool to work, you will need to create a web address different to that of your normal web address. In most cases clients prefer a sub domain.</p>
                                           <p style="margin:3px;padding:4px 0;font-size:15px;">This usually takes the form of something like subdomain.your-domain-name.com.</p>
                                           <p style="margin:3px;padding:4px 0;font-size:15px;">Then you will need to update the DNS for this seperate web address by adding an A record pointing to the Serviced City Pads Server. If you dont know how to do this, contact your hosting provider / domain registrar as most of them will be happy to do this for you. </p>
                                           <p style="text-align:center;margin:3px;padding:4px 0;font-size:15px;"><strong>New A Record :: 185.77.83.90</strong></p>
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