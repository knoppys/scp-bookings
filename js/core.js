/********************
* This file contains all the jQuery required to run the plugin
* Please backup this file before making changes
* Version 1
********************/


jQuery(document).ready(function(){
	var loading = jQuery('#loadingDiv').hide();
	jQuery(document)
	.ajaxStart(function () {
		loading.show();
	})
	.ajaxStop(function () {
	loading.hide();
	});
});


jQuery(document).ready(function(){ 
    jQuery('.upload_image_button').click(function(){ 
    var textfieldid = jQuery(this).prev().attr("id"); 
    wp.media.editor.send.attachment = function(props, attachment){jQuery('#' + textfieldid).val(attachment.url);}
    wp.media.editor.open(this);
    return false;         
  });   
});

jQuery(document).ready(function(){

	//start date for search query
	jQuery('#startdate').datetimepicker({																								
		timepicker: false,
		format:'d.m.Y'
	});

	//end date for search query
	jQuery('#enddate').datetimepicker({																								
		timepicker: false,
		format:'d.m.Y'
	});

	//Actual booking check out time
	jQuery('#date1').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Actual booking check out time
	jQuery('#date2').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//up coming Bookings Report
	jQuery('#date12').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//up coming Bookings Report
	jQuery('#date11').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//up coming payments Report
	jQuery('#date13').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//up coming payments Report
	jQuery('#date14').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Client Report
	jQuery('#date15').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Client Report
	jQuery('#date16').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Operator Report
	jQuery('#date17').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Operator Report
	jQuery('#date18').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Operator Report
	jQuery('#date19').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Operator Report
	jQuery('#date20').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Client Report
	jQuery('#date21').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Client Report
	jQuery('#date22').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Locations Report
	jQuery('#date23').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Locations Report
	jQuery('#date24').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Apartments Report
	jQuery('#date25').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Apartments Report
	jQuery('#date26').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Apartments Report
	jQuery('#leavingdate').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	
	//Tabs for apartment terms and conditions
    jQuery( "#tabs" ).tabs();
    jQuery( "#pricing-tabs" ).tabs();

});


jQuery(document).ready(function(){
    jQuery('.dashboard_widget').DataTable({
        "order": [[ 1, "desc" ]],
        "autoWidth": false
        
    });
})

jQuery(document).ready(function() {
	jQuery.fn.dataTable.moment( 'DD.MM.YYYY' );
    jQuery.fn.dataTable.moment( 'DD.MM.YY' );

    jQuery('.bookingstable').DataTable({
        "order": [[ 7, "desc" ]],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],	        
	    "iDisplayLength": -1	        
    });

    jQuery('.accountstable').DataTable({
        "order": [[ 1, "desc" ]],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],	        
	    "iDisplayLength": -1	        
    });
});
jQuery(document).ready(function(){
	jQuery ("#booking-container").steps({
	    headerTag: "h3",
	    bodyTag: "section",
	    transitionEffect: "slideLeft",
	    autoFocus: true,
	    enableAllSteps: true,
		enablePagination: false,
		autoFocus: true
	});
})

jQuery(document).ready(function(){
	jQuery('#accordion').accordion({
		active: false,
		collapsible: true,
		autoHeight: false,
		heightStyle: "content" 
	});
	jQuery('#accordion h3 input').on('click', function(e){
		e.stopPropagation();
	})
});
	


jQuery(document).ready(function(){
	jQuery('#arrivaldate').datetimepicker({
		format:'d.m.Y',
		timepicker: false
	})	
	jQuery('#leavingdate').datetimepicker({
		format:'d.m.Y',
		timepicker: false
	})	
	jQuery('#actualcheckintime').datetimepicker({
		format:'H:i',
		datepicker: false,
		timepicker: true
	})	
	jQuery('#actualcheckouttime').datetimepicker({
  		format:'H:i',
  		datepicker: false,
		timepicker: true
	})
	jQuery('#apptchekintime').datetimepicker({
		format:'H:i',
		datepicker: false,
		timepicker: true
	})	
	jQuery('#apptchekouttime').datetimepicker({
		format:'H:i',
		datepicker: false,
		timepicker: true
	})	
	jQuery('#apartmentduedate').datetimepicker({
		format:'d.m.Y',
		timepicker: false
	})
	jQuery('#balanceduedate').datetimepicker({
		format:'d.m.Y',
		timepicker: false
	})
	jQuery('#depositdate').datetimepicker({
		format:'d.m.Y',
		timepicker: false
	})
})


