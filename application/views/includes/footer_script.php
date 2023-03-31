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
				 data :{part_number:part_number,description:description,qty:qty,rate:rate,value:value,buyer_po_number:buyer_po_number,date:date,buyer_po_date:buyer_po_date,buyer_name:buyer_name,currency:currency,delivery_date:delivery_date,remark:remark,unit:unit,po_id:po_id},
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


<?php if($pageTitle=='Supplier PO' || $pageTitle=='Add Supplier PO' || $pageTitle=="Edit Supplier PO"){ ?>
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

			   var sup_id=  $('#sup_id').val();
					 
			$.ajax({
				url : "<?php echo base_url();?>addSuplieritem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,qty:qty,rate:rate,value:value,date:date,supplier_name:supplier_name,buyer_name:buyer_name,vendor_name:vendor_name,quatation_ref_no:quatation_ref_no,quatation_date:quatation_date,delivery_date:delivery_date,delivery:delivery,delivery_address:delivery_address,work_order:work_order,remark:remark,buyer_po_number:buyer_po_number,vendor_qty:vendor_qty,unit:unit,item_remark:item_remark,sup_id:sup_id},
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
            
			if($('#supplier_name').val()){
				var supplier_name = $('#supplier_name').val();
			}else{
				var supplier_name = $('#buyer_name').val();
			}


			if($('#supplier_po_number').val()){
				var supplier_po_number = $('#supplier_po_number').val();
			}else{
				var supplier_po_number = $('#buyer_po_number').val();
			}

			if(supplier_name){
				if(supplier_po_number){
						$.ajax({
							url : "<?php echo ADMIN_PATH;?>getfinishedgoodsPartnumberByidvendor",
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
									$('#net_weight').val(data_row_material.supplier_goods_net_weight);
									$('#SAC').val(data_row_material.supplier_goods_sac);
									$('#drawing_number').val(data_row_material.drawing_number);
									$('#description_1').val(data_row_material.description_1);
									$('#description_2').val(data_row_material.description_2);

									if($('#supplier_name').val()){
										$('#qty').val(data_row_material.vendor_qty);
									    $('#vendor_qty').val(data_row_material.order_oty);
									}else{
										$('#qty').val();
										$('#vendor_qty').val();
									}
								
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

			if(supplier_name){

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
						$('.supplier_po_number_div').css('display','none');
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
									$('#vendor_name').val('');
									$('#vendor_id').val('');

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
			   var pre_remark =   $('#pre_remark').val();

			   var short_excess =   $('#short_excess').val();
			   var sent_qty =   $('#sent_qty').val();

			   var sent_qty_pcs =   $('#sent_qty_pcs').val();

			   var vendor_id =   $('#vendor_id').val();

			  
			   
								 
			$.ajax({
				url : "<?php echo base_url();?>addSupplierpoConfirmationitem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,qty:qty,rate:rate,value:value,unit:unit,vendor_qty:vendor_qty,item_remark:item_remark,pre_date:pre_date,pre_supplier_name:pre_supplier_name,pre_supplier_po_number:pre_supplier_po_number,pre_buyer_name:pre_buyer_name,pre_buyer_po_number:pre_buyer_po_number,pre_po_confirmed:pre_po_confirmed,pre_confirmed_date:pre_confirmed_date,pre_confirmed_with:pre_confirmed_with,pre_remark:pre_remark,short_excess:short_excess,sent_qty:sent_qty,sent_qty_pcs:sent_qty_pcs,vendor_id:vendor_id},
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
								window.location.href = "<?php echo base_url().'addSupplierpoconfirmation'?>";
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
												window.location.href = "<?php echo base_url().'addSupplierpoconfirmation'?>";
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

    </script>
<?php } ?>


<?php  if($pageTitle=='Vendor PO Confirmation' || $pageTitle=='Add Vendor PO Confirmation'){ ?>
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
							url : "<?php echo ADMIN_PATH;?>getSuppliergoodsPartnumberByid",
							type: "POST",
							data : {'part_number' : part_number,'vendor_po_number':vendor_po_number},
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
									$('#rmqty').val(data_row_material.sent_qty);


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
			   

								 
			$.ajax({
				url : "<?php echo base_url();?>saveVendorconfromationpoitem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,vendor_qty:vendor_qty,qty:qty,rmqty:rmqty,finishedgoodqty:finishedgoodqty,gross_weight:gross_weight,expected_qty:expected_qty,item_remark:item_remark,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_buyer_name:pre_buyer_name,pre_po_confirmed:pre_po_confirmed,pre_confirmed_date:pre_confirmed_date,pre_confirmed_with:pre_confirmed_with,pre_remark:pre_remark,pre_date:pre_date},
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
								window.location.href = "<?php echo base_url().'addVendorpoconfirmation'?>";
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
												window.location.href = "<?php echo base_url().'addVendorpoconfirmation'?>";
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

    </script>
<?php } ?>


<?php  if($pageTitle=='Job Work' || $pageTitle=="Add Job Work"){ ?>
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
	                 { "width": "10%", "targets": 5 }
					
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

		$(document).on('click','#savenewjobwork',function(e){
			e.preventDefault();
			$(".loader_ajax").show();
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
									$('#raw_material_size').val(data_row_material.sitting_size);
									$('#vendor_order_qty').val(data_row_material.order_oty);
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
			   var grand_total =   $('#grand_total').val();
			   var item_remark =   $('#item_remark').val();

			   var pre_date =   $('#date').val();
			   var pre_vendor_name =   $('#vendor_name').val();
			   var pre_vendor_po_number =   $('#vendor_po_number').val();
			   var pre_raw_material_supplier_name =   $('#raw_material_supplier_name').val();
			   var pre_remark =   $('#remark').val();
			 
			$.ajax({
				url : "<?php echo base_url();?>saveJobworktem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number ,description:description,SAC_no:SAC_no,HSN_Code:HSN_Code,raw_material_size:raw_material_size,vendor_order_qty:vendor_order_qty,rm_actual_aty:rm_actual_aty,unit:unit,rm_rate:rm_rate,value:value,packing_and_forwarding:packing_and_forwarding,total:total,gst:gst,grand_total:grand_total,item_remark:item_remark,pre_date:pre_date,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_raw_material_supplier_name:pre_raw_material_supplier_name,pre_remark:pre_remark},
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
								window.location.href = "<?php echo base_url().'addjobwork'?>";
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
		
    </script>
<?php } ?>


<?php if($pageTitle=='Bill of Material' || $pageTitle=="Add New Bill Of Material"){ ?>

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
	                 { "width": "10%", "targets": 5 },
					
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




    </script>
<?php } ?>



<?php if($pageTitle=='Vendor Bill of Material' || $pageTitle=="Add New Vendor Bill Of Material"){ ?>
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
	                 { "width": "10%", "targets": 5 }					
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

		$(document).on('change', '#vendor_received_aty,#vendor_order_qty', function(){	
				$("#balanced_aty").val();
			  
				if($("#vendor_received_aty").val()){
					 var vendor_received_aty = $("#vendor_received_aty").val();
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
			   var vendor_received_aty =   $('#vendor_received_aty').val();
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
		 
			$.ajax({
				url : "<?php echo base_url();?>saveVendorbilloamaterialitems",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,buyer_order_qty:buyer_order_qty,vendor_order_qty:vendor_order_qty,vendor_received_aty:vendor_received_aty,balanced_aty:balanced_aty,item_remark:item_remark,pre_date:pre_date,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_buyer_name:pre_buyer_name,pre_buyer_po_number:pre_buyer_po_number,pre_buyer_po_date:pre_buyer_po_date,pre_buyer_delivery_date:pre_buyer_delivery_date,pre_bom_status:pre_bom_status,pre_remark:pre_remark},
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
								window.location.href = "<?php echo base_url().'addvendorBillofmaterial'?>";
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

    </script>
<?php } ?>