<?php
/**
Adds a Location Details Meta box to the Apartments Post Type
*/

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function emailbuttons_add_meta_box() {

    $screens = array( 'bookings' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'emailbuttons_sectionid',
            __( 'Email Notifications', 'emailbuttons_textdomain' ),
            'emailbuttons_meta_box_callback',
            $screen,
            'side',
            'core'

        );
    }
}

add_action( 'add_meta_boxes', 'emailbuttons_add_meta_box' );




/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function emailbuttons_meta_box_callback( $post ) { 
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
                            <tr><th><h2><i class="fa fa-map-envelope"></i>Email Notifications</h2></th></tr>
                            <tr>
                                <td>      
                                    <p>You and the accounts team will be included in the email.</p> 
                                    <p><?php echo $current_user->user_email; ?><br>bookings@citypadsmail.com</p>                            

                                   	<div class="email_button">
                                   		<input class="button button-primary button-large" id="email_client" value="Send to Client">
                                   	</div>
                                   	<div class="email_button">
                                   		<input class="button button-primary button-large" id="email_operator" value="Send to Operator">
                                   	</div>                                      
                                    <input id="useremail" type="hidden" value="<?php echo $useremail; ?>">      
                                    
                                </td>                               
                            </tr>
                       </tbody>
                    </table>                    

                </td>
            </tr>
        </tbody>
    </table>    

<?php } ?>