jQuery(document).ready(function(){
	jQuery('#bookingtype').change(function(){
		//If the booking type is Corporate then mark the booking as +VAT
		var bookingtype = jQuery('#bookingtype').val();	
		console.log(bookingtype);
		if (bookingtype == 'Groups' ) {
			jQuery('#incvat').prop('checked', true);
		} else {
			jQuery('#incvat').prop('checked', false);
		}
	})
})

/********************
// Ajax auto populate booking fields
********************/																																																																																																																																																																																																																																																																													


jQuery(document).ready(function(){
		jQuery('#bookingtype').change(function() {

		jQuery('span.bookingupdate').show();
		//get the data i need	
		var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
		var bookingtype = jQuery('#bookingtype').val();				
		var apartmentname = jQuery('#apartmentname').val();	
		var startdate = jQuery('#arrivaldate').val();
		var enddate = jQuery('#leavingdate').val();

		//got the data, make the ajax request
		jQuery(function(){
		    jQuery.ajax({
	            url: siteUrl,
	            type:'POST',
	            data:'action=my_special_action&apartmentname=' + apartmentname + 
	            '&bookingtype=' + bookingtype +
	            '&startdate=' + startdate +
	            '&enddate=' + enddate,
	            dataType:'json',
	            success:function(data){
	            	
	            	//got it back, now assign it to its fields. 	            	
	            	jQuery('#checkintime').val(data.checkintime);
	            	jQuery('#checkouttime').val(data.checkouttime);
	            	jQuery('#ownerprice').val(data.ownerprice);	
	            	jQuery('#emergencycontact').val(data.emergencycontact);
	            	
	            	jQuery('#numberofnights').val(data.nights);
	            	tinyMCE.get('terms').setContent(data.terms);
	            	tinyMCE.get('arrivalprocess').setContent(data.arrivalprocess);	            	
					
					console.log(data);

				}
			});
		});
	});
})

/********************
// Ajax populate the hidden location field. This is hidden for the benefit of recording location data against a booking
********************/																																																																																																																																																																																																																																																																											

jQuery(document).ready(function(){
	
		jQuery('#apartmentname').change(function() {
		//get the data i need	
		var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
		var apartmentname = jQuery('#apartmentname').val();					
		//got the data, make the ajax request
		jQuery(function(){
		    jQuery.ajax({
	            url:siteUrl,
	            type:'POST',
	            data:'action=getlocation&apartmentname=' + apartmentname,	            
	            success:function(data){
	            	//got it back, now assign it to its fields. 	            	
	            	jQuery('#location').val(data);
	            	//console.log(data);
	            	//alert(data);
	            }
			});
		});
	});

})

/********************
// Ajax auto populate booking vat rate field
********************/						


