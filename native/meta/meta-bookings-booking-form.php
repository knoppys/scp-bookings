<?php

/**
Adds a Lead Guest Meta box to the Bookings Post Type
*/

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function bookingsteps_add_meta_box() {

    $screens = array( 'bookings' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'bookingsteps_sectionid',
            __( 'Booking', 'bookingsteps_textdomain' ),
            'bookingsteps_meta_box_callback',
            $screen,
            'advanced',
            'core'
        );

    }
}
add_action( 'add_meta_boxes', 'bookingsteps_add_meta_box' );


/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function bookingsteps_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'bookingsteps_meta_box', 'bookingsteps_meta_box_nonce' );

    //apartment details
    $apartmentname = get_post_meta( $post->ID, 'apartmentname', true );
    $numberofapts = get_post_meta($post->ID,'numberofapts', true );
    $numberofguests = get_post_meta($post->ID,'numberofguests', true );
    $apartments = get_posts(
            array(
                'post_type'   => 'apartments', 
                'orderby'     => 'title', 
                'order'       => 'ASC', 
                'numberposts' => -1 
            )
        );
    $locations = get_posts(
            array(
                'post_type'   => 'locations', 
                'orderby'     => 'title', 
                'order'       => 'ASC', 
                'numberposts' => -1 
            )
        );
    $welcomepacks = get_posts(
            array(
                'post_type'   => 'welcomepacks', 
                'orderby'     => 'title', 
                'order'       => 'ASC', 
                'numberposts' => -1 
            )
        );
    $operators = get_posts(
        array(
            'post_type'   => 'operators', 
            'orderby'     => 'title', 
            'order'       => 'ASC', 
            'numberposts' => -1 
        )
    ); 
    $clients = get_posts(
        array(
            'post_type'   => 'clients', 
            'orderby'     => 'title', 
            'order'       => 'ASC', 
            'numberposts' => -1 
        )
    );

    /*
     * Use get_post_meta() to retrieve an existing values
     * from the database and use the value for the form.
     */

    //lead guest details
    $guestname = get_post_meta( $post->ID, 'guestname', true );
    $phone = get_post_meta( $post->ID, 'phone', true);
    $email = get_post_meta( $post->ID, 'email', true);
    $guestage = get_post_meta( $post->ID, 'guestage', true);
    $guestsex = get_post_meta( $post->ID, 'guestsex', true);
    $refid = get_post_meta($post->ID, 'refid', true);

    //booking type
    $bookingtype = get_post_meta( $post->ID, 'bookingtype', true );


    //checkin details
    $checkintime = get_post_meta( $post->ID, 'checkintime', true );
    $checkouttime = get_post_meta( $post->ID, 'checkouttime', true );
    $actualcheckintime = get_post_meta( $post->ID, 'actualcheckintime', true );
    $actualcheckouttime = get_post_meta( $post->ID, 'actualcheckouttime', true );
    $leavingdate = get_post_meta( $post->ID, 'leavingdate', true );
    $arrivaldate = get_post_meta( $post->ID, 'arrivaldate', true );   
    $location = get_post_meta( $post->ID, 'location', true );
    $displayname = get_post_meta($post->ID, 'displayname', true);

    //pricing details
    $rentalprice = get_post_meta( $post->ID, 'rentalprice', true );
    $priceperperson = get_post_meta( $post->ID, 'priceperperson', true );
    $welcomepack = get_post_meta( $post->ID, 'welcomepack', true );
    $supplements = get_post_meta( $post->ID, 'supplements', true );
    $supplementsprice = get_post_meta( $post->ID, 'supplementsprice', true );
    $chargetype = get_post_meta( $post->ID, 'chargetype', true );
    $deposit = get_post_meta( $post->ID, 'deposit', true );
    $depositdate = get_post_meta( $post->ID, 'depositdate', true );
    $depositmethod = get_post_meta( $post->ID, 'depositmethod', true );
    $balancedue = get_post_meta( $post->ID, 'balancedue', true );
    $ownerprice = get_post_meta( $post->ID, 'ownerprice', true );
    $ourcommision = get_post_meta( $post->ID, 'ourcommision', true );
    $discount = get_post_meta( $post->ID, 'discount', true );
    $vatselect = get_post_meta( $post->ID, 'vatselect', true );
    $costcode = get_post_meta( $post->ID, 'costcode', true );
    $vatamount = get_post_meta( $post->ID, 'vatamount', true );
    $depositpaid = get_post_meta( $post->ID,'depositpaid', true);
    $balancepaid = get_post_meta( $post->ID,'balancepaid', true);
    $apartmentpaid = get_post_meta( $post->ID,'apartmentpaid', true);
    $balanceduedate = get_post_meta( $post->ID, 'balanceduedate', true );
    $apartmentduedate = get_post_meta( $post->ID, 'apartmentduedate', true );
    $totalcost = get_post_meta( $post->ID, 'totalcost', true );
    $customvatvalue = get_post_meta( $post->ID, 'customvatvalue', true );
    $username = get_post_meta($post->ID, 'username', true); 

    //Additional Notes Table
    $additionalnotes = get_post_meta( $post->ID, 'additionalnotes', true);
    $apptbreakdown = get_post_meta( $post->ID, 'apptbreakdown', true);

    $staffnotes = get_post_meta($post->ID, 'staffnotes', true);

    //Terms and Conditions Table
    $terms = get_post_meta( $post->ID, 'terms', true);

    $arrivalprocess = get_post_meta( $post->ID, 'arrivalprocess', true);
    $emergencycontact = get_post_meta( $post->ID, 'emergencycontact', true);

    //Operator details
    $operatorname = get_post_meta( $post->ID, 'operatorname', true );
    $operatoremail = get_post_meta( $post->ID, 'operatoremail', true);
    $operatorphone = get_post_meta( $post->ID, 'operatorphone', true);

    //client details
    $clientname = get_post_meta( $post->ID, 'clientname', true );
    $clientphone = get_post_meta($post->ID, 'clientphone', true);
    $clientemail = get_post_meta($post->ID, 'clientemail', true);


