/********************
// Ajax send the client an email with all the download link etc
********************/
jQuery(document).ready(function(){
	jQuery('#sendreseller').click(function(){
		var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
		var email = jQuery('#resllerp_email').val(); 	


		jQuery(function(){
		    jQuery.ajax({
	            url:siteUrl,
	            type:'POST',
	            data:'action=sendreseller&email='+jQuery('#resellerp_email').val(),
	            success:function(result){
	            //got it done now let them know the result	            
	            jQuery('#scphs #addhere2').html('<i class="fa fa-check-circle"></i>');
				jQuery('#scphs input').val('<i class="fa fa-check-circle"></i>');
								
	            }
			});		
		});
	});
});