jQuery(document).ready(function(){
	jQuery('#calculate').click(function() {

	jQuery('#chargetype').on('click', function () {
	    jQuery(this).val(this.checked ? true : false);	    
	});

	jQuery('#incvat').on('click', function () {
	    jQuery(this).val(this.checked ? true : false);	    
	});
		
	//get the data i need	
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var arrivaldate = jQuery('#arrivaldate').val();	
	var leavingdate = jQuery('#leavingdate').val();
	var actualcheckintime = jQuery('#actualcheckintime').val();	
	var actualcheckouttime = jQuery('#actualcheckouttime').val();
	var rentalprice = jQuery('#rentalprice').val();	
	var bookingtype = jQuery('#bookingtype').val();
	var deposit = jQuery('#deposit').val();
	var supplementsprice = jQuery('#supplementsprice').val();
	var supplements = jQuery('#supplements').val();
	if (jQuery('#chargetype').prop('checked')==true) {var chargetype = 'true'} else {var chargetype = 'false'}
	if (jQuery('#incvat').prop('checked')==true) {var incvat = 'true'} else {var incvat = 'false'}
	var numberofguests = jQuery('#numberofguests').val();	
	var discount = jQuery('#discount').val();
	var oprentalprice = jQuery('#oprentalprice').val();
	var opsupplementsprice = jQuery('#opsupplementsprice').val();
	var numberofnights = jQuery('#numberofnights').val();

    	//got the data, make the ajax request
		jQuery(function(){
		    jQuery.ajax({
	            url:siteUrl,
	            type:'POST',
	            data:'action=my_special_vataction&arrivaldate=' + arrivaldate + 
	            '&leavingdate=' + leavingdate + 
	            '&actualcheckintime=' + actualcheckintime + 
	            '&actualcheckouttime=' + actualcheckouttime + 
	            '&rentalprice=' + rentalprice + 
	            '&bookingtype=' + bookingtype + 
	            '&deposit=' + deposit + 
	            '&supplements=' + supplements +
	            '&supplementsprice=' + supplementsprice + 
	            '&chargetype=' + chargetype +
	            '&incvat=' + incvat +
	            '&oprentalprice=' + oprentalprice + 
	            '&numberofguests=' + numberofguests + 
	            '&discount=' + discount + 
	            '&numberofnights=' + numberofnights +
	            '&opsupplementsprice=' + opsupplementsprice,
	           	dataType:'json',
	            success:function(result){

	            	//If the price is to be shown as INC VAT then 
	            	if (incvat == 'true') {
	            		jQuery('#balancedue').val(result.totalcost);
	            		jQuery('#vatamount').val('0');	
	            		jQuery('#totalcost').val(result.totalcost); 
	            		//jQuery('#numberofnights').text(result.nights);
	            		jQuery('#ownerprice').val(result.optotal);
	            	} else {
	            		jQuery('#balancedue').val(result.totalcost + result.vatfigure);
	            		jQuery('#vatamount').val(result.vatfigure);
	            		jQuery('#totalcost').val(result.totalcost);	
	            		//jQuery('#numberofnights').text(result.nights);
	            		jQuery('#ownerprice').val(result.optotal);
	            	}
	            	
	            	console.log(result);

	            	
			    }
			});
		});
	});
})
/********************
// Ajax auto populate the operator details
********************/	

jQuery(document).ready(function(){
	jQuery('#operatorname').change(function() { 
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php'; 
		var operatorname = jQuery('#operatorname').val();  
		jQuery(function(){
		    jQuery.ajax({
	            url:siteUrl,
	            type:'POST',
	            data:'action=operatordetails&operatorname=' + encodeURIComponent(operatorname),           
	            success:function(result){
	            	//got it back, now assign it to its fields. 	            	
	            	jQuery('#operatorajax').html( result );;    
	            	
	            }
			});
		});
	});
})

/********************
// Ajax auto populate the client details
********************/	

jQuery(document).ready(function(){
	jQuery('#clientname').change(function() {  
		var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
		var clientname = jQuery('#clientname').val();  
		console.log(clientname);
		jQuery(function(){
		    jQuery.ajax({
	            url:siteUrl,
	            type:'POST',
	            data:'action=clientdetails&clientname=' + encodeURIComponent(clientname),           
	            success:function(result){
	            	//got it back, now assign it to its fields. 	            	
	            	jQuery('#clientajax').html( result );  
	            	
	            }
			});
		});
	});
})

/********************
// Ajax reduce balancedue after deposit paid
********************/	
jQuery(document).ready(function(){

jQuery('#recalculate').click(function() { 
var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php'; 
	var deposit = jQuery('#deposit').val();  
	var balancedue = jQuery('#balancedue').val();
	var depositpaid = jQuery('#depositpaid').val();  
	var apartmentpaid = jQuery('#apartmentpaid').val(); 
	var balancepaid = jQuery('#balancepaid').val(); 
	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=depositpaid&deposit=' + deposit + 
            '&balancedue=' + balancedue + 
            '&apartmentpaid=' + apartmentpaid + 
            '&balancepaid=' + balancepaid +
            '&depositpaid=' + depositpaid,
            success:function(result){
            	//got it back, now assign it to its fields. 	            	
            	jQuery('#balancedue').val(result);  
            	//console.log( result );       	   
            }
		});
	});
});
})
/********************
// Ajax send an email to the client
********************/	