/**
Meta box Contents
*/
?>
 <table cellpadding="0" cellspacing="0" border="0" class="bookings-admin" >
     <tbody>
        <tr>
            <td>
                <?php 
                /********************************
                Booking Ref
                ********************************/ 
                ?>
                <h2>Booking Ref:                         
                    <?php 
                    if ($refid) {
                        echo $refid;
                        } else {
                            echo '<p> This booking does not have a ref yet, one will be created when you complete the form </p>';
                        }                            
                    ?>                         
                </h2> 

            </td>
        </tr>
        <tr>
            <td>


        
                <div id="booking-container">
                    <?php 
                    /********************************
                    Client Details
                    ********************************/ 
                    ?>
                    <h3>Client Details</h3>
                    <section>  
                    <table style="width:100%;">
                        <tr>
                            <td style="width:48%;">
                               <?php

                                //get the post status
                                $post_status = get_post_status( $post->id );                 
                                if ($post_status == 'auto-draft') { ?>

                                   
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                       <tbody>                                            
                                            <tr>
                                                <td colspan="2">
                                                    <?php
                                                    echo '<h4>';
                                                    _e( 'Select the Operator', 'bookingsoperator_textdomain' );
                                                    echo '</h4> ';
                                                    echo '<select class="widefat" id="operatorname" name="operatorname">';
                                                    echo '<option  value="' . esc_attr( $operatorname ) . '" size="25" />' . esc_attr( $operatorname ) . '</option>';
                                                        foreach ($operators as $operator) {
                                                            echo '<option value="' . $operator->post_title . '" size="25" />' . $operator->post_title . '</option>'; 
                                                        }                                        
                                                    echo "</select>";                                
                                                    ?>                                
                                                </td>
                                            </tr>
                                            <tr id="operatorajax">
                                                <!-- TO GO HERE -->
                                            </tr>
                                       </tbody>
                                    </table>

                                    <?php } else { ?>

                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tbody><tr>
                                                <td colspan="2">
                                                    <?php
                                                    echo '<h4>';
                                                    _e( 'Select the operator', 'bookingsoperator_textdomain' );
                                                    echo '</h4> ';
                                                    echo '<select class="widefat" id="operatorname" name="operatorname">';
                                                    echo '<option value="' . esc_attr( $operatorname ) . '" size="25" />' . esc_attr( $operatorname ) . '</option>';
                                                        foreach ($operators as $operator) {
                                                            echo '<option value="' . $operator->post_title . '" size="25" />' . $operator->post_title . '</option>'; 
                                                        }
                                                        
                                                    echo "</select>";
                                                    ?> 
                                                </td>
                                            </tr>                         

                                            <tr>
                                               <td>
                                                    <?php
                                                    //deposit date field
                                                    echo '<h4>';
                                                         _e( 'Operator Phone', 'bookingsrentalprice_textdomain' );
                                                    echo '</h4>';
                                                    echo '<input type="text" class="widefat" name="operatorphone" id="operatorphone" value="' . esc_attr( $operatorphone ) . '"/>';
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    //deposit date field
                                                    echo '<h4>';
                                                         _e( 'Operator Email', 'bookingsrentalprice_textdomain' );
                                                    echo '</h4>';
                                                    echo '<input type="text" class="widefat" name="operatoremail" id="operatoremail" value="' . esc_attr( $operatoremail ) . '"/>';

                                                    ?>
                                               </td>
                                            </tr>                              
                                             
                                        </tbody>
                                    </table>

                                <?php } ?> 
                            </td>
                            <td>
                               <?php

                                //get the post status
                                $post_status = get_post_status( $post->id );                 
                                if ($post_status == 'auto-draft') { ?>
                              
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tbody> <tr>
                                                <td colspan="2">
                                                    <?php
                                                    echo '<h4>';
                                                    _e( 'Select the client', 'bookingsclient_textdomain' );
                                                    echo '</h4> ';
                                                    echo '<select class="widefat" id="clientname" name="clientname">';        
                                                    echo '<option value="" size="25" />Select Client</option>';                             
                                                        foreach ($clients as $client) {
                                                            echo '<option value="' . $client->post_title . '" size="25" selected />' . $client->post_title . '</option>'; 
                                                        }
                                                        
                                                    echo "</select>";
                                                    ?> 
                                                </td>
                                            </tr>
                                           

                                            <tr id="clientajax">
                                                <!-- TO GO HERE -->
                                            </tr>                              
                                             
                                        </tbody>
                                </table>

                                <?php } else { ?>

                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                       <tbody>
                                            <tr>
                                                <td colspan="2">
                                                    <?php
                                                    echo '<h4>';
                                                    _e( 'Select the client', 'bookingsclient_textdomain' );
                                                    echo '</h4> ';
                                                    echo '<select class="widefat" id="clientname" name="clientname">';
                                                    echo '<option value="' . esc_attr( $clientname ) . '" size="25" />' . esc_attr( $clientname ) . '</option>';
                                                        foreach ($clients as $client) {
                                                            echo '<option value="' . $client->post_title . '" size="25" />' . $client->post_title . '</option>'; 
                                                        }
                                                        
                                                    echo "</select>";
                                                    ?> 
                                                </td>
                                            </tr>                         

                                            <tr>
                                               <td>
                                                    <?php
                                                    //deposit date field
                                                    echo '<h4>';
                                                         _e( 'Client Phone', 'bookingsrentalprice_textdomain' );
                                                    echo '</h4>';
                                                    echo '<input type="text" class="widefat" name="clientphone" id="clientphone" value="' . esc_attr( $clientphone ) . '"/>';
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    //deposit date field
                                                    echo '<h4>';
                                                         _e( 'Client Email', 'bookingsrentalprice_textdomain' );
                                                    echo '</h4>';
                                                    echo '<input type="text" class="widefat" name="clientemail" id="clientemail" value="' . esc_attr( $clientemail ) . '"/>';
                                                    ?>
                                               </td>
                                            </tr>                              
                                             
                                       </tbody>
                                </table>

                                <?php } ?>    
                            </td>
                        </tr>
                    </table> 
                   
                    </section>
                    


                    <?php 
                    /********************************
                    Apartment and Checkin
                    ********************************/ 
                    ?>
                    <h3>Apartment and Checkin</h3>
                    <section>             
                     <?php
                    echo '<h4>';
                    _e( 'Select Apartment', 'bookingsapartment_textdomain' );
                    echo '</h4> ';
                    echo '<select class="widefat" id="apartmentname" name="apartmentname">';                                
                    echo '<option value="' . esc_attr( $apartmentname ) . '" size="25" />' . esc_attr( $apartmentname ) . '</option>';
                        foreach ($apartments as $apartment) {
                            echo '<option value="' . $apartment->post_title . '" size="25" />' . $apartment->post_title . '</option>'; 
                        }
                    echo "</select>";
                    ?>
                    <?php
                    //Display name field
                    echo '<h4>';
                         _e( 'Apartment display name to client', 'bookingsrentalprice_textdomain' );
                    echo '</h4>';
                    echo '<input type="text" class="widefat" name="displayname" id="displayname" value="' . esc_attr( $displayname ) . '"/>';
                    ?>   
                    <?php
                    //booking type    
                    if ($bookingtype) {
                        $updatetext = '<span class="bookingupdate" style="color:red;display:none;"> >>> You have changed the booking type. Please update your booking</span>';
                    } else {
                        $updatetext = '';
                    }
                                                                    
                    echo '<h4>';
                        _e( 'Booking Type'.$updatetext, 'bookingscheckin_textdomain' );
                    echo '</h4>';
                    echo '<select class="widefat" id="bookingtype" name="bookingtype">'; 
                        echo '<option value="' . esc_attr( $bookingtype ) . '" size="25" />' . esc_attr( $bookingtype ) . '</option>';                          
                        echo '<option value="Corporate" size="25" />Corporate</option>';
                        echo '<option value="Groups" size="25" />Groups</option>';
                        echo '<option value="Leisure" size="25" />Leisure</option>';
                    echo "</select>";
                
                    ?> 
                    <table style="width:100%;">
                        <tr>                    
                            <td style="width:48%;">
                                                                 
                                <?php
                                //checkin field
                                echo '<h4>';
                                    _e( 'Number Of Apartments', 'bookingscheckin_textdomain' );
                                echo '</h4>';
                                echo '<input type="text" class="widefat" name="numberofapts" id="numberofapts" value="' . esc_attr( $numberofapts ) . '"/>';
                                ?> 
                                <?php
                                //location field                                
                                echo '<input type="hidden" class="widefat" name="location" id="location" value="' . esc_attr( $location ) . '"/>';
                                ?>                            
                                
                                <?php
                                //arriva field
                                echo '<h4>';
                                    _e( 'Checkin Date', '' );
                                echo '</h4>';
                                echo '<input type="text" class="widefat" name="arrivaldate" id="arrivaldate" value="' . esc_attr( $arrivaldate ) . '"/>';
                                ?>
                            </td>

                            <td style="width:50%;">
                              <?php
                                //checkin field
                                echo '<h4>';
                                    _e( 'Number Of Guests', 'bookingscheckin_textdomain' );
                                echo '</h4>';
                                echo '<input type="text" class="widefat" name="numberofguests" id="numberofguests" value="' . esc_attr( $numberofguests ) . '"/>';
                                ?>
                                <?php
                                //checkout field
                                echo '<h4>';
                                     _e( 'Checkout Date', 'leavingdate' );
                                echo '</h4>';
                                echo '<input type="text" class="widefat" name="leavingdate" id="leavingdate" value="' . esc_attr( $leavingdate ) . '"/>';

                                ?>
                            </td>
                        </tr>
                        <tr>                    
                            <td style="width:48%;">
                                <?php
                                //checkin field
                                echo '<h4>';
                                    _e( 'Checkin Time', 'bookingscheckin_textdomain' );
                                echo '</h4>';
                                echo '<input type="text" class="widefat upDate" name="checkintime" id="checkintime" value="' . esc_attr( $checkintime ) . '"/>';
                                ?>
                            </td>

                            <td style="width:50%;"> 
                                <?php
                                //checkout field
                                echo '<h4>';
                                     _e( 'Checkout Time', 'bookingscheckout_textdomain' );
                                echo '</h4>';
                                echo '<input type="text" class="widefat upDate" name="checkouttime" id="checkouttime" value="' . esc_attr( $checkouttime ) . '"/>';

                                ?>
                            </td>
                        </tr>
                         <tr>                    
                            <td style="width:48%;">
                                <?php
                                //checkin field
                                echo '<h4>';
                                    _e( 'Overide Checkin Time', 'bookingscheckin_textdomain' );
                                echo '</h4>';
                                echo '<input type="text" class="widefat upDate" name="actualcheckintime" id="actualcheckintime" value="' . esc_attr( $actualcheckintime ) . '"/>';
                                ?>
                            </td>

                            <td style="width:50%;">
                                <?php
                                //checkout field
                                echo '<h4>';
                                     _e( 'Overide Checkout Time', 'bookingscheckout_textdomain' );
                                echo '</h4>';
                                echo '<input type="text" class="widefat upDate" name="actualcheckouttime" id="actualcheckouttime" value="' . esc_attr( $actualcheckouttime ) . '"/>';

                                ?>
                            </td>
                        </tr>
                    </table>    
                    </section>

                    <?php 
                    /********************************
                    Guest Details
                    ********************************/ 
                    ?>
                    <h3>Guest Details</h3>
                    <section>
                         <table width="100%">
                                <tbody>
                                    <tr>
                                        <td width="33%">
                                            <?php
                                            //Name field
                                            echo '<h4>';
                                                _e( 'Guest Name', 'bookingscheckin_textdomain' );
                                            echo '</h4>';
                                            echo '<input type="text" class="widefat" name="guestname" id="guestname" value="' . esc_attr( $guestname ) . '"/>';
                                            ?>
                                        </td>
                                        <td width="33%">
                                             <?php
                                            //Phone field
                                            echo '<h4>';
                                                _e( 'Contact Email', 'bookingscheckin_textdomain' );
                                            echo '</h4>';
                                            echo '<input type="text" class="widefat" name="email" id="email" value="' . esc_attr( $email ) . '"/>';
                                            ?>
                                        </td>
                                        <td width="33%">
                                             <?php
                                            //Phone field
                                            echo '<h4>';
                                                _e( 'Contact Phone Number', 'bookingscheckin_textdomain' );
                                            echo '</h4>';
                                            echo '<input type="text" class="widefat" name="phone" id="phone" value="' . esc_attr( $phone ) . '"/>';
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table width="100%">
                                <tr>
                                    <td width="50%">
                                        <?php
                                        //Age field
                                        echo '<h4>';
                                            _e( 'Guest Age', 'bookingscheckin_textdomain' );
                                        echo '</h4>';
                                        echo '<input type="text" class="widefat" name="guestage" id="guestage" value="' . esc_attr( $guestage ) . '"/>';
                                        ?>
                                    </td>
                                    <td width="50%">
                                      <?php
                                      //Sex Field
                                        echo '<h4>';
                                        _e( 'Sex', 'bookingsapartment_textdomain' );
                                        echo '</h4> ';
                                        echo '<select class="widefat" id="guestsex" name="guestsex">';
                                        echo '<option value="' . esc_attr( $guestsex ) . '" size="25" />' . esc_attr( $guestsex ) . '</option>';
                                            echo '<option>Male</option>';
                                            echo '<option>Female</option>';
                                        echo "</select>";
                                        ?>
                                    </td>
                                </tr>
                            </table>
                    </section>

                    <?php 
                    /********************************
                    Party Details
                    ********************************/ 
                    ?>
                    <h3>Pricing and Payment</h3>
                        <section> 
                            <table style="width:100%">
                                <tr>                    
                                    <td style="width:48%;padding-right:2%;">
                                        <?php
                                        //rental price field
                                        echo '<h4>';
                                             _e( 'Corporate and Leisure Price Per Night (inc vat)', 'bookingsrentalprice_textdomain' );
                                        echo '</h4>';
                                        echo '<input type="text" class="widefat" name="rentalprice" id="rentalprice" value="' . esc_attr( $rentalprice ) . '"/>';
                                        ?>
                                        <?php
                                        //price per person field
                                        echo '<h4>';
                                             _e( 'Groups Price Per Person (inc vat)', 'bookingsrentalprice_textdomain' );
                                        echo '</h4>';
                                        echo '<input type="text" class="widefat" name="priceperperson" id="priceperperson" value="' . esc_attr( $priceperperson ) . '"/>';
                                        ?>                                                                          
                                        <?php
                                            echo '<h4>';
                                            _e( 'Welcome Pack', 'bookingsapartment_textdomain' );
                                            echo '</h4> ';
                                            echo '<select class="widefat" id="welcomepack" name="welcomepack">';
                                            echo '<option value="' . esc_attr( $welcomepack ) . '" size="25" />' . esc_attr( $welcomepack ) . '</option>';                                              
                                            foreach ($welcomepacks as $packoption) {
                                                echo '<option value="' . $packoption->post_title . '" size="25" />' . $packoption->post_title . '</option>'; 
                                            }

                                            echo "</select>";
                                        ?>
                                        <table style="width:100%">
                                            <tbody>
                                                <tr>
                                                    <td class="widefat" style="width:30%">
                                                        <?php
                                                        //supplements field
                                                        echo '<h4>';
                                                             _e( 'Supplements', 'bookingsrentalprice_textdomain' );
                                                        echo '</h4>';
                                                        echo '<input type="text" class="widefat" name="supplements" id="supplements" value="' . esc_attr( $supplements ) . '"/>';
                                                        ?> 
                                                    </td>
                                                    <td class="widefat" style="width:30%">
                                                        <?php
                                                        //supplements price field
                                                        echo '<h4>';
                                                             _e( 'Supplements Price', 'bookingsrentalprice_textdomain' );
                                                        echo '</h4>';
                                                        echo '<input type="text" class="widefat" name="supplementsprice" id="supplementsprice" value="' . esc_attr( $supplementsprice ) . '"/>';
                                                        ?>
                                                    </td>
                                                    <td class="widefat" style="width:30%">
                                                    <?php
                                                    echo '<h4>';
                                                    _e( 'Charge Nightly', 'bookingsapartment_textdomain' );
                                                    echo '</h4> ';
                                                    if ($chargetype) {
                                                        echo '<input type="checkbox" class="widefat" name="chargetype" id="chargetype" checked="checked" /><br>';
                                                    } else {
                                                        echo '<input type="checkbox" class="widefat" name="chargetype" id="chargetype" /><br>';
                                                    }                                            
                                                    ?>  
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>                                                                       
                                        <?php
                                        //deposit field
                                        echo '<h4>';
                                             _e( 'Deposit', 'bookingsrentalprice_textdomain' );
                                        echo '</h4>';
                                        echo '<input type="text" class="widefat" name="deposit" id="deposit" value="' . esc_attr( $deposit ) . '"/>';
                                        ?>                           
                                        <?php
                                        echo '<h4>';
                                        _e( 'Select Payment Type', 'bookingsapartment_textdomain' );
                                        echo '</h4> ';
                                        echo '<select class="widefat" id="depositmethod" name="depositmethod">';
                                        echo '<option value="' . esc_attr( $depositmethod ) . '" size="25" />' . esc_attr( $depositmethod ) . '</option>';
                                            echo '<option> Card </option>';
                                            echo '<option> Transfer </option>';
                                            echo '<option> Cash </option>';
                                        echo "</select>";
                                        ?>
                                        <?php
                                        //discount field
                                        echo '<h4>';
                                             _e( 'Discount', 'bookingsrentalprice_textdomain' );
                                        echo '</h4>';
                                        echo '<input type="text" class="widefat" name="discount" id="discount" value="' . esc_attr( $discount ) . '"/>';
                                        ?>                                        
                                        <?php
                                        echo '<h4>';
                                        _e( 'Select Vat Applicable (default is Yes + VAT)', 'bookingsapartment_textdomain' );
                                        echo '</h4> ';
                                        if ($vatselect) {
                                            echo '<input type="checkbox" name="vatselect" id="vatselect" checked="checked" /><br>';
                                        } else {
                                            echo '<input type="checkbox" name="vatselect" id="vatselect" /><br>';
                                        }
                                        
                                        ?>                
                                         <?php
                                        //custom vat field
                                        echo '<h4>';
                                             _e( 'Custom VAT %', 'bookingsrentalprice_textdomain' );
                                        echo '</h4>';
                                        echo '<input type="text" class="widefat" name="customvatvalue" id="customvatvalue" value="' . esc_attr( $customvatvalue ) . '"/>';
                                        ?>
                                        
                                    </td>
                                    <td id="showafterdeposit"style="width:50%;">      
                                         <table cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop container-table" width="100%">
                                            <tbody>                                
                                                <tr>
                                                    <td style="padding:20px;">
                                                        <?php
                                                        //balance due field
                                                        echo '<h4>';
                                                             _e( 'Balance Due', 'bookingsrentalprice_textdomain' );
                                                        echo '</h4>';
                                                        echo '<input type="text" class="widefat" name="balancedue" id="balancedue" value="' . esc_attr( $balancedue ) . '"/>';
                                                        ?>
                                                        <?php
                                                            echo '<h4>';
                                                             _e( 'Vat Amount', 'bookingsrentalprice_textdomain' );
                                                            echo '</h4>';
                                                            echo '<input type="text" class="widefat" name="vatamount" id="vatamount" value="' . esc_attr( $vatamount ) . '"/>';
                                                            ?>
                                                        <?php
                                                        //owner price field
                                                        echo '<h4>';
                                                             _e( 'Owner Price', 'bookingsrentalprice_textdomain' );
                                                        echo '</h4>';
                                                        echo '<input type="text" class="widefat" name="ownerprice" id="ownerprice" value="' . esc_attr( $ownerprice ) . '"/>';
                                                        ?>
                                                        <?php
                                                        //our commision field
                                                        echo '<h4>';
                                                             _e( 'Our Commision', 'bookingsrentalprice_textdomain' );
                                                        echo '</h4>';
                                                        echo '<input type="text" class="widefat" name="ourcommision" id="ourcommision" value="' . esc_attr( $ourcommision ) . '"/>';
                                                        ?>                            
                                                        <?php
                                                        //cost code field
                                                        echo '<h4>';
                                                             _e( 'Cost Code', 'bookingsrentalprice_textdomain' );
                                                        echo '</h4>';
                                                        echo '<input type="text" class="widefat" name="costcode" id="costcode" value="' . esc_attr( $costcode ) . '"/>';
                                                        ?>
                                                        <?php
                                                        //cost code field
                                                        echo '<h4>';
                                                             _e( 'Total Cost for <span id="numberofnights"></span>', 'bookingsrentalprice_textdomain' );
                                                        echo '</h4>';
                                                        echo '<input type="text" class="widefat" name="totalcost" id="totalcost" value="' . esc_attr( $totalcost ) . '"/>';
                                                        ?>
                                                        <input style="width:200px; display:block; margin:10px auto; text-align:center;" class="button button-primary button-large" id="calculate" value="Calculate" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                      
                                    </td>
                                </tr> 
                            </table> 
                            <table class="payments" style="width:100%;">
                                <tr>
                                    <td>
                                        <h4>Payment Information</h4>
                                    </td>
                                </tr>
                                 <tr> 
                                    <td>
                                        <?php
                                        //deposit date field
                                        echo '<label for="depositdate">';
                                             _e( 'Deposit Due Date', 'bookingsrentalprice_textdomain' );
                                        echo '</label>';
                                        echo '<input type="text" class="widefat" name="depositdate" id="depositdate" value="' . esc_attr( $depositdate ) . '"/>';
                                        ?>
                                       <?php
                                        echo '<label for="depositpaid">';
                                        _e( 'Deposit Paid', 'bookingsapartment_textdomain' );
                                        echo '</label> ';
                                        echo '<select class="widefat" id="depositpaid" name="depositpaid">';
                                        echo '<option value="' . esc_attr( $depositpaid ) . '" size="25" />' . esc_attr( $depositpaid ) . '</option>';
                                            echo '<option value="Yes"> Yes </option>';
                                            echo '<option value="No"> No </option>';
                                        echo "</select>";
                                        ?>
                                    </td> 
                                    <td>
                                        <?php
                                        //balance date field
                                        echo '<label for="balanceduedate">';
                                             _e( 'Balance Due Date', 'bookingsrentalprice_textdomain' );
                                        echo '</label>';
                                        echo '<input type="text" class="widefat" name="balanceduedate" id="balanceduedate" value="' . esc_attr( $balanceduedate ) . '"/>';
                                        ?>
                                         <?php
                                        echo '<label for="balancepaid">';
                                        _e( 'Balance Paid', 'bookingsapartment_textdomain' );
                                        echo '</label> ';
                                        echo '<select class="widefat" id="balancepaid" name="balancepaid">';
                                        echo '<option value="' . esc_attr( $balancepaid ) . '" size="25" />' . esc_attr( $balancepaid ) . '</option>';
                                           echo '<option value="Yes"> Yes </option>';
                                            echo '<option value="No"> No </option>';
                                        echo "</select>";
                                        ?>
                                        <input style="width:200px; display:block; margin:10px auto; text-align:center;" class="button button-primary button-large" id="recalculate" value="Recalculate" />
                                    </td>
                                    <td>
                                        <?php
                                        //apartment date field
                                        echo '<label for="apartmentduedate">';
                                             _e( 'Apartment Due Date', 'bookingsrentalprice_textdomain' );
                                        echo '</label>';
                                        echo '<input type="text" class="widefat" name="apartmentduedate" id="apartmentduedate" value="' . esc_attr( $apartmentduedate ) . '"/>';
                                        ?>
                                        <?php
                                        echo '<label for="apartmentpaid">';
                                        _e( 'Apartment Paid', 'bookingsapartment_textdomain' );
                                        echo '</label> ';
                                        echo '<select class="widefat" id="apartmentpaid" name="apartmentpaid">';
                                        echo '<option value="' . esc_attr( $apartmentpaid ) . '" size="25" />' . esc_attr( $apartmentpaid ) . '</option>';
                                            echo '<option value="Yes"> Yes </option>';
                                            echo '<option value="No"> No </option>';
                                        echo "</select>";
                                        ?>
                                    </td>
                                </tr>              
                            </table>                         
                        </section>

                    <?php 
                    /********************************
                    Additional Information 
                    ********************************/ 
                    ?>
                    <h3>Additional Information</h3>

                        <section>  
                        <table style="width:100%;">
                             <tr>                    
                                <td style="width:50%">
                                    <?php
                                    //additional notes field
                                    echo '<h4>';
                                         _e( 'Additional Notes', 'bookingsrentalprice_textdomain' );
                                    echo '</h4>';
                                    echo '<textarea contenteditable rows="5" class="widefat" name="additionalnotes" id="additionalnotes" />';
                                    echo esc_attr( $additionalnotes ); 
                                    echo '</textarea>';
                                    ?>
                                </td>
                                <td style="width:50%">
                                    <?php
                                    //apartment breakdown field
                                    echo '<h4>';
                                         _e( 'Apartment Breakdown', 'bookingsrentalprice_textdomain' );
                                    echo '</h4>';
                                    echo '<textarea contenteditable rows="5" class="widefat" name="apptbreakdown" id="apptbreakdown" />';
                                    echo esc_attr( $apptbreakdown ); 
                                    echo '</textarea>';
                                    ?>
                                </td>
                            </tr> 
                        </table>
                        <?php
                        //apartment breakdown field
                        echo '<h4>';
                             _e( 'Operator Terms', 'bookingsrentalprice_textdomain' );
                        echo '</h4>';
                        echo '<textarea rows="5" class="widefat terms contenteditable" name="terms" id="terms" /><div>';
                        echo esc_attr( $terms );
                        echo '</div></textarea>';
                        ?>      
                        <?php
                        //apartment breakdown field
                        echo '<h4>';
                             _e( 'Arrival Process', 'bookingsrentalprice_textdomain' );
                        echo '</h4>';
                        echo '<textarea rows="5" class="widefat arrivalprocess contenteditable" name="arrivalprocess" id="arrivalprocess" /><div>';
                        echo esc_attr( $arrivalprocess ); 
                        echo '</div></textarea>';
                        ?>                        
                        <?php
                        //apartment breakdown field
                        echo '<h4>';
                             _e( 'Emergency Contact', 'bookingsrentalprice_textdomain' );
                        echo '</h4>';
                        echo '<input type="text" class="widefat" name="emergencycontact" id="emergencycontact" value="' . esc_attr( $emergencycontact ) . '"/>';
                        ?>                  
                        </section>
                        <h3 class="staffnotes">Staff Notes</h3>
                        <section>
                            <?php
                            //apartment breakdown field
                            echo '<h4>';
                                 _e( 'Staff Notes', 'bookingsrentalprice_textdomain' );
                            echo '</h4>';
                            wp_editor($staffnotes, 'staffnotes', $settings = array('wpautop' => false));
                            ?>
                        </section>
   
                </div>

                <?php 
                    /********************************
                    Booking Confirmation
                    ********************************/ 
                    ?>
                    <table class="confirmationtable">
                        <tr>
                            <td>
                                <?php 
                    if ($refid) { ?>
                        <h2>Booking Confirmation</h2>
                           
                                <div id="accordion">
                                    <h3>Client Booking Confirmation</h3>
                                    <div>
                                        <?php
                                         //Check to see if there is a display name overide. 
                                            if ($displayname) {
                                                $titletext = $displayname;
                                            } else {
                                                $titletext = $apartmentname;
                                            }         
                                            

                                            //Check to see if there is a cost code
                                            if ($costcode) {
                                                $costcodetext = '<tr>
                                                                    <td style="width:250px;"valign="middle">
                                                                        <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Cost code</p></strong> 
                                                                    </td>
                                                                    <td style="width:250px;"valign="middle">  
                                                                       <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$costcode.'</p>                                          
                                                                    </td>
                                                                </tr>';
                                            } else {
                                                $costcodetext = '';
                                            }

                                            //Check to see if there are Supplements
                                            if (get_post_meta($post->id, 'supplements', true)) {
                                                $suplementtext   = '<tr>
                                                                        <td style="width:250px;"valign="middle">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Supplements</p></strong> 
                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$supplements.'</p>
                                                                        </td>
                                                                        <td style="width:250px;"valign="middle">  
                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">&pound;'.$Supplementsprice.'</p>                                          
                                                                        </td>
                                                                    </tr>';
                                            } else {
                                                $suplementtext   = '';
                                            }

                                            //Check to see if there is a discount
                                            if ($discount) {
                                                $discounttext   = '<tr>
                                                                        <td style="width:250px;"valign="middle">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Discount</p></strong> 
                                                                        </td>
                                                                        <td style="width:250px;"valign="middle">  
                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">&pound;'.$discount.'</p>                                          
                                                                        </td>
                                                                    </tr>';
                                            } else {
                                                $discounttext   = '';
                                            }


                                            /**
                                            HTML Email Elements
                                            */


                                            $apartmentnamee = get_post_meta( $post->ID, 'apartmentname', true );
                                            $page = get_page_by_title( $apartmentnamee, OBJECT, 'apartments');

                                            //get the apartment address details
                                            $apartmentaddress   = get_post_meta($page->ID,'address', true );            
                                            $aprtmentlocation   = get_post_meta($page->ID,'apptlocation1', true);
                                            $aprtmentlocation2  = get_post_meta($page->ID,'apptlocation2', true);
                                            $apartmentpostcode  = get_post_meta($page->ID,'postcode', true );
                                            $apartmentstate     = get_post_meta($page->ID,'state', true );
                                            $apartmentcountry   = get_post_meta($page->ID,'country', true ); 
                                            //get the location name
                                            $locationPage = get_page_by_title( $aprtmentlocation, OBJECT, 'locations' );
                                            //get the location meta
                                            $areainformation = get_post_meta( $locationPage->ID, 'areainformation', true );
                                            if ($areainformation) {
                                                $areainformationtext = '<tr>
                                                                            <td valign="top" colspan="2">
                                                                                <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Area Information</p></strong>                                                     
                                                                               <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$areainformation.'</p>                                          
                                                                            </td>
                                                                        </tr>';
                                            } else {
                                                $areainformationtext = '';
                                            }

                                            //get the number of nights
                                            $datetime1 = new DateTime($arrivaldate);
                                            $datetime2 = new DateTime($leavingdate);
                                            $interval = $datetime1->diff($datetime2);
                                            $numberofnights = $interval->format('%a nights');

                                            //Get the right nightly rate field
                                            if ($bookingtype == ('Corporate')) {
                                                $nightlyratetext = ($rentalprice);
                                            } else {
                                                $nightlyratetext = ($priceperperson);
                                            }

                                            //Get the right total cost field
                                            if ($bookingtype == ('Corporate')) {
                                                $totalcosttext = ($totalcost);
                                            } else {
                                                $totalcosttext = ($totalcost);
                                            }

                                            //Get the nightly rate label
                                            if ($bookingtype == ('Corporate')) {
                                                $ratelabel = 'Nightly Rate';
                                            } else {
                                                $ratelabel = 'Price per person, per night';
                                            }


                                            //the chekin time
                                            if ($actualcheckintime ) {
                                                $theintime = $actualcheckintime ;
                                            } else {
                                                $theintime = ($checkintime);
                                            }

                                            //the chekin time
                                            if ($actualcheckouttime) {
                                                $theouttime = $actualcheckouttime;
                                            } else {
                                                $theouttime = $checkouttime;
                                            }

                                            if ($bookingtype == 'Corporate') {
                                                $vatselecttext = ' &#43;VAT';
                                            } else {
                                                $vatselecttext = '';
                                            } 
                                                        
                                            /**
                                                Build the email
                                            **/ 
                                            echo ' 


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
                                                                            <h2 style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Booking Confirmation</h2>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- Welcome text -->                                    
                                                                    <tr>
                                                                        <td valign="top" colspan="2">
                                                                       <p style="margin:3px;border-bottom:1px solid #fff;"></p>
                                                                        <p></p>
                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Thank you for booking with Serviced City Pads. Please find below your booking confirmation.</p>

                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Please see below for Terms and Conditions and details regarding payment of the remaining balance.</p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <p></p>                            
                                                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                                                <tbody>                                   

                                                                    <!-- Apartment details -->
                                                                    <tr>
                                                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                                                           <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Apartment Details</p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:250px;"valign="top">                                            
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Apartment Name</p></strong>
                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">' . $titletext . '<br>
                                                                            <a target="_blank"href="'.$page->guid.'">View apartment information</a><br>
                                                                            <a href="https://www.google.co.uk/maps/place/'.$apartmentpostcode.'">Get directions</a>
                                                                            </p>


                                                                        </td>
                                                                        <td style="width:250px;"valign="top">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Apartment Address</p></strong>
                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">' . $apartmentaddress . '<br>' . $aprtmentlocation . '<br>' . $aprtmentlocation2 . '<br>' . $apartmentstate . '<br/>' . $apartmentpostcode . '&nbsp;' . $apartmentcountry . '</p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <p></p>

                                                            <!-- Booking details -->   
                                                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                                                <tbody>  
                                                                     <!-- Apartment details -->
                                                                    <tr>
                                                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                                                           <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Check-in Details</p>
                                                                        </td>
                                                                    </tr>                  
                                                                    <tr>
                                                                        <td style="width:250px;"valign="top">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Check-in Date</p></strong>
                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">' . $arrivaldate . '(' . $theintime . ')</p> 
                                                                        </td>
                                                                        <td style="width:250px;"valign="top">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Check-out Date</p></strong>
                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">' . $leavingdate . '(' . $theouttime . ')</p> 
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:250px;"valign="top">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Length of Stay</p></strong>
                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$numberofnights.'</p> 
                                                                        </td>
                                                                        <td style="width:250px;"valign="top">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Guests / Apartments</p></strong>
                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$numberofguests.'&nbsp; / &nbsp;'.$numberofapts.'</p> 
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td valign="top" colspan="1">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Apartment(s) Breakdown</p></strong>
                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$apptbreakdown.'</p> 
                                                                        </td>  
                                                                         <td valign="top" colspan="1">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Additional Notes</p></strong>
                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$additionalnotes.'</p> 
                                                                        </td>                                        
                                                                    </tr>
                                                                    '.$areainformationtext.'
                                                                    <tr>
                                                                        <!-- Guest Details -->
                                                                        <td style="width:250px;"valign="top">
                                                                            <h4 style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Guest Contact</h4>
                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$guestname.'</p> 
                                                                        </td>
                                                                         <!-- Client Details -->
                                                                        <td style="width:250px;"valign="top">
                                                                            <h4 style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Client Contact</h4>
                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$clientname.'</p> 
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <p></p>
                                                            <!-- Pricing -->
                                                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                                                <tbody>
                                                                    <!-- Apartment details -->
                                                                    <tr>
                                                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                                                           <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Price</p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:250px;"valign="middle" style="width:50%;">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$ratelabel.'</p></strong> 
                                                                        </td>
                                                                        <td style="width:250px;"valign="middle" style="width:50%;">  
                                                                           <p style=";font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">&pound;'. round($nightlyratetext, 2) . $vatselecttext .'</p>                                          
                                                                        </td>
                                                                    </tr>
                                                                    '.$discounttext.'
                                                                    '.$costcodetext.'
                                                                    '.$suplementtext.'
                                                                    <tr>
                                                                       <td style="width:250px;"valign="middle">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Total Cost</p></strong>
                                                                        </td>
                                                                        <td style="width:250px;"valign="middle">  
                                                                          <p style=";font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">&pound;'. round($totalcosttext, 2) . $vatselecttext .'</p>                                     
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>                           

                                                            <p></p>
                                                            <!-- Arrival Process -->
                                                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                                                <tbody>                                 
                                                                    <tr>
                                                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                                                           <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Arrival Process</p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>                                        
                                                                        <td valign="top" colspan="2">
                                                                           <div class="arrivalprocess" style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$arrivalprocess.'</div>    
                                                                            
                                                                        </td>
                                                                    </tr>                                  
                                                                </tbody>
                                                            </table>

                                                            <p></p>
                                                            <!--Terms -->
                                                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                                                           <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Terms and Conditions</p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>                                        
                                                                        <td valign="top" colspan="2">  
                                                                           <div class="terms" style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$terms.'</div>                                         
                                                                        </td>
                                                                    </tr>                                  
                                                                </tbody>
                                                            </table>

                                                            <p></p>
                                                            <!-- Thank you -->
                                                            <table style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                                                <tbody>
                                                                    <tr>                                        
                                                                        <td valign="top" colspan="2">
                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Thanks for using Serviced City Pads as your booking agent. We hope you have an enjoyable stay.</p>

                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">We have an extensive selection of serviced apartments located across the UK. Please visit www.servicedcitypads.com to see how we can help you with your next stay.</p>

                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">If you have any comments or feedback about Serviced City Pads, please get in touch by e-mailing the Customer Service team. </p>

                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Regards</p>

                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">'.$username.'</p>
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

                                            </table>';
                                        ?>
                                    </div>
                                    <h3>Operator Booking Confirmation</h3>
                                    <div>
                                        <?php
                                         //Check to see if there is a display name overide. 
                                            if ($displayname) {
                                                $titletext = $displayname;
                                            } else {
                                                $titletext = $apartmentname;
                                            }         
                                            

                                            //Check to see if there is a cost code
                                            if ($costcode) {
                                                $costcodetext = '<tr>
                                                                    <td style="width:250px;"valign="middle">
                                                                        <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Cost code</p></strong> 
                                                                    </td>
                                                                    <td style="width:250px;"valign="middle">  
                                                                       <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$costcode.'</p>                                          
                                                                    </td>
                                                                </tr>';
                                            } else {
                                                $costcodetext = '';
                                            }

                                            //Check to see if there are Supplements
                                            if (get_post_meta($post->id, 'supplements', true)) {
                                                $suplementtext   = '<tr>
                                                                        <td style="width:250px;"valign="middle">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Supplements</p></strong> 
                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$supplements.'</p>
                                                                        </td>
                                                                        <td style="width:250px;"valign="middle">  
                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">&pound;'.$Supplementsprice.'</p>                                          
                                                                        </td>
                                                                    </tr>';
                                            } else {
                                                $suplementtext   = '';
                                            }

                                            //Check to see if there is a discount
                                            if ($discount) {
                                                $discounttext   = '<tr>
                                                                        <td style="width:250px;"valign="middle">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Discount</p></strong> 
                                                                        </td>
                                                                        <td style="width:250px;"valign="middle">  
                                                                           <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">&pound;'.$discount.'</p>                                          
                                                                        </td>
                                                                    </tr>';
                                            } else {
                                                $discounttext   = '';
                                            }


                                            /**
                                            HTML Email Elements
                                            */


                                            //Get the apartment details
                                         

                                            //$apartmenttitle = get_post_meta($post->id, 'apartmentname', true);
                                            $apartmentnamef = get_post_meta( $post->ID, 'apartmentname', true );
                                            $pagf = get_page_by_title( $apartmentnamef, OBJECT, 'apartments');

                                            //get the apartment address details
                                            $apartmentaddress   = get_post_meta($pagf->ID,'address', true );            
                                            $aprtmentlocation   = get_post_meta($pagf->ID,'apptlocation1', true);
                                            $aprtmentlocation2  = get_post_meta($pagf->ID,'apptlocation2', true);
                                            $apartmentpostcode  = get_post_meta($pagf->ID,'postcode', true );
                                            $apartmentstate     = get_post_meta($pagf->ID,'state', true );
                                            $apartmentcountry   = get_post_meta($pagf->ID,'country', true ); 
                                            //get the location name
                                            $locationPage = get_page_by_title( $aprtmentlocation, OBJECT, 'locations' );
                                                //get the location meta
                                                $areainformation = get_post_meta( $locationPage->ID, 'areainformation', true );
                                                if ($areainformation) {
                                                    $areainformationtext = '<tr>
                                                                                <td valign="top" colspan="2">
                                                                                    <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Area Information</p></strong>                                                     
                                                                                   <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$areainformation.'</p>                                          
                                                                                </td>
                                                                            </tr>';
                                                } else {
                                                    $areainformationtext = '';
                                                }

                                                //get the number of nights
                                                $datetime1 = new DateTime($arrivaldate);
                                                $datetime2 = new DateTime($leavingdate);
                                                $interval = $datetime1->diff($datetime2);
                                                $numberofnights = $interval->format('%a nights');

                                                //Get the right nightly rate field
                                                if ($bookingtype == ('Corporate')) {
                                                    $nightlyratetext = ($rentalprice);
                                                } else {
                                                    $nightlyratetext = ($priceperperson);
                                                }

                                                //Get the right total cost field
                                                if ($bookingtype == ('Corporate')) {
                                                    $totalcosttext = ($totalcost);
                                                } else {
                                                    $totalcosttext = ($totalcost);
                                                }


                                                //the chekin time
                                                if ($actualcheckintime ) {
                                                    $theintime = $actualcheckintime ;
                                                } else {
                                                    $theintime = ($checkintime);
                                                }

                                                //the chekin time
                                                if ($actualcheckouttime) {
                                                    $theouttime = $actualcheckouttime;
                                                } else {
                                                    $theouttime = $checkouttime;
                                                }

                                                if ($bookingtype == 'Corporate') {
                                                    $vatselecttext = ' &#43;VAT';
                                                } else {
                                                    $vatselecttext = '';
                                                } 
                                            
                                              

                                        /**
                                            Build the email
                                        **/ 
                                        echo ' 


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
                                                                            <h2 style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Booking Confirmation</h2>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- Welcome text -->                                    
                                                                    <tr>
                                                                        <td valign="top" colspan="2">
                                                                        <p style="margin:3px;border-bottom:1px solid #fff;"></p>
                                                                        <p></p>
                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Thank you for booking with Serviced City Pads. Please find below your booking confirmation.</p>

                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Please see below for Terms and Conditions and details regarding payment of the remaining balance.</p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <p></p>                            
                                                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                                                <tbody>                                   

                                                                    <!-- Apartment details -->
                                                                    <tr>
                                                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                                                            <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Apartment Details</p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:250px;"valign="top">                                            
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Apartment Name</p></strong>
                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">' . $titletext . '<br>
                                                                             <a target="_blank"href="'.$page->guid.'">View apartment information</a><br>
                                                                            <a href="https://www.google.co.uk/maps/place/'.$apartmentpostcode.'">Get directions</a>
                                                                            </p>


                                                                        </td>
                                                                        <td style="width:250px;"valign="top">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Apartment Address</p></strong>
                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">' . $apartmentaddress . '<br>' . $aprtmentlocation . '<br>' . $aprtmentlocation2 . '<br>' . $apartmentstate . '<br/>' . $apartmentpostcode . '&nbsp;' . $apartmentcountry . '</p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <p></p>

                                                            <!-- Booking details -->   
                                                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                                                <tbody>  
                                                                     <!-- Apartment details -->
                                                                    <tr>
                                                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                                                            <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Check-in Details</p>
                                                                        </td>
                                                                    </tr>                  
                                                                    <tr>
                                                                        <td style="width:250px;"valign="top">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Check-in Date</p></strong>
                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">' . $arrivaldate . '(' . $theintime . ')</p> 
                                                                        </td>
                                                                        <td style="width:250px;"valign="top">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Check-out Date</p></strong>
                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">' . $leavingdate . '(' . $theouttime . ')</p> 
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:250px;"valign="top">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Length of Stay</p></strong>
                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$numberofnights.'</p> 
                                                                        </td>
                                                                        <td style="width:250px;"valign="top">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Guests / Apartments</p></strong>
                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$numberofguests.'&nbsp; / &nbsp;'.$numberofapts.'</p> 
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td valign="top" colspan="1">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Apartment(s) Breakdown</p></strong>
                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$apptbreakdown.'</p> 
                                                                        </td>  
                                                                         <td valign="top" colspan="1">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Additional Notes</p></strong>
                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$additionalnotes.'</p> 
                                                                        </td>                                        
                                                                    </tr>
                                                                    '.$areainformationtext.'
                                                                    <tr>
                                                                        <!-- Guest Details -->
                                                                        <td style="width:250px;"valign="top">
                                                                            <h4 style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Guest Contact</h4>
                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$guestname.'</p> 
                                                                        </td>
                                                                         <!-- Operator Details -->
                                                                        <td style="width:250px;"valign="top">
                                                                            <h4 style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Operator Contact</h4>
                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$operatorname.'</p> 
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <p></p>
                                                            <!-- Pricing -->
                                                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                                                <tbody>
                                                                    <!-- Apartment details -->
                                                                    <tr>
                                                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                                                           <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Price</p>
                                                                        </td>
                                                                    </tr>                                                            
                                                                    <tr>
                                                                       <td style="width:250px;"valign="middle">
                                                                            <strong><p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">Owner Price</p></strong>
                                                                        </td>
                                                                        <td style="width:250px;"valign="middle">  
                                                                          <p style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">&pound;'.$ownerprice.'</p>                                     
                                                                        </td>
                                                                    </tr>                                                                   
                                                                </tbody>
                                                            </table>                        

                                                            <p></p>
                                                            <!-- Arrival Process -->
                                                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                                                <tbody>                                 
                                                                    <tr>
                                                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                                                           <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Arrival Process</p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>                                        
                                                                        <td valign="top" colspan="2">
                                                                           <div class="arrivalprocess" style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$arrivalprocess.'</div>    
                                                                            
                                                                        </td>
                                                                    </tr>                                  
                                                                </tbody>
                                                            </table>

                                                            <p></p>
                                                            <!--Terms -->
                                                            <table style="background:#eee;border:1px solid #a2a2a2;border-radius:5px;margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="2" valign="middle" style="background:#d2d2d2;text-align:center;border-radius:4px;">
                                                                           <p style="margin:3px;padding:4px 0;font-size:15px;font-weight:bold;">Terms and Conditions</p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>                                        
                                                                        <td valign="top" colspan="2">  
                                                                           <div class="terms" style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#333;">'.$terms.'</div>                                         
                                                                        </td>
                                                                    </tr>                                  
                                                                </tbody>
                                                            </table>

                                                            <p></p>
                                                            <!-- Thank you -->
                                                            <table style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif; max-width:500px; width:100%">
                                                                <tbody>
                                                                    <tr>                                        
                                                                        <td valign="top" colspan="2">
                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Thanks for using Serviced City Pads as your booking agent. We hope you have an enjoyable stay.</p>

                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">We have an extensive selection of serviced apartments located across the UK. Please visit www.servicedcitypads.com to see how we can help you with your next stay.</p>

                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">If you have any comments or feedback about Serviced City Pads, please get in touch by e-mailing the Customer Service team. </p>

                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">Regards</p>

                                                                            <p style="margin:3px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;color:#fff;">'.$username.'</p>
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

                                            </table>';
                                        ?>
                                    </div>
                                </div>         
                            
                                <?php } else { ?>
                                    <h2>Booking Confirmation</h2>
                                        
                                            <p>You need to save your booking before viewing the booking confirmation.</p>                           
                                        
                                <?php } ?>
                            </td>
                        </tr>
                    </table>


       
            </td>
        </tr>
     </tbody>
 </table>

