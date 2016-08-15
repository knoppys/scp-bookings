<?php

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function downloadbutton_add_meta_box() {

    $screens = array( 'resellerp' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'downloadbutton_sectionid',
            __( 'Email Notifications', 'downloadbutton_textdomain' ),
            'downloadbutton_meta_box_callback',
            $screen,
            'side',
            'core'

        );
    }
}

add_action( 'add_meta_boxes', 'downloadbutton_add_meta_box' );




/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function downloadbutton_meta_box_callback( $post ) { 
  $current_user = wp_get_current_user();
  $useremail = $current_user->user_email;
  ?>
    
    <table cellpadding="0" cellspacing="0" border="0" class="bookings-admin">    
        <tbody>
            <tr>
                <td>               
                   
                   <!-- Location Table -->
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="bookings-aligntop container-table">
                       <tbody>
                            <tr><th><h2><i class="fa fa-map-envelope"></i>Reseller Download</h2></th></tr>
                            <tr>
                                <td>      
                                    <p>Download the reseller file here and ask them to upload it to the root folder of their website.</p> 
                                    <p>If the client requires hosting space, please ask them to upload this file to the root of their sub-domain</p>
                                    <a class="btn btn-primary" href="http://www.servicedcitypads.com/downloads/customerquery.zip" target="_blank">Download</a>      
                                    
                                </td>                               
                            </tr>
                       </tbody>
                    </table>                    

                </td>
            </tr>
        </tbody>
    </table>    

<?php } ?>