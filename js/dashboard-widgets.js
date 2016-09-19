
	/*******************************
	Search query for Top Operators
	*******************************/	
	jQuery('#leaderoperator-dash').click(function(){
		jQuery('.leaderdash-operator-div').show();
	});

	jQuery('#leaderoperator-dash').click(function() { 	
		var startdate = jQuery('#date19').val();
		var enddate = jQuery('#date20').val();

		jQuery(function(){
		    jQuery.ajax({
	            url:"http://www.servicedcitypads.com/wp-admin/admin-ajax.php",
	            type:'POST',
	            data:'action=topoperator&startdate=' + startdate +
	            '&enddate=' + enddate,          
	            success:function(result){
	            //got it back, now assign it to its fields. 	            	
	           	jQuery('.leaderdash-operator').html( result );
	           	jQuery('.pleasewait-operator').hide();
	           	jQuery('.leaderdash-operator').DataTable({"order": [[ 1, "desc" ]]});
	            //console.log(result);
	            	
	            }
			});		
		});
	});


	/*******************************
	Search query for Top Clients
	*******************************/
	jQuery('#leaderclient-dash').click(function(){
		jQuery('.leaderdash-client-div').show();
	});

	jQuery('#leaderclient-dash').click(function() { 	
		var startdate = jQuery('#date21').val();
		var enddate = jQuery('#date22').val();

		jQuery(function(){
		    jQuery.ajax({
	            url:"http://www.servicedcitypads.com/wp-admin/admin-ajax.php",
	            type:'POST',
	            data:'action=topclient&startdate=' + startdate +
	            '&enddate=' + enddate,          
	            success:function(result){
	            //got it back, now assign it to its fields. 	            	
	           	jQuery('.leaderdash-client').html( result );
	            //console.log(result);
	            jQuery(function(){
			            // this will hide all the rows that equal 0 spend.
					    var search = '£0';
					    jQuery(".leaderdash-client tr td").filter(function() {
					        return jQuery(this).text() == search;
					    }).parent('tr').hide();
					    jQuery('.pleasewait-client').hide();
	           			jQuery('.leaderdash-client').DataTable({"order": [[ 1, "desc" ]]});
		            });
				}		
			});	
		});	
	});


	/*******************************
	Search query for Top Apartments
	*******************************/
	jQuery('#leaderapartments-dash').click(function(){
		jQuery('.leaderdash-apartment-div').show();
	});

	jQuery('#leaderapartments-dash').click(function() { 	
		var startdate = jQuery('#date23').val();
		var enddate = jQuery('#date24').val();

		jQuery(function(){
		    jQuery.ajax({
	            url:"http://www.servicedcitypads.com/wp-admin/admin-ajax.php",
	            type:'POST',
	            data:'action=topapartmentswidget&startdate=' + startdate +
	            '&enddate=' + enddate,         
	            success:function(result){
	            //got it back, now assign it to its fields. 	            	
	           	jQuery('.leaderdash-apartment').html( result );
	            console.log(result);
		            jQuery(function(){
			            // this will hide all the rows that equal 0 spend.
					    var search = '£0';
					    jQuery(".leaderdash-apartment tr td").filter(function() {
					        return jQuery(this).text() == search;
					    }).parent('tr').hide();
					    jQuery('.pleasewait-apartment').hide();
	           			jQuery('.leaderdash-apartment').DataTable({"order": [[ 1, "desc" ]]});
		            });
				}		
			});	
		});	
	});