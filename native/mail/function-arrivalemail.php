<?php

/*****************************************************************************
*This fine contains the mail functionality for booking confirmation emails. 
******************************************************************************/

function implement_ajax_arrival_email(){
    if(isset($_POST['bookingID']))
        { 
 
        $to = get_post_meta(($_POST['bookingID']), 'clientemail', true);
        $message = arrivalemail(($_POST['bookingID']));       

        $subject = 'Arrival Process';
        $headers .= "Content-type: text/html;charset=utf-8\n";
        $headers .= "X-Priority: 3\n";
        $headers .= "X-MSMail-Priority: Normal\n";
        $headers .= "X-Mailer: php\n";
        $headers .= "From: Serviced City Pads <bookings@citypadsmail.com>\n";    
        $headers .= 'Cc: info@servicedcitypads.com,accounts@servicedcitypads.com';
        wp_mail( $to, $subject, $message, $headers);
        
        }       
        echo $message;
        die();        

}
 
add_action('wp_ajax_arrival_email', 'implement_ajax_arrival_email');
add_action('wp_ajax_nopriv_arrival_email', 'implement_ajax_arrival_email');

?>