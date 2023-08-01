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
			   
			   var description_1 =   $('#description_1').val();
			   var description_2 =   $('#description_2').val();
			   var sup_id=  $('#sup_id').val();
					 
			$.ajax({
				url : "<?php echo base_url();?>addSuplieritem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,qty:qty,rate:rate,value:value,date:date,supplier_name:supplier_name,buyer_name:buyer_name,vendor_name:vendor_name,quatation_ref_no:quatation_ref_no,quatation_date:quatation_date,delivery_date:delivery_date,delivery:delivery,delivery_address:delivery_address,work_order:work_order,remark:remark,buyer_po_number:buyer_po_number,vendor_qty:vendor_qty,unit:unit,item_remark:item_remark,sup_id:sup_id,description_1:description_1,description_2:description_2},
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
									//$('#description_1').val(data_row_material.description_1);
									//$('#description_2').val(data_row_material.description_2);

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

			   var vendor_id =   $('#vendor_id').val();

			   var description_1 =   $('#description_1').val();
			   var description_2 =   $('#description_2').val();

			   
					 
			$.ajax({
				url : "<?php echo base_url();?>addVendoritem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,qty:qty,rate:rate,value:value,date:date,supplier_name:supplier_name,buyer_name:buyer_name,vendor_name:vendor_name,quatation_ref_no:quatation_ref_no,quatation_date:quatation_date,delivery_date:delivery_date,delivery:delivery,delivery_address:delivery_address,work_order:work_order,remark:remark,buyer_po_number:buyer_po_number,vendor_qty:vendor_qty,unit:unit,item_remark:item_remark,rm_type:rm_type,supplier_po_number:supplier_po_number,vendor_id:vendor_id,description_1:description_1,description_2:description_2},
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


			   var job_work_id =   $('#job_work_id').val();

			 
			$.ajax({
				url : "<?php echo base_url();?>saveJobworktem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number ,description:description,SAC_no:SAC_no,HSN_Code:HSN_Code,raw_material_size:raw_material_size,vendor_order_qty:vendor_order_qty,rm_actual_aty:rm_actual_aty,unit:unit,rm_rate:rm_rate,value:value,packing_and_forwarding:packing_and_forwarding,total:total,gst:gst,grand_total:grand_total,item_remark:item_remark,pre_date:pre_date,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_raw_material_supplier_name:pre_raw_material_supplier_name,pre_remark:pre_remark,job_work_id:job_work_id},
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

				if(vendor_name){
					if(vendor_po_number){
							$.ajax({
								url : "<?php echo ADMIN_PATH;?>getItemdetailsdependonvendorpobom",
								type: "POST",
								data : {'part_number' : part_number,'vendor_po_number':vendor_po_number,'vendor_name':vendor_name},
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

									}
									else
									{
										var data_row_material = jQuery.parseJSON( data );
										$('#description').val(data_row_material.name);
										$('#rm_order_qty').val(data_row_material.order_oty);
										$('#rm_type').val(data_row_material.type_of_raw_material);
										$('#slitting_size').val(data_row_material.sitting_size);
										$('#diameter').val(data_row_material.diameter);
										$('#thickness').val(data_row_material.thickness);
										$('#hex_af').val(data_row_material.hex_a_f);
										$('#gross_weight').val(data_row_material.fg_gross_weight);
										$('#net_weight_per_pcs').val(data_row_material.fg_net_weight);


								
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
			

			   var pre_date  =  $('#date').val();
			   var pre_vendor_name =  $('#vendor_name').val();
               var pre_vendor_po_number =  $('#vendor_po_number').val();
			   var pre_supplier_name =  $('#supplier_name').val();
               var pre_supplier_po_number =  $('#supplier_po_number').val();
			   var pre_buyer_name =  $('#buyer_name').val();
			   var pre_buyer_po_number =  $('#buyer_po_number').val();
			   var pre_buyer_po_date =  $('#buyer_po_date').val();
               var pre_buyer_delivery_date  =  $('#buyer_delivery_date').val();
               var pre_bom_status =  $('#bom_status').val();
			   var pre_incoming_details =  $('#incoming_details').val();
               var pre_remark =  $('#remark').val();

			$.ajax({
				url : "<?php echo base_url();?>saveBillofmaterialtem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,rm_actual_aty:rm_actual_aty,expected_qty:expected_qty,vendor_actual_received_Qty:vendor_actual_received_Qty,net_weight_per_pcs:net_weight_per_pcs,total_net_weight:total_net_weight,short_access:short_access,scrap:scrap,actual_scrap_recived:actual_scrap_recived,item_remark,pre_date:pre_date,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_supplier_name:pre_supplier_name,pre_supplier_po_number:pre_supplier_po_number,pre_buyer_name:pre_buyer_name,pre_buyer_po_number:pre_buyer_po_number,pre_buyer_po_date:pre_buyer_po_date,pre_buyer_delivery_date:pre_buyer_delivery_date,pre_bom_status:pre_bom_status,pre_incoming_details:pre_incoming_details,pre_remark},
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
								window.location.href = "<?php echo base_url().'addnewBillofmaterial'?>";
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

			   var pre_incoming_details =   $('#incoming_details').val();
		 
			$.ajax({
				url : "<?php echo base_url();?>saveVendorbilloamaterialitems",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,buyer_order_qty:buyer_order_qty,vendor_order_qty:vendor_order_qty,vendor_received_aty:vendor_received_aty,balanced_aty:balanced_aty,item_remark:item_remark,pre_date:pre_date,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_buyer_name:pre_buyer_name,pre_buyer_po_number:pre_buyer_po_number,pre_buyer_po_date:pre_buyer_po_date,pre_buyer_delivery_date:pre_buyer_delivery_date,pre_bom_status:pre_bom_status,pre_remark:pre_remark,pre_incoming_details:pre_incoming_details},
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
	                 { "width": "10%", "targets": 5 }					
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
			   var remarks =   $('#remarks').val();

			   var pre_vendor_name =   $('#vendor_name').val();
			   var pre_vendor_po_number =   $('#vendor_po_number').val();
			   var pre_reported_by =   $('#reported_by').val();
			   var pre_report_date =   $('#reported_date').val();
			   var pre_remark  =   $('#remark').val();
			   
			   var incomingdetail_editid  =   $('#incomingdetail_editid').val();

			

			$.ajax({
				url : "<?php echo base_url();?>saveincomingitem",
				type: "POST",
				 //data : formData,
				 data :{ part_number:part_number,description:description,p_o_qty:p_o_qty,net_weight:net_weight,invoice_no:invoice_no,invoice_date:invoice_date,challan_no:challan_no,challan_date:challan_date,received_date:received_date,invoice_qty:invoice_qty,invoice_qty_in_kgs:invoice_qty_in_kgs,balance_qty:balance_qty,fg_material_gross_weight:fg_material_gross_weight,units:units,boxex_goni_bundle:boxex_goni_bundle,remarks:remarks,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_reported_by:pre_reported_by,pre_report_date:pre_report_date,pre_remark:pre_remark,incomingdetail_editid:incomingdetail_editid},
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
													window.location.href = "<?php echo base_url().'addnewencomingdetails'?>";
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
					 { "width": "5%", "targets": 4 },
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


			$.ajax({
				url : "<?php echo base_url();?>savescrapreturnitem",
				type: "POST",
				 //data : formData,
				 data :{ description:description,gross_weight:gross_weight,net_weight:net_weight,quantity:quantity,number_of_bags:number_of_bags,hsn_code:hsn_code,estimated_value:estimated_value,number_of_processing:number_of_processing,item_remark:item_remark,pre_challan_date:pre_challan_date,pre_vendor_name:pre_vendor_name,pre_supplier_name:pre_supplier_name,pre_remark:pre_remark,challan_table_id:challan_table_id },
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
					 { "width": "5%", "targets": 6 },
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
								data : {'part_number' : part_number,'vendor_po_number':vendor_po_number},
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
										$('#HSN_Code').val(data_row_material.hsn_code);
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
			   var rate =   $('#rate').val();
			   var value =   $('#value').val();
			   var row_material_cost =   $('#row_material_cost').val();
			   var gst_rate =   $('#gst_rate').val();
			   var grand_total =   $('#grand_total').val();
			   var item_remark =   $('#item_remark').val();

			   var pre_challan_date =   $('#challan_date').val();
			   var pre_vendor_supplier_name =   $('#vendor_supplier_name').val();
			   var pre_vendor_name =   $('#vendor_name').val();
			   var pre_vendor_po_number =   $('#vendor_po_number').val();
			   var pre_supplier_name =   $('#supplier_name').val();
			   var pre_supplier_po_number =   $('#supplier_po_number').val();
			   var pre_dispath_through =   $('#dispath_through').val();
			   var pre_total_weight =   $('#total_weight').val();
			   var pre_total_bags =   $('#total_bags').val();
			   var pre_remark =   $('#remark').val();

			   var reworkrejectionid =   $('#reworkrejectionid').val();
			   


			$.ajax({
				url : "<?php echo base_url();?>savereworkrejectiontem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,rejected_work_reason:rejected_work_reason,quantity:quantity,rate:rate,value:value,row_material_cost:row_material_cost,gst_rate:gst_rate,grand_total:grand_total,item_remark:item_remark,pre_challan_date:pre_challan_date,pre_vendor_supplier_name:pre_vendor_supplier_name,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_supplier_name:pre_supplier_name,pre_supplier_po_number:pre_supplier_po_number,pre_dispath_through:pre_dispath_through,pre_total_weight:pre_total_weight,pre_total_bags:pre_total_bags,pre_remark:pre_remark,reworkrejectionid:reworkrejectionid },
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
					 { "width": "5%", "targets": 6 },
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
								url : "<?php echo ADMIN_PATH;?>getSuppliergoodsreworkrejectionvendor",
								type: "POST",
								data : {'part_number' : part_number,'vendor_po_number':vendor_po_number},
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
										$('#HSN_Code').val(data_row_material.hsn_code);
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
			   var row_material_cost =   $('#row_material_cost').val();
			   var gst_rate =   $('#gst_rate').val();
			   var grand_total =   $('#grand_total').val();
			   var item_remark =   $('#item_remark').val();

			   var pre_challan_date =   $('#challan_date').val();
			   var pre_vendor_supplier_name =   $('#vendor_supplier_name').val();
			   var pre_vendor_name =   $('#vendor_name').val();
			   var pre_vendor_po_number =   $('#vendor_po_number').val();
			   var pre_supplier_name =   $('#supplier_name').val();
			   var pre_supplier_po_number =   $('#supplier_po_number').val();
			   var pre_remark =   $('#remark').val();

			   var challan_id =   $('#challan_id').val();


			   $.ajax({
				url : "<?php echo base_url();?>saveChallanformitem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,description:description,type_of_raw_platting:type_of_raw_platting,quantity:quantity,rate:rate,value:value,row_material_cost:row_material_cost,gst_rate:gst_rate,grand_total:grand_total,item_remark:item_remark,pre_challan_date:pre_challan_date,pre_vendor_supplier_name:pre_vendor_supplier_name,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_supplier_name:pre_supplier_name,pre_supplier_po_number:pre_supplier_po_number,pre_remark:pre_remark,challan_id:challan_id },
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
					 { "width": "5%", "targets": 7 },
					 { "width": "5%", "targets": 8 },
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
								url : "<?php echo ADMIN_PATH;?>getSuppliergoodsreworkrejectionvendor",
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
										$('#description').val(data_row_material.name);
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

		 $(document).on('change', '#invoice_qty,#less_quantity,#rejected_quantity', function(){	
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
				 $("#received_quantity").val( Math.round(value));

				 var debit_amount =  parseFloat(less_qty_rejected_qty) *  parseFloat(rate);

				 $("#debit_amount").val(Math.round(debit_amount));

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
				
				$("#igst_rate_18").val( Math.round(gst_value));
				$("#gst").val( Math.round(gst_value));
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

				 var total_qty_for_ok_qty = parseFloat(Math.round(ok_qty)) *  parseFloat(Math.round(rate))

				 var gst_value_ok_18 = parseFloat(total_qty_for_ok_qty) * 18 / 100;

				 $("#igst_rate_ok_18").val( Math.round(gst_value_ok_18));



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

				var less_qty_rejected_qty = parseFloat(less_quantity) +  parseFloat(rejected_quantity);

				var base_val = parseFloat(less_qty_rejected_qty) * parseFloat(rate);

				var total_value = parseFloat(base_val);

				var gst_value = parseFloat(total_value) * 18 / 100;

				var cgst_rate  =Math.round(gst_value)/2;

				var SGST_rate  =Math.round(gst_value)/2;

				$("#CGST_rate_9").val( Math.round(cgst_rate));
				$("#SGST_rate_9").val( Math.round(SGST_rate));

				$("#gst").val( Math.round(gst_value));

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


				var total_qty_for_ok_qty = parseFloat(Math.round(ok_qty)) *  parseFloat(Math.round(rate))
				var gst_value_ok_9 = parseFloat(total_qty_for_ok_qty) * 18 / 100;
				var cgst_rate_ok_9  =Math.round(gst_value_ok_9)/2;
				var SGST_rate_ok_9  =Math.round(gst_value_ok_9)/2;
				$("#CGST_rate_9_ok").val( Math.round(cgst_rate_ok_9));
				$("#SGST_rate_9_ok").val( Math.round(SGST_rate_ok_9));


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

				var cgst_rate  =Math.round(gst_value)/2;

				var SGST_rate  =Math.round(gst_value)/2;

				$("#CGST_rate_6").val( Math.round(cgst_rate));
				$("#SGST_rate_6").val( Math.round(SGST_rate));

				$("#gst").val( Math.round(gst_value));

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

				var total_qty_for_ok_qty = parseFloat(Math.round(ok_qty)) *  parseFloat(Math.round(rate))
				var gst_value_ok_6 = parseFloat(total_qty_for_ok_qty) * 18 / 100;
				var cgst_rate_ok_6  =Math.round(gst_value_ok_6)/2;
				var SGST_rate_ok_6  =Math.round(gst_value_ok_6)/2;
				$("#CGST_rate_6_ok").val( Math.round(cgst_rate_ok_6));
				$("#SGST_rate_6_ok").val( Math.round(SGST_rate_ok_6));
				
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
				
				$("#igst_rate_12").val( Math.round(gst_value));
				$("#gst").val( Math.round(gst_value));
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

				 var total_qty_for_ok_12_qty = parseFloat(Math.round(ok_qty)) *  parseFloat(Math.round(rate))

				 var gst_value_ok_12 = parseFloat(total_qty_for_ok_12_qty) * 12 / 100;

				 $("#igst_rate_ok_12").val( Math.round(gst_value_ok_12));
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

				var total_ok_qty_amount = parseFloat(CGST_rate_ok) + parseFloat(SGST_rate_ok) + parseFloat(rate);

			   }

			   if(gst_rate=='CGST_SGST_6'){
				var sgst_value =   $('#SGST_rate_6').val();
				var cgst_value =   $('#CGST_rate_6').val();

				var SGST_rate_ok =   $('#SGST_rate_6_ok').val();
				var CGST_rate_ok =   $('#CGST_rate_6_ok').val();

				var total_ok_qty_amount = parseFloat(CGST_rate_ok) + parseFloat(SGST_rate_ok) + parseFloat(rate);


			   }

			   if(gst_rate=='IGST'){
				var igst_rate =   $('#igst_rate_18').val();
				var igst_rate_ok =   $('#igst_rate_ok_18').val();

				var total_ok_qty_amount = parseFloat(igst_rate_ok) + parseFloat(rate);
			   }

			   if(gst_rate=='IGST_12'){
				var igst_rate =   $('#igst_rate_12').val();
				var igst_rate_ok =   $('#igst_rate_ok_12').val();

				var total_ok_qty_amount = parseFloat(igst_rate_ok) + parseFloat(rate);
			   }

			
			
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

			   var debit_id =   $('#debit_id').val();
			
			   $.ajax({
				url : "<?php echo base_url();?>saveDebitnoteitem",
				type: "POST",
				 //data : formData,
				 data :{part_number:part_number,invoice_no:invoice_no,invoice_date:invoice_date,invoice_qty:invoice_qty,ok_qty:ok_qty,less_quantity:less_quantity,rejected_quantity:rejected_quantity,received_quantity:received_quantity,rate:rate,gst_rate:gst_rate,sgst_value:sgst_value,cgst_value:cgst_value,igst_rate:igst_rate,item_remark:item_remark,pre_debit_note_date:pre_debit_note_date,pre_select_with_po_without_po:pre_select_with_po_without_po,pre_vendor_supplier_name:pre_vendor_supplier_name,pre_vendor_name:pre_vendor_name,pre_vendor_po_number:pre_vendor_po_number,pre_supplier_name:pre_supplier_name,pre_supplier_po_number:pre_supplier_po_number,pre_po_date:pre_po_date,pre_remark:pre_remark,sgst_value:sgst_value,cgst_value:cgst_value,SGST_rate_ok:SGST_rate_ok,CGST_rate_ok:CGST_rate_ok,igst_rate:igst_rate,igst_rate_ok:igst_rate_ok,debit_amount:debit_amount,total_ok_qty_amount:total_ok_qty_amount,debit_id:debit_id},
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
									window.location.href = "<?php echo base_url().'editdebitnoteform'?>"+debit_id;
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

    </script>
<?php } ?>



<?php if($pageTitle=='Payment Details' || $pageTitle=='Add New Payment Details'){ ?>
	<script type="text/javascript">
		 $(document).ready(function() {
		    var dt = $('#view_payment_details').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "15%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
					 { "width": "10%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "10%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					 { "width": "10%", "targets": 6 },
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


    </script>
<?php } ?>


<?php if($pageTitle=='POD Detials' || $pageTitle=='Add New POD Details'){ ?>
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



    </script>
<?php } ?>