jQuery('#email_client').click(function(e){

	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var bookingID = jQuery('#refid').val();
	
	jQuery.ajax({
		url:siteUrl,
	    type:'POST',
	    data:'action=booking_confirmation_email_client&bookingID='+bookingID,
         success:function(result){ 
            	alert('Your email was sent to the client.');
            	console.log(bookingID);
            	
		    }

	});


});
/********************
// Ajax send an email to the operator
********************/	

jQuery('#email_operator').click(function(e){

	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var bookingID = jQuery('#refid').val();
	
	jQuery.ajax({
		url:siteUrl,
	    type:'POST',
	    data:'action=booking_confirmation_email_operator&bookingID='+bookingID,
         success:function(result){ 
            	alert('Your email was sent to the Operator.');
            	console.log(result);
		    }

	});


});

/********************
// Ajax send an Arrival Process email to the client
********************/	

jQuery('#email_arrival').click(function(e){

	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var bookingID = jQuery('#refid').val();
	
	jQuery.ajax({
		url:siteUrl,
	    type:'POST',
	    data:'action=arrival_email&bookingID='+bookingID,
	     success:function(result){ 
	        	alert('Your email was sent to the Client.');
	        	console.log(result);
            	
		}
	});
});


/********************
// Ajax search query for upcoming bookings
********************/	

jQuery('#searchquery').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#searchquery').click(function() { 
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var startdate = jQuery('input#date11').val();
		
	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=searchquery&startdate=' + startdate,
            success:function(result){
            	//got it back, now assign it to its fields. 	            	
            	jQuery('#searchresult').html( result );
            	jQuery('#searchresult').DataTable({"order": [[ 1, "desc" ]],"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});
            	console.log(startdate);
            	
            }
		});
	});

	
});


/********************
// Ajax search query for upcoming payments
********************/	

jQuery('#paymentsquery').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#paymentsquery').click(function() {  
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var startdate = jQuery('#date13').val();
	var enddate = jQuery('#date14').val();
	
	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=paymentsquery&startdate=' + startdate + '&enddate=' + enddate,
            success:function(result){
            	//got it back, now assign it to its fields. 	            	
            	jQuery('#searchresult').html( result );
            	jQuery('#searchresult').DataTable({"order": [[ 1, "desc" ]],"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});
            //console.log(result);
            	
            }
		});
	});
});

/********************
// Ajax search query for client report
********************/	

jQuery('#clientquery').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#clientquery').click(function() {  
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var clientname = jQuery('#clientreportname').val();
	var startdate = jQuery('#date15').val();
	var enddate = jQuery('#date16').val();
	var apartmentname = jQuery('#clientreportapartment').val();
	var location = jQuery('#clientreportlocation').val();

	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=clientreport&clientname=' + encodeURIComponent(clientname) + 
            '&apartmentname=' + apartmentname +
            '&location=' + location +
            '&startdate=' + startdate +
            '&enddate=' + enddate,          
            success:function(result){
            //got it back, now assign it to its fields. 	            	
            jQuery('#searchresult').html( result );
            jQuery('#searchresult').DataTable({"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});

            //Total Spend Calculation
			jQuery(function() {
			    jQuery("#calculate_total").click(function() {
			        var add = 0;
			       	jQuery(".total-cost").each(function() {
			            add += Number(jQuery(this).text());
			        });
			        jQuery("#total_spend").text('£' + add);
			    });
			    jQuery('#calculate_average').click(function(){
					var add = 0;
					jQuery('.total-cost').each(function(){							
						add += Number(jQuery(this).text());
						numberofcells = jQuery('.total-cost').length;
						num = (add / numberofcells);
					});
					jQuery("#average_spend").text('£' + (Math.round(num*100)/100).toFixed(2) );		
				});
				jQuery('#calculate_total_bookings').click(function(){
					var numberofcells = jQuery('.booking').length;
					jQuery('#total_bookings').text(numberofcells + ' bookings');
				});
				jQuery('#calculate_average_duration').click(function(){
					var add = 0;
					jQuery('.numberofnights').each(function(){							
						add += Number(jQuery(this).text());
						numberofcells = jQuery('.numberofnights').length;
						num = (add / numberofcells);
					});
					jQuery("#average_duration").text((Math.round(num*100)/100).toFixed(0) + ' nights');					
				});
				jQuery('#calculate_average_nightly').click(function(){
					var add = 0;
					jQuery('.nightlyrate').each(function(){							
						add += Number(jQuery(this).text());
						numberofcells = jQuery('.numberofnights').length;
						num = (add / numberofcells);
					});						
					jQuery("#average_nightly").text('£' + (Math.round(num*100)/100).toFixed(2) );
				
				});
			});
			
            	
            }
		});		
	});
});

