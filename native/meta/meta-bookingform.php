<?php

/**
Adds a Lead Guest Meta box to the Bookings Post Type
*/

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function bookingsteps2_add_meta_box() {

    $screens = array( 'bookings' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'bookingsteps2_sectionid',
            __( 'Booking', 'bookingsteps2_textdomain' ),
            'bookingsteps2_meta_box_callback',
            $screen,
            'advanced',
            'core'
        );

    }
}
add_action( 'add_meta_boxes', 'bookingsteps2_add_meta_box' );


/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function bookingsteps2_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'bookingsteps2_meta_box', 'bookingsteps2_meta_box_nonce' );
    add_filter( 'wp_default_editor', create_function('', 'return "tinymce";') );


    //get the post type objects for the drop down menus
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

    
    //***************************************
    // Run legacy functions 
    //***************************************

        //Legacy Rental Price
        $Priceperperson = get_post_meta( $post->ID, 'priceperperson', true );
        $Rentalprice = get_post_meta( $post->ID, 'rentalprice', true );

        if ($Priceperperson != NULL) {
            $rentalprice = $Priceperperson;
        } elseif ($Rentalprice != NULL) {
            $rentalprice = $Rentalprice;
        }

        //operatorrentalprice
        $oprentalprice = get_post_meta( $post->ID, 'oprentalprice', true );
        

    //get the booking as an OBJECT
        $booking = get_post_meta($post->ID);

    //dublin bookings price sybmol check
        $apartmentobject = get_page_by_title($booking['apartmentname'][0], OBJECT, 'apartments');
        $apartmentmeta = get_post_meta($apartmentobject->ID);
        if ( ($apartmentmeta['apptlocation1'][0] == 'Dublin') || $apartmentmeta['apptlocation2'][0] == 'Dublin' ) {
            $currency = '€';
        } else {
            $currency = '£';
        }
        


?>


