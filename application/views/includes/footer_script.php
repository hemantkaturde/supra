<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script src="<?php echo base_url(); ?>assets/bootstrap/js/select2.js"></script>
<link href="<?php echo base_url(); ?>assets/bootstrap/css/select2.css" rel="stylesheet" type="text/css" />
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> -->

<script>
    // Get the select input within the first div
    $(document).ready(function() {
        // Select the select element within the first div
        var selectInput = $('#addNewModal').find('select');
		selectInput.addClass('serachfilternotrequired');
    });
	 // Add a class to all select inputs on the page
	$(document).ready(function() {
        // Select all select elements and add the class
        $('select').addClass('searchfilter');
    });
</script>


<script>
    $(document).ready(function() {
        // Apply Select2 to all select inputs within the 'applySelect2' class
        $('.searchfilter').select2();

        // Remove Select2 from all select inputs within the 'removeSelect2' class
        $('.serachfilternotrequired').each(function() {
            // Destroy Select2 instance if it exists
            $(this).select2('destroy');
        });
    });
</script>

<script type="text/javascript">

    // $(document).ready(function(){
	// 		$(".searchfilter").select2();
	// });

//    $(function() {
// 			$(".datepicker").datepicker({ 
// 				// minDate: 0,
// 				todayHighlight: true,
//                  dateFormat: 'yy-mm-dd',
// 				startDate: new Date()
// 			});
// 		});
</script>

<script type="text/javascript">
//    $(document).ready(function(){
// 			$("select").select2();
// 	});
</script>


<?php if($pageTitle=='Company Master'){ ?>
<script type="text/javascript">
		$(document).on('click','#updateCompanyInfo',function(e){
				e.preventDefault();
				$(".loader_ajax").show();
				var formData = new FormData($("#updateCompanyInfoform")[0]);

				$.ajax({
					url : "<?php echo base_url();?>updateCompanyInfo",
					type: "POST",
					data : formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data, textStatus, jqXHR)
					{
						var fetchResponse = $.parseJSON(data);
						if(fetchResponse.status == "failure")
						{
							$.each(fetchResponse.error, function (i, v)
							{
								$('.'+i+'_error').html(v);
							});

							$(".loader_ajax").hide();
						}
						else if(fetchResponse.status == 'success')
						{
							swal({
								title: "Success",
								text: "Company Infromation Successfully Updated",
								icon: "success",
								button: "Ok",
								},function(){ 
									window.location.href = "<?php echo base_url().'companymaster'?>";
							});						
						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$(".loader_ajax").hide();
					}
				});
				return false;
		});  
</script>
<?php } ?>

<?php if($pageTitle=='Supplier Master' || $pageTitle=='Add Supplier Master' || $pageTitle=='Edit Supplier Master'){ ?>
	<script type="text/javascript">
        $(document).ready(function() {
            var dt = $('#view_supplier').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "20%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "8%", "targets": 3 },
	                 { "width": "10%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					 { "width": "5%", "targets": 6 },
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Supplier Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchSupplier",
                    type: "post",
	            },
	        });
	    });

		$(document).on('click','#savenewsupplier',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnewsupplierform")[0]);

			$.ajax({
				url : "<?php echo base_url();?>addnewSupplier",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Supplier Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								$("#modal-md").hide();
								window.location.href = "<?php echo base_url().'suppliermaster'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','#updatesupplier',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#updatesupplierform")[0]);
            var supplier_id = $("#supplier_id").val();
			$.ajax({
				url : "<?php echo base_url();?>updateSupplier/"+supplier_id,
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Supplier Successfully Updated!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'suppliermaster'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deletesupplier',function(e){

			var elemF = $(this);
			e.preventDefault();

				swal({
					title: "Are you sure?",
					text: "Delete Supplier",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deleteSupplier",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "Supplier Deleted Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 
													window.location.href = "<?php echo base_url().'suppliermaster'?>";
											});	
									    }

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "Supplier deletion cancelled ", "error");
					}
				});
		});

</script>
<?php } ?>

<?php if($pageTitle=='Row Material Master' || $pageTitle=='Add Material Master' || $pageTitle=='Edit Raw Material Master'){ ?>
	<script type="text/javascript">
		$(document).ready(function() {
            var dt = $('#view_rowmaterial').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "20%", "targets": 0 },
	                 { "width": "20%", "targets": 1 },
					 { "width": "15%", "targets": 2 },
					 { "width": "15%", "targets": 3 },
					 { "width": "15%", "targets": 4 },
	                 { "width": "10%", "targets": 5 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Raw Material Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchRowmaterial",
                    type: "post",
	            },
	        });
	    });

		$(document).on('click','#savenewRawmaterial',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnewrawmaterialform")[0]);

			$.ajax({
				url : "<?php echo base_url();?>addnewmaterialdata",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Raw Material Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'rowmaterialmaster'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','#updateRawmaterial',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#updaterawmaterialform")[0]);
            var rawmaetrial_id = $("#rawmaetrial_id").val();
			$.ajax({
				url : "<?php echo base_url();?>updateRawmaterial/"+rawmaetrial_id,
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Raw Material Successfully Updated!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'rowmaterialmaster'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deleteRawmaterial',function(e){

			var elemF = $(this);
			e.preventDefault();

				swal({
					title: "Are you sure?",
					text: "Delete Raw Material",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deleteRawmaterial",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "Raw Material Deleted Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 
													window.location.href = "<?php echo base_url().'rowmaterialmaster'?>";
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "Raw Material deletion cancelled ", "error");
					}
				});
		});

    </script>
<?php } ?>


<?php if($pageTitle=='Vendor Master' || $pageTitle=='Add Vendor Master' || $pageTitle=='Edit Vendor Master'){ ?>
<script type="text/javascript">
		$(document).ready(function() {
				var dt = $('#view_vendor').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "10%", "targets": 0 },
						{ "width": "20%", "targets": 1 },
						{ "width": "10%", "targets": 2 },
						{ "width": "8%", "targets": 3 },
						{ "width": "10%", "targets": 4 },
						{ "width": "10%", "targets": 5 },
						{ "width": "5%", "targets": 6 },
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No Vendor Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchVendor",
						type: "post",
					},
				});
		});

		$(document).on('click','#savenewvendor',function(e){
				e.preventDefault();
				$(".loader_ajax").show();
				var formData = new FormData($("#addnewvendorform")[0]);

				$.ajax({
					url : "<?php echo base_url();?>addnewVendor",
					type: "POST",
					data : formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data, textStatus, jqXHR)
					{
						var fetchResponse = $.parseJSON(data);
						if(fetchResponse.status == "failure")
						{
							$.each(fetchResponse.error, function (i, v)
							{
								$('.'+i+'_error').html(v);
							});
							$(".loader_ajax").hide();
						}
						else if(fetchResponse.status == 'success')
						{
							swal({
								title: "Success",
								text: "Vendor Successfully Added!",
								icon: "success",
								button: "Ok",
								},function(){ 
									window.location.href = "<?php echo base_url().'vendormaster'?>";
							});		
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
					$(".loader_ajax").hide();
					}
				});
				return false;
		});

		$(document).on('click','#updatevendor',function(e){
				e.preventDefault();
				$(".loader_ajax").show();
				var formData = new FormData($("#updatevendorform")[0]);
				var vendor_id = $("#vendor_id").val();
				$.ajax({
					url : "<?php echo base_url();?>updateVendor/"+vendor_id,
					type: "POST",
					data : formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data, textStatus, jqXHR)
					{
						var fetchResponse = $.parseJSON(data);
						if(fetchResponse.status == "failure")
						{
							$.each(fetchResponse.error, function (i, v)
							{
								$('.'+i+'_error').html(v);
							});
							$(".loader_ajax").hide();
						}
						else if(fetchResponse.status == 'success')
						{
							swal({
								title: "Success",
								text: "Vendor Successfully Updated!",
								icon: "success",
								button: "Ok",
								},function(){ 
									window.location.href = "<?php echo base_url().'vendormaster'?>";
							});		
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
					$(".loader_ajax").hide();
					}
				});
				return false;
		});

		$(document).on('click','.deletevendor',function(e){
			var elemF = $(this);
			e.preventDefault();

			swal({
				title: "Are you sure?",
				text: "Delete Vendor",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteVendor",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Vendor Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'vendormaster'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Vendor deletion cancelled ", "error");
				}
			});
		});

</script>
<?php } ?>


<?php if($pageTitle=='USP Master' || $pageTitle=='Add USP Master' || $pageTitle=='Edit USP Master'){ ?>
	<script type="text/javascript">
		$(document).ready(function() {
            var dt = $('#view_USP').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "20%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "8%", "targets": 3 },
	                 { "width": "10%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					 { "width": "5%", "targets": 6 },
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No USP Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchUSP",
                    type: "post",
	            },
	        });
	    });

		$(document).on('click','#savenewUSP',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnewuspform")[0]);

			$.ajax({
				url : "<?php echo base_url();?>addnewUSP",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "USP Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'uspmaster'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','#updateusp',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#updateuspform")[0]);
            var usp_id = $("#usp_id").val();
			$.ajax({
				url : "<?php echo base_url();?>updateUSP/"+usp_id,
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "USP Successfully Updated!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'uspmaster'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deletesusp',function(e){
				var elemF = $(this);
				e.preventDefault();

				swal({
					title: "Are you sure?",
					text: "Delete USP",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deleteUSP",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "USP Deleted Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 
													window.location.href = "<?php echo base_url().'uspmaster'?>";
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "USP deletion cancelled ", "error");
					}
				});
		});

	</script>
<?php } ?>



<?php if($pageTitle=='Sampling Master'  || $pageTitle=="Add Sampling Master" || $pageTitle=="Edit Sampling"){ ?>
	<script type="text/javascript">
		$(document).ready(function() {
            var dt = $('#view_smapling_method').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "45%", "targets": 0 },
	                 { "width": "45%", "targets": 1 },
					 { "width": "10%", "targets": 2 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Smapling Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchSamplingmaster",
                    type: "post",
	            },
	        });
	    });

		$(document).on('click','#savenewsampling',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnewsamplingform")[0]);

			$.ajax({
				url : "<?php echo base_url();?>addnewSamplingmaster",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Sampling Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'samplingmaster'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','#editsampling',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#editsamplingform")[0]);
            var sampling_method_id = $("#sampling_method_id").val();
			$.ajax({
				url : "<?php echo base_url();?>updatesampling/"+sampling_method_id,
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Sampling Successfully Updated!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'samplingmaster'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deletesampling',function(e){
				var elemF = $(this);
				e.preventDefault();

				swal({
					title: "Are you sure?",
					text: "Delete Sampling",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deletesampling",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "Sampling Deleted Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 
													window.location.href = "<?php echo base_url().'samplingmaster'?>";
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "USP deletion cancelled ", "error");
					}
				});
		});

	</script>
<?php } ?>


<?php if($pageTitle=='Finished Goods Master' || $pageTitle=='Add Finished Goods' || $pageTitle=='Update Finished Goods'){ ?>
	<script type="text/javascript">
		$(document).ready(function() {
            var dt = $('#view_finished_goods_master').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "20%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
	                 { "width": "10%", "targets": 4 },
					 { "width": "8%", "targets": 5 },
					 { "width": "15%", "targets": 6 },
					 { "width": "10%", "targets": 7 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Finished Goods Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchfinishedgoods",
                    type: "post",
	            },
	        });
	    });

		$(document).on('click','#savenewfinishedgoods',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnewfinishedgoodsform")[0]);

			$.ajax({
				url : "<?php echo base_url();?>addnewFinishedgoods",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Finished Goods Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'finishedgoodsmaster'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','#updatefinishedgoods',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#editnewfinishedgoodsform")[0]);
            var finished_goods_id = $("#finished_goods_id").val();
			$.ajax({
				url : "<?php echo base_url();?>updateFinishedgoods/"+finished_goods_id,
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Finished Goods Successfully Updated!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'finishedgoodsmaster'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deletefinishedgoodsdata',function(e){

			var elemF = $(this);
			e.preventDefault();

				swal({
					title: "Are you sure?",
					text: "Delete Finished Goods",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deletefinishedgoods",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "Finished Goods Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 
													window.location.href = "<?php echo base_url().'finishedgoodsmaster'?>";
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "Finished Goods deletion cancelled ", "error");
					}
				});
		});
		
	</script>
<?php } ?>


<?php if($pageTitle=='Platting Master' || $pageTitle=='Add Platting Master' || $pageTitle=='Update Platting Master'){ ?>
<script type="text/javascript">
	$(document).ready(function() {
            var dt = $('#view_paltting_master').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "30%", "targets": 0 },
	                 { "width": "30%", "targets": 1 },
					 { "width": "10%", "targets": 2 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Platting List Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchplattinglist",
                    type: "post",
	            },
	        });
	});

	$(document).on('click','#savenewPlatting',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnewplattingform")[0]);

			$.ajax({
				url : "<?php echo base_url();?>addnewPlatting",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Paltting Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'plattingmaster'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	});

	$(document).on('click','#updatePlatting',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#updateplattingform")[0]);
            var platting_id = $("#platting_id").val();
			$.ajax({
				url : "<?php echo base_url();?>updatePlattingmaster/"+platting_id,
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Platting  Successfully Updated!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'plattingmaster'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	});

	$(document).on('click','.deleteplattingmaster',function(e){

		var elemF = $(this);
		e.preventDefault();

			swal({
				title: "Are you sure?",
				text: "Delete Platting ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteplatting",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Platting Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'plattingmaster'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Platting deletion cancelled ", "error");
				}
			});
	});
	
</script>
<?php } ?>


<?php if($pageTitle=='Rejection Master' || $pageTitle=='Add Rejection Master' || $pageTitle=='Update Rejection Master'){ ?>
<script type="text/javascript">
	$(document).ready(function() {
            var dt = $('#view_rejection_master').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "60%", "targets": 0 },
	                 { "width": "10%", "targets": 1 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Rejection List Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchrRjectionglist",
                    type: "post",
	            },
	        });
	});

	$(document).on('click','#savenewRejection',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnewRejectionform")[0]);

			$.ajax({
				url : "<?php echo base_url();?>addnewRejection",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Rejection Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'rejectionmaster'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	});

	$(document).on('click','#updateRejection',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#updatenewRejectionform")[0]);
            var rejection_reason_id = $("#rejection_reason_id").val();
			$.ajax({
				url : "<?php echo base_url();?>updateRejectionmaster/"+rejection_reason_id,
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Rejection  Successfully Updated!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'rejectionmaster'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	});

	$(document).on('click','.deleteRejection',function(e){

		var elemF = $(this);
		e.preventDefault();

			swal({
				title: "Are you sure?",
				text: "Delete Rejection ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteRejection",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Rejection Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'rejectionmaster'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Rejection deletion cancelled ", "error");
				}
			});
	});
	
</script>
<?php } ?>


<?php if($pageTitle=='Buyer Master' || $pageTitle=='Add Buyer Master' || $pageTitle=="Update Buyer Master"){ ?>
	<script type="text/javascript">
		$(document).ready(function() {
            var dt = $('#view_buyer').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "15%", "targets": 0 },
	                 { "width": "18%", "targets": 1 },
					 { "width": "15%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
	                 { "width": "15%", "targets": 5 },
					 { "width": "10%", "targets": 6 },
					 { "width": "15%", "targets": 7 },
					 { "width": "15%", "targets": 8 },
					
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Buyer List Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchrBuyerlist",
                    type: "post",
	            },
	        });
	    });

		$(document).on('click','#savebuyer',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addbuyerform")[0]);

			$.ajax({
				url : "<?php echo base_url();?>addnewBuyer",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Buyer Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'buyermaster'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','#updateBuyer',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#editebuyerform")[0]);
            var buyer_id = $("#buyer_id").val();
			$.ajax({
				url : "<?php echo base_url();?>updateBuyer/"+buyer_id,
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Buyer  Successfully Updated!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'buyermaster'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deleteBuyer',function(e){

			var elemF = $(this);
			e.preventDefault();
				swal({
					title: "Are you sure?",
					text: "Delete Buyer ",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deleteBuyer",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "Buyer Deleted Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 
													window.location.href = "<?php echo base_url().'buyermaster'?>";
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "Buyer deletion cancelled ", "error");
					}
				});
		});

</script>
<?php } ?>


<?php if($pageTitle=='Buyer PO' || $pageTitle=='Add Buyer PO' || $pageTitle=='Edit Buyer PO'){ ?>
	<script type="text/javascript">
        $(document).ready(function() {
            var dt = $('#view_buyerpo').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "15%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "15%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "15%", "targets": 4 },
	                 { "width": "10%", "targets": 5 },
					 { "width": "8%", "targets": 6 },
					 { "width": "8%", "targets": 7 },
					 { "width": "20%", "targets": 8 },
					//  { "width": "15%", "targets": 7 },
					
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Buyer Po List Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchrBuyerpolist",
                    type: "post",
	            },
	        });
	    });

		$(document).on('click','#savenewbuyerpo',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnewbuyerform")[0]);
			var po_id =   $('#po_id').val();
			$.ajax({
				url : "<?php echo base_url();?>addnewBuyerpo",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						if(po_id){
							swal({
							title: "Success",
							text: "Buyer PO Successfully Updated!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'buyerpo'?>";
						    });	

						}else{
							swal({
								title: "Success",
								text: "Buyer PO Successfully Added!",
								icon: "success",
								button: "Ok",
								},function(){ 
									window.location.href = "<?php echo base_url().'buyerpo'?>";
							});
						}		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deleteBuyerpo',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Buyer PO ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteBuyerpo",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Buyer PO Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'buyerpo'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Buyer PO deletion cancelled ", "error");
				}
			});
		});

		$(document).on('click','#savebuyeritem',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			   var formData = new FormData($("#addbuyeritemform")[0]);
			   var po_id =   $('#po_id').val();
               var part_number =   $('#part_number').val();
			   var description =   $('#description').val();
			   var qty =   $('#qty').val();
			   var rate =   $('#rate').val();
			   var value =   $('#value').val();
			   var unit =   $('#unit').val();
			   var buyer_po_part_delivery_date =   $('#buyer_po_part_delivery_date').val();
			   
			   var sales_order_number =   $('#sales_order_number').val();
			   var date =   $('#date').val();
			   var buyer_po_number =   $('#buyer_po_number').val();
			   var buyer_po_date =   $('#buyer_po_date').val();
			   var buyer_name =   $('#buyer_name').val();
			   var currency =   $('#currency').val();
			   var delivery_date =   $('#delivery_date').val();
			   var remark =   $('#remark').val();
			   var buyer_po_item_id =   $('#buyer_po_item_id').val();
			   var generate_po =   $('#generate_po').val();
			   var po_status =   $('#po_status').val();
			   var packaging_instraction =   $('#packaging_instraction').val();
			   var item_po_status =   $('#item_po_status').val();

						 
			$.ajax({
				url : "<?php echo base_url();?>addbuyeritem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,qty:qty,rate:rate,value:value,buyer_po_part_delivery_date:buyer_po_part_delivery_date,buyer_po_number:buyer_po_number,date:date,buyer_po_date:buyer_po_date,buyer_name:buyer_name,currency:currency,delivery_date:delivery_date,remark:remark,unit:unit,po_id:po_id,buyer_po_item_id:buyer_po_item_id,generate_po:generate_po,po_status:po_status,packaging_instraction:packaging_instraction,item_po_status:item_po_status},
				// method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {

						if(po_id){
								swal({
									title: "Success",
									text: "Item Successfully Added!",
									icon: "success",
									button: "Ok",
									},function(){ 
										window.location.href = "<?php echo base_url().'editBuyerpo/'?>"+po_id;
							   });	
						}else{

							swal({
									title: "Success",
									text: "Item Successfully Added!",
									icon: "success",
									button: "Ok",
									},function(){ 
										window.location.href = "<?php echo base_url().'addnewBuyerpo'?>";
								});	
						}
						
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deleteBuyerpoitem',function(e){
			var elemF = $(this);
			var po_id =   $('#po_id').val();
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Buyer PO Item ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteBuyerpoitem",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Buyer PO Item Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 

												if(po_id){
													window.location.href = "<?php echo base_url().'editBuyerpo/'?>"+po_id;

												}else{
													window.location.href = "<?php echo base_url().'addnewBuyerpo'?>";

												}
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Buyer PO Item deletion cancelled ", "error");
				}
			});
		});

		$(document).on('change','#buyer_name',function(e){  
			e.preventDefault();

			$('#currency').html();
			
			//$(".loader_ajax").show();
			var buyer_name = $('#buyer_name').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerCurrency",
				type: "POST",
				data : {'buyer_name' : buyer_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#currency').value('');
					}
					else
					{
						$('#currency').val(data);
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#currency').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('blur', '#qty,#rate', function(){
				if($("#qty").val()){
					var qty = $("#qty").val();
				}else{
					var qty = 0;
				}

				if($("#rate").val()){
					var rate = $("#rate").val();
				}else{
					var rate = 0;
				}
				
				var total_value = rate * qty;
				$("#value").val(total_value.toFixed(2));
        });

		$(document).on('click','.closebuyerpo', function(){
			location.reload();
        });

		$(document).on('change','#part_number',function(e){  
			e.preventDefault();
			
			//$(".loader_ajax").show();
			var part_number = $('#part_number').val();
			
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getfinishedgoodsPartnumberByid",
				type: "POST",
				data : {'part_number' : part_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#description').value('');
					}
					else
					{
						var data_row_material = jQuery.parseJSON( data );

						$('#description').val(data_row_material.name);
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#description').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('click','.editbuyerpoitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			$.ajax({
				url : "<?php echo base_url();?>getbuyeritemdataforitemedit",
				type: "POST",
				data : 'id='+item_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 
						$('#buyer_po_item_id').val(fetchResponse.buyer_item_id); 
						$('#part_number').val(fetchResponse.fin_id);  
						$('#description').val(fetchResponse.description);  
						$('#qty').val(fetchResponse.order_oty);  
						$('#unit').val(fetchResponse.unit);  
						$('#rate').val(fetchResponse.rate);  
						$('#value').val(fetchResponse.value); 
						$('#buyer_po_part_delivery_date').val(fetchResponse.buyer_po_part_delivery_date);  
						$('#packaging_instraction').val(fetchResponse.packaging_instraction);  
						$('#item_po_status').val(fetchResponse.item_po_status);  
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		});

		$(document).on('change','#buyer_po_number,#buyer_name',function(e){  
			e.preventDefault();

			//$(".loader_ajax").show();
			var buyer_po_number = $('#buyer_po_number').val();
			var buyer_name = $('#buyer_name').val();

			if(buyer_name && buyer_po_number){
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>checkBuyerpoandbuyeralredayexists",
					type: "POST",
					data : {'buyer_name' : buyer_name,'buyer_po_number':buyer_po_number},
					success: function(data, textStatus, jqXHR)
					{
						if(data == "failure")
						{
						}else{
						        swal({
								title: "Record Exists Notification",
								text: "Buyer po Already Exists for this Buyer PO and Buyer. Do you Still want to Insert The record ?",
								icon: "success",
								button: "Ok",
									},function(){ 
												
								});	
							}	
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						
					}
				});
				return false;
			}
		});
    </script>
<?php } ?>


<?php if($pageTitle=='Supplier PO' || $pageTitle=='Add Supplier PO' || $pageTitle=="Edit Supplier PO"){ ?>
	<script type="text/javascript">
     
	    $(document).ready(function() {
            var dt = $('#view_supplierpo').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "8%", "targets": 1 },
					 { "width": "15%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "15%", "targets": 4 },
	                 { "width": "10%", "targets": 5 },
					 { "width": "10%", "targets": 6 },
					 { "width": "10%", "targets": 7 },
					 { "width": "15%", "targets": 8 },
					
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Supplier PO List Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchSupplierpolist",
                    type: "post",
	            },
	        });
	    });

		$(document).ready(function() {

			var buyer_po_number = $('#buyer_po_number').val();
			if(buyer_po_number){
				
				$("#customers-list").html('');
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>getBuyerItemsforDisplay",
					type: "POST",
					data : {'buyer_po_number' : buyer_po_number},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						}
						else
						{
							//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
							//$('#buyer_po_number').html(data);
							$("#customers-list").html(data);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#buyer_po_number').html();
						//$(".loader_ajax").hide();
					}
				});
				return false;
		    }

		});

		$(document).ready(function() {
			var buyer_po_number = $('.buyer_po_number_for_item').val();
				$("#part_number").html('');
				var flag = 'Buyer';
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>getSuppliritemonlyforgetbuyeritemonlyfrompo",
					type: "POST",
					data : {'supplier_po_number' : buyer_po_number,'flag':flag},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$('#part_number').html('<option value="">Select Part Number</option>');
						}
						else
						{
							$('#part_number').html(data);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#part_number').html();
					}
				});
				return false;
		});	

		$(document).on('click','#savenewsupplierpo',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnewSupplierform")[0]);
			var sup_id = $('#sup_id').val();

			$.ajax({
				url : "<?php echo base_url();?>addnewSupplierpo",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {

						swal({
							title: "Success",
							text: "Supplier PO Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'supplierpo'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deleteSupplierpo',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Supplier PO ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteSupplierpo",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Supplier PO Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'supplierpo'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Supplier PO deletion cancelled ", "error");
				}
			});
		});

		$(document).on('click','.closeSupplierpo', function(){
			location.reload();
        });

		$(document).on('change','#part_number',function(e){  
			e.preventDefault();
			
			//$(".loader_ajax").show();
			var part_number = $('#part_number').val();
			
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getPartnumberByid",
				type: "POST",
				data : {'part_number' : part_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#description').value('');
						$('#diameter').val('');
						$('#slitting_size').val('');
						$('#thickness').val('');
						$('#hex_af').val('');
						$('#hsn_code').val('');
						$('#length').val('');
						$('#gross_weight').val('');
						$('#net_weight').val('');
						$('#sac').val('');
					}
					else
					{
						var data_row_material = jQuery.parseJSON( data );
						$('#description').val(data_row_material.type_of_raw_material);
						$('#diameter').val(data_row_material.diameter);
						$('#slitting_size').val(data_row_material.sitting_size);
						$('#thickness').val(data_row_material.thickness);
						$('#hex_af').val(data_row_material.hex_a_f);
						$('#hsn_code').val(data_row_material.HSN_code);
						$('#length').val(data_row_material.length);
						$('#gross_weight').val(data_row_material.gross_weight);
						$('#net_weight').val(data_row_material.net_weight);
						$('#sac').val(data_row_material.sac);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					    $('#description').value('');
						$('#diameter').val('');
						$('#slitting_size').val('');
						$('#thickness').val('');
						$('#hex_af').val('');
						$('#hsn_code').val('');
						$('#length').val('');
						$('#gross_weight').val('');
						$('#net_weight').val('');
						$('#sac').val('');
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('blur', '#qty,#rate', function(){
				if($("#qty").val()){
					var qty = $("#qty").val();
				}else{
					var qty = 0;
				}

				if($("#rate").val()){
					var rate = $("#rate").val();
				}else{
					var rate = 0;
				}
				
				var total_value = rate * qty;
				$("#value").val( Math.round(total_value));
        });

		$(document).on('click','#savesupplieritem',function(e){
			e.preventDefault();
			$(".loader_ajax").show();

			   var formData = new FormData($("#addbuyeritemform")[0]);
             
			   if($('#part_number').val()){
				   var part_number =  $('#part_number').val() ;
			   }else{
				   var part_number =   $('#part_number_1_edit').val();
			   }
			   
			   var description =   $('#description').val();
			   var qty =   $('#qty').val();
			   var rate =   $('#rate').val();
			   var value =   $('#value').val();

			   var vendor_qty =   $('#vendor_qty').val();
			   var unit =   $('#unit').val();
			   var item_remark =   $('#item_remark').val();

			   var date =   $('#date').val();
			   var supplier_name =   $('#supplier_name').val();
			   var buyer_name =   $('#buyer_name').val();
			   var buyer_po_number =   $('#buyer_po_number').val();
			   var vendor_name =   $('#vendor_name').val();
			   var quatation_ref_no =   $('#quatation_ref_no').val();
			   var quatation_date =   $('#quatation_date').val();
			   var delivery_date =   $('#delivery_date').val();
			   var delivery =   $('#delivery').val();
			   var delivery_address =   $('#delivery_address').val();
			   var work_order =   $('#work_order').val();
			   var remark =   $('#remark').val();
			   
			   var description_1 =   $('#description_1').val();
			   var description_2 =   $('#description_2').val();
			   var sup_id=  $('#sup_id').val();

			   var supplier_po_item_id=  $('#supplier_po_item_id').val();
					 
			$.ajax({
				url : "<?php echo base_url();?>addSuplieritem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,qty:qty,rate:rate,value:value,date:date,supplier_name:supplier_name,buyer_name:buyer_name,vendor_name:vendor_name,quatation_ref_no:quatation_ref_no,quatation_date:quatation_date,delivery_date:delivery_date,delivery:delivery,delivery_address:delivery_address,work_order:work_order,remark:remark,buyer_po_number:buyer_po_number,vendor_qty:vendor_qty,unit:unit,item_remark:item_remark,sup_id:sup_id,description_1:description_1,description_2:description_2,supplier_po_item_id:supplier_po_item_id},
				// method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {

						if(sup_id){

								swal({
								title: "Success",
								text: "Item Successfully Updated!",
								icon: "success",
								button: "Ok",
								},function(){ 
									window.location.href = "<?php echo base_url().'editSupplierpo/'?>"+sup_id;
								});	

						}else{
								swal({
								title: "Success",
								text: "Item Successfully Added!",
								icon: "success",
								button: "Ok",
								},function(){ 
									window.location.href = "<?php echo base_url().'addnewSupplierpo'?>";
								});	
						}

							
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deleteSupplierpoitem',function(e){
			var elemF = $(this);

			
			var sup_id =   $('#sup_id').val();
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Supplier PO Item ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteSupplierpoitem",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Supplier PO Item Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 

												if(sup_id){
													window.location.href = "<?php echo base_url().'editSupplierpo/'?>"+sup_id;
												}else{
													window.location.href = "<?php echo base_url().'addnewSupplierpo'?>";
												}
												
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Supplier PO Item deletion cancelled ", "error");
				}
			});
		});

		$(document).on('change','#buyer_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			$("#customers-list").html('');
			var buyer_name = $('#buyer_name').val();
		    $('.buyer_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerPonumberbyBuyeridforsupplierandvendorpo",
				type: "POST",
				data : {'buyer_name' : buyer_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						$('#buyer_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#buyer_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});
		
		$(document).on('change','#buyer_po_number',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var buyer_po_number = $('#buyer_po_number').val();
			$("#customers-list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerItemsforDisplay",
				type: "POST",
				data : {'buyer_po_number' : buyer_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#customers-list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#buyer_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});


		$(document).on('change','.buyer_po_number_for_item',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var buyer_po_number = $('.buyer_po_number_for_item').val();

			$("#part_number").html('');

			var flag = 'Buyer';
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getSuppliritemonlyforgetbuyeritemonlyfrompo",
				type: "POST",
				data : {'supplier_po_number' : buyer_po_number,'flag':flag},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;
		});


		$(document).on('click','.editSupplierpoitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');

			$("#part_number_old").hide();
			$("#part_number_new").show();


			$.ajax({
				url : "<?php echo base_url();?>getSupplieritemdataforitemedit",
				type: "POST",
				data : 'id='+item_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 
						$('#supplier_po_item_id').val(fetchResponse.supplier_item_id); 
						$('#part_number_1').val(fetchResponse.raw_id);  
						$('#part_number_1_edit').val(fetchResponse.raw_id);  
						$('#description').val(fetchResponse.description);  
						$('#diameter').val(fetchResponse.diameter);  
						$('#slitting_size').val(fetchResponse.sitting_size);  
						$('#thickness').val(fetchResponse.thickness);  
						$('#hex_af').val(fetchResponse.hex_a_f);  
						$('#hsn_code').val(fetchResponse.HSN_code);  
						$('#length').val(fetchResponse.length);  
						$('#gross_weight').val(fetchResponse.gross_weight);  
						$('#net_weight').val(fetchResponse.net_weight);  
						$('#sac').val(fetchResponse.sac);  
						$('#description_1').val(fetchResponse.description_1);  
						$('#description_2').val(fetchResponse.description_2);  	
						$('#vendor_qty').val(fetchResponse.vendor_qty);  	
						$('#qty').val(fetchResponse.order_oty);  
						$('#unit').val(fetchResponse.unit);  
						$('#rate').val(fetchResponse.rate);  
						$('#value').val(fetchResponse.value);  
						$('#item_remark').val(fetchResponse.item_remark);  
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		});

		$(document).on('click','.createnewitem',function(e){  
			$("#part_number_old").show();
			$("#part_number_new").hide();
		});

    </script>
<?php } ?>


<?php if($pageTitle=='Add Supplier PO' || $pageTitle=='Supplier PO View'){ ?>
	<script type="text/javascript">
		
		$( document ).ready(function() {
			
			var buyer_po_number = $('#buyer_po_number').val();
			$("#customers-list").html('');

			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerItemsforDisplay",
				type: "POST",
				data : {'buyer_po_number' : buyer_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#customers-list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					//$('#buyer_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

   
		// $( document ).ready(function() {
		// 	var buyer_po_id = $('#buyer_po_number').val();

		// 	$.ajax({
		// 		url : "<?php echo ADMIN_PATH;?>getBuyerItemsforDisplayBybuyerid",
		// 		type: "POST",
		// 		data : {'buyer_po_id' : buyer_po_id},
		// 		success: function(data, textStatus, jqXHR)
		// 		{
		// 			$(".loader_ajax").hide();
		// 			if(data == "failure")
		// 			{
		// 				//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
		// 			}
		// 			else
		// 			{
		// 				$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
		// 				$('#buyer_po_number').html(data);
		// 				//$("#customers-list").html(data);

		// 			}
		// 		},
		// 		error: function (jqXHR, textStatus, errorThrown)
		// 		{
		// 			$('#buyer_po_number').html();
		// 			//$(".loader_ajax").hide();
		// 		}
		// 	});
		// 	return false;
		// });

    </script>
<?php } ?>


<?php if($pageTitle=='Vendor PO Master' || $pageTitle=='Add Vendor PO' || $pageTitle=='Edit Vendor PO' ){ ?>
	<script type="text/javascript">

		$(document).ready(function() {
            var dt = $('#view_vendorpo').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "15%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "15%", "targets": 4 },
	                 { "width": "10%", "targets": 5 },
					 { "width": "10%", "targets": 6 },
					 { "width": "10%", "targets": 7 },
					
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Vendor PO List Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchVendorpolist",
                    type: "post",
	            },
	        });
	    });

		$( document ).ready(function() {
			
			var buyer_po_number = $('#buyer_po_number').val();
			$("#customers-list").html('');

			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerItemsforDisplay",
				type: "POST",
				data : {'buyer_po_number' : buyer_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#customers-list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					//$('#buyer_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$( document ).ready(function() {
			//e.preventDefault();
			//$(".loader_ajax").show();
			var supplier_po_number = $('#supplier_po_number').val();
			$("#supplier_po_item_list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getSupplierItemsforDisplay",
				type: "POST",
				data : {'supplier_po_number' : supplier_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#supplier_po_item_list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#supplier_po_item_list').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$( document ).ready(function() {
			
			var buyer_po_number = $('.buyer_po_number_for_item').val();

				$("#part_number").html('');

				var flag = 'Buyer';

				$.ajax({
					url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
					type: "POST",
					data : {'supplier_po_number' : buyer_po_number,'flag':flag},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$('#part_number').html('<option value="">Select Part Number</option>');
						}
						else
						{
							$('#part_number').html(data);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#part_number').html();
					}
				});
				return false;
		});

		$(document).on('change','#buyer_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			$("#customers-list").html('');
			var buyer_name = $('#buyer_name').val();
		    $('.buyer_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerPonumberbyBuyeridvendorpo",
				type: "POST",
				data : {'buyer_name' : buyer_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						$('#buyer_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#buyer_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});
		
		$(document).on('change','#buyer_po_number',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var buyer_po_number = $('#buyer_po_number').val();
			$("#customers-list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerItemsforDisplay",
				type: "POST",
				data : {'buyer_po_number' : buyer_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#customers-list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					//$('#buyer_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('click','#savenewvendorpo',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnewVendorform")[0]);

			var vendor_id =   $('#vendor_id').val();

			$.ajax({
				url : "<?php echo base_url();?>addnewVendorpo",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {

						if(vendor_id){

							swal({
								title: "Success",
								text: "Vendor PO Successfully Updated!",
								icon: "success",
								button: "Ok",
								},function(){ 
									window.location.href = "<?php echo base_url().'vendorpo'?>";
								});		


						}else{
								swal({
								title: "Success",
								text: "Vendor PO Successfully Added!",
								icon: "success",
								button: "Ok",
								},function(){ 
									window.location.href = "<?php echo base_url().'vendorpo'?>";
								});		
						}
						
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.cloVendorpo', function(){
			location.reload();
        });

		$(document).on('change','#part_number',function(e){  
			e.preventDefault();
			
						//$(".loader_ajax").show();
						var part_number = $('#part_number').val();
          
						if($('#supplier_po_number').val()){
							var po_number = $('#supplier_po_number').val();
							var flag = 'Supplier';
						}else{
							var po_number = $('#buyer_po_number').val();
							var flag = 'Buyer';
						}

	
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getfinishedgoodsPartnumberByidvendor",
							type: "POST",
							data : {'part_number' : part_number,'po_number':po_number,'flag':flag},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#description').val('');
									$('#HSN_Code').val('');
									$('#gross_weight').val('');
									$('#net_weight').val('');
									$('#SAC').val('');
									$('#drawing_number').val('');
									$('#description_1').val('');
									$('#description_2').val('');
									$('#qty').val('');
									$('#vendor_qty').val('');
									//$('#unit').val('');
									$('#rm_type').val('');

								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );
									$('#description').val(data_row_material.name);
									$('#HSN_Code').val(data_row_material.hsn_code);
									$('#gross_weight').val(data_row_material.groass_weight);
									$('#net_weight').val(data_row_material.supplier_goods_net_weight);
									$('#SAC').val(data_row_material.supplier_goods_sac);
									$('#drawing_number').val(data_row_material.drawing_number);
									//$('#description_1').val(data_row_material.description_1);
									//$('#description_2').val(data_row_material.description_2);

									if($('#supplier_name').val()){
										$('#qty').val(data_row_material.vendor_qty);
									    $('#vendor_qty').val(data_row_material.order_oty);
									}else{
										$('#qty').val();
										$('#vendor_qty').val();
									}
								
									//$('#unit').val(data_row_material.unit);
									$('#rm_type').val(data_row_material.type_of_raw_material);
									

								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
									$('#description').val('');
									$('#HSN_Code').val('');
									$('#gross_weight').val('');
									$('#net_weight').val('');
									$('#SAC').val('');
									$('#drawing_number').val('');
									$('#description_1').val('');
									$('#description_2').val('');
									$('#qty').val('');
									$('#vendor_qty').val('');
									//$('#unit').val('');
									$('#rm_type').val('');
								//$(".loader_ajax").hide();
							}
						});
						return false;
			
		});

		$(document).on('blur', '#qty,#rate', function(){
				if($("#qty").val()){
					var qty = $("#qty").val();
				}else{
					var qty = 0;
				}

				if($("#rate").val()){
					var rate = $("#rate").val();
				}else{
					var rate = 0;
				}
				
				var total_value = rate * qty;
				$("#value").val( Math.round(total_value));
        });

		$(document).on('click','#savevenodritem',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			   var formData = new FormData($("#addvendoritemform")[0]);

			   if($('#part_number').val()){
				   var part_number =  $('#part_number').val() ;
			   }else{
				   var part_number =   $('#part_number_1_edit').val();
			   }

               //var part_number =   $('#part_number').val();
			   var description =   $('#description').val();
			   var qty =   $('#qty').val();
			   var rate =   $('#rate').val();
			   var value =   $('#value').val();
			   var rm_type =   $('#rm_type').val();
			
			   var vendor_qty =   $('#vendor_qty').val();
			   var unit =   $('#unit').val();
			   var item_remark =   $('#item_remark').val();

			   var date =   $('#date').val();
			   var supplier_name =   $('#supplier_name').val();
			   var supplier_po_number =   $('#supplier_po_number').val();
			   var buyer_name =   $('#buyer_name').val();
			   var buyer_po_number =   $('#buyer_po_number').val();
			   var vendor_name =   $('#vendor_name').val();
			   var quatation_ref_no =   $('#quatation_ref_no').val();
			   var quatation_date =   $('#quatation_date').val();
			   var delivery_date =   $('#delivery_date').val();
			   var delivery =   $('#delivery').val();
			   var delivery_address =   $('#delivery_address').val();
			   var work_order =   $('#work_order').val();
			   var remark =   $('#remark').val();

			   var vendor_id =   $('#vendor_id').val();

			   var description_1 =   $('#description_1').val();
			   var description_2 =   $('#description_2').val();

			   var vendor_po_item_id = $('#vendor_po_item_id').val();
			   
					 
			$.ajax({
				url : "<?php echo base_url();?>addVendoritem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,qty:qty,rate:rate,value:value,date:date,supplier_name:supplier_name,buyer_name:buyer_name,vendor_name:vendor_name,quatation_ref_no:quatation_ref_no,quatation_date:quatation_date,delivery_date:delivery_date,delivery:delivery,delivery_address:delivery_address,work_order:work_order,remark:remark,buyer_po_number:buyer_po_number,vendor_qty:vendor_qty,unit:unit,item_remark:item_remark,rm_type:rm_type,supplier_po_number:supplier_po_number,vendor_id:vendor_id,description_1:description_1,description_2:description_2,vendor_po_item_id:vendor_po_item_id},
				// method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {

						if(vendor_id){


							swal({
									title: "Success",
									text: "Item Successfully Added!",
									icon: "success",
									button: "Ok",
									},function(){ 
										window.location.href = "<?php echo base_url().'editVendorpo/'?>"+vendor_id;
							   });	

						}else{
								swal({
								title: "Success",
								text: "Item Successfully Added!",
								icon: "success",
								button: "Ok",
								},function(){ 
									window.location.href = "<?php echo base_url().'addnewVendorpo'?>";
							   });	

						}

							
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deleteVendorpo',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Vendor PO ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteVendorpo",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Vendor PO Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'vendorpo'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Vendor PO deletion cancelled ", "error");
				}
			});
		});

		$(document).on('click','.deleteVendorpoitem',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Supplier PO Item ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteVendorpoitem",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Vendor PO Item Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'addnewVendorpo'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Vendor PO Item deletion cancelled ", "error");
				}
			});
		});

		$(document).on('change','#supplier_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var supplier_name = $('#supplier_name').val();

			if(supplier_name){

		    $('.supplier_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getSupplierPonumberbySupplieridvendorponew",
				type: "POST",
				data : {'supplier_name' : supplier_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('.supplier_po_number_div').css('display','block');
						$('#supplier_po_number').html('<option value="">Select Supplier PO Number</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#supplier_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#supplier_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		}else{
			
			$('.supplier_po_number_div').css('display','none');
			var buyer_po_number_for_vendor_details = $('.buyer_po_number_for_vendor_details').val();

			$("#vendor_name").html('');

			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorDetailsBybuyerPOnumber",
				type: "POST",
				data : {'supplier_po_number' : buyer_po_number_for_vendor_details},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#vendor_name').html('<option value="">Select Vendor Name</option>');
					}
					else
					{
						$('#vendor_name').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_name').html();
				}
			});
			return false;

		}
		});

		$(document).on('change','#supplier_po_number',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			
			var supplier_po_number = $('#supplier_po_number').val();
			$("#supplier_po_item_list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getSupplierItemsforDisplay",
				type: "POST",
				data : {'supplier_po_number' : supplier_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#supplier_po_item_list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#supplier_po_item_list').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		// $(document).on('change','.supplier_po_number_for_item',function(e){  
		// 	e.preventDefault();
		// 	//$(".loader_ajax").show();
		// 	var supplier_po_number = $('.supplier_po_number_for_item').val();

		// 	var flag = 'Supplier';


		// 	$("#part_number").html('');
		
		// 	$.ajax({
		// 		url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
		// 		type: "POST",
		// 		data : {'supplier_po_number' : supplier_po_number,'flag':flag},
		// 		success: function(data, textStatus, jqXHR)
		// 		{
		// 			$(".loader_ajax").hide();
		// 			if(data == "failure")
		// 			{
		// 				$('#part_number').html('<option value="">Select Part Number</option>');
		// 			}
		// 			else
		// 			{
		// 				$('#part_number').html(data);

		// 			}
		// 		},
		// 		error: function (jqXHR, textStatus, errorThrown)
		// 		{
		// 			$('#part_number').html();
		// 		}
		// 	});
		// 	return false;
		// });

		$(document).on('change','.buyer_po_number_for_item',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var buyer_po_number = $('.buyer_po_number_for_item').val();

			$("#part_number").html('');

			var flag = 'Buyer';
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
				type: "POST",
				data : {'supplier_po_number' : buyer_po_number,'flag':flag},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;
		});

		$(document).on('change','.supplier_po_number_for_vendor_details',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var supplier_po_number_for_vendor_details = $('.supplier_po_number_for_vendor_details').val();

			$("#vendor_name").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorDetailsBysupplierponumber",
				type: "POST",
				data : {'supplier_po_number' : supplier_po_number_for_vendor_details},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#vendor_name').html('<option value="">Select Vendor Name</option>');
					}
					else
					{
						$('#vendor_name').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_name').html();
				}
			});
			return false;
		});

		$(document).on('change','.buyer_po_number_for_vendor_details',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var supplier_name = $('#supplier_name').val();
			if(supplier_name==""){

			var buyer_po_number_for_vendor_details = $('.buyer_po_number_for_vendor_details').val();

			$("#vendor_name").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorDetailsBybuyerPOnumber",
				type: "POST",
				data : {'supplier_po_number' : buyer_po_number_for_vendor_details},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#vendor_name').html('<option value="">Select Vendor Name</option>');
					}
					else
					{
						$('#vendor_name').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_name').html();
				}
			});
			return false;

		}
		});

		$(document).on('change','.supplier_po_for_fetch_buyer_details',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var supplier_po_for_fetch_buyer_details = $('.supplier_po_for_fetch_buyer_details').val();

			$("#buyer_name").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerDetailsBysupplierponumberforbuyer",
				type: "POST",
				data : {'supplier_po_number' : supplier_po_for_fetch_buyer_details},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#buyer_name').html('<option value="">Select Buyer Name</option>');
					}
					else
					{

						$('#buyer_name').html(data);

						$(".autobuyerpo").html('');

						    $.ajax({
								url : "<?php echo ADMIN_PATH;?>getBuyerDetailsBysupplierponumberforbuyerpo",
								type: "POST",
								data : {'supplier_po_number' : supplier_po_for_fetch_buyer_details},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{
										$('.autobuyerpo').html('<option value="">Select Buyer PO</option>');
									}
									else
									{
 
										$('.autobuyerpo').html(data);


										$.ajax({
											url : "<?php echo ADMIN_PATH;?>getbuyerpoidforshowinitems",
											type: "POST",
											data : {'supplier_po_number' : supplier_po_for_fetch_buyer_details},
											success: function(data, textStatus, jqXHR)
											{
												$(".loader_ajax").hide();
												if(data == "failure")
												{
													//$('.autobuyerpo').html('<option value="">Select Buyer Name</option>');
												}
												else
												{

													           //$('.autobuyerpo').html(data);

														       var buyer_po_number = data;
																$("#customers-list").html('');

																$.ajax({
																	url : "<?php echo ADMIN_PATH;?>getBuyerItemsforDisplay",
																	type: "POST",
																	data : {'buyer_po_number' : buyer_po_number},
																	success: function(data, textStatus, jqXHR)
																	{
																		$(".loader_ajax").hide();
																		if(data == "failure")
																		{
																			//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
																		}
																		else
																		{
																			// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
																			//$('#buyer_po_number').html(data);
																			$("#customers-list").html(data);

																		}
																	},
																	error: function (jqXHR, textStatus, errorThrown)
																	{
																		//$('#buyer_po_number').html();
																		//$(".loader_ajax").hide();
																	}
																});



																var buyer_po_number = $('.buyer_po_number_for_item').val();

																	$("#part_number").html('');

																	var flag = 'Buyer';
																
																	$.ajax({
																		url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
																		type: "POST",
																		data : {'supplier_po_number' : buyer_po_number,'flag':flag},
																		success: function(data, textStatus, jqXHR)
																		{
																			$(".loader_ajax").hide();
																			if(data == "failure")
																			{
																				$('#part_number').html('<option value="">Select Part Number</option>');
																			}
																			else
																			{
																				$('#part_number').html(data);

																			}
																		},
																		error: function (jqXHR, textStatus, errorThrown)
																		{
																			$('#part_number').html();
																		}
																});
																

															
												}
											},
											error: function (jqXHR, textStatus, errorThrown)
											{
												$('#buyer_name').html();
											}
										});



									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$('#buyer_name').html();
								}
							});

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#buyer_name').html();
				}
			});
			return false;
		});

		$(document).on('click','.deleteVendorpoitemedit',function(e){
			var elemF = $(this);
			e.preventDefault();
			var vendor_id =   $('#vendor_id').val();
			swal({
				title: "Are you sure?",
				text: "Delete Vendor PO Item ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteVendorpoitemedit",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Vendor PO Item Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'editVendorpo/'?>"+vendor_id;
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Supplier PO Item deletion cancelled ", "error");
				}
			});
		});


		$(document).on('click','.editVendorpoitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');

			$("#part_number_old").hide();
			$("#part_number_new").show();

			$.ajax({
				url : "<?php echo base_url();?>getVendoritemdataforitemedit",
				type: "POST",
				data : 'id='+item_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 
						$('#vendor_po_item_id').val(fetchResponse.vendor_po_item_id); 
						$('#part_number').val(fetchResponse.fin_id);  
						$('#part_number_1').val(fetchResponse.fin_id);  
						$('#part_number_1_edit').val(fetchResponse.fin_id);  
						$('#description').val(fetchResponse.description);  
						// $('#diameter').val(fetchResponse.diameter);  
						// $('#slitting_size').val(fetchResponse.sitting_size);  
						$('#rm_type').val(fetchResponse.rm_type);  
						$('#drawing_number').val(fetchResponse.drawing_number);  
						$('#HSN_Code').val(fetchResponse.hsn_code);  
						$('#length').val(fetchResponse.length);  
						$('#gross_weight').val(fetchResponse.groass_weight);  
						$('#net_weight').val(fetchResponse.net_weight);  
						$('#SAC').val(fetchResponse.sac);  
						$('#description_1').val(fetchResponse.description_1);  
						$('#description_2').val(fetchResponse.description_2);  	
						$('#vendor_qty').val(fetchResponse.vendor_qty);  	
						$('#qty').val(fetchResponse.order_oty);  
						$('#unit').val(fetchResponse.unit);  
						$('#rate').val(fetchResponse.rate);  
						$('#value').val(fetchResponse.value);  
						$('#item_remark').val(fetchResponse.item_remark);  
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		});


		$(document).on('click','.createnewitem',function(e){  
			$("#part_number_old").show();
			$("#part_number_new").hide();
		});

	
    </script>
<?php } ?>


<?php  if($pageTitle=='Supplier PO Confirmation' || $pageTitle=='Add Supplier PO Confirmation' || $pageTitle=='Edit Supplier PO Confirmation'){ ?>
	<script type="text/javascript">
		$(document).ready(function() {
            var dt = $('#view_supplierpoconfirmation').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "15%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "15%", "targets": 4 },
	                 { "width": "10%", "targets": 5 },
					 { "width": "10%", "targets": 6 },
					 { "width": "10%", "targets": 7 },
					 { "width": "10%", "targets": 8 },
					
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Supplier PO Confirmation List Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchSupplierpoconfirmationlist",
                    type: "post",
	            },
	        });
	    });

		$( document ).ready(function() {
			//e.preventDefault();
			//$(".loader_ajax").show();
			var supplier_po_number = $('#supplier_po_number').val();
			$("#supplier_po_item_list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getSupplierItemsforDisplay",
				type: "POST",
				data : {'supplier_po_number' : supplier_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#supplier_po_item_list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#supplier_po_item_list').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$( document ).ready(function() {
			
			var buyer_po_number = $('#buyer_po_number').val();
			$("#customers-list").html('');

			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerItemsforDisplay",
				type: "POST",
				data : {'buyer_po_number' : buyer_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#customers-list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					//$('#buyer_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});


		$( document ).ready(function() {

		//$(".loader_ajax").show();
		var supplier_po_number = $('.supplier_po_number_for_item').val();
			var flag = 'Supplier';
			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
				type: "POST",
				data : {'supplier_po_number' : supplier_po_number,'flag':flag},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;

        });


		$(document).on('change','#supplier_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var supplier_name = $('#supplier_name').val();
		    $('.supplier_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getSupplierPonumberbySupplierid",
				type: "POST",
				data : {'supplier_name' : supplier_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#supplier_po_number').html('<option value="">Select Supplier PO Number</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#supplier_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#supplier_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','#supplier_po_number',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var supplier_po_number = $('#supplier_po_number').val();
			$("#supplier_po_item_list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getSupplierItemsforDisplay",
				type: "POST",
				data : {'supplier_po_number' : supplier_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#supplier_po_item_list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#supplier_po_item_list').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','#buyer_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			$("#customers-list").html('');
			var buyer_name = $('#buyer_name').val();
		    $('.buyer_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerPonumberbyBuyerid",
				type: "POST",
				data : {'buyer_name' : buyer_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						$('#buyer_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#buyer_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','#buyer_po_number',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var buyer_po_number = $('#buyer_po_number').val();
			$("#customers-list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerItemsforDisplay",
				type: "POST",
				data : {'buyer_po_number' : buyer_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#customers-list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					//$('#buyer_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('click','#savenewsupplierconfrimationpo',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnnewsupplierconfrimationpoform")[0]);

			$.ajax({
				url : "<?php echo base_url();?>addSupplierpoconfirmation",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Supplier PO Confirmation Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'supplierpoconfirmation'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deleteSupplierPoconfirmation',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Supplier PO COnfirmation ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteSupplierPoconfirmation",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Supplier PO Confirmation Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'supplierpoconfirmation'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Supplier PO Confirmation deletion cancelled ", "error");
				}
			});
		});

		$(document).on('change','.supplier_po_number_for_item',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var supplier_po_number = $('.supplier_po_number_for_item').val();
			var flag = 'Supplier';
			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
				type: "POST",
				data : {'supplier_po_number' : supplier_po_number,'flag':flag},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;
		});

		$(document).on('change','#part_number',function(e){  
			e.preventDefault();

			//$(".loader_ajax").show();
			var part_number = $('#part_number').val();
		    var supplier_po_number = $('#supplier_po_number').val();
			var supplier_name = $('#supplier_name').val();

			var selectElement = document.getElementById("part_number");
			// Get the selected option element
			var selectedOption = selectElement.options[selectElement.selectedIndex];

			// Get the value of the data-info attribute of the selected option
			var poitemid = selectedOption.getAttribute("data_id");

			if(supplier_name){
				if(supplier_po_number){
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getRowmaterialPartnumberByidsupplierpoconfirmation",
							type: "POST",
							data : {'part_number' : part_number,'supplier_po_number':supplier_po_number,'poitemid':poitemid},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#description').val('');
									$('#HSN_Code').val('');
									$('#gross_weight').val('');
									$('#net_weight').val('');
									$('#SAC').val('');
									$('#drawing_number').val('');
									$('#description_1').val('');
									$('#description_2').val('');
									$('#qty').val('');
									$('#vendor_qty').val('');
									$('#unit').val('');
									$('#rm_type').val('');
									$('#vendor_name').val('');
									$('#vendor_id').val('');

								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );
									$('#description').val(data_row_material.type_of_raw_material);
									$('#HSN_Code').val(data_row_material.hsn_code);
									$('#gross_weight').val(data_row_material.groass_weight);
									$('#net_weight').val(data_row_material.net_weight);
									$('#SAC').val(data_row_material.sac);
									$('#drawing_number').val(data_row_material.drawing_number);
									$('#description_1').val(data_row_material.description_1);
									$('#description_2').val(data_row_material.description_2);
									$('#qty').val(data_row_material.order_oty);
									$('#vendor_qty').val(data_row_material.vendor_qty);
									$('#unit').val(data_row_material.unit);
									$('#rm_type').val(data_row_material.type_of_raw_material);
									$('#vendor_name').val(data_row_material.vendor_name);
									$('#vendor_id').val(data_row_material.ven_id);
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
									$('#description').val('');
									$('#HSN_Code').val('');
									$('#gross_weight').val('');
									$('#net_weight').val('');
									$('#SAC').val('');
									$('#drawing_number').val('');
									$('#description_1').val('');
									$('#description_2').val('');
									$('#qty').val('');
									$('#vendor_qty').val('');
									$('#unit').val('');
									$('#rm_type').val('');
									$('#vendor_name').val('');
									$('#vendor_id').val('');
								//$(".loader_ajax").hide();
							}
						});
						return false;

				}else{
					$('.part_number_error').html('Please Select Supplier PO Number');
				}

			}else{

				$('.part_number_error').html('Please Select Supplier PO');
			}
			
		});
	
		$(document).on('click','.closeSupplierpoconfirmation', function(){
			location.reload();
        });

		$(document).on('blur', '#qty,#rate', function(){
				if($("#qty").val()){
					var qty = $("#qty").val();
				}else{
					var qty = 0;
				}

				if($("#rate").val()){
					var rate = $("#rate").val();
				}else{
					var rate = 0;
				}
				
				var total_value = rate * qty;
				$("#value").val( Math.round(total_value));
        });

		$(document).on('click','#saveSupplierconfromationpoitem',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			   var formData = new FormData($("#saveSupplierconfromationpoitemform")[0]);
               var part_number =   $('#part_number').val();
			   var description =   $('#description').val();
			   var qty =   $('#qty').val();
			   var rate =   $('#rate').val();
			   var value =   $('#value').val();
			   var unit =   $('#unit').val();
			   var vendor_qty =   $('#vendor_qty').val();
			   var item_remark =   $('#item_remark').val();

			   var pre_date =   $('#date').val();
			   var pre_supplier_name =   $('#supplier_name').val();
			   var pre_supplier_po_number =   $('#supplier_po_number').val();
			   var pre_buyer_name =   $('#buyer_name').val();
			   var pre_buyer_po_number =   $('#buyer_po_number').val();
			   var pre_po_confirmed =   $('#po_confirmed').val();
			   var pre_confirmed_date =   $('#confirmed_date').val();
			   var pre_confirmed_with =   $('#confirmed_with').val();
			   var pre_remark =   $('#remark').val();

			   var short_excess =   $('#short_excess').val();
			   var sent_qty =   $('#sent_qty').val();

			   var sent_qty_pcs =   $('#sent_qty_pcs').val();

			   var vendor_id =   $('#vendor_id').val();

			   var supplierpoconfirmation_id =   $('#supplierpoconfirmation_id').val();
			  
			   var supplier_confirmation_po_item_id =   $('#supplier_confirmation_po_item_id').val();
			   
								 
			$.ajax({
				url : "<?php echo base_url();?>addSupplierpoConfirmationitem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,qty:qty,rate:rate,value:value,unit:unit,vendor_qty:vendor_qty,item_remark:item_remark,pre_date:pre_date,pre_supplier_name:pre_supplier_name,pre_supplier_po_number:pre_supplier_po_number,pre_buyer_name:pre_buyer_name,pre_buyer_po_number:pre_buyer_po_number,pre_po_confirmed:pre_po_confirmed,pre_confirmed_date:pre_confirmed_date,pre_confirmed_with:pre_confirmed_with,pre_remark:pre_remark,short_excess:short_excess,sent_qty:sent_qty,sent_qty_pcs:sent_qty_pcs,vendor_id:vendor_id,supplierpoconfirmation_id:supplierpoconfirmation_id,supplier_confirmation_po_item_id:supplier_confirmation_po_item_id},
				// method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						
						swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								if(supplierpoconfirmation_id){
									window.location.href = "<?php echo base_url().'editSupplierpoconfirmation/'?>"+supplierpoconfirmation_id;
								}else{
									window.location.href = "<?php echo base_url().'addSupplierpoconfirmation'?>";
								}
								
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deleteSupplierpoitem',function(e){
			var elemF = $(this);
			e.preventDefault();

			var supplierpoconfirmation_id =   $('#supplierpoconfirmation_id').val();

			swal({
				title: "Are you sure?",
				text: "Delete Supplier PO Confirmation Item ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteSupplierpoconfirmationitem",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Supplier PO Confirmation Item Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												if(supplierpoconfirmation_id){
													window.location.href = "<?php echo base_url().'editSupplierpoconfirmation/'?>"+supplierpoconfirmation_id;
												}else{
													window.location.href = "<?php echo base_url().'addSupplierpoconfirmation'?>";
												}
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Supplier PO Item deletion cancelled ", "error");
				}
			});
		});

		$(document).on('blur', '#sent_qty,#short_excess', function(){
				
		       $("#short_excess").val();
		 	
			   if($("#sent_qty").val()){
					var sent_qty = $("#sent_qty").val();
				}else{
					var sent_qty = 0;
				}

				if($("#qty").val()){
					var qty = $("#qty").val();
				}else{
					var qty = 0;
				}
				
				var total_value = qty - sent_qty;
				$("#short_excess").val( Math.round(total_value));
        });

		$(document).on('change','.supplier_po_number_for_buyer_details',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var supplier_po_number_for_buyer_details = $('.supplier_po_number_for_buyer_details').val();

			$("#buyer_name").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerDetailsBysupplierponumber",
				type: "POST",
				data : {'supplier_po_number' : supplier_po_number_for_buyer_details},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#buyer_name').html('<option value="">Select Buyer Name</option>');
					}
					else
					{
						$('#buyer_name').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#buyer_name').html();
				}
			});
			return false;
		});


		$(document).on('click','.editSupplierpoconfimationitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			$.ajax({
				url : "<?php echo base_url();?>getSupplierpoconfimationitemedit",
				type: "POST",
				data : 'id='+item_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 

						$('#supplier_confirmation_po_item_id').val(fetchResponse.supplier_confirmation_po_item_id); 
						$('#part_number').val(fetchResponse.raw_id);  
						$('#description').val(fetchResponse.description); 
						$('#qty').val(fetchResponse.order_oty);
						$('#sent_qty').val(fetchResponse.sent_qty);
						$('#unit').val(fetchResponse.unit);
						$('#short_excess').val(fetchResponse.short_excess);
						$('#sent_qty_pcs').val(fetchResponse.sent_qty_pcs);
						$('#vendor_id').val(fetchResponse.vendor_id);
						$('#vendor_name').val(fetchResponse.vendor_name);
						$('#vendor_qty').val(fetchResponse.vendor_qty);
						
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		});


		$(document).on('change','#supplier_name,#supplier_po_number',function(e){  
			e.preventDefault();
			$('.supplier_po_number_error').html('');
			var supplier_name = $('#supplier_name').val();
			var supplier_po_number = $('#supplier_po_number').val();

			var supplierpoconfirmation_id = $('#supplierpoconfirmation_id').val();

			if(supplier_name && supplier_po_number){

				        $.ajax({
							url : "<?php echo ADMIN_PATH;?>checkvendorpoandvendornumberinsupplierpoconfirmation",
							type: "POST",
							data : {'supplier_name' : supplier_name,'supplier_po_number':supplier_po_number,'supplierpoconfirmation_id':supplierpoconfirmation_id},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									
									$('.supplier_po_number_error').val('');
									$('#savenewsupplierconfrimationpo').prop('disabled', false);
									$('.addNewModal').prop('disabled', false);
							
								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );

									if(data_row_material.supplier_po_number){
										$('.supplier_po_number_error').html('Supplier PO Confirmation Alreday Exists For This Supplier PO');
										$('#savenewsupplierconfrimationpo').prop('disabled', true);
										$('.addNewModal').prop('disabled', true);
									}else{

										$('.supplier_po_number_error').html('');
										$('#savenewsupplierconfrimationpo').prop('disabled', false);
										$('.addNewModal').prop('disabled', false);
									}

									// console.log(data_row_material.vendor_po_number);

									//$('#vendor_po_number').val(data_row_material.name);		
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								    $('.supplier_po_number_error').val('');
									$('#savenewsupplierconfrimationpo').prop('disabled', false);
									$('.addNewModal').prop('disabled', false);
							}
						});
						return false;


			}
		});


    </script>
<?php } ?>


<?php  if($pageTitle=='Vendor PO Confirmation' || $pageTitle=='Add Vendor PO Confirmation' || $pageTitle=='Edit Vendor PO Confirmation'){ ?>
	<script type="text/javascript">
        $(document).ready(function() {
            var dt = $('#view_vendorpoconfirmation').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "15%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "15%", "targets": 4 },
	                 { "width": "10%", "targets": 5 },
					 { "width": "10%", "targets": 6 },
					 { "width": "10%", "targets": 7 },
					 { "width": "10%", "targets": 8 },
					
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Vendor PO Confirmation List Not Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchVendorrpoconfirmationlist",
                    type: "post",
	            },
	        });
	    });

		$(document).ready(function() {
			var vendor_po_number = $('#vendor_po_number').val();
			var supplier_po_number = $('#supplier_po_number').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number,'supplier_po_number':supplier_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;
		});

		$(document).on('change','#vendor_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_name = $('#vendor_name').val();
		    $('.vendor_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorPoconfirmationvendorlist",
				type: "POST",
				data : {'vendor_name' : vendor_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#vendor_po_number').html('<option value="">Select Vendor PO Number</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#vendor_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','.vendor_name_for_buyer_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_name_for_buyer_name = $('.vendor_name_for_buyer_name').val();

			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerNamebySupplierid",
				type: "POST",
				data : {'vendor_name' : vendor_name_for_buyer_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#buyer_name').html('<option value="">Select Buyer Name</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#buyer_name').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#buyer_name').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('click','#savenewvendorconfrimationpo',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnnewvendorconfrimationpoform")[0]);

			$.ajax({
				url : "<?php echo base_url();?>addvendorpoconfirmation",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Vendor PO Confirmation Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'vendorpoconfirmation'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('change','.vendor_po_for_item',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();
			var supplier_po_number = $('#supplier_po_number').val();
			

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number,'supplier_po_number':supplier_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;
		});

		$(document).on('change','#part_number',function(e){  
			e.preventDefault();
			
			//$(".loader_ajax").show();
			var part_number = $('#part_number').val();
		    var vendor_po_number = $('#vendor_po_number').val();
			var vendor_name = $('#vendor_name').val();

			var selectElement = document.getElementById("part_number");
			// Get the selected option element
			var selectedOption = selectElement.options[selectElement.selectedIndex];

			// Get the value of the data-info attribute of the selected option
			var poitemid = selectedOption.getAttribute("data_id");



			if(vendor_name){
				if(vendor_po_number){
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getSuppliergoodsPartnumberByidvendorpoconfirmation",
							type: "POST",
							data : {'part_number' : part_number,'vendor_po_number':vendor_po_number,'poitemid':poitemid},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#description').val('');
									$('#HSN_Code').val('');
									$('#gross_weight').val('');
									$('#net_weight').val('');
									$('#SAC').val('');
									$('#drawing_number').val('');
									$('#description_1').val('');
									$('#description_2').val('');
									$('#qty').val('');
									$('#vendor_qty').val('');
									$('#unit').val('');
									//$('#rm_type').val('');
									$('#rmqty').val('');
									$("#expected_qty").val('');

								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );
									$('#description').val(data_row_material.name);
									$('#HSN_Code').val(data_row_material.hsn_code);

									if(data_row_material.groass_weight){
										$('#gross_weight').val(data_row_material.groass_weight);
									}else{
										var zero_val = 0;
										$('#gross_weight').val(zero_val);
									}
									

									if(data_row_material.supplier_sent_qty != "undefined"){
										$('#rmqty').val(data_row_material.supplier_sent_qty);
									}else{
										var zero_val = 0;
										$('#rmqty').val(zero_val);
									}	


									$('#net_weight').val(data_row_material.net_weight);
									$('#SAC').val(data_row_material.sac);
									$('#drawing_number').val(data_row_material.drawing_number);
									$('#description_1').val(data_row_material.description_1);
									$('#description_2').val(data_row_material.description_2);
									$('#qty').val(data_row_material.supplier_order_qty);
									$('#vendor_qty').val(data_row_material.vendor_order_qty);
									$('#unit').val(data_row_material.unit);
									$('#rm_type').val(data_row_material.type_of_raw_material);

								

								
									
										if($("#rmqty").val()){
											var rmqty = $("#rmqty").val();
										}else{
											var rmqty = 0;
										}

										if($("#gross_weight").val()){
											var gross_weight = $("#gross_weight").val();
										}else{
											var gross_weight = 0;
										}
										
										var total_value = rmqty / gross_weight;
										$("#expected_qty").val( Math.round(total_value));
									
									
									
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
									$('#description').val('');
									$('#HSN_Code').val('');
									$('#gross_weight').val('');
									$('#net_weight').val('');
									$('#SAC').val('');
									$('#drawing_number').val('');
									$('#description_1').val('');
									$('#description_2').val('');
									$('#qty').val('');
									$('#vendor_qty').val('');
									$('#unit').val('');
									$('#rm_type').val('');
									$('#rmqty').val('');
									$("#expected_qty").val('');
								//$(".loader_ajax").hide();
							}
						});
						return false;

				}else{
					$('.part_number_error').html('Please Select Vendor PO Number');
				}

			}else{

				$('.part_number_error').html('Please Select Vendor PO');
			}
			
		});
	
		$(document).on('change', '#finishedgoodqty,#gross_weight', function(){	
				$("#expected_qty").val();
			  
				if($("#rmqty").val()){
					 var rmqty = $("#rmqty").val();
				 }else{
					 var rmqty = 0;
				 }

				 if($("#gross_weight").val()){
					 var gross_weight = $("#gross_weight").val();
				 }else{
					 var gross_weight = 0;
				 }
				 
				 var total_value = rmqty / gross_weight;
				 $("#expected_qty").val( Math.round(total_value));
		});

		$(document).on('click','#saveVendorconfromationpoitem',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			   var formData = new FormData($("#saveVendorconfromationpoitemform")[0]);
               var part_number =   $('#part_number').val();
			   var description =   $('#description').val();
			   var vendor_qty =   $('#vendor_qty').val();
			   var qty =   $('#qty').val();
			   var rmqty =   $('#rmqty').val();
			   var finishedgoodqty =   $('#finishedgoodqty').val();
			   var gross_weight =   $('#gross_weight').val();
			   var expected_qty =   $('#expected_qty').val();
			   var item_remark =   $('#item_remark').val();

			   var pre_vendor_name =   $('#vendor_name').val();
			   var pre_vendor_po_number =   $('#vendor_po_number').val();
			   var pre_buyer_name =   $('#buyer_name').val();
			   var pre_po_confirmed =   $('#po_confirmed').val();
			   var pre_confirmed_date =   $('#confirmed_date').val();
			   var pre_confirmed_with =   $('#confirmed_with').val();
			   var pre_remark =   $('#remark').val();
			   var pre_date =   $('#date').val();
			   

			   var venodr_po_confirmation_id =   $('#venodr_po_confirmation_id').val();

			   var vendor_po_confirmation_item_id =   $('#vendor_po_confirmation_item_id').val();
								 
			$.ajax({
				url : "<?php echo base_url();?>saveVendorconfromationpoitem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,vendor_qty:vendor_qty,qty:qty,rmqty:rmqty,finishedgoodqty:finishedgoodqty,gross_weight:gross_weight,expected_qty:expected_qty,item_remark:item_remark,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_buyer_name:pre_buyer_name,pre_po_confirmed:pre_po_confirmed,pre_confirmed_date:pre_confirmed_date,pre_confirmed_with:pre_confirmed_with,pre_remark:pre_remark,pre_date:pre_date,venodr_po_confirmation_id:venodr_po_confirmation_id,vendor_po_confirmation_item_id:vendor_po_confirmation_item_id},
				// method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								if(venodr_po_confirmation_id){
									window.location.href = "<?php echo base_url().'editvendorpoconfirmation/'?>"+venodr_po_confirmation_id;
								}else{
									window.location.href = "<?php echo base_url().'addVendorpoconfirmation'?>";
								}
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deletevendorpoitem',function(e){
			var elemF = $(this);
			e.preventDefault();

			var venodr_po_confirmation_id = $('#venodr_po_confirmation_id').val();

			swal({
				title: "Are you sure?",
				text: "Delete Vendor PO Confirmation Item ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteVendorpoconfirmatuionitem",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Vendor PO Confirmation Item Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 

												if(venodr_po_confirmation_id){
													window.location.href = "<?php echo base_url().'editvendorpoconfirmation/'?>"+venodr_po_confirmation_id;
												}else{
													window.location.href = "<?php echo base_url().'addVendorpoconfirmation'?>";
												}
												
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Vendor PO Item deletion cancelled ", "error");
				}
			});
		});

		$(document).on('click','.deleteVendorPoconfirmation',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Vendor PO COnfirmation ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteVendorPoconfirmation",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Vendor PO Confirmation Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'vendorpoconfirmation'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Supplier PO Confirmation deletion cancelled ", "error");
				}
			});
		});

		$(document).on('click','.closeVendorpoconfirmation', function(){
			location.reload();
        });

		$(document).on('change','.vendor_po_get_data',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_po_id = $('.vendor_po_get_data').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>get_vendorpodata",
				type: "POST",
				data : {'vendor_po_id' : vendor_po_id},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#supplier_po_number').val('');
					}
					else
					{
						var get_vendorpodata = jQuery.parseJSON( data );
						$('#supplier_po_number').val(get_vendorpodata.supplier_po_number);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#supplier_po_number').val('');
				}
			});
			return false;
		});


		$(document).on('click','.editvendorpoconfirmationitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			$.ajax({
				url : "<?php echo base_url();?>getvendorpoconfirmationitemedit",
				type: "POST",
				data : 'id='+item_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 

						$('#vendor_po_confirmation_item_id').val(fetchResponse.vendor_po_confirmation_item_id); 
						$('#part_number').val(fetchResponse.fin_id);  
						$('#description').val(fetchResponse.description); 
						$('#vendor_qty').val(fetchResponse.vendor_qty);
						$('#qty').val(fetchResponse.order_qty);
						$('#rmqty').val(fetchResponse.row_material_recived_qty);
						$('#finishedgoodqty').val(fetchResponse.finished_good_recived_qty);
						$('#gross_weight').val(fetchResponse.gross_weight);
						$('#expected_qty').val(fetchResponse.expected_qty);
						$('#item_remark').val(fetchResponse.item_remark);
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		});


		$(document).on('change','#vendor_name,#vendor_po_number',function(e){  
			e.preventDefault();
			$('.vendor_po_number_error').html('');
			var vendor_name = $('#vendor_name').val();
			var vendor_po_number = $('#vendor_po_number').val();
			var venodr_po_confirmation_id = $('#venodr_po_confirmation_id').val();

			if(vendor_name && vendor_po_number){

				        $.ajax({
							url : "<?php echo ADMIN_PATH;?>checkvendorpoandvendornumberinvendorpoconfirmation",
							type: "POST",
							data : {'vendor_name' : vendor_name,'vendor_po_number':vendor_po_number,'venodr_po_confirmation_id':venodr_po_confirmation_id},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('.vendor_po_number_error').val('');
									$('#savenewvendorconfrimationpo').prop('disabled', false);
									$('.addNewModal').prop('disabled', false);
							
								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );

									if(data_row_material.vendor_po_number){
										$('.vendor_po_number_error').html('Vendor PO Confirmation Alreday Exists For This Vendor PO');
										$('#savenewvendorconfrimationpo').prop('disabled', true);
										$('.addNewModal').prop('disabled', true);

									}else{

										$('.vendor_po_number_error').html('');
										$('#savenewvendorconfrimationpo').prop('disabled', false);
										$('.addNewModal').prop('disabled', false);

									}

									// console.log(data_row_material.vendor_po_number);

									//$('#vendor_po_number').val(data_row_material.name);		
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								    $('.vendor_po_number_error').val('');
									$('#savenewvendorconfrimationpo').prop('disabled', false);
									$('.addNewModal').prop('disabled', false);

							}
						});
						return false;


			}
		});


    </script>
<?php } ?>


<?php  if($pageTitle=='Job Work' || $pageTitle=="Add Job Work" || $pageTitle=="Edit Job Work"){ ?>
	<script type="text/javascript">
        $(document).ready(function() {
            var dt = $('#view_Job_Work').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "15%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "15%", "targets": 4 },
	                 { "width": "8%", "targets": 5 }
					
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>Job Work List Not Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchJobworklist",
                    type: "post",
	            },
	        });
	    });

		$(document).ready(function() {
			
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;

		});

		$(document).on('click','#savenewjobwork',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var job_work_id =   $('#job_work_id').val();
			var formData = new FormData($("#addnnewjobworkform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addjobwork",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {

				
							swal({
							title: "Success",
							text: "Job Work Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'jobWork'?>";
						   });		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('change','#vendor_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_name = $('#vendor_name').val();
		    $('.vendor_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorPonumberbySupplierid",
				type: "POST",
				data : {'vendor_name' : vendor_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#vendor_po_number').html('<option value="">Select Vendor PO Number</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#vendor_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','#vendor_po_number',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_po_number = $('#vendor_po_number').val();
		    //$('.vendor_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getSuppliernamebyvendorpo",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#raw_material_supplier_name').html('<option value="">Select Row Material Supplier Name</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#raw_material_supplier_name').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#raw_material_supplier_name').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','.vendor_po_number_itam',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;
		});

		$(document).on('change','#part_number',function(e){  
			e.preventDefault();
			
			//$(".loader_ajax").show();
			var part_number = $('#part_number').val();
		    var vendor_po_number = $('#vendor_po_number').val();
			var vendor_name = $('#vendor_name').val();


			var raw_material_supplier_name = $('#raw_material_supplier_name').val();

			if(vendor_name){
				if(vendor_po_number){
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getSuppliergoodsPartnumberByidjobwork",
							type: "POST",
							data : {'part_number' : part_number,'vendor_po_number':vendor_po_number,'raw_material_supplier_name':raw_material_supplier_name},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#description').val('');
									$('#SAC').val('');
									$('#HSN_Code').val('');
									$('#raw_material_size').val('');
									$('#vendor_order_qty').val('');
									$('#unit').val('');
									$('#rm_rate').val('');

								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );
									$('#description').val(data_row_material.name);
									$('#SAC').val(data_row_material.sac_no);
									$('#HSN_Code').val(data_row_material.hsn_code);
									$('#raw_material_size').val(data_row_material.type_of_raw_material);
									$('#vendor_order_qty').val(data_row_material.vendor_order_qty);
									$('#unit').val(data_row_material.unit);
									$('#rm_rate').val(data_row_material.supplierrate);
									
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								    $('#description').val('');
									$('#SAC').val('');
									$('#HSN_Code').val('');
									$('#raw_material_size').val('');
									$('#vendor_order_qty').val('');
									$('#unit').val('');
									$('#rm_rate').val('');									
								    //$(".loader_ajax").hide();
							}
						});
						return false;

				}else{
					$('.part_number_error').html('Please Select Vendor PO Number');
				}

			}else{

				$('.part_number_error').html('Please Select Vendor PO');
			}
			
		});

		$(document).on('click','#saveJobworktem',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			   var formData = new FormData($("#savejobworkitemform")[0]);
              
			   var part_number =   $('#part_number').val();
			   var description =   $('#description').val();
			   var SAC_no =   $('#SAC').val();
			   var HSN_Code =   $('#HSN_Code').val();
			   var raw_material_size =   $('#raw_material_size').val();
			   var vendor_order_qty =   $('#vendor_order_qty').val();
			   var rm_actual_aty =   $('#rm_actual_aty').val();
			   var unit =   $('#unit').val();
			   var rm_rate =   $('#rm_rate').val();
			   var value =   $('#value').val();
			   var packing_and_forwarding =   $('#packing_and_forwarding').val();
			   var total =   $('#total').val();
			   var gst =   $('#gst').val();
			   var gst_rate =   $('#gst_rate').val();
			   var grand_total =   $('#grand_total').val();
			   var item_remark =   $('#item_remark').val();

			   var pre_date =   $('#date').val();
			   var pre_vendor_name =   $('#vendor_name').val();
			   var pre_vendor_po_number =   $('#vendor_po_number').val();
			   var pre_raw_material_supplier_name =   $('#raw_material_supplier_name').val();
			   var pre_remark =   $('#remark').val();


			   var job_work_id =   $('#job_work_id').val();

			   var jobwork_item_id =   $('#jobwork_item_id').val();

			 
			$.ajax({
				url : "<?php echo base_url();?>saveJobworktem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number ,description:description,SAC_no:SAC_no,HSN_Code:HSN_Code,raw_material_size:raw_material_size,vendor_order_qty:vendor_order_qty,rm_actual_aty:rm_actual_aty,unit:unit,rm_rate:rm_rate,value:value,packing_and_forwarding:packing_and_forwarding,total:total,gst:gst,grand_total:grand_total,item_remark:item_remark,pre_date:pre_date,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_raw_material_supplier_name:pre_raw_material_supplier_name,pre_remark:pre_remark,job_work_id:job_work_id,gst_rate:gst_rate,jobwork_item_id:jobwork_item_id},
				// method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {


						if(job_work_id){

							swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'editjobwork/'?>"+job_work_id;
						    });	

						}else{

							swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'addjobwork'?>";
						    });	

						}

							
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.closejobworkmodal', function(){
			location.reload();
        });

		$(document).on('change', '#rm_actual_aty,#rm_rate', function(){	
				$("#value").val();
			  
				if($("#rm_actual_aty").val()){
					 var rm_actual_aty = $("#rm_actual_aty").val();
				 }else{
					 var rm_actual_aty = 0;
				 }

				 if($("#rm_rate").val()){
					 var rm_rate = $("#rm_rate").val();
				 }else{
					 var rm_rate = 0;
				 }
				 
				 var total_value = parseFloat(rm_actual_aty) * parseFloat(rm_rate);
				 $("#value").val( Math.round(total_value));
				 $("#total").val( Math.round(total_value));
		});


		// $(document).on('change', '#packing_and_forwarding,#value', function(){	
		// 		$("#total").val();
			  
		// 		if($("#packing_and_forwarding").val()){
		// 			 var packing_and_forwarding = $("#packing_and_forwarding").val();
		// 		 }else{
		// 			 var packing_and_forwarding = 0;
		// 		 }

		// 		 if($("#value").val()){
		// 			 var value = $("#value").val();
		// 		 }else{
		// 			 var value = 0;
		// 		 }
				 
		// 		 var total_value = parseFloat(packing_and_forwarding) +  parseFloat(value);
		// 		 $("#total").val( Math.round(total_value));

		// 		  var gst_value = parseFloat(total_value) * 18 / 100;

		// 		  $("#gst").val( Math.round(gst_value));

		// 		  $("#grand_total").val( Math.round(gst_value) + Math.round(total_value)); 
		// });

		$(document).on('change', '#packing_and_forwarding,#value', function(){	
				$("#total").val();
			  
				if($("#packing_and_forwarding").val()){
					 var packing_and_forwarding = $("#packing_and_forwarding").val();
				 }else{
					 var packing_and_forwarding = 0;
				 }

				 if($("#value").val()){
					 var value = $("#value").val();
				 }else{
					 var value = 0;
				 }
				 
				 var total_value = parseFloat(packing_and_forwarding) +  parseFloat(value);
				 $("#total").val( Math.round(total_value));

				//  var gst_value = parseFloat(total_value) * 18 / 100;

				//  $("#gst").val( Math.round(gst_value));

				//  $("#grand_total").val( Math.round(gst_value) + Math.round(total_value)); 
		});


		$(document).on('change', '#gst_rate', function(){	

             var gst_rate_value = $("#gst_rate").val();

			if(gst_rate_value=='IGST'){

				 var total_value = $("#total").val();

				 var gst_value = parseFloat(total_value) * 18 / 100;
				 
				 $(".cgst_sgst_div").attr("style", "display:none");
				 $(".igst_div").attr("style", "display:block");

				 $("#igst_rate").val( Math.round(gst_value));

				 $("#gst").val( Math.round(gst_value));

				 $("#grand_total").val( Math.round(gst_value) + Math.round(total_value)); 

			}else{

                 var total_value = $("#total").val();

				 var gst_value = parseFloat(total_value) * 18 / 100;

				 $(".igst_div").attr("style", "display:none");
				 $(".cgst_sgst_div").attr("style", "display:block");

				 var cgst_rate  =Math.round(gst_value)/2;

				 var SGST_rate  =Math.round(gst_value)/2;

				 $("#CGST_rate").val( Math.round(cgst_rate));
				 $("#SGST_rate").val( Math.round(SGST_rate));

				 $("#gst").val( Math.round(gst_value));

				 $("#grand_total").val( Math.round(gst_value) + Math.round(total_value));

			}

				

		});

		$(document).on('click','.deleteJobwork',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Job Work",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteJobwork",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Job Work Succesfully Deleted",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'jobWork'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Vendor PO deletion cancelled ", "error");
				}
			});
		});


		$(document).on('click','.deletejobworkitem',function(e){
			var elemF = $(this);
			e.preventDefault();

			var job_work_id = $("#job_work_id").val();
			

			swal({
				title: "Are you sure?",
				text: "Delete Job Work Item",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deletejobworkitem",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Job Work Item Succesfully Deleted",
											icon: "success",
											button: "Ok",
											},function(){ 

												if(job_work_id){
													window.location.href = "<?php echo base_url().'editjobwork/'?>"+job_work_id;
												}else{

													window.location.href = "<?php echo base_url().'addjobwork'?>";
												}
												
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Vendor PO deletion cancelled ", "error");
				}
			});
		});


		$(document).on('click','.editjobworkitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			$.ajax({
				url : "<?php echo base_url();?>geteditjobworkitem",
				type: "POST",
				data : 'id='+item_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 
						$('#jobwork_item_id').val(fetchResponse.jobwork_item_id); 
						$('#part_number').val(fetchResponse.raw_id); 
						$('#description').val(fetchResponse.description); 
						$('#SAC').val(fetchResponse.sac); 
						$('#HSN_Code').val(fetchResponse.HSN_code); 
						$('#raw_material_size').val(fetchResponse.type_of_raw_material); 
						$('#vendor_order_qty').val(fetchResponse.vendor_qty); 
						$('#rm_actual_aty').val(fetchResponse.rm_actual_qty); 
						$('#unit').val(fetchResponse.unit); 
						$('#rm_rate').val(fetchResponse.ram_rate); 
						$('#value').val(fetchResponse.value); 
						$('#packing_and_forwarding').val(fetchResponse.packing_forwarding); 
						$('#total').val(fetchResponse.total); 
						$('#gst').val(fetchResponse.gst); 
						$('#gst_rate').val(fetchResponse.gst_rate); 
						$('#grand_total').val(fetchResponse.grand_total);
						$('#item_remark').val(fetchResponse.item_remark); 
						
						
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		});
		
    </script>
<?php } ?>


<?php if($pageTitle=='Bill of Material' || $pageTitle=="Add New Bill Of Material" || $pageTitle=="Edit Bill Of Material"){ ?>

	<script type="text/javascript">
        $(document).ready(function() {
            var dt = $('#view_billofmaterial').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "15%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "15%", "targets": 4 },
	                 { "width": "7%", "targets": 5 },
					
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No BOM List Not Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchBillofmaterial",
                    type: "post",
	            },
	        });

	    });


		$(document).ready(function() {
			var vendor_po_number = $('#vendor_po_number').val();
			$("#customers-list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorsItemsforDisplay",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#customers-list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});


		$(document).ready(function() {

			var buyer_po_number = $('#buyer_po_number').val();
			$("#buyer_po_item_list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerItemsforDisplay",
				type: "POST",
				data : {'buyer_po_number' : buyer_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#buyer_po_item_list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#buyer_po_item_list').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;



		});


		$(document).ready(function() {

			var incoming_details = $('#incoming_details').val();
			$("#incoming_details_item_list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getincomingListforDisplay",
				type: "POST",
				data : {'incoming_details' : incoming_details},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						$("#incoming_details_item_list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#incoming_details_item_list').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;


		});


		$(document).ready(function() {

		   var vendor_po_number = $('#vendor_po_number').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemsonlyvendorBillofmaterial",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;
		});

		$(document).ready(function() {

			var vendor_po_number = $('#vendor_po_number').val();
			
			$.ajax({
					url : "<?php echo ADMIN_PATH;?>getIncomingDetailsofbillofmaterial",
					type: "POST",
					data : {'vendor_po_number' : vendor_po_number},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$('#incoming_details').html('<option value="">Select Incoming Details</option>');
						}
						else
						{
							$('#incoming_details').html(data);

							var incoming_details = $('#incoming_details').val();
							$("#incoming_details_item_list").html('');
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>getincomingListforDisplay",
								type: "POST",
								data : {'incoming_details' : incoming_details},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{
										//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
									}
									else
									{
										$("#incoming_details_item_list").html(data);

									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$('#incoming_details_item_list').html();
									//$(".loader_ajax").hide();
								}
							});

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						   
							$('#incoming_details').html('');				
					}
				});
		return false;

		});



		$(document).on('change','#vendor_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_name = $('#vendor_name').val();
		    $('.vendor_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorPonumberbySupplierid",
				type: "POST",
				data : {'vendor_name' : vendor_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#vendor_po_number').html('<option value="">Select Vendor PO Number</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#vendor_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});


		$(document).on('change','#vendor_po_number',function(e){  
			e.preventDefault();
			
						//$(".loader_ajax").show();
						var vendor_po_number = $('#vendor_po_number').val();
	
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getSupplierdetailsbyvendorponumber",
							type: "POST",
							data : {'vendor_po_number' : vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#supplier_name').val('');
									$('#supplier_po_number').val('');
									$('#supplier_po_date').val('');
								}
								else
								{
									var data_row = jQuery.parseJSON( data );

									$('#supplier_name').val(data_row.supplier);
									$('#supplier_po_number').val(data_row.supplierpo);	
									$('#supplier_po_date').val(data_row.supplierdate);								
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								   
									$('#supplier_name').val('');
									$('#supplier_po_number').val('');
									$('#supplier_po_date').val('');						
							}
						});
						return false;

		});

		$(document).on('click','#savenewBillofmaterail',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnnewbillofmaterialform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addnewBillofmaterial",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Bill Of Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'billofmaterial'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deleteBillofmaterial',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Bill of Material",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteBillofmaterial",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Bill Of Material Succesfully Deleted",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'billofmaterial'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Bill Of Material deletion cancelled ", "error");
				}
			});
		});

		$(document).on('click','.closebillofmaterialmodal', function(){
			location.reload();
        });

		$(document).on('change','#buyer_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			//$("#customers-list").html('');
			var buyer_name = $('#buyer_name').val();
		    $('.buyer_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerPonumberbyBuyerid",
				type: "POST",
				data : {'buyer_name' : buyer_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						$('#buyer_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#buyer_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','#buyer_po_number',function(e){  
			e.preventDefault();
			
			//$(".loader_ajax").show();
			var buyer_po_number = $('#buyer_po_number').val();
		
			if(vendor_name){
				if(vendor_po_number){
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getbuyerdetialsbybuyerponumber",
							type: "POST",
							data : {'buyer_po_number' : buyer_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#buyer_po_date').val('');
									$('#buyer_delivery_date').val('');
								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );
									$('#buyer_po_date').val(data_row_material.buyer_po_date);
									$('#buyer_delivery_date').val(data_row_material.delivery_date);									
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								    $('#buyer_po_date').val('');
									$('#buyer_delivery_date').val('');							
								    //$(".loader_ajax").hide();
							}
						});
						return false;

				}else{
					$('.part_number_error').html('Please Select Vendor PO Number');
				}

			}else{

				$('.part_number_error').html('Please Select Vendor PO');
			}
			
		});

		// $(document).on('change','.buyer_po_number_for_itam_mapping',function(e){  
		// 	e.preventDefault();
		// 	//$(".loader_ajax").show();
		// 	var vendor_po_number = $('#vendor_po_number').val();
		// 	var buyer_po_number = $('#buyer_po_number').val();

		// 	$("#part_number").html('');
		
		// 	$.ajax({
		// 		url : "<?php echo ADMIN_PATH;?>getVendoritemsonlyvendorBillofmaterial",
		// 		type: "POST",
		// 		data : {'vendor_po_number' : vendor_po_number,'buyer_po_number':buyer_po_number},
		// 		success: function(data, textStatus, jqXHR)
		// 		{
		// 			$(".loader_ajax").hide();
		// 			if(data == "failure")
		// 			{
		// 				$('#part_number').html('<option value="">Select Part Number</option>');
		// 			}
		// 			else
		// 			{
		// 				$('#part_number').html(data);

		// 			}
		// 		},
		// 		error: function (jqXHR, textStatus, errorThrown)
		// 		{
		// 			$('#part_number').html();
		// 		}
		// 	});
		// 	return false;
		// });
		
		$(document).on('change','.vendor_po_number_itam_mapping',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemsonlyvendorBillofmaterial",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;
		});

		$(document).on('change','#part_number',function(e){  
				e.preventDefault();
			
				//$(".loader_ajax").show();
				var part_number = $('#part_number').val();
				var vendor_po_number = $('#vendor_po_number').val();
				var vendor_name = $('#vendor_name').val();
				var supplier_po_number = $('#supplier_po_number').val();

				var selectElement = document.getElementById("part_number");
				// Get the selected option element
				var selectedOption = selectElement.options[selectElement.selectedIndex];

				// Get the value of the data-info attribute of the selected option
				var poitemid = selectedOption.getAttribute("data_id");


				if(vendor_name){
					if(vendor_po_number){
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>getItemdetailsdependonvendorpobom",
								type: "POST",
								data : {'part_number' : part_number,'vendor_po_number':vendor_po_number,'vendor_name':vendor_name,'supplier_po_number':supplier_po_number,'poitemid':poitemid},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{
										$('#description').val('');
										$('#rm_order_qty').val('');
										$('#rm_type').val('');
										$('#slitting_size').val('');
										$('#diameter').val('');
										$('#thickness').val('');
										$('#hex_af').val('');
										$('#gross_weight').val('');
										$('#net_weight_per_pcs').val('');
										$('#vendor_order_qty').val('');



									}
									else
									{
										var data_row_material = jQuery.parseJSON( data );
										$('#description').val(data_row_material.name);
										$('#rm_order_qty').val(data_row_material.raSm_supplier_order_qty);
										$('#rm_type').val(data_row_material.type_of_raw_material);
										$('#slitting_size').val(data_row_material.sitting_size);
										$('#diameter').val(data_row_material.diameter);
										$('#thickness').val(data_row_material.thickness);
										$('#hex_af').val(data_row_material.hex_a_f);
										$('#gross_weight').val(data_row_material.fg_gross_weight);
										$('#net_weight_per_pcs').val(data_row_material.fg_net_weight);
										$('#vendor_order_qty').val(data_row_material.vendor_or_qty);

										

									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
										$('#description').val('');
										$('#rm_order_qty').val('');
										$('#rm_type').val('');
										$('#slitting_size').val('');
										$('#diameter').val('');
										$('#thickness').val('');
										$('#hex_af').val('');
										$('#gross_weight').val('');
										$('#net_weight_per_pcs').val('');
										$('#vendor_order_qty').val('');

								}
							});
							return false;

					}else{
						$('.part_number_error').html('Please Select Vendor PO Number');
					}

				}else{

					$('.part_number_error').html('Please Select Vendor PO');
				}
				
		});


		$(document).on('change', '#rm_actual_aty', function(){	

				$("#expected_qty").val();
				if($("#rm_actual_aty").val()){
					 var rm_actual_aty = $("#rm_actual_aty").val();
				 }else{
					 var rm_actual_aty = 0;
				 }
				 if($("#gross_weight").val()){
					 var gross_weight = $("#gross_weight").val();
				 }else{
					 var gross_weight = 0;
				 }
				 
				 var total_value = parseFloat(rm_actual_aty) /  parseFloat(gross_weight);

				 $("#expected_qty").val( Math.round(total_value.toFixed(2)));
	
		});


		$(document).on('change', '#vendor_actual_received_Qty', function(){	

				$("#total_net_weight").val();
				$("#short_access").val();


				if($("#vendor_actual_received_Qty").val()){
					var vendor_actual_received_Qty = $("#vendor_actual_received_Qty").val();
				}else{
					var vendor_actual_received_Qty = 0;
				}
				if($("#net_weight_per_pcs").val()){
					var net_weight_per_pcs = $("#net_weight_per_pcs").val();
				}else{
					var net_weight_per_pcs = 0;
				}


				
				var total_value = parseFloat(vendor_actual_received_Qty) *  parseFloat(net_weight_per_pcs);


				$("#total_net_weight").val( total_value.toFixed(2));


				if($("#expected_qty").val()){
					var expected_qty = $("#expected_qty").val();
				}else{
					var expected_qty = 0;
				}

	
				var total_short_access_value = parseFloat(expected_qty) -  parseFloat(vendor_actual_received_Qty);


				$("#short_access").val(total_short_access_value.toFixed(2));



				if($("#total_net_weight").val()){
					var total_net_weight = $("#total_net_weight").val();
				}else{
					var total_net_weight = 0;
				}

				if($("#rm_actual_aty").val()){
					 var rm_actual_aty = $("#rm_actual_aty").val();
				 }else{
					 var rm_actual_aty = 0;
				 }


				var total_sscrap_value = parseFloat(rm_actual_aty) -  parseFloat(total_net_weight);

				$("#scrap").val(total_sscrap_value.toFixed(2));


		});


		$(document).on('change','.vendor_po_number_for_view_item',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();
			$("#customers-list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorsItemsforDisplay",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#customers-list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});


		$(document).on('change','.buyer_po_number_for_itam_display',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var buyer_po_number = $('#buyer_po_number').val();
			$("#buyer_po_item_list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerItemsforDisplay",
				type: "POST",
				data : {'buyer_po_number' : buyer_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#buyer_po_item_list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#buyer_po_item_list').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});


		$(document).on('change','.incoming_details_item_list_display',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var incoming_details = $('#incoming_details').val();
			$("#incoming_details_item_list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getincomingListforDisplay",
				type: "POST",
				data : {'incoming_details' : incoming_details},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						$("#incoming_details_item_list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#incoming_details_item_list').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});


		$(document).on('click','#saveBillofmaterialtem',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			   var formData = new FormData($("#saveBillofmaterialform")[0]);
              
			   var part_number =   $('#part_number').val();
			   var rm_actual_aty =   $('#rm_actual_aty').val();
			   var expected_qty =  $('#expected_qty').val();
			   var vendor_actual_received_Qty =   $('#vendor_actual_received_Qty').val();
			   var net_weight_per_pcs =  $('#net_weight_per_pcs').val();
			   var total_net_weight =  $('#total_net_weight').val();
			   var short_access =  $('#short_access').val();
			   var scrap =  $('#scrap').val();
			   var actual_scrap_recived =  $('#actual_scrap_recived').val();
			   var item_remark =  $('#item_remark').val();
			
			   var vendor_order_qty =  $('#vendor_order_qty').val();


			   var pre_date  =  $('#date').val();
			   var pre_vendor_name =  $('#vendor_name').val();
               var pre_vendor_po_number =  $('#vendor_po_number').val();
			   var pre_supplier_name =  $('#supplier_name').val();
               var pre_supplier_po_number =  $('#supplier_po_number').val();
			   var supplier_po_date =  $('#supplier_po_date').val();
			   var pre_buyer_name =  $('#buyer_name').val();
			   var pre_buyer_po_number =  $('#buyer_po_number').val();
			   var pre_buyer_po_date =  $('#buyer_po_date').val();
               var pre_buyer_delivery_date  =  $('#buyer_delivery_date').val();
               var pre_bom_status =  $('#bom_status').val();
			   var pre_incoming_details =  $('#incoming_details').val();
               var pre_remark =  $('#remark').val();

			   var bom_id_edit =  $('#bom_id_edit').val();

			   var bill_of_material_item_id =  $('#bill_of_material_item_id').val();


			$.ajax({
				url : "<?php echo base_url();?>saveBillofmaterialtem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,rm_actual_aty:rm_actual_aty,expected_qty:expected_qty,vendor_actual_received_Qty:vendor_actual_received_Qty,net_weight_per_pcs:net_weight_per_pcs,total_net_weight:total_net_weight,short_access:short_access,scrap:scrap,actual_scrap_recived:actual_scrap_recived,item_remark,pre_date:pre_date,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_supplier_name:pre_supplier_name,pre_supplier_po_number:pre_supplier_po_number,pre_buyer_name:pre_buyer_name,pre_buyer_po_number:pre_buyer_po_number,pre_buyer_po_date:pre_buyer_po_date,pre_buyer_delivery_date:pre_buyer_delivery_date,pre_bom_status:pre_bom_status,pre_incoming_details:pre_incoming_details,pre_remark,supplier_po_date:supplier_po_date,bom_id_edit:bom_id_edit,bill_of_material_item_id:bill_of_material_item_id,vendor_order_qty:vendor_order_qty},
				// method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								if(bom_id_edit){
									window.location.href = "<?php echo base_url().'editbillofmaterial/'?>"+bom_id_edit;
								}else{
									window.location.href = "<?php echo base_url().'addnewBillofmaterial'?>";
								}
								
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });


		$(document).on('change','.vendor_po_for_buyer_details_',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			        var vendor_po_number = $('#vendor_po_number').val();
			
			        $.ajax({
							url : "<?php echo ADMIN_PATH;?>getbuyerpodetailsforvendorbillofmaterial",
							type: "POST",
							data : {'vendor_po_number' : vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#buyer_name').html('<option value="">Select Buyer Name</option>');
								}
								else
								{
									$('#buyer_name').html(data);
					             	$(".autobuyerpo").html('');		


									$.ajax({
										url : "<?php echo ADMIN_PATH;?>getBuyerDetailsByvendorpoautofill",
										type: "POST",
										data : {'vendor_po_number' : vendor_po_number},
										success: function(data, textStatus, jqXHR)
										{
											$(".loader_ajax").hide();
											if(data == "failure")
											{
												$('.autobuyerpo').html('<option value="">Select Buyer PO</option>');
											}
											else
											{
		
												$('.autobuyerpo').html(data);


													var buyer_po_number = $('#buyer_po_number').val();
														$("#buyer_po_item_list").html('');
														$.ajax({
															url : "<?php echo ADMIN_PATH;?>getBuyerItemsforDisplay",
															type: "POST",
															data : {'buyer_po_number' : buyer_po_number},
															success: function(data, textStatus, jqXHR)
															{
																$(".loader_ajax").hide();
																if(data == "failure")
																{
																	//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
																}
																else
																{
																	//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
																	//$('#buyer_po_number').html(data);
																	$("#buyer_po_item_list").html(data);

																}
															},
															error: function (jqXHR, textStatus, errorThrown)
															{
																$('#buyer_po_item_list').html();
																//$(".loader_ajax").hide();
															}
														});
											}
										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											$('#buyer_name').html();
										}
									});

										
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								   
									$('#buyer_name').html('');				
							}
						});
			    return false;
	                   
		});


		$(document).on('change','.vendor_po_for_incoming_details',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			        var vendor_po_number = $('#vendor_po_number').val();
			
			        $.ajax({
							url : "<?php echo ADMIN_PATH;?>getIncomingDetailsofbillofmaterial",
							type: "POST",
							data : {'vendor_po_number' : vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#incoming_details').html('<option value="">Select Incoming Details</option>');
								}
								else
								{
									$('#incoming_details').html(data);

									var incoming_details = $('#incoming_details').val();
									$("#incoming_details_item_list").html('');
									$.ajax({
										url : "<?php echo ADMIN_PATH;?>getincomingListforDisplay",
										type: "POST",
										data : {'incoming_details' : incoming_details},
										success: function(data, textStatus, jqXHR)
										{
											$(".loader_ajax").hide();
											if(data == "failure")
											{
												//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
											}
											else
											{
												$("#incoming_details_item_list").html(data);

											}
										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											$('#incoming_details_item_list').html();
											//$(".loader_ajax").hide();
										}
									});

								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								   
									$('#incoming_details').html('');				
							}
						});
			    return false;
	                   
		});


		$(document).on('click','.deleteBillofmaterialitem',function(e){
			var elemF = $(this);
			e.preventDefault();


			var bom_id_edit =  $('#bom_id_edit').val();


			swal({
				title: "Are you sure?",
				text: "Delete Bill of Material Item ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteBillofmaterialitem",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Bill of Material Item Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 

												if(bom_id_edit){
													window.location.href = "<?php echo base_url().'editbillofmaterial'?>"+bom_id_edit;
												}else{
													window.location.href = "<?php echo base_url().'addnewBillofmaterial'?>";
												}
												
										
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Bill of Material Item deletion cancelled ", "error");
				}
			});
		});


		$(document).on('change','.vendor_po_for_buyer_details_date_and_podetails',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			        var vendor_po_number = $('#vendor_po_number').val();
		
									$('#buyer_po_date').val('');
									$('#buyer_delivery_date').val('');	

									$.ajax({
										url : "<?php echo ADMIN_PATH;?>getbuyerpodetailsforvendorstockform",
										type: "POST",
										data : {'vendor_po_number' : vendor_po_number},
										success: function(data, textStatus, jqXHR)
										{
											var get_buyerdata = jQuery.parseJSON( data );

											$(".loader_ajax").hide();
											if(data == "failure")
											{
											
												$('#buyer_po_date').val('');
												$('#buyer_delivery_date').val('');	
											}
											else
											{
												
												$('#buyer_po_date').val(get_buyerdata.date);
												$('#buyer_delivery_date').val(get_buyerdata.delivery_date);	
											}
										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											    $('#buyer_po_date').val('');
												$('#buyer_delivery_date').val('');	
											
										}
									});
									return false;
							
		});


		$(document).on('change','#vendor_name,#vendor_po_number',function(e){  
			e.preventDefault();
			$('.vendor_po_number_error').html('');
			var vendor_name = $('#vendor_name').val();
			var vendor_po_number = $('#vendor_po_number').val();

			if(vendor_name && vendor_po_number){

				        $.ajax({
							url : "<?php echo ADMIN_PATH;?>checkvendorpoandvendornumberinbillofmaterial",
							type: "POST",
							data : {'vendor_name' : vendor_name,'vendor_po_number':vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									    $('.vendor_po_number_error').val('');
									    $('#savenewBillofmaterail').prop('disabled', false);
										$('.addNewModal').prop('disabled', false);
							
								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );

									if(data_row_material.vendor_po_number){
										$('.vendor_po_number_error').html('Bill Of Material Alreday Exists For This Vendor PO');
										$('#savenewBillofmaterail').prop('disabled', true);
										$('.addNewModal').prop('disabled', true);
									}else{

										$('.vendor_po_number_error').html('');
										$('#savenewBillofmaterail').prop('disabled', false);
										$('.addNewModal').prop('disabled', false);
									}

									// console.log(data_row_material.vendor_po_number);

									//$('#vendor_po_number').val(data_row_material.name);		
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								    $('.vendor_po_number_error').val('');
									$('#savenewBillofmaterail').prop('disabled', false);
									$('.addNewModal').prop('disabled', false);
							}
						});
						return false;


			}
		});

		$(document).on('click','.editBillofmaterialitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			var supplier_po_id = elemF.attr('supplier-po-id');
			$.ajax({
				url : "<?php echo base_url();?>geteditBillofmaterialitem",
				type: "POST",
				data : 'id='+item_id+'&supplier_po_id='+supplier_po_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 

						$('#bill_of_material_item_id').val(fetchResponse.bill_of_material_item_id); 
						$('#part_number').val(fetchResponse.raw_id);  
						$('#description').val(fetchResponse.description); 
						$('#rm_order_qty').val(fetchResponse.rmsupplier_order_qty);
						$('#rm_actual_aty').val(fetchResponse.rm_actual_aty);
						$('#rm_type').val(fetchResponse.rm_type);
						$('#slitting_size').val(fetchResponse.sitting_size);
						$('#diameter').val(fetchResponse.diameter);
						$('#thickness').val(fetchResponse.thickness);
						$('#hex_af').val(fetchResponse.hex_a_f);
						$('#gross_weight').val(fetchResponse.gross_weight);
						$('#expected_qty').val(fetchResponse.expected_qty);
						$('#vendor_order_qty').val(fetchResponse.vendor_order_qty);
						$('#vendor_actual_received_Qty').val(fetchResponse.vendor_actual_recived_qty);
						$('#net_weight_per_pcs').val(fetchResponse.net_weight_per_pcs);
						$('#total_net_weight').val(fetchResponse.total_neight_weight);
						$('#short_access').val(fetchResponse.short_excess);
						$('#scrap').val(fetchResponse.scrap_in_kgs);
						$('#actual_scrap_recived').val(fetchResponse.actual_scrap_recived);
						$('#item_remark').val(fetchResponse.remark);

				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		});

    </script>
<?php } ?>


<?php if($pageTitle=='Vendor Bill of Material' || $pageTitle=="Add New Vendor Bill Of Material" || $pageTitle=="Edit Vendor Bill Of Material"){ ?>
	<script type="text/javascript">
		$(document).ready(function() {
            var dt = $('#view_vendorbillofmaterialVendor').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "15%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "15%", "targets": 4 },
	                 { "width": "7%", "targets": 5 }					
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Vendor BOM List Not Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchvendorBillofmaterial",
                    type: "post",
	            },
	        });
	    });

		$(document).ready(function() {
			//e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();
			var buyer_po_number = $('#buyer_po_number').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemsonlyvendorBillofmaterial",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number,'buyer_po_number':buyer_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;

		});

		$(document).ready(function() {
			var vendor_po_number = $('#vendor_po_number').val();
			$("#customers-list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorsItemsforDisplay",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#customers-list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).ready(function() {

			var buyer_po_number = $('#buyer_po_number').val();
			$("#buyer_po_item_list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerItemsforDisplay",
				type: "POST",
				data : {'buyer_po_number' : buyer_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#buyer_po_item_list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#buyer_po_item_list').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;



		});

		$(document).ready(function() {

			var incoming_details = $('#incoming_details').val();
			$("#incoming_details_item_list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getincomingListforDisplay",
				type: "POST",
				data : {'incoming_details' : incoming_details},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						$("#incoming_details_item_list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#incoming_details_item_list').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;


		});

		$(document).ready(function() {
				var vendor_po_number = $('#vendor_po_number').val();
				
				$.ajax({
						url : "<?php echo ADMIN_PATH;?>getIncomingDetailsofbillofmaterial",
						type: "POST",
						data : {'vendor_po_number' : vendor_po_number},
						success: function(data, textStatus, jqXHR)
						{
							$(".loader_ajax").hide();
							if(data == "failure")
							{
								$('#incoming_details').html('<option value="">Select Incoming Details</option>');
							}
							else
							{
								$('#incoming_details').html(data);

								var incoming_details = $('#incoming_details').val();
								$("#incoming_details_item_list").html('');
								$.ajax({
									url : "<?php echo ADMIN_PATH;?>getincomingListforDisplay",
									type: "POST",
									data : {'incoming_details' : incoming_details},
									success: function(data, textStatus, jqXHR)
									{
										$(".loader_ajax").hide();
										if(data == "failure")
										{
											//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
										}
										else
										{
											$("#incoming_details_item_list").html(data);

										}
									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$('#incoming_details_item_list').html();
										//$(".loader_ajax").hide();
									}
								});

							}
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							
								$('#incoming_details').html('');				
						}
					});
			    return false;
		});
	

		$(document).on('click','#savenewvendorBillofmaterial',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnnewvendorbillofmaterialform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addvendorBillofmaterial",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Vendor Bill Of Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'vendorbillofmaterial'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('change','#vendor_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_name = $('#vendor_name').val();
		    $('.vendor_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorPonumberbySupplieridvendorbillofmaterial",
				type: "POST",
				data : {'vendor_name' : vendor_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#vendor_po_number').html('<option value="">Select Vendor PO Number</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#vendor_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('click','.deletevendorBillofmaterial',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Vendor Bill of Material",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deletevendorBillofmaterial",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Vendor Bill Of Material Succesfully Deleted",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'vendorbillofmaterial'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Vendor Bill Of Material deletion cancelled ", "error");
				}
			});
		});

		$(document).on('change','.vendor_po_for_item',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;
		});

		$(document).on('change','#buyer_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			//$("#customers-list").html('');
			var buyer_name = $('#buyer_name').val();
		    $('.buyer_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerPonumberbyBuyerid",
				type: "POST",
				data : {'buyer_name' : buyer_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						$('#buyer_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#buyer_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','#buyer_po_number',function(e){  
			e.preventDefault();
			
			//$(".loader_ajax").show();
			var buyer_po_number = $('#buyer_po_number').val();
		
			if(vendor_name){
				if(vendor_po_number){
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getbuyerdetialsbybuyerponumber",
							type: "POST",
							data : {'buyer_po_number' : buyer_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#buyer_po_date').val('');
									$('#buyer_delivery_date').val('');
								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );
									$('#buyer_po_date').val(data_row_material.buyer_po_date);
									$('#buyer_delivery_date').val(data_row_material.delivery_date);									
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								    $('#buyer_po_date').val('');
									$('#buyer_delivery_date').val('');							
								    //$(".loader_ajax").hide();
							}
						});
						return false;

				}else{
					$('.part_number_error').html('Please Select Vendor PO Number');
				}

			}else{

				$('.part_number_error').html('Please Select Vendor PO');
			}
			
		});

		$(document).on('click','.closeVendorbillofmaterialmodal', function(){
			location.reload();
        });

		$(document).on('change','.buyer_po_number_for_itam_mapping',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();
			var buyer_po_number = $('#buyer_po_number').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemsonlyvendorBillofmaterial",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number,'buyer_po_number':buyer_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;
		});

		$(document).on('change','#part_number',function(e){  
			e.preventDefault();
			
			//$(".loader_ajax").show();
			var part_number = $('#part_number').val();
		    var vendor_po_number = $('#vendor_po_number').val();
			var vendor_name = $('#vendor_name').val();

			if(vendor_name){
				if(vendor_po_number){
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getSuppliergoodsPartnumberByidforvendorbillofmaetrial",
							type: "POST",
							data : {'part_number' : part_number,'vendor_po_number':vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#description').val('');
									$('#vendor_order_qty').val('');
									$('#buyer_order_qty').val('');
								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );
									$('#description').val(data_row_material.name);
									$('#vendor_order_qty').val(data_row_material.vendor_qty);
									$('#buyer_order_qty').val(data_row_material.buyer_po_qty);
									
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								    $('#description').val('');
									$('#vendor_order_qty').val('');	
									$('#buyer_order_qty').val('');					
								    //$(".loader_ajax").hide();
							}
						});
						return false;

				}else{
					$('.part_number_error').html('Please Select Vendor PO Number');
				}

			}else{

				$('.part_number_error').html('Please Select Vendor PO');
			}
			
		});

		$(document).on('change', '#vendor_received_qty,#vendor_order_qty', function(){	
				$("#balanced_aty").val();
			  
				if($("#vendor_received_qty").val()){
					 var vendor_received_aty = $("#vendor_received_qty").val();
				 }else{
					 var vendor_received_aty = 0;
				 }

				 if($("#vendor_order_qty").val()){
					 var vendor_order_qty = $("#vendor_order_qty").val();
				 }else{
					 var vendor_order_qty = 0;
				 }
				 
				 var total_value = parseFloat(vendor_order_qty) - parseFloat(vendor_received_aty);
				 $("#balanced_aty").val( Math.round(total_value));
		});

		$(document).on('click','#saveVendorbilloamaterialitem',function(e){
			e.preventDefault();
			  $(".loader_ajax").show();
			   var formData = new FormData($("#saveVendorbilloamaterialitemform")[0]);

               var part_number =   $('#part_number').val();
			   var description =   $('#description').val();
			   var buyer_order_qty =   $('#buyer_order_qty').val();
			   var vendor_order_qty =   $('#vendor_order_qty').val();
			   var vendor_received_qty =   $('#vendor_received_qty').val();
			   var balanced_aty =   $('#balanced_aty').val();
			   var item_remark =   $('#item_remark').val();


			   var pre_date =   $('#date').val();
			   var pre_vendor_name =   $('#vendor_name').val();
			   var pre_vendor_po_number =   $('#vendor_po_number').val();
			   var pre_buyer_name =   $('#buyer_name').val();
			   var pre_buyer_po_number =   $('#buyer_po_number').val();
			   var pre_buyer_po_date =   $('#buyer_po_date').val();
			   var pre_buyer_delivery_date =   $('#buyer_delivery_date').val();
			   var pre_bom_status =   $('#bom_status').val();
			   var pre_remark =   $('#remark').val();

			   var pre_incoming_details =   $('#incoming_details').val();


			   var editvbmid =   $('#editvbmid').val();

			   var vendor_bill_of_material_item_id =   $('#vendor_bill_of_material_item_id').val();
		 
			$.ajax({
				url : "<?php echo base_url();?>saveVendorbilloamaterialitems",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,buyer_order_qty:buyer_order_qty,vendor_order_qty:vendor_order_qty,vendor_received_qty:vendor_received_qty,balanced_aty:balanced_aty,item_remark:item_remark,pre_date:pre_date,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_buyer_name:pre_buyer_name,pre_buyer_po_number:pre_buyer_po_number,pre_buyer_po_date:pre_buyer_po_date,pre_buyer_delivery_date:pre_buyer_delivery_date,pre_bom_status:pre_bom_status,pre_remark:pre_remark,pre_incoming_details:pre_incoming_details,editvbmid:editvbmid,vendor_bill_of_material_item_id:vendor_bill_of_material_item_id},
				// method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								if(editvbmid){
									window.location.href = "<?php echo base_url().'editvendorbillofmaterial/'?>"+editvbmid;
								}else{
									window.location.href = "<?php echo base_url().'addvendorBillofmaterial'?>";
								}
								
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deleteVendorbillofmaterialpoitem',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Vendor Bill of Material",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteVendorbillofmaterialpoitem",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Vendor Bill of Material Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'addvendorBillofmaterial'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Delete Vendor Bill of Material deletion cancelled ", "error");
				}
			});
		});

		$(document).on('change','.vendor_po_number_for_view_item',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();
			$("#customers-list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorsItemsforDisplay",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#customers-list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','.buyer_po_number_for_itam_display',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var buyer_po_number = $('#buyer_po_number').val();
			$("#buyer_po_item_list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerItemsforDisplay",
				type: "POST",
				data : {'buyer_po_number' : buyer_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#buyer_po_item_list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#buyer_po_item_list').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});
		
		$(document).on('change','.incoming_details_item_list_display',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var incoming_details = $('#incoming_details').val();
			$("#incoming_details_item_list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getincomingListforDisplay",
				type: "POST",
				data : {'incoming_details' : incoming_details},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						$("#incoming_details_item_list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#incoming_details_item_list').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','.vendor_po_for_buyer_details_',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			        var vendor_po_number = $('#vendor_po_number').val();
			
			        $.ajax({
							url : "<?php echo ADMIN_PATH;?>getbuyerpodetailsforvendorbillofmaterial",
							type: "POST",
							data : {'vendor_po_number' : vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#buyer_name').html('<option value="">Select Buyer Name</option>');
								}
								else
								{
									$('#buyer_name').html(data);
					             	$(".autobuyerpo").html('');		


									$.ajax({
										url : "<?php echo ADMIN_PATH;?>getBuyerDetailsByvendorpoautofill",
										type: "POST",
										data : {'vendor_po_number' : vendor_po_number},
										success: function(data, textStatus, jqXHR)
										{
											$(".loader_ajax").hide();
											if(data == "failure")
											{
												$('.autobuyerpo').html('<option value="">Select Buyer PO</option>');
											}
											else
											{
		
												$('.autobuyerpo').html(data);


													var buyer_po_number = $('#buyer_po_number').val();
														$("#buyer_po_item_list").html('');
														$.ajax({
															url : "<?php echo ADMIN_PATH;?>getBuyerItemsforDisplay",
															type: "POST",
															data : {'buyer_po_number' : buyer_po_number},
															success: function(data, textStatus, jqXHR)
															{
																$(".loader_ajax").hide();
																if(data == "failure")
																{
																	//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
																}
																else
																{
																	//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
																	//$('#buyer_po_number').html(data);
																	$("#buyer_po_item_list").html(data);

																}
															},
															error: function (jqXHR, textStatus, errorThrown)
															{
																$('#buyer_po_item_list').html();
																//$(".loader_ajax").hide();
															}
														});
											}
										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											$('#buyer_name').html();
										}
									});

										
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								   
									$('#buyer_name').html('');				
							}
						});
			    return false;
	                   
		});

		$(document).on('change','.vendor_po_for_incoming_details',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			        var vendor_po_number = $('#vendor_po_number').val();
			
			        $.ajax({
							url : "<?php echo ADMIN_PATH;?>getIncomingDetailsofbillofmaterial",
							type: "POST",
							data : {'vendor_po_number' : vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#incoming_details').html('<option value="">Select Incoming Details</option>');
								}
								else
								{
									$('#incoming_details').html(data);

									var incoming_details = $('#incoming_details').val();
									$("#incoming_details_item_list").html('');
									$.ajax({
										url : "<?php echo ADMIN_PATH;?>getincomingListforDisplay",
										type: "POST",
										data : {'incoming_details' : incoming_details},
										success: function(data, textStatus, jqXHR)
										{
											$(".loader_ajax").hide();
											if(data == "failure")
											{
												//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
											}
											else
											{
												$("#incoming_details_item_list").html(data);

											}
										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											$('#incoming_details_item_list').html();
											//$(".loader_ajax").hide();
										}
									});

								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								   
									$('#incoming_details').html('');				
							}
						});
			    return false;
	                   
		});

		$(document).on('change','.vendor_po_for_buyer_details_date_and_podetails',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			        var vendor_po_number = $('#vendor_po_number').val();
		
									$('#buyer_po_date').val('');
									$('#buyer_delivery_date').val('');	

									$.ajax({
										url : "<?php echo ADMIN_PATH;?>getbuyerpodetailsforvendorstockform",
										type: "POST",
										data : {'vendor_po_number' : vendor_po_number},
										success: function(data, textStatus, jqXHR)
										{
											var get_buyerdata = jQuery.parseJSON( data );

											$(".loader_ajax").hide();
											if(data == "failure")
											{
											
												$('#buyer_po_date').val('');
												$('#buyer_delivery_date').val('');	
											}
											else
											{
												
												$('#buyer_po_date').val(get_buyerdata.date);
												$('#buyer_delivery_date').val(get_buyerdata.delivery_date);	
											}
										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											    $('#buyer_po_date').val('');
												$('#buyer_delivery_date').val('');	
											
										}
									});
									return false;
							
		});

		$(document).on('change','#vendor_name,#vendor_po_number',function(e){  
			e.preventDefault();
			$('.vendor_po_number_error').html('');
			var vendor_name = $('#vendor_name').val();
			var vendor_po_number = $('#vendor_po_number').val();

			if(vendor_name && vendor_po_number){

				        $.ajax({
							url : "<?php echo ADMIN_PATH;?>checkvendorpoandvendornumberinvendorbillofmaterial",
							type: "POST",
							data : {'vendor_name' : vendor_name,'vendor_po_number':vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('.vendor_po_number_error').val('');
									$('#savenewvendorBillofmaterial').prop('disabled', false);
                                    $('.addNewModal').prop('disabled', false);
							
								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );

									if(data_row_material.vendor_po_number){
										$('.vendor_po_number_error').html('Vendor Bill Of Material Already Exists For This Vendor PO');

										$('#savenewvendorBillofmaterial').prop('disabled', true);
                                        $('.addNewModal').prop('disabled', true);


									}else{

										$('.vendor_po_number_error').html('');
										$('#savenewvendorBillofmaterial').prop('disabled', false);
                                        $('.addNewModal').prop('disabled', false);
									}

									// console.log(data_row_material.vendor_po_number);

									//$('#vendor_po_number').val(data_row_material.name);		
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								    $('.vendor_po_number_error').val('');
									$('#savenewvendorBillofmaterial').prop('disabled', false);
                                    $('.addNewModal').prop('disabled', false);
							}
						});
						return false;


			}
		});

		$(document).on('click','.editVendorbillofmaterialpoitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			$.ajax({
				url : "<?php echo base_url();?>geteditVendorbillofmaterialpoitem",
				type: "POST",
				data : 'id='+item_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 

						$('#vendor_bill_of_material_item_id').val(fetchResponse.vendor_bill_of_material_item_id); 
						$('#part_number').val(fetchResponse.fin_id);  
						$('#description').val(fetchResponse.description); 
						$('#buyer_order_qty').val(fetchResponse.buyer_order_qty);
						$('#vendor_order_qty').val(fetchResponse.vendor_order_qty);

						$('#vendor_received_qty').val(fetchResponse.vendor_received_qty);

						$('#balanced_aty').val(fetchResponse.balenced_qty);
						$('#item_remark').val(fetchResponse.item_remark);
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		});

    </script>
<?php } ?>


<?php if($pageTitle=='Add New Incoming Details' || $pageTitle=='Incoming Details' || $pageTitle=='Edit Incoming Details'){ ?>
	<script type="text/javascript">
        $(document).ready(function() {
            var dt = $('#view_incomingdetailss').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "15%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "15%", "targets": 4 },
	                 { "width": "10%", "targets": 5 },
					 { "width": "10%", "targets": 6 }					
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Incoming Details Not Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchincomingdeatils",
                    type: "post",
	            },
	        });
	    });


		$(document).ready(function() {
			//e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemsonlyvendorBillofmaterial",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;
		});

		$(document).on('change','#vendor_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_name = $('#vendor_name').val();
		    $('.vendor_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorPonumberbyVendorid",
				type: "POST",
				data : {'vendor_name' : vendor_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#vendor_po_number').html('<option value="">Select Vendor PO Number</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#vendor_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('click','#saveincomingdetails',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnewincomingdetailsform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addnewencomingdetails",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Incoming Details Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'incomingdetails'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deleteIncomingDetails',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Incomig Details",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteIncomingDetails",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Incomig Details Succesfully Deleted",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'incomingdetails'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Incomig Details deletion cancelled ", "error");
				}
			});
		});

		$(document).on('change','.vendor_po_number_itam_mapping',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemsonlyvendorBillofmaterial",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;
		});

		$(document).on('change','#part_number',function(e){  
			e.preventDefault();
			
			//$(".loader_ajax").show();
			var part_number = $('#part_number').val();
		    var vendor_po_number = $('#vendor_po_number').val();
			var vendor_name = $('#vendor_name').val();

			if(vendor_name){
				if(vendor_po_number){
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getVendorpoitems",
							type: "POST",
							data : {'part_number' : part_number,'vendor_po_number':vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#description').val('');
									$('#p_o_qty').val('');
									$('#net_weight').val('');
								
								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );
									$('#description').val(data_row_material.name);
									$('#p_o_qty').val(data_row_material.vendor_qty);
									$('#net_weight').val(data_row_material.net_weightfg);
								
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								    $('#description').val('');
									$('#p_o_qty').val('');	
									$('#net_weight').val('');				
								    //$(".loader_ajax").hide();
							}
						});
						return false;

				}else{
					$('.part_number_error').html('Please Select Vendor PO Number');
				}

			}else{

				$('.part_number_error').html('Please Select Vendor PO');
			}
			
		});

		$(document).on('click','.closeIncomingDetailsmodal', function(){
			location.reload();
        });

		$(document).on('click','#saveincomingitem',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			   var formData = new FormData($("#saveincomingitemform")[0]);
              
			   var part_number =   $('#part_number').val();
			   var description =   $('#description').val();
			   var p_o_qty =   $('#p_o_qty').val();
			   var net_weight =   $('#net_weight').val();
			   var invoice_no =   $('#invoice_no').val();
			   var invoice_date =   $('#invoice_date').val();
			   var challan_no =   $('#challan_no').val();
			   var challan_date =   $('#challan_date').val();
			   var received_date =   $('#received_date').val();
			   var invoice_qty =   $('#invoice_qty').val();
			   var invoice_qty_in_kgs =   $('#invoice_qty_in_kgs').val();
			   var balance_qty =   $('#balance_qty').val();
			   var fg_material_gross_weight =   $('#fg_material_gross_weight').val();
			   var units =   $('#units').val();
			   var boxex_goni_bundle =   $('#boxex_goni_bundle').val();
			   var lot_no =   $('#lot_no').val();
			   var assign_team =   $('#assign_team').val();
			   var working_hrs_status =   $('#working_hrs_status').val();
			   var remarks =   $('#remarks').val();

			   var pre_vendor_name =   $('#vendor_name').val();
			   var pre_vendor_po_number =   $('#vendor_po_number').val();
			   var pre_reported_by =   $('#reported_by').val();
			   var pre_report_date =   $('#reported_date').val();
			   var pre_remark  =   $('#remark').val();
			   
			   var incomingdetail_editid  =   $('#incomingdetail_editid').val();
			   var incoiming_details_item_id  =   $('#incoiming_details_item_id').val();

			

			$.ajax({
				url : "<?php echo base_url();?>saveincomingitem",
				type: "POST",
				 //data : formData,
				 data :{ part_number:part_number,description:description,p_o_qty:p_o_qty,net_weight:net_weight,invoice_no:invoice_no,invoice_date:invoice_date,challan_no:challan_no,challan_date:challan_date,received_date:received_date,invoice_qty:invoice_qty,invoice_qty_in_kgs:invoice_qty_in_kgs,balance_qty:balance_qty,fg_material_gross_weight:fg_material_gross_weight,units:units,boxex_goni_bundle:boxex_goni_bundle,remarks:remarks,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_reported_by:pre_reported_by,pre_report_date:pre_report_date,pre_remark:pre_remark,incomingdetail_editid:incomingdetail_editid,lot_no:lot_no,incoiming_details_item_id:incoiming_details_item_id,assign_team:assign_team,working_hrs_status:working_hrs_status},
				// method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 


								if(incomingdetail_editid){

									window.location.href = "<?php echo base_url().'editincomingdetails/'?>"+incomingdetail_editid;
								}else{

									window.location.href = "<?php echo base_url().'addnewencomingdetails'?>";
								}

								
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('change', '#invoice_qty', function(){	

				$("#invoice_qty_in_kgs").val();
			  
				 if($("#invoice_qty").val()){
					 var invoice_qty = $("#invoice_qty").val();
				 }else{
					 var invoice_qty = 0;
				 }

				 if($("#net_weight").val()){
					 var net_weight = $("#net_weight").val();
				 }else{
					 var net_weight = 0;
				 }

				 var total_value = parseFloat(invoice_qty) * parseFloat(net_weight);
				
				 $("#invoice_qty_in_kgs").val(total_value.toFixed(2));



				 /*============================================================*/

				 $("#balance_qty").val();


				 if($("#p_o_qty").val()){
					 var p_o_qty = $("#p_o_qty").val();
				 }else{
					 var p_o_qty = 0;
				 }

				 if($("#invoice_qty").val()){
					 var invoice_qty = $("#invoice_qty").val();
				 }else{
					 var invoice_qty = 0;
				 }

				 var bal_value = parseFloat(p_o_qty) - parseFloat(invoice_qty);
				
				 $("#balance_qty").val( bal_value.toFixed(2));

				 
		});

		$(document).on('click','.deleteIncomingDetailsitem',function(e){
			var elemF = $(this);
			e.preventDefault();

			var incomingdetail_editid  =   $('#incomingdetail_editid').val();

			swal({
				title: "Are you sure?",
				text: "Delete Incoming Details Item ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteIncomingDetailsitem",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Incoming Details Item Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 

												if(incomingdetail_editid){
													window.location.href = "<?php echo base_url().'editincomingdetails/'?>"+incomingdetail_editid;
												}else{
													window.location.href = "<?php echo base_url().'addnewencomingdetails'?>";
												}
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Incoming Details Item deletion cancelled ", "error");
				}
			});
		});

		$(document).on('change','#vendor_name,#vendor_po_number',function(e){  
			e.preventDefault();
			$('.vendor_po_number_error').html('');
			var incoming_no = $('#incoming_no').val();
			var vendor_po_number = $('#vendor_po_number').val();

			if(incoming_no && vendor_po_number){

				        $.ajax({
							url : "<?php echo ADMIN_PATH;?>checkvendorpoandvendornumber",
							type: "POST",
							data : {'incoming_no' : incoming_no,'vendor_po_number':vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('.vendor_po_number_error').val('');
							
								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );

									if(data_row_material.vendor_po_number){
										$('.vendor_po_number_error').html('Incoming Id Alreday Exists For This Vendor PO');
									}else{

										$('.vendor_po_number_error').html('');
									}

									// console.log(data_row_material.vendor_po_number);

									//$('#vendor_po_number').val(data_row_material.name);		
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								    $('.vendor_po_number_error').val('');
							}
						});
						return false;


			}
		});

		$(document).on('change','#part_number_serach',function(e){  
			$("#view_incomingdetailss_item_on_add").dataTable().fnDestroy();
			getIncomigDataFilter($("#part_number_serach").val());
		});

		$(document).ready(function() {
			$("#view_incomingdetailss_item_on_add").dataTable().fnDestroy();
			getIncomigDataFilter($("#part_number_serach").val());
	    });

		function getIncomigDataFilter(part_number_serach)
	    {
			var dt = $('#view_incomingdetailss_item_on_add').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "5%", "targets": 0 },
	                 { "width": "5%", "targets": 1 },
					 { "width": "5%", "targets": 2 },
	                 { "width": "5%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
	                 { "width": "10%", "targets": 5 },
					 { "width": "10%", "targets": 6 },	
					 { "width": "10%", "targets": 7 },
	                 { "width": "10%", "targets": 8 },
					 { "width": "10%", "targets": 9 },
	                 { "width": "10%", "targets": 10 },
					 { "width": "10%", "targets": 11 },
	                 { "width": "10%", "targets": 12 },
					 { "width": "10%", "targets": 13 },		
					 { "width": "10%", "targets": 14 },
	                 { "width": "10%", "targets": 15 },
					 { "width": "10%", "targets": 16 },
	                 { "width": "10%", "targets": 17 },
					 { "width": "10%", "targets": 18 }
	            ],
	            responsive: false,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Incoming Details item Found.</i>",
	            }, 
				"bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchincomingdeatilsitemlistadd/"+$.trim(part_number_serach),
                    type: "post",
	            },


				"footerCallback": function ( row, data, start, end, display) {
						var api = this.api(), data;

						var intVal = function ( i ) {
							return typeof i === 'string' ?
								i.replace(/[\$,]/g, '')*1 :
								typeof i === 'number' ?
									i : 0;
						};

						var amtTotal = api
							.column( 5 )
							.data()
							.reduce( function (a, b) {
								return intVal(a) + intVal(b);
							}, 0 );

					$( api.column( 5 ).footer() ).html(amtTotal);
                },

	        });

		}
	

		$(document).on('change','#part_number_serach_edit',function(e){  
			$("#view_incomingdetailss_item_on_edit").dataTable().fnDestroy();
			getIncomigDataFilteredit($("#part_number_serach_edit").val());
		});


		$(document).ready(function() {
			$("#view_incomingdetailss_item_on_edit").dataTable().fnDestroy();
			getIncomigDataFilteredit($("#part_number_serach_edit").val());
	    });

		function getIncomigDataFilteredit(part_number_serach_edit)
	    {
			var incomingdetail_editid = $("#incomingdetail_editid").val();
	
			var dt = $('#view_incomingdetailss_item_on_edit').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "5%", "targets": 0 },
	                 { "width": "5%", "targets": 1 },
					 { "width": "5%", "targets": 2 },
	                 { "width": "5%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
	                 { "width": "10%", "targets": 5 },
					 { "width": "10%", "targets": 6 },	
					 { "width": "10%", "targets": 7 },
	                 { "width": "10%", "targets": 8 },
					 { "width": "10%", "targets": 9 },
	                 { "width": "10%", "targets": 10 },
					 { "width": "10%", "targets": 11 },
	                 { "width": "10%", "targets": 12 },
					 { "width": "10%", "targets": 13 },		
					 { "width": "10%", "targets": 14 },
	                 { "width": "10%", "targets": 15 },
					 { "width": "10%", "targets": 16 },
	                 { "width": "10%", "targets": 17 },
					 { "width": "10%", "targets": 18 }
	            ],
	            responsive: false,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Incoming Details item Found.</i>",
	            }, 
				"bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>admin/fetchincomingdeatilsitemlistedit/"+$.trim(part_number_serach_edit)+'/'+incomingdetail_editid,
                    type: "post",
	            },

				
				"footerCallback": function ( row, data, start, end, display) {
						var api = this.api(), data;

						var intVal = function ( i ) {
							return typeof i === 'string' ?
								i.replace(/[\$,]/g, '')*1 :
								typeof i === 'number' ?
									i : 0;
						};

						var amtTotal = api
							.column( 5 )
							.data()
							.reduce( function (a, b) {
								return intVal(a) + intVal(b);
							}, 0 );
							
					$( api.column( 5 ).footer() ).html(amtTotal);
                },
	        });

		}

		
		$(document).on('click','.editIncomingDetailsitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			$.ajax({
				url : "<?php echo base_url();?>getIncomingDetailitemedit",
				type: "POST",
				data : 'id='+item_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 

						$('#incoiming_details_item_id').val(fetchResponse.incoiming_details_item_id); 
						$('#part_number').val(fetchResponse.part_number);  
						$('#description').val(fetchResponse.description); 
						$('#p_o_qty').val(fetchResponse.p_o_qty);
						$('#net_weight').val(fetchResponse.net_weight);
						$('#invoice_no').val(fetchResponse.invoice_no);
						$('#invoice_date').val(fetchResponse.invoice_date);
						$('#challan_no').val(fetchResponse.challan_no);
						$('#challan_date').val(fetchResponse.challan_date);
						$('#received_date').val(fetchResponse.received_date);
						$('#invoice_qty').val(fetchResponse.invoice_qty);
						$('#invoice_qty_in_kgs').val(fetchResponse.invoice_qty_in_kgs);
						$('#balance_qty').val(fetchResponse.balance_qty);
						$('#fg_material_gross_weight').val(fetchResponse.fg_material_gross_weight);

						$('#assign_team').val(fetchResponse.assign_team);
						$('#working_hrs_status').val(fetchResponse.working_hrs_status);

						$('#units').val(fetchResponse.units);
						$('#boxex_goni_bundle').val(fetchResponse.boxex_goni_bundle);
						$('#lot_no').val(fetchResponse.lot_no);
						$('#remarks').val(fetchResponse.remarks);
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		});


   </script>
<?php } ?>


<?php if($pageTitle=='Add New Packing Instaruction' || $pageTitle=='Packing Instaruction'  || $pageTitle=='Add Packing Instraction Details' || $pageTitle=='Edit Packing Instraction Details' ){ ?>
	<script type="text/javascript">
        $(document).ready(function() {
            var dt = $('#view_Packing_Instarction').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "15%", "targets": 0 },
	                 { "width": "15%", "targets": 1 },
					 { "width": "15%", "targets": 2 },
	                 { "width": "15%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Packing Instartion Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchpackinginstartion",
                    type: "post",
	            },
	        });
	    });


		$(document).on('change','#buyer_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			$("#customers-list").html('');
			var buyer_name = $('#buyer_name').val();
		    $('.buyer_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerPonumberbyBuyerid",
				type: "POST",
				data : {'buyer_name' : buyer_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						$('#buyer_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#buyer_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','#buyer_po_number',function(e){  
			e.preventDefault();
			
			//$(".loader_ajax").show();
			         var buyer_po_number = $('#buyer_po_number').val();
		
		
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getbuyerdetialsbybuyerponumber",
							type: "POST",
							data : {'buyer_po_number' : buyer_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#buyer_po_date').val('');
									$('#buyer_delivery_date').val('');
								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );
									$('#buyer_po_date').val(data_row_material.buyer_po_date);
							}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								    $('#buyer_po_date').val('');
								    //$(".loader_ajax").hide();
							}
						});
						return false;
		});

		$(document).on('click','#savepackinginstarction',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnewpackinginstructionform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addnewPackinginstruction",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Packing Instructions Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'packinginstaruction'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deletepackinginstraction',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Packing Instraction Succesfully Deleted",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deletepackinginstraction",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Packing Instraction Succesfully Deleted",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'packinginstaruction'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Packing Instraction deletion cancelled ", "error");
				}
			});
		});

		$(document).on('click','#editpackinginstarction',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#editnewpackinginstructionform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>updatepackinginstraction",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Packing Instructions Successfully Updated!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'packinginstaruction'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });
		
		$(document).on('click','#addpackinginstractiondetails',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var vendor_po_number_number = $('#main_id').val();
			var formData = new FormData($("#addpackingdetailsform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addpackinginstractiondetailsaction",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Packing Instructions Details Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'addpackinginstractiondetails/'?>"+vendor_po_number_number;
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deletepackinginstractionsubitem',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Packing Instraction Item Succesfully Deleted",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deletepackinginstractionsubitem",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Packing Instraction Item Succesfully Deleted",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'addpackinginstractiondetails/'?>"+elemF.attr('main-id');
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Packing Instraction Item deletion cancelled ", "error");
				}
			});
		});

        $(document).on('click','.editpackinginstractionsubitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			$.ajax({
				url : "<?php echo base_url();?>geteditpackinginstractionsubitem",
				type: "POST",
				data : 'id='+item_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 
						$('#packing_details_item_id').val(fetchResponse.id); 
						$('#part_number').val(fetchResponse.part_number);  
						$('#buyer_invoice_number').val(fetchResponse.buyer_invoice_number); 
						$('#buyer_invoice_qty').val(fetchResponse.buyer_invoice_qty); 
						$('#buyer_invoice_date').val(fetchResponse.buyer_invoice_date); 
						$('#buyer_item_delivery_date').val(fetchResponse.buyer_item_delivery_date); 
						$('#box_qty').val(fetchResponse.box_qty); 
						$('#remark').val(fetchResponse.remark); 
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		});


		$(document).on('change','#part_number',function(e){  
			e.preventDefault();
			        var part_number = $('#part_number').val();	
					var main_id = $('#main_id').val();	

					$.ajax({
							url : "<?php echo ADMIN_PATH;?>checkifpartnumberisalreadyexists",
							type: "POST",
							data : {'part_number' : part_number,'main_id' : main_id},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									// $('#buyer_po_date').val('');
									   $('#buyer_delivery_date').val('');
								}
								else
								{
										swal({
											title: "Record Exists Notification",
											text: "Record Already Exists for this buyer PO and Date.Do you Still want to Insert The record ?",
											icon: "success",
											button: "Ok",
											},function(){ 
												
										});		
							    }
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								    $('#buyer_po_date').val('');
								    //$(".loader_ajax").hide();
							}
				});
			return false;
		});


		$(document).on('change','#buyer_name,#buyer_po_number',function(e){  
			e.preventDefault();
			        var buyer_name = $('#buyer_name').val();	
					var buyer_po_number = $('#buyer_po_number').val();	

					$.ajax({
							url : "<?php echo ADMIN_PATH;?>checkifpackingintractionalreadyexists",
							type: "POST",
							data : {'buyer_name' : buyer_name,'buyer_po_number' : buyer_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									// $('#buyer_po_date').val('');
									// $('#buyer_delivery_date').val('');
								}
								else
								{
										swal({
											title: "Record Exists Notification",
											text: "Record Already Exists for this buyer Name and buyer PO .Do you Still want to Insert The record ?",
											icon: "success",
											button: "Ok",
											},function(){ 
												
										});		
							    }
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								    //$('#buyer_po_date').val('');
								    //$(".loader_ajax").hide();
							}
				});
			return false;
		});

		
		
		$(document).on('change','.get_buyer_delivery_date',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// var elemF = $(this);
			// var item_id = elemF.getAttribute('data-id');

			var selectElement = document.getElementById("part_number");
			// Get the selected option element
			var selectedOption = selectElement.options[selectElement.selectedIndex];

			// Get the value of the data-info attribute of the selected option
			var poitemid = selectedOption.getAttribute("data_id");

			


			                        var buyer_po_number_id = $('#buyer_po_number_id').val();
									var part_number = $('#part_number').val();
									var buyer_item_delivery_date = $('#buyer_item_delivery_date').val();
									
		
									$('#buyer_item_delivery_date').val('');	

									$.ajax({
										url : "<?php echo ADMIN_PATH;?>getbuyerdetailsbybuteridoritemid",
										type: "POST",
										data : {'buyer_po_number_id' : buyer_po_number_id,'part_number':part_number,'poitemid':poitemid,'buyer_item_delivery_date':buyer_item_delivery_date},
										success: function(data, textStatus, jqXHR)
										{
											var get_buyerdata = jQuery.parseJSON( data );

											$(".loader_ajax").hide();
											if(data == "failure")
											{
										
												$('#buyer_item_delivery_date').val('');	
											}
											else
											{
												
												$('#buyer_item_delivery_date').val(get_buyerdata.buyer_po_part_delivery_date);	



												var selectElement = document.getElementById("part_number");
			// Get the selected option element
			var selectedOption = selectElement.options[selectElement.selectedIndex];

			// Get the value of the data-info attribute of the selected option
			var poitemid = selectedOption.getAttribute("data_id");
			var buyer_po_number_id = $('#buyer_po_number_id').val();
			var part_number = $('#part_number').val();
			var buyer_item_delivery_date = $('#buyer_item_delivery_date').val();


			$(".loader_ajax").show();
			$("#buyer_po_item_list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>admin/getBuyerItemsforDisplaypackgininstarction",
				type: "POST",
				data : {'poitemid' : poitemid,'buyer_po_number_id':buyer_po_number_id,'part_number':part_number,'buyer_item_delivery_date':buyer_item_delivery_date},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						$("#packging_instraction-list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#packging_instraction-list').html();
					$(".loader_ajax").hide();
				}
			});
			return false;


											}
										},
										error: function (jqXHR, textStatus, errorThrown)
										{
												$('#buyer_item_delivery_date').val('');	
											
										}
									});
									return false;
							
		});


		// $(document).on('change','.get_all_records_for_this_buyer_po',function(e){  
		// 	e.preventDefault();

		// 	var selectElement = document.getElementById("part_number");
		// 	// Get the selected option element
		// 	var selectedOption = selectElement.options[selectElement.selectedIndex];

		// 	// Get the value of the data-info attribute of the selected option
		// 	var poitemid = selectedOption.getAttribute("data_id");
		// 	var buyer_po_number_id = $('#buyer_po_number_id').val();
		// 	var part_number = $('#part_number').val();
		// 	var buyer_item_delivery_date = $('#buyer_item_delivery_date').val();


		// 	$(".loader_ajax").show();
		// 	$("#buyer_po_item_list").html('');
		// 	$.ajax({
		// 		url : "<?php echo ADMIN_PATH;?>admin/getBuyerItemsforDisplaypackgininstarction",
		// 		type: "POST",
		// 		data : {'poitemid' : poitemid,'buyer_po_number_id':buyer_po_number_id,'part_number':part_number,'buyer_item_delivery_date':buyer_item_delivery_date},
		// 		success: function(data, textStatus, jqXHR)
		// 		{
		// 			$(".loader_ajax").hide();
		// 			if(data == "failure")
		// 			{
		// 				//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
		// 			}
		// 			else
		// 			{
		// 				$("#packging_instraction-list").html(data);

		// 			}
		// 		},
		// 		error: function (jqXHR, textStatus, errorThrown)
		// 		{
		// 			$('#packging_instraction-list').html();
		// 			$(".loader_ajax").hide();
		// 		}
		// 	});
		// 	return false;







		// });

		</script>
<?php } ?>


<?php if($pageTitle=='Export Details' || $pageTitle=='Add New Export Details' || $pageTitle=="Edit Export Details" || $pageTitle=="Add Export Details Items"){ ?>
	<script type="text/javascript">
        $(document).ready(function() {
            var dt = $('#view_export_details').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "20%", "targets": 0 },
	                 { "width": "20%", "targets": 1 },
					 { "width": "20%", "targets": 2 },
	                 { "width": "15%", "targets": 3 },
					 { "width": "5%", "targets": 4 },
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Export Details Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchexportdetails",
                    type: "post",
	            },
	        });
	    });

		$(document).on('click','#saveexportdetails',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnExportDetailsform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addnewExportDetails",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Export Details Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'exportdetails'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('change','#buyer_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			$("#customers-list").html('');
			var buyer_name = $('#buyer_name').val();
		    $('.buyer_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerPonumberbyBuyerid",
				type: "POST",
				data : {'buyer_name' : buyer_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						$('#buyer_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#buyer_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','#buyer_po_number',function(e){  
			e.preventDefault();
			
			//$(".loader_ajax").show();
			         var buyer_po_number = $('#buyer_po_number').val();
		
		
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getbuyerdetialsbybuyerponumber",
							type: "POST",
							data : {'buyer_po_number' : buyer_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#buyer_po_date').val('');
									$('#buyer_delivery_date').val('');
								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );
									$('#buyer_po_date').val(data_row_material.buyer_po_date);
							}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								    $('#buyer_po_date').val('');
								    //$(".loader_ajax").hide();
							}
						});
						return false;

	
		
		});

		$(document).on('click','#editExportDetails',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#exitExportDetailsform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>updatexportdetails",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Export Details Successfully Updated!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'exportdetails'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });
		
		$(document).on('click','.deleteexportdetailsmain',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Export Details Succesfully Deleted",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteexportdetailsmain",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Export Details Succesfully Deleted",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'exportdetails'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Export Details deletion cancelled ", "error");
				}
			});
		});

		$(document).on('change','#part_number',function(e){  
			e.preventDefault();
		
			    var part_number = $('#part_number').val();
				var exportdetailsid = $('#main_id').val();

		
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>getbuyeramdpackgindetails",
					type: "POST",
					data : {'exportdetailsid' : exportdetailsid,'part_number':part_number},
					success: function(data, textStatus, jqXHR)
					   {
						    $(".loader_ajax").hide();
								
							if(data == "failure")
								{
									$('#buyer_po_date').val('');
									$('#buyer_delivery_date').val('');
								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );
									$('#buyer_po_date').val(data_row_material.buyer_po_date);
							    }
					    },
						error: function (jqXHR, textStatus, errorThrown)
							{
								    $('#buyer_po_date').val('');
					        }
				});
				
				return false;		
		});

    </script>
<?php } ?>


<?php if($pageTitle=='Scrap Return' || $pageTitle=="Add New Scrap Return" || $pageTitle=="Edit Scrap Return"){ ?>
	<script type="text/javascript">
       $(document).ready(function() {
		    var dt = $('#view_scrap_return').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "15%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "20%", "targets": 2 },
	                 { "width": "15%", "targets": 3 },
					 { "width": "8%", "targets": 4 },
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Scrap Return Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchscrapreturn",
                    type: "post",
	            },
	        });
	   });

	   $(document).on('click','#saveScrapreturn',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnewScrapreturnform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addnewScrapreturn",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Scrap Return Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'scrapreturn'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	   });

	   $(document).on('click','.deletescrapreturn',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Scrap Return Succesfully Deleted",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deletescrapreturn",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Scrap Return Succesfully Deleted",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'scrapreturn'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Scrap Return deletion cancelled ", "error");
				}
			});
	   });

	   $(document).on('click','.closeScrapreturn', function(){
			location.reload();
       });

	   $(document).on('click','#savescrapreturnitem',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			   var formData = new FormData($("#addscrapreturnform")[0]);
              
			   var description =   $('#description').val();
			   var gross_weight =   $('#gross_weight').val();
			   var net_weight =   $('#net_weight').val();
			   var quantity =   $('#quantity').val();
			   var number_of_bags =   $('#number_of_bags').val();
			   var hsn_code =   $('#hsn_code').val();
			   var estimated_value =   $('#estimated_value').val();
			   var number_of_processing =   $('#number_of_processing').val();
			   var item_remark =   $('#item_remark').val();
			   var pre_challan_date =   $('#challan_date').val();
			   var pre_vendor_name =   $('#vendor_name').val();
			   var pre_supplier_name =   $('#supplier_name').val();
			   var pre_remark =   $('#remark').val();

			   var challan_table_id = $('#challan_table_id').val();

			   var scrap_item_id = $('#scrap_item_id').val();


			$.ajax({
				url : "<?php echo base_url();?>savescrapreturnitem",
				type: "POST",
				 //data : formData,
				 data :{ description:description,gross_weight:gross_weight,net_weight:net_weight,quantity:quantity,number_of_bags:number_of_bags,hsn_code:hsn_code,estimated_value:estimated_value,number_of_processing:number_of_processing,item_remark:item_remark,pre_challan_date:pre_challan_date,pre_vendor_name:pre_vendor_name,pre_supplier_name:pre_supplier_name,pre_remark:pre_remark,challan_table_id:challan_table_id,scrap_item_id:scrap_item_id },
				// method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								if(challan_table_id){
									window.location.href = "<?php echo base_url().'editscrapreturn/'?>"+challan_table_id;

								}else{
									window.location.href = "<?php echo base_url().'addnewScrapreturn'?>";

								}

										
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	   });

	   $(document).on('click','.deleteScrpareturnid',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Scrap Return Item ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deletescrapreturnitem",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Scrap Return Item Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
													window.location.href = "<?php echo base_url().'addnewScrapreturn'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Scrap Return Item deletion cancelled ", "error");
				}
			});
	   });

	   
	   $(document).on('click','.editScrpareturnid',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			$.ajax({
				url : "<?php echo base_url();?>geteditScrpareturnid",
				type: "POST",
				data : 'id='+item_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 
						$('#scrap_item_id').val(fetchResponse.id); 
						$('#description').val(fetchResponse.description);  
						$('#gross_weight').val(fetchResponse.gross_weight); 
						$('#net_weight').val(fetchResponse.net_weight); 
						$('#quantity').val(fetchResponse.quantity); 
						$('#number_of_bags').val(fetchResponse.number_of_bags); 
						$('#hsn_code').val(fetchResponse.hsn_code); 
						$('#estimated_value').val(fetchResponse.estimated_value); 
						$('#number_of_processing').val(fetchResponse.number_of_processing); 
						$('#item_remark').val(fetchResponse.remarks); 
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		});


    </script>
<?php }?>


<?php if($pageTitle=='Current Order Status'){ ?>

	<script type="text/javascript">
      
		$(document).ready(function() {
		    $("#view_current_order_status").dataTable().fnDestroy();
			var vendor_name = $('#vendor_name').val();
			var status = $('#status').val();
			getallCurrentOrserReport($("#vendor_name").val(), $("#status").val());
	    });

		$(document).on('change','#vendor_name',function(e){  
			$("#view_current_order_status").dataTable().fnDestroy();
				e.preventDefault();
				var vendor_name = $('#vendor_name').val();
				var status = $('#status').val();
				getallCurrentOrserReport($("#vendor_name").val(), $("#status").val());
		});

		$(document).on('change','#status',function(e){  
			$("#view_current_order_status").dataTable().fnDestroy();

			e.preventDefault();
			var vendor_name = $('#vendor_name').val();
			var status = $('#status').val();
			getallCurrentOrserReport($("#vendor_name").val(), $("#status").val());
		});

		function getallCurrentOrserReport(vendor_name,status){

				var dt = $('#view_current_order_status').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "10%", "targets": 0 },
						{ "width": "10%", "targets": 1 },
						{ "width": "10%", "targets": 2 },
						{ "width": "10%", "targets": 3 },
						{ "width": "10%", "targets": 4 },
						{ "width": "10%", "targets": 5 },
						{ "width": "10%", "targets": 6 },
						{ "width": "10%", "targets": 7 },
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No Current Order Status Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>admin/fetchcurrentorderstatusreport/"+vendor_name+"/"+status,
						type: "post",
					},
				});

		}
		
	    $(document).on('click','#export_to_excel',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var vendor_name       =    $('#vendor_name').val();
			var status         =    $("#status").val();

			if(vendor_name){
			    var vendor_name_value = vendor_name;
			}else{
				var vendor_name_value = 'NA';
			}

			if(status){

				var status_value = status;
			}else{

				var status_value = 'NA';
			}
 
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>admin/downlaod_current_orderstatus/"+vendor_name_value+"/"+status_value,
				type: "POST",
				// data : {'hospitals' : hospitals, 'driver' : driver,'ride_start':ride_start,'ride_stop':ride_stop},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
				    {
						$(".report_type_error").html("");
				    	alert('No data fond');
				    }
				    else
				    {
						$(".report_type_error").html("");
				    	window.location.href = "<?php echo ADMIN_PATH;?>admin/downlaod_current_orderstatus/"+vendor_name+"/"+status;
				    }
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   		alert('No data fond');
					$(".loader_ajax").hide();
			    }
			});
		   return false;
	    });

    </script>  
<?php } ?>


<?php if($pageTitle=='Rework Rejection Return Form' || $pageTitle=='Add New Rework Rejection' || $pageTitle=='Edit Rework Rejection'){ ?>
	<script type="text/javascript">
	    $(document).ready(function() {
		    var dt = $('#view_rework_rejection').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					 { "width": "8%", "targets": 6 },
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Rework Rejection Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchreworkrejection",
                    type: "post",
	            },
	        });
	    });

		$(document).ready(function() {

			var vendor_supplier_name = $('#vendor_supplier_name').val();

			    if(vendor_supplier_name=='vendor'){
				    $('#vendor_name_div_for_hide_show').css('display','block');
					$('#supplier_name_div_for_hide_show').css('display','none');

					 var vendor_po_number = $('#vendor_po_number').val();
						$("#part_number").html('');
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
								type: "POST",
								data : {'vendor_po_number' : vendor_po_number},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{
										$('#part_number').html('<option value="">Select Part Number</option>');
									}
									else
									{
										$('#part_number').html(data);

									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$('#part_number').html();
								}
							});
						return false;
			    }


			    if(vendor_supplier_name=='supplier'){
				    $('#supplier_name_div_for_hide_show').css('display','block');
					$('#vendor_name_div_for_hide_show').css('display','none');

						//$(".loader_ajax").show();
						var supplier_po_number = $('.supplier_po_number_for_item').val();
						var flag = 'Supplier';
						$("#part_number").html('');
					
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
							type: "POST",
							data : {'supplier_po_number' : supplier_po_number,'flag':flag},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#part_number').html('<option value="">Select Part Number</option>');
								}
								else
								{
									$('#part_number').html(data);

								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								$('#part_number').html();
							}
						});
						return false;
			        }

			
		});

		$(document).on('change','#vendor_name',function(e){  
				e.preventDefault();
				//$(".loader_ajax").show();
				// $("#customers-list").html('');
				var vendor_name = $('#vendor_name').val();
				$('.vendor_po_number_div').css('display','block');
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>getVendorPonumberbyVendorid",
					type: "POST",
					data : {'vendor_name' : vendor_name},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$('#vendor_po_number').html('<option value="">Select Vendor PO Number</option>');
						}
						else
						{
							// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
							$('#vendor_po_number').html(data);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#vendor_po_number').html();
						//$(".loader_ajax").hide();
					}
				});
				return false;
		});

		$(document).on('change','#supplier_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var supplier_name = $('#supplier_name').val();

		    $('.supplier_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getSupplierPonumberbySupplierid",
				type: "POST",
				data : {'supplier_name' : supplier_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('.supplier_po_number_div').css('display','none');
						$('#supplier_po_number').html('<option value="">Select Supplier PO Number</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#supplier_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#supplier_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('click','#savenewreworkrejection',function(e){
			e.preventDefault();
			$(".loader_ajax").show();

			var formData = new FormData($("#addnnewreworkrejectionform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addneworkrejection",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Rework Rejection Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								window.location.href = "<?php echo base_url().'reworkrejectionreturn'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deletereworkrejection',function(e){
					var elemF = $(this);
					e.preventDefault();
					swal({
						title: "Are you sure?",
						text: "Delete Rework Rejection ",
						type: "warning",
						showCancelButton: true,
						closeOnClickOutside: false,
						confirmButtonClass: "btn-sm btn-danger",
						confirmButtonText: "Yes, delete it!",
						cancelButtonText: "No, cancel plz!",
						closeOnConfirm: false,
						closeOnCancel: false
					}, function(isConfirm) {
						if (isConfirm) {
									$.ajax({
										url : "<?php echo base_url();?>deletereworkrejection",
										type: "POST",
										data : 'id='+elemF.attr('data-id'),
										success: function(data, textStatus, jqXHR)
										{
											const obj = JSON.parse(data);
										
											if(obj.status=='success'){
												swal({
													title: "Deleted!",
													text: "Rework Rejection Deleted Succesfully",
													icon: "success",
													button: "Ok",
													},function(){ 
															window.location.href = "<?php echo base_url().'reworkrejectionreturn'?>";
												});	
											}

										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											$(".loader_ajax").hide();
										}
									})
								}
								else {
						swal("Cancelled", "Rework Rejection deletion cancelled ", "error");
						}
					});
		});

		$(document).on('change','#vendor_supplier_name',function(e){  
				e.preventDefault();
			
				var vendor_supplier_name = $('#vendor_supplier_name').val();

				if(vendor_supplier_name=='vendor'){
					$('#vendor_name_div_for_hide_show').css('display','block');
					$('#supplier_name_div_for_hide_show').css('display','none');

					$(document).on('change','.vendor_po_number_itam',function(e){  
							e.preventDefault();
							//$(".loader_ajax").show();
							var vendor_po_number = $('#vendor_po_number').val();

							$("#part_number").html('');
						
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>getVendoritemonlyforreworkrejection",
								type: "POST",
								data : {'vendor_po_number' : vendor_po_number,'flag':'vendor'},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{
										$('#part_number').html('<option value="">Select Part Number</option>');
									}
									else
									{
										$('#part_number').html(data);

									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$('#part_number').html();
								}
							});
							return false;
					});

				}

				if(vendor_supplier_name=='supplier'){

					$('#supplier_name_div_for_hide_show').css('display','block');
					$('#vendor_name_div_for_hide_show').css('display','none');


					$(document).on('change','.supplier_po_number_for_item',function(e){  
						e.preventDefault();
						//$(".loader_ajax").show();
						var supplier_po_number = $('.supplier_po_number_for_item').val();
						var flag = 'Supplier';
						$("#part_number").html('');
					
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
							type: "POST",
							data : {'supplier_po_number' : supplier_po_number,'flag':flag},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#part_number').html('<option value="">Select Part Number</option>');
								}
								else
								{
									$('#part_number').html(data);

								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								$('#part_number').html();
							}
						});
						return false;
					});

				}			
		});
   
		$(document).on('change','#part_number',function(e){  
			e.preventDefault();


			
			
			var part_number = $('#part_number').val();
		    var vendor_po_number = $('#vendor_po_number').val();
			var vendor_name = $('#vendor_name').val();
			var vendor_supplier_name = $('#vendor_supplier_name').val();

			if(vendor_supplier_name=='vendor'){

				if(vendor_name){
					if(vendor_po_number){
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>getSuppliergoodsreworkrejectionvendor",
								type: "POST",
								data : {'part_number' : part_number,'vendor_po_number':vendor_po_number,'vendor_supplier_name':vendor_supplier_name},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{
										$('#description').val('');
										$('#SAC').val('');
										$('#HSN_Code').val('');
										$('#raw_material_size').val('');
										$('#type_of_raw_material').val('');
										//$('#quantity').val('');
										$('#unit').val('');
										$('#rate').val('');

									}
									else
									{
										var data_row_material = jQuery.parseJSON( data );
										$('#description').val(data_row_material.name);
										$('#SAC').val(data_row_material.sac_no);
										$('#HSN_Code').val(data_row_material.hsn_code);
										$('#raw_material_size').val(data_row_material.sitting_size);
									    $('#type_of_raw_material').val(data_row_material.typeofrawmaterial);
										$('#unit').val(data_row_material.unit);
										$('#rate').val(data_row_material.vendorrate);
										
									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
										$('#description').val('');
										$('#SAC').val('');
										$('#HSN_Code').val('');
										$('#raw_material_size').val('');
										$('#type_of_raw_material').val('');
										//$('#quantity').val('');
										$('#unit').val('');
										$('#rate').val('');									
										//$(".loader_ajax").hide();
								}
							});
							return false;

					}else{
						$('.part_number_error').html('Please Select Vendor PO Number');
					}

				}else{
					$('.part_number_error').html('Please Select Vendor PO');
				}

			}

			if(vendor_supplier_name=='supplier'){

				var supplier_po_number = $('#supplier_po_number').val();
			    var supplier_name = $('#supplier_name').val();
				
				if(supplier_name){
					if(supplier_po_number){
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>getSuppliergoodsreworkrejectionsupplier",
								type: "POST",
								data : {'part_number' : part_number,'supplier_po_number':supplier_po_number,'vendor_po_number':''},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{
										$('#description').val('');
										$('#SAC').val('');
										$('#HSN_Code').val('');
										$('#raw_material_size').val('');
										$('#vendor_order_qty').val('');
										$('#unit').val('');
										$('#rate').val('');

									}
									else
									{

										var data_row_material = jQuery.parseJSON( data );

										$('#description').val(data_row_material.name);
										$('#SAC').val(data_row_material.sac_no);
										$('#HSN_Code').val(data_row_material.HSN_code);
										$('#raw_material_size').val(data_row_material.sitting_size);
										$('#vendor_order_qty').val(data_row_material.order_oty);
										$('#unit').val(data_row_material.unit);
										$('#rate').val(data_row_material.supplierrate);
										
									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
										$('#description').val('');
										$('#SAC').val('');
										$('#HSN_Code').val('');
										$('#raw_material_size').val('');
										$('#vendor_order_qty').val('');
										$('#unit').val('');
										$('#rate').val('');									
										//$(".loader_ajax").hide();
								}
							});
							return false;

					}else{
						$('.part_number_error').html('Please Select Vendor PO Number');
					}

				}else{
					$('.part_number_error').html('Please Select Vendor PO');
				}
			}

		});

		$(document).on('click','.closereworkrejectionmodal', function(){
			location.reload();
        });

		$(document).on('change', '#rate,#quantity', function(){	
				$("#balanced_aty").val();
			  
				if($("#rate").val()){
					 var rate = $("#rate").val();
				 }else{
					 var rate = 0;
				 }

				 if($("#quantity").val()){
					 var quantity = $("#quantity").val();
				 }else{
					 var quantity = 0;
				 }
				 
				 var value = parseFloat(rate) * parseFloat(quantity);
				 $("#value").val( Math.round(value));
		});

		$(document).on('change', '#gst_rate', function(){	

		    var gst_rate_value = $("#gst_rate").val();

			if(gst_rate_value=='IGST'){

				$(".cgst_sgst_div").attr("style", "display:none");
				$(".igst_div").attr("style", "display:block");
				$(".cgst_sgst_div_6").attr("style", "display:none");
				$(".igst_div_12").attr("style", "display:none");

				var base_val = $("#value").val();
				var row_material_cost = $("#row_material_cost").val();
				var total_value = parseFloat(base_val) + parseFloat(row_material_cost) ;
				var gst_value = parseFloat(total_value) * 18 / 100;
				
				$("#igst_rate_18").val( Math.round(gst_value));
				$("#gst").val( Math.round(gst_value));
				$("#grand_total").val( Math.round(gst_value) + Math.round(total_value)); 


			}else if(gst_rate_value=='CGST_SGST'){

				var base_val = $("#value").val();
				var row_material_cost = $("#row_material_cost").val();
				var total_value = parseFloat(base_val) + parseFloat(row_material_cost) ;

				var gst_value = parseFloat(total_value) * 18 / 100;

				$(".igst_div").attr("style", "display:none");
				$(".cgst_sgst_div").attr("style", "display:block");
				$(".cgst_sgst_div_6").attr("style", "display:none");
				$(".igst_div_12").attr("style", "display:none");

				var cgst_rate  =Math.round(gst_value)/2;

				var SGST_rate  =Math.round(gst_value)/2;

				$("#CGST_rate_9").val( Math.round(cgst_rate));
				$("#SGST_rate_9").val( Math.round(SGST_rate));

				$("#gst").val( Math.round(gst_value));

				$("#grand_total").val( Math.round(gst_value) + Math.round(total_value));

			}else if(gst_rate_value=='CGST_SGST_6'){

				$(".igst_div").attr("style", "display:none");
				$(".cgst_sgst_div").attr("style", "display:none");
				$(".cgst_sgst_div_6").attr("style", "display:block");
				$(".igst_div_12").attr("style", "display:none");

				var base_val = $("#value").val();
				var row_material_cost = $("#row_material_cost").val();
				var total_value = parseFloat(base_val) + parseFloat(row_material_cost) ;

				var gst_value = parseFloat(total_value) * 12 / 100;

				var cgst_rate  =Math.round(gst_value)/2;

				var SGST_rate  =Math.round(gst_value)/2;

				$("#CGST_rate_6").val( Math.round(cgst_rate));
				$("#SGST_rate_6").val( Math.round(SGST_rate));

				$("#gst").val( Math.round(gst_value));

				$("#grand_total").val( Math.round(gst_value) + Math.round(total_value));

			}else if(gst_rate_value=='IGST_12'){

				$(".igst_div").attr("style", "display:none");
				$(".cgst_sgst_div").attr("style", "display:none");
				$(".cgst_sgst_div_6").attr("style", "display:none");
				$(".igst_div_12").attr("style", "display:block");

				var base_val = $("#value").val();
				var row_material_cost = $("#row_material_cost").val();
				var total_value = parseFloat(base_val) + parseFloat(row_material_cost) ;
				var gst_value = parseFloat(total_value) * 12 / 100;
				
				$("#igst_rate_12").val( Math.round(gst_value));
				$("#gst").val( Math.round(gst_value));
				$("#grand_total").val( Math.round(gst_value) + Math.round(total_value)); 

			}


		});

		$(document).on('click','#savereworkrejectiontem',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			   var formData = new FormData($("#addnnewreworkrejectionitemform")[0]);

			   var part_number =   $('#part_number').val();
			   var description =   $('#description').val();
			   var rejected_work_reason =   $('#rejected_work_reason').val();
			   var quantity =   $('#quantity').val();
			   var unit =   $('#unit').val();
			   var rate =   $('#rate').val();
			   var value =   $('#value').val();
			   var row_material_cost =   $('#row_material_cost').val();
			   var gst_rate =   $('#gst_rate').val();
			   var grand_total =   $('#grand_total').val();
			   var item_remark =   $('#item_remark').val();
			   var gst_val =   $('#gst').val();

			   var pre_challan_date =   $('#challan_date').val();
			   var pre_vendor_supplier_name =   $('#vendor_supplier_name').val();
			   var pre_vendor_name =   $('#vendor_name').val();
			   var pre_vendor_po_number =   $('#vendor_po_number').val();
			   var pre_supplier_name =   $('#supplier_name').val();
			   var pre_supplier_po_number =   $('#supplier_po_number').val();
			   var pre_dispath_through =   $('#dispath_through').val();
			   var pre_total_weight =   $('#total_weight').val();
			   var pre_total_netweight_weight =   $('#total_netweight_weight').val();
			   var pre_total_bags =   $('#total_bags').val();
			   var pre_remark =   $('#remark').val();

			   var reworkrejectionid =   $('#reworkrejectionid').val();

			   var rework_rejection_item_id =   $('#rework_rejection_item_id').val();
			   
			   


			$.ajax({
				url : "<?php echo base_url();?>savereworkrejectiontem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,rejected_work_reason:rejected_work_reason,quantity:quantity,rate:rate,value:value,row_material_cost:row_material_cost,gst_rate:gst_rate,grand_total:grand_total,item_remark:item_remark,pre_challan_date:pre_challan_date,pre_vendor_supplier_name:pre_vendor_supplier_name,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_supplier_name:pre_supplier_name,pre_supplier_po_number:pre_supplier_po_number,pre_dispath_through:pre_dispath_through,pre_total_weight:pre_total_weight,pre_total_bags:pre_total_bags,pre_remark:pre_remark,reworkrejectionid:reworkrejectionid,rework_rejection_item_id:rework_rejection_item_id,unit:unit,gst_val:gst_val,pre_total_netweight_weight:pre_total_netweight_weight },
				// method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								if(reworkrejectionid){
								 	window.location.href = "<?php echo base_url().'editreworkrejection/'?>"+reworkrejectionid;
								 }else{
									window.location.href = "<?php echo base_url().'addneworkrejection'?>";
								}		
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deleteReworkRejectionitem',function(e){
				var elemF = $(this);
				e.preventDefault();
				swal({
					title: "Are you sure?",
					text: "Delete Rework Rejection Item ",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deleteReworkRejectionitem",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "Rework Rejection Item Deleted Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 
														window.location.href = "<?php echo base_url().'addneworkrejection'?>";
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "Rework Rejection Item deletion cancelled ", "error");
					}
				});
		});

		$(document).on('click','.editReworkRejectionitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');

			var vendor_po_number =   $('#vendor_po_number').val();
			var vendor_supplier_name = $('#vendor_supplier_name').val();

			$.ajax({
				url : "<?php echo base_url();?>geteditReworkRejectionitem",
				type: "POST",
			    data : {'id' : item_id,'vendor_po_number':vendor_po_number,'vendor_supplier_name':vendor_supplier_name},
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 
						$('#rework_rejection_item_id').val(fetchResponse.rework_rejection_item_id); 
						$('#part_number').val(fetchResponse.raw_id);  
						$('#description').val(fetchResponse.description); 
						$('#HSN_Code').val(fetchResponse.HSN_code); 
						$('#SAC').val(fetchResponse.sac); 
						$('#type_of_raw_material').val(fetchResponse.tppp); 
						$('#rejected_work_reason').val(fetchResponse.rejection_rework_reason); 
						$('#quantity').val(fetchResponse.qty); 
						$('#unit').val(fetchResponse.unit); 
						$('#rate').val(fetchResponse.rate); 
						$('#value').val(fetchResponse.value); 
						$('#row_material_cost').val(fetchResponse.row_material_cost); 
						$('#gst_rate').val(fetchResponse.gst_rate); 
						$('#gst').val(fetchResponse.gst_value); 
						$('#grand_total').val(fetchResponse.grand_total); 
						$('#item_remark').val(fetchResponse.item_remark); 
						
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		});

	</script> 
<?php } ?>


<?php if($pageTitle=='Challan Form' || $pageTitle=='Add New Challan Form' || $pageTitle=='Edit Challan Form'){ ?>
	<script type="text/javascript">

        $(document).ready(function() {
		    var dt = $('#view_challan_form').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					 { "width": "10%", "targets": 6 },
					 { "width": "10%", "targets": 7 },
					 { "width": "10%", "targets": 8 },
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Challan Form Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchchallanform",
                    type: "post",
	            },
	        });
	    });

		$(document).ready(function() {

		    var vendor_supplier_name = $('#vendor_supplier_name').val();
			if(vendor_supplier_name=='vendor'){

				$('#vendor_name_div_for_hide_show').css('display','block');
				$('#supplier_name_div_for_hide_show').css('display','none');

				var vendor_po_number = $('#vendor_po_number').val();
					$("#part_number").html('');
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
							type: "POST",
							data : {'vendor_po_number' : vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#part_number').html('<option value="">Select Part Number</option>');
								}
								else
								{
									$('#part_number').html(data);

								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								$('#part_number').html();
							}
						});
					return false;
			}


			if(vendor_supplier_name=='supplier'){
				$('#supplier_name_div_for_hide_show').css('display','block');
				$('#vendor_name_div_for_hide_show').css('display','none');

					//$(".loader_ajax").show();
					var supplier_po_number = $('.supplier_po_number_for_item').val();
					var flag = 'Supplier';
					$("#part_number").html('');
				
					$.ajax({
						url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
						type: "POST",
						data : {'supplier_po_number' : supplier_po_number,'flag':flag},
						success: function(data, textStatus, jqXHR)
						{
							$(".loader_ajax").hide();
							if(data == "failure")
							{
								$('#part_number').html('<option value="">Select Part Number</option>');
							}
							else
							{
								$('#part_number').html(data);

							}
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							$('#part_number').html();
						}
					});
					return false;
				}


		});

		$(document).on('click','#savenewchallanform',function(e){
			e.preventDefault();
			$(".loader_ajax").show();

			var formData = new FormData($("#addnnewchallanform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addchallanform",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Challan Form Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								window.location.href = "<?php echo base_url().'challanform'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

        $(document).on('change','#vendor_name',function(e){  
				e.preventDefault();
				//$(".loader_ajax").show();
				// $("#customers-list").html('');
				var vendor_name = $('#vendor_name').val();
				$('.vendor_po_number_div').css('display','block');
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>getVendorPonumberbyVendorid",
					type: "POST",
					data : {'vendor_name' : vendor_name},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$('#vendor_po_number').html('<option value="">Select Vendor PO Number</option>');
						}
						else
						{
							// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
							$('#vendor_po_number').html(data);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#vendor_po_number').html();
						//$(".loader_ajax").hide();
					}
				});
				return false;
		});

		$(document).on('change','#supplier_name',function(e){  
				e.preventDefault();
				//$(".loader_ajax").show();
				// $("#customers-list").html('');
				var supplier_name = $('#supplier_name').val();

				$('.supplier_po_number_div').css('display','block');
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>getSupplierPonumberbySupplierid",
					type: "POST",
					data : {'supplier_name' : supplier_name},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							//$('.supplier_po_number_div').css('display','none');
							$('#supplier_po_number').html('<option value="">Select Supplier PO Number</option>');
						}
						else
						{
							// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
							$('#supplier_po_number').html(data);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#supplier_po_number').html();
						//$(".loader_ajax").hide();
					}
				});
				return false;
		});

        $(document).on('change','#vendor_supplier_name',function(e){  
				e.preventDefault();
			
				var vendor_supplier_name = $('#vendor_supplier_name').val();

				if(vendor_supplier_name=='vendor'){
					$('#vendor_name_div_for_hide_show').css('display','block');
					$('#supplier_name_div_for_hide_show').css('display','none');

					$(document).on('change','.vendor_po_number_itam',function(e){  
							e.preventDefault();
							//$(".loader_ajax").show();
							var vendor_po_number = $('#vendor_po_number').val();

							$("#part_number").html('');
						
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>getVendoritemonlyforchallan",
								type: "POST",
								data : {'vendor_po_number' : vendor_po_number},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{
										$('#part_number').html('<option value="">Select Part Number</option>');
									}
									else
									{
										$('#part_number').html(data);

									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$('#part_number').html();
								}
							});
							return false;
					});

				}

				if(vendor_supplier_name=='supplier'){

					$('#supplier_name_div_for_hide_show').css('display','block');
					$('#vendor_name_div_for_hide_show').css('display','none');


					$(document).on('change','.supplier_po_number_for_item',function(e){  
						e.preventDefault();
						//$(".loader_ajax").show();
						var supplier_po_number = $('.supplier_po_number_for_item').val();
						var flag = 'Supplier';
						$("#part_number").html('');
					
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
							type: "POST",
							data : {'supplier_po_number' : supplier_po_number,'flag':flag},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#part_number').html('<option value="">Select Part Number</option>');
								}
								else
								{
									$('#part_number').html(data);

								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								$('#part_number').html();
							}
						});
						return false;
					});

				}			
		});

		$(document).on('click','.deletechallanform',function(e){
					var elemF = $(this);
					e.preventDefault();
					swal({
						title: "Are you sure?",
						text: "Delete Challan Form ",
						type: "warning",
						showCancelButton: true,
						closeOnClickOutside: false,
						confirmButtonClass: "btn-sm btn-danger",
						confirmButtonText: "Yes, delete it!",
						cancelButtonText: "No, cancel plz!",
						closeOnConfirm: false,
						closeOnCancel: false
					}, function(isConfirm) {
						if (isConfirm) {
									$.ajax({
										url : "<?php echo base_url();?>deletechallanform",
										type: "POST",
										data : 'id='+elemF.attr('data-id'),
										success: function(data, textStatus, jqXHR)
										{
											const obj = JSON.parse(data);
										
											if(obj.status=='success'){
												swal({
													title: "Deleted!",
													text: "Challan Form Deleted Succesfully",
													icon: "success",
													button: "Ok",
													},function(){ 
															window.location.href = "<?php echo base_url().'challanform'?>";
												});	
											}

										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											$(".loader_ajax").hide();
										}
									})
								}
								else {
						swal("Cancelled", "Challan form deletion cancelled ", "error");
						}
					});
		});

		$(document).on('change','#part_number',function(e){  
			e.preventDefault();
			
			var part_number = $('#part_number').val();
		    var vendor_po_number = $('#vendor_po_number').val();
			var vendor_name = $('#vendor_name').val();
			var vendor_supplier_name = $('#vendor_supplier_name').val();

			if(vendor_supplier_name=='vendor'){

				if(vendor_name){
					if(vendor_po_number){
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>getSuppliergoodsreworkrejectionvendorchallan",
								type: "POST",
								data : {'part_number' : part_number,'vendor_po_number':vendor_po_number,'vendor_supplier_name':vendor_supplier_name},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{
										$('#description').val('');
										$('#SAC').val('');
										$('#HSN_Code').val('');
										$('#raw_material_size').val('');
										$('#type_of_raw_material').val('');
										//$('#quantity').val('');
										$('#unit').val('');
										$('#rate').val('');

									}
									else
									{
										var data_row_material = jQuery.parseJSON( data );
										$('#description').val(data_row_material.name);
										$('#SAC').val(data_row_material.sac_no);
										$('#HSN_Code').val(data_row_material.hsn_code);
										$('#raw_material_size').val(data_row_material.sitting_size);
									    $('#type_of_raw_material').val(data_row_material.typeofrawmaterial);
										$('#unit').val(data_row_material.unit);
										$('#rate').val(data_row_material.vendorrate);
										
									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
										$('#description').val('');
										$('#SAC').val('');
										$('#HSN_Code').val('');
										$('#raw_material_size').val('');
										$('#type_of_raw_material').val('');
										//$('#quantity').val('');
										$('#unit').val('');
										$('#rate').val('');									
										//$(".loader_ajax").hide();
								}
							});
							return false;

					}else{
						$('.part_number_error').html('Please Select Vendor PO Number');
					}

				}else{
					$('.part_number_error').html('Please Select Vendor PO');
				}

			}

			if(vendor_supplier_name=='supplier'){

				var supplier_po_number = $('#supplier_po_number').val();
			    var supplier_name = $('#supplier_name').val();
				
				if(supplier_name){
					if(supplier_po_number){
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>getSuppliergoodsreworkrejectionsupplier",
								type: "POST",
								data : {'part_number' : part_number,'supplier_po_number':supplier_po_number,'vendor_po_number':''},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{
										$('#description').val('');
										$('#SAC').val('');
										$('#HSN_Code').val('');
										$('#raw_material_size').val('');
										$('#vendor_order_qty').val('');
										$('#unit').val('');
										$('#rate').val('');

									}
									else
									{

										var data_row_material = jQuery.parseJSON( data );

										$('#description').val(data_row_material.name);
										$('#SAC').val(data_row_material.sac_no);
										$('#HSN_Code').val(data_row_material.HSN_code);
										$('#raw_material_size').val(data_row_material.sitting_size);
										$('#vendor_order_qty').val(data_row_material.order_oty);
										$('#unit').val(data_row_material.unit);
										$('#rate').val(data_row_material.supplierrate);
										
									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
										$('#description').val('');
										$('#SAC').val('');
										$('#HSN_Code').val('');
										$('#raw_material_size').val('');
										$('#vendor_order_qty').val('');
										$('#unit').val('');
										$('#rate').val('');									
										//$(".loader_ajax").hide();
								}
							});
							return false;

					}else{
						$('.part_number_error').html('Please Select Vendor PO Number');
					}

				}else{
					$('.part_number_error').html('Please Select Vendor PO');
				}
			}

		});

        $(document).on('change', '#rate,#quantity', function(){	
				$("#balanced_aty").val();
			  
				if($("#rate").val()){
					 var rate = $("#rate").val();
				 }else{
					 var rate = 0;
				 }

				 if($("#quantity").val()){
					 var quantity = $("#quantity").val();
				 }else{
					 var quantity = 0;
				 }
				 
				 var value = parseFloat(rate) * parseFloat(quantity);
				 $("#value").val( Math.round(value));
		});

		$(document).on('change', '#gst_rate', function(){	
			var gst_rate_value = $("#gst_rate").val();
			if(gst_rate_value=='IGST'){

				$(".cgst_sgst_div").attr("style", "display:none");
				$(".igst_div").attr("style", "display:block");
				$(".cgst_sgst_div_6").attr("style", "display:none");
				$(".igst_div_12").attr("style", "display:none");

				var base_val = $("#value").val();
				var row_material_cost = $("#row_material_cost").val();
				var total_value = parseFloat(base_val) + parseFloat(row_material_cost) ;
				var gst_value = parseFloat(total_value) * 18 / 100;
				
				$("#igst_rate_18").val( Math.round(gst_value));
				$("#gst").val( Math.round(gst_value));
				$("#grand_total").val( Math.round(gst_value) + Math.round(total_value)); 


			}else if(gst_rate_value=='CGST_SGST'){

				var base_val = $("#value").val();
				var row_material_cost = $("#row_material_cost").val();
				var total_value = parseFloat(base_val) + parseFloat(row_material_cost) ;

				var gst_value = parseFloat(total_value) * 18 / 100;

				$(".igst_div").attr("style", "display:none");
				$(".cgst_sgst_div").attr("style", "display:block");
				$(".cgst_sgst_div_6").attr("style", "display:none");
				$(".igst_div_12").attr("style", "display:none");

				var cgst_rate  =Math.round(gst_value)/2;

				var SGST_rate  =Math.round(gst_value)/2;

				$("#CGST_rate_9").val( Math.round(cgst_rate));
				$("#SGST_rate_9").val( Math.round(SGST_rate));

				$("#gst").val( Math.round(gst_value));

				$("#grand_total").val( Math.round(gst_value) + Math.round(total_value));

			}else if(gst_rate_value=='CGST_SGST_6'){

				$(".igst_div").attr("style", "display:none");
				$(".cgst_sgst_div").attr("style", "display:none");
				$(".cgst_sgst_div_6").attr("style", "display:block");
				$(".igst_div_12").attr("style", "display:none");

				var base_val = $("#value").val();
				var row_material_cost = $("#row_material_cost").val();
				var total_value = parseFloat(base_val) + parseFloat(row_material_cost) ;

				var gst_value = parseFloat(total_value) * 12 / 100;

				var cgst_rate  =Math.round(gst_value)/2;

				var SGST_rate  =Math.round(gst_value)/2;

				$("#CGST_rate_6").val( Math.round(cgst_rate));
				$("#SGST_rate_6").val( Math.round(SGST_rate));

				$("#gst").val( Math.round(gst_value));

				$("#grand_total").val( Math.round(gst_value) + Math.round(total_value));

			}else if(gst_rate_value=='IGST_12'){

				$(".igst_div").attr("style", "display:none");
				$(".cgst_sgst_div").attr("style", "display:none");
				$(".cgst_sgst_div_6").attr("style", "display:none");
				$(".igst_div_12").attr("style", "display:block");

				var base_val = $("#value").val();
				var row_material_cost = $("#row_material_cost").val();
				var total_value = parseFloat(base_val) + parseFloat(row_material_cost) ;
				var gst_value = parseFloat(total_value) * 12 / 100;
				
				$("#igst_rate_12").val( Math.round(gst_value));
				$("#gst").val( Math.round(gst_value));
				$("#grand_total").val( Math.round(gst_value) + Math.round(total_value)); 

			}
        });

		$(document).on('click','.closechallanformmodal', function(){
			location.reload();
        });

		$(document).on('click','#saveChallanformpopopitem',function(e){
			e.preventDefault();
			   $(".loader_ajax").show();
			   var formData = new FormData($("#saveChallanformitem_form")[0]);

			   var part_number =   $('#part_number').val();
			   var description =   $('#description').val();
			   var type_of_raw_platting =   $('#type_of_raw_platting').val();
			   var quantity =   $('#quantity').val();
			   var rate =   $('#rate').val();
			   var value =   $('#value').val();
			   var unit =   $('#unit').val();
			   var row_material_cost =   $('#row_material_cost').val();
			   var gst_rate =   $('#gst_rate').val();
			   var gst_value =   $('#gst').val();
			   var grand_total =   $('#grand_total').val();
			   var item_remark =   $('#item_remark').val();

			   var pre_challan_date =   $('#challan_date').val();
			   var pre_vendor_supplier_name =   $('#vendor_supplier_name').val();
			   var pre_vendor_name =   $('#vendor_name').val();
			   var pre_vendor_po_number =   $('#vendor_po_number').val();
			   var pre_supplier_name =   $('#supplier_name').val();
			   var pre_supplier_po_number =   $('#supplier_po_number').val();
			   var pre_usp_id =   $('#usp').val();
			   var pre_remark =   $('#remark').val();

			   var dispatched_by =   $('#dispatched_by').val();
			   var total_gross_weight_in_kgs =   $('#total_gross_weight_in_kgs').val();
			   var total_netweight_in_kgs =   $('#total_netweight_in_kgs').val();
			   var no_of_bags_boxs_goni =   $('#no_of_bags_boxs_goni').val();
			   var paid_unpaid =   $('#paid_unpaid').val();

			   var challan_id =   $('#challan_id').val();
			   var challan_form_item_id =   $('#challan_form_item_id').val();


			
			   $.ajax({
				url : "<?php echo base_url();?>saveChallanformitem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,type_of_raw_platting:type_of_raw_platting,quantity:quantity,rate:rate,value:value,row_material_cost:row_material_cost,gst_rate:gst_rate,grand_total:grand_total,item_remark:item_remark,pre_challan_date:pre_challan_date,pre_vendor_supplier_name:pre_vendor_supplier_name,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_supplier_name:pre_supplier_name,pre_supplier_po_number:pre_supplier_po_number,pre_remark:pre_remark,challan_id:challan_id,challan_form_item_id:challan_form_item_id,unit:unit,pre_usp_id:pre_usp_id,gst_value:gst_value,dispatched_by:dispatched_by,total_gross_weight_in_kgs:total_gross_weight_in_kgs,total_netweight_in_kgs:total_netweight_in_kgs,no_of_bags_boxs_goni:no_of_bags_boxs_goni,paid_unpaid:paid_unpaid},
				 method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								if(challan_id){
								 	window.location.href = "<?php echo base_url().'editchallanform/'?>"+challan_id;
								 }else{
									window.location.href = "<?php echo base_url().'addchallanform'?>";
								}		
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			   });
			return false;
	    });

		$(document).on('click','.deleteChallanformitem',function(e){
			
			var challan_id = $("#challan_id").val();
			var elemF = $(this);
				e.preventDefault();
				swal({
					title: "Are you sure?",
					text: "Delete Challan Form Item ",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deleteChallanformitem",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "Challan Form Item Deleted Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 

													if(challan_id){
														window.location.href = "<?php echo base_url().'editchallanform/'?>"+challan_id;
													}else{
														window.location.href = "<?php echo base_url().'addchallanform'?>";
													}

														
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "Challan Form Item deletion cancelled ", "error");
					}
				});
		});

		$(document).on('click','.editChallanformitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			var vendor_po_number =   $('#vendor_po_number').val();
			var vendor_supplier_name = $('#vendor_supplier_name').val();
			$.ajax({
				url : "<?php echo base_url();?>geteditChallanformitem",
				type: "POST",
				data : {'id' : item_id,'vendor_po_number':vendor_po_number,'vendor_supplier_name':vendor_supplier_name},
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 
						$('#challan_form_item_id').val(fetchResponse.challan_form_item_id); 
						$('#part_number').val(fetchResponse.raw_id);  
						$('#description').val(fetchResponse.description); 
						$('#HSN_Code').val(fetchResponse.HSN_code1); 
						$('#SAC').val(fetchResponse.sac); 
						$('#type_of_raw_material').val(fetchResponse.typeofrow5gk); 
						$('#type_of_raw_platting').val(fetchResponse.type_of_raw_platting); 
						$('#quantity').val(fetchResponse.qty); 
						$('#unit').val(fetchResponse.unit1); 
						$('#rate').val(fetchResponse.rate); 
						$('#value').val(fetchResponse.value); 
						$('#row_material_cost').val(fetchResponse.row_material_cost); 
						$('#gst_rate').val(fetchResponse.gst_rate); 
						$('#gst').val(fetchResponse.gst_value); 
						$('#grand_total').val(fetchResponse.grand_total); 
						$('#item_remark').val(fetchResponse.item_remark); 
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	     });



	</script>
<?php } ?>


<?php if($pageTitle=='Debit Note' || $pageTitle=='Add New Debit Note' || $pageTitle=='Edit Debit Note Form' ){ ?>
	<script type="text/javascript">
		 $(document).ready(function() {
		    var dt = $('#view_debit_note').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					 { "width": "5%", "targets": 6 },
					 { "width": "10%", "targets": 7 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Debit Note Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchdebitnotedetails",
                    type: "post",
	            },
	        });
	     });

		 $(document).ready(function() {

			var vendor_supplier_name = $('#vendor_supplier_name').val();
			if(vendor_supplier_name=='vendor'){

				$('#vendor_name_div_for_hide_show').css('display','block');
				$('#supplier_name_div_for_hide_show').css('display','none');

				var vendor_po_number = $('#vendor_po_number').val();
					$("#part_number").html('');
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
							type: "POST",
							data : {'vendor_po_number' : vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#part_number').html('<option value="">Select Part Number</option>');
								}
								else
								{
									$('#part_number').html(data);

								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								$('#part_number').html();
							}
						});
					return false;
			}

		    if(vendor_supplier_name=='supplier'){
				$('#supplier_name_div_for_hide_show').css('display','block');
				$('#vendor_name_div_for_hide_show').css('display','none');

				//$(".loader_ajax").show();
				var supplier_po_number = $('.supplier_po_number_for_item').val();
				var flag = 'Supplier';
				$("#part_number").html('');
			
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
					type: "POST",
					data : {'supplier_po_number' : supplier_po_number,'flag':flag},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$('#part_number').html('<option value="">Select Part Number</option>');
						}
						else
						{
							$('#part_number').html(data);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#part_number').html();
					}
				});
				return false;
		    }
		 });


		 $(document).ready(function() {


			$("#chq_amt").val();

			//$("#grand_total_main").val();

			if($("#total_amount_of_ok_qty_data").val()){
				var total_amount_of_ok_qty_data = $("#total_amount_of_ok_qty_data").val();
			}else{
				var total_amount_of_ok_qty_data = 0;
			}

			if($("#total_amount_of_ok_qty").val()){
				var total_amount_of_ok_qty = $("#total_amount_of_ok_qty").val();
			}else{
				var total_amount_of_ok_qty = 0;
			}

			if($("#p_and_f_charges").val()){
				var p_and_f_charges = $("#p_and_f_charges").val();
			}else{
				var p_and_f_charges = 0;
			}

			if($("#tds_amount").val()){
				var tds_amount = $("#tds_amount").val();
			}else{
				var tds_amount = 0;
			}

			if($("#freight_amount_charge").val()){
				var freight_amount_charge = $("#freight_amount_charge").val();
			}else{
				var freight_amount_charge = 0;
			}

			if($("#total_debit_amount").val()){
				var total_debit_amount = $("#total_debit_amount").val();
			}else{
				var total_debit_amount = 0;
			}


			//  if($("#p_and_f_charges_main").val()){
			// 	 var p_and_f_charges_main = $("#p_and_f_charges_main").val();
			//  }else{
			// 	 var p_and_f_charges_main = 0;
			//  }


			//  var total_one_group = parseFloat(total_amount_of_ok_qty_data) +  parseFloat(total_amount_of_ok_qty) +  parseFloat(p_and_f_charges_main) ;

			//var total_one_group = parseFloat(total_amount_of_ok_qty_data) +  parseFloat(total_amount_of_ok_qty);

			var total_one_group =  parseFloat(total_amount_of_ok_qty_data);

			var total_second_group = parseFloat(tds_amount) +  parseFloat(freight_amount_charge);

			var chq_amt =  parseFloat(total_one_group) - parseFloat(total_second_group);

			$("#chq_amt").val(chq_amt);


			//var total_third_group = parseFloat(total_debit_amount) +  parseFloat(tds_amount) + parseFloat(chq_amt) +  parseFloat(freight_amount_charge);

			//$("#grand_total_main").val(Math.round(total_third_group));

		 });

		 $(document).on('change','#vendor_supplier_name',function(e){  
				e.preventDefault();
			
				var vendor_supplier_name = $('#vendor_supplier_name').val();

				if(vendor_supplier_name=='vendor'){

					$('#vendor_name_div_for_hide_show').css('display','block');
					$('#supplier_name_div_for_hide_show').css('display','none');

					$(document).on('change','.vendor_po_number_itam',function(e){  
							e.preventDefault();
							//$(".loader_ajax").show();
							var vendor_po_number = $('#vendor_po_number').val();

							$("#part_number").html('');
						
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
								type: "POST",
								data : {'vendor_po_number' : vendor_po_number},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{
										$('#part_number').html('<option value="">Select Part Number</option>');
									}
									else
									{
										$('#part_number').html(data);

									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$('#part_number').html();
								}
							});
							return false;
					});

				}

				if(vendor_supplier_name=='supplier'){

					$('#supplier_name_div_for_hide_show').css('display','block');
					$('#vendor_name_div_for_hide_show').css('display','none');


					$(document).on('change','.supplier_po_number_for_item',function(e){  
						e.preventDefault();
						//$(".loader_ajax").show();
						var supplier_po_number = $('.supplier_po_number_for_item').val();
						var flag = 'Supplier';
						$("#part_number").html('');
					
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
							type: "POST",
							data : {'supplier_po_number' : supplier_po_number,'flag':flag},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#part_number').html('<option value="">Select Part Number</option>');
								}
								else
								{
									$('#part_number').html(data);

								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								$('#part_number').html();
							}
						});
						return false;
					});

				}			
		 });

		 $(document).on('change','#vendor_name',function(e){  
				e.preventDefault();
				//$(".loader_ajax").show();
				// $("#customers-list").html('');
				var vendor_name = $('#vendor_name').val();
				$('.vendor_po_number_div').css('display','block');
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>getVendorPonumberbyVendorid",
					type: "POST",
					data : {'vendor_name' : vendor_name},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$('#vendor_po_number').html('<option value="">Select Vendor PO Number</option>');
						}
						else
						{
							// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
							$('#vendor_po_number').html(data);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#vendor_po_number').html();
						//$(".loader_ajax").hide();
					}
				});
				return false;
		 });

		 $(document).on('change','#supplier_name',function(e){  
				e.preventDefault();
				//$(".loader_ajax").show();
				// $("#customers-list").html('');
				var supplier_name = $('#supplier_name').val();

				$('.supplier_po_number_div').css('display','block');
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>getSupplierPonumberbySupplierid",
					type: "POST",
					data : {'supplier_name' : supplier_name},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							//$('.supplier_po_number_div').css('display','none');
							$('#supplier_po_number').html('<option value="">Select Supplier PO Number</option>');
						}
						else
						{
							// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
							$('#supplier_po_number').html(data);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#supplier_po_number').html();
						//$(".loader_ajax").hide();
					}
				});
				return false;
		 });

         $(document).on('click','#savenewdebitnote',function(e){
			e.preventDefault();
			$(".loader_ajax").show();

			var formData = new FormData($("#addnewdebitnoteform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addnewdebitnote",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Debit Note Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								window.location.href = "<?php echo base_url().'debitnote'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	     });

		 $(document).on('click','.deletedebitnote',function(e){
					var elemF = $(this);
					e.preventDefault();
					swal({
						title: "Are you sure?",
						text: "Delete Debit Note",
						type: "warning",
						showCancelButton: true,
						closeOnClickOutside: false,
						confirmButtonClass: "btn-sm btn-danger",
						confirmButtonText: "Yes, delete it!",
						cancelButtonText: "No, cancel plz!",
						closeOnConfirm: false,
						closeOnCancel: false
					}, function(isConfirm) {
						if (isConfirm) {
									$.ajax({
										url : "<?php echo base_url();?>deletedebitnote",
										type: "POST",
										data : 'id='+elemF.attr('data-id'),
										success: function(data, textStatus, jqXHR)
										{
											const obj = JSON.parse(data);
										
											if(obj.status=='success'){
												swal({
													title: "Deleted!",
													text: "Delete Debit Note Succesfully",
													icon: "success",
													button: "Ok",
													},function(){ 
															window.location.href = "<?php echo base_url().'debitnote'?>";
												});	
											}

										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											$(".loader_ajax").hide();
										}
									})
								}
								else {
						swal("Cancelled", "Debit Note deletion cancelled ", "error");
						}
					});
		 });

		 $(document).on('change','#part_number',function(e){  
			e.preventDefault();
			
			var part_number = $('#part_number').val();
		    var vendor_po_number = $('#vendor_po_number').val();
			var vendor_name = $('#vendor_name').val();
			var vendor_supplier_name = $('#vendor_supplier_name').val();


			if(vendor_supplier_name=='vendor'){

				if(vendor_name){
					if(vendor_po_number){
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>getdebitnotepartnumberdetails_byvendor",
								type: "POST",
								data : {'part_number' : part_number,'vendor_po_number':vendor_po_number},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{
										$('#description').val('');
										$('#rate').val('');
									}
									else
									{
										var data_row_material = jQuery.parseJSON( data );
										$('#description').val(data_row_material.name);
										$('#rate').val(data_row_material.vendorrate);
									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
										$('#description').val('');
										$('#rate').val('');
								}
							});
							return false;

					}else{
						$('.part_number_error').html('Please Select Vendor PO Number');
					}

				}else{
					$('.part_number_error').html('Please Select Vendor PO');
				}

			}

			if(vendor_supplier_name=='supplier'){

				var supplier_po_number = $('#supplier_po_number').val();
			    var supplier_name = $('#supplier_name').val();
				
				if(supplier_name){
					if(supplier_po_number){
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>getSuppliergoodsreworkrejectionsupplier",
								type: "POST",
								data : {'part_number' : part_number,'supplier_po_number':supplier_po_number,'vendor_po_number':''},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{
										$('#description').val('');
										$('#rate').val('');

									}
									else
									{
										var data_row_material = jQuery.parseJSON( data );
										$('#description').val(data_row_material.type_of_raw_material);
										$('#rate').val(data_row_material.supplierrate);
										
									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
										$('#description').val('');
										$('#rate').val('');									
										//$(".loader_ajax").hide();
								}
							});
							return false;

					}else{
						$('.part_number_error').html('Please Select Vendor PO Number');
					}

				}else{
					$('.part_number_error').html('Please Select Vendor PO');
				}
			}

		 });

		 $(document).on('change', '#invoice_qty,#less_quantity,#rejected_quantity,#ok_qty,#p_and_f_charges', function(){	
				$("#received_quantity").val();
			  
				 if($("#invoice_qty").val()){
					 var invoice_qty = $("#invoice_qty").val();
				 }else{
					 var invoice_qty = 0;
				 }

				 if($("#less_quantity").val()){
					 var less_quantity = $("#less_quantity").val();
				 }else{
					 var less_quantity = 0;
				 }

				 if($("#rejected_quantity").val()){
					 var rejected_quantity = $("#rejected_quantity").val();
				 }else{
					 var rejected_quantity = 0;
				 }

				 if($("#rate").val()){
					 var rate = $("#rate").val();
				 }else{
					 var rate = 0;
				 }

				 //var less_qty_rejected_qty = parseFloat(less_quantity) +  parseFloat(rejected_quantity);
				 var less_qty_rejected_qty = parseFloat(less_quantity) +  parseFloat(rejected_quantity);
 
				 var value = parseFloat(invoice_qty) - parseFloat(less_quantity);
				 $("#received_quantity").val(value);

				 var debit_amount =  parseFloat(less_qty_rejected_qty) *  parseFloat(rate);

				 $("#debit_amount").val(debit_amount);


				 if($("#ok_qty").val()){
					 var ok_qty = $("#ok_qty").val();
				 }else{
					 var ok_qty = 0;
				 }

				 if($("#p_and_f_charges").val()){
					 var p_and_f_charges = $("#p_and_f_charges").val();
				 }else{
					 var p_and_f_charges = 0;
				 }

				 var total_amount_ok_qty_data =  parseFloat(ok_qty) *  parseFloat(rate);

				//  var plus_p_n_f_charges =  parseFloat(total_amount_ok_qty_data) +  parseFloat(p_and_f_charges);

                 $("#total_amount_ok_qty_data").val(total_amount_ok_qty_data);

		 });

		 $(document).on('change', '#gst_rate', function(){	
			var gst_rate_value = $("#gst_rate").val();
			if(gst_rate_value=='IGST'){

				$(".cgst_sgst_div").attr("style", "display:none");
				$(".igst_div").attr("style", "display:block");
				$(".cgst_sgst_div_6").attr("style", "display:none");
				$(".igst_div_12").attr("style", "display:none");
				
			
				 if($("#rejected_quantity").val()){
					 var rejected_quantity = $("#rejected_quantity").val();
				 }else{
					 var rejected_quantity = 0;
				 }

				 if($("#less_quantity").val()){
					 var less_quantity = $("#less_quantity").val();
				 }else{
					 var less_quantity = 0;
				 }

				 if($("#rate").val()){
					 var rate = $("#rate").val();
				 }else{
					 var rate = 0;
				 }

				var less_qty_rejected_qty = parseFloat(less_quantity) +  parseFloat(rejected_quantity);

				var base_val = parseFloat(less_qty_rejected_qty) * parseFloat(rate);

				var total_value = parseFloat(base_val);
				var gst_value = parseFloat(total_value) * 18 / 100;
				
				$("#igst_rate_18").val(gst_value);
				$("#gst").val(gst_value);
				//$("#grand_total").val( Math.round(gst_value) + Math.round(total_value)); 


				$(".igst_ok_qty_div").attr("style", "display:block");
				$(".igst_ok_div_12_div").attr("style", "display:none");
				$(".cgst_sgst_ok_9_div").attr("style", "display:none");
				$(".cgst_sgst_ok_6_div").attr("style", "display:none");
				
				if($("#ok_qty").val()){
					 var ok_qty = $("#ok_qty").val();
				 }else{
					 var ok_qty = 0;
				 }


				 if($("#invoice_qty").val()){
					 var invoice_qty = $("#invoice_qty").val();
				 }else{
					 var invoice_qty = 0;
				 }


				 if($("#p_and_f_charges").val()){
					 var p_and_f_charges = $("#p_and_f_charges").val();
				 }else{
					 var p_and_f_charges = 0;
				 }


				 var total_qty_for_ok_qty_plus_pnf = parseFloat(ok_qty) *  parseFloat(rate);

				 var total_qty_for_ok_qty = parseFloat(total_qty_for_ok_qty_plus_pnf) +  parseFloat(p_and_f_charges);

				 var gst_value_ok_18 = parseFloat(total_qty_for_ok_qty) * 18 / 100;

				 $("#igst_rate_ok_18").val(gst_value_ok_18);


				/*=======================================normal invoice=========================================================*/

				var total_qty_normal_plus_pnf = parseFloat(invoice_qty) *  parseFloat(rate);

				var total_qty_normal_qty = parseFloat(total_qty_normal_plus_pnf) +  parseFloat(p_and_f_charges);

				var gst_normal_gst = parseFloat(total_qty_normal_qty) * 18 / 100;

				var total_value_plus_gst_normal= parseFloat(total_qty_normal_qty) + parseFloat(gst_normal_gst);


				$("#total_qty_into_rate").val(total_qty_normal_plus_pnf);
				$("#total_qty_normal_qty_plus_pnf").val(total_qty_normal_qty);
				$("#total_normal_gst_value").val(gst_normal_gst);
				$("#total_normal_gst_value_plus_total").val(total_value_plus_gst_normal);

                /*=======================================normal invoice=========================================================*/


			}else if(gst_rate_value=='CGST_SGST'){

				
				$(".igst_div").attr("style", "display:none");
				$(".cgst_sgst_div").attr("style", "display:block");
				$(".cgst_sgst_div_6").attr("style", "display:none");
				$(".igst_div_12").attr("style", "display:none");

		
				if($("#rejected_quantity").val()){
					 var rejected_quantity = $("#rejected_quantity").val();
				 }else{
					 var rejected_quantity = 0;
				 }


				 if($("#less_quantity").val()){
					 var less_quantity = $("#less_quantity").val();
				 }else{
					 var less_quantity = 0;
				 }

				 if($("#rate").val()){
					 var rate = $("#rate").val();
				 }else{
					 var rate = 0;
				 }

				 if($("#invoice_qty").val()){
					 var invoice_qty = $("#invoice_qty").val();
				 }else{
					 var invoice_qty = 0;
				 }

				var less_qty_rejected_qty = parseFloat(less_quantity) +  parseFloat(rejected_quantity);

				var base_val = parseFloat(less_qty_rejected_qty) * parseFloat(rate);

				var total_value = parseFloat(base_val);

				var gst_value = parseFloat(total_value) * 18 / 100;

				var cgst_rate  =gst_value/2;

				var SGST_rate  =gst_value/2;

				$("#CGST_rate_9").val( cgst_rate);
				$("#SGST_rate_9").val( SGST_rate);

				$("#gst").val(parseFloat(gst_value));

				//$("#grand_total").val( Math.round(gst_value) + Math.round(total_value));

				$(".igst_ok_qty_div").attr("style", "display:none");
				$(".igst_ok_div_12_div").attr("style", "display:none");
				$(".cgst_sgst_ok_9_div").attr("style", "display:block");
				$(".cgst_sgst_ok_6_div").attr("style", "display:none");

				if($("#ok_qty").val()){
					 var ok_qty = $("#ok_qty").val();
				 }else{
					 var ok_qty = 0;
				 }

				 
				 if($("#p_and_f_charges").val()){
					 var p_and_f_charges = $("#p_and_f_charges").val();
				 }else{
					 var p_and_f_charges = 0;
				 }


				 var total_qty_for_ok_qty_plus_pnf = parseFloat(ok_qty) *  parseFloat(rate);

				 var total_qty_for_ok_qty = parseFloat(total_qty_for_ok_qty_plus_pnf) +  parseFloat(p_and_f_charges);


				// var total_qty_for_ok_qty = parseFloat(ok_qty) *  parseFloat(rate)
				var gst_value_ok_9 = parseFloat(total_qty_for_ok_qty) * 18 / 100;
				var cgst_rate_ok_9  =gst_value_ok_9/2;
				var SGST_rate_ok_9  =gst_value_ok_9/2;
				$("#CGST_rate_9_ok").val(cgst_rate_ok_9);
				$("#SGST_rate_9_ok").val(SGST_rate_ok_9);


					/*=======================================normal invoice=========================================================*/

					var total_qty_normal_plus_pnf = parseFloat(invoice_qty) *  parseFloat(rate);

					var total_qty_normal_qty = parseFloat(total_qty_normal_plus_pnf) +  parseFloat(p_and_f_charges);

					var gst_normal_gst = parseFloat(total_qty_normal_qty) * 18 / 100;

					var total_value_plus_gst_normal= parseFloat(total_qty_normal_qty) + parseFloat(gst_normal_gst);


					$("#total_qty_into_rate").val(total_qty_normal_plus_pnf);
					$("#total_qty_normal_qty_plus_pnf").val(total_qty_normal_qty);
					$("#total_normal_gst_value").val(gst_normal_gst);
					$("#total_normal_gst_value_plus_total").val(total_value_plus_gst_normal);

					/*=======================================normal invoice=========================================================*/


			}else if(gst_rate_value=='CGST_SGST_6'){

				$(".igst_div").attr("style", "display:none");
				$(".cgst_sgst_div").attr("style", "display:none");
				$(".cgst_sgst_div_6").attr("style", "display:block");
				$(".igst_div_12").attr("style", "display:none");
				

				if($("#rejected_quantity").val()){
					 var rejected_quantity = $("#rejected_quantity").val();
				 }else{
					 var rejected_quantity = 0;
				 }

				 if($("#less_quantity").val()){
					 var less_quantity = $("#less_quantity").val();
				 }else{
					 var less_quantity = 0;
				 }

				 if($("#rate").val()){
					 var rate = $("#rate").val();
				 }else{
					 var rate = 0;
				 }

				var less_qty_rejected_qty = parseFloat(less_quantity) +  parseFloat(rejected_quantity);

				var base_val = parseFloat(less_qty_rejected_qty) * parseFloat(rate);

				var total_value = parseFloat(base_val);

				var gst_value = parseFloat(total_value) * 12 / 100;

				var cgst_rate  =gst_value/2;

				var SGST_rate  =gst_value/2;

				$("#CGST_rate_6").val( cgst_rate);
				$("#SGST_rate_6").val( SGST_rate);

				$("#gst").val( gst_value);

				//$("#grand_total").val( Math.round(gst_value) + Math.round(total_value));

				$(".igst_ok_qty_div").attr("style", "display:none");
				$(".igst_ok_div_12_div").attr("style", "display:none");
				$(".cgst_sgst_ok_9_div").attr("style", "display:none");
				$(".cgst_sgst_ok_6_div").attr("style", "display:block");

				 if($("#ok_qty").val()){
					 var ok_qty = $("#ok_qty").val();
				 }else{
					 var ok_qty = 0;
				 }

				 if($("#p_and_f_charges").val()){
					 var p_and_f_charges = $("#p_and_f_charges").val();
				 }else{
					 var p_and_f_charges = 0;
				 }


				 if($("#invoice_qty").val()){
					 var invoice_qty = $("#invoice_qty").val();
				 }else{
					 var invoice_qty = 0;
				 }
				 

				 var total_qty_for_ok_qty_plus_pnf = parseFloat(ok_qty) *  parseFloat(rate);

				 var total_qty_for_ok_qty = parseFloat(total_qty_for_ok_qty_plus_pnf) +  parseFloat(p_and_f_charges);

				// var total_qty_for_ok_qty = parseFloat(ok_qty) *  parseFloat(rate)
				var gst_value_ok_6 = parseFloat(total_qty_for_ok_qty) * 12 / 100;
				var cgst_rate_ok_6  =gst_value_ok_6/2;
				var SGST_rate_ok_6  =gst_value_ok_6/2;
				$("#CGST_rate_6_ok").val( cgst_rate_ok_6);
				$("#SGST_rate_6_ok").val( SGST_rate_ok_6);


					/*=======================================normal invoice=========================================================*/

					var total_qty_normal_plus_pnf = parseFloat(invoice_qty) *  parseFloat(rate);

					var total_qty_normal_qty = parseFloat(total_qty_normal_plus_pnf) +  parseFloat(p_and_f_charges);

					var gst_normal_gst = parseFloat(total_qty_normal_qty) * 12 / 100;

					var total_value_plus_gst_normal= parseFloat(total_qty_normal_qty) + parseFloat(gst_normal_gst);


					$("#total_qty_into_rate").val(total_qty_normal_plus_pnf);
					$("#total_qty_normal_qty_plus_pnf").val(total_qty_normal_qty);
					$("#total_normal_gst_value").val(gst_normal_gst);
					$("#total_normal_gst_value_plus_total").val(total_value_plus_gst_normal);

					/*=======================================normal invoice=========================================================*/



				
			}else if(gst_rate_value=='IGST_12'){

				$(".igst_div").attr("style", "display:none");
				$(".cgst_sgst_div").attr("style", "display:none");
				$(".cgst_sgst_div_6").attr("style", "display:none");
				$(".igst_div_12").attr("style", "display:block");

				if($("#rejected_quantity").val()){
					 var rejected_quantity = $("#rejected_quantity").val();
				 }else{
					 var rejected_quantity = 0;
				 }

				 if($("#less_quantity").val()){
					 var less_quantity = $("#less_quantity").val();
				 }else{
					 var less_quantity = 0;
				 }

				 if($("#rate").val()){
					 var rate = $("#rate").val();
				 }else{
					 var rate = 0;
				 }

				var less_qty_rejected_qty = parseFloat(less_quantity) +  parseFloat(rejected_quantity);

				var base_val = parseFloat(less_qty_rejected_qty) * parseFloat(rate);

				var total_value = parseFloat(base_val);
				var gst_value = parseFloat(total_value) * 12 / 100;
				
				$("#igst_rate_12").val( gst_value);
				$("#gst").val(gst_value);
				//$("#grand_total").val( Math.round(gst_value) + Math.round(total_value)); 

				$(".igst_ok_qty_div").attr("style", "display:none");
				$(".igst_ok_div_12_div").attr("style", "display:block");
				$(".cgst_sgst_ok_9_div").attr("style", "display:none");
				$(".cgst_sgst_ok_6_div").attr("style", "display:none");

				if($("#ok_qty").val()){
					 var ok_qty = $("#ok_qty").val();
				 }else{
					 var ok_qty = 0;
				 }

				 if($("#p_and_f_charges").val()){
					 var p_and_f_charges = $("#p_and_f_charges").val();
				 }else{
					 var p_and_f_charges = 0;
				 }


				 if($("#invoice_qty").val()){
					 var invoice_qty = $("#invoice_qty").val();
				 }else{
					 var invoice_qty = 0;
				 }

				 var total_qty_for_ok_qty_plus_pnf = parseFloat(ok_qty) *  parseFloat(rate);

				 var total_qty_for_ok_12_qty = parseFloat(total_qty_for_ok_qty_plus_pnf) + parseFloat(p_and_f_charges);


				//  var total_qty_for_ok_12_qty = parseFloat(ok_qty) *  parseFloat(rate)

				 var gst_value_ok_12 = parseFloat(total_qty_for_ok_12_qty) * 12 / 100;

				 $("#igst_rate_ok_12").val(gst_value_ok_12);

				/*=======================================normal invoice=========================================================*/

				var total_qty_normal_plus_pnf = parseFloat(invoice_qty) *  parseFloat(rate);

				var total_qty_normal_qty = parseFloat(total_qty_normal_plus_pnf) +  parseFloat(p_and_f_charges);

				var gst_normal_gst = parseFloat(total_qty_normal_qty) * 12 / 100;

				var total_value_plus_gst_normal= parseFloat(total_qty_normal_qty) + parseFloat(gst_normal_gst);


				$("#total_qty_into_rate").val(total_qty_normal_plus_pnf);
				$("#total_qty_normal_qty_plus_pnf").val(total_qty_normal_qty);
				$("#total_normal_gst_value").val(gst_normal_gst);
				$("#total_normal_gst_value_plus_total").val(total_value_plus_gst_normal);

				/*=======================================normal invoice=========================================================*/
			}
         });

		 $(document).on('click','.closedebitnotemodel', function(){
			location.reload();
         });

		 $(document).on('click','#savedebitnoteitem',function(e){
			e.preventDefault();
			   $(".loader_ajax").show();
			   var formData = new FormData($("#saveDebitnoteitem_form")[0]);

			   var part_number =   $('#part_number').val();
			   var description =   $('#description').val();
			   var invoice_no =   $('#invoice_no').val();
			   var invoice_date =   $('#invoice_date').val();
			   var invoice_qty =   $('#invoice_qty').val();
			   var ok_qty =   $('#ok_qty').val();
			   var less_quantity =   $('#less_quantity').val();
			   var rejected_quantity =   $('#rejected_quantity').val();
			   var received_quantity =   $('#received_quantity').val();
			   var rate =   $('#rate').val();

			   var gst_rate =   $('#gst_rate').val();

			   if(gst_rate=='CGST_SGST'){
				var sgst_value =   $('#SGST_rate_9').val();
				var cgst_value =   $('#CGST_rate_9').val();

				var SGST_rate_ok =   $('#SGST_rate_9_ok').val();
				var CGST_rate_ok =   $('#CGST_rate_9_ok').val();

				//var total_ok_qty_amount = parseFloat(CGST_rate_ok) + parseFloat(SGST_rate_ok) + parseFloat(rate);

				var total_ok_qty_amount = parseFloat(CGST_rate_ok) + parseFloat(SGST_rate_ok);

			   }

			   if(gst_rate=='CGST_SGST_6'){
				var sgst_value =   $('#SGST_rate_6').val();
				var cgst_value =   $('#CGST_rate_6').val();

				var SGST_rate_ok =   $('#SGST_rate_6_ok').val();
				var CGST_rate_ok =   $('#CGST_rate_6_ok').val();

				//var total_ok_qty_amount = parseFloat(CGST_rate_ok) + parseFloat(SGST_rate_ok) + parseFloat(rate);
				var total_ok_qty_amount = parseFloat(CGST_rate_ok) + parseFloat(SGST_rate_ok);

			   }

			   if(gst_rate=='IGST'){
				var igst_rate =   $('#igst_rate_18').val();
				var igst_rate_ok =   $('#igst_rate_ok_18').val();

				//var total_ok_qty_amount = parseFloat(igst_rate_ok) + parseFloat(rate);

				var total_ok_qty_amount = parseFloat(igst_rate_ok);
			   }

			   if(gst_rate=='IGST_12'){
				var igst_rate =   $('#igst_rate_12').val();
				var igst_rate_ok =   $('#igst_rate_ok_12').val();

				//var total_ok_qty_amount = parseFloat(igst_rate_ok) + parseFloat(rate);

				var total_ok_qty_amount = parseFloat(igst_rate_ok);
			   }

			   var total_amount_of_ok_qty_data =   $('#total_amount_ok_qty_data').val();

			
			   var grand_total =   $('#grand_total').val();
			   var item_remark =   $('#item_remark').val();

			   var debit_amount =   $('#debit_amount').val();

			   var pre_debit_note_date =   $('#debit_note_date').val();
			   var pre_select_with_po_without_po =   $('#select_with_po_without_po').val();
			   var pre_vendor_supplier_name =   $('#vendor_supplier_name').val();
			   var pre_vendor_name =   $('#vendor_name').val();
			   var pre_vendor_po_number =   $('#vendor_po_number').val();
			   var pre_supplier_name =   $('#supplier_name').val();
			   var pre_supplier_po_number =   $('#supplier_po_number').val();
			   var pre_po_date =   $('#po_date').val();
			   var pre_remark =   $('#remark').val();

			   var p_and_f_charges =   $('#p_and_f_charges').val();

			   
			   var debit_id =   $('#debit_id').val();
			   var debit_note_item_id =   $('#debit_note_item_id').val();


			   var total_qty_into_rate =   $('#total_qty_into_rate').val();
			   var total_qty_normal_qty_plus_pnf =   $('#total_qty_normal_qty_plus_pnf').val();
			   var total_normal_gst_value =   $('#total_normal_gst_value').val();
			   var total_normal_gst_value_plus_total =   $('#total_normal_gst_value_plus_total').val();

			   var pre_text_label =   $('#text_label').val();
			   var pre_text_amount =   $('#text_amount').val();

			   var pre_vendor_inv_value =   $('#vendor_inv_value').val();

			
			   $.ajax({
				url : "<?php echo base_url();?>saveDebitnoteitem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,invoice_no:invoice_no,invoice_date:invoice_date,invoice_qty:invoice_qty,ok_qty:ok_qty,less_quantity:less_quantity,rejected_quantity:rejected_quantity,received_quantity:received_quantity,rate:rate,gst_rate:gst_rate,sgst_value:sgst_value,cgst_value:cgst_value,igst_rate:igst_rate,item_remark:item_remark,pre_debit_note_date:pre_debit_note_date,pre_select_with_po_without_po:pre_select_with_po_without_po,pre_vendor_supplier_name:pre_vendor_supplier_name,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_supplier_name:pre_supplier_name,pre_supplier_po_number:pre_supplier_po_number,pre_po_date:pre_po_date,pre_remark:pre_remark,sgst_value:sgst_value,cgst_value:cgst_value,SGST_rate_ok:SGST_rate_ok,CGST_rate_ok:CGST_rate_ok,igst_rate:igst_rate,igst_rate_ok:igst_rate_ok,debit_amount:debit_amount,total_ok_qty_amount:total_ok_qty_amount,debit_id:debit_id,total_amount_of_ok_qty_data:total_amount_of_ok_qty_data,p_and_f_charges:p_and_f_charges,debit_note_item_id:debit_note_item_id,total_qty_into_rate:total_qty_into_rate,total_qty_normal_qty_plus_pnf:total_qty_normal_qty_plus_pnf,total_normal_gst_value:total_normal_gst_value,total_normal_gst_value_plus_total:total_normal_gst_value_plus_total,pre_text_label,pre_text_amount,pre_vendor_inv_value:pre_vendor_inv_value},
				 method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								if(debit_id){
									window.location.href = "<?php echo base_url().'editdebitnoteform/'?>"+debit_id;
								}else{
									window.location.href = "<?php echo base_url().'addnewdebitnote'?>";
								}
							
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			   });
			return false;
	     });

		 $(document).on('click','.deleteDebitnoteitem',function(e){
			
			var challan_id = $("#challan_id").val();
			var elemF = $(this);
				e.preventDefault();
				swal({
					title: "Are you sure?",
					text: "Delete Challan Form Item ",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deleteDebitnoteitem",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "Debit Note Item Deleted Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 

													if(challan_id){
														window.location.href = "<?php echo base_url().'editchallanform/'?>"+challan_id;
													}else{
														window.location.href = "<?php echo base_url().'addnewdebitnote'?>";
													}

														
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "Debit Note Item deletion cancelled ", "error");
					}
				});
	     });

		 $(document).on('change', '#tds_amount,#freight_amount_charge', function(){	
				 $("#chq_amt").val();

				// $("#grand_total_main").val();
			  
				 if($("#total_amount_of_ok_qty_data").val()){
					 var total_amount_of_ok_qty_data = $("#total_amount_of_ok_qty_data").val();
				 }else{
					 var total_amount_of_ok_qty_data = 0;
				 }

				 if($("#total_amount_of_ok_qty").val()){
					 var total_amount_of_ok_qty = $("#total_amount_of_ok_qty").val();
				 }else{
					 var total_amount_of_ok_qty = 0;
				 }

				 if($("#p_and_f_charges").val()){
					 var p_and_f_charges = $("#p_and_f_charges").val();
				 }else{
					 var p_and_f_charges = 0;
				 }

				 if($("#tds_amount").val()){
					 var tds_amount = $("#tds_amount").val();
				 }else{
					 var tds_amount = 0;
				 }

				 if($("#freight_amount_charge").val()){
					 var freight_amount_charge = $("#freight_amount_charge").val();
				 }else{
					 var freight_amount_charge = 0;
				 }

				 if($("#total_debit_amount").val()){
					 var total_debit_amount = $("#total_debit_amount").val();
				 }else{
					 var total_debit_amount = 0;
				 }


				//  if($("#p_and_f_charges_main").val()){
				// 	 var p_and_f_charges_main = $("#p_and_f_charges_main").val();
				//  }else{
				// 	 var p_and_f_charges_main = 0;
				//  }

				 
				//  var total_one_group = parseFloat(total_amount_of_ok_qty_data) +  parseFloat(total_amount_of_ok_qty) +  parseFloat(p_and_f_charges_main) ;

				//var total_one_group = parseFloat(total_amount_of_ok_qty_data) +  parseFloat(total_amount_of_ok_qty);

				 var total_one_group =  parseFloat(total_amount_of_ok_qty_data);

				 var total_second_group = parseFloat(tds_amount) +  parseFloat(freight_amount_charge);

				 var chq_amt =  parseFloat(total_one_group) - parseFloat(total_second_group);

				 $("#chq_amt").val(chq_amt);


				 //var total_third_group = parseFloat(total_debit_amount) +  parseFloat(tds_amount) + parseFloat(chq_amt) +  parseFloat(freight_amount_charge);


				// var total_third_group = parseFloat(total_debit_amount) +  parseFloat(tds_amount) + parseFloat(chq_amt) +  parseFloat(freight_amount_charge);


				// $("#grand_total_main").val(Math.round(total_third_group));
			
		 });

		 $(document).on('change','.vendor_po_get_data',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_po_id = $('.vendor_po_get_data').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>get_vendorpodata",
				type: "POST",
				data : {'vendor_po_id' : vendor_po_id},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#po_date').val('');
					}
					else
					{
						var get_vendorpodata = jQuery.parseJSON( data );
						$('#po_date').val(get_vendorpodata.date);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#po_date').val('');
				}
			});
			return false;
		 });

		 $(document).on('change','.supplier_po_get_data',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var supplier_po_id = $('.supplier_po_get_data').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>get_supplierpodata",
				type: "POST",
				data : {'supplier_po_id' : supplier_po_id},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#po_date').val('');
					}
					else
					{
						var get_supplierdata = jQuery.parseJSON( data );
						$('#po_date').val(get_supplierdata.date);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#po_date').val('');
				}
			});
			return false;
		 });

		 $(document).on('click','.editDebitnoteitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			var vendor_supplier_name = $('#vendor_supplier_name').val();

		
			$.ajax({
				url : "<?php echo base_url();?>geteditDebitnoteitemedit",
				type: "POST",
				data : 'id='+item_id+'&vendor_supplier_name='+vendor_supplier_name,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 

						$('#debit_note_item_id').val(fetchResponse.debit_note_item_id); 
						$('#part_number').val(fetchResponse.raw_id);  
						$('#description').val(fetchResponse.description); 
						$('#invoice_no').val(fetchResponse.invoice_no);
                        $('#invoice_date').val(fetchResponse.invoice_date);
						$('#invoice_qty').val(fetchResponse.invoice_qty);
						$('#ok_qty').val(fetchResponse.ok_qty);
						$('#less_quantity').val(fetchResponse.less_quantity);
						$('#rejected_quantity').val(fetchResponse.rejected_quantity);
						$('#received_quantity').val(fetchResponse.received_quantity);
						$('#p_and_f_charges').val(fetchResponse.p_and_f_charges);
						$('#rate').val(fetchResponse.rate);
						$('#gst_rate').val(fetchResponse.gst_rate);
						$('#debit_amount').val(fetchResponse.debit_amount);
						$('#item_remark').val(fetchResponse.remark);


						if(fetchResponse.gst_rate=='CGST_SGST'){
							$(".cgst_sgst_div").attr("style", "display:block");
							$(".cgst_sgst_ok_9_div").attr("style", "display:block");
							
							$('#SGST_rate_9').val(fetchResponse.SGST_value);
							$('#CGST_rate_9').val(fetchResponse.CGST_value);

							$('#SGST_rate_9_ok').val(fetchResponse.SGST_value_ok_val);
							$('#CGST_rate_9_ok').val(fetchResponse.CGST_value_ok_val);
						}

						if(fetchResponse.gst_rate=='CGST_SGST_6'){
							
							$(".cgst_sgst_div_6").attr("style", "display:block");
							$(".cgst_sgst_ok_6_div").attr("style", "display:block");
							
							$('#SGST_rate_6').val(fetchResponse.SGST_value);
							$('#CGST_rate_6').val(fetchResponse.CGST_value);

							$('#SGST_rate_6_ok').val(fetchResponse.SGST_value_ok_val);
							$('#SGST_rate_6_ok').val(fetchResponse.CGST_value_ok_val);
						}


						if(fetchResponse.gst_rate=='IGST'){
							
							$(".igst_div").attr("style", "display:block");
							$(".igst_ok_qty_div").attr("style", "display:block");
							
							$('#igst_rate_18').val(fetchResponse.IGST_value);
							$('#igst_rate_ok_18').val(fetchResponse.IGST_value_ok_val);

						}


						if(fetchResponse.gst_rate=='IGST_12'){
							
							$(".igst_div_12").attr("style", "display:block");
							$(".igst_ok_div_12_div").attr("style", "display:block");
							
							$('#igst_rate_12').val(fetchResponse.IGST_value);
							$('#igst_rate_ok_12').val(fetchResponse.IGST_value_ok_val);

						}
					

					        $('#total_qty_into_rate').val(fetchResponse.total_qty_into_rate);
							$('#total_qty_normal_qty_plus_pnf').val(fetchResponse.total_qty_normal_qty_plus_pnf);
							$('#total_normal_gst_value').val(fetchResponse.total_normal_gst_value);
							$('#total_normal_gst_value_plus_total').val(fetchResponse.total_normal_gst_value_plus_total);

						


				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		 });

    </script>
<?php } ?>


<?php if($pageTitle=='Payment Details' || $pageTitle=='Add New Payment Details' || $pageTitle=='Edit Payment Details'){ ?>
	<script type="text/javascript">
		$(document).ready(function() {
		    var dt = $('#view_payment_details').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					 { "width": "10%", "targets": 6 },
					 { "width": "10%", "targets": 7 },
					 { "width": "10%", "targets": 8 },
					 { "width": "10%", "targets": 9 },
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Payment Details Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchPaymentdetails",
                    type: "post",
	            },
	        });
	    });

		$(document).ready(function() {
			var vendor_supplier_name = $('#vendor_supplier_name').val();
			if(vendor_supplier_name=='vendor'){

				$('#vendor_name_div_for_hide_show').css('display','block');
				$('#supplier_name_div_for_hide_show').css('display','none');

				var vendor_po_number = $('#vendor_po_number').val();
					$("#part_number").html('');
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
							type: "POST",
							data : {'vendor_po_number' : vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#part_number').html('<option value="">Select Part Number</option>');
								}
								else
								{
									$('#part_number').html(data);

								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								$('#part_number').html();
							}
						});
					return false;
			}

			if(vendor_supplier_name=='supplier'){
				$('#supplier_name_div_for_hide_show').css('display','block');
				$('#vendor_name_div_for_hide_show').css('display','none');

				//$(".loader_ajax").show();
				var supplier_po_number = $('.supplier_po_number_for_item').val();
				var flag = 'Supplier';
				$("#part_number").html('');

				$.ajax({
					url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
					type: "POST",
					data : {'supplier_po_number' : supplier_po_number,'flag':flag},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$('#part_number').html('<option value="">Select Part Number</option>');
						}
						else
						{
							$('#part_number').html(data);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#part_number').html();
					}
				});
				return false;
			}
		});

		$(document).on('change','#vendor_supplier_name',function(e){  
			e.preventDefault();

			var vendor_supplier_name = $('#vendor_supplier_name').val();

			if(vendor_supplier_name=='vendor'){

				$('#vendor_name_div_for_hide_show').css('display','block');
				$('#supplier_name_div_for_hide_show').css('display','none');

				$(document).on('change','.vendor_po_number_itam',function(e){  
						e.preventDefault();
						//$(".loader_ajax").show();
						var vendor_po_number = $('#vendor_po_number').val();

						$("#part_number").html('');
					
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
							type: "POST",
							data : {'vendor_po_number' : vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#part_number').html('<option value="">Select Part Number</option>');
								}
								else
								{
									$('#part_number').html(data);

								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								$('#part_number').html();
							}
						});
						return false;
				});

			}

			if(vendor_supplier_name=='supplier'){

				$('#supplier_name_div_for_hide_show').css('display','block');
				$('#vendor_name_div_for_hide_show').css('display','none');


				$(document).on('change','.supplier_po_number_for_item',function(e){  
					e.preventDefault();
					//$(".loader_ajax").show();
					var supplier_po_number = $('.supplier_po_number_for_item').val();
					var flag = 'Supplier';
					$("#part_number").html('');
				
					$.ajax({
						url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
						type: "POST",
						data : {'supplier_po_number' : supplier_po_number,'flag':flag},
						success: function(data, textStatus, jqXHR)
						{
							$(".loader_ajax").hide();
							if(data == "failure")
							{
								$('#part_number').html('<option value="">Select Part Number</option>');
							}
							else
							{
								$('#part_number').html(data);

							}
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							$('#part_number').html();
						}
					});
					return false;
				});

			}			
		});

		$(document).on('change','#vendor_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_name = $('#vendor_name').val();
			$('.vendor_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorPonumberbyVendorid",
				type: "POST",
				data : {'vendor_name' : vendor_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#vendor_po_number').html('<option value="">Select Vendor PO Number</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#vendor_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','#supplier_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var supplier_name = $('#supplier_name').val();

			$('.supplier_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getSupplierPonumberbySupplierid",
				type: "POST",
				data : {'supplier_name' : supplier_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('.supplier_po_number_div').css('display','none');
						$('#supplier_po_number').html('<option value="">Select Supplier PO Number</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#supplier_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#supplier_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('click','#savenewpaymentdetails',function(e){

			e.preventDefault();
			$(".loader_ajax").show();

			var formData = new FormData($("#addnewpaymentdetailsform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addnewpaymentdetails",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Payment Details Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								window.location.href = "<?php echo base_url().'paymentdetails'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deletepaymentdetails',function(e){
					var elemF = $(this);
					e.preventDefault();
					swal({
						title: "Are you sure?",
						text: "Delete Payment Details",
						type: "warning",
						showCancelButton: true,
						closeOnClickOutside: false,
						confirmButtonClass: "btn-sm btn-danger",
						confirmButtonText: "Yes, delete it!",
						cancelButtonText: "No, cancel plz!",
						closeOnConfirm: false,
						closeOnCancel: false
					}, function(isConfirm) {
						if (isConfirm) {
									$.ajax({
										url : "<?php echo base_url();?>deletepaymentdetails",
										type: "POST",
										data : 'id='+elemF.attr('data-id'),
										success: function(data, textStatus, jqXHR)
										{
											const obj = JSON.parse(data);
										
											if(obj.status=='success'){
												swal({
													title: "Deleted!",
													text: "Payment Details Succesfully Deleted",
													icon: "success",
													button: "Ok",
													},function(){ 
															window.location.href = "<?php echo base_url().'paymentdetails'?>";
												});	
											}

										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											$(".loader_ajax").hide();
										}
									})
								}
								else {
						swal("Cancelled", "Payment Details deletion cancelled ", "error");
						}
					});
		});

		$(document).on('change','.vendor_po_get_data',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_po_id = $('.vendor_po_get_data').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>get_vendorpodata",
				type: "POST",
				data : {'vendor_po_id' : vendor_po_id},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#po_date').val('');
					}
					else
					{
						var get_vendorpodata = jQuery.parseJSON( data );
						$('#po_date').val(get_vendorpodata.date);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#po_date').val('');
				}
			});
			return false;
		});

		$(document).on('change','.supplier_po_get_data',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var supplier_po_id = $('.supplier_po_get_data').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>get_supplierpodata",
				type: "POST",
				data : {'supplier_po_id' : supplier_po_id},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#po_date').val('');
					}
					else
					{
						var get_supplierdata = jQuery.parseJSON( data );
						$('#po_date').val(get_supplierdata.date);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#po_date').val('');
				}
			});
			return false;
		});

		$(document).on('change','.get_vendorpodata_with_debit_data',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			
			var vendor_supplier_name = $('#vendor_supplier_name').val();
			var supplier_po_number = $('#supplier_po_number').val();
			var vendor_po_id = $('.vendor_po_get_data').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>get_vendorpodata_with_debit_data",
				type: "POST",
				data : {'vendor_po_id' : vendor_po_id,'supplier_po_number':supplier_po_number,'vendor_supplier_name':vendor_supplier_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#tds').val('');
						$('#debit_note_amount').val('');
						$('#debit_note_no').val('');
						
					}
					else
					{
						var get_vendorpodata = jQuery.parseJSON( data );
						
						$('#tds').val(get_vendorpodata.tds_amount);
						$('#debit_note_amount').val(get_vendorpodata.total_debit_amount);
						$('#debit_note_no').val(get_vendorpodata.debit_note_number);
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					    $('#tds').val('');
						$('#debit_note_amount').val('');
						$('#debit_note_no').val('');
				}
			});
			return false;
		});

		$(document).on('change','.get_supplierpodata_debit_data',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var supplier_po_id = $('.supplier_po_get_data').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>get_supplierpodata_debit_data",
				type: "POST",
				data : {'supplier_po_id' : supplier_po_id},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#tds').val('');
						$('#debit_note_amount').val('');
						$('#debit_note_no').val('');
					}
					else
					{
						var get_supplierdata = jQuery.parseJSON( data );
						$('#tds').val(get_supplierdata.tds_amount);
						$('#debit_note_amount').val(get_supplierdata.total_debit_amount);
						$('#debit_note_no').val(get_supplierdata.debit_note_number);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					    $('#tds').val('');
						$('#debit_note_amount').val('');
						$('#debit_note_no').val('');
				}
			});
			return false;
		});

    </script>
<?php } ?>


<?php if($pageTitle=='POD Detials' || $pageTitle=='Add New POD Details' || $pageTitle=='edit POD Details'){ ?>
	<script type="text/javascript">
		$(document).ready(function() {
		    var dt = $('#view_POD_details').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					 { "width": "10%", "targets": 6 },
					 { "width": "10%", "targets": 7 },
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No POD Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchpoddetails",
                    type: "post",
	            },
	        });
	    });

		$(document).ready(function() {

		
			var vendor_supplier_name = $('#vendor_supplier_name').val();


			if(vendor_supplier_name=='vendor'){

				// $('#vendor_name_div_for_hide_show').css('display','block');
				// $('#supplier_name_div_for_hide_show').css('display','none');

				// $(document).on('change','.vendor_po_number_itam',function(e){  
						// e.preventDefault();
						//$(".loader_ajax").show();
						var vendor_po_number = $('#vendor_po_number').val();

						$("#part_number").html('');
					
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
							type: "POST",
							data : {'vendor_po_number' : vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#part_number').html('<option value="">Select Part Number</option>');
								}
								else
								{
									$('#part_number').html(data);

								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								$('#part_number').html();
							}
						});
						return false;
				// });

			}

			if(vendor_supplier_name=='supplier'){

				// $('#supplier_name_div_for_hide_show').css('display','block');
				// $('#vendor_name_div_for_hide_show').css('display','none');


				// $(document).on('change','.supplier_po_number_for_item',function(e){  
				// 	e.preventDefault();
					//$(".loader_ajax").show();
					var supplier_po_number = $('.supplier_po_number_for_item').val();
					var flag = 'Supplier';
					$("#part_number").html('');
				
					$.ajax({
						url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
						type: "POST",
						data : {'supplier_po_number' : supplier_po_number,'flag':flag},
						success: function(data, textStatus, jqXHR)
						{
							$(".loader_ajax").hide();
							if(data == "failure")
							{
								$('#part_number').html('<option value="">Select Part Number</option>');
							}
							else
							{
								$('#part_number').html(data);

							}
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							$('#part_number').html();
						}
					});
					return false;
				// });

			}			
		});

		$(document).on('click','#savenewpaymentdetails',function(e){

			e.preventDefault();
			$(".loader_ajax").show();

			var formData = new FormData($("#addnewpaymentdetailsform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addnewpaymentdetails",
				type: "POST",
				data : formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
					{
						$.each(fetchResponse.error, function (i, v)
						{
							$('.'+i+'_error').html(v);
						});
						$(".loader_ajax").hide();
					}
					else if(fetchResponse.status == 'success')
					{
						swal({
							title: "Success",
							text: "Payment Details Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								window.location.href = "<?php echo base_url().'paymentdetails'?>";
						});		
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$(".loader_ajax").hide();
				}
			});
		  return false;
		});

		$(document).on('change','#vendor_supplier_name',function(e){  
			e.preventDefault();

			var vendor_supplier_name = $('#vendor_supplier_name').val();

			if(vendor_supplier_name=='vendor'){

				$('#vendor_name_div_for_hide_show').css('display','block');
				$('#supplier_name_div_for_hide_show').css('display','none');

				$(document).on('change','.vendor_po_number_itam',function(e){  
						e.preventDefault();
						//$(".loader_ajax").show();
						var vendor_po_number = $('#vendor_po_number').val();

						$("#part_number").html('');
					
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getVendoritemonlyforpod",
							type: "POST",
							data : {'vendor_po_number' : vendor_po_number,'vendor_supplier_name':vendor_supplier_name},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#part_number').html('<option value="">Select Part Number</option>');
								}
								else
								{
									$('#part_number').html(data);

								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								$('#part_number').html();
							}
						});
						return false;
				});

			}

			if(vendor_supplier_name=='supplier'){

				$('#supplier_name_div_for_hide_show').css('display','block');
				$('#vendor_name_div_for_hide_show').css('display','none');


				$(document).on('change','.supplier_po_number_for_item',function(e){  
					e.preventDefault();
					//$(".loader_ajax").show();
					var supplier_po_number = $('.supplier_po_number_for_item').val();
					var flag = 'Supplier';
					$("#part_number").html('');
				
					$.ajax({
						url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
						type: "POST",
						data : {'supplier_po_number' : supplier_po_number,'flag':flag},
						success: function(data, textStatus, jqXHR)
						{
							$(".loader_ajax").hide();
							if(data == "failure")
							{
								$('#part_number').html('<option value="">Select Part Number</option>');
							}
							else
							{
								$('#part_number').html(data);

							}
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							$('#part_number').html();
						}
					});
					return false;
				});

			}			
		});

		$(document).on('change','#vendor_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_name = $('#vendor_name').val();
			$('.vendor_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorPonumberbyVendorid",
				type: "POST",
				data : {'vendor_name' : vendor_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#vendor_po_number').html('<option value="">Select Vendor PO Number</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#vendor_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','#supplier_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var supplier_name = $('#supplier_name').val();

			$('.supplier_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getSupplierPonumberbySupplierid",
				type: "POST",
				data : {'supplier_name' : supplier_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('.supplier_po_number_div').css('display','none');
						$('#supplier_po_number').html('<option value="">Select Supplier PO Number</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#supplier_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#supplier_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('click','#savenewpoddetails',function(e){

			e.preventDefault();
			$(".loader_ajax").show();

			var formData = new FormData($("#addnewPODform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addNewPODdetails",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "POD Details Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								window.location.href = "<?php echo base_url().'poddetails'?>";
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.deletepaymentdetails',function(e){
					var elemF = $(this);
					e.preventDefault();
					swal({
						title: "Are you sure?",
						text: "Delete Payment Details",
						type: "warning",
						showCancelButton: true,
						closeOnClickOutside: false,
						confirmButtonClass: "btn-sm btn-danger",
						confirmButtonText: "Yes, delete it!",
						cancelButtonText: "No, cancel plz!",
						closeOnConfirm: false,
						closeOnCancel: false
					}, function(isConfirm) {
						if (isConfirm) {
									$.ajax({
										url : "<?php echo base_url();?>deletepaymentdetails",
										type: "POST",
										data : 'id='+elemF.attr('data-id'),
										success: function(data, textStatus, jqXHR)
										{
											const obj = JSON.parse(data);
										
											if(obj.status=='success'){
												swal({
													title: "Deleted!",
													text: "Payment Details Succesfully Deleted",
													icon: "success",
													button: "Ok",
													},function(){ 
															window.location.href = "<?php echo base_url().'paymentdetails'?>";
												});	
											}

										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											$(".loader_ajax").hide();
										}
									})
								}
								else {
						swal("Cancelled", "Payment Details deletion cancelled ", "error");
						}
					});
		});

		$(document).on('change','.vendor_po_get_data',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_po_id = $('.vendor_po_get_data').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>get_vendorpodata",
				type: "POST",
				data : {'vendor_po_id' : vendor_po_id},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#po_date').val('');
					}
					else
					{
						var get_vendorpodata = jQuery.parseJSON( data );
						$('#po_date').val(get_vendorpodata.date);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#po_date').val('');
				}
			});
			return false;
		});

		 $(document).on('change','.supplier_po_get_data',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var supplier_po_id = $('.supplier_po_get_data').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>get_supplierpodata",
				type: "POST",
				data : {'supplier_po_id' : supplier_po_id},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#po_date').val('');
					}
					else
					{
						var get_supplierdata = jQuery.parseJSON( data );
						$('#po_date').val(get_supplierdata.date);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#po_date').val('');
				}
			});
			return false;
		 });

		 $(document).on('change','#part_number',function(e){  
			e.preventDefault();
			
			var part_number = $('#part_number').val();
		    var vendor_po_number = $('#vendor_po_number').val();
			var vendor_name = $('#vendor_name').val();
			var vendor_supplier_name = $('#vendor_supplier_name').val();


			if(vendor_supplier_name=='vendor'){

				if(vendor_name){
					if(vendor_po_number){
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>getSuppliergoodsreworkrejectionvendorpod",
								type: "POST",
								data : {'part_number' : part_number,'vendor_po_number':vendor_po_number,'vendor_supplier_name':vendor_supplier_name},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{
										$('#description').val('');
										$('#rate').val('');
										$('#order_qty').val('');
									}
									else
									{
										var data_row_material = jQuery.parseJSON( data );
										$('#description').val(data_row_material.typeofrawmaterial);
										$('#rate').val(data_row_material.vendorrate);
										$('#order_qty').val(data_row_material.vendor_order_qty);
									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
										$('#description').val('');
										$('#rate').val('');
										$('#order_qty').val('');
								}
							});
							return false;

					}else{
						$('.part_number_error').html('Please Select Vendor PO Number');
					}

				}else{
					$('.part_number_error').html('Please Select Vendor PO');
				}

			}


			if(vendor_supplier_name=='supplier'){

				var supplier_po_number = $('#supplier_po_number').val();
			    var supplier_name = $('#supplier_name').val();
				
				if(supplier_name){
					if(supplier_po_number){
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>getSuppliergoodsreworkrejectionsupplier",
								type: "POST",
								data : {'part_number' : part_number,'supplier_po_number':supplier_po_number,'vendor_po_number':''},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{
										$('#description').val('');
										$('#rate').val('');
										$('#order_qty').val('');
										

									}
									else
									{
										var data_row_material = jQuery.parseJSON( data );
										$('#description').val(data_row_material.type_of_raw_material);
										$('#rate').val(data_row_material.supplierrate);
										$('#order_qty').val(data_row_material.supplier_order_qty);
										
									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
										$('#description').val('');
										$('#rate').val('');		
										$('#order_qty').val('');							
										//$(".loader_ajax").hide();
								}
							});
							return false;

					}else{
						$('.part_number_error').html('Please Select Vendor PO Number');
					}

				}else{
					$('.part_number_error').html('Please Select Vendor PO');
				}
			}

		 });

		 $(document).on('change', '#qty_recived', function(){	
				 
				 $("#short_excess_qty").val();
			  
				 if($("#order_qty").val()){
					 var order_qty = $("#order_qty").val();
				 }else{
					 var order_qty = 0;
				 }

				 if($("#qty_recived").val()){
					 var qty_recived = $("#qty_recived").val();
				 }else{
					 var qty_recived = 0;
				 }

				 if($("#previous_short_excess_qty").val()){
					 var previous_short_excess_qty = $("#previous_short_excess_qty").val();
				 }else{
					 var previous_short_excess_qty = 0;
				 }

				 if(previous_short_excess_qty == 0){
					var calculate_qty = order_qty;
				 }else{
					var calculate_qty = previous_short_excess_qty;
				 }

				//var calculate_qty = previous_short_excess_qty;

				 var total_short_excess_qty = parseFloat(calculate_qty) -  parseFloat(qty_recived);
				 

				 $("#short_excess_qty").val(total_short_excess_qty.toFixed(2));
			
		 });

		 $(document).on('click','#savePODitem',function(e){
			e.preventDefault();
			   $(".loader_ajax").show();
			   var formData = new FormData($("#savePODitem_form")[0]);

			   var part_number =   $('#part_number').val();
			   var description =   $('#description').val();
			   var order_qty =   $('#order_qty').val();
			   var lot_no =   $('#lot_no').val();
			   var qty_recived =   $('#qty_recived').val();
			   var unit =   $('#unit').val();
			   var bill_no =   $('#bill_no').val();
			   var bill_date =   $('#bill_date').val();
               var previous_short_excess_qty = $('#previous_short_excess_qty').val();
			   var short_excess_qty =   $('#short_excess_qty').val();
			   var item_remark =   $('#item_remark').val();
	

			   var pre_debit_note_date =   $('#debit_note_date').val();
			   var pre_vendor_supplier_name =   $('#vendor_supplier_name').val();
			   var pre_vendor_name =   $('#vendor_name').val();
			   var pre_vendor_po_number =   $('#vendor_po_number').val();
			   var pre_supplier_name =   $('#supplier_name').val();
			   var pre_supplier_po_number =   $('#supplier_po_number').val();
			   var pre_po_date =   $('#po_date').val();
			   var pre_remark =   $('#remark').val();

			   var POD_details_id =   $('#POD_details_id').val();
			   
			   var poditems_id =   $('#poditems_id').val();

			   $.ajax({
				url : "<?php echo base_url();?>savepoditem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,order_qty:order_qty,lot_no:lot_no,qty_recived:qty_recived,unit:unit,bill_no:bill_no,bill_date:bill_date,short_excess_qty:short_excess_qty,item_remark:item_remark, pre_debit_note_date:pre_debit_note_date,pre_vendor_supplier_name:pre_vendor_supplier_name,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_supplier_name:pre_supplier_name,pre_supplier_po_number:pre_supplier_po_number,pre_po_date:pre_po_date,pre_remark:pre_remark,POD_details_id:POD_details_id,poditems_id:poditems_id,previous_short_excess_qty:previous_short_excess_qty},
				 method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								if(POD_details_id){
									window.location.href = "<?php echo base_url().'editpoddetails/'?>"+POD_details_id;
								}else{
									window.location.href = "<?php echo base_url().'addNewPODdetails'?>";
								}	
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			   });
			return false;
	     });

		 $(document).on('click','.deletepoddetails',function(e){
					var elemF = $(this);
					e.preventDefault();
					swal({
						title: "Are you sure?",
						text: "Delete POD Details",
						type: "warning",
						showCancelButton: true,
						closeOnClickOutside: false,
						confirmButtonClass: "btn-sm btn-danger",
						confirmButtonText: "Yes, delete it!",
						cancelButtonText: "No, cancel plz!",
						closeOnConfirm: false,
						closeOnCancel: false
					}, function(isConfirm) {
						if (isConfirm) {
									$.ajax({
										url : "<?php echo base_url();?>deletepoddetails",
										type: "POST",
										data : 'id='+elemF.attr('data-id'),
										success: function(data, textStatus, jqXHR)
										{
											const obj = JSON.parse(data);
										
											if(obj.status=='success'){
												swal({
													title: "Deleted!",
													text: "POD Details Succesfully Deleted",
													icon: "success",
													button: "Ok",
													},function(){ 
															window.location.href = "<?php echo base_url().'poddetails'?>";
												});	
											}

										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											$(".loader_ajax").hide();
										}
									})
								}
								else {
						swal("Cancelled", "POD Details deletion cancelled ", "error");
						}
					});
		 });

		 $(document).on('click','.deletePODitem',function(e){
		
			var POD_details_id = $('#POD_details_id').val();
			var elemF = $(this);
				e.preventDefault();
				swal({
					title: "Are you sure?",
					text: "Delete POD Form Item ",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deletePODitem",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "POD Item Deleted Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 

													    if(POD_details_id){
															window.location.href = "<?php echo base_url().'editpoddetails/'?>"+POD_details_id;
														}else{
															window.location.href = "<?php echo base_url().'addNewPODdetails'?>";
														}

														
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "POD Item deletion cancelled ", "error");
					}
				});
	     });

		 $(document).on('click','.editPODitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			$.ajax({
				url : "<?php echo base_url();?>geteditPODitem",
				type: "POST",
				data : 'id='+item_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 

						$('#poditems_id').val(fetchResponse.poditems_id); 
						$('#part_number').val(fetchResponse.raw_id);  
						$('#description').val(fetchResponse.description);  
						$('#order_qty').val(fetchResponse.order_qty);  
						$('#lot_no').val(fetchResponse.lot_no);  
						$('#qty_recived').val(fetchResponse.qty_recived);  
						$('#unit').val(fetchResponse.unit);  
						$('#bill_no').val(fetchResponse.bill_no);  
						$('#bill_date').val(fetchResponse.bill_date);  
						$('#previous_short_excess_qty').val(fetchResponse.previous_short_excess_qty);  
						$('#short_excess_qty').val(fetchResponse.short_excess_qty);  
						$('#item_remark').val(fetchResponse.remark);  
						
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		 });
          
		 $(document).on('change','.part_number_for_previous_short_excess',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var part_number = $('#part_number').val();
			var vendor_po_number = $('#vendor_po_number').val();
			var supplier_po_number = $('#supplier_po_number').val();
			$.ajax({
				url : "<?php echo base_url();?>getpreviousshortexcess",
				type: "POST",
				data : 'part_number='+part_number+'&vendor_po_number='+vendor_po_number+'&supplier_po_number='+supplier_po_number,
				success: function(data, textStatus, jqXHR)
				{ 
					    var fetchResponse = $.parseJSON(data);

						if(fetchResponse =='failure'){
							var short_excess_qty = 0;
						}else{
							// if(fetchResponse.short_excess_qty > 0){
                            //    var short_excess_qty = fetchResponse.short_excess_qty;
							// }else{
							//    var short_excess_qty = 0;
							// }

							var short_excess_qty = fetchResponse.short_excess_qty;
							$('#previous_short_excess_qty').val(short_excess_qty); 	

						}
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	        $(".loader_ajax").hide();
			    }
			});
			return false;
		 });

		 $(document).on('change','#vendor_name,#vendor_po_number,#supplier_name,#supplier_po_number',function(e){  

			var vendor_supplier_name = $('#vendor_supplier_name').val();

			if(vendor_supplier_name=='vendor'){

				var vendor_name = $('#vendor_name').val();
				var vendor_po_number = $('#vendor_po_number').val();
				var POD_details_id = $('#POD_details_id').val();

				if(vendor_name && vendor_po_number){

					$.ajax({
							url : "<?php echo ADMIN_PATH;?>checkvendorpoandvendornumberinpoddetails",
							type: "POST",
							data : {'vendor_name' : vendor_name,'vendor_po_number':vendor_po_number,'POD_details_id':POD_details_id},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('.vendor_po_number_error').html('');
									$('#savenewpoddetails').prop('disabled', false);
									$('#add_item_details').prop('disabled', false);

								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );

									if(data_row_material.vendor_po){
										$('.vendor_po_number_error').html('POD Details Alreday Exists For This Vendor PO');
										$('#savenewpoddetails').prop('disabled', true);
										$('#add_item_details').prop('disabled', true);
									}else{

										$('.vendor_po_number_error').html('');
										$('#add_item_details').prop('disabled', false);
										$('#savenewpoddetails').prop('disabled', false);
									}
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								    $('.vendor_po_number_error').html('');
									$('#savenewpoddetails').prop('disabled', false);
							}
						});
					return false;
				}
				    
			}

			if(vendor_supplier_name=='supplier'){

				var supplier_name = $('#supplier_name').val();
				var supplier_po_number = $('#supplier_po_number').val();
				var POD_details_id = $('#POD_details_id').val();


				if(supplier_name && supplier_po_number){

					$.ajax({
							url : "<?php echo ADMIN_PATH;?>checksupplierandvendornumberinpoddetails",
							type: "POST",
							data : {'supplier_name' : supplier_name,'supplier_po_number':supplier_po_number,'POD_details_id':POD_details_id},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('.supplier_po_number_error').html('');
									$('#savenewpoddetails').prop('disabled', false);
							
								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );

									if(data_row_material.vendor_po){
										$('.supplier_po_number_error').html('POD Details Alreday Exists For This Supplier PO');
										$('#savenewpoddetails').prop('disabled', true);
									}else{

										$('.supplier_po_number_error').html('');
										$('#savenewpoddetails').prop('disabled', false);
									}
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								    $('.supplier_po_number_error').html('');
									$('#savenewpoddetails').prop('disabled', false);
							}
						});
					return false;
				}

            }

		 });
    </script>
<?php } ?>


<?php if($pageTitle=='Qulity Record' || $pageTitle=='Add New Qulity Record Form' || $pageTitle=='Edit Qulity Record Form' ){ ?>
	<script type="text/javascript">
         $(document).ready(function() {
		    var dt = $('#view_qulity_record').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "15%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "15%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					 { "width": "8%", "targets": 6 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Qulity Records Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchqulityrecords",
                    type: "post",
	            },
	        });
	     });

		 $(document).ready(function() {

			var vendor_po_number = $('#vendor_po_number').val();
			$("#stockform_item_list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>vendorponumberforviewitemstockform_display",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#stockform_item_list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#stockform_item_list').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		 });

		 $(document).ready(function() {
			// e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;

		 });

		 $(document).on('change','#vendor_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_name = $('#vendor_name').val();
		    $('.vendor_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorPoconfirmationvendorlist",
				type: "POST",
				data : {'vendor_name' : vendor_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#vendor_po_number').html('<option value="">Select Vendor PO Number</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#vendor_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		 });

		 $(document).ready(function() {

			var vendor_po_number = $('#vendor_po_number').val();
			        $.ajax({
							url : "<?php echo ADMIN_PATH;?>getbuyerpodetailsforvendorbillofmaterial",
							type: "POST",
							data : {'vendor_po_number' : vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#buyer_name').html('<option value="">Select Buyer Name</option>');
								}
								else
								{
									$('#buyer_name').html(data);
					             	$(".autobuyerpo").html('');		

									$.ajax({
										url : "<?php echo ADMIN_PATH;?>getBuyerDetailsByvendorpoautofill",
										type: "POST",
										data : {'vendor_po_number' : vendor_po_number},
										success: function(data, textStatus, jqXHR)
										{
											$(".loader_ajax").hide();
											if(data == "failure")
											{
												$('.autobuyerpo').html('<option value="">Select Buyer PO</option>');
											}
											else
											{
												$('.autobuyerpo').html(data);

												var autobuyerpo = $(".autobuyerpo").val();

												$("#export-list").html('');
												$.ajax({
													url : "<?php echo ADMIN_PATH;?>getexportdetailsforqulityrecord",
													type: "POST",
													data : {'buyer_po' : autobuyerpo},
													success: function(data, textStatus, jqXHR)
													{
														$(".loader_ajax").hide();
														if(data == "failure")
														{
															//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
														}
														else
														{
															//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
															//$('#buyer_po_number').html(data);
															$("#export-list").html(data);

														}
													},
													error: function (jqXHR, textStatus, errorThrown)
													{
														$('#export-list').html();
														//$(".loader_ajax").hide();
													}
												});



											}
										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											$('#buyer_name').html();
										}
									});

										
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
									$('#buyer_name').html('');				
							}
						});
			    return false;

		 });


		 $(document).on('change','#vendor_po_number',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			        var vendor_po_number = $('#vendor_po_number').val();
			        $.ajax({
							url : "<?php echo ADMIN_PATH;?>getbuyerpodetailsforvendorbillofmaterial",
							type: "POST",
							data : {'vendor_po_number' : vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#buyer_name').html('<option value="">Select Buyer Name</option>');
								}
								else
								{
									$('#buyer_name').html(data);
					             	$(".autobuyerpo").html('');		

									$.ajax({
										url : "<?php echo ADMIN_PATH;?>getBuyerDetailsByvendorpoautofill",
										type: "POST",
										data : {'vendor_po_number' : vendor_po_number},
										success: function(data, textStatus, jqXHR)
										{
											$(".loader_ajax").hide();
											if(data == "failure")
											{
												$('.autobuyerpo').html('<option value="">Select Buyer PO</option>');
											}
											else
											{
												$('.autobuyerpo').html(data);

												var autobuyerpo = $(".autobuyerpo").val();

												$("#export-list").html('');
												$.ajax({
													url : "<?php echo ADMIN_PATH;?>getexportdetailsforqulityrecord",
													type: "POST",
													data : {'buyer_po' : autobuyerpo},
													success: function(data, textStatus, jqXHR)
													{
														$(".loader_ajax").hide();
														if(data == "failure")
														{
															//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
														}
														else
														{
															//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
															//$('#buyer_po_number').html(data);
															$("#export-list").html(data);

														}
													},
													error: function (jqXHR, textStatus, errorThrown)
													{
														$('#export-list').html();
														//$(".loader_ajax").hide();
													}
												});



											}
										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											$('#buyer_name').html();
										}
									});

										
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
									$('#buyer_name').html('');				
							}
						});
			    return false;
	                   
		 });

		 $(document).on('change','.vendor_po_get_data',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_po_id = $('.vendor_po_get_data').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>get_vendorpodata",
				type: "POST",
				data : {'vendor_po_id' : vendor_po_id},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#vedor_po_date').val('');
					}
					else
					{
						var get_vendorpodata = jQuery.parseJSON( data );
						$('#vedor_po_date').val(get_vendorpodata.date);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vedor_po_date').val('');
				}
			});
			return false;
		 });

		 $(document).on('change','.vendor_po_number_itam',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;
		 });

		 $(document).on('change','#part_number',function(e){  
			e.preventDefault();
			
			//$(".loader_ajax").show();
			var part_number = $('#part_number').val();
			
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getfinishedgoodsPartnumberByid",
				type: "POST",
				data : {'part_number' : part_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#description').value('');
					}
					else
					{
						var data_row_material = jQuery.parseJSON( data );

						$('#description').val(data_row_material.name);
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#description').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		 });

		 $(document).on('click','#addnewquality',function(e){

			e.preventDefault();
			$(".loader_ajax").show();


			var quality_record_id =$('#quality_record_id').val();

			var formData = new FormData($("#addnewqualityform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addNewqualityrecord",
				type: "POST",
				data : formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
					{
						$.each(fetchResponse.error, function (i, v)
						{
							$('.'+i+'_error').html(v);
						});
						$(".loader_ajax").hide();
					}
					else if(fetchResponse.status == 'success')
					{
						swal({
							title: "Success",
							text: "Qulity Records Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								// if(quality_record_id){
								// 	window.location.href = "<?php echo base_url().'editqulityrecordform/'?>"+quality_record_id;
								// }else{
									window.location.href = "<?php echo base_url().'qualityrecord'?>";
								// }
								
						});		
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$(".loader_ajax").hide();
				}
			});
			return false;
		 });

		 $(document).on('click','.closequlityrecordmodel', function(){
			location.reload();
         });

		 $(document).on('click','#savequlityrecorditem',function(e){
			e.preventDefault();
			   $(".loader_ajax").show();
			   var formData = new FormData($("#savequlityrecord_form")[0]);

			   var part_number =   $('#part_number').val();
			   var description =   $('#description').val();
			   var inspection_report_no =   $('#inspection_report_no').val();
			   var inspection_report_date =   $('#inspection_report_date').val();
			   var lot_qty =   $('#lot_qty').val();
			   var inspected_by =   $('#inspected_by').val();
			   var item_remark =   $('#item_remark').val();

			   var pre_QR_details_date =   $('#pre_QR_details_date').val();
			   var pre_vendor_name =   $('#vendor_name').val();
			   var pre_vendor_po_number =   $('#vendor_po_number').val();
			   var pre_vedor_po_date =   $('#vedor_po_date').val();
			   var pre_buyer_name =   $('#buyer_name').val();
			   var pre_buyer_po_number =   $('#buyer_po_number').val();
			   var pre_remark =   $('#remark').val();

			   var quality_record_item_id =   $('#quality_record_item_id').val();
			   var quality_record_id =   $('#quality_record_id').val();

			   $.ajax({
				url : "<?php echo base_url();?>savequlityrecorditem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,inspection_report_no:inspection_report_no,inspection_report_date:inspection_report_date,lot_qty:lot_qty,inspected_by:inspected_by,item_remark:item_remark,pre_QR_details_date:pre_QR_details_date,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_vedor_po_date:pre_vedor_po_date,pre_buyer_name:pre_buyer_name,pre_buyer_po_number:pre_buyer_po_number,pre_remark:pre_remark,quality_record_item_id:quality_record_item_id,quality_record_id:quality_record_id},
				 method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								if(quality_record_id){

									window.location.href = "<?php echo base_url().'editqulityrecordform/'?>"+quality_record_id;
								}else{
									window.location.href = "<?php echo base_url().'addNewqualityrecord'?>";
								}

							
								
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			   });
			return false;
	     });

		 $(document).on('change','.vendor_po_number_for_view_item_stock_form',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();
			$("#stockform_item_list").html('');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>vendorponumberforviewitemstockform_display",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						//$('#buyer_po_number').html(data);
						$("#stockform_item_list").html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#stockform_item_list').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		 });

		 $(document).on('click','.deletequlityrecords',function(e){
					var elemF = $(this);
					e.preventDefault();
					swal({
						title: "Are you sure?",
						text: "Delete Quality Records",
						type: "warning",
						showCancelButton: true,
						closeOnClickOutside: false,
						confirmButtonClass: "btn-sm btn-danger",
						confirmButtonText: "Yes, delete it!",
						cancelButtonText: "No, cancel plz!",
						closeOnConfirm: false,
						closeOnCancel: false
					}, function(isConfirm) {
						if (isConfirm) {
									$.ajax({
										url : "<?php echo base_url();?>deletequlityrecords",
										type: "POST",
										data : 'id='+elemF.attr('data-id'),
										success: function(data, textStatus, jqXHR)
										{
											const obj = JSON.parse(data);
										
											if(obj.status=='success'){
												swal({
													title: "Deleted!",
													text: "Quality Succesfully Deleted",
													icon: "success",
													button: "Ok",
													},function(){ 
															window.location.href = "<?php echo base_url().'qualityrecord'?>";
												});	
											}

										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											$(".loader_ajax").hide();
										}
									})
								}
								else {
						swal("Cancelled", "Quality deletion cancelled ", "error");
						}
					});
		 });


		 $(document).on('click','.deletequalityrecordsitem',function(e){
					var elemF = $(this);
					e.preventDefault();
					swal({
						title: "Are you sure?",
						text: "Delete Quality Records Item",
						type: "warning",
						showCancelButton: true,
						closeOnClickOutside: false,
						confirmButtonClass: "btn-sm btn-danger",
						confirmButtonText: "Yes, delete it!",
						cancelButtonText: "No, cancel plz!",
						closeOnConfirm: false,
						closeOnCancel: false
					}, function(isConfirm) {
						if (isConfirm) {
									$.ajax({
										url : "<?php echo base_url();?>deletequalityrecordsitem",
										type: "POST",
										data : 'id='+elemF.attr('data-id'),
										success: function(data, textStatus, jqXHR)
										{
											const obj = JSON.parse(data);
										
											if(obj.status=='success'){
												swal({
													title: "Deleted!",
													text: "Delete Quality Records Item",
													icon: "success",
													button: "Ok",
													},function(){ 
															window.location.href = "<?php echo base_url().'addNewqualityrecord'?>";
												});	
											}

										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											$(".loader_ajax").hide();
										}
									})
								}
								else {
						swal("Cancelled", "Quality Items deletion cancelled ", "error");
						}
					});
		 });


		 $(document).on('click','.editqualityrecordsitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			$.ajax({
				url : "<?php echo base_url();?>geteditqualityrecordsitem",
				type: "POST",
				data : 'id='+item_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 
						$('#quality_record_item_id').val(fetchResponse.quality_record_item_id); 
						$('#part_number').val(fetchResponse.part_number_id);  
						$('#description').val(fetchResponse.description); 
						$('#inspection_report_no').val(fetchResponse.inspection_report_no); 
						$('#inspection_report_date').val(fetchResponse.inspection_report_date); 
						$('#lot_qty').val(fetchResponse.lot_qty); 
						$('#inspected_by').val(fetchResponse.inspected_by); 
						$('#item_remark').val(fetchResponse.remark); 
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	     });

    </script>
<?php } ?>

<?php if($pageTitle=='Add New Stock Form' || $pageTitle=='Stock Form' || $pageTitle=='Edit Stock Form'){ ?>
	<script type="text/javascript">

        $(document).ready(function() {
		    var dt = $('#view_stock_form_record').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "8%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "8%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					 { "width": "8%", "targets": 6 },
					 { "width": "8%", "targets": 7 },
					 { "width": "8%", "targets": 8 },
					 { "width": "12%", "targets":9 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Stock Form Records Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchstockformrecords",
                    type: "post",
	            },
	        });
	    });

		$(document).ready(function() {
			//e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;

		});


		// $(document).ready(function() {
		// 	var vendor_id = $('#vendor_name').val();
		// 	var vendor_po_number = $('#vendor_po_number').val();
		// 	var part_number = $('.part_number_for_incoming_details').val();

		// 	$.ajax({
		// 		url : "<?php echo ADMIN_PATH;?>getincominglotnumberbyvendor",
		// 		type: "POST",
		// 		data : {'vendor_id' : vendor_id,'part_number':part_number,'vendor_po_number':vendor_po_number},
		// 		success: function(data, textStatus, jqXHR)
		// 		{
		// 			$(".loader_ajax").hide();
		// 			if(data == "failure")
		// 			{
		// 				$('#lot_number').html('<option value="">Select Lot Number</option>');
		// 			}
		// 			else
		// 			{
		// 				$('#lot_number').html(data);

		// 			}
		// 		},
		// 		error: function (jqXHR, textStatus, errorThrown)
		// 		{
		// 			$('#lot_number').html();
		// 			//$(".loader_ajax").hide();
		// 		}
		// 	});
		// 	return false;


		// });


		$(document).on('change','#vendor_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_name = $('#vendor_name').val();
		    $('.vendor_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorPoconfirmationvendorlist",
				type: "POST",
				data : {'vendor_name' : vendor_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#vendor_po_number').html('<option value="">Select Vendor PO Number</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#vendor_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','.vendor_po_for_buyer_details_',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			        var vendor_po_number = $('#vendor_po_number').val();
			
			        $.ajax({
							url : "<?php echo ADMIN_PATH;?>getbuyerpodetailsforvendorbillofmaterial",
							type: "POST",
							data : {'vendor_po_number' : vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#buyer_name').html('');
								}
								else
								{
									$('#buyer_name').html(data);
									$('#buyer_po_id').val('');
					             	$("#buyer_po_number").val('');	
									$('#buyer_po_date').val('');
									$('#buyer_delivery_date').val('');	

									$.ajax({
										url : "<?php echo ADMIN_PATH;?>getbuyerpodetailsforvendorstockform",
										type: "POST",
										data : {'vendor_po_number' : vendor_po_number},
										success: function(data, textStatus, jqXHR)
										{
											var get_buyerdata = jQuery.parseJSON( data );

											$(".loader_ajax").hide();
											if(data == "failure")
											{
												$('#buyer_po_id').val('');
												$('#buyer_po_number').val('');
												$('#buyer_po_date').val('');
												$('#buyer_delivery_date').val('');	
											}
											else
											{
												$('#buyer_po_id').val(get_buyerdata.buyer_po_id);
												$('#buyer_po_number').val(get_buyerdata.sales_order_number);
												$('#buyer_po_date').val(get_buyerdata.date);
												$('#buyer_delivery_date').val(get_buyerdata.delivery_date);	
											}
										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											$('#buyer_name').html();
											
										}
									});

										
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								   
									$('#buyer_name').html('');				
							}
						});
			    return false;
	                   
		});

		$(document).on('change','.vendor_name_for_buyer_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_name_for_buyer_name = $('.vendor_name_for_buyer_name').val();

			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerNamebySupplierid",
				type: "POST",
				data : {'vendor_name' : vendor_name_for_buyer_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#buyer_name').html('<option value="">Select Buyer Name</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#buyer_name').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#buyer_name').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','.vendor_po_get_data',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_po_id = $('.vendor_po_get_data').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>get_vendorpodata",
				type: "POST",
				data : {'vendor_po_id' : vendor_po_id},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#vendor_po_date').val('');
					}
					else
					{
						var get_vendorpodata = jQuery.parseJSON( data );
						$('#vendor_po_date').val(get_vendorpodata.date);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_po_date').val('');
				}
			});
			return false;
		});

		$(document).on('change','.vendor_po_for_item',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;
		});

		$(document).on('change','#part_number',function(e){  
				e.preventDefault();
			
				//$(".loader_ajax").show();
				var part_number = $('#part_number').val();
				var vendor_po_number = $('#vendor_po_number').val();
				var vendor_name = $('#vendor_name').val();

				var buyer_po_id = $('#buyer_po_id').val();

				if(vendor_name){
					if(vendor_po_number){
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>getItemdetailsdependonvendorpoforstockform",
								type: "POST",
								data : {'part_number' : part_number,'vendor_po_number':vendor_po_number,'vendor_name':vendor_name,'buyer_po_id':buyer_po_id},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{
										$('#description').val('');
										$('#fg_order_qty').val('');
										$('#buyre_order_qty').val('');
										$('#invoice_qty_in_pcs').val('');
										//$('#invoice_qty_in_kgs').val('');
										$('#net_weight').val('');
										$('#privious_balenace').val('');
									}
									else
									{
										var data_finish_good = jQuery.parseJSON( data );
										$('#description').val(data_finish_good.name);
										$('#fg_order_qty').val(data_finish_good.vendor_order_qty);
										$('#buyre_order_qty').val(data_finish_good.buyer_order_qty);
										//$('#invoice_qty_in_pcs').val(data_finish_good.vendor_qtyvendor_qty);
										$('#net_weight').val(data_finish_good.net_weight);
										if(data_finish_good.current_stock){
                                           var previous_bal =data_finish_good.current_stock;
										}else{
											var previous_bal =0;
										}
										$('#privious_balenace').val(previous_bal);
										
									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
										$('#description').val('');
										$('#fg_order_qty').val('');
										$('#buyre_order_qty').val('');
										$('#invoice_qty_in_pcs').val('');
										//$('#invoice_qty_in_kgs').val('');
										$('#net_weight').val('');
										$('#privious_balenace').val('');
								}
							});
							return false;

					}else{
						$('.part_number_error').html('Please Select Vendor PO Number');
					}

				}else{

					$('.part_number_error').html('Please Select Vendor PO');
				}
				
		});

		$(document).on('click','#addnewstockform',function(e){

				e.preventDefault();
				$(".loader_ajax").show();
				var formData = new FormData($("#addstockform")[0]);
				$.ajax({
					url : "<?php echo base_url();?>addNewstockform",
					type: "POST",
					data : formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data, textStatus, jqXHR)
					{
						var fetchResponse = $.parseJSON(data);
						if(fetchResponse.status == "failure")
						{
							$.each(fetchResponse.error, function (i, v)
							{
								$('.'+i+'_error').html(v);
							});
							$(".loader_ajax").hide();
						}
						else if(fetchResponse.status == 'success')
						{
							swal({
								title: "Success",
								text: "Stock Form Details Successfully Added!",
								icon: "success",
								button: "Ok",
								},function(){ 

									window.location.href = "<?php echo base_url().'stockform'?>";
							});		
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$(".loader_ajax").hide();
					}
				});
				return false;
		});

		$(document).on('click','#saveStockform_item',function(e){
			e.preventDefault();
			   $(".loader_ajax").show();

			   var stock_id =   $('#stock_id_main').val();

			   var part_number =   $('#part_number').val();
			   var buyre_order_qty =   $('#buyre_order_qty').val();
			   var fg_order_qty =   $('#fg_order_qty').val();
			   var invoice_number =   $('#invoice_number').val();
			   var invoice_date =   $('#invoice_date').val();
			   var invoice_qty_in_pcs =   $('#invoice_qty_in_pcs').val();
			   var invoice_qty_in_kgs =   $('#invoice_qty_in_kgs').val();
			   var lot_number =   $('#lot_number').val();
			   var actaul_recived_qty_in_pics =   $('#actaul_recived_qty_in_pics').val();
			   var actaul_recived_qty_in_kgs =   $('#actaul_recived_qty_in_kgs').val();
			   var privious_balenace =   $('#privious_balenace').val();
			   var itemremark =   $('#itemremark').val();

			   var pre_stock_date =   $('#stock_date').val();
			   var pre_vendor_name =   $('#vendor_name').val();
			   var pre_vendor_po_number =   $('#vendor_po_number').val();
			   var pre_vendor_po_date =   $('#vendor_po_date').val();

			   var pre_buyer_name =   $('#buyer_name').val();
			   var pre_buyer_po_id =   $('#buyer_po_id').val();
			   var pre_buyer_po_date =   $('#buyer_po_date').val();
			   var pre_buyer_delivery_date =   $('#buyer_delivery_date').val();
			   var pre_remark =   $('#remark').val();

			   var stock_form_item_id =   $('#stock_form_item_id').val();

			
			   $.ajax({
				url : "<?php echo base_url();?>saveStockformitem",
				type: "POST",
				 //data : formData,
				 data :{ part_number :part_number,buyre_order_qty:buyre_order_qty,fg_order_qty:fg_order_qty,invoice_number:invoice_number,invoice_date :invoice_date,invoice_qty_in_pcs:invoice_qty_in_pcs,invoice_qty_in_kgs :invoice_qty_in_kgs, lot_number :lot_number,actaul_recived_qty_in_pics :actaul_recived_qty_in_pics,actaul_recived_qty_in_kgs : actaul_recived_qty_in_kgs,privious_balenace :privious_balenace,itemremark :itemremark,pre_stock_date:pre_stock_date,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_vendor_po_date:pre_vendor_po_date,pre_buyer_name:pre_buyer_name,pre_buyer_po_id:pre_buyer_po_id,pre_buyer_po_date:pre_buyer_po_date,pre_buyer_delivery_date:pre_buyer_delivery_date,pre_remark:pre_remark,stock_id:stock_id,stock_form_item_id:stock_form_item_id},
				 method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								if(stock_id){
									window.location.href = "<?php echo base_url().'editstcokformdetails/'?>"+stock_id;

								}else{
									window.location.href = "<?php echo base_url().'addNewstockform'?>";
								}
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			   });
			return false;
	    });

		$(document).on('change', '#actaul_recived_qty_in_pics', function(){	
				
			    $("#actaul_recived_qty_in_kgs").val();

				 if($("#actaul_recived_qty_in_pics").val()){
					 var actaul_recived_qty_in_pics = $("#actaul_recived_qty_in_pics").val();
				 }else{
					 var actaul_recived_qty_in_pics = 0;
				 }

				 if($("#net_weight").val()){
					 var net_weight = $("#net_weight").val();
				 }else{
					 var net_weight = 0;
				 }

				 
				 var total_one_group = parseFloat(net_weight) *  parseFloat(actaul_recived_qty_in_pics);

				 $("#actaul_recived_qty_in_kgs").val(total_one_group.toFixed(2));
			
		});

		$(document).on('click','.deleteStockformitem',function(e){

			
		 var stock_id =   $('#stock_id_main').val();
		
		 var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Stock Form Item ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteStockformitem",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Stock Form Item Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 

												 if(stock_id){
													window.location.href = "<?php echo base_url().'editstcokformdetails/'?>"+stock_id;
												 }else{
													window.location.href = "<?php echo base_url().'addNewstockform'?>";
												 }
													
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Stock Form Item deletion cancelled ", "error");
				}
			});
	    });

		$(document).on('change','.part_number_for_incoming_details',function(e){  
			e.preventDefault();
			$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_id = $('#vendor_name').val();
			var vendor_po_number = $('#vendor_po_number').val();
			var part_number = $('.part_number_for_incoming_details').val();

			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getincominglotnumberbyvendor",
				type: "POST",
				data : {'vendor_id' : vendor_id,'part_number':part_number,'vendor_po_number':vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#lot_number').html('<option value="">Select Lot Number</option>');
					}
					else
					{
						$('#lot_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#lot_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','.get_invoice_qty_bylot_number',function(e){  
				e.preventDefault();
				var lot_id = $('.get_invoice_qty_bylot_number').val();

				if(vendor_name){
					if(vendor_po_number){
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>getinvoiceqtybyLotnumber",
								type: "POST",
								data : {'lot_id' : lot_id},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{

										$('#invoice_number').val('');
										$('#invoice_date').val('');

										$('#invoice_qty_in_pcs').val('');
										$('#invoice_qty_in_kgs').val('');
									}
									else
									{
										var invoice_qty_in_pcs_data = jQuery.parseJSON( data );
										$('#invoice_qty_in_pcs').val(invoice_qty_in_pcs_data.invoice_qty);

										var net_weight = $('#net_weight').val();

										var invoice_qty_in_kgs =  parseFloat(invoice_qty_in_pcs_data.invoice_qty) * parseFloat(net_weight);
										$('#invoice_qty_in_kgs').val(invoice_qty_in_kgs);


										$('#invoice_number').val(invoice_qty_in_pcs_data.invoice_no);
										$('#invoice_date').val(invoice_qty_in_pcs_data.invoice_date);


										
									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									    $('#invoice_number').val('');
										$('#invoice_date').val('');
										$('#invoice_qty_in_pcs').val('');
										$('#invoice_qty_in_kgs').val('');
								}
							});
							return false;

					}else{
						$('.get_invoice_qty_bylot_number').html('Please Select Lot Number');
					}

				}else{

					$('.get_invoice_qty_bylot_number').html('Please Select Lot Number');
				}
				
		});

		$(document).on('change', '#invoice_qty_in_pcs', function(){	
				
			    $("#invoice_qty_in_pcs").val();

				 if($("#invoice_qty_in_pcs").val()){
					 var invoice_qty_in_pcs = $("#invoice_qty_in_pcs").val();
				 }else{
					 var invoice_qty_in_pcs = 0;
				 }

				 if($("#net_weight").val()){
					 var net_weight = $("#net_weight").val();
				 }else{
					 var net_weight = 0;
				 }

				 var onchange_value = parseFloat(net_weight) *  parseFloat(invoice_qty_in_pcs);

				 $("#invoice_qty_in_kgs").val(onchange_value);
			
		});

		$(document).on('click','.deletestockform',function(e){
		
		 var elemF = $(this);
		   e.preventDefault();
		   swal({
			   title: "Are you sure?",
			   text: "Delete Stock Form ",
			   type: "warning",
			   showCancelButton: true,
			   closeOnClickOutside: false,
			   confirmButtonClass: "btn-sm btn-danger",
			   confirmButtonText: "Yes, delete it!",
			   cancelButtonText: "No, cancel plz!",
			   closeOnConfirm: false,
			   closeOnCancel: false
		   }, function(isConfirm) {
			   if (isConfirm) {
						   $.ajax({
							   url : "<?php echo base_url();?>deletestockform",
							   type: "POST",
							   data : 'id='+elemF.attr('data-id'),
							   success: function(data, textStatus, jqXHR)
							   {
								   const obj = JSON.parse(data);
							   
								   if(obj.status=='success'){
									   swal({
										   title: "Deleted!",
										   text: "Stock Form Deleted Succesfully",
										   icon: "success",
										   button: "Ok",
										   },function(){ 
												   window.location.href = "<?php echo base_url().'stockform'?>";
									   });	
								   }

							   },
							   error: function (jqXHR, textStatus, errorThrown)
							   {
								   $(".loader_ajax").hide();
							   }
						   })
					   }
					   else {
			   swal("Cancelled", "Stock Form deletion cancelled ", "error");
			   }
		   });
	    });

		$(document).on('click','.editStockformitem',function(e){  
			e.preventDefault();

			var vendor_id = $('#vendor_name').val();
			var vendor_po_number = $('#vendor_po_number').val();
			var elemFrx = $(this);
			var part_number = elemFrx.attr('data_id_part_number');


			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getincominglotnumberbyvendor",
				type: "POST",
				data : {'vendor_id' : vendor_id,'part_number':part_number,'vendor_po_number':vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#lot_number').html('<option value="">Select Lot Number</option>');
					}
					else
					{
						$('#lot_number').html(data);


						
							$.ajax({
								url : "<?php echo base_url();?>geteditStockformitem",
								type: "POST",
								data : 'id='+item_id,
								success: function(data, textStatus, jqXHR)
								{
										var fetchResponse = $.parseJSON(data);
										$('#addNewModal').modal('show'); 
										$('#stock_form_item_id').val(fetchResponse.item_id); 
										$('#part_number').val(fetchResponse.fin_id);  
										$('#description').val(fetchResponse.description); 
										$('#buyre_order_qty').val(fetchResponse.buyer_order_qty); 
										$('#fg_order_qty').val(fetchResponse.f_g_order_qty); 
										$('#lot_number').val(fetchResponse.lot_number); 
										$('#invoice_number').val(fetchResponse.invoice_number); 
										$('#invoice_date').val(fetchResponse.invoice_date); 
										$('#invoice_qty_in_pcs').val(fetchResponse.invoice_qty_In_pcs); 
										$('#invoice_qty_in_kgs').val(fetchResponse.invoice_qty_In_kgs); 
										$('#actaul_recived_qty_in_pics').val(fetchResponse.actual_received_qty_in_pcs); 
										$('#actaul_recived_qty_in_kgs').val(fetchResponse.actual_received_qty_in_kgs); 

										$('#net_weight').val(fetchResponse.net_weight); 
										$('#privious_balenace').val(fetchResponse.previous_balence); 
										$('#itemremark').val(fetchResponse.item_remark); 


								},
								error: function (jqXHR, textStatus, errorThrown)
								{
								$(".loader_ajax").hide();
								}
							});
							 return false;


					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#lot_number').html();
					//$(".loader_ajax").hide();
				}
			});
            return false;
	    });

		$(document).on('click','.closestockform', function(){
			location.reload();
        });

    </script>
<?php } ?>


<?php if($pageTitle=='Search Stock'){ ?>
	<script type="text/javascript">    

		var vendor_po_id =  $('#vendor_po_id').val();
		var vendor_po_item_id =  $('#vendor_po_item_id').val();
		var sock_id =  $('#stock_id').val();
		var part_number_id =  $('#part_number_id').val();
		var buyer_po_number_id =  $('#buyer_po_number_id').val();
		var finishgood_id =  $('#finishgood_id').val();


        $(document).ready(function() {
		    var dt = $('#view_stock_search_record').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "15%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					 { "width": "10%", "targets": 6 },
					 { "width": "5%", "targets": 7 },
					 { "width": "10%", "targets": 8 },
					 { "width": "15%", "targets": 9 },
					 { "width": "15%", "targets": 10 },
					 { "width": "15%", "targets": 11 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Stock Records Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>admin/fetchsearchstockrecords/"+sock_id+"/"+part_number_id,
                    type: "post",
	            },
	        });
	    });

		$(document).ready(function() {
	        $('#invoice_qty_in_pcs').val('');
			$('#invoice_qty_in_kgs').val('');
			$('#actual_received_qty_in_pcs').val('');
			$('#actual_received_qty_in_kgs').val('');

			$.ajax({
				url : "<?php echo ADMIN_PATH;?>admin/getalltotalcalculationstockform/"+sock_id+"/"+part_number_id,
				type: "POST",
				data : {'vendor_name' : ''},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#invoice_qty_in_pcs').val('');
						$('#invoice_qty_in_kgs').val('');
						$('#actual_received_qty_in_pcs').val('');
						$('#actual_received_qty_in_kgs').val('');
					}
					else
					{

						var invoice_qty_in_pcs_data = jQuery.parseJSON( data );
						$('#invoice_qty_in_pcs').val(parseFloat(invoice_qty_in_pcs_data.invoice_qty_In_pcs).toFixed(2));
						$('#invoice_qty_in_kgs').val(parseFloat(invoice_qty_in_pcs_data.invoice_qty_In_kgs).toFixed(3));
						$('#actual_received_qty_in_pcs').val(parseFloat(invoice_qty_in_pcs_data.actual_received_qty_in_pcss).toFixed(2));
						$('#actual_received_qty_in_kgs').val(parseFloat(invoice_qty_in_pcs_data.actual_received_qty_in_kgs).toFixed(3));


						/*================================================================================= */
						$('#total_rejected_qty_in_pcs').val('');
						$('#total_rejected_qty_in_kgs').val('');

						$.ajax({
							url : "<?php echo ADMIN_PATH;?>admin/getallcalculationrejecteditems/"+vendor_po_item_id+"/"+vendor_po_id+"/"+finishgood_id,
							type: "POST",
							data : {'vendor_name' : '','vendor_item_id':''},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#total_rejected_qty_in_pcs').val('');
									$('#total_rejected_qty_in_kgs').val('');
								}
								else
								{
									var rejecteditems_data = jQuery.parseJSON( data );
									
									var total_rejected_qty_kgs = parseFloat(rejecteditems_data.qty_In_kgs) * parseFloat(rejecteditems_data.fg_net_weight);

										if(rejecteditems_data.qty_In_kgs_rejection && rejecteditems_data.total_rejected_qty_in_pcs){
											var total_rejected_qty_kgs = parseFloat(rejecteditems_data.qty_In_kgs_rejection);
											$('#total_rejected_qty_in_pcs').val(parseFloat(rejecteditems_data.total_rejected_qty_in_pcs).toFixed(2));
											$('#total_rejected_qty_in_kgs').val(parseFloat(total_rejected_qty_kgs).toFixed(3));
										}else{
											var total_rejected_qty_kgs = parseFloat(rejecteditems_data.qty_In_kgs_rejection);
											$('#total_rejected_qty_in_pcs').val(0);
											$('#total_rejected_qty_in_kgs').val(0);
										}
										

							         /*================================================================================= */
                                     

											$('#total_exp_qty_in_pcs').val('');
											$('#total_exp_qty_in_kgs').val('');

											$.ajax({
												url : "<?php echo ADMIN_PATH;?>admin/getallcalculationexportitems/"+buyer_po_number_id+"/"+part_number_id,
												type: "POST",
												data : {'vendor_name' : ''},
												success: function(data, textStatus, jqXHR)
												{
													$(".loader_ajax").hide();
													if(data == "failure")
													{
														$('#total_exp_qty_in_pcs').val('');
														$('#total_exp_qty_in_kgs').val('');
													}
													else
													{
														var exportitems_data = jQuery.parseJSON( data );

														if(exportitems_data.fg_net_weight && exportitems_data.total_exp_qty_in_pcs){
															var total_export_qty_kgs = parseFloat(exportitems_data.total_exp_qty_in_pcs) * parseFloat(exportitems_data.fg_net_weight);
															$('#total_exp_qty_in_pcs').val(parseFloat(exportitems_data.total_exp_qty_in_pcs).toFixed(2));
															$('#total_exp_qty_in_kgs').val(parseFloat(total_export_qty_kgs).toFixed(3));
														}else{
															// var total_export_qty_kgs = parseFloat(exportitems_data.total_exp_qty_in_pcs) * parseFloat(exportitems_data.fg_net_weight);

															$('#total_exp_qty_in_pcs').val(0);
															$('#total_exp_qty_in_kgs').val(0);
														}

                                                        /*================================================================================= */
                                                          

																	$('#balence_qty_in_pcs').val('');
																	$('#balence_qty_in_kgs').val('');
																	$.ajax({
																		url : "<?php echo ADMIN_PATH;?>admin/getallbalencecalculationexportitems/"+sock_id+"/"+part_number_id,
																		type: "POST",
																		// data : {'vendor_name' : ''},
																		success: function(data, textStatus, jqXHR)
																		{
																			$(".loader_ajax").hide();
																			if(data == "failure")
																			{
																				$('#balence_qty_in_pcs').val('');
																				$('#balence_qty_in_kgs').val('');
																			}
																			else
																			{
																				var balenceitems_data = jQuery.parseJSON( data );

										
																				    // console.log(balence_qty_in_pcs);
																					// console.log('Hemant');

																					$('#balence_qty_in_pcs').val(parseFloat(balenceitems_data.balence_qty_in_pcs).toFixed(2));
																					$('#balence_qty_in_kgs').val(parseFloat(balenceitems_data.balence_qty_in_kgs).toFixed(3));


																					$('#ready_for_exp_pcs').val('');

																					if(rejecteditems_data.total_rejected_qty_in_pcs==null){
                                                                                      var total_rejected_qty_in_pcs =0;

																					}else{
																						var total_rejected_qty_in_pcs =rejecteditems_data.total_rejected_qty_in_pcs;
																					}


																					var precalculation_ready_for_export =  parseFloat(invoice_qty_in_pcs_data.actual_received_qty_in_pcss) - parseFloat(total_rejected_qty_in_pcs);
																					var ready_for_exp_pcs = parseFloat(balenceitems_data.balence_qty_in_pcs) + parseFloat(precalculation_ready_for_export);
																					if(isNaN(ready_for_exp_pcs)){
																					    $('#ready_for_exp_pcs').val(0);
																					}else{
																						$('#ready_for_exp_pcs').val(ready_for_exp_pcs);
																					}


																					$('#ready_for_exp_kgs').val('');
																					var ready_for_exp_kgs = parseFloat($('#ready_for_exp_pcs').val()) * parseFloat(balenceitems_data.fg_net_weight);
																					if(isNaN(ready_for_exp_kgs)){
																				    	$('#ready_for_exp_kgs').val(0);
																					}else{
																						$('#ready_for_exp_kgs').val(ready_for_exp_kgs.toFixed(3));
																					}

																					var previous_stock_bal = $('#previous_stock_bal').val();


																					$('#balence_qty_in_pcs').val('');
																					// var precalculation_ready_for_export_pcs =  (parseFloat(previous_stock_bal) + parseFloat(ready_for_exp_pcs)) - parseFloat(exportitems_data.total_exp_qty_in_pcs);
																					
																					var precalculation_ready_for_export_pcs =  (parseFloat(ready_for_exp_pcs)) - parseFloat(exportitems_data.total_exp_qty_in_pcs);


																					if(isNaN(precalculation_ready_for_export_pcs)){
																					    $('#balence_qty_in_pcs').val(0);
																					}else{
																						$('#balence_qty_in_pcs').val(precalculation_ready_for_export_pcs);
																					}


																					var balence_qty_in_pcs_calculation = $('#balence_qty_in_pcs').val();


																					$('#balence_qty_in_kgs').val('');
																					// var precalculation_ready_for_export_kgs = (parseFloat(previous_stock_bal) + parseFloat(ready_for_exp_kgs)) - parseFloat(total_export_qty_kgs);

																					 var precalculation_ready_for_export_kgs = parseFloat(balence_qty_in_pcs_calculation) * parseFloat(balenceitems_data.fg_net_weight);


																					if(isNaN(precalculation_ready_for_export_kgs)){
																						$('#balence_qty_in_kgs').val(0);
																					}else{
																						$('#balence_qty_in_kgs').val(precalculation_ready_for_export_kgs);
																					}

																					var total_exp_qty_in_pcs = $('#total_exp_qty_in_pcs').val();

																					if(total_exp_qty_in_pcs==0){
																						$('#balence_qty_in_pcs').val(ready_for_exp_pcs);
																					}

																					var total_exp_qty_in_kgs = $('#total_exp_qty_in_kgs').val();

																					if(total_exp_qty_in_kgs==0){
																						$('#balence_qty_in_kgs').val(ready_for_exp_kgs.toFixed(3));
																					}
																			}
																		},
																		error: function (jqXHR, textStatus, errorThrown)
																		{
																				$('#balence_qty_in_pcs').val('');
																				$('#balence_qty_in_kgs').val('');
																		}
																	});
																





													}
												},
												error: function (jqXHR, textStatus, errorThrown)
												{
														$('#total_exp_qty_in_pcs').val('');
														$('#total_exp_qty_in_kgs').val('');
												}
											});
											return false;
										
									

								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
									$('#total_rejected_qty_in_pcs').val('');
									$('#total_rejected_qty_in_kgs').val('');
							}
						});
						
				

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					    $('#invoice_qty_in_pcs').val('');
						$('#invoice_qty_in_kgs').val('');
						$('#actual_received_qty_in_pcs').val('');
						$('#actual_received_qty_in_kgs').val('');
				}
			});
			return false;
	    });

		/* Commnet Starrt 04-07-2024*/

		$(document).ready(function() {
			var dt = $('#view_export_items').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "10%", "targets": 4 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Export Items Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":false,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>admin/fetchexportrecordsitem/"+buyer_po_number_id+"/"+part_number_id,
                    type: "post",
	            },
	        });
		});

		$(document).ready(function() {
			var dt = $('#view_rejected_items').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Rejected Items Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":false,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>admin/fetchrejecteditem/"+vendor_po_item_id+"/"+vendor_po_id+"/"+part_number_id,
                    type: "post",
	            },
	        });
		});

		$(document).on('click','#update_stock',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
		    var finishgood_id = $('#finishgood_id').val();
			var balence_qty_in_pcs = $('#balence_qty_in_pcs').val();
			var stock_id = $('#stock_id').val();
			$.ajax({
					url : "<?php echo ADMIN_PATH;?>admin/updatestockaftercalculation",
					type: "POST",
					 data : {'finishgood_id' : finishgood_id,'balence_qty_in_pcs':balence_qty_in_pcs,'stock_id':stock_id},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$(".report_type_error").html("");
						}
						else
						{
								swal({
										title: "Success",
										text: "Balance Qty Successfully Updated!",
										icon: "success",
										button: "Ok",
									},function(){ 
									window.location.href = "<?php echo base_url().'searchstock/'?>"+stock_id;
							    });		
						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$(".loader_ajax").hide();
					}
				});
			return false;
    	});


		$(document).on('click','#print_stock',function(e){
			e.preventDefault();
			$(".loader_ajax").show();

			var balence_qty_in_pcs = $('#balence_qty_in_pcs').val();
			var ready_for_exp_pcs = $('#ready_for_exp_pcs').val();
			var total_exp_qty_in_pcs = $('#total_exp_qty_in_pcs').val();
			var stock_id = $('#stock_id').val();
			var part_number_id = $('#part_number_id').val();

			$.ajax({
					url : "<?php echo ADMIN_PATH;?>admin/printstock/"+stock_id+'/'+balence_qty_in_pcs+'/'+ready_for_exp_pcs+'/'+total_exp_qty_in_pcs+'/'+part_number_id,
					type: "POST",
					 data : {'ready_for_exp_pcs' : ready_for_exp_pcs,'balence_qty_in_pcs':balence_qty_in_pcs,'stock_id':stock_id,'total_exp_qty_in_pcs':total_exp_qty_in_pcs,'part_number_id':part_number_id},
					success: function(data, textStatus, jqXHR)
					{

						window.location.href = "<?php echo base_url().'admin/printstock/'?>"+stock_id+'/'+balence_qty_in_pcs+'/'+ready_for_exp_pcs+'/'+total_exp_qty_in_pcs+'/'+part_number_id;
						$(".loader_ajax").hide();
						// if(data == "failure")
						// {
						// 	$(".report_type_error").html("");
						// }
						// else
						// {
						// 		swal({
						// 				title: "Success",
						// 				text: "Balance Qty Successfully Updated!",
						// 				icon: "success",
						// 				button: "Ok",
						// 			},function(){ 
						// 			window.location.href = "<?php echo base_url().'admin/printstock/'?>"+stock_id;
						// 	    });		
						// }
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$(".loader_ajax").hide();
					}
				});
			return false;
    	});


	
   </script>
<?php } ?>


<?php if($pageTitle=='OMS challan' || $pageTitle=='Add New OMS challan' || $pageTitle=='Edit OMS Chllan Form'){ ?>
	<script type="text/javascript">    
        $(document).ready(function() {
			var dt = $('#view_OMS_chllan').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					 { "width": "12%", "targets": 6 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No OMS Challan Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchomschallan",
                    type: "post",
	            },
	        });
		});

		$(document).ready(function() {
			// e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();
			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;

		});

		$(document).on('change','#vendor_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_name = $('#vendor_name').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorPoconfirmationvendorlist",
				type: "POST",
				data : {'vendor_name' : vendor_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#vendor_po_number').html('<option value="">Select Vendor PO Number</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#vendor_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','.vendor_po_get_data',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_po_id = $('.vendor_po_get_data').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>get_vendorpodata",
				type: "POST",
				data : {'vendor_po_id' : vendor_po_id},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#vendor_po_date').val('');
					}
					else
					{
						var get_vendorpodata = jQuery.parseJSON( data );
						$('#vendor_po_date').val(get_vendorpodata.date);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#vendor_po_date').val('');
				}
			});
			return false;
		});

		$(document).on('click','#addnewomschallan',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnewomschallanform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addNewOMSChallan",
				type: "POST",
				data : formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
					{
						$.each(fetchResponse.error, function (i, v)
						{
							$('.'+i+'_error').html(v);
						});
						$(".loader_ajax").hide();
					}
					else if(fetchResponse.status == 'success')
					{
						swal({
							title: "Success",
							text: "OMS Challan Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								window.location.href = "<?php echo base_url().'omschallan'?>";
						});		
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('click','.deleteomschallan',function(e){
		
		  var elemF = $(this);
		  e.preventDefault();
		  swal({
			  title: "Are you sure?",
			  text: "Delete OMS Challan ",
			  type: "warning",
			  showCancelButton: true,
			  closeOnClickOutside: false,
			  confirmButtonClass: "btn-sm btn-danger",
			  confirmButtonText: "Yes, delete it!",
			  cancelButtonText: "No, cancel plz!",
			  closeOnConfirm: false,
			  closeOnCancel: false
		  }, function(isConfirm) {
			  if (isConfirm) {
						  $.ajax({
							  url : "<?php echo base_url();?>deleteomschallan",
							  type: "POST",
							  data : 'id='+elemF.attr('data-id'),
							  success: function(data, textStatus, jqXHR)
							  {
								  const obj = JSON.parse(data);
							  
								  if(obj.status=='success'){
									  swal({
										  title: "Deleted!",
										  text: "OMS Challan Deleted Succesfully",
										  icon: "success",
										  button: "Ok",
										  },function(){ 
												  window.location.href = "<?php echo base_url().'omschallan'?>";
									  });	
								  }

							  },
							  error: function (jqXHR, textStatus, errorThrown)
							  {
								  $(".loader_ajax").hide();
							  }
						  })
					  }
					  else {
			  swal("Cancelled", "OMS Challan deletion cancelled ", "error");
			  }
		  });
	    });

		$(document).on('change','.vendor_po_for_item',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#vendor_po_number').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;
		});

		$(document).on('change','#part_number',function(e){  
				e.preventDefault();
			
				//$(".loader_ajax").show();
				var part_number = $('#part_number').val();
				var vendor_po_number = $('#vendor_po_number').val();
				var vendor_name = $('#vendor_name').val();

				if(vendor_name){
					if(vendor_po_number){
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>admin/getItemdetailsdependonvendorpoforstockformOMSChallan",
								type: "POST",
								data : {'part_number' : part_number,'vendor_po_number':vendor_po_number,'vendor_name':vendor_name},
								success: function(data, textStatus, jqXHR)
								{
									$(".loader_ajax").hide();
									if(data == "failure")
									{
										$('#fg_description').val('');
										$('#rm_description').val('');
										$('#hsn_no').val('');
									}
									else
									{
										var data_finish_good = jQuery.parseJSON( data );
										$('#fg_description').val(data_finish_good.name); 
										$('#rm_description').val(data_finish_good.type_of_raw_material);
										$('#hsn_no').val(data_finish_good.finhsn_code);

									}
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
										$('#fg_description').val('');
										$('#rm_description').val('');
										$('#hsn_no').val('');
								}
							});
							return false;

					}else{
						$('.part_number_error').html('Please Select Vendor PO Number');
					}

				}else{

					$('.part_number_error').html('Please Select Vendor PO');
				}
				
		});

		$(document).on('click','#saveomschallan_item',function(e){
			e.preventDefault();
			   $(".loader_ajax").show();

			   var oms_challan_id =   $('#oms_challan_id').val();

			   var part_number =   $('#part_number').val();
			   var gross_weight =   $('#gross_weight').val();
			   var net_weight =   $('#net_weight').val();
			   var no_of_bags =   $('#no_of_bags').val();
			   var hsn_no =   $('#hsn_no').val();
			   var unit =   $('#unit').val();
			   var calculation =   $('#calculation').val();
			   var qty = $('#qty').val();
			   var itemremark =   $('#itemremark').val();

			   var pre_oms_challan_date =   $('#oms_challan_date').val();
			   var pre_vendor_name =   $('#vendor_name').val();
			   var pre_vendor_po_number =   $('#vendor_po_number').val();
			   var pre_vendor_po_date =   $('#vendor_po_date').val();
			   var pre_remark =   $('#remark').val();

			   var oms_challan_item_id =   $('#oms_challan_item_id').val();

			   $.ajax({
				url : "<?php echo base_url();?>saveomschallanitem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,gross_weight:gross_weight,net_weight:net_weight,no_of_bags:no_of_bags,hsn_no:hsn_no,itemremark:itemremark,qty:qty,pre_oms_challan_date:pre_oms_challan_date,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_vendor_po_date:pre_vendor_po_date,pre_remark:pre_remark,oms_challan_id:oms_challan_id,unit:unit,calculation:calculation,oms_challan_item_id:oms_challan_item_id},
				 method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								if(oms_challan_id){
									window.location.href = "<?php echo base_url().'editomschallan/'?>"+oms_challan_id;	
								}else{
									window.location.href = "<?php echo base_url().'addNewOMSChallan'?>";	
								}
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			   });
			return false;
	    });

		$(document).on('click','.deleteOmschallnitem',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete OMS Challan Item ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteOmschallnitem",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "OMS Challan Item Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
													window.location.href = "<?php echo base_url().'addNewOMSChallan'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "OMS Challan Item deletion cancelled ", "error");
				}
			});
	    });
		
		$(document).on('click','.editChallanformitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			$.ajax({
				url : "<?php echo base_url();?>geteditChallanformitemforedititem",
				type: "POST",
				data : 'id='+item_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 

						$('#oms_challan_item_id').val(fetchResponse.omschallanid); 
						$('#part_number').val(fetchResponse.part_number);  
						$('#fg_description').val(fetchResponse.fg_description);  
						$('#rm_description').val(fetchResponse.rm_description);  
						$('#gross_weight').val(fetchResponse.gross_weight);  
						$('#unit').val(fetchResponse.unit);  
						$('#calculation').val(fetchResponse.calculation);  
						$('#net_weight').val(fetchResponse.net_weight);  
						$('#qty').val(fetchResponse.qty);  
						$('#hsn_no').val(fetchResponse.hsn_no);  
						$('#no_of_bags').val(fetchResponse.no_of_bags);  
						$('#itemremark').val(fetchResponse.remark);  
						
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		});

		$(document).on('click','.closeomschallan',function(e){  
			location.reload();
		});

	</script>
<?php } ?>


<?php if($pageTitle=='Enquiry Form' || $pageTitle=='Add New Enquiry Form' || $pageTitle=='Edit New Enquiry Form' ){  ?>
	<script type="text/javascript">   
         $(document).ready(function() {
			var dt = $('#view_enquiry_form').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "15%", "targets": 0 },
	                 { "width": "15%", "targets": 1 },
					 { "width": "15%", "targets": 2 },
	                 { "width": "15%", "targets": 3 },
					 { "width": "15%", "targets": 4 },
					 { "width": "12%", "targets": 5 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Enquiry Form Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchenquiryform",
                    type: "post",
	            },
	        });
		 });

		 $(document).on('click','#savenewenauiryform',function(e){
			e.preventDefault();
			$(".loader_ajax").show();

			
			var formData = new FormData($("#addnewenauiryform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addnewenquiryform",
				type: "POST",
				data : formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
					{
						$.each(fetchResponse.error, function (i, v)
						{
							$('.'+i+'_error').html(v);
						});
						$(".loader_ajax").hide();
					}
					else if(fetchResponse.status == 'success')
					{
						swal({
							title: "Success",
							text: "Enquiry Form Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								window.location.href = "<?php echo base_url().'enquiryform'?>";
						});		
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$(".loader_ajax").hide();
				}
			});
			return false;
		 });

		 $(document).on('change','#part_number',function(e){  
			e.preventDefault();
			
			//$(".loader_ajax").show();
			var part_number = $('#part_number').val();
			
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getfinishedgoodsPartnumberByid",
				type: "POST",
				data : {'part_number' : part_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#fg_description').value('');
					}
					else
					{
						var data_row_material = jQuery.parseJSON( data );

						$('#fg_description').val(data_row_material.name);
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#fg_description').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		 });

		 $(document).on('click','#saveenquiryform_item',function(e){
			e.preventDefault();
			   $(".loader_ajax").show();

			   var part_number =   $('#part_number').val();
			   var rm_description =   $('#rm_description').val();
			   var gross_weight =   $('#gross_weight').val();
			   var rm_size =   $('#rm_size').val();
			   var supplier_qty_in_kgs =   $('#supplier_qty_in_kgs').val();
			   var venodr_qty_in_pcs =   $('#venodr_qty_in_pcs').val();
			   
			   var supplier_name_1 =   $('#supplier_name_1').val();
			   var rate_1 =   $('#rate_1').val();
			   var supplier_name_2 =   $('#supplier_name_2').val();
			   var rate_2 =   $('#rate_2').val();
			   var supplier_name_3 =   $('#supplier_name_3').val();
			   var rate_3 =   $('#rate_3').val();
			   var supplier_name_4 =   $('#supplier_name_4').val();
			   var rate_4 =   $('#rate_4').val();
			   var supplier_name_5 =   $('#supplier_name_5').val();
			   var rate_5 =   $('#rate_5').val();

			   var vendor_name_1 =   $('#vendor_name_1').val();
			   var venodr_rate_1 =   $('#venodr_rate_1').val();
			   var vendor_name_2 =   $('#vendor_name_2').val();
			   var venodr_rate_2 =   $('#venodr_rate_2').val();
			   var vendor_name_3 =   $('#vendor_name_3').val();
			   var venodr_rate_3 =   $('#venodr_rate_3').val();
			   var vendor_name_4 =   $('#vendor_name_4').val();
			   var venodr_rate_4 =   $('#venodr_rate_4').val();
			   var vendor_name_5 =   $('#vendor_name_5').val();
			   var venodr_rate_5 =   $('#venodr_rate_5').val();

			   var pre_remark =   $('#remark').val();
			   var pre_status =   $('#status').val();
			   var pre_buyer_enquiry_date =   $('#buyer_enquiry_date').val();
			   var pre_buyer_enquiry_no =   $('#buyer_enquiry_no').val();
			   var pre_enquiry_date =   $('#enquiry_date').val();

			   var enquiry_form_item_id =   $('#enquiry_form_item_id').val();
			   var enquiry_form_id =   $('#enquiry_form_id').val();


			   var remark_1 =   $('#remark_1').val();
			   var remark_2 =   $('#remark_2').val();
			   var remark_3 =   $('#remark_3').val();
			   var remark_4 =   $('#remark_4').val();
			   var remark_5 =   $('#remark_5').val();

			   var remark_6 =   $('#remark_6').val();
			   var remark_7 =   $('#remark_7').val();
			   var remark_8 =   $('#remark_8').val();
			   var remark_9 =   $('#remark_9').val();
			   var remark_10 =   $('#remark_10').val();


			   $.ajax({
				url : "<?php echo base_url();?>saveenquiryformitem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,rm_description:rm_description,gross_weight:gross_weight,supplier_name_1:supplier_name_1,rate_1:rate_1,supplier_name_2:supplier_name_2,rate_2:rate_2,supplier_name_3:supplier_name_3,rate_3:rate_3,supplier_name_4:supplier_name_4,rate_4:rate_4,supplier_name_5:supplier_name_5,rate_5:rate_5,vendor_name_1:vendor_name_1,venodr_rate_1:venodr_rate_1,vendor_name_2:vendor_name_2,venodr_rate_2:venodr_rate_2,vendor_name_3:vendor_name_3,venodr_rate_3:venodr_rate_3,vendor_name_4:vendor_name_4,venodr_rate_4:venodr_rate_4,vendor_name_5:vendor_name_5,venodr_rate_5:venodr_rate_5,rm_size:rm_size,supplier_qty_in_kgs:supplier_qty_in_kgs,venodr_qty_in_pcs:venodr_qty_in_pcs,pre_remark:pre_remark,pre_status:pre_status,pre_buyer_enquiry_date:pre_buyer_enquiry_date,pre_buyer_enquiry_no:pre_buyer_enquiry_no,pre_enquiry_date:pre_enquiry_date,enquiry_form_item_id:enquiry_form_item_id,remark_1:remark_1,remark_2:remark_2,remark_3:remark_3,remark_4:remark_4,remark_5:remark_5,remark_6:remark_6,remark_7:remark_7,remark_8:remark_8,remark_9:remark_9,remark_10:remark_10,enquiry_form_id:enquiry_form_id},
				 method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								if(enquiry_form_id){

									window.location.href = "<?php echo base_url().'editeqnuiryformdatabyid/'?>"+enquiry_form_id;	
								}else{

									window.location.href = "<?php echo base_url().'addnewenquiryform'?>";	
								}
								
							   
								
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			   });
			return false;
	     });

		 $(document).on('click','.deleteeqnuiryformdata',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Enquiry Form Data",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteenquiryformdata",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Enquiry Form Data Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
													window.location.href = "<?php echo base_url().'enquiryform'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Enquiry Form Data deletion cancelled ", "error");
				}
			});
	     });

		 $(document).on('click','.deleteenquiryformitemdata',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Enquiry Form Item Data",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteenquiryformitemdata",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Enquiry Form Item Data Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
													window.location.href = "<?php echo base_url().'addnewenquiryform'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Enquiry Form Item Data deletion cancelled ", "error");
				}
			});
	     });

		 $(document).on('click','.editenquiryformitemdata',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			$.ajax({
				url : "<?php echo base_url();?>geteditenquiryformitemdata",
				type: "POST",
				data : 'id='+item_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 
						$('#enquiry_form_item_id').val(fetchResponse.enquiry_form_item_id); 
						$('#part_number').val(fetchResponse.fin_id); 
						$('#fg_description').val(fetchResponse.name); 
						$('#rm_description').val(fetchResponse.rm_description); 
						$('#gross_weight').val(fetchResponse.engroass_weight); 
						$('#rm_size').val(fetchResponse.rm_size); 
						$('#supplier_qty_in_kgs').val(fetchResponse.supplier_qty_in_kgs); 
                        $('#venodr_qty_in_pcs').val(fetchResponse.venodr_qty_in_pcs); 

						$('#supplier_name_1').val(fetchResponse.suplier_id_name_1); 
						$('#supplier_name_2').val(fetchResponse.suplier_id_name_2); 
						$('#supplier_name_3').val(fetchResponse.suplier_id_name_3); 
						$('#supplier_name_4').val(fetchResponse.suplier_id_name_4); 
						$('#supplier_name_5').val(fetchResponse.suplier_id_name_5); 

						$('#rate_1').val(fetchResponse.suplier_rate_1); 
						$('#rate_2').val(fetchResponse.suplier_rate_2); 
						$('#rate_3').val(fetchResponse.suplier_rate_3); 
						$('#rate_4').val(fetchResponse.suplier_rate_4); 
						$('#rate_5').val(fetchResponse.suplier_rate_5); 

						$('#vendor_name_1').val(fetchResponse.vendor_name_1); 
						$('#vendor_name_2').val(fetchResponse.vendor_name_2); 
						$('#vendor_name_3').val(fetchResponse.vendor_name_3); 
						$('#vendor_name_4').val(fetchResponse.vendor_name_4); 
						$('#vendor_name_5').val(fetchResponse.vendor_name_5); 
						$('#venodr_rate_1').val(fetchResponse.vendor_rate_1); 
						$('#venodr_rate_2').val(fetchResponse.vendor_rate_2); 
						$('#venodr_rate_3').val(fetchResponse.vendor_rate_3); 
						$('#venodr_rate_4').val(fetchResponse.vendor_rate_4); 
						$('#venodr_rate_5').val(fetchResponse.vendor_rate_5); 


						
					    $('#remark_1').val(fetchResponse.remark_1); 
						$('#remark_2').val(fetchResponse.remark_2); 
						$('#remark_3').val(fetchResponse.remark_3); 
						$('#remark_4').val(fetchResponse.remark_4); 
						$('#remark_5').val(fetchResponse.remark_5); 

						$('#remark_6').val(fetchResponse.remark_6); 
						$('#remark_7').val(fetchResponse.remark_7); 
						$('#remark_8').val(fetchResponse.remark_8); 
						$('#remark_9').val(fetchResponse.remark_9); 
						$('#remark_10').val(fetchResponse.remark_10); 
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		 });

	</script>
<?php } ?>


<?php if($pageTitle=='Stockrejection Form' || $pageTitle=='Add New Rejection Form' || $pageTitle=='Edit Rejection Form' || $pageTitle=='Add Rejection Form Data'){ ?>
	<script type="text/javascript">  
         $(document).ready(function() {
			var dt = $('#view_stockrejection_form').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "20%", "targets": 0 },
	                 { "width": "20%", "targets": 1 },
					 { "width": "20%", "targets": 2 },
	                 { "width": "15%", "targets": 3 },
					 { "width": "15%", "targets": 4 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Stock Rejection Form Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchenstockrejectionform",
                    type: "post",
	            },
	        });
		 });

		 $(document).ready(function() {
			var rejection_form_id = $('#rejection_form_id').val();

			var dt = $('#view_stockrejection_form_item_data').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "20%", "targets": 0 },
	                 { "width": "20%", "targets": 1 },
					 { "width": "20%", "targets": 2 },
	                 { "width": "8%", "targets": 3 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Stock Rejection Form Item Data Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchenstockrejectionformitemdata/"+rejection_form_id,
                    type: "post",
	            },
	        });
		 });

		 $(document).on('click','#addnewrejectionform',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnewrejectionformdata")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addnewrejectionform",
				type: "POST",
				data : formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
					{
						$.each(fetchResponse.error, function (i, v)
						{
							$('.'+i+'_error').html(v);
						});
						$(".loader_ajax").hide();
					}
					else if(fetchResponse.status == 'success')
					{
						swal({
							title: "Success",
							text: "Rejection Form Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								window.location.href = "<?php echo base_url().'stockrejectionform'?>";
						});		
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$(".loader_ajax").hide();
				}
			});
			return false;
		 });

		 $(document).on('change','#vendor_name',function(e){  
				e.preventDefault();
				//$(".loader_ajax").show();
				// $("#customers-list").html('');
				var vendor_name = $('#vendor_name').val();
				$('.vendor_po_number_div').css('display','block');
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>getVendorPonumberbyVendorid",
					type: "POST",
					data : {'vendor_name' : vendor_name},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$('#vendor_po_number').html('<option value="">Select Vendor PO Number</option>');
						}
						else
						{
							// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
							$('#vendor_po_number').html(data);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#vendor_po_number').html();
						//$(".loader_ajax").hide();
					}
				});
				return false;
		 });

		 $(document).on('click','.deleterejectionform',function(e){
				var elemF = $(this);
				e.preventDefault();
				swal({
					title: "Are you sure?",
					text: "Delete Rejection Form ",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deleterejectionform",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "Rejection Form Deleted Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 
													window.location.href = "<?php echo base_url().'stockrejectionform'?>";
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "Rejection Form deletion cancelled ", "error");
					}
				});
	     });

		 $(document).on('click','.addrejectionitemdata',function(e){
			var elemF = $(this);

			$('#rejection_form_id_popup').val();
			$('#vendor_po_id').val();
			$('#vendor_po_item_id').val();
			$('#net_weight').val();

			var rejection_form_id = elemF.attr('rejection-form-id');
			var vendor_po_id = elemF.attr('vendor-po-id');
			var vendor_po_item_id = elemF.attr('vendor_po_item_id');
			var net_weight = elemF.attr('net_weight');

			$('#rejection_form_id_popup').val(rejection_form_id);
			$('#vendor_po_id').val(vendor_po_id);
			$('#vendor_po_item_id').val(vendor_po_item_id);
			$('#net_weight').val(net_weight);
	     });

		 $(document).on('change', '#qty_in_pcs', function(){	
				
			     $("#qty_in_kgs").val();
			  
				 if($("#qty_in_pcs").val()){
					 var qty_in_pcs = $("#qty_in_pcs").val();
				 }else{
					 var qty_in_pcs = 0;
				 }

				 if($("#net_weight").val()){
					 var net_weight = $("#net_weight").val();
				 }else{
					 var net_weight = 0;
				 }
		 
				 var value = parseFloat(qty_in_pcs) * parseFloat(net_weight);
				 $("#qty_in_kgs").val(value);
		 });

		 $(document).on('click','#saverejectedformitemdata',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var rejection_form_id_popup = $("#rejection_form_id_popup").val();
			var formData = new FormData($("#saverejectedformitemdataform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>saverejectedformitemdata",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Items Details Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'addrejectionformitemsdata/'?>"+rejection_form_id_popup;
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	     });	 
	</script>
<?php } ?>


<?php if($pageTitle=='View Rejection Form Data'){ ?>
	<script type="text/javascript">  
        $(document).ready(function() {

			var rejection_form_id = $("#rejection_form_id").val();
			var vendor_po_item_id = $("#vendor_po_item_id").val();
			var vendor_po_id = $("#vendor_po_id").val();

			var dt = $('#view_stock_rejection_form_ttem_details').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "20%", "targets": 0 },
	                 { "width": "20%", "targets": 1 },
					 { "width": "20%", "targets": 2 },
	                 { "width": "15%", "targets": 3 },
					 { "width": "15%", "targets": 4 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Stock Rejection Form Item Details Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetch_stock_rejection_form_ttem_details",
                    type: "post",
					data : {'rejection_form_id':rejection_form_id,'vendor_po_item_id':vendor_po_item_id,'vendor_po_id':vendor_po_id},
	            },
	        });
		});


		$(document).on('click','.deleterejectionformitem',function(e){
			
			var rejection_form_id = $("#rejection_form_id").val();
			var vendor_po_item_id = $("#vendor_po_item_id").val();
			var vendor_po_id = $("#vendor_po_id").val();
			
			    var elemF = $(this);
				e.preventDefault();
				swal({
					title: "Are you sure?",
					text: "Delete Rejection Form Item Details",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deleterejectionformitem",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "Rejection Form Item Details Deleted Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 
													window.location.href = "<?php echo base_url().'viewrejectionformitemdetails?'?>rejection_form_id="+rejection_form_id+"vendor_po_item_id="+vendor_po_item_id+"vendor_po_id="+vendor_po_id;
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "Rejection Form Item Details deletion cancelled ", "error");
					}
				});
	    });


		$(document).on('click','.editrejectionformitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');		
			$.ajax({
				url : "<?php echo base_url();?>geteditrejectionformitem",
				type: "POST",
				data : 'id='+item_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 
						$('#rejection_form_id_popup').val(fetchResponse.id); 
						$('#rejected_reason').val(fetchResponse.rejected_reason);  
						$('#qty_in_pcs').val(fetchResponse.qty_In_pcs);  
						$('#qty_in_kgs').val(fetchResponse.qty_in_kgs);  
						$('#remark').val(fetchResponse.remark); 
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		});

		$(document).on('change', '#qty_in_pcs', function(){	
				
				$("#qty_in_kgs").val();
			 
				if($("#qty_in_pcs").val()){
					var qty_in_pcs = $("#qty_in_pcs").val();
				}else{
					var qty_in_pcs = 0;
				}

				if($("#net_weight_fg").val()){
					var net_weight = $("#net_weight_fg").val();
				}else{
					var net_weight = 0;
				}
		
				var value = parseFloat(qty_in_pcs) * parseFloat(net_weight);
				$("#qty_in_kgs").val(value);
		});


		$(document).on('click','#editrejectedformitemdata',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var rejection_form_id = $("#rejection_form_id").val();
			var vendor_po_item_id = $("#vendor_po_item_id").val();
			var vendor_po_id = $("#vendor_po_id").val();

			var formData = new FormData($("#editrejectedformitemdataform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>editrejectedformitemdata",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Items Details Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								window.location.href = "<?php echo base_url().'viewrejectionformitemdetails?';?>rejection_form_id="+rejection_form_id+"&vendor_po_item_id="+vendor_po_item_id+"&vendor_po_id="+vendor_po_id;
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
	     });


	</script>
<?php } ?>


<?php if($pageTitle=='View Buyer PO Details Report'){ ?>
	<script type="text/javascript"> 
        $(document).ready(function() {
			$("#view_buyer_PO_details_report").dataTable().fnDestroy();
			if($("#buyer_name").val()){
				var buyer_name = $("#buyer_name").val();
			}else{
				var buyer_name = 'NA';
			}

			if($("#part_number").val()){
				var part_number = $("#part_number").val();
			}else{
				var part_number = 'NA';
			}

			if($("#from_date").val()){
				var from_date = $("#from_date").val();
			}else{
				var from_date = 'NA';
			}

			if($("#to_date").val()){
				var to_date = $("#to_date").val();
			}else{
				var to_date = 'NA';
			}

			getAlldatausingfilter(buyer_name,part_number,from_date,to_date);

		});

		$("#from_date").datepicker({

			dateFormat: 'yy-mm-dd',
			controlType: 'select',
			oneLine: true,
			changeMonth: true,
			changeYear: true,
			timeFormat: '',
			// maxDate: 0,

			onSelect: function(dateText) {
				

				if($("#buyer_name").val()){
					var buyer_name = $("#buyer_name").val();
				}else{
					var buyer_name = 'NA';
				}

				if($("#part_number").val()){
					var part_number = $("#part_number").val();
				}else{
					var part_number = 'NA';
				}

				if($("#from_date").val()){
					var from_date = $("#from_date").val();
				}else{
					var from_date = 'NA';
				}

				if($("#to_date").val()){
					var to_date = $("#to_date").val();
				}else{
					var to_date = 'NA';
				}
				
				getAlldatausingfilter(buyer_name,part_number,from_date,to_date);
			}
		});

		$("#to_date").datepicker({
			         dateFormat: 'yy-mm-dd',
					controlType: 'select',
					oneLine: true,
					changeMonth: true,
			    	changeYear: true,
					timeFormat: '',
					// maxDate: 0,
			onSelect: function(dateText) {

				if($("#buyer_name").val()){
					var buyer_name = $("#buyer_name").val();
				}else{
					var buyer_name = 'NA';
				}

				if($("#part_number").val()){
					var part_number = $("#part_number").val();
				}else{
					var part_number = 'NA';
				}

				if($("#from_date").val()){
					var from_date = $("#from_date").val();
				}else{
					var from_date = 'NA';
				}

				if($("#to_date").val()){
					var to_date = $("#to_date").val();
				}else{
					var to_date = 'NA';
				}
				
				getAlldatausingfilter(buyer_name,part_number,from_date,to_date);
			}
		});

		$(document).on('change','#buyer_name',function(e){
			e.preventDefault();
			$("#view_buyer_PO_details_report").dataTable().fnDestroy();
			if($("#buyer_name").val()){
				var buyer_name = $("#buyer_name").val();
			}else{
				var buyer_name = 'NA';
			}

			if($("#part_number").val()){
				var part_number = $("#part_number").val();
			}else{
				var part_number = 'NA';
			}

			if($("#from_date").val()){
				var from_date = $("#from_date").val();
			}else{
				var from_date = 'NA';
			}

			if($("#to_date").val()){
				var to_date = $("#to_date").val();
			}else{
				var to_date = 'NA';
			}

			getAlldatausingfilter(buyer_name,part_number,from_date,to_date);

			
		});

		$(document).on('change','#part_number',function(e){
			e.preventDefault();
			$("#view_buyer_PO_details_report").dataTable().fnDestroy();
			if($("#buyer_name").val()){
				var buyer_name = $("#buyer_name").val();
			}else{
				var buyer_name = 'NA';
			}

			if($("#part_number").val()){
				var part_number = $("#part_number").val();
			}else{
				var part_number = 'NA';
			}

			if($("#from_date").val()){
				var from_date = $("#from_date").val();
			}else{
				var from_date = 'NA';
			}

			if($("#to_date").val()){
				var to_date = $("#to_date").val();
			}else{
				var to_date = 'NA';
			}

			getAlldatausingfilter(buyer_name,part_number,from_date,to_date);

			
		});

		function getAlldatausingfilter(buyer_name,part_number,from_date,to_date){
			$("#view_buyer_PO_details_report").dataTable().fnDestroy();
			var dt = $('#view_buyer_PO_details_report').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					 { "width": "10%", "targets": 6 },
					 { "width": "10%", "targets": 7 },
					 { "width": "10%", "targets": 8 },
					 { "width": "10%", "targets": 9 },
					 { "width": "10%", "targets": 10 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Buyer PO Details Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>admin/fetchbuyerpodetailsreport/"+buyer_name+"/"+part_number+"/"+from_date+"/"+to_date,
                    type: "post",
	            },
	        });


			$.ajax({
				url : "<?php echo ADMIN_PATH;?>admin/calculatesumofallbuyerdetails/"+buyer_name+"/"+part_number+"/"+from_date+"/"+to_date,
				type: "POST",
				data : {'flag' : 'sum of all buyer details'},
					success: function(data, textStatus, jqXHR)
				    {
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#total_order_qty').val('');
					             	$("#total_export_qty").val('');	
									$("#balenace_export_qty").val('');	
								}
								else
								{
									var calculate_valuecls = jQuery.parseJSON( data );
									var total_order_qty =  calculate_valuecls.total_order_aty;
									var total_export_qty =  calculate_valuecls.export_qty;

									
										$('#total_order_qty').val(total_order_qty);
					             	    $("#total_export_qty").val(total_export_qty);	

									    var balence_export_qty = parseFloat(total_order_qty) - parseFloat(total_export_qty);
										if(isNaN(balence_export_qty)) {
											var result = 0;
										}else{
											var result = balence_export_qty;
										}
										
									    $("#balenace_export_qty").val(result);
									
								}
					},
					error: function (jqXHR, textStatus, errorThrown)
						{
							$('#total_order_qty').val('');
					        $("#total_export_qty").val('');	
							$("#balenace_export_qty").val('');			
						}
            });

		};

	    $(document).on('click','#export_to_excel',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			if($("#buyer_name").val()){
				var buyer_name = $("#buyer_name").val();
			}else{
				var buyer_name = 'NA';
			}

			if($("#part_number").val()){
				var part_number = $("#part_number").val();
			}else{
				var part_number = 'NA';
			}

			if($("#from_date").val()){
				var from_date = $("#from_date").val();
			}else{
				var from_date = 'NA';
			}

			if($("#to_date").val()){
				var to_date = $("#to_date").val();
			}else{
				var to_date = 'NA';
			}

 
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>admin/exportbuyerdetailsrecord/"+buyer_name+"/"+part_number+"/"+from_date+"/"+to_date,
				type: "POST",
				// data : {'hospitals' : hospitals, 'driver' : driver,'ride_start':ride_start,'ride_stop':ride_stop},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
				    {
						$(".report_type_error").html("");
				    	alert('No data fond');
				    }
				    else
				    {
						$(".report_type_error").html("");
				    	window.location.href = "<?php echo ADMIN_PATH;?>admin/exportbuyerdetailsrecord/"+buyer_name+"/"+part_number+"/"+from_date+"/"+to_date;
				    }
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   		alert('No data fond');
					$(".loader_ajax").hide();
			    }
			});
		   return false;
	    });

	</script>
<?php } ?>


<?php if($pageTitle=='ITC Report'){ ?>
	<script type="text/javascript"> 
	  $(document).on('click','#ITC_export_to_excel',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			
			if($("#ITC_report").val()){
				var ITC_report = $("#ITC_report").val();
			}else{
				var ITC_report = 'NA';
			}

			if($("#job_work_no").val()){
				var job_work_no = $("#job_work_no").val();
			}else{
				var job_work_no = 'NA';
			}

			if($("#from_date").val()){
				var from_date = $("#from_date").val();
			}else{
				var from_date = 'NA';
			}

			if($("#to_date").val()){
				var to_date = $("#to_date").val();
			}else{
				var to_date = 'NA';
			}

			$.ajax({
				url : "<?php echo ADMIN_PATH;?>admin/exportitcreportITC/"+ITC_report+"/"+job_work_no+"/"+from_date+"/"+to_date,
				type: "POST",
				// data : {'hospitals' : hospitals, 'driver' : driver,'ride_start':ride_start,'ride_stop':ride_stop},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
				    {
						$(".report_type_error").html("");
				    	alert('No data fond');
				    }
				    else
				    {
						$(".report_type_error").html("");
				    	window.location.href = "<?php echo ADMIN_PATH;?>admin/exportitcreportITC/"+ITC_report+"/"+job_work_no+"/"+from_date+"/"+to_date;
				    }
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   		alert('No data fond');
					$(".loader_ajax").hide();
			    }
			});
		   return false;
	    });

    </script>
<?php } ?>


<?php if($pageTitle=='Complaint Form' || $pageTitle=='Add New Compalint Form' || $pageTitle=='Edit Complain Form' ){ ?>
	<script type="text/javascript"> 
        $(document).ready(function() {
		    var dt = $('#view_complaint_form').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "15%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					 { "width": "8%", "targets": 6 },
					 { "width": "8%", "targets": 7 },
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Complaint Records Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchcompalintrecords",
                    type: "post",
	            },
	        });
        });

		// $(document).ready(function() {

		// 	var vendor_po_number = $('#po_no_wo_no').val();

		// 	$("#drawing_no_rev_no").html('');
		
		// 	$.ajax({
		// 		url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
		// 		type: "POST",
		// 		data : {'vendor_po_number' : vendor_po_number},
		// 		success: function(data, textStatus, jqXHR)
		// 		{
		// 			$(".loader_ajax").hide();
		// 			if(data == "failure")
		// 			{
		// 				$('#drawing_no_rev_no').html('<option value="">Select Part Number</option>');
		// 			}
		// 			else
		// 			{
		// 				$('#drawing_no_rev_no').html(data);

		// 			}
		// 		},
		// 		error: function (jqXHR, textStatus, errorThrown)
		// 		{
		// 			$('#drawing_no_rev_no').html();
		// 		}
		// 	});
		// 	return false;
		    
        // });

		$(document).on('click','#savenewcompalinformdata',function(e){
			e.preventDefault();
			$(".loader_ajax").show();

			var formData = new FormData($("#savenewcompalinform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addcomplaintform",
				type: "POST",
				data : formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
					{
						$.each(fetchResponse.error, function (i, v)
						{
							$('.'+i+'_error').html(v);
						});
						$(".loader_ajax").hide();
					}
					else if(fetchResponse.status == 'success')
					{
						swal({
							title: "Success",
							text: "Complain Form Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								window.location.href = "<?php echo base_url().'complaintform'?>";
						});		
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('click','.deletecomplainform',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Complian Form ",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deletecomplainform",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Complian Form Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
													window.location.href = "<?php echo base_url().'complaintform'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Compliant Form  deletion cancelled ", "error");
				}
			});
	    });

		$(document).on('change','#vendor_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			// $("#customers-list").html('');
			var vendor_name = $('#vendor_name').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendorPonumberbyVendorid",
				type: "POST",
				data : {'vendor_name' : vendor_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#po_no_wo_no').html('<option value="">Select Vendor PO Number</option>');
					}
					else
					{
						// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
						$('#po_no_wo_no').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#po_no_wo_no').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','.po_no_wo_no',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var vendor_po_number = $('#po_no_wo_no').val();

			$("#drawing_no_rev_no").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getVendoritemonly",
				type: "POST",
				data : {'vendor_po_number' : vendor_po_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#drawing_no_rev_no').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#drawing_no_rev_no').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#drawing_no_rev_no').html();
				}
			});
			return false;
		});

		$(document).on('change','.drawing_no_rev_no',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var drawing_no_rev_no = $('#drawing_no_rev_no').val();

			$("#component_description").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getPartDetailsbypartnumber",
				type: "POST",
				data : {'drawing_no_rev_no' : drawing_no_rev_no},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#component_description').html('<option value="">Select Part </option>');
					}
					else
					{
						$('#component_description').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#component_description').html();
				}
			});
			return false;
		});

    </script>
<?php } ?>


<?php if($pageTitle=='Credit Note' || $pageTitle=='Add Credit Note' || $pageTitle=='Edit Credit Note'){ ?>
	<script type="text/javascript"> 
        $(document).ready(function() {
		    var dt = $('#view_credit_note').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					 { "width": "8%", "targets": 6 },
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Credit Report Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>fetchcreditnoterecords",
                    type: "post",
	            },
	        });
        });

		$(document).ready(function() {
			var buyer_po_number = $('.buyer_po_number_for_item').val();

					$("#part_number").html('');

					var flag = 'Buyer';

					$.ajax({
						url : "<?php echo ADMIN_PATH;?>getbuyeritemonly",
						type: "POST",
						data : {'buyer_po_number' : buyer_po_number,'flag':flag},
						success: function(data, textStatus, jqXHR)
						{
							$(".loader_ajax").hide();
							if(data == "failure")
							{
								$('#part_number').html('<option value="">Select Part Number</option>');
							}
							else
							{
								$('#part_number').html(data);

							}
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							$('#part_number').html();
						}
					});
					return false;
		});

		// $(document).ready(function() {

		// 	var part_number_for_export_invoice = $('.part_number_for_export_invoice').val();
		// 	var buyer_po_number = $('#buyer_po_number').val();

		// 	$("#invoice_number").html('');

		// 	$.ajax({
		// 		url : "<?php echo ADMIN_PATH;?>getexportInvoicebybyerpo",
		// 		type: "POST",
		// 		data : {'buyer_po_number' : buyer_po_number,'part_number_for_export_invoice' : part_number_for_export_invoice},
		// 		success: function(data, textStatus, jqXHR)
		// 		{
		// 			$(".loader_ajax").hide();
		// 			if(data == "failure")
		// 			{
		// 				$('#invoice_number').html('<option value="">Select Invoice Number</option>');
		// 			}
		// 			else
		// 			{
		// 				$('#invoice_number').html(data);

		// 			}
		// 		},
		// 		error: function (jqXHR, textStatus, errorThrown)
		// 		{
		// 			$('#invoice_number').html();
		// 		}
		// 	});
		// 	return false;

		// });

		$(document).on('change','#buyer_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			$("#customers-list").html('');
			var buyer_name = $('#buyer_name').val();
		    $('.buyer_po_number_div').css('display','block');
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerPonumbercreditnote",
				type: "POST",
				data : {'buyer_name' : buyer_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						$('#buyer_po_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#buyer_po_number').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','.buyer_name_for_currency',function(e){  
			e.preventDefault();

			$('#currency').html();
			
			//$(".loader_ajax").show();
			var buyer_name = $('#buyer_name').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerCurrency",
				type: "POST",
				data : {'buyer_name' : buyer_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#currency').value('');
					}
					else
					{
						$('#currency').val(data);
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#currency').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('change','.buyer_po_number_for_item',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var buyer_po_number = $('.buyer_po_number_for_item').val();

			$("#part_number").html('');

			var flag = 'Buyer';
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getbuyeritemonly",
				type: "POST",
				data : {'buyer_po_number' : buyer_po_number,'flag':flag},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;
		});
		
		$(document).on('change','.part_number_for_export_invoice',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var part_number_for_export_invoice = $('.part_number_for_export_invoice').val();
			var buyer_po_number = $('#buyer_po_number').val();

			$("#invoice_number").html('');

			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getexportInvoicebybyerpo",
				type: "POST",
				data : {'buyer_po_number' : buyer_po_number,'part_number_for_export_invoice' : part_number_for_export_invoice},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#invoice_number').html('<option value="">Select Invoice Number</option>');
					}
					else
					{
						$('#invoice_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#invoice_number').html();
				}
			});
			return false;
		});

		$(document).on('change','#part_number',function(e){  
			e.preventDefault();
			
			//$(".loader_ajax").show();
			var part_number = $('#part_number').val();
			
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getPartnumberBypartnumberforcreitnote",
				type: "POST",
				data : {'part_number' : part_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#description').value('');
						$('#hsn_code').val('');
					}
					else
					{
						var data_row_material = jQuery.parseJSON( data );
						$('#description').val(data_row_material.name);
						$('#hsn_code').val(data_row_material.hsn_code);
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					    $('#description').value('');
						$('#hsn_code').val('');
					   //$(".loader_ajax").hide();
				}
			});
			return false;
		});

		// $(document).on('change', '#rate,#qty', function(){	
		// 		 $("#invoice_value").val();

		// 		 if($("#rate").val()){
		// 			 var rate = $("#rate").val();
		// 		 }else{
		// 			 var rate = 0;
		// 		 }

		// 		 if($("#qty").val()){
		// 			 var qty = $("#qty").val();
		// 		 }else{
		// 			 var qty = 0;
		// 		 }

		// 		 var total_second_group = parseFloat(rate) *  parseFloat(qty);
		// 		 $("#invoice_value").val(Math.round(total_second_group));

		// });

		// $(document).on('change', '#recivable_amount', function(){	
		// 		 $("#diff_value").val();

		// 		 if($("#invoice_value").val()){
		// 			 var invoice_value = $("#invoice_value").val();
		// 		 }else{
		// 			 var invoice_value = 0;
		// 		 }

		// 		 if($("#recivable_amount").val()){
		// 			 var recivable_amount = $("#recivable_amount").val();
		// 		 }else{
		// 			 var recivable_amount = 0;
		// 		 }
		// 		 var total_second_group = parseFloat(invoice_value) - parseFloat(recivable_amount);
		// 		 $("#diff_value").val(Math.round(total_second_group));

		// });

		$(document).on('change','.invoice_number',function(e){  
			e.preventDefault();

			$('#currency').html();
			
			//$(".loader_ajax").show();
			var invoice_number = $('#invoice_number').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getInvoicedateforcreditdate",
				type: "POST",
				data : {'invoice_number' : invoice_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#invoice_date').value('');
					}
					else
					{
						$('#invoice_date').val(data);
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#invoice_date').html();
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('click','#savecreditnoteitrminformation',function(e){
			e.preventDefault();
			   $(".loader_ajax").show();
			   var formData = new FormData($("#savecreditnoteinformationform")[0]);

			   var part_number =   $('#part_number').val();
			   var description =   $('#description').val();
			   var invoice_no =   $('#invoice_number').val();
			   var invoice_date =   $('#invoice_date').val();
			   var qty =   $('#qty').val();
			   var rate =   $('#rate').val();
			   var invoice_value =   $('#invoice_value').val();
			   var recivable_amount =   $('#recivable_amount').val();
			   var diff_value =   $('#diff_value').val();
			   var item_remark =   $('#item_remark').val();

			   var pre_date =   $('#date').val();
			   var pre_buyer_name =   $('#buyer_name').val();
			   var pre_buyer_po_number =   $('#buyer_po_number').val();
			   var pre_currency =   $('#currency').val();
			   var pre_remark =   $('#remark').val();


			   var cerdit_note_id =   $('#cerdit_note_id').val();
			
			   var cerdit_note_item_id =   $('#cerdit_note_item_id').val();

			   $.ajax({
				url : "<?php echo base_url();?>saveCreditnoteitem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,invoice_no:invoice_no,invoice_date:invoice_date,qty:qty,rate:rate,invoice_value:invoice_value,recivable_amount:recivable_amount,diff_value:diff_value,item_remark:item_remark,pre_date:pre_date,pre_buyer_name:pre_buyer_name,pre_buyer_po_number:pre_buyer_po_number,pre_currency:pre_currency,pre_remark:pre_remark,cerdit_note_id:cerdit_note_id,cerdit_note_item_id:cerdit_note_item_id},
				 method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								if(cerdit_note_id){
								 	window.location.href = "<?php echo base_url().'editcreditnote/'?>"+cerdit_note_id;
								 }else{
									window.location.href = "<?php echo base_url().'addcreditnote'?>";
								 }
							
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			   });
			return false;
	    });

		$(document).on('click','#savenewcreditnote',function(e){
			e.preventDefault();
			$(".loader_ajax").show();

			var formData = new FormData($("#addnnewcreditnoteform")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addcreditnote",
				type: "POST",
				data : formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
					{
						$.each(fetchResponse.error, function (i, v)
						{
							$('.'+i+'_error').html(v);
						});
						$(".loader_ajax").hide();
					}
					else if(fetchResponse.status == 'success')
					{
						swal({
							title: "Success",
							text: "Credit Note Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								window.location.href = "<?php echo base_url().'creditnote'?>";
						});		
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('click','.deletecreditnote',function(e){
			var elemF = $(this);
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Delete Credit Note",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deletecreditnote",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Credit Note Succesfully Deleted",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'creditnote'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Credit Note deletion cancelled ", "error");
				}
			});
		});

        $(document).on('click','.deletecreditnoteitem',function(e){
			
			//var challan_id = $("#challan_id").val();
			var elemF = $(this);
				e.preventDefault();
				swal({
					title: "Are you sure?",
					text: "Delete Credit Note Item ",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deletecreditnoteitem",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "Credit Note Item Deleted Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 

													// if(challan_id){
													// 	window.location.href = "<?php echo base_url().'editchallanform/'?>"+challan_id;
													// }else{
														window.location.href = "<?php echo base_url().'addcreditnote'?>";
													// }
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "Credit Note Item deletion cancelled ", "error");
					}
				});
	    });

	    $(document).on('click','.closecreditnotemodal',function(e){  
			location.reload();
		});

		$(document).on('click','.editcreditnoteitem',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			$.ajax({
				url : "<?php echo base_url();?>geteditcreditnoteitem",
				type: "POST",
				data : 'id='+item_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#addNewModal').modal('show'); 
						$('#cerdit_note_item_id').val(fetchResponse.credit_note_item_id); 
						$('#part_number').val(fetchResponse.raw_id); 
						$('#description').val(fetchResponse.description); 
						$('#hsn_code').val(fetchResponse.hsn_code); 
						$('#invoice_number').val(fetchResponse.invoice_no_id); 
						$('#invoice_date').val(fetchResponse.invoice_date); 
						$('#qty').val(fetchResponse.qty); 
						$('#rate').val(fetchResponse.price); 
						$('#invoice_value').val(fetchResponse.price); 
						$('#recivable_amount').val(fetchResponse.recivable_amount); 
						$('#diff_value').val(fetchResponse.diff_credite_note_value); 
					    $('#item_remark').val(fetchResponse.remark); 
						// $('#gst').val(fetchResponse.gst); 
						// $('#gst_rate').val(fetchResponse.gst_rate); 
						// $('#grand_total').val(fetchResponse.grand_total);
						// $('#item_remark').val(fetchResponse.item_remark); 
						
						
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		});

    </script>
<?php } ?>


<?php if($pageTitle=='Pre Export' || $pageTitle=='Add New Export Export' || $pageTitle=="Edit Pre Export"){?>
	<script type="text/javascript"> 
	        $(document).ready(function() {
				var dt = $('#view_pre_export').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "10%", "targets": 0 },
						{ "width": "10%", "targets": 1 },
						{ "width": "10%", "targets": 2 },
						{ "width": "10%", "targets": 3 },
						{ "width": "10%", "targets": 4 },
						{ "width": "10%", "targets": 5 },
						{ "width": "10%", "targets": 6 },
						{ "width": "8%", "targets": 7 },
						{ "width": "8%", "targets": 8 },
						{ "width": "10%", "targets": 9 },
						// { "width": "15%", "targets": 10 },
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No Pre Export Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchpreexportdetails",
						type: "post",
					},
				});
            });


			$(document).on('change','#buyer_name',function(e){  
				e.preventDefault();
				//$(".loader_ajax").show();
				$("#customers-list").html('');
				var buyer_name = $('#buyer_name').val();
				$('.buyer_po_number_div').css('display','block');
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>getBuyerPonumbercreditnote",
					type: "POST",
					data : {'buyer_name' : buyer_name},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						}
						else
						{
							// $('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
							$('#buyer_po_number').html(data);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#buyer_po_number').html();
						//$(".loader_ajax").hide();
					}
				});
				return false;
		    });


		    $(document).on('click','#savenewpreexport',function(e){

				e.preventDefault();
				$(".loader_ajax").show();

				var preexport_id = $('#preexport_id').val();

				var formData = new FormData($("#savenewpreexportform")[0]);
				$.ajax({
					url : "<?php echo base_url();?>addnewfreexport",
					type: "POST",
					data : formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data, textStatus, jqXHR)
					{
						var fetchResponse = $.parseJSON(data);
						if(fetchResponse.status == "failure")
						{
							$.each(fetchResponse.error, function (i, v)
							{
								$('.'+i+'_error').html(v);
							});
							$(".loader_ajax").hide();
						}
						else if(fetchResponse.status == 'success')
						{
							swal({
								title: "Success",
								text: "Pre-Export Successfully Added!",
								icon: "success",
								button: "Ok",
								},function(){ 
									
									window.location.href = "<?php echo base_url().'preexport'?>";
								
							});		
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$(".loader_ajax").hide();
					}
				});
				return false;
            });


			$(document).on('click','.deletepreexport',function(e){
				var elemF = $(this);
				e.preventDefault();
				swal({
					title: "Are you sure?",
					text: "Delete Pre-Export ",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deletepreexport",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "Pre-Export Succesfully Deleted",
												icon: "success",
												button: "Ok",
												},function(){ 
													window.location.href = "<?php echo base_url().'preexport'?>";
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "Pre-Export deletion cancelled ", "error");
					}
				});
		    });

    </script>
<?php } ?>


<?php if($pageTitle=='Pre Export Item Details' || $pageTitle=='Add New Pre Export Item Details' || $pageTitle=='Edit Pre Export Item Details'){?>
	<script type="text/javascript"> 
	        $(document).ready(function() {
				
				var main_export_id = $('#main_export_id').val();
				var dt = $('#view_pre_export_item_details').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "10%", "targets": 0 },
						{ "width": "10%", "targets": 1 },
						{ "width": "10%", "targets": 2 },
						{ "width": "10%", "targets": 3 },
						{ "width": "10%", "targets": 4 },
						{ "width": "10%", "targets": 5 },
						{ "width": "10%", "targets": 6 },
						{ "width": "10%", "targets": 7 },
					    { "width": "10%", "targets": 8 },
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No Pre Export Item Details Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchpreexportitemdetails/"+main_export_id,
						type: "post",
					},
				});
            });


			$(document).ready(function() {
				//$(".loader_ajax").show();
				// $("#customers-list").html('');
				var part_number = $('#part_number').val();
				var main_export_id = $('#main_export_id').val();
				var buyer_po_id = $('#buyer_po_id').val();
				var buyer_name_id = $('#buyer_name_id').val();

				var selectElement = document.getElementById("part_number");
				// Get the selected option element
				var selectedOption = selectElement.options[selectElement.selectedIndex];

				// Get the value of the data-info attribute of the selected option
				var data_buyer_po_number = selectedOption.getAttribute("data_buyer_po_number");
				var data_buyer_po_date = selectedOption.getAttribute("data_buyer_po_date");
				
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>get_preexport_item_details",
					type: "POST",
					data : {'part_number' : part_number,'main_export_id' : main_export_id,'buyer_po_id':buyer_po_id,'buyer_name_id':buyer_name_id,'data_buyer_po_number':data_buyer_po_number,'data_buyer_po_date':data_buyer_po_date},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$('#part_description').val('');
							$('#buyer_po_number').val('');
							$('#buyer_po_number_id').val('');
						}
						else
						{
							var data_part_details = jQuery.parseJSON( data );

							var buyer_po_number_with_original_po = data_part_details.sales_order_number +'-'+ data_part_details.buyer_po_number

							$('#part_description').val(data_part_details.name);
							$('#buyer_po_number').val(buyer_po_number_with_original_po);
							$('#buyer_po_number_id').val(data_part_details.buyer_po_number_id);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#part_description').val('');
						$('#buyer_po_number').val('');
						$('#buyer_po_number_id').val('');
					}
				});
				return false;

			});



			$(document).on('change','#part_number',function(e){  
				e.preventDefault();
				//$(".loader_ajax").show();
				// $("#customers-list").html('');
				var part_number = $('#part_number').val();
				var main_export_id = $('#main_export_id').val();
				var buyer_po_id = $('#buyer_po_id').val();
				var buyer_name_id = $('#buyer_name_id').val();
				
				var selectElement = document.getElementById("part_number");
				// Get the selected option element
				var selectedOption = selectElement.options[selectElement.selectedIndex];

				// Get the value of the data-info attribute of the selected option
				var data_buyer_po_number = selectedOption.getAttribute("data_buyer_po_number");
				var data_buyer_po_date = selectedOption.getAttribute("data_buyer_po_date");
				
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>get_preexport_item_details",
					type: "POST",
					data : {'part_number' : part_number,'main_export_id' : main_export_id,'buyer_po_id':buyer_po_id,'buyer_name_id':buyer_name_id,'data_buyer_po_number':data_buyer_po_number,'data_buyer_po_date':data_buyer_po_date},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$('#part_description').val('');
							$('#buyer_po_number').val('');
							$('#buyer_po_number_id').val('');
						}
						else
						{
							var data_part_details = jQuery.parseJSON( data );
							var buyer_po_number_with_original_po = data_part_details.sales_order_number +'-'+ data_part_details.buyer_po_number

							$('#part_description').val(data_part_details.name);
							$('#buyer_po_number').val(buyer_po_number_with_original_po);
							$('#buyer_po_number_id').val(data_part_details.buyer_po_number_id);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#part_description').val('');
						$('#buyer_po_number').val('');
						$('#buyer_po_number_id').val('');
					}
				});
				return false;
		    });

		    $(document).on('click','#savenewpreexportitemdetails',function(e){

				e.preventDefault();
				$(".loader_ajax").show();

				var main_export_id = $('#main_export_id').val();
				var preexportitemdetailsid = $('#preexportitemdetailsid').val();
				var formData = new FormData($("#savenewpreexportitemdetailsform")[0]);
				$.ajax({
					url : "<?php echo base_url();?>addpreexportitemdetails/"+main_export_id,
					type: "POST",
					data : formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data, textStatus, jqXHR)
					{
						var fetchResponse = $.parseJSON(data);
						if(fetchResponse.status == "failure")
						{
							$.each(fetchResponse.error, function (i, v)
							{
								$('.'+i+'_error').html(v);
							});
							$(".loader_ajax").hide();
						}
						else if(fetchResponse.status == 'success')
						{
							swal({
								title: "Success",
								text: "Pre-Export Item Details Successfully Added!",
								icon: "success",
								button: "Ok",
								},function(){ 
									
									window.location.href = "<?php echo base_url().'exportdetailsitemdetails/'?>"+main_export_id;
								
							});		
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$(".loader_ajax").hide();
					}
				});
				return false;
            });

			$(document).on('click','.deletepreexportitemdetails',function(e){
				var elemF = $(this);
				e.preventDefault();

				var pre_export_id = elemF.attr('data-id');

				swal({
					title: "Are you sure?",
					text: "Delete Pre-Export Item Details",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deletepreexportitemdetails",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "Pre-Export Item Details Succesfully Deleted",
												icon: "success",
												button: "Ok",
												},function(){ 
													window.location.href = "<?php echo base_url().'exportdetailsitemdetails/'?>"+pre_export_id;
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "Pre-Export Item Details deletion cancelled ", "error");
					}
				});
		    });

    </script>
<?php } ?>


<?php if($pageTitle=='Pre Export Item Attributes' || $pageTitle=='Pre Export Item Attributes Edit' || $pageTitle=='Pre Export Item Attributes add'){?>
	<script type="text/javascript"> 
	        $(document).ready(function() {
				var preexportitemdetailsid = $('#preexportitemdetailsid').val();
				var dt = $('#view_pre_export_item_details_attribute').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "8%", "targets": 0 },
						{ "width": "8%", "targets": 1 },
						{ "width": "8%", "targets": 2 },
						{ "width": "8%", "targets": 3 },
						{ "width": "8%", "targets": 4 },
						{ "width": "8%", "targets": 5 },
						{ "width": "5%", "targets": 6 },
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No Pre Export Item Attributes Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchpreexportitemdetailsattribute/"+preexportitemdetailsid,
						type: "post",
					},
				});
            });


			$(document).on('click','#addexportitemdetailswithattributesvalues',function(e){

				e.preventDefault();
				$(".loader_ajax").show();

				var main_export_id = $('#main_export_id').val();
				var preexportitemdetailsid = $('#preexportitemdetailsid').val();


				var pre_export_item_id = $('#pre_export_item_id').val();

				var formData = new FormData($("#addexportitemdetailswithattributesvaluesform")[0]);
				$.ajax({
					url : "<?php echo base_url();?>addexportitemdetailswithattributesvalues/"+preexportitemdetailsid,
					type: "POST",
					data : formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data, textStatus, jqXHR)
					{
						var fetchResponse = $.parseJSON(data);
						if(fetchResponse.status == "failure")
						{
							$.each(fetchResponse.error, function (i, v)
							{
								$('.'+i+'_error').html(v);
							});
							$(".loader_ajax").hide();
						}
						else if(fetchResponse.status == 'success')
						{
							swal({
								title: "Success",
								text: "Pre-Export Item Details Successfully Added!",
								icon: "success",
								button: "Ok",
								},function(){ 

									if(pre_export_item_id){
										window.location.href = "<?php echo base_url().'addexportitemdetailswithattributes/'?>"+pre_export_item_id;
									}else{
										window.location.href = "<?php echo base_url().'addexportitemdetailswithattributes/'?>"+preexportitemdetailsid;
									}
									
								
							});		
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$(".loader_ajax").hide();
					}
				});
				return false;
			});


			$(document).on('click','.deletepreexportitemattributes',function(e){
				var elemF = $(this);
				e.preventDefault();

				var pre_export_item_id = elemF.attr('pre_export_item_id');

				swal({
					title: "Are you sure?",
					text: "Delete Pre-Export Item Attributes",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deletepreexportitemattributes",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "Pre-Export Item Attributes Succesfully Deleted",
												icon: "success",
												button: "Ok",
												},function(){ 
													window.location.href = "<?php echo base_url().'addexportitemdetailswithattributes/'?>"+pre_export_item_id;
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "Pre-Export Item Attributes deletion cancelled ", "error");
					}
				});
		    });


			$(document).on('change', '#per_boc_pcs,#no_of_cartoons', function(){	

				if($("#per_boc_pcs").val() && $("#no_of_cartoons").val()){

					if($("#per_boc_pcs").val()){
						var per_boc_pcs = $("#per_boc_pcs").val();
					}else{
						var per_boc_pcs = 0;
					}

					if($("#no_of_cartoons").val()){
						var no_of_cartoons = $("#no_of_cartoons").val();
					}else{
						var no_of_cartoons = 0;
					}

					//var less_qty_rejected_qty = parseFloat(less_quantity) +  parseFloat(rejected_quantity);
					var total_qty = parseFloat(per_boc_pcs) *  parseFloat(no_of_cartoons);
	
					$("#total_qty").val(total_qty);

				}
				
		    });


			$(document).on('change', '#gross_per_box_weight,#no_of_cartoons', function(){	

				if($("#gross_per_box_weight").val() && $("#no_of_cartoons").val()){

					if($("#gross_per_box_weight").val()){
						var gross_per_box_weight = $("#gross_per_box_weight").val();
					}else{
						var gross_per_box_weight = 0;
					}

					if($("#no_of_cartoons").val()){
						var no_of_cartoons = $("#no_of_cartoons").val();
					}else{
						var no_of_cartoons = 0;
					}

					//var less_qty_rejected_qty = parseFloat(less_quantity) +  parseFloat(rejected_quantity);
					var total_gross_weight = parseFloat(gross_per_box_weight) *  parseFloat(no_of_cartoons);

					$("#total_gross_weight").val(total_gross_weight);

				}

			});


   </script>
<?php } ?>


<?php if($pageTitle=='CHA Master' || $pageTitle=='Add New CHA Master' || $pageTitle=='Edit CHA Master'){ ?>
<script type="text/javascript">
		$(document).ready(function() {
				var dt = $('#view_cha_master').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "10%", "targets": 0 },
						{ "width": "20%", "targets": 1 },
						{ "width": "10%", "targets": 2 },
						{ "width": "8%", "targets": 3 },
						{ "width": "10%", "targets": 4 },
						{ "width": "10%", "targets": 5 },
						{ "width": "5%", "targets": 6 },
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No CHA Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchCHA",
						type: "post",
					},
				});
		});

		$(document).on('click','#savenewcha',function(e){
				e.preventDefault();
				$(".loader_ajax").show();
				var formData = new FormData($("#addnewchaform")[0]);

				$.ajax({
					url : "<?php echo base_url();?>addnewCha",
					type: "POST",
					data : formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data, textStatus, jqXHR)
					{
						var fetchResponse = $.parseJSON(data);
						if(fetchResponse.status == "failure")
						{
							$.each(fetchResponse.error, function (i, v)
							{
								$('.'+i+'_error').html(v);
							});
							$(".loader_ajax").hide();
						}
						else if(fetchResponse.status == 'success')
						{
							swal({
								title: "Success",
								text: "CHA Successfully Added!",
								icon: "success",
								button: "Ok",
								},function(){ 
									window.location.href = "<?php echo base_url().'chamaster'?>";
							});		
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
					$(".loader_ajax").hide();
					}
				});
				return false;
		});

		$(document).on('click','#updatecha',function(e){
				e.preventDefault();
				$(".loader_ajax").show();
				var formData = new FormData($("#updatechaform")[0]);
				var cha_id = $("#cha_id").val();
				$.ajax({
					url : "<?php echo base_url();?>updatecha/"+cha_id,
					type: "POST",
					data : formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data, textStatus, jqXHR)
					{
						var fetchResponse = $.parseJSON(data);
						if(fetchResponse.status == "failure")
						{
							$.each(fetchResponse.error, function (i, v)
							{
								$('.'+i+'_error').html(v);
							});
							$(".loader_ajax").hide();
						}
						else if(fetchResponse.status == 'success')
						{
							swal({
								title: "Success",
								text: "CHA Successfully Updated!",
								icon: "success",
								button: "Ok",
								},function(){ 
									window.location.href = "<?php echo base_url().'chamaster'?>";
							});		
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
					$(".loader_ajax").hide();
					}
				});
				return false;
		});

		$(document).on('click','.deletecha',function(e){
			var elemF = $(this);
			e.preventDefault();

			swal({
				title: "Are you sure?",
				text: "Delete Vendor",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deletecha",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "CHA Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'chamaster'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "CHA deletion cancelled ", "error");
				}
			});
		});
</script>
<?php } ?>



<?php if($pageTitle=='Sales Tracking Report' || $pageTitle=='Add New Sales Tracking Report' || $pageTitle=='Edit Tracking Report' || $pageTitle=='Add Sales Tracking Report'){ ?>
    <script type="text/javascript">
		$(document).ready(function() {
				var dt = $('#view_sales_tracking_report').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "10%", "targets": 0 },
						{ "width": "10%", "targets": 1 },
						{ "width": "10%", "targets": 2 },
						{ "width": "10%", "targets": 3 },
						{ "width": "8%", "targets": 4 },
						{ "width": "8%", "targets": 5 },
						{ "width": "8%", "targets": 6 },
						{ "width": "8%", "targets": 7 },
						{ "width": "10%", "targets": 8 },
						{ "width": "8%", "targets": 9 },
						{ "width": "15%", "targets": 10},
						// { "width": "15%", "targets": 11},
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No Seles Tracking Report Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchsalestrackingReport",
						type: "post",
					},
				});
		});

		$(document).ready(function() {
			var invoice_number = $('#invoice_number').val();
            $.ajax({
				url : "<?php echo ADMIN_PATH;?>getinvoicedetilsbyinvoiceid",
				type: "POST",
				data : {'invoice_number' : invoice_number},
					success: function(data, textStatus, jqXHR)
					{
					    var get_buyerdata = jQuery.parseJSON( data );

						$(".loader_ajax").hide();
							if(data == "failure")
								{
									$('#invoice_date').val('');
									$('#buyer_name').val('');
									$('#buyer_address').val('');	
									$('#invoice_currency').val('');		
									$('#buyer_PO').val('');		
								}
								else
									{
											$('#invoice_date').val(get_buyerdata.buyer_invoice_date);
											$('#buyer_name').val(get_buyerdata.buyer_name);	
											$('#buyer_address').val(get_buyerdata.address);	
											$('#invoice_currency').val(get_buyerdata.currency);	
											$('#buyer_PO').val(get_buyerdata.sales_order_number);	
									}
								    },
									error: function (jqXHR, textStatus, errorThrown)
										{
											$('#invoice_date').val('');
											$('#buyer_name').val('');	
											$('#buyer_address').val('');
											$('#invoice_currency').val('');		
											$('#buyer_PO').val('');		
											
										}
									});
				 return false;
		});

		$(document).ready(function() {

			var get_numberofcartoons = $('.get_numberofcartoons').val();
            $.ajax({
				url : "<?php echo ADMIN_PATH;?>getnumberofcartoonsfrompreexport",
				type: "POST",
				data : {'get_numberofcartoons' : get_numberofcartoons},
					success: function(data, textStatus, jqXHR)
					{
					    var get_buyerdata = jQuery.parseJSON( data );

						$(".loader_ajax").hide();
							if(data == "failure")
								{
									    $('#no_of_ctns').val('');
								}
								else
									{
										$('#no_of_ctns').val(get_buyerdata.total_no_of_carttons);
									}
								    },
									error: function (jqXHR, textStatus, errorThrown)
										{
										  $('#no_of_ctns').val('');
										}
									});
				 return false;

        });

		$(document).ready(function() {

			var credit_note_number = $('#credit_note_number').val();
            $.ajax({
				url : "<?php echo ADMIN_PATH;?>getcreditnotedetailsbycreditnoteid",
				type: "POST",
				data : {'credit_note_number' : credit_note_number},
					success: function(data, textStatus, jqXHR)
					{
					    var get_buyerdata = jQuery.parseJSON( data );

						$(".loader_ajax").hide();
							if(data == "failure")
								{
									$('#credit_note_date').val('');
									$('#receivable_amt').val('');
									$('#difference').val('');	
									$('#credit_note_reason').val('');		
								}
								else
									{
											$('#credit_note_date').val(get_buyerdata.date);
											$('#receivable_amt').val(get_buyerdata.recivable_amount);	
											$('#difference').val(get_buyerdata.diff_credite_note_value);	
											$('#credit_note_reason').val(get_buyerdata.credite_note_remark);	
									}
								    },
									error: function (jqXHR, textStatus, errorThrown)
										{
											$('#credit_note_date').val('');
											$('#receivable_amt').val('');	
											$('#difference').val('');
											$('#credit_note_reason').val('');		
											
										}
									});
				 return false;

		});


		$(document).on('click','#savenewsalestracking',function(e){
				e.preventDefault();
				$(".loader_ajax").show();
				var formData = new FormData($("#addsalestrackingreport")[0]);
			
				$.ajax({
					url : "<?php echo base_url();?>addsalestrackingreport",
					type: "POST",
					data : formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data, textStatus, jqXHR)
					{
						var fetchResponse = $.parseJSON(data);
						if(fetchResponse.status == "failure")
						{
							$.each(fetchResponse.error, function (i, v)
							{
								$('.'+i+'_error').html(v);
							});
							$(".loader_ajax").hide();
						}
						else if(fetchResponse.status == 'success')
						{
							swal({
								title: "Success",
								text: "Sales Tracking Report Successfully Added!",
								icon: "success",
								button: "Ok",
								},function(){ 
									window.location.href = "<?php echo base_url().'salestrackingreport'?>";
							});		
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
					$(".loader_ajax").hide();
					}
				});
				return false;
		});

		$(document).on('click','#updatecha',function(e){
				e.preventDefault();
				$(".loader_ajax").show();
				var formData = new FormData($("#updatechaform")[0]);
				var cha_id = $("#cha_id").val();
				$.ajax({
					url : "<?php echo base_url();?>updatecha/"+cha_id,
					type: "POST",
					data : formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data, textStatus, jqXHR)
					{
						var fetchResponse = $.parseJSON(data);
						if(fetchResponse.status == "failure")
						{
							$.each(fetchResponse.error, function (i, v)
							{
								$('.'+i+'_error').html(v);
							});
							$(".loader_ajax").hide();
						}
						else if(fetchResponse.status == 'success')
						{
							swal({
								title: "Success",
								text: "CHA Successfully Updated!",
								icon: "success",
								button: "Ok",
								},function(){ 
									window.location.href = "<?php echo base_url().'chamaster'?>";
							});		
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
					$(".loader_ajax").hide();
					}
				});
				return false;
		});

		$(document).on('click','.deletesalestracking',function(e){
			var elemF = $(this);
			e.preventDefault();

			swal({
				title: "Are you sure?",
				text: "Delete Vendor",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deletesalestracking",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Sales Tracking Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'salestrackingreport'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Sales Tracking deletion cancelled ", "error");
				}
			});
		});

        $(document).on('change','#invoice_number',function(e){  
			e.preventDefault();
			var invoice_number = $('#invoice_number').val();
            $.ajax({
				url : "<?php echo ADMIN_PATH;?>getinvoicedetilsbyinvoiceid",
				type: "POST",
				data : {'invoice_number' : invoice_number},
					success: function(data, textStatus, jqXHR)
					{
					    var get_buyerdata = jQuery.parseJSON( data );

						$(".loader_ajax").hide();
							if(data == "failure")
								{
									$('#invoice_date').val('');
									$('#buyer_name').val('');
									$('#buyer_address').val('');	
									$('#invoice_currency').val('');		
									$('#buyer_PO').val('');		
								}
								else
									{
											$('#invoice_date').val(get_buyerdata.buyer_invoice_date);
											$('#buyer_name').val(get_buyerdata.buyer_name);	
											$('#buyer_address').val(get_buyerdata.address);	
											$('#invoice_currency').val(get_buyerdata.currency);	
											$('#buyer_PO').val(get_buyerdata.sales_order_number);	
									}
								    },
									error: function (jqXHR, textStatus, errorThrown)
										{
											$('#invoice_date').val('');
											$('#buyer_name').val('');	
											$('#buyer_address').val('');
											$('#invoice_currency').val('');		
											$('#buyer_PO').val('');		
											
										}
				});
			return false;
	    });		

		$(document).on('change','#credit_note_number',function(e){  
			e.preventDefault();
			var credit_note_number = $('#credit_note_number').val();
            $.ajax({
				url : "<?php echo ADMIN_PATH;?>getcreditnotedetailsbycreditnoteid",
				type: "POST",
				data : {'credit_note_number' : credit_note_number},
					success: function(data, textStatus, jqXHR)
					{
					    var get_buyerdata = jQuery.parseJSON( data );

						$(".loader_ajax").hide();
							if(data == "failure")
								{
									$('#credit_note_date').val('');
									$('#receivable_amt').val('');
									$('#difference').val('');	
									$('#credit_note_reason').val('');		
								}
								else
									{
											$('#credit_note_date').val(get_buyerdata.date);
											$('#receivable_amt').val(get_buyerdata.recivable_amount);	
											$('#difference').val(get_buyerdata.diff_credite_note_value);	
											$('#credit_note_reason').val(get_buyerdata.credite_note_remark);	
									}
								    },
									error: function (jqXHR, textStatus, errorThrown)
										{
											$('#credit_note_date').val('');
											$('#receivable_amt').val('');	
											$('#difference').val('');
											$('#credit_note_reason').val('');		
											
										}
									});
				 return false;
	    });

		$(document).on('change','#debit_note_number',function(e){  
			e.preventDefault();
			var debit_note_number = $('#debit_note_number').val();
            $.ajax({
				url : "<?php echo ADMIN_PATH;?>getdebitnotedetailsbydebitenoteeid",
				type: "POST",
				data : {'debit_note_number' : debit_note_number},
					success: function(data, textStatus, jqXHR)
					{
					    var get_buyerdata = jQuery.parseJSON( data );

						$(".loader_ajax").hide();
							if(data == "failure")
								{
										$('#debit_note_date').val('');
										$('#difference_debit_note_amt').val('');
										$('#receivable_amt_debit').val('');	
										$('#debit_amount_reason').val('');	
										
								}
								else
									{
										$('#debit_note_date').val(get_buyerdata.cha_debit_note_date);
										$('#receivable_amt_debit').val(get_buyerdata.bill_amount);	
										$('#difference_debit_note_amt').val(get_buyerdata.debit_amount);	
										$('#debit_amount_reason').val(get_buyerdata.subject);	
											
									}
								    },
									error: function (jqXHR, textStatus, errorThrown)
										{
										  $('#debit_note_date').val('');
										  $('#difference_debit_note_amt').val('');	
										  $('#debit_amount_reason').val('');
										}
									});
				 return false;
	    });

		$(document).on('change', '#inv_amount,#brc_value', function(){	
				
			    $("#foreign_bank_charges").val();

				 if($("#inv_amount").val()){
					 var inv_amount = $("#inv_amount").val();
				 }else{
					 var inv_amount = 0;
				 }

				 if($("#brc_value").val()){
					 var brc_value = $("#brc_value").val();
				 }else{
					 var brc_value = 0;
				 }

				 
				 var total_one_group = parseFloat(inv_amount) -  parseFloat(brc_value);

				 $("#foreign_bank_charges").val(total_one_group);
			
		});

		$(document).on('change', '#payment_exchange_amt,#foreign_bank_charges', function(){	
				
			    $("#foreign_bank_charges_in_inr").val();

				 if($("#payment_exchange_amt").val()){
					 var payment_exchange_amt = $("#payment_exchange_amt").val();
				 }else{
					 var payment_exchange_amt = 0;
				 }

				 if($("#foreign_bank_charges").val()){
					 var foreign_bank_charges = $("#foreign_bank_charges").val();
				 }else{
					 var foreign_bank_charges = 0;
				 }

				 
				 var total_one_group = parseFloat(payment_exchange_amt) *  parseFloat(foreign_bank_charges);

				 $("#foreign_bank_charges_in_inr").val(total_one_group);
			
		});

        $(document).on('change','.get_numberofcartoons',function(e){  
			e.preventDefault();
			var get_numberofcartoons = $('.get_numberofcartoons').val();
            $.ajax({
				url : "<?php echo ADMIN_PATH;?>getnumberofcartoonsfrompreexport",
				type: "POST",
				data : {'get_numberofcartoons' : get_numberofcartoons},
					success: function(data, textStatus, jqXHR)
					{
					    var get_buyerdata = jQuery.parseJSON( data );

						$(".loader_ajax").hide();
							if(data == "failure")
								{
									    $('#no_of_ctns').val('');
								}
								else
									{
										$('#no_of_ctns').val(get_buyerdata.total_no_of_carttons);
									}
								    },
									error: function (jqXHR, textStatus, errorThrown)
										{
										  $('#no_of_ctns').val('');
										}
									});
				 return false;
	    });	
		
		$(document).on('change', '#payment_rcivd_amt,#payment_exchange_amt', function(){	
				
			    $("#payment_rcivd_amt").val();
				$("#payment_exchange_amt").val();

				 if($("#payment_rcivd_amt").val()){
					 var payment_rcivd_amt = $("#payment_rcivd_amt").val();
				 }else{
					 var payment_rcivd_amt = 0;
				 }

				 if($("#payment_exchange_amt").val()){
					 var payment_exchange_amt = $("#payment_exchange_amt").val();
				 }else{
					 var payment_exchange_amt = 0;
				 }

				 var total_one_group = parseFloat(payment_rcivd_amt) *  parseFloat(payment_exchange_amt);

				 $("#realised_amt_in_inr").val(total_one_group);
			
		});
	
    </script>
<?php } ?>


<?php if($pageTitle=='Add CHA Debit note' || $pageTitle=='CHA Debit Note' || $pageTitle=='Edit CHA Debit Note' ){ ?>
	<script type="text/javascript">

            $(document).ready(function() {
				var dt = $('#view_chatdebitnote').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "10%", "targets": 0 },
						{ "width": "10%", "targets": 1 },
						{ "width": "10%", "targets": 2 },
						{ "width": "2%", "targets": 3 },
						{ "width": "2%", "targets": 4 },
						{ "width": "6%", "targets": 5 },
					
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No CHA Debit Note Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchadebitnote",
						type: "post",
					},
				});
		    });

	        $(document).on('click','#savechadebitnote',function(e){
				e.preventDefault();
				$(".loader_ajax").show();
				var formData = new FormData($("#savechadebitnoteform")[0]);

			    var cha_debit_note_id = $("#cha_debit_note_id").val();

				var AWB_No = $("#AWB_No").val();

                if(AWB_No){
					$.ajax({
						url : "<?php echo base_url();?>addchadebitnote",
						type: "POST",
						data : formData,
						cache: false,
						contentType: false,
						processData: false,
						success: function(data, textStatus, jqXHR)
						{
							var fetchResponse = $.parseJSON(data);
							if(fetchResponse.status == "failure")
							{
								$.each(fetchResponse.error, function (i, v)
								{
									$('.'+i+'_error').html(v);
								});
								$(".loader_ajax").hide();
							}
							else if(fetchResponse.status == 'success')
							{
								swal({
									title: "Success",
									text: "CHA Debit Note Successfully Added!",
									icon: "success",
									button: "Ok",
									},function(){ 
										
										window.location.href = "<?php echo base_url().'chadebitnote'?>";
								});		
							}
							
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
						$(".loader_ajax").hide();
						}
					});
					return false;

			    }else{
					$(".loader_ajax").hide();
					alert('AWB No is Required');
					return false;
				}


		    });


		$(document).on('click','.deletechadebitnote',function(e){
				var elemF = $(this);
				e.preventDefault();

				swal({
					title: "Are you sure?",
					text: "Delete CHA Debit Note",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deletechadebitnote",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "CHA Debit Note Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'chadebitnote'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "CHA Debit Note deletion cancelled ", "error");
				}
			});
		});


		$(document).on('change', '#taxable_amount,#cgst_sgst', function(){	
				
			    $("#taxable_amount").val();
				$("#cgst_sgst").val();

				 if($("#taxable_amount").val()){
					 var taxable_amount = $("#taxable_amount").val();
				 }else{
					 var taxable_amount = 0;
				 }

				 if($("#cgst_sgst").val()){
					 var cgst_sgst = $("#cgst_sgst").val();
				 }else{
					 var cgst_sgst = 0;
				 }

				 var total_one_group = parseFloat(taxable_amount) +  parseFloat(cgst_sgst);

				 $("#bill_amount").val(total_one_group);
		});


		$(document).on('change', '.debit_amount_total', function(){	
				
			    $("#bill_amount").val();
				$(".debit_amount_total").val();

				 if($("#bill_amount").val()){
					 var bill_amount = $("#bill_amount").val();
				 }else{
					 var bill_amount = 0;
				 }

				 if($(".debit_amount_total").val()){
					 var debit_amount = $(".debit_amount_total").val();
				 }else{
					 var debit_amount = 0;
				 }

				 var total_one_groupq= parseFloat(bill_amount) -  parseFloat(debit_amount);

				 $("#amount_payable_before_tds").val(total_one_groupq);
			
		});


		$(document).on('change', '#less_tdsss', function(){	

			    $("#amount_payable_before_tds").val();
				$("#less_tdsss").val();

				 if($("#amount_payable_before_tds").val()){
					 var amount_payable_before_tds = $("#amount_payable_before_tds").val();
				 }else{
					 var amount_payable_before_tds = 0;
				 }

				 if($("#less_tdsss").val()){
					 var less_tds = $("#less_tdsss").val();
				 }else{
					 var less_tds = 0;
				 }

				 var total_one_group = parseFloat(amount_payable_before_tds) -  parseFloat(less_tds);

				 $("#payable_amount").val(total_one_group);
		});


</script>
<?php } ?>


<?php if($pageTitle=='Scrap Calculation Report'){ ?>

<script type="text/javascript">
  
	$(document).ready(function() {
		$("#view_scrap_calculation_report").dataTable().fnDestroy();
		var status = $('#status').val();
		var vendor_name = $('#vendor_name').val();
		getallCurrentOrserReport(status,vendor_name);
	});

	$(document).on('change','#status',function(e){  
		e.preventDefault();
		$("#view_scrap_calculation_report").dataTable().fnDestroy();
		var status = $('#status').val();
		var vendor_name = $('#vendor_name').val();
		getallCurrentOrserReport(status,vendor_name);
	});


	$(document).on('change','#vendor_name',function(e){  
		e.preventDefault();
		$("#view_scrap_calculation_report").dataTable().fnDestroy();
		var status = $('#status').val();
		var vendor_name = $('#vendor_name').val();
		getallCurrentOrserReport(status,vendor_name);
	});

	function getallCurrentOrserReport(status,vendor_name){

			var dt = $('#view_scrap_calculation_report').DataTable({
				"columnDefs": [ 
					{ className: "details-control", "targets": [ 0 ] },
					{ "width": "10%", "targets": 0 },
					{ "width": "10%", "targets": 1 },
					{ "width": "10%", "targets": 2 },
					{ "width": "10%", "targets": 3 },
					{ "width": "10%", "targets": 4 },
					{ "width": "10%", "targets": 5 },
					{ "width": "10%", "targets": 6 },
					{ "width": "10%", "targets": 7 },
				],
				responsive: true,
				"oLanguage": {
					"sEmptyTable": "<i>No Scrap Calculation Records Found.</i>",
				}, 
				"bSort" : false,
				"bFilter":true,
				"bLengthChange": true,
				"iDisplayLength": 10,   
				"bProcessing": true,
				"serverSide": true,
				"ajax":{
					url :"<?php echo base_url();?>admin/fetchscrapcalculationreport/"+status+"/"+vendor_name,
					type: "post",
				},
			});

	}
	
	$(document).on('click','#export_to_excel',function(e){
		e.preventDefault();
		$(".loader_ajax").show();
		var status         =    $("#status").val();

		if(status){
			var status_value = status;
		}else{

			var status_value = 'NA';
		}


		var vendor_name         =    $("#vendor_name").val();

		if(vendor_name){
			var vendor_name_value = vendor_name;
		}else{

			var vendor_name_value = 'NA';
		}

		$.ajax({
			url : "<?php echo ADMIN_PATH;?>admin/downlaod_scrap_calculation_report/"+status_value+"/"+vendor_name_value,
			type: "POST",
			// data : {'hospitals' : hospitals, 'driver' : driver,'ride_start':ride_start,'ride_stop':ride_stop},
			success: function(data, textStatus, jqXHR)
			{
				$(".loader_ajax").hide();
				if(data == "failure")
				{
					$(".report_type_error").html("");
					alert('No data fond');
				}
				else
				{
					$(".report_type_error").html("");
					window.location.href = "<?php echo ADMIN_PATH;?>admin/downlaod_scrap_calculation_report/"+status_value+"/"+vendor_name_value;
				}
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				   alert('No data fond');
				$(".loader_ajax").hide();
			}
		});
	   return false;
	});

</script>  
<?php } ?>

<?php if($pageTitle=='Production Status Report'){ ?>
<script type="text/javascript">
  
	$(document).ready(function() {
		$("#view_production_status_report").dataTable().fnDestroy();
		var vendor_po = $('#vendor_po').val();
		var part_number = $('#part_number').val();
		var vendor_name = $('#vendor_name').val();
		var status = $('#status').val();
		getallProductionstatusreport($("#vendor_name").val(), $("#status").val(),$("#part_number").val(),$("#vendor_po").val());
	});

	$(document).on('change','#vendor_name',function(e){  
		$("#view_production_status_report").dataTable().fnDestroy();
			e.preventDefault();
			var vendor_po = $('#vendor_po').val();
    		var part_number = $('#part_number').val();
			var vendor_name = $('#vendor_name').val();
			var status = $('#status').val();
			getallProductionstatusreport($("#vendor_name").val(), $("#status").val(),$("#part_number").val(),$("#vendor_po").val());
	});

	$(document).on('change','#status',function(e){  
		$("#view_production_status_report").dataTable().fnDestroy();
		e.preventDefault();
			var vendor_po = $('#vendor_po').val();
			var part_number = $('#part_number').val();
			var vendor_name = $('#vendor_name').val();
			var status = $('#status').val();
		getallProductionstatusreport($("#vendor_name").val(), $("#status").val(),$("#part_number").val(),$("#vendor_po").val());
	});

	$(document).on('change','#part_number',function(e){  
		$("#view_production_status_report").dataTable().fnDestroy();
			e.preventDefault();
 			var vendor_po = $('#vendor_po').val();
    		var part_number = $('#part_number').val();
			var vendor_name = $('#vendor_name').val();
			var status = $('#status').val();
			getallProductionstatusreport($("#vendor_name").val(), $("#status").val(),$("#part_number").val(),$("#vendor_po").val());
	});

	$(document).on('change','#vendor_po',function(e){  
		$("#view_production_status_report").dataTable().fnDestroy();
		e.preventDefault();
			var vendor_po = $('#vendor_po').val();
			var part_number = $('#part_number').val();
			var vendor_name = $('#vendor_name').val();
			var status = $('#status').val();
		getallProductionstatusreport($("#vendor_name").val(), $("#status").val(),$("#part_number").val(),$("#vendor_po").val());
	});

	function getallProductionstatusreport(vendor_name,status,part_number,vendor_po){

			var dt = $('#view_production_status_report').DataTable({
				"columnDefs": [ 
					{ className: "details-control", "targets": [ 0 ] },
					{ "width": "10%", "targets": 0 },
					{ "width": "10%", "targets": 1 },
					{ "width": "10%", "targets": 2 },
					{ "width": "10%", "targets": 3 },
					{ "width": "10%", "targets": 4 },
					{ "width": "10%", "targets": 5 },
					{ "width": "10%", "targets": 6 },
					{ "width": "10%", "targets": 7 },
					{ "width": "10%", "targets": 8 },
					{ "width": "10%", "targets": 9 },
					{ "width": "10%", "targets": 10 },
					{ "width": "10%", "targets": 11 },
					{ "width": "10%", "targets": 12 },
				],
				responsive: true,
				"oLanguage": {
					"sEmptyTable": "<i>No Production Status Found.</i>",
				}, 
				"bSort" : false,
				"bFilter":true,
				"bLengthChange": true,
				"iDisplayLength": 10,   
				"bProcessing": true,
				"serverSide": true,
				"ajax":{
					url :"<?php echo base_url();?>admin/fetchproductionstatusreport/"+vendor_name+"/"+status+"/"+part_number+"/"+vendor_po,
					type: "post",
				},
			});

	}
	
	$(document).on('click','#export_to_excel',function(e){
		e.preventDefault();
		$(".loader_ajax").show();
		var vendor_name       =    $('#vendor_name').val();
		var status         =       $("#status").val();
		var vendor_po       =        $('#vendor_po').val();
		var part_number         =    $("#part_number").val();

		if(vendor_name){
			var vendor_name_value = vendor_name;
		}else{
			var vendor_name_value = 'NA';
		}

		if(status){
			var status_value = status;
		}else{
			var status_value = 'NA';
		}

		if(vendor_po){
			var vendor_po_number = vendor_po;
		}else{
			var vendor_po_number = 'NA';
		}

		if(part_number){
			var part_number_id = part_number;
		}else{
			var part_number_id = 'NA';
		}

		$.ajax({
			url : "<?php echo ADMIN_PATH;?>admin/downlaod_production_status_report/"+vendor_name_value+"/"+status_value+"/"+vendor_po_number+"/"+part_number_id,
			type: "POST",
			// data : {'hospitals' : hospitals, 'driver' : driver,'ride_start':ride_start,'ride_stop':ride_stop},
			success: function(data, textStatus, jqXHR)
			{
				$(".loader_ajax").hide();
				if(data == "failure")
				{
					$(".report_type_error").html("");
					alert('No data fond');
				}
				else
				{
					$(".report_type_error").html("");
					window.location.href = "<?php echo ADMIN_PATH;?>admin/downlaod_production_status_report/"+vendor_name_value+"/"+status_value+"/"+vendor_po_number+"/"+part_number_id;
				}
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				   alert('No data fond');
				   $(".loader_ajax").hide();
			}
		});
	   return false;
	});

	$(document).on('click','.addnotes',function(e){
		var elemF = $(this);
	    e.preventDefault();
		$.ajax({
			url : "<?php echo ADMIN_PATH;?>getpreviousaddednotesfordisplay",
			type: "POST",
			data : {'id' : elemF.attr('data-id'),'flag' : elemF.attr('flag')},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
						{
							$('#notes').val('');
							$('#notes_id').val('');
							$('#flag').val('');
							$('#addnotes').modal('hide');
						}
						else
						{
							var notedata = jQuery.parseJSON( data );
							$('#notes').val(notedata.notes);
							$('#notes_id').val(notedata.id);
							$('#flag').val(notedata.flag);
							$('#addnotes').modal('show');
					    }
				},
				error: function (jqXHR, textStatus, errorThrown)
					{
							$('#notes').val('');
							$('#notes_id').val('');
							$('#flag').val('');
							$('#addnotes').modal('hide');
					}
		});
	});

	$(document).on('click','#close',function(e){
		window.location.reload();
	});

	$(document).on('click','#savebillofmaterialnotes',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			
				var notes_id = $('#notes_id').val();
				var notes = $('#notes').val();
				var flag = $('#flag').val();

				$.ajax({
					url : "<?php echo base_url();?>savebillofmaterialnotes",
					type: "POST",
					data : {'notes_id':notes_id,'notes':notes,'flag':flag},
					success: function(data, textStatus, jqXHR)
					{
						var fetchResponse = $.parseJSON(data);
						if(fetchResponse.status == "failure")
						{
							$.each(fetchResponse.error, function (i, v)
							{
								$('.'+i+'_error').html(v);
							});
							//$(".loader_ajax").hide();
						}
						else if(fetchResponse.status == 'success')
						{
							swal({
								title: "Success",
								text: "Notes Added Successfully!",
								icon: "success",
								button: "Ok",
								},function(){ 
									$('#addnotes').modal('hide');
									window.location.href = "<?php echo base_url().'productionstatusreport'?>";
							});		
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
					  //$(".loader_ajax").hide();
					}
				});
				return false;
	});

</script>  
<?php } ?>

<?php if($pageTitle=='Supplier PO Confirmation Report'){ ?>
	<script type="text/javascript">

    $(document).ready(function() {
		$("#view_supplier_po_report").dataTable().fnDestroy();
		var supplier_name = $('#supplier_name').val();
		var supplier_po = $('#supplier_po').val();
		var material_sent = $('#material_sent').val();
		var materila_recipt_confirmation = $('#materila_recipt_confirmation').val();
		getallsupplierporeport(supplier_name,supplier_po,material_sent,materila_recipt_confirmation);
	});


	$(document).on('change','#supplier_name',function(e){  
		$("#view_supplier_po_report").dataTable().fnDestroy();
		e.preventDefault();
		var supplier_name = $('#supplier_name').val();
		var supplier_po = $('#supplier_po').val();
		var material_sent = $('#material_sent').val();
		var materila_recipt_confirmation = $('#materila_recipt_confirmation').val();
		getallsupplierporeport(supplier_name,supplier_po,material_sent,materila_recipt_confirmation);
	});

	$(document).on('change','#supplier_po',function(e){  
		$("#view_supplier_po_report").dataTable().fnDestroy();
		e.preventDefault();	
		var supplier_name = $('#supplier_name').val();
		var supplier_po = $('#supplier_po').val();
		var material_sent = $('#material_sent').val();
		var materila_recipt_confirmation = $('#materila_recipt_confirmation').val();
		getallsupplierporeport(supplier_name,supplier_po,material_sent,materila_recipt_confirmation);
	});

	$(document).on('change','#material_sent',function(e){  
		$("#view_supplier_po_report").dataTable().fnDestroy();
		e.preventDefault();
		var supplier_name = $('#supplier_name').val();
		var supplier_po = $('#supplier_po').val();
		var material_sent = $('#material_sent').val();
		var materila_recipt_confirmation = $('#materila_recipt_confirmation').val();
		getallsupplierporeport(supplier_name,supplier_po,material_sent,materila_recipt_confirmation);
	});

	$(document).on('change','#materila_recipt_confirmation',function(e){  
		$("#view_supplier_po_report").dataTable().fnDestroy();
		e.preventDefault();	
		var supplier_name = $('#supplier_name').val();
		var supplier_po = $('#supplier_po').val();
		var material_sent = $('#material_sent').val();
		var materila_recipt_confirmation = $('#materila_recipt_confirmation').val();
		getallsupplierporeport(supplier_name,supplier_po,material_sent,materila_recipt_confirmation);
	});

    function getallsupplierporeport(supplier_name,supplier_po,material_sent,materila_recipt_confirmation){

		var dt = $('#view_supplier_po_report').DataTable({
			"columnDefs": [ 
				{ className: "details-control", "targets": [ 0 ] },
				{ "width": "10%", "targets": 0 },
				{ "width": "10%", "targets": 1 },
				{ "width": "10%", "targets": 2 },
				{ "width": "10%", "targets": 3 },
				{ "width": "10%", "targets": 4 },
				{ "width": "10%", "targets": 5 },
				{ "width": "10%", "targets": 6 },
				{ "width": "10%", "targets": 7 },
				{ "width": "10%", "targets": 8 },
				{ "width": "10%", "targets": 9 },
				{ "width": "10%", "targets": 10 },
			],
			responsive: true,
			"oLanguage": {
				"sEmptyTable": "<i>No Production Status Found.</i>",
			}, 
			"bSort" : false,
			"bFilter":true,
			"bLengthChange": true,
			"iDisplayLength": 10,   
			"bProcessing": true,
			"serverSide": true,
			"ajax":{
				url :"<?php echo base_url();?>admin/fetchsupplierporeport/"+supplier_name+"/"+supplier_po+"/"+material_sent+"/"+materila_recipt_confirmation,
				type: "post",
			},
		});
	}

	$(document).on('click','#export_to_excel_supplier_po',function(e){
		e.preventDefault();
		$(".loader_ajax").show();
		var supplier_name = $('#supplier_name').val();
		var supplier_po = $('#supplier_po').val();
		var material_sent = $('#material_sent').val();
		var materila_recipt_confirmation = $('#materila_recipt_confirmation').val();


		$.ajax({
			url : "<?php echo ADMIN_PATH;?>admin/downlaod_supplier_po_details_report/"+supplier_name+"/"+supplier_po+"/"+material_sent+"/"+materila_recipt_confirmation,
			type: "POST",
			// data : {'hospitals' : hospitals, 'driver' : driver,'ride_start':ride_start,'ride_stop':ride_stop},
			success: function(data, textStatus, jqXHR)
			{
				$(".loader_ajax").hide();
				if(data == "failure")
				{
					$(".report_type_error").html("");
					alert('No data fond');
				}
				else
				{
					$(".report_type_error").html("");
					window.location.href = "<?php echo ADMIN_PATH;?>admin/downlaod_supplier_po_details_report/"+supplier_name+"/"+supplier_po+"/"+material_sent+"/"+materila_recipt_confirmation;
				}
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				   alert('No data fond');
				   $(".loader_ajax").hide();
			}
		});
	   return false;
	});

    </script>  
<?php } ?>

<?php if($pageTitle=='Payment Details Report'){ ?>
	<script type="text/javascript">
		$(document).ready(function() {
      		var vendor_name = $('#vendor_name_id').val();
			var supplier_name =$('#supplier_name_id').val();
			var payment_details_no = $('#payment_details_no').val();
			var status = $('#status').val();
			getallPatmentdetailsreport(vendor_name,supplier_name,payment_details_no,status);
	    });

		$(document).on('change','#vendor_supplier_name',function(e){  
			var vendor_supplier_name = $('#vendor_supplier_name').val();
			if(vendor_supplier_name=='Vendor'){
                 $('#vendor_name_div').css('display','block');
				 $('#supplier_name_div').css('display','none');
				 $('#supplier_name_div').val('');
			}
			if(vendor_supplier_name=='Supplier'){
				$('#supplier_name_div').css('display','block');
				$('#vendor_name_div').css('display','none');
				$('#vendor_name_div').val('');

            }
		});

		$(document).on('change','#vendor_name_id',function(e){  
			    $("#view_payment_details_report").dataTable().fnDestroy();
				var vendor_name = $('#vendor_name_id').val();
				var supplier_name ='NA';
				var payment_details_no = $('#payment_details_no').val();
				var status = $('#status').val();
				getallPatmentdetailsreport(vendor_name,supplier_name,payment_details_no,status);
		});

		$(document).on('change','#supplier_name_id',function(e){  
			    $("#view_payment_details_report").dataTable().fnDestroy();
				
				var vendor_name = 'NA';
				var supplier_name =$('#supplier_name_id').val();
				var payment_details_no = $('#payment_details_no').val();
				var status = $('#status').val();
				getallPatmentdetailsreport(vendor_name,supplier_name,payment_details_no,status);
		});

		$(document).on('change','#payment_details_no',function(e){  
			    $("#view_payment_details_report").dataTable().fnDestroy();
				var vendor_name = $('#vendor_name_id').val();
				var supplier_name =$('#supplier_name_id').val();
			
				var payment_details_no = $('#payment_details_no').val();
				var status = $('#status').val();
				getallPatmentdetailsreport(vendor_name,supplier_name,payment_details_no,status);
		});
		
		$(document).on('change','#status',function(e){  
			    $("#view_payment_details_report").dataTable().fnDestroy();
				var vendor_name = $('#vendor_name_id').val();
				var supplier_name =$('#supplier_name_id').val();
				var payment_details_no = $('#payment_details_no').val();
				var status = $('#status').val();
				getallPatmentdetailsreport(vendor_name,supplier_name,payment_details_no,status);
		});

		function getallPatmentdetailsreport(vendor_name,supplier_name,payment_details_no,status){

			var dt = $('#view_payment_details_report').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					 { "width": "10%", "targets": 6 },
					 { "width": "10%", "targets": 7 },
					 { "width": "10%", "targets": 8 },
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Payment Details Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
					url :"<?php echo base_url();?>admin/fetchPaymentdetailsreport/"+vendor_name+"/"+supplier_name+"/"+payment_details_no+"/"+status,
                    type: "post",
	            },
	        });
        }


		$(document).on('click','#export_to_excel_payment_details',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
		    var vendor_name = $('#vendor_name_id').val();
			var supplier_name =$('#supplier_name_id').val();

		
			var payment_details_no = $('#payment_details_no').val();
			var status = $('#status').val();


			$.ajax({
					url : "<?php echo ADMIN_PATH;?>admin/export_to_excel_payment_details/"+vendor_name+"/"+supplier_name+"/"+payment_details_no+"/"+status,
					type: "POST",
					// data : {'hospitals' : hospitals, 'driver' : driver,'ride_start':ride_start,'ride_stop':ride_stop},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$(".report_type_error").html("");
							alert('No data fond');
						}
						else
						{
							$(".report_type_error").html("");
							window.location.href = "<?php echo ADMIN_PATH;?>admin/export_to_excel_payment_details/"+vendor_name+"/"+supplier_name+"/"+payment_details_no+"/"+status;
						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						alert('No data fond');
						$(".loader_ajax").hide();
					}
				});
			return false;
    	});

    </script>
<?php } ?>

<?php  if($pageTitle=='Sales Tracking Excel Report'){ ?>
	<script type="text/javascript">

		$(document).on('click','#Sales_Tracking_export_to_excel',function(e){
			e.preventDefault();
			$(".loader_ajax").show();

			var sales_tracking_report_name  = $("#sales_tracking_report_name").val();
            var buyer_name  = $("#buyer_name").val();

			if(sales_tracking_report_name=='NA'){
				$(".sales_tracking_report_name_error").html('<p>Sales Tracking Report</p>');
				$(".loader_ajax").hide();
				return;
			}
	
			if($("#from_date").val()){
				var from_date  = $("#from_date").val();
			}else{
				var from_date  = 'NA';
			}

			if($("#to_date").val()){
				var to_date  = $("#to_date").val();
            }else{
				var to_date  = 'NA';
			}


			$.ajax({
				url : "<?php echo ADMIN_PATH;?>admin/download_sales_tracking_export_to_excel/"+sales_tracking_report_name+"/"+buyer_name+"/"+from_date+"/"+to_date,
				type: "POST",
				// data : {'hospitals' : hospitals, 'driver' : driver,'ride_start':ride_start,'ride_stop':ride_stop},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$(".sales_tracking_report_name_error").html("");
						alert('No data fond');
					}
					else
					{
						$(".sales_tracking_report_name_error").html("");
						window.location.href = "<?php echo ADMIN_PATH;?>admin/download_sales_tracking_export_to_excel/"+sales_tracking_report_name+"/"+buyer_name+"/"+from_date+"/"+to_date;
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('No data fond');
					$(".loader_ajax").hide();
				}
			});
		return false;
		});

    </script>
<?php } ?>

<?php  if($pageTitle=='Customer Compliant Report' || $pageTitle=='Add New Coustmor Complaint' || 'Edit Customer Complaint'){ ?>
 <script type="text/javascript">

        $(document).ready(function() { 
				var dt = $('#view_customer_compalint_report').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "10%", "targets": 0 },
						{ "width": "10%", "targets": 1 },
						{ "width": "10%", "targets": 2 },
						{ "width": "10%", "targets": 3 },
						{ "width": "10%", "targets": 4 },
						{ "width": "8%", "targets": 5 },
						{ "width": "10%", "targets": 6 },
						{ "width": "8%", "targets": 7 },
						{ "width": "8%", "targets": 8 },
						{ "width": "10%", "targets": 9 },
					
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No Customer Comaplint Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchcustomercompalintreport",
						type: "post",
					},
				});
		});

        $(document).on('change','#customer_name',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var buyer_name = $('#customer_name').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerPonumberbyBuyeridforcoustomercomplint",
				type: "POST",
				data : {'buyer_name' : buyer_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#customer_po').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						$('#customer_po').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#customer_po').html();
				}
			});
			return false;
		});

		$(document).on('change','#customer_po',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var buyer_po = $('#customer_po').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getpartsusingbuyerpo",
				type: "POST",
				data : {'buyer_po' : buyer_po},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_no').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_no').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_no').html();
				}
			});
			return false;
		});

		$(document).on('change','#part_no',function(e){  
			
			e.preventDefault();
			var part_no = $('#part_no').val();
            $.ajax({
				url : "<?php echo ADMIN_PATH;?>getpartdescriptionusingpartnumber",
				type: "POST",
				data : {'part_no' : part_no},
					success: function(data, textStatus, jqXHR)
					{
					    var get_buyerdata = jQuery.parseJSON( data );

						$(".loader_ajax").hide();
							if(data == "failure")
								{
									$('#component_part_description').val('');
									$('#order_qty').val('');
									
								}
							else
								{
									$('#component_part_description').val(get_buyerdata.name);
									$('#order_qty').val(get_buyerdata.order_oty);
								}
					},
					error: function (jqXHR, textStatus, errorThrown)
					   {
							$('#component_part_description').val('');
							$('#order_qty').val('');
					   }
				});
			return false;
		});

		$(document).on('click','#addnewcustomercomplaint',function(e){
				e.preventDefault();
				$(".loader_ajax").show();
				var formData = new FormData($("#addnewcustomercomplaintform")[0]);
			    var complaint_form_id = $("#complaint_form_id").val();
			   
				$.ajax({
					url : "<?php echo base_url();?>addnewcustomercomplaint",
					type: "POST",
					data : formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data, textStatus, jqXHR)
					{
						var fetchResponse = $.parseJSON(data);
						if(fetchResponse.status == "failure")
						{
							$.each(fetchResponse.error, function (i, v)
							{
								$('.'+i+'_error').html(v);
							});
							$(".loader_ajax").hide();
						}
						else if(fetchResponse.status == 'success')
						{
							swal({
								title: "Success",
								text: "Customer Compalint Successfully Added!",
								icon: "success",
								button: "Ok",
								},function(){ 
									
									window.location.href = "<?php echo base_url().'customercompliant'?>";
							});		
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
					$(".loader_ajax").hide();
					}
				});
				return false;
		});

		$(document).on('click','.deletecustomercompalintreport',function(e){
				var elemF = $(this);
				e.preventDefault();

				swal({
					title: "Are you sure?",
					text: "Delete Customer Compalint",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deletecustomercompalintreport",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Customer Compalint Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'customercompliant'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Customer Compalint deletion cancelled ", "error");
				}
			});
		});

 </script>
<?php } ?>

<?php if($pageTitle=='Search Stock Report'){ ?>
	<script type="text/javascript">

	       $(document).ready(function() { 
				var dt = $('#view_search_stock_report').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "10%", "targets": 0 },
						{ "width": "10%", "targets": 1 },
						{ "width": "10%", "targets": 2 },
						{ "width": "10%", "targets": 3 },
						{ "width": "10%", "targets": 4 },
						{ "width": "10%", "targets": 5 },
						{ "width": "10%", "targets": 6 },
						{ "width": "5%", "targets": 7 },
						// { "width": "10%", "targets": 8 },
						// { "width": "10%", "targets": 9 },
						// { "width": "10%", "targets": 10 },
						// { "width": "10%", "targets": 11 },
						// { "width": "10%", "targets": 12 },
						// { "width": "10%", "targets": 13 },
						// { "width": "10%", "targets": 14 },
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No Search Stock Report Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchserchstocksrport",
						type: "post",
					},
				});
		    });

	</script>
<?php }	?>

<?php if($pageTitle=='Supplier Vendor Compliant Report' || $pageTitle=='Add New Supplier Vendor Compliant Report' ||  $pageTitle=='Edit Supplier Vendor Compliant Report'){ ?>
	    <script type="text/javascript">
	        $(document).ready(function() { 
				var dt = $('#view_supplier_vendor_complaint').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "10%", "targets": 0 },
						{ "width": "10%", "targets": 1 },
						{ "width": "10%", "targets": 2 },
						{ "width": "10%", "targets": 3 },
						{ "width": "10%", "targets": 4 },
						{ "width": "10%", "targets": 5 },
						{ "width": "8%", "targets": 6 }
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No Supplier Vendor Compliant data Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchsuppliervendorrport",
						type: "post",
					},
				});
		    });

			$(document).ready(function() { 
				var supplier_vendor = $('#vendor_supplier').val();
				if(supplier_vendor=='Supplier'){
					$('#supplier_div').css('display','block');
					$('#vendor_div').css('display','none');
					$('#vendor_name').val('');
				}
				if(supplier_vendor=='Vendor'){
					$('#supplier_div').css('display','none');
					$('#vendor_div').css('display','block');
					$('#supplier_name').val('');
				}
			});

			$(document).ready(function() { 

				var supplier_vendor = $('#vendor_supplier').val();

				if(supplier_vendor=='Supplier'){

					$('#supplier_po_number_div').css('display','block');
					$('#vendor_po_number_div').css('display','none');
					$('#supplier_part_number_div').css('display','block');
					$('#vendor_part_number_div').css('display','none');


					var supplier_po_id =$('#supplier_po_id').val();
					var supplier_name = $('#supplier_name').val();
					$.ajax({
						url : "<?php echo ADMIN_PATH;?>admin/getSupplierPonumbeforsuppliervendorcompalint",
						type: "POST",
						data : {'supplier_name' : supplier_name,'supplier_po_id':supplier_po_id},
						success: function(data, textStatus, jqXHR)
						{
							$(".loader_ajax").hide();
							if(data == "failure")
							{
								$('#supplier_po_number').html('<option value="">Select Supplier PO Number</option>');
							}
							else
							{
								// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
								$('#supplier_po_number').html(data);

								$('#supplier_part_number_div').css('display','block');
								$('#vendor_part_number_div').css('display','none');

								var supplier_po_number = $('#supplier_po_number').val();
								var supplier_part_number_id = $('#supplier_part_number_id').val();

								$("#supplier_part_number").html('');
							
								$.ajax({
									url : "<?php echo ADMIN_PATH;?>admin/getSuppliritemonlyforsuppliervendorcompalint",
									type: "POST",
									data : {'supplier_po_number' : supplier_po_number,'supplier_part_number_id':supplier_part_number_id},
									success: function(data, textStatus, jqXHR)
									{
										$(".loader_ajax").hide();
										if(data == "failure")
										{
											$('#supplier_part_number').html('<option value="">Select Part Number</option>');
										}
										else
										{
											$('#supplier_part_number').html(data);

										}
									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$('#supplier_part_number').html();
									}
								});
								return false;

							}
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							$('#supplier_po_number').html();
							//$(".loader_ajax").hide();
						}
					});
				return false;

			   }

			});

			$(document).ready(function() { 

				var supplier_vendor = $('#vendor_supplier').val();

				if(supplier_vendor=='Vendor'){

					//$(".loader_ajax").show();
					// $("#customers-list").html('');
					$('#supplier_po_number_div').css('display','none');
					$('#vendor_po_number_div').css('display','block');
					$('#supplier_part_number_div').css('display','none');
					$('#vendor_part_number_div').css('display','block');

					var vendor_name = $('#vendor_name').val();
					var vendor_po_id = $('#vendor_po_id').val();
				
					$.ajax({
						url : "<?php echo ADMIN_PATH;?>getVendorPoconfirmationvendorlist",
						type: "POST",
						data : {'vendor_name' : vendor_name,'vendor_po_id':vendor_po_id},
						success: function(data, textStatus, jqXHR)
						{
							$(".loader_ajax").hide();
							if(data == "failure")
							{
								$('#vendor_po_number').html('<option value="">Select Vendor PO Number</option>');
							}
							else
							{
								// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
								$('#vendor_po_number').html(data);

								var vendor_po_number = $('#vendor_po_number').val();

								$('#supplier_part_number_div').css('display','none');
								$('#vendor_part_number_div').css('display','block');

								$("#vendor_part_number").html('');

								var vendor_part_number_id =  $('#vendor_part_number_id').val();



								$.ajax({
									url : "<?php echo ADMIN_PATH;?>admin/getVendoritemonlyforsyppliervendorcompaint",
									type: "POST",
									data : {'vendor_po_number' : vendor_po_number,'vendor_part_number_id':vendor_part_number_id},
									success: function(data, textStatus, jqXHR)
									{
										$(".loader_ajax").hide();
										if(data == "failure")
										{
											$('#vendor_part_number').html('<option value="">Select Part Number</option>');
										}
										else
										{
											$('#vendor_part_number').html(data);

										}
									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$('#vendor_part_number').html();
									}
								});
								return false;

								

							}
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							$('#vendor_po_number').html();
							//$(".loader_ajax").hide();
						}
					});
					return false;
			    }
			});
					

			$(document).on('click','#addnewsuppliervendorcomplaint',function(e){
				e.preventDefault();
				$(".loader_ajax").show();
				var formData = new FormData($("#addnewsuppliervendorcomplaintform")[0]);
			    // var complaint_form_id = $("#complaint_form_id").val();
			   
				$.ajax({
					url : "<?php echo base_url();?>addnewsuppliervendorcomplaint",
					type: "POST",
					data : formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data, textStatus, jqXHR)
					{
						var fetchResponse = $.parseJSON(data);
						if(fetchResponse.status == "failure")
						{
							$.each(fetchResponse.error, function (i, v)
							{
								$('.'+i+'_error').html(v);
							});
							$(".loader_ajax").hide();
						}
						else if(fetchResponse.status == 'success')
						{
							swal({
								title: "Success",
								text: "Supplier Vendor Compalint Successfully Added!",
								icon: "success",
								button: "Ok",
								},function(){ 
									
									window.location.href = "<?php echo base_url().'suppliervendorcompliant'?>";
							});		
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
					$(".loader_ajax").hide();
					}
				});
				return false;
	     	});

			$(document).on('change','#vendor_supplier',function(e){  

				var supplier_vendor = $('#vendor_supplier').val();
				if(supplier_vendor=='Supplier'){
					$('#supplier_div').css('display','block');
					$('#vendor_div').css('display','none');
					$('#vendor_name').val('');
				}

				if(supplier_vendor=='Vendor'){
					$('#supplier_div').css('display','none');
					$('#vendor_div').css('display','block');
					$('#supplier_name').val('');
                }
			});


			$(document).on('click','.deletesuppliervendorcompalintreport',function(e){
				var elemF = $(this);
				e.preventDefault();

				swal({
					title: "Are you sure?",
					text: "Delete Supplier Vendor Compalint",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deletesuppliervendorcompalintreport",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Supplier Vendor Compalint Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'suppliervendorcompliant'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Supplier Vendor Compalint deletion cancelled ", "error");
				}
			  });
	     	});


			$(document).on('change','#supplier_name',function(e){  
				e.preventDefault();
				//$(".loader_ajax").show();
				// $("#customers-list").html('');
				$('#supplier_po_number_div').css('display','block');
				$('#vendor_po_number_div').css('display','none');


				var supplier_name = $('#supplier_name').val();
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>admin/getSupplierPonumbeforsuppliervendorcompalint",
					type: "POST",
					data : {'supplier_name' : supplier_name},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$('#supplier_po_number').html('<option value="">Select Supplier PO Number</option>');
						}
						else
						{
							// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
							$('#supplier_po_number').html(data);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#supplier_po_number').html();
						//$(".loader_ajax").hide();
					}
				});
				return false;
	    	});


			$(document).on('change','#vendor_name',function(e){  
				e.preventDefault();
				//$(".loader_ajax").show();
				// $("#customers-list").html('');
				$('#supplier_po_number_div').css('display','none');
				$('#vendor_po_number_div').css('display','block');

				var vendor_name = $('#vendor_name').val();
			
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>getVendorPoconfirmationvendorlist",
					type: "POST",
					data : {'vendor_name' : vendor_name},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$('#vendor_po_number').html('<option value="">Select Vendor PO Number</option>');
						}
						else
						{
							// $('#supplier_po_number').html('<option value="">Select supplier PO Number</option>');
							$('#vendor_po_number').html(data);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#vendor_po_number').html();
						//$(".loader_ajax").hide();
					}
				});
				return false;
	    	});


			$(document).on('change','#vendor_po_number',function(e){  
				e.preventDefault();
				//$(".loader_ajax").show();
				var vendor_po_number = $('#vendor_po_number').val();

				$('#supplier_part_number_div').css('display','none');
				$('#vendor_part_number_div').css('display','block');
		
				$("#vendor_part_number").html('');

				
			
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>admin/getVendoritemonlyforsyppliervendorcompaint",
					type: "POST",
					data : {'vendor_po_number' : vendor_po_number},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$('#vendor_part_number').html('<option value="">Select Part Number</option>');
						}
						else
						{
							$('#vendor_part_number').html(data);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#vendor_part_number').html();
					}
				});
				return false;
			});


			$(document).on('change','#supplier_po_number',function(e){  
				e.preventDefault();
				//$(".loader_ajax").show();

				$('#supplier_part_number_div').css('display','block');
				$('#vendor_part_number_div').css('display','none');

				var supplier_po_number = $('#supplier_po_number').val();

				$("#supplier_part_number").html('');
			
				$.ajax({
					url : "<?php echo ADMIN_PATH;?>admin/getSuppliritemonlyforsuppliervendorcompalint",
					type: "POST",
					data : {'supplier_po_number' : supplier_po_number},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							$('#supplier_part_number').html('<option value="">Select Part Number</option>');
						}
						else
						{
							$('#supplier_part_number').html(data);

						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#supplier_part_number').html();
					}
				});
				return false;
	    	});


			$(document).on('change','#supplier_part_number',function(e){  
			         e.preventDefault();
			
						//$(".loader_ajax").show();
						var supplier_part_number = $('#supplier_part_number').val();
						var supplier_po_number = $('#supplier_po_number').val();
						
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>admin/getPartnumberdetailsforsupplierposuppliervendorpo",
							type: "POST",
							data : {'supplier_part_number' : supplier_part_number,'supplier_po_number':supplier_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#part_description').val('');
								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );
									$('#part_description').val(data_row_material.type_of_raw_material);
									
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
									$('#part_description').val('');
							}
						});
						return false;
			
		    });

			$(document).on('change','#vendor_part_number',function(e){  
			         e.preventDefault();
			
						//$(".loader_ajax").show();
						var vendor_part_number = $('#vendor_part_number').val();
						var vendor_po_number = $('#vendor_po_number').val();
						
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>admin/getPartnumberdetailsforsupplierposuppliervendorpovendor",
							type: "POST",
							data : {'vendor_part_number' : vendor_part_number,'vendor_po_number':vendor_po_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#part_description').val('');
								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );
									$('#part_description').val(data_row_material.name);
									
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
									$('#part_description').val('');
							}
						});
						return false;
			
		    });
			

		</script>
<?php } ?>

<?php if($pageTitle=='Admin : Home page'){ ?>
	<script type="text/javascript">

        $(document).ready(function() {
		   $("#seachbypartnumberreport").dataTable().fnDestroy();
		   var finish_good_part_number = $('#finish_good_part_number').val();
		   var form_type_finish_good = $('#form_type_finish_good').val();
		   var raw_material_part_number = $('#raw_material_part_number').val();
		   var form_type_raw_material = $('#form_type_raw_material').val();
		   seachbypartnumberreport(finish_good_part_number,form_type_finish_good,raw_material_part_number,form_type_raw_material);
		});

		$(document).on('change','#finish_good_part_number',function(e){  
			e.preventDefault();
			$("#seachbypartnumberreport").dataTable().fnDestroy();
			var finish_good_part_number = $('#finish_good_part_number').val();
			var form_type_finish_good = $('#form_type_finish_good').val();
			var raw_material_part_number = $('#raw_material_part_number').val();
			var form_type_raw_material = $('#form_type_raw_material').val();
			seachbypartnumberreport(finish_good_part_number,form_type_finish_good,raw_material_part_number,form_type_raw_material);
		});


        $(document).on('change','#form_type_finish_good',function(e){  
			e.preventDefault();
			$("#seachbypartnumberreport").dataTable().fnDestroy();
			var finish_good_part_number = $('#finish_good_part_number').val();
			var form_type_finish_good = $('#form_type_finish_good').val();
			var raw_material_part_number = $('#raw_material_part_number').val();
			var form_type_raw_material = $('#form_type_raw_material').val();
			seachbypartnumberreport(finish_good_part_number,form_type_finish_good,raw_material_part_number,form_type_raw_material);
		});


		$(document).on('change','#raw_material_part_number',function(e){  
			e.preventDefault();
			$("#seachbypartnumberreport").dataTable().fnDestroy();
			var finish_good_part_number = $('#finish_good_part_number').val();
			var form_type_finish_good = $('#form_type_finish_good').val();
			var raw_material_part_number = $('#raw_material_part_number').val();
			var form_type_raw_material = $('#form_type_raw_material').val();
			seachbypartnumberreport(finish_good_part_number,form_type_finish_good,raw_material_part_number,form_type_raw_material);
		});


        $(document).on('change','#form_type_raw_material',function(e){  
			e.preventDefault();
			$("#seachbypartnumberreport").dataTable().fnDestroy();
			var finish_good_part_number = $('#finish_good_part_number').val();
			var form_type_finish_good = $('#form_type_finish_good').val();
			var raw_material_part_number = $('#raw_material_part_number').val();
			var form_type_raw_material = $('#form_type_raw_material').val();
			seachbypartnumberreport(finish_good_part_number,form_type_finish_good,raw_material_part_number,form_type_raw_material);
		});


		function seachbypartnumberreport(finish_good_part_number,form_type_finish_good,raw_material_part_number,form_type_raw_material){

				var dt = $('#seachbypartnumberreport').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "10%", "targets": 0 },
						{ "width": "10%", "targets": 1 },
						{ "width": "10%", "targets": 2 },
						{ "width": "1%", "targets": 3 },
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>Data Not Preview Please Select part Number First.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>admin/fetchseachbypartnumberreport/"+finish_good_part_number+"/"+form_type_finish_good+"/"+raw_material_part_number+"/"+form_type_raw_material,
						type: "post",
					},
				});

		}
		
    </script>
<?php } ?>

<?php if($pageTitle=='USP Incoming' || $pageTitle=='Add New USP incoming' || $pageTitle=='Edit USP incoming'){ ?>
	<script type="text/javascript">

		$(document).ready(function() { 
			getallPatmentdetailsreport();
		});


		$(document).ready(function() { 
				    var challan_number = $('#challan_number').val();
					$.ajax({
							url : "<?php echo ADMIN_PATH;?>admin/getchallandatabychallannumber",
							type: "POST",
							data : {'challan_number' : challan_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#challan_date').val('');
								}
								else
								{
									var data_row_challan_number = jQuery.parseJSON( data );
									$('#challan_date').val(data_row_challan_number.challan_date);
									
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
									$('#challan_date').val('');
							}
					});
				return false;
		});


		$(document).ready(function() { 
			//$(".loader_ajax").show();
			var challan_number = $('#challan_number').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>admin/getallchallanpartusingchallannumber",
				type: "POST",
				data : {'challan_number' : challan_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;

		});


		function getallPatmentdetailsreport(){
			var dt = $('#view_usp_incoming').DataTable({
				"columnDefs": [ 
					{ className: "details-control", "targets": [ 0 ] },
					{ "width": "12%", "targets": 0 },
					{ "width": "10%", "targets": 1 },
					{ "width": "10%", "targets": 2 },
					{ "width": "10%", "targets": 3 },
					{ "width": "10%", "targets": 4 },
					{ "width": "15%", "targets": 5 },
					{ "width": "10%", "targets": 6 },
					{ "width": "10%", "targets": 7 },
					{ "width": "15%", "targets": 8 },


				],
				responsive: true,
				"oLanguage": {
					"sEmptyTable": "<i>No UspIncoming Details Found.</i>",
				}, 
				"bSort" : false,
				"bFilter":true,
				"bLengthChange": true,
				"iDisplayLength": 10,   
				"bProcessing": true,
				"serverSide": true,
				"ajax":{
					url :"<?php echo base_url();?>admin/fetchuspincomingdetails",
					type: "post",
				},
			});
		}

		$(document).on('change','#usp_name',function(e){  
			e.preventDefault();
			var usp_name = $('#usp_name').val();
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getChallanPObychaid",
				type: "POST",
				data : {'usp_name' : usp_name},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#challan_number').html('<option value="">Select Challan Number</option>');
					}
					else
					{
						$('#challan_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#challan_number').html();
				}
			});
			return false;
		});

		$(document).on('change','#challan_number',function(e){  
			    e.preventDefault();
				    var challan_number = $('#challan_number').val();
					$.ajax({
							url : "<?php echo ADMIN_PATH;?>admin/getchallandatabychallannumber",
							type: "POST",
							data : {'challan_number' : challan_number},
							success: function(data, textStatus, jqXHR)
							{
								$(".loader_ajax").hide();
								if(data == "failure")
								{
									$('#challan_date').val('');
								}
								else
								{
									var data_row_challan_number = jQuery.parseJSON( data );
									$('#challan_date').val(data_row_challan_number.challan_date);
									
								}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
									$('#challan_date').val('');
							}
					});
				return false;
		});

		$(document).on('click','#addnewsupincomingformsubmit',function(e){
				e.preventDefault();
				$(".loader_ajax").show();
				var formData = new FormData($("#addnewsupincomingform")[0]);
			    var usp_incoming_id = $("#usp_incoming_id").val();
			   
				$.ajax({
					url : "<?php echo base_url();?>addnewuspincoming",
					type: "POST",
					data : formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data, textStatus, jqXHR)
					{
						var fetchResponse = $.parseJSON(data);
						if(fetchResponse.status == "failure")
						{
							$.each(fetchResponse.error, function (i, v)
							{
								$('.'+i+'_error').html(v);
							});
							$(".loader_ajax").hide();
						}
						else if(fetchResponse.status == 'success')
						{
							swal({
								title: "Success",
								text: "USP Incoming Successfully Added!",
								icon: "success",
								button: "Ok",
								},function(){ 
										window.location.href = "<?php echo base_url().'uspincoming'?>";
							});		
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
					$(".loader_ajax").hide();
					}
				});
				return false;
	    });

		$(document).on('change','.challan_number_for_part_number',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var challan_number = $('#challan_number').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>admin/getallchallanpartusingchallannumber",
				type: "POST",
				data : {'challan_number' : challan_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#part_number').html('<option value="">Select Part Number</option>');
					}
					else
					{
						$('#part_number').html(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#part_number').html();
				}
			});
			return false;
		});

		$(document).on('click','.deleteuspincoming',function(e){
				var elemF = $(this);
				e.preventDefault();

				swal({
					title: "Are you sure?",
					text: "Delete USP Incoming",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteuspincoming",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "USP Incoming Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'uspincoming'?>";
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "USP Incoming deletion cancelled ", "error");
				}
			});
		});

		$(document).on('change','#part_number',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var part_number = $('#part_number').val();
			var challan_number = $('#challan_number').val();
			
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>admin/getChallanformitemdetailsbychallanandaprt",
				type: "POST",
				data : {'part_number' : part_number,'challan_number':challan_number},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#description').value('');
						$('#challan_qty').value('');
						$('#net_weight_per_kgs_pcs').value('');
					
					}
					else
					{
						var data_row = jQuery.parseJSON( data );

						$('#description').val(data_row.description1);
						$('#challan_qty').val(data_row.qty);
						$('#net_weight_per_kgs_pcs').val(data_row.net_weight1);
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#description').html();
					$('#challan_qty').html();
					$('#net_weight_per_kgs_pcs').html('');
					//$(".loader_ajax").hide();
				}
			});
			return false;
		});

		$(document).on('click','#saveuspincoming_item',function(e){
			e.preventDefault();
			   $(".loader_ajax").show();

			   var part_number =   $('#part_number').val();
			   var description =   $('#description').val();
			   var challan_qty =   $('#challan_qty').val();
			   var net_weight_per_kgs_pcs =   $('#net_weight_per_kgs_pcs').val();
			   var challan_no =   $('#challan_no').val();
			   var previous_balance =   $('#previous_balance').val();
			   var challan_date_item =   $('#challan_date_item').val();
			   var received_qty_in_pcs =   $('#received_qty_in_pcs').val();
			   var received_qty_in_kgs = $('#received_qty_in_kgs').val();
			   var gross_qty_in_includin_bg =   $('#gross_qty_in_includin_bg').val();
			   var units =   $('#units').val();
			   var no_of_bags =   $('#no_of_bags').val();
			   var lot_no =   $('#lot_no').val();
			   var itemremark =   $('#itemremark').val();
			   var balance_qty_in_pcs =   $('#balance_qty_in_pcs').val();
			   var balance_qty_in_kgs =   $('#balance_qty_in_kgs').val();
			   var status =   $('#status').val();
			   var pre_usp_date =   $('#usp_date').val();
		       var pre_usp_name =   $('#usp_name').val();
			   var pre_challan_number =   $('#challan_number').val();
			   var pre_challan_date =   $('#challan_date').val();
			   var pre_report_by =   $('#report_by').val();
			   var pre_remark =   $('#remark').val();
			   var pre_status =   $('#usp_status').val();

			   var usp_incoming_id = $("#usp_incoming_id").val();

			   var usp_incoming_item_id = $("#usp_incoming_item_id").val();

			   $.ajax({
				url : "<?php echo base_url();?>admin/saveuspincoming_item_form",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,challan_qty:challan_qty,net_weight_per_kgs_pcs:net_weight_per_kgs_pcs,challan_no:challan_no,challan_date_item:challan_date_item,received_qty_in_pcs:received_qty_in_pcs,received_qty_in_kgs:received_qty_in_kgs,gross_qty_in_includin_bg:gross_qty_in_includin_bg,units:units,no_of_bags:no_of_bags,lot_no:lot_no,itemremark:itemremark,balance_qty_in_pcs:balance_qty_in_pcs,balance_qty_in_kgs:balance_qty_in_kgs,status:status,pre_usp_date:pre_usp_date,pre_usp_name:pre_usp_name,pre_challan_number:pre_challan_number,pre_challan_date:pre_challan_date,pre_report_by:pre_report_by,pre_remark:pre_remark,usp_incoming_id:usp_incoming_id,previous_balance:previous_balance,usp_incoming_item_id:usp_incoming_item_id,pre_status:pre_status},
				 method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 
								
								if(usp_incoming_id){
									window.location.href = "<?php echo base_url().'edituspincomig/'?>"+usp_incoming_id;	

								}else{
									window.location.href = "<?php echo base_url().'addnewuspincoming'?>";	

								}
							
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			   });
			return false;
	    });

		$(document).on('click','.deleteuspincomingitem',function(e){
				var elemF = $(this);
				e.preventDefault();

				var usp_incoming_id = $('#usp_incoming_id').val();


				swal({
					title: "Are you sure?",
					text: "Delete USP Incoming Item",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteuspincomingitem",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "USP Incoming Item Deleted Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 


                                                if(usp_incoming_id){
													window.location.href = "<?php echo base_url().'edituspincomig/'?>"+usp_incoming_id;
												}else{
													window.location.href = "<?php echo base_url().'addnewuspincoming'?>";
												}

												
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "USP Incoming Item deletion cancelled ", "error");
				}
			});
		});

		$(document).on('change', '#received_qty_in_pcs', function(){	
				 $("#received_qty_in_kgs").val();

				// $("#grand_total_main").val();
			  
				 if($("#net_weight_per_kgs_pcs").val()){
					 var net_weight_per_kgs_pcs = $("#net_weight_per_kgs_pcs").val();
				 }else{
					 var net_weight_per_kgs_pcs = 0;
				 }

				 if($("#received_qty_in_pcs").val()){
					 var received_qty_in_pcs = $("#received_qty_in_pcs").val();
				 }else{
					 var received_qty_in_pcs = 0;
				 }

				 var total_second_group = parseFloat(net_weight_per_kgs_pcs) * parseFloat(received_qty_in_pcs);

				 $("#received_qty_in_kgs").val(total_second_group.toFixed(2));
			
		});

		$(document).on('change', '#challan_qty,#received_qty_in_pcs', function(){	
				 $("#balance_qty_in_pcs").val();

				// $("#grand_total_main").val();
			  
				 if($("#challan_qty").val()){
					 var challan_qty = $("#challan_qty").val();
				 }else{
					 var challan_qty = 0;
				 }

				 if($("#received_qty_in_pcs").val()){
					 var received_qty_in_pcs = $("#received_qty_in_pcs").val();
				 }else{
					 var received_qty_in_pcs = 0;
				 }

				 if($("#previous_balance").val()){
					 var previous_balance = $("#previous_balance").val();
				 }else{
					 var previous_balance = 0;
				 }

				 if(previous_balance > 0){

					var calcualtion_qty_pre = previous_balance;

				 }else{
					var calcualtion_qty_pre = challan_qty;
				 }


				 var total_second_group = parseFloat(calcualtion_qty_pre) - parseFloat(received_qty_in_pcs);

				 $("#balance_qty_in_pcs").val(total_second_group.toFixed(2));




				 $("#balance_qty_in_kgs").val();

				// $("#grand_total_main").val();

				if($("#balance_qty_in_pcs").val()){
					var balance_qty_in_pcs = $("#balance_qty_in_pcs").val();
				}else{
					var balance_qty_in_pcs = 0;
				}

				if($("#net_weight_per_kgs_pcs").val()){
					var net_weight_per_kgs_pcs = $("#net_weight_per_kgs_pcs").val();
				}else{
					var net_weight_per_kgs_pcs = 0;
				}

				var total_second_group_2 = parseFloat(balance_qty_in_pcs) * parseFloat(net_weight_per_kgs_pcs);

				$("#balance_qty_in_kgs").val(total_second_group_2.toFixed(2));


		});

		$(document).on('click','.closeuspincoming_item', function(){
			location.reload();
        });

		$(document).on('change','.partnumberforpreviousbal',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var part_number = $('#part_number').val();
			var challan_number = $('#challan_number').val();
			var usp_incoming_id = $('#usp_incoming_id').val();
			
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>admin/partnumberforpreviousbal",
				type: "POST",
				data : {'part_number' : part_number,'challan_number':challan_number,'usp_incoming_id':usp_incoming_id},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						$('#previous_balance').val(0);
				
					}
					else
					{
						var data_row = jQuery.parseJSON( data );
						$('#previous_balance').val(data_row.balance_qty_in_pcs);
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#previous_balance').val(0);
				}
			});
			return false;
		});


		$(document).on('click','.edituspincomingitem',function(e){  
			e.preventDefault();

			var elemF = $(this);
			var item_id = elemF.attr('data-id');
			
				$.ajax({
					url : "<?php echo base_url();?>admin/geteditUspincomingitemdatabyuspitemId",
					type: "POST",
					data : 'id='+item_id,
					success: function(data, textStatus, jqXHR)
						{
							var fetchResponse = $.parseJSON(data);
									$('#addNewModal').modal('show'); 
									   $('#usp_incoming_item_id').val(fetchResponse.uspincoming_item_id); 
									   $('#part_number').val(fetchResponse.fin_id);  
								       $('#description').val(fetchResponse.name); 
									   $('#challan_qty').val(fetchResponse.challan_qty); 
									   $('#net_weight_per_kgs_pcs').val(fetchResponse.net_weight_per_pcs); 
									   $('#previous_balance').val(fetchResponse.previous_balance); 
									   $('#challan_no').val(fetchResponse.challan_no); 
									   $('#invoice_date').val(fetchResponse.invoice_date); 
									   $('#challan_date_item').val(fetchResponse.challan_date); 
									   $('#received_qty_in_pcs').val(fetchResponse.rqip); 
									   $('#received_qty_in_kgs').val(fetchResponse.rqik);    
									   $('#gross_qty_in_includin_bg').val(fetchResponse.gross_weight_Including_bag);    
									   $('#units').val(fetchResponse.units); 
									   $('#no_of_bags').val(fetchResponse.no_of_bags); 
									   $('#lot_no').val(fetchResponse.lot_no); 
									   $('#itemremark').val(fetchResponse.itemremark); 
									   $('#balance_qty_in_pcs').val(fetchResponse.balance_qty_in_pcs); 
									   $('#balance_qty_in_kgs').val(fetchResponse.balance_qty_in_kgs); 
									   $('#status').val(fetchResponse.itemstatus); 


								},
								error: function (jqXHR, textStatus, errorThrown)
								{
								   $(".loader_ajax").hide();
								}
						});
			return false;
	    });	
    </script>
<?php } ?>

<?php if($pageTitle=='Log History'){ ?>
<script type="text/javascript">
		$(document).ready(function() {
				var dt = $('#log_record_view').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "10%", "targets": 0 },
						{ "width": "20%", "targets": 1 },
						{ "width": "10%", "targets": 2 },
						{ "width": "8%", "targets": 3 },
						{ "width": "10%", "targets": 4 },
						{ "width": "10%", "targets": 5 },
						{ "width": "5%", "targets": 6 },
						{ "width": "5%", "targets": 7 },
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No CHA Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>admin/fetchlogrecord",
						type: "post",
					},
				});
		});

</script>
<?php } ?>

<?php if($pageTitle=='QC Challan' || $pageTitle=='Add QC Challan' || $pageTitle=='Edit QC Challan'){ ?>
	<script type="text/javascript">
            $(document).ready(function() {
				var dt = $('#view_qc_challan').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "10%", "targets": 0 },
						{ "width": "10%", "targets": 1 },
						{ "width": "20%", "targets": 2 },
						{ "width": "25%", "targets": 3 },
						{ "width": "8%", "targets": 4 }
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No QC Challan Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchqcchallan",
						type: "post",
					},
				});
     		});

			$(document).on('click','#addqcchallanform',function(e){
					e.preventDefault();
					$(".loader_ajax").show();
					
					var qc_challan_id =   $('#qc_challan_id').val();
					var formData = new FormData($("#addqchallanformid")[0]);
					$.ajax({
						url : "<?php echo base_url();?>addqcchallan",
						type: "POST",
						data : formData,
						cache: false,
						contentType: false,
						processData: false,
						success: function(data, textStatus, jqXHR)
						{
							var fetchResponse = $.parseJSON(data);
							if(fetchResponse.status == "failure")
							{
								$.each(fetchResponse.error, function (i, v)
								{
									$('.'+i+'_error').html(v);
								});
								$(".loader_ajax").hide();
							}
							else if(fetchResponse.status == 'success')
							{
								swal({
									title: "Success",
									text: "Qc Challan Form Successfully Added!",
									icon: "success",
									button: "Ok",
									},function(){ 
										
											window.location.href = "<?php echo base_url().'qcchallan'?>";

										
								});		
							}
							
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							$(".loader_ajax").hide();
						}
					});
					return false;
			});

			$(document).on('click','#saveQcchallan_item',function(e){
			   e.preventDefault();
			   $(".loader_ajax").show();
			   var formData = new FormData($("#saveQcchallanitemform")[0]);

			   var field_1 =   $('#field_1').val();
			   var field_2 =   $('#field_2').val();
			   var field_3 =   $('#field_3').val();
			   var field_4 =   $('#field_4').val();
			   var field_5 =   $('#field_5').val();
			   var field_6 =   $('#field_6').val();
			   var remark  =    $('#item_remark').val();

			   var pre_date =   $('#challan_date').val();
			   var pre_vendor_name =   $('#vendor_name').val();
			   var pre_remark =   $('#remark').val();

			   var qc_challan_id =   $('#qc_challan_id').val();

			   var qc_challan_item_id = $('#qc_challan_item_id').val();

		
			   $.ajax({
				url : "<?php echo base_url();?>saveQcchallanitem",
				type: "POST",
				 //data : formData,
				 data :{field_1:field_1,field_2:field_2,field_3:field_3,field_4:field_4,field_5:field_5,field_6:field_6,remark:remark,pre_date:pre_date,pre_vendor_name:pre_vendor_name,pre_remark:pre_remark,qc_challan_id:qc_challan_id,qc_challan_item_id:qc_challan_item_id},
				 method: "POST",
                // data :{package_id:package_id},
                cache:false,
				success: function(data, textStatus, jqXHR)
				{
					var fetchResponse = $.parseJSON(data);
					if(fetchResponse.status == "failure")
				    {
				    	$.each(fetchResponse.error, function (i, v)
		                {
		                    $('.'+i+'_error').html(v);
		                });
						$(".loader_ajax").hide();
				    }
					else if(fetchResponse.status == 'success')
				    {
						swal({
							title: "Success",
							text: "Item Successfully Added!",
							icon: "success",
							button: "Ok",
							},function(){ 

								if(qc_challan_id){
									window.location.href = "<?php echo base_url().'editqcchallan/'?>"+qc_challan_id;
								}else{
									window.location.href = "<?php echo base_url().'addqcchallan'?>";
								 }
							
						});		
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			   });
			 return false;
	        });

			$(document).on('click','.deleteQcchllanitem',function(e){
				var elemF = $(this);
				e.preventDefault();
				var qc_challan_id =   $('#qc_challan_id').val();

				swal({
					title: "Are you sure?",
					text: "Delete QC Challan Item ",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deleteQcchllanitem",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "QC Challan Item Deleted Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 

													if(qc_challan_id){
														window.location.href = "<?php echo base_url().'editqcchallan/'?>"+qc_challan_id;
													}else{
														window.location.href = "<?php echo base_url().'addqcchallan'?>";
													}
																			
													//window.location.href = "<?php echo base_url().'addqcchallan'?>";
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "OMS Challan Item deletion cancelled ", "error");
					}
				});
	        });

			$(document).on('click','.deleteqcchllan',function(e){
				var elemF = $(this);
				e.preventDefault();
				swal({
					title: "Are you sure?",
					text: "Delete QC Challan ",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deleteqcchllan",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "QC Challan Deleted Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 
														window.location.href = "<?php echo base_url().'qcchallan'?>";
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "OMS Challan deletion cancelled ", "error");
					}
				});
	        });

			$(document).on('click','.editQcchllanitem',function(e){  
				e.preventDefault();
				var elemF = $(this);
				var item_id = elemF.attr('data-id');
				$.ajax({
					url : "<?php echo base_url();?>getqcchallanitemdata",
					type: "POST",
					data : 'id='+item_id,
					success: function(data, textStatus, jqXHR)
					{
						    var fetchResponse = $.parseJSON(data);
							$('#addNewModal').modal('show'); 
							$('#qc_challan_item_id').val(fetchResponse.id); 
							$('#field_1').val(fetchResponse.field_1);  
							$('#field_2').val(fetchResponse.field_2);  
							$('#field_3').val(fetchResponse.field_3);  
							$('#field_4').val(fetchResponse.field_4);  
							$('#field_5').val(fetchResponse.field_5);  
							$('#field_6').val(fetchResponse.field_6);  
							$('#item_remark').val(fetchResponse.remark);  
							
					},
					error: function (jqXHR, textStatus, errorThrown)
				    {
				   	   $(".loader_ajax").hide();
				    }
				});
				return false;
			});

			$(document).on('click','.closeQcchallanform',function(e){  
				location.reload();
			});

    </script>
<?php } ?>

<?php if($pageTitle=='Team Master' || $pageTitle=='Add Team' || $pageTitle=="Edit Team Master"){ ?>
	<script type="text/javascript">
            $(document).ready(function() {
				var dt = $('#team_master').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "25%", "targets": 0 },
						{ "width": "10%", "targets": 1 },
						{ "width": "20%", "targets": 2 },
						{ "width": "8%", "targets": 3 },
						
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No Team Master Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchteammaster",
						type: "post",
					},
				});
     		});

			$(document).on('click','#savenewteam',function(e){
					e.preventDefault();
					$(".loader_ajax").show();
					
					var formData = new FormData($("#addnewteamform")[0]);
					$.ajax({
						url : "<?php echo base_url();?>addteam",
						type: "POST",
						data : formData,
						cache: false,
						contentType: false,
						processData: false,
						success: function(data, textStatus, jqXHR)
						{
							var fetchResponse = $.parseJSON(data);
							if(fetchResponse.status == "failure")
							{
								$.each(fetchResponse.error, function (i, v)
								{
									$('.'+i+'_error').html(v);
								});
								$(".loader_ajax").hide();
							}
							else if(fetchResponse.status == 'success')
							{
								swal({
									title: "Success",
									text: "New Team Successfully Added!",
									icon: "success",
									button: "Ok",
									},function(){ 
										
											window.location.href = "<?php echo base_url().'teammaster'?>";
								});		
							}
							
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							$(".loader_ajax").hide();
						}
					});
					return false;
			});

			$(document).on('click','.deleteteammaster',function(e){
				var elemF = $(this);
				e.preventDefault();
				swal({
					title: "Are you sure?",
					text: "Delete Team Master",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deleteteammaster",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "Team Master Deleted Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 
														window.location.href = "<?php echo base_url().'teammaster'?>";
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "Team Master deletion cancelled ", "error");
					}
				});
	        });

	</script>
<?php } ?>

<?php if($pageTitle=='Sampling Method' || $pageTitle=='Add New Sampling Method' || $pageTitle=='Update Sampling Method' ){ ?>
	<script type="text/javascript">
		$(document).ready(function() {
			var sampling_master_id =   $('#sampling_master_id').val();

			var dt = $('#view_smapling_method').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "20%", "targets": 0 },
						{ "width": "20%", "targets": 1 },
						{ "width": "25%", "targets": 2 },
						{ "width": "25%", "targets": 3 },
						{ "width": "10%", "targets": 4 },
						
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No Sampling Method Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchsamplingmethodtrans/"+sampling_master_id,
						type: "post",
					},
				});
     	});
		 
		$(document).on('click','#savenewsamplingmethodsubmit',function(e){
				e.preventDefault();
				$(".loader_ajax").show();

				var sampling_master_id =   $('#sampling_master_id').val();
				var formData = new FormData($("#addnewsamplingmethodfrom")[0]);

				$.ajax({
					url : "<?php echo base_url();?>addnewSamplingmethod/"+sampling_master_id,
					type: "POST",
					data : formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data, textStatus, jqXHR)
					{
						var fetchResponse = $.parseJSON(data);
						if(fetchResponse.status == "failure")
						{
							$.each(fetchResponse.error, function (i, v)
							{
								$('.'+i+'_error').html(v);
							});
							$(".loader_ajax").hide();
						}
						else if(fetchResponse.status == 'success')
						{
							swal({
								title: "Success",
								text: "Sampling Method Successfully Added!",
								icon: "success",
								button: "Ok",
								},function(){ 
									window.location.href = "<?php echo base_url().'addsamplingmethod/'?>"+sampling_master_id;
							});		
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
					$(".loader_ajax").hide();
					}
				});
				return false;
		});

		$(document).on('click','#updatenewsamplingmethodsubmit',function(e){
				e.preventDefault();
				$(".loader_ajax").show();

				var sampling_method_id =   $('#sampling_method_id').val();
				var sampling_master_id =   $('#sampling_master_id').val();
				var formData = new FormData($("#addnewsamplingmethodfrom")[0]);

				$.ajax({
					url : "<?php echo base_url();?>updatesamplingmethodtrans/"+sampling_master_id,
					type: "POST",
					data : formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data, textStatus, jqXHR)
					{
						var fetchResponse = $.parseJSON(data);
						if(fetchResponse.status == "failure")
						{
							$.each(fetchResponse.error, function (i, v)
							{
								$('.'+i+'_error').html(v);
							});
							$(".loader_ajax").hide();
						}
						else if(fetchResponse.status == 'success')
						{
							swal({
								title: "Success",
								text: "Sampling Method Successfully Added!",
								icon: "success",
								button: "Ok",
								},function(){ 
									window.location.href = "<?php echo base_url().'addsamplingmethod/'?>"+sampling_master_id;
							});		
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
					$(".loader_ajax").hide();
					}
				});
				return false;
		});

		// $(document).on('click','#updatecha',function(e){
		// 		e.preventDefault();
		// 		$(".loader_ajax").show();
		// 		var formData = new FormData($("#updatechaform")[0]);
		// 		var cha_id = $("#cha_id").val();
		// 		$.ajax({
		// 			url : "<?php echo base_url();?>updatecha/"+cha_id,
		// 			type: "POST",
		// 			data : formData,
		// 			cache: false,
		// 			contentType: false,
		// 			processData: false,
		// 			success: function(data, textStatus, jqXHR)
		// 			{
		// 				var fetchResponse = $.parseJSON(data);
		// 				if(fetchResponse.status == "failure")
		// 				{
		// 					$.each(fetchResponse.error, function (i, v)
		// 					{
		// 						$('.'+i+'_error').html(v);
		// 					});
		// 					$(".loader_ajax").hide();
		// 				}
		// 				else if(fetchResponse.status == 'success')
		// 				{
		// 					swal({
		// 						title: "Success",
		// 						text: "CHA Successfully Updated!",
		// 						icon: "success",
		// 						button: "Ok",
		// 						},function(){ 
		// 							window.location.href = "<?php echo base_url().'chamaster'?>";
		// 					});		
		// 				}
						
		// 			},
		// 			error: function (jqXHR, textStatus, errorThrown)
		// 			{
		// 			$(".loader_ajax").hide();
		// 			}
		// 		});
		// 		return false;
		// });

		$(document).on('click','.deletesamplingmethod',function(e){
			var elemF = $(this);
			e.preventDefault();
			var sampling_master_id =   $('#sampling_master_id').val();

			swal({
				title: "Are you sure?",
				text: "Delete Sampling Method",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deletesamplingmethod",
								type: "POST",
								data : 'id='+elemF.attr('data-id'),
								success: function(data, textStatus, jqXHR)
								{
									const obj = JSON.parse(data);
								
									if(obj.status=='success'){
										swal({
											title: "Deleted!",
											text: "Sampling Method Succesfully",
											icon: "success",
											button: "Ok",
											},function(){ 
												window.location.href = "<?php echo base_url().'addsamplingmethod/'?>"+sampling_master_id;
										});	
									}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									$(".loader_ajax").hide();
								}
							})
						}
						else {
				swal("Cancelled", "Sampling Method deletion cancelled ", "error");
				}
			});
		});

    </script>
<?php } ?>


<?php if($pageTitle=='Add Team Member' || $pageTitle=='Add New Team Member Action' || $pageTitle=='Update Team Member'){ ?>
	<script type="text/javascript">
		$(document).ready(function() {
			var team_id =   $('#team_id').val();
			var dt = $('#view_team_member_list').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "50%", "targets": 0 },
						{ "width": "40%", "targets": 1 },	
						{ "width": "10%", "targets": 2 },						
					
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>Team Member List Not Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchteammemberlist/"+team_id,
						type: "post",
					},
				});
     	});

		$(document).on('click','#addnewteammemberfromsubmit',function(e){
					e.preventDefault();
					$(".loader_ajax").show();
					var main_team_id =   $('#main_team_id').val();

					var formData = new FormData($("#addnewteammemberfrom")[0]);
					$.ajax({
						url : "<?php echo base_url();?>addteammemberaction/"+main_team_id,
						type: "POST",
						data : formData,
						cache: false,
						contentType: false,
						processData: false,
						success: function(data, textStatus, jqXHR)
						{
							var fetchResponse = $.parseJSON(data);
							if(fetchResponse.status == "failure")
							{
								$.each(fetchResponse.error, function (i, v)
								{
									$('.'+i+'_error').html(v);
								});
								$(".loader_ajax").hide();
							}
							else if(fetchResponse.status == 'success')
							{
								swal({
									title: "Success",
									text: "Team Member Successfully Added!",
									icon: "success",
									button: "Ok",
									},function(){ 
										
											window.location.href = "<?php echo base_url().'addteammembers/'?>"+main_team_id;
								});		
							}
							
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							$(".loader_ajax").hide();
						}
					});
					return false;
		});

		$(document).on('click','.deleteteammember',function(e){
				var elemF = $(this);
				e.preventDefault();

				var main_team_id =   $('#team_id').val();

				swal({
					title: "Are you sure?",
					text: "Delete Team Master",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deleteteammember",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "Team Member Deleted Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 
														window.location.href = "<?php echo base_url().'addteammembers/'?>"+main_team_id;
											});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "Team Member deletion cancelled ", "error");
					}
				});
	    });
	</script>
<?php }  ?>


<?php if($pageTitle=='Add Scrap Rejection Form Details'){?>
	<script type="text/javascript">

        $(document).ready(function() {
			var rejection_form_id =   $('#rejection_form_id').val();
			var vendor_po_item_id =   $('#vendor_po_item_id').val();
			var vendor_po_id =   $('#vendor_po_id').val();

			    var dt = $('#view_stock_rejectiondetails').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "30%", "targets": 0 },
						{ "width": "30%", "targets": 1 },	
						{ "width": "30%", "targets": 2 },	
						{ "width": "8%", "targets": 3 },						
					
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>Scrap Rejection Details Not Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>admin/fetchscarprejectiondetails/"+rejection_form_id+"/"+vendor_po_item_id+"/"+vendor_po_id,
						type: "post",
					},
				});
        });

		$(document).on('click','.closescraprejection',function(e){  
				location.reload();
		});

		$(document).on('click','#savescraprejectiondetails',function(e){
			e.preventDefault();
				var rejection_form_id =   $('#rejection_form_id').val();
				var vendor_po_item_id =   $('#vendor_po_item_id').val();
				var vendor_po_id =   $('#vendor_po_id').val();
				var formData = new FormData($("#savescraprejectiondetailsform")[0]);

				$.ajax({
						url : "<?php echo base_url();?>savescraprejectiondetails",
						type: "POST",
						data : formData,
						cache: false,
						contentType: false,
						processData: false,
						success: function(data, textStatus, jqXHR)
						{
							var fetchResponse = $.parseJSON(data);
							if(fetchResponse.status == "failure")
							{
								$.each(fetchResponse.error, function (i, v)
								{
									$('.'+i+'_error').html(v);
								});
								$(".loader_ajax").hide();
							}
							else if(fetchResponse.status == 'success')
							{
								swal({
									title: "Success",
									text: "Scrap Details Successfully Added!",
									icon: "success",
									button: "Ok",
									},function(){ 
										
											window.location.href = "<?php echo base_url()?>addscraprejection?rejection_form_id="+rejection_form_id+'&vendor_po_item_id='+vendor_po_item_id+'&vendor_po_id='+vendor_po_id;
								});		
							}
							
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							$(".loader_ajax").hide();
						}
				});
				return false;
		});


		$(document).on('click','.deletescrapdetails',function(e){
				var elemF = $(this);
				e.preventDefault();

				var rejection_form_id =   $('#rejection_form_id').val();
				var vendor_po_item_id =   $('#vendor_po_item_id').val();
				var vendor_po_id =   $('#vendor_po_id').val();

				swal({
					title: "Are you sure?",
					text: "Delete Scrap Details",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>admin/deletescrapdetails",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
									
										if(obj.status=='success'){
											swal({
												title: "Deleted!",
												text: "Scrap Details Deleted Succesfully",
												icon: "success",
												button: "Ok",
												},function(){ 
													window.location.href = "<?php echo base_url()?>addscraprejection?rejection_form_id="+rejection_form_id+'&vendor_po_item_id='+vendor_po_item_id+'&vendor_po_id='+vendor_po_id;
												});	
										}

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
								})
							}
							else {
					swal("Cancelled", "Scrap Details deletion cancelled ", "error");
					}
				});
	    });


		$(document).on('click','.updatescrapdetails',function(e){  
			e.preventDefault();
			var elemF = $(this);
			var item_id = elemF.attr('data-id');		
			$.ajax({
				url : "<?php echo base_url();?>admin/geteupdatescrapdetails",
				type: "POST",
				data : 'id='+item_id,
				success: function(data, textStatus, jqXHR)
				{
					    var fetchResponse = $.parseJSON(data);
						$('#exampleModal').modal('show'); 
						$('#scrap_rejection_details_id_popup').val(fetchResponse.scrap_id); 
						$('#scrap_date').val(fetchResponse.scrap_date);  
						$('#scrap_type').val(fetchResponse.scrap_type);  
						$('#remark').val(fetchResponse.scrap_remark);  
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   	   $(".loader_ajax").hide();
			    }
			});
			return false;
		});

	</script>
<?php } ?>


<?php if($pageTitle=='CBAM Report'){?>
	<script type="text/javascript">

            // $(document).ready(function() {
			//     var dt = $('#view_CBAM_calculation_report').DataTable({
			// 		"columnDefs": [ 
			// 			{ className: "details-control", "targets": [ 0 ] },
			// 			{ "width": "10%", "targets": 0 },
			// 			{ "width": "10%", "targets": 1 },	
			// 			{ "width": "10%", "targets": 2 },	
			// 			{ "width": "10%", "targets": 3 },	
			// 			{ "width": "10%", "targets": 4 },
			// 			{ "width": "10%", "targets": 5 },	
			// 			{ "width": "10%", "targets": 6 },	
			// 			{ "width": "10%", "targets": 7 },			
			// 			{ "width": "10%", "targets": 8 },			
			// 			{ "width": "10%", "targets": 9 },						
					
			// 		],
			// 		responsive: true,
			// 		"oLanguage": {
			// 			"sEmptyTable": "<i>CBAM Not Found.</i>",
			// 		}, 
			// 		"bSort" : false,
			// 		"bFilter":true,
			// 		"bLengthChange": true,
			// 		"iDisplayLength": 10,   
			// 		"bProcessing": true,
			// 		"serverSide": true,
			// 		"ajax":{
			// 			url :"<?php echo base_url();?>admin/fetchcbamreport",
			// 			type: "post",
			// 		},
			// 	});
            // });

			$(document).ready(function() {
				$("#view_CBAM_calculation_report").dataTable().fnDestroy();
				var from_date = $('#from_date').val();
				var to_date = $('#to_date').val();
				var vendor_name = $('#vendor_name').val();
				getCBAMcalculationreport(from_date,to_date,vendor_name);
			});

			$(document).on('change','#vendor_name',function(e){  
				e.preventDefault();
				$("#view_CBAM_calculation_report").dataTable().fnDestroy();
				var from_date = $('#from_date').val();
				var to_date = $('#to_date').val();
				var vendor_name = $('#vendor_name').val();
				getCBAMcalculationreport(from_date,to_date,vendor_name);
			});


			$(document).on('change','#from_date',function(e){  
				e.preventDefault();
				$("#view_CBAM_calculation_report").dataTable().fnDestroy();
				var from_date = $('#from_date').val();
				var to_date = $('#to_date').val();
				var vendor_name = $('#vendor_name').val();
				getCBAMcalculationreport(from_date,to_date,vendor_name);
			});


			$(document).on('change','#to_date',function(e){  
				e.preventDefault();
				$("#view_CBAM_calculation_report").dataTable().fnDestroy();
				var from_date = $('#from_date').val();
				var to_date = $('#to_date').val();
				var vendor_name = $('#vendor_name').val();
				getCBAMcalculationreport(from_date,to_date,vendor_name);
			});


			function getCBAMcalculationreport(from_date,to_date,vendor_name){

				if(from_date){
					from_date = from_date;
				}else{
					from_date ='NA';
				}

				if(to_date){
					to_date = to_date;
				}else{
					to_date ='NA';
				}

				var dt = $('#view_CBAM_calculation_report').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "10%", "targets": 0 },
						{ "width": "10%", "targets": 1 },	
						{ "width": "10%", "targets": 2 },	
						{ "width": "10%", "targets": 3 },	
						{ "width": "10%", "targets": 4 },
						{ "width": "10%", "targets": 5 },	
						{ "width": "10%", "targets": 6 },	
						{ "width": "10%", "targets": 7 },			
						{ "width": "10%", "targets": 8 },			
						{ "width": "10%", "targets": 9 },						
						{ "width": "10%", "targets": 10 },
						{ "width": "10%", "targets": 11 },
					
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>CBAM Not Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>admin/fetchcbamreport/"+from_date+"/"+to_date+"/"+vendor_name,
						type: "post",
					},
				});
            }


			$(document).on('click','#export_to_excel_cbam_report',function(e){
				e.preventDefault();
				$(".loader_ajax").show();

				var vendor_name  = $("#vendor_name").val();
	
				if($("#from_date").val()){
					var from_date  = $("#from_date").val();
				}else{
					var from_date  = 'NA';
				}

				if($("#to_date").val()){
					var to_date  = $("#to_date").val();
				}else{
					var to_date  = 'NA';
				}


				$.ajax({
					url : "<?php echo ADMIN_PATH;?>admin/export_to_excel_cbam_report/"+vendor_name+"/"+from_date+"/"+to_date,
					type: "POST",
					// data : {'hospitals' : hospitals, 'driver' : driver,'ride_start':ride_start,'ride_stop':ride_stop},
					success: function(data, textStatus, jqXHR)
					{
						$(".loader_ajax").hide();
						if(data == "failure")
						{
							// $(".sales_tracking_report_name_error").html("");
							alert('No data fond');
						}
						else
						{
							// $(".sales_tracking_report_name_error").html("");
							window.location.href = "<?php echo ADMIN_PATH;?>admin/export_to_excel_cbam_report/"+vendor_name+"/"+from_date+"/"+to_date;
						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						alert('No data fond');
						$(".loader_ajax").hide();
					}
				});
			return false;
		});



    </script>
<?php } ?>


<?php if($pageTitle=='Admin : Add User' || $pageTitle=='Admin : Edit User'){?>
	<script type="text/javascript">
           
			$(document).ready(function() {
				var role = $('#role').val();
				
				if(role==7){
					$('#row_team').show(); 
				}else{
					$('#row_team').hide(); 
				}
			});

		 
		   $(document).on('change','#role',function(e){  
				var role = $('#role').val();
               
				if(role==7){
					$('#row_team').show(); 
				}else{
					$('#row_team').hide(); 
				}
			});

    </script>
<?php } ?>
