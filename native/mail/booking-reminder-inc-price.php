<?php

/**
This is the file for the booking reminder email, it is sent using cron jobs at different intervals.
*/


// here's the function we'd like to call with our cron job
function bookingreminderfunction() {
	
	//get the posts
	$postargs = array('post_type' => 'bookings');
	$bookings = get_posts($postargs);

	//get the post meta
	foreach ($bookings as $booking) {
		$arrivaldate = get_post_meta($booking, 'arrivaldate', true);
	}

	//get the number of days between the current date and the checkin date
	$start = time();
	$end = $arrivaldate;
	$datediff = ceil(abs($end - $start) / 86400);

	//if the number of days before checkin is either 7 or 14 then run the email function
	if ( ($datediff == 7) || ($datediff == 14) ){

            //get the bookings meta
            $guestname          = get_post_meta($booking,'guestname', true);
            $title              = get_post_meta($booking,'title', true);
            $guestemail         = get_post_meta($booking,'email', true); 
            $guestphone         = get_post_meta($booking,'phone', true);
            $apartmentname      = get_post_meta($booking,'apartmentname', true); 
            $numberofapts       = get_post_meta($booking,'numberofapts', true); 
            $additionalnotes    = get_post_meta($booking,'additionalnotes', true); 
            $apptbreakdown      = get_post_meta($booking,'apptbreakdown', true);
            $arrivaldate        = get_post_meta($booking,'arrivaldate', true);
            $terms              = get_post_meta($booking,'terms', true); 
            $arrivalprocess     = get_post_meta($booking,'arrivalprocess', true);  
            $emergencycontact   = get_post_meta($booking,'emergencycontact', true);  
            $clientname         = get_post_meta($booking,'clientname', true);  
            $operatorname       = get_post_meta($booking,'operatorname', true);
            $operatoremail      = get_post_meta($booking,'operatoremail', true); 
            $operatorphone      = get_post_meta($booking,'operatorphone', true);  
            $leavingdate        = get_post_meta($booking,'leavingdate', true);
            $checkintime        = get_post_meta($booking,'checkintime', true);
            $checkouttime       = get_post_meta($booking,'checkouttime', true);
            $actualcheckintime  = get_post_meta($booking,'actualcheckintime', true);
            $actualcheckouttime = get_post_meta($booking,'actualcheckouttime', true); 
            $supplementsprice   = get_post_meta($booking,'supplementsprice', true);  
            $priceperperson     = get_post_meta($booking,'priceperperson', true); 
            $numberofguests     = get_post_meta($booking,'numberofguests', true);              
            $rentalprice        = get_post_meta($booking,'rentalprice', true); 
            $vatamount          = get_post_meta($booking,'vatamount', true);
            $totalcost         = get_post_meta($booking,'totalcost', true);
            $discount           = get_post_meta($booking, 'discount', true);

            //get the apartment meta
            $apartmenttitle = $apartmentname;
            $page = get_page_by_title( $apartmenttitle, OBJECT, 'apartments');

            //get the apartment address details
            $apartmentaddress   = get_post_meta($page->ID,'address', true );            
            $aprtmentlocation   = get_post_meta($page->ID,'apartmentlocation', true);
            $aprtmentlocation2  = get_post_meta($page->ID,'apptlocation2', true);
            $apartmentpostcode  = get_post_meta($page->ID,'postcode', true );
            $apartmentstate     = get_post_meta($page->ID,'state', true );
            $apartmentcountry   = get_post_meta($page->ID,'country', true );
            
            //get the number of nights
            $datetime1 = new DateTime($arrivaldate);
            $datetime2 = new DateTime($leavingdate);
            $interval = $datetime1->diff($datetime2);
            $numberofnights = $interval->format('%a nights');

            //get the nightly rate
            if ($priceperperson) {
                $nightlyrate = $priceperperson;
            } else {
                $nightlyrate = $rentalprice;
            }

            //get the default check in and check out times
            //or use the overide. 
                //the chekin time
                if ($actualcheckintime) {
                    $thetime = $actualcheckintime;
                } else {
                    $theintime = $checkintime;
                }
                //the chek out time
                if ($actualcheckouttime) {
                    $theouttime = $actualcheckouttime;
                } else {
                    $theouttime = $checkouttime;
                }
                

            $authoremail = get_the_author_meta( 'user_email', $userID );

            //send it back to test
            $to = $recipient;
            $message = '
                        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                        <head style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                        <!-- If you delete this tag, the sky will fall on your head -->
                        <meta name="viewport" content="width=device-width" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">

                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                        <title style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">ZURBemails</title>
                            
                        <style type="text/css" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                        /* ------------------------------------- 
                                GLOBAL 
                        ------------------------------------- */
                        * { 
                            margin:0;
                            padding:0;
                        }
                        * { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; }

                        img { 
                            max-width: 100%; 
                        }
                        .collapse {
                            margin:0;
                            padding:0;
                        }
                        body {
                            -webkit-font-smoothing:antialiased; 
                            -webkit-text-size-adjust:none; 
                            width: 100%!important; 
                            height: 100%;
                        }


                        /* ------------------------------------- 
                                ELEMENTS 
                        ------------------------------------- */
                        a { color: #2BA6CB;}

                        .btn {
                            text-decoration:none;
                            color: #FFF;
                            background-color: #666;
                            padding:10px 16px;
                            font-weight:bold;
                            margin-right:10px;
                            text-align:center;
                            cursor:pointer;
                            display: inline-block;
                        }

                        p.callout {
                            padding:15px;
                            background-color:#ECF8FF;
                            margin-bottom: 15px;
                        }
                        .callout a {
                            font-weight:bold;
                            color: #2BA6CB;
                        }
                        .spacertext{
                            color: #ebebeb;
                        }
                        table.social {
                        /*  padding:15px; */
                            background-color: #ebebeb;
                            
                        }
                        .social .soc-btn {
                            padding: 3px 7px;
                            font-size:12px;
                            margin-bottom:10px;
                            text-decoration:none;
                            color: #FFF;font-weight:bold;
                            display:block;
                            text-align:center;
                        }
                        a.fb { background-color: #3B5998!important; }
                        a.tw { background-color: #1daced!important; }
                        a.gp { background-color: #DB4A39!important; }
                        a.ms { background-color: #000!important; }

                        .sidebar .soc-btn { 
                            display:block;
                            width:100%;
                        }

                        /* ------------------------------------- 
                                HEADER 
                        ------------------------------------- */
                        table.head-wrap { width: 100%;}

                        .header.container table td.logo { padding: 15px; }
                        .header.container table td.label { padding: 15px; padding-left:0px;}


                        /* ------------------------------------- 
                                BODY 
                        ------------------------------------- */
                        table.body-wrap { width: 100%;}


                        /* ------------------------------------- 
                                FOOTER 
                        ------------------------------------- */
                        table.footer-wrap { width: 100%;    clear:both!important;
                        }
                        .footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
                        .footer-wrap .container td.content p {
                            font-size:10px;
                            font-weight: bold;
                            
                        }


                        /* ------------------------------------- 
                                TYPOGRAPHY 
                        ------------------------------------- */
                        h1,h2,h3,h4,h5,h6 {
                        font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
                        }
                        h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

                        h1 { font-weight:200; font-size: 44px;}
                        h2 { font-weight:200; font-size: 37px;}
                        h3 { font-weight:500; font-size: 27px;}
                        h4 { font-weight:500; font-size: 23px;}
                        h5 { font-weight:900; font-size: 17px;}
                        h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

                        .collapse { margin:0!important;}

                        p, ul { 
                            margin-bottom: 10px; 
                            font-weight: normal; 
                            font-size:14px; 
                            line-height:1.6;
                        }
                        p.lead { font-size:17px; }
                        p.last { margin-bottom:0px;}

                        ul li {
                            margin-left:5px;
                            list-style-position: inside;
                        }

                        /* ------------------------------------- 
                                SIDEBAR 
                        ------------------------------------- */
                        ul.sidebar {
                            background:#ebebeb;
                            display:block;
                            list-style-type: none;
                        }
                        ul.sidebar li { display: block; margin:0;}
                        ul.sidebar li a {
                            text-decoration:none;
                            color: #666;
                            padding:10px 16px;
                        /*  font-weight:bold; */
                            margin-right:10px;
                        /*  text-align:center; */
                            cursor:pointer;
                            border-bottom: 1px solid #777777;
                            border-top: 1px solid #FFFFFF;
                            display:block;
                            margin:0;
                        }
                        ul.sidebar li a.last { border-bottom-width:0px;}
                        ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}




                        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                        .container {
                            display:block!important;
                            max-width:600px!important;
                            margin:0 auto!important; /* makes it centered */
                            clear:both!important;
                        }

                        /* This should also be a block element, so that it will fill 100% of the .container */
                        .content {
                            padding:15px;
                            max-width:600px;
                            margin:0 auto;
                            display:block; 
                        }

                        /* Lets make sure tables in the content area are 100% wide */
                        .content table {
                          width: 100%;
                          border-radius: 4px;
                        }


                        /* Odds and ends */
                        .column {
                            width: 300px;
                            float:left;
                        }
                        .column tr td { padding: 15px; }
                        .price tr td { padding: 15px; }
                        .row tr td { padding: 15px; }
                        .column-wrap { 
                            padding:0!important; 
                            margin:0 auto; 
                            max-width:600px!important;
                        }
                        .column table { width:100%;}
                        .social .column {
                            width: 280px;
                            min-width: 279px;
                            float:left;
                        }
                        .social .price {
                            width: 100%;
                            min-width: 279px;
                            text-align: center;
                            background: #e2e2e2;
                        }
                        .social .row {
                            width: 100%;
                            min-width: 279px;
                            background: #e2e2e2;
                        }

                        /* Be sure to place a .clear element after each set of columns, just to be safe */
                        .clear { display: block; clear: both; }


                        /* ------------------------------------------- 
                                PHONE
                                For clients that support media queries.
                                Nothing fancy. 
                        -------------------------------------------- */
                        @media only screen and (max-width: 600px) {

                            .spacertext{display: none;}
                            
                            a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

                            div[class="column"] { width: auto!important; float:none!important;}
                            
                            table.social div[class="column"] {
                                width:auto!important;
                            }

                        }
                        </style>

                        </head>
                         
                        <body bgcolor="#FFFFFF" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;-webkit-font-smoothing: antialiased;-webkit-text-size-adjust: none;height: 100%;width: 100%!important;">

                        <!-- HEADER -->
                        <table class="head-wrap" bgcolor="#999999" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;">
                            <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"></td>
                                <td class="header container" style="margin: 0 auto!important;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;display: block!important;max-width: 600px!important;clear: both!important;">
                                    
                                        <div class="content" style="margin: 0 auto;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;max-width: 600px;display: block;">
                                            <table bgcolor="#999999" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;border-radius: 4px;">
                                            <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"><h6 class="collapse" style="margin: 0!important;padding: 0;font-family: &quot;HelveticaNeue-Light&quot;, &quot;Helvetica Neue Light&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;line-height: 1.1;margin-bottom: 15px;color: #444;font-weight: 900;font-size: 14px;text-transform: uppercase;">Booking Title & REF:' . $title .'</h6></td>
                                                <td align="right" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"><h6 class="collapse" style="margin: 0!important;padding: 0;font-family: &quot;HelveticaNeue-Light&quot;, &quot;Helvetica Neue Light&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;line-height: 1.1;margin-bottom: 15px;color: #444;font-weight: 900;font-size: 14px;text-transform: uppercase;">Booking Confirmation</h6></td>
                                            </tr>
                                        </table>
                                        </div>
                                        
                                </td>
                                <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"></td>
                            </tr>
                        </table><!-- /HEADER -->


                        <!-- BODY -->
                        <table class="body-wrap" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;">
                            <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"></td>
                                <td class="container" bgcolor="#FFFFFF" style="margin: 0 auto!important;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;display: block!important;max-width: 600px!important;clear: both!important;">

                                    <div class="content" style="margin: 0 auto;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;max-width: 600px;display: block;">
                                    <table style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;border-radius: 4px;">
                                        <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                            <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                <p style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;"><img src="http://knoppys.co.uk/scpads/wp-content/plugins/scp-bookings/native/mail/scplogo.png" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;max-width: 100%;"></p><!-- /hero -->
                                                <h1 style="margin: 0;padding: 0;font-family: &quot;HelveticaNeue-Light&quot;, &quot;Helvetica Neue Light&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;line-height: 1.1;margin-bottom: 15px;color: #000;font-weight: 200;font-size: 44px;">Booking Confirmation</h1>
                                                <p class="lead" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 17px;line-height: 1.6;">Thank you for booking with Serviced City Pads. Please find below your booking confirmation.</p>
                                                <p class="lead" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 17px;line-height: 1.6;">Your booking is now the responsibility of the Apartment Operator. Please see below for Terms and Conditions and details regarding payment of the remaining balance.</p> 

                                                <table class="social" width="100%" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;background-color: #ebebeb;width: 100%;border-radius: 4px;">
                                                    <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                        <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                            <!--- column 1 -->
                                                            <table align="left" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;border-radius: 4px;min-width: 279px;">
                                                                <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                                    <td style="margin: 0;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"> 
                                                                        <h5 class="" style="margin: 0;padding: 0;font-family: &quot;HelveticaNeue-Light&quot;, &quot;Helvetica Neue Light&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;line-height: 1.1;margin-bottom: 15px;color: #000;font-weight: 900;font-size: 17px;">Apartment Details</h5>
                                                                        <p class="" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;"><strong style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">Apartment Name</strong><br style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">' . $apartmentname . '</p>
                                                                        <p class="" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;"><strong style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">Apartment Address</strong><br style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">' . $apartmentaddress . ',&nbsp;' . $aprtmentlocation . ',&nbsp;' . $aprtmentlocation2 . ',&nbsp;' . $apartmentstate . '<br/>' . $apartmentpostcode . '&nbsp;-&nbsp;' . $country . '</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>                                                   


                                                <table width="100%" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;border-radius: 4px;">
                                                    <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                        <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">                                 
                                                        </td>
                                                    </tr>
                                                </table>

                                                <table class="social" width="100%" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;background-color: #ebebeb;width: 100%;border-radius: 4px;">
                                                    <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                        <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                            <!--- column 1 -->
                                                            <table align="left" class="column" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 280px;float: left;border-radius: 4px;min-width: 279px;">
                                                                <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                                    <td style="margin: 0;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">      
    
                                                                        
                                                                        <h5 class="" style="margin: 0;padding: 0;font-family: &quot;HelveticaNeue-Light&quot;, &quot;Helvetica Neue Light&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;line-height: 1.1;margin-bottom: 15px;color: #000;font-weight: 900;font-size: 17px;">Booking Details</h5>
                                                                            
                                                                            <p class="" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;"><strong style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">Check-in date</strong><br style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">' . $arrivaldate . '&nbsp;(' . $theintime . ')</p>
                                                                            <p class="" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;"><strong style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">Length of stay</strong><br style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">' . $numberofnights . '</p>
                                                                            <p class="" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;"><strong style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">Apartment(s) description</strong><br style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">' . $apptbreakdown . '</p>           
                                                                        </td><td style="margin: 0;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">

                                                                </td></tr>
                                                            </table><!-- /column 1 -->  
                                                            <!--- column 1 -->
                                                            <table align="left" class="column" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 280px;float: left;border-radius: 4px;min-width: 279px;">
                                                                <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                                    <td style="margin: 0;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">      
                                                                        <h5 class="spacertext" style="margin: 0;padding: 0;font-family: &quot;HelveticaNeue-Light&quot;, &quot;Helvetica Neue Light&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;line-height: 1.1;margin-bottom: 15px;color: #ebebeb;font-weight: 900;font-size: 17px;">spacer</h5>
                                                                        <p class="" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;"><strong style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">Check-out date</strong><br style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">' . $leavingdate . '&nbsp;(' . $theouttime . ')</p>
                                                                        <p class="" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;"><strong style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">Number of guests</strong><br style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">' . $numberofguests . '</p>
                                                                        <p class="" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;"><strong style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">Number of apartments</strong><br style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">' . $numberofapts . '</p>            
                                                                    </td><td style="margin: 0;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                                </td></tr>
                                                            </table><!-- /column 1 -->  
                                                        </td>
                                                    </tr>
                                                </table>

                                                <table width="100%" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;border-radius: 4px;">
                                                    <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                        <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">                                 
                                                        </td>
                                                    </tr>
                                                </table>

                                                <table class="social" width="100%" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;background-color: #ebebeb;width: 100%;border-radius: 4px;">
                                                    <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                        <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                            <table align="left" class="column" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 280px;float: left;border-radius: 4px;min-width: 279px;">
                                                                <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                                    <td style="margin: 0;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">  
                                                                        <h5 style="margin: 0;padding: 0;font-family: &quot;HelveticaNeue-Light&quot;, &quot;Helvetica Neue Light&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;line-height: 1.1;margin-bottom: 15px;color: #000;font-weight: 900;font-size: 17px;">Guest Details</h5>
                                                                        <p class="" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;"><strong style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">Contact name: &nbsp;</strong>' . $guestname . '</p>
                                                                        <p class="" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;"><strong style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">Contact phone: &nbsp;</strong>' . $guestphone . '</p></p>
                                                                        <p class="" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;"><strong style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">Contact email: &nbsp;</strong><a href="mailto:' . $guestemail . '" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color: #2BA6CB;">Click to email</a></p>
                                                                    </td><td style="margin: 0;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                                </td></tr>
                                                            </table>
                                                            <table align="left" class="column" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 280px;float: left;border-radius: 4px;min-width: 279px;">
                                                                <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                                    <td style="margin: 0;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">  
                                                                        <h5 style="margin: 0;padding: 0;font-family: &quot;HelveticaNeue-Light&quot;, &quot;Helvetica Neue Light&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;line-height: 1.1;margin-bottom: 15px;color: #000;font-weight: 900;font-size: 17px;">Operator Details</h5>
                                                                        <p class="" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;"><strong style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">Operator Name: &nbsp;</strong>' . $operatorname . '</p>
                                                                        <p class="" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;"><strong style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">Operator phone: &nbsp;</strong>' . $operatorphone . '</p>
                                                                        <p class="" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;"><strong style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">Operator email: &nbsp;</strong><a href="mailto:' . $operatoremail . '" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color: #2BA6CB;">Click to email</a></p>
                                                                    </td><td style="margin: 0;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                                </td></tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>

                                                <table width="100%" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;border-radius: 4px;">
                                                    <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                        <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">                                 
                                                        </td>
                                                    </tr>
                                                </table>

                                               <table width="100%" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;border-radius: 4px;">
                                                    <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                        <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">                                 
                                                        </td>
                                                    </tr>
                                                </table>

                                                <table class="social" width="100%" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;background-color: #ebebeb;width: 100%;border-radius: 4px;">
                                                    <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                        <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                            <table align="left" class="row" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;border-radius: 4px;min-width: 279px;background: #e2e2e2;">
                                                                <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                                    <td width="100%" style="margin: 0;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"> 
                                                                        <p style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;">Thanks for using Serviced City Pads as your booking agent. We hope you have an enjoyable stay. </p>
                                                                        <p style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;">We have an extensive selection of serviced apartments located across the UK. Please visit www.servicedcitypads.com to see how we can help  you with your next stay.</p>
                                                                        <p style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;">If you have any comments or feedback about Serviced City Pads, please get in touch by e-mailing the Customer Service team at <a href="mailto:feedback@servicedcitypads.com">Email Us</a>.   </p>
                                                                    </td><td style="margin: 0;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                                </td></tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>

                                                <table width="100%" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;border-radius: 4px;">
                                                    <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                        <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">                                 
                                                        </td>
                                                    </tr>
                                                </table>

                                                <table class="social" width="100%" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;background-color: #ebebeb;width: 100%;border-radius: 4px;">
                                                    <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                        <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                            <table align="left" class="row" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;border-radius: 4px;min-width: 279px;background: #e2e2e2;">
                                                                <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                                    <td width="100%" style="margin: 0;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"> 
                                                                        
                                                                        <h5 style="margin: 0;padding: 0;font-family: &quot;HelveticaNeue-Light&quot;, &quot;Helvetica Neue Light&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;line-height: 1.1;margin-bottom: 15px;color: #000;font-weight: 900;font-size: 17px;">Arrival Process</h5>
                                                                        <p style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;">' . $arrivalprocess . '</p>
                                                                        <h5 style="margin: 0;padding: 0;font-family: &quot;HelveticaNeue-Light&quot;, &quot;Helvetica Neue Light&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;line-height: 1.1;margin-bottom: 15px;color: #000;font-weight: 900;font-size: 17px;">Operator Terms and Conditions</h5>
                                                                        <p style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;">' . $terms . '</p>
                                                                    </td><td style="margin: 0;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                                </td></tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>

                                                <table width="100%" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;border-radius: 4px;">
                                                    <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                        <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">                                 
                                                        </td>
                                                    </tr>
                                                </table>
                                                
                                                <!-- social & contact -->
                                                <table class="social" width="100%" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;background-color: #ebebeb;width: 100%;border-radius: 4px;">
                                                    <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                        <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                            
                                                            <!--- column 2 -->
                                                            <table align="left" class="column" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 280px;float: left;border-radius: 4px;min-width: 279px;">
                                                                <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                                    <td style="margin: 0;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">              
                                                                        
                                                                        <h5 class="" style="margin: 0;padding: 0;font-family: &quot;HelveticaNeue-Light&quot;, &quot;Helvetica Neue Light&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;line-height: 1.1;margin-bottom: 15px;color: #000;font-weight: 900;font-size: 17px;">Connect with Us:</h5>
                                                                        <p class="" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;"><a href="https://www.facebook.com/ServicedCityPadsApartments" class="soc-btn fb" style="margin: 0;padding: 3px 7px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color: #FFF;font-size: 12px;margin-bottom: 10px;text-decoration: none;font-weight: bold;display: block;text-align: center;background-color: #3B5998!important;">Facebook</a> <a href="https://twitter.com/CityPadTeam" class="soc-btn tw" style="margin: 0;padding: 3px 7px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color: #FFF;font-size: 12px;margin-bottom: 10px;text-decoration: none;font-weight: bold;display: block;text-align: center;background-color: #1daced!important;">Twitter</a> <a href="#" class="soc-btn gp" style="margin: 0;padding: 3px 7px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color: #FFF;font-size: 12px;margin-bottom: 10px;text-decoration: none;font-weight: bold;display: block;text-align: center;background-color: #DB4A39!important;">Google+</a></p>                      
                                                                        
                                                                    </td>
                                                                </tr>
                                                            </table><!-- /column 2 -->  
                                                            
                                                            <!--- column 2 -->
                                                            <table align="left" class="column" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 280px;float: left;border-radius: 4px;min-width: 279px;">
                                                                <tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
                                                                    <td style="margin: 0;padding: 15px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">              
                                                                                                    
                                                                        <h5 class="" style="margin: 0;padding: 0;font-family: &quot;HelveticaNeue-Light&quot;, &quot;Helvetica Neue Light&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;line-height: 1.1;margin-bottom: 15px;color: #000;font-weight: 900;font-size: 17px;">Contact Info:</h5>                                             
                                                                        <p style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;">Phone: <strong style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">0844 335 8866</strong><br style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">Email: <strong style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"><a href="mailto:adele@servicedcitypads.com" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color: #2BA6CB;">Adele Thompson <br style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"> Reservations & Bookings Manager</a></strong></p>
                                        
                                                                    </td>
                                                                </tr>
                                                            </table><!-- /column 2 -->
                                                
                                                            <span class="clear" style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;display: block;clear: both;"></span>   
                                                            
                                                        </td>
                                                    </tr>
                                                </table><!-- /social & contact -->

                                            </td>
                                        </tr>
                                    </table>
                                    </div>
                                                            
                                </td>
                                <td style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"></td>
                            </tr>
                        </table><!-- /BODY -->

                        </body>
                        </html>



            ';
            $subject = 'Booking Reminder ' . $title;
            $headers[] = 'From: Serviced City Pads';
            $headers[] = 'Bcc:' . $operatoremail;
            wp_mail( $to, $subject, $message, $headers);
                  
        } else {
            // do nothing
        }

}

add_action('wp_ajax_booking_confirmation_email', 'implement_ajax_email');
add_action('wp_ajax_nopriv_booking_confirmation_email', 'implement_ajax_email');


?>