<table class="widefat bookingsmeta" border-collapse="collapse">
    <tbody>
        <tr>
         <tr>
            <td>
                <?php 
                /********************************
                Booking Ref
                ********************************/ 
                ?>
                <h2>Booking Ref:                         
                    <?php 
                    if ($booking['refid'][0]) {
                        echo $booking['refid'][0];
                        } else {
                            echo '<p> This booking does not have a ref yet, one will be created when you complete the form </p>';
                        }                            
                    ?>                         
                </h2> 
                <input type="hidden" name="refid" id="refid" value="<?php echo $booking['refid'][0]; ?>">
            </td>
        </tr>
            <!-- Left Column Content -->
            <td width="40%">

                <!-- ***********************************
                Select the Operator
                *************************************-->
                <section>
                <h4 class="moduletitle">Operator Details</h4>
                    <?php if (get_post_status( $post->id ) == 'auto-draft') { ?>
                       <table cellpadding="0" cellspacing="0" border="0" width="100%">
                           <tbody>                                            
                                <tr>
                                    <td>
                                        <?php
                                        echo '<label>';
                                        _e( 'Select the Operator', 'bookingsoperator_textdomain' );
                                        echo '</label>';
                                        echo '<select class="widefat" id="operatorname" name="operatorname">';
                                        echo '<option  value="' . esc_attr( $booking['operatorname'][0] ) . '" size="25" />' . esc_attr( $booking['operatorname'][0] ) . '</option>';
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
                            <tbody>
                                <tr>
                                    <td>
                                        <?php
                                        echo '<label>';
                                        _e( 'Select the operator');
                                        echo '</label>';
                                        echo '<select class="widefat" id="operatorname" name="operatorname">';
                                        echo '<option  value="' . esc_attr( $booking['operatorname'][0] ) . '" size="25" />' . esc_attr( $booking['operatorname'][0] ) . '</option>';
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
                                        echo '<label>';
                                             _e( 'Operator Phone');
                                        echo '</label>';
                                        echo '<input type="text" class="widefat" name="operatorphone" id="operatorphone" value="' . esc_attr( $booking['operatorphone'][0] ) . '"/>';
                                        ?>
                                    </td>                        
                                </tr>   
                                <tr>
                                    <td>
                                        <?php
                                        //deposit date field
                                        echo '<label>';
                                             _e( 'Operator Email' );
                                        echo '</label>';
                                        echo '<input type="text" class="widefat" name="operatoremail" id="operatoremail" value="' . esc_attr( $booking['operatoremail'][0] ) . '"/>';
                                        ?>
                                   </td>
                                </tr>                         
                            </tbody>
                        </table>

                    <?php } ?>
                </section>

                <!-- ***********************************
                Select the Client
                *************************************-->
                <section>
                <h4 class="moduletitle">Client Details</h4>
                    <?php if (get_post_status( $post->id ) == 'auto-draft') { ?>
                   <table cellpadding="0" cellspacing="0" border="0" width="100%">
                       <tbody>                                            
                            <tr>
                                <td>
                                    <?php
                                    echo '<label>';
                                    _e( 'Select the Client');
                                    echo '</label>';
                                    echo '<select class="widefat" id="clientname" name="clientname">';
                                    echo '<option  value="' . esc_attr( $booking['clientname'][0] ) . '" size="25" />' . esc_attr( $booking['clientname'][0] ) . '</option>';
                                        foreach ($clients as $client) {
                                            echo '<option value="' . $client->post_title . '" size="25" />' . $client->post_title . '</option>'; 
                                        }                                        
                                    echo "</select>";                                
                                    ?>                                
                                </td>
                            </tr>
                            <tr id="clientajax">
                                <!-- TO GO HERE -->
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    //deposit date field
                                    echo '<label>';
                                         _e( 'Cost Code' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="costcode" id="costcode" value="' . esc_attr( $booking['costcode'][0] ) . '"/>';
                                    ?>
                               </td>
                            </tr>    
                       </tbody>
                    </table>

                    <?php } else { ?>

                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <?php
                                    echo '<label>';
                                    _e( 'Select the Client');
                                    echo '</label>';
                                    echo '<select class="widefat" id="clientname" name="clientname">';
                                    echo '<option  value="' . esc_attr( $booking['clientname'][0] ) . '" size="25" />' . esc_attr( $booking['clientname'][0] ) . '</option>';
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
                                    echo '<label>';
                                         _e( 'Client Phone');
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="clientphone" id="clientphone" value="' . esc_attr( $booking['clientphone'][0] ) . '"/>';
                                    ?>
                                </td>                        
                            </tr>   
                            <tr>
                                <td>
                                    <?php
                                    //deposit date field
                                    echo '<label>';
                                         _e( 'Client Email' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="clientemail" id="clientemail" value="' . esc_attr( $booking['clientemail'][0] ) . '"/>';
                                    ?>
                               </td>
                            </tr> 
                            <tr>
                                <td>
                                    <?php
                                    //deposit date field
                                    echo '<label>';
                                         _e( 'Cost Code' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="costcode" id="costcode" value="' . esc_attr( $booking['costcode'][0] ) . '"/>';
                                    ?>
                               </td>
                            </tr>                         
                        </tbody>
                    </table>

                <?php } ?>
               </section>              

                <!-- ***********************************
                Select the Apartment and fire booking type function
                *************************************-->
               <section>
               <h4 class="moduletitle">Apartment Details</h4>                   
                   <table cellspacing="0" cellpadding="0" class="" width="100%" border-collapse="collapse">
                       <tbody>
                           <tr>    
                               <td>
                                   <?php
                                    echo '<label>';
                                    _e( 'Select the Apartment');
                                    echo '</label>';
                                    echo '<select class="widefat" id="apartmentname" name="apartmentname">';                                
                                    echo '<option value="' . esc_attr( $booking['apartmentname'][0] ) . '" size="25" />' . esc_attr( $booking['apartmentname'][0] ) . '</option>';
                                        foreach ($apartments as $apartment) {
                                            echo '<option value="' . $apartment->post_title . '" size="25" />' . $apartment->post_title . '</option>'; 
                                        }
                                    echo "</select>";                           
                                    ?> 
                               </td>
                           </tr>
                           <tr>    
                               <td>
                                   <?php
                                     echo '<label>';
                                    _e( 'Display As');
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="displayname" id="displayname" value="' . esc_attr( $booking['displayname'][0] ) . '"/>';
                                    ?>   
                               </td>
                           </tr>
                           <tr>
                               <td>
                                   <?php
                                    echo '<label>';
                                    _e( 'Booking Type');
                                    echo '</label>';
                                    echo '<select class="widefat" id="bookingtype" name="bookingtype">'; 
                                        echo '<option value="' . esc_attr( $booking['bookingtype'][0] ) . '" size="25" />' . esc_attr( $booking['bookingtype'][0] ) . '</option>';
                                        echo '<option value="Corporate" size="25" />Corporate</option>';
                                        echo '<option value="Groups" size="25" />Groups</option>';
                                        echo '<option value="Leisure" size="25" />Leisure</option>';
                                    echo "</select>";
                                   ?>
                               </td>
                           </tr>  
                           <tr>
                               <td>
                                    <?php
                                    echo '<label>';
                                         _e( 'Emergency Contact', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="emergencycontact" id="emergencycontact" value="' . esc_attr( $emergencycontact ) . '"/>';
                                    ?> 
                               </td>
                           </tr>                       
                        </tbody>
                   </table>                   
                </section>

                <!-- ***********************************
                Number of apartments and guests
                *************************************-->
                <section>
                <h4 class="moduletitle">Checkin Details</h4>
                    <table cellspacing="0" cellpadding="0" class="" width="100%" border-collapse="collapse">
                        <tbody>
                            <tr>
                                <td>
                                    <tr>
                                       <td colspan="2">
                                            <?php                                    
                                            echo '<label>';
                                            _e( 'Number of Guests');
                                            echo '</label>';
                                            echo '<input type="text" class="widefat" name="numberofguests" id="numberofguests" value="' . esc_attr( $booking['numberofguests'][0] ) . '"/>';?>                                            
                                       </td>
                                    </tr>
                                    <tr>
                                    <td>
                                        <?php
                                        echo '<label>';
                                             _e( 'Supplements (no. of)');
                                        echo '</label>';
                                        echo '<input type="text" class="widefat" name="supplements" id="supplements" value="' . esc_attr( $booking['supplements'][0] ) . '"/>';
                                        ?> 
                                    </td>
                                     <td>
                                        <?php
                                        echo '<label>';
                                        _e( 'Charge Nightly');
                                        echo '</label> ';
                                        if ($booking['chargetype'][0]) {
                                            echo '<input type="checkbox" class="widefat" name="chargetype" id="chargetype" checked="checked" /><br>';
                                        } else {
                                            echo '<input type="checkbox" class="widefat" name="chargetype" id="chargetype" /><br>';
                                        }                                            
                                        ?>  
                                    </td>
                                </tr>
                                    <tr>
                                        <td colspan="2">
                                            <?php                                    
                                            echo '<label>';
                                            _e( 'Number of Apartments');
                                            echo '</label>';
                                            echo '<input type="text" class="widefat" name="numberofapts" id="numberofapts" value="' . esc_attr( $booking['numberofapts'][0] ) . '"/>';
                                            echo '<input type="hidden" class="widefat" name="location" id="location" value="' . esc_attr( $booking['location'][0] ) . '"/>';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                       <td>
                                           <?php
                                            echo '<label>';
                                                _e( 'Checkin Date');
                                            echo '</label>';
                                            echo '<input type="text" class="widefat" name="arrivaldate" id="arrivaldate" value="' . esc_attr( $booking['arrivaldate'][0] ) . '"/>';
                                            ?>
                                       </td>
                                       <td>
                                            <?php                                           
                                            echo '<label>';
                                                 _e( 'Checkin Time', 'bookingscheckout_textdomain' );
                                            echo '</label>';
                                            echo '<input type="text" class="widefat upDate" name="checkintime" id="checkintime" value="' . esc_attr( $booking['checkintime'][0] ) . '"/>';
                                            ?>
                                       </td>
                                    </tr>                                    
                                    <tr>
                                        <td>
                                           <?php
                                            echo '<label>';
                                                _e( 'Checkout Date');
                                            echo '</label>';
                                            echo '<input type="text" class="widefat" name="leavingdate" id="leavingdate" value="' . esc_attr( $booking['leavingdate'][0] ) . '"/>';
                                            ?>
                                        </td>
                                        <td>
                                            <?php                                           
                                            echo '<label>';
                                                 _e( 'Checkout Time', 'bookingscheckout_textdomain' );
                                            echo '</label>';
                                            echo '<input type="text" class="widefat upDate" name="checkouttime" id="checkouttime" value="' . esc_attr( $booking['checkouttime'][0] ) . '"/>';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                         <td colspan="2">
                                           <?php
                                            echo '<label>';
                                                _e( 'Number of nights');
                                            echo '</label>';
                                            echo '<input type="text" class="widefat" name="numberofnights" id="numberofnights" value="' . esc_attr( $booking['numberofnights'][0] ) . '"/>';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <?php
                                                echo '<label>';
                                                _e( 'Welcome Pack');
                                                echo '</label> ';
                                                echo '<select class="widefat" id="welcomepack" name="welcomepack">';
                                                echo '<option value="' . esc_attr( $booking['welcomepack'][0] ) . '" size="25" />' . esc_attr( $booking['welcomepack'][0] ) . '</option>';                                              
                                                foreach ($welcomepacks as $packoption) {
                                                    echo '<option value="' . $packoption->post_title . '" size="25" />' . $packoption->post_title . '</option>'; 
                                                }
                                                echo "</select>";
                                            ?>
                                        </td>
                                    </tr>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>


                <!-- ***********************************
                Guest Details
                *************************************-->
                <section>
                <h4 class="moduletitle">Guest Details</h4>
                    <table cellspacing="0" cellpadding="0" class="" width="100%" border-collapse="collapse">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <?php
                                    echo '<label>';
                                        _e( 'Guest Name');
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="guestname" id="guestname" value="' . esc_attr( $booking['guestname'][0] ) . '"/>';
                                    ?>
                                </td>                                
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    echo '<label>';
                                        _e( 'Contact Email');
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="email" id="email" value="' . esc_attr( $booking['email'][0] ) . '"/>';
                                    ?>
                                </td>
                                 <td>
                                    <?php
                                    echo '<label>';
                                        _e( 'Contact Number');
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="contactnumber" id="contactnumber" value="' . esc_attr( $booking['contactnumber'][0] ) . '"/>';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    echo '<label>';
                                        _e( 'Guest Age');
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="guestage" id="guestage" value="' . esc_attr( $booking['guestage'][0] ) . '"/>';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo '<label>';
                                        _e( 'Guest Sex');
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="guestsex" id="guestsex" value="' . esc_attr( $booking['guestsex'][0] ) . '"/>';
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>


               
            <!-- Left Column Ends -->                
            </td>
            


            <!-- Right Column Content -->
            <td>
                <!-- ***********************************
                Pricing
                *************************************-->
                <center>                
                    <section class="pricing">
                    <h4 class="moduletitle">Pricing Details</h4>
                        <table class="" border-collapse="collapse" style="margin-bottom: 20px;" width="75%" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <?php echo '<p><strong>Corporate Booking:</strong> Please enter Price Per Night <br> <strong>Groups or Leisure Booking:</strong> Please enter Price Per Person</p>'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php
                                        echo '<label>';
                                             _e( 'Client Price');
                                        echo '</label>';                                      
                                        echo '<span style="display:inline;width:2%;font-weight:bold;line-height:1.5;font-size:18px;">'.$currency.'</span><input type="text" class="widefat" style="width:90%;float:right;display:inline;" name="rentalprice" id="rentalprice" value="' . esc_attr( $booking['rentalprice'][0] ) . '"/>';
                                        ?>
                                    </td>                                
                                    <td>
                                        <?php
                                        echo '<label>';
                                             _e( 'Operator Price');
                                        echo '</label>';                                     
                                        echo '<span style="display:inline;width:2%;font-weight:bold;line-height:1.5;font-size:18px;">'.$currency.'</span><input type="text" class="widefat" style="width:90%;float:right;display:inline;" name="oprentalprice" id="oprentalprice" value="' . esc_attr( $booking['oprentalprice'][0] ) . '"/>';
                                        ?>
                                    </td>
                                </tr>                              
                                <tr>
                                    <td>
                                        <?php
                                        echo '<label>';
                                             _e( 'Supplements Price to Client' );
                                        echo '</label>';
                                        echo '<span style="display:inline;width:2%;font-weight:bold;line-height:1.5;font-size:18px;">'.$currency.'</span><input type="text" class="widefat" style="width:90%;float:right;display:inline;"  name="supplementsprice" id="supplementsprice" value="' . esc_attr( $booking['supplementsprice'][0] ) . '"/>';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo '<label>';
                                             _e( 'Supplements Price to Operator' );
                                        echo '</label>';
                                        echo '<span style="display:inline;width:2%;font-weight:bold;line-height:1.5;font-size:18px;">'.$currency.'</span><input type="text" class="widefat" style="width:90%;float:right;display:inline;"  name="opsupplementsprice" id="opsupplementsprice" value="' . esc_attr( $booking['opsupplementsprice'][0] ) . '"/>';
                                        ?>
                                    </td>                                   
                                </tr>                                
                                <tr>
                                    <td colspan="2">
                                        <?php
                                        echo '<label>';
                                        _e( 'Select Payment Type');
                                        echo '</label> ';
                                        echo '<select class="widefat" id="depositmethod" name="depositmethod">';
                                        echo '<option value="' . esc_attr( $booking['depositmethod'][0] ) . '" size="25" />' . esc_attr( $booking['depositmethod'][0] ) . '</option>';
                                            echo '<option> Card </option>';
                                            echo '<option> Transfer </option>';
                                            echo '<option> Cash </option>';
                                        echo "</select>";
                                        ?>
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <table cellspacing="0" cellpadding="0" class="" width="75%" border-collapse="collapse">
                         <h4 class="moduletitle">Totals</h4>
                            <tbody>
                                <tr>
                                    <td>
                                       <label>Deposit</label>
                                    </td>
                                    <td>
                                        <?php echo '<span style="display:inline;width:2%;font-weight:bold;line-height:1.5;font-size:18px;">'.$currency.'</span><input type="text" class="widefat" style="width:90%;float:right;display:inline;" name="deposit" id="deposit" value="' . esc_attr( $booking['deposit'][0] ) . '"/>'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Discount</label>
                                    </td>
                                     <td>
                                        <?php echo '<span style="display:inline;width:2%;font-weight:bold;line-height:1.5;font-size:18px;">'.$currency.'</span><input type="text" class="widefat" style="width:90%;float:right;display:inline;" name="discount" id="discount" value="' . esc_attr( $booking['discount'][0] ) . '"/>'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Operator Total</label>
                                    </td>
                                    <td>
                                        <?php echo '<span style="display:inline;width:2%;font-weight:bold;line-height:1.5;font-size:18px;">'.$currency.'</span><input type="text" class="widefat" style="width:90%;float:right;display:inline;" name="ownerprice" id="ownerprice" value="' . esc_attr( $booking['ownerprice'][0] ) . '"/>'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Client Total</label>
                                    </td>
                                    <td>
                                         <?php echo '<span style="display:inline;width:2%;font-weight:bold;line-height:1.5;font-size:18px;">'.$currency.'</span><input type="text" class="widefat" style="width:90%;float:right;display:inline;" name="totalcost" id="totalcost" value="' . esc_attr( $booking['totalcost'][0] ) . '"/>'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="40%">
                                        
                                    </td>
                                    <td align="right"> 
                                        <table width="100%">
                                            <tbody>
                                                <tr>
                                                    <td style="padding-top:20px;">
                                                        <label>Show as inc VAT</label>
                                                    </td>
                                                    <td style="padding-top:20px;">
                                                        <?php
                                                        if ( $booking['incvat'][0] == '1' ) { 
                                                            echo '<input type="checkbox" class="widefat" name="incvat" id="incvat" checked="checked" />'; } 
                                                        else { 
                                                            echo '<input type="checkbox" class="widefat" name="incvat" id="incvat" />'; 
                                                        }                                           
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <input style="display:block; margin:10px auto; text-align:center;" class="button" id="calculate" value="Calculate" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>                                                                          
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                </center>

                <section>
                     <table cellspacing="0" cellpadding="0" class="" width="100%" border-collapse="collapse">
                         <h4 class="moduletitle">Additional Information</h4>
                        <tbody>
                            <tr>
                                <td>
                                    <?php
                                    echo '<label>';
                                         _e( 'Additional Notes');
                                    echo '</label>';
                                    wp_editor($booking['additionalnotes'][0], 'additionalnotes', $settings = array('wpautop' => false, 'textarea_rows' => 5));
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    echo '<label>';
                                         _e( 'Apartment Breakdown');
                                    echo '</label>';
                                    wp_editor($booking['apptbreakdown'][0], 'apptbreakdown', $settings = array('wpautop' => false, 'textarea_rows' => 5));
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    echo '<label>';
                                         _e( 'Arrival Process');
                                    echo '</label>';                                   
                                    wp_editor($booking['arrivalprocess'][0], 'arrivalprocess', $settings = array('wpautop' => false, 'textarea_rows' => 5));
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    echo '<label>';
                                         _e( 'Operator Terms');
                                    echo '</label>';
                                    
                                    wp_editor($booking['terms'][0], 'terms', $settings = array('wpautop' => false, 'textarea_rows' => 5));
                                    ?>  
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    echo '<label>';
                                         _e( 'Staff Notes');
                                    echo '</label>';
                                    wp_editor($booking['staffnotes'][0], 'staffnotes', $settings = array('wpautop' => false, 'textarea_rows' => 5));
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                <section>
                    <?php 
                    /********************************
                    Booking Confirmation
                    ********************************/ 
                    ?>

                    <table class="confirmationtable">
                        <h4 class="moduletitle">Email Notifications
                            <div class="module-title-menu">
                                <input class="button" id="email_operator" value="Send to Operator">
                                <input class="button" id="email_client" value="Send to Client">
                                <input class="button" id="email_arrival" value="Send Arrival Email">
                            </div>
                        </h4>
                        <tr>
                            <td>
                                <?php 
                                    if ($booking['refid'][0]) { ?>
                                    <div id="accordion">
                                    <h3>
                                        Client Booking Confirmation
                                        <?php                                        
                                        if ($booking['clientAmendment'][0]) {
                                            echo '<div class="amend-input">Check for Amendment<input type="checkbox" class="widefat" name="clientAmendment" id="clientAmendment" checked="checked" /><br></div>';
                                           } else {
                                            echo '<div class="amend-input">Check for Amendment<input type="checkbox" class="widefat" name="clientAmendment" id="clientAmendment" /><br></div>';
                                            }                                            
                                        ?> 
                                    </h3>
                                    <div>
                                        <?php  echo clientemail($booking['refid'][0]); ?>
                                    </div>
                                    <h3>
                                        Operator Booking Confirmation
                                        <?php                                        
                                        if ($booking['operatorAmendment'][0]) {
                                            echo '<div class="amend-input">Check for Amendment<input type="checkbox" class="widefat" name="operatorAmendment" id="operatorAmendment" checked="checked" /><br></div>';
                                        } else {
                                            echo '<div class="amend-input">Check for Amendment<input type="checkbox" class="widefat" name="operatorAmendment" id="operatorAmendment" /><br></div>';
                                        }                                            
                                        ?> 
                                    </h3>
                                    <div>
                                        <?php  echo operatoremail($booking['refid'][0]); ?>
                                    </div>
                                    <h3>Arrival Process Email</h3>
                                    <div>
                                        <?php  echo arrivalemail($booking['refid'][0]); ?>
                                    </div>
                                </div> 
                                <input id="useremail" type="hidden" value="<?php echo $useremail; ?>">         
                            
                                <?php } else { ?>
                                    <h2>Booking Confirmation</h2>        
                                    <p>You need to save your booking before viewing the booking confirmation.</p>                          
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </section>
            <!-- Right Column Ends -->
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
function bookingsteps2_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['bookingsteps2_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['bookingsteps2_meta_box_nonce'], 'bookingsteps2_meta_box' ) ) {
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
    $mydata_oprentalprice = sanitize_text_field( $_POST['oprentalprice'] );
    $mydata_priceperperson = sanitize_text_field( $_POST['priceperperson'] );
    $mydata_supplements = sanitize_text_field( $_POST['supplements'] );
    $mydata_supplementsprice = sanitize_text_field( $_POST['supplementsprice'] );
    $mydata_opsupplementsprice = sanitize_text_field( $_POST['opsupplementsprice'] );
    $mydata_chargetype = sanitize_text_field( $_POST['chargetype'] );
    $mydata_incvat = $_POST['incvat'] ? true : false;
    $mydata_deposit = sanitize_text_field( $_POST['deposit'] );
    $mydata_depositdate = sanitize_text_field( $_POST['depositdate'] );
    $mydata_depositmethod = sanitize_text_field( $_POST['depositmethod'] );
    $mydata_balancedue = sanitize_text_field( $_POST['balancedue'] );
    $mydata_ownerprice = sanitize_text_field( $_POST['ownerprice'] );
    $mydata_ourcommision = sanitize_text_field( $_POST['ourcommision'] );    
    $mydata_costcode = sanitize_text_field( $_POST['costcode'] );    
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
    $mydata_contactnumber = sanitize_text_field( $_POST['contactnumber'] );
    $mydata_numberofnights = sanitize_text_field( $_POST['numberofnights'] );
    $mydata_clientAmendment = sanitize_text_field( $_POST['clientAmendment'] );
    $mydata_operatorAmendment = sanitize_text_field( $_POST['operatorAmendment'] );

    $mydata_arrivalprocess = ( $_POST['arrivalprocess'] ); 
    $mydata_terms = ( $_POST['terms'] ); 
    $mydata_additionalnotes = ( $_POST['additionalnotes'] );
    $mydata_apptbreakdown = ( $_POST['apptbreakdown'] );



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
    update_post_meta($post_id, 'oprentalprice',$mydata_oprentalprice);
    update_post_meta($post_id, 'priceperson',$mydata_priceperson);
    update_post_meta($post_id, 'supplements',$mydata_supplements);
    update_post_meta($post_id, 'supplementsprice',$mydata_supplementsprice);
    update_post_meta($post_id, 'opsupplementsprice',$mydata_opsupplementsprice);
    update_post_meta($post_id, 'chargetype',$mydata_chargetype);
    update_post_meta($post_id, 'incvat',$mydata_incvat);
    update_post_meta($post_id, 'deposit',$mydata_deposit);
    update_post_meta($post_id, 'depositdate',$mydata_depositdate);
    update_post_meta($post_id, 'depositmethod',$mydata_depositmethod);
    update_post_meta($post_id, 'balancedue',$mydata_balancedue);
    update_post_meta($post_id, 'ownerprice',$mydata_ownerprice);
    update_post_meta($post_id, 'ourcommision',$mydata_ourcommision);
    update_post_meta($post_id, 'additionalnotes',$mydata_additionalnotes);
    update_post_meta($post_id, 'apptbreakdown',$mydata_apptbreakdown);
    //update_post_meta($post_id, 'vatselect',$mydata_vatselect);
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
    update_post_meta($post_id, 'contactnumber', $mydata_contactnumber);
    update_post_meta($post_id, 'numberofnights', $mydata_numberofnights);
    update_post_meta( $post_id, 'refid', get_the_ID() );
    update_post_meta( $post_id, 'staffnotes', ($_POST['staffnotes']) );
    update_post_meta($post_id, 'clientAmendment',$mydata_clientAmendment);
    update_post_meta($post_id, 'operatorAmendment',$mydata_operatorAmendment);

    
}
add_action( 'save_post', 'bookingsteps2_save_meta_box_data' );

?>