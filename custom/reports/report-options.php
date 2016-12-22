<?php
function clientreportsettings() {
    //register our settings
    register_setting( 'clientreportexclude-group', 'excludelist' );
}

function scp_bookings_options_page() {
?>
<div class="wrap">
<h2>Client Report options</h2>
<p>Select the Clients you wish to <strong>EXCLUDE</strong> from all Client Reports</p>

<form method="post" action="options.php" class="reportoptions">
    <?php 
    settings_fields( 'clientreportexclude-group' );
    do_settings_sections( 'clientreportexclude-group' );
    $options = get_option( 'excludelist' );  
    $i = 0;
    $args = array('post_type' => 'clients', 'posts_per_page' => -1, 'post_status' => 'ANY', 'orderby'=>'title', 'order'=>'ASC');
    $clients = get_posts($args); 
    ?>
    <div class="widefat">
    <?php foreach ( $clients as $client ) : setup_postdata( $post ); ?>
        <div class="item">
            <?php echo $client->post_title ?> 
            <input 
            class="iteminput"
            type='checkbox' 
            name='clientidfield'            
            value=''
            id="<?php echo $client->ID; ?>"> 
            <?php $i++; ?>
        </div>
    <?php endforeach; 
    wp_reset_postdata();    
    ?>    
    </div>
    <div class="widefat" style="display:block;">
    	<label>Excluded ID's</label>
    	<input type="text" name="excludelist" id="excludelist" value="<?php echo get_option( 'excludelist' ); ?>">
    </div>
    <?php submit_button(); ?>
</form>
</div>
<script type="text/javascript">
	
	jQuery(document).ready(function(){        

		jQuery('.iteminput').on('click', function(){
			const id = jQuery(this).attr('id');
            const inputValue = jQuery('input[type=text]').val();

            // Split the IDs into an array by comma.
            const currentIds = inputValue.split(',');

            if (currentIds.indexOf(id) === -1) {
                // ID has not yet been added to the input box.
                // We can add it to the array here, and
                // update it later.
                currentIds.push(id);
            } else {
                // ID is in the current list of IDs. We
                // can remove it like this:
                currentIds.splice(currentIds.indexOf(id), 1);
            }

            // Finally, we can reset the input string
            // with the new values we set above.
            jQuery('input[type=text]').val(currentIds.join(','));
		})
	});

    jQuery(document).ready(function(){
        jQuery('.iteminput').each(function(){
            var id = jQuery(this).attr('id');
            var inputValue = jQuery('input[type=text]').val();

            // Split the IDs into an array by comma.
            var currentIds = inputValue.split(',');

            if (currentIds.indexOf(id) === -1) {
                jQuery('.iteminput').prop('checked');
            }  

            console.log(id);

        });
    })

</script>
<?php } ?>