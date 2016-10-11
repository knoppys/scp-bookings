<?php

/**
**********************************
Get the chosen apartment list from the custom search query and send it to the client in a nice tempalte
**********************************
**/

function implement_ajax_apartmentsearchemail() {



        if ( ($_POST['email']) ) {
            //get the correct page ID
            $to = ($_POST['email']);
            $name = ($_POST['name']);
            $subject = 'Our Recommendations.';
            $postidstring = ($_POST['postidstring']);  
            $commentsstring = ($_POST['commentsstring']) ;
            $reseller = ($_POST['reseller']);
            $pricestring = ($_POST['pricestring']);

            if ($name) {
                $nametext = $name;
            } else {
                $nametext = 'Sir / Madam';
            }
            

            if ($reseller == '') {
                $message = emailcontentscp($postidstring, $commentsstring, $pricestring, $nametext);
            } else {
                $message = emailcontentreseller($postidstring, $commentsstring, $pricestring, $nametext, $reseller);
            }  

            $current_user = wp_get_current_user();          
        
            $subject = 'Our Recommendations';
            $headers = "Content-type: text/html;charset=UTF-8\n";
            $headers .= "X-Priority: 3\n";
            $headers .= "X-MSMail-Priority: Normal\n";
            $headers .= "X-Mailer: php\n";
            $headers .= "From: Serviced City Pads  <bookings@citypadsmail.com>\n";
            $headers .= 'CC: '.$current_user->user_email;    
            wp_mail( $to, $subject, $message, $headers);   

            die();
        }


}   

add_action('wp_ajax_apartmentsearchemail', 'implement_ajax_apartmentsearchemail');
add_action('wp_ajax_nopriv_apartmentsearchemail', 'implement_ajax_apartmentsearchemail');