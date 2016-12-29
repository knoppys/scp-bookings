<?php
function locationtypes_callback(){ ?>
	
	<script type="text/javascript">
		jQuery(document).ready(function(){
			var siteUrl = siteUrlobject.siteUrl;
			window.location.href = siteUrl+'/wp-admin/edit-tags.php?taxonomy=locationcategory';
		})
	</script>

<?php }