<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

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


<?php if($pageTitle=='Finished Goods Master' || $pageTitle=='Add Finished Goods' || $pageTitle=='Update Finished Goods'){ ?>
	<script type="text/javascript">
		$(document).ready(function() {
            var dt = $('#view_finished_goods_master').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "25%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
	                 { "width": "10%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
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


<?php if($pageTitle=='Buyer PO' || $pageTitle=='Add Buyer PO'){ ?>
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
					 { "width": "10%", "targets": 6 },
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
						swal({
							title: "Success",
							text: "Buyer PO Successfully Added!",
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
               var part_number =   $('#part_number').val();
			   var description =   $('#description').val();
			   var qty =   $('#qty').val();
			   var rate =   $('#rate').val();
			   var value =   $('#value').val();
			   var unit =   $('#unit').val();
			   
			   var sales_order_number =   $('#sales_order_number').val();
			   var date =   $('#date').val();
			   var buyer_po_number =   $('#buyer_po_number').val();
			   var buyer_po_date =   $('#buyer_po_date').val();
			   var buyer_name =   $('#buyer_name').val();
			   var currency =   $('#currency').val();
			   var delivery_date =   $('#delivery_date').val();
			   var remark =   $('#remark').val();
			 
			$.ajax({
				url : "<?php echo base_url();?>addbuyeritem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,qty:qty,rate:rate,value:value,buyer_po_number:buyer_po_number,date:date,buyer_po_date:buyer_po_date,buyer_name:buyer_name,currency:currency,delivery_date:delivery_date,remark:remark,unit:unit},
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
								window.location.href = "<?php echo base_url().'addnewBuyerpo'?>";
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

		$(document).on('click','.deleteBuyerpoitem',function(e){
			var elemF = $(this);
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
												window.location.href = "<?php echo base_url().'addnewBuyerpo'?>";
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
				$("#value").val( Math.round(total_value));
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

    </script>
<?php } ?>


<?php if($pageTitle=='Supplier PO' || $pageTitle=='Add Supplier PO'){ ?>
	<script type="text/javascript">
        $(document).ready(function() {
            var dt = $('#view_supplierpo').DataTable({
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

		$(document).on('click','#savenewsupplierpo',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnewSupplierform")[0]);

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
               var part_number =   $('#part_number').val();
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



					 
			$.ajax({
				url : "<?php echo base_url();?>addSuplieritem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,qty:qty,rate:rate,value:value,date:date,supplier_name:supplier_name,buyer_name:buyer_name,vendor_name:vendor_name,quatation_ref_no:quatation_ref_no,quatation_date:quatation_date,delivery_date:delivery_date,delivery:delivery,delivery_address:delivery_address,work_order:work_order,remark:remark,buyer_po_number:buyer_po_number,vendor_qty:vendor_qty,unit:unit,item_remark:item_remark},
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
								window.location.href = "<?php echo base_url().'addnewSupplierpo'?>";
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
												window.location.href = "<?php echo base_url().'addnewSupplierpo'?>";
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

   
		$( document ).ready(function() {
			var buyer_po_id = $('#buyer_po_number').val();

			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerItemsforDisplayBybuyerid",
				type: "POST",
				data : {'buyer_po_id' : buyer_po_id},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						$('#buyer_po_number').html(data);
						//$("#customers-list").html(data);

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

    </script>
<?php } ?>


<?php if($pageTitle=='Vendor PO Master' || $pageTitle=='Add Vendor PO'){ ?>
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
			var buyer_po_id = $('#buyer_po_number').val();

			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getBuyerItemsforDisplayBybuyerid",
				type: "POST",
				data : {'buyer_po_id' : buyer_po_id},
				success: function(data, textStatus, jqXHR)
				{
					$(".loader_ajax").hide();
					if(data == "failure")
					{
						//$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
					}
					else
					{
						$('#buyer_po_number').html('<option value="">Select Buyer PO Number</option>');
						$('#buyer_po_number').html(data);
						//$("#customers-list").html(data);

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

		$(document).on('click','#savenewvendorpo',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
			var formData = new FormData($("#addnewVendorform")[0]);

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
						swal({
							title: "Success",
							text: "Vendor PO Successfully Added!",
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
		    var supplier_po_number = $('#supplier_po_number').val();
			var supplier_name = $('#supplier_name').val();

			if(supplier_name){
				if(supplier_po_number){
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getfinishedgoodsPartnumberByid",
							type: "POST",
							data : {'part_number' : part_number,'supplier_po_number':supplier_po_number},
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

								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );
									$('#description').val(data_row_material.name);
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
               var part_number =   $('#part_number').val();
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

					 
			$.ajax({
				url : "<?php echo base_url();?>addVendoritem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,qty:qty,rate:rate,value:value,date:date,supplier_name:supplier_name,buyer_name:buyer_name,vendor_name:vendor_name,quatation_ref_no:quatation_ref_no,quatation_date:quatation_date,delivery_date:delivery_date,delivery:delivery,delivery_address:delivery_address,work_order:work_order,remark:remark,buyer_po_number:buyer_po_number,vendor_qty:vendor_qty,unit:unit,item_remark:item_remark,rm_type:rm_type,supplier_po_number:supplier_po_number},
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
								window.location.href = "<?php echo base_url().'addnewVendorpo'?>";
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

		$(document).on('change','.supplier_po_number_for_item',function(e){  
			e.preventDefault();
			//$(".loader_ajax").show();
			var supplier_po_number = $('.supplier_po_number_for_item').val();

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
				type: "POST",
				data : {'supplier_po_number' : supplier_po_number},
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

    </script>
<?php } ?>


<?php  if($pageTitle=='Supplier PO Confirmation' || $pageTitle=='Add Supplier PO Confirmation'){ ?>
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

			$("#part_number").html('');
		
			$.ajax({
				url : "<?php echo ADMIN_PATH;?>getSuppliritemonly",
				type: "POST",
				data : {'supplier_po_number' : supplier_po_number},
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

			if(supplier_name){
				if(supplier_po_number){
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getRowmaterialPartnumberByid",
							type: "POST",
							data : {'part_number' : part_number,'supplier_po_number':supplier_po_number},
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

								}
								else
								{
									var data_row_material = jQuery.parseJSON( data );
									$('#description').val(data_row_material.name);
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
			   var formData = new FormData($("#saveSupplierconfromationpoitem")[0]);
               var part_number =   $('#part_number').val();
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

					 
			$.ajax({
				url : "<?php echo base_url();?>addSupplierpoConfirmationitem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,qty:qty,rate:rate,value:value,date:date,supplier_name:supplier_name,buyer_name:buyer_name,vendor_name:vendor_name,quatation_ref_no:quatation_ref_no,quatation_date:quatation_date,delivery_date:delivery_date,delivery:delivery,delivery_address:delivery_address,work_order:work_order,remark:remark,buyer_po_number:buyer_po_number,vendor_qty:vendor_qty,unit:unit,item_remark:item_remark,rm_type:rm_type,supplier_po_number:supplier_po_number},
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
								window.location.href = "<?php echo base_url().'addnewVendorpo'?>";
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