/********************
// Ajax search query for operator report
********************/	

jQuery('#operatorquery').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#operatorquery').click(function() {  
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var operatorname = jQuery('#operatorreportname').val();
	var startdate = jQuery('#date17').val();
	var enddate = jQuery('#date18').val();
	var apartmentname = jQuery('#operatorreportapartment').val();
	var location = jQuery('#operatorreportlocation').val();

	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=operatorreport&operatorname=' + encodeURIComponent(operatorname) + 
            '&apartmentname=' + apartmentname +
            '&location=' + location +
            '&startdate=' + startdate +
            '&enddate=' + enddate,          
            success:function(result){
            //got it back, now assign it to its fields. 	            	
           	jQuery('#searchresult').html( result );
           	jQuery('#searchresult').DataTable({"order": [[ 1, "desc" ]],"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});
            

            //Total Spend Calculation
			jQuery(function() {
			    jQuery("#calculate_total").click(function() {
			        var add = 0;
			       	jQuery(".total-cost").each(function() {
			            add += Number(jQuery(this).text());
			        });
			        jQuery("#total_spend").text('£' + add);
			    });
			    jQuery('#calculate_average').click(function(){
					var add = 0;
					jQuery('.total-cost').each(function(){							
						add += Number(jQuery(this).text());
						numberofcells = jQuery('.total-cost').length;
						num = (add / numberofcells);
					});
					jQuery("#average_spend").text('£' + (Math.round(num*100)/100).toFixed(2) );		
				});
				jQuery('#calculate_total_bookings').click(function(){
					var numberofcells = jQuery('.booking').length;
					jQuery('#total_bookings').text(numberofcells + ' bookings');
				});
				jQuery('#calculate_average_duration').click(function(){
					var add = 0;
					jQuery('.numberofnights').each(function(){							
						add += Number(jQuery(this).text());
						numberofcells = jQuery('.numberofnights').length;
						num = (add / numberofcells);
					});
					jQuery("#average_duration").text((Math.round(num*100)/100).toFixed(0) + ' nights');					
				});
				jQuery('#calculate_average_nightly').click(function(){
					var add = 0;
					jQuery('.nightlyrate').each(function(){							
						add += Number(jQuery(this).text());
						numberofcells = jQuery('.numberofnights').length;
						num = (add / numberofcells);
					});						
					jQuery("#average_nightly").text('£' + (Math.round(num*100)/100).toFixed(2) );
				
				});
			});
				
            }
		});		
	});
});

/********************
// Ajax search query for Top Operator Report
********************/	

jQuery('#leaderoperator').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#leaderoperator').click(function() { 	
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var startdate = jQuery('#date19').val();
	var enddate = jQuery('#date20').val();

	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=topoperator&startdate=' + startdate +
            '&enddate=' + enddate,          
            success:function(result){
            //got it back, now assign it to its fields. 	            	
           	jQuery('#searchresult').html( result );
            jQuery('#searchresult').DataTable({"order": [[ 1, "desc" ]],"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});
 			var search = '£0.00';
            jQuery("#searchresult").filter(function() {
		        return jQuery(this).text() == search;
		    }).closest('tr.sortrows').hide();
            	
            }
		});		
	});
});


/********************
// Ajax search query for Top Client Report
********************/	

