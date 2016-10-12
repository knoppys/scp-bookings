<?php

/**
**********************************
Send an email to Bryony to update the specified apartment. 
**********************************
**/

function implement_ajax_updaterequest() {



        if ( ($_POST['apartment']) ) {
            //get the correct page ID

            $to = 'bryony@servicedcitypads.com';
            $subject = 'Apartment Update Request';
            $message = 'A request has been made by '.($_POST['username']).' to update the Pending Apartment: "'.($_POST['apartment']).'" for use in the Customer Query Tool.';

            $headers = "Content-type: text/html;charset=UTF-8\n";
            $headers .= "X-Priority: 3\n";
            $headers .= "X-MSMail-Priority: Normal\n";
            $headers .= "X-Mailer: php\n";
            $headers .= 'From:'.($_POST['username']).'<bookings@citypadsmail.com>\n';   
            wp_mail( $to, $subject, $message, $headers);   

            echo $message;

            die();
        }


}   

add_action('wp_ajax_updaterequest', 'implement_ajax_updaterequest');
add_action('wp_ajax_nopriv_updaterequest', 'implement_ajax_updaterequest');