<?php    

}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function bookingsteps_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['bookingsteps_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['bookingsteps_meta_box_nonce'], 'bookingsteps_meta_box' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */
    
    // Make sure that it is set.
    if ( ! isset( $_POST['guestname'] ) ) {
        return;
    }

    // Sanitize user input.
    $mydata_apartmentname = ( $_POST['apartmentname'] );
    $mydata_numberofapts = sanitize_text_field( $_POST['numberofapts'] );
    $mydata_numberofguests = sanitize_text_field( $_POST['numberofguests'] );
    $mydata_checkintime = sanitize_text_field( $_POST['checkintime'] );
    $mydata_checkouttime = sanitize_text_field( $_POST['checkouttime'] );
    $mydata_actualcheckintime = sanitize_text_field( $_POST['actualcheckintime'] );
    $mydata_actualcheckouttime = sanitize_text_field( $_POST['actualcheckouttime'] );
    $mydata_rentalprice = sanitize_text_field( $_POST['rentalprice'] );
    $mydata_priceperperson = sanitize_text_field( $_POST['priceperperson'] );
    $mydata_supplements = sanitize_text_field( $_POST['supplements'] );
    $mydata_supplementsprice = sanitize_text_field( $_POST['supplementsprice'] );
    $mydata_chargetype = sanitize_text_field( $_POST['chargetype'] );
    $mydata_deposit = sanitize_text_field( $_POST['deposit'] );
    $mydata_depositdate = sanitize_text_field( $_POST['depositdate'] );
    $mydata_depositmethod = sanitize_text_field( $_POST['depositmethod'] );
    $mydata_balancedue = sanitize_text_field( $_POST['balancedue'] );
    $mydata_ownerprice = sanitize_text_field( $_POST['ownerprice'] );
    $mydata_ourcommision = sanitize_text_field( $_POST['ourcommision'] );
    $mydata_additionalnotes = sanitize_text_field( $_POST['additionalnotes'] );
    $mydata_apptbreakdown = sanitize_text_field( $_POST['apptbreakdown'] );
    $mydata_vatselect = sanitize_text_field( $_POST['vatselect'] );
    $mydata_costcode = sanitize_text_field( $_POST['costcode'] );
    $mydata_terms = ( $_POST['terms'] ); //removed sanitisation
    $mydata_emergencycontact = sanitize_text_field( $_POST['emergencycontact'] );
    $mydata_arrivaldate = sanitize_text_field( $_POST['arrivaldate'] );
    $mydata_leavingdate = sanitize_text_field( $_POST['leavingdate'] );
    $mydata_bookingtype = sanitize_text_field( $_POST['bookingtype'] );
    $mydata_discount = sanitize_text_field( $_POST['discount'] );
    $mydata_vatamount = sanitize_text_field( $_POST['vatamount'] );
    $mydata_depositpaid = sanitize_text_field( $_POST['depositpaid'] );
    $mydata_apartmentpaid = sanitize_text_field( $_POST['apartmentpaid'] );
    $mydata_balancepaid = sanitize_text_field( $_POST['balancepaid'] );
    $mydata_balanceduedate = sanitize_text_field( $_POST['balanceduedate'] );
    $mydata_apartmentduedate = sanitize_text_field( $_POST['apartmentduedate'] );
    $mydata_totalcost = sanitize_text_field( $_POST['totalcost'] );
    $mydata_location = sanitize_text_field( $_POST['location'] );
    $mydata_customvatvalue = sanitize_text_field( $_POST['customvatvalue'] );
    $mydata_welcomepack = sanitize_text_field( $_POST['welcomepack'] );
    $mydata_displayname = sanitize_text_field( $_POST['displayname'] );
    $mydata_username = sanitize_text_field( $_POST['username'] );
    $mydata_operatorname = sanitize_text_field( $_POST['operatorname'] );
    $mydata_operatoremail = sanitize_text_field( $_POST['operatoremail'] );
    $mydata_operatorphone = sanitize_text_field( $_POST['operatorphone'] );
    $mydata_clientname = sanitize_text_field( $_POST['clientname'] );
    $mydata_clientphone = sanitize_text_field( $_POST['clientphone'] );
    $mydata_clientemail = sanitize_text_field( $_POST['clientemail'] );
    $mydata_guestname = sanitize_text_field( $_POST['guestname'] );
    $mydata_phone = sanitize_text_field( $_POST['phone'] );
    $mydata_email = sanitize_text_field( $_POST['email'] );
    $mydata_guestage = sanitize_text_field( $_POST['guestage'] );
    $mydata_guestsex = sanitize_text_field( $_POST['guestsex'] );
    $mydata_arrivalprocess = ( $_POST['arrivalprocess'] ); //removed sanitisation



    // Update the meta field in the database.
    update_post_meta($post_id, 'arrivalprocess', $mydata_arrivalprocess);
    update_post_meta($post_id, 'apartmentname',$mydata_apartmentname);
    update_post_meta($post_id, 'numberofapts',$mydata_numberofapts);
    update_post_meta($post_id, 'numberofguests',$mydata_numberofguests);
    update_post_meta($post_id, 'checkintime',$mydata_checkintime);
    update_post_meta($post_id, 'checkouttime',$mydata_checkouttime);
    update_post_meta($post_id, 'actualcheckintime',$mydata_actualcheckintime);
    update_post_meta($post_id, 'actualcheckouttime',$mydata_actualcheckouttime);
    update_post_meta($post_id, 'rentalprice',$mydata_rentalprice);
    update_post_meta($post_id, 'priceperson',$mydata_priceperson);
    update_post_meta($post_id, 'supplements',$mydata_supplements);
    update_post_meta($post_id, 'supplementsprice',$mydata_supplementsprice);
    update_post_meta($post_id, 'chargetype',$mydata_chargetype);
    update_post_meta($post_id, 'deposit',$mydata_deposit);
    update_post_meta($post_id, 'depositdate',$mydata_depositdate);
    update_post_meta($post_id, 'depositmethod',$mydata_depositmethod);
    update_post_meta($post_id, 'balancedue',$mydata_balancedue);
    update_post_meta($post_id, 'ownerprice',$mydata_ownerprice);
    update_post_meta($post_id, 'ourcommision',$mydata_ourcommision);
    update_post_meta($post_id, 'additionalnotes',$mydata_additionalnotes);
    update_post_meta($post_id, 'apptbreakdown',$mydata_apptbreakdown);
    update_post_meta($post_id, 'vatselect',$mydata_vatselect);
    update_post_meta($post_id, 'costcode',$mydata_costcode);
    update_post_meta($post_id, 'terms',$mydata_terms);
    update_post_meta($post_id, 'emergencycontact',$mydata_emergencycontact);
    update_post_meta($post_id, 'arrivaldate',$mydata_arrivaldate);
    update_post_meta($post_id, 'leavingdate',$mydata_leavingdate);
    update_post_meta($post_id, 'bookingtype',$mydata_bookingtype);
    update_post_meta($post_id, 'discount',$mydata_discount);
    update_post_meta($post_id, 'vatamount',$mydata_vatamount);
    update_post_meta($post_id, 'depositpaid',$mydata_depositpaid);
    update_post_meta($post_id, 'apartmentpaid',$mydata_apartmentpaid);
    update_post_meta($post_id, 'balancepaid',$mydata_balancepaid);
    update_post_meta($post_id, 'balanceduedate',$mydata_balanceduedate);
    update_post_meta($post_id, 'apartmentduedate',$mydata_apartmentduedate);
    update_post_meta($post_id, 'totalcost',$mydata_totalcost);
    update_post_meta($post_id, 'location',$mydata_location);
    update_post_meta($post_id, 'customvatvalue',$mydata_customvatvalue);
    update_post_meta($post_id, 'welcomepack',$mydata_welcomepack);
    update_post_meta($post_id, 'displayname',$mydata_displayname);
    update_post_meta($post_id, 'username',$mydata_username);
    update_post_meta($post_id, 'operatorname',$mydata_operatorname);
    update_post_meta($post_id, 'operatoremail',$mydata_operatoremail);
    update_post_meta($post_id, 'operatorphone',$mydata_operatorphone);
    update_post_meta($post_id, 'clientname',$mydata_clientname);
    update_post_meta($post_id, 'clientphone',$mydata_clientphone);
    update_post_meta($post_id, 'clientemail',$mydata_clientemail);
    update_post_meta($post_id, 'guestname',$mydata_guestname);
    update_post_meta($post_id, 'phone',$mydata_phone);
    update_post_meta($post_id, 'email',$mydata_email);
    update_post_meta($post_id, 'guestage',$mydata_guestage);
    update_post_meta($post_id, 'guestsex',$mydata_guestsex);
    update_post_meta($post_id, 'priceperperson', $mydata_priceperperson);
    update_post_meta( $post_id, 'refid', get_the_id() );
    update_post_meta( $post_id, 'staffnotes', ($_POST['staffnotes']) );


    
}
add_action( 'save_post', 'bookingsteps_save_meta_box_data' );

?>