jQuery('#leaderclient').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#leaderclient').click(function() { 	
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var startdate = jQuery('#date21').val();
	var enddate = jQuery('#date22').val();

	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=topclient&startdate=' + startdate +
            '&enddate=' + enddate,          
            success:function(result){
            //got it back, now assign it to its fields. 	            	
           	jQuery('#searchresult').html( result );
            //console.log(result);
            jQuery(function(){
	            // this will hide all the rows that equal 0 spend.				    
			    jQuery('#searchresult').DataTable({"order": [[ 1, "desc" ]],"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});				    
            });
			}		
		});	
	});	
});



/********************
// Ajax search query for Top Locations Report
********************/	

jQuery('#leaderlocations').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#leaderlocations').click(function() { 
var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';	
	var startdate = jQuery('#date23').val();
	var enddate = jQuery('#date24').val();
	var clientname = jQuery('#leaderloc_clientname').val();
	var operatorname = jQuery('#leaderloc_operatorname').val();


	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=toplocations&startdate=' + startdate +
            '&enddate=' + enddate +
            '&operatorname=' + encodeURIComponent(operatorname) +
            '&clientname=' + encodeURIComponent(clientname),          
            success:function(result){
            //got it back, now assign it to its fields. 	            	
           	jQuery('#searchresult').html( result );
            //console.log(result);
	            jQuery(function(){
		            // this will hide all the rows that equal 0 spend.
				    var search = '£0';
				    jQuery("#searchresult").filter(function() {
				        return jQuery(this).text() == search;
				    }).parent('tr').hide();
				    jQuery('#searchresult').DataTable({"order": [[ 1, "desc" ]],"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});
	            });
			}		
		});	
	});	

});


/********************
// Ajax search query for Top Apartment Report
********************/	

jQuery('#leaderapartments').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#leaderapartments').click(function() { 	
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var startdate = jQuery('#date25').val();
	var enddate = jQuery('#date26').val();
	var clientname = jQuery('#leaderapp_clientname').val();
	var operatorname = jQuery('#leaderapp_operatorname').val();

	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=topapartments&startdate=' + startdate +
            '&enddate=' + enddate +
            '&operatorname=' + encodeURIComponent(operatorname) + 
            '&clientname=' + encodeURIComponent(clientname),          
            success:function(result){
            //got it back, now assign it to its fields. 	            	
           	jQuery('#searchresult').html( result );
            //console.log(result);
	            jQuery(function(){
		            // this will hide all the rows that equal 0 spend.
				    var search = '£0';
				    jQuery("#searchresult").filter(function() {
				        return jQuery(this).text() == search;
				    }).parent('tr').hide();
				    jQuery('#searchresult').DataTable({"order": [[ 1, "desc" ]],"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});
	            });
			}		
		});	
	});	
});

/********************
// Ajax search query for Customer Apartment Search
********************/	

jQuery('#customerapartmentsquery').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#customerapartmentsquery').click(function() { 
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var operatorname = jQuery('#operator').val();
	var location = jQuery('#location').val();
	var noofnights = jQuery('#noofnights').val();
	var bookingtype = jQuery('#bookingtypesearch').val();

	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=customer_query_ajax&operator=' + operatorname + '&location=' + location + '&noofnights=' + noofnights + '&bookingtype=' + bookingtype,       
            success:function(result){
            //got it back, now assign it to its fields. 	            	
           	jQuery('#searchresult').html( result );
            //console.log(result);
            	
            }
		});		
	});

});


/********************
// Ajax update all bookings posts
********************/
jQuery(document).ready(function(){
	jQuery('#updateclick').click(function(){
		var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';

		jQuery(function(){
		    jQuery.ajax({
	            url:siteUrl,
	            type:'POST',
	            data:'action=update_bookings',
	            success:function(result){
	            //got it back, now assign it to its fields. 
	            jQuery('#searchresults').html( result );	            	
	            jQuery('#searchresults').show();	
	            	
	            }
			});		
		});
		console.log('bookings updated');
	});
});


