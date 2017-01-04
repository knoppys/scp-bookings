<?php

/*****************************************************************************
*This fine contains the mail functionality for booking confirmation emails. 
******************************************************************************/

function implement_ajax_email_client(){
    if(isset($_POST['bookingId']))
        { 

        $to = get_post_meta(($_POST['bookingId']), 'clientemail', true); 
        $message = operatoremail(($_POST['bookingID']));             

        $subject = 'Booking Confirmation: '.get_post_meta(($_POST['bookingID']), 'guestname', true);
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
 
add_action('wp_ajax_booking_confirmation_email_client', 'implement_ajax_email_client');
add_action('wp_ajax_nopriv_booking_confirmation_email_client', 'implement_ajax_email_client');

?>