<?php
function apartment_options_page() {
?>
<div class="wrap">
<h2>Apartment Report Options</h2>
<p>Select the Apartments you wish to <strong>EXCLUDE</strong> from all apartment Reports</p>

<form method="post" action="options.php" class="reportoptions">
    <?php 
    settings_fields( 'apartmentreportexclude-group' );
    do_settings_sections( 'apartmentreportexclude-group' );
    $options = get_option( 'apartment-excludelist' );  
    $i = 0;
    $args = array('post_type' => 'apartments', 'posts_per_page' => -1, 'post_status' => 'ANY', 'orderby'=>'title', 'order'=>'ASC');
    $apartments = get_posts($args); 
    ?>
    <div class="widefat">
    <?php foreach ( $apartments as $apartment ) : setup_postdata( $post ); ?>
        <div class="item">
            <?php echo $apartment->post_title ?> 
            <input 
            class="iteminput"
            type='checkbox' 
            name='apartmentidfield'            
            value=''
            id="<?php echo $apartment->ID; ?>"> 
            <?php $i++; ?>
        </div>
    <?php endforeach; 
    wp_reset_postdata();    
    ?>    
    </div>
    <div class="widefat" style="display:none;">
    	<label>Excluded ID's</label>
    	<input type="text" name="apartment-excludelist" id="apartment-excludelist" value="<?php echo get_option( 'apartment-excludelist' ); ?>">
    </div>
     <div class="widefat">
        <?php submit_button(); ?>
    </div>
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
            var string = jQuery('input[type=text]').val();

            if (string.indexOf(id) >= 1) {
                jQuery('input#'+id).prop('checked', true);
            }  

            console.log(string);

        });
    })

</script>
<?php } ?>