/********************
// Ajax create add on domain for the reseller
********************/
jQuery(document).ready(function(){
	jQuery('#createreseller').click(function(){
		var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
		var addondomain = jQuery('#resellerp_pageurl').val();
		var email = jQuery('#resllerp_email').val(); 	


		jQuery(function(){
		    jQuery.ajax({
	            url:siteUrl,
	            type:'POST',
	            data:'action=addondomain&addondomain='+addondomain+'&email='+jQuery('#resellerp_email').val(),
	            success:function(result){
	            //got it done now let them know the result	            
	            jQuery('#scphs #addhere2').html('<i class="fa fa-check-circle"></i>');
				jQuery('#scphs input').val('<i class="fa fa-check-circle"></i>');

				jQuery('#shs #addhere1').html('');
				jQuery('#shs input').val('');

				alert('The domain ' + addondomain + ' has been added to the SCP Server. An email has also been sent with instructions.\nPlease remember to Publish/Update your post.')
			
	            }
			});		
		});
	});
});

/********************
// Ajax delete add on domain for the reseller
********************/
jQuery(document).ready(function(){
	jQuery('#deletereseller').click(function(){
		var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
		var addondomain = jQuery('#resellerp_pageurl').val();
		var email = jQuery('#resllerp_email').val(); 
		//var query = 'https://host.knoppys.co.uk:2087/json-api/cpanel?cpanel_jsonapi_user=servicedcitypads&apiversion=2&cpanel_jsonapi_module=addondomain&cpanel_jsonapi_func=deladdondomain&domain=' + addondomain  +'&subdomain='+ addondomain  +'_servicedcitypads.com';			
		

		jQuery(function(){
		    jQuery.ajax({
	            url:siteUrl,
	            type:'POST',
	            data:'action=deladdondomain&addondomain='+addondomain+'&email='+jQuery('#resellerp_email').val(),
	            success:function(result){
	            //got it done now let them know the result	            

				jQuery('#shs #addhere1').html('');
				jQuery('#shs input').val('');

				jQuery('#shs #addhere2').html('');
				jQuery('#shs input').val('');

			    console.log(result);		
	            }
			});		
		});
		
	});
});

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
	            data:'action=sendemail&email='+jQuery('#resellerp_email').val(),
	            success:function(result){
	            //got it done now let them know the result	            
	            jQuery('#shs #addhere1').html('<i class="fa fa-check-circle"></i>');
				jQuery('#shs input').val('<i class="fa fa-check-circle"></i>');

				jQuery('#scphs #addhere2').html('');
				jQuery('#scphs input').val('');

				alert('An email has been sent to the client with the download link and instructions on how to proceed.\nPlease remember to Publish/Update your post.');
	            
	            }
			});		
		});
	});
});

/********************
// Toggle Child Bookings
********************/
jQuery(document).ready(function(){
	jQuery('.bookingexpand').click(function(){
		jQuery(this).find('.expand').toggle();
	});
});

/********************
// Ajax auto populate the operator details
*****************/
jQuery(document).ready(function(){
	jQuery('#postcodesearch').click(function() { 
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php'; 
	var postcode = jQuery('#postcodeinput').val();  
		jQuery(function(){
		    jQuery.ajax({
	            url:siteUrl,
	            type:'POST',
	            data:'action=postcodesearch&postcode=' + postcode,           
	            success:function(result){
	            	
	            	var apartments = jQuery.parseJSON(result);
	            	var map = new google.maps.Map(document.getElementById('map-canvas'), {
						center: new google.maps.LatLng(53.408371, -2.991573),
						zoom: 5
					});
					var infowindow = new google.maps.InfoWindow();

					google.maps.event.addListenerOnce(map, 'tilesloaded', function() {

					    for (var i = 0; i < apartments.length; ++i) {

					    	geocodeAddress(apartments[i].postcode, infowindow, map);

					    }

					});

					google.maps.event.addDomListener(window, "load", result);

					function geocodeAddress(address, infowindow, map) {

						var geocoder = new google.maps.Geocoder();

						geocoder.geocode({address: address.postcode + ' UK',}, function(result, status) {

							if (status == 'OK' && result.length > 0) {

								var marker = new google.maps.Marker({
									position: result[0].geometry.location,
									map: map,
								});

								google.maps.event.addListener(marker, 'click', function() {
								var content = (address.info);

									infowindow.setContent(content);
									infowindow.open(map, this);

								});
							} else {
					
								alert("geocoder returns status:" + status)
							}
						});

					}

					

				
				    
				          	
	            	
	            }
			});
